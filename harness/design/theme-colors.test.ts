import { test, expect } from "bun:test";
import stylelint from "stylelint";
import plugin, { fixedColors } from "./theme-colors.mjs";
test("color parser does not confuse URLs with colors", () => {
  expect(fixedColors('url("/art/black.webp") var(--color-primary)')).toEqual([]);
  expect(fixedColors("linear-gradient(#ffffff, rgb(0 0 0 / .2))")).toHaveLength(2);
  expect(fixedColors('var(--color-primary, #abcdef)')).toEqual(['#abcdef']);
});
test("an arbitrary UI color fails while tokens and exact artwork scopes pass", async () => {
  const config = { plugins: [plugin], rules: { "jw/theme-colors": [true, { artworkSelectors: ["^\\.artwork$"] }] } };
  expect((await stylelint.lint({ code: ".button{color:#fffffe}", config })).errored).toBe(true);
  expect((await stylelint.lint({ code: ".button{color:var(--color-primary)} .artwork{color:#fffffe}", config })).errored).toBe(false);
  expect((await stylelint.lint({ code: ".artwork-button{color:#fffffe}", config })).errored).toBe(true);
});
