import { afterAll, beforeAll, expect, test } from 'bun:test';
import { chromium, type Browser } from '@playwright/test';
import { resolve } from 'node:path';

// Real Embla + real browser regression; run explicitly with:
// bun test harness/ui/regressions/onepage-autoplay.test.ts
let browser: Browser;
let server: ReturnType<typeof Bun.serve>;
beforeAll(async () => {
  const build = await Bun.build({ entrypoints: [resolve('themes/business/jw_business/src/scripts/onepages.js')], target: 'browser' });
  if (!build.success) throw new Error(build.logs.map(String).join('\n'));
  const script = await build.outputs[0].text();
  const html = `<!doctype html><html><head><meta charset="utf-8"><style>
    body{margin:0}section{width:100%}.viewport{overflow:hidden;height:240px}.jwo-project-hero__track{display:flex;height:100%}.jwo-project-hero__track>figure{flex:0 0 100%;min-width:0;margin:0}button,a{display:inline-block;padding:15px}#studio{height:900px}
    </style></head><body><article data-jw-onepage="projects">
    <nav class="jwo-nav"><div class="jwo-nav__links"><a href="#studio">스튜디오</a></div></nav>
    <section data-jwo-project-hero><div class="viewport" data-jwo-project-hero-viewport><div class="jwo-project-hero__track"><figure>One</figure><figure>Two</figure><figure>Three</figure></div></div>
    <div hidden data-jwo-project-hero-controls><button data-jwo-project-hero-prev>이전</button><span data-jwo-project-hero-status></span><button data-jwo-project-hero-next>다음</button><button data-jwo-project-hero-toggle></button></div></section>
    <section id="studio"><a href="#studio">다른 영역</a></section></article><script type="module" src="/onepages.js"></script></body></html>`;
  server = Bun.serve({ port: 0, fetch: request => new Response(new URL(request.url).pathname === '/onepages.js' ? script : html, { headers: { 'Content-Type': new URL(request.url).pathname === '/onepages.js' ? 'text/javascript' : 'text/html' } }) });
  browser = await chromium.launch({ headless: true });
});
afterAll(async () => { await browser?.close(); server?.stop(true); });

test('explicit pause survives blur, mouseleave, navigation and a full autoplay interval; play resumes', async () => {
  const page = await browser.newPage({ viewport: { width: 390, height: 844 }, colorScheme: 'dark', reducedMotion: 'no-preference' });
  try {
    page.setDefaultTimeout(5000);
    await page.goto(server.url.href);
    const toggle = page.locator('[data-jwo-project-hero-toggle]');
    const status = page.locator('[data-jwo-project-hero-status]');
    const viewport = page.locator('[data-jwo-project-hero-viewport]');
    await page.getByRole('button', { name: '자동 슬라이드 일시 정지', exact: true }).click();
    const paused = await status.textContent();
    await viewport.focus();
    await page.mouse.move(150, 150);
    await page.getByRole('link', { name: '스튜디오', exact: true }).click();
    await page.mouse.move(380, 800);
    await page.waitForTimeout(8200);
    expect(await status.textContent()).toBe(paused);
    expect(await toggle.getAttribute('aria-label')).toBe('자동 슬라이드 재생');
    await page.locator('[data-jwo-project-hero-next]').click();
    expect(await status.textContent()).not.toBe(paused);
    await page.locator('[data-jwo-project-hero-prev]').click();
    await viewport.press('End');
    expect(await status.textContent()).toBe('03 / 03');
    await page.getByRole('link', { name: '스튜디오', exact: true }).click();
    await page.mouse.move(380, 800);
    await page.waitForTimeout(8200);
    expect(await status.textContent()).toBe('03 / 03');
    expect(await toggle.getAttribute('aria-label')).toBe('자동 슬라이드 재생');
    await toggle.click();
    await page.getByRole('link', { name: '스튜디오', exact: true }).click();
    await page.mouse.move(380, 800);
    await page.waitForFunction(() => document.querySelector('[data-jwo-project-hero-status]')?.textContent !== '03 / 03', null, { timeout: 8000 });
    expect(await toggle.getAttribute('aria-label')).toBe('자동 슬라이드 일시 정지');
  } finally { await page.close(); }
}, 40000);

test('reduced motion stops an active carousel and remains paused after leaving the viewport', async () => {
  const page = await browser.newPage({ viewport: { width: 1440, height: 1000 }, reducedMotion: 'no-preference' });
  try {
    page.setDefaultTimeout(5000);
    await page.goto(server.url.href);
    await page.waitForSelector('[data-jwo-project-hero-toggle][aria-pressed="true"]');
    await page.emulateMedia({ reducedMotion: 'reduce' });
    await page.waitForSelector('[data-jwo-project-hero-toggle][aria-pressed="false"]');
    const status = page.locator('[data-jwo-project-hero-status]');
    const paused = await status.textContent();
    await page.locator('[data-jwo-project-hero-viewport]').focus();
    await page.mouse.move(150, 150);
    await page.getByRole('link', { name: '스튜디오', exact: true }).click();
    await page.mouse.move(1400, 950);
    await page.waitForTimeout(8200);
    expect(await status.textContent()).toBe(paused);
    expect(await page.locator('[data-jwo-project-hero-toggle]').getAttribute('aria-pressed')).toBe('false');
  } finally { await page.close(); }
}, 15000);
