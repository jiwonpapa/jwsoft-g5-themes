/** Match a menu destination without treating pagination/device selection as a new section. */
export function menuMatchScore(href: string, currentHref: string): number {
  try {
    const current = new URL(currentHref);
    const target = new URL(href, current);
    const normalize = (path: string): string => path.replace(/\/index\.php$/, "/");
    if (!/^https?:$/.test(target.protocol) || target.origin !== current.origin
      || normalize(target.pathname) !== normalize(current.pathname)) return -1;
    let score = 0;
    for (const [key, value] of target.searchParams) {
      if (key === "device") continue;
      if (current.searchParams.get(key) !== value) return -1;
      score += 1;
    }
    if (target.hash && target.hash !== current.hash) return -1;
    return score + (target.hash ? 1 : 0);
  } catch {
    return -1;
  }
}

export function initializeMobileMenu(): void {
  const dialog = document.querySelector<HTMLDialogElement>("[data-jw-mobile-menu]");
  const opener = document.querySelector<HTMLButtonElement>("[data-jw-menu-open]");
  const closer = dialog?.querySelector<HTMLButtonElement>("[data-jw-menu-close]");
  const content = dialog?.querySelector<HTMLElement>("[data-jw-menu-content]");
  if (!dialog || !opener || !closer || !content || dialog.dataset.jwInitialized) return;
  dialog.dataset.jwInitialized = "true";
  const categories = [...dialog.querySelectorAll<HTMLButtonElement>("[data-jw-menu-category]")];
  const sections = [...dialog.querySelectorAll<HTMLElement>("[data-jw-menu-section]")];
  const root = document.documentElement;
  let savedY = 0;
  let locked = false;

  const select = (id: string): void => {
    categories.forEach((button) => button.setAttribute("aria-expanded", String(button.dataset.jwMenuCategory === id)));
    sections.forEach((section) => { section.hidden = section.dataset.jwMenuSection !== id; });
    content.scrollTop = 0;
  };

  // Only the most specific matching destination gets current-page semantics.
  let currentLink: HTMLAnchorElement | undefined;
  let bestScore = -1;
  dialog.querySelectorAll<HTMLAnchorElement>(".jw-mobile-menu__body a[href]").forEach((link) => {
    const score = menuMatchScore(link.href, window.location.href);
    if (score > bestScore) { currentLink = link; bestScore = score; }
  });
  if (currentLink) {
    currentLink.setAttribute("aria-current", "page");
    const group = currentLink.closest<HTMLDetailsElement>("[data-jw-menu-group]");
    if (group) group.open = true;
  }
  const initialSection = currentLink?.closest<HTMLElement>("[data-jw-menu-section]")?.dataset.jwMenuSection
    ?? categories[0]?.dataset.jwMenuCategory;
  if (initialSection !== undefined) select(initialSection);

  categories.forEach((button) => button.addEventListener("click", () => select(button.dataset.jwMenuCategory!)));
  dialog.querySelectorAll<HTMLDetailsElement>("[data-jw-menu-group]").forEach((group) => {
    group.addEventListener("toggle", () => {
      if (!group.open) return;
      group.closest("section")?.querySelectorAll<HTMLDetailsElement>("[data-jw-menu-group]").forEach((sibling) => {
        if (sibling !== group) sibling.open = false;
      });
    });
  });

  const unlock = (): void => {
    if (!locked) return;
    locked = false;
    root.classList.remove("jw-menu-is-open");
    root.style.removeProperty("--jw-menu-scroll");
    window.scrollTo({ top: savedY, behavior: "instant" });
    opener.setAttribute("aria-expanded", "false");
    if (opener.getClientRects().length) opener.focus({ preventScroll: true });
  };
  opener.addEventListener("click", () => {
    if (dialog.open) return;
    savedY = window.scrollY;
    dialog.showModal();
    locked = true;
    root.style.setProperty("--jw-menu-scroll", `${-savedY}px`);
    root.classList.add("jw-menu-is-open");
    document.querySelector("[data-jw-sticky-header]")?.classList.remove("is-hidden");
    opener.setAttribute("aria-expanded", "true");
    closer.focus({ preventScroll: true });
  });
  closer.addEventListener("click", () => dialog.close());
  dialog.addEventListener("close", unlock);
  // Native dialogs can tab into browser chrome; keep the menu's first/last control connected.
  dialog.addEventListener("keydown", (event) => {
    if (event.key !== "Tab") return;
    const controls = [...dialog.querySelectorAll<HTMLElement>("a[href], button:not([disabled]), summary, [tabindex='0']")]
      .filter((element) => {
        const closedGroup = element.closest("details:not([open])");
        return !element.closest("[hidden]") && element.getClientRects().length > 0
          && (!closedGroup || closedGroup.querySelector(":scope > summary") === element);
      });
    const first = controls[0];
    const last = controls.at(-1);
    if (event.shiftKey && document.activeElement === first && last) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last && first) {
      event.preventDefault();
      first.focus();
    }
  });
  // Restore the document before the browser stores a page in the back-forward cache.
  dialog.addEventListener("click", (event) => {
    const link = event.target instanceof Element ? event.target.closest<HTMLAnchorElement>("a[href]") : null;
    if (link && link.target !== "_blank" && !(event.metaKey || event.ctrlKey || event.shiftKey || event.altKey)) {
      dialog.close();
      unlock();
    }
  });
  window.matchMedia("(min-width: 861px)").addEventListener("change", (event) => {
    if (event.matches && dialog.open) dialog.close();
  });
  window.addEventListener("pagehide", () => { if (dialog.open) dialog.close(); unlock(); });
}
