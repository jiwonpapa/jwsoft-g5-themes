import { readdir, readFile } from "node:fs/promises";
import { basename, dirname, join, relative, resolve, sep } from "node:path";

import Ajv2020, { type ErrorObject, type ValidateFunction } from "ajv/dist/2020.js";
import addFormats from "ajv-formats";

export const contractKinds = [
  "theme.manifest.json",
  "theme.tokens.json",
  "ASSET-MANIFEST.json",
  "DESIGN-REFERENCE.json",
  "RELEASE-MANIFEST.json",
  "shared-candidates.json",
] as const;

export type ContractKind = (typeof contractKinds)[number];

export interface ContractFailure {
  file: string;
  message: string;
}

const schemaDir = resolve(import.meta.dir, "../schemas");
const schemaFiles: Record<ContractKind, string> = {
  "theme.manifest.json": "theme-manifest.schema.json",
  "theme.tokens.json": "theme-tokens.schema.json",
  "ASSET-MANIFEST.json": "asset-manifest.schema.json",
  "DESIGN-REFERENCE.json": "design-reference.schema.json",
  "RELEASE-MANIFEST.json": "release-manifest.schema.json",
  "shared-candidates.json": "shared-candidates.schema.json",
};

async function readJson(path: string): Promise<unknown> {
  return JSON.parse(await readFile(path, "utf8"));
}

function formatErrors(errors: ErrorObject[] | null | undefined): string {
  if (!errors?.length) return "unknown schema error";

  return errors
    .map((error) => {
      const location = error.instancePath || "/";
      return `${location} ${error.message ?? error.keyword}`;
    })
    .join("; ");
}

export async function createValidators(): Promise<Map<ContractKind, ValidateFunction>> {
  const ajv = new Ajv2020({
    allErrors: true,
    strict: true,
    validateFormats: true,
  });
  addFormats(ajv);

  const common = await readJson(join(schemaDir, "common.schema.json"));
  ajv.addSchema(common);

  const validators = new Map<ContractKind, ValidateFunction>();
  for (const kind of contractKinds) {
    const schema = await readJson(join(schemaDir, schemaFiles[kind]));
    validators.set(kind, ajv.compile(schema));
  }

  return validators;
}

export async function validateContractFile(
  file: string,
  validators?: Map<ContractKind, ValidateFunction>,
): Promise<ContractFailure[]> {
  const kind = basename(file) as ContractKind;
  if (!contractKinds.includes(kind)) {
    return [{ file, message: `unsupported contract filename: ${kind}` }];
  }

  const activeValidators = validators ?? (await createValidators());
  const validate = activeValidators.get(kind);
  if (!validate) return [{ file, message: `validator missing for ${kind}` }];

  let data: unknown;
  try {
    data = await readJson(file);
  } catch (error) {
    return [{ file, message: `invalid JSON: ${(error as Error).message}` }];
  }

  return validate(data) ? [] : [{ file, message: formatErrors(validate.errors) }];
}

async function walk(dir: string): Promise<string[]> {
  const files: string[] = [];
  let entries;
  try {
    entries = await readdir(dir, { withFileTypes: true });
  } catch {
    return files;
  }

  for (const entry of entries) {
    if (entry.name === "node_modules" || entry.name === ".runtime" || entry.name === ".git") continue;
    const path = join(dir, entry.name);
    if (entry.isDirectory()) files.push(...(await walk(path)));
    else if (contractKinds.includes(entry.name as ContractKind)) files.push(path);
  }

  return files;
}

function asRecord(value: unknown): Record<string, unknown> | null {
  if (!value || typeof value !== "object" || Array.isArray(value)) return null;
  return value as Record<string, unknown>;
}

async function validateThemeLinks(repoRoot: string, manifestPath: string): Promise<ContractFailure[]> {
  const failures: ContractFailure[] = [];
  const themeDir = dirname(manifestPath);
  const pathParts = relative(join(repoRoot, "themes"), themeDir).split(sep);
  const manifest = asRecord(await readJson(manifestPath));
  if (!manifest) return failures;

  if (pathParts.length !== 2) {
    failures.push({
      file: manifestPath,
      message: "theme.manifest.json must be at themes/<category>/<slug>",
    });
    return failures;
  }

  const [category, slug] = pathParts;
  if (manifest.category !== category) {
    failures.push({ file: manifestPath, message: `/category must equal directory ${category}` });
  }
  if (manifest.slug !== slug) {
    failures.push({ file: manifestPath, message: `/slug must equal directory ${slug}` });
  }

  const manifests = asRecord(manifest.manifests);
  if (!manifests) return failures;

  for (const [name, value] of Object.entries(manifests)) {
    if (typeof value !== "string") continue;
    const target = resolve(themeDir, value);
    const rel = relative(themeDir, target);
    if (rel.startsWith(`..${sep}`) || rel === "..") {
      failures.push({ file: manifestPath, message: `/manifests/${name} escapes the theme directory` });
      continue;
    }
    // The release manifest is generated only when a distributable archive is built.
    if (name === "release") continue;
    try {
      await readFile(target);
    } catch {
      failures.push({ file: manifestPath, message: `/manifests/${name} is missing: ${value}` });
    }
  }

  return failures;
}

export async function validateRepository(repoRoot: string): Promise<ContractFailure[]> {
  const validators = await createValidators();
  const files = await walk(join(repoRoot, "themes"));
  const candidates = join(repoRoot, "governance", "shared-candidates.json");
  try {
    await readFile(candidates);
    files.push(candidates);
  } catch {
    return [{ file: candidates, message: "required governance registry is missing" }];
  }

  const failures: ContractFailure[] = [];
  for (const file of files.sort()) {
    failures.push(...(await validateContractFile(file, validators)));
    if (basename(file) === "theme.manifest.json") {
      failures.push(...(await validateThemeLinks(repoRoot, file)));
    }
  }

  return failures;
}
