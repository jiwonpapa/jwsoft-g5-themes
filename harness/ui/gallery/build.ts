import { cp, mkdir, readFile, writeFile, readdir } from 'node:fs/promises';
import { resolve } from 'node:path';
import { mainPages, root, themeRoot, states } from '../catalog';
export const galleryOutput = resolve(root, '.runtime/ui-gallery');
export function sections(source: string) {
  const result: string[] = []; let depth = 0, start = 0;
  for (const match of source.matchAll(/<\/?section\b[^>]*>/g)) {
    if (match[0].startsWith('</')) { if (--depth === 0) result.push(source.slice(start, match.index! + match[0].length)); }
    else if (depth++ === 0) start = match.index!;
  }
  return result;
}
export async function buildGallery() {
  await mkdir(galleryOutput, { recursive: true });
  for (const file of ['index.php', 'gallery.css', 'gallery.js']) await cp(resolve(import.meta.dirname, file), resolve(galleryOutput, file));
  await writeFile(resolve(galleryOutput, '.enabled'), 'Developer-only; never distribute with the theme.\n');
  const names = ['히어로 · 이미지와 소개', '과정 · 대형 아이콘 카드', '발견 · 리서치 브리프', '전략 · 고객 여정', '디지털 · 시안과 화면', '브랜드 · 비주얼 보드', '전달 · 결과물 패키지', '질문 · FAQ', '문의 · 다음 단계'];
  const data = [];
  for (const plan of mainPages) {
    const source = await readFile(resolve(themeRoot, plan.path), 'utf8');
    const blocks = plan.id === 'home-4' ? sections(source).map((text, index) => ({
      title: names[index], selector: 'main section:nth-of-type(' + (index + 1) + ')',
      source: '<!-- 복사 원본: JW-Business index_4.php / 독립 수정 블록. JW SOFT 저작권 및 상품 라이선스 적용. -->\n' + text,
    })) : [{ title: '전체 페이지', selector: 'main', source }];
    const references: Record<string,string> = {};
    if (plan.id === 'home-4') {
      const referenceDir = resolve(themeRoot, 'quality/evidence/main4-20260927');
      const files = await readdir(referenceDir);
      for (const state of states) {
        const file = files.find(name => name === state.name + '.png');
        if (file) { const out = 'reference-' + state.name + '.png'; await cp(resolve(referenceDir, file), resolve(galleryOutput, out)); references[state.name] = out; }
      }
    }
    data.push({ id: plan.id, label: plan.id.replace('home-', '메인 ').replace('onepage-', '원페이지 · '),
      path: 'themes/business/jw_business/' + plan.path, route: plan.route, purpose: plan.purpose, blocks, references,
      dependencies: plan.id === 'home-4' ? 'G5 head/tail + jw-business 및 home-four CSS/JS가 필요합니다. .jwh4[data-jw-home="4"] 안에 배치하세요. 이미지 경로와 Lucide 아이콘 등록도 함께 확인하세요. inc/sections include를 만들지 않습니다.' : '완성형 PHP 원본입니다. 기존 G5 head/tail·개별 CSS/JS·이미지 경로를 유지하고 필요한 섹션을 페이지 안에서 직접 편집하세요.',
    });
  }
  await writeFile(resolve(galleryOutput, 'catalog.json'), JSON.stringify(data, null, 2));
  console.log('Developer gallery generated: ' + galleryOutput);
}
if (import.meta.main) await buildGallery();
