# JW-Business 1.0 작업 지침

존댓말을 사용하고 사용자를 `형님`이라고 부릅니다. 결과와 영향을 먼저 간결하게 보고합니다.

## 상품과 현재 단계

- 상품명 `JW-Business 1.0`, slug `jw_business`, 개발 버전 `1.0.0-dev.1`.
- 기업·전문 서비스용 G5 커뮤니티 테마입니다. 영카트·빌더·에디터·업로더는 제외합니다.
- 2026-09-21 공식 베이직 전체 반입과 build·구매자 개발 하네스를 구축했습니다. 기존 공통 헤더·메뉴·푸터·메인 source는 실제 화면에서 레거시 G5 CSS·DOM·JavaScript 결합 문제가 확인되어 구현 기준선에서 제외했습니다.
- 공통 기반은 `docs/plans/JW-BUSINESS-LEGACY-MODERNIZATION-PLAN.md`를 따릅니다. 잔여 기능 검증과 일반페이지 개선은 분리합니다. 2026-09-22 사용자 지시에 따라 페이지마다 승인을 묻지 않고 메뉴별로 하위 레이아웃 전체를 묶어 구현·시야 검증·커밋·푸시합니다. 진행 상태는 `docs/plans/JW-BUSINESS-MENU-BATCHES.md`에 기록하며, 전체 기능 완료로 확대 보고하지 않습니다.
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
- `.runtime/gnuboard5` 원본을 수정하지 않습니다. 사용자의 `배포` 지시는 사무실 Ubuntu의 `g5themes.test` 개발 환경을 뜻하며, 해당 지시 범위에서 배포·시험합니다. 별도 온라인 운영 사이트는 없습니다.

## PHP 구조 계약

- 실제 홈은 `src/php/index.php` 하나이며, 선택용 홈은 완성형 `index_1.php`~`index_4.php`로 둡니다. 사용자 지시로 메인 5번은 상품에서 제외했습니다.
- 홈 변경 안내는 선택한 `index_N.php`를 `index.php`로 복사하는 방식만 사용합니다.
- 일반 페이지는 웹루트 `pages/`의 완성형 PHP 파일입니다. `common.php`, 제목, 테마 head, 전체 본문, 테마 tail을 파일 안에 직접 둡니다.
- 테마 내부 `pages/`, `partials/`, `sections/`, `blocks/`와 page dispatcher, 동적 화면 include를 만들지 않습니다.
- 복사용 블록은 런타임 밖에서 관리하고 페이지로 복사한 위치에 원본과 독립 수정임을 주석으로 남깁니다.
- 공용 include는 `docs/STRUCTURE-CONTRACT.md`의 명시 목록에 있는 메뉴와 실제 다중 소비 스킨 조각만 허용합니다.
- 공개 메뉴의 원본은 G5 관리자 메뉴 DB `get_menu_db()`입니다. 별도 navigation catalog를 만들지 않습니다.
- JW 작성·수정 PHP에는 파일 역할, 작성자 또는 원저작자, 저작권, 라이선스 헤더를 둡니다.
- 구조 변경 후 `bun run structure:check`를 먼저 실행합니다.

## 디자인·코딩

- 6차 메인은 정보 구조 참고로만 사용합니다. 공통 기반 gate 전에는 시안 DOM을 구현하지 않습니다.
- daisyUI 기반 사용자 정의 `jw-light`·`jw-dark`와 전체 typography·spacing·container·radius·shadow·motion token으로 공개 화면 전체를 처리합니다.
- 새 페이지 CSS는 `src/styles/` 원본에서 Tailwind 4의 `tw:` utility·`@apply`, daisyUI `tw:d-*` 컴포넌트, DTCG token을 먼저 사용하고 기존 Vite 빌드로 생성합니다. 직접 만든 CSS는 그리드 구성·시안 내부 그래픽 등 필요한 경우에 한정하며 배포 CSS를 손으로 고치지 않습니다.
- 슬라이더는 Embla Carousel, 필요한 스크롤 연출은 Motion `inView`·`scroll`을 사용합니다. 같은 동작을 새 타이머·스크롤 감지기로 중복 구현하지 않고, hover·focus와 동작 줄이기는 CSS와 브라우저 기본 동작을 우선합니다.
- Pretendard·Lucide·Tailwind·DaisyUI·Vite는 공통 표준에 맞게 연결했습니다. 기존 basic 공개 화면 전체 개편과 실제 브라우저 검증은 남아 있습니다.
- 공개 기본 번들은 jQuery와 Migrate를 포함하지 않습니다. 관리자와 외부 확장은 각 소유 영역의 책임이며, core-only 공개 경로는 코어 수정 없는 대체 가능성을 먼저 검증합니다.
- 명시적인 입력·출력과 `data-jw-*` 동작 선택자를 사용합니다. 주석은 호출 순서·보안·접근성의 이유만 간략히 설명합니다.
- 섹션은 먼저 이 테마 내부에서 재사용합니다. 두 테마가 실제 소비하는 코드만 공통 package로 일반화합니다.
- 새 페이지에 고정 게시판 ID나 원격 CDN 의존성을 만들지 않습니다.
- 고객 서버에 Bun·Node.js·Composer·빌드를 요구하지 않습니다.

## 현재 실행 가능한 검사

### 페이지 제작의 필수 품질 차단

- `quality/README.md`, `quality/contract.json`, `quality/assets.json`을 먼저 확인합니다. 과거의 본문 구현 완료 기록은 새로운 품질 통과가 아닙니다.
- 현재 작성된 페이지도 `bun run quality:check`를 통과해야 합니다. 사진의 페이지 간 재사용, 원본·사용 페이지 미등록, 요구사항 누락, 시각 검토 누락·불일치에는 예외를 만들지 않습니다.
- 다음 묶음은 `bun run quality:start <group>`, 완료 보고는 `bun run quality:complete <group>`가 성공해야 합니다. 실패 상태에서 다음 묶음 양산·완료 보고·판매 패키지 생성 금지입니다.
- 내장 브라우저 전체 화면 수집과 다섯 변형 비교는 작업 에이전트가 수행합니다. 실제로 다른 검토 작업의 판단과 근거를 남기며, 구현자가 검토자 ID만 바꿔 자가 승인하지 않습니다.
- 검토 뒤 소스·스타일·사진·생성 파일이 바뀌면 기존 검토 기록을 새 digest로 고쳐 재사용하지 않습니다. 영향을 다시 실제 화면으로 검토합니다.
- `ready` 플래그, 선택자 존재, 자동 검사 통과는 시각적 품질을 보장하지 않습니다. 통과를 위해 검사 규칙·범위·원본 ID를 조작하지 않습니다.

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
