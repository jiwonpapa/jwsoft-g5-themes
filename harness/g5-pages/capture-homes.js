async (page) => {
  const results = [];
  const errors = [];
  page.on('pageerror', (error) => errors.push(error.message));
  for (const variant of [2, 3, 4, 5]) {
    for (const width of [360, 390, 768, 1440]) {
      for (const mode of ['jw-light', 'jw-dark']) {
        await page.setViewportSize({ width, height: width >= 768 ? 1000 : 844 });
        await page.emulateMedia({ reducedMotion: 'reduce' });
        const response = await page.goto('https://g5themes.test/theme/jw_business/index_' + variant + '.php?device=' + (width < 768 ? 'mobile' : 'pc'));
        await page.evaluate((theme) => {
          document.documentElement.dataset.theme = theme;
          localStorage.setItem('jw-business-theme', theme);
          window.scrollTo(0, 0);
        }, mode);
        await page.evaluate(() => document.fonts.ready);
        const metrics = await page.evaluate(() => ({
          viewport: innerWidth,
          document: document.documentElement.scrollWidth,
          headingCount: document.querySelectorAll('main h1').length,
          home: document.querySelector('[data-jw-home]')?.getAttribute('data-jw-home'),
          missingIcons: document.querySelectorAll('main i[data-lucide]').length,
          brokenImages: [...document.images].filter((image) => !image.complete || image.naturalWidth === 0).length,
          overflow: [...document.querySelectorAll('main *')].filter((element) => element.getBoundingClientRect().right > innerWidth + 1).slice(0, 8).map((element) => element.className),
        }));
        let screenshot = null;
        if ((width === 1440 && mode === 'jw-light') || (width === 390 && mode === 'jw-dark')) {
          screenshot = 'output/playwright/menu-batches/home-' + variant + '-' + (width === 1440 ? 'desktop' : 'mobile') + '.png';
          await page.screenshot({ path: screenshot, fullPage: true, animations: 'disabled' });
        }
        results.push({ variant, width, mode, status: response.status(), screenshot, ...metrics });
      }
    }
  }
  return { errors, results };
}
