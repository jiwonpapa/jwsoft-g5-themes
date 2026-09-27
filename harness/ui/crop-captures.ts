// Inspection crops come from the complete capture, not a second scrolled render.
import sharp from '../../themes/business/jw_business/node_modules/sharp';
import { readFile } from 'node:fs/promises';
import { resolve } from 'node:path';
import { root, states } from './catalog';
const directory=resolve(root,'output/qa/ui/captures/home-4');
for(const state of states) {
  const capture=JSON.parse(await readFile(resolve(directory,state.name+'.json'),'utf8'));
  for(const [selector,name] of [['.h4-process','process'],['.jw-footer','footer']]) {
    const region=capture.regions[selector!];
    if(!region) throw new Error('Region not captured: '+selector);
    await sharp(resolve(directory,state.name+'.png')).extract(region).toFile(resolve(directory,state.name+'.'+name+'.png'));
  }
}
