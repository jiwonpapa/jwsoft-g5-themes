/** Standalone onepage source, bundle, and fixture render contracts. */
import { readFileSync, readdirSync, statSync } from 'node:fs';
import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import { gzipSync } from 'node:zlib';
import assert from 'node:assert/strict';
const project = resolve(dirname(fileURLToPath(import.meta.url)), '../..');
const bundle = resolve(project, 'themes/business/jw_business');
let checks = 0;
const check = (name, test) => { test(); checks++; console.log(`PASS ${name}`); };
for (const variant of ['showcase', 'services', 'projects']) {
  const file = resolve(bundle, `pages/onepage-${variant}.php`);
  const source = readFileSync(file, 'utf8');
  check(`${variant}: PHP syntax`, () => execFileSync('php', ['-l', file]));
  check(`${variant}: G5 standalone boundary`, () => {
    assert.match(source, /dirname\(__DIR__\).*common\.php/);
    assert.match(source, /G5_THEME_PATH.*head\.php/);
    assert.match(source, /G5_THEME_PATH.*tail\.php/);
    assert.doesNotMatch(source, /sql_query|sql_fetch|INSERT INTO|UPDATE .*SET|https?:\/\//i);
    assert.match(source, /Author: JW SOFT/);
    assert.equal((source.match(/<h1>/g) || []).length, 1);
  });
  const html = execFileSync('php', ['-r', `$_SERVER['REMOTE_ADDR']='127.0.0.1'; $_SERVER['REQUEST_URI']='/${variant}'; $_SERVER['REQUEST_METHOD']='GET'; include '${project}/harness/jw-onepages/router.php';`], { encoding: 'utf8' });
  check(`${variant}: full fixture render and anchors`, () => {
    assert.match(html, /<!doctype html>/);
    assert.doesNotMatch(html, /Warning:|Fatal error|Notice:/);
    const ids = [...html.matchAll(/\bid="([^"]+)"/g)].map(m => m[1]);
    assert.equal(new Set(ids).size, ids.length, 'duplicate IDs');
    for (const [, id] of html.matchAll(/href="#([^"]+)"/g)) assert(ids.includes(id), `missing ${id}`);
    for (const [, src] of html.matchAll(/(?:src|href)="\/theme\/onepages\/([^"#?]+)"/g)) assert(statSync(resolve(bundle, 'onepages', src)).isFile(), src);
    for (const [, path] of html.matchAll(/(?:src|href)="\/theme\/((?:css|js)\/onepages\.min\.(?:css|js))"/g)) assert(statSync(resolve(bundle, 'theme', path)).isFile(), path);
    assert.match(html, /href="\/bbs\/qalist\.php"/);
  });
  check(`${variant}: progressive enhancement`, () => {
    assert.doesNotMatch(html, /<section[^>]*\shidden/);
    assert.match(html, /(?:가상|시연|예시)/);
  });
}
check('onepage image ownership and package paths', () => {
  const owners = new Map();
  for (const variant of ['showcase', 'services', 'projects']) {
    const source = readFileSync(resolve(bundle, `pages/onepage-${variant}.php`), 'utf8');
    for (const [, image] of source.matchAll(/\/images\/([a-z0-9-]+\.webp)/g)) {
      assert(!owners.has(image), `reused onepage image ${image}: ${owners.get(image)} and ${variant}`);
      owners.set(image, variant);
      assert(statSync(resolve(bundle, 'theme/onepages/assets/images', image)).isFile(), `packaged image missing: ${image}`);
    }
  }
  for (const required of ['node-poster.webp', 'service-workshop.webp', 'courtyard.webp', 'courtyard-interior.webp', 'courtyard-detail.webp', 'courtyard-colonnade.webp', 'courtyard-lounge.webp', 'courtyard-terrace.webp']) {
    assert(owners.has(required), `missing owned scene: ${required}`);
  }
  assert(!owners.has('workspace.webp') && !owners.has('consultation.webp'), 'legacy cross-page stock scenes remain');
});
check('36 Blender frames; compressed budget <= 3 MiB', () => {
  const frames = readdirSync(resolve(bundle, 'onepages/assets/sequence')).filter(f => /^node-\d{3}\.webp$/.test(f));
  assert.equal(frames.length, 36);
  const bytes = frames.reduce((sum, name) => sum + statSync(resolve(bundle, 'onepages/assets/sequence', name)).size, 0);
  assert(bytes <= 3 * 1024 * 1024, `${bytes} bytes`);
  console.log(`Sequence ${(bytes / 1024).toFixed(1)} KiB`);
});
check('CSS and JS budgets; CSS selectors remain scoped', () => {
  const css = readFileSync(resolve(bundle, 'onepages/assets/onepages.css'), 'utf8');
  const js = readFileSync(resolve(bundle, 'onepages/assets/onepages.js'), 'utf8');
  assert(gzipSync(css).length < 12 * 1024);
  assert(gzipSync(js).length < 12 * 1024);
  assert.doesNotMatch(css, /(?:^|\n)(?:body|html|:root|h[1-6]|button|a\s)[{\s]/);
  assert.match(css, /prefers-reduced-motion/);
  assert.match(js, /saveData/);
  assert.match(js, /max-width: 767px/);
  assert.match(js, /IntersectionObserver/);
  assert.doesNotMatch(js, /window\.[a-zA-Z]+\s*=|document\.body\.style|preventDefault\(\).*wheel/);
  console.log(`CSS ${gzipSync(css).length} bytes gzip; JS ${gzipSync(js).length} bytes gzip`);
});
console.log(`${checks} checks passed. Fixture proof only, not live G5/ZIP installation proof.`);
