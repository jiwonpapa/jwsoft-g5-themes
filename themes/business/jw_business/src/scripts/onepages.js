/* JW SOFT Commercial License. Onepage behavior uses the theme's Embla and Motion stack. */
import EmblaCarousel from 'embla-carousel';
import { inView, scroll } from 'motion';

const root = document.querySelector('[data-jw-onepage]');
if (root) {
  const reduced = matchMedia('(prefers-reduced-motion: reduce)');
  const compact = matchMedia('(max-width: 767px)');
  const connection = navigator.connection;
  const motionAllowed = () => !reduced.matches && !compact.matches && !connection?.saveData;
  const header = document.querySelector('[data-jw-sticky-header]');
  const nav = root.querySelector('.jwo-nav');
  const links = [...root.querySelectorAll('.jwo-nav__links a')];
  const targets = links.map(link => root.querySelector(link.getAttribute('href')));
  const updateNavigation = () => {
    const headerBottom = header ? Math.max(0, Math.min(header.offsetHeight, header.getBoundingClientRect().bottom)) : 0;
    root.style.setProperty('--jwo-header-offset', `${headerBottom}px`);
    const line = headerBottom + (nav?.offsetHeight || 0) + 100;
    let active = -1;
    targets.forEach((target, index) => { if (target?.getBoundingClientRect().top <= line) active = index; });
    links.forEach((link, index) => {
      if (index === active) link.setAttribute('aria-current', 'location');
      else link.removeAttribute('aria-current');
    });
  };
  scroll(updateNavigation);
  header?.addEventListener('transitionend', updateNavigation);
  updateNavigation();

  const sequence = root.querySelector('[data-jwo-sequence]');
  if (sequence) {
    const image = sequence.querySelector('[data-jwo-sequence-image]');
    const controls = sequence.querySelector('[data-jwo-sequence-controls]');
    const range = controls.querySelector('input');
    const angle = controls.querySelector('output');
    const toggle = controls.querySelector('button');
    const hint = sequence.querySelector('[data-jwo-sequence-hint]');
    const count = Number(sequence.dataset.frameCount);
    const frames = new Map();
    let automatic = false;
    let ready = false;
    let loading;
    let requested = 0;
    const url = index => `${sequence.dataset.sequenceBase}${String(index + 1).padStart(3, '0')}.webp?v=${sequence.dataset.sequenceVersion}`;
    const frame = index => {
      if (!frames.has(index)) {
        const photo = new Image();
        photo.src = url(index);
        const decoded = photo.decode().then(() => photo).catch(error => { frames.delete(index); throw error; });
        frames.set(index, decoded);
      }
      return frames.get(index);
    };
    const draw = async index => {
      requested = index;
      try {
        const photo = await frame(index);
        if (requested !== index) return;
        image.src = photo.src;
        image.dataset.frame = String(index);
        range.value = String(index);
        const degrees = Math.round(index * 360 / count);
        angle.value = `${degrees}°`;
        range.setAttribute('aria-valuetext', `${degrees}도`);
      } catch {
        hint.textContent = '이미지를 불러오지 못했습니다. 다른 각도를 선택하거나 잠시 후 다시 시도해 주세요.';
      }
    };
    const sync = () => {
      sequence.classList.toggle('is-ready', ready && motionAllowed());
      toggle.setAttribute('aria-pressed', String(automatic));
      toggle.textContent = automatic ? '스크롤 회전 끄기' : '스크롤 회전 켜기';
      toggle.hidden = !motionAllowed();
    };
    const preload = async () => {
      if (loading) return loading;
      loading = (async () => {
        let next = 0;
        // Four concurrent requests bound simultaneous transfer and decoding; mobile loads chosen angles only.
        await Promise.all(Array.from({ length: 4 }, async () => {
          while (next < count) await frame(next++);
        }));
        ready = true;
        sync();
      })().catch(() => { loading = undefined; automatic = false; sync(); });
      return loading;
    };
    controls.hidden = false;
    range.addEventListener('input', () => { automatic = false; sync(); draw(Number(range.value)); });
    toggle.addEventListener('click', async () => {
      automatic = !automatic;
      if (automatic) await preload();
      sync();
    });
    inView(sequence, () => {
      if (motionAllowed()) { automatic = true; preload(); }
    }, { margin: '400px' });
    scroll(progress => {
      if (automatic && ready && motionAllowed()) draw(Math.min(count - 1, Math.round(progress * (count - 1))));
    }, { target: sequence, offset: ['start start', 'end end'] });
    for (const query of [reduced, compact]) query.addEventListener('change', () => {
      if (!motionAllowed()) automatic = false;
      sync();
    });
    sync();
  }

  // Keep every semantic panel available when script execution is unavailable.
  root.querySelectorAll('[data-jwo-tabs]').forEach(group => {
    const list = group.querySelector('[data-jwo-tablist]');
    const tabs = [...group.querySelectorAll('[data-jwo-tab]')];
    const panels = tabs.map(tab => group.querySelector(`#${tab.dataset.jwoTab}`));
    if (panels.some(panel => !panel)) return;
    const select = index => {
      tabs.forEach((tab, i) => {
        tab.setAttribute('aria-selected', String(i === index));
        tab.tabIndex = i === index ? 0 : -1;
        panels[i].hidden = i !== index;
      });
    };
    tabs.forEach((tab, index) => {
      tab.id = `${tab.dataset.jwoTab}-tab`;
      tab.setAttribute('role', 'tab');
      tab.setAttribute('aria-controls', panels[index].id);
      panels[index].setAttribute('role', 'tabpanel');
      panels[index].setAttribute('aria-labelledby', tab.id);
      panels[index].tabIndex = 0;
      tab.addEventListener('click', () => select(index));
      tab.addEventListener('keydown', event => {
        let next = index;
        if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
        else if (event.key === 'ArrowLeft') next = (index + tabs.length - 1) % tabs.length;
        else if (event.key === 'Home') next = 0;
        else if (event.key === 'End') next = tabs.length - 1;
        else return;
        event.preventDefault(); select(next); tabs[next].focus();
      });
    });
    list.setAttribute('role', 'tablist');
    list.hidden = false;
    select(0);
  });

  root.querySelectorAll('[data-jwo-gallery]').forEach(gallery => {
    const viewport = gallery.querySelector('[data-jwo-gallery-viewport]');
    const slides = [...gallery.querySelectorAll('.jwo-gallery__track > figure')];
    const prev = gallery.querySelector('[data-jwo-prev]');
    const next = gallery.querySelector('[data-jwo-next]');
    const status = gallery.querySelector('[data-jwo-gallery-status]');
    if (!viewport || !slides.length || !prev || !next || !status) return;
    const carousel = EmblaCarousel(viewport, {
      align: 'center', containScroll: 'trimSnaps', loop: false,
      duration: reduced.matches ? 0 : 25,
      breakpoints: { '(prefers-reduced-motion: reduce)': { duration: 0 } },
    });
    viewport.classList.add('is-enhanced');
    const sync = () => {
      const current = carousel.selectedScrollSnap();
      prev.disabled = !carousel.canScrollPrev();
      next.disabled = !carousel.canScrollNext();
      status.textContent = `${current + 1} / ${slides.length} · ${slides[current].querySelector('strong').textContent}`;
    };
    prev.addEventListener('click', () => carousel.scrollPrev());
    next.addEventListener('click', () => carousel.scrollNext());
    viewport.addEventListener('keydown', event => {
      if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
      event.preventDefault();
      if (event.key === 'Home') carousel.scrollTo(0);
      else if (event.key === 'End') carousel.scrollTo(slides.length - 1);
      else if (event.key === 'ArrowLeft') carousel.scrollPrev();
      else carousel.scrollNext();
    });
    carousel.on('select', sync).on('reInit', sync);
    gallery.querySelector('[data-jwo-gallery-controls]').hidden = false;
    sync();
  });

  const depth = root.querySelector('[data-jwo-depth] img');
  if (depth) {
    scroll(value => {
      if (!motionAllowed()) { depth.style.transform = ''; return; }
      depth.style.transform = `translateY(${(value - .5) * -48}px) scale(1.07)`;
    }, { target: depth.parentElement, offset: ['start end', 'end start'] });
    reduced.addEventListener('change', () => { if (reduced.matches) depth.style.transform = ''; });
    compact.addEventListener('change', () => { if (compact.matches) depth.style.transform = ''; });
  }
}
