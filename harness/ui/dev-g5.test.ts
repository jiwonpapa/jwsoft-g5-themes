import { test, expect } from 'bun:test';
import { buildThenSync, syncPlan } from './dev-g5';
test('a failed build never calls deployment', async () => {
  let sent = false;
  await expect(buildThenSync(async () => {throw new Error('broken build');},async () => {sent=true;})).rejects.toThrow('broken build');
  expect(sent).toBe(false);
});
test('Main 4 sync cannot write G5 core, database, menu or other page files', () => {
  const plan = syncPlan('home-4');
  expect(plan.every(row => row[0] === 'rsync' && !row.includes('--delete'))).toBe(true);
  expect(plan.filter(row => row.at(-2)?.endsWith('.php')).map(row => row.at(-2)?.split('/').at(-1))).toEqual(['index_4.php']);
  expect(plan.every(row => row.at(-1)?.startsWith('localubuntu:/home/neojins/services/g5themes-test/site/theme/jw_business/'))).toBe(true);
  expect(() => syncPlan('home-5')).toThrow();
});

test('onepage scopes sync their own built media without deleting server files', () => {
  const plan = syncPlan('onepage-showcase');
  expect(plan.some(row => row.at(-1)?.endsWith('/theme/jw_business/onepages/assets/'))).toBe(true);
  expect(plan.some(row => row.includes('--delete'))).toBe(false);
  expect(syncPlan('home-4').some(row => row.at(-1)?.endsWith('/onepages/assets/'))).toBe(false);
});
