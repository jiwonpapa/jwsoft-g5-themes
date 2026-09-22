import { access, readFile } from "node:fs/promises";
import { dirname, join, resolve } from "node:path";

export interface DevelopmentContract {
  schemaVersion: number;
  product: { slug: string; version: string };
  toolchain: { bun: string; serverIncluded: boolean };
  commands: Record<"setup" | "doctor" | "build" | "check" | "hashPayload", string>;
  paths: {
    required: string[];
    editable: string[];
    generated: string[];
    forbidden: string[];
  };
  ai: {
    readOrder: string[];
    requiredEvidence: string[];
  };
  support: {
    included: string[];
    excluded: string[];
  };
}

export interface DevelopmentContext {
  contract: DevelopmentContract;
  themeRoot: string;
  workspaceRoot: string;
}

export interface EnvironmentFinding {
  level: "pass" | "warn" | "fail";
  id: string;
  message: string;
}

export function currentBunVersion(): string {
  return (process.versions as NodeJS.ProcessVersions & { bun?: string }).bun ?? "not-bun";
}

async function exists(path: string): Promise<boolean> {
  return access(path).then(() => true, () => false);
}

async function findWorkspaceRoot(start: string): Promise<string> {
  let current = resolve(start);
  for (let depth = 0; depth < 8; depth += 1) {
    if (await exists(join(current, "bun.lock")) && await exists(join(current, "package.json"))) return current;
    const parent = dirname(current);
    if (parent === current) break;
    current = parent;
  }
  throw new Error("개발 키트 루트의 package.json과 bun.lock을 찾지 못했습니다.");
}

function assertContract(value: unknown): asserts value is DevelopmentContract {
  if (!value || typeof value !== "object") throw new Error("DEVELOPMENT-CONTRACT.json 형식이 잘못되었습니다.");
  const contract = value as Partial<DevelopmentContract>;
  if (contract.schemaVersion !== 1 || !contract.toolchain?.bun || !contract.commands || !contract.paths || !contract.ai || !contract.support) {
    throw new Error("DEVELOPMENT-CONTRACT.json 필수 항목이 누락되었습니다.");
  }
}

export async function loadDevelopmentContext(): Promise<DevelopmentContext> {
  const themeRoot = resolve(import.meta.dirname, "..");
  const workspaceRoot = await findWorkspaceRoot(themeRoot);
  const contractPath = join(themeRoot, "delivery/developer-kit/DEVELOPMENT-CONTRACT.json");
  const contract = JSON.parse(await readFile(contractPath, "utf8")) as unknown;
  assertContract(contract);
  return { contract, themeRoot, workspaceRoot };
}

export async function inspectDevelopmentEnvironment(
  context: DevelopmentContext,
  bunVersion = currentBunVersion()
): Promise<EnvironmentFinding[]> {
  const { contract, themeRoot, workspaceRoot } = context;
  const findings: EnvironmentFinding[] = [];
  const add = (level: EnvironmentFinding["level"], id: string, message: string): void => {
    findings.push({ level, id, message });
  };

  add(
    bunVersion === contract.toolchain.bun ? "pass" : "fail",
    "bun-version",
    bunVersion === contract.toolchain.bun
      ? `Bun ${bunVersion}`
      : `Bun ${contract.toolchain.bun}이 필요하지만 ${bunVersion}이 실행 중입니다.`
  );

  const rootPackage = JSON.parse(await readFile(join(workspaceRoot, "package.json"), "utf8")) as {
    packageManager?: string;
  };
  add(
    rootPackage.packageManager === `bun@${contract.toolchain.bun}` ? "pass" : "fail",
    "package-manager",
    `packageManager=${rootPackage.packageManager ?? "missing"}`
  );

  const themePackage = JSON.parse(await readFile(join(themeRoot, "package.json"), "utf8")) as {
    scripts?: Record<string, string>;
  };
  for (const [purpose, scriptName] of Object.entries(contract.commands)) {
    add(
      themePackage.scripts?.[scriptName] ? "pass" : "fail",
      `command-${purpose}`,
      themePackage.scripts?.[scriptName] ? `bun run ${scriptName}` : `package.json script 누락: ${scriptName}`
    );
  }

  for (const path of contract.paths.required) {
    add(await exists(join(workspaceRoot, path)) ? "pass" : "fail", `required-${path}`, path);
  }

  for (const lockfile of ["package-lock.json", "pnpm-lock.yaml", "yarn.lock"]) {
    add(
      await exists(join(workspaceRoot, lockfile)) ? "fail" : "pass",
      `foreign-lock-${lockfile}`,
      `${lockfile} ${await exists(join(workspaceRoot, lockfile)) ? "발견" : "없음"}`
    );
  }

  add(
    await exists(join(workspaceRoot, "node_modules")) ? "pass" : "warn",
    "dependencies",
    await exists(join(workspaceRoot, "node_modules")) ? "의존성 설치됨" : "의존성 미설치: bun run setup을 실행하세요."
  );
  add(contract.toolchain.serverIncluded ? "fail" : "pass", "server-boundary", "개발 키트는 웹서버와 DB를 설치하지 않습니다.");

  return findings;
}
