# `jw-editor for G5` 전환 연구 및 공통 플러그인 사양

- 문서 상태: 구현 전 연구·설계 확정안
- 기준일: 2026-09-20
- 원본 조사 대상: `/Users/neojins/Documents/jwsoft-tiptap-editor` commit `98d650d`, 제품 버전 0.2.2
- G5 조사 기준: `.runtime/gnuboard5` 5.6.391
- 구현 여부: 미구현. 이 문서는 G7 저장소나 G5 런타임을 수정하지 않습니다.
- 상품 경계: 테마팩 기본 구성·가격·CS에 포함하지 않는 별도 선택 플러그인

## 1. 결론

`jwsoft-editor`는 새로 다시 만들지 않고, 검증된 Tiptap 편집 코어·정책 SSoT·이미지/동영상 업로드 UX를 가져와 **G5용 독립 플러그인으로 이식**합니다. G7 adapter, Laravel route/model/migration, 권한·저장소 구현은 재사용하지 않고 G5 adapter로 교체합니다.

이 연구서는 향후 독립 플러그인 개발 기준입니다. 첫 테마팩을 출시하기 위해 구현해야 하는 공통 기능으로 취급하지 않습니다. 별도 상품명·가격·지원 기간·설치 문서·문의 분류가 준비되기 전에는 테마 ZIP에 동봉하지 않습니다.

핵심 결정은 다음과 같습니다.

1. 테마에 에디터를 복사하지 않습니다. `jw-editor for G5`라는 공통 플러그인 ZIP으로 별도 버전과 업데이트를 가집니다.
2. G5 코어를 수정하지 않습니다. 공식 editor adapter, `extend/`, plugin-owned endpoint와 plugin-owned DB table만 사용합니다.
3. 기존 G7 제품의 엄격한 class-token 정책을 그대로 바꾸지 않습니다. G5 포트에 별도 `safe-inline` 정책 profile을 만들고, 안전한 서식용 inline style을 서버에서 허용 목록으로 정제합니다.
4. `style` 속성을 무조건 통과시키지 않습니다. DOMPurify 공식 threat model도 자신이 CSS sanitizer가 아니라고 밝히므로, 서버 CSS sanitizer가 최종 승인해야 합니다.
5. G5 기본 번들에는 현재 CKEditor가 없습니다. G5 5.6.391에는 SmartEditor2와 Cheditor5가 있습니다. CKEditor 4의 EOL 위험은 다른 설치에서의 교체 근거일 뿐 G5 기본 상태 설명으로 사용하지 않습니다.
6. 업로더는 기존 `jw-editor`의 진행률·재시도·queue·MP4 청크 재개 코드를 먼저 이식합니다. Uppy를 동시에 도입해 같은 상태 기계를 두 개 만들지 않습니다.
7. 이미지 편집은 기존 Filerobot 기반 모듈을 선택 기능으로 유지하고 최초 사용 때만 lazy load합니다. 기본 편집기는 이 모듈이 없어도 동작해야 합니다.

## 2. 조사로 확인한 사실

### 2.1 G5 편집기 계약

G5 5.6.391은 설정의 `cf_editor` 값으로 `plugin/editor/<id>/editor.lib.php`를 고릅니다. adapter는 다음 세 함수를 제공합니다.

```php
editor_html($id, $content, $is_dhtml_editor = true)
get_editor_js($id, $is_dhtml_editor = true)
chk_editor_js($id, $is_dhtml_editor = true)
```

현재 `.runtime/gnuboard5/plugin/editor/`에는 다음 두 편집기만 있습니다.

- `smarteditor2`
- `cheditor5`

SmartEditor2 adapter는 jQuery와 `document.write()`를 사용합니다. upstream 최신 release 2.10.0은 2019-08-10 공개됐고 2.9.2에는 Stored XSS 대응 기록이 있습니다. 이 사실은 “현재 확인된 CVE가 반드시 남아 있다”는 뜻이 아니라, 신규 유료 플러그인의 장기 유지 기준으로 보기 어려운 레거시 유지 상태라는 뜻입니다.

### 2.2 CKEditor에 대한 정확한 판단

- CKEditor 4 무료판은 2023-06-30 EOL이며 마지막 무료 4.22.1에는 알려진 보안 문제가 있다고 제작사가 명시합니다.
- CKEditor 4 LTS는 상업 계약 제품입니다.
- CKEditor 5는 현재 유지 중인 별도 제품입니다. 2026년 48.5.1도 style 처리와 General HTML Support 조건에서 XSS 문제를 수정했습니다.
- CKEditor 제작사도 frontend editor filter를 완전한 XSS 방어로 보지 않고 backend sanitization을 권고합니다.

따라서 “CKEditor라는 이름 전체가 보안상 사용할 수 없다”고 말하면 부정확합니다. 이 제품에서 Tiptap을 선택하는 이유는 기존 JW SOFT 구현 자산, G5/G7 공통 사용자 경험, 업로드·정책 통제, 라이선스와 유지보수 독립성입니다.

### 2.3 기존 `jw-editor`에서 재사용 가능한 것

현재 소스로 확인한 재사용 자산은 다음과 같습니다.

- Tiptap 3.31.3 / ProseMirror 편집 구조
- `policy/editor-policy.json`에서 TS·PHP·CSS·검사를 생성하는 정책 SSoT
- 붙여넣기 정제와 기존 HTML 손실 사전 경고
- 이미지 선택·드래그 앤 드롭·붙여넣기 업로드
- 업로드 진행률·취소·실패 재시도·queue
- 이미지 정렬·크기·대체 텍스트·캡션
- Filerobot 이미지 편집의 지연 로드와 편집본 새 파일 저장
- MP4 청크 업로드·재개·SHA-256·진행률
- URL 정책, 링크 카드, 미디어/SNS module registry
- 기능 OFF 상태에서도 기존 canonical node를 읽는 parser
- DOMPurify 출력 방어와 정책 회귀 fixture

### 2.4 그대로 가져오면 안 되는 것

- G7 namespace와 plugin lifecycle
- Laravel route, middleware, FormRequest, service container
- G7 model과 migration
- G7 storage contract와 authorization contract
- G7의 11개 저장 route 목록
- G7 설정 UI와 API 경로
- PHP 8.2 기준 Symfony sanitizer 구성
- 임의 inline style을 전부 거부하는 G7 정책 profile

포트는 소스 복사 작업이 아니라 **편집 코어 재사용 + host adapter 재작성**입니다.

## 3. 제품과 디렉터리 경계

배포 ZIP은 다음 G5 표준 위치만 사용합니다.

```text
plugin/editor/jwsoft_editor/
├── editor.lib.php              # G5의 세 함수 adapter
├── dist/                       # 빌드된 JS/CSS, 고객 빌드 불필요
└── assets/

plugin/jwsoft-editor/
├── bootstrap.php
├── api/                        # 업로드·정제·asset API
├── src/                        # G5 service, policy, storage, auth
├── admin/                      # 플러그인 설정·asset 관리
├── config/
├── policy/
└── vendor-prefixed/            # 충돌 방지 prefix가 적용된 PHP 의존성

extend/jwsoft_editor.extend.php # G5 요청 초기화와 저장 전 sanitizer 연결
data/jwsoft-editor/             # 업로드·임시 파일·cache, 웹 실행 금지
```

구현을 시작할 경우 테마 저장소 안의 workspace가 아니라 별도 `jwsoft-editor-g5` 저장소에서 관리하고, 릴리스 단계에서 위 설치 구조로 조립합니다. editor ID는 G5 폴더 규칙에 맞춰 `jwsoft_editor`, 제품 표시는 `jw-editor`를 사용합니다.

G7 원본 저장소를 G5 조건에 맞게 직접 뒤틀지 않습니다. 포트 시작 시 사용한 G7 commit과 재사용 파일 목록을 provenance 문서에 고정하고 별도 저장소에서 adapter와 policy profile을 분기합니다. 새 저장소의 package manager는 Bun과 단일 `bun.lock`을 사용합니다.

### 3.1 테마와의 관계

- 테마는 에디터 설치를 필수로 요구하지 않습니다.
- 테마 package에는 에디터 소스 복사본을 넣지 않습니다.
- 테마는 본문 출력 CSS와 canonical HTML contract만 호환합니다.
- 에디터가 없거나 꺼져도 G5 textarea 또는 선택한 기존 editor가 동작합니다.
- 에디터 설정·업로드·보안 문의는 테마 CS와 분리합니다.

## 4. G5 host adapter 설계

### 4.1 화면 adapter

`editor.lib.php`는 G5가 기대하는 textarea를 유지하고 그 위에 Tiptap UI를 연결합니다.

- 원본 textarea가 제출 정본입니다.
- Tiptap 변경 시 canonical 후보 HTML을 textarea에 동기화합니다.
- `get_editor_js()`는 submit 직전에 동기화와 빈 본문 검사를 수행합니다.
- `chk_editor_js()`는 한국어 안내와 focus 복귀를 제공합니다.
- 여러 editor field가 한 페이지에 있어도 한 번만 runtime을 로드합니다.
- JS 초기화 실패 시 textarea를 숨기지 않습니다.
- form name, field ID, maxlength, G5 token과 기존 submit handler를 변경하지 않습니다.

### 4.2 모바일 조건

G5 5.6.391의 `G5_IS_MOBILE_DHTML_USE` 기본값은 `false`입니다. 따라서 다음을 구분합니다.

- 반응형 PC 테마로 동작하는 화면: 동일 adapter 사용
- G5 별도 mobile 경로: 사이트 운영자가 `G5_IS_MOBILE_DHTML_USE`를 켠 환경에서만 rich editor 사용
- 값이 false이면 textarea fallback 유지

플러그인이 코어 `config.php`를 자동 수정하지 않습니다. 모바일 editor 활성화 절차와 위험을 설치 문서에서 안내합니다.

### 4.3 저장 전 서버 정제

G5의 `extend/` 파일은 `common.php` 초기화 끝에 로드되고 각 update script가 POST field를 지역 변수로 읽기 전 실행됩니다. 이 지점을 저장 전 방어 경계로 사용합니다.

`jwsoft_editor.extend.php`는 다음 조건을 모두 만족할 때만 동작합니다.

1. POST 요청
2. `cf_editor` 또는 게시판 editor가 `jwsoft_editor`
3. request script가 surface registry의 정확한 경로와 일치
4. field가 registry에 등록됨
5. 문자열 크기 상한과 UTF-8 검사를 통과

정제된 canonical HTML로 `$_POST[field]`를 교체한 뒤 G5 update script가 기존 token·권한·SQL 절차를 수행하게 합니다. 업로드나 DB 변경은 이 preprocessor에서 하지 않습니다.

### 4.4 surface registry

현재 G5 소스에서 `editor_html()` 사용을 확인한 1차 범위입니다.

| 영역 | form/update | 확인된 editor field |
| --- | --- | --- |
| 게시판 | `bbs/write.php` → `bbs/write_update.php` | `wr_content` |
| 1:1 문의 | `bbs/qawrite.php` → `bbs/qawrite_update.php` | `qa_content` |
| 내용 관리 | `adm/contentform.php` → `adm/contentformupdate.php` | `co_content`, `co_mobile_content` |
| FAQ | `adm/faqform.php` → `adm/faqformupdate.php` | `fa_subject`, `fa_content` |
| 팝업 | `adm/newwinform.php` → `adm/newwinformupdate.php` | `nw_content` |
| 메일 | `adm/mail_form.php` → `adm/mail_update.php` | `ma_content` |
| 상품 | `adm/shop_admin/itemform.php` → `itemformupdate.php` | `it_explan`, `it_mobile_explan`, head/tail HTML 4종 |
| 쇼핑몰 설정 | `adm/shop_admin/configform.php` → `configformupdate.php` | 배송·교환·비회원 개인정보 field 3종 |
| 이벤트 | `adm/shop_admin/itemeventform.php` → `itemeventformupdate.php` | `ev_head_html`, `ev_tail_html` |
| 분류 | `adm/shop_admin/categoryform.php` → `categoryformupdate.php` | PC/mobile head/tail HTML 4종 |
| 상품 문의 | `shop/itemqaform.php` → update script | `iq_question` |
| 상품 후기 | `shop/itemuseform.php` → update script | `is_content` |

이 표는 form field 확인 결과입니다. update script의 실제 저장 변수·권한·길이 제한·hook 시점을 모두 추적한 뒤에만 해당 surface를 “지원”으로 엽니다. 미검증 surface는 editor adapter를 표시하지 않습니다.

## 5. canonical HTML과 보안 경계

### 5.1 방어 계층

1. Tiptap schema: 편집 가능한 구조 제한
2. paste importer: Word/기존 HTML의 불필요한 markup 제거와 손실 안내
3. G5 pre-save sanitizer: 유일한 저장 승인 경계
4. canonical serializer: 같은 의미를 같은 HTML로 정규화
5. DOMPurify: editor preview와 공개 renderer의 방어심층
6. G5 `html_purifier()`: 사이트 출력 정책과 최종 호환 검사

클라이언트가 보낸 “이미 정제됨” 표식은 보안 근거로 사용하지 않습니다. 관리자 입력, 기존 DB HTML, 직접 POST도 신뢰하지 않습니다.

### 5.2 서버 sanitizer 선택

G5 5.6.391은 HTMLPurifier 4.15.0을 포함하지만 upstream 최신은 4.19.1이며 PHP 8.5 호환 개선을 포함합니다. 공통 플러그인은 다음 방식으로 독립성을 확보합니다.

- `ezyang/htmlpurifier` 4.19.1 exact pin
- build 단계에서 `humbug/php-scoper` 0.18.19로 `JwsoftEditorG5Vendor` prefix 적용
- Composer와 scoper는 개발 도구이며 고객 서버에는 완성 vendor만 제공
- G5의 전역 `HTMLPurifier_*` class와 이름 충돌 금지
- LGPL-2.1 원문·저작권·변경 고지 포함
- `CSS.Trusted=false`, `CSS.AllowTricky=false`, `CSS.AllowImportant=false`
- `HTML.Allowed`, `CSS.AllowedProperties`, `CSS.AllowedFonts`를 정책 생성물로 고정

prefix build가 안정적으로 재현되지 않으면 출시를 막고, G5 내장 4.15에 조용히 fallback하지 않습니다.

DOMPurify 3.4.15는 브라우저 방어심층으로 사용합니다. 공식 threat model상 DOMPurify는 CSS sanitizer가 아니며 `style`과 `<style>`을 기본 허용할 수 있으므로 명시적 config와 CSS hook을 사용합니다. 서버 결과가 항상 정본입니다.

## 6. inline style 정책

### 6.1 결정

G5 포트에서는 G7 원본의 “임의 inline style 전부 제거”를 그대로 적용하지 않습니다. Tiptap의 공식 `TextStyleKit`이 color, background color, font family, font size, line height를 inline style로 출력하므로, **서식에 필요한 style 속성은 보존**합니다.

그렇다고 `style="..."` 전체를 통과시키지는 않습니다. CSS는 외부 요청, 화면 가리기, 클릭 방해, 정보 노출을 만들 수 있고 DOMPurify도 이를 방어 범위로 보지 않습니다.

### 6.2 기본 `safe-inline` 허용 목록

| 목적 | 속성 | 값 제한 |
| --- | --- | --- |
| 글자색 | `color` | sanitizer가 인정한 color, editor UI는 승인 palette |
| 강조색 | `background-color` | sanitizer가 인정한 color, 투명/승인 palette |
| 글꼴 | `font-family` | Pretendard, Noto Sans KR, Arial, serif, sans-serif, monospace allowlist |
| 크기 | `font-size` | 10~48px의 승인 단계 |
| 굵기 | `font-weight` | normal, bold, 400, 500, 600, 700 |
| 기울임 | `font-style` | normal, italic |
| 밑줄/취소선 | `text-decoration` | none, underline, line-through 및 안전 조합 |
| 정렬 | `text-align` | left, center, right, justify |
| 행간 | `line-height` | 1.2~2.2 승인 단계 |
| 자간 | `letter-spacing` | -0.05em~0.2em 승인 단계 |
| 들여쓰기 | `margin-left` | 0~4rem 승인 단계, paragraph/list에 한정 |
| 이미지·표 폭 | `width`, `max-width` | 10~100% 또는 1~1600px, 대상 element 한정 |
| 높이 | `height` | media에서는 `auto`, table cell은 미지원 |
| 셀 정렬 | `vertical-align` | top, middle, bottom |
| 표/셀 | `border`, `border-width`, `border-style`, `border-color`, `border-collapse` | 0~4px, solid/dashed/dotted, 안전 색, table 계열에 한정 |
| 표/셀 여백 | `padding` | 0~32px, table cell에 한정 |
| 이미지 배치 | `float`, `margin` | image/figure의 승인 preset만 변환 |

허용 목록에 있어도 element별 규칙에 맞지 않으면 제거합니다. 예를 들어 `width`는 임의 span에 허용하지 않습니다.

### 6.3 항상 금지

- `<style>`, `<link>`, `@import`, `@font-face`, CSS custom property
- `url()`, 외부 자원 참조, `expression()`
- `position`, inset 계열, `z-index`
- `display`, `visibility`, `opacity`
- `overflow`, `clip`, `mask`
- `transform`, `filter`, `animation`, `transition`
- `content`, `cursor`, `pointer-events`, `user-select`
- `!important`, vendor-prefixed property
- `on*` 이벤트 속성, `srcdoc`, 임의 iframe/script/object/embed

### 6.4 기존 콘텐츠 전환

- 설치·활성화·조회만으로 기존 저장 HTML을 바꾸지 않습니다.
- 기존 글을 열 때 server dry-run으로 원본과 canonical 후보를 비교합니다.
- 손실이 있으면 읽기 전용 preview와 제거 항목을 보여 주고 사용자가 확인해야 편집합니다.
- 저장하지 않고 닫으면 원본은 그대로입니다.
- 안전한 inline style은 보존하고 구식 `font`, `align`, `bgcolor` 속성은 canonical style로 변환합니다.
- 금지 CSS나 실행 HTML은 보존을 약속하지 않습니다.
- 일괄 자동 마이그레이션은 v1 범위에서 제외합니다.

## 7. 업로더 공통 사양

### 7.1 이미지 입력

- 파일 선택, 다중 선택, drag and drop, clipboard paste
- JPEG, PNG, GIF, WebP, AVIF
- SVG 기본 금지
- 업로드별 진행률, 취소, 실패 재시도
- queue 동시 처리 3개 기본
- 업로드 중 form 제출 차단과 명확한 상태 안내
- 모바일 touch와 카메라/앨범 선택

### 7.2 서버 검증

- 브라우저 MIME와 확장자는 참고만 사용
- `finfo`, 이미지 decode, `getimagesize`로 실제 형식 검사
- 파일 byte, width, height, 총 pixel 상한
- 무작위 public ID 또는 content hash 파일명
- 실행 가능한 확장자와 이중 확장자 거부
- 업로드 디렉터리에서 PHP 실행 금지
- EXIF 위치정보 제거 정책과 방향 정규화
- DB 기록 실패 시 물리 파일 회수
- 임시·중단 파일 만료 정리
- quota, 권한, 저장소 실패는 fail closed

### 7.3 원본과 파생본

- 원본은 수정하지 않고 보존합니다.
- 표시용 WebP/AVIF/JPEG 파생본을 별도 생성합니다.
- 이미지 편집 결과는 새 asset으로 저장하고 원본 asset 관계를 기록합니다.
- 취소·실패 시 현재 본문과 원본을 바꾸지 않습니다.
- GIF animation과 AVIF는 v1 이미지 편집 대상에서 제외하되 업로드·표시는 지원합니다.

### 7.4 이미지 편집

기존 Filerobot image editor integration을 재사용합니다.

- feature registry 기본 OFF
- 켰을 때 최초 사용 시 JS/CSS lazy load
- crop, rotate, resize, correction, filter
- 한국어 UI, 모바일 gesture, 큰 이미지 memory 검사
- 저장 전 실제 출력 MIME와 확장자 재검사
- 편집 모듈이 없거나 실패해도 업로드·대체 텍스트·정렬 기능 유지

### 7.5 MP4

기존 구현의 청크·재시도·재개 설계를 가져옵니다.

- 기능 기본 OFF
- MP4만 지원하고 실제 MIME과 `ftyp` 확인
- 세션당 128-bit 이상 임의 token과 로그인 소유권 확인
- 청크 hash와 전체 byte 수 확인
- 완료 전 공개 URL 발급 금지
- 중단 session 만료 정리
- 서버가 전체 파일을 PHP 문자열 하나로 읽지 않음
- autoplay 기본 OFF, playsinline, caption 확장 지점 확보

### 7.6 Uppy 평가

Uppy는 modular upload, XHR, retry, Tus/cloud source를 제공하는 적합한 후보입니다. 그러나 현재 `jw-editor`가 이미 image queue·progress·retry와 MP4 chunk resume를 구현하고 있어 v1에 Uppy를 추가하면 다음이 중복됩니다.

- file state와 progress state
- retry/cancel lifecycle
- error message와 form submit guard
- chunk session protocol
- 번들·업데이트·테스트 범위

따라서 v1은 기존 코드를 이식합니다. 직접 S3/R2 multipart, Tus, Google Drive/Dropbox source가 실제 요구가 되면 기존 uploader를 폐기하거나 adapter로 감싸는 조건으로 다시 평가합니다.

## 8. asset 저장 구조

테마가 아니라 플러그인이 자체 table을 가질 수 있습니다. G5 코어 table은 변경하지 않습니다.

초기 table 후보는 다음과 같습니다.

- `<prefix>jw_editor_assets`: public ID, owner, MIME, byte, width/height, storage key, original relation, 상태
- `<prefix>jw_editor_upload_sessions`: media chunk session, owner, size, part, hash, expiry
- `<prefix>jw_editor_asset_refs`: G5 surface와 content record의 asset 참조

최종 schema는 G5 삭제·수정 lifecycle을 조사한 뒤 확정합니다. 본문 HTML의 URL만 검색해 즉시 파일을 지우지 않습니다. reference가 불확실하면 asset을 보존하고 관리자 cleanup 후보로 표시합니다.

local storage 기본 위치는 `data/jwsoft-editor/YYYY/MM`이며 storage adapter가 URL과 key를 분리합니다. S3/R2는 v1 이후 선택 adapter입니다.

## 9. 기능 module 기준

| module | 기본값 | 비활성 시 |
| --- | --- | --- |
| basic text | ON | textarea fallback |
| table | ON | 기존 table render 유지 |
| image upload | ON | 기존 image render 유지, 새 업로드 UI 숨김 |
| image tools | OFF | 기본 image upload/edit metadata 유지 |
| MP4 upload | OFF | 기존 canonical video link render 유지 |
| YouTube/Vimeo | OFF | 안전한 원문 링크 유지 |
| SNS official embed | OFF | 안전한 원문 링크 유지 |
| smart card | OFF | 일반 HTTPS link 유지 |
| AI writing | 제외 | base editor 영향 없음 |

이미지 편집과 향후 AI writing은 독립 제품이 아니라 `jw-editor` 내부 선택 module입니다. upload, permission, sanitizer, feature registry를 공유하고 base editor가 module 부재로 깨지지 않아야 합니다.

## 10. 라이브러리와 버전 기준

| 항목 | 초기 기준 | license | 용도 |
| --- | --- | --- | --- |
| Tiptap | 3.31.3 | MIT | 편집 엔진 |
| ProseMirror | Tiptap lock이 정한 버전 | MIT | document model |
| DOMPurify | 3.4.15 | Apache-2.0 또는 MPL-2.0, 배포 고지에서 Apache-2.0 선택 | 브라우저 출력 방어심층 |
| HTMLPurifier | 4.19.1 prefixed | LGPL-2.1 | 서버 HTML/CSS 정제 |
| PHP-Scoper | 0.18.19, build only | MIT | G5 내장 PHP library와 namespace/class 충돌 방지 |
| Lucide | 공통 catalog 1.47.0 목표 | ISC | toolbar SVG |
| Filerobot | 5.0.0 기존 pin, 별도 upgrade 평가 | MIT | 선택 이미지 편집 |
| React/ReactDOM | 18.3.1 기존 pin | MIT | 이미지 편집 chunk 내부에만 격리 |

G5 포트 첫 단계에서 기존 G7 제품의 모든 package를 최신으로 한꺼번에 올리지 않습니다. adapter 전환과 dependency major upgrade를 한 diff에 섞으면 회귀 원인을 구분하기 어렵습니다. 단, 알려진 sanitizer 보안 패치는 포트 시작 전에 반영합니다.

## 11. 설정과 권한

### 11.1 설정

- master enable
- editor 높이와 toolbar profile
- image upload, image tools, MP4, external media, smart card 개별 toggle
- 파일·픽셀·사용자 quota
- 허용 font와 color palette
- inline style policy version
- 외부 콘텐츠 click-to-load
- asset retention과 cleanup 기간

설정값은 PHP config 파일이나 plugin table에 저장하고 frontend가 임의로 바꿀 수 없습니다.

### 11.2 권한

- G5 core가 판단한 글쓰기·수정 권한을 대체하지 않습니다.
- 업로드 API는 로그인, board/surface, write/update context, CSRF token을 다시 확인합니다.
- 관리자 endpoint는 `is_admin` 등급과 별도 request token을 확인합니다.
- asset public ID를 알아도 삭제·교체 권한이 생기지 않습니다.
- 비회원 게시판 업로드는 v1에서 기본 OFF로 두고 별도 abuse/quota 설계 후 엽니다.

## 12. 테스트와 출시 게이트

### 12.1 자동 검사

- policy schema → TS/PHP/CSS 생성물 checksum
- HTML security corpus: load, paste, direct POST, save, render
- CSS corpus: safe property 보존, forbidden property/value 제거
- URL scheme, data URI, malformed HTML, mixed-case event attribute
- image MIME/extension mismatch, oversized pixel, truncated file
- upload cancel/retry/rollback/orphan cleanup
- MP4 interrupted resume, wrong chunk hash, foreign owner token
- 모든 surface registry field의 direct POST
- Bun audit, Composer audit, NOTICE/license 생성 검사

### 12.2 실제 G5 검사

- PHP 8.3/8.4/8.5
- MariaDB 10.11, MySQL 8.4
- PC/mobile, 반응형/별도 mobile
- 비회원/회원/관리자
- 게시판 새 글 → 저장 → 보기 → 수정 → 재저장
- 내용/FAQ/팝업/메일/영카트 각 지원 surface
- SmartEditor2 → jw-editor 전환, 저장하지 않고 복귀, 손실 확인 후 저장
- Korean IME, 모바일 키보드, 표와 긴 문서
- 20MB 이상 큰 이미지의 진행률·취소·memory
- plugin OFF/제거 후 기존 글 출력

### 12.3 완료 정의

다음이 모두 있어야 G5 포트 완료입니다.

1. 지원 surface 전수 registry와 pre-save sanitizer 증거
2. 실제 G5의 저장→조회→수정 lifecycle 통과
3. safe inline style 보존과 위험 CSS 제거 browser 증거
4. 이미지 원본 보존, 편집본 새 저장, 취소 no-op 증거
5. 모바일 Korean IME와 large-image 검사
6. plugin OFF 상태 fallback
7. 설치·업데이트·롤백 ZIP과 checksum
8. THIRD_PARTY_NOTICES와 라이선스 원문

## 13. 구현 순서

### 1단계: 포트 가능성 spike

- G5 adapter 3함수
- board `wr_content` 한 surface
- prefixed HTMLPurifier 4.19.1 build
- TextStyleKit safe-inline round trip
- direct POST sanitizer
- Bun 기반 build

통과 조건은 글 작성·조회·수정에서 허용 style이 유지되고 위험 CSS가 저장되지 않는 것입니다.

### 2단계: 기본 편집과 이미지

- toolbar, paste, legacy warning
- image upload queue/progress/retry/cancel
- asset table/install migration
- board permission과 cleanup

### 3단계: 전체 G5 surface

- 내용·FAQ·팝업·메일·Q&A
- 영카트 상품·설정·분류·이벤트·후기·문의
- surface별 권한·길이·삭제 lifecycle

### 4단계: 선택 module

- image tools
- MP4
- external media와 smart card

### 5단계: 릴리스

- PHP/DB/browser matrix
- 기존 콘텐츠 migration UX
- package install/update/rollback
- 보안·라이선스·checksum

## 14. 주요 위험과 대응

| 위험 | 대응 |
| --- | --- |
| G5 내장 HTMLPurifier 4.15 class 충돌 | prefixed 4.19.1 vendor, 재현 실패 시 출시 차단 |
| inline CSS를 통한 정보 노출·화면 가리기 | property/value/element 3중 allowlist, style tag와 URL 금지 |
| update surface 누락 | form과 update script를 쌍으로 registry화하고 direct POST 회귀 |
| 기존 HTML 손실 | 조회만으로 변경 금지, dry-run diff와 명시적 확인 |
| 테마마다 editor 복사본 발생 | 독립 plugin 한 개, 테마는 contract만 소비 |
| 업로드 고아 파일 | session/asset 상태, DB 실패 rollback, 만료 cleanup |
| 큰 optional bundle | feature OFF, lazy load, base editor와 분리 |
| G7와 G5 정책 drift | 공통 schema의 host profile, 생성물 checksum과 fixture 공유 |

## 15. 연구 근거

### 외부 공식 자료

- [CKEditor 4 EOL과 무료판 보안 상태](https://ckeditor.com/blog/ckeditor-4-end-of-life/)
- [CKEditor 5 48.5.1 보안 수정](https://ckeditor.com/docs/ckeditor5/latest/updating/guides/changelog.html)
- [CKEditor 5도 backend sanitization이 필요하다는 안내](https://ckeditor.com/docs/ckeditor5/latest/features/html/general-html-support.html#security)
- [SmartEditor2 release 기록](https://github.com/naver/smarteditor2/releases)
- [Tiptap TextStyleKit](https://tiptap.dev/docs/editor/extensions/functionality/text-style-kit)
- [Tiptap Color의 inline style 출력](https://tiptap.dev/docs/editor/extensions/functionality/color)
- [DOMPurify CSS 비보장 threat model](https://github.com/cure53/DOMPurify/wiki/Security-Goals-%26-Threat-Model)
- [HTMLPurifier CSS allowlist 설정](https://htmlpurifier.org/live/configdoc/plain.html#CSS.AllowedProperties)
- [HTMLPurifier 최신 release](https://github.com/ezyang/htmlpurifier/releases)
- [PHP-Scoper 0.18.19과 namespace 격리 목적](https://packagist.org/packages/humbug/php-scoper)

### 로컬 소스 근거

- `.runtime/gnuboard5/common.php`: `G5_EDITOR_LIB` 선택과 `extend/` 로드
- `.runtime/gnuboard5/plugin/editor/*/editor.lib.php`: G5 adapter 함수
- `.runtime/gnuboard5/config.php`: mobile DHTML 기본값
- `.runtime/gnuboard5/lib/common.lib.php`: `html_purifier_config`와 `html_purifier_result` hook
- `.runtime/gnuboard5/plugin/htmlpurifier/HTMLPurifier.standalone.php`: bundled 4.15.0
- `/Users/neojins/Documents/jwsoft-tiptap-editor/package.json`: 현재 Tiptap·DOMPurify·Filerobot 구성
- `/Users/neojins/Documents/jwsoft-tiptap-editor/resources/js/editor/`: upload·queue·media·module 구현
- `/Users/neojins/Documents/jwsoft-tiptap-editor/docs/04-security.md`: 기존 server canonical policy
