import { createHash } from "node:crypto";
import { lstat, readdir, readFile } from "node:fs/promises";
import { isAbsolute, join, relative, resolve, sep } from "node:path";

export const sha256 = (data: string | Uint8Array): string => createHash("sha256").update(data).digest("hex");
export async function safeFile(root: string, path: string): Promise<string> {
  if (isAbsolute(path) || path.includes("\\") || path.split("/").some(part => part === ".." || part === "." || !part)) throw new Error(`unsafe path: ${path}`);
  const target = resolve(root, path);
  if (relative(root, target).startsWith(`..${sep}`)) throw new Error(`path escapes root: ${path}`);
  let current = root;
  for (const part of path.split("/")) {
    current = join(current, part);
    if ((await lstat(current)).isSymbolicLink()) throw new Error(`symlink is forbidden: ${path}`);
  }
  if (!(await lstat(target)).isFile()) throw new Error(`not a file: ${path}`);
  return target;
}
export async function walk(root: string, path: string): Promise<string[]> {
  const result: string[] = [];
  for (const entry of (await readdir(join(root, path), { withFileTypes: true })).sort((a, b) => a.name.localeCompare(b.name))) {
    const child = `${path}/${entry.name}`;
    if (entry.isSymbolicLink()) throw new Error(`symlink is forbidden: ${child}`);
    if (entry.isDirectory()) result.push(...await walk(root, child));
    else if (entry.isFile()) result.push(child);
  }
  return result;
}
// Reviews are deliberately outside this digest. Every production input, the policy and
// the checker itself are included; changing any of them invalidates previous reviews.
export async function inputDigest(root: string): Promise<string> {
  const paths: string[] = [];
  for (const dir of ["src", "pages", "tokens", "generated", "theme", "scripts/quality"]) paths.push(...await walk(root, dir));
  paths.push("scripts/check-quality.ts", "quality/contract.json", "quality/assets.json", "docs/PAGE-CATALOG.json", "package.json", "theme.manifest.json", "vite.config.ts");
  const digest = createHash("sha256");
  for (const path of paths.sort()) digest.update(path).update("\0").update(await readFile(await safeFile(root, path))).update("\0");
  return digest.digest("hex");
}
