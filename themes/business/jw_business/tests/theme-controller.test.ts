import { describe, expect, test } from "bun:test";

import { DARK_THEME, LIGHT_THEME, nextTheme, resolveThemeChoice } from "../src/scripts/theme-controller";

describe("theme choice", () => {
  test("keeps an explicit light or dark choice", () => {
    expect(resolveThemeChoice(LIGHT_THEME, true)).toBe(LIGHT_THEME);
    expect(resolveThemeChoice(DARK_THEME, false)).toBe(DARK_THEME);
  });

  test("uses the system preference when no valid choice exists", () => {
    expect(resolveThemeChoice(null, true)).toBe(DARK_THEME);
    expect(resolveThemeChoice("unknown", false)).toBe(LIGHT_THEME);
  });

  test("switches between the two approved themes", () => {
    expect(nextTheme(LIGHT_THEME)).toBe(DARK_THEME);
    expect(nextTheme(DARK_THEME)).toBe(LIGHT_THEME);
  });
});
