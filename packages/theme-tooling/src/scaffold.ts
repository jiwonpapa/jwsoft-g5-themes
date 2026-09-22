import { access, mkdir, readFile, rm, writeFile } from "node:fs/promises";
import { join, resolve } from "node:path";

import { validateContractFile, validateRepository } from "../../theme-contracts/src/contracts";
import { buildThemeTokens } from "../../theme-tokens/src/build";

const slugPattern = /^[a-z][a-z0-9]*(?:-[a-z0-9]+)*$/;
const themeSlugPattern = /^[a-z][a-z0-9]*(?:[-_][a-z0-9]+)*$/;

export interface ScaffoldOptions {
  repoRoot: string;
  category: string;
  slug: string;
  name: string;
  industry: string;
  youngcart: "excluded" | "optional" | "included";
  tokensFile: string;
}

function assertText(value: string, name: string): void {
  if (!value.trim()) throw new Error(`${name} is required`);
}

function themeAgents(options: ScaffoldOptions): string {
  return `# ${options.name} 작업 지침

항상 존댓말을 사용하고 사용자를 \`형님\`이라고 부릅니다. 결과와 영향을 먼저 간결하게 보고합니다.

## 확정된 상품 경계

- slug: \`${options.slug}\`
- 분류: \`${options.category}\`
- 업종: ${options.industry}
- 영카트: \`${options.youngcart}\`
- 상태: 상품 조사와 디자인 승인이 필요한 초안

## 작업 순서

1. 저장소 루트 \`AGENTS.md\`
2. \`docs/START-HERE.md\`
3. \`docs/standards/G5-THEME-PLATFORM-STANDARD.md\`
4. 이 파일과 \`PRODUCT.md\`
5. 요청에 직접 관련된 파일

## 구현 규칙

- G5 코어와 DB schema를 수정하지 않습니다.
- 이 테마는 다른 테마와 독립 설치·업데이트돼야 합니다.
- \`tokens/theme.tokens.json\`만 직접 고치고 \`generated/\`는 다시 생성합니다.
- PRODUCT.md의 미확정 항목과 디자인 방향을 추측해 구현하지 않습니다.
- 공통 코드는 두 테마에서 재사용이 확인된 뒤에만 루트 package 후보로 올립니다.
- 고객 서버에는 Bun, Node.js, Vite, Tailwind를 요구하지 않습니다.
- 실제 G5의 PC·모바일, 로그인 상태와 적용 화면을 확인하기 전 완료로 보고하지 않습니다.
- Impeccable은 수동 경고 검사이며 token, 승인 시안과 실제 화면보다 우선하지 않습니다.

## 표준 명령

\`\`\`bash
bun run --filter @jwsoft/theme-${options.slug} tokens:build
bun run --filter @jwsoft/theme-${options.slug} tokens:check
\`\`\`
`;
}

function productBrief(options: ScaffoldOptions): string {
  return `# ${options.name} 상품 계약

- 상태: 조사 전 초안
- 업종: ${options.industry}
- 영카트: ${options.youngcart}
- 제품 형태: 그누보드5 설치형 독립 테마

## 확정할 항목

- 실제 운영자와 방문자
- 방문자가 가장 먼저 해야 할 행동
- 페이지·메뉴·게시판·회원 화면 범위
- 실제 업종 사이트 분석 결과와 차별점
- 데모 콘텐츠와 자산 출처
- 판매 문구, 지원 G5 범위와 출시 버전

관리자 페이지 빌더, 고객별 콘텐츠 입력, 에디터·예약·업로더 plugin은 이 상품 범위에 넣지 않습니다.
`;
}

function manifest(options: ScaffoldOptions): Record<string, unknown> {
  return {
    $schema: "../../../packages/theme-contracts/schemas/theme-manifest.schema.json",
    schemaVersion: 1,
    slug: options.slug,
    name: options.name,
    version: "0.1.0",
    category: options.category,
    support: {
      gnuboard5: ">=5.6.391 <5.7.0",
      php: ["8.3", "8.4", "8.5"],
      youngcart: options.youngcart
    },
    entries: {
      php: ["src/php/head.php"],
      css: ["src/styles/theme.css"],
      js: ["src/scripts/theme.ts"]
    },
    surfaces: ["home"],
    modules: [],
    workspacePackages: ["@jwsoft/theme-tokens"],
    externalLibraries: [],
    manifests: {
      assets: "ASSET-MANIFEST.json",
      designReference: "DESIGN-REFERENCE.json",
      release: "RELEASE-MANIFEST.json"
    },
    build: {
      sourceDir: "src",
      payloadDir: "theme",
      zipAllowlist: ["theme/**", "ASSET-MANIFEST.json", "LICENSE.txt", "LICENSES/**", "THIRD_PARTY_NOTICES.md"]
    },
    manual: {
      path: "docs/manual",
      versioned: true
    }
  };
}

async function writeJson(path: string, value: unknown): Promise<void> {
  await writeFile(path, `${JSON.stringify(value, null, 2)}\n`);
}

export async function scaffoldTheme(options: ScaffoldOptions): Promise<string> {
  if (!slugPattern.test(options.category)) throw new Error("category must be a lowercase kebab-case slug");
  if (!themeSlugPattern.test(options.slug)) throw new Error("slug must use lowercase letters, numbers, hyphens or underscores");
  assertText(options.name, "name");
  assertText(options.industry, "industry");

  const repoRoot = resolve(options.repoRoot);
  const sourceTokens = resolve(options.tokensFile);
  const tokenFailures = await validateContractFile(sourceTokens);
  if (tokenFailures.length) throw new Error(`token source is invalid: ${tokenFailures.map((item) => item.message).join("; ")}`);

  const existingFailures = await validateRepository(repoRoot);
  if (existingFailures.length) {
    throw new Error(`repository contracts must pass before scaffolding: ${existingFailures[0]?.message}`);
  }

  const themeRoot = join(repoRoot, "themes", options.category, options.slug);
  try {
    await access(themeRoot);
    throw new Error(`theme already exists: ${themeRoot}`);
  } catch (error) {
    if ((error as NodeJS.ErrnoException).code !== "ENOENT") throw error;
  }

  let created = false;
  try {
    await mkdir(themeRoot, { recursive: true });
    created = true;
    const directories = [
      ".impeccable/surfaces",
      "docs/manual",
      "generated",
      "src/assets",
      "src/php",
      "src/scripts",
      "src/styles",
      "tests",
      "theme",
      "tokens",
      "LICENSES"
    ];
    await Promise.all(directories.map((directory) => mkdir(join(themeRoot, directory), { recursive: true })));

    const tokenDocument = JSON.parse(await readFile(sourceTokens, "utf8"));
    tokenDocument.$schema = "../../../../packages/theme-contracts/schemas/theme-tokens.schema.json";

    await Promise.all([
      writeFile(join(themeRoot, "AGENTS.md"), themeAgents(options)),
      writeFile(join(themeRoot, "PRODUCT.md"), productBrief(options)),
      writeFile(join(themeRoot, "CHANGELOG.md"), `# 변경 기록\n\n## 0.1.0\n\n- 테마 개발 골격 생성\n`),
      writeFile(join(themeRoot, "THIRD_PARTY_NOTICES.md"), "# Third-party notices\n\n배포 자산을 추가할 때 라이선스와 출처를 기록합니다.\n"),
      writeFile(join(themeRoot, "src/php/head.php"), "<?php\nif (!defined('_GNUBOARD_')) {\n    exit;\n}\n"),
      writeFile(join(themeRoot, "src/styles/theme.css"), "@import \"../../generated/tokens.css\";\n@import \"../../generated/tailwind-theme.css\";\n"),
      writeFile(join(themeRoot, "src/scripts/theme.ts"), "export function initializeTheme(): void {\n  // Behaviors are registered explicitly by each G5 entry point.\n}\n"),
      writeFile(join(themeRoot, ".impeccable/surfaces/.gitkeep"), ""),
      writeFile(join(themeRoot, "docs/manual/.gitkeep"), ""),
      writeFile(join(themeRoot, "src/assets/.gitkeep"), ""),
      writeFile(join(themeRoot, "tests/.gitkeep"), ""),
      writeFile(join(themeRoot, "theme/.gitkeep"), ""),
      writeFile(join(themeRoot, "LICENSES/.gitkeep"), ""),
      writeJson(join(themeRoot, "theme.manifest.json"), manifest(options)),
      writeJson(join(themeRoot, "ASSET-MANIFEST.json"), {
        $schema: "../../../packages/theme-contracts/schemas/asset-manifest.schema.json",
        schemaVersion: 1,
        theme: options.slug,
        assets: []
      }),
      writeJson(join(themeRoot, "DESIGN-REFERENCE.json"), {
        $schema: "../../../packages/theme-contracts/schemas/design-reference.schema.json",
        schemaVersion: 1,
        theme: options.slug,
        provider: "local",
        frames: {},
        status: "draft"
      }),
      writeJson(join(themeRoot, "package.json"), {
        name: `@jwsoft/theme-${options.slug}`,
        version: "0.1.0",
        private: true,
        type: "module",
        scripts: {
          "tokens:build": "bun run ../../../packages/theme-tokens/src/cli.ts build tokens/theme.tokens.json generated",
          "tokens:check": "bun run ../../../packages/theme-tokens/src/cli.ts check tokens/theme.tokens.json generated"
        },
        dependencies: {
          "@jwsoft/theme-tokens": "workspace:*"
        }
      }),
      writeJson(join(themeRoot, "tokens/theme.tokens.json"), tokenDocument)
    ]);

    await buildThemeTokens(join(themeRoot, "tokens/theme.tokens.json"), join(themeRoot, "generated"));
    const finalFailures = await validateRepository(repoRoot);
    if (finalFailures.length) throw new Error(finalFailures.map((item) => `${item.file}: ${item.message}`).join("\n"));
    return themeRoot;
  } catch (error) {
    if (created) await rm(themeRoot, { recursive: true, force: true });
    throw error;
  }
}
