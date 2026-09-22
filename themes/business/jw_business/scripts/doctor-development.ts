import { inspectDevelopmentEnvironment, loadDevelopmentContext } from "./development-environment";

const labels = { pass: "PASS", warn: "WARN", fail: "FAIL" } as const;

try {
  const context = await loadDevelopmentContext();
  const findings = await inspectDevelopmentEnvironment(context);
  for (const finding of findings) {
    console.log(`[${labels[finding.level]}] ${finding.id}: ${finding.message}`);
  }

  const failed = findings.filter((finding) => finding.level === "fail");
  if (failed.length) {
    console.error(`개발 환경 진단 실패: ${failed.length}개`);
    process.exit(1);
  }
  console.log("개발 환경 진단 통과");
} catch (error) {
  console.error((error as Error).message);
  process.exit(1);
}
