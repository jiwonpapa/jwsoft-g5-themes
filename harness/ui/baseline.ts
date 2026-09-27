import { readFile } from 'node:fs/promises';
import { createHash } from 'node:crypto';
import { resolve } from 'node:path';
import { root } from './catalog';
export type Baseline = {page:string;state:string;file:string;sha256:string;sourceDigest:string;platform:string;browser:string;reviewer:string;implementer:string;reviewedAt:string;result:string;evidence:string;evidenceSha256:string};
export function validateBaseline(record: Baseline, bytes: Uint8Array, platform: string, browser: string) {
  if (record.result !== 'pass' || record.reviewer === record.implementer || record.reviewer.length < 6 || /pending|todo|unknown/i.test(record.reviewer)) throw new Error('Independent baseline review required');
  if (!/^[a-f0-9]{64}$/.test(record.sourceDigest) || !record.evidence || !Number.isFinite(Date.parse(record.reviewedAt))) throw new Error('Baseline provenance missing');
  if (!/^[a-f0-9]{64}$/.test(record.evidenceSha256)) throw new Error('Review artifact hash missing');
  if (record.platform !== platform || record.browser !== browser) throw new Error('Baseline environment mismatch; compare inside the pinned Linux runner');
  if (createHash('sha256').update(bytes).digest('hex') !== record.sha256) throw new Error('Baseline image hash mismatch');
}
export async function reviewedBaseline(page: string, state: string, browser: string) {
  const directory = resolve(root,'harness/ui/baselines');
  const records = JSON.parse(await readFile(resolve(directory,'manifest.json'),'utf8')) as Baseline[];
  const record = records.find(item => item.page === page && item.state === state);
  if (!record) throw new Error('No reviewed baseline: ' + page + '/' + state);
  if (record.file !== state + '/' + page + '.png') throw new Error('Unexpected baseline path');
  if (!/^harness\/ui\/baselines\/[a-zA-Z0-9_-]+\.md$/.test(record.evidence)) throw new Error('Unexpected review artifact path');
  const evidence=await readFile(resolve(root,record.evidence));
  if(createHash('sha256').update(evidence).digest('hex')!==record.evidenceSha256) throw new Error('Review artifact hash mismatch');
  const bytes = await readFile(resolve(directory,record.file));
  validateBaseline(record,bytes,process.platform,browser);
  return record;
}
