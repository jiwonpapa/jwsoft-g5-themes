import { afterEach, describe, expect, test } from "bun:test";
import { cp, mkdir, mkdtemp, readFile, rm, symlink, writeFile } from "node:fs/promises";
import { tmpdir } from "node:os";
import { dirname, join, resolve } from "node:path";
import sharp from "sharp";
import { checkQuality, loadPolicy } from "../scripts/quality/check";
import { inputDigest, sha256 } from "../scripts/quality/files";
import { imageFingerprint, inspectMedia, inspectSources, similar } from "../scripts/quality/media";
import { inspectReview } from "../scripts/quality/review";
import type { AssetRegistry, PagePlan, QualityContract, Review } from "../scripts/quality/model";

const realRoot = resolve(import.meta.dirname, "..");
const temporary: string[] = [];
afterEach(async () => { for (const path of temporary.splice(0)) await rm(path, { recursive: true, force: true }); });
async function put(root: string, path: string, value: unknown): Promise<void> {
  await mkdir(dirname(join(root, path)), { recursive: true });
  await writeFile(join(root, path), typeof value === "string" || value instanceof Uint8Array ? value : JSON.stringify(value));
}
async function fixture(): Promise<{ root: string; contract: QualityContract; plans: PagePlan[]; review: Review }> {
  const root = await mkdtemp(join(tmpdir(), "jw-quality-test-")); temporary.push(root);
  const contract = JSON.parse(await readFile(join(realRoot, "quality/contract.json"), "utf8")) as QualityContract;
  for (const dir of ["src/styles", "src/assets/images", "onepages/assets/images", "tokens", "generated", "theme", "scripts/quality", "quality/evidence"]) await mkdir(join(root, dir), { recursive: true });
  await put(root, "docs/PAGE-CATALOG.json", await readFile(join(realRoot, "docs/PAGE-CATALOG.json")));
  for (const file of ["package.json", "theme.manifest.json", "vite.config.ts", "scripts/check-quality.ts"]) await put(root, file, "{}");
  const homeFourPhotos: AssetRegistry["photos"] = [];
  for (let index = 0; index < 4; index++) {
    const bytes = await sharp({ create: { width: 80, height: 60, channels: 3, background: { r: 40 + index * 30, g: 80, b: 130 } } }).png().toBuffer();
    const path = `src/assets/home-four/fixture-${index}.png`;
    await put(root, path, bytes);
    homeFourPhotos.push({ path, sha256: sha256(bytes), origin: `fixture-main4-${index}`, owner: "home-4" });
  }
  for (const page of contract.pages) {
    page.ready = page.group === "home" || page.group === "onepage";
    page.firstViewport = "방문자의 주제와 첫 행동이 실제 화면에 명확하게 표시됩니다.";
    page.composition = "변형마다 서로 다른 콘텐츠 흐름과 시각적 위계가 실제 화면에 표시됩니다.";
    page.imagery = "이 테스트에서는 원본 사진 없는 본문과 별개의 검토 화면 증거를 사용합니다.";
    const count = Number(page.id.at(-1));
    const requiredMarkers = page.id === "home-2"
        ? "data-jw-home2-slider data-jw-digital-artifact data-jwh2-decision-matrix data-jwh2-decision-evidence"
        : "";
    const homeFourProducts = page.id === "home-4" ? '<section data-jwh4-work-product></section>'.repeat(4) + homeFourPhotos.map(photo => `<img src="${photo.path}">`).join("") + '<a class="h4-process-card"><i class="h4-large-icon"></i></a>'.repeat(4) + '<div class="h4-insights"><div></div><div></div></div>' : "";
    const mainOneSections = [
      '<section data-jw-hero-slider><h1>Test home-1</h1></section>',
      `<section>${'<span class="jwh1-service-icon"><svg></svg></span>'.repeat(3)}</section>`,
      '<section><div class="jwh1-industries__grid"></div></section>',
      '<section><div class="strategy-map"></div></section>',
      `<section><ol class="jwh1-process__rail">${"<li>Step</li>".repeat(4)}</ol></section>`,
      '<section><div class="digital-artifact"></div></section>',
      `<section><div class="jwh1-showcase__grid">${"<article>Example</article>".repeat(3)}</div></section>`,
      '<section><div class="brand"></div></section>',
      '<section><div class="jwh1-touchpoints__board"></div></section>',
      `<section><div class="jwh1-questions">${"<details><summary>Question</summary></details>".repeat(4)}</div></section>`,
      '<section><div class="news"></div></section>',
      '<section><div class="contact"></div></section>',
    ];
    await put(root, page.path, page.group === "home"
      ? page.id === "home-1"
        ? `<div class="jwh1-concept">${mainOneSections.join("")}</div>`
        : `<article><header ${requiredMarkers}><h1>Test ${page.id}</h1>${"<p>Distinct fixture structure</p>".repeat(count)}</header>${homeFourProducts}</article>`
      : page.group === "onepage"
        ? `<article><section><h1>Test ${page.id}</h1><p>Independent onepage fixture</p></section></article>`
        : '<article class="jw-page-facade"><h2>Scaffold</h2></article>');
  }
  await put(root, "quality/contract.json", contract);
  await put(root, "quality/assets.json", { schemaVersion: 1, photos: homeFourPhotos });
  const plans = contract.pages.filter(page => page.group === "home");
  const now = new Date().toISOString();
  const review: Review = {
    schemaVersion: 1, group: "home", inputDigest: await inputDigest(root),
    implementer: "fixture-implementation-task", reviewer: "fixture-independent-review-task", reviewedAt: now, result: "pass",
    captures: [], pages: plans.map(page => ({ id: page.id,
      purpose: { id: "purpose", result: "pass", reason: "테스트 목적의 독립적 페이지 검토 항목을 확인했습니다." },
      imagery: { id: "imagery", result: "pass", reason: "테스트 목적의 독립적 이미지 검토 항목을 확인했습니다." },
      composition: { id: "composition", result: "pass", reason: "테스트 목적의 독립적 구성 검토 항목을 확인했습니다." },
    })), comparisons: plans.flatMap((left, index) => plans.slice(index + 1).map(right => ({ left: left.id, right: right.id, result: "pass" as const, reason: "테스트에서 서로 다른 문서 구조를 사용하는 변형을 비교했습니다." }))), interactions: [],
  };
  let color = 30;
  for (const page of plans) for (const viewport of ["desktop", "mobile"] as const) for (const mode of ["light", "dark"] as const) {
    const width = viewport === "desktop" ? 1280 : 390;
    const bytes = await sharp({ create: { width, height: 640, channels: 3, background: { r: color++, g: 70, b: 120 } } }).png().toBuffer();
    const path = `quality/evidence/${page.id}-${viewport}-${mode}.png`;
    await put(root, path, bytes);
    review.captures.push({ page: page.id, viewport, mode, width, height: 640, documentHeight: 640, fullPage: true, path, sha256: sha256(bytes),
      url: `https://g5themes.test${page.route}`, capturedAt: now, media: page.id === "home-4" ? homeFourPhotos.map(photo => photo.path) : [], requirements: page.requirements.map(item => ({ id: item.id, count: item.min, visible: true })) });
  }
  for (const page of plans) for (const id of page.interactions) for (const viewport of ["desktop", "mobile"] as const) {
    const captures = review.captures.filter(item => item.page === page.id && item.viewport === viewport);
    review.interactions.push({ page: page.id, id, viewport, result: "pass", steps: "테스트의 동작 전후 화면 자료를 별도로 비교했습니다.", before: { path: captures[0]!.path, sha256: captures[0]!.sha256 }, after: { path: captures[1]!.path, sha256: captures[1]!.sha256 } });
  }
  await put(root, "quality/reviews/home.json", review);
  return { root, contract, plans, review };
}
async function photo(root: string, name: string, seed = 1): Promise<string> {
  const width = 100, height = 80;
  const data = Buffer.from(Array.from({ length: width * height * 3 }, (_, i) => (i * seed + (i % 7) * 25) % 256));
  const bytes = await sharp(data, { raw: { width, height, channels: 3 } }).png().toBuffer();
  const path = `src/assets/images/${name}.png`;
  await put(root, path, bytes);
  return path;
}

describe("mandatory product quality gate", () => {
  test("passes a complete independent fixture, not merely a report file", async () => {
    const { root } = await fixture();
    expect((await checkQuality(root, "home")).failures).toEqual([]);
  });
  test("rejects scope shrinkage and deletion of the hero slider requirement", async () => {
    const { root, contract } = await fixture();
    await put(root, "quality/contract.json", { ...contract, pages: contract.pages.slice(1) });
    await expect(loadPolicy(root)).rejects.toThrow("원페이지 3개");
    contract.pages[0]!.interactions = [];
    await put(root, "quality/contract.json", contract);
    await expect(loadPolicy(root)).rejects.toThrow("슬라이더");
  });
  test("fails missing, self-approved, incomplete, failed and stale reviews", async () => {
    const { root, plans, review } = await fixture();
    const sources = await inspectSources(root, plans);
    for (const bad of [
      {}, { ...review, result: "pending" }, { ...review, reviewer: review.implementer },
      { ...review, captures: review.captures.slice(1) }, { ...review, comparisons: [] },
      { ...review, interactions: [] }, { ...review, inputDigest: "0".repeat(64) },
    ]) {
      await put(root, "quality/reviews/home.json", bad);
      expect((await inspectReview(root, "home", plans, review.inputDigest, sources)).failures.length).toBeGreaterThan(0);
    }
    await rm(join(root, "quality/reviews/home.json"));
    expect((await checkQuality(root, "home")).failures.some(item => item.code === "REVIEW_MISSING_OR_INVALID")).toBe(true);
  });
  test("invalidates evidence after source, CSS, JS, image, policy and payload changes", async () => {
    const { root, review } = await fixture();
    for (const path of ["src/styles/changed.css", "src/scripts/changed.ts", "src/assets/images/changed.png", "onepages/assets/images/changed.png", "theme/index.php", "pages/extra.php", "scripts/quality/changed.ts"]) {
      await put(root, path, "changed");
      expect(await inputDigest(root)).not.toBe(review.inputDigest);
      await rm(join(root, path));
    }
    expect(await inputDigest(root)).toBe(review.inputDigest);
  });
  test("blocks missing required markup, duplicated skeleton and unresolved design", async () => {
    const { root, contract } = await fixture();
    await cp(join(root, "src/php/index_2.php"), join(root, "src/php/index_1.php"));
    contract.pages[1]!.ready = false;
    await put(root, "quality/contract.json", contract);
    const codes = (await checkQuality(root, "home")).failures.map(item => item.code);
    expect(codes).toContain("REQUIRED_CONTENT"); expect(codes).toContain("REPEATED_STRUCTURE"); expect(codes).toContain("DESIGN_NOT_READY");
  });
  test("blocks the home-1 candidate when a required service icon is missing", async () => {
    const { root } = await fixture();
    const file = join(root, "src/php/index_1.php");
    await writeFile(file, (await readFile(file, "utf8")).replace('<span class="jwh1-service-icon"><svg></svg></span>', ""));
    expect((await checkQuality(root, "home")).failures.some(item => item.code === "REQUIRED_CONTENT" && item.target === "home-1")).toBe(true);
  });
  test("rejects changed screenshots, reused captures, invisible requirements and false URLs", async () => {
    const { root, plans, review } = await fixture();
    review.captures[1] = { ...review.captures[0]!, mode: "dark" };
    review.captures[2]!.url = "https://example.com/";
    review.captures[3]!.requirements[0]!.visible = false;
    await put(root, review.captures[4]!.path, "not a screenshot");
    await put(root, "quality/reviews/home.json", review);
    const codes = (await inspectReview(root, "home", plans, review.inputDigest, await inspectSources(root, plans))).failures.map(item => item.code);
    expect(codes).toContain("REUSED_CAPTURE"); expect(codes).toContain("CAPTURE_URL"); expect(codes).toContain("REQUIREMENT_NOT_VISIBLE"); expect(codes).toContain("EVIDENCE_FILE");
  });
  test("detects CSS backgrounds, PHP photo helper and cross-page reuse", async () => {
    const { root, plans } = await fixture();
    const path = await photo(root, "scene");
    await put(root, "src/styles/photos.css", ".jwc-photo--team { background-image:url('../assets/images/scene.png'); }");
    await put(root, plans[0]!.path, '<div class="jwc-photo--team"></div>');
    await put(root, plans[1]!.path, "<?php $jw_photo('team', 'scene'); ?>");
    const registry: AssetRegistry = { schemaVersion: 1, photos: [{ path, origin: "scene", owner: "home-1", sha256: sha256(await readFile(join(root, path))) }] };
    const sources = await inspectSources(root, plans);
    expect([...sources[1]!.media]).toEqual([path]);
    const codes = (await inspectMedia(root, registry, sources)).map(item => item.code);
    expect(codes).toContain("PHOTO_REUSE"); expect(codes).toContain("PHOTO_OWNER");
  });
  test("detects renamed, recompressed and declared cropped derivatives", async () => {
    const { root, plans } = await fixture();
    const path = await photo(root, "original");
    const renamed = "src/assets/images/renamed.png";
    const recompressed = "src/assets/images/recompressed.webp";
    const cropped = "src/assets/images/cropped.png";
    await cp(join(root, path), join(root, renamed));
    await sharp(join(root, path)).webp({ quality: 90 }).toFile(join(root, recompressed));
    await sharp(join(root, path)).extract({ left: 15, top: 10, width: 70, height: 50 }).toFile(join(root, cropped));
    expect(similar(await imageFingerprint(join(root, path)), await imageFingerprint(join(root, renamed)))).toBe(true);
    expect(similar(await imageFingerprint(join(root, path)), await imageFingerprint(join(root, recompressed)))).toBe(true);
    const paths = [path, renamed, recompressed, cropped];
    for (const [index, asset] of paths.entries()) await put(root, plans[index]!.path, `<img src="../${asset}">`);
    // Paths here are relative to src/php. Supply discovered media explicitly to isolate the origin rule.
    const sources = await inspectSources(root, plans);
    for (const [index, asset] of paths.entries()) sources[index]!.media = new Set([asset]);
    const registry: AssetRegistry = { schemaVersion: 1, photos: await Promise.all(paths.map(async (asset, index) => ({ path: asset, origin: "same-original", owner: plans[index]!.id, sha256: sha256(await readFile(join(root, asset))) }))) };
    expect((await inspectMedia(root, registry, sources)).filter(item => item.code === "PHOTO_DERIVATIVE").length).toBe(6);
  });
  test("unregistered, changed and dynamic remote photos fail closed", async () => {
    const { root, plans } = await fixture();
    const path = await photo(root, "scene");
    await put(root, plans[0]!.path, '<img src="https://example.com/a.jpg"><img src="<?php echo $photo; ?>">');
    const sources = await inspectSources(root, plans);
    sources[0]!.media.add(path);
    expect((await inspectMedia(root, { schemaVersion: 1, photos: [] }, sources)).some(item => item.code === "UNREGISTERED_PHOTO")).toBe(true);
    expect(sources[0]!.failures.some(item => item.code === "UNRESOLVED_MEDIA")).toBe(true);
    expect((await inspectMedia(root, { schemaVersion: 1, photos: [{ path, origin: "scene", owner: "home-1", sha256: "0".repeat(64) }] }, sources)).some(item => item.code === "PHOTO_CHANGED")).toBe(true);
  });
  test("versioned script URLs are not images while dynamic image URLs still fail", async () => {
    const { root, plans } = await fixture();
    await put(root, plans[0]!.path, '<script type="module" src="<?php echo $js_url; ?>"></script><img src="<?php echo $photo; ?>">');
    const sources = await inspectSources(root, plans);
    expect(sources[0]!.failures.filter(item => item.code === "UNRESOLVED_MEDIA")).toHaveLength(1);
  });
  test("rejects evidence and input symlink escapes", async () => {
    const { root } = await fixture();
    await symlink("/etc/hosts", join(root, "src/escape"));
    await expect(inputDigest(root)).rejects.toThrow("symlink");
  });
  test("release cannot pass with remaining scaffold pages", async () => {
    const { root } = await fixture();
    const result = await checkQuality(root, "release");
    expect(result.pages).toBe(77); expect(result.failures.filter(item => item.code === "SCAFFOLD")).toHaveLength(70);
  });
  test("reclassifying delivered pages as scaffolds cannot remove them from current checks", async () => {
    const { root } = await fixture();
    const result = await checkQuality(root);
    expect(result.pages).toBe(23);
    expect(result.failures.some(item => item.code === "SCAFFOLD" && item.target === "company-overview-1")).toBe(true);
  });
});
