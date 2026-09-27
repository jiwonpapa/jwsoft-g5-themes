import { test, expect } from 'bun:test';
import { createHash } from 'node:crypto';
import { validateBaseline, type Baseline } from './baseline';
test('baseline cannot silently accept missing review, changed image or wrong rendering environment', () => {
  const bytes=Buffer.from('fixture');
  const record: Baseline={page:'home-4',state:'desktop-light',file:'desktop-light/home-4.png',sha256:createHash('sha256').update(bytes).digest('hex'),sourceDigest:'a'.repeat(64),platform:'linux',browser:'pinned',reviewer:'independent-reviewer',implementer:'implementation-agent',reviewedAt:'2026-09-27T00:00:00Z',result:'pass',evidence:'review.md',evidenceSha256:'b'.repeat(64)};
  expect(() => validateBaseline(record,bytes,'linux','pinned')).not.toThrow();
  for (const patch of [{result:'pending'},{reviewer:record.implementer},{sourceDigest:''},{sha256:'0'.repeat(64)}]) expect(() => validateBaseline({...record,...patch},bytes,'linux','pinned')).toThrow();
  expect(() => validateBaseline(record,bytes,'darwin','pinned')).toThrow();
});
