import { readFileSync } from "node:fs";
import { resolve } from "node:path";
import type { QualityContract } from "../../themes/business/jw_business/scripts/quality/model";

export const root = resolve(import.meta.dirname, "../..");
export const themeRoot = resolve(root, "themes/business/jw_business");
export const contract: QualityContract = JSON.parse(readFileSync(resolve(themeRoot, "quality/contract.json"), "utf8"));
export const mainPages = contract.pages.filter(page => ["home", "onepage"].includes(page.group));
export function selectedPages(ids = process.env.JW_UI_PAGES) {
  if (!ids || ids === 'all') return mainPages;
  const names = ids.split(",");
  if (names.some(id => !mainPages.some(page => page.id === id))) throw new Error("Unknown main page: " + ids);
  return mainPages.filter(page => names.includes(page.id));
}
export const states = [
  { name: "desktop-light", viewport: { width: 1440, height: 1000 }, mode: "jw-light" },
  { name: "desktop-dark", viewport: { width: 1440, height: 1000 }, mode: "jw-dark" },
  { name: "mobile-light", viewport: { width: 390, height: 844 }, mode: "jw-light" },
  { name: "mobile-dark", viewport: { width: 390, height: 844 }, mode: "jw-dark" },
] as const;
