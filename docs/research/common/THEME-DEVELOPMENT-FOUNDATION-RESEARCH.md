# 반복 구현을 줄이면서 독립 상품성을 지키는 G5 테마 개발 기반 연구

- 문서 상태: 연구 완료, 기반 2단계 완료·3단계 기준 runtime 구축
- 기준일: 2026-09-20
- 대상: `jwsoft-g5-themes` 모노레포의 모든 G5·영카트5 테마
- 현재 기준 G5: 5.6.391, upstream commit `148d748c2d3fe60a536966164d1d7dbbe6f9c477`

## 결론

연구 결과에 따라 **개발 헌법, 기계 판독 계약과 공통 생성 도구를 실제 코드로 구축했습니다.** 현재 저장소에는 Bun 1.4.2 workspace, `theme-contracts`, 여섯 JSON schema, DTCG token 생성·drift 검사, 테마 scaffold, 결정론적 ZIP allowlist 조립기, 공통 후보 registry, ADR 골격과 Impeccable 보정 하네스가 있습니다.

아직 Vite/Tailwind 실제 테마 build, fixture reset·Playwright 자동화, CI와 실제 테마는 없습니다. 다만 형님의 2026-09-20 지시에 따라 Ubuntu에 G5 5.6.391·PHP 8.3.33·MySQL 8.4.11 기준 runtime을 설치하고 Mac mini의 `g5themes.test` TLS 접속과 PC·mobile·로그인·게시판 기본 화면을 확인했습니다. 판매 ZIP 설치·업데이트·롤백 자동화는 실행하지 않았으므로 전체 개발 기반이 끝난 상태는 아닙니다.

다음 다섯 층을 순서대로 구축해야 합니다.

1. **개발 헌법**: 사람이든 AI든 바꿀 수 없는 경계와 완료 정의
2. **기계 판독 계약**: 테마·토큰·자산·릴리스 manifest와 schema
3. **공통 workspace**: 빌드·검사 도구는 즉시 공통화하고, 런타임 코드는 두 번째 실제 사용에서 승격
4. **G5 하네스**: 고정된 G5/PHP/DB/브라우저에서 설치·화면·시각 회귀 검증
5. **릴리스 거버넌스**: 변경 영향 계산, 버전·변경 이력, 독립 ZIP과 근거물 생성

이 구조의 핵심은 **소스는 재사용하고 판매 ZIP은 독립적으로 만든다**는 것입니다. 공통 코드를 고객 서버의 중앙 plugin처럼 공유하지 않습니다. 각 테마 빌드가 필요한 공통 코드를 자기 ZIP 안에 포함하므로 다른 테마나 개발 도구가 없어도 설치·업데이트할 수 있어야 합니다.

## 1. 현재 문서에 반영된 것과 부족한 것

| 영역 | 현재 반영 | 남은 기반 |
| --- | --- | --- |
| 저장소 경계 | 독립 설치 원칙, manifest schema, path 경계와 ZIP allowlist 검사 | 깨끗한 판매 ZIP 설치 검사 |
| 기술 스택 | Bun 1.4.2 workspace·lockfile, 계약·token·tooling package | Vite/Tailwind build와 Ubuntu 재현 |
| 공통화 | 두 테마 승격 원칙과 후보 registry | 실제 두 테마 소비 증거와 영향 검사 |
| 디자인 토큰 | DTCG 단일 원본, semantic schema, CSS·Tailwind 생성과 drift 검사 | 실제 테마 시각 회귀 |
| 자산 | `ASSET-MANIFEST.json` schema, release 파일 hash와 ZIP 포함 여부 검사 | hash 중복 검사와 라이선스 의미 검증 |
| AI 작업 | root 헌법, package AGENTS, 테마 템플릿, scaffold 생성 AGENTS, Impeccable skill | manifest 기반 theme inventory |
| 검증 | 계약 14개, token 3개, tooling 4개 test, 디자인 detector 보정 fixture, Ubuntu G5/PHP/MySQL 기준 runtime | fixture reset과 Playwright 자동 기준본 |
| 배포 | 독립 ZIP allowlist·checksum·재압축 검증 | clean install·update·rollback 자동화 |
| 변경 관리 | ADR 언급 | 버전, changeset, 공통 변경 소비 테마 목록 |

계약 위반을 막는 첫 실행 장치는 생겼습니다. 다음 위험은 token·build 산출물 drift와 실제 G5 runtime 차이입니다.

## 2. 개발 헌법

헌법은 긴 코딩 규칙 모음이 아니라 **실수를 막는 상위 불변 조건**이어야 합니다. root `AGENTS.md`에는 아래 항목만 간결하게 두고, 상세 근거는 이 문서와 표준 문서로 연결합니다.

### 2.1 상품 불변 조건

1. 테마는 G5 코어 파일과 코어 DB schema를 수정하지 않습니다.
2. 테마 ZIP 하나만으로 독립 설치·업데이트·롤백할 수 있어야 합니다.
3. 고객 서버에는 Bun, Node.js, Composer와 source build를 요구하지 않습니다.
4. 페이지 빌더, 범용 editor·uploader, 예약·CRM·외부 계정 설정을 테마에 넣지 않습니다.
5. JavaScript가 실패해도 메뉴, 본문과 핵심 CTA는 사용할 수 있어야 합니다.
6. 지원 범위 밖 기능을 코드에 먼저 넣고 나중에 문서로 숨기지 않습니다.

### 2.2 변경 불변 조건

1. 작업 시작 전 대상 테마, 수정 파일, 완료 조건과 필수 gate를 정합니다.
2. 생성 파일을 직접 고치지 않고 원본 token·source·generator를 수정합니다.
3. 공통 package 변경은 모든 소비 테마를 식별하고 최소 smoke를 실행합니다.
4. 공통 runtime으로 옮기려면 서로 다른 두 테마에서 같은 책임과 API가 확인되어야 합니다.
5. 새 dependency는 기능 중복, 유지 상태, 라이선스, 보안, 번들, 접근성, 제거 가능성을 기록합니다.
6. 테스트 통과, 브라우저 확인, 패키지 생성과 배포를 서로 다른 증거로 보고합니다.

### 2.3 완료 불변 조건

변경은 다음 조건이 모두 충족되어야 완료입니다.

- 대상 파일의 정적 검사와 build가 통과했습니다.
- 관련 G5 화면을 실제 runtime에서 확인했습니다.
- 공통 package 변경이면 영향을 받는 테마를 검사했습니다.
- 사용자 화면 변경이면 고정 Linux browser 환경에서 시각 비교를 검토했습니다.
- 판매 파일 변경이면 깨끗한 G5에 ZIP을 설치해 확인했습니다.
- 매뉴얼, 변경 이력과 지원 범위가 실제 동작과 일치합니다.
- 실행하지 않은 검사는 완료로 표시하지 않았습니다.

이 헌법은 Markdown으로만 두지 않습니다. 가능한 항목은 manifest schema, 금지 pattern 검사, package allowlist, browser scenario와 release script로 실행 가능하게 만듭니다.

## 3. 권장 저장소 구조

```text
jwsoft-g5-themes/
├── AGENTS.md                         # 짧은 저장소 헌법과 표준 명령
├── package.json                      # Bun workspace·catalog·공통 script
├── bun.lock
├── bunfig.toml
├── composer.json                     # 개발용 PHP 검사 도구만
├── composer.lock
├── .changeset/                       # 테마·공통 package 버전 의도
├── .github/workflows/                # CI gate
├── apps/
│   └── manual/                       # 온라인 매뉴얼
├── packages/
│   ├── theme-contracts/              # manifest schema와 공통 이름 계약
│   ├── theme-tooling/                # build·검사·assemble·checksum
│   ├── theme-tokens/                 # DTCG token 검증·CSS 생성
│   ├── theme-testkit/                # 향후 fixture·browser helper 후보
│   ├── theme-behaviors/              # 두 테마에서 검증된 TS runtime만
│   ├── theme-php/                    # 두 테마에서 검증된 PHP helper만
│   └── theme-assets/                 # 재배포 가능한 공통 font·SVG와 고지
├── harness/
│   └── design/                       # 현재 구현된 디자인 규칙 보정 fixture
├── themes/
│   └── <category>/<slug>/
│       ├── AGENTS.md
│       ├── package.json
│       ├── theme.manifest.json
│       ├── CHANGELOG.md
│       ├── tokens/*.tokens.json      # 직접 편집하는 token 원본
│       ├── src/php/
│       ├── src/styles/
│       ├── src/scripts/
│       ├── src/assets/
│       ├── tests/
│       ├── theme/                    # assemble된 G5 상품 payload
│       ├── ASSET-MANIFEST.json
│       └── RELEASE-MANIFEST.json
└── docs/
    ├── adr/                          # 공통 경계 변경 결정
    ├── standards/
    └── research/
```

빈 package를 한꺼번에 만들지는 않습니다. `theme-contracts`, `theme-tooling`, `theme-tokens`, `theme-testkit`은 첫 기반 단계에서 필요합니다. `theme-behaviors`와 `theme-php`는 실제 두 테마의 중복을 비교한 뒤 생성합니다.

## 4. 기계 판독 계약

AI와 사람이 Markdown만 읽어 구조를 추측하게 하면 drift가 생깁니다. 다음 여섯 파일을 JSON Schema Draft 2020-12로 검증합니다. 구현은 Ajv 8.20.0 strict mode와 `ajv-formats` 3.0.1을 사용하며, Ajv의 제한에 따라 Draft 2020-12 schema와 이전 draft를 한 validator instance에 섞지 않습니다.

### 4.1 `theme.manifest.json`

필수 항목:

- 상품 slug, version, category
- 지원 G5·PHP 범위와 영카트 포함 여부
- entry PHP, CSS, JS
- 사용하는 공통 package와 기능 module
- 필요한 G5 surface와 browser scenario
- 외부 library, font, icon, asset manifest 경로
- build output과 ZIP allowlist
- 온라인 매뉴얼 경로

이 파일을 package 조립, 영향 검사, 매뉴얼 목차와 AI용 inventory의 단일 입력으로 사용합니다.

### 4.2 `ASSET-MANIFEST.json`

파일마다 다음을 기록합니다.

- 안정적인 asset ID와 SHA-256
- 원본 URL·제작자·취득일
- SPDX license expression 또는 `LicenseRef-*`
- 원본/파생본 관계와 생성 명령
- AI 생성 여부와 사용 도구
- 사용할 수 있는 상품 범위
- 판매 ZIP 포함 여부

같은 hash의 자산을 여러 위치에 복사하면 검사에서 알려 줍니다. 공통 font·장식 SVG는 `theme-assets`에서 배포하고, 업종 hero 사진과 데모 이미지는 각 테마에 둡니다. 여러 테마가 같은 대표 이미지를 공유해 상품 인상이 같아지는 것은 재사용 이익보다 손해가 큽니다.

### 4.3 `RELEASE-MANIFEST.json`

- theme version과 source commit
- G5 upstream commit
- Bun·build runtime·lockfile hash
- 사용한 공통 package version
- 산출물 checksum과 bundle 크기
- 실행한 gate와 결과 artifact
- 매뉴얼 version URL

빌드 도구가 생성하며 사람이 직접 수정하지 않습니다.

### 4.4 `shared-candidates.json`

첫 테마에서 재사용 가능해 보이는 코드를 바로 공통 package로 옮기지 않고 다음 정보를 기록합니다.

- 책임과 현재 theme 경로
- 예상 소비자
- 외부 API와 G5 전제
- 두 번째 사용에서 달라진 점
- `local`, `candidate`, `shared`, `deprecated` 상태

이 registry는 공통화를 잊지 않게 하면서 첫 구현의 우연한 구조가 전체 테마를 묶는 문제를 막습니다.

### 4.5 `DESIGN-REFERENCE.json`

- 승인한 Figma file URL과 frame node ID
- desktop·mobile·주요 상태 frame map
- 승인 시각, token source hash와 preview hash
- 디자인 검토 상태와 다시 검토해야 하는 변경 조건

OAuth token과 계정 정보는 저장하지 않습니다. Figma는 시안·검토 통로이며 승인된 token과 구현 계약의 단일 원본은 저장소입니다. 구체적인 MCP 역할과 권한 정책은 [디자인·웹 MCP 도입 연구](WEB-DESIGN-MCP-RESEARCH.md)를 따릅니다.

### 4.6 `theme.tokens.json`

- DTCG `$type`, `$value`와 alias 문법의 제한된 subset
- 필수 semantic color 12종
- Tailwind `@theme inline`으로 공개할 token allowlist
- alias가 가리키는 실제 token 존재 여부

Style Dictionary 출력에는 원본 SHA-256과 직접 수정 금지 marker를 넣습니다. 생성 결과를 임시 디렉터리에서 다시 만들어 `generated/tokens.css`와 `generated/tailwind-theme.css` drift를 검사합니다.

## 5. 공통 코드 승격 규칙

### 5.1 두 번째 사용 승격

1. 첫 테마에서는 가장 단순하게 테마 내부에 구현합니다.
2. 두 번째 테마가 같은 책임을 요구하면 두 구현의 입력·출력·접근성·G5 의존성을 비교합니다.
3. 실제로 같은 부분만 공통 package로 추출하고 테마 차이는 adapter나 token으로 남깁니다.
4. 두 테마의 기능·시각·패키지 gate가 모두 통과한 뒤 `shared`로 표시합니다.
5. 세 번째 테마는 공통 API가 업종과 시안에 치우치지 않았는지 확인하는 소비자가 됩니다.

복사 후 조금 수정하는 방식은 허용하지 않습니다. 공통 API로 표현되지 않는 차이라면 별도 구현으로 유지합니다. 공통 package 안에 테마 slug 조건문이 생기면 경계가 잘못된 것입니다.

### 5.2 공통화 범위

| 즉시 공통화 | 두 번째 사용 후 공통화 | 공통화하지 않음 |
| --- | --- | --- |
| manifest schema | sticky header controller | hero art direction |
| token 이름·생성기 | mobile menu behavior | 업종별 문구와 정보 구조 |
| build·package·checksum | accessible tabs/dialog helper | 테마별 색·type·spacing 값 |
| G5 fixture와 scenario | G5 view/helper adapter | 대표 이미지와 업종 사진 |
| license·asset 검사 | Swiper/Motion 얇은 adapter | 고객별 콘텐츠 |
| AGENTS 템플릿 | 반복되는 PHP partial contract | 검증되지 않은 범용 component |

재사용은 화면을 똑같게 만드는 작업이 아닙니다. **이름, 동작 계약, 접근성, lifecycle과 검사 방식을 공유하고 시각 값은 테마가 소유**합니다.

## 6. 디자인 토큰과 스타일 기반

### 6.1 token 단일 원본

각 테마의 `tokens/*.tokens.json`을 단일 원본으로 사용합니다. 형식은 Design Tokens Community Group의 `$type`, `$value`, alias 문법을 따릅니다. 2025-07 문서는 W3C Community Group draft이며 W3C 표준은 아니므로, 사용하는 subset을 `theme-contracts` schema로 고정합니다.

초기 개발 도구는 Style Dictionary 5.5.3을 사용합니다. 5.5.4는 2026-09-18 배포되어 Bun의 3일 공급망 대기 정책에 걸렸으므로 즉시 우회하지 않습니다. 공식 CSS variable format은 token reference를 CSS `var()` 관계로 유지할 수 있습니다. 생성 대상은 다음 두 파일로 제한합니다.

- `generated/tokens.css`: 일반 semantic·component CSS variable
- `generated/tailwind-theme.css`: utility가 필요한 token만 Tailwind `@theme` namespace로 연결

Tailwind 공식 문서도 공유 token을 별도 CSS의 `@theme` 변수로 두고 프로젝트에서 import하는 방식을 지원합니다. token 생성물에는 `generated; do not edit` header와 source hash를 넣습니다.

### 6.2 token 소유권

| 계층 | 공통화 대상 | 테마 소유 |
| --- | --- | --- |
| primitive | 이름·type·단위·허용 범위 | 실제 색상·크기 값 |
| semantic | 필수 이름과 대비 계약 | brand·surface·text 연결 값 |
| component | 반복 component의 선택 schema | header·hero·card의 표현 값 |

모든 테마에 같은 spacing과 radius 값을 강제하지 않습니다. 공통 package는 token 이름과 검증 규칙을 제공하고, 각 테마가 디자인 방향에 맞는 값을 가집니다.

### 6.3 CSS 계층

```text
tokens       생성된 변수
base         테마 root 안의 최소 normalize와 typography
g5-bridge    G5 기본 markup을 테마 contract에 연결
components   반복되는 의미 단위
pages        업종·페이지 고유 표현
utilities    Tailwind 생성 utility
vendor       승인 library의 좁은 override
```

- `body`, `a`, `table`, `input` 같은 전역 selector를 무제한 덮어쓰지 않습니다.
- G5 bridge selector는 테마 root 또는 명확한 G5 surface에 한정합니다.
- token이 있는 값은 임의 hex·spacing arbitrary value로 다시 쓰지 않습니다.
- PHP에서 Tailwind class를 문자열 조합하지 않고 완전한 class map을 사용합니다.
- 반복된 utility 묶음은 의미와 변경 이유가 같을 때만 component로 승격합니다.

## 7. 공통 TypeScript 동작 계약

공통 runtime module은 UI 모양이 아니라 동작을 담당합니다.

```ts
export interface BehaviorHandle {
  destroy(): void;
}

export function mountStickyHeader(root: ParentNode): BehaviorHandle;
```

필수 규칙:

- `mount(root)`는 같은 root에 두 번 호출해도 listener를 중복 등록하지 않습니다.
- `destroy()` 또는 `AbortSignal`로 listener·observer·timer를 정리합니다.
- 전역 singleton과 import 시 자동 실행을 피합니다.
- selector는 `data-jw-*` namespace를 사용하고 CSS class와 분리합니다.
- 서버가 출력한 semantic HTML이 원본이며 JS는 상태만 향상합니다.
- custom event의 이름, detail type과 lifecycle을 export합니다.
- reduced motion, keyboard, focus 복귀와 JavaScript OFF 상태를 contract test로 둡니다.
- Swiper·Motion·PhotoSwipe wrapper는 실제 사용 화면에서만 dynamic import합니다.

공통 후보는 sticky header, mobile menu, disclosure, tabs, dialog, slider adapter, reveal adapter입니다. hero layout과 page composition은 공통 TypeScript package의 책임이 아닙니다.

## 8. 공통 PHP 경계

G5 template은 전역 변수와 include 관례가 많으므로 공통 PHP를 무리하게 framework화하지 않습니다.

- G5 진입 파일은 얇은 adapter로 유지합니다.
- 데이터 정규화와 view helper는 입력·출력이 명확한 순수 함수로 분리합니다.
- 공통 symbol은 namespace 또는 충돌 없는 `jwsoft_` prefix를 사용합니다.
- G5 권한·token·escape helper를 우회하지 않습니다.
- 테마가 직접 SQL을 만들거나 core schema를 가정하지 않습니다.
- 공통 PHP package는 build 시 각 테마 payload 안으로 복사하고 source version을 release manifest에 기록합니다.
- 고객 서버에서 다른 테마 저장소 경로나 Composer autoloader를 참조하지 않습니다.

PHPStan은 G5 전역과 function의 type 정보를 별도 stub로 제공할 수 있지만, stub은 symbol discovery 자체를 대신하지 않는다는 공식 제한을 따릅니다. 실제 G5 source를 분석 과정에서 실행해 side effect를 만들지 않도록 최소 symbol map과 scan 설정을 분리합니다.

## 9. AI 친화적 코딩 기준

AI 친화성은 주석을 많이 쓰는 것이 아니라 **문맥을 짧게 읽어도 책임과 검증법이 분명한 구조**입니다.

### 9.1 파일과 API

- 한 파일은 한 책임과 한 주요 변경 이유를 가집니다.
- 공개 함수는 명확한 입력·출력 type과 실패 조건을 가집니다.
- `index.ts` 재수출을 과도하게 쌓아 실제 구현 위치를 숨기지 않습니다.
- magic string, 동적 include, 동적 class 생성보다 명시적인 map과 manifest를 사용합니다.
- 생성 파일, vendor 파일과 직접 수정 파일을 디렉터리로 분리합니다.
- 임의 LOC 상한으로 파일을 자르지 않습니다. 책임이 둘 이상이고 변경·검사 이유가 갈릴 때 분리합니다.

### 9.2 간략 주석 규칙

주석은 다음 경우에만 씁니다.

- G5의 비표준 markup·전역·호출 순서 때문에 필요한 코드
- 접근성·보안·성능상 평범해 보이는 구현을 피한 이유
- browser/library workaround와 제거 조건
- public behavior contract와 부작용

코드가 그대로 말하는 동작을 한국어로 다시 설명하지 않습니다. workaround 주석에는 근거 URL 또는 issue와 제거 조건을 함께 둡니다. `TODO`는 막연한 희망 대신 조건이나 추적 문서를 가집니다.

### 9.3 AI context 계층

OpenAI 공식 문서상 Codex는 root에서 현재 디렉터리까지 `AGENTS.md`를 계층적으로 읽고 가까운 지침을 우선합니다. 이를 이용해 다음처럼 분리합니다.

- root `AGENTS.md`: 헌법, 표준 명령, 금지 경계
- `packages/*/AGENTS.md`: package API, 소비자, 필수 contract test
- `themes/<category>/<slug>/AGENTS.md`: 상품·시안·surface·허용 library·완료 gate
- 생성 `THEME-INVENTORY.md`: manifest에서 만든 파일·entry·scenario map

root AGENTS를 모든 연구 내용으로 비대하게 만들지 않습니다. 공식 가이드도 짧고 구체적인 지침과 상세 문서 링크를 권장합니다. 같은 AI 오류가 반복될 때만 새 규칙을 헌법이나 가까운 AGENTS에 추가합니다.

## 10. G5 실행 하네스

### 10.1 runtime 고정

- `.runtime/gnuboard5`는 개발 편의를 위한 checkout으로 유지합니다.
- `harness/upstream/*.lock.json`에는 G5 version, commit, source URL과 checksum을 기록합니다.
- CI는 lock에 맞는 깨끗한 G5를 준비하며 개발자의 오염된 runtime을 재사용하지 않습니다.
- 형님의 2026-09-20 지시에 따라 기존 사무실 Ubuntu의 웹 서버·PHP·DB·포트를 먼저 확인하고 `g5themes.test` 기준 환경을 구축했습니다.
- 기존 서비스와 충돌하지 않도록 PHP 8.3·MySQL 8.4·내부 Nginx는 Compose로 격리하고, 호스트 Nginx는 TLS 종료와 `127.0.0.1:18085` 연결만 담당합니다.
- 어떤 방식을 택하든 web·DB 준비 상태를 확인한 뒤 test를 시작하고, fixture reset은 이전 실행 상태에 의존하지 않게 설계합니다.

### 10.2 fixture

공통 fixture는 다음 상태를 반드시 포함합니다.

- 비회원, 일반 회원, 관리자
- 빈 게시판, 1개 글, 20개 초과 목록, 긴 제목, 첨부 이미지 실패
- 공지, 비밀글, 검색, paging, captcha가 필요한 흐름
- 영카트 OFF와 ON, 빈 상품과 대표 상품·장바구니·주문 화면
- 모바일 메뉴 1·2·3 depth와 매우 긴 메뉴명
- 팝업, 쪽지, 로그인·회원가입·마이페이지

업종 fixture는 실제 판매 demo 품질을 가져야 하지만 실제 고객·환자·회원 데이터를 사용하지 않습니다. 무작위 생성은 시각 기준본을 흔들므로 seed와 asset을 고정합니다.

### 10.3 검사 층

| 층 | 검사 | 실행 시점 |
| --- | --- | --- |
| L0 계약 | schema, forbidden path/CDN, license, generated drift | 모든 변경 |
| L1 source | TypeScript type/lint/unit, PHP lint/static/style, token build | 모든 코드 변경 |
| L2 G5 smoke | 테마 설치·활성화, 핵심 URL, 로그인·게시판·영카트 | 관련 테마 변경 |
| L3 browser | Chromium 기능, mobile, axe, JS OFF, visual diff | 화면·공통 runtime 변경 |
| L4 release | 전체 browser matrix, 깨끗한 ZIP 설치, rollback, checksum | 판매 release |

개발 중에는 변경한 테마와 해당 공통 package 소비자만 검사합니다. release에서는 지원 matrix 전체를 검사합니다. 공통 package를 바꾸고 소비 테마를 하나도 검사하지 않는 경로는 허용하지 않습니다.

### 10.4 browser와 시각 회귀

Playwright 1.63.0은 Chromium·Firefox·WebKit project와 mobile emulation, screenshot 비교를 제공합니다. 시각 기준본은 OS·browser·font·hardware에 따라 달라질 수 있으므로 같은 기준 환경에서만 비교합니다. Linux image를 미리 만들거나 고정하지 않으며, 형님이 실행 검증을 지시한 때 기존 Ubuntu와 실제 기기 범위를 확인해 기준 환경을 정합니다.

- 기능 smoke: 지시 시 확정한 Chromium, Firefox, WebKit 범위
- 대표 mobile: 390px touch와 WebKit mobile profile
- 시각 기준본: 동일 OS·browser·font 환경, 390·768·1440px
- 변동 콘텐츠: 고정 fixture 사용, 불가피한 영역만 좁게 mask
- 기준본 갱신: 일반 test 실행과 분리된 명령, diff 검토 기록 필수
- 접근성: `@axe-core/playwright` 자동 검사 + keyboard·focus·200% zoom 수동 확인

Playwright도 자동 접근성 검사가 일부 문제만 찾는다고 명시합니다. axe 통과를 접근성 완료로 표현하지 않습니다.

### 10.5 PHP 검사

| 도구 | 권고 | 이유 |
| --- | --- | --- |
| PHP 8.3·8.4·8.5 `php -l` | 필수 | 각 지원 parser에서 syntax 확인 |
| PHPStan 2.2.14 | 도입 | G5 stub·scan 설정으로 type와 명백한 오류 확인 |
| PHP_CodeSniffer 4.0.4 | 도입 | 최소 JW SOFT style과 금지 pattern 검사 |
| PHPCompatibility | 보류 | 최신 stable 9.3.5는 오래됐고 10.0은 alpha이므로 단독 release gate로 부적합 |

PHP 도구는 root `composer.json`의 dev dependency로만 관리하고 `vendor/`와 Composer를 판매 ZIP에 넣지 않습니다. 실제 runtime matrix가 정적 호환 검사보다 우선합니다.

## 11. build와 runtime 사실 정정

Bun은 package manager, workspace, catalog, script entry와 TypeScript unit test의 기준으로 적합합니다. 그러나 Bun 공식 문서는 Node API 호환이 아직 완전하지 않다고 밝히고 있습니다. 또한 현재 채택·평가 도구는 다음 Node engine을 선언합니다.

| 도구 | 2026-09-20 확인 버전 | package가 선언한 engine |
| --- | --- | --- |
| Vite | 8.3.0 | Node `^20.19.0 || >=22.12.0` |
| Sharp | 0.35.4 | Node `>=20.9.0` |
| Style Dictionary | 5.5.3 | Node `>=22.0.0` |
| Playwright | 1.63.0 | Node `>=20` |
| Changesets | 3.0.3 | Node `^22.11 || ^24 || >=26` |

따라서 아직 실행하지 않은 상태에서 “Node 없는 전체 toolchain”을 보장하면 안 됩니다.

권고 정책:

- JS package manager와 lockfile은 Bun 1.4.2와 `bun.lock` 하나만 사용합니다.
- 먼저 모든 도구를 Bun runtime으로 실행하는 compatibility spike를 macOS에서 수행하고, Ubuntu 검증은 형님의 명시적 지시 뒤 수행합니다.
- 공식 Node engine을 선언한 도구가 Bun에서 실패하거나 비결정적이면 Node 24 LTS를 **개발·CI tool runtime으로만** 허용합니다.
- 이 경우에도 npm·package-lock은 사용하지 않고 install과 script orchestration은 Bun이 담당합니다.
- 고객 ZIP과 고객 서버에는 Bun·Node·Composer가 모두 필요 없습니다.
- spike 후 canonical build runtime 하나를 정하고 release manifest에 기록합니다.

현재 로컬 Bun은 1.4.2이며 workspace와 lockfile도 같은 버전으로 고정했습니다.

## 12. 변경 영향과 버전 거버넌스

### 12.1 초기 단계

Bun workspace dependency와 `theme.manifest.json` 소비 목록으로 영향 범위를 계산합니다.

- 테마 내부 변경: 해당 테마 gate
- `theme-tooling` 변경: 모든 theme build·package gate
- `theme-tokens` 변경: 모든 token 소비 theme build·visual gate
- `theme-behaviors` 변경: 해당 module 소비 theme browser gate
- `theme-assets` 변경: 해당 asset 소비 theme license·bundle·visual gate
- harness 변경: 대표 theme로 하네스 자체 검증 후 관련 matrix

변경된 파일 이름만 보고 검사 범위를 줄이지 않습니다. dependency와 manifest consumer를 함께 봅니다.

### 12.2 외부 도구 도입 판단

- Changesets 3.0.3은 private workspace의 version과 changelog 관리 후보로 채택합니다. npm 공개 배포는 사용하지 않습니다.
- Nx Core 23.2.1은 `bun.lock`과 affected graph를 지원하지만 초기부터 도입하지 않습니다.
- 테마 수와 공통 package가 늘어 전체 검사가 반복적으로 불필요한 작업을 만든다는 측정이 나오면 Nx Core의 local cache와 `affected`를 spike합니다.
- Nx Cloud, 원격 cache와 외부 계정은 별도 효익·비용·비밀값 검토 전 사용하지 않습니다.

처음부터 task orchestrator까지 넣는 것보다 manifest와 workspace dependency를 정확히 만드는 것이 우선입니다. 그래프 입력이 틀리면 어떤 affected 도구도 올바른 결과를 만들지 못합니다.

### 12.3 release

1. changeset에 사용자 영향과 semver 종류를 기록합니다.
2. 영향 theme와 공통 package gate를 실행합니다.
3. theme version과 changelog를 갱신합니다.
4. clean G5에서 ZIP 설치·업데이트·롤백을 확인합니다.
5. `RELEASE-MANIFEST.json`, checksum, NOTICE와 온라인 매뉴얼을 생성합니다.
6. 생성 ZIP을 다시 풀어 allowlist와 실행 결과를 검사합니다.
7. 승인된 artifact만 판매 파일로 이동합니다.

공통 package version과 판매 theme version은 같게 맞추지 않습니다. 테마는 실제 사용자 영향에 따라 독립 version을 갖습니다.

## 13. CI 정책

GitHub Actions를 사용할 경우 job matrix로 PHP·DB·browser 조합을 표현합니다. 조합을 무조건 곱해 과도한 job을 만들지 않고 검사의 목적에 따라 나눕니다.

### 빠른 gate

- schema와 generated drift
- TypeScript·CSS·PHP source 검사
- 변경 theme build
- unit·contract test
- package allowlist dry run

### 통합 gate

- 기준 PHP 8.4 + MariaDB 10.11
- Chromium desktop/mobile G5 smoke
- 관련 screenshot과 axe

### release matrix

- PHP 8.3·8.4·8.5 syntax와 runtime smoke
- MariaDB 10.11과 MySQL 8.4 대표 조합
- Chromium·Firefox·WebKit 기능 흐름
- 깨끗한 G5 ZIP install/update/rollback
- macOS·Ubuntu build 재현과 산출물 비교

visual baseline 생성은 CI 자동 갱신 대상이 아닙니다. 실패 diff를 사람이 검토하고 의도된 변경일 때만 별도 명령으로 기준본을 바꿉니다.

## 14. 구현 순서

### 1단계: 헌법과 계약 — 완료

- root AGENTS를 짧은 헌법·명령 중심으로 개편
- theme, token, asset, design reference, release와 shared-candidate schema
- JSON Schema Draft 2020-12 + Ajv strict validator
- 공통 후보 registry와 ADR 형식
- 생성 파일 marker와 forbidden path 규칙

완료 증거: Ajv strict mode에서 정상·실패 fixture와 현재 registry를 검사하는 14개 test가 통과했습니다. 상대 경로 탈출, 필수 semantic token 누락, 누락 license, 승인된 Figma URL 누락, 수동 release manifest와 성급한 공통 승격을 각각 차단합니다.

### 2단계: workspace와 생성기 — 로컬 구현 완료

- Bun 1.4.2 workspace·catalog·lockfile: 완료
- theme-contracts: 완료
- theme-tokens: DTCG subset, Style Dictionary CSS·Tailwind 출력, drift 검사 완료
- theme-tooling: 덮어쓰기 방지 scaffold와 독립 ZIP allowlist·checksum·재압축 검증 완료
- scaffold는 승인할 token 파일을 입력받아 테마 AGENTS·manifest·PRODUCT 초안·폴더를 생성
- 릴리스 manifest는 ZIP 자체 hash의 순환 참조를 피하려고 ZIP 외부에 생성

현재 증거: macOS Bun 1.4.2에서 계약 14개, token 3개, tooling 4개 test가 통과하고 같은 입력의 ZIP hash가 일치합니다. Ubuntu build 재현과 판매 ZIP 설치는 후속 단계에서 확인합니다.

### 3단계: G5 하네스

- 기존 Ubuntu inventory와 격리 방식 확정: 완료
- G5 5.6.391·PHP 8.3.33·MySQL 8.4.11·호스트 TLS 기준 runtime: 완료
- 결정론적 G5 install과 fixture reset
- 확정한 browser 환경과 핵심 scenario
- PHP matrix와 G5 stub

현재 증거: 깨끗한 공식 G5 설치와 PC·mobile·로그인·게시판 수동 smoke가 통과했습니다. 상세 내용은 [G5 로컬 검증 환경 구축 보고서](../../reports/G5-LOCAL-RUNTIME-SETUP-2026-09-20.md)에 기록했습니다.

단계 완료 증거: fixture theme를 설치하고 같은 PC·mobile·로그인·게시판 smoke를 초기화부터 반복 실행할 수 있어야 합니다.

### 4단계: 첫 테마

- Figma 승인 frame을 `DESIGN-REFERENCE.json`에 기록하고 token 잠금
- 테마 local PHP/TS 구현
- Playwright MCP로 실제 G5 화면을 탐색하고 고정 test로 회귀 조건 기록
- package·visual·manual·release gate 완주
- 공통 후보만 기록하고 runtime 공통 package는 아직 만들지 않음

### 5단계: 두 번째 테마와 공통 승격

- 두 구현 비교
- 동일 책임만 theme-behaviors/theme-php로 승격
- 두 테마 browser·visual·ZIP 회귀 확인
- 변경 영향 계산을 실제 package dependency와 연결

이 순서를 따르면 첫 테마 전에 추상화에 시간을 쓰지 않으면서, 두 번째 테마부터 같은 기능을 다시 만드는 낭비를 줄일 수 있습니다.

## 15. 채택·보류 결정

| 항목 | 결정 | 이유 |
| --- | --- | --- |
| 모노레포 | 채택 | 공통 source·harness·manual을 한 commit에서 검증 |
| 테마별 독립 ZIP | 채택 | 고객 설치와 업데이트 결합 방지 |
| Bun workspace/catalog | 채택 | 공통 version·lockfile·filter |
| JSON Schema 2020-12 + Ajv strict | 채택 | manifest를 기계 검증하고 AI 추측 제거 |
| Node 없는 toolchain 보장 | 보류 | 채택 도구가 Node engine을 선언하며 Bun 호환 spike 미실행 |
| DTCG token JSON | 제한 채택 | AI·도구가 읽기 쉽지만 spec이 Community Group draft |
| Style Dictionary 5.5.3 | 채택 | Bun 1.4.2 macOS에서 DTCG·CSS reference·drift test 통과, Ubuntu는 후속 |
| fflate 0.8.3 | 채택 | 고정 mtime과 정렬 입력으로 ZIP을 만들고 즉시 재압축 검증 |
| Playwright 고정 Docker image | 보류 | Ubuntu 기준 runtime은 확정했으며 browser 자동화·시각 기준 환경은 첫 테마 범위에서 결정 |
| Figma 플러그인·remote MCP | 무료 범위 도입 | 시안·variable·frame 검토에 제한 사용, 결제 전제 없음 |
| Playwright MCP | 활용 | 개발 중 실제 G5 화면 탐색·진단 |
| Impeccable skill 4.3.1 | 제한 채택 | 프로젝트 skill과 수동 경고 검사, 자동 hook OFF |
| Storybook MCP | 조건부 보류 | preview이며 G5 component manifest 이점이 아직 작음 |
| Chrome DevTools MCP | 조건부 보류 | 실제 performance trace 수요가 생길 때 추가 |
| shadcn MCP | 제외 | React component 설치가 G5 PHP+daisyUI 기준과 충돌 |
| PHPStan·PHPCS | 채택 | G5 stub 기반 정적 검사와 최소 style gate |
| PHPCompatibility stable | 보류 | stable 노후, 최신 10.x alpha |
| Changesets | spike 후 채택 | private app version·changelog 관리, Node engine 검증 필요 |
| Nx Core | 조건부 보류 | 초기 복잡도보다 manifest·dependency 정확성이 우선 |
| 공통 UI runtime 선제 제작 | 금지 | 첫 테마 구조가 모든 상품을 묶는 위험 |
| 공통 runtime 두 번째 사용 승격 | 채택 | 중복 제거와 테마 독립성의 균형 |

## 16. 근거와 확인 자료

### 공식 자료

- [Bun workspaces와 catalog](https://bun.sh/docs/pm/workspaces)
- [Bun filter와 dependency order](https://bun.sh/docs/pm/filter)
- [Bun Node.js compatibility](https://bun.sh/docs/runtime/nodejs-compat)
- [Tailwind theme variables와 모노레포 공유](https://tailwindcss.com/docs/theme)
- [Tailwind source detection과 동적 class 제한](https://tailwindcss.com/docs/detecting-classes-in-source-files)
- [Design Tokens Format Module](https://tr.designtokens.org/format/)
- [Style Dictionary CSS variable format](https://styledictionary.com/reference/hooks/formats/)
- [JSON Schema Draft 2020-12](https://json-schema.org/draft/2020-12)
- [Ajv JSON Schema 지원과 draft 경계](https://ajv.js.org/json-schema)
- [Docker Compose profiles](https://docs.docker.com/compose/how-tos/profiles/)
- [Docker Compose healthcheck](https://docs.docker.com/reference/compose-file/services/#healthcheck)
- [Docker Compose trust model](https://docs.docker.com/compose/trust-model/)
- [Playwright browser projects](https://playwright.dev/docs/browsers)
- [Playwright visual comparisons](https://playwright.dev/docs/test-snapshots)
- [Playwright Docker version pinning](https://playwright.dev/docs/docker)
- [Playwright accessibility testing 한계](https://playwright.dev/docs/accessibility-testing)
- [PHPStan stub files](https://phpstan.org/user-guide/stub-files)
- [PHPCompatibility 상태와 사용법](https://github.com/PHPCompatibility/PHPCompatibility)
- [Changesets monorepo versioning](https://github.com/changesets/changesets)
- [Nx affected와 bun.lock 지원](https://nx.dev/docs/features/ci-features/affected)
- [REUSE 3.3과 `REUSE.toml`](https://reuse.software/spec-3.3/)
- [SPDX license expressions](https://spdx.github.io/spdx-spec/v3.0.1/annexes/spdx-license-expressions/)
- [Codex `AGENTS.md` 계층](https://developers.openai.com/docs/agent-configuration/agents-md)
- [Codex repository instruction 권고](https://developers.openai.com/guides/best-practices)
- [Figma MCP 소개](https://developers.figma.com/docs/figma-mcp-server/)
- [Storybook MCP](https://storybook.js.org/docs/ai/mcp/overview)
- [Chrome DevTools for agents](https://developer.chrome.com/docs/devtools/agents/get-started)
- [shadcn MCP](https://ui.shadcn.com/docs/mcp)
- [Impeccable 공식 저장소](https://github.com/pbakaus/impeccable)
- [Impeccable skill 4.3.1](https://github.com/pbakaus/impeccable/releases/tag/skill-v4.3.1)

### 2026-09-20 registry와 release 확인

- Bun upstream latest: 1.4.2, 현재 로컬: 1.4.2
- Ajv 8.20.0, MIT
- `ajv-formats` 3.0.1, MIT
- Style Dictionary 5.5.3, Apache-2.0
- fflate 0.8.3, MIT
- Playwright 1.63.0, Apache-2.0
- `@axe-core/playwright` 4.13.0, MPL-2.0
- PHPStan 2.2.14
- PHP_CodeSniffer 4.0.4
- PHPCompatibility stable 9.3.5, prerelease 10.0.0-alpha2
- Changesets 3.0.3, MIT
- Nx 23.2.1, MIT
- Impeccable skill 4.3.1, engine 0.1.5, Apache-2.0

### 현재 저장소 확인

- 실제 존재: root Bun workspace·lockfile, `theme-contracts`, 여섯 schema, `theme-tokens`, `theme-tooling`, 21개 회귀 test, `governance/`, Impeccable project skill·보정 fixture, Ubuntu G5 기준 runtime 정의, `docs/`, `themes/.gitkeep`, `.runtime/gnuboard5`
- 아직 없음: 실제 Vite/Tailwind theme build, `composer.json`, fixture reset·Playwright 자동 하네스, CI workflow, 실제 판매 theme
- 기반 1·2단계와 Impeccable 정적 감지 보정, token build, fixture ZIP 생성·재압축 검증을 실행했습니다. Ubuntu에서 공식 G5 설치와 PC·mobile·로그인·게시판 수동 smoke를 실행했습니다. 판매 ZIP 설치·업데이트·롤백은 실행하지 않았습니다.
