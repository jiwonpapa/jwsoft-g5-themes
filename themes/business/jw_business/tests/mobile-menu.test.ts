import { describe, expect, test } from "bun:test";
import { menuMatchScore } from "../src/scripts/mobile-menu";

describe("mobile navigation current destination", () => {
  test("matches a board while reading a post or changing pages", () => {
    const href = "https://g5themes.test/bbs/board.php?bo_table=gallery";
    expect(menuMatchScore(href, `${href}&wr_id=311&device=mobile`)).toBe(1);
    expect(menuMatchScore(href, `${href}&page=11`)).toBe(1);
    expect(menuMatchScore(href, "https://g5themes.test/bbs/board.php?bo_table=free")).toBe(-1);
  });
  test("keeps page variants distinct and ignores only device selection in the target", () => {
    expect(menuMatchScore("/pages/company-overview-2.php", "https://g5themes.test/pages/company-overview-2.php?device=mobile")).toBe(0);
    expect(menuMatchScore("/pages/company-overview-1.php", "https://g5themes.test/pages/company-overview-2.php")).toBe(-1);
    expect(menuMatchScore("/index.php?device=pc", "https://g5themes.test/?device=mobile")).toBe(0);
  });
  test("does not mark external or malformed destinations as current", () => {
    expect(menuMatchScore("https://example.com/", "https://g5themes.test/")).toBe(-1);
    expect(menuMatchScore("javascript:alert(1)", "https://g5themes.test/")).toBe(-1);
    expect(menuMatchScore("https://[", "https://g5themes.test/")).toBe(-1);
  });
  test("ranks a specific category or anchor above its parent", () => {
    const current = "https://g5themes.test/bbs/board.php?bo_table=gallery&sca=공간#projects";
    expect(menuMatchScore("/bbs/board.php?bo_table=gallery&sca=공간", current)).toBe(2);
    expect(menuMatchScore("/bbs/board.php?bo_table=gallery#projects", current)).toBe(2);
    expect(menuMatchScore("/bbs/board.php?bo_table=gallery#other", current)).toBe(-1);
  });
});
