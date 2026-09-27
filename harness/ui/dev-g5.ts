import { watch } from 'node:fs';
import { mkdir, writeFile, unlink, rmdir } from 'node:fs/promises';
import { resolve } from 'node:path';
import { root, themeRoot, selectedPages } from './catalog';
import { buildGallery, galleryOutput } from './gallery/build';

const office = 'localubuntu:/home/neojins/services/g5themes-test/site/';
export async function buildThenSync(build: () => Promise<void>, sync: () => Promise<void>) { await build(); await sync(); }
export function syncPlan(scope: string) {
  const pages = selectedPages(scope === 'all' ? undefined : scope);
  const entries = [
    ['theme/css/', 'theme/jw_business/css/'], ['theme/js/', 'theme/jw_business/js/'],
    ['theme/fonts/', 'theme/jw_business/fonts/'], ['theme/img/', 'theme/jw_business/img/'],
    ['theme/assets/', 'theme/jw_business/assets/'],
    ...pages.map(page => page.path.startsWith('src/php/') ? ['theme/' + page.path.slice(8), 'theme/jw_business/'] : [page.path, 'pages/']),
  ];
  if (pages.some(page => page.id === 'home-1')) entries.push(['theme/index.php','theme/jw_business/'],['theme/mobile/index.php','theme/jw_business/mobile/']);
  return entries.map(([source, destination]) => ['rsync', '-azc', '--itemize-changes', resolve(themeRoot, source!) + (source!.endsWith('/') ? '/' : ''), office + destination]);
}
async function run(args: string[]) {
  const child = Bun.spawn(args, { cwd: root, stdout:'inherit', stderr:'inherit', stdin:'ignore' });
  if (await child.exited) throw new Error('Command failed: ' + args[0]);
}
if (import.meta.main) {
  const args = process.argv.slice(2), index = args.indexOf('--page');
  const plan = syncPlan(index >= 0 ? args[index + 1]! : 'all');
  if (args.some(arg => !['--once','--dry-run','--page','--gallery'].includes(arg) && arg !== args[index + 1])) throw new Error('Unknown option');
  if (args.includes('--dry-run')) { console.log(JSON.stringify({ target:'office Ubuntu only', buildBeforeSync:true, commands:plan, gallery:args.includes('--gallery') },null,2)); process.exit(0); }
  const lock = resolve(root,'.runtime/dev-g5.lock');
  await mkdir(resolve(root,'.runtime'),{recursive:true});
  try { await mkdir(lock); } catch { throw new Error('Another dev:g5 owns .runtime/dev-g5.lock. Check its PID before removing a stale lock.'); }
  await writeFile(resolve(lock,'pid'),String(process.pid));
  let released = false;
  async function release() { if (!released) { released=true; await unlink(resolve(lock,'pid')); await rmdir(lock); } }
  let stopping = false;
  for (const signal of ['SIGINT','SIGTERM'] as const) process.on(signal, () => { stopping=true; });
  let dirty = true, running = false;
  const sources = ['src','pages','tokens','vite.config.ts','theme.manifest.json'].map(path => resolve(themeRoot,path));
  const watchers = args.includes('--once') ? [] : sources.map(path => watch(path,{recursive:true},() => {dirty=true;}));
  try {
    do {
      if (dirty && !running) {
        dirty=false; running=true;
        try {
          await buildThenSync(async () => {
            await run(['bun','run','stack:check']);
            for (const command of ['structure:check','typecheck','build','check:build']) await run(['bun','run','--cwd',themeRoot,command]);
          }, async () => {
            if (stopping) return;
            for (const command of plan) await run(command);
            if (args.includes('--gallery')) { await buildGallery(); await run(['rsync','-azc','--itemize-changes',galleryOutput+'/',office+'__jw-dev/']); }
            const pages = selectedPages(index >= 0 ? args[index + 1] : undefined);
            for (const page of pages) {
              // curl uses the workstation's trusted mkcert CA; never disable TLS checks.
              await run(['curl','--fail','--silent','--show-error','--output','/dev/null','https://g5themes.test' + page.route]);
            }
            console.log('Office preview synced: https://g5themes.test/ — development preview, not quality/release approval');
          });
        } catch(error) { console.error(error); if (args.includes('--once')) throw error; }
        finally { running=false; }
      }
      if (!args.includes('--once') && !stopping) await Bun.sleep(600);
    } while (!args.includes('--once') && !stopping);
  } finally { watchers.forEach(watcher => watcher.close()); await release(); }
}
