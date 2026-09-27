import { test, expect } from "@playwright/test";
import { selectedPages } from "../catalog";
import { reviewedBaseline } from '../baseline';
import { openPage } from "../browser";

for (const plan of selectedPages()) {
  test(plan.id, async ({ page, browser }, info) => {
    // A missing baseline is a failure, never an invitation to silently accept the current page.
    await reviewedBaseline(plan.id, info.project.name, browser.version());
    await openPage(page, plan, info.project.name.endsWith("-dark"));
    await expect(page).toHaveScreenshot(plan.id + ".png", { fullPage: true });
  });
}
