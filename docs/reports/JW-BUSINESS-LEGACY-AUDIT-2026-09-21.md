# JW-Business 1.0 공개 영역 레거시 감사

- 기준일: 2026-09-21
- 상태: 구현 순서를 다시 정하기 위한 현황 감사
- 대상: `themes/business/jw_business/src/php` 공개 커뮤니티 화면
- 제외: G5 관리자 화면, 영카트 화면, G5 코어 직접 수정

## 결론

현재 구현은 현대화된 테마의 기준선으로 사용할 수 없다. 새 메인 화면보다 먼저 공개 문서의 `head.sub.php`, 자산 로딩, 공통 DOM, 메뉴, G5 브라우저 동작을 다시 설계해야 한다.

문제의 핵심은 새 스타일이 부족한 것이 아니다. 공식 basic의 구형 CSS·JavaScript·PC/모바일 DOM을 유지한 상태에서 새 CSS를 겹쳐 놓았기 때문에 두 설계가 동시에 페이지를 지배한다. 이 상태에서 게시판과 일반 페이지를 늘리면 화면마다 예외 CSS와 jQuery 호환 코드가 증가한다.

## 확인한 사실

| 항목 | 현재 상태 | 영향 |
| --- | --- | --- |
| 기본 CSS | `default.css` 또는 `mobile.css` 뒤에 새 CSS를 추가 로딩 | 비레이어인 기본 CSS가 `@layer` 안의 새 CSS보다 우선하여 `#container` 930px, 12px 제목, 구형 헤더가 유지됨 |
| jQuery | G5의 1.12.4 + Migrate 1.4.1 전역 로딩 | 지원이 끝난 구형 런타임을 모든 공개 페이지가 부담 |
| 테마 PHP | 영카트 경로 제외 50개 PHP 파일에 `jQuery` 또는 `$()` 존재 | 단순 script tag 삭제로는 기능 보존 불가 |
| G5 JavaScript | `jquery.menu.js`, `common.js`, `wrest.js`, `placeholders.min.js` 로딩 | 메뉴·폼·전역 함수가 구형 DOM과 전역 상태에 결합 |
| 기타 자산 | Font Awesome 4, 모바일 Modernizr 2.6 계열, IE8 html5 shim | Lucide·현대 브라우저 기준과 중복되며 지원 범위를 흐림 |
| 문서 head | 모바일에만 viewport, 데스크톱에는 `X-UA-Compatible`·`imagetoolbar` | 반응형 문서 계약이 기기 판정에 따라 달라짐 |
| PC/모바일 | 별도 PHP·skin·CSS 구조 | 동일 기능을 두 번 구현하고 화면·접근성 회귀가 갈라짐 |
| 토큰 | 색상 역할 12개만 정의 | 글자·간격·컨테이너·모서리·그림자·동작의 일관성을 보장하지 못함 |

실제 개발 화면에서는 viewport 1421px에서 `#container`가 930px, 메인 제목이 12px로 계산되었다. 이는 시안 재현 실패가 디자인 취향 문제가 아니라 자산 우선순위와 DOM 경계 실패임을 보여 준다.

## jQuery 판단

### 최종 기준

JW-Business 공개 테마 기본 번들에서는 jQuery와 jQuery Migrate를 제거한다. 테마 소유 PHP·TypeScript·JavaScript에는 `jQuery`, `$()`, jQuery plugin을 허용하지 않는다.

현재 1.12.4를 최신 4.0.0으로 바로 바꾸는 방식은 채택하지 않는다. 공식 jQuery Migrate 안내도 jQuery 4 전환 전에 먼저 jQuery 3.x로 올리고 경고를 해소하도록 요구한다. Migrate는 구형 코드를 영구 지원하는 호환 계층이 아니라 전환 중 폐기 API를 찾는 개발 도구다.

- [jQuery 4.0.0 출시 안내](https://blog.jquery.com/2026/01/17/jquery-4-0-0/)
- [jQuery 공식 지원 정책](https://jquery.com/support/)
- [jQuery Migrate 공식 전환 안내](https://github.com/jquery/jquery-migrate)
- [jQuery 공식 다운로드와 Migrate 버전 안내](https://jquery.com/download/)

### 전환 중 사용 원칙

1. 전역 기본 로딩은 제거 대상으로 표시한다.
2. 아직 변환하지 않은 화면을 조사할 때만 개발 환경에서 jQuery 3.7.1 + Migrate 3.6.0 개발판을 사용해 경고를 수집한다.
3. 경고를 해소한 뒤 필요할 때만 jQuery 4.0.0 + Migrate 4.0.2로 잔여 의존성을 확인한다.
4. 최종 판매 payload에는 두 단계의 jQuery와 Migrate 모두 포함하지 않는다.
5. 외부 스킨·플러그인이 jQuery를 요구하면 해당 확장이 자기 의존성과 호환성을 책임진다. 테마는 이를 기본 지원 범위로 약속하지 않는다.

### 코어 경계의 예외 조사

G5 코어의 `bbs/view_image.php` 등 일부 공개 경로는 인라인 jQuery를 직접 사용한다. 코어를 수정하지 않고 테마·hook·별도 public adapter로 동작을 교체할 수 있는지 먼저 검증한다.

대체가 불가능하다고 실증된 경로만 페이지 한정 호환 자산을 검토한다. 이 경우에도 전역 head에 jQuery를 되돌리지 않으며, 해당 경로·버전·제거 조건을 manifest에 기록한다. 가능성 검토 없이 “코어가 쓰므로 유지”하거나 “일단 삭제”하지 않는다.

관리자 화면은 G5 코어 소유이므로 이번 테마의 jQuery 제거 대상이 아니다. 테마가 관리자 head나 자산을 덮어쓰지 않는다.

## 폐기할 공개 자산

| 자산 | 처리 |
| --- | --- |
| `default.css`, `mobile.css` 및 basic skin CSS | 최종 공개 화면에서 로딩 금지. 기능별 새 source로 교체 |
| jQuery 1.12.4, Migrate 1.4.1 | 전역 로딩 제거 |
| `jquery.menu.js` | 네이티브 메뉴 controller로 교체 |
| `common.js` | 실제 사용하는 함수 목록을 추출하고 작은 G5 adapter로 교체 |
| `wrest.js` | HTML 제약 검증 + 서버 검증을 유지하는 폼 adapter로 교체 |
| `placeholders.min.js` | 제거 |
| `modernizr.custom.70111.js` | 제거 |
| IE8 `html5.js` | 제거 |
| Font Awesome 4 | 제거하고 필요한 Lucide SVG만 build |
| 원본의 PC/모바일 시각 분기 | 하나의 반응형 공통 partial로 수렴 |

PHP 파일을 삭제하는 것이 아니라 G5가 요구하는 include 경로와 변수 계약은 유지한다. 구형 CSS 클래스와 전역 JavaScript를 시각·동작 기반으로 사용하지 않는다는 뜻이다.

## 기존 계획과의 충돌

기존 벤치마킹 문서의 “G5 코어가 사용하는 jQuery는 그대로 둘 수 있다”는 판단은 이 감사와 사용자 지시로 JW-Business에 한해 폐기한다. 공통 표준도 공개 테마 최종 목표를 jQuery-free로 바꾼다.

구체적인 구현 순서와 중단 조건은 [레거시 제거·현대화 실행 계획](../plans/JW-BUSINESS-LEGACY-MODERNIZATION-PLAN.md)을 따른다.
