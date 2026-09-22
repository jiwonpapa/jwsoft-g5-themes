# 재사용 섹션 라이브러리 구현 방안 초안

- 문서 상태: 구현 방법 초안, 출시 대상은 확정 범위 문서 적용
- 작성일: 2026-09-20
- 임시 참고 시안: `prototypes/business-theme-v2`이며 최종 디자인 기준은 추가 시안 비교 후 확정
- 적용 대상: JW SOFT G5 유료 테마의 일반 페이지
- 구현 상태: `/pages` route·catalog·직접 메뉴 파사드 착수

2026-09-21 [출시 구현 범위](JW-BUSINESS-1.0-IMPLEMENTATION-SCOPE.md)에서 메인 5종·하위 일반 페이지 14개 유형 각각 5종, 총 75개 레이아웃을 확정했다. 아래 20개는 기본 섹션 역할 목록이며 배포 수량 상한이 아니다. 75개 페이지에 채택한 재사용 섹션의 모든 레이아웃 변형을 제공한다.

## 기존 제작물 참고 근거

2026-09-21 [ASKTHEME B3 상품의 PC·모바일 화면을 직접 검토](../research/business/ASKTHEME-B3-VISUAL-REFERENCE-2026-09-21.md)했다. 서로 다른 최신글 표현과 소개·사업·실적·문의 섹션을 조합하는 방식, 소개 한 열·갤러리 두 열처럼 콘텐츠에 맞춘 모바일 배치를 참고한다. 과거 디자인과 제공 수량은 그대로 승계하지 않는다. 실제 데모 접속은 불가능했으므로 기존 효과의 동작 품질이나 코드 재사용 구조를 검증한 것은 아니다.

과거 변경이력의 Swiper 중복 사용 수정은 새 섹션을 반복 삽입할 때 컨트롤·상태·초기화 간섭을 검사해야 한다는 참고 사례다. 아래 정적 복사형과 PHP 조합형의 구분 및 기존 기획 범위는 유지한다.

## 1. 결정 요약

2차 기업 테마 시안에서 확인한 섹션 재사용 원칙을 유지하되, 최종 시각 기준은 추가 시안까지 비교한 뒤 정합니다. 테마마다 **완성형 일반 페이지와 복사 가능한 섹션 라이브러리**를 함께 제공합니다.

구매자는 관리자 페이지 빌더나 G5 내용관리를 거치지 않고 다음 방식으로 일반 페이지를 구성합니다.

1. 제공된 완성형 일반 페이지를 그대로 사용합니다.
2. 온라인 매뉴얼의 섹션 미리보기에서 필요한 섹션을 고릅니다.
3. 검증된 section partial을 선택한 page recipe에 추가합니다.
4. `custom/` 예시에서 문구·링크·이미지만 바꿉니다.
5. 테마에 포함된 CSS와 공통 동작 스크립트가 레이아웃·반응형·효과를 자동 적용합니다.

이 기능은 페이지 빌더가 아닙니다. 드래그 앤 드롭 편집기, 관리자 설정 생성기, 임의 디자인 조합 엔진을 만들지 않습니다. 판매 ZIP 안에 이미 완성된 페이지·섹션·자산·동작과 버전이 맞는 사용 설명서를 제공하는 방식입니다.

## 2. 목표와 경계

### 2.1 목표

- 메인에서 사용한 사진·실적·프로젝트·역량·프로세스·문의 섹션을 일반 페이지에서도 재사용
- 회사소개·비전·연혁·사업소개·인재채용·오시는 길을 완성형 페이지로 제공
- 서로 다른 페이지의 섹션을 순서 변경·중복 삽입해도 스타일과 효과 유지
- 구매자가 Bun·Node.js·Tailwind 빌드 없이 사용
- 테마 업데이트 후에도 같은 major의 page recipe·section 계약을 유지
- 섹션별 미리보기·복사 코드·수정 위치·주의사항을 온라인 매뉴얼에 제공

### 2.2 하지 않는 것

- G5 코어와 DB 스키마 수정
- 관리자용 페이지 빌더·블록 편집기·사이트 자동 생성기
- 구매자 서버에서 Tailwind·Vite·Bun 실행
- page recipe에 `<script>`, `<style>`, 이벤트 속성이나 외부 CDN을 직접 삽입
- 모든 테마에서 섹션의 디자인을 똑같게 강제
- 한 테마에서 산 섹션을 다른 테마에서도 무조건 호환한다고 보장
- 구매자의 임의 HTML·CSS 변경과 제3자 편집기 변형을 제품 결함으로 지원

## 3. 두 가지 사용 경로

| 경로 | 대상 | 제공 형식 | 허용 기능 |
| --- | --- | --- | --- |
| 정적 section 조합형 | 일반 구매자 | 테마 내부 PHP partial과 교체용 데이터 | 정적 레이아웃, reveal, 숫자 표현, JS가 보강하는 slider·accordion |
| 동적 section 조합형 | 제작사·개발자 | 테마 내부 PHP partial과 명시적 입력값 | G5 최신글·게시판·회원 상태 등 동적 데이터 포함 |

두 경로는 같은 시각 토큰과 동작 어댑터를 사용합니다. 일반 페이지 본문은 모두 PHP route·recipe·partial로 관리하고, 내용관리는 약관·개인정보처럼 단순 텍스트 정책문서에만 사용합니다.

### 3.1 정적 section 조합형

구매자용 기본 경로입니다. 온라인 매뉴얼에서 원하는 section ID를 고르고 제공된 page recipe 예시에 partial 호출과 데이터 배열을 붙여넣습니다.

```php
<?php
echo jw_business_render_section('proof-stats-01', array(
    'title' => '숫자로 확인하는 경험',
    'items' => array(
        array('value' => '18년', 'label' => '프로젝트 경험'),
        array('value' => '320+', 'label' => '완료 프로젝트'),
        array('value' => '86개사', 'label' => '고객사'),
    ),
));
?>
```

위 코드는 입력 계약 예시이며 최종 함수명과 항목 schema는 실제 page recipe 구현 때 고정합니다.

### 3.2 PHP 조합형

최신글, 특정 게시판 목록, 로그인 상태, G5 경로 상수처럼 서버 데이터가 필요한 섹션에 사용합니다. 테마 페이지에서 검증된 partial을 호출하고, 문자열·URL·목록 데이터는 명시적인 입력 배열로 전달합니다.

```php
<?php
echo jwsoft_render_section('news-featured-01', array(
    'board' => 'news',
    'limit' => 4,
));
?>
```

실제 함수명과 입력 계약은 두 번째 테마 사용이 확인되기 전까지 첫 테마 내부에 둡니다. G5 전역값을 partial 곳곳에서 직접 읽거나 섹션이 SQL을 직접 작성하지 않습니다.

## 4. G5 일반 페이지 route 원칙

- 공개 주소는 `/pages/<page-id>-<1~5>.php`다.
- 루트 `/pages/*.php`는 `common.php`를 불러오고 활성 테마의 공통 page renderer에 안정적인 page ID만 넘긴다.
- 75개 route는 catalog에서 생성하고 사람이 중복 편집하지 않는다.
- 테마의 page recipe가 section ID와 순서, 입력 데이터를 소유한다.
- 구매자 수정은 `theme/jw_business/custom/` 아래 예시를 복사해 적용하며 업데이트 ZIP이 실제 custom 파일을 덮어쓰지 않는다.
- 주 메뉴는 테마의 `navigation.php`가 소유한다. G5 관리자 메뉴 DB와 2단 제한에 의존하지 않는다.
- 내용관리는 약관·개인정보처리방침·이메일무단수집거부 같은 단순 정책문서에만 사용한다.
- section의 동작 selector는 `data-jw-*`, 시각 class는 `jw-section--*`로 분리한다. JS가 실패해도 핵심 본문과 링크를 읽을 수 있어야 한다.

## 5. 섹션 단위 계약

각 섹션은 다음 파일과 정보를 한 단위로 관리합니다.

```text
sections/<section-id>/
├── partial.php             # 정적·동적 공통 출력 원본
├── example.php             # page recipe에 복사할 입력 예시
├── preview.desktop.png
├── preview.mobile.png
├── README.md               # 교체할 문구·이미지·링크와 제한
└── fixture.json            # 긴 문구·누락 이미지·반복 삽입 시험 데이터
```

섹션 ID는 `영역-역할-번호` 형식을 사용합니다.

- `intro-image-copy-01`
- `business-photo-grid-01`
- `proof-stats-01`
- `project-slider-01`
- `company-timeline-01`
- `contact-cta-01`

한 섹션의 계약에는 다음 필드를 둡니다.

| 필드 | 의미 |
| --- | --- |
| `id` | 테마 안에서 변하지 않는 섹션 식별자 |
| `version` | 섹션 마크업 계약 버전 |
| `mode` | `static-partial`, `dynamic-partial` 또는 둘 다 |
| `behaviors` | reveal·slider·accordion 등 필요한 동작 |
| `assets` | 포함 이미지·아이콘과 라이선스 |
| `themeCompatibility` | 사용할 수 있는 테마 slug와 최소 버전 |
| `recipeSafe` | 명시된 page recipe 입력 계약을 통과했는지 여부 |
| `repeatSafe` | 같은 페이지에 두 번 넣어도 되는지 여부 |
| `variants` | 구매자가 선택할 수 있는 검증된 변형 class |

구현 단계에서는 이 정보를 `SECTION-LIBRARY.json`으로 만들고 JSON Schema·중복 ID·파일 누락·자산 누락을 검사합니다.

## 6. 스타일 구성

구매자에게 Tailwind utility 조합법을 노출하지 않습니다. 섹션 HTML에는 의미가 고정된 `jw-*` class를 사용하고, 판매 CSS에 필요한 스타일을 모두 포함합니다.

```text
src/styles/
├── tokens.css
├── components.css
├── sections/
│   ├── intro.css
│   ├── business.css
│   ├── proof.css
│   ├── project.css
│   ├── company.css
│   └── contact.css
└── theme.css
```

- 색·서체·간격·radius는 해당 테마 token을 사용합니다.
- 같은 섹션 ID라도 다른 테마에서는 각 테마의 token과 사진 방향을 따릅니다.
- 섹션 바깥 페이지 구조나 `#main`, 메인 전용 body class에 의존하지 않습니다.
- 섹션 자체의 바깥 여백은 공통 rhythm class가 소유하고, 첫·마지막 여백은 content skin이 처리합니다.
- container 중첩을 막기 위해 `jw-section__inner`를 한 번만 사용합니다.
- section partial 안에 인라인 색상·간격·글꼴 값을 넣지 않습니다.
- 추가 섹션 전체를 Tailwind 4 source로 명시해, 배포 뒤 복사한 섹션의 CSS가 빠지지 않게 합니다.

```css
@import "tailwindcss" source("../");
@source "../sections/**/*.html";
@source "../pages/**/*.html";
```

최종 상품에는 생성된 CSS만 포함하며 고객 서버에서 source scan이나 build를 실행하지 않습니다.

## 7. 효과와 공통 스크립트

효과는 섹션 HTML에 스크립트를 복사하는 방식이 아니라 테마의 단일 runtime이 hook을 찾아 보강하는 방식으로 제공합니다.

```ts
export function mountSectionBehaviors(root: ParentNode = document): BehaviorHandle;
```

### 7.1 필수 동작 규칙

- 같은 root에 두 번 실행해도 listener·Swiper·observer를 중복 생성하지 않음
- 같은 섹션을 한 페이지에 두 번 넣어도 버튼과 pagination이 자기 섹션 안에서만 작동
- `destroy()` 또는 `AbortSignal`로 listener·observer·timer 정리
- class 하나가 시각 스타일과 동작 selector 역할을 동시에 하지 않음
- 본문·폼·핵심 CTA를 패럴랙스 대상으로 사용하지 않음
- `prefers-reduced-motion: reduce`와 모바일에서는 reveal·패럴랙스를 정적으로 표시
- 초기 HTML은 항상 보이고, JS 초기화 뒤에만 효과 상태를 부여
- Swiper는 2장 이상일 때만 초기화하고 navigation element를 섹션 root 안에서 직접 찾음
- autoplay는 기본 OFF, 사용할 경우 정지 버튼·hover/focus 정지 제공

### 7.2 제공할 효과

| 효과 | 적용 대상 | 기본값 |
| --- | --- | --- |
| reveal | 제목·사진·목록 | 1회, 짧은 거리와 시간 |
| stagger | 아이콘·실적·목록 | 항목 수 제한, 내용 즉시 접근 가능 |
| slider | 프로젝트·인증·사례 | 수동 전환, touch·keyboard·A11y |
| accordion | FAQ·과정 설명 | JS가 버튼과 ARIA 생성, 첫 항목 선택 가능 |
| parallax | 장식 사진 일부 | 최대 80px 또는 대상 높이 10%, 모바일 OFF |

숫자 count-up은 실제 숫자를 HTML에 먼저 출력하고 시각적으로만 보강합니다. 검색엔진·스크린리더·JS OFF 환경에서 0으로 보이지 않게 합니다.

## 8. 첫 상품의 섹션 목록 초안

초기 초안의 **6개 계열, 20개 섹션**은 기본 역할 목록으로 사용합니다. 이를 수량 상한으로 제한하지 않고, 75개 페이지에 채택한 전체 재사용 섹션 변형을 구현·검증·배포합니다. 최종 독립 섹션 수는 승인된 화면을 분해한 manifest에서 산출합니다.

| 계열 | 섹션 초안 |
| --- | --- |
| Intro 3종 | 서브페이지 소개, 사진+소개문, 대표 인사말 |
| Business 4종 | 사진형 3분할, 좌우 교차 상세, 아이콘 역량, 단계별 프로세스 |
| Proof 3종 | 실적 수치, 인증·수상, 고객·파트너 목록 |
| Project 3종 | 대표 사례, 사례 그리드, 사례 slider |
| Company 4종 | 비전·가치, 연혁 timeline, 조직 안내, 복리후생 |
| Conversion 3종 | 자료 다운로드, 문의 CTA, 연락처·오시는 길 |

본문 안에서 실시간 게시물을 불러오는 기업소식·채용공고·프로젝트 목록은 HTML 섹션 수에 포함하지 않고 PHP 조합형으로 제공합니다.

## 9. 완성형 일반 페이지 초안

2026-09-21 사용자 정정과 출시 범위 확정에 따라 **각 하위 페이지마다 5종의 완성 레이아웃**을 제공합니다. 기업개요·인사말·연혁 등을 각각 한 개 만들고 합쳐서 '회사소개 5종'으로 세지 않습니다.

[확정 구성표](JW-BUSINESS-1.0-IMPLEMENTATION-SCOPE.md)에 기업개요·인사말·비전·연혁·조직도·인증·오시는 길과 사업·채용·고객지원·연락처 각각의 5개 레이아웃을 정리했습니다. 메인까지 합쳐 75개이며 상위 메뉴 6분류 30종 집계는 폐기합니다.

구매자에게는 `회사소개 > 연혁 03 — 연도별 표형`처럼 하위 페이지·패턴 번호·미리보기·필요한 자료를 함께 보여줍니다. 페이지 조합은 달라도 색상·버튼·아이콘·공통 기능은 재사용합니다. 동적 고객지원·최신글은 PHP 조합형이며 정적 HTML 제공 수량에 섞어 표기하지 않습니다.

### 하위 일반 페이지 범위와 조합 소재

각 행은 5개 레이아웃을 갖는 별도 페이지 유형입니다. 아래 기본 조합은 소재 참고이며 모든 패턴을 같은 순서로 만드는 명세가 아닙니다. 메인·고객센터 안내·연락처 안내까지 포함한 전체 목록은 출시 범위 문서를 따릅니다.

| 페이지 | 기본 조합 |
| --- | --- |
| 기업 개요 | 서브 소개 + 사진·소개문 + 실적 + 비전·가치 + 문의 CTA |
| 대표 인사말 | 서브 소개 + 대표 사진·인사말 + 핵심 원칙 + 문의 CTA |
| 비전·가치 | 서브 소개 + 비전 선언 + 아이콘 가치 + 실적 |
| 연혁 | 서브 소개 + 연혁 timeline + 실적 + 문의 CTA |
| 조직도 | 조직 소개 + 상하 관계가 드러나는 조직 구성 + 부서 안내 |
| 인증·수상 | 서브 소개 + 인증 그리드 + 고객·파트너 + 자료 다운로드 |
| 사업영역 | 서브 소개 + 사진형 사업 3분할 + 프로세스 + 대표 사례 |
| 사업 상세 | 사업 소개 + 상세 설명 + 근거·사례 + 문의·자료 연결 |
| 프로세스 | 과정 소개 + 단계·산출물 안내 + 관련 사례·문의 연결 |
| 인재상 | 인재상 선언 + 역량·가치 + 채용공고 연결 |
| 복리후생 | 제도 소개 + 항목별 설명·사진 + 채용공고 연결 |
| 오시는 길 | 회사 정보 + 연락처 + 정적 지도 이미지 또는 승인된 지도 링크 |

완성 페이지는 섹션 원본을 복제해 따로 유지하지 않습니다. 페이지 recipe가 섹션 ID와 순서를 참조하고, build가 배포용 HTML 예시를 생성하도록 설계합니다.

## 10. 개발 저장소와 판매 ZIP

### 10.1 개발 저장소

```text
themes/business/<theme-slug>/
├── src/
│   ├── sections/                 # 섹션 단일 원본
│   ├── pages/                    # 섹션 조합 recipe
│   ├── styles/sections/
│   └── scripts/behaviors/
├── theme/                        # 공식 basic 기반 G5 테마
├── SECTION-LIBRARY.json
├── PRODUCT.md
├── DESIGN.md
└── AGENTS.md
```

### 10.2 판매 ZIP

```text
<product-version>.zip
├── theme/<theme-slug>/           # G5 theme 아래에 업로드할 완성 테마
├── pages/                        # G5 루트에 업로드할 75개 route와 catalog
├── section-library/
│   ├── START.html                # 사용 순서와 호환 버전
│   ├── sections/                 # 섹션별 recipe 예시
│   ├── pages/                    # 완성 페이지 조합 설명
│   └── previews/                 # PC·모바일 미리보기
├── CHANGELOG.md
├── THIRD_PARTY_NOTICES.md
└── SHA256SUMS
```

테마의 최종 CSS·JS에는 판매 ZIP의 모든 제공 섹션이 포함됩니다. 루트 `/pages`의 route는 활성 테마 renderer를 호출하고, section partial과 실행 자산은 설치된 테마가 소유합니다. 일반 페이지 본문을 G5 내용 DB에 저장하지 않습니다.

## 11. 온라인 매뉴얼

온라인 매뉴얼에는 테마 버전별 `섹션 라이브러리` 메뉴를 둡니다.

각 섹션 문서는 다음을 한 화면에서 제공합니다.

- PC·모바일·라이트·다크 미리보기
- 지원 테마와 최소 버전
- PHP recipe 예시 복사 버튼
- 교체할 문구·링크·이미지 표시
- 사용할 수 있는 변형 class
- 지원 효과와 모션 감소 상태
- 같은 페이지에 중복 사용 가능한지 여부
- 조합이 확인된 다른 섹션
- 흔한 오류와 원본으로 복구하는 방법

문서의 복사 버튼은 검증된 원본 파일을 그대로 복사해야 합니다. 웹페이지에 보이기 위해 escape한 코드와 실제 배포 snippet이 달라지는 복제 구조를 만들지 않습니다.

## 12. 버전·업데이트 정책

- 섹션 ID와 PHP 출력·입력 계약은 테마 major 안에서 유지합니다.
- 새 섹션 추가는 minor, 오탈자·스타일 결함 수정은 patch로 분류합니다.
- 기존 class 제거·마크업 필수 변경은 major 또는 명시적인 migration 대상입니다.
- 업데이트 전 `SECTION-LIBRARY.json`의 이전 버전 fixture로 기존 recipe를 다시 렌더링합니다.
- 폐기 예정 섹션은 최소 한 minor 동안 유지하고 대체 섹션·이전 방법을 문서화합니다.
- 구매자의 `custom/` recipe는 자동으로 덮어쓰지 않습니다. CSS·JS와 section 입력 계약의 호환 계층으로 먼저 유지합니다.
- 다른 테마로 옮길 때는 대상 테마 manifest에 같은 섹션 ID와 호환 범위가 있을 때만 지원합니다.

## 13. CS 경계

### 지원하는 것

- 매뉴얼 그대로 복사한 섹션이 지원 G5·테마 버전에서 깨지는 문제
- 제공 효과·반응형·라이트·다크의 재현 가능한 오류
- 섹션 중복 삽입 시 발생하는 ID·slider·observer 충돌
- 문서의 경로·코드·이미지 교체 설명 오류
- 보안·브라우저 호환 결함과 공식 업데이트

### 별도 제작 또는 지원 제외

- 구매자가 구조 class를 삭제·변경한 HTML
- 제공하지 않은 Tailwind utility·외부 slider·스크립트 혼합
- 고객사 고유 레이아웃 제작, 문구 작성, 이미지 편집과 콘텐츠 입력 대행
- 구매자가 예시 밖의 방식으로 section 입력 계약을 변경한 문제
- 지원 목록에 없는 다른 테마로 섹션을 옮긴 결과

문의 접수 시 테마 버전, 섹션 ID, 페이지 URL, 원본 대비 변경 내용이 없으면 재현부터 안내합니다. 매뉴얼로 해결할 사용법 문의와 제품 오류를 분리해 CS 총량을 관리합니다.

## 14. 필수 검증

### 14.1 섹션 단위

- section 입력 fixture → page recipe → 공개 출력 DOM 일치
- route 파일·page ID·catalog·메뉴 링크의 상호 일치
- 페이지 최상단·중간·마지막 배치
- 같은 섹션 2개와 서로 다른 효과 섹션 5개 동시 배치
- 섹션 순서 변경, 배경색 연속, container 중첩
- 320px·390px·768px·1440px와 긴 한국어 제목
- 라이트·다크, 키보드, JS OFF, reduced motion
- 이미지 누락·링크 없음·항목 1개·항목 다수
- 구버전 recipe fixture를 새 CSS·JS와 section runtime으로 렌더링

### 14.2 완성 페이지

- 승인된 전체 페이지 recipe와 실제 배포 HTML/PHP의 일치
- PC·모바일 시각 회귀
- 직접 메뉴 설정에서 `/pages/*.php` route 연결
- header·sub navigation·footer와의 간격
- 로그인·로그아웃에 따른 공통 header 변화
- 핵심 링크와 CTA의 실제 목적지

### 14.3 배포

- 판매 ZIP 새 설치·업데이트·롤백
- CSS에 모든 배포 섹션 스타일 포함
- 필요한 JS module만 번들에 포함
- CDN·source build·저장소 상대경로 없음
- preview·snippet·manual의 섹션 ID와 checksum 일치
- `ASSET-MANIFEST.json`, 라이선스, `THIRD_PARTY_NOTICES.md` 일치

## 15. 구현 순서

1. catalog에서 75개 `/pages/*.php` route와 직접 메뉴 링크를 생성하고 실제 G5에서 확인합니다.
2. `proof-stats-01`, `business-photo-grid-01`, `project-slider-01` 세 종류로 page recipe·section 입력 spike를 합니다.
3. `SECTION-LIBRARY.json` schema와 Tailwind source·배포 누락 gate를 추가합니다.
4. 형님이 추가 시안까지 비교해 승인한 메인 섹션을 첫 테마 내부 섹션 원본으로 정리합니다.
5. 검증을 통과한 섹션으로 각 하위 일반 페이지마다 승인된 레이아웃 5종을 조합합니다.
6. 온라인 매뉴얼과 판매 ZIP의 snippet·preview를 같은 원본에서 생성합니다.
7. 깨끗한 G5에서 복사·수정·업데이트 절차를 문서만 보고 재현합니다.
8. 두 번째 테마에서 같은 동작 계약이 확인된 섹션 runtime만 공통 package로 승격합니다.

첫 구현에서 20개를 한꺼번에 만들지 않습니다. 정적·reveal·slider 세 유형으로 저장 경계와 동작 계약을 먼저 증명한 뒤 같은 규칙으로 늘립니다.

## 16. 완료 기준

다음 조건을 모두 충족해야 섹션 라이브러리를 상품 기능으로 표기합니다.

- 제공한다고 적은 모든 섹션이 실제 판매 ZIP과 온라인 매뉴얼에 존재
- 구매자가 고객 서버에서 build 없이 복사·수정 가능
- `/pages` route와 page recipe 출력에서 구조와 효과 유지
- 동일 섹션 중복 삽입과 서로 다른 페이지 이동 후에도 충돌 없음
- PC·모바일·라이트·다크·JS OFF·reduced motion 증거 확보
- 일반 페이지 recipe와 섹션 원본의 중복 유지보수 없음
- 테마 업데이트에서 이전 recipe fixture 회귀 검사 통과
- 지원 범위·수정 위치·복구 방법이 매뉴얼에 명시
- 설치 테마·섹션 라이브러리·문서의 버전이 일치

## 17. 근거와 후속 결정

- 공식 G5 bootstrap 기준선: `.runtime/gnuboard5/common.php`, `.runtime/gnuboard5/head.php`, `.runtime/gnuboard5/tail.php`
- [Tailwind CSS source detection](https://tailwindcss.com/docs/detecting-classes-in-source-files)
- [Swiper API](https://swiperjs.com/swiper-api)
- [Intersection Observer API](https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API)
- [G5 테마 공통 플랫폼 표준](../standards/G5-THEME-PLATFORM-STANDARD.md)
- [테마 개발 헌법·하네스·공통화 기반 연구](../research/common/THEME-DEVELOPMENT-FOUNDATION-RESEARCH.md)
- [온라인 매뉴얼 운영 표준](../standards/ONLINE-MANUAL-STANDARD.md)

첫 테마 설치 slug는 `jw_business`, 페이지 범위는 75개로 확정했습니다. 남은 항목은 각 페이지를 이루는 섹션 변형의 상세 설계와 실제 route·recipe·메뉴·브라우저 검증입니다. 서로 다른 하위 페이지를 하나씩 제공해 패턴 수를 채우거나 모든 페이지를 같은 형태로 만들지 않습니다. 구현 범위 확정과 실제 테마 디자인 승인을 구분합니다.
