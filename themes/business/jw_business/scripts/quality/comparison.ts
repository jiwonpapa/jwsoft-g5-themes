import { readFile, mkdir, writeFile } from "node:fs/promises";
import { join, relative, dirname } from "node:path";
import { safeFile } from "./files";
import { validate, type QualityContract, type Review } from "./model";

const escape = (value: string): string => value.replaceAll("&", "&amp;").replaceAll("<", "&lt;").replaceAll(">", "&gt;").replaceAll('"', "&quot;");
export async function writeComparison(root: string, contract: QualityContract, group: string): Promise<string> {
  const review = validate<Review>("review", JSON.parse(await readFile(await safeFile(root, `quality/reviews/${group}.json`), "utf8")));
  if (review.group !== group) throw new Error("비교판과 검토 묶음이 다릅니다.");
  const output = join(root, `quality/evidence/${group}/comparison.html`);
  const pages = contract.pages.filter(page => page.group === group);
  const sections: string[] = [];
  for (const viewport of ["desktop", "mobile"]) for (const mode of ["light", "dark"]) {
    const cards: string[] = [];
    for (const page of pages) {
      const capture = review.captures.find(item => item.page === page.id && item.viewport === viewport && item.mode === mode);
      let content = '<p class="missing">필수 전체 화면 누락 — 통과 불가</p>';
      if (capture) {
        const file = await safeFile(root, capture.path);
        if (!capture.path.startsWith("quality/evidence/")) throw new Error("검토 화면 경로가 아닙니다.");
        const image = relative(dirname(output), file).split("/").map(encodeURIComponent).join("/");
        content = `<a href="${escape(image)}"><img src="${escape(image)}" alt="${escape(page.id)} ${viewport} ${mode} 전체 화면"></a>`;
      }
      cards.push(`<article><h3>${escape(page.id)}</h3><p>${escape(page.layout)}</p>${content}</article>`);
    }
    sections.push(`<section><h2>${viewport} · ${mode}</h2><div class="grid">${cards.join("")}</div></section>`);
  }
  const html = `<!doctype html><html lang="ko"><meta charset="utf-8"><title>${escape(group)} 변형 비교</title><style>body{font:15px system-ui;margin:24px;background:#eceff1;color:#17212b}.grid{display:grid;grid-template-columns:repeat(${pages.length},minmax(0,1fr));gap:16px}article{background:white;padding:12px}img{width:100%;height:auto}h2{margin-top:40px}.missing{color:#a00000}a{color:inherit}</style><h1>${escape(group)} ${pages.length}개 변형 비교</h1><p>검토 결과: ${escape(review.result)}. 비교판 생성 자체는 통과가 아닙니다. 각 화면을 열어 첫 화면·중간·마지막 구성과 콘텐츠 적합성을 직접 확인하세요.</p>${sections.join("")}</html>`;
  await mkdir(dirname(output), { recursive: true });
  await writeFile(output, html);
  return output;
}
