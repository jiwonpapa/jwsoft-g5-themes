import { defineConfig } from "@playwright/test";
import { resolve } from "node:path";
import { root, states } from "./catalog";
const runName = (process.env.JW_UI_COMMAND || 'check') + '-' + (process.env.JW_UI_PAGES || 'all').replace(/[^a-z0-9,-]/g, '_');

export default defineConfig({
  testDir: "./specs",
  testMatch: process.env.JW_UI_COMMAND === "gallery" ? "gallery.spec.ts" : process.env.JW_UI_COMMAND === "compare" ? "visual.spec.ts" : process.env.JW_UI_COMMAND === "selftest" ? "guard.spec.ts" : "pages.spec.ts",
  outputDir: resolve(root, "output/qa/ui/runs", runName, "results"),
  snapshotPathTemplate: resolve(root, "harness/ui/baselines/{projectName}/{arg}{ext}"),
  updateSnapshots: "none",
  fullyParallel: false,
  workers: 1,
  retries: 0,
  timeout: 60000,
  expect: { timeout: 10000, toHaveScreenshot: { animations: "disabled", maxDiffPixelRatio: 0.001 } },
  reporter: [["list"], ["html", { outputFolder: resolve(root, "output/qa/ui/runs", runName, "report"), open: "never" }], ['json',{outputFile:resolve(root,'output/qa/ui/runs',runName,'result.json')}]],
  use: {
    baseURL: process.env.JW_UI_BASE_URL || "https://g5themes.test",
    browserName: "chromium",
    locale: "ko-KR",
    timezoneId: "Asia/Seoul",
    ignoreHTTPSErrors: true,
    reducedMotion: "reduce",
    trace: "retain-on-failure",
    screenshot: "only-on-failure",
    serviceWorkers: "block",
  },
  projects: states.map(state => ({ name: state.name, use: { viewport: state.viewport, colorScheme: state.mode === "jw-dark" ? "dark" : "light" } })),
});
