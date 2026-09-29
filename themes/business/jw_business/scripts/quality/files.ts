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
    // Blender's ignored backups and intermediate renders are not product inputs.
    // Including them makes a developer checkout hash differently from clean CI.
    if (child === "onepages/design/renders" || child === "onepages/design/aura-renders" || /^onepages\/design\/[^/]+\.blend1$/.test(child)) continue;
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
  for (const dir of ["src", "pages", "onepages", "tokens", "generated", "theme", "scripts/quality"]) paths.push(...await walk(root, dir));
  paths.push("scripts/check-quality.ts", "quality/contract.json", "quality/assets.json", "docs/PAGE-CATALOG.json", "package.json", "theme.manifest.json", "vite.config.ts");
  const digest = createHash("sha256");
  for (const path of paths.sort()) digest.update(path).update("\0").update(await readFile(await safeFile(root, path))).update("\0");
  return digest.digest("hex");
}

// Only registered, independent page PHP from other groups is excluded.
// Shared PHP, all CSS/JS/chunks, tokens, photos and every checker/policy stay global.
// Unknown files are included conservatively. Global photo reuse still runs in check.ts.
export async function groupDigest(root: string, group: string): Promise<string> {
  const contract = JSON.parse(await readFile(await safeFile(root, 'quality/contract.json'), 'utf8')) as { pages: Array<{group:string;path:string}> };
  if (!contract.pages.some(page => page.group === group)) throw new Error('Unknown review group: ' + group);
  const excluded = new Set<string>();
  for (const page of contract.pages.filter(page => page.group !== group)) {
    excluded.add(page.path);
    if (page.path.startsWith('src/php/')) excluded.add('theme/' + page.path.slice(8));
  }
  const paths: string[] = [];
  for (const dir of ['src','pages','onepages','tokens','generated','theme','scripts/quality']) paths.push(...await walk(root,dir));
  paths.push('scripts/check-quality.ts','quality/contract.json','quality/assets.json','docs/PAGE-CATALOG.json','package.json','theme.manifest.json','vite.config.ts');
  const digest = createHash('sha256').update('group-v2\0' + group + '\0');
  for (const path of paths.sort()) if (!excluded.has(path)) digest.update(path).update('\0').update(await readFile(await safeFile(root,path))).update('\0');
  return digest.digest('hex');
}
