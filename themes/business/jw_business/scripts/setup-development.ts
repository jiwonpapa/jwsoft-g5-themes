import { spawn } from "node:child_process";

import { currentBunVersion, inspectDevelopmentEnvironment, loadDevelopmentContext } from "./development-environment";

async function run(label: string, command: string[], cwd: string): Promise<void> {
  console.log(`\n[setup] ${label}`);
  const child = spawn(command[0]!, command.slice(1), {
    cwd,
    env: process.env,
    stdio: "inherit"
  });
  const exitCode = await new Promise<number>((resolve, reject) => {
    child.once("error", reject);
    child.once("close", (code) => resolve(code ?? 1));
  });
  if (exitCode !== 0) throw new Error(`${label} 실패(exit ${exitCode})`);
}

try {
  const context = await loadDevelopmentContext();
  const bunVersion = currentBunVersion();
  if (bunVersion !== context.contract.toolchain.bun) {
    throw new Error(`Bun ${context.contract.toolchain.bun}이 필요합니다. 현재 버전: ${bunVersion}`);
  }

  await run("고정 lockfile로 의존성 설치", [process.execPath, "install", "--frozen-lockfile"], context.workspaceRoot);
  await run("테마 build와 자동 검사", [process.execPath, "run", "check"], context.themeRoot);

  const failed = (await inspectDevelopmentEnvironment(context)).filter((finding) => finding.level === "fail");
  if (failed.length) throw new Error(`설치 후 환경 진단 실패: ${failed.map((finding) => finding.id).join(", ")}`);

  console.log("\nJW-Business 개발 환경 구축 완료");
  console.log("산출물: themes/business/jw_business/theme");
} catch (error) {
  console.error((error as Error).message);
  process.exit(1);
}
