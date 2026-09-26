import { readFile } from "node:fs/promises";
import { dirname, posix } from "node:path";
import { load } from "cheerio";
import sharp from "sharp";
import { safeFile, sha256, walk } from "./files";
import type { AssetRegistry, Failure, PagePlan } from "./model";

export const withoutPhp = (source: string): string => source.replace(/<\?[\s\S]*?\?>/g, "").replace(/<!--[\s\S]*?-->/g, "");
const raster = /\.(?:avif|webp|png|jpe?g|gif)(?:[?#].*)?$/i;
export interface PageSource { plan: PagePlan; source: string; body: string; media: Set<string>; failures: Failure[] }

export async function inspectSources(root: string, plans: PagePlan[]): Promise<PageSource[]> {
  const cssFiles = (await walk(root, "src/styles")).filter(path => path.endsWith(".css"));
  const rules: Array<{ selector: string; media: string }> = [];
  for (const file of cssFiles) {
    const css = (await readFile(await safeFile(root, file), "utf8")).replace(/\/\*[\s\S]*?\*\//g, "");
    for (const rule of css.matchAll(/([^{}]+)\{([^{}]*)\}/g)) {
      for (const url of rule[2]!.matchAll(/url\(\s*['"]?([^'"\s)]+)['"]?\s*\)/g)) {
        if (!raster.test(url[1]!)) continue;
        rules.push({ selector: rule[1]!.trim(), media: /^(?:https?:|data:|\/)/.test(url[1]!) ? url[1]! : posix.normalize(posix.join(dirname(file), url[1]!)) });
      }
    }
  }
  const result: PageSource[] = [];
  for (const plan of plans) {
    const source = await readFile(await safeFile(root, plan.path), "utf8");
    const stripped = withoutPhp(source);
    const $ = load(`<html class="jw-theme" data-theme="jw-light"><body class="jw-theme">${stripped}</body></html>`);
    // Existing PHP photo helper is explicitly understood. Unknown dynamic sources
    // remain blocked until rendered media inventory is supplied and reviewed.
    for (const match of source.matchAll(/(?:\$jw_photo\s*\(|array\s*\()\s*['"](campus|team|workspace)['"]/g)) {
      $("body").append(`<div class="jwc-photo jwc-photo--${match[1]}"></div>`);
    }
    const media = new Set<string>();
    const failures: Failure[] = [];
    const add = (path: string) => {
      const normalized = path.split(/[?#]/)[0]!;
      if (!normalized.startsWith("src/assets/")) failures.push({ code: "UNRESOLVED_MEDIA", target: plan.id, message: `본문 이미지의 원본 경로를 확인할 수 없습니다: ${path}` });
      else media.add(normalized);
    };
    for (const rule of rules) {
      // Match the last compound as well: outer G5 containers are absent in PHP source.
      const selectors = rule.selector.split(",").map(s => s.trim().replace(/::[\w-]+/g, "").replace(/:(?:hover|focus-visible|focus|active)/g, ""));
      for (const selector of selectors) {
        try {
          if ($(selector).length || $(selector.split(/\s+|\s*>\s*/).at(-1)!).length) { add(rule.media); break; }
        } catch { failures.push({ code: "UNRESOLVED_CSS_MEDIA", target: plan.id, message: `이미지 선택자를 해석할 수 없습니다: ${selector}` }); }
      }
    }
    for (const match of source.matchAll(/(?:src|srcset|poster)\s*=\s*(["'])([\s\S]*?)\1|url\(\s*['"]?([^'"\s)]+)/g)) {
      let value = match[2] ?? match[3] ?? "";
      value = value.replace(/<\?php\s+echo\s+G5_THEME_URL\s*;?\s*\?>/g, "@theme");
      for (const candidate of value.split(",")) {
        const path = candidate.trim().split(/\s+/)[0]!;
        if (!path || (!raster.test(path) && !path.includes("<?"))) continue;
        if (path.startsWith("@theme/assets/")) add(`src/${path.slice(7)}`);
        else if (path.startsWith("src/assets/")) add(path);
        else if (!path.includes("<?") && !/^(https?:|data:|\/)/.test(path)) add(posix.normalize(posix.join(dirname(plan.path), path)));
        else add(path);
      }
    }
    result.push({ plan, source, body: stripped, media, failures });
  }
  return result;
}

export async function imageFingerprint(file: string): Promise<{ hash: string; pixels: string; gradient: string; samples: number[] }> {
  const bytes = await readFile(file);
  const pixels = await sharp(bytes).rotate().removeAlpha().resize(32, 32, { fit: "fill" }).raw().toBuffer();
  const gray = await sharp(bytes).rotate().flatten({ background: "white" }).greyscale().resize(9, 8, { fit: "fill" }).raw().toBuffer();
  let gradient = "";
  for (let y = 0; y < 8; y++) for (let x = 0; x < 8; x++) gradient += gray[y * 9 + x]! > gray[y * 9 + x + 1]! ? "1" : "0";
  const samples = [...await sharp(bytes).rotate().flatten({ background: "white" }).greyscale().resize(16, 16, { fit: "fill" }).raw().toBuffer()];
  return { hash: sha256(bytes), pixels: sha256(pixels), gradient, samples };
}
export function similar(a: Awaited<ReturnType<typeof imageFingerprint>>, b: Awaited<ReturnType<typeof imageFingerprint>>): boolean {
  if (a.hash === b.hash || a.pixels === b.pixels) return true;
  const distance = [...a.gradient].filter((bit, i) => bit !== b.gradient[i]).length;
  // dHash alone gives false matches for flat images; require tonal agreement too.
  const error = a.samples.reduce((sum, value, i) => sum + Math.abs(value - b.samples[i]!), 0) / a.samples.length;
  return distance <= 7 && error <= 18;
}

export async function inspectMedia(root: string, registry: AssetRegistry, pages: PageSource[]): Promise<Failure[]> {
  const failures: Failure[] = [];
  const records = new Map(registry.photos.map(record => [record.path, record]));
  if (records.size !== registry.photos.length) failures.push({ code: "ASSET_REGISTRY", target: "quality/assets.json", message: "중복 자산 경로가 있습니다." });
  const usage = new Map<string, Set<string>>();
  for (const page of pages) {
    failures.push(...page.failures);
    for (const path of page.media) {
      if (!usage.has(path)) usage.set(path, new Set());
      usage.get(path)!.add(page.plan.id);
    }
  }
  const fingerprints = new Map<string, Awaited<ReturnType<typeof imageFingerprint>>>();
  for (const [path, users] of usage) {
    const record = records.get(path);
    if (!record) failures.push({ code: "UNREGISTERED_PHOTO", target: path, message: `원본·사용 페이지 미등록: ${[...users].join(", ")}` });
    try {
      const fingerprint = await imageFingerprint(await safeFile(root, path));
      fingerprints.set(path, fingerprint);
      if (record && record.sha256 !== fingerprint.hash) failures.push({ code: "PHOTO_CHANGED", target: path, message: "등록 이후 이미지 내용이 바뀌었습니다." });
    } catch (error) { failures.push({ code: "PHOTO_FILE", target: path, message: String(error) }); }
    if (users.size > 1) failures.push({ code: "PHOTO_REUSE", target: path, message: `페이지 간 사진 재사용: ${[...users].join(", ")}` });
    if (record && [...users].some(id => id !== record.owner)) failures.push({ code: "PHOTO_OWNER", target: path, message: `허용 페이지는 ${record.owner}입니다. 실제: ${[...users].join(", ")}` });
  }
  const paths = [...usage.keys()];
  for (let i = 0; i < paths.length; i++) for (let j = i + 1; j < paths.length; j++) {
    const a = paths[i]!, b = paths[j]!;
    if (new Set([...usage.get(a)!, ...usage.get(b)!]).size < 2) continue;
    const first = fingerprints.get(a), second = fingerprints.get(b);
    if ((records.get(a)?.origin && records.get(a)!.origin === records.get(b)?.origin) || (first && second && similar(first, second))) {
      failures.push({ code: "PHOTO_DERIVATIVE", target: `${a} / ${b}`, message: "동일 원본 또는 유사 이미지의 페이지 간 재사용입니다. 확인 전 통과할 수 없습니다." });
    }
  }
  return failures;
}
