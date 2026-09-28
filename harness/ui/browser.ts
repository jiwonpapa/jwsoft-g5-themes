import type { Page } from "@playwright/test";
import type { PagePlan } from "../../themes/business/jw_business/scripts/quality/model";

export async function settle(page: Page) {
  await page.evaluate(async () => {
    await document.fonts.ready;
    // Trigger lazy media with the real scroll path before taking a full document capture.
    for (let y = 0; y < document.documentElement.scrollHeight; y += innerHeight) {
      scrollTo(0, y);
      await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));
    }
    // Offscreen Embla slides are horizontally hidden, so vertical scrolling alone
    // does not request their lazy images. Load them for a complete capture.
    await Promise.all([...document.images].map(image => {
      image.loading = 'eager';
      return image.decode().catch(() => undefined);
    }));
    scrollTo(0, 0);
    await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));
  });
}

export async function openPage(page: Page, plan: PagePlan, dark: boolean) {
  await page.addInitScript(mode => localStorage.setItem("jw-business-theme", mode), dark ? "jw-dark" : "jw-light");
  const device = (page.viewportSize()?.width || 1440) < 768 ? 'mobile' : 'pc';
  const response = await page.goto(plan.route + (plan.route.includes('?') ? '&' : '?') + 'device=' + device, { waitUntil: "networkidle" });
  if (!response?.ok()) throw new Error("HTTP " + response?.status() + ": " + plan.route);
  await settle(page);
}

export async function inspectPage(page: Page, plan: Pick<PagePlan, "requirements">) {
  return page.evaluate(requirements => {
    const visible = (element: Element) => {
      const box = element.getBoundingClientRect(), css = getComputedStyle(element);
      return box.width > 0 && box.height > 0 && css.display !== "none" && css.visibility !== "hidden" && Number(css.opacity) > 0;
    };
    const body = document.querySelector("main") || document.body;
    const headings = [...body.querySelectorAll("h1,h2,h3")].filter(visible);
    const reversedText = headings.filter(el => {
      let matrix = new DOMMatrixReadOnly();
      for (let current: Element | null = el; current; current = current.parentElement) {
        const transform = getComputedStyle(current).transform;
        if (transform !== 'none') matrix = new DOMMatrixReadOnly(transform).multiply(matrix);
      }
      return matrix.a < 0 || matrix.d < 0;
    }).map(el => el.textContent?.trim().slice(0, 80));
    return {
      mode: document.documentElement.dataset.theme,
      documentHeight: document.documentElement.scrollHeight,
      overflow: Math.max(0, document.documentElement.scrollWidth - innerWidth),
      brokenImages: [...document.images].filter(img => !img.complete || img.naturalWidth === 0).map(img => img.currentSrc || img.src),
      missingIcons: [...body.querySelectorAll("i[data-lucide],i[data-h4-icon],i[data-jwo-icon]")].filter(visible).length,
      reversedText,
      requirements: requirements.map(item => {
        const all = [...document.querySelectorAll(item.selector)];
        return { id: item.id, count: all.length, visible: all.filter(visible).length >= item.min };
      }),
      media: [...new Set([
        ...[...document.images].map(img => img.currentSrc || img.src),
        ...[...body.querySelectorAll('*')].flatMap(el => [...getComputedStyle(el).backgroundImage.matchAll(/url\(["']?(https?:[^"')]+)["']?\)/g)].map(match => match[1]!)),
      ])],
      regions: Object.fromEntries(['.h4-process','.jw-footer'].flatMap(selector => {
        const el=document.querySelector(selector); if (!el) return [];
        const box=el.getBoundingClientRect();
        return [[selector,{left:Math.round(box.left+scrollX),top:Math.round(box.top+scrollY),width:Math.round(box.width),height:Math.round(box.height)}]];
      })),
    };
  }, plan.requirements);
}

export async function alignedRows(page: Page, selector: string) {
  return page.locator(selector).evaluateAll(elements => {
    const rows = new Map<number, number[]>();
    for (const element of elements) {
      const card = element.closest(".h4-process-card")?.getBoundingClientRect();
      if (!card) continue;
      const key = Math.round(card.top), box = element.getBoundingClientRect();
      rows.set(key, [...(rows.get(key) || []), box.top]);
    }
    return [...rows.values()].every(values => Math.max(...values) - Math.min(...values) <= 1);
  });
}
