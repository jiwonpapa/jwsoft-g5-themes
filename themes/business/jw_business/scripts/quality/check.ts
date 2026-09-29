import { readFile } from "node:fs/promises";
import { load } from "cheerio";
import { inputDigest, groupDigest, safeFile, sha256 } from "./files";
import { inspectMedia, inspectSources, withoutPhp } from "./media";
import { inspectReview } from "./review";
import { validate, type AssetRegistry, type Failure, type PagePlan, type QualityContract, type QualityResult } from "./model";

export async function loadPolicy(root: string): Promise<{ contract: QualityContract; assets: AssetRegistry }> {
  const contract = validate<QualityContract>("contract", JSON.parse(await readFile(await safeFile(root, "quality/contract.json"), "utf8")));
  const assets = validate<AssetRegistry>("assets", JSON.parse(await readFile(await safeFile(root, "quality/assets.json"), "utf8")));
  const catalog = JSON.parse(await readFile(await safeFile(root, "docs/PAGE-CATALOG.json"), "utf8")) as { pageTypes: Array<{ id: string; layouts: string[] }> };
  const groups = ["home", "onepage", ...catalog.pageTypes.map(page => page.id)];
  if (groups.length !== 16 || new Set(groups).size !== 16 || catalog.pageTypes.some(page => page.layouts.length !== 5)) throw new Error("메인 4개·원페이지 3개·일반 페이지 70개 계약을 줄이거나 중복시킬 수 없습니다.");
  const expected = groups.flatMap(group => (group === "onepage" ? [] : group === "home" ? [1, 2, 3, 4] : [1, 2, 3, 4, 5]).map(variant => ({
    id: `${group}-${variant}`, group,
    path: group === "home" ? `src/php/index_${variant}.php` : `pages/${group}-${variant}.php`,
    route: group === "home" ? `/theme/jw_business/index_${variant}.php` : `/pages/${group}-${variant}.php`,
  }))).concat(["showcase", "services", "projects"].map(variant => ({
    id: `onepage-${variant}`, group: "onepage", path: `pages/onepage-${variant}.php`, route: `/pages/onepage-${variant}.php`,
  })));
  if (contract.pages.length !== 77 || new Set(contract.pages.map(page => page.id)).size !== 77) throw new Error("검사 계약에 메인 4개·원페이지 3개·일반 페이지 70개가 모두 필요합니다.");
  for (const entry of expected) {
    const plan = contract.pages.find(page => page.id === entry.id);
    if (!plan || Object.entries(entry).some(([key, value]) => plan[key as keyof PagePlan] !== value)) throw new Error(`검사 대상·경로를 누락하거나 변경할 수 없습니다: ${entry.id}`);
    if (new Set(plan.requirements.map(item => item.id)).size !== plan.requirements.length) throw new Error(`요구사항 ID 중복: ${entry.id}`);
  }
  const homeSlider = contract.pages.find(page => page.id === "home-1")!;
  if (!homeSlider.requirements.some(item => item.id === "hero-slider" && item.selector === "[data-jw-hero-slider]" && item.min >= 1)
    || ["slider-next", "slider-prev", "slider-keyboard", "slider-play-pause", "slider-reduced-motion"].some(id => !homeSlider.interactions.includes(id))) throw new Error("메인 히어로 슬라이더 요구사항을 삭제하거나 완화할 수 없습니다.");
  for (const asset of assets.photos) if (!expected.some(page => page.id === asset.owner)) throw new Error(`자산 소유 페이지가 유효하지 않습니다: ${asset.path}`);
  return { contract, assets };
}

export async function checkQuality(root: string, scope = "current"): Promise<QualityResult> {
  const failures: Failure[] = [];
  const { contract, assets } = await loadPolicy(root);
  const sources = await inspectSources(root, contract.pages);
  const implemented = sources.filter(page => !/class=["'][^"']*jw-page-facade\b/.test(page.body));
  const groups = [...new Set(contract.pages.map(page => page.group))];
  if (!["current", "release", ...groups].includes(scope)) throw new Error(`알 수 없는 검사 범위: ${scope}`);
  // Already delivered pages cannot disappear from the gate by being relabelled as
  // scaffolds. Newly implemented pages automatically join the same mandatory set.
  const established = new Set(["home", "company-overview", "business-list", "business-detail"].flatMap(group => (group === "home" ? [1, 2, 3, 4] : [1, 2, 3, 4, 5]).map(number => `${group}-${number}`)).concat("contact-1", "onepage-showcase", "onepage-services", "onepage-projects"));
  const selected = scope === "current" ? sources.filter(page => established.has(page.plan.id) || implemented.includes(page))
    : scope === "release" ? sources : sources.filter(page => page.plan.group === scope);
  const digest = await inputDigest(root);
  for (const page of selected) {
    if (!page.plan.ready || [page.plan.firstViewport, page.plan.composition, page.plan.imagery].some(value => value.length < 20 || /미정|준비 필요|설계 필요/.test(value))) failures.push({ code: "DESIGN_NOT_READY", target: page.plan.id, message: "첫 화면·구성·이미지 계획이 확정되지 않았습니다. 수량 확보를 위한 구현을 진행할 수 없습니다." });
    if (!implemented.includes(page)) failures.push({ code: "SCAFFOLD", target: page.plan.id, message: "작성된 페이지가 아닌 스캐폴드입니다." });
    const $ = load(withoutPhp(page.source));
    for (const requirement of page.plan.requirements) {
      try {
        if ($(requirement.selector).length < requirement.min) failures.push({ code: "REQUIRED_CONTENT", target: page.plan.id, message: `${requirement.id}: ${requirement.description} (${requirement.selector})` });
      } catch { failures.push({ code: "INVALID_SELECTOR", target: page.plan.id, message: requirement.selector }); }
    }
  }
  // Titles, prose, image paths and section order do not make another design.
  // Exact skeleton matches block mechanically; subtler similarity needs pairwise visual review.
  for (const group of new Set(selected.map(page => page.plan.group))) {
    const peers = implemented.filter(page => page.plan.group === group);
    const skeletons = new Map<string, string>();
    const openings = new Map<string, string[]>();
    for (const peer of peers) {
      const $ = load(peer.body);
      $("nav, aside, script, style").remove();
      const blocks = $("header, section").filter((_, element) => !$(element).parents("section, header").length).toArray();
      const signatureOf = (element: typeof blocks[number]) => $(element).find("*").addBack().toArray().map(node =>
        `${"tagName" in node ? node.tagName : ""}.${($(node).attr("class") ?? "").split(/\s+/).sort().join(".")}`
      ).join(" ");
      const fragments = blocks.map(signatureOf).sort();
      if (blocks[0]) {
        const opening = sha256(signatureOf(blocks[0]));
        openings.set(opening, [...(openings.get(opening) ?? []), peer.plan.id]);
      }
      const signature = sha256(fragments.join("\n"));
      if (fragments.length && skeletons.has(signature)) failures.push({ code: "REPEATED_STRUCTURE", target: `${skeletons.get(signature)} / ${peer.plan.id}`, message: "문구·이미지·순서를 제외한 섹션 구조가 같습니다. 시각적으로 다른 설계가 필요합니다." });
      skeletons.set(signature, peer.plan.id);
    }
    for (const matching of openings.values()) if (matching.length >= 3) failures.push({ code: "REPEATED_OPENING", target: matching.join(" / "), message: "같은 목적의 변형 3개 이상이 동일한 도입 구조를 사용합니다. 첫 화면에서 선택 이유가 드러나도록 재설계해야 합니다." });
    // A current-scope review covers only delivered pages in its group. Requiring
    // the other scaffold variants here contradicts the 23-page current scope;
    // release and explicit group completion still select every variant.
    const reviewPlans = selected.filter(page => page.plan.group === group).map(page => page.plan);
    const reviewed = await inspectReview(root, group, reviewPlans, digest, sources, await groupDigest(root, group));
    failures.push(...reviewed.failures);
    // Include dynamically rendered assets so PHP/CSS indirection cannot omit them from reuse checks.
    for (const capture of reviewed.review?.captures ?? []) {
      const source = sources.find(page => page.plan.id === capture.page);
      if (source) for (const path of capture.media) source.media.add(path);
    }
  }
  failures.push(...await inspectMedia(root, assets, sources));
  const photoUsage = new Map<string, Set<string>>();
  for (const page of sources) for (const path of page.media) {
    if (!photoUsage.has(path)) photoUsage.set(path, new Set());
    photoUsage.get(path)!.add(page.plan.id);
  }
  return { result: failures.length ? "fail" : "pass", scope, inputDigest: digest, pages: selected.length, failures,
    photoUsage: [...photoUsage].map(([path, users]) => ({ path, pages: [...users].sort() })) };
}

export async function assertQuality(root: string, scope = "release"): Promise<void> {
  const result = await checkQuality(root, scope);
  if (result.result !== "pass") throw new Error(`JW-Business quality blocked (${result.failures.length}): ${result.failures.slice(0, 6).map(failure => `${failure.code} ${failure.target}`).join("; ")}`);
}
