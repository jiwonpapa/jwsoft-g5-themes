import { createHash } from "node:crypto";
import { lstat, mkdir, readFile, readdir, writeFile } from "node:fs/promises";
import { basename, isAbsolute, join, posix, relative, resolve, sep } from "node:path";

import { unzipSync, zipSync, type Zippable } from "fflate";

import { validateContractFile, validateRepository } from "../../theme-contracts/src/contracts";
import { checkThemeTokens } from "../../theme-tokens/src/build";

interface GateEvidence {
  id: string;
  evidence: string;
}

export interface PackageThemeOptions {
  repoRoot: string;
  themeRoot: string;
  outputDir: string;
  sourceCommit: string;
  gnuboardVersion: string;
  gnuboardCommit: string;
  generatedAt: string;
  manualVersionUrl: string;
  gates: GateEvidence[];
}

interface ThemeManifest {
  slug: string;
  version: string;
  workspacePackages?: string[];
  build: {
    payloadDir: string;
    zipAllowlist: string[];
  };
}

interface CollectedFile {
  sourcePath: string;
  archivePath: string;
  bytes: Uint8Array;
}

const fixedZipTime = new Date("1980-01-01T00:00:00.000Z");
const forbiddenNames = new Set(["node_modules", ".git", ".DS_Store"]);
const commitPattern = /^[0-9a-f]{40}$/;
const slugPattern = /^[a-z][a-z0-9]*(?:-[a-z0-9]+)*$/;

function sha256(data: Uint8Array): string {
  return createHash("sha256").update(data).digest("hex");
}

function assertInside(root: string, target: string, label: string): void {
  const path = relative(root, target);
  if (path === ".." || path.startsWith(`..${sep}`) || resolve(target) === resolve(root) && label !== "theme root") {
    throw new Error(`${label} must stay inside ${root}`);
  }
}

function portablePath(path: string): string {
  return path.split(sep).join(posix.sep);
}

function safeManualUrl(value: string): string {
  const url = new URL(value);
  if (url.protocol !== "https:") throw new Error("manualVersionUrl must use HTTPS");
  return value.replaceAll("&", "&amp;").replaceAll('"', "&quot;").replaceAll("<", "&lt;").replaceAll(">", "&gt;");
}

async function walkFiles(root: string): Promise<string[]> {
  const entries = await readdir(root, { withFileTypes: true });
  const files: string[] = [];
  for (const entry of entries.sort((left, right) => left.name.localeCompare(right.name))) {
    if (forbiddenNames.has(entry.name) || entry.name === ".gitkeep") continue;
    const path = join(root, entry.name);
    const details = await lstat(path);
    if (details.isSymbolicLink()) throw new Error(`symlinks are forbidden in release input: ${path}`);
    if (details.isDirectory()) files.push(...(await walkFiles(path)));
    else if (details.isFile()) files.push(path);
  }
  return files;
}

async function collectAllowlist(themeRoot: string, manifest: ThemeManifest): Promise<CollectedFile[]> {
  const collected = new Map<string, CollectedFile>();
  for (const pattern of manifest.build.zipAllowlist) {
    if (pattern === "RELEASE-MANIFEST.json") {
      throw new Error("RELEASE-MANIFEST.json must stay outside the ZIP because it records the ZIP checksum");
    }
    const isTree = pattern.endsWith("/**");
    const relativeSource = isTree ? pattern.slice(0, -3) : pattern;
    const source = resolve(themeRoot, relativeSource);
    assertInside(themeRoot, source, `allowlist path ${pattern}`);

    let files: string[];
    try {
      const details = await lstat(source);
      if (details.isSymbolicLink()) throw new Error(`symlinks are forbidden in release input: ${source}`);
      if (isTree) {
        if (!details.isDirectory()) throw new Error(`allowlist tree is not a directory: ${pattern}`);
        files = await walkFiles(source);
      } else {
        if (!details.isFile()) throw new Error(`allowlist entry is not a file: ${pattern}`);
        files = [source];
      }
    } catch (error) {
      if ((error as NodeJS.ErrnoException).code === "ENOENT") throw new Error(`allowlist entry is missing: ${pattern}`);
      throw error;
    }

    for (const file of files) {
      const sourceRelative = portablePath(relative(themeRoot, file));
      const archivePath = sourceRelative === manifest.build.payloadDir || sourceRelative.startsWith(`${manifest.build.payloadDir}/`)
        ? posix.join("theme", manifest.slug, sourceRelative.slice(manifest.build.payloadDir.length + 1))
        : sourceRelative;
      if (archivePath.endsWith(".map")) throw new Error(`source maps are forbidden in release ZIP: ${sourceRelative}`);
      if (collected.has(archivePath)) throw new Error(`duplicate release path: ${archivePath}`);
      collected.set(archivePath, { sourcePath: file, archivePath, bytes: await readFile(file) });
    }
  }

  const payloadPrefix = `theme/${manifest.slug}/`;
  if (![...collected.keys()].some((path) => path.startsWith(payloadPrefix))) {
    throw new Error(`theme payload is empty: ${manifest.build.payloadDir}`);
  }
  return [...collected.values()].sort((left, right) => left.archivePath.localeCompare(right.archivePath));
}

async function commonPackages(repoRoot: string, names: string[]): Promise<Array<{ name: string; version: string }>> {
  const packagesDir = join(repoRoot, "packages");
  const packageDirs = await readdir(packagesDir, { withFileTypes: true });
  const available = new Map<string, string>();
  for (const entry of packageDirs) {
    if (!entry.isDirectory()) continue;
    try {
      const packageJson = JSON.parse(await readFile(join(packagesDir, entry.name, "package.json"), "utf8"));
      if (typeof packageJson.name === "string" && typeof packageJson.version === "string") {
        available.set(packageJson.name, packageJson.version);
      }
    } catch {
      // Directories without package metadata are not workspace packages.
    }
  }
  return names.sort().map((name) => {
    const version = available.get(name);
    if (!version) throw new Error(`workspace package metadata is missing: ${name}`);
    return { name, version };
  });
}

async function validateAssets(themeRoot: string, files: CollectedFile[]): Promise<void> {
  const manifest = JSON.parse(await readFile(join(themeRoot, "ASSET-MANIFEST.json"), "utf8")) as {
    assets: Array<{ id: string; path: string; sha256: string; salePackage: boolean }>;
  };
  const included = new Set(files.map((file) => resolve(file.sourcePath)));
  for (const asset of manifest.assets) {
    const path = resolve(themeRoot, asset.path);
    assertInside(themeRoot, path, `asset ${asset.id}`);
    const details = await lstat(path).catch(() => null);
    if (!details?.isFile() || details.isSymbolicLink()) throw new Error(`asset file is missing or invalid: ${asset.id}`);
    const bytes = await readFile(path);
    if (sha256(bytes) !== asset.sha256) throw new Error(`asset checksum mismatch: ${asset.id}`);
    if (asset.salePackage && !included.has(path)) throw new Error(`sale asset is outside the ZIP allowlist: ${asset.id}`);
    if (!asset.salePackage && included.has(path)) throw new Error(`development-only asset entered the ZIP allowlist: ${asset.id}`);
  }
}

function offlineReadme(manifest: ThemeManifest, manualVersionUrl: string): Uint8Array {
  const pageRoutes = manifest.build.zipAllowlist.includes("pages/**")
    ? "<p>ZIP의 <code>pages/</code> 디렉터리는 그누보드5 설치 루트의 <code>pages/</code>에 복사합니다. 이 파일은 일반 페이지 주소만 연결하며 그누보드5 코어를 수정하지 않습니다.</p>"
    : "";
  const html = `<!doctype html>
<html lang="ko"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>${manifest.slug} ${manifest.version}</title></head>
<body><main><h1>${manifest.slug} ${manifest.version}</h1><p>ZIP의 <code>theme/${manifest.slug}</code> 디렉터리를 그누보드5의 <code>theme/</code> 아래에 복사한 뒤 관리자에서 선택합니다.</p>${pageRoutes}<p>업데이트 전 기존 테마와 설정을 백업하고, 문제 발생 시 백업본으로 원복합니다.</p><p><a href="${safeManualUrl(manualVersionUrl)}">버전별 온라인 매뉴얼</a></p></main></body></html>
`;
  return new TextEncoder().encode(html);
}

export async function packageTheme(options: PackageThemeOptions): Promise<{ zipPath: string; releaseManifestPath: string; sha256: string }> {
  const repoRoot = resolve(options.repoRoot);
  const themeRoot = resolve(options.themeRoot);
  const outputDir = resolve(options.outputDir);
  assertInside(repoRoot, themeRoot, "theme root");
  assertInside(repoRoot, outputDir, "output directory");

  const repositoryFailures = await validateRepository(repoRoot);
  if (repositoryFailures.length) throw new Error(`repository contract failure: ${repositoryFailures[0]?.message}`);
  await checkThemeTokens(join(themeRoot, "tokens/theme.tokens.json"), join(themeRoot, "generated"));

  const manifest = JSON.parse(await readFile(join(themeRoot, "theme.manifest.json"), "utf8")) as ThemeManifest;
  if (basename(themeRoot) !== manifest.slug) throw new Error("theme directory and manifest slug differ");
  if (!commitPattern.test(options.sourceCommit)) throw new Error("sourceCommit must be a lowercase 40-character Git commit");
  if (!commitPattern.test(options.gnuboardCommit)) throw new Error("gnuboardCommit must be a lowercase 40-character Git commit");
  if (!/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d{3})?Z$/.test(options.generatedAt) || !Number.isFinite(Date.parse(options.generatedAt))) {
    throw new Error("generatedAt must be an ISO UTC date-time");
  }
  safeManualUrl(options.manualVersionUrl);
  if (!options.gates.length) throw new Error("at least one passed gate evidence is required");
  const gateIds = new Set<string>();
  for (const gate of options.gates) {
    if (!slugPattern.test(gate.id) || gateIds.has(gate.id)) throw new Error(`gate id is invalid or duplicated: ${gate.id}`);
    gateIds.add(gate.id);
    if (isAbsolute(gate.evidence)) throw new Error(`gate evidence must be repository-relative: ${gate.evidence}`);
    const evidence = resolve(repoRoot, gate.evidence);
    assertInside(repoRoot, evidence, `gate evidence ${gate.id}`);
    const details = await lstat(evidence).catch(() => null);
    if (!details?.isFile()) throw new Error(`gate evidence is missing: ${gate.evidence}`);
  }

  const files = await collectAllowlist(themeRoot, manifest);
  await validateAssets(themeRoot, files);
  const lockfile = await readFile(join(repoRoot, "bun.lock"));
  const resolvedCommonPackages = await commonPackages(repoRoot, manifest.workspacePackages ?? []);
  const buildInfo = {
    theme: manifest.slug,
    version: manifest.version,
    sourceCommit: options.sourceCommit,
    generatedAt: options.generatedAt,
    gnuboard: { version: options.gnuboardVersion, commit: options.gnuboardCommit },
    toolchain: { bun: Bun.version, runtime: "bun" }
  };

  const buildInfoBytes = new TextEncoder().encode(`${JSON.stringify(buildInfo, null, 2)}\n`);
  const readmeBytes = offlineReadme(manifest, options.manualVersionUrl);
  const includedChecksums = [
    ...files.map((file) => ({ path: file.archivePath, bytes: file.bytes })),
    { path: "BUILD-INFO.json", bytes: buildInfoBytes },
    { path: "README.html", bytes: readmeBytes }
  ]
    .sort((left, right) => left.path.localeCompare(right.path))
    .map((file) => `${sha256(file.bytes)}  ${file.path}`)
    .join("\n") + "\n";

  const zipEntries: Zippable = {};
  for (const file of files) zipEntries[file.archivePath] = [file.bytes, { mtime: fixedZipTime, level: 9 }];
  zipEntries["BUILD-INFO.json"] = [buildInfoBytes, { mtime: fixedZipTime, level: 9 }];
  zipEntries["CHECKSUMS.sha256"] = [new TextEncoder().encode(includedChecksums), { mtime: fixedZipTime, level: 9 }];
  zipEntries["README.html"] = [readmeBytes, { mtime: fixedZipTime, level: 9 }];

  const zipBytes = zipSync(zipEntries, { level: 9, mtime: fixedZipTime });
  const unpacked = unzipSync(zipBytes);
  const expectedEntries = Object.keys(zipEntries).sort();
  const actualEntries = Object.keys(unpacked).sort();
  if (JSON.stringify(actualEntries) !== JSON.stringify(expectedEntries)) throw new Error("ZIP verification found an unexpected entry set");
  for (const name of expectedEntries) {
    const expected = zipEntries[name];
    const expectedBytes = Array.isArray(expected) ? expected[0] as Uint8Array : expected as Uint8Array;
    if (sha256(unpacked[name]!) !== sha256(expectedBytes)) throw new Error(`ZIP content verification failed: ${name}`);
  }

  await mkdir(outputDir, { recursive: true });
  const zipPath = join(outputDir, `${manifest.slug}-${manifest.version}.zip`);
  await writeFile(zipPath, zipBytes);
  const zipHash = sha256(zipBytes);

  const releaseManifest = {
    $schema: "../../../packages/theme-contracts/schemas/release-manifest.schema.json",
    schemaVersion: 1,
    generated: true,
    generatedAt: options.generatedAt,
    theme: manifest.slug,
    version: manifest.version,
    sourceCommit: options.sourceCommit,
    gnuboard: { version: options.gnuboardVersion, commit: options.gnuboardCommit },
    toolchain: { bun: Bun.version, runtime: "bun" },
    lockfileSha256: sha256(lockfile),
    commonPackages: resolvedCommonPackages,
    artifacts: [{ path: portablePath(relative(repoRoot, zipPath)), sha256: zipHash, bytes: zipBytes.byteLength }],
    gates: options.gates.map((gate) => ({ id: gate.id, result: "pass", evidence: portablePath(gate.evidence) })),
    manualVersionUrl: options.manualVersionUrl
  };
  const releaseManifestPath = join(themeRoot, "RELEASE-MANIFEST.json");
  await writeFile(releaseManifestPath, `${JSON.stringify(releaseManifest, null, 2)}\n`);
  const manifestFailures = await validateContractFile(releaseManifestPath);
  if (manifestFailures.length) throw new Error(`generated release manifest is invalid: ${manifestFailures[0]?.message}`);

  return { zipPath, releaseManifestPath, sha256: zipHash };
}
