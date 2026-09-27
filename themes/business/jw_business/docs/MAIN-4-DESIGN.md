---
name: JW-Business Main 4
description: 기존 JW 테마 안에서 FORME 가상 브랜드의 과정과 산출물을 보여주는 메인 4 구현 기록
colors:
  light-primary: "oklch(51% 0.145 241.966)"
  light-primary-content: "oklch(100% 0 0)"
  light-base-100: "oklch(100% 0 0)"
  light-base-200: "oklch(93% 0 0)"
  light-base-content: "oklch(22.389% 0.031 278.072)"
  dark-primary: "oklch(41.703% 0.099 251.473)"
  dark-primary-content: "oklch(88.34% 0.019 251.473)"
  dark-base-100: "oklch(24.353% 0 0)"
  dark-base-200: "oklch(22.648% 0 0)"
  dark-base-content: "oklch(84.87% 0 0)"
  h4-accent: "var(--color-primary)"
  h4-accent-dark: "color-mix(in srgb,var(--color-primary) 38%,var(--color-primary-content))"
  h4-muted: "color-mix(in srgb,var(--color-base-content) 74%,var(--color-base-100))"
  h4-line: "color-mix(in srgb,var(--color-base-content) 16%,transparent)"
  h4-soft: "color-mix(in srgb,var(--color-primary) 5%,var(--color-base-100))"
  h4-soft-dark: "color-mix(in srgb,var(--h4-accent) 7%,var(--color-base-100))"
  forme-forest: "#294638"
  forme-ivory: "#f5f3eb"
  forme-sage-swatch: "#b9c4ae"
  forme-ivory-swatch: "#eae5d8"
  forme-swatch-ink: "#23382d"
typography:
  display:
    fontFamily: "'Pretendard Variable', Pretendard, sans-serif"
    fontSize: "clamp(38px,4.15vw,60px)"
    fontWeight: 800
    lineHeight: 1.19
    letterSpacing: "-.035em"
  headline:
    fontSize: "clamp(30px,3.2vw,44px)"
    fontWeight: 780
    lineHeight: 1.25
    letterSpacing: "-.03em"
  process-title:
    fontSize: "25px"
    fontWeight: 740
  summary:
    fontSize: "16px"
    lineHeight: 1.8
  stage-label:
    fontSize: "13px"
    fontWeight: 700
  forme-wordmark:
    fontFamily: "Georgia, serif"
    fontSize: "46px"
    fontWeight: 400
    letterSpacing: ".16em"
rounded:
  control: "6px"
  panel: "8px"
  photo-card: "10px"
  board: "12px"
spacing:
  section: "100px"
  section-wide: "112px"
  section-tablet: "76px"
  section-mobile: "64px"
components:
  process-card:
    backgroundColor: "var(--color-base-100)"
    rounded: "{rounded.photo-card}"
    padding: "37px 24px 22px"
  primary-button:
    backgroundColor: "var(--color-primary)"
    textColor: "var(--color-primary-content)"
    rounded: "{rounded.control}"
  forme-artwork:
    backgroundColor: "{colors.forme-ivory}"
    textColor: "{colors.forme-forest}"
---

# Main 4 디자인 계약

## Overview

2026-09-27 구현 기준입니다. 범위는 `src/php/index_4.php`와 전용 스타일·스크립트·사진입니다. 기존 G5 헤더·메뉴·푸터, `jw-light`/`jw-dark`, Pretendard와 의미 토큰을 상속합니다. **다른 페이지나 테마 전체에 새 디자인 체계를 선언하는 문서가 아닙니다.**

페이지의 기준은 “FORME라는 하나의 가상 브랜드 사례로 각 과정에서 무엇을 만드는지 보여준다”입니다. 큰 과정 아이콘, 작업 사진, 고객 여정도, HTML 웹 시안, 브랜드 보드, 전달 파일을 서로 다른 구성으로 제시합니다. 사진 속 브랜드와 인물은 생성된 예시이며 실제 고객·프로젝트 실적을 주장하지 않습니다.

독립 마감 검토의 최종 전달 판정은 `ship`입니다. 전용 사진 4장, 아이콘 카드, 섹션 변화, 정렬, PC·모바일/라이트·다크가 해당 검토 범위입니다. **Main 4의 화면 판정이며 전체 상품 품질 gate, 홈 4종 비교, 판매 ZIP 설치·업데이트·복구 및 출시 승인이 아닙니다.** 문서화 작업에서는 화면 검토를 재실행하지 않고 전달된 판정과 현재 소스를 대조했습니다.

근거는 저장소 루트의 [검토 범위와 화면 목록](../../../../.impeccable/review/main4-20260927/BRIEF.md), [PRODUCT.md](../PRODUCT.md), [품질 차단](../quality/README.md)입니다. 생성된 `direction-comp.png`는 작업자가 만든 방향 참고 이미지이며 사용자 승인 시안이나 실제 브라우저 캡처가 아닙니다.

테마의 공통 기준은 `../DESIGN.md`와 `../.impeccable/design.json`에서 확인합니다. 2026-09-27 개발 하네스 개선 시 현행 소스 기준으로 문서화했으며, light primary와 공통 footer는 실제 대비 검사 후 조정했습니다. 저장소의 `prototypes/`에 있는 별도 시안 문서는 이 테마의 상속 계약이 아닙니다.

## Colors

사이트는 중립 표면과 파란 강조색을 사용합니다. 위 frontmatter는 현재 코드의 값과 참조를 옮긴 스냅샷입니다. 실제 색상 원본은 [theme.css](../src/styles/theme.css)의 daisyUI theme 정의이며, DTCG 의미 연결은 [theme.tokens.json](../tokens/theme.tokens.json)입니다. 이 문서를 수정해도 CSS는 바뀌지 않습니다.

| 역할 | 실제 참조 | 적용 |
| --- | --- | --- |
| 기본 표면·본문 | `--color-base-100`, `--color-base-content` | 페이지, 카드, 사진 설명판 |
| 구획 표면 | `--color-base-200` | 고객 여정·FAQ 배경 |
| 실행 버튼 | `--color-primary`, `--color-primary-content` | 과정 이동·문의 CTA, 단계 번호 원 |
| 아이콘·강조 | `--h4-accent` | 큰 아이콘, 단계명, 링크 상태; 다크에서 밝기 보정 |
| 보조 본문·선 | `--h4-muted`, `--h4-line` | 설명, 카드 구분선, 테두리 |
| 옅은 강조 표면 | `--h4-soft` | 과정 띠, 발견 메모, 브랜드 구획, 인계 카드 |

`--h4-*` 값은 `.jwh4` 범위 안에 정의됩니다. 다크 모드에서는 accent와 soft만 별도 식으로 바꾸고 나머지는 상속된 의미 색을 따라갑니다. DTCG의 `color.surface`, `color.surface-muted`, `color.text`, `color.brand`, `color.brand-contrast`도 같은 daisyUI 변수로 연결됩니다.

FORME의 forest·sage·ivory는 작품 내부 색입니다. 사진, `.h4-demo-site`, 워드마크와 색상 견본은 다크에서도 브랜드 색을 유지합니다. 반면 브라우저 바, 시안 바깥 받침, 설명판과 본문은 사이트 테마를 따라갑니다. 이 작품 색을 전역 배경이나 CTA 색으로 확장하지 않습니다.

## Typography

사이트 문구는 로컬 번들 Pretendard를 사용하며 인위적인 굵기 합성을 끕니다. 제목은 `keep-all`과 `overflow-wrap:break-word`를 적용합니다. 제목·설명·캡션의 단계 차이를 유지하고 반복되는 장식용 eyebrow는 사용하지 않습니다. 과정에 필요한 `01`–`04` 번호·단계명은 유지합니다.

frontmatter의 display/headline은 기본 폭의 값입니다. 반응형 override는 다음과 같습니다.

| 폭 | 주요 변경 |
| --- | --- |
| 1100px 이하 | 히어로 제목 44px |
| 800px 이하 | 히어로 제목 36px |
| 560px 이하 | 히어로 제목 38px, 섹션 제목 30px, 카드 제목 21px, 요약 14px |

히어로 설명은 기본 17px/1.8, 섹션 요약 최대 폭은 460px입니다. 카드 본문은 기본 14px/1.7, 모바일 12px/1.75입니다. 작은 영문·캡션은 보조 정보입니다. FORME 워드마크의 Georgia는 작품 표현에만 사용하며 사이트 본문 서체를 대체하지 않습니다.

## Layout

기본 컨테이너는 `min(1280px, calc(100% - 96px))`입니다. 1100px 이하에서는 좌우 28px, 560px 이하에서는 좌우 20px 여백을 둡니다. 일반 섹션 간격은 frontmatter의 section 값이며 1600px 이상, 800px 이하, 560px 이하에서 각각 wide/tablet/mobile을 적용합니다. 히어로·과정 띠·마지막 문의는 자체 간격을 사용합니다.

| 순서 | 섹션·소스 식별자 | 실제 구성과 역할 |
| --- | --- | --- |
| 01 | 프로젝트 커버 `.h4-hero` | `1fr 1.15fr`, 간격 52px. 문구·과정 링크·문의와 큰 제품 사진. 560px 이하에서 문구 다음 사진 |
| 02 | 과정 `#h4-process` | 발견·설계·제작·인계 4개 링크 카드. 800px 이하에서 2열 유지 |
| 03 | 발견 `#h4-discovery` | 작업 사진 + 관찰/목표 2개 메모 + 필요/가치 관계도. 800px 이하에서 1열 |
| 04 | 설계 `#h4-strategy` | 연결된 HTML 고객 여정 4단계. 기본 가로 4열 → 800px 이하 2열 → 560px 이하 세로 연결선 |
| 05 | 제작 `#h4-digital` | 설명·기능 목록 + 실제 HTML 브라우저 시안. 바깥 비율 `.8fr 1.2fr`, 800px 이하 1열 |
| 06 | 브랜드 `#h4-brand` | 전달물 사진과 워드마크·색 견본. 기본 `1.6fr 1fr`, 800px 이하 동등 2열, 560px 이하 1열 |
| 07 | 인계 `#h4-handoff` | 설명 + 원본/이미지/가이드/체크리스트 2×2. 800px 이하 바깥 1열; 카드 내부는 2열 유지 |
| 08 | 질문 `.h4-questions` | 소개와 네 개의 native `details/summary`. 800px 이하 1열 |
| 09 | 문의 `.h4-contact` | 전송 아이콘·마지막 문구·문의 링크. 모바일에서 세로 흐름 |

앵커 대상의 상단 여유는 110px입니다. 과정 카드의 제목·본문·하단선, 발견 메모의 제목은 같은 행에서 정렬합니다. 문구를 바꿀 때 PC뿐 아니라 모바일 줄바꿈도 함께 확인합니다. 숨겨지는 `<br>` 뒤 공백을 보존해 단어가 붙지 않도록 합니다.

## Elevation & Depth

기본은 표면 색 차이와 얇은 구분선입니다. 과정 카드는 hover/focus에서만 5px 올라오며 `0 12px 28px color-mix(in srgb,var(--color-primary) 9%,transparent)` 그림자를 사용합니다. 브라우저 시안에는 `0 18px 40px color-mix(in srgb,var(--color-base-content) 12%,transparent)` 그림자가 있습니다. 다른 일반 구획에 임의의 그림자를 추가하지 않습니다.

## Shapes

주요 모서리는 frontmatter의 6–12px 범위입니다. 브라우저 창은 7px, 접점 표시는 4px이며 단계 번호·여정 아이콘·문의 아이콘 받침은 원형입니다. 모바일 사진과 과정 카드는 7px로 조정합니다. 사진은 둥근 틀 안에서 `object-fit:cover`로 배치하며 좌우 반전하지 않습니다.

## Components

### 동작과 접근성

- 기본 버튼은 daisyUI `tw:d-btn`/`tw:d-btn-primary`입니다. Main 4 override는 최소 높이 50px, 모바일 48px입니다. 현재 구현값이며 전역 `--jw-control-height:48px`로 모두 연결되어 있다고 해석하지 않습니다.
- 과정 카드는 전체가 앵커입니다. 큰 Lucide 아이콘은 PC 80px, 모바일 60px입니다. hover/focus의 360도 Y축 회전은 아이콘에만 적용하고 제목·본문·사진은 회전하지 않습니다. 테두리/이동 전환은 250ms, 아이콘 회전은 650ms입니다.
- 키보드 focus는 `--h4-accent`의 3px 외곽선과 5px offset을 사용합니다. 장식 아이콘에는 `aria-hidden`, 그림에는 의미 있는 `alt`를 유지합니다.
- FAQ는 native `details/summary`와 daisyUI collapse입니다. 별도 FAQ JavaScript 없이 펼칠 수 있습니다. 인계 카드와 HTML 시안의 컬렉션 문구는 설명용이며 다운로드·쇼핑 링크가 아닙니다.
- Motion `inView`는 `.h4-reveal`이 15% 보일 때 `.h4-entered`를 붙입니다. CSS는 24px 아래에서 원위치로 이동하며 `--jw-motion-duration-reveal` 420ms와 `--jw-motion-ease-out` `cubic-bezier(0.16, 1, 0.3, 1)`을 사용합니다. DTCG의 거리 토큰은 16px이나 이 페이지 이동값은 실제 코드상 24px입니다.
- 콘텐츠는 JavaScript 실행 전부터 보입니다. `prefers-reduced-motion:reduce`에서는 inView 등록과 CSS 애니메이션·전환·카드 이동을 끕니다. 슬라이더와 Embla는 이 페이지에서 사용하지 않습니다.

### 전용 자산과 소유권

네 사진은 OpenAI image generation으로 2026-09-27 생성했으며 JW SOFT가 방향을 지정했습니다. FORME는 가상 브랜드입니다. 원본 PNG는 로컬 생성 기록에 보존하고 1536×1024 WebP를 설치 payload에 포함합니다. 정확한 프롬프트·원본 위치는 [사진 README](../src/assets/home-four/README.md)를 따릅니다.

| 사진 | 용도 | 등록 소유자·원본 계열 |
| --- | --- | --- |
| `hero.webp` | 커버 제품 사진 | `home-4`, `imagegen:98a62823-c1a3-4c1d-8530-fbfa26ae54ea` |
| `discovery.webp` | 디자이너 협업 장면 | `home-4`, `imagegen:b77b85a9-852f-4de3-a8b8-d1d8a2e36cc2` |
| `digital.webp` | 웹 시안의 별도 캠페인 사진 | `home-4`, hero와 같은 참조 원본 계열. 별도 생성 장면이며 파일 해시는 다름 |
| `handoff.webp` | 패키지·가이드·명함 결과물 | `home-4`, `imagegen:72a76b56-abb2-48ae-90e5-b21a604bd671` |

digital은 제품 디자인을 일치시키기 위해 hero를 참조해 새 장면으로 생성했습니다. 동일 사진 복사로 설명하거나 계열 추적을 끊지 않습니다. 네 파일의 SHA-256·owner·origin은 [quality/assets.json](../quality/assets.json), 설치 경로·생성 도구·저작자·라이선스 표기는 [ASSET-MANIFEST.json](../ASSET-MANIFEST.json)이 관리합니다. 이 자산 등록은 상품 출시 승인과 별개입니다. 다른 페이지에서 이름만 바꾸거나 크롭해 재사용하지 않습니다.

### 페이지 전용 로딩

`src/scripts/home-four-entry.ts`가 CSS를 import하고 Lucide·Motion을 초기화합니다. Vite의 `home-four` entry와 CSS 분할로 `home-four.min.css`/`home-four.min.js`를 만들며 공유 chunk가 생길 수 있습니다. PHP가 이 두 자산을 명시적으로 등록하고 `[data-jw-home="4"]` 내부만 초기화합니다. CSS는 공통 `theme.css`를 `@reference`하여 Tailwind utility를 사용합니다. 공통 shell 자산을 이 전용 번들로 대체하지 않습니다.

원본·생성물·고객 수정 경로는 [MAIN-4-EDITING.md](MAIN-4-EDITING.md)에 정리했습니다.

## Do's and Don'ts

- **Do** 네 사진의 용도, 아홉 섹션의 읽는 순서, 네 과정과 산출물의 연결을 함께 유지합니다.
- **Do** 사이트 UI는 의미 색상으로, 작품 내부는 FORME 색으로 처리하고 PC·모바일/라이트·다크를 함께 확인합니다.
- **Do** 소스에서 수정하고 빌드한 뒤 실제 G5 화면으로 검토합니다. 소스나 자산 변경 뒤 이전 검토 증거를 재사용하지 않습니다.
- **Don't** Main 4의 아이콘 카드나 사진 구성을 다른 페이지 전체에 강제하지 않습니다.
- **Don't** 제거한 장식용 eyebrow 세 개를 복구하거나 필요한 과정 번호까지 삭제하지 않습니다.
- **Don't** 전용 사진을 다른 페이지에 재사용하거나 전체 화면 이미지를 실제 HTML 시안 대신 넣지 않습니다.
- **Don't** Main 4의 `ship` 판정을 전체 테마 완료나 판매 가능 판정으로 확대하지 않습니다.
