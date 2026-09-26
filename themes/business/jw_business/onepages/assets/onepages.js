/* JW SOFT Commercial License. Native module; no globals, dependency or build step. */
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
  let queued = false;
  const updates = [];
  const update = () => {
    queued = false;
    const headerBottom = header ? Math.max(0, Math.min(header.offsetHeight, header.getBoundingClientRect().bottom)) : 0;
    root.style.setProperty('--jwo-header-offset', `${headerBottom}px`);
    const line = headerBottom + (nav?.offsetHeight || 0) + 100;
    let active = -1;
    targets.forEach((target, index) => { if (target?.getBoundingClientRect().top <= line) active = index; });
    links.forEach((link, index) => {
      if (index === active) link.setAttribute('aria-current', 'location');
      else link.removeAttribute('aria-current');
    });
    for (const fn of updates) fn();
  };
  const schedule = () => { if (!queued) { queued = true; requestAnimationFrame(update); } };
  addEventListener('scroll', schedule, { passive: true });
  addEventListener('resize', schedule, { passive: true });
  header?.addEventListener('transitionend', schedule);
  document.addEventListener('visibilitychange', schedule);

  // Enhance semantic sections into tabs only after every control has been wired.
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
    const track = gallery.querySelector('.jwo-gallery__track');
    const slides = [...track.querySelectorAll('figure')];
    const prev = gallery.querySelector('[data-jwo-prev]');
    const next = gallery.querySelector('[data-jwo-next]');
    const status = gallery.querySelector('[data-jwo-gallery-status]');
    let current = 0;
    const position = index => slides[index].offsetLeft - track.offsetLeft - (track.clientWidth - slides[index].offsetWidth) / 2;
    const sync = () => {
      let closest = Infinity;
      slides.forEach((slide, index) => {
        const delta = Math.abs(position(index) - track.scrollLeft);
        if (delta < closest) { closest = delta; current = index; }
      });
      prev.disabled = current === 0;
      next.disabled = current === slides.length - 1;
      const message = `${current + 1} / ${slides.length} · ${slides[current].querySelector('strong').textContent}`;
      if (status.textContent !== message) status.textContent = message;
    };
    const go = index => track.scrollTo({ left: position(Math.max(0, Math.min(slides.length - 1, index))), behavior: reduced.matches ? 'instant' : 'smooth' });
    prev.addEventListener('click', () => go(current - 1));
    next.addEventListener('click', () => go(current + 1));
    track.addEventListener('keydown', event => {
      if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
      event.preventDefault();
      go(event.key === 'Home' ? 0 : event.key === 'End' ? slides.length - 1 : current + (event.key === 'ArrowRight' ? 1 : -1));
    });
    let frame = 0;
    track.addEventListener('scroll', () => { cancelAnimationFrame(frame); frame = requestAnimationFrame(sync); }, { passive: true });
    addEventListener('resize', sync, { passive: true });
    gallery.querySelector('[data-jwo-gallery-controls]').hidden = false;
    sync();
  });

  const scene = root.querySelector('[data-jwo-sequence]');
  if (scene) {
    const canvas = scene.querySelector('canvas');
    const context = canvas.getContext('2d');
    const status = scene.querySelector('[data-jwo-sequence-status]');
    const toggle = scene.querySelector('[data-jwo-motion-toggle]');
    const count = Number(scene.dataset.frameCount);
    const frames = new Array(count);
    let ready = false, loading = false, failed = false, near = false, paused = false, last = -1;
    let generation = 0;
    const render = () => {
      if (!ready || !motionAllowed() || document.hidden || paused) return;
      const rect = scene.getBoundingClientRect();
      if (rect.bottom < 0 || rect.top > innerHeight) return;
      const stage = scene.querySelector('.jwo-sequence__stage');
      const distance = Math.max(1, scene.offsetHeight - stage.offsetHeight);
      const top = parseFloat(getComputedStyle(stage).top) || 0;
      const progress = Math.max(0, Math.min(1, (top - rect.top) / distance));
      const index = Math.round(progress * (count - 1));
      if (index !== last && frames[index]) {
        context.drawImage(frames[index], 0, 0, canvas.width, canvas.height);
        canvas.dataset.frame = String(index + 1);
        last = index;
      }
    };
    const applyMode = () => {
      const enabled = ready && motionAllowed();
      scene.classList.toggle('is-ready', enabled);
      canvas.hidden = !enabled;
      toggle.hidden = !enabled;
      status.textContent = failed ? '대표 이미지로 제품을 살펴보세요.' : enabled ? '스크롤하면 제품의 각도가 바뀝니다.' : '3D 모델의 대표 이미지입니다.';
      if (!motionAllowed()) generation++;
      last = -1;
      schedule();
      if (near && motionAllowed() && !ready && !loading && !failed) load();
    };
    const loadImage = index => new Promise((resolve, reject) => {
      const img = new Image();
      const timer = setTimeout(() => { img.src = ''; reject(new Error('frame timeout')); }, 15000);
      img.onload = () => { clearTimeout(timer); resolve(img); };
      img.onerror = () => { clearTimeout(timer); reject(new Error('frame unavailable')); };
      img.src = `${scene.dataset.frameRoot}${String(index + 1).padStart(3, '0')}.webp`;
    });
    const load = async () => {
      if (!context || !motionAllowed() || loading || ready || failed) return;
      loading = true;
      const token = ++generation;
      status.textContent = '회전 장면을 준비하고 있습니다. 본문은 계속 읽을 수 있습니다.';
      try {
        // Four concurrent requests, only when the section approaches the viewport.
        for (let start = 0; start < count; start += 4) {
          if (token !== generation || !motionAllowed()) return;
          await Promise.all(Array.from({ length: Math.min(4, count - start) }, async (_, step) => {
            const index = start + step;
            if (!frames[index]) frames[index] = await loadImage(index);
          }));
        }
        if (token === generation) ready = true;
      } catch { failed = true; }
      finally { loading = false; applyMode(); }
    };
    toggle.addEventListener('click', () => {
      paused = !paused;
      toggle.setAttribute('aria-pressed', String(paused));
      toggle.textContent = paused ? '회전 다시 시작' : '회전 멈추기';
      schedule();
    });
    updates.push(render);
    reduced.addEventListener('change', applyMode);
    compact.addEventListener('change', applyMode);
    connection?.addEventListener?.('change', applyMode);
    const observer = new IntersectionObserver(entries => {
      near = entries[0].isIntersecting;
      if (near && motionAllowed()) load();
    }, { rootMargin: '300px' });
    observer.observe(scene);
    applyMode();
  }

  const depth = root.querySelector('[data-jwo-depth] img');
  if (depth) {
    updates.push(() => {
      if (!motionAllowed()) { depth.style.transform = ''; return; }
      const rect = depth.parentElement.getBoundingClientRect();
      if (rect.bottom < 0 || rect.top > innerHeight) return;
      const amount = Math.max(-1, Math.min(1, (rect.top + rect.height / 2 - innerHeight / 2) / innerHeight));
      depth.style.transform = `translateY(${amount * 24}px) scale(1.07)`;
    });
    reduced.addEventListener('change', schedule);
    compact.addEventListener('change', schedule);
  }
  schedule();
}
