---
name: JW-Business 1.0 · 기업 테마 2차 후보 시안
description: 추가 시안 비교 전의 다섯 화면 PNG를 위한 잠정 디자인 기록
colors:
  corporate-base-100: "oklch(100% 0 0)"
  corporate-base-200: "oklch(93% 0 0)"
  corporate-base-300: "oklch(86% 0 0)"
  corporate-base-content: "oklch(22.389% 0.031 278.072)"
  corporate-primary: "oklch(58% 0.158 241.966)"
  corporate-primary-content: "oklch(100% 0 0)"
  corporate-secondary: "oklch(55% 0.046 257.417)"
  corporate-accent: "oklch(60% 0.118 184.704)"
  corporate-neutral: "oklch(0% 0 0)"
  corporate-neutral-content: "oklch(100% 0 0)"
  corporate-error: "oklch(70% 0.191 22.216)"
  business-base-100: "oklch(24.353% 0 0)"
  business-base-200: "oklch(22.648% 0 0)"
  business-base-300: "oklch(20.944% 0 0)"
  business-base-content: "oklch(84.87% 0 0)"
  business-primary: "oklch(41.703% 0.099 251.473)"
  business-primary-content: "oklch(88.34% 0.019 251.473)"
  business-secondary: "oklch(64.092% 0.027 229.389)"
  business-accent: "oklch(67.271% 0.167 35.791)"
  business-neutral: "oklch(27.441% 0.013 253.041)"
  business-neutral-content: "oklch(85.488% 0.002 253.041)"
  business-error: "oklch(51.61% 0.146 29.674)"
typography:
  display:
    fontFamily: "Pretendard, sans-serif"
    fontSize: "62px"
    fontWeight: 750
    lineHeight: 1.24
    letterSpacing: "-0.065em"
  headline:
    fontFamily: "Pretendard, sans-serif"
    fontSize: "38px"
    fontWeight: 730
    lineHeight: 1.35
    letterSpacing: "-0.05em"
  body:
    fontFamily: "Pretendard, sans-serif"
    fontSize: "15px"
    lineHeight: 1.65
    letterSpacing: "-0.025em"
  button:
    fontFamily: "Pretendard, sans-serif"
    fontSize: "14px"
    fontWeight: 650
    lineHeight: 1.4
rounded:
  field: "0.25rem"
  box: "0.25rem"
  corporate-selector: "0.25rem"
  business-selector: "0rem"
spacing:
  button-block: "11px"
  button-inline: "20px"
  section-desktop: "96px"
  section-mobile: "60px"
components:
  button-primary:
    backgroundColor: "var(--color-primary)"
    textColor: "var(--color-primary-content)"
    typography: "{typography.button}"
    rounded: "{rounded.field}"
    padding: "11px 20px"
  button-outline:
    backgroundColor: "var(--color-base-100)"
    textColor: "var(--color-base-content)"
    rounded: "{rounded.field}"
    padding: "11px 20px"
  input:
    backgroundColor: "var(--color-base-100)"
    textColor: "var(--color-base-content)"
    rounded: "{rounded.field}"
    padding: "11px 13px"
---

# Design System: JW-Business 1.0 · 기업 테마 2차 후보 시안

## Overview

**Creative North Star: "현장과 기술을 연결하는 기업"** — 현재 시안을 설명하는 잠정 이름이며 사용자 확정 문구가 아닙니다.

사진을 중심으로 기업의 사업과 프로젝트를 보여주고, 기능 화면은 읽기와 입력에 집중합니다. 서로 다른 밀도의 섹션을 쌓되 헤더·푸터·버튼·입력·아이콘 체계는 다섯 화면에 공유합니다.

이 문서는 PNG 렌더링 원본의 현재 값을 기록합니다. `JW-Business 1.0`은 확정 상품명이며 JW NEXUS는 시안 속 가상 회사명입니다. 회사·실적·주소·프로젝트·게시물·댓글은 가상이고 사진은 AI 생성입니다. 이 2차 안은 추가 시안과 비교할 후보이며 디자인 승인이나 G5 구현 승인을 의미하지 않습니다.

**Key Characteristics:**
- 큰 사진, 비대칭 사업 영역, 높이가 다른 프로젝트 배치
- 짙은 실적 띠와 밝은 정보 영역의 교대
- 공통 헤더·푸터·Lucide 아이콘과 일관된 입력 언어

## Colors

색상의 원본은 daisyUI 5.7.42의 `vendor/corporate.css`와 `vendor/business.css`입니다. 위 OKLCH 값을 유지하며 독립 HEX 팔레트나 새로운 색상 단계를 만들지 않습니다.

`corporate`는 라이트, `business`는 다크입니다. 배경·본문·테두리는 `base-*`, 주요 행동은 `primary`/`primary-content`, 필수 표시는 `error`를 사용합니다. 약한 배경과 구분선은 원본 semantic color를 `color-mix(in oklch, …)`로 혼합합니다. 실적 띠는 페이지 테마와 무관하게 `business`를 적용하며 아이콘은 `accent`입니다. 다크의 작은 분류 글자와 일부 아이콘은 `secondary`를 사용합니다.

사진 위 글자는 라이트의 `neutral-content`, 다크의 `primary-content`입니다. `white` 버튼도 다크에서는 `primary-content` 배경과 `base-100` 글자로 전환합니다. Frontmatter의 테마별 값은 출처 기록이며 렌더링 컴포넌트는 활성 테마의 CSS 변수에 연결됩니다.

## Typography

Pretendard Variable 1.3.9를 로컬 제공하고 `sans-serif`로 대체합니다. 본문은 15px/1.65, 메인 제목은 62px/1.24, 섹션 제목은 38px/1.35입니다. 1100px 이하에서 각각 53px·32px, 800px 이하에서 40px/1.35·29px로 줄어듭니다. 한국어 제목과 문장은 `word-break: keep-all`을 사용합니다. 입력은 13px, 일반 버튼은 14px/650이며 기능 화면의 보조 크기는 원본 CSS를 따릅니다.

## Layout

기본 컨테이너는 `min(1240px, calc(100% - 100px))`, 1100px 이하 좌우 여백은 32px, 800px 이하는 20px입니다. 섹션 상하 간격은 PC 96px·모바일 60px, 헤더 높이는 90px·72px, 히어로 높이는 640px·620px입니다.

사업 영역은 `1.4fr 1fr 1fr`, 프로젝트는 `1.3fr 1fr`와 두 번째 항목의 40px 하강, 역량은 4열, 업무 과정은 사진과 글 2열입니다. 모바일에서 사업은 첫 사진 전폭+2열, 프로젝트와 업무 과정은 1열, 역량은 2열이 됩니다. 혼합 뉴스 다음에 문의 띠와 공통 푸터가 이어집니다.

게시글은 최대 890px 본문+240px 보조 영역, 글쓰기는 220px 보조 영역+최대 900px 폼, 가입은 340px 사진 영역+폼입니다. 800px 이하에서 보조 영역을 숨기고 폼은 1열, 게시판 표는 제목·메타정보가 쌓인 목록으로 바꿉니다. 가입 CAPTCHA 입력은 모바일에서 다음 줄 전체 폭을 사용합니다.

## Elevation & Depth

박스 그림자 없이 면의 명도와 1px 테두리로 구분합니다. 사진 위에는 semantic neutral 기반 그라데이션을 사용하며 히어로 제목에만 `0 2px 30px color-mix(in oklch,var(--color-neutral) 15%,transparent)` 텍스트 그림자가 있습니다.

## Shapes

박스와 입력의 모서리는 두 테마 모두 0.25rem입니다. selector는 corporate 0.25rem·business 0rem입니다. 프로젝트 이동 버튼·역량 아이콘 바탕·아바타는 원형입니다. Lucide 1.47.0은 기본 21px, stroke 1.8을 사용하며 버튼 안은 18px입니다.

## Components

- **버튼:** primary·outline·white·quiet 네 종류. 기본 최소 높이 46px, 패딩 11px 20px, 아이콘 간격 20px입니다. 전역 포커스는 primary 3px 외곽선과 3px offset입니다. 일반 버튼의 별도 hover/active 효과는 현재 없습니다. 아이콘 버튼만 hover 시 base-200으로 바뀝니다.
- **필드:** 기본 최소 높이 47px, 패딩 11px 13px, base-300 1px 테두리와 동일 포커스 규칙을 공유합니다. 글쓰기 도구모음·첨부·CAPTCHA와 회원 옵션은 외형 시안입니다.
- **태그:** 최소 높이 26px, 패딩 3px 9px, 글자 12px/650. 배경은 primary 9%+base-100입니다.
- **탐색:** PC 선택 메뉴는 primary 글자와 하단 3px 표시, 모바일은 메뉴 아이콘입니다. 메뉴 펼침은 구현하지 않았습니다.
- **사진 영역:** 사업은 390px, 프로젝트는 365px·325px, 업무 과정은 565px입니다. 실제 사진 자산과 위치를 유지해 이미지 비율·줄바꿈을 함께 검토합니다.

제공 증거는 1440px PC 다섯 화면, 390px 모바일 다섯 화면과 메인·목록 다크 PNG입니다. 독립 검토에서 모바일 CAPTCHA 줄바꿈 수정 항목은 해소 판정을 받았습니다(`QA.md`). 이는 사용자 최종 승인이 아니며 전체 접근성·키보드 동선·저장·회원가입·G5 권한·ZIP 설치를 검증한 결과가 아닙니다. 다크 이미지는 메인·목록 두 화면뿐이므로 전 화면 라이트·다크 상품 계약을 증명하지 않습니다. README의 스크롤 헤더·히어로 전환·Swiper·숫자 변화·패럴랙스는 승인 후 후보입니다. 현재 모션은 CSS의 smooth anchor scroll과 reduced-motion 시 auto 처리뿐입니다.

## Do's and Don'ts

### Do:
- Do 활성 daisyUI 테마의 semantic color와 공유 컴포넌트를 사용합니다.
- Do 가칭·가상 데이터·AI 이미지 표시와 시안 검증 경계를 유지합니다.
- Do 다섯 대표 화면의 사진 비율·한국어 줄바꿈·PC/모바일 구성을 함께 검토합니다.

### Don't:
- Don't 이 문서를 최종 디자인 승인이나 G5 구현 지시로 취급하지 않습니다.
- Don't 별도 HEX 팔레트나 구현되지 않은 모션·기능 상태를 추가하지 않습니다.
- Don't 이미지 검토를 전체 접근성·G5 기능·배포 완료의 증거로 사용하지 않습니다.
