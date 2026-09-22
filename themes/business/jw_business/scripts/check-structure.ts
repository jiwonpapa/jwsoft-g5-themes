import { createHash } from "node:crypto";
import { readFile, readdir, stat } from "node:fs/promises";
import { join, relative, resolve, sep } from "node:path";

export type StructureViolation = {
  code: string;
  path: string;
  message: string;
};

const HOME_VARIANTS = [1, 2, 3, 4, 5].map((variant) => `index_${variant}.php`);
const FORBIDDEN_RUNTIME_DIRECTORIES = ["blocks", "pages", "partials", "sections"];
const ALLOWED_SHARED_INCLUDES = new Map<string, Set<string>>([
  ["inc/menu.php", new Set(["head.php", "mobile/head.php"])],
  ["inc/mobile-menu.php", new Set(["head.php", "mobile/head.php"])],
  ["skin/member/basic/certification.php", new Set(["skin/member/basic/password_lost.skin.php", "skin/member/basic/register_form.skin.php"])],
  ["skin/member/basic/steps.php", new Set(["skin/member/basic/register.skin.php", "skin/member/basic/register_form.skin.php", "skin/member/basic/register_result.skin.php"])],
  ["skin/qa/basic/attachments.php", new Set(["skin/qa/basic/view.skin.php", "skin/qa/basic/view.answer.skin.php"])],
  ["skin/qa/basic/form.fields.php", new Set(["skin/qa/basic/write.skin.php", "skin/qa/basic/view.answerform.skin.php"])],
]);
const NATIVE_THEME_INCLUDES = new Set([
  "head.php",
  "head.sub.php",
  "tail.php",
  "tail.sub.php",
]);

function portablePath(path: string): string {
  return path.split(sep).join("/");
}

function sha256(source: string): string {
  return createHash("sha256").update(source).digest("hex");
}

async function exists(path: string): Promise<boolean> {
  return (await stat(path).catch(() => null)) !== null;
}

async function walkFiles(root: string): Promise<string[]> {
  const entries = await readdir(root, { withFileTypes: true }).catch(() => []);
  const files: string[] = [];
  for (const entry of entries.sort((left, right) => left.name.localeCompare(right.name))) {
    const path = join(root, entry.name);
    if (entry.isDirectory()) files.push(...await walkFiles(path));
    else if (entry.isFile()) files.push(path);
  }
  return files;
}

function hasFileHeader(source: string): boolean {
  const header = source.slice(0, 2400);
  return [
    /Theme:\s*JW-Business 1\.0/i,
    /File:\s*\S+/i,
    /Role:\s*\S+/i,
    /(?:Author|Original):\s*\S+/i,
    /Copyright:\s*\S+/i,
    /License:\s*\S+/i,
  ].every((pattern) => pattern.test(header));
}

function hasThemeInclude(source: string, target: "head.php" | "tail.php"): boolean {
  const pattern = new RegExp(`G5_THEME_PATH\\s*\\.\\s*['\"]/${target.replace(".", "\\.")}['\"]`);
  return pattern.test(source);
}

function hasPageBody(source: string): boolean {
  return /<(?:article|div|header|main|section)\b/i.test(source);
}

function includeExpressions(source: string): string[] {
  const expressions: string[] = [];
  const pattern = /\b(?:include|include_once|require|require_once)\b\s*\(?\s*([^;\n]+?)\s*\)?\s*;/g;
  for (const match of source.matchAll(pattern)) {
    if (match[1]) expressions.push(match[1].trim());
  }
  return expressions;
}

function literalThemeTarget(expression: string): string | null {
  const match = expression.match(/G5_THEME_PATH\s*\.\s*['\"]\/([^'\"]+)['\"]/);
  return match?.[1] ?? null;
}

function checkRuntimeIncludes(path: string, source: string, violations: StructureViolation[]): void {
  for (const expression of includeExpressions(source)) {
    const target = literalThemeTarget(expression);
    if (target) {
      if (FORBIDDEN_RUNTIME_DIRECTORIES.some((directory) => target.startsWith(`${directory}/`))) {
        violations.push({
          code: "VIEW_INCLUDE_FORBIDDEN",
          path,
          message: `페이지·블록 조각을 런타임 include할 수 없습니다: ${target}`,
        });
        continue;
      }

      const sharedConsumers = ALLOWED_SHARED_INCLUDES.get(target);
      if (sharedConsumers) {
        if (!sharedConsumers.has(path)) {
          violations.push({
            code: "SHARED_INCLUDE_CONSUMER_FORBIDDEN",
            path,
            message: `${target}는 명시된 실제 공용 소비 파일에서만 사용할 수 있습니다`,
          });
        }
        continue;
      }

      if (target.startsWith("inc/")) {
        if (!ALLOWED_SHARED_INCLUDES.has(target)) {
          violations.push({
            code: "SHARED_INCLUDE_NOT_ALLOWED",
            path,
            message: `허용 목록에 없는 공통 include입니다: ${target}`,
          });
        }
        continue;
      }

      const isG5Skin = target.startsWith("skin/") && /\.skin(?:\.\d+)?\.php$/.test(target);
      if (target.startsWith("lib/") || NATIVE_THEME_INCLUDES.has(target) || isG5Skin) {
        continue;
      }

      violations.push({
        code: "THEME_INCLUDE_NOT_ALLOWED",
        path,
        message: `테마 내부 PHP include는 명시된 공통 메뉴·순수 lib·G5 기본 파일만 허용합니다: ${target}`,
      });
      continue;
    }

    if (/^\$jw_(?:partial|page|route)/.test(expression)) {
      violations.push({
        code: "DYNAMIC_VIEW_INCLUDE_FORBIDDEN",
        path,
        message: `동적 화면 include를 사용할 수 없습니다: ${expression}`,
      });
    }

    const isRootBootstrap = /dirname\(__DIR__\)\s*\.\s*['\"]\/common\.php['\"]/.test(expression)
      || (HOME_VARIANTS.includes(path) && expression === "dirname(__DIR__, 2).'/common.php'");
    if (expression.includes("__DIR__") && !expression.includes(".skin.php") && !isRootBootstrap) {
      violations.push({
        code: "LOCAL_VIEW_INCLUDE_FORBIDDEN",
        path,
        message: `로컬 화면 조각 include를 사용할 수 없습니다: ${expression}`,
      });
    }
  }
}

function checkCompleteHome(path: string, source: string, violations: StructureViolation[]): void {
  if (!/define\s*\(\s*['\"]_INDEX_['\"]/.test(source)) {
    violations.push({ code: "HOME_INDEX_FLAG_MISSING", path, message: "홈 파일은 _INDEX_를 선언해야 합니다" });
  }
  if (!hasThemeInclude(source, "head.php")) {
    violations.push({ code: "HOME_HEAD_MISSING", path, message: "홈 파일이 테마 head.php를 직접 불러야 합니다" });
  }
  if (!hasThemeInclude(source, "tail.php")) {
    violations.push({ code: "HOME_TAIL_MISSING", path, message: "홈 파일이 테마 tail.php를 직접 불러야 합니다" });
  }
  if (!hasPageBody(source)) {
    violations.push({ code: "HOME_BODY_MISSING", path, message: "홈 파일 안에 완성된 본문 마크업이 있어야 합니다" });
  }
}

function checkCompleteRootPage(path: string, source: string, violations: StructureViolation[]): void {
  if (!/(?:include_once|require_once)\s*\(?\s*dirname\(__DIR__\)\s*\.\s*['\"]\/common\.php['\"]/.test(source)) {
    violations.push({ code: "PAGE_COMMON_MISSING", path, message: "웹루트 페이지가 ../common.php를 직접 불러야 합니다" });
  }
  if (!/\$g5\s*\[\s*['\"]title['\"]\s*\]\s*=/.test(source)) {
    violations.push({ code: "PAGE_TITLE_MISSING", path, message: "웹루트 페이지가 자신의 $g5['title']을 선언해야 합니다" });
  }
  if (!hasThemeInclude(source, "head.php")) {
    violations.push({ code: "PAGE_HEAD_MISSING", path, message: "웹루트 페이지가 테마 head.php를 직접 불러야 합니다" });
  }
  if (!hasThemeInclude(source, "tail.php")) {
    violations.push({ code: "PAGE_TAIL_MISSING", path, message: "웹루트 페이지가 테마 tail.php를 직접 불러야 합니다" });
  }
  if (!hasPageBody(source)) {
    violations.push({ code: "PAGE_BODY_MISSING", path, message: "웹루트 페이지 안에 완성된 본문 마크업이 있어야 합니다" });
  }
  if (/\$jw_page_id\b|G5_THEME_PATH\s*\.\s*['\"]\/pages\//.test(source)) {
    violations.push({ code: "PAGE_DISPATCHER_FORBIDDEN", path, message: "공통 page dispatcher로 넘기는 wrapper 페이지는 금지합니다" });
  }

  for (const expression of includeExpressions(source)) {
    if (!expression.includes("G5_THEME_PATH")) continue;
    const target = literalThemeTarget(expression);
    if (target !== "head.php" && target !== "tail.php") {
      violations.push({
        code: "PAGE_THEME_INCLUDE_FORBIDDEN",
        path,
        message: `웹루트 페이지는 테마 head.php와 tail.php 외의 화면 파일을 include할 수 없습니다: ${target ?? expression}`,
      });
    }
  }
}

function checkReadme(source: string, violations: StructureViolation[]): void {
  const required = [
    "Theme Name:",
    "Theme URI:",
    "Maker:",
    "Maker URI:",
    "Version:",
    "Detail:",
    "License:",
    "License URI:",
  ];
  const lines = source.split(/\r?\n/).filter((line) => line.trim() !== "");
  for (let index = 0; index < required.length; index += 1) {
    if (!lines[index]?.startsWith(required[index]!)) {
      violations.push({
        code: "README_FIELD_ORDER_INVALID",
        path: "src/php/readme.txt",
        message: `${index + 1}번째 줄은 ${required[index]} 형식이어야 합니다`,
      });
    }
  }
}

export async function collectStructureViolations(themeRootInput: string): Promise<StructureViolation[]> {
  const themeRoot = resolve(themeRootInput);
  const sourceRoot = join(themeRoot, "src/php");
  const pagesRoot = join(themeRoot, "pages");
  const violations: StructureViolation[] = [];

  for (const directory of FORBIDDEN_RUNTIME_DIRECTORIES) {
    const directoryPath = join(sourceRoot, directory);
    const files = await walkFiles(directoryPath);
    if (files.length > 0) {
      violations.push({
        code: "RUNTIME_DIRECTORY_FORBIDDEN",
        path: `src/php/${directory}`,
        message: `런타임 테마에 ${directory}/ 디렉터리를 둘 수 없습니다. 블록은 저장소의 blocks/에서 복사만 합니다`,
      });
    }
  }

  const incRoot = join(sourceRoot, "inc");
  for (const file of await walkFiles(incRoot)) {
    const target = `inc/${portablePath(relative(incRoot, file))}`;
    if (!ALLOWED_SHARED_INCLUDES.has(target)) {
      violations.push({ code: "SHARED_INCLUDE_FILE_FORBIDDEN", path: `src/php/${target}`, message: "허용되지 않은 공통 include 파일입니다" });
    }
  }

  const inventoryPath = join(themeRoot, "docs/BASIC-INVENTORY.json");
  const inventory = await readFile(inventoryPath, "utf8")
    .then((source) => JSON.parse(source) as { files?: Array<{ path: string; importedSha256: string }> })
    .catch(() => ({ files: [] }));
  const importedHashes = new Map((inventory.files ?? []).map((file) => [file.path, file.importedSha256]));

  const sourcePhpFiles = (await walkFiles(sourceRoot)).filter((file) => file.endsWith(".php"));
  for (const file of sourcePhpFiles) {
    const path = portablePath(relative(sourceRoot, file));
    const source = await readFile(file, "utf8");
    const importedHash = importedHashes.get(path);
    if ((!importedHash || importedHash !== sha256(source)) && !hasFileHeader(source)) {
      violations.push({
        code: "FILE_HEADER_MISSING",
        path: `src/php/${path}`,
        message: "JW 작성·수정 PHP에는 Theme, File, Role, Author 또는 Original, Copyright, License 헤더가 필요합니다",
      });
    }
    if (/(?:^|\/)navigation\.php$/.test(path) || /jw_business_navigation|custom\/navigation\.php/.test(source)) {
      violations.push({
        code: "CUSTOM_NAVIGATION_SOURCE_FORBIDDEN",
        path: `src/php/${path}`,
        message: "별도 navigation catalog를 둘 수 없습니다. 공개 메뉴는 G5 관리자 메뉴 DB를 사용합니다",
      });
    }
    checkRuntimeIncludes(path, source, violations);
  }

  const menuSources = await Promise.all(
    ["head.php", "mobile/head.php", "inc/menu.php", "inc/mobile-menu.php"].map((path) =>
      readFile(join(sourceRoot, path), "utf8").catch(() => ""),
    ),
  );
  if (!menuSources.some((source) => source.includes("get_menu_db("))) {
    violations.push({
      code: "G5_MENU_SOURCE_MISSING",
      path: "src/php/head.php",
      message: "공개 메뉴는 G5 관리자 메뉴 DB의 get_menu_db()를 기본 데이터 원본으로 사용해야 합니다",
    });
  }

  for (const homeFile of ["index.php", ...HOME_VARIANTS]) {
    const file = join(sourceRoot, homeFile);
    if (!(await exists(file))) {
      violations.push({ code: "HOME_VARIANT_MISSING", path: `src/php/${homeFile}`, message: "index.php와 index_1.php~index_5.php를 각각 완성형으로 제공해야 합니다" });
      continue;
    }
    checkCompleteHome(`src/php/${homeFile}`, await readFile(file, "utf8"), violations);
  }

  const pageFiles = (await walkFiles(pagesRoot)).filter((file) => file.endsWith(".php"));
  if (pageFiles.length === 0) {
    violations.push({ code: "ROOT_PAGES_MISSING", path: "pages", message: "웹루트 /pages에 완성형 일반 페이지가 필요합니다" });
  }
  for (const file of pageFiles) {
    const path = `pages/${portablePath(relative(pagesRoot, file))}`;
    const source = await readFile(file, "utf8");
    if (!hasFileHeader(source)) {
      violations.push({ code: "FILE_HEADER_MISSING", path, message: "웹루트 일반 페이지에 작성자·저작권·역할·라이선스 헤더가 필요합니다" });
    }
    checkCompleteRootPage(path, source, violations);
    checkRuntimeIncludes(path, source, violations);
  }

  const catalogPath = join(themeRoot, "docs/PAGE-CATALOG.json");
  const catalog = await readFile(catalogPath, "utf8")
    .then((source) => JSON.parse(source) as { pageTypes?: Array<{ id?: string; layouts?: string[] }> })
    .catch(() => ({ pageTypes: [] }));
  const expectedPages = new Set(["index.php"]);
  for (const pageType of catalog.pageTypes ?? []) {
    if (!pageType.id || pageType.id === "home" || !Array.isArray(pageType.layouts) || pageType.layouts.length !== 5) {
      violations.push({ code: "PAGE_CATALOG_INVALID", path: "docs/PAGE-CATALOG.json", message: "일반 페이지 유형은 home을 제외하고 각각 5개 레이아웃을 가져야 합니다" });
      continue;
    }
    for (let variant = 1; variant <= 5; variant += 1) expectedPages.add(`${pageType.id}-${variant}.php`);
  }
  const actualPages = new Set(pageFiles.map((file) => portablePath(relative(pagesRoot, file))));
  for (const expected of expectedPages) {
    if (!actualPages.has(expected)) violations.push({ code: "ROOT_PAGE_CATALOG_MISSING", path: `pages/${expected}`, message: "일반 페이지 카탈로그에 대응하는 완성형 파일이 없습니다" });
  }
  for (const actual of actualPages) {
    if (!expectedPages.has(actual)) violations.push({ code: "ROOT_PAGE_NOT_CATALOGED", path: `pages/${actual}`, message: "카탈로그에 없거나 홈으로 잘못 만든 웹루트 페이지입니다" });
  }

  const readmePath = join(sourceRoot, "readme.txt");
  if (await exists(readmePath)) checkReadme(await readFile(readmePath, "utf8"), violations);
  else violations.push({ code: "README_MISSING", path: "src/php/readme.txt", message: "G5 테마 readme.txt가 필요합니다" });

  if (!(await exists(join(themeRoot, "LICENSE.txt")))) {
    violations.push({ code: "COMMERCIAL_LICENSE_MISSING", path: "LICENSE.txt", message: "JW SOFT 상용 라이선스 파일이 필요합니다" });
  }
  if (!(await exists(join(themeRoot, "LICENSES/gnuboard5-LGPL-2.1.txt")))) {
    violations.push({ code: "UPSTREAM_LICENSE_MISSING", path: "LICENSES/gnuboard5-LGPL-2.1.txt", message: "G5 원본 LGPL 고지를 유지해야 합니다" });
  }

  const payloadBuilderPath = join(themeRoot, "scripts/build-payload.ts");
  if (await exists(payloadBuilderPath)) {
    const builder = await readFile(payloadBuilderPath, "utf8");
    if (builder.includes("buildPageRoutes") || builder.includes("$jw_page_id") || builder.includes("'/pages/page.php'")) {
      violations.push({
        code: "PAGE_WRAPPER_GENERATOR_FORBIDDEN",
        path: "scripts/build-payload.ts",
        message: "빌드는 완성형 /pages 파일을 복사해야 하며 공통 dispatcher wrapper를 생성할 수 없습니다",
      });
    }
  }

  return violations.sort((left, right) => left.path.localeCompare(right.path) || left.code.localeCompare(right.code));
}

async function main(): Promise<void> {
  const themeRoot = resolve(import.meta.dirname, "..");
  const violations = await collectStructureViolations(themeRoot);
  if (violations.length === 0) {
    console.log("JW-Business structure contract passed");
    return;
  }

  const counts = new Map<string, number>();
  for (const violation of violations) counts.set(violation.code, (counts.get(violation.code) ?? 0) + 1);
  console.error("JW-Business structure contract failed");
  const detailLimit = 30;
  for (const violation of violations.slice(0, detailLimit)) {
    console.error(`- [${violation.code}] ${violation.path}: ${violation.message}`);
  }
  if (violations.length > detailLimit) console.error(`- ... ${violations.length - detailLimit}개 추가 위반 생략`);
  console.error("위반 집계:");
  for (const [code, count] of [...counts].sort(([left], [right]) => left.localeCompare(right))) {
    console.error(`- ${code}: ${count}`);
  }
  process.exitCode = 1;
}

if (import.meta.main) await main();
