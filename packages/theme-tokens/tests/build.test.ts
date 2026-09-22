import { describe, expect, test } from "bun:test";
import { cp, mkdtemp, readFile, rm, writeFile } from "node:fs/promises";
import { tmpdir } from "node:os";
import { join } from "node:path";

import { buildThemeTokens, checkThemeTokens } from "../src/build";

const validFixture = join(import.meta.dir, "../../theme-contracts/tests/fixtures/valid/theme.tokens.json");

describe("theme token build", () => {
  test("generates deterministic CSS and Tailwind mappings", async () => {
    const root = await mkdtemp(join(tmpdir(), "jwsoft-token-test-"));
    try {
      const source = join(root, "theme.tokens.json");
      const first = join(root, "first");
      const second = join(root, "second");
      await cp(validFixture, source);

      const firstResult = await buildThemeTokens(source, first);
      const secondResult = await buildThemeTokens(source, second);
      expect(secondResult).toEqual(firstResult);
      expect(await readFile(join(second, "tokens.css"), "utf8")).toBe(firstResult.tokensCss);
      expect(firstResult.tokensCss).toContain("--jw-color-brand: #1463ff;");
      expect(firstResult.tokensCss).toContain("--jw-radius-box: 16px;");
      expect(firstResult.tailwindThemeCss).toContain("@theme inline");
      expect(firstResult.tailwindThemeCss).toContain("--color-brand: var(--jw-color-brand);");
      await checkThemeTokens(source, first);
    } finally {
      await rm(root, { recursive: true, force: true });
    }
  });

  test("rejects a Tailwind mapping to a missing token", async () => {
    const root = await mkdtemp(join(tmpdir(), "jwsoft-token-test-"));
    try {
      const source = join(root, "theme.tokens.json");
      const fixture = JSON.parse(await readFile(validFixture, "utf8"));
      fixture.$extensions["dev.jwsoft.g5-theme"].tailwind["--color-ghost"] = "{color.ghost}";
      await writeFile(source, `${JSON.stringify(fixture, null, 2)}\n`);
      expect(buildThemeTokens(source, join(root, "generated"))).rejects.toThrow("missing token color.ghost");
    } finally {
      await rm(root, { recursive: true, force: true });
    }
  });

  test("detects generated output drift", async () => {
    const root = await mkdtemp(join(tmpdir(), "jwsoft-token-test-"));
    try {
      const source = join(root, "theme.tokens.json");
      const output = join(root, "generated");
      await cp(validFixture, source);
      await buildThemeTokens(source, output);
      await writeFile(join(output, "tokens.css"), "stale\n");
      expect(checkThemeTokens(source, output)).rejects.toThrow("tokens.css is missing or stale");
    } finally {
      await rm(root, { recursive: true, force: true });
    }
  });
});
