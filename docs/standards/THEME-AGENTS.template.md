# `<THEME_NAME>` Agent Guide

> 이 파일을 `themes/<category>/<theme-slug>/AGENTS.md`로 복사한 뒤 대문자 placeholder를 모두 실제 값으로 바꿉니다. 미확정 값을 추측해 채우지 않습니다.

항상 존댓말을 사용하고 사용자를 `형님`이라고 부릅니다. 결과와 영향을 먼저 간결하게 보고합니다.

## 1. 상품 정의

- 상품명: `<THEME_NAME>`
- 상품 slug: `<THEME_SLUG>`
- 업종: `<INDUSTRY>`
- 주 사용자: `<PRIMARY_OPERATOR>`
- 방문자 핵심 행동: `<PRIMARY_VISITOR_ACTION>`
- 영카트: `<INCLUDED | EXCLUDED | OPTIONAL>`
- 제품 버전: `<VERSION>`
- 지원·업데이트 종료 기준: `<DATE_OR_POLICY>`

이 테마는 `<ONE_SENTENCE_PRODUCT_PROMISE>`를 제공하는 G5 설치형 상품입니다. 관리자 페이지 빌더나 개별 사이트 제작 서비스로 범위를 확대하지 않습니다.

## 2. 작업 전 확인

다음 순서로 읽습니다.

1. 저장소 루트 `AGENTS.md`
2. `docs/standards/G5-THEME-PLATFORM-STANDARD.md`
3. `docs/research/common/THEME-DEVELOPMENT-FOUNDATION-RESEARCH.md`
4. `docs/research/common/WEB-DESIGN-MCP-RESEARCH.md`
5. 이 파일
6. `docs/PRODUCT-BRIEF.md`
7. 요청에 직접 관련된 문서와 파일

작업 전에 반드시 확인합니다.

- `git status --short`
- 대상 파일과 사용자 변경
- 완료 조건
- 필수 자동 검사와 실제 G5 화면 검사
- 구현·패키지·배포 중 이번 요청이 허용한 단계

## 3. 지원 환경

- G5: `<SUPPORTED_G5_RANGE>`
- PHP: 8.3, 8.4, 8.5
- 기준 PHP: 8.3
- DB QA: MariaDB 10.11 LTS, MySQL 8.4 LTS
- 브라우저: Chrome 111+, Safari 16.4+, Firefox 128+, 현재 iOS Safari/Android Chrome
- 서버: Nginx, Apache
- 개발 package manager: Bun 1.4.2
- 개발·CI tool runtime: Bun 우선, 공통 표준의 compatibility gate가 요구하면 Node 24 LTS
- 고객 서버 build tool: 없음

지원 범위를 바꾸면 이 파일, 설치 문서, 상품 설명, 테스트 matrix를 함께 갱신합니다.

### 3.1 공식 기본 테마 반입

- 구현 시작 시 지원할 공식 G5 버전의 `theme/basic` **전체**를 상품의 `<THEME_SLUG>` 폴더로 복제하고 테마명과 자산 경계를 바꿉니다.
- 다른 테마를 런타임 부모로 요구하지 않습니다.
- 복제 직후 원본 버전·파일 목록·checksum을 `THEME-INVENTORY.md`에 기록합니다.
- 원본 파일은 모두 `개편`, `그대로 상속`, `상품 범위 제외` 중 하나로 분류합니다. 분류되지 않은 누락 파일이 있으면 완료가 아닙니다.
- G5 코어 파일과 DB schema는 수정하지 않습니다.

## 4. 포함 범위

### 페이지

- `<PAGE_1>`
- `<PAGE_2>`
- `<PAGE_3>`

### G5 기능 화면

- PC·모바일 테마 골격과 basic·gallery 게시판의 목록·보기·쓰기·댓글·첨부·검색·분류·페이징·권한·빈 상태
- 로그인·가입·약관·가입 완료·정보수정·비밀번호·프로필·폼메일
- 쪽지·포인트·스크랩, 내용관리·FAQ·1:1 문의
- 통합검색·새글·현재접속자·인기검색어·방문자·설문·최신글·외부로그인
- 정책 페이지와 `<YOUNGCART_SURFACES_IF_ANY>`

영카트가 제외된 상품도 G5 커뮤니티 기본 기능과 PC·모바일 skin을 빠짐없이 처리합니다. 세부 파일과 상태는 `THEME-INVENTORY.md`와 화면 검증표에서 관리합니다.

### 공통 동작

- 데스크톱·모바일 메뉴
- 스크롤 방향 반응형 스티키 헤더
- 접근 가능한 dialog, tab, accordion
- reduced motion 대응
- JavaScript 실패 시 핵심 콘텐츠 fallback

## 5. 제외 범위

- G5 코어 수정
- G5 코어 DB table 변경
- 관리자 페이지 빌더
- 고객별 메뉴·문구·이미지 대행 입력
- 외부 SaaS 계정과 API key 제공
- 테마 안에 `jw-editor for G5` 소스 복사
- 에디터·예약·업로더·외부 연동 plugin을 테마 CS에 포함
- `<THEME_SPECIFIC_EXCLUSIONS>`

## 6. 디렉터리 책임

```text
<THEME_ROOT>/
├── AGENTS.md
├── package.json
├── theme.manifest.json
├── DESIGN-REFERENCE.json
├── PRODUCT.md
├── DESIGN.md                     # 구현·검토 완료 뒤 현재 시각 체계를 기록
├── CHANGELOG.md
├── .impeccable/
│   ├── design.json              # 구현·검토 완료 뒤 DESIGN.md와 함께 생성
│   └── surfaces/                # 화면별 승인 방향 계약
├── docs/
├── tokens/
│   └── theme.tokens.json         # 직접 편집하는 token 원본
├── src/
│   ├── php/
│   ├── styles/
│   ├── scripts/
│   └── assets/
├── tests/
├── theme/                       # 판매 ZIP의 G5 theme payload
├── LICENSES/
├── THIRD_PARTY_NOTICES.md
├── ASSET-MANIFEST.json
└── RELEASE-MANIFEST.json        # release 도구가 생성, 직접 수정 금지
```

- `src/`는 빌드 원본입니다.
- `tokens/`는 색·type·spacing의 단일 원본이며 생성 CSS를 직접 수정하지 않습니다.
- `DESIGN-REFERENCE.json`은 승인한 Figma frame과 token·preview hash를 연결하며 인증 정보는 넣지 않습니다.
- `PRODUCT.md`는 상품 사실, `DESIGN.md`는 구현된 시각 체계를 기록합니다.
- `DESIGN.md`와 `.impeccable/design.json`은 구현 전 추측으로 만들지 않고, 구현·검토가 끝난 현재 시각 체계를 DTCG token과 함께 기록합니다.
- `theme/`에는 고객 서버가 바로 실행할 결과만 둡니다.
- `.runtime/gnuboard5`는 공식 원본 시험용이며 상품에 포함하지 않습니다.
- 공통 runtime 코드는 두 개 이상의 테마에서 재사용이 확인되기 전 `packages/`로 이동하지 않습니다.
- 재사용 후보는 `shared-candidates.json`에 기록하고 복사 후 변형하지 않습니다.

## 7. 디자인 계약

- 디자인 방향: `<VISUAL_THESIS>`
- token 원본: `<TOKEN_FILE>`
- 기본 폰트: self-hosted Pretendard Variable 1.3.9 다이내믹 서브셋, 디자인 토큰 400/500/600/700
- 추가 폰트: `<NONE_OR_FONT_AND_LICENSE>`
- 아이콘: Lucide SVG
- 이미지 방향: `<IMAGE_DIRECTION>`
- daisyUI color theme: light `<LIGHT_THEME>`, dark `<DARK_THEME>`
- theme switch 범위·저장 규칙: `<THEME_SWITCH_CONTRACT>`
- 모서리: `<RADIUS_RULE>`
- 그림자: `<SHADOW_RULE>`
- section rhythm: `<SECTION_SPACING_RULE>`
- 승인 디자인 참조: `<DESIGN_REFERENCE_FILE>`

임의 hex, 임의 spacing, 임의 font size를 PHP template에 반복하지 않습니다. 시안이 바뀌면 token부터 바꿉니다.
Figma와 MCP 결과는 참고·검토 입력이며, token과 source diff 없이 구현 기준이나 visual baseline을 바꾸지 않습니다.
Impeccable는 수동 경고 검사로 사용하며 자동 hook과 전체 rule ignore를 임의로 켜지 않습니다.

## 8. 기술 스택

- Vite 8.3.0
- TypeScript 7.0.2
- Tailwind CSS 4.3.3
- daisyUI 5.7.40, `d-` component prefix와 최종 `tw:d-*` class, manifest에 선언한 theme만 포함
- Tailwind `tw:` prefix, Preflight 전역 적용 금지
- Swiper 14.2.0: `<USED_SURFACES_OR_NONE>`
- Motion 13.4.0: `<USED_SURFACES_OR_NONE>`
- PhotoSwipe 5.4.4: `<USED_SURFACES_OR_NONE>`
- Lucide 1.47.0
- Sharp 0.35.4: build only

허용 목록에 없는 라이브러리를 임의 추가하지 않습니다. 필요하면 기능 중복·라이선스·보안·번들·접근성·오프라인 동작을 문서로 평가합니다.

## 9. 기능 동작 계약

### 메뉴

- 메뉴 원본: `<G5_MENU_SOURCE_OR_STATIC_CONTRACT>`
- desktop 방식: `<MEGA | DROPDOWN | SIMPLE>`
- mobile 방식: `<DIALOG | DRAWER>`
- 현재 위치 표시: `<RULE>`
- 키보드: Tab, Shift+Tab, Enter, Space, Escape

### 스티키 헤더

- 첫 화면과 상단 80px에서 표시
- 아래 방향 12px 이상 이동 시 숨김
- 위 방향 이동·focus 진입·모바일 메뉴 열림 시 표시
- 레이아웃 점프 금지

### Swiper

- 1장일 때 slider를 초기화하지 않음
- 사용하는 module: `<MODULES>`
- autoplay: `<OFF_OR_JUSTIFICATION>`
- navigation accessible label은 한국어
- 이미지 실패·긴 제목·2장·다수 장 상태 검사

### 패럴랙스와 reveal

- 대상: `<DECORATIVE_TARGETS>`
- 본문·form·CTA 이동 금지
- 이동량: 최대 80px 또는 대상 높이 10%
- reduced motion·모바일 fallback: 정적 표시

## 10. 콘텐츠와 자산

- demo 데이터 출처: `<SOURCE>`
- 실제 인물·기관으로 오인 가능한 허위 의료/법률/금융 주장 금지
- 모든 이미지·영상·폰트는 `ASSET-MANIFEST.json`에 출처와 라이선스 기록
- 원격 library/font CDN 금지
- 외부 지도·SNS·widget: `<NONE_OR_APPROVED_ALLOWLIST>`
- API key, 개인정보, 서버 주소 커밋 금지

## 11. 에디터 관계

- 기본 테마는 G5가 선택한 editor와 동작해야 합니다.
- `jw-editor for G5`는 별도 plugin입니다.
- 테마 ZIP과 테마 상품 CS에는 포함하지 않습니다.
- editor가 없거나 OFF여도 textarea와 저장 흐름이 깨지면 안 됩니다.
- 본문 출력 CSS는 `jw-editor` canonical HTML과 safe-inline style을 덮어쓰지 않게 검사합니다.
- 테마가 upload·sanitizer·editor 설정을 다시 구현하지 않습니다.

## 12. 금지 사항

- G5 코어 파일·코어 schema 수정
- 사이트별 domain, 전화번호, 주소, API key 하드코딩
- `eval`, `document.write`, 문자열 event handler
- 무검증 `innerHTML`
- 새 jQuery plugin
- remote library/font CDN
- GSAP, Lenis, AOS, Slick, Owl, Font Awesome 전체 번들의 무단 추가
- build 결과를 손으로 수정
- 실행하지 않은 검사를 통과로 기록
- 자동 검사만으로 판매 화면 시각 완성 선언

## 12.1 AI 친화적 코드

- 공개 함수는 입력·출력 type과 실패 조건을 명확히 합니다.
- import 시 자동 실행, 동적 include, 동적 Tailwind class와 숨은 전역 상태를 만들지 않습니다.
- UI 동작 selector는 `data-jw-*` 계약을 사용하고 표현 CSS class와 분리합니다.
- 주석은 G5 호출 순서, 접근성·보안 이유, browser workaround와 제거 조건에만 간략히 씁니다.
- 코드가 그대로 보여 주는 동작을 주석으로 반복하지 않습니다.
- 임의 LOC 상한으로 파일을 자르지 않고 책임과 검사 이유가 갈릴 때 분리합니다.
- 생성 파일 header가 있는 파일은 직접 수정하지 않습니다.

## 13. 표준 명령

```bash
bun ci
bun run --bun --filter @jwsoft/theme-<THEME_SLUG> check
bun run --bun --filter @jwsoft/theme-<THEME_SLUG> build
bun audit --audit-level=high
```

실행 검증은 기존 서비스와 분리된 `g5themes.test` 기준 환경에서 수행합니다. 호스트 설정·포트·런타임 변경이 필요하면 현재 상태와 작업 범위를 먼저 확인합니다.

테마별 추가 명령:

```bash
<THEME_COMMANDS>
```

## 14. 검사 matrix

### 자동

- PHP syntax와 지원 버전 matrix
- TypeScript typecheck, lint, unit test
- Tailwind source 누락과 forbidden CDN 검사
- 라이트·다크 전체 공개 화면과 사용자 선택 저장·초기화 검사
- asset manifest와 license/NOTICE 검사
- bundle budget
- ZIP allowlist와 checksum

### 실제 G5

- PC/mobile
- 비회원/회원/관리자
- 목록/보기/쓰기/수정/검색/페이징
- 로그인/회원가입/마이페이지
- 영카트 OFF/ON `<APPLICABLE>`
- 팝업·캡차·기본 overlay
- 360/390/768/1440px
- keyboard only, reduced motion, 200% zoom
- JavaScript 실패 fallback

### 시각

- benchmark와 색·type·spacing·image rhythm 비교
- 실제 업종 demo 데이터
- header 스크롤 상태
- slider edge case
- 폰트 로딩 전후 CLS
- 빈 데이터·긴 제목·이미지 실패·오류 상태

## 15. 완료 조건

작업 완료 보고에는 다음을 구분합니다.

1. 변경한 파일과 사용자에게 보이는 결과
2. 실행한 검사와 실제 결과
3. 실제 G5 browser 확인 범위
4. 실행하지 못한 검사와 이유
5. 패키지 생성 여부
6. 배포 여부

테스트 통과를 설치·배포 완료로 표현하지 않습니다. 시안이나 fixture를 실제 판매 데이터로 표현하지 않습니다.

## 16. CS 경계

기본 지원:

- 테마 자체 오류
- 명시한 G5/PHP 버전에서의 호환 오류
- 보안 관련 문제
- 설치 문서대로 수행했을 때의 재현 가능한 설치 오류
- 구매 후 1년 이내 제공한 업데이트

온라인 매뉴얼 또는 유상 작업:

- 로고·색상·폰트·메뉴 변경 위치 안내
- 고객별 사이트 제작과 콘텐츠 입력
- 외부 API 계정·키 발급
- 타 plugin 충돌 조사와 맞춤 개발
- 서버 이전·운영·백업

문의 응답은 G5 버전, PHP 버전, 테마 버전, 브라우저, 재현 순서, 오류 로그를 먼저 받습니다.

설치·업데이트·롤백·자주 바꾸는 항목의 위치는 `<MANUAL_BASE_URL>/<THEME_SLUG>/<VERSION>/`에 문서화합니다. 같은 사용법 문의를 개별 설명으로 반복하지 않고 정확한 매뉴얼 항목으로 연결합니다. 문서대로 수행해도 재현되는 문제만 상품 결함으로 판정합니다.

## 17. 이 테마의 확정값

- 메뉴 map: `<LINK_TO_MENU_MAP>`
- page inventory: `<LINK_TO_PAGE_INVENTORY>`
- benchmark: `<LINK_TO_BENCHMARK>`
- design tokens: `<LINK_TO_TOKENS>`
- asset manifest: `<LINK_TO_ASSET_MANIFEST>`
- acceptance checklist: `<LINK_TO_ACCEPTANCE>`
