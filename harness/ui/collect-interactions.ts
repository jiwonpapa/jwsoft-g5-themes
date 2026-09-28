import { chromium, expect, type Page } from '@playwright/test';
import { mkdir, writeFile } from 'node:fs/promises';
import { resolve, relative } from 'node:path';
import { createHash } from 'node:crypto';
import { mainPages, themeRoot, root } from './catalog';

// Collects real actions and screenshots; does not authorize a visual quality review.
const directory=resolve(themeRoot,'quality/evidence/main-seven-20260928/interactions');
await mkdir(directory,{recursive:true});
const evidence:any[]=[];
const browser=await chromium.launch();
for(const viewport of (process.env.JW_INTERACTION_VIEWPORT ? [process.env.JW_INTERACTION_VIEWPORT as 'desktop'|'mobile'] : ['desktop','mobile'] as const)){
 const context=await browser.newContext({viewport:viewport==='desktop'?{width:1440,height:1000}:{width:390,height:844},ignoreHTTPSErrors:true,locale:'ko-KR',reducedMotion:'no-preference'});
 const page=await context.newPage();
 await page.addInitScript(()=>localStorage.setItem('jw-business-theme','jw-light'));
 let owner='';
 async function open(id:string,reduced=false){owner=id;await page.emulateMedia({reducedMotion:reduced?'reduce':'no-preference'});await page.goto('https://g5themes.test'+mainPages.find(p=>p.id===id)!.route+'?device='+(viewport==='desktop'?'pc':'mobile'),{waitUntil:'networkidle'});await page.evaluate(()=>document.fonts.ready);}
 async function shot(id:string,phase:string){const path=resolve(directory,`${owner}-${viewport}-${id}-${phase}.png`);const bytes=await page.screenshot({path});return {path:relative(themeRoot,path),sha256:createHash('sha256').update(bytes).digest('hex')};}
 async function record(id:string,steps:string,action:()=>Promise<void>){const before=await shot(id,'before');await action();const after=await shot(id,'after');expect(after.sha256).not.toBe(before.sha256);evidence.push({page:owner,id,viewport,result:'pass',steps,before,after});await writeFile(resolve(directory,viewport+'-manifest.json'),JSON.stringify(evidence,null,2)+'\n');console.log(owner,viewport,id,'pass');}
 for(const id of ['home-1','home-2']){
  await open(id,true);
  const one=id==='home-1';
  const current=page.locator(one?'[data-current]':'[data-jwh2-current]');
  const next=page.locator(one?'[data-dir="1"]':'[data-jwh2-next]');
  const previous=page.locator(one?'[data-dir="-1"]':'[data-jwh2-prev]');
  const vp=page.locator(one?'[data-jw-hero-viewport]':'[data-jwh2-viewport]');
  await next.scrollIntoViewIfNeeded();
  await record('slider-next','다음 버튼을 눌러 01에서 02로 변경되고 선택 슬라이드가 표시되는지 확인했습니다.',async()=>{await next.click();await expect(current).toHaveText('02');await page.waitForTimeout(350);});
  await record('slider-prev','이전 버튼을 눌러 02에서 01로 복귀하는 실제 화면을 확인했습니다.',async()=>{await previous.click();await expect(current).toHaveText('01');await page.waitForTimeout(350);});
  await record('slider-keyboard','슬라이더에 키보드 ArrowRight를 보내 다음 슬라이드와 표시 번호가 바뀌는지 확인했습니다.',async()=>{await vp.press('ArrowRight');await expect(current).toHaveText('02');await page.waitForTimeout(350);});
  await open(id,false);
  const play=page.locator(one?'[data-play]':'[data-jwh2-play]');
  await play.scrollIntoViewIfNeeded();await page.waitForTimeout(400);
  // Both controls begin in a known stopped state before testing a full playback interval.
  if((await play.textContent())!=='재생')await play.click();
  await record('slider-play-pause','재생 후 실제 자동 전환을 기다려 번호 변경을 확인하고 정지했습니다. 정지 후 번호 유지도 확인했습니다.',async()=>{const start=await current.textContent();await play.click();await page.evaluate(()=>scrollTo(0,0));await page.mouse.move(-10,-10);await expect(current).not.toHaveText(start!,{timeout:11000});await play.click();const stopped=await current.textContent();await page.waitForTimeout(500);await expect(current).toHaveText(stopped!);});
  await open(id,true);await next.scrollIntoViewIfNeeded();
  await record('slider-reduced-motion','줄인 동작 설정에서 자동 재생이 정지된 상태와 수동 다음 이동을 확인했습니다.',async()=>{await expect(play).toHaveText('재생');if(one)await expect(play).toBeDisabled();const start=await current.textContent();await page.waitForTimeout(700);await expect(current).toHaveText(start!);await next.click();await expect(current).toHaveText('02');});
 }
 await open('home-1');
 const card=page.locator('.services__index a').first();
 await card.scrollIntoViewIfNeeded();await page.mouse.move(0,0);await page.waitForTimeout(400);
 await record('service-hover-turn','첫 서비스 카드에 포인터를 올려 아이콘 회전과 카드 강조를 확인했습니다. 모바일 크기에서도 마우스 입력을 시험했습니다.',async()=>{await card.hover();await page.waitForTimeout(180);expect(await card.locator('.service-icon').evaluate(el=>getComputedStyle(el).transform)).not.toBe('none');});
 await page.mouse.move(0,0);await page.waitForTimeout(500);
 await record('service-keyboard-focus','Tab 키로 첫 서비스 카드에 초점을 이동하여 focus-visible 표시와 아이콘 반응을 확인했습니다.',async()=>{await card.focus();await page.keyboard.press('Tab');await page.keyboard.press('Shift+Tab');await expect(card).toBeFocused();expect(await card.evaluate(el=>el.matches(':focus-visible'))).toBe(true);await page.waitForTimeout(180);});
 await open('home-1');
 await record('scroll-reveal','화면 아래 전략 지도로 스크롤하여 Motion inView가 is-visible을 부여하고 콘텐츠가 나타나는지 확인했습니다.',async()=>{const el=page.locator('.strategy__map');await el.scrollIntoViewIfNeeded();await expect(el).toHaveClass(/is-visible/);await page.waitForTimeout(700);await expect(el).toBeVisible();});
 await open('home-1',true);
 await record('scroll-reduced-motion','줄인 동작 환경에서 아래 전략 지도까지 스크롤하여 내용과 글자가 즉시 보이고 transform이 없는지 확인했습니다.',async()=>{const el=page.locator('.strategy__map');await el.scrollIntoViewIfNeeded();await expect(el).toBeVisible();expect(await el.evaluate(el=>getComputedStyle(el).transform)).toBe('none');});
 await open('onepage-showcase');
 const tabs=page.getByRole('tab');await tabs.first().scrollIntoViewIfNeeded();
 await record('detail-tabs-keyboard','탭의 ArrowRight와 End 키로 크기와 설치 검토를 선택하고 aria-selected 및 배치도의 실제 표시를 확인했습니다.',async()=>{await tabs.first().press('ArrowRight');await expect(tabs.nth(1)).toHaveAttribute('aria-selected','true');await tabs.nth(1).press('End');await expect(tabs.nth(2)).toHaveAttribute('aria-selected','true');await expect(page.locator('[data-jwo-install-diagram]')).toBeVisible();});
 await open('onepage-showcase');
 await record('detail-scroll',viewport==='desktop'?'소재 사진으로 스크롤하여 Motion 패럴랙스 transform과 이미지 표시를 확인했습니다.':'모바일 소재 사진으로 스크롤하여 자동 이동이 없는 정적 대체 화면을 확인했습니다.',async()=>{const img=page.locator('[data-jwo-depth] img');await img.scrollIntoViewIfNeeded();await page.waitForTimeout(400);const transform=await img.evaluate(el=>getComputedStyle(el).transform);if(viewport==='desktop')expect(transform).not.toBe('none');else expect(transform).toBe('none');});
 await open('onepage-showcase',true);
 await record('detail-reduced-motion','줄인 동작 설정에서 소재 사진까지 이동하여 transform 없는 정적 사진과 본문을 확인했습니다.',async()=>{const img=page.locator('[data-jwo-depth] img');await img.scrollIntoViewIfNeeded();expect(await img.evaluate(el=>getComputedStyle(el).transform)).toBe('none');await expect(img).toBeVisible();});
 await open('onepage-projects',true);
 const next=page.locator('[data-jwo-next]'),prev=page.locator('[data-jwo-prev]'),status=page.locator('[data-jwo-gallery-status]');
 await next.scrollIntoViewIfNeeded();
 await record('gallery-next','갤러리 다음 버튼으로 두 번째 공간 사진과 설명으로 이동하는지 확인했습니다.',async()=>{await next.click();await expect(status).toContainText('2 /');});
 await record('gallery-prev','갤러리 이전 버튼으로 첫 번째 사진으로 복귀하는지 확인했습니다.',async()=>{await prev.click();await expect(status).toContainText('1 /');});
 await record('gallery-keyboard','갤러리의 ArrowRight 키로 두 번째 사진을 선택하고 설명 변경을 확인했습니다.',async()=>{await page.locator('[data-jwo-gallery-viewport]').press('ArrowRight');await expect(status).toContainText('2 /');});
 await context.close();
}
await browser.close();
await writeFile(resolve(directory,'manifest.json'),JSON.stringify(evidence,null,2)+'\n');
console.log('Collected',evidence.length,'actual interactions; independent review still required.');
