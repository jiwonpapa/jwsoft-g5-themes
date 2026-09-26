import EmblaCarousel, { type EmblaCarouselType } from "embla-carousel";

const AUTOPLAY_DELAY = 8500;

export const initializeHome2 = (root: ParentNode = document): void => {
  root.querySelectorAll<HTMLElement>("[data-jw-home2-slider]").forEach((slider) => {
    if (slider.dataset.jwHome2Ready === "true") return;

    const viewport = slider.querySelector<HTMLElement>("[data-jwh2-viewport]");
    const slides = Array.from(slider.querySelectorAll<HTMLElement>("[data-jwh2-slide]"));
    const dots = Array.from(slider.querySelectorAll<HTMLButtonElement>("[data-jwh2-dot]"));
    const current = slider.querySelector<HTMLElement>("[data-jwh2-current]");
    const previous = slider.querySelector<HTMLButtonElement>("[data-jwh2-prev]");
    const next = slider.querySelector<HTMLButtonElement>("[data-jwh2-next]");
    const play = slider.querySelector<HTMLButtonElement>("[data-jwh2-play]");
    if (!viewport || slides.length < 2) return;

    slider.dataset.jwHome2Ready = "true";
    const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
    let carousel: EmblaCarouselType | null = EmblaCarousel(viewport, {
      loop: true,
      align: "start",
      duration: reducedMotion.matches ? 0 : 28,
      watchDrag: !reducedMotion.matches,
    });
    let timer: number | null = null;
    let manuallyPaused = reducedMotion.matches;
    let pageVisible = !document.hidden;
    let sliderVisible = true;

    const update = (): void => {
      if (!carousel) return;
      const selected = carousel.selectedScrollSnap();
      slides.forEach((slide, index) => {
        const active = index === selected;
        slide.classList.toggle("is-active", active);
        slide.setAttribute("aria-hidden", String(!active));
        slide.querySelectorAll<HTMLElement>("a, button, input, select, textarea, [tabindex]").forEach((item) => {
          if (active) item.removeAttribute("tabindex");
          else item.setAttribute("tabindex", "-1");
        });
      });
      dots.forEach((dot, index) => {
        const active = index === selected;
        dot.classList.toggle("is-active", active);
        dot.setAttribute("aria-pressed", String(active));
      });
      if (current) current.textContent = String(selected + 1).padStart(2, "0");
    };

    const stop = (): void => {
      if (timer !== null) {
        window.clearInterval(timer);
        timer = null;
      }
    };
    const start = (): void => {
      stop();
      if (!carousel || manuallyPaused || reducedMotion.matches || !pageVisible || !sliderVisible) return;
      timer = window.setInterval(() => carousel?.scrollNext(), AUTOPLAY_DELAY);
    };
    const syncPlay = (): void => {
      if (!play) return;
      play.textContent = manuallyPaused ? "재생" : "멈춤";
      play.setAttribute("aria-label", manuallyPaused ? "슬라이드 자동 전환 재생" : "슬라이드 자동 전환 멈춤");
    };

    previous?.addEventListener("click", () => { carousel?.scrollPrev(); start(); });
    next?.addEventListener("click", () => { carousel?.scrollNext(); start(); });
    dots.forEach((dot, index) => dot.addEventListener("click", () => { carousel?.scrollTo(index); start(); }));
    play?.addEventListener("click", () => { manuallyPaused = !manuallyPaused; syncPlay(); start(); });
    viewport.addEventListener("keydown", (event) => {
      if (event.key === "ArrowLeft") { event.preventDefault(); carousel?.scrollPrev(); start(); }
      if (event.key === "ArrowRight") { event.preventDefault(); carousel?.scrollNext(); start(); }
    });
    slider.addEventListener("pointerenter", stop);
    slider.addEventListener("pointerleave", start);
    slider.addEventListener("focusin", stop);
    slider.addEventListener("focusout", (event) => {
      if (!slider.contains(event.relatedTarget as Node | null)) start();
    });
    document.addEventListener("visibilitychange", () => { pageVisible = !document.hidden; start(); });

    const observer = new IntersectionObserver(([entry]) => {
      sliderVisible = Boolean(entry?.isIntersecting);
      start();
    }, { threshold: 0.15 });
    observer.observe(slider);

    const handleReducedMotion = (): void => {
      if (reducedMotion.matches) manuallyPaused = true;
      carousel?.reInit({ loop: true, align: "start", duration: reducedMotion.matches ? 0 : 28, watchDrag: !reducedMotion.matches });
      syncPlay();
      start();
    };
    reducedMotion.addEventListener("change", handleReducedMotion);
    carousel.on("select", update);
    carousel.on("reInit", update);
    update();
    syncPlay();
    start();

    window.addEventListener("beforeunload", () => {
      stop();
      observer.disconnect();
      reducedMotion.removeEventListener("change", handleReducedMotion);
      carousel?.destroy();
      carousel = null;
    }, { once: true });
  });
};
