# 메인 7종 디자인 인계 — 2026-09-28

## Overview

이 문서는 **형님께 검토받을 메인 7종의 현재 구현 의도와 편집 책임**을 기록합니다. 기존 디자인 세계를 개선한 결과이며, 새 디자인 시스템이나 전체 상품 승인 선언이 아닙니다. 근거는 현행 PHP·CSS·스크립트·자산 원본과 아래 검사 기록입니다. [DESIGN.md](../DESIGN.md)와 [.impeccable/design.json](../.impeccable/design.json)은 수정하지 않았습니다.

공통 언어는 로컬 Pretendard, `jw-light`·`jw-dark` 의미 색상, 정보 역할이 있는 큰 아이콘과 사진입니다. 각 페이지의 선택 가치는 다음 순서와 매체 조합에 있습니다. 아래 수량은 최상위 콘텐츠 영역 기준이며, 히어로 내부 슬라이드나 상세 탭 패널은 별도 섹션으로 세지 않습니다.

| 대상·수정 PHP 원본 | 영역 | 보존할 흐름·시각적 중심 |
| --- | ---: | --- |
| Main 1 — [index.php](../src/php/index.php), [index_1.php](../src/php/index_1.php) | 12 | 종합 서비스. 사진 히어로 → 큰 서비스 SVG → 업종 모자이크 → 결정 지도 → 제작 과정 → PC·모바일 화면 견본 → 비대칭 사례 → 브랜드 사진 → 표현 보드 → FAQ → 실제 최신글 → 문의입니다. 전략·디지털·브랜드를 폭넓게 선택하게 합니다. |
| Main 2 — [index_2.php](../src/php/index_2.php) | 9 | 판단과 근거. 사진 히어로 → 시작점 → 고객 여정 → 우선순위 매트릭스 → 지표 화면 견본 → 관찰 근거표 → 인계물 → 판단 과정 → 문의입니다. 큰 Lucide와 자료의 구조가 사업 설명을 받칩니다. |
| Main 3 — [index_3.php](../src/php/index_3.php) | 8 | 매체별 결과물. 교통 사인 히어로 → 소개 → 방향 지도 → 인쇄물 → 전시 설치 → FIELDNOTE 화면 견본 → 세 읽는 거리 → 문의입니다. 사인·인쇄·전시 사진의 관찰 거리와 실제 SVG 동선이 다릅니다. 전시 사진을 같은 페이지의 웹 시안에 다시 쓰는 것은 동일 프로젝트의 매체 연결입니다. |
| Main 4 — [index_4.php](../src/php/index_4.php) | 9 | FORME 한 사례의 완성 과정. 제품 히어로 → 큰 과정 아이콘 → 발견·브리프 → 고객 여정 → 웹 시안 → 브랜드·패키지 → 인계 → FAQ → 문의입니다. 사진, 여정, 화면, 브랜드 보드가 같은 사례를 이어갑니다. |
| 제품형 — [onepage-showcase.php](../pages/onepage-showcase.php) | 8 | 가상 오디오 AURA. 제품 히어로 → 재료 특징 → 확대 사진 → 생활 장면 → 상세 탭 → 기능 설명용 큰 아이콘 → FAQ → 문의입니다. 같은 물체의 전체·재료·생활 사진과 크기·설치 SVG가 다른 질문에 답합니다. |
| 서비스형 — [onepage-services.php](../pages/onepage-services.php) | 9 | 서비스 선택과 상담 준비. 벽면 워크숍 히어로 → 큰 서비스 아이콘 → 고객 질문의 연결 → PARTNER 화면 견본 → 업종 적용 → 협업 자료 사진 → 인계물 → FAQ → 상담입니다. 카드도 선택·여정·적용·인계에 따라 역할과 배열이 다릅니다. |
| 공간형 — [onepage-projects.php](../pages/onepage-projects.php) | 7 | 공간의 쓰임과 체류 경험. 정원 건축 히어로 → 의도 → 실제 SVG 개념 동선 → 실내 → 재료 상세 → 세 장면 갤러리 → 문의입니다. 사진의 연속 사이에서 평면 도해가 입구·정원·라운지의 관계를 설명합니다. |

가상 회사·프로젝트·제품과 시연 수치 고지를 유지합니다. 화면 견본은 정보 배치를 보여 주는 HTML 자료이며, 사진이나 견본 숫자를 실제 고객 실적·제품 성능·서비스 운영 증거로 바꾸어 설명하지 않습니다.

## Colors

색상 값은 [theme.css](../src/styles/theme.css)의 daisyUI 테마 정의가, 의미 연결은 [theme.tokens.json](../tokens/theme.tokens.json)이 소유합니다. `surface → base-100`, `surface-muted → base-200`, `text → base-content`, `brand/focus → primary` 연결을 유지합니다. [generated/tokens.css](../generated/tokens.css)와 [generated/tailwind-theme.css](../generated/tailwind-theme.css)는 생성물입니다.

| 역할 | jw-light | jw-dark |
| --- | --- | --- |
| 본 표면 `base-100` | `oklch(100% 0 0)` | `oklch(24.353% 0 0)` |
| 글자 `base-content` | `oklch(22.389% 0.031 278.072)` | `oklch(84.87% 0 0)` |
| 주요 행동 `primary` | `oklch(51% 0.145 241.966)` | `oklch(41.703% 0.099 251.473)` |
| 주요 행동 위 글자 `primary-content` | `oklch(100% 0 0)` | `oklch(88.34% 0.019 251.473)` |

**의미 색상 쌍 유지:** 본문·표면·선택 상태는 대응하는 content 색과 함께 편집합니다. 페이지 전용 `color-mix`는 그 페이지의 원본에 둡니다. AURA의 월넛·샴페인 금속, FORME의 Forest·Sage·Ivory는 사진·작품 내부의 정체성입니다. 사이트 UI 전체 팔레트로 확대하지 않습니다.

F1 보정은 Main 1 모바일 화면 견본의 링과 브랜드 보드의 원을 `neutral-content`로, 보드의 세 번째 칩을 `neutral-content`와 가시 경계로 표현합니다. 칩의 접근성 설명도 실제 의미 색과 일치시켰습니다. 다크에서 검은 도형이 배경에 묻히던 값을 향후 기준으로 복구하지 않습니다.

## Typography

로컬 Pretendard Variable을 공유하되, 메인별 제목 크기를 단일 값으로 통합하지 않습니다. 예를 들어 Main 1 히어로는 `clamp(52px, 5.65vw, 91px)`/800, Main 2는 `clamp(50px, 5.5vw, 82px)`/700, Main 3은 `clamp(62px, 8vw, 112px)`를 사용합니다. 원페이지 공용 H2는 `clamp(2rem, 3.6vw, 3.5rem)`/700이며 AURA 등에는 목적별 별도 제목 크기가 있습니다. 실제 적용과 모바일 값은 해당 CSS의 뒤쪽 재정의까지 확인합니다.

F3에서 제거한 장식 문구는 Main 1 `CONTENT TO EXPERIENCE`, Main 3 `SELECTED WORK / 01—04`·`FOUR DIFFERENT OUTCOMES`·`NEXT PROJECT`, 공간형 `SPATIAL ROUTE / 01—03`입니다. 이 다섯 문구를 공통 eyebrow 규칙으로 재도입하지 않습니다. 과정 번호·도해 라벨·작품 안의 브랜드·시연 고지는 각자의 정보이므로 일괄 제거하지 않습니다.

## Layout

**본문 직접 소유:** 각 PHP가 초기화·제목·head·전체 본문·tail을 소유합니다. 홈 선택은 `index_N.php`를 `index.php`로 복사하는 방식입니다. Main 1은 기본 홈과 선택용 홈을 함께 확인합니다. 원페이지는 설치 사이트의 웹루트 `/pages/`에 배치합니다. 런타임 dispatcher·partials·sections include를 새로 만들지 않습니다. 상세 경계는 [STRUCTURE-CONTRACT.md](STRUCTURE-CONTRACT.md)를 따릅니다.

Main 2 본문은 최대 1280px/좌우 합계 48px, Main 4는 최대 1280px/좌우 합계 96px, 원페이지 공용 본문은 최대 1200px/좌우 합계 96px입니다. AURA 히어로는 최대 1440px입니다. 모바일에서 각각의 원본이 여백·열·사진 크롭을 조정합니다. Main 1의 700px, Main 3·원페이지의 767px, Main 4의 1100/800/560px 등 현재 전환점을 임의로 하나로 합치지 않습니다.

F2에서 Main 1 모바일 결정 지도는 `viewBox="0 0 320 430"`의 독립 SVG로 바뀌었습니다. 질문·가설 뒤에서 검증된 선택은 실행하고 근거가 부족한 선택은 보류하는 관계를 보여 줍니다. PC SVG를 글자까지 축소하거나 다음 제작 과정과 같은 세로 글 목록으로 되돌리지 않습니다. F3 후속 보정은 Main 3 소개의 두 자식(제목·설명)을 `1.35fr .65fr` 두 열에 배치하며 모바일 한 열 전환을 유지합니다.

## Elevation & Depth

자료와 화면 견본에는 페이지별 그림자가 실제로 사용됩니다. Main 1 결정 지도·화면 견본, Main 2 지표 화면, Main 3 FIELDNOTE 화면의 깊이는 해당 자료의 경계를 드러내는 용도입니다. 이 값을 모든 카드나 버튼의 공통 그림자로 확장하지 않습니다.

Motion은 등장과 스크롤 연출을, Embla는 슬라이더와 갤러리를 담당합니다. DTCG 동작 값은 피드백 180ms·순차 지연 70ms·등장 420ms·주목 620ms·등장 거리 16px·`cubic-bezier(0.16, 1, 0.3, 1)`입니다. 줄인 동작에서도 내용과 필수 조작은 남아야 합니다.

## Shapes

공통 box/field 모서리는 `var(--radius-box)`·`var(--radius-field)`를 사용하며 현재 두 모드 모두 0.25rem입니다. 컨트롤·칩·사진·화면 견본의 모양을 한 값으로 강제하지 않습니다. Main 1의 브랜드 링, Main 3의 방향 화살표, FORME의 패키지, AURA의 월넛 곡면, 공간형의 평면 선은 각 사례의 설명 장치입니다.

큰 아이콘은 장식 면적을 채우는 대신 서비스·과정·재료·인계물의 차이를 전달합니다. Main 1의 직접 작성된 서비스 SVG는 72×72 viewBox를 유지합니다. Main 3 방향 보드의 Lucide는 68px, 서비스형 서비스 아이콘은 PC 80px/모바일 64px, AURA 특징 아이콘은 PC 64px/모바일 52px입니다. 조작용 작은 화살표와 같은 크기로 줄이지 않습니다.

## Components

### 편집 원본과 생성 책임

| 수정 책임 | 원본 | 생성·사용 결과 |
| --- | --- | --- |
| Main 1 배치·그래픽 | [home-one.css](../src/styles/home-one.css) | `theme/css/home-one.min.css` |
| Main 2 배치·자료 | [home-2.css](../src/styles/home-2.css) | `theme.css` import → `theme/css/jw-business.min.css` |
| Main 3 배치·자료 | [home-variants.css](../src/styles/home-variants.css) | `theme.css` import → `theme/css/jw-business.min.css`; 기존 다른 선택자도 있으므로 영향을 확인합니다. |
| Main 4 배치·작품 | [home-four.css](../src/styles/home-four.css) | `theme/css/home-four.min.css` |
| 원페이지 3종 | [onepages.css](../src/styles/onepages.css) | `theme/css/onepages.min.css`; 세 페이지를 함께 재확인합니다. |
| 테마 의미 토큰·공통 정의 | [theme.tokens.json](../tokens/theme.tokens.json), [theme.css](../src/styles/theme.css) | DTCG 생성 CSS·Tailwind 4 `tw:`/`@apply`·daisyUI 5 `jw-light`/`jw-dark` → Vite |
| 설치 자산 조립 | [vite.config.ts](../vite.config.ts), [build-payload.ts](../scripts/build-payload.ts) | `build/vite/` → `theme/`; 웹루트 페이지는 `pages/`의 독립 원본을 배포하며 build에서 개수·구조를 확인합니다. |

빌드는 테마 루트의 `bun run build`로 토큰 → Vite 자산 → payload 순서로 실행합니다. 고정 버전은 [package.json](../package.json)에 있습니다. 생성 CSS·JS·`theme/`를 손으로 수정하지 않습니다. 고객 서버에는 빌드 도구 없이 생성 자산을 포함한 설치물을 제공합니다.

### 동작·아이콘 소유권

| 대상 | 동작 원본 | 보존할 행동 |
| --- | --- | --- |
| Main 1 | [home-one-entry.ts](../src/scripts/home-one-entry.ts), [home-one.ts](../src/scripts/home-one.ts) | Embla + Fade + Autoplay(6.5초), 이전/다음·현재 위치·재생/정지·키보드·비활성 슬라이드 접근성입니다. Motion `inView`와 데스크톱 과정 레일 `scroll`이 있으며 줄인 동작에서 자동 재생·레일 연출을 제한합니다. |
| Main 2 | [home-2.ts](../src/scripts/home-2.ts), [theme.ts](../src/scripts/theme.ts) | Embla 히어로, 선택 버튼의 `aria-pressed`, 이전/다음·키보드·재생/정지와 화면 노출·문서 가시성·줄인 동작 처리입니다. 현행 자동 재생 제어를 별도 신규 슬라이더로 복제하지 않습니다. |
| Main 4 | [home-four-entry.ts](../src/scripts/home-four-entry.ts) | 필요한 Lucide만 등록하고 `inView` 등장만 더합니다. JS 이전·실패·줄인 동작에서도 본문을 읽을 수 있습니다. |
| 원페이지 | [onepages-entry.ts](../src/scripts/onepages-entry.ts), [onepages.js](../src/scripts/onepages.js) | `data-jwo-icon` 전용 Lucide, 섹션 내비게이션, AURA 상세 탭, 공간형 Embla 갤러리, Motion 등장·사진 깊이입니다. 탭은 좌우/Home/End·선택 상태·포커스를, 갤러리는 이전/다음·키보드·순서 안내를 유지합니다. |

원페이지 사진 깊이는 767px 이하·줄인 동작·데이터 절약에서 정지합니다. AURA 상세 패널은 JS가 없으면 전체 정보가 남고, 갤러리 조작은 Embla 초기화 뒤 노출됩니다. 새 라이브러리나 같은 역할의 타이머·스크롤 감지기를 추가하지 않습니다.

### 사진·원본 이력

신규 원본은 **5개**입니다. 정확한 생성 prompt, 생성 PNG 경로, 참조 편집 관계는 [MAIN-SEVEN-ASSETS-2026-09-28.json](MAIN-SEVEN-ASSETS-2026-09-28.json)에 있습니다. WebP 옆의 `.webp.json`은 prompt와 생성 시각 출처입니다. 이 기록을 최종 사용 범위·검수 통과 기록으로 오인하지 않습니다.

| WebP 수정 원본 | 소유 페이지·역할 |
| --- | --- |
| [aura-hero.webp](../onepages/assets/images/aura-hero.webp) | 제품형의 동일 제품 정체성을 정하는 전체 사진입니다. |
| [aura-detail.webp](../onepages/assets/images/aura-detail.webp) | 히어로를 참조한 월넛·금속 다이얼·패브릭 접합 확대 사진입니다. |
| [aura-living.webp](../onepages/assets/images/aura-living.webp) | 히어로를 참조한 같은 제품의 실제 크기감과 생활 배치 콘셉트입니다. |
| [service-journey-workshop.webp](../onepages/assets/images/service-journey-workshop.webp) | 서비스형 첫 화면의 벽면 고객 여정 협업 장면입니다. 기존 `service-workshop.webp`는 후반 자료 검토 사진으로 역할을 유지합니다. |
| [exhibition.webp](../src/assets/home-three/exhibition.webp) | Main 3 전시 그래픽 결과물과 FIELDNOTE 시안의 동일 전시 소재입니다. |

위 원본은 build에서 `theme/onepages/assets/images/` 또는 `theme/assets/home-three/`로 들어갑니다. prompt 목록·`.webp.json` sidecar는 설치 payload에 넣지 않습니다. [quality/assets.json](../quality/assets.json)의 원본·사용 페이지 등록과 [ASSET-MANIFEST.json](../ASSET-MANIFEST.json)의 배포 자산 이력을 함께 유지합니다.

**NODE 폐기 결정:** 이전 NODE 포스터와 회전 프레임 36장은 AURA 상품 payload에서 제외했습니다. `onepages/assets/images/node-poster.webp`와 `onepages/assets/sequence/node-001.webp`~`node-036.webp` 소스는 보존합니다. [check-build.ts](../scripts/check-build.ts)가 폐기 자산의 payload 재유입을 실패 처리합니다. AURA 제품형을 NODE 회전 프레임 연출로 되돌리거나 보존 소스를 이유로 다시 배포하지 않습니다.

### 검사 증거와 승인 경계

아래는 문서화 시 확인한 확정 로그 상태입니다. 독립 검토 기록의 최종 시각은 **2026-09-28 02:27:49 UTC**이며 MD·JSON의 입력 digest는 `47292a2d84ea5e6025a9826481a547ad17cdb1098e5be3ccd5826b69a890e8ef`로 일치합니다. 문서화 에이전트가 브라우저 검사나 배포를 새로 실행한 것은 아닙니다.

| 증거 | 확인한 결과·범위 |
| --- | --- |
| [ui-final.log](../../../../output/qa/main-seven-improvement-20260928/ui-final.log) | 최종 소스·배포 기준 7종 × PC/모바일 × 라이트/다크 **28 passed**입니다. [ui-review-fix.log](../../../../output/qa/main-seven-improvement-20260928/ui-review-fix.log)의 앞선 28 pass와 구분합니다. |
| [deploy-hashes.json](../../../../output/qa/main-seven-improvement-20260928/deploy-hashes.json) | `g5themes.test` 개발 환경에 반영한 **172파일 해시 일치**, 불일치 0건입니다. 판매 ZIP이나 별도 운영 환경 증거는 아닙니다. |
| [foundation-final.log](../../../../output/qa/main-seven-improvement-20260928/foundation-final.log) | Foundation passed, 테마 회귀 64 pass/0 fail입니다. 상품 품질·브라우저 판정은 별도라는 로그 경계를 유지합니다. |
| [harness-final.log](../../../../output/qa/main-seven-improvement-20260928/harness-final.log) | 9 pass/0 fail입니다. 하네스 자체 회귀 증거입니다. |
| [interactions-final.log](../../../../output/qa/main-seven-improvement-20260928/interactions-final.log) | 실제 상호작용 **40개 수집 완료**입니다. 수집 로그는 독립 시각/동작 승인과 별도입니다. |
| [독립 검토 MD](../../../../docs/MAIN-SEVEN-INDEPENDENT-REVIEW-2026-09-28.md), [JSON](../../../../docs/MAIN-SEVEN-INDEPENDENT-REVIEW-2026-09-28.json) | 최초 `fix` → 최종 `ship`/`pass`입니다. F1/F2/F3 및 Main 3 소개 회귀 R1 해결을 확인했고 7페이지의 목적·이미지·구성 21항목과 변형 9쌍 비교가 pass입니다. 최종 ship은 점수화한 수정과 그 회귀 범위이며, 전체 화면·동작·상품 출시 인증으로 확대하지 않습니다. `interactionsReviewed: false` 경계를 유지합니다. |

전체 `quality:check`는 일반 페이지 사진 재사용 6건 및 나머지 기존 미설계·미검토 페이지 때문에 차단 상태입니다. 전체 `styles:check`도 이번 범위 밖 `theme.css`·`company-overview.css` 29건 실패를 유지합니다. 이 문서는 실패를 경고로 낮추거나 7종을 예외 처리하지 않습니다. 판매 ZIP 설치·업데이트·롤백, 회원 기능 전체, 실물 기기의 터치 검증, 전체 테마·판매 승인은 이 증거에 포함되지 않습니다. 절차는 [quality/README.md](../quality/README.md)를 따릅니다.

## Do's and Don'ts

- Do 페이지의 목적·사진 거리·큰 아이콘·실제 도해·화면 견본 역할을 먼저 보존합니다. 섹션 수만 늘리거나 새 취향·라이브러리를 더하지 않습니다.
- Do 원본을 바꾼 뒤 재빌드하고 영향받는 4상태를 다시 수집·검토합니다. 기존 승인 기록을 새 digest로만 고쳐 재사용하지 않습니다.
- Do Main 1 F1/F2, 지정 다섯 장식 영문의 제거, Main 3 소개 두 열 후속 보정을 함께 보존합니다.
- Don't 가상 결과물을 실제 실적·사양으로, 검사 통과를 판매·회원·설치 검증으로 확대하지 않습니다.
- Don't 기존 `DESIGN.md`와 `.impeccable/design.json`을 이 인계 작업에서 재작성하거나 페이지 전용 값을 전역 규칙으로 승격하지 않습니다.

**관찰한 문서 drift:** 기존 `DESIGN.md`의 깊이 설명은 그림자 사용처를 메뉴·모달·헤더·버튼 위주로 한정하지만 현재 메인의 자료·화면 견본에도 그림자가 있습니다. 기존 sidecar는 공통 컴포넌트 중심이며 이번 AURA·서비스 화면·공간 도해와 최종 보정을 별도로 담지 않습니다. 이번 범위는 페이지 인계이므로 두 파일을 수정하지 않았고, 이 차이를 새 전역 금지나 결함을 정당화하는 토큰으로 만들지 않았습니다.
