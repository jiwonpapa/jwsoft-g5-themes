/** Read-only smoke of the office Ubuntu G5 deployment. TLS verification stays enabled. */
import { readdirSync, readFileSync } from 'node:fs';
import { resolve, dirname, relative } from 'node:path';
import { fileURLToPath } from 'node:url';
import { execFile } from 'node:child_process';
import { promisify } from 'node:util';
import { createHash } from 'node:crypto';
import assert from 'node:assert/strict';

const run = promisify(execFile);
const theme = resolve(dirname(fileURLToPath(import.meta.url)), '../../themes/business/jw_business/theme');
const base = 'https://g5themes.test';
const hash = bytes => createHash('sha256').update(bytes).digest('hex');
const walk = path => readdirSync(path, { withFileTypes: true }).flatMap(item => item.isDirectory() ? walk(resolve(path, item.name)) : [resolve(path, item.name)]);
const get = async url => (await run('curl', ['--fail', '--silent', '--show-error', url], { encoding: 'buffer', maxBuffer: 4 * 1024 * 1024 })).stdout;
const assetFiles = [
  resolve(theme, 'css/onepages.min.css'),
  resolve(theme, 'js/onepages.min.js'),
  ...walk(resolve(theme, 'onepages/assets')),
];

for (const file of assetFiles) {
  const path = relative(theme, file);
  assert.equal(hash(await get(`${base}/theme/jw_business/${path}`)), hash(readFileSync(file)), path);
}

const menuNames = [
  '#1 종합 에이전시', '#2 전략·의사결정', '#3 결과물 포트폴리오', '#4 과정·산출물',
  '원페이지 · 제품 쇼케이스', '원페이지 · 서비스 상담', '원페이지 · 공간 프로젝트',
];
const pages = ['/', '/theme/jw_business/index_1.php', '/theme/jw_business/index_2.php', '/theme/jw_business/index_3.php', '/theme/jw_business/index_4.php',
  '/pages/onepage-showcase.php', '/pages/onepage-services.php', '/pages/onepage-projects.php'];
for (const path of pages) {
  for (const device of ['pc', 'mobile']) {
    const html = (await get(`${base}${path}?device=${device}`)).toString('utf8');
    assert.equal([...html.matchAll(/<h1(?:\s[^>]*)?>/g)].length, 1, `${path}/${device}: h1`);
    assert.doesNotMatch(html, /Fatal error|Warning:|Parse error|Uncaught (?:Error|Exception)/, `${path}/${device}`);
    for (const name of menuNames) assert.ok(html.includes(name), `${path}/${device}: menu ${name}`);
    if (path.startsWith('/pages/')) {
      const variant = path.match(/onepage-(.+)\.php/)[1];
      assert.ok(html.includes(`data-jw-onepage="${variant}"`), `${path}/${device}: marker`);
      assert.ok(html.includes('/css/onepages.min.css'), `${path}/${device}: CSS`);
      assert.ok(html.includes('/js/onepages.min.js'), `${path}/${device}: JS`);
    }
  }
}
console.log(`PASS: ${assetFiles.length} deployed onepage assets byte-identical to theme payload`);
console.log(`PASS: ${pages.length} routes × PC/mobile, 7 menu names, h1 and PHP smoke`);
