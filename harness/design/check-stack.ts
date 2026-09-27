import { readFile, access, readdir } from 'node:fs/promises';
import { resolve } from 'node:path';
import { themeRoot } from '../ui/catalog';
import { mainPages } from '../ui/catalog';
import { fixedColors } from './theme-colors.mjs';
const manifest = JSON.parse(await readFile(resolve(themeRoot, 'theme.manifest.json'), 'utf8'));
const pkg = JSON.parse(await readFile(resolve(themeRoot, 'package.json'), 'utf8'));
const vite = await readFile(resolve(themeRoot, 'vite.config.ts'), 'utf8');
const required = ['@tailwindcss/vite','daisyui','tailwindcss','lucide','pretendard','embla-carousel','embla-carousel-autoplay','embla-carousel-fade','motion','typescript','vite'];
const errors: string[] = [];
for (const name of required) {
  const version = pkg.devDependencies[name];
  if (!/^\d+\.\d+\.\d+$/.test(version || '') || !manifest.externalLibraries.includes(name + '@' + version)) errors.push('Missing or unpinned manifest library: ' + name);
}
const entries = [...vite.matchAll(/resolve\(import\.meta\.dirname, "(src\/scripts\/[^"\n]+)"\)/g)].map(match => match[1]);
if (JSON.stringify([...entries].sort()) !== JSON.stringify([...manifest.entries.js].sort())) errors.push('Vite and manifest JS entries differ');
const styles = new Set<string>();
for (const entry of entries) {
  await access(resolve(themeRoot, entry!));
  const source = await readFile(resolve(themeRoot, entry!), 'utf8');
  for (const match of source.matchAll(/import\s+['"]\.\.\/styles\/([^'"]+)['"]/g)) styles.add('src/styles/' + match[1]);
}
if (JSON.stringify([...styles].sort()) !== JSON.stringify([...manifest.entries.css].sort())) errors.push('Entry CSS and manifest differ');
for (const file of await readdir(resolve(themeRoot,'src/scripts'))) {
  if (!/\.[cm]?[jt]s$/.test(file)) continue;
  const source=await readFile(resolve(themeRoot,'src/scripts',file),'utf8');
  for (const match of source.matchAll(/(?:from\s+|import\s*\(?\s*)['"]([^'".][^'"]*)['"]/g)) {
    const name=match[1]!.startsWith('@') ? match[1]!.split('/').slice(0,2).join('/') : match[1]!.split('/')[0];
    if (!manifest.externalLibraries.some((item:string) => item.startsWith(name+'@'))) errors.push('Unregistered browser import: '+file+' → '+name);
  }
}
for (const page of mainPages) {
  const source=await readFile(resolve(themeRoot,page.path),'utf8');
  for (const match of source.matchAll(/\bstyle\s*=\s*["']([^"']*)["']/g)) {
    if (fixedColors(match[1]).length) errors.push('Hardcoded inline UI color: '+page.path);
  }
}
if (errors.length) { console.error(errors.join('\n')); process.exitCode = 1; }
else console.log('Stack: pinned libraries, Vite entries and manifest agree');
