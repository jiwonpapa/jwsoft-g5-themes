async (page) => {
  const checks = [];
  const errors = [];
  page.on('pageerror', (error) => errors.push(error.message));
  for (const width of [900, 1024, 1440]) {
    for (const mode of ['jw-light', 'jw-dark']) {
      await page.setViewportSize({ width, height: 900 });
      await page.goto('https://g5themes.test/?device=pc');
      await page.emulateMedia({ reducedMotion: 'reduce' });
      await page.evaluate((theme) => { document.documentElement.dataset.theme = theme; }, mode);
      await page.evaluate(() => document.fonts.ready);
      const items = page.locator('.jw-nav__item');
      for (let index = 0; index < await items.count(); index += 1) {
        const item = items.nth(index);
        await item.locator('.jw-nav__link').hover();
        await page.waitForFunction((position) => {
          const menu = document.querySelectorAll('.jw-nav__item')[position].querySelector('.jw-nav__submenu');
          const style = getComputedStyle(menu);
          return style.visibility === 'visible' && style.opacity === '1';
        }, index);
        const metrics = await item.evaluate((element) => {
          const menu = element.querySelector('.jw-nav__submenu');
          const rect = menu.getBoundingClientRect();
          return {
            title: element.querySelector('.jw-nav__link').textContent.trim(),
            visible: getComputedStyle(menu).visibility === 'visible',
            scroll: menu.scrollHeight > menu.clientHeight + 1,
            bounds: { left: rect.left, right: rect.right, top: rect.top, bottom: rect.bottom },
            groupCount: menu.querySelectorAll('.jw-nav__group').length,
            linkCount: menu.querySelectorAll('a').length,
            clippedLinks: [...menu.querySelectorAll('a')].filter(link => {
              const box = link.getBoundingClientRect();
              return box.right > innerWidth || box.left < 0 || box.bottom > innerHeight;
            }).map(link => link.textContent.trim()),
          };
        });
        checks.push({ width, mode, ...metrics });
        if (width === 1440 && mode === 'jw-light') {
          await page.screenshot({ path: 'output/playwright/menu-restoration/desktop-' + index + '.png', animations: 'disabled' });
        }
      }
    }
  }
  const mobile = [];
  for (const width of [360, 390]) {
    await page.setViewportSize({ width, height: 844 });
    await page.goto('https://g5themes.test/?device=mobile');
    await page.evaluate(() => { document.documentElement.dataset.theme = 'jw-dark'; });
    await page.getByRole('button', { name: '전체 메뉴 열기' }).click();
    const buttons = page.locator('[data-jw-menu-category]');
    for (let index = 0; index < await buttons.count(); index += 1) {
      await buttons.nth(index).click();
      const section = page.locator('[data-jw-menu-section]:not([hidden])');
      const groups = section.locator('details');
      if (await groups.count()) await groups.first().locator('summary').click();
      mobile.push({ width, index, groups: await groups.count(), links: await section.locator('a').count(), opened: await section.locator('details[open]').count(), overflow: await page.evaluate(() => document.documentElement.scrollWidth > innerWidth) });
      if (width === 390) await page.screenshot({ path: 'output/playwright/menu-restoration/mobile-' + index + '.png', animations: 'disabled' });
    }
    await page.keyboard.press('Escape');
    mobile.push({ width, closed: !(await page.locator('dialog').evaluate(el => el.open)), restoredFocus: await page.getByRole('button', { name: '전체 메뉴 열기' }).evaluate(el => el === document.activeElement) });
  }
  return { errors, checks, mobile };
}
