import '../styles/home-four.css';
import { inView, scroll } from 'motion';
import { createIcons, ArrowDown, ArrowUpRight, Layers, Search, Route, PenTool, PackageCheck, ArrowDownRight, MessagesSquare, ScanEye, Target, UsersRound, Sprout, Plus, ArrowRight, Lightbulb, Eye, Leaf, MousePointer2, Gift, Image, BookOpen, Monitor, Package, Link, LayoutTemplate, Smartphone, Palette, PanelTop, Menu, Droplets, Recycle, MonitorSmartphone, Fingerprint, FilePenLine, Images, BookOpenCheck, ListChecks, Send, Check, FolderOpen } from 'lucide';

const root = document.querySelector<HTMLElement>('[data-jw-home="4"]');
if (root) {
  createIcons({
    root, nameAttr: 'data-h4-icon', attrs: { 'stroke-width': 1.6 },
    icons: { ArrowDown, ArrowUpRight, Layers, Search, Route, PenTool, PackageCheck, ArrowDownRight, MessagesSquare, ScanEye, Target, UsersRound, Sprout, Plus, ArrowRight, Lightbulb, Eye, Leaf, MousePointer2, Gift, Image, BookOpen, Monitor, Package, Link, LayoutTemplate, Smartphone, Palette, PanelTop, Menu, Droplets, Recycle, MonitorSmartphone, Fingerprint, FilePenLine, Images, BookOpenCheck, ListChecks, Send, Check, FolderOpen },
  });
  // Lucide adds its default marker even with a custom nameAttr. Keep these
  // page-owned icons out of the shell's icon refresh when the theme changes.
  root.querySelectorAll<SVGElement>('svg[data-h4-icon]').forEach((icon) => {
    icon.removeAttribute('data-lucide');
  });
  const story = root.querySelector<HTMLElement>('[data-jw-forme-story]');
  const panels = [...root.querySelectorAll<HTMLElement>('[data-jw-forme-panel]')];
  const selectors = [...root.querySelectorAll<HTMLButtonElement>('[data-jw-forme-select]')];
  const selectMaterial = (index: number): void => {
    if (!story || !panels[index]) return;
    story.dataset.jwStage = String(index);
    panels.forEach((panel, current) => {
      panel.hidden = current !== index;
      panel.inert = current !== index;
    });
    selectors.forEach((button, current) => button.setAttribute('aria-pressed', String(current === index)));
  };
  if (story && panels.length === selectors.length) {
    story.classList.add('is-enhanced');
    selectMaterial(0);
    selectors.forEach((button, index) => {
      button.addEventListener('click', () => selectMaterial(index));
      button.addEventListener('keydown', (event: KeyboardEvent) => {
        let next = index;
        if (event.key === 'ArrowRight' || event.key === 'ArrowDown') next = (index + 1) % selectors.length;
        else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') next = (index - 1 + selectors.length) % selectors.length;
        else if (event.key === 'Home') next = 0;
        else if (event.key === 'End') next = selectors.length - 1;
        else return;
        event.preventDefault();
        selectMaterial(next);
        selectors[next]?.focus();
      });
    });
  }
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  const desktop = window.matchMedia('(min-width: 1000px) and (min-height: 930px)');
  let stopStory: (() => void) | undefined;
  const updateStoryMotion = (): void => {
    stopStory?.();
    stopStory = undefined;
    story?.classList.remove('is-scroll-driven');
    if (!story || reduced.matches || !desktop.matches) return;
    story.classList.add('is-scroll-driven');
    let lastStage = -1;
    stopStory = scroll((progress: number) => {
      const stage = Math.min(panels.length - 1, Math.floor(progress * panels.length));
      if (stage !== lastStage) {
        selectMaterial(stage);
        lastStage = stage;
      }
    }, { target: story, offset: ['start 120px', 'end end'] });
  };
  reduced.addEventListener('change', updateStoryMotion);
  desktop.addEventListener('change', updateStoryMotion);
  updateStoryMotion();
  if (!reduced.matches) {
    // Content remains visible before JS, after failures and in reduced-motion mode.
    inView(root.querySelectorAll<HTMLElement>('.h4-reveal'), (element) => {
      element.classList.add('h4-entered');
    }, { amount: 0.15 });
    const browser = root.querySelector<HTMLElement>('.h4-browser-stage');
    if (browser) {
      browser.classList.add('h4-browser-stage--motion');
      scroll((progress: number) => {
        browser.style.setProperty('--h4-preview-y', `${(1 - progress) * 58}px`);
        browser.style.setProperty('--h4-preview-angle', `${(1 - progress) * 9}deg`);
        browser.style.setProperty('--h4-preview-scale', String(.88 + progress * .12));
        browser.style.setProperty('--h4-preview-opacity', String(.4 + progress * .6));
      }, { target: browser, offset: ['start 85%', 'end 25%'] });
    }
  }
}
