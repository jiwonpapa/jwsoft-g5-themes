// Captures the contract-required general-page actions; review remains independent.
import { chromium, expect } from '@playwright/test';
import { mkdir, writeFile } from 'node:fs/promises';
import { resolve, relative } from 'node:path';
import { createHash } from 'node:crypto';
import { contract, themeRoot } from './catalog';

const directory = resolve(themeRoot, 'quality/evidence/current-20260929/general-interactions');
await mkdir(directory, {recursive:true});
const evidence: unknown[] = [];
const browser = await chromium.launch();
for (const viewport of ['desktop','mobile'] as const) {
  const context = await browser.newContext({viewport:viewport==='desktop'?{width:1440,height:1000}:{width:390,height:844},ignoreHTTPSErrors:true,locale:'ko-KR',reducedMotion:'reduce'});
  const page = await context.newPage();
  let owner = '';
  async function open(id:string) {
    owner = id;
    const plan = contract.pages.find(item => item.id === id)!;
    await page.goto('https://g5themes.test' + plan.route + '?device=' + (viewport==='desktop'?'pc':'mobile'),{waitUntil:'networkidle'});
    await page.evaluate(() => document.fonts.ready);
  }
  async function shot(id:string,phase:string) {
    const path = resolve(directory,`${owner}-${viewport}-${id}-${phase}.png`);
    const bytes = await page.screenshot({path,animations:'disabled'});
    return {path:relative(themeRoot,path),sha256:createHash('sha256').update(bytes).digest('hex')};
  }
  async function record(id:string,steps:string,action:()=>Promise<void>) {
    const before=await shot(id,'before');
    await action();
    const after=await shot(id,'after');
    expect(after.sha256).not.toBe(before.sha256);
    evidence.push({page:owner,id,viewport,result:'pass',steps,before,after});
    console.log(owner,viewport,id,'pass');
  }
  await open('company-overview-2');
  const status=page.locator('[data-jwc-status]'), next=page.locator('[data-jwc-next]'), prev=page.locator('[data-jwc-prev]'), slider=page.locator('[data-jwc-viewport]');
  await next.scrollIntoViewIfNeeded();
  await record('slider-next','다음 사진을 눌러 번호와 현장 사진이 1/3에서 2/3으로 바뀌는지 확인했습니다.',async()=>{await next.click();await expect(status).toHaveText('2 / 3');});
  await record('slider-prev','이전 사진을 눌러 현장 사진과 번호가 1/3으로 돌아오는지 확인했습니다.',async()=>{await prev.click();await expect(status).toHaveText('1 / 3');});
  await record('slider-keyboard','사진 슬라이더에서 오른쪽 화살표 키로 다음 사진을 표시했습니다.',async()=>{await slider.press('ArrowRight');await expect(status).toHaveText('2 / 3');});
  await page.emulateMedia({reducedMotion:'no-preference'}); await open('company-overview-2');
  const play=page.locator('[data-jwc-play]'); await play.scrollIntoViewIfNeeded();
  await record('slider-play-pause','자동 재생을 켜고 실제 사진 전환을 기다린 뒤 중지 버튼으로 정지했습니다.',async()=>{
    await play.click(); await expect(play).toHaveAttribute('aria-pressed','true');
    await page.mouse.move(0,0); await page.evaluate(()=>scrollTo(0,0));
    await expect(status).toHaveText('2 / 3',{timeout:10000});
    await play.click(); await expect(play).toHaveAttribute('aria-pressed','false');
  });
  await page.emulateMedia({reducedMotion:'reduce'});
  for (const [id,selector,target] of [
    ['company-overview-3','.jwc-scene-nav a[href="#company-review"]','#company-review'],
    ['company-overview-5','.jwc-reading-nav a[href="#company-continuity"]','#company-continuity'],
    ['business-detail-5','.jwb-process-nav a[href="#process-plan"]','#process-plan'],
  ] as const) {
    await open(id);
    const link=page.locator(selector); await link.scrollIntoViewIfNeeded();
    await record('section-navigation','목차 링크를 눌러 해당 본문 섹션으로 이동하고 주소의 앵커와 화면 변화를 확인했습니다.',async()=>{
      await link.click(); await expect(page).toHaveURL(new RegExp(target+'$')); await expect(page.locator(target)).toBeInViewport();
    });
  }
  await context.close();
}
await browser.close();
await writeFile(resolve(directory,'manifest.json'),JSON.stringify(evidence,null,2)+'\n');
console.log(`Collected ${evidence.length} general-page interactions; independent review still required.`);
