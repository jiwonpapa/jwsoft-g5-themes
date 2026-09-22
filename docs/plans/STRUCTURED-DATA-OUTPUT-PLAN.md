# 테마 메타·구조화 데이터 출력 및 설정 계획

- 상태: 구현 전 기준안
- 기준일: 2026-09-21
- 적용 범위: JW SOFT G5 테마의 공개 화면
- 구현 상태: 미착수

JW-Business 1.0의 적용 범위는 [출시 구현 범위](JW-BUSINESS-1.0-IMPLEMENTATION-SCOPE.md)를 따른다. 일반 페이지 입력 대상에 제공 PHP 페이지를 포함하며, 장터 데이터가 없는 이번 상품은 `market` profile을 활성화하지 않는다.

## 1. 결정

테마는 다음 세 기능만 제공합니다.

1. G5 게시판의 **목록·본문·댓글**과 실제 이미지·영상·장터 데이터를 Schema.org 구조로 출력
2. 게시판 목록과 각 게시글의 실제 데이터로 서로 다른 title·description·Open Graph 출력
3. G5 `내용관리`로 만든 일반 페이지의 제한된 메타정보 입력·출력

SEO 점수, 키워드 추천, AI 문구, sitemap·robots·IndexNow, Search Console 연동과 순위 관리는 만들지 않습니다. 설정 화면도 SEO 관리자처럼 확장하지 않고 구조화 데이터와 일반 페이지 메타 출력에 필요한 값만 받습니다.

월척에서 JSON-LD만 사용했을 때보다 실제 콘텐츠 DOM의 Microdata를 함께 사용했을 때 Search Console이 이미지·미디어·장터·포럼 구조를 더 구체적으로 인식한 운영 결과를 기준에 반영합니다. Google도 포럼 게시물의 긴 본문과 댓글을 중복하지 않도록 `DiscussionForumPosting`에는 가능하면 Microdata를 쓰도록 안내합니다.

## 2. G5 현행 구조 조사

현재 로컬 기준은 G5 5.6.391입니다.

### 확인된 제약

- `g5_content`에는 제목·본문·스킨·URL용 `co_seo_title`은 있지만 페이지별 meta description이나 대표 이미지 URL 전용 필드가 없습니다.
- `co_seo_title`은 예쁜 URL slug를 위한 값이므로 브라우저 제목이나 meta title 저장소로 재사용하면 안 됩니다.
- 기본환경설정의 `cf_add_meta`는 모든 공개 화면에 원문 HTML을 출력하므로 페이지별 입력에 부적합합니다.
- `cf_1~10`, `bo_1~10`, `wr_1~10`은 다른 스킨·플러그인이 쓸 수 있는 여분 필드입니다. 테마가 고정 점유하면 충돌과 이전 CS가 생깁니다.
- 내용관리 폼에는 필드를 안정적으로 삽입하는 전용 출력 hook이 없고, 생성·수정·삭제 뒤 event만 있습니다. 코어 파일 수정이나 관리자 DOM 문자열 치환은 업데이트에 취약합니다.
- 활성 테마의 `theme.config.php`는 관리자 요청에서도 로드됩니다. 여기서 `admin_menu` filter와 `/adm/view.php?call=...` event route를 등록하면 G5 코어 파일을 추가·수정하지 않고 전용 관리자 화면을 만들 수 있습니다.
- 게시판 상세의 `$write`는 공통 초기화에서 읽히지만 목록의 `$list`는 head 출력 뒤 `list.php`에서 완성됩니다. 목록 항목 구조는 head의 JSON-LD로 다시 조회하지 않고 `list.skin.php`의 실제 DOM에서 출력하는 편이 정확합니다.
- G5 기본 글 수정은 `wr_datetime`을 유지하고 별도 수정시각을 저장하지 않습니다. `wr_last`는 최근 댓글 활동에도 바뀌므로 `dateModified`로 사용할 수 없습니다.

### 결론

설정값은 G5 코어 테이블이나 여분 필드에 넣지 않습니다. **활성 테마가 등록하는 관리자 한 화면**에서 편집하고, **G5 data 경로의 JW SOFT 전용 설정 파일**에 저장합니다.

## 3. 출력 책임

### 3.1 게시판 목록

게시판 목록은 화면에 실제 출력된 행만 다음 구조로 표시합니다.

- 목록 전체: `CollectionPage`와 `ItemList`
- 각 게시물: `ListItem`
- 각 항목 필수값: 현재 페이지 안의 `position`, 게시물 절대 URL, 화면에 보이는 제목
- 갤러리형 항목: 화면에 실제 보이는 대표 이미지에 `ImageObject` 연결

목록 페이지의 메타값도 해당 게시판과 현재 목록 상태에서 만듭니다.

| 출력 | 기본 데이터 |
| --- | --- |
| `<title>`·`og:title` | `bo_subject` + 현재 분류 + 페이지 번호 + `cf_title` |
| meta·OG description | 게시판별 입력 설명, 없으면 공개된 게시판 상단 설명을 정제해 사용, 둘 다 없으면 생략 |
| `og:image` | 게시판별 대표 이미지, 없으면 현재 목록의 첫 공개 대표 이미지, 없으면 생략 |
| `og:url` | 검색·분류·페이지를 반영한 현재 절대 URL |
| `ItemList.name` | 현재 화면에 표시된 게시판명과 분류명 |

모바일에서도 같은 URL의 메타값이 달라지지 않도록 `bo_mobile_subject`가 아니라 기준 게시판명인 `bo_subject`를 사용합니다.

검색·분류·페이지 이동 결과도 현재 DOM에 표시된 항목만 사용합니다. 비밀글 내용, 권한이 없는 제목, 삭제 데이터와 다음 페이지 항목을 미리 넣지 않습니다.

Google의 summary page 예시처럼 목록 항목에는 상세 페이지 URL과 순서만 우선 제공하고, 게시글 본문 전체를 목록에 중복하지 않습니다.

`bo_use_list_view`로 상세 하단에 목록이 함께 보일 때는 게시글을 페이지의 주 엔터티로 유지하고 목록은 별도 `hasPart` 성격의 보조 목록으로 출력합니다.

### 3.2 게시판 본문

게시판 스킨별 profile이 본문 타입을 결정합니다.

| profile | 본문 타입 | 적용 조건 |
| --- | --- | --- |
| `article` | `Article` | 공지·뉴스·자료처럼 운영자가 발행한 글 |
| `forum` | `DiscussionForumPosting` | 회원 의견·경험·토론 중심 게시판 |
| `gallery` | `Article` + `ImageObject` | 대표 이미지와 본문이 함께 있는 갤러리 글 |
| `video` | `VideoObject` 또는 `Article` + `VideoObject` | 재생 가능한 영상과 썸네일·업로드일이 실제로 있음 |
| `market` | `Product` + `Offer` | 가격·통화·판매 상태·상품 상태를 전용 스킨이 실제로 확보함 |
| `none` | 출력 안 함 | 구조를 확정할 수 없는 특수 게시판 |

본문에서 사용하는 기본 속성은 제목, 작성자, 작성일, 본문, 절대 URL과 화면에 표시되는 미디어입니다. 평점·가격·판매 상태·의료기관 정보처럼 없는 값을 추정하지 않습니다.

각 게시글의 메타값은 사이트 공통 문구가 아니라 해당 글에서 자동 생성합니다.

| 출력 | 기본 데이터 |
| --- | --- |
| `<title>`·`og:title` | `wr_subject` + `bo_subject` + `cf_title` |
| meta·OG description | 공개된 `wr_content`를 HTML 제거·공백 정규화한 요약 |
| `og:image` | 첫 공개 이미지 첨부 → 본문 첫 이미지 → 게시판 대표 이미지 순서 |
| `og:url` | 해당 게시글의 절대 URL |
| `headline`·`name` | `wr_subject` |
| `author` | 화면에 공개된 실제 작성자 |
| `datePublished` | `wr_datetime`을 ISO 8601로 변환 |
| `articleBody`·`text` | 권한 확인 뒤 화면에 출력한 실제 본문 |

게시글마다 제목·본문·작성자·날짜·URL·대표 이미지가 달라지므로 구조화 데이터와 메타값도 게시글별로 달라집니다. 전체 사이트 설명을 게시글 description으로 반복하지 않습니다.

기본 G5에는 신뢰할 수 있는 글 수정시각이 없으므로 `dateModified`는 출력하지 않습니다. `wr_last`를 수정시각으로 오인하지 않으며, 향후 실제 수정시각을 기록하는 별도 계약이 생겼을 때만 출력합니다.

Q&A는 댓글이 있다는 이유만으로 `QAPage`를 쓰지 않습니다. 질문·답변 관계와 채택 답변을 실제로 제공하는 전용 스킨이 생겼을 때 별도 profile로 추가합니다.

### 3.3 댓글

댓글은 부모 글의 `comment` 아래 `Comment`로 출력합니다.

- 화면에 보이는 댓글 전문을 `text`로 표시
- 실제 작성자와 작성일 사용
- 답글 관계가 화면과 데이터에서 확정되면 `Comment.comment`로 중첩
- 비밀·삭제·권한 제한 댓글은 공개 DOM에 보이는 범위만 출력
- 댓글 수는 G5가 실제 제공하는 값과 일치시킴

포럼 글은 큰 본문과 댓글을 JSON-LD에 다시 복제하지 않고 실제 HTML 요소의 Microdata를 우선합니다.

댓글은 별도 페이지 메타를 만들지 않습니다. 부모 게시글 안에서 각 댓글의 작성자·날짜·본문으로 서로 다른 `Comment`를 구성합니다.

### 3.4 고유값과 fallback 규칙

페이지별 데이터 우선순위는 다음과 같습니다.

```text
현재 게시글 또는 현재 목록 데이터
        ↓ 값이 없을 때만
게시판별 설정값
        ↓ 공통 suffix·상위 엔터티에만
사이트 공통값
```

- 게시글 제목을 사이트 공통 제목으로 덮어쓰지 않음
- 게시글 본문 요약이 없으면 게시판 설명을 복제하지 않고 description을 생략
- 이미지가 없으면 존재하지 않는 기본 이미지를 구조화 데이터에 넣지 않음
- 작성자·날짜·가격을 사이트 공통값으로 대체하지 않음
- 목록의 분류·페이지 번호를 title과 `ItemList` 식별에 반영
- 같은 URL 안에서 meta, Open Graph, JSON-LD, Microdata가 서로 다른 값을 만들지 않음

## 4. JSON-LD와 Microdata의 역할

### JSON-LD

head에서 실제 값이 있는 사이트·페이지 상위 관계만 출력합니다.

- `WebSite`
- `Organization` 또는 테마가 허용한 하위 타입
- 현재 화면의 `WebPage` 계열
- 필요한 경우 `BreadcrumbList`
- Microdata 주 엔터티를 가리키는 `mainEntity.@id`

### Microdata

콘텐츠를 그리는 실제 테마·스킨 DOM에 출력합니다.

- 게시판 `ItemList`와 `ListItem`
- `Article` 또는 `DiscussionForumPosting`
- `Comment`
- `ImageObject`, `VideoObject`
- 전용 장터 스킨의 `Product`, `Offer`

한 번 정규화한 컨텍스트에서 URL·제목·작성자·날짜·대표 이미지·가격을 공급하고 JSON-LD와 Microdata의 `@id`·`itemid`를 맞춥니다. 같은 엔터티가 서로 다른 값으로 출력되면 검사 실패입니다.

## 5. 일반 페이지 메타 입력

대상은 G5 관리자 `내용관리`의 공개 페이지와 테마가 manifest에 등록한 제공 PHP 페이지입니다. PHP 페이지는 `home-01` 등 안정적인 페이지 ID로 식별하고 현재 테마가 선언한 목록만 선택하게 합니다. 임의 파일 경로나 URL을 실행 대상으로 입력받지 않습니다. 입력 필드는 다음으로 제한합니다.

| 입력 | 출력 | 비어 있을 때 |
| --- | --- | --- |
| 페이지 제목 재정의 | `<title>` 및 `og:title` | `co_subject` 사용 |
| 페이지 설명 | `<meta name="description">`, `og:description` | 정제된 본문 요약 사용 또는 값이 불충분하면 생략 |
| 대표 이미지 URL | `og:image`와 `WebPage.image` | 내용 상단 이미지, 본문의 첫 공개 이미지, 없으면 생략 |
| 페이지 구조 타입 | `WebPage`, `AboutPage`, `ContactPage` 중 선택 | `WebPage` |

`og:url`과 구조화 데이터 URL은 현재 페이지 절대 URL에서 자동 생성합니다. `og:type`도 페이지 타입에 따라 자동 결정합니다.

다음 입력은 제공하지 않습니다.

- keywords
- 임의 canonical URL
- 임의 robots 문자열
- raw meta HTML
- raw JSON-LD
- 임의 Schema.org 타입 문자열
- 일반 페이지별 SNS 플랫폼 전용 문구

사용자가 입력한 제목·설명·이미지는 구조화 데이터와 메타태그가 함께 사용합니다. 서로 다른 화면에서 같은 값을 다시 입력하게 만들지 않습니다. PHP 페이지는 비어 있을 때 해당 recipe의 제목·안전한 본문 요약·공개 대표 이미지를 사용하며, 요청 경로의 실제 URL을 출력합니다. 파일명이나 사이트 공통 설명만 반복하지 않습니다.

## 6. 설정 화면 위치

활성 테마가 G5 관리자 **환경설정** 메뉴 아래에 `테마 메타·구조화 데이터` 한 항목을 추가합니다.

```text
관리자
└── 환경설정
    └── 테마 메타·구조화 데이터
        ├── 사이트 정보
        ├── 게시판 유형
        └── 일반 페이지 메타
```

### 사이트 정보

- 전체 출력 ON/OFF
- 사이트·기관 이름: 기본값 `cf_title`
- 허용된 기관 타입: 상품별 allowlist
- 공개 로고 URL
- 공개 전화·이메일·주소
- 공개 프로필 URL 목록 `sameAs`

빈 값은 출력하지 않습니다. 비즈니스 테마는 `Organization` 계열만, 향후 의료 테마는 실제 입력이 있을 때 `MedicalClinic` 등 상품에 정의된 타입만 허용합니다.

### 게시판 유형

- 설치된 게시판 목록을 자동 표시
- 현재 PC·모바일 스킨과 기본 profile 표시
- 출력 ON/OFF
- profile 선택: `article`, `forum`, `gallery`, `video`, `market`, `none`
- 목록 title 재정의, 목록 description과 대표 이미지 URL
- 스킨 기본값으로 되돌리기

게시판 ID를 코드에 하드코딩하지 않습니다. 기본 profile은 테마 스킨 manifest가 선언하고 관리자는 예외만 바꿉니다. PC와 모바일 profile이 다르면 저장을 막거나 명확한 오류를 표시합니다.

위 목록은 공통 설계의 전체 후보이며 상품 manifest가 지원하는 profile만 실제 선택 항목으로 노출합니다. JW-Business 1.0은 장터를 포함하지 않으므로 `market`을 제공하지 않습니다.

### 일반 페이지 메타

- 현재 `내용관리` 페이지 목록을 자동 표시
- `co_subject`, 공개 URL, 현재 스킨을 읽기 전용으로 표시
- 제목 재정의, 설명, 대표 이미지 URL과 페이지 타입 입력
- 각 페이지의 원래 내용관리 수정 화면으로 이동하는 링크
- 개별값 초기화

제공 PHP 페이지도 같은 화면의 별도 목록에 표시합니다. 페이지 ID·표시 제목·공개 URL은 manifest에서 읽고 수정 필드는 위 네 항목으로 제한합니다. 같은 화면을 내용관리 경로로 설치했다면 `co_id`를 사용하고, PHP 경로와 이중으로 연결하지 않습니다.

G5 내용관리 폼 자체를 수정하지 않습니다. 전용 화면에서 페이지를 선택해 한곳에서 편집합니다.

## 7. 설정 저장 위치

DB 테이블·G5 여분 필드·테마 소스 파일 대신 다음 파일을 사용합니다.

```text
data/jwsoft/meta-structured/settings.json
```

이 파일은 설치 사이트에 귀속되며 JW SOFT 테마를 바꾸어도 유지됩니다.

```json
{
  "schema_version": 1,
  "enabled": true,
  "site": {},
  "boards": {},
  "contents": {},
  "pages": {}
}
```

### 선택 이유

`contents`는 G5 `co_id`, `pages`는 테마 slug 아래의 안정적인 페이지 ID로 저장해 서로 충돌하지 않게 합니다. 기존 설정에 `pages`가 없으면 빈 목록으로 읽습니다. 테마 변경 시 다른 테마의 설정을 지우지 않습니다.

- G5 코어·DB 스키마를 수정하지 않음
- `cf_1`, `bo_1`, `wr_1` 등 여분 필드 충돌 없음
- 테마 업데이트 ZIP이 설정을 덮어쓰지 않음
- G5 `data` 백업에 포함 가능
- 테마 비활성화 시 실행 코드는 사라지고 설정은 보존됨

### 저장 규칙

- 최고관리자만 읽기·쓰기 화면 접근
- G5 관리자 token과 POST만 사용
- 허용된 scalar·URL·enum만 저장하고 HTML·PHP 입력 금지
- `json_encode()`·`json_decode()`만 사용하고 writable 파일을 PHP로 include하지 않음
- 임시 파일 작성, lock, 검증, atomic rename 순으로 교체
- G5 data 접근 차단 설정을 확인하고, 파일에는 공개 화면에 출력할 값만 저장
- `schema_version`으로 향후 migration 수행
- 저장 실패 시 기존 파일 유지와 명확한 오류 표시
- 설정 파일에 비밀번호·API 키·환자 정보 저장 금지

## 8. G5 연결 방식

테마 바깥의 `extend/` 파일이나 `/adm` 파일을 설치하지 않습니다.

```text
theme/<theme-slug>/
├── theme.config.php
├── lib/meta-structured/bootstrap.php
├── lib/meta-structured/context.php
├── lib/meta-structured/render-jsonld.php
├── lib/meta-structured/admin.php
└── skin/board/<skin>/
    ├── schema.profile.php
    ├── list.skin.php
    ├── view.skin.php
    └── view_comment.skin.php
```

`theme.config.php`는 작은 bootstrap만 불러옵니다.

- `admin_menu` filter: 환경설정 메뉴 한 항목 등록
- `admin_get_page_jw_theme_meta`: 설정 화면 출력
- `admin_request_handler_jw_theme_meta`: 검증·저장 후 redirect
- 공개 `head.sub.php`: 사이트·일반 페이지 JSON-LD와 메타 출력
- 게시판 스킨: 목록·본문·댓글 Microdata 출력

테마가 활성화되지 않으면 관리자 메뉴와 출력도 등록되지 않습니다. 설정 파일은 남아 있으므로 같은 JW SOFT 테마를 다시 활성화하면 재사용할 수 있습니다.

## 9. 기본값과 입력 최소화

설정 파일이 없어도 테마는 다음 기본값으로 동작해야 합니다.

- 구조화 데이터 출력 ON
- 사이트 이름은 `cf_title`
- 일반 페이지 제목은 `co_subject`
- 일반 페이지 설명은 안전하게 추출 가능한 본문 요약
- 게시판 profile은 선택한 테마 스킨의 manifest 값
- 게시판 목록 title은 `bo_subject`, 분류명과 페이지 번호
- 게시글 제목·작성자·날짜·본문·댓글은 G5 실제 데이터
- 이미지와 영상은 공개 화면에서 확인되는 파일만 사용

관리자가 반드시 입력해야만 사이트가 작동하는 구조로 만들지 않습니다. 설정은 자동값을 바꾸거나 G5에 없는 기관 정보만 보완합니다.

## 10. 채택하지 않는 저장 방식

| 방식 | 판단 | 이유 |
| --- | --- | --- |
| `cf_add_meta` | 사용 안 함 | 사이트 전체 raw HTML이며 페이지별 관리·중복 방지가 어려움 |
| `cf_1~10`, `bo_1~10`, `wr_1~10` | 사용 안 함 | 구매자와 외부 스킨·플러그인의 확장 슬롯을 점유함 |
| G5 코어 테이블 컬럼 추가 | 사용 안 함 | 업데이트·이전·복구와 uninstall 부담이 커짐 |
| 전용 DB 테이블 | 1차 제외 | 설치·migration·삭제·백업 지원 범위가 늘어남 |
| 테마 안의 writable PHP 설정 | 사용 안 함 | ZIP 업데이트로 덮일 수 있고 writable PHP 실행 위험이 있음 |
| 내용관리 폼 DOM 주입 | 사용 안 함 | 전용 출력 hook이 없어 G5 관리자 마크업 변경에 취약함 |
| 별도 SEO 플러그인 번들 | 사용 안 함 | 라이선스·충돌·CS 범위를 테마가 떠안게 됨 |

## 11. HTMLPurifier 경계

G5 기본 HTMLPurifier 단독 확인에서 `itemscope`, `itemtype`, `itemprop`과 해당 바깥 요소가 제거될 수 있었습니다.

따라서 구매자가 내용관리에 붙여넣는 섹션 HTML이나 게시글 본문 안의 Microdata를 신뢰하지 않습니다. 정제된 본문을 감싸는 테마 PHP skin이 구조화 데이터 속성을 출력합니다. HTMLPurifier 설정을 느슨하게 바꾸지 않습니다.

## 12. 외부 SEO 플러그인

- 기본값: 테마 메타·구조화 데이터 출력 ON
- 외부 플러그인이 같은 값을 출력하면: 테마 출력 전체 OFF
- 자동 플러그인 감지와 플러그인별 합성 로직은 만들지 않음
- 설정 화면 최상단에 전체 ON/OFF 하나만 제공

외부 플러그인과 출력을 합치거나 그 플러그인의 설정을 진단하는 일은 테마 지원에 포함하지 않습니다.

## 13. 검증

### 자동 검사

- JSON-LD 파싱과 허용 타입 확인
- 목록 `ItemList`의 현재 DOM 항목 수·순서·URL 비교
- 본문 타입, 제목, 작성자, 날짜와 절대 URL 비교
- 서로 다른 게시글 fixture에서 title·description·대표 이미지가 서로 달라지는지 확인
- 게시판 목록·분류·페이지 이동별 title과 `ItemList`가 현재 데이터와 일치하는지 확인
- 화면에 보이는 댓글 수·본문과 `Comment` 비교
- JSON-LD와 Microdata의 공통 ID·URL·이미지 일치
- 빈 값, 상대 외부 URL, 잘못된 날짜·가격·통화 차단
- 비밀글·비밀댓글·권한 없음 화면의 보호 데이터 미출력
- 설정 파일 저장 실패·중단·구버전 migration 회귀

### 실제 화면 검사

- 게시판 빈 목록, 1건, 2건 이상, 공지 포함, 검색, 분류, 페이지 이동
- 일반 게시글, 포럼 글, 갤러리, 영상, 장터
- 댓글 없음·일반 댓글·답글·비밀댓글·삭제댓글
- PC·모바일, 로그인·비로그인·관리자
- 일반 페이지 기본값·수동값·빈 설명·없는 이미지
- 서버 원문과 브라우저 DOM
- Google Rich Results Test와 Schema Markup Validator

Search Console은 유형별 인식 결과를 관찰하는 운영 증거로 사용합니다. 검색 노출 자체를 출시 합격 조건이나 상품 보장으로 사용하지 않습니다.

## 14. CS 경계

### 지원

- 테마가 출력한 JSON-LD·Microdata·일반 페이지 meta의 문법 오류
- 실제 화면과 다른 제목·날짜·작성자·댓글·이미지 출력
- 지원 G5·PHP 환경에서 설정 저장이 안 되는 재현 가능한 오류
- 비공개·비밀 데이터가 구조화 데이터로 노출되는 결함
- 공식 테마 업데이트 후 설정 유실 또는 출력 회귀

### 지원 제외

- 검색엔진 수집 시점·노출·순위·리치 결과 여부
- 제목·설명 문구 작성과 Schema.org 유형 컨설팅
- Search Console·서치어드바이저 등록과 경고 해석 대행
- 외부 SEO 플러그인 충돌·설정·데이터 병합
- 고객이 settings 파일이나 테마 PHP를 직접 수정한 결과

## 15. 완료 조건

- 게시판 목록·본문·댓글이 각각 실제 DOM에 대응하는 구조를 출력함
- 일반 페이지의 제목·설명·대표 이미지·페이지 타입을 제한된 필드로 관리함
- G5 코어·DB·여분 필드를 수정하거나 점유하지 않음
- 설정이 한 관리자 화면과 한 data 파일에 모임
- 설정 없이도 안전한 기본 출력이 동작함
- 외부 플러그인 사용 시 전체 출력을 한 번에 끌 수 있음
- 구조화 데이터와 일반 페이지 meta 이외의 SEO 기능이 포함되지 않음

## 16. 조사 근거

### 현재 G5 코드

- `.runtime/gnuboard5/common.php`: 활성 `theme.config.php` 로드
- `.runtime/gnuboard5/adm/admin.lib.php`: `admin_menu` filter와 동적 관리자 메뉴
- `.runtime/gnuboard5/adm/view.php`: `call` 기반 관리자 event route
- `.runtime/gnuboard5/adm/contentform.php`: 기본 내용관리 입력 필드
- `.runtime/gnuboard5/adm/contentformupdate.php`: 내용관리 저장 event
- `.runtime/gnuboard5/install/gnuboard5.sql`: content·config·board 필드 계약
- `.runtime/gnuboard5/theme/basic/head.sub.php`: 전역 `cf_add_meta` 출력 위치
- `.runtime/gnuboard5/theme/basic/skin/board/basic/`: 목록·본문·댓글 실제 DOM

### 외부 기준

- [Google Discussion Forum structured data](https://developers.google.com/search/docs/appearance/structured-data/discussion-forum)
- [Google Carousel ItemList structured data](https://developers.google.com/search/docs/appearance/structured-data/carousel)
- [Google General structured data guidelines](https://developers.google.com/search/docs/appearance/structured-data/sd-policies)
- [Google meta description guidance](https://developers.google.com/search/docs/appearance/snippet)
- [Google VideoObject structured data](https://developers.google.com/search/docs/appearance/structured-data/video)
