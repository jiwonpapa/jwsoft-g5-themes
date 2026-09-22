# JW-Business 1.0 레거시 제거·현대화 실행 계획

- 기준일: 2026-09-21
- 상태: 승인 전 구현 기준선
- 선행 자료: [공개 영역 레거시 감사](../reports/JW-BUSINESS-LEGACY-AUDIT-2026-09-21.md)
- 적용 범위: G5 커뮤니티 공개 화면 전체

## 1. 목표와 중단 선언

현재 적용된 메인 화면은 상품 구현 기준선으로 사용하지 않는다. 6차 이미지는 정보 구조와 분위기 참고 자료로만 남긴다.

새 섹션·게시판·일반 페이지 제작은 0~4단계가 끝날 때까지 중단한다. 먼저 하나의 현대적 문서 shell, 반응형 DOM, 디자인 token, 네이티브 메뉴, G5 동작 adapter를 만든다. 이후 모든 화면은 이 기반만 소비한다.

완료 상태는 “예쁘게 보임”이 아니라 다음 네 조건을 모두 만족하는 상태다.

1. 공개 페이지가 구형 G5 CSS와 전역 jQuery에 의존하지 않는다.
2. 코어 수정 없이 G5 회원·게시판·검색·쪽지·폼 기능을 보존한다.
3. 같은 semantic DOM이 PC·모바일과 라이트·다크를 처리한다.
4. 실제 G5 대표 경로의 브라우저 화면이 token과 승인 시안에 맞는다.

## 2. 범위와 경계

### 포함

- `head.sub.php`, `head.php`, `tail.php`와 모바일 entry의 문서 shell
- 공개 헤더·메뉴·검색·로그인 상태·모바일 drawer·푸터
- G5 커뮤니티 기본 기능의 PC·모바일 skin
- 테마 소유 CSS·TypeScript·SVG·폰트 자산
- 공개 페이지의 최소 meta와 구조화 데이터 출력 연결
- 테마 설치·수정 매뉴얼의 호환성 항목

### 제외

- G5 코어 파일 수정
- G5 관리자 UI와 관리자 전용 jQuery 교체
- 영카트 공개 화면
- 외부 스킨·플러그인의 jQuery 코드 변환
- 페이지 빌더·별도 에디터·업로더
- Ubuntu 재배포와 판매 ZIP 설치 시험: 구현 gate 완료 뒤 별도 수행

## 3. 확정 기술 결정

| 영역 | 결정 |
| --- | --- |
| PHP 기준 | 8.3, G5 5.6.391 공개 계약 보존 |
| CSS | Tailwind CSS 4 + daisyUI 5 + DTCG token, 단일 build CSS |
| JavaScript | vanilla TypeScript ESM, 단일 기본 module entry + 기능별 dynamic import |
| jQuery | 최종 공개 기본 번들 0개. Migrate도 최종 payload 0개 |
| 아이콘 | Lucide 개별 SVG import |
| 폰트 | 로컬 Pretendard Variable, 400·500·600·700만 디자인에 사용 |
| PC/모바일 | 표시용 DOM·CSS·JS 공통. G5가 요구하는 entry는 동일 partial을 include |
| 색상 모드 | daisyUI 기반 사용자 정의 `jw-light`·`jw-dark`, 공개 화면 전체 적용 |
| 브라우저 | Chrome/Chromium 111+, Firefox 128+, Safari 16.4+ |
| 외부 CDN | 기본 금지. 판매 ZIP에 검증 자산 포함 |

## 4. 최종 `head.sub.php` 계약

### 4.1 반드시 출력

```html
<!doctype html>
<html lang="ko" class="jw-theme" data-theme="jw-light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="color-scheme" content="light dark">
  <meta name="theme-color" media="(prefers-color-scheme: light)" content="…">
  <meta name="theme-color" media="(prefers-color-scheme: dark)" content="…">
  <title>페이지 제목</title>
  <link rel="stylesheet" href="…/jw-business.min.css">
  <script type="module" src="…/jw-business.min.js"></script>
</head>
```

- viewport는 G5 모바일 판정과 관계없이 항상 동일하게 출력한다.
- 저장된 사용자 선택 → `prefers-color-scheme` → 라이트 기본값 순으로 theme를 결정한다.
- CSS 요청 전에 최소 인라인 boot만 실행해 색상 깜빡임을 막는다. 이벤트·UI 기능은 인라인에 넣지 않는다.
- 제목·description·canonical·Open Graph는 페이지 context가 만든 값을 한 번만 출력한다.
- 게시판 meta와 구조화 데이터는 실제 게시판·글·댓글 데이터를 사용한다.
- 일반 페이지 meta는 페이지별 설정값을 사용한다.
- G5가 정말 요구하는 공개 context만 안전한 JSON 직렬화로 전달한다. 기존 전역 이름이 필요한 동안에는 consumer와 제거 조건을 목록화한다.

### 4.2 제거

- `HandheldFriendly`, `X-UA-Compatible`, `imagetoolbar`
- `minimum-scale=0`, `maximum-scale=10`
- IE8 html5 shim, placeholders polyfill, 구형 Modernizr
- Font Awesome 4
- G5 `default.css`·`mobile.css`·구형 skin CSS의 공개 로딩
- jQuery 1.12.4, Migrate 1.4.1, `jquery.menu.js`
- 검증 없이 전역 로딩한 `common.js`, `wrest.js`
- `$config['cf_add_meta']`를 주요 SEO 입력으로 직접 출력하는 방식

`cf_add_script` 같은 관리자 자유 입력은 기존 설치 호환성과 보안·중복 출력 범위를 조사한 뒤 정책을 확정한다. 근거 없이 유지하거나 삭제하지 않는다.

## 5. DOM·메뉴 설계

### 문서 shell

```text
body
├── a.skip-link
├── header.site-header
│   ├── brand
│   ├── nav[aria-label="주 메뉴"]
│   ├── utility actions
│   └── dialog.mobile-navigation
├── main#main-content
└── footer.site-footer
```

- `header`, `nav`, `main`, `footer`, `dialog`, `button`을 역할에 맞게 사용한다.
- G5가 ID·name·action을 요구하는 폼과 필드는 계약 adapter에서만 보존한다.
- 시각 스타일을 `#hd`, `#container`, `#gnb` 같은 레거시 ID에 결합하지 않는다.
- PC·모바일에서 같은 메뉴 데이터와 같은 partial을 쓴다.

### 데스크톱 메뉴

- 1차 메뉴는 1180~1360px container 안에서 정렬한다.
- 2차 메뉴는 hover뿐 아니라 click·keyboard로 열고 닫는다.
- `aria-expanded`, `aria-controls`, Escape, 외부 click, focus 복귀를 지원한다.
- active와 current page를 색상 하나에만 의존해 표시하지 않는다.
- 아래 스크롤 시 숨김, 위 스크롤 시 표시하되 상단 80px·메뉴 focus·drawer open 상태에서는 고정한다.

### 모바일 메뉴

- `<dialog>` 기반 drawer를 사용한다.
- 1차 항목과 하위 항목 토글을 분리해 링크 이동을 막지 않는다.
- 열릴 때 focus 이동, 닫힐 때 trigger 복귀, Escape, backdrop, body scroll lock을 검증한다.
- 메뉴 폭·breakpoint를 CSS와 TypeScript에 중복 하드코딩하지 않고 token/미디어 쿼리 한곳에서 관리한다.

## 6. 디자인 기반 재정의

현재 색상 12개뿐인 token을 다음 계약으로 확장한 뒤 화면을 만든다.

| 계층 | 필수 항목 |
| --- | --- |
| typography | family, 12/14/16/18/22/28/36/48/64 fluid scale, 400/500/600/700, line-height 1.15/1.35/1.6, letter spacing |
| spacing | 4/8/12/16/24/32/48/64/96/128 |
| container | reading 720, content 1180, wide 1360, mobile gutter 20, tablet 32, desktop 48~64 |
| radius | 0/8/12/16/pill |
| elevation | subtle/floating/dialog shadow |
| border | default/strong/focus |
| z-index | base/header/dropdown/drawer/dialog/toast |
| motion | 120/200/320/500ms와 표준 easing, reduced-motion 대체 |
| component | header, nav, button, form, table, pagination, board, dialog, section |

CSS layer 순서는 한 파일에서 명시한다.

```css
@layer reset, vendor, tokens, base, components, utilities, exceptions;
```

구형 비레이어 CSS를 함께 싣지 않는다. `exceptions`는 G5 계약상 제거할 수 없는 마크업 보정에만 사용하고 각 규칙에 제거 조건을 기록한다.

## 7. G5 공개 런타임 adapter

`src/scripts/g5/` 아래에서 기능을 작게 분리한다.

```text
g5/context.ts       안전한 PHP context 읽기
g5/menu.ts          주 메뉴·모바일 drawer
g5/forms.ts         필수 입력·오류 focus·서버 오류 연결
g5/board.ts         선택·삭제·추천·링크 등 게시판 공통 동작
g5/member.ts        로그인·가입·비밀번호 화면 동작
g5/popup.ts         새창·레이어 팝업
g5/image-viewer.ts  원본 이미지 보기/확대
```

- `common.js`와 `wrest.js` 전체를 복사하거나 이름만 바꾸지 않는다.
- 실제 공개 화면이 호출하는 함수, selector, 전역을 route matrix로 먼저 추출한다.
- 서버 검증을 약화하지 않는다. 브라우저 검증은 빠른 피드백과 접근성에 사용한다.
- core-only 인라인 jQuery 경로는 hook/테마 대체 가능성을 별도 spike로 검증한다.
- 불가피한 page-only bridge가 생기면 전역 entry와 분리하고 기본 bundle 예산에서 제외 사유를 기록한다.

## 8. 단계별 실행 순서와 종료 조건

### 0단계 — 실패 기준선 동결

- 현재 live 화면과 계산 스타일을 감사 증거로 남긴다.
- 현재 메인 구현을 승인 component로 승격하지 않는다.
- 작업 파일, 로컬 runtime, 사용자 변경을 구분한다.

종료 조건: 감사 보고서와 이 계획이 `START-HERE`의 현재 기준으로 연결됨.

### 1단계 — 경로·의존성 계약표

- 공개 route별 PHP entry, include, CSS, script, inline handler, jQuery, 전역 함수, G5 hook을 목록화한다.
- PC/모바일 중복과 theme-owned/core-owned를 구분한다.
- `bbs/view_image.php`, `move.php`, `newwin.inc.php` 같은 예외 경로를 재현한다.

종료 조건: 미분류 공개 jQuery consumer 0개, 제거/대체/페이지 한정 보류 사유 100% 기록.

### 2단계 — head와 자산 그래프 재작성

- 4장의 문서 계약으로 `head.sub.php`를 다시 쓴다.
- 공개 페이지에서 구형 CSS·polyfill·icon font의 로딩을 끊는다.
- meta·theme boot·module entry의 중복을 검사한다.

종료 조건: 대표 빈 페이지 network에 승인된 CSS 1개와 기본 module entry 1개, jQuery/Migrate/FA/Modernizr 요청 0개.

### 3단계 — token·reset·문서 shell

- token 전체 계약과 `jw-light`·`jw-dark`를 정의한다.
- 공통 reset, body, container, type, focus, form 최소값을 만든다.
- PC/모바일 entry가 같은 semantic shell을 include하게 한다.

종료 조건: 320/768/1440px에서 수평 overflow 0, 라이트·다크 AA 대비, 기본 글자와 container 계산값이 token과 일치.

### 4단계 — 메뉴·공통 header/footer

- 데스크톱 nav, 모바일 dialog, sticky 상태, 로그인/검색 utility를 native TypeScript로 구현한다.
- 키보드·screen reader·reduced-motion 동작을 검증한다.

종료 조건: 마우스 없이 전체 메뉴 사용 가능, focus 유실 0, jQuery 호출 0, PC·모바일 동일 메뉴 데이터.

### 5단계 — G5 adapter와 core-only spike

- route matrix에 따라 `common.js`·`wrest.js`의 필요한 책임만 교체한다.
- 팝업·이미지 보기·글 이동 등 core-only 경로의 무수정 대체 가능성을 실증한다.

종료 조건: 대표 기능 성공, 브라우저 console error 0, 전역 jQuery 0. 예외가 있으면 경로 한정 bridge의 사유·제거 조건 승인.

### 6단계 — 기능 surface 수직 완성

다음 순서로 한 화면군씩 PHP·DOM·CSS·동작·다크모드까지 끝낸다.

1. 게시판 목록
2. 게시글 본문 + 첨부 + 댓글
3. 글쓰기/수정
4. 로그인 + 회원가입 + 비밀번호
5. 검색 + 새글 + 인기검색어 + FAQ + Q&A + 쪽지 + 투표 + 접속자

종료 조건: 해당 surface의 old CSS/inline jQuery 0, 비회원·회원·관리자 권한 동작, 모바일·다크 화면 통과.

### 7단계 — 승인 메인 재구현

- 6차 시안의 정보 구조를 token과 공통 component 위에서 다시 구현한다.
- 시안과 live screenshot을 나란히 비교해 밀도·여백·위계·이미지 비율을 조정한다.

종료 조건: 메인 이미지 비교 승인, 7개 섹션을 한꺼번에 늘리기 전에 상·중·하 대표 구간 검토 완료.

### 8단계 — 전체 페이지·패키지·매뉴얼

- 75개 레이아웃과 재사용 섹션은 앞 단계 component만 조합한다.
- jQuery가 필요한 외부 확장 설치 방법은 호환성 부록에 두고 기본 설치 흐름에 포함하지 않는다.
- build 산출물을 포함해 고객 서버에는 Bun/Node를 요구하지 않는다.

종료 조건: 계약·token·build·route·browser gate, 판매 ZIP 설치/업데이트/원복, 온라인 매뉴얼 검증.

## 9. 자동 검사

다음 검사는 계획 구현과 함께 추가한다.

| 검사 | 실패 조건 |
| --- | --- |
| public legacy scan | theme-owned PHP/TS/JS의 `jQuery`, `$()`, inline `on*=` 발견 |
| forbidden asset scan | 공개 head에서 old CSS, Migrate, FA4, Modernizr, placeholders 요청 |
| head contract | viewport·charset·title 중복 또는 누락, 금지 meta 존재 |
| token contract | 필수 typography/spacing/container/motion token 누락 |
| DOM contract | `main` 중복, label 없는 control, 메뉴 ARIA 연결 실패 |
| route smoke | PHP fatal, console error, 4xx/5xx 자산, 핵심 form 실패 |
| visual | 320/768/1440, light/dark, 비회원/회원 대표 screenshot 회귀 |

기존 `bun run check`에 모든 항목을 한 번에 얹지 않는다. 먼저 독립 명령으로 오탐을 보정하고 안정된 검사만 필수 gate로 승격한다.

## 10. 구현 파일 예정

```text
themes/business/jw_business/
├── docs/
│   ├── PUBLIC-ROUTE-MATRIX.json
│   └── LEGACY-EXCEPTIONS.json
├── src/php/
│   ├── head.sub.php
│   ├── partials/document/
│   ├── partials/site/
│   └── adapters/
├── src/scripts/
│   ├── main.ts
│   └── g5/
├── src/styles/
│   ├── index.css
│   ├── base/
│   ├── components/
│   └── surfaces/
└── tokens/theme.tokens.json
```

실제 두 테마가 재사용하기 전에는 이 adapter와 component를 공통 package로 올리지 않는다.

## 11. 작업 착수 기준

다음 구현은 **1단계 경로·의존성 계약표 작성**부터 시작한다. `head.sub.php`를 먼저 고치기 전에 core-only 경로와 전역 함수 consumer를 목록화하여 기능 손실을 막는다. 계약표가 끝나면 2~4단계를 하나의 수직 작업으로 진행하고 실제 G5 공통 shell을 먼저 검토한다.

이 계획이 완료될 때까지 게시판 디자인 확장, 일반 페이지 양산, 섹션 라이브러리 확대는 진행하지 않는다.
