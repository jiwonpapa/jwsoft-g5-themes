import "../styles/onepages.css";
import "./onepages.js";
import { createIcons, ArrowDown, ArrowUpRight, Compass, PanelsTopLeft, Workflow, ScanSearch, GitCompareArrows, MessagesSquare, Route, LayoutTemplate, CircleCheck, Store, GraduationCap, Factory, MousePointer2, FolderCheck, Map, MonitorSmartphone, BookOpenCheck, Trees, AudioLines, SlidersHorizontal, Music2, Bluetooth, Hand, Headphones } from 'lucide';
import { inView } from 'motion';
const root = document.querySelector<HTMLElement>('[data-jw-onepage]');
if (root) {
  createIcons({ root, nameAttr: 'data-jwo-icon', attrs: { 'stroke-width': 1.6 }, icons: { ArrowDown, ArrowUpRight, Compass, PanelsTopLeft, Workflow, ScanSearch, GitCompareArrows, MessagesSquare, Route, LayoutTemplate, CircleCheck, Store, GraduationCap, Factory, MousePointer2, FolderCheck, Map, MonitorSmartphone, BookOpenCheck, Trees, AudioLines, SlidersHorizontal, Music2, Bluetooth, Hand, Headphones } });
  root.querySelectorAll('svg[data-jwo-icon]').forEach(icon => icon.removeAttribute('data-lucide'));
  if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
    inView(root.querySelectorAll<HTMLElement>('.jwo-service-card, .jwo-workbench, .jwo-aura-values, .jwo-delivery-files'), element => { element.setAttribute('data-jwo-entered', ''); }, { amount: .15 });
  }
}
