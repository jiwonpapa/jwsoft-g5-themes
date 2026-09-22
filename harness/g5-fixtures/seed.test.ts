import { describe, expect, test } from "bun:test";
import manifest from "./boards.json";

function pagingState(current: number, total: number, links: number) {
  const start = Math.floor((current - 1) / links) * links + 1;
  const end = Math.min(start + links - 1, total);
  return {
    start,
    end,
    first: current > 1,
    previous: start > 1,
    next: total > end,
    last: current < total,
  };
}

describe("G5 board fixture manifest", () => {
  test("allocates enough posts for every paging control on page 11", () => {
    const { rowsPerPage, linksPerBlock, requiredPages, postsPerBoard } = manifest.pagination;
    const totalPages = Math.ceil(postsPerBoard / rowsPerPage);
    expect(totalPages).toBe(requiredPages);
    expect(postsPerBoard).toBe(rowsPerPage * linksPerBlock * 2 + 1);
    expect(pagingState(11, totalPages, linksPerBlock)).toEqual({
      start: 11,
      end: 20,
      first: true,
      previous: true,
      next: true,
      last: true,
    });
  });

  test("keeps board ids unique and assigns theme skins", () => {
    const ids = manifest.boards.map((board) => board.id);
    expect(new Set(ids).size).toBe(ids.length);
    for (const board of manifest.boards) {
      expect(board.skin.startsWith("theme/")).toBe(true);
      expect(board.categories.length).toBeGreaterThan(0);
    }
  });

  test("assigns every configurable public PC/mobile skin to the theme", () => {
    expect(Object.keys(manifest.skinSettings.config)).toEqual([
      "cf_member_skin", "cf_mobile_member_skin", "cf_new_skin", "cf_mobile_new_skin",
      "cf_search_skin", "cf_mobile_search_skin", "cf_connect_skin", "cf_mobile_connect_skin",
      "cf_faq_skin", "cf_mobile_faq_skin",
    ]);
    expect(Object.keys(manifest.skinSettings.qa)).toEqual(["qa_skin", "qa_mobile_skin"]);
    expect(Object.keys(manifest.skinSettings.content)).toEqual(["co_skin", "co_mobile_skin"]);
    expect(Object.values(manifest.skinSettings.config).every((skin) => skin === "theme/basic")).toBe(true);
    expect(Object.values(manifest.skinSettings.qa).every((skin) => skin === "theme/basic")).toBe(true);
    expect(Object.values(manifest.skinSettings.content).every((skin) => skin === "theme/basic")).toBe(true);
  });

  test("shell profile only uses skins already present in the imported basic theme", () => {
    const shell = new Set(manifest.profiles.shell);
    const shellBoards = manifest.boards.filter((board) => shell.has(board.id));
    expect(shellBoards.map((board) => board.skin).every((skin) => ["theme/basic", "theme/gallery"].includes(skin))).toBe(true);
  });
});
