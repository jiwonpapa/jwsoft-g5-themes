import { readFileSync } from "node:fs";
import { resolve } from "node:path";
import type { QualityContract } from "../../themes/business/jw_business/scripts/quality/model";

export const root = resolve(import.meta.dirname, "../..");
export const themeRoot = resolve(root, "themes/business/jw_business");
export const contract: QualityContract = JSON.parse(readFileSync(resolve(themeRoot, "quality/contract.json"), "utf8"));
export const mainPages = contract.pages.filter(page => ["home", "onepage"].includes(page.group));
export const generalPages = contract.pages.filter(page =>
  ["company-overview", "business-list", "business-detail", "contact"].includes(page.group) && page.ready);
export function selectedPages(ids = process.env.JW_UI_PAGES) {
  if (!ids || ids === 'all') return mainPages;
  if (ids === 'general') return generalPages;
  const names = ids.split(",");
  const readyPages = [...mainPages, ...generalPages];
  if (names.some(id => !readyPages.some(page => page.id === id))) throw new Error("Unknown ready page: " + ids);
  return readyPages.filter(page => names.includes(page.id));
}
export const states = [
  { name: "wide-light", viewport: { width: 2560, height: 1100 }, mode: "jw-light" },
  { name: "large-light", viewport: { width: 1920, height: 1080 }, mode: "jw-light" },
  { name: "compact-light", viewport: { width: 1280, height: 900 }, mode: "jw-light" },
  { name: "tablet-light", viewport: { width: 768, height: 1024 }, mode: "jw-light" },
  { name: "desktop-light", viewport: { width: 1440, height: 1000 }, mode: "jw-light" },
  { name: "desktop-dark", viewport: { width: 1440, height: 1000 }, mode: "jw-dark" },
  { name: "mobile-light", viewport: { width: 390, height: 844 }, mode: "jw-light" },
  { name: "mobile-dark", viewport: { width: 390, height: 844 }, mode: "jw-dark" },
] as const;
