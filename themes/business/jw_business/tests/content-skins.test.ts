import { describe, expect, test } from "bun:test";
import { access, readFile } from "node:fs/promises";
import { join } from "node:path";

const root = join(import.meta.dir, "..");
const source = join(root, "src/php");
const boardSkins = ["basic", "gallery", "portfolio", "webzine", "download", "video"];
const latestSkins = ["basic", "notice", "image-list", "image-grid", "featured", "slider", "tabs", "video"];

describe("commercial content skins", () => {
  test("ships six complete PC and mobile board skin selections", async () => {
    for (const skin of boardSkins) {
      for (const surface of ["", "mobile/"]) {
        for (const file of ["list.skin.php", "view.skin.php", "view_comment.skin.php", "write.skin.php"]) {
          await expect(access(join(source, surface, "skin/board", skin, file))).resolves.toBeNull();
        }
      }
    }
  });

  test("ships eight PC and mobile latest-post selections", async () => {
    for (const skin of latestSkins) {
      await expect(access(join(source, "skin/latest", skin, "latest.skin.php"))).resolves.toBeNull();
      await expect(access(join(source, "mobile/skin/latest", skin, "latest.skin.php"))).resolves.toBeNull();
    }
  });

  test("removes superseded latest skins and legacy runtime dependencies", async () => {
    for (const skin of ["pic_basic", "pic_block", "pic_list"]) {
      await expect(access(join(source, "skin/latest", skin, "latest.skin.php"))).rejects.toThrow();
    }

    const files = [
      ...boardSkins.map((skin) => join(source, "skin/board", skin, "list.skin.php")),
      ...latestSkins.map((skin) => join(source, "skin/latest", skin, "latest.skin.php")),
    ];
    const code = (await Promise.all(files.map((file) => readFile(file, "utf8")))).join("\n");
    expect(code).not.toMatch(/jquery|font-awesome|\bfa\s+fa-/i);
    expect(code).toContain("data-jw-latest-slider");
    expect(code).toContain("data-jw-latest-tabs");
  });

  test("each G5 board and latest skin owns its markup without inc renderers", async () => {
    for (const surface of ["", "mobile/"]) {
      for (const skin of boardSkins) {
        const code = await readFile(join(source, surface, "skin/board", skin, "list.skin.php"), "utf8");
        expect(code).toContain("data-jw-board-list");
        expect(code).toContain("jw-board-search");
        expect(code).not.toContain("G5_THEME_PATH.'/skin/board/");
        expect(code).not.toContain("/inc/");
      }
    }
    for (const surface of ["", "mobile/"]) {
      for (const skin of [...latestSkins, "home_news"]) {
        const code = await readFile(join(source, surface, "skin/latest", skin, "latest.skin.php"), "utf8");
        expect(code).toContain("<section");
        expect(code).not.toContain("G5_THEME_PATH.'/skin/latest/");
        expect(code).not.toContain("/inc/");
      }
    }
    for (const name of ["board-list.php", "latest.php"]) {
      await expect(access(join(source, "inc", name))).rejects.toThrow();
    }
  });

  test("cycles all latest expressions on the native G5 group page", async () => {
    for (const path of ["group.php", "mobile/group.php"]) {
      const group = await readFile(join(source, path), "utf8");
      for (const skin of latestSkins) expect(group).toContain(`'${skin}'`);
      expect(group).toContain("latest('theme/'.$jw_skin");
      expect(group).toContain("$jw_group_subject");
      expect(group.indexOf("$jw_group_subject =")).toBeLessThan(group.indexOf("/head.php"));
      expect(group).not.toContain("get_text($group['gr_subject'])");
    }
  });
});
