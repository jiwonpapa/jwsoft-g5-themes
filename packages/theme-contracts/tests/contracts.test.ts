import { describe, expect, test } from "bun:test";
import { join } from "node:path";
import { readFile } from "node:fs/promises";
import themeSlugs from "./fixtures/theme-slugs.json";

import {
  contractKinds,
  createValidators,
  validateContractFile,
  validateRepository,
} from "../src/contracts";

const fixtureRoot = join(import.meta.dir, "fixtures");
const repoRoot = join(import.meta.dir, "../../..");

describe("contract schemas", () => {
  test("compile in Ajv strict mode", async () => {
    const validators = await createValidators();
    expect(validators.size).toBe(contractKinds.length);
  });

  for (const kind of contractKinds) {
    test(`${kind} accepts the valid fixture`, async () => {
      const failures = await validateContractFile(join(fixtureRoot, "valid", kind));
      expect(failures).toEqual([]);
    });

    test(`${kind} rejects the invalid fixture`, async () => {
      const failures = await validateContractFile(join(fixtureRoot, "invalid", kind));
      expect(failures.length).toBeGreaterThan(0);
    });
  }

  test("current repository contracts pass", async () => {
    const failures = await validateRepository(repoRoot);
    expect(failures).toEqual([]);
  });

  test("theme identities accept G5 underscores but reject unsafe names in every manifest", async () => {
    const validators = await createValidators();
    for (const kind of ["theme.manifest.json", "ASSET-MANIFEST.json", "DESIGN-REFERENCE.json", "RELEASE-MANIFEST.json"] as const) {
      const fixture = JSON.parse(await readFile(join(fixtureRoot, "valid", kind), "utf8"));
      const field = kind === "theme.manifest.json" ? "slug" : "theme";
      for (const slug of themeSlugs.valid) expect(validators.get(kind)!({ ...fixture, [field]: slug })).toBe(true);
      for (const slug of themeSlugs.invalid) expect(validators.get(kind)!({ ...fixture, [field]: slug })).toBe(false);
    }
  });
});
