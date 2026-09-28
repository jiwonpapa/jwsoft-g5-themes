import { test, expect } from "bun:test";
import { mainPages, selectedPages, states } from "./catalog";
test("all seven current main routes and wide/intermediate/theme states derive from the product contract", () => {
  expect(mainPages.map(page => page.id)).toEqual(["home-1", "home-2", "home-3", "home-4", "onepage-showcase", "onepage-services", "onepage-projects"]);
  expect(mainPages.some(page => page.route.includes("index_5"))).toBe(false);
  expect([...new Set(states.map(state=>state.viewport.width))]).toEqual([2560,1920,1280,768,1440,390]);
  expect(mainPages.length * states.length).toBe(56);
  expect(selectedPages("home-4")).toHaveLength(1);
  expect(() => selectedPages("home-5")).toThrow();
});
