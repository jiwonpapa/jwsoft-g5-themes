import { expect, test } from "bun:test";
import { searchValidation } from "../src/scripts/community-utilities";

test("global search rejects empty or one-character Korean input", () => {
  expect(searchValidation("   ")).not.toBe("");
  expect(searchValidation("가")).not.toBe("");
  expect(searchValidation("  서비스  ")).toBe("");
});
test("global search respects the core limit of one internal space", () => {
  expect(searchValidation("서비스 안내")).toBe("");
  expect(searchValidation("서비스 도입 안내")).not.toBe("");
});
