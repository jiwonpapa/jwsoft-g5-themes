---
name: JW-Business
description: 독립 G5 PHP와 네이티브 스킨으로 제공하는 기업·전문 서비스 테마의 현재 디자인 기준
colors:
  light-primary: "oklch(51% 0.145 241.966)"
  light-primary-content: "oklch(100% 0 0)"
  light-base-100: "oklch(100% 0 0)"
  light-base-200: "oklch(93% 0 0)"
  light-base-300: "oklch(86% 0 0)"
  light-base-content: "oklch(22.389% 0.031 278.072)"
  light-secondary: "oklch(55% 0.046 257.417)"
  light-secondary-content: "oklch(100% 0 0)"
  light-accent: "oklch(60% 0.118 184.704)"
  light-accent-content: "oklch(100% 0 0)"
  light-success: "oklch(62% 0.194 149.214)"
  light-success-content: "oklch(100% 0 0)"
  light-warning: "oklch(85% 0.199 91.936)"
  light-warning-content: "oklch(0% 0 0)"
  light-error: "oklch(70% 0.191 22.216)"
  light-error-content: "oklch(0% 0 0)"
  light-info: "oklch(60% 0.126 221.723)"
  light-info-content: "oklch(100% 0 0)"
  dark-primary: "oklch(41.703% 0.099 251.473)"
  dark-primary-content: "oklch(88.34% 0.019 251.473)"
  dark-base-100: "oklch(24.353% 0 0)"
  dark-base-200: "oklch(22.648% 0 0)"
  dark-base-300: "oklch(20.944% 0 0)"
  dark-base-content: "oklch(84.87% 0 0)"
  dark-secondary: "oklch(64.092% 0.027 229.389)"
  dark-secondary-content: "oklch(12.818% 0.005 229.389)"
  dark-accent: "oklch(67.271% 0.167 35.791)"
  dark-accent-content: "oklch(13.454% 0.033 35.791)"
  dark-success: "oklch(70.226% 0.094 156.596)"
  dark-success-content: "oklch(14.045% 0.018 156.596)"
  dark-warning: "oklch(77.482% 0.115 81.519)"
  dark-warning-content: "oklch(15.496% 0.023 81.519)"
  dark-error: "oklch(51.61% 0.146 29.674)"
  dark-error-content: "oklch(90.322% 0.029 29.674)"
  dark-info: "oklch(62.616% 0.143 240.033)"
  dark-info-content: "oklch(12.523% 0.028 240.033)"
typography:
  page-title:
    fontFamily: "\"Pretendard Variable\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", \"Noto Sans KR\", sans-serif"
    fontSize: "clamp(2rem, 4vw, 3.4rem)"
    fontWeight: 650
    lineHeight: 1.14
  section-heading:
    fontFamily: "\"Pretendard Variable\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", \"Noto Sans KR\", sans-serif"
    fontSize: "clamp(2rem, 4vw, 4rem)"
    fontWeight: 640
    lineHeight: 1.16
    letterSpacing: "-0.045em"
  field-label:
    fontFamily: "\"Pretendard Variable\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", \"Noto Sans KR\", sans-serif"
    fontSize: "13px"
    fontWeight: 650
  button:
    fontFamily: "\"Pretendard Variable\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", \"Noto Sans KR\", sans-serif"
    fontSize: "14px"
    fontWeight: 650
  badge:
    fontSize: "12px"
    fontWeight: 700
  card-body:
    fontFamily: "\"Pretendard Variable\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", \"Noto Sans KR\", sans-serif"
    fontSize: "14px"
    lineHeight: 1.7
rounded:
  box: "0.25rem"
  field: "0.25rem"
  selector-light: "0.25rem"
  selector-dark: "0rem"
  control: "8px"
  pill: "999px"
spacing:
  label-gap: "8px"
  field-gap: "16px"
  shell-gutter: "24px"
components:
  button-primary:
    backgroundColor: "var(--color-primary)"
    textColor: "var(--color-primary-content)"
    rounded: "{rounded.control}"
    padding: "0 20px"
    typography: "{typography.button}"
  control-quiet:
    backgroundColor: "var(--color-base-100)"
    textColor: "var(--color-base-content)"
    rounded: "{rounded.control}"
    height: "48px"
    padding: "0 16px"
    typography: "{typography.button}"
  field:
    backgroundColor: "var(--color-base-100)"
    textColor: "var(--color-base-content)"
    rounded: "{rounded.control}"
    height: "48px"
    padding: "0 13px"
  badge:
    backgroundColor: "var(--color-base-200)"
    rounded: "{rounded.pill}"
    padding: "0 8px"
    typography: "{typography.badge}"
  media:
    backgroundColor: "var(--color-base-200)"
    rounded: "{rounded.box}"
---

# Design System: JW-Business

## Overview

**Creative North Star: "기업 정보와 작업 결과"**

기업·전문 서비스의 정보와 실제로 보여 줄 수 있는 결과물을 명확하게 구성하는 상업용 G5 테마입니다. 로컬 Pretendard, 의미 색상, 읽기 쉬운 컨트롤을 공통 언어로 쓰되, 각 페이지는 목적에 맞는 사진·큰 아이콘·자료·섹션 구도의 조합으로 서로 다른 선택 이유를 제공해야 합니다.

이 문서는 2026-09-27 현재 구현의 재사용 기준입니다. [PRODUCT.md](PRODUCT.md)의 대상·독립 테마·커뮤니티 범위는 유지하되, 과거 진행 상태를 현재 화면의 디자인 진실로 재사용하지 않습니다. 시각 기준의 우선순위는 현재 DTCG 의미 연결과 원본 CSS → 실제 G5 화면 → 이 문서 → 개별 페이지의 과거 기록입니다. 기존 구현 전체가 이 기준을 충족했다는 선언은 아닙니다.

형님의 우선순위는 상업용 테마로 쓸 수 있는 충분한 섹션 변화와 정보 역할이 있는 큰 아이콘입니다. 특정 도구의 일반적인 카드 없는 4섹션 랜딩 규칙보다 이 요구와 페이지 목적이 우선합니다. 카드·표·사진·다이어그램을 금지하거나 모두 같은 조합으로 고정하지 않습니다.

**Key Characteristics:**

- jw-light·jw-dark 의미 색상과 로컬 Pretendard
- 목적이 분명한 사진·대형 Lucide 아이콘·실제 HTML 자료
- 여러 섹션과 서로 구별되는 상업용 페이지 변형
- 독립 PHP와 G5 네이티브 스킨의 직접 수정 가능성

## Colors

색상 원본은 [theme.css](src/styles/theme.css)의 daisyUI `jw-light`·`jw-dark` 정의입니다. YAML의 모드별 값은 현행 소스에서 추출했습니다. [DTCG 원본](tokens/theme.tokens.json)은 `surface → base-100`, `surface-muted → base-200`, `text → base-content`, `brand/focus → primary`, `brand-contrast → primary-content`, `border → base-300`, `danger → error`를 연결합니다. [generated/tokens.css](generated/tokens.css)와 [generated/tailwind-theme.css](generated/tailwind-theme.css)는 생성물이므로 직접 편집하지 않습니다.

### Primary

청색 계열의 `primary`는 주요 행동·선택·포커스를 담당하고 `primary-content`는 그 위의 글자색입니다. 밝은 화면의 원본 primary는 현재 frontmatter의 `light-primary`를 따릅니다. [MAIN-4-DESIGN](docs/MAIN-4-DESIGN.md)은 이 공통 기준을 상속하고 작품 내부의 색상만 별도로 정의합니다. 페이지 문서의 스냅샷보다 현재 원본을 우선합니다.

### Secondary

`secondary`와 `accent`는 기존 테마에 정의된 보조 의미 색상입니다. 라이트의 청록 accent와 다크의 따뜻한 accent를 임의의 동일 고정 색으로 덮지 않습니다. 성공·경고·오류·정보는 해당 상태 토큰과 그 content 색의 짝을 사용합니다.

### Neutral

`base-100/200/300`은 본 표면·보조 표면·경계, `base-content`는 텍스트입니다. 옅은 글자와 표면 변화는 현행 CSS의 `color-mix`로 파생합니다. DTCG의 `text-muted` 자체는 현재 `base-content`를 가리키므로 별도의 회색 값이 있다고 가정하지 않습니다.

**The Semantic Pair Rule.** 색상과 그 위의 content 색을 함께 사용하고 두 모드에서 읽기·선택·상태 전달을 확인합니다.

FORME처럼 페이지 안에 보이는 가상 브랜드 작품의 색은 해당 작품 범위의 자료입니다. 사이트의 버튼·헤더·본문 팔레트로 확대하지 않습니다. 별도 합성 tonal ramp를 만들지 않고 현재 원본값을 보존합니다.

## Typography

제목·본문·컨트롤은 로컬 Pretendard Variable을 공유합니다. 가변 굵기와 촘촘한 한글 제목을 활용하되, 본문과 설명의 읽기 흐름을 우선합니다. 위 계층은 공용 페이지 제목·섹션 제목·입력 라벨·버튼·배지·게시물 카드에서 추출한 역할이며 모든 메인에 강제로 적용할 단일 display scale이 아닙니다.

일반 페이지 제목은 650 굵기, 공용 섹션 제목은 640 굵기, 단일 행 컨트롤은 14px/650을 사용합니다. 커뮤니티 작업 화면은 제목을 낮추고 입력·실제 콘텐츠를 먼저 보이게 합니다. Main 4 등 별도 메인의 제목 크기·행간·카피 제한은 전용 스타일과 설계 문서를 따릅니다.

[CONTENT-BOUNDS](quality/CONTENT-BOUNDS.json)의 현재 편집 계약은 공백 포함 H1 8–56자, H2 4–60자, 문단 최대 260자, 버튼 최대 24자입니다. 길이가 늘면 390px·1440px에서 다시 렌더링합니다. 글자를 무조건 줄이는 방식으로 넘침을 숨기지 않습니다.

## Layout

공용 shell은 `min(100% - 48px, 1280px)`, 일반 페이지 본문은 `min(100% - 48px, 1180px)`입니다. 공용 본문 상단은 가변 여백 `clamp(48px, 7vw, 96px)`를 사용합니다. 폼은 16px 간격의 두 열에서 내용과 화면에 따라 재배치합니다. 반응형 전환은 공용 shell·회원/게시판·개별 메인 스타일이 각각 소유하므로 한 breakpoint 체계로 임의 통합하지 않습니다.

메인·일반 페이지는 도입, 사업 정보, 선택 근거, 과정, 사례, 자료, 질문, 연락 등 해당 목적에 필요한 흐름을 구성합니다. 사진 교차, 큰 아이콘 카드, 비교표, 단계 레일, 비대칭 갤러리, 자료 보드가 서로 다른 정보 역할을 가져야 합니다. 빈 여백을 없애기 위한 반복 카드나 섹션 수만 채우는 장식을 추가하지 않습니다. [PATTERN-INVENTORY](docs/PATTERN-INVENTORY.md)는 현재 원본을 찾는 색인이고 [MAIN-4-DESIGN](docs/MAIN-4-DESIGN.md)은 해당 페이지의 상세 사례입니다.

## Elevation & Depth

기본 표면은 의미 색상과 경계로 구분합니다. 다단 메뉴·검색 모달·스크롤된 헤더·상호작용 중인 주요 버튼에만 현행 역할별 그림자를 사용합니다. daisyUI의 기본 `depth`와 `noise`는 모두 0입니다. 그림자와 focus 값은 스키마에 맞춰 사이드카에 기록합니다.

Motion은 필요한 `inView`·`scroll` 연출, Embla는 슬라이더를 담당합니다. DTCG의 피드백 180ms·순차 지연 70ms·등장 420ms·주목 620ms·등장 거리 16px·out easing을 우선 사용합니다. 기존 공용 컨트롤의 160ms 전환도 별도 현행 값으로 보존합니다. 줄인 동작 설정에서는 정보를 숨기거나 필수 행동을 막지 않습니다.

## Shapes

daisyUI box·field는 두 모드 모두 0.25rem이고 selector는 라이트 0.25rem/다크 0rem입니다. 공용 실행 버튼과 필드는 8px, 배지는 999px 둥근 모서리를 사용합니다. 이미지·특수 자료 보드는 해당 페이지 규칙을 따릅니다. 전역적으로 모든 요소를 하나의 모서리 값에 맞추지 않습니다.

## Components

- **주요 행동:** 공용 메인 버튼은 primary/content의 짝과 작은 상승·그림자 피드백을 사용합니다. 게시판·회원용 실행 컨트롤과 단일 행 입력은 DTCG의 48px 높이를 공유합니다. 메인·헤더 버튼은 현재 별도 44px 최소 높이입니다.
- **입력·상태:** 입력 배경과 글자색은 의미 토큰을 사용하고, community.css의 명시적 field 경계·포커스가 기본 선언을 보완합니다. 도움말은 컨트롤 높이를 바꾸지 않습니다. 오류·성공은 색과 설명을 함께 제공합니다.
- **배지·분류:** 중립 배지와 현재 항목의 강조색 배지를 구분합니다. 정보 배지를 클릭 요소로 위장하지 않습니다.
- **메뉴:** PC는 분류·다열 구성을, 모바일은 전체 화면과 대분류·아코디언 구조를 유지합니다. 데이터 원본은 `get_menu_db()`입니다. 키보드 포커스와 현재 상태를 삭제하지 않습니다.
- **사진·카드·큰 아이콘:** 사진은 페이지 고유 목적과 원본 기록이 있어야 합니다. 콘텐츠 카드의 사진은 4:3, 영상 미디어는 16:9를 사용합니다. Lucide는 작은 조작 아이콘과 정보 역할이 큰 과정 아이콘을 구별해 크기를 정합니다. 대형 아이콘의 실제 사례는 Main 4 전용 스타일을 따릅니다.
- **페이지·스킨 소유권:** 홈의 `index_1.php`–`index_4.php`, 웹루트 `pages/*.php`, PC·모바일의 G5 `.skin.php`가 각 본문을 직접 소유합니다. 재사용 블록은 복사한 위치에서 독립 수정하며 런타임 partial/section dispatcher를 만들지 않습니다. 허용 include는 [STRUCTURE-CONTRACT](docs/STRUCTURE-CONTRACT.md)의 목록만 따릅니다.

기술 기준은 [package.json](package.json)의 고정 버전입니다. 현재 Pretendard 1.3.9, Lucide 1.47.0, Tailwind CSS 4.3.3, daisyUI 5.7.40, Motion 13.4.0, Embla 8.6.0을 사용합니다. 새 원본은 Tailwind `tw:`·daisyUI `tw:d-*`·DTCG를 우선하고 Vite로 설치 자산을 빌드합니다. 고객 서버에서 빌드 도구를 실행하게 하지 않습니다.

문서·개발 갤러리는 [harness/ui](../../../harness/ui/README.md)에서 유지하며 판매 payload에 포함하지 않습니다. 구조·토큰·build·styles·실제 G5 검사, [quality:check·quality:complete·quality:release](quality/README.md), 판매 ZIP 설치·업데이트·롤백은 별개의 증거입니다. 이 문서 작성은 전체 품질 gate 통과나 상품 승인이 아닙니다.

## Do's and Don'ts

- Do 색상은 의미 토큰에서, 타이포그래피·간격은 해당 원본 스타일에서 확인합니다.
- Do 페이지의 정보 역할에 맞게 사진·큰 아이콘·자료·카드·표·목록을 조합합니다.
- Do PC·모바일, 라이트·다크, 필요한 로그인 상태와 실제 G5 동작을 함께 검토합니다.
- Do 원본과 생성물을 구분하고 수정 뒤 빌드·필수 gate·새 화면 검토를 수행합니다.
- Don't Main 4의 FORME 팔레트·아홉 섹션·아이콘 카드를 테마 전체의 규격으로 일반화하지 않습니다.
- Don't 카드 금지나 네 섹션짜리 범용 랜딩 구성을 상업용 테마의 기본값으로 강제하지 않습니다.
- Don't 사진·문구·순서만 바꾸어 별개 디자인 변형으로 계산하지 않습니다.
- Don't G5 코어 수정, 별도 페이지 dispatcher, 런타임 sections include로 독립 PHP 계약을 우회하지 않습니다.
- Don't 페이지 ship·자동 검사·배포 성공을 전체 상품 승인이나 판매 ZIP 검증으로 바꾸어 말하지 않습니다.
