import { root } from './catalog';
const paths=['themes/business/jw_business/generated','themes/business/jw_business/theme','themes/business/jw_business/ASSET-MANIFEST.json'];
const child=Bun.spawn(['git','diff','--exit-code','HEAD','--',...paths],{cwd:root,stdout:'inherit',stderr:'inherit'});
if(await child.exited) throw new Error('Generated assets differ from committed source build');
const untracked=Bun.spawnSync(['git','ls-files','--others','--exclude-standard','--',...paths],{cwd:root});
if(untracked.stdout.toString().trim()) throw new Error('Untracked generated payload files: '+untracked.stdout.toString());
console.log('Committed generated payload matches rebuilt source');
