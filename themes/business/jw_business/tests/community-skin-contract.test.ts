import { readFile } from "node:fs/promises";
import { join, resolve } from "node:path";
import { describe, expect, test } from "bun:test";

const themeRoot = resolve(import.meta.dirname, "..");

async function readSource(path: string): Promise<string> {
  return readFile(join(themeRoot, "src/php", path), "utf8");
}

describe("community skin contract", () => {
  test("primary board and login screens do not restore legacy public assets or jQuery", async () => {
    const paths = [
      "skin/board/basic/list.skin.php",
      "skin/board/basic/view.skin.php",
      "skin/board/basic/view_comment.skin.php",
      "skin/board/basic/write.skin.php",
      "skin/member/basic/login.skin.php",
      "skin/member/basic/register.skin.php",
      "skin/member/basic/register_form.skin.php",
      "mobile/skin/board/basic/list.skin.php",
      "mobile/skin/board/basic/view.skin.php",
      "mobile/skin/board/basic/view_comment.skin.php",
      "mobile/skin/board/basic/write.skin.php",
      "mobile/skin/member/basic/login.skin.php",
      "mobile/skin/member/basic/register.skin.php",
      "mobile/skin/member/basic/register_form.skin.php",
    ];
    for (const mode of ["skin", "mobile/skin"]) {
      paths.push(`${mode}/faq/basic/list.skin.php`);
      for (const part of ["new", "search", "popular"]) paths.push(`${mode}/${part}/basic/${part}.skin.php`);
      for (const state of [1, 2]) paths.push(`${mode}/outlogin/basic/outlogin.skin.${state}.php`);
      for (const screen of ["list", "view", "write", "view.answer", "view.answerform"]) paths.push(`${mode}/qa/basic/${screen}.skin.php`);
      for (const screen of ["list", "view", "write", "view_comment"]) paths.push(`${mode}/board/gallery/${screen}.skin.php`);
      for (const screen of ["register_result", "member_confirm", "password", "password_lost", "password_reset"]) paths.push(`${mode}/member/basic/${screen}.skin.php`);
    }
    const source = (await Promise.all(paths.map(readSource))).join("\n");

    expect(source).not.toMatch(/\bjQuery\b|\$\s*\(|add_stylesheet|font-awesome|\bfa fa-/i);
    expect(source).not.toMatch(/style="/i);
  });

  test("board, comments, login, writing, and registration expose native module hooks", async () => {
    const [list, view, comments, login, write, register, registerForm, controller] = await Promise.all([
      readSource("skin/board/basic/list.skin.php"),
      readSource("skin/board/basic/view.skin.php"),
      readSource("skin/board/basic/view_comment.skin.php"),
      readSource("skin/member/basic/login.skin.php"),
      readSource("skin/board/basic/write.skin.php"),
      readSource("skin/member/basic/register.skin.php"),
      readSource("skin/member/basic/register_form.skin.php"),
      readFile(join(themeRoot, "src/scripts/theme-controller.ts"), "utf8"),
    ]);

    expect(list).toContain("data-jw-board-list");
    expect(view).toContain("data-jw-reaction");
    expect(comments).toContain("data-jw-comment-form");
    expect(login).toContain("data-jw-auto-login");
    expect(write).toContain("data-jw-write-form");
    expect(register).toContain("data-jw-register-terms");
    expect(registerForm).toContain("data-jw-member-form");
    expect(controller).toContain("function initializeBoardLists");
    expect(controller).toContain("function initializeComments");
    expect(controller).toContain("function initializeLogin");
    expect(controller).toContain("function initializeWriteForm");
    expect(controller).toContain("function initializeRegistrationTerms");
    expect(controller).toContain("function initializeMemberForm");
  });
});
