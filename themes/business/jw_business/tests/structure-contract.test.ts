import { mkdtemp, mkdir, rm, writeFile } from "node:fs/promises";
import { join } from "node:path";
import { tmpdir } from "node:os";
import { afterEach, describe, expect, test } from "bun:test";
import { collectStructureViolations } from "../scripts/check-structure";

const temporaryRoots: string[] = [];

function header(file: string, role: string): string {
  return `<?php
/**
 * Theme: JW-Business 1.0
 * File: ${file}
 * Role: ${role}
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT
 * License: JW SOFT Commercial License
 */
`;
}

function home(file: string): string {
  return `${header(file, "완성형 홈")}
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit;
include_once G5_THEME_PATH.'/head.php';
?>
<section class="home"><h1>홈</h1></section>
<?php include_once G5_THEME_PATH.'/tail.php';
`;
}

function page(file: string): string {
  return `${header(`pages/${file}`, "완성형 일반 페이지")}
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '회사소개';
include_once G5_THEME_PATH.'/head.php';
?>
<article><h1>회사소개</h1></article>
<?php include_once G5_THEME_PATH.'/tail.php';
`;
}

async function fixture(): Promise<string> {
  const root = await mkdtemp(join(tmpdir(), "jw-business-structure-"));
  temporaryRoots.push(root);
  await mkdir(join(root, "src/php/inc"), { recursive: true });
  await mkdir(join(root, "pages"), { recursive: true });
  await mkdir(join(root, "docs"), { recursive: true });
  await mkdir(join(root, "LICENSES"), { recursive: true });

  await writeFile(join(root, "docs/BASIC-INVENTORY.json"), '{"files":[]}\n');
  await writeFile(join(root, "docs/PAGE-CATALOG.json"), JSON.stringify({
    schemaVersion: 2,
    pageTypes: [{ id: "company-overview", layouts: ["1", "2", "3", "4", "5"] }],
  }));
  await writeFile(join(root, "LICENSE.txt"), "JW SOFT Commercial License\n");
  await writeFile(join(root, "LICENSES/gnuboard5-LGPL-2.1.txt"), "LGPL-2.1\n");
  await writeFile(join(root, "src/php/readme.txt"), [
    "Theme Name: JW-Business 1.0",
    "Theme URI: https://example.com",
    "Maker: JW SOFT",
    "Maker URI: https://example.com",
    "Version: 1.0.0",
    "Detail: 테스트",
    "License: JW SOFT Commercial License",
    "License URI: LICENSE.txt",
  ].join("\n"));

  for (const file of ["index.php", "index_1.php", "index_2.php", "index_3.php", "index_4.php", "index_5.php"]) {
    await writeFile(join(root, "src/php", file), home(file));
  }
  await writeFile(join(root, "src/php/inc/menu.php"), `${header("inc/menu.php", "공통 PC 메뉴")}$menu_datas = get_menu_db(0, true);\n?>\n<nav>메뉴</nav>\n`);
  await writeFile(join(root, "src/php/inc/mobile-menu.php"), `${header("inc/mobile-menu.php", "공통 모바일 메뉴")}?>\n<nav>모바일 메뉴</nav>\n`);
  await writeFile(join(root, "src/php/head.php"), `${header("head.php", "G5 헤더")}
include G5_THEME_PATH.'/inc/menu.php';
include G5_THEME_PATH.'/inc/mobile-menu.php';
`);
  for (let variant = 1; variant <= 5; variant += 1) {
    await writeFile(join(root, `pages/company-overview-${variant}.php`), page(`company-overview-${variant}.php`));
  }
  await writeFile(join(root, "pages/index.php"), page("index.php"));
  return root;
}

afterEach(async () => {
  await Promise.all(temporaryRoots.splice(0).map((root) => rm(root, { recursive: true, force: true })));
});

describe("JW-Business structure contract", () => {
  test("accepts complete home/page files and only approved shared menu includes", async () => {
    const violations = await collectStructureViolations(await fixture());
    expect(violations).toEqual([]);
  });

  test("rejects runtime partial directories and home fragment includes", async () => {
    const root = await fixture();
    await mkdir(join(root, "src/php/partials"), { recursive: true });
    await writeFile(join(root, "src/php/partials/home.php"), `${header("partials/home.php", "홈 조각")}?>\n<section>조각</section>\n`);
    await writeFile(join(root, "src/php/index.php"), `${home("index.php")}\n<?php include G5_THEME_PATH.'/partials/home.php';\n`);

    const codes = (await collectStructureViolations(root)).map((violation) => violation.code);
    expect(codes).toContain("RUNTIME_DIRECTORY_FORBIDDEN");
    expect(codes).toContain("VIEW_INCLUDE_FORBIDDEN");
  });

  test("allows only the exact G5 bootstrap for direct alternative-home previews", async () => {
    const root = await fixture();
    await writeFile(join(root, "src/php/index_2.php"), home("index_2.php").replace(
      "if (!defined('_GNUBOARD_')) exit;",
      "if (!defined('_GNUBOARD_')) { include_once dirname(__DIR__, 2).'/common.php'; }",
    ));
    expect(await collectStructureViolations(root)).toEqual([]);

    await writeFile(join(root, "src/php/index_2.php"), home("index_2.php").replace(
      "if (!defined('_GNUBOARD_')) exit;",
      "include_once dirname(__DIR__, 2).'/body.php';",
    ));
    const codes = (await collectStructureViolations(root)).map((violation) => violation.code);
    expect(codes).toContain("LOCAL_VIEW_INCLUDE_FORBIDDEN");
  });

  test("rejects wrapper pages that delegate their body to a theme dispatcher", async () => {
    const root = await fixture();
    await writeFile(
      join(root, "pages/company-overview-1.php"),
      "<?php\ninclude_once dirname(__DIR__).'/common.php';\n$jw_page_id = 'company-overview-1';\ninclude G5_THEME_PATH.'/pages/page.php';\n",
    );

    const codes = (await collectStructureViolations(root)).map((violation) => violation.code);
    expect(codes).toContain("FILE_HEADER_MISSING");
    expect(codes).toContain("PAGE_DISPATCHER_FORBIDDEN");
    expect(codes).toContain("PAGE_HEAD_MISSING");
    expect(codes).toContain("PAGE_TAIL_MISSING");
  });

  test("rejects unapproved shared include files", async () => {
    const root = await fixture();
    await writeFile(join(root, "src/php/inc/card.php"), `${header("inc/card.php", "카드 조각")}?>\n<div>카드</div>\n`);

    const codes = (await collectStructureViolations(root)).map((violation) => violation.code);
    expect(codes).toContain("SHARED_INCLUDE_FILE_FORBIDDEN");
  });

  test("rejects custom navigation that bypasses the G5 menu database", async () => {
    const root = await fixture();
    await writeFile(join(root, "src/php/inc/menu.php"), `${header("inc/menu.php", "공통 PC 메뉴")}?>\n<nav>고정 메뉴</nav>\n`);

    const codes = (await collectStructureViolations(root)).map((violation) => violation.code);
    expect(codes).toContain("G5_MENU_SOURCE_MISSING");
  });

  test("rejects build code that regenerates dispatcher wrappers", async () => {
    const root = await fixture();
    await mkdir(join(root, "scripts"), { recursive: true });
    await writeFile(join(root, "scripts/build-payload.ts"), "function buildPageRoutes() { return \"$jw_page_id\"; }\n");

    const codes = (await collectStructureViolations(root)).map((violation) => violation.code);
    expect(codes).toContain("PAGE_WRAPPER_GENERATOR_FORBIDDEN");
  });
});
