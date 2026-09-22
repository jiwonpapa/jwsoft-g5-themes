# JW SOFT G5 테마 공통 플랫폼 표준 v1.0

- 문서 상태: 기준 확정, 공통 기반 2단계 구현
- 기준일: 2026-09-20
- 적용 범위: `themes/**`의 모든 그누보드5·영카트5 유료 테마와 공통 빌드 체계
- 별도 제품: `jw-editor for G5`는 이 저장소와 테마팩에 포함하지 않으며, 별도 저장소·상품으로 진행할 때 [전환 연구서](../research/common/JWSOFT-EDITOR-G5-PORT-RESEARCH.md)를 인계 자료로 사용합니다.

## 1. 결론

여러 테마를 한 저장소에서 개발하되, **개발 도구와 품질 규칙은 공통화하고 상품 런타임은 테마별로 독립 배포**합니다. 고객 서버에는 Bun·Vite·TypeScript·Tailwind가 없어도 됩니다. 설치 ZIP에는 빌드가 끝난 CSS·JavaScript·폰트·아이콘과 PHP 템플릿만 포함하며, source 수정용 개발 키트는 별도 ZIP으로 제공합니다.

다음 항목을 공통 기준으로 확정합니다.

| 구분 | 기준 |
| --- | --- |
| G5 기준 | 공식 G5 최신 5.6.x를 기준으로 개발, 현재 연구 기준본은 5.6.391 |
| 테마 시작점 | 지원할 공식 G5의 `theme/basic` 전체를 새 테마 slug로 복제하고 원본 inventory 고정 |
| PHP 지원 | 8.3·8.4·8.5 검증 목표, 사용자 지정 기준 개발 환경 8.3 |
| DB | 테마는 DB 비침범. QA 기준 MariaDB 10.11 LTS와 MySQL 8.4 LTS |
| JS package manager | Bun 1.4.2, 루트 워크스페이스와 단일 `bun.lock` |
| JS tool runtime | Bun 우선, 공식 Node engine 도구의 개발·CI 호환 경로는 Node 24 LTS |
| 번들러 | Vite 8.3.0 |
| 언어 | PHP + TypeScript 7.0.2 + HTML/CSS |
| CSS | Tailwind CSS 4.3.3 + daisyUI 5.7.40 |
| 슬라이더 | Swiper 14.2.0, 필요한 모듈만 import |
| 스크롤 효과 | Motion 13.4.0, 필요한 화면에서만 import |
| 갤러리 | PhotoSwipe 5.4.4, 갤러리형 테마에서만 동적 import |
| 아이콘 | Lucide 1.47.0 SVG, 사용 아이콘만 번들 |
| 기본 한글 폰트 | Pretendard Variable 1.3.9 다이내믹 서브셋 자체 호스팅, 디자인 토큰은 400·500·600·700 사용 |
| 이미지 빌드 | Sharp 0.35.4 개발 의존성, 고객 서버에서는 사용하지 않음 |
| 외부 CDN | 기본 금지. 판매 ZIP 안에 자산과 라이선스 고지를 포함 |
| AI 작업 규칙 | 각 테마 루트에 `AGENTS.md` 필수 |
| AI 디자인 점검 | Impeccable 4.3.1 project skill, 수동 경고 검사, 자동 hook OFF |

위 버전은 2026-09-20 공식 문서와 패키지 레지스트리의 안정판을 기준으로 한 **초기 고정 버전**입니다. `latest`를 빌드 명령에 사용하지 않고 루트 catalog와 `bun.lock`으로 고정합니다. 보안 패치와 호환성 검증을 통과한 경우에만 갱신합니다.

## 2. 사실·결정·미검증의 경계

| 표기 | 의미 | 이 문서의 예 |
| --- | --- | --- |
| 확인 | 공식 문서·현재 소스·패키지 메타데이터로 확인 | G5 5.6.391, PHP 지원 종료일, 라이브러리 버전 |
| 결정 | JW SOFT 상품 정책으로 채택 | PHP 8.3~8.5 지원, CDN 금지, Bun 단일화 |
| 구현 게이트 | 실제 적용 전 자동·브라우저 검증 필요 | Vite 8 + Bun 실행, G5 화면 CSS 충돌, 번들 용량 |

문서 확정은 구현 완료나 호환성 증명이 아닙니다. 첫 테마 골격에서 아래 검증 게이트를 통과한 뒤 플랫폼 v1.0을 코드 기준선으로 승격합니다.

개발 헌법, 공통 코드 승격, manifest, 실행 하네스와 변경 영향 구조는 [테마 개발 기반 연구](../research/common/THEME-DEVELOPMENT-FOUNDATION-RESEARCH.md)를 구현 기준으로 사용합니다.

G7 유료 테마 경험은 코드나 런타임을 이식하지 않고 [G7 경험의 G5 적용 검토](../research/common/G7-THEME-LESSONS-TRANSFER-REVIEW.md)에서 `채택·G5식 변환·제외`로 판정한 원칙만 사용합니다.

Figma·Playwright 등 agent 연결의 역할과 권한 경계는 [디자인·웹 MCP 도입 연구](../research/common/WEB-DESIGN-MCP-RESEARCH.md)를 따릅니다.

## 3. 저장소와 상품 경계

```text
jwsoft-g5-themes/
├── AGENTS.md
├── package.json                 # Bun workspace와 단일 catalog
├── bun.lock                     # 반드시 커밋
├── bunfig.toml
├── tsconfig.base.json
├── composer.json                # PHP 개발 검사 도구만
├── composer.lock
├── apps/
│   └── manual/                  # 테마 설치·수정 온라인 매뉴얼 정적 사이트
├── packages/
│   ├── theme-contracts/         # manifest schema와 이름 계약
│   ├── theme-tooling/           # 빌드·검사·패키징 도구
│   ├── theme-tokens/            # token 검증과 CSS 생성
│   ├── theme-testkit/           # fixture와 browser helper
│   ├── theme-behaviors/         # 두 테마 검증 뒤 생성
│   └── theme-php/               # 두 테마 검증 뒤 생성
├── harness/                     # 현재는 계약·디자인 fixture, 실행 환경은 지시 뒤 구성
└── themes/
│   └── <category>/<theme-slug>/
│       ├── AGENTS.md            # 테마별 AI 작업 계약
│       ├── package.json
│       ├── docs/
│       ├── src/                 # 빌드 원본
│       ├── theme/               # G5 설치 구조와 빌드 결과
│       ├── LICENSES/
│       ├── THIRD_PARTY_NOTICES.md
│       ├── ASSET-MANIFEST.json
│       └── README.html           # 해당 버전 온라인 매뉴얼 진입점
```

### 3.0 공식 G5 기준 소스

- 실제 구현은 공식 배포본의 `theme/basic` 일부를 재작성해 흉내 내는 방식으로 시작하지 않습니다. 디렉터리 전체를 해당 상품의 테마명 폴더로 복제합니다.
- 복제 시점의 G5 버전, 원본 파일 목록과 checksum을 고정합니다.
- 각 파일은 `개편`, `그대로 상속`, `상품 범위 제외` 중 하나로 추적합니다.
- 영카트 제외 상품도 G5 커뮤니티 기능과 PC·모바일 skin 전체를 처리하며, 범위 밖 기능은 상품 설정과 설명에 명시합니다.
- 다른 JW 테마를 런타임 부모로 요구하지 않고 판매 ZIP 하나로 동작합니다.

### 3.1 처음부터 공통화하는 것

- Bun workspace, catalog, 잠금파일
- theme·asset·release manifest schema
- Vite/Tailwind/daisyUI 기본 설정 생성기
- token 검증과 CSS 생성기
- 정적 검사, 자산 라이선스 검사, ZIP 패키징 도구
- G5 fixture, 브라우저 QA 시나리오와 성능 예산
- 디자인 토큰의 이름과 계층
- 의존성 승인 목록과 보안 업데이트 절차
- 테마별 `AGENTS.md` 형식

### 3.2 두 테마 이상에서 검증된 뒤 공통화하는 것

- 헤더·푸터·메가메뉴·카드의 실제 PHP/HTML 컴포넌트
- 업종별 게시판 스킨과 데이터 조회 코드
- 특정 히어로·슬라이드·문의 UI
- 런타임 JavaScript helper

한 테마의 우연한 구조를 공통 컴포넌트로 먼저 뽑지 않습니다. 공통 빌드 도구와 상품 런타임 코드를 구분합니다.

### 3.3 기능과 CS 경계

**테마팩 v1은 테마에 집중합니다.** 구매 가격에 포함되는 기능이 많을수록 서버 환경·권한·외부 API·업로드·데이터 lifecycle 조합이 늘어나고, 1년 지원 약속의 비용도 함께 커집니다.

| 구분 | 포함 정책 | CS 책임 |
| --- | --- | --- |
| 테마 핵심 | 헤더·메뉴·푸터·페이지·게시판·회원·영카트 시각 통합, 반응형 | 테마 상품이 지원 |
| 테마 시각 효과 | 해당 시안에 필요한 Swiper·Motion·PhotoSwipe만 | 테마 상품이 정한 동작만 지원 |
| 공통 플러그인 | `jw-editor for G5`, 고급 uploader 등 | 별도 상품·버전·문서·지원 기간 |
| 외부 연동 | 지도·예약·상담·결제·SNS SDK | 기본 제외, 승인된 adapter만 별도 상품 |
| 고객별 제작 | 문구·이미지·메뉴 입력, 레이아웃 변경 | 유상 제작 범위 |

테마 안에 다음 기능을 넣지 않습니다.

- page builder와 관리자 drag-and-drop 편집
- 범용 form builder
- 자체 예약·CRM·결제·문자 시스템
- 범용 파일 관리자와 고급 media library
- AI 글쓰기·챗봇
- 외부 서비스 계정 자동 설정
- 플러그인 marketplace

#### 기능 입장 조건

새 기능은 다음 질문이 모두 `예`일 때만 테마 자체 기능으로 넣습니다.

1. 업종별 시안의 핵심 화면을 완성하는가?
2. 별도 DB table·cron·외부 계정 없이 동작하는가?
3. 기능 OFF 상태와 JavaScript 실패 상태에서도 콘텐츠가 유지되는가?
4. 지원 G5/PHP/mobile matrix를 기존 릴리스 절차 안에서 검증할 수 있는가?
5. 설치·사용법을 한 페이지 안에서 설명할 수 있는가?
6. 1년간 JW SOFT가 직접 오류를 재현하고 고칠 수 있는가?

하나라도 아니면 별도 플러그인 또는 제외로 분류합니다.

#### 테마별 기능 예산

- 기본 runtime library는 해당 테마가 실제 사용하는 것만 포함합니다.
- slider가 없으면 Swiper를 빌드하지 않습니다.
- scroll-linked effect가 없으면 Motion을 빌드하지 않습니다.
- gallery 확대가 없으면 PhotoSwipe를 빌드하지 않습니다.
- 시각 효과의 관리자 옵션을 범용 설정 화면으로 확장하지 않습니다.
- 기능 toggle 조합은 최대 3개로 제한하고 각 조합을 실제 화면에서 검사합니다.

이 기준에 따라 `jw-editor for G5` 연구 문서는 인계 자료로만 유지하고, 구현·패키징·CS는 이 테마 저장소의 범위에서 제외합니다.

### 3.4 온라인 매뉴얼 우선 정책

설치와 수정 지원은 개별 답변을 반복하지 않고 **버전이 표시된 온라인 매뉴얼**로 제공합니다. 매뉴얼은 상품의 일부이지만 테마 PHP runtime과 분리합니다.

- 판매 ZIP의 `README.html`은 해당 상품·버전의 온라인 매뉴얼과 최소 오프라인 설치 절차로 연결합니다.
- 설치, 업데이트, 롤백, 로고·색상·폰트·메뉴·이미지 변경 위치, 자주 발생하는 오류를 검색 가능하게 제공합니다.
- 모든 절차는 대상 G5·PHP·테마 버전, 예상 결과, 실패 시 원복 방법을 함께 적습니다.
- 고객별 화면·서버에 맞춘 해석과 수정 대행은 매뉴얼 범위를 넘는 유상 작업입니다.
- 답변이 두 번 이상 반복된 문의는 매뉴얼 후보로 기록하고, 문서 결함이면 문서를 고친 뒤 해당 항목 URL로 응답합니다.
- 에디터·예약·외부 연동 등 별도 상품의 매뉴얼을 테마 매뉴얼에 섞지 않습니다.

구조·필수 문서·릴리스 게이트는 [온라인 매뉴얼 운영 표준](ONLINE-MANUAL-STANDARD.md)을 따릅니다.

## 4. 서버 런타임 기준

### 4.1 PHP

| 등급 | 버전 | 정책 |
| --- | --- | --- |
| 기준 | PHP 8.3 최신 패치 | 사용자 지정 로컬·CI 대표 환경, 전체 필수 검사 |
| 지원 | PHP 8.4 최신 패치 | 전체 필수 검사 |
| 지원 | PHP 8.5 최신 패치 | 전체 필수 검사 |
| 한시적 이전 확인 | PHP 8.2 | 2026-12-31까지만 마이그레이션 참고 검사, 판매 지원선에는 포함하지 않음 |
| 미지원 | PHP 8.1 이하 | 보안 지원 종료 버전이므로 신규 상품 지원 대상에서 제외 |

PHP 공식 정책상 8.2의 보안 지원은 2026-12-31, 8.3은 2027-12-31, 8.4는 2028-12-31, 8.5는 2029-12-31까지입니다. G5 README에 남아 있는 PHP 5.2.17 최소값과 PHP 7.2 권장은 G5의 레거시 호환 범위이며 JW SOFT 신규 유료 상품의 보안 지원 범위로 사용하지 않습니다.

2026-09-21 출시 범위 확정에서 대표 환경을 사용자가 지정하고 실제 구축한 PHP 8.3으로 정정했습니다. 표의 지원 버전은 검증 대상이며 실제 상품의 필수 검사를 통과하기 전에는 호환성 확인 완료로 표시하지 않습니다.

테마 PHP는 G5 전역과 템플릿 관례를 존중하되 다음을 금지합니다.

- G5 코어 파일 수정
- 서버 전역 설정 변경
- 버전별 분기 하드코딩의 무제한 누적
- `eval`, 문자열로 만든 실행 코드, 동적 파일 include 경로
- 직접 조합한 SQL과 코어 테이블 스키마 변경
- 에러 숨김으로 호환성 문제를 정상 처리하는 방식

### 4.2 PHP 확장

| 분류 | 확장 |
| --- | --- |
| 테마·G5 필수 검사 | `mysqli`, `mbstring`, `gd`, `fileinfo`, `json`, `openssl` |
| 네트워크·압축 기능 사용 시 | `curl`, `zip` |
| 에디터 이미지 처리 권장 | `imagick`, 없으면 검증된 GD 경로 |
| 이미지 방향 정보 사용 시 | `exif` |

설치 점검기는 확장 누락을 명시적으로 보여 줘야 합니다. 조용한 기능 축소는 허용하지 않습니다.

### 4.3 데이터베이스

테마는 DB 테이블을 만들거나 바꾸지 않으므로 G5가 정상 설치된 데이터베이스를 그대로 사용합니다. 신규 QA 기준은 다음과 같습니다.

- MariaDB 10.11 LTS 최신 패치
- MySQL 8.4 LTS 최신 패치
- 문자셋 `utf8mb4`

MariaDB 10.3·10.6과 MySQL 8.0은 공식 유지보수 종료 버전입니다. 레거시 호스팅에서 테마가 우연히 실행되더라도 이를 보안 지원으로 표현하지 않습니다. 별도 플러그인이 자체 테이블을 사용하면 그 플러그인이 독립적으로 마이그레이션과 DB 호환 검사를 책임집니다.

### 4.4 웹 서버와 배포 환경

- Nginx와 Apache 모두 지원합니다.
- 내부 기준 QA는 Ubuntu 24.04 LTS + Nginx + PHP-FPM입니다.
- URL 재작성은 G5 공식 규칙을 따릅니다.
- 고객 서버는 PHP 런타임만 필요합니다. Bun, Node.js, Composer, Sharp 설치를 요구하지 않습니다.
- 디버그 소스맵, 테스트 fixture, 원본 디자인 파일, `node_modules`는 판매 ZIP에서 제외합니다.
- 사무실 Ubuntu에는 2026-09-20 승인에 따라 기존 서비스와 분리된 `g5themes.test` 기준 환경을 구축했습니다. 호스트 설정·포트·런타임을 추가 변경할 때는 현재 상태를 다시 확인합니다.

## 5. 브라우저 기준

Tailwind CSS 4의 공식 최소 테스트 기준을 그대로 채택합니다.

- Chrome 111+
- Safari 16.4+
- Firefox 128+
- 현재 Android Chrome, iOS Safari

IE와 구형 WebView는 지원하지 않습니다. CSS나 JavaScript의 최신 기능을 추가로 사용할 때는 위 기준에서 실제 동작을 확인합니다. 핵심 메뉴·본문·문의 CTA는 JavaScript가 실패해도 접근 가능한 HTML로 남겨 둡니다.

## 6. Bun 모노레포 표준

### 6.1 원칙

- npm·pnpm·Yarn 잠금파일을 병용하지 않습니다.
- 루트 `package.json`의 workspace catalog에 공통 버전을 한 번만 기록합니다.
- 모든 workspace는 `catalog:` 참조를 사용합니다.
- `packageManager`는 `bun@1.4.2`로 고정합니다.
- `bun.lock`을 릴리스 근거물로 커밋합니다.
- 새 의존성은 정확한 버전으로 추가하고 자동 범위 갱신을 막습니다.

권장 `bunfig.toml` 정책은 다음과 같습니다.

```toml
[install]
exact = true
minimumReleaseAge = 259200
```

3일 최소 공개 기간은 새 패키지의 공급망 사고 노출을 줄이는 지연 장치입니다. 보안 긴급 패치는 검토 기록과 함께 예외 처리합니다. Bun은 임의 lifecycle script를 기본 실행하지 않는 방향을 제공하므로 `trustedDependencies`는 실제로 필요한 패키지만 루트에서 명시합니다. `ignoreScripts=true`는 허용한 패키지의 스크립트까지 막으므로 기본값으로 사용하지 않습니다.

### 6.2 표준 명령

```bash
bun ci
bun run --bun --filter @jwsoft/theme-<slug> build
bun run --bun --filter @jwsoft/theme-<slug> check
bun run --bun build:all
bun audit --audit-level=high
```

Vite 같은 Node shebang CLI도 먼저 Bun으로 실행되게 `--bun`을 사용합니다. 다만 Vite 8과 Sharp 등은 package metadata에서 Node engine을 선언하고 Bun의 Node API 호환도 아직 완전하지 않습니다. 첫 골격에서 macOS·Ubuntu의 Bun 실행을 증명하고, 실패하거나 비결정적이면 Node 24 LTS를 개발·CI tool runtime으로만 허용합니다. npm과 `package-lock.json`은 사용하지 않으며 고객 서버에는 어느 build runtime도 요구하지 않습니다.

### 6.3 Bun과 Node 호환 경계

- Bun은 install, workspace, catalog, lockfile, script entry와 TypeScript unit test의 기준입니다.
- Node는 공식 Node engine을 선언한 build/test 도구의 호환 경로일 뿐 package manager가 아닙니다.
- canonical build runtime은 compatibility spike 후 하나로 확정하고 release manifest에 기록합니다.
- Bun과 Node가 다른 산출물을 만들면 release를 막고 원인을 먼저 해결합니다.
- “Node 없는 build”는 실제 macOS·Ubuntu gate를 통과하기 전 상품 보장으로 사용하지 않습니다.

## 7. CSS와 컴포넌트 계층

### 7.1 Tailwind CSS 4

- Vite 공식 플러그인 `@tailwindcss/vite`를 사용합니다.
- Sass/Less/Stylus를 추가하지 않습니다.
- 동적 문자열로 class를 조립하지 않습니다. 필요한 변형은 정적 map이나 `@source inline()`으로 명시합니다.
- PHP, JS, 스킨 파일을 source scan 범위에 명시합니다.
- 사용자 입력값을 Tailwind class 이름으로 직접 출력하지 않습니다.

G5는 기존 CSS와 플러그인이 많으므로 Tailwind Preflight를 전역 주입하지 않습니다. `theme.css`와 `utilities.css`만 가져오고 JW SOFT가 관리하는 base layer를 테마 루트에 제한합니다. Tailwind utility prefix는 `tw:`, daisyUI 자체 prefix는 `d-`를 사용합니다. 두 prefix가 함께 적용된 daisyUI class의 최종 표기는 공식 규칙에 따라 `tw:d-btn` 형태입니다.

### 7.2 daisyUI 5

daisyUI는 form·button·dialog 표현과 라이트·다크 semantic color의 기반으로 사용합니다. daisyUI는 CSS library이므로 HTML 의미 구조, keyboard 동작, focus 관리와 전 화면 검증은 JW SOFT 코드가 책임집니다. 제품의 시각 정체성은 색 이름만이 아니라 사진, 서체, 간격, 정보 구조와 컴포넌트 구성으로 만듭니다.

- 각 상품 manifest에 사용할 daisyUI theme를 명시하고 필요한 theme만 생성 CSS에 포함합니다. `JW-Business 1.0`은 `corporate`와 `business`만 포함합니다.
- 라이트·다크 전환은 루트의 `data-theme` 값을 바꾸며, 컴포넌트는 `base-*`, `base-content`, `primary`, `secondary`, `accent`와 상태 semantic color만 사용합니다.
- 사용자 선택이 없으면 `prefers-color-scheme`을 따르고, 명시적 선택은 브라우저 저장소에 보존합니다. 초기 색상 깜빡임과 저장소 접근 실패 fallback을 검사합니다.
- 색상은 선택한 daisyUI theme를 원본으로 사용하고, 모서리·그림자·간격·서체는 테마별 token으로 정의합니다.
- 사용하지 않는 component는 `include` 또는 `exclude`로 제거합니다.
- `tw:d-btn`, `tw:d-modal`처럼 Tailwind와 daisyUI prefix가 함께 붙은 class만 사용합니다.
- 원본 component를 무리하게 덮어쓸 정도로 디자인이 다르면 semantic HTML과 Tailwind로 직접 구성합니다.

### 7.3 디자인 토큰

모든 테마는 다음 토큰 계층을 가져야 합니다.

```text
primitive  →  semantic  →  component
색상값        surface       header-bg
간격값        section-gap   hero-gap
글자값        text-body     nav-label
```

색상 semantic token은 daisyUI의 `base-100`, `base-200`, `base-300`, `base-content`, `primary`, `primary-content`, `secondary`, `secondary-content`, `accent`, `accent-content`, `info`, `success`, `warning`, `error` 계열에 연결합니다. 템플릿 안에 임의 hex 색을 반복하지 않습니다. DTCG token은 색상을 새로 발명하는 파일이 아니라 선택한 daisyUI theme와 서체·간격·모서리·컴포넌트 역할의 고정 계약입니다.

### 7.4 디자인 도구와 MCP 경계

- Figma 플러그인·MCP는 시안, variable·frame 문맥과 구현 화면의 code-to-canvas 검토에 사용합니다.
- Figma는 무료 Starter 범위만 사용하며 유료 좌석을 공통 개발비나 필수 조건으로 두지 않습니다.
- 무료 호출 한도가 끝나도 저장소 token·preview와 Playwright 검증으로 작업을 계속할 수 있어야 합니다.
- 승인된 token의 단일 원본은 저장소의 `tokens/*.tokens.json`입니다.
- 테마는 승인 frame을 `DESIGN-REFERENCE.json`의 node ID와 hash로 참조합니다.
- Playwright MCP 확인은 개발 중 탐색 증거이며, 릴리스 통과 판정은 고정된 `@playwright/test`가 담당합니다.
- MCP 장애나 외부 계정 부재가 build·test·package를 막지 않아야 합니다.
- MCP가 생성한 코드와 자산도 source diff, 접근성, 라이선스와 실제 G5 gate를 거칩니다.
- Impeccable은 MCP가 아니며 정적 보조 검사로만 사용합니다. detector 경고가 token·승인 시안·실제 화면보다 우선하지 않습니다.

## 8. JavaScript와 시각 기능 표준

### 8.1 기본 원칙

- 새 기능은 vanilla TypeScript ESM을 기본으로 합니다.
- 신규 유료 테마의 공개 기본 번들은 jQuery와 jQuery Migrate를 포함하지 않습니다. 테마 소유 PHP·TypeScript·JavaScript에서 `jQuery`, `$()`, jQuery plugin을 사용하지 않습니다.
- G5 코어 공개 경로가 jQuery를 직접 요구하면 코어 수정 없이 대체 가능한 hook·테마 adapter를 먼저 검증합니다. 실증상 대체가 불가능한 경로만 page-only bridge를 허용하며 경로·버전·제거 조건을 manifest에 기록합니다.
- 관리자 화면과 외부 스킨·플러그인의 jQuery는 각 소유 영역의 책임입니다. 테마가 관리자 head를 덮어쓰거나 외부 확장의 호환성을 전역 구버전 jQuery로 보장하지 않습니다.
- jQuery Migrate는 영구 호환 계층이 아닙니다. 전환 조사에만 개발판을 사용하고 판매 payload에서는 제거합니다.
- `innerHTML`, `document.write`, `eval`, 문자열 이벤트 handler를 사용하지 않습니다.
- 이벤트 listener는 중복 초기화와 해제를 관리합니다.
- 핵심 정보와 이동은 효과가 꺼져도 사용할 수 있어야 합니다.
- `prefers-reduced-motion: reduce`에서는 비필수 이동·자동재생을 제거합니다.

### 8.2 기능별 선택

| 기능 | 채택 방식 | 필수 조건 |
| --- | --- | --- |
| 히어로/콘텐츠 슬라이드 | Swiper | 2장 이상일 때만 초기화, `Navigation`·`Pagination`·`A11y` 등 필요한 모듈만 import |
| 자동 슬라이드 | Swiper `Autoplay` 선택 | 기본 OFF, 사용 시 정지 버튼·키보드 포커스·hover 정지 제공 |
| 패럴랙스 | Motion `scroll()` | 장식 이미지에만, 모바일·reduced-motion에서는 정적 표시 |
| 등장 효과 | Motion `inView()` | 1회, 300~500ms, 본문 읽기를 늦추지 않음 |
| 스티키 메뉴 | CSS `position: sticky` + 소형 TS controller | 아래 스크롤 숨김, 위 스크롤 표시, 포커스 진입 시 즉시 표시 |
| 갤러리 확대 | PhotoSwipe | 상세 갤러리에서 동적 import, 원본 링크 fallback 유지 |
| 아코디언/탭 | 네이티브 요소 또는 소형 TS | ARIA, 키보드 이동, URL/초기 상태 명시 |
| 모달 | `<dialog>` 우선 | focus trap, Escape, focus 복귀 검사 |

#### 스티키 헤더 동작 계약

1. 첫 화면에서는 항상 보입니다.
2. 아래로 12px 이상 연속 이동할 때만 숨깁니다.
3. 위로 이동하면 즉시 나타납니다.
4. 페이지 상단 80px 이내, 메뉴 포커스 진입, 모바일 메뉴 열림 상태에서는 숨기지 않습니다.
5. 스크롤 listener는 passive로 등록하고 프레임당 한 번만 상태를 갱신합니다.
6. 헤더가 사라져도 건너뛰기 링크와 키보드 포커스가 화면 밖에 갇히지 않습니다.

#### 패럴랙스 동작 계약

- 본문 텍스트, 입력 폼, CTA 자체를 패럴랙스 대상으로 쓰지 않습니다.
- 이동량은 요소 높이의 10% 또는 80px 중 작은 값 이내로 제한합니다.
- 레이아웃 속성 대신 `transform`을 사용합니다.
- 모바일에서 성능 저하가 있으면 정적 이미지로 자동 축소합니다.
- Core Web Vitals가 예산을 넘으면 효과를 제거합니다.

### 8.3 기본 채택하지 않는 라이브러리

- GSAP: 기본 기능에 비해 별도 런타임과 라이선스 검토 범위를 늘립니다.
- Lenis: 페이지 전체 스크롤 감각을 바꿔 접근성과 기존 G5 플러그인 충돌 위험이 큽니다.
- AOS: Motion `inView()`와 책임이 겹칩니다.
- Slick/Owl Carousel: jQuery 의존과 Swiper 중복입니다.
- Font Awesome 전체 번들: Lucide SVG와 책임이 겹치고 icon font가 불필요합니다.
- Uppy: 현재 `jw-editor`의 업로드 queue·진행률·재시도·청크 재개 구현과 중복됩니다. 직접 클라우드 multipart/Tus가 필요해질 때 별도 평가합니다.

이 목록은 라이브러리의 품질 평가가 아니라 이 상품군의 중복·용량·유지보수 판단입니다.

### 8.4 대안 평가표

| 책임 | 채택 | 검토한 대안 | 채택 근거 | 재평가 조건 |
| --- | --- | --- | --- | --- |
| 소형 UI 상태 | vanilla TypeScript | Alpine.js, Stimulus | 메뉴·dialog·tab 규모에서 별도 runtime 없이 충분 | 화면 간 상태 공유가 반복되고 자체 controller가 복잡해질 때 |
| slider | Swiper | Splide, Glide, Slick/Owl | 모듈 import, touch, A11y, TypeScript와 현재 유지 상태 | 번들·브라우저 회귀가 예산을 넘을 때 |
| scroll/reveal | Motion | GSAP, AOS, ScrollMagic | `scroll()`·`inView()`를 필요한 함수만 사용하고 native API를 활용 | 복합 timeline이 실제 대표 시안의 필수 기능이 될 때 |
| smooth scroll | 채택 안 함 | Lenis | 핵심 상품 가치가 아니고 전체 페이지 입력·접근성에 영향 | 접근성 fallback까지 포함한 명확한 상품 요구가 생길 때 |
| lightbox | PhotoSwipe 5 | GLightbox, 직접 구현 | progressive enhancement, dynamic import, responsive image 지원 | PhotoSwipe 6 안정판 전환 검증 또는 요구 기능 부족 |
| icon | Lucide | Font Awesome, 자체 icon font | SVG, 개별 import, 일관된 선형 icon | 업종 전용 pictogram set이 필요할 때 별도 자산으로 추가 |
| font | Pretendard Variable 다이내믹 서브셋 | Noto Sans KR, static weight 파일 | 한글 가독성, 자체 호스팅, 실제 노출 glyph group만 요청 | 한글 첫 화면 전송량·CLS가 예산을 넘을 때 subset 구성을 재검토 |
| upload | 기존 `jw-editor` uploader | Uppy | 이미 queue·progress·retry·chunk resume가 있어 중복 방지 | Tus·직접 cloud multipart·cloud source가 필요할 때 |

## 9. 자산 기준

### 9.1 폰트

- 기본 본문은 공식 Pretendard Variable 1.3.9의 다이내믹 서브셋을 자체 호스팅합니다.
- 공식 다이내믹 서브셋 CSS와 분할 WOFF2 자산을 배포하고 `font-display: swap`을 사용합니다. 브라우저는 페이지에 실제 표시된 glyph가 속한 `unicode-range` 파일만 요청합니다.
- 폰트가 지원하는 전체 가변 범위를 디자인 자유도로 노출하지 않습니다. 테마 토큰과 시안은 400·500·600·700만 사용합니다.
- npm 개발 package 전체를 판매 ZIP에 복사하지 않고, 검증한 다이내믹 서브셋 CSS·폰트 파일·OFL 고지만 포함합니다.
- 시스템 fallback은 `-apple-system`, `BlinkMacSystemFont`, `Segoe UI`, `Noto Sans KR`, `sans-serif` 순으로 둡니다.
- 업종별 display font는 해당 테마에서만 추가하고 한글 glyph·웹 재배포 권한·용량을 검토합니다.
- Google Fonts 등 원격 폰트 요청을 기본값으로 두지 않습니다.

### 9.2 아이콘

- Lucide 아이콘을 ESM import해 빌드 시 SVG로 포함합니다.
- 전체 sprite나 icon font를 넣지 않습니다.
- 장식 아이콘은 `aria-hidden="true"`, 의미 있는 단독 버튼은 한국어 accessible name을 가집니다.
- 브랜드 로고와 의료·법률 등 전문 상징은 Lucide 일반 아이콘으로 대체하지 않고 별도 승인 자산으로 관리합니다.

### 9.3 이미지와 영상

- 원본, 파생본, 출처, 라이선스, 생성 도구, 사용 위치를 `ASSET-MANIFEST.json`에 기록합니다.
- 빌드 시 Sharp로 크기별 AVIF/WebP/JPEG 파생본을 만들되 원본은 제작 저장소에 보존합니다.
- 판매 ZIP에는 실제 사용 파생본만 넣습니다.
- width/height 또는 aspect-ratio를 제공해 CLS를 막습니다.
- 히어로 영상은 포스터와 정적 fallback을 포함하고 모바일 자동재생을 기본값으로 삼지 않습니다.

### 9.4 외부 서비스

지도, SNS 공식 embed, 예약·상담 widget은 테마 공통 자산이 아닙니다. 해당 테마의 기능으로 승인된 경우에만 다음을 만족해야 합니다.

- 관리자가 명시적으로 켜야 외부 연결
- 허용 도메인과 데이터 전송 내용을 문서화
- API key를 상품 소스에 포함하지 않음
- 실패 시 주소·전화·원문 링크 같은 정적 fallback 제공
- 일반 라이브러리와 폰트는 여전히 자체 호스팅

## 10. 외부 라이브러리 도입 게이트

### 10.1 승인 목록과 라이선스

2026-09-20 npm registry package metadata와 각 프로젝트 공식 페이지로 확인한 초기 목록입니다.

| package/asset | version | license | 배포 |
| --- | --- | --- | --- |
| Vite | 8.3.0 | MIT | 개발 도구만 |
| TypeScript | 7.0.2 | Apache-2.0 | 개발 도구만 |
| Tailwind CSS | 4.3.3 | MIT | 생성 CSS만 |
| `@tailwindcss/vite` | 4.3.3 | MIT | 개발 도구만 |
| daisyUI | 5.7.40 | MIT | 생성 CSS만 |
| Swiper | 14.2.0 | MIT | 사용 module 번들 |
| Motion | 13.4.0 | MIT | 사용 함수 번들 |
| PhotoSwipe | 5.4.4 | MIT | 선택 테마의 동적 chunk |
| Lucide | 1.47.0 | ISC | 사용 SVG/코드 번들 |
| Pretendard | 1.3.9 | OFL-1.1 | 공식 Variable 다이내믹 서브셋 CSS·WOFF2 |
| Sharp | 0.35.4 | Apache-2.0 | 개발 도구만, 고객 ZIP 제외 |
| fflate | 0.8.3 | MIT | 결정론적 ZIP 조립 도구, 고객 ZIP 제외 |

라이선스가 허용적이라는 이유만으로 고지를 생략하지 않습니다. 판매 ZIP의 `LICENSES/`와 `THIRD_PARTY_NOTICES.md`에는 실제로 포함된 자산만 기록합니다. Pretendard OFL 원문과 실제 복사한 release 자산을 함께 기록합니다.

### 10.2 신규 의존성 평가

새 라이브러리는 다음 표를 채우기 전 추가하지 않습니다.

| 평가 항목 | 통과 기준 |
| --- | --- |
| 기능 중복 | 기존 채택 라이브러리와 책임이 겹치지 않음 |
| 유지보수 | 현재 지원되는 안정판과 공개 변경 기록 존재 |
| 라이선스 | 무제한 상업 배포와 ZIP 재배포 조건을 확인하고 고지 가능 |
| 보안 | 알려진 high/critical 취약점 없음, 업데이트 경로 존재 |
| 번들 | 필요한 기능만 import 가능, 페이지 예산 안에 포함 |
| 접근성 | 키보드·ARIA·reduced motion 정책 적용 가능 |
| 오프라인 | CDN 없이 판매 ZIP에서 동작 |
| 제거 가능성 | 기능 OFF/라이브러리 누락 시 핵심 콘텐츠가 유지됨 |
| 검증 | 실제 G5 PC·모바일 화면에서 초기화/중복/충돌 검사 |

채택 시 exact version, 라이선스 원문, 저작권 고지, 사용 기능, 제거 사유를 `THIRD_PARTY_NOTICES.md`에 기록합니다.

## 11. 번들 및 성능 예산

초기 예산은 압축 전 파일 크기가 아니라 배포 gzip 크기와 실제 화면 로딩을 함께 봅니다.

| 항목 | 첫 화면 예산 |
| --- | --- |
| 공통 CSS | gzip 90KB 이하 |
| 공통 JS | gzip 80KB 이하 |
| 첫 화면 JS 전체 | gzip 140KB 이하 |
| 초기 로드 폰트 | 첫 화면에서 실제 요청된 WOFF2 합계 500KB 이하 목표, 판매 ZIP 내 전체 폰트 용량은 별도 기록 |
| 히어로 이미지 | 모바일 250KB, 데스크톱 450KB 이하 목표 |
| CLS | 0.1 이하 |
| LCP | 기준 모바일 장비·네트워크에서 2.5초 이하 목표 |

PhotoSwipe, 이미지 편집기, 지도, 영상 player처럼 첫 화면에 필요 없는 코드는 동적 import합니다. 예산을 넘기면 압축 숫자를 숨기지 않고 원인 라이브러리와 화면을 기록한 뒤 제거·지연·대체를 결정합니다.

## 12. 테마별 `AGENTS.md`

각 `themes/<category>/<theme-slug>/AGENTS.md`는 선택 사항이 아닙니다. [공통 템플릿](THEME-AGENTS.template.md)을 복사해 다음을 반드시 확정합니다.

- 상품명, 업종, 사용자, 포함/제외 범위
- 지원 G5/PHP/영카트 조건
- 디자인 방향과 token 파일
- 허용한 라이브러리와 금지한 외부 의존성
- 메뉴·페이지·게시판 map
- 수정 가능한 파일과 G5 코어 금지 경계
- Bun 명령과 패키징 경로
- PC/모바일/로그인/게시판/영카트 검사표
- 이미지·폰트·라이선스 출처
- CS 범위와 알려진 제한
- 완료 근거와 실행하지 않은 검사 표기

에이전트는 테마의 AGENTS를 읽지 않고 구현을 시작하면 안 됩니다. 테마 요구가 공통 표준과 충돌하면 조용히 우회하지 않고 ADR 또는 문서 변경으로 남깁니다.

## 13. 릴리스 패키지 규격

테마 ZIP은 다음 조건을 만족해야 합니다.

- G5의 `theme/<theme-slug>`에 복사 가능한 구조
- minified CSS/JS와 self-hosted 폰트·아이콘 포함
- 최소 오프라인 설치·롤백 문서와 버전별 온라인 매뉴얼 URL
- 지원 버전과 알려진 제한
- `LICENSE`, `THIRD_PARTY_NOTICES.md`, `ASSET-MANIFEST.json`
- 빌드 정보 파일: 소스 commit, Bun 버전, lockfile hash, 빌드 시간
- 파일 checksum 목록
- 개발 의존성, 소스맵, 테스트 데이터, 비밀값 제외

source 수정이 필요한 구매자에게는 설치 ZIP과 분리된 개발 키트를 제공합니다. 개발 키트의 자동 구축·AI 헌법·기계 계약·지원 경계는 [구매자 개발 키트 표준](CUSTOMER-DEVELOPMENT-KIT-STANDARD.md)을 따릅니다. 개발 키트 파일과 `node_modules`를 운영 서버용 설치 ZIP에 섞지 않습니다.

테마와 `jw-editor for G5`는 별도 버전으로 배포합니다. 테마가 에디터 설치를 강제하지 않으며, 에디터가 꺼져도 기본 textarea/기존 에디터 흐름이 유지되어야 합니다.

## 14. 필수 검증 게이트

### 14.1 플랫폼 골격 게이트

1. 구현 지시 뒤 macOS에서 Bun 1.4.2 `bun ci`를 재현하고, 구축된 Ubuntu 기준 환경에서도 같은 build를 재현
2. Vite·Sharp와 추가 tool의 Bun runtime compatibility spike, 필요 시 Node 24 LTS 호환 경로 확인
3. 같은 commit과 lockfile에서 산출물 hash 비교
4. Tailwind source scan 누락 검사
5. 라이선스·NOTICE·자산 manifest 검사
6. `bun audit --audit-level=high`
7. 판매 ZIP 내용 allowlist 검사
8. `bun run design:calibrate`로 고정 Impeccable engine과 규칙 최소 동작 확인

### 14.2 G5 화면 게이트

- PC/모바일 반응형
- 비회원·회원·관리자
- 게시판 목록·보기·쓰기·수정·검색·페이징
- 로그인·회원가입·약관·가입 완료·회원정보·비밀번호·프로필·폼메일
- 쪽지·포인트·스크랩
- 내용관리·FAQ·1:1 문의
- 통합검색·새글·현재접속자·인기검색어·방문자·설문
- 최신글·외부로그인과 PC·모바일 skin
- 영카트 미사용/사용 양쪽
- 팝업·캡차·쪽지 등 G5 기본 overlay
- 테마가 라이트·다크를 제공하면 위 공개 화면 전체를 두 상태로 반복 검사
- 키보드만으로 메뉴·슬라이더·dialog 사용
- reduced motion와 고대비/200% 확대
- JavaScript 실패 시 메뉴·본문·CTA fallback

### 14.3 테마별 시각 게이트

- 실제 업종 데이터와 실제 비율 이미지 사용
- 360/390/768/1440px 대표 폭 캡처
- 헤더 초기/아래 스크롤/위 스크롤/모바일 메뉴 상태
- Swiper 1장/2장/긴 제목/이미지 실패 상태
- 패럴랙스 ON/OFF/reduced motion 비교
- 폰트 로딩 전후 레이아웃 이동
- G5 기본 CSS와 관리자·플러그인 CSS 충돌
- 라이트·다크 전환 직후 배경·글자·테두리·이미지 overlay·폼·표의 대비와 색상 깜빡임

## 15. 업데이트 정책

- 월 1회 의존성 보안·유지 상태를 검토합니다.
- high/critical 보안 문제는 정기 주기보다 우선합니다.
- minor/patch도 자동 병합하지 않고 build·G5 browser gate를 통과시킵니다.
- major upgrade는 별도 branch와 시각 회귀 비교가 필요합니다.
- 판매 후 1년 업데이트 범위는 보안 패치, 지원 G5/PHP 호환, 상품 자체 오류입니다.
- 로고 교체 위치, 색상 변경법, 개별 사이트 제작·콘텐츠 입력은 오류 지원이 아니라 온라인 매뉴얼·유상 작업 범위입니다.

## 16. 첫 구현 전에 남은 증명 작업

다음은 결정이 아니라 실제 코드로 증명해야 하는 항목입니다.

1. Bun 1.4.2 + Vite 8.3.0 + TypeScript 7.0.2 + Sharp 0.35.4의 canonical build runtime 확정
2. Tailwind Preflight 제외와 `tw:`/`d-` prefix가 G5 화면 충돌을 막는지 확인
3. Swiper 14의 지원 브라우저와 실제 G5 마크업 접근성
4. Motion 패럴랙스가 모바일 성능 예산을 만족하는지 확인
5. Pretendard Variable 다이내믹 서브셋의 첫 화면 요청 수·전송량과 fallback 전환 시 CLS
6. MariaDB 10.11/MySQL 8.4에서 G5 설치·게시판·영카트 smoke
7. PHP 8.3/8.4/8.5에서 warning·deprecated를 오류로 올린 검사

이 일곱 항목이 통과해야 “공통 기술스택 구현 완료”로 보고합니다.

## 17. 근거 자료

### 공식·1차 자료

- [PHP 지원 버전](https://www.php.net/supported-versions.php)
- [MySQL 8.4 LTS 릴리스 모델](https://dev.mysql.com/doc/refman/8.4/en/mysql-releases.html)
- [MariaDB 유지보수 기간](https://mariadb.org/about/#maintenance-policy)
- [Bun workspace catalog](https://bun.sh/docs/pm/catalogs)
- [Bun 1.4.2 release](https://github.com/oven-sh/bun/releases/tag/bun-v1.4.2)
- [Bun Node.js compatibility](https://bun.sh/docs/runtime/nodejs-compat)
- [Bun 재현 설치와 minimum release age](https://bun.sh/docs/pm/cli/install)
- [Bun lifecycle script와 trustedDependencies](https://bun.sh/docs/pm/lifecycle)
- [Bun audit](https://bun.sh/docs/pm/cli/audit)
- [Tailwind CSS Vite 설치](https://tailwindcss.com/docs/installation/using-vite)
- [Tailwind CSS 브라우저 기준](https://tailwindcss.com/docs/compatibility)
- [Tailwind Preflight 제외 방법](https://tailwindcss.com/docs/preflight)
- [daisyUI 설치](https://daisyui.com/docs/install/)
- [daisyUI prefix와 component 선택](https://daisyui.com/docs/config/)
- [Swiper 모듈·A11y API](https://swiperjs.com/swiper-api)
- [Motion scroll](https://motion.dev/docs/scroll)
- [Motion inView](https://motion.dev/docs/inview)
- [PhotoSwipe progressive enhancement](https://photoswipe.com/getting-started/)
- [Lucide SVG·tree shaking·ISC](https://lucide.dev/)
- [Pretendard 공식 README와 Variable 다이내믹 서브셋](https://github.com/orioncactus/pretendard/tree/main/packages/pretendard)
- [Pretendard 다이내믹 서브셋 설계](https://github.com/orioncactus/pretendard/discussions/169)

### 현재 저장소 확인 자료

- `.runtime/gnuboard5/version.php`: G5 5.6.391
- `.runtime/gnuboard5/README.md`: G5 자체 레거시 PHP/DB 요구 사항
- `.runtime/gnuboard5/plugin/editor/`: 현재 포함 편집기 확인
- 패키지 버전·라이선스: 2026-09-20 npm registry `latest` 메타데이터 조회
