import { readFile } from "node:fs/promises";
import { join, resolve } from "node:path";
import { describe, expect, test } from "bun:test";

const themeRoot = resolve(import.meta.dirname, "..");
const sourcePath = join(themeRoot, "src/php/head.sub.php");

describe("public head contract", () => {
  test("loads one modern stylesheet and one ESM entry", async () => {
    const source = await readFile(sourcePath, "utf8");

    expect(source.match(/jw-business\.min\.css/g)).toHaveLength(1);
    expect(source.match(/jw-business\.min\.js/g)).toHaveLength(1);
    expect(source).toContain('<script type="module"');
  });

  test("uses one responsive document contract on every device", async () => {
    const source = await readFile(sourcePath, "utf8");

    expect(source.match(/<meta charset=/g)).toHaveLength(1);
    expect(source.match(/<meta name="viewport"/g)).toHaveLength(1);
    expect(source.match(/<title>/g)).toHaveLength(1);
    expect(source).toContain("width=device-width, initial-scale=1, viewport-fit=cover");
    expect(source).toContain('class="jw-theme" data-theme="jw-light"');
    expect(source).toContain('name="color-scheme" content="light dark"');
  });

  test("does not restore forbidden public legacy assets or metadata", async () => {
    const source = await readFile(sourcePath, "utf8");
    const forbidden = [
      "jquery",
      "migrate",
      "font-awesome",
      "modernizr",
      "placeholders",
      "default.css",
      "mobile.css",
      "X-UA-Compatible",
      "HandheldFriendly",
      "imagetoolbar",
      "minimum-scale",
      "maximum-scale",
      "cf_add_meta",
      "cf_add_script",
      "body_script",
      "add_javascript",
      "add_stylesheet",
    ];

    for (const token of forbidden) {
      expect(source.toLowerCase()).not.toContain(token.toLowerCase());
    }
  });

  test("escapes page metadata and accepts route-owned values only", async () => {
    const source = await readFile(sourcePath, "utf8");

    expect(source).toContain("ENT_QUOTES | ENT_SUBSTITUTE");
    expect(source).toContain("$g5['document_meta']");
    expect(source).toContain('rel="canonical"');
    expect(source).toContain('property="og:title"');
  });
});
