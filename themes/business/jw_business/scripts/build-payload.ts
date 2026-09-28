import { createHash } from "node:crypto";
import { cp, lstat, mkdir, readFile, readdir, rm, writeFile } from "node:fs/promises";
import { basename, dirname, join, relative, resolve, sep } from "node:path";

const themeRoot = resolve(import.meta.dirname, "..");
const sourceRoot = join(themeRoot, "src/php");
const buildRoot = join(themeRoot, "build/vite");
const payloadRoot = join(themeRoot, "theme");
const pagesRoot = join(themeRoot, "pages");
const inventoryPath = join(themeRoot, "docs/BASIC-INVENTORY.json");
const assetManifestPath = join(themeRoot, "ASSET-MANIFEST.json");
const staticExtensions = new Set(["css", "gif", "ico", "jpeg", "jpg", "js", "png", "svg", "webp", "woff", "woff2"]);

function portablePath(path: string): string {
  return path.split(sep).join("/");
}

function sha256(bytes: Uint8Array): string {
  return createHash("sha256").update(bytes).digest("hex");
}

function assetId(prefix: string, path: string): string {
  const readable = path.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/^-|-$/g, "").slice(0, 72) || "asset";
  return `${prefix}-${readable}-${sha256(new TextEncoder().encode(path)).slice(0, 8)}`;
}

function isYoungcartPath(path: string): boolean {
  const parts = path.split("/");
  return path === "js/theme.shop.list.js"
    || parts.some((part) => part === "shop" || part.startsWith("shop_"))
    || path.includes("_shop.");
}

async function walkFiles(root: string): Promise<string[]> {
  const entries = await readdir(root, { withFileTypes: true });
  const files: string[] = [];
  for (const entry of entries.sort((left, right) => left.name.localeCompare(right.name))) {
    const path = join(root, entry.name);
    if (entry.isDirectory()) files.push(...await walkFiles(path));
    else if (entry.isFile()) files.push(path);
  }
  return files;
}

async function copyFile(source: string, destination: string): Promise<void> {
  await mkdir(dirname(destination), { recursive: true });
  await cp(source, destination);
}

async function countStandalonePages(): Promise<number> {
  const pageFiles = (await walkFiles(pagesRoot))
    .map((path) => portablePath(relative(pagesRoot, path)))
    .filter((path) => path.endsWith(".php"));
  if (pageFiles.length !== 74 || !pageFiles.includes("index.php")
    || !["showcase", "services", "projects"].every((name) => pageFiles.includes(`onepage-${name}.php`))) {
    throw new Error(`expected 70 general pages, 3 onepages and one catalog, found ${pageFiles.length}`);
  }
  if (pageFiles.some((path) => /^home-[1-4]\.php$/.test(path))) {
    throw new Error("home variants belong in theme index_1.php through index_4.php");
  }
  return pageFiles.length - 1;
}

async function main(): Promise<void> {
  if (basename(themeRoot) !== "jw_business" || basename(payloadRoot) !== "theme") {
    throw new Error("refusing to build outside themes/business/jw_business/theme");
  }
  if (!(await lstat(buildRoot).catch(() => null))?.isDirectory()) {
    throw new Error("Vite output is missing; run build:assets first");
  }
  const builtFiles = await walkFiles(buildRoot);
  const builtAssets = new Set(builtFiles.map((file) => portablePath(relative(buildRoot, file))));

  const inventory = JSON.parse(await readFile(inventoryPath, "utf8")) as {
    files: Array<{ path: string; area: string }>;
  };
  const excluded = new Set(
    inventory.files
      .filter((file) => isYoungcartPath(file.path) || file.path === "screenshot.png")
      .map((file) => file.path)
  );

  await rm(payloadRoot, { recursive: true, force: true });
  await mkdir(payloadRoot, { recursive: true });
  const pageRouteCount = await countStandalonePages();

  for (const source of await walkFiles(sourceRoot)) {
    const path = portablePath(relative(sourceRoot, source));
    if (!excluded.has(path)) await copyFile(source, join(payloadRoot, path));
  }
  for (const source of builtFiles) {
    const path = portablePath(relative(buildRoot, source));
    await copyFile(source, join(payloadRoot, path));
  }

  await cp(join(themeRoot, "src/assets/brand"), join(payloadRoot, "assets/brand"), { recursive: true });
  for (const name of ["strategy", "digital", "brand", "brand-detail", "industry-ceramics", "case-food", "case-learning"]) {
    await copyFile(join(themeRoot, "src/assets/main-one", `${name}.webp`), join(payloadRoot, "assets/main-one", `${name}.webp`));
  }
  for (const name of ["hero", "discovery", "digital", "handoff"]) {
    await copyFile(join(themeRoot, "src/assets/home-four", `${name}.webp`), join(payloadRoot, "assets/home-four", `${name}.webp`));
  }
  await cp(join(themeRoot, "src/assets/home-three"), join(payloadRoot, "assets/home-three"), { recursive: true, filter: (source) => !source.endsWith('.json') });
  for (const source of await walkFiles(join(themeRoot, "onepages/assets/images"))) {
    if (basename(source) !== "node-poster.webp" && !source.endsWith('.json')) await copyFile(source, join(payloadRoot, "onepages/assets/images", basename(source)));
  }

  const assets = [];
  for (const file of await walkFiles(payloadRoot)) {
    const path = portablePath(relative(payloadRoot, file));
    const extension = path.split(".").pop()?.toLowerCase() ?? "";
    if (!staticExtensions.has(extension)) continue;

    const bytes = await readFile(file);
    const blenderLogo = path.startsWith("assets/brand/");
    const generatedImage = (path.startsWith("assets/") || path.startsWith("onepages/assets/")) && /\.(?:avif|jpe?g|png|webp)$/i.test(path);
    const generated = builtAssets.has(path) || generatedImage;
    const font = path.startsWith("fonts/");
    assets.push({
      id: assetId(generated ? "build" : "g5", path),
      path: `theme/${path}`,
      sha256: sha256(bytes),
      provenance: generated ? "generated" : "original",
      ...(generated ? {
        generatedBy: blenderLogo || path.startsWith("onepages/assets/sequence/")
          ? "Blender 5.2.2 LTS + ImageMagick WebP"
          : font
          ? "Vite 8.3.0 + Pretendard 1.3.9"
          : generatedImage
            ? "OpenAI image generation + cwebp + Vite 8.3.0"
            : "Vite 8.3.0"
      } : {}),
      ...(font
        ? { sourceUrl: "https://github.com/orioncactus/pretendard/releases/tag/v1.3.9" }
        : generated
          ? {}
          : { sourceUrl: `https://github.com/gnuboard/gnuboard5/blob/v5.6.391/theme/basic/${path.split("/").map(encodeURIComponent).join("/")}` }),
      author: blenderLogo || path.startsWith("onepages/assets/sequence/")
        ? "JW SOFT; lettering based on Pretendard by Kil Hyung-jin"
        : font
        ? "Kil Hyung-jin"
        : generatedImage
          ? "OpenAI image generation, directed by JW SOFT"
          : generated
            ? "JW SOFT and bundled library authors"
            : "SIR",
      acquiredAt: path.startsWith("assets/home-four/") ? "2026-09-27" : "2026-09-21",
      licenseExpression: blenderLogo
        ? "LicenseRef-JWSOFT AND OFL-1.1"
        : path.startsWith("onepages/assets/sequence/")
        ? "LicenseRef-JWSOFT"
        : font
        ? "OFL-1.1"
        : generatedImage
          ? "LicenseRef-OpenAI-Generated-Asset AND LicenseRef-JWSOFT"
          : builtAssets.has(path) && extension === "css"
          ? "MIT AND OFL-1.1 AND LicenseRef-JWSOFT"
          : builtAssets.has(path) && extension === "js"
            ? "ISC AND MIT AND LicenseRef-JWSOFT"
            : "LGPL-2.1-only",
      usageScope: "theme",
      salePackage: true
    });
  }

  await writeFile(assetManifestPath, `${JSON.stringify({
    $schema: "../../../packages/theme-contracts/schemas/asset-manifest.schema.json",
    schemaVersion: 1,
    theme: "jw_business",
    assets
  }, null, 2)}\n`);

  console.log(`payload built: ${payloadRoot} (${inventory.files.length - excluded.size} inherited files, ${assets.length} registered assets, ${pageRouteCount} page routes)`);
}

await main();
