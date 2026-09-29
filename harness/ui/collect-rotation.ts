import { chromium, expect, type Page } from '@playwright/test';
import { mkdir, writeFile } from 'node:fs/promises';
import { createHash } from 'node:crypto';
import { resolve, relative } from 'node:path';
import { themeRoot } from './catalog';
// Actual actions and distinct before/after evidence; visual approval remains independent.
const directory=resolve(themeRoot,process.env.JW_ROTATION_OUTPUT || 'quality/evidence/main-seven-correction-20260928/rotation');
await mkdir(directory,{recursive:true});
const browser=await chromium.launch();
const evidence:any[]=[], extras:any[]=[];
async function shot(page:Page,name:string){await page.locator('[data-jwo-sequence-image]').evaluate(async(el:HTMLImageElement)=>{if(el.complete&&el.naturalWidth)await el.decode();});await page.waitForTimeout(100);const path=resolve(directory,name+'.png');const bytes=await page.screenshot({path});return {path:relative(themeRoot,path),sha256:createHash('sha256').update(bytes).digest('hex')};}
for(const viewport of ['desktop','mobile'] as const){
 for(const variant of ['normal','reduced','no-js','dark','network-failure']){
  const context=await browser.newContext({viewport:viewport==='mobile'?{width:390,height:844}:{width:1440,height:1000},ignoreHTTPSErrors:true,locale:'ko-KR',javaScriptEnabled:variant!=='no-js',reducedMotion:variant==='reduced'?'reduce':'no-preference'});
  const page=await context.newPage(), errors:string[]=[];
  page.on('pageerror',error=>errors.push(error.message));
  await page.addInitScript(mode=>localStorage.setItem('jw-business-theme',mode),variant==='dark'?'jw-dark':'jw-light');
  if(variant==='network-failure')await page.route('**/sequence/aura-*.webp*',route=>route.request().url().includes('aura-001.webp')?route.continue():route.abort());
  await page.goto('https://g5themes.test/pages/onepage-showcase.php?device='+(viewport==='mobile'?'mobile':'pc'),{waitUntil:'networkidle'});
  const sequence=page.locator('[data-jwo-sequence]'), image=page.locator('[data-jwo-sequence-image]'), range=page.locator('#aura-angle');
  const top=await shot(page,viewport+'-'+variant+'-top');
  await sequence.scrollIntoViewIfNeeded();
  async function record(id:string,steps:string,action:()=>Promise<void>,beforeOverride?:{path:string;sha256:string}){
   const before=beforeOverride||await shot(page,viewport+'-'+id+'-before');await action();
   const after=await shot(page,viewport+'-'+id+'-after');expect(after.sha256).not.toBe(before.sha256);
   evidence.push({page:'onepage-showcase',id,viewport,result:'pass',steps,before,after});
  }
  if(variant==='normal'||variant==='dark'){
   if(viewport==='desktop'){
    await expect(sequence).toHaveClass(/is-ready/,{timeout:45000});
    const position=await sequence.evaluate(el=>({top:el.getBoundingClientRect().top+scrollY,height:el.getBoundingClientRect().height}));
    for(const [name,fraction] of [['front',.05],['rear',.55],['return',.95]] as const){
     await page.evaluate(({top,height,fraction})=>scrollTo(0,top+(height-innerHeight)*fraction),{...position,fraction});
     await expect.poll(async()=>Math.abs(Number(await image.getAttribute('data-frame'))-Math.round(fraction*59))).toBeLessThanOrEqual(2);
     extras.push({viewport,variant,phase:name,frame:await image.getAttribute('data-frame'),...await shot(page,viewport+'-'+variant+'-'+name)});
    }
   }else{await expect(sequence).not.toHaveClass(/is-ready/);await expect(image).not.toHaveAttribute('data-frame',/[1-9]/);}
   if(variant==='normal'){
    await record('product-rotation-scroll',viewport==='desktop'?'스크롤 5%, 55%, 95%에서 앞·뒤·복귀 프레임을 확인했습니다.':'모바일에서 제품 영역으로 스크롤해 정적 포스터 유지와 수동 제어 표시를 확인했습니다.',async()=>{await expect(image).toBeVisible();},top);
    await range.press('End');await expect(image).toHaveAttribute('data-frame','59');await range.press('Home');await expect(image).toHaveAttribute('data-frame','0');
    await record('product-rotation-keyboard','각도 슬라이더를 End, Home, ArrowRight 키로 조작하고 59, 0, 1 프레임 및 6도 안내를 확인했습니다.',async()=>{
     await range.press('End');await expect(image).toHaveAttribute('data-frame','59');await range.press('Home');await expect(image).toHaveAttribute('data-frame','0');await range.press('ArrowRight');await expect(image).toHaveAttribute('data-frame','1');await expect(range).toHaveAttribute('aria-valuetext','6도');
    });
   }
  }else if(variant==='reduced'){
   await record('product-rotation-reduced-motion','줄인 동작에서 스크롤 고정·자동 회전 없이 정적 제품을 표시하고 방향키 수동 전환을 확인했습니다.',async()=>{await expect(sequence).not.toHaveClass(/is-ready/);await range.press('Home');await range.press('ArrowRight');await expect(image).toHaveAttribute('data-frame','1');},top);
  }else if(variant==='no-js'){
   await record('product-rotation-fallback','JavaScript가 꺼진 상태에서 제품 영역까지 스크롤했습니다. 포스터 로드와 조작부 숨김을 확인했습니다.',async()=>{await expect(page.locator('[data-jwo-sequence-controls]')).toBeHidden();expect(await image.evaluate((el:HTMLImageElement)=>el.complete&&el.naturalWidth>0)).toBe(true);},top);
  }else{
   await expect(sequence).not.toHaveClass(/is-ready/);await range.press('ArrowRight');await expect(page.locator('[data-jwo-sequence-hint]')).toContainText('불러오지');await expect(image).toHaveAttribute('src',/aura-001\.webp/);await expect(image).toBeVisible();
  }
  expect(await image.evaluate((el:HTMLImageElement)=>el.complete&&el.naturalWidth>0)).toBe(true);expect(errors).toEqual([]);
  extras.push({viewport,variant,result:'pass',errors,...await shot(page,viewport+'-'+variant+'-final')});
  await writeFile(resolve(directory,'manifest.json'),JSON.stringify(evidence,null,2)+'\n');
  await writeFile(resolve(directory,'variants.json'),JSON.stringify(extras,null,2)+'\n');
  console.log(viewport,variant,'rotation passed');await context.close();
 }
}
await browser.close();
