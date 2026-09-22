# JW-Business 1.0 작업 지침

존댓말을 사용하고 사용자를 `형님`이라고 부릅니다. 결과와 영향을 먼저 간결하게 보고합니다.

## 상품과 현재 단계

- 상품명 `JW-Business 1.0`, slug `jw_business`, 개발 버전 `1.0.0-dev.1`.
- 기업·전문 서비스용 G5 커뮤니티 테마입니다. 영카트·빌더·에디터·업로더는 제외합니다.
- 2026-09-21 공식 베이직 전체 반입과 build·구매자 개발 하네스를 구축했습니다. 기존 공통 헤더·메뉴·푸터·메인 source는 실제 화면에서 레거시 G5 CSS·DOM·JavaScript 결합 문제가 확인되어 구현 기준선에서 제외했습니다.
- 공통 기반은 `docs/plans/JW-BUSINESS-LEGACY-MODERNIZATION-PLAN.md`를 따릅니다. 2026-09-22 사용자 지시에 따라 잔여 기능 검증과 일반페이지 개선을 분리하여 진행합니다. 일반페이지는 Enfold 연구 적용 보고서의 순서대로 페이지 단위 구현·시야 검증을 하며, 전체 기능 완료로 확대 보고하지 않습니다.
- 출시 범위는 루트 `docs/plans/JW-BUSINESS-1.0-IMPLEMENTATION-SCOPE.md`를 따릅니다.

## 먼저 읽기

루트 `AGENTS.md` → `docs/START-HERE.md` → 이 파일과 `PRODUCT.md` → 요청 관련 기준 문서 순서로 읽습니다.
작업 전 `git status --short`, 대상 파일, 완료 조건과 필수 검사를 확인합니다.

## 수정 경계

- `src/php/`는 공식 basic 460개 파일을 반입한 수정 원본입니다. 기존 CSS·JS·이미지도 원래 상대 경로로 보존했습니다.
- `THEME-INVENTORY.md`와 `docs/BASIC-INVENTORY.json`에 원본 버전·hash·분류가 있습니다. 반입 hash는 최종 디자인 승인 hash가 아닙니다.
- `src/styles/`, `src/scripts/`, `src/assets/`는 새 스타일·동작·자산 원본입니다.
- `tokens/theme.tokens.json`을 수정하고 `generated/`를 재생성합니다. 생성 CSS를 직접 고치지 않습니다.
- `theme/`는 build가 다시 만드는 설치 payload입니다. 생성 결과를 직접 고치거나 실제 G5 설치 검증 완료본으로 안내하지 않습니다.
- G5 코어와 DB schema는 수정하지 않습니다. `theme/basic` 스킨 문자열을 테마 경로라고 오인해 일괄 변경하지 않습니다.
- 쇼핑몰 174개 파일은 반입 증거로 보존하며 출시 payload에서는 제외합니다. 커뮤니티 PC·모바일 경로는 모두 개편·검증합니다.
- `.runtime/gnuboard5` 원본을 수정하지 않습니다. Ubuntu 배포·시험은 별도 명시 지시에 따릅니다.

## 디자인·코딩

- 6차 메인은 정보 구조 참고로만 사용합니다. 공통 기반 gate 전에는 시안 DOM을 구현하지 않습니다.
- daisyUI 기반 사용자 정의 `jw-light`·`jw-dark`와 전체 typography·spacing·container·radius·shadow·motion token으로 공개 화면 전체를 처리합니다.
- Pretendard·Lucide·Tailwind·DaisyUI·Vite는 공통 표준에 맞게 연결했습니다. 기존 basic 공개 화면 전체 개편과 실제 브라우저 검증은 남아 있습니다.
- 공개 기본 번들은 jQuery와 Migrate를 포함하지 않습니다. 관리자와 외부 확장은 각 소유 영역의 책임이며, core-only 공개 경로는 코어 수정 없는 대체 가능성을 먼저 검증합니다.
- 명시적인 입력·출력과 `data-jw-*` 동작 선택자를 사용합니다. 주석은 호출 순서·보안·접근성의 이유만 간략히 설명합니다.
- 섹션은 먼저 이 테마 내부에서 재사용합니다. 두 테마가 실제 소비하는 코드만 공통 package로 일반화합니다.
- 새 페이지에 고정 게시판 ID나 원격 CDN 의존성을 만들지 않습니다.
- 고객 서버에 Bun·Node.js·Composer·빌드를 요구하지 않습니다.

## 현재 실행 가능한 검사

테마 루트에서 실행합니다.

```sh
bun run doctor
bun run build
bun run check
bun run hash:payload
```

구매자 개발 키트의 최초 일괄 구축 명령은 `bun run setup`입니다. 내부 AGENTS와 구매자용 `delivery/developer-kit/AGENTS.md`를 섞지 않습니다.
PHP 버전 matrix·브라우저·ZIP 설치 검사는 아직 완료 전입니다. 없는 검사나 실행하지 않은 검사를 통과로 보고하지 않습니다.
실제 G5 PC/모바일, 비회원/회원/관리자, 게시판·회원·기본 기능 전체와 라이트/다크 검증 전에는 테마 완료로 보고하지 않습니다.

## 입력·버튼 정렬 규칙

- 단일 행 입력·선택상자·실행 버튼은 `--jw-control-height` 토큰을 사용합니다. 각각 다른 고정 높이를 지정하지 않습니다.
- 라벨을 포함한 검색행은 컨트롤 하단을 정렬하며, 모바일은 필터를 위에 두고 검색 입력과 실행 버튼을 같은 행에 유지합니다.
- 체크박스·라디오·파일 입력·여러 줄 텍스트는 단일 행 높이 강제 대상에서 제외합니다.
- 폼 변경은 PC/모바일에서 실제 입력칸과 버튼의 높이·상단 좌표를 측정하고 시야 확인합니다. 같은 행의 허용 오차는 1px 이내입니다.
