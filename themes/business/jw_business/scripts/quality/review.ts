import { readFile } from "node:fs/promises";
import sharp from "sharp";
import { safeFile, sha256 } from "./files";
import { validate, type Artifact, type Failure, type PagePlan, type Review } from "./model";
import type { PageSource } from "./media";

const validTime = (value: string): boolean => /^\d{4}-\d{2}-\d{2}T/.test(value) && Number.isFinite(Date.parse(value)) && Date.parse(value) <= Date.now() + 60_000;
const placeholder = /^(?:pending|todo|unknown|author|reviewer|implementer|pass|승인|검토자|미정)$/i;
export async function inspectReview(root: string, group: string, plans: PagePlan[], digest: string, sources: PageSource[]): Promise<{ failures: Failure[]; review?: Review }> {
  const failures: Failure[] = [];
  const fail = (code: string, target: string, message: string) => failures.push({ code, target, message });
  let review: Review;
  try { review = validate<Review>("review", JSON.parse(await readFile(await safeFile(root, `quality/reviews/${group}.json`), "utf8"))); }
  catch (error) { return { failures: [{ code: "REVIEW_MISSING_OR_INVALID", target: group, message: String(error) }] }; }
  if (review.group !== group || review.inputDigest !== digest) fail("STALE_REVIEW", group, "현재 소스·이미지·검사 정책과 검토 기록이 일치하지 않습니다.");
  if (review.result !== "pass") fail("REVIEW_NOT_PASSED", group, "시각 검토가 통과하지 않았습니다.");
  if (review.implementer === review.reviewer || [review.implementer, review.reviewer].some(value => value.length < 6 || placeholder.test(value))) fail("INDEPENDENT_REVIEW", group, "구현자와 별개 검토자의 실제 작업 식별자가 필요합니다.");
  if (!validTime(review.reviewedAt)) fail("REVIEW_TIME", group, "유효한 실제 검토 시각이 필요합니다.");
  const ids = new Set(plans.map(plan => plan.id));
  if (review.pages.length !== ids.size || new Set(review.pages.map(page => page.id)).size !== ids.size || review.pages.some(page => !ids.has(page.id))) fail("REVIEW_COVERAGE", group, "페이지별 검토 범위가 요구한 묶음과 다릅니다.");
  for (const page of review.pages) for (const key of ["purpose", "imagery", "composition"] as const) {
    if (page[key].id !== key || page[key].result !== "pass") fail("VISUAL_REJECTED", page.id, `${key}: ${page[key].reason}`);
  }
  const seenFiles = new Set<string>(), seenHashes = new Set<string>();
  async function artifact(item: Artifact): Promise<{ width?: number; height?: number } | undefined> {
    try {
      if (!item.path.startsWith("quality/evidence/")) throw new Error("검토 화면은 quality/evidence/에 있어야 합니다.");
      const bytes = await readFile(await safeFile(root, item.path));
      if (sha256(bytes) !== item.sha256) throw new Error("화면 파일이 검토 이후 바뀌었습니다.");
      const metadata = await sharp(bytes).metadata();
      if (!["png", "jpeg", "webp"].includes(metadata.format ?? "")) throw new Error("실제 화면 이미지가 아닙니다.");
      return metadata;
    } catch (error) { fail("EVIDENCE_FILE", item.path, String(error)); return undefined; }
  }
  const keys = new Set<string>();
  if (review.captures.length !== ids.size * 4) fail("CAPTURE_COVERAGE", group, "각 페이지의 PC·모바일 × 라이트·다크 전체 화면 4장이 필요합니다.");
  for (const capture of review.captures) {
    const key = `${capture.page}/${capture.viewport}/${capture.mode}`;
    const plan = plans.find(page => page.id === capture.page);
    if (!plan || keys.has(key)) fail("CAPTURE_COVERAGE", key, "검사 범위 밖이거나 중복된 캡처입니다.");
    keys.add(key);
    if (seenFiles.has(capture.path) || seenHashes.has(capture.sha256)) fail("REUSED_CAPTURE", key, "다른 페이지·화면 상태의 증거를 재사용했습니다.");
    seenFiles.add(capture.path); seenHashes.add(capture.sha256);
    const metadata = await artifact(capture);
    if (metadata && (metadata.width !== capture.width || !metadata.height || metadata.height < capture.height || Math.abs(metadata.height - capture.documentHeight) > 2)) fail("CAPTURE_DIMENSIONS", key, "캡처 크기와 기록된 전체 문서 크기가 다릅니다.");
    if (capture.viewport === "desktop" ? capture.width < 1280 || capture.width > 1920 : capture.width < 360 || capture.width > 430) fail("VIEWPORT", key, "PC 1280–1920px, 모바일 360–430px 범위로 확인해야 합니다.");
    try {
      const url = new URL(capture.url);
      if (url.origin !== "https://g5themes.test" || url.pathname !== plan?.route) throw new Error("검토 페이지 주소가 지정된 실제 G5 경로와 다릅니다.");
    } catch (error) { fail("CAPTURE_URL", key, String(error)); }
    if (!validTime(capture.capturedAt) || Date.parse(capture.capturedAt) > Date.parse(review.reviewedAt)) fail("CAPTURE_TIME", key, "캡처 시각이 검토보다 늦거나 유효하지 않습니다.");
    const expected = sources.find(page => page.plan.id === capture.page)?.media ?? new Set<string>();
    if ([...expected].some(path => !capture.media.includes(path))) fail("MEDIA_COVERAGE", key, "소스에서 발견한 이미지가 실제 화면 이미지 목록에 없습니다.");
    const observations = new Map(capture.requirements.map(item => [item.id, item]));
    if (observations.size !== capture.requirements.length || observations.size !== plan?.requirements.length) fail("REQUIREMENT_COVERAGE", key, "필수 콘텐츠의 실제 표시 관찰 기록이 빠지거나 중복됐습니다.");
    for (const requirement of plan?.requirements ?? []) {
      const observation = observations.get(requirement.id);
      if (!observation?.visible || observation.count < requirement.min) fail("REQUIREMENT_NOT_VISIBLE", key, `${requirement.description}: 실제 표시와 수량 확인이 필요합니다.`);
    }
  }
  for (const id of ids) for (const viewport of ["desktop", "mobile"]) for (const mode of ["light", "dark"]) {
    if (!keys.has(`${id}/${viewport}/${mode}`)) fail("CAPTURE_MISSING", id, `${viewport}/${mode} 전체 화면이 없습니다.`);
  }
  const comparisons = new Set<string>();
  for (const comparison of review.comparisons) {
    const key = [comparison.left, comparison.right].sort().join("/");
    if (!ids.has(comparison.left) || !ids.has(comparison.right) || comparison.left === comparison.right || comparisons.has(key)) fail("COMPARISON_COVERAGE", group, "변형 비교가 중복되거나 검사 범위를 벗어났습니다.");
    comparisons.add(key);
    if (comparison.result !== "pass") fail("VARIANTS_TOO_SIMILAR", key, comparison.reason);
  }
  for (let i = 0; i < plans.length; i++) for (let j = i + 1; j < plans.length; j++) {
    if (!comparisons.has([plans[i]!.id, plans[j]!.id].sort().join("/"))) fail("COMPARISON_MISSING", group, `${plans[i]!.id}와 ${plans[j]!.id}의 시각 비교가 없습니다.`);
  }
  const expectedInteractions = new Set(plans.flatMap(page => page.interactions.flatMap(id => ["desktop", "mobile"].map(viewport => `${page.id}/${id}/${viewport}`))));
  const actualInteractions = new Set<string>();
  for (const action of review.interactions) {
    const key = `${action.page}/${action.id}/${action.viewport}`;
    if (!expectedInteractions.has(key) || actualInteractions.has(key)) fail("INTERACTION_COVERAGE", key, "필요하지 않거나 중복된 동작 기록입니다.");
    actualInteractions.add(key);
    if (action.result !== "pass" || action.before.sha256 === action.after.sha256) fail("INTERACTION_FAILED", key, "동작 전후의 실제 변화와 통과 기록이 필요합니다.");
    await artifact(action.before); await artifact(action.after);
  }
  for (const key of expectedInteractions) if (!actualInteractions.has(key)) fail("INTERACTION_MISSING", key, "PC·모바일 실제 동작 검증이 없습니다.");
  return { failures, review };
}
