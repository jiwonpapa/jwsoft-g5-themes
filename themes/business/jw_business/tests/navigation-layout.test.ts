import { expect, test } from "bun:test";
import { readFile } from "node:fs/promises";
import { resolve } from "node:path";

const root = resolve(import.meta.dir, "..");

test("all native menus retain grouped desktop/mobile presentation", async () => {
  const desktop = await readFile(resolve(root, "src/php/inc/menu.php"), "utf8");
  const mobile = await readFile(resolve(root, "src/php/inc/mobile-menu.php"), "utf8");
  expect(desktop).toContain("get_menu_db(0, true)");
  expect(mobile).toContain("get_menu_db(1, true)");
  for (const source of [desktop, mobile]) {
    expect(source).toContain("jw_business_menu_groups($children)");
    expect(source).toContain("$group['items']");
  }
  expect(desktop).toContain("jw-nav__mega");
  expect(mobile).toContain("data-jw-menu-group");
});

test("desktop dropdowns do not reintroduce nested scrolling", async () => {
  const css = await readFile(resolve(root, "src/styles/theme.css"), "utf8");
  const menus = [...css.matchAll(/\.jw-theme \.jw-nav__submenu[^}]+\}/g)].map((match) => match[0]);
  expect(menus.length).toBeGreaterThan(0);
  for (const rules of menus) {
    expect(rules).not.toMatch(/max-height\s*:|overflow(?:-y)?\s*:\s*(?:auto|scroll)/);
  }
});
