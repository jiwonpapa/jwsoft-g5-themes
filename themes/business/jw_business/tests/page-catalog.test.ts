import { readFile } from "node:fs/promises";
import { join, resolve } from "node:path";
import { describe, expect, test } from "bun:test";

const themeRoot = resolve(import.meta.dirname, "..");

describe("general page catalog", () => {
  test("defines fourteen general page types and exactly seventy unique routes", async () => {
    const catalog = JSON.parse(await readFile(join(themeRoot, "docs/PAGE-CATALOG.json"), "utf8")) as {
      pageTypes: Array<{ id: string; layouts: string[] }>;
    };
    const routes = catalog.pageTypes.flatMap((pageType) => {
      expect(pageType.id).toMatch(/^[a-z][a-z0-9-]*$/);
      expect(pageType.layouts).toHaveLength(5);
      return pageType.layouts.map((_, index) => `${pageType.id}-${index + 1}`);
    });

    expect(catalog.pageTypes).toHaveLength(14);
    expect(routes).toHaveLength(70);
    expect(new Set(routes).size).toBe(70);
    expect(routes.some((route) => route.startsWith("home-"))).toBe(false);
  });

  test("ships web-root pages separately from the G5 theme directory", async () => {
    const manifest = await readFile(join(themeRoot, "theme.manifest.json"), "utf8")
      .then((source) => JSON.parse(source) as { build: { zipAllowlist: string[] } });

    expect(manifest.build.zipAllowlist).toContain("pages/**");
  });
});
