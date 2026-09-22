import { resolve } from "node:path";

const repoRoot = resolve(import.meta.dir, "../..");
const impeccable = resolve(repoRoot, "tools/impeccable");

function detect(file: string): { exitCode: number; findings: Array<{ antipattern: string }> } {
  const result = Bun.spawnSync({
    cmd: [impeccable, "detect", "--json", resolve(import.meta.dir, "fixtures", file)],
    cwd: repoRoot,
    stdout: "pipe",
    stderr: "inherit",
  });
  const output = new TextDecoder().decode(result.stdout);
  return {
    exitCode: result.exitCode,
    findings: JSON.parse(output),
  };
}

const clean = detect("clean.html");
if (clean.exitCode !== 0 || clean.findings.length !== 0) {
  throw new Error(`clean design fixture must pass: ${JSON.stringify(clean.findings)}`);
}

const knownBad = detect("known-bad.html");
const ruleIds = new Set(knownBad.findings.map((finding) => finding.antipattern));
for (const expected of ["gradient-text", "dark-glow", "overused-font"]) {
  if (!ruleIds.has(expected)) throw new Error(`known-bad fixture did not trigger ${expected}`);
}
if (knownBad.exitCode !== 2) {
  throw new Error(`known-bad fixture must exit 2, got ${knownBad.exitCode}`);
}

console.log(`design detector calibrated: ${ruleIds.size} rule types found`);
