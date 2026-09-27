const $ = selector => document.querySelector(selector);
let pages;
try {
  pages = await fetch('catalog.json').then(response => { if (!response.ok) throw new Error('목록을 불러오지 못했습니다.'); return response.json(); });
  if (!Array.isArray(pages) || !pages.length) throw new Error('목록이 비어 있습니다.');
} catch {
  $('#section-title').textContent = '목록을 불러오지 못했습니다';
  $('#purpose').textContent = '연결을 확인한 뒤 다시 시도해 주세요.';
  $('#status').replaceChildren();
  const retry = document.createElement('button'); retry.type = 'button'; retry.textContent = '다시 불러오기';
  retry.addEventListener('click', () => location.reload()); $('#status').append(retry);
  $('.gallery-panes').hidden = true; $('.source-panel').hidden = true;
  for (const control of document.querySelectorAll('select')) control.disabled = true;
  throw new Error('Gallery catalog unavailable; retry UI displayed.');
}
const select = $('#page-select'), iframe = $('#live');
let active = pages.find(page => page.id === 'home-4') || pages[0], block = null;
for (const page of pages) select.add(new Option(page.label, page.id));
select.value = active.id;
function sizePreview() {
  const width = Number($('#device').value), space = $('.live-viewport').clientWidth;
  const scale = Math.min(1, space / width);
  iframe.style.width = width + 'px';
  iframe.style.height = $('.live-viewport').clientHeight / scale + 'px';
  iframe.style.transform = 'scale(' + scale + ')';
  $('#scale').textContent = width + 'px · ' + Math.round(scale * 100) + '%';
}
function updateReference() {
  const state = ($('#device').value === '390' ? 'mobile' : 'desktop') + ($('#mode').value === 'jw-dark' ? '-dark' : '-light');
  const ref = active.references?.[state];
  $('#reference').hidden = !ref; $('#reference-empty').hidden = !!ref;
  if (ref) $('#reference').src = ref;
}
async function focusBlock() {
  const doc = iframe.contentDocument;
  if (!doc?.querySelector('main')) return;
  const chosen = block;
  await doc.fonts.ready;
  const image = $('#reference');
  if (!image.hidden) await image.decode().catch(() => {});
  if (chosen !== block || doc !== iframe.contentDocument) return;
  await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));
  doc.documentElement.dataset.theme = $('#mode').value;
  const target = block?.selector ? doc.querySelector(block.selector) : doc.querySelector('main');
  if (target) {
    const y = target.getBoundingClientRect().top + iframe.contentWindow.scrollY;
    iframe.contentWindow.scrollTo({top:Math.max(0,y - 88),behavior:'instant'});
    const offset = Math.max(0,y - 88) * image.clientWidth / Number($('#device').value);
    // Anchor the selected reference in layout, independent of screenshot/resize scroll restoration.
    image.style.marginTop = -offset + 'px';
    $('.reference-viewport').scrollTop = 0;
    image.dataset.offset = String(offset);
    document.body.dataset.previewReady = chosen.title;
  }
}
function choose(item) {
  block = item;
  delete document.body.dataset.previewReady;
  $('#section-title').textContent = item.title;
  $('#purpose').textContent = active.purpose;
  $('#source').textContent = item.source;
  $('#source-path').textContent = '수정 원본: ' + active.path;
  $('#dependencies').textContent = active.dependencies;
  $('#copy-state').textContent = '';
  for (const button of $('#sections').children) button.setAttribute('aria-current', String(button.textContent === item.title));
  focusBlock();
}
function loadPage() {
  $('#sections').replaceChildren();
  for (const item of active.blocks) {
    const button = document.createElement('button'); button.type = 'button'; button.textContent = item.title;
    button.addEventListener('click', () => choose(item)); $('#sections').append(button);
  }
  $('#open-page').href = active.route;
  localStorage.setItem('jw-business-theme', $('#mode').value);
  iframe.src = active.route + '?device=' + ($('#device').value === '390' ? 'mobile' : 'pc');
  updateReference(); choose(active.blocks[0]); sizePreview();
}
iframe.addEventListener('load', () => { sizePreview(); focusBlock(); $('#status').textContent = '실제 G5 렌더링 · 캡처와 자동 검사 통과는 별도로 확인하세요.'; });
select.addEventListener('change', () => { active = pages.find(page => page.id === select.value); loadPage(); });
$('#mode').addEventListener('change', () => { document.documentElement.dataset.theme = $('#mode').value; loadPage(); });
$('#device').addEventListener('change', loadPage);
new ResizeObserver(sizePreview).observe($('.live-viewport'));
$('#copy').addEventListener('click', async () => {
  try { await navigator.clipboard.writeText($('#source').textContent); $('#copy-state').textContent = '복사했습니다. 사용 조건을 확인해 주세요.'; }
  catch { $('#copy-state').textContent = '복사 권한이 없습니다. 아래 원본을 선택해 복사해 주세요.'; }
});
loadPage();
