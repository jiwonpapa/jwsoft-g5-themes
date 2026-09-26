import EmblaCarousel from 'embla-carousel';
import Autoplay from 'embla-carousel-autoplay';
import Fade from 'embla-carousel-fade';
import { inView, scroll } from 'motion';

/** Main 1 owns its markup; reusable libraries own slide and scroll mechanics. */
export function initializeHomeOne(): void {
  const root = document.querySelector<HTMLElement>('[data-jw-home="1"].jwh1-concept');
  const hero = root?.querySelector<HTMLElement>('[data-jw-hero-slider]');
  const viewport = hero?.querySelector<HTMLElement>('[data-jw-hero-viewport]');
  if (!root || !hero || !viewport) return;

  const slides = [...viewport.querySelectorAll<HTMLElement>('[data-slide]')];
  const dots = [...hero.querySelectorAll<HTMLButtonElement>('[data-goto]')];
  const current = hero.querySelector<HTMLElement>('[data-current]');
  const playButton = hero.querySelector<HTMLButtonElement>('[data-play]');
  if (slides.length < 2 || !current || !playButton) return;

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  slides.forEach(slide => { slide.hidden = false; });
  const autoplay = Autoplay({ delay: 6500, playOnInit: false, stopOnFocusIn: true, stopOnMouseEnter: true, stopOnInteraction: true, rootNode: () => hero });
  const carousel = EmblaCarousel(viewport, {
    loop: true,
    duration: reduced.matches ? 0 : 25,
    breakpoints: { '(prefers-reduced-motion: reduce)': { duration: 0 } },
  }, [Fade(), autoplay]);

  const syncPlayback = (): void => {
    const playing = autoplay.isPlaying() && !reduced.matches;
    playButton.textContent = playing ? '정지' : '재생';
    playButton.setAttribute('aria-label', playing ? '슬라이드 자동 재생 정지' : '슬라이드 자동 재생');
    playButton.setAttribute('aria-pressed', String(playing));
    playButton.disabled = reduced.matches;
  };
  const stopPlayback = (): void => { autoplay.stop(); syncPlayback(); };
  const syncSelection = (): void => {
    const index = carousel.selectedScrollSnap();
    current.textContent = String(index + 1).padStart(2, '0');
    slides.forEach((slide, number) => {
      const active = number === index;
      slide.inert = !active;
      slide.setAttribute('aria-hidden', String(!active));
    });
    dots.forEach((dot, number) => {
      const active = number === index;
      dot.classList.toggle('is-active', active);
      if (active) dot.setAttribute('aria-current', 'true');
      else dot.removeAttribute('aria-current');
    });
  };

  hero.querySelectorAll<HTMLButtonElement>('[data-dir]').forEach(button => {
    button.addEventListener('click', () => {
      stopPlayback();
      if (button.dataset.dir === '-1') carousel.scrollPrev();
      else carousel.scrollNext();
    });
  });
  dots.forEach(button => button.addEventListener('click', () => {
    stopPlayback();
    carousel.scrollTo(Number(button.dataset.goto));
  }));
  playButton.addEventListener('click', () => {
    if (reduced.matches) return;
    if (autoplay.isPlaying()) autoplay.stop();
    else autoplay.play();
    syncPlayback();
  });
  hero.addEventListener('keydown', event => {
    if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
    event.preventDefault();
    stopPlayback();
    if (event.key === 'ArrowLeft') carousel.scrollPrev();
    else carousel.scrollNext();
  });
  carousel.on('select', syncSelection);
  carousel.on('autoplay:play', syncPlayback);
  carousel.on('autoplay:stop', syncPlayback);
  document.addEventListener('visibilitychange', () => { if (document.hidden) stopPlayback(); });
  reduced.addEventListener('change', () => { if (reduced.matches) stopPlayback(); syncPlayback(); });

  const backToTop = document.querySelector<HTMLButtonElement>('[data-jw-back-to-top]');
  const updateHeroVisibility = (visible: boolean): void => {
    backToTop?.classList.toggle('jwh1-back-to-top-hidden', visible);
    if (!visible) stopPlayback();
  };
  if (typeof IntersectionObserver !== 'undefined') {
    new IntersectionObserver(([entry]) => updateHeroVisibility(entry?.isIntersecting ?? false), { threshold: 0.05 }).observe(hero);
  } else {
    const update = () => updateHeroVisibility(hero.getBoundingClientRect().bottom > 0);
    update();
    window.addEventListener('scroll', update, { passive: true });
  }
  syncSelection();
  syncPlayback();

  const rail = root.querySelector<HTMLElement>('.jwh1-process__rail');
  const sceneSelectors = [
    '.jwh1-industries__photo', '.strategy__map', '.digital__stage',
    '.jwh1-showcase__feature', '.brand__image', '.jwh1-touchpoints__board',
  ];
  root.classList.add('js-motion');
  if (rail) inView(rail, () => rail.classList.add('is-visible'), { amount: 0.12 });
  for (const selector of sceneSelectors) {
    const scene = root.querySelector<HTMLElement>(selector);
    if (scene) inView(scene, () => scene.classList.add('is-visible'), { amount: 0.15 });
  }

  // The rail expresses reading progress; static content remains available on mobile/reduced motion.
  const desktop = window.matchMedia('(min-width: 701px)');
  let stopRailScroll: (() => void) | undefined;
  const updateRailMotion = (): void => {
    stopRailScroll?.();
    stopRailScroll = undefined;
    if (!rail || reduced.matches || !desktop.matches) {
      rail?.style.removeProperty('--h1-rail-progress');
      return;
    }
    stopRailScroll = scroll((progress: number) => {
      rail.style.setProperty('--h1-rail-progress', String(progress));
    }, { target: rail, offset: ['start 0.85', 'end 0.35'] });
  };
  reduced.addEventListener('change', updateRailMotion);
  desktop.addEventListener('change', updateRailMotion);
  updateRailMotion();
}
