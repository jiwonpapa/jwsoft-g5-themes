---
name: G5 블록 검토실
description: JW-Business의 실제 G5 화면과 이전 검토 자료를 비교하는 개발 작업대
colors:
  light-primary: "oklch(51% 0.145 241.966)"
  light-primary-content: "oklch(100% 0 0)"
  light-base-100: "oklch(100% 0 0)"
  light-base-200: "oklch(93% 0 0)"
  light-base-300: "oklch(86% 0 0)"
  light-base-content: "oklch(22.389% 0.031 278.072)"
  dark-primary: "oklch(41.703% 0.099 251.473)"
  dark-primary-content: "oklch(88.34% 0.019 251.473)"
  dark-base-100: "oklch(24.353% 0 0)"
  dark-base-200: "oklch(22.648% 0 0)"
  dark-base-300: "oklch(20.944% 0 0)"
  dark-base-content: "oklch(84.87% 0 0)"
typography:
  title:
    fontFamily: "'Pretendard Variable', sans-serif"
    fontSize: "24px"
    letterSpacing: "-0.02em"
  section:
    fontSize: "20px"
  pane:
    fontSize: "14px"
  body:
    fontSize: "14px"
    lineHeight: 1.6
  label:
    fontSize: "12px"
  code:
    fontSize: "12px"
    lineHeight: 1.6
rounded:
  box: "0.25rem"
spacing:
  control-x: "12px"
  control-y: "8px"
  sidebar: "16px"
  panel-gap: "20px"
  header-y: "24px"
  workspace-x: "28px"
  header-x: "32px"
components:
  button:
    backgroundColor: "var(--color-base-100)"
    textColor: "var(--color-base-content)"
    rounded: "{rounded.box}"
    padding: "8px 12px"
  section-selected:
    backgroundColor: "var(--color-primary)"
    textColor: "var(--color-primary-content)"
    rounded: "{rounded.box}"
    padding: "8px 12px"
  preview:
    backgroundColor: "var(--color-base-200)"
    height: "520px"
  preview-mobile:
    backgroundColor: "var(--color-base-200)"
    height: "440px"
  source:
    backgroundColor: "var(--color-base-200)"
    padding: "20px"
    typography: "{typography.code}"
---

# Design System: G5 블록 검토실

## Overview

**Creative North Star: "블록 검토실"**

기존 JW-Business의 의미 색상과 Pretendard로 만든 개발 작업대입니다. 얇은 경계, 명확한 선택 상태, 읽을 수 있는 작업창으로 현재 G5 화면과 이전 캡처를 비교합니다. 별도 브랜드 팔레트나 판매용 히어로를 추가하지 않습니다.

범위와 사용 장면은 [BRIEF.md](BRIEF.md)의 승인된 방향을 따릅니다. 이 문서는 2026-09-27의 [gallery.css](gallery.css), [gallery.js](gallery.js), [index.php](index.php), 실제 PC 라이트·모바일 다크 캡처를 대조한 구현 기록입니다. 독립 마감 검토의 `ship`은 갤러리의 섹션 대응·실패 재시도·SVG 수정 범위이며 테마 전체나 판매 ZIP 승인으로 확대하지 않습니다.

**Key Characteristics:**

- 페이지·섹션 선택과 현재/이전 화면의 대응이 분명한 구조
- 중립 표면과 선택 상태에 쓰는 기존 강조색
- PC·모바일과 라이트·다크를 같은 작업 흐름에서 비교

## Colors

색상 원본은 테마의 [theme.css](../../../themes/business/jw_business/src/styles/theme.css)의 `jw-light`·`jw-dark`입니다. 위 토큰은 실제 값의 스냅샷이며 갤러리 CSS에는 값을 복제하지 않고 `--color-*` 참조를 유지합니다. 모드별 `light-*`와 `dark-*`는 같은 의미 역할의 두 상태입니다.

### Primary

파란 강조색과 그 위의 글자색은 선택된 섹션과 키보드 포커스에 씁니다. 모드 전환 시 `primary`와 `primary-content`를 함께 바꿉니다.

### Neutral

`base-100`은 본 작업 표면·컨트롤, `base-200`은 선택 목록·미리보기 바탕·원본 코드, `base-300`은 경계, `base-content`는 제목·본문·상태 안내입니다.

**The Inherited Palette Rule.** 갤러리는 테마의 의미 색상을 소비하며 별도 팔레트를 만들지 않습니다.

## Typography

제목·설명·컨트롤은 로컬 Pretendard Variable을 사용하고 코드만 브라우저의 고정폭 글꼴을 사용합니다. 제목은 24px, 선택한 섹션 제목은 20px, 패널 제목과 설명은 14px, 보조 표시는 12px입니다. 설명과 코드는 줄간격 1.6을 유지합니다. 제목에 별도 display 서체나 과장된 크기를 쓰지 않습니다.

## Layout

기본 구조는 224px 선택 목록과 가변 작업창입니다. 헤더 여백은 24px 32px, 작업창은 24px 28px, 나란한 비교창 사이는 20px입니다. 900px 이하에서는 목록 폭이 184px로 줄고 두 비교창이 세로로 쌓입니다. 600px 이하에서는 목록도 본문 위로 이동하고 섹션 버튼은 두 열, 바깥 여백은 20px입니다.

미리보기 창 높이는 기본 520px, 작은 화면 440px입니다. 실제 페이지는 PC 1440px 또는 모바일 390px로 렌더링한 뒤 가용 폭에 맞춰 축소하며, 현재 배율을 숫자로 알립니다. 원본 코드는 펼침 뒤 최대 480px 안에서 스크롤합니다. 실제 페이지의 작은 글자를 작업창 전체 글자 크기의 기준으로 사용하지 않습니다.

## Elevation & Depth

갤러리 자체는 그림자 없이 표면의 밝기 차이와 1px 경계로 구분합니다. 미리보기 안의 그림자는 테마 콘텐츠의 표현입니다. 포커스는 강조색 2px 외곽선과 3px 간격으로 드러냅니다. 선택 이동은 즉시 적용하며 장식용 모션을 추가하지 않습니다.

## Shapes

버튼·선택 입력은 기존 `--radius-box`를 상속한 작은 모서리(두 모드 모두 0.25rem)입니다. 비교창은 직사각형이며 카드처럼 둥글게 포장하지 않습니다. 최소 44px인 작업 컨트롤과 36px인 원본 펼침 요약은 서로 다른 현행 규칙입니다.

## Components

- **페이지·기기·모드 선택:** 네이티브 select를 사용합니다. 텍스트 라벨을 항상 표시하고 목록을 읽지 못하면 선택을 비활성화합니다.
- **섹션 탐색:** 중립 버튼을 세로로 나열하고 `aria-current="true"`에 강조색·대비 글자색·650 굵기를 적용합니다. 섹션 선택 뒤 현재 페이지의 위치와 이전 캡처의 오프셋이 함께 갱신됩니다.
- **현재/이전 비교창:** 현재 G5는 제목 있는 iframe, 이전 자료는 전체 캡처입니다. 이미지가 없는 페이지는 빈 상태를 표시합니다. 이전 캡처와 현재 레이아웃이 달라질 수 있으므로 정확한 픽셀 동등성의 증거로 삼지 않습니다.
- **실제 페이지 링크:** 새 창임을 읽을 수 있는 문구와 16px 인라인 SVG 화살표로 표시합니다. SVG는 장식용으로 보조기술에서 숨깁니다.
- **원본 펼침·복사:** 네이티브 details/summary 아래에 의존성, 수정 원본 경로, 복사 버튼, 코드를 제공합니다. 복사 성공·실패를 `role="status"`로 알리고 실패하면 수동 선택을 안내합니다.
- **목록 실패:** 비교창과 원본 영역을 숨기고 명확한 실패 제목·연결 확인 안내·다시 불러오기 버튼을 표시합니다. 빈 성공 화면으로 남기지 않습니다.

참고 래스터는 기존 Main 4의 [캡처 manifest](../../../themes/business/jw_business/quality/evidence/main4-20260927/manifest.json)에 등록된 네 PNG입니다. 원본 URL·시각·크기·SHA-256의 소유 기록을 유지하며 새 생성 이미지로 표기하지 않습니다. 이 작업은 새 래스터 자산을 만들지 않았습니다.

실행·검증 경계는 [UI 하네스](../README.md), 페이지 패턴은 [PATTERN-INVENTORY](../../../themes/business/jw_business/docs/PATTERN-INVENTORY.md), 상품 차단은 [quality/README](../../../themes/business/jw_business/quality/README.md)를 따릅니다. 소스 수정·원본 PHP 복사는 [구조 계약](../../../themes/business/jw_business/docs/STRUCTURE-CONTRACT.md)의 독립 파일 경계를 유지합니다.

## Do's and Don'ts

- Do 기존 의미 색상과 Pretendard를 사용하고 두 모드에서 선택 상태를 확인합니다.
- Do 선택한 섹션의 현재 화면과 이전 캡처를 같은 위치로 이동시킵니다.
- Do 참고 자료의 출처와 승인 여부를 분리해 표시합니다.
- Do 목록 실패·참고 이미지 없음·복사 실패 상태에서 다음 행동을 알려 줍니다.
- Don't 작업창에 새 브랜드 컬러, 장식용 그림자, 랜딩용 영웅 영역을 추가하지 않습니다.
- Don't 참고 캡처나 자동 검사 통과를 사용자 승인·상품 완료로 표시하지 않습니다.
- Don't 복사한 PHP를 새 런타임 include 체계로 바꾸거나 갤러리를 판매 ZIP에 넣지 않습니다.
