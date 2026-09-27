import { test, expect } from 'bun:test';
import { mkdtemp, mkdir, writeFile, rm } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import { join, dirname } from 'node:path';
import { groupDigest, inputDigest } from '../../themes/business/jw_business/scripts/quality/files';
test('independent page edits preserve another group while shared CSS and policy invalidate it', async () => {
  const root = await mkdtemp(join(tmpdir(),'jw-digest-'));
  try {
    for (const dir of ['src','pages','onepages','tokens','generated','theme','scripts/quality','quality','docs']) await mkdir(join(root,dir),{recursive:true});
    const files = ['src/shared.css','pages/a.php','pages/b.php','scripts/check-quality.ts','quality/assets.json','docs/PAGE-CATALOG.json','package.json','theme.manifest.json','vite.config.ts'];
    for (const path of files) { await mkdir(dirname(join(root,path)),{recursive:true}); await writeFile(join(root,path),'original'); }
    await writeFile(join(root,'quality/contract.json'),JSON.stringify({pages:[{group:'a',path:'pages/a.php'},{group:'b',path:'pages/b.php'}]}));
    const before = await groupDigest(root,'a'), global = await inputDigest(root);
    await writeFile(join(root,'pages/b.php'),'other group change');
    expect(await groupDigest(root,'a')).toBe(before);
    expect(await inputDigest(root)).not.toBe(global);
    await writeFile(join(root,'src/shared.css'),'shared change');
    expect(await groupDigest(root,'a')).not.toBe(before);
    await writeFile(join(root,'src/shared.css'),'original');
    await writeFile(join(root,'quality/assets.json'),'photo ownership change');
    expect(await groupDigest(root,'a')).not.toBe(before);
    await expect(groupDigest(root,'missing')).rejects.toThrow();
  } finally { await rm(root,{recursive:true,force:true}); }
});
