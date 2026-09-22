import { createHash } from "node:crypto";
import { readFile } from "node:fs/promises";
import { resolve } from "node:path";

interface ImpeccableLock {
  engineVersion: string;
  installedSkillSha256: string;
  licenseSha256: string;
}

const repoRoot = resolve(import.meta.dir, "..");
const lock = JSON.parse(
  await readFile(resolve(repoRoot, "third_party/impeccable/LOCK.json"), "utf8"),
) as ImpeccableLock;

async function sha256(path: string): Promise<string> {
  return createHash("sha256").update(await readFile(path)).digest("hex");
}

const checks = [
  {
    path: resolve(repoRoot, ".agents/skills/impeccable/SKILL.md"),
    expected: lock.installedSkillSha256,
  },
  {
    path: resolve(repoRoot, "third_party/impeccable/LICENSE"),
    expected: lock.licenseSha256,
  },
];

for (const check of checks) {
  const actual = await sha256(check.path);
  if (actual !== check.expected) {
    throw new Error(`${check.path}: expected ${check.expected}, got ${actual}`);
  }
}

const engineVersion = (
  await readFile(resolve(repoRoot, ".agents/skills/impeccable/scripts/VERSION"), "utf8")
).trim();
if (engineVersion !== lock.engineVersion) {
  throw new Error(`Impeccable engine expected ${lock.engineVersion}, got ${engineVersion}`);
}

console.log(`Impeccable skill and license verified; engine ${engineVersion}`);
