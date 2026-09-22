import { createHash } from "node:crypto";
import { readFile, readdir } from "node:fs/promises";
import { join, relative, resolve, sep } from "node:path";

const payloadRoot = resolve(import.meta.dirname, "../theme");
const separator = new Uint8Array([0]);

function portablePath(path: string): string {
  return path.split(sep).join("/");
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

const digest = createHash("sha256");
for (const file of await walkFiles(payloadRoot)) {
  digest.update(portablePath(relative(payloadRoot, file)));
  digest.update(separator);
  digest.update(await readFile(file));
  digest.update(separator);
}

console.log(digest.digest("hex"));
