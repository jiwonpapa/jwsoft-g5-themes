import { describe, expect, test } from "bun:test";
import { readFile } from "node:fs/promises";
import { resolve } from "node:path";

const themeRoot = resolve(import.meta.dir, "..");

describe("standalone home designs", () => {
  test("each new home owns its body, accessible title and valid local anchors", async () => {
    for (const variant of [2, 3, 4, 5]) {
      const source = await readFile(resolve(themeRoot, `src/php/index_${variant}.php`), "utf8");
      expect(source.match(/<h1\b/g)).toHaveLength(1);
      expect(source).toContain(`data-jw-home="${variant}"`);
      expect(source).not.toMatch(/jw-page-facade|partials\/|home-[1-5]\.php|Layout [1-5]/);
      const ids = [...source.matchAll(/\bid="([^"]+)"/g)].map((match) => match[1]);
      expect(new Set(ids).size).toBe(ids.length);
      for (const match of source.matchAll(/href="#([^"]+)"/g)) {
        expect(ids).toContain(match[1]);
      }
      for (const match of source.matchAll(/jw_business_page_url\('([^']+)'\)/g)) {
        expect(await Bun.file(resolve(themeRoot, `pages/${match[1]}.php`)).exists()).toBe(true);
      }
    }
  });

  test("business, project, process and one-page structures are distinct", async () => {
    const selectors = ["jwh-business-rows", "jwh-case-pair", "jwh-deliverables", "jwh-one-nav"];
    for (const [index, expected] of selectors.entries()) {
      const source = await readFile(resolve(themeRoot, `src/php/index_${index + 2}.php`), "utf8");
      expect(source).toContain(expected);
      for (const other of selectors.filter((selector) => selector !== expected)) {
        expect(source).not.toContain(other);
      }
    }
  });

  test("illustrative projects disclose that they are not customer claims", async () => {
    for (const variant of [2, 3, 5]) {
      const source = await readFile(resolve(themeRoot, `src/php/index_${variant}.php`), "utf8");
      expect(source).toContain("시연");
      expect(source).toMatch(/실제 고객.*(?:아닙니다|뜻하지 않습니다)/);
    }
  });

  test("copy-source references exist outside the runtime theme", async () => {
    for (const variant of [2, 4]) {
      const source = await readFile(resolve(themeRoot, `src/php/index_${variant}.php`), "utf8");
      for (const match of source.matchAll(/JW BLOCK COPY START: ([^;]+);/g)) {
        expect(await Bun.file(resolve(themeRoot, match[1]!)).exists()).toBe(true);
      }
    }
  });

  test("sprite logos retain their clipping frame in every native shell", async () => {
    for (const file of ["head.php", "tail.php", "mobile/head.php", "mobile/tail.php"]) {
      const source = await readFile(resolve(themeRoot, "src/php", file), "utf8");
      expect(source).toContain('class="jw-brand__viewport');
      expect(source).toContain('class="jw-brand__image jw-brand__image--light"');
      expect(source).not.toContain("jw-brand__mark");
    }
  });
});
