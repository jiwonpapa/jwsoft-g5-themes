// Transfers observed browser captures into the quality gate's evidence directory.
// This prepares facts for an independent reviewer; it never marks a review passed.
import { copyFile, mkdir, readFile, writeFile } from 'node:fs/promises';
import { basename, resolve } from 'node:path';
import { contract, root, themeRoot } from './catalog';
import { groupDigest, sha256 } from '../../themes/business/jw_business/scripts/quality/files';
import { inspectSources } from '../../themes/business/jw_business/scripts/quality/media';

const group = process.argv[2];
const batch = process.argv[3] || 'current-20260929';
if (!group || !/^[a-z-]+$/.test(group) || !/^[a-z0-9-]+$/.test(batch)) throw new Error('Usage: bun harness/ui/prepare-review-captures.ts <group> [batch]');
const plans = contract.pages.filter(plan => plan.group === group && plan.ready);
if (!plans.length) throw new Error(`No ready pages in ${group}`);
const registry = JSON.parse(await readFile(resolve(themeRoot, 'quality/assets.json'), 'utf8')) as { photos: Array<{path:string;sha256:string}> };
const assets = JSON.parse(await readFile(resolve(themeRoot, 'ASSET-MANIFEST.json'), 'utf8')) as { assets: Array<{path:string;sha256:string}> };
const sourceByPath = new Map(registry.photos.map(item => [item.path, item]));
const sourceByHash = new Map(registry.photos.map(item => [item.sha256, item.path]));
const assetsByHash = new Map<string, string[]>();
for (const asset of assets.assets) assetsByHash.set(asset.sha256, [...(assetsByHash.get(asset.sha256) || []), asset.path]);
const sources = new Map((await inspectSources(themeRoot, plans)).map(item => [item.plan.id, item]));
const states = ['desktop-light','desktop-dark','mobile-light','mobile-dark'] as const;
const captures = [];
const unmatched: string[] = [];
for (const plan of plans) for (const state of states) {
  const from = resolve(root, 'output/qa/ui/captures', plan.id, state);
  const data = JSON.parse(await readFile(from + '.json', 'utf8')) as {
    url:string; capturedAt:string; viewport:{width:number;height:number}; documentHeight:number;
    media:string[]; requirements:Array<{id:string;count:number;visible:boolean}>;
    errors:string[]; overflow:number; brokenImages:string[]; missingIcons:number; reversedText:string[];
  };
  if (data.errors.length || data.overflow > 1 || data.brokenImages.length || data.missingIcons || data.reversedText.length)
    throw new Error(`Browser defects in ${plan.id}/${state}`);
  const observed = new Set(data.media.map(url => new URL(url).pathname));
  const media: string[] = [];
  for (const path of sources.get(plan.id)!.media) {
    const record = sourceByPath.get(path);
    if (!record) throw new Error(`Unregistered source media: ${path}`);
    const outputPaths = assetsByHash.get(record.sha256) || [];
    const matching = outputPaths.some(output => observed.has('/theme/jw_business/' + output.replace(/^theme\//, '')));
    // Original PHP assets are copied byte-for-byte and present in the release manifest.
    if (!matching) unmatched.push(`${plan.id}/${state}: ${path} (${outputPaths.join(', ')})`);
    media.push(path);
  }
  // Also record observed page media not already listed by the PHP/CSS scanner.
  for (const url of observed) {
    const output = assets.assets.find(asset => url.endsWith('/' + asset.path.replace(/^theme\//, '')));
    const source = output && sourceByHash.get(output.sha256);
    if (source && !media.includes(source)) media.push(source);
  }
  const destination = `quality/evidence/${batch}/${plan.id}/${state}.png`;
  await mkdir(resolve(themeRoot, `quality/evidence/${batch}/${plan.id}`), { recursive: true });
  const original = await readFile(from + '.png');
  try {
    const previous = await readFile(resolve(themeRoot,destination));
    if (sha256(previous) !== sha256(original)) throw new Error(`Evidence already differs: ${destination}. Use a new batch.`);
  } catch (error) {
    if ((error as NodeJS.ErrnoException).code !== 'ENOENT') throw error;
    await copyFile(from + '.png', resolve(themeRoot, destination));
  }
  captures.push({path:destination,sha256:sha256(original),page:plan.id,
    viewport:state.startsWith('desktop')?'desktop':'mobile',mode:state.endsWith('light')?'light':'dark',
    width:data.viewport.width,height:data.viewport.height,url:data.url,capturedAt:data.capturedAt,
    fullPage:true,documentHeight:data.documentHeight,media,requirements:data.requirements});
}
if (unmatched.length) throw new Error(`Expected media absent from actual browser observation:\n${unmatched.join('\n')}`);
const manifest = {group,inputDigest:await groupDigest(themeRoot,group),assembledAt:new Date().toISOString(),captures};
const path = resolve(root,`output/qa/ui/${batch}-${group}-review-captures.json`);
await writeFile(path,JSON.stringify(manifest,null,2)+'\n');
console.log(`${basename(path)}: ${captures.length} observed captures; reviewer judgment still required`);
