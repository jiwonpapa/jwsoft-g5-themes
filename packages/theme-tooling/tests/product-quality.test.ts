import { afterEach, expect, test } from "bun:test";
import { mkdir, mkdtemp, rm, writeFile } from "node:fs/promises";
import { join } from "node:path";
import { tmpdir } from "node:os";
import { requireProductQuality } from "../src/product-quality";

const roots: string[] = [];
afterEach(async () => { for (const root of roots.splice(0)) await rm(root, { recursive: true, force: true }); });
test("JW-Business package gate cannot be skipped with a missing checker, empty success or failure report", async () => {
  const root = await mkdtemp(join(tmpdir(), "jw-product-gate-")); roots.push(root);
  await expect(requireProductQuality(root, root, "jw_business")).rejects.toThrow("mandatory quality checker is missing");
  await mkdir(join(root, "scripts"));
  for (const report of [{}, { result: "pass" }, { result: "fail", scope: "release", pages: 75, failures: ["duplicate photo"] }, { result: "pass", scope: "current", pages: 21, failures: [] }]) {
    await writeFile(join(root, "scripts/check-quality.ts"), `console.log(${JSON.stringify(JSON.stringify(report))});`);
    await expect(requireProductQuality(root, root, "jw_business")).rejects.toThrow("mandatory quality gate blocked release");
  }
  await writeFile(join(root, "scripts/check-quality.ts"), 'console.log(JSON.stringify({result:"pass",scope:"release",pages:75,failures:[]}));');
  await expect(requireProductQuality(root, root, "jw_business")).resolves.toBeUndefined();
});
