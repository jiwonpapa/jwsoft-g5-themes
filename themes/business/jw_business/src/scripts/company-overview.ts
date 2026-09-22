import EmblaCarousel from "embla-carousel";

export function initializeCompanyPages(): void {
  const run = (): void => {
    const reduced = window.matchMedia("(prefers-reduced-motion: reduce)");
    document.querySelectorAll<HTMLElement>("[data-jwc-slider]").forEach((root) => {
      const viewport = root.querySelector<HTMLElement>("[data-jwc-viewport]");
      const play = root.querySelector<HTMLButtonElement>("[data-jwc-play]");
      if (!viewport || !play) return;
      const carousel = EmblaCarousel(viewport, { loop: true, duration: reduced.matches ? 0 : 25 });
      const status = root.querySelector<HTMLElement>("[data-jwc-status]");
      let playing = false;
      let timer: ReturnType<typeof setInterval> | undefined;
      let visible = true;
      const stopTimer = (): void => { clearInterval(timer); timer = undefined; };
      const schedule = (): void => {
        stopTimer();
        if (playing && visible && !document.hidden && !reduced.matches) timer = setInterval(() => carousel.scrollNext(), 5500);
      };
      const update = (): void => {
        const selected = carousel.selectedScrollSnap();
        if (status) status.textContent = `${selected + 1} / ${carousel.scrollSnapList().length}`;
        carousel.slideNodes().forEach((slide, index) => slide.setAttribute("aria-hidden", String(index !== selected)));
      };
      const setPlaying = (value: boolean): void => {
        playing = value && !reduced.matches;
        play.setAttribute("aria-pressed", String(playing));
        play.textContent = playing ? "재생 중지" : "자동 재생";
        schedule();
      };
      root.querySelector("[data-jwc-prev]")?.addEventListener("click", () => { setPlaying(false); carousel.scrollPrev(); });
      root.querySelector("[data-jwc-next]")?.addEventListener("click", () => { setPlaying(false); carousel.scrollNext(); });
      play.addEventListener("click", () => setPlaying(!playing));
      viewport.addEventListener("keydown", (event) => {
        if (event.key !== "ArrowLeft" && event.key !== "ArrowRight") return;
        event.preventDefault(); setPlaying(false);
        event.key === "ArrowLeft" ? carousel.scrollPrev() : carousel.scrollNext();
      });
      viewport.addEventListener("pointerenter", stopTimer);
      viewport.addEventListener("pointerleave", schedule);
      root.addEventListener("focusin", (event) => { if (event.target !== play) setPlaying(false); });
      carousel.on("pointerDown", () => setPlaying(false));
      carousel.on("select", update);
      carousel.on("reInit", update);
      document.addEventListener("visibilitychange", schedule);
      const preference = (): void => { setPlaying(false); play.disabled = reduced.matches; carousel.reInit({ duration: reduced.matches ? 0 : 25 }); };
      reduced.addEventListener("change", preference);
      new IntersectionObserver(([entry]) => { visible = entry?.isIntersecting ?? false; schedule(); }).observe(root);
      play.disabled = reduced.matches;
      update();
    });
    const scenes = [...document.querySelectorAll<HTMLElement>("[data-jwc-parallax]")];
    if (!scenes.length) return;
    const desktop = window.matchMedia("(min-width: 769px)");
    let queued = false;
    const paint = (): void => {
      queued = false;
      for (const scene of scenes) {
        const rect = scene.getBoundingClientRect();
        const shift = reduced.matches || !desktop.matches ? 0 : Math.max(-48, Math.min(48, (innerHeight / 2 - rect.top - rect.height / 2) * .12));
        scene.style.setProperty("--jwc-shift", `${shift.toFixed(1)}px`);
      }
    };
    const request = (): void => { if (!queued) { queued = true; requestAnimationFrame(paint); } };
    window.addEventListener("scroll", request, { passive: true });
    window.addEventListener("resize", request, { passive: true });
    reduced.addEventListener("change", request);
    desktop.addEventListener("change", request);
    paint();
  };
  document.readyState === "loading" ? document.addEventListener("DOMContentLoaded", run, { once: true }) : run();
}
