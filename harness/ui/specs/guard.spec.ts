import { test, expect } from "@playwright/test";
import { inspectPage } from "../browser";

test("real layout defects are detected", async ({ page }) => {
  await page.setContent('<main><h1 style="transform:rotate(180deg)">뒤집힌 제목</h1><section style="transform:rotateX(180deg)"><h2>부모가 뒤집힌 제목</h2></section><div style="width:calc(100vw + 100px)">overflow</div><i data-h4-icon="search">icon</i><img src="data:image/png;base64,broken"></main>');
  const result = await inspectPage(page, { requirements: [{ id: "cards", description: "required cards", selector: ".required-card", min: 4 }] });
  expect(result.reversedText).toEqual(["뒤집힌 제목", "부모가 뒤집힌 제목"]);
  expect(result.overflow).toBeGreaterThan(0);
  expect(result.brokenImages).toHaveLength(1);
  expect(result.missingIcons).toBe(1);
  expect(result.requirements[0]?.visible).toBe(false);
});
