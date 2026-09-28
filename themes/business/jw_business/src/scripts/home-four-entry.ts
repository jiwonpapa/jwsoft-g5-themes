import '../styles/home-four.css';
import { inView, scroll } from 'motion';
import { createIcons, ArrowDown, ArrowUpRight, Layers, Search, Route, PenTool, PackageCheck, ArrowDownRight, MessagesSquare, ScanEye, Target, UsersRound, Sprout, Plus, ArrowRight, Lightbulb, Eye, Leaf, MousePointer2, Gift, Image, BookOpen, Monitor, Package, Link, LayoutTemplate, Smartphone, Palette, PanelTop, Menu, Droplets, Recycle, MonitorSmartphone, Fingerprint, FilePenLine, Images, BookOpenCheck, ListChecks, Send } from 'lucide';

const root = document.querySelector<HTMLElement>('[data-jw-home="4"]');
if (root) {
  createIcons({
    root, nameAttr: 'data-h4-icon', attrs: { 'stroke-width': 1.6 },
    icons: { ArrowDown, ArrowUpRight, Layers, Search, Route, PenTool, PackageCheck, ArrowDownRight, MessagesSquare, ScanEye, Target, UsersRound, Sprout, Plus, ArrowRight, Lightbulb, Eye, Leaf, MousePointer2, Gift, Image, BookOpen, Monitor, Package, Link, LayoutTemplate, Smartphone, Palette, PanelTop, Menu, Droplets, Recycle, MonitorSmartphone, Fingerprint, FilePenLine, Images, BookOpenCheck, ListChecks, Send },
  });
  // Lucide adds its default marker even with a custom nameAttr. Keep these
  // page-owned icons out of the shell's icon refresh when the theme changes.
  root.querySelectorAll<SVGElement>('svg[data-h4-icon]').forEach((icon) => {
    icon.removeAttribute('data-lucide');
  });
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (!reduced.matches) {
    // Content remains visible before JS, after failures and in reduced-motion mode.
    inView(root.querySelectorAll<HTMLElement>('.h4-reveal'), (element) => {
      element.classList.add('h4-entered');
    }, { amount: 0.15 });
    const journey = root.querySelector<HTMLElement>('.h4-journey');
    const nodes = journey?.querySelectorAll<HTMLElement>('.h4-journey-nodes li');
    if (journey && nodes?.length) {
      journey.classList.add('h4-journey--motion');
      scroll((progress: number) => {
        journey.style.setProperty('--h4-journey-progress', String(progress));
        const active = Math.min(nodes.length - 1, Math.floor(progress * nodes.length));
        nodes.forEach((node, index) => node.classList.toggle('h4-is-current', index === active));
      }, { target: journey, offset: ['start 85%', 'end 25%'] });
    }
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
