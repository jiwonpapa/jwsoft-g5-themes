import { describe, expect, test } from "bun:test";
import { cp, mkdtemp, mkdir, readFile, rm, stat, writeFile } from "node:fs/promises";
import { tmpdir } from "node:os";
import { join } from "node:path";
import { unzipSync } from "fflate";

import { validateRepository } from "../../theme-contracts/src/contracts";
import { checkThemeTokens } from "../../theme-tokens/src/build";
import { packageInputDigest, packageTheme } from "../src/package-theme";
import { scaffoldTheme } from "../src/scaffold";

const repoRoot = join(import.meta.dir, "../../..");
const validTokens = join(repoRoot, "packages/theme-contracts/tests/fixtures/valid/theme.tokens.json");

async function temporaryRepository(): Promise<{ root: string; tokens: string }> {
  const root = await mkdtemp(join(tmpdir(), "jwsoft-scaffold-test-"));
  await mkdir(join(root, "governance"), { recursive: true });
  await cp(join(repoRoot, "governance/shared-candidates.json"), join(root, "governance/shared-candidates.json"));
  await mkdir(join(root, "packages/theme-tokens"), { recursive: true });
  await writeFile(join(root, "packages/theme-tokens/package.json"), `${JSON.stringify({ name: "@jwsoft/theme-tokens", version: "0.1.0" }, null, 2)}\n`);
  await cp(join(repoRoot, "bun.lock"), join(root, "bun.lock"));
  const tokens = join(root, "theme.tokens.json");
  await cp(validTokens, tokens);
  return { root, tokens };
}

describe("theme scaffold", () => {
  test.each(["sample-office", "jw_business"])("creates an independent, contract-valid theme: %s", async (slug) => {
    const temporary = await temporaryRepository();
    try {
      const themeRoot = await scaffoldTheme({
        repoRoot: temporary.root,
        category: "business",
        slug,
        name: "Sample Office",
        industry: "전문 서비스",
        youngcart: "excluded",
        tokensFile: temporary.tokens
      });

      expect((await stat(join(themeRoot, "AGENTS.md"))).isFile()).toBe(true);
      expect((await stat(join(themeRoot, "PRODUCT.md"))).isFile()).toBe(true);
      expect((await stat(join(themeRoot, "generated/tokens.css"))).isFile()).toBe(true);
      expect((await stat(join(themeRoot, "generated/tailwind-theme.css"))).isFile()).toBe(true);
      expect(await validateRepository(temporary.root)).toEqual([]);
      await checkThemeTokens(join(themeRoot, "tokens/theme.tokens.json"), join(themeRoot, "generated"));

      const designReference = JSON.parse(await readFile(join(themeRoot, "DESIGN-REFERENCE.json"), "utf8"));
      expect(designReference.status).toBe("draft");
      expect(designReference.frames).toEqual({});
      expect(Bun.file(join(themeRoot, "RELEASE-MANIFEST.json")).size).toBe(0);
    } finally {
      await rm(temporary.root, { recursive: true, force: true });
    }
  });

  test.each(["../escape", "jw/business", "jw__business", "JW_business"])("rejects unsafe or malformed theme slug: %s", async (slug) => {
    const temporary = await temporaryRepository();
    try {
      await expect(scaffoldTheme({
        repoRoot: temporary.root,
        category: "business",
        slug,
        name: "Sample Office",
        industry: "전문 서비스",
        youngcart: "excluded",
        tokensFile: temporary.tokens
      })).rejects.toThrow("slug must use");
    } finally {
      await rm(temporary.root, { recursive: true, force: true });
    }
  });

  test("refuses to overwrite an existing theme", async () => {
    const temporary = await temporaryRepository();
    try {
      const themeRoot = join(temporary.root, "themes/business/sample-office");
      await mkdir(themeRoot, { recursive: true });
      await writeFile(join(themeRoot, "owner.txt"), "preserve\n");

      expect(scaffoldTheme({
        repoRoot: temporary.root,
        category: "business",
        slug: "sample-office",
        name: "Sample Office",
        industry: "전문 서비스",
        youngcart: "excluded",
        tokensFile: temporary.tokens
      })).rejects.toThrow("theme already exists");
      expect(await readFile(join(themeRoot, "owner.txt"), "utf8")).toBe("preserve\n");
    } finally {
      await rm(temporary.root, { recursive: true, force: true });
    }
  });

  test("builds a deterministic, allowlisted ZIP and an external release manifest", async () => {
    const temporary = await temporaryRepository();
    try {
      const themeRoot = await scaffoldTheme({
        repoRoot: temporary.root,
        category: "business",
        slug: "sample-office",
        name: "Sample Office",
        industry: "전문 서비스",
        youngcart: "excluded",
        tokensFile: temporary.tokens
      });
      await writeFile(join(themeRoot, "theme/index.php"), "<?php defined('_GNUBOARD_') || exit;\n");
      await writeFile(join(themeRoot, "LICENSE.txt"), "Sample commercial license fixture.\n");
      await mkdir(join(temporary.root, "artifacts"), { recursive: true });
      const evidence = { schemaVersion: 1, gateId: "contract-check", result: "pass", sourceCommit: "a".repeat(40), inputDigest: await packageInputDigest(themeRoot), checkedAt: "2026-09-20T00:00:00.000Z" };
      await writeFile(join(temporary.root, "artifacts/contracts.json"), JSON.stringify(evidence));

      const options = {
        repoRoot: temporary.root,
        themeRoot,
        outputDir: join(temporary.root, "dist"),
        sourceCommit: "a".repeat(40),
        gnuboardVersion: "5.6.391",
        gnuboardCommit: "b".repeat(40),
        generatedAt: "2026-09-20T00:00:00.000Z",
        manualVersionUrl: "https://manual.example.com/sample-office/0.1.0/",
        gates: [{ id: "contract-check", evidence: "artifacts/contracts.json" }]
      };
      const first = await packageTheme(options);
      const firstBytes = await readFile(first.zipPath);
      const second = await packageTheme(options);
      const secondBytes = await readFile(second.zipPath);

      expect(first.sha256).toBe(second.sha256);
      expect(firstBytes).toEqual(secondBytes);
      const entries = Object.keys(unzipSync(firstBytes)).sort();
      expect(entries).toContain("theme/sample-office/index.php");
      expect(entries).toContain("BUILD-INFO.json");
      expect(entries).toContain("CHECKSUMS.sha256");
      expect(entries).toContain("README.html");
      expect(entries).not.toContain("RELEASE-MANIFEST.json");
      expect(entries.some((entry) => entry.startsWith("src/"))).toBe(false);

      const release = JSON.parse(await readFile(first.releaseManifestPath, "utf8"));
      expect(release.artifacts[0].sha256).toBe(first.sha256);
      expect(await validateRepository(temporary.root)).toEqual([]);

      for (const invalid of [{}, { ...evidence, result: "fail" }, { ...evidence, sourceCommit: "c".repeat(40) }, { ...evidence, inputDigest: "0".repeat(64) }, { ...evidence, checkedAt: "2030-01-01T00:00:00Z" }]) {
        await writeFile(join(temporary.root, "artifacts/contracts.json"), JSON.stringify(invalid));
        await expect(packageTheme(options)).rejects.toThrow("gate evidence is failed, incomplete or stale");
      }
      await writeFile(join(temporary.root, "artifacts/contracts.json"), JSON.stringify(evidence));
      await writeFile(join(themeRoot, "theme/index.php"), "<?php echo 'changed after review';\n");
      await expect(packageTheme(options)).rejects.toThrow("gate evidence is failed, incomplete or stale");
    } finally {
      await rm(temporary.root, { recursive: true, force: true });
    }
  });

  test("rejects an asset whose recorded checksum does not match", async () => {
    const temporary = await temporaryRepository();
    try {
      const themeRoot = await scaffoldTheme({
        repoRoot: temporary.root,
        category: "business",
        slug: "sample-office",
        name: "Sample Office",
        industry: "전문 서비스",
        youngcart: "excluded",
        tokensFile: temporary.tokens
      });
      await mkdir(join(themeRoot, "theme/images"), { recursive: true });
      await writeFile(join(themeRoot, "theme/index.php"), "<?php defined('_GNUBOARD_') || exit;\n");
      await writeFile(join(themeRoot, "theme/images/brand.svg"), "<svg/>\n");
      await writeFile(join(themeRoot, "LICENSE.txt"), "Sample commercial license fixture.\n");
      const assetsPath = join(themeRoot, "ASSET-MANIFEST.json");
      const assets = JSON.parse(await readFile(assetsPath, "utf8"));
      assets.assets.push({
        id: "brand-mark",
        path: "theme/images/brand.svg",
        sha256: "0".repeat(64),
        provenance: "original",
        acquiredAt: "2026-09-20",
        licenseExpression: "LicenseRef-JWSOFT",
        usageScope: "theme",
        salePackage: true
      });
      await writeFile(assetsPath, `${JSON.stringify(assets, null, 2)}\n`);
      await mkdir(join(temporary.root, "artifacts"), { recursive: true });
      await writeFile(join(temporary.root, "artifacts/contracts.json"), "{}\n");

      expect(packageTheme({
        repoRoot: temporary.root,
        themeRoot,
        outputDir: join(temporary.root, "dist"),
        sourceCommit: "a".repeat(40),
        gnuboardVersion: "5.6.391",
        gnuboardCommit: "b".repeat(40),
        generatedAt: "2026-09-20T00:00:00.000Z",
        manualVersionUrl: "https://manual.example.com/sample-office/0.1.0/",
        gates: [{ id: "contract-check", evidence: "artifacts/contracts.json" }]
      })).rejects.toThrow("asset checksum mismatch: brand-mark");
    } finally {
      await rm(temporary.root, { recursive: true, force: true });
    }
  });
});
