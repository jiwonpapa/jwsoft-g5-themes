import '../styles/home-four.css';
import { inView } from 'motion';
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
  }
}
