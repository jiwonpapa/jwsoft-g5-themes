import {chromium,expect} from '@playwright/test';
import {mkdir,writeFile} from 'node:fs/promises';
import {resolve,relative} from 'node:path';
import {createHash} from 'node:crypto';
import {mainPages,themeRoot} from './catalog';
import {inputDigest} from '../../themes/business/jw_business/scripts/quality/files';
import sharp from '../../themes/business/jw_business/node_modules/sharp';

// An evidence collector, never a visual approval or a substitute for browsing.
const directory=resolve(themeRoot,process.env.JW_SIGNATURE_OUTPUT || 'quality/evidence/seven-correction-20260929/signatures-final');
await mkdir(directory,{recursive:true});
const digest=await inputDigest(themeRoot);
const plans=[
 {page:'home-1',selector:'[data-jw-decision-board]',attribute:'data-jw-stage',controls:'[data-jw-decision-select]',values:['0','1','2'],offsets:[.75,.3]},
 {page:'home-2',selector:'[data-jwh2-priority-scroll]',attribute:'data-priority-step',controls:'[data-priority-label]',values:['0','1','2'],offsets:[.7,.45]},
 {page:'home-3',selector:'[data-jwh3-wayfinding-scroll]',attribute:'data-route-step',controls:'[data-jwh3-route]',values:['a','b','c'],offsets:[.5,0],scrollTarget:'.jwh3-wayfinding-v2',sameEdge:true},
 {page:'home-4',selector:'[data-jw-forme-story]',attribute:'data-jw-stage',controls:'[data-jw-forme-select]',values:['0','1','2'],offsets:[.12,1]},
 {page:'onepage-services',selector:'.jwo-journey-study[data-jwo-narrative]',attribute:'data-active-step',controls:'[data-jwo-narrative-button]',values:['0','1','2'],offsets:[],steps:'[data-jwo-narrative-step]'},
 {page:'onepage-projects',selector:'.jwo-space-atlas[data-jwo-narrative]',attribute:'data-active-step',controls:'[data-jwo-narrative-button]',values:['0','1','2'],offsets:[],steps:'[data-jwo-narrative-step]'},
];
const browser=await chromium.launch();
const evidence:any[]=[];
try{
 for(const plan of plans){
  for(const state of ['desktop-scroll','mobile-controls','desktop-reduced'] as const){
   const mobile=state==='mobile-controls';
   const context=await browser.newContext({viewport:mobile?{width:390,height:844}:{width:1440,height:1000},ignoreHTTPSErrors:true,locale:'ko-KR',reducedMotion:state==='desktop-reduced'?'reduce':'no-preference'});
   const page=await context.newPage();
   await page.addInitScript(()=>localStorage.setItem('jw-business-theme','jw-light'));
   await page.goto('https://g5themes.test'+mainPages.find(p=>p.id===plan.page)!.route+'?device='+(mobile?'mobile':'pc'),{waitUntil:'networkidle'});
   await page.evaluate(()=>document.fonts.ready);
   const target=page.locator(plan.selector),controls=page.locator(plan.controls);
   await expect(controls).toHaveCount(3);
   const shots=[];
   for(let index=0;index<3;index++){
    if(state==='desktop-scroll'){
     if(plan.steps){
      const box=await target.locator(plan.steps).nth(index).evaluate(el=>{const r=el.getBoundingClientRect();return {top:r.top+scrollY,height:r.height}});
      await page.evaluate(y=>scrollTo({top:y,behavior:'instant'}),box.top+box.height/2-425);
     }else{
      const scrollTarget=plan.scrollTarget?target.locator(plan.scrollTarget):target;
      const box=await scrollTarget.evaluate(el=>{const r=el.getBoundingClientRect();return {top:r.top+scrollY,height:r.height}});
      const start=box.top-1000*plan.offsets[0]!,end=box.top+('sameEdge' in plan?0:box.height)-1000*plan.offsets[1]!;
      await page.evaluate(y=>scrollTo({top:y,behavior:'instant'}),start+(end-start)*[.12,.5,.9][index]!);
     }
    }else{
     // Mobile/reduced mode is a real keyboard-operated fallback, not an animation freeze.
     await controls.nth(index).press('Enter');
    }
    await expect(target).toHaveAttribute(plan.attribute,plan.values[index]!);
    await page.waitForTimeout(250);
    const file=resolve(directory,`${plan.page}-${state}-${index}.png`);
    const bytes=await page.screenshot({path:file});
    const full=await page.screenshot({fullPage:true});
    const rect=await target.evaluate(el=>{const r=el.getBoundingClientRect();return {left:Math.max(0,Math.round(r.left+scrollX)),top:Math.max(0,Math.round(r.top+scrollY)),width:Math.floor(r.width),height:Math.floor(r.height)}});
    const metadata=await sharp(full).metadata();
    rect.width=Math.min(rect.width,metadata.width!-rect.left);rect.height=Math.min(rect.height,metadata.height!-rect.top);
    const cropFile=resolve(directory,`${plan.page}-${state}-${index}-material.png`);
    const crop=await sharp(full).extract(rect).png().toBuffer();
    await writeFile(cropFile,crop);
    const material=await target.evaluate(el=>({text:(el as HTMLElement).innerText,images:[...el.querySelectorAll('img')].filter(i=>{const r=i.getBoundingClientRect();return r.width>0&&r.height>0&&!i.closest('[hidden]')}).map(i=>({src:i.currentSrc,loaded:i.complete&&i.naturalWidth>0})),overflow:document.documentElement.scrollWidth-innerWidth}));
    expect(material.overflow).toBeLessThanOrEqual(1);
    expect(material.images.filter(i=>!i.loaded)).toEqual([]);
    shots.push({stage:plan.values[index],path:relative(themeRoot,file),sha256:createHash('sha256').update(bytes).digest('hex'),materialCapture:{path:relative(themeRoot,cropFile),sha256:createHash('sha256').update(crop).digest('hex')},material});
   }
   evidence.push({page:plan.page,state,result:'observed-not-visually-approved',inputDigest:digest,capturedAt:new Date().toISOString(),shots});
   await context.close();
   await writeFile(resolve(directory,'manifest.json'),JSON.stringify(evidence,null,2)+'\n');
   console.log(plan.page,state,'3 actual states');
  }
 }
}finally{await browser.close()}
if(await inputDigest(themeRoot)!==digest)throw Error('Sources changed during collection');
