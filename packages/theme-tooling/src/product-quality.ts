import { join } from "node:path";
import { lstat } from "node:fs/promises";

// One implemented product currently needs this gate. Do not invent a general
// plugin/registry before another product actually consumes the same contract.
export async function requireProductQuality(repoRoot: string, themeRoot: string, slug: string): Promise<void> {
  if (slug !== "jw_business") return;
  const checker = join(themeRoot, "scripts/check-quality.ts");
  const details = await lstat(checker).catch(() => null);
  if (!details?.isFile() || details.isSymbolicLink()) throw new Error("JW-Business mandatory quality checker is missing");
  const result = Bun.spawnSync({ cmd: [process.execPath, "run", checker, "release"], cwd: repoRoot, stdout: "pipe", stderr: "pipe" });
  let report: { result?: string; scope?: string; pages?: number; failures?: unknown[] } = {};
  try { report = JSON.parse(new TextDecoder().decode(result.stdout)); } catch { /* Missing/malformed output is a failure. */ }
  if (result.exitCode !== 0 || report.result !== "pass" || report.scope !== "release" || report.pages !== 75 || !Array.isArray(report.failures) || report.failures.length) {
    throw new Error(`JW-Business mandatory quality gate blocked release (${report.failures?.length ?? "invalid report"})`);
  }
}
