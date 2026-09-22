import { readFile, readdir } from "node:fs/promises";
import { join, resolve } from "node:path";
import { describe, expect, test } from "bun:test";

const themeRoot = resolve(import.meta.dirname, "..");

describe("general page catalog", () => {
  test("defines fifteen page types and exactly seventy-five unique routes", async () => {
    const catalog = JSON.parse(await readFile(join(themeRoot, "src/php/pages/catalog.json"), "utf8")) as {
      pageTypes: Array<{ id: string; layouts: string[] }>;
    };
    const routes = catalog.pageTypes.flatMap((pageType) => {
      expect(pageType.id).toMatch(/^[a-z][a-z0-9-]*$/);
      expect(pageType.layouts).toHaveLength(5);
      return pageType.layouts.map((_, index) => `${pageType.id}-${index + 1}`);
    });

    expect(catalog.pageTypes).toHaveLength(15);
    expect(routes).toHaveLength(75);
    expect(new Set(routes).size).toBe(75);
  });

  test("build emits physical root routes and one catalog route", async () => {
    const [pages, manifest] = await Promise.all([
      readdir(join(themeRoot, "pages")),
      readFile(join(themeRoot, "theme.manifest.json"), "utf8").then((source) => JSON.parse(source) as { build: { zipAllowlist: string[] } }),
    ]);
    pages.sort();
    expect(pages).toHaveLength(76);
    expect(pages).toContain("index.php");
    expect(manifest.build.zipAllowlist).toContain("pages/**");

    const wrapper = await readFile(join(themeRoot, "pages/company-overview-1.php"), "utf8");
    expect(wrapper).toContain("dirname(__DIR__).'/common.php'");
    expect(wrapper).toContain("$jw_page_id = 'company-overview-1'");
    expect(wrapper).toContain("G5_THEME_PATH.'/pages/page.php'");
  });

  test("theme owns navigation without the G5 menu database", async () => {
    const [header, library] = await Promise.all([
      readFile(join(themeRoot, "src/php/partials/site-header.php"), "utf8"),
      readFile(join(themeRoot, "src/php/lib/jw-business.lib.php"), "utf8"),
    ]);

    expect(header).not.toContain("get_menu_db");
    expect(header).toContain("jw_business_navigation()");
    expect(library).toContain("custom/navigation.php");
    expect(library).toContain("jw_business_page_menu_group");
    expect(library).toContain("jw_business_page_menu_group('home')");
    expect(library.indexOf("$home[0]")).toBeLessThan(library.indexOf("'me_name' => '회사소개'"));
  });

  test("routes the finished first home through its dedicated partial", async () => {
    const [router, homePage, rootHome] = await Promise.all([
      readFile(join(themeRoot, "src/php/pages/page.php"), "utf8"),
      readFile(join(themeRoot, "src/php/pages/home.php"), "utf8"),
      readFile(join(themeRoot, "src/php/partials/home.php"), "utf8"),
    ]);

    expect(router).toContain("$jw_page['id'] === 'home'");
    expect(homePage).toContain("'/partials/home/'");
    expect(homePage).toContain("$jw_full_width_page = true");
    expect(rootHome).toContain("'/partials/home/1.php'");
  });
});
