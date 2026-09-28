import { test, expect } from "@playwright/test";
import AxeBuilder from "@axe-core/playwright";
import { mkdir, writeFile } from "node:fs/promises";
import { createHash } from "node:crypto";
import { resolve } from "node:path";
import { root, themeRoot, selectedPages } from "../catalog";
import { alignedRows, inspectPage, openPage } from "../browser";
import { inputDigest } from "../../../themes/business/jw_business/scripts/quality/files";

for (const plan of selectedPages()) {
  test(plan.id, async ({ page, browser }, info) => {
    const errors: string[] = [];
    page.on("pageerror", error => errors.push(error.message));
    await openPage(page, plan, info.project.name.endsWith("-dark"));
    const directory = resolve(root, "output/qa/ui/captures", plan.id);
    await mkdir(directory, { recursive: true });
    // Required diagram belongs to an inactive tab: verify each real state, then capture installation.
    if (plan.id === 'onepage-showcase') {
      const tabs = page.getByRole('tab');
      await expect(tabs).toHaveCount(3);
      for (let index = 0; index < 3; index++) {
        await tabs.nth(index).click();
        await expect(tabs.nth(index)).toHaveAttribute('aria-selected', 'true');
        const panelId = await tabs.nth(index).getAttribute('aria-controls');
        await expect(page.locator('#' + panelId)).toBeVisible();
        await page.locator('#' + panelId).screenshot({path: resolve(directory, info.project.name + '.detail-' + index + '.png')});
      }
      await tabs.nth(2).press('Home');
      await expect(tabs.nth(0)).toHaveAttribute('aria-selected', 'true');
      await tabs.nth(0).press('ArrowRight');
      await expect(tabs.nth(1)).toHaveAttribute('aria-selected', 'true');
      await tabs.nth(1).press('End');
      await expect(page.locator('[data-jwo-install-diagram]')).toBeVisible();
      await page.evaluate(() => scrollTo(0, 0));
    }
    const metrics = await inspectPage(page, plan);

    const file = resolve(directory, info.project.name + ".png");
    const bytes = await page.screenshot({ path: file, fullPage: true, animations: "disabled" });
    const capture = {
      result: "collected-not-approved", page: plan.id, state: info.project.name,
      url: page.url(), capturedAt: new Date().toISOString(), viewport: page.viewportSize(),
      fullPage: true, file, sha256: createHash("sha256").update(bytes).digest("hex"),
      inputDigest: await inputDigest(themeRoot), platform: process.platform, browser: browser.version(), errors, ...metrics,
    };
    await writeFile(resolve(directory, info.project.name + ".json"), JSON.stringify(capture, null, 2) + "\n");
    await info.attach("capture", { path: file, contentType: "image/png" });
    if (process.env.JW_UI_COMMAND === "capture") return;
    expect.soft(errors, "browser errors").toEqual([]);
    expect.soft(metrics.overflow, "horizontal overflow").toBeLessThanOrEqual(1);
    expect.soft(metrics.brokenImages, "broken images").toEqual([]);
    expect.soft(metrics.missingIcons, "unrendered icons").toBe(0);
    expect.soft(metrics.reversedText, "reversed headings").toEqual([]);
    for (const requirement of plan.requirements) {
      const actual = metrics.requirements.find(item => item.id === requirement.id)!;
      expect.soft(actual.count, requirement.description).toBeGreaterThanOrEqual(requirement.min);
      expect.soft(actual.visible, requirement.description).toBe(true);
    }
    if (plan.id === 'onepage-services') {
      const icons = page.locator('.jwo-service-card > svg[data-jwo-icon]');
      await expect(icons).toHaveCount(3);
      for (const icon of await icons.all()) expect((await icon.boundingBox())!.width).toBeGreaterThanOrEqual(60);
    }
    if (plan.id === "home-4") {
      expect.soft(await alignedRows(page, ".h4-process-card h3"), "process title alignment").toBe(true);
      expect.soft(await alignedRows(page, ".h4-process-card p"), "process copy alignment").toBe(true);
    }
    const accessibility = await new AxeBuilder({ page }).withTags(["wcag2a", "wcag2aa", "wcag21aa"]).analyze();
    await writeFile(resolve(directory, info.project.name + ".axe.json"), JSON.stringify(accessibility.violations, null, 2));
    await info.attach("accessibility", { body: JSON.stringify(accessibility.violations, null, 2), contentType: "application/json" });
    expect.soft(accessibility.violations.map(item => ({ id: item.id, nodes: item.nodes.map(node => node.target) })), "accessibility").toEqual([]);
    if (plan.id === 'home-4') {
      const question=page.locator('.h4-faq-list details').first();
      await question.locator('summary').click(); await expect(question).toHaveAttribute('open','');
      await question.locator('summary').click(); await expect(question).not.toHaveAttribute('open','');
      if (info.project.name.startsWith('mobile')) await page.locator('[data-jw-menu-open]').click();
      await page.locator('[data-jw-theme-toggle]:visible').click();
      await expect(page.locator('html')).toHaveAttribute('data-theme',info.project.name.endsWith('-dark')?'jw-light':'jw-dark');
      expect(await page.locator('.h4-process-card > svg.h4-large-icon').count()).toBe(4);
    }
  });
}
