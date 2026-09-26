# JW-Business 파일 구조 계약

이 문서는 `JW-Business 1.0`의 런타임 PHP 구조를 고정합니다. 기존 그누보드5 테마 사용자가 별도의 page renderer, recipe, partial 규칙을 다시 배우지 않게 하는 것이 목적입니다.

## 1. 홈 파일

- 실제 홈 진입점은 `theme/jw_business/index.php` 하나입니다.
- 선택용 홈은 `index_1.php`부터 `index_4.php`까지 각각 완성형 파일로 제공합니다.
- 각 파일은 `_INDEX_` 선언, `head.php` 호출, 전체 홈 본문, `tail.php` 호출을 직접 포함합니다.
- 홈을 바꿀 때는 기존 `index.php`를 백업하고 선택한 `index_N.php`를 `index.php`로 복사합니다.
- 홈 본문을 `partials/`, `sections/`, renderer 함수나 동적 include로 분리하지 않습니다.
- 선택용 `index_N.php`의 직접 미리보기에는 `dirname(__DIR__, 2).'/common.php'`의 G5 초기화만 허용합니다. 사이트 기본 홈 선택은 파일 복사로만 변경합니다.

## 2. 일반 페이지

- 일반 페이지는 판매 ZIP의 웹루트 `/pages/`에 둡니다.
- 각 PHP 파일은 `../common.php`, 페이지 제목, 테마 `head.php`, 전체 본문, 테마 `tail.php`를 직접 포함합니다.
- `$jw_page_id`만 지정하고 공통 dispatcher에 넘기는 wrapper 페이지를 금지합니다.
- 테마 내부에 일반 페이지용 `pages/` 디렉터리나 page renderer를 두지 않습니다.

## 3. 허용하는 공통 include

여러 파일에서 실제로 함께 쓰는 사이트 골격만 허용합니다.

| 파일 | 허용 호출 위치 | 역할 |
| --- | --- | --- |
| `inc/menu.php` | `head.php`, `mobile/head.php` | PC 공통 메뉴 |
| `inc/mobile-menu.php` | `head.php`, `mobile/head.php` | 모바일 공통 메뉴 |

게시판 목록과 최신글 마크업은 PC·모바일 각 `skin/board/<종류>/list.skin.php`, `skin/latest/<종류>/latest.skin.php`가 직접 소유합니다. `inc/`에는 메뉴 두 파일 외의 화면 공통 파일을 두지 않습니다. 새 공통 파일은 사용자 승인 전에 허용 목록에 추가하지 않습니다.

G5 스킨에서 실제 두 곳 이상이 함께 사용하는 아래 기능 조각도 호출 위치를 고정하여 허용합니다.

| 파일 | 허용 호출 위치 | 역할 |
| --- | --- | --- |
| `skin/member/basic/certification.php` | 비밀번호 찾기, 회원정보 입력 스킨 | 본인확인 제공자 설정 |
| `skin/member/basic/steps.php` | 회원가입 1~3단계 스킨 | 회원가입 단계 표시 |
| `skin/qa/basic/attachments.php` | 문의 본문, 답변 본문 스킨 | 문의 첨부 출력 |
| `skin/qa/basic/form.fields.php` | 문의 작성, 관리자 답변 스킨 | 동일한 문의 폼 |

- 새 공통 include는 사용자 승인을 받은 뒤 이 표와 구조 검사기의 명시적 허용 목록에 추가합니다.
- 공통 메뉴의 데이터 원본은 G5 관리자 메뉴 DB의 `get_menu_db()`입니다. 별도 navigation catalog가 이를 대체하지 않습니다.
- 데이터 원본 변경과 메뉴 화면 평탄화는 별개입니다. PC 다열 분류와 모바일 분류·아코디언을 유지합니다. 테마 시연의 연속 디자인 항목만 순수 함수로 묶으며 DB의 URL·순서·노출 설정을 새 항목으로 대체하거나 되살리지 않습니다. 일반 메뉴는 기본 G5 방식으로 표시합니다.
- 일반 페이지와 홈 파일은 `head.php`, `tail.php` 외의 테마 화면 파일을 include하지 않습니다.
- 순수 데이터·이스케이프·URL 함수는 `lib/`에 둘 수 있지만 HTML을 출력하는 함수나 renderer는 두지 않습니다.
- G5 기본 `.skin.php` 호출과 G5 코어 라이브러리 호출은 이 계약의 화면 조각 include로 보지 않습니다.

## 4. 블록과 섹션 재사용

- 복사용 블록 원본은 런타임 테마 밖의 `blocks/`에 둡니다.
- 블록은 대상 홈이나 일반 페이지로 복사하여 사용합니다.
- `blocks/` 파일을 실행 중 include하지 않습니다.
- 복사된 코드는 독립본이며 원본 블록 변경을 자동 반영하지 않습니다.

```html
<!--
JW BLOCK: home/service-grid-02
복사 원본: blocks/home/service-grid-02.php
현재 페이지에 복사된 독립 코드입니다.
-->
```

## 5. PHP 파일 상단 정보

JW SOFT가 새로 작성하거나 G5 원본에서 수정한 PHP 파일은 상단에 다음 정보를 둡니다.

```php
/**
 * Theme: JW-Business 1.0
 * File: index_2.php
 * Role: 메인 홈 디자인 2번
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT
 * License: JW SOFT Commercial License
 */
```

G5 원본을 수정한 파일은 원저작자와 원본 라이선스를 보존하고 `Original`, `Modified by` 정보를 사용합니다. 수정하지 않은 원본 파일은 `BASIC-INVENTORY.json`과 LGPL 고지로 추적합니다.

## 6. 자동 강제

```sh
bun run structure:check
```

이 검사는 다음을 실패 처리합니다.

- `src/php/pages`, `partials`, `sections`, `blocks` 런타임 디렉터리
- 누락되거나 본문이 없는 `index.php`, `index_1.php`~`index_4.php`
- 공통 dispatcher에 넘기는 `/pages/*.php` wrapper
- wrapper 페이지를 다시 생성하는 build 코드
- 허용하지 않은 공통 include 파일 또는 호출 위치
- G5 관리자 메뉴 DB를 우회한 별도 메뉴 데이터 원본
- 동적 페이지·블록·섹션 include
- JW 작성·수정 PHP의 작성자·저작권·역할·라이선스 헤더 누락
- G5 `readme.txt` 8개 필드 순서 오류
- 상용 `LICENSE.txt` 또는 G5 LGPL 고지 누락

테마 `bun run check`와 저장소 루트 `bun run check`의 첫 단계에서 실행합니다. 기존 구조에 대한 예외 목록은 두지 않으므로 현재 위반을 모두 제거하기 전까지 전체 검사는 실패합니다.
