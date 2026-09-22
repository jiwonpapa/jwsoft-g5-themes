import { readFile } from "node:fs/promises";
import { join, resolve } from "node:path";
import { describe, expect, test } from "bun:test";

const themeRoot = resolve(import.meta.dirname, "..");

async function readSource(path: string): Promise<string> {
  return readFile(join(themeRoot, "src/php", path), "utf8");
}

describe("public shell script contract", () => {
  test("desktop and mobile shells do not emit jQuery startup code", async () => {
    const sources = await Promise.all([
      readSource("head.php"),
      readSource("tail.php"),
      readSource("mobile/head.php"),
      readSource("mobile/tail.php"),
    ]);
    const shell = sources.join("\n");

    expect(shell).not.toMatch(/\bjQuery\b|\$\s*\(/);
    expect(shell).not.toContain("newwin.inc.php");
    expect(shell.match(/jw_business_render_popup_layer/g)).toHaveLength(2);
  });

  test("popup behavior uses the theme module contract", async () => {
    const [library, controller] = await Promise.all([
      readSource("lib/jw-business.lib.php"),
      readFile(join(themeRoot, "src/scripts/theme-controller.ts"), "utf8"),
    ]);

    expect(library).toContain("data-jw-popup-layer");
    expect(library).toContain("data-jw-popup-dismiss");
    expect(controller).toContain("function initializePopupLayer");
    expect(controller).toContain('SameSite=Lax');
  });
});
