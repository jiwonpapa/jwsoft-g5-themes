/** Developer-only WebP conversion after Blender rendering. Requires cwebp, not a customer dependency. */
import { execFileSync } from 'node:child_process';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
const here = dirname(fileURLToPath(import.meta.url));
for (let index = 1; index <= 36; index++) {
  execFileSync('cwebp', ['-quiet', '-q', '78', resolve(here, `renders/node-${String(index).padStart(4, '0')}.png`), '-o', resolve(here, `../assets/sequence/node-${String(index).padStart(3, '0')}.webp`)]);
}
execFileSync('cwebp', ['-quiet', '-q', '86', resolve(here, 'renders/node-poster.png'), '-o', resolve(here, '../assets/images/node-poster.webp')]);
console.log('Prepared 36 sequence frames and one consistent poster. No theme build or menu was changed.');
