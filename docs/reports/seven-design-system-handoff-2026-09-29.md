# 메인 7종 디자인 시스템·제작 인계 — 2026-09-29

형님, 이번 교정은 JW-Business의 기존 디자인 시스템 안에서 페이지별 자료와 표현을 확장한 작업입니다. 새 시각 체계나 공통 컴포넌트 규격을 정하지 않았습니다. 이 문서는 원본 동결 시점의 유지관리 인계이며 **시각 합격·묶음 완료·판매 승인 보고가 아닙니다.** 독립 Sol 검토와 최종 actual-G5 판정은 root가 별도로 확정합니다.

## 적용 기준과 문서 경계

- 대상: 메인 1–4와 제품·서비스·프로젝트 원페이지 3종입니다. [실행 지시서](../plans/JW-BUSINESS-MAIN-SEVEN-CORRECTION-BRIEF-2026-09-29.md), [7종 구성 지도](../plans/JW-BUSINESS-MAIN-SEVEN-CORRECTION-MAP-2026-09-29.md), [42개 원장](../plans/JW-BUSINESS-MAIN-SEVEN-CORRECTION-LEDGER-2026-09-29.json)을 따릅니다.
- Impeccable `new-work.md`의 ordinary extension 인계로 처리했습니다. 기존 [DESIGN.md](../../themes/business/jw_business/DESIGN.md), [.impeccable/design.json](../../themes/business/jw_business/.impeccable/design.json), [PRODUCT.md](../../themes/business/jw_business/PRODUCT.md)을 보존했습니다. 토큰·정책·품질 계약·상품 소스·자산을 이 문서화 작업에서 수정하지 않았습니다.
- 대조 자료: 루트/테마 AGENTS, START-HERE, Impeccable `document.md`, 위 설계 문서, [메인 1·4 카드](../plans/seven-correction-home14-2026-09-29.md), [메인 2·3 카드](../plans/seven-correction-home23-2026-09-29.md), [원페이지 카드](../plans/seven-correction-onepages-2026-09-29.md), 구현 보고 3종, 실제 PHP/CSS/JS·토큰·빌드 자산 복사 경로·수집 manifest입니다.
- 이 담당은 새 브라우저 검수·빌드·배포·커밋을 실행하지 않았습니다. 아래 실행 수치는 기존 파일에서 읽은 수집 결과이고, 시각 판단은 별도 검토자의 책임입니다.

## 기존 시스템과의 대조

| 기준 | 현재 구현과의 관계 | 유지관리 원칙 |
| --- | --- | --- |
| 색·모드 | `src/styles/theme.css`의 daisyUI `jw-light`·`jw-dark`, DTCG 의미 연결을 유지합니다. `base-*`, `primary/content`, `neutral/content` 및 파생 색을 사용합니다. | 사이트 UI는 의미 색과 content 색을 함께 수정합니다. ATELIER·ORBIT·FIELDNOTE·FORME·ONDO·AURA·SAI 작품 내부의 색을 전역 UI로 확대하지 않습니다. |
| 글꼴·계층 | 사이트 본문과 컨트롤은 로컬 Pretendard입니다. FORME 작품 워드마크·편집물 안의 Georgia 표현도 기존 작품 언어의 범위입니다. | 새 폰트를 도입하지 않았습니다. 메인 전용 display 크기를 DESIGN.md의 공용 제목 scale에 억지로 맞추지 않습니다. |
| 토큰 | `tokens/theme.tokens.json`의 의미 색·48px 컨트롤·180/70/420/620ms 동작·16px 등장 거리·out easing을 보존합니다. | `generated/tokens.css`·`generated/tailwind-theme.css`는 직접 고치지 않습니다. 별도 타이밍이 있는 페이지 동작은 소유 원본에서 확인합니다. |
| 레이아웃·모서리 | 공용 shell과 페이지 전용 구도를 유지합니다. 메인별 독립 폭·모바일 전환을 사용합니다. | 페이지별 설계 기준을 따릅니다. 단일 breakpoint·카드·모서리 체계로 7종을 통합하지 않습니다. |
| 동작·아이콘 | Motion `scroll`/`inView`, Embla·Autoplay/Fade, 선택 Lucide를 사용합니다. 메인 3 신규 동작도 `theme.ts`에서 초기화합니다. | 자료 전환을 수제 스크롤 감지기로 다시 만들지 않습니다. 큰 아이콘은 정보 역할이 있는 항목에 사용하며 본문·제목을 함께 뒤집지 않습니다. |
| 독립 PHP | `src/php/index_1.php`–`index_4.php`, `pages/onepage-*.php`가 본문을 직접 소유합니다. 메인 1 기본/모바일 진입은 현행 복사 방식을 유지합니다. | 런타임 section/partial/dispatcher로 본문 책임을 감추지 않습니다. 기존 메뉴·G5 코어·DB를 이번 표현 확장에 끌어들이지 않습니다. |

확인한 고정 의존성은 Pretendard 1.3.9, Lucide 1.47.0, Tailwind 4.3.3, daisyUI 5.7.40, Motion 13.4.0, Embla 8.6.0입니다. 현재 package.json과 DESIGN.md의 버전 기재가 일치합니다. 새 라이브러리나 고객 서버 빌드 요구는 없습니다.

## 페이지별 제작 책임

아래 경로는 `themes/business/jw_business/` 기준입니다. 페이지의 새 표현을 다른 메인으로 복사하더라도 해당 페이지에서 독립 수정하며, 이번 7종이 쓴다는 이유만으로 다른 테마용 공통 package를 만들지 않습니다.

| 페이지·선택 이유 | 본문·스타일·동작 원본 | 유지할 자료와 구성 |
| --- | --- | --- |
| 메인 1: 여러 업종과 매체를 다루는 기업 | `src/php/index_1.php`, `src/php/index.php`, `src/php/mobile/index.php`; `home-one.css`, `home-one.ts` | 12섹션·히어로 3장. 관찰/선택 보드, ATELIER PC·모바일, DAYLINE 일정, FAQ·실제 latest·문의의 역할을 구별합니다. |
| 메인 2: 판단 근거를 설명하는 컨설팅 | `src/php/index_2.php`; `home-2.css`, `home-2.ts` | 9섹션·히어로 3장. 한 번의 우선순위 지도, ORBIT 서비스 비교, 운영 인계 도서와 준비 브리프를 유지합니다. |
| 메인 3: 거리와 매체가 다른 작업 포트폴리오 | `src/php/index_3.php`; `home-variants.css`, `home-three.ts`, `theme.ts` | 8섹션. 작품 밖의 제목, 안내 평면·인쇄물·전시·FIELDNOTE 웹/편집물, 의뢰 준비 내용을 유지합니다. |
| 메인 4: 단일 FORME 브랜드의 제작 과정 | `src/php/index_4.php`; `home-four.css`, `home-four-entry.ts` | 9섹션. 기존 제품 가족·4사진, 브리프→화면→포장, 브랜드 사용 가이드·파일 명세를 유지합니다. |
| 제품형: 같은 물건의 형태·재질·쓰임 | `pages/onepage-showcase.php`; `onepages.css`, `onepages.js` | 11섹션·소재/크기/설치 3탭·60프레임. 모든 제품 표현은 같은 AURA assembly를 사용합니다. |
| 서비스형: 고객이 탐색하고 준비하는 결과 화면 | `pages/onepage-services.php`; `onepages.css`, `onepages.js` | 12섹션. ONDO 서비스 탐색→비교→준비, 운영 지면·인계 문서·범위표를 유지합니다. 메인 2의 의사결정표와 역할을 구별합니다. |
| 프로젝트형: 사진·동선·재료를 함께 읽는 공간 | `pages/onepage-projects.php`; `onepages.css`, `onepages.js` | 12섹션·히어로 3장·갤러리 5장. 개념 평면과 실제 표시 장면의 대응, 재료 견본·설계 인계 지면을 유지합니다. |

스타일과 동작 파일은 각각 `src/styles/`, `src/scripts/` 아래에 있습니다. 더미 브랜드와 완성 시안은 상업용 테마의 예시 자료이며 실제 고객 실적·성과·예약·결제 기능을 뜻하지 않습니다.

## 6개 의미 전환의 조작 계약

| 페이지 | 표시 자료의 변화 | 상태·조작 선택자와 대안 |
| --- | --- | --- |
| 메인 1 | 관찰 질문에 맞는 제품 스펙·관리법·콘텐츠 준비의 전후 자료 | `[data-jw-decision-board]`의 `data-jw-stage=0/1/2`; `[data-jw-decision-select]` 버튼. 일반 동작에서는 Motion scroll, reduced motion에서는 수동 선택을 남깁니다. |
| 메인 2 | 관찰 질문→조건 비교→선택 실험 | `[data-jwh2-priority-scroll]`의 `data-priority-step=0/1/2`; `[data-priority-label]`. 951px 이상·일반 동작에서 자동 연결하며 수동 선택 후 자동 전환을 멈춥니다. 모바일/reduced/no-JS는 3개 자료를 정적으로 읽습니다. |
| 메인 3 | A 출구→B 승강장→C 환승 경로와 도착 표지 | `[data-jwh3-wayfinding-scroll]`의 `data-route-step=a/b/c`; `[data-jwh3-route]`. 768px 이상 일반 동작의 scroll target은 `.jwh3-wayfinding-v2`, offset은 `start 0.5`→`start 0`입니다. 모바일 버튼과 reduced/no-JS 전체 경로를 유지합니다. |
| 메인 4 | 브랜드 브리프→제품 비교 화면→완성 패키지 | `[data-jw-forme-story]`의 `data-jw-stage=0/1/2`; `[data-jw-forme-select]`·`[data-jw-forme-panel]`. 1000×930px 이상에서 sticky/scroll, 작은/짧은 화면·reduced에서는 수동 전환. 방향키·Home/End, no-JS 전체 자료를 유지합니다. |
| 서비스형 | 발견→비교→방문 준비의 ONDO 화면 | `.jwo-journey-study[data-jwo-narrative]`의 `data-active-step=0/1/2`; `[data-jwo-narrative-button]`·`[data-jwo-narrative-panel]`. 실제 화면 내용이 교체됩니다. |
| 프로젝트형 | 도착→실내→중정의 사진과 평면 위치 | `.jwo-space-atlas[data-jwo-narrative]`의 같은 상태와 버튼; `[data-jwo-floor-stop]`의 `.is-active`. 사진과 위치가 같은 단계에 대응합니다. |

원페이지 두 서사는 Motion `inView`의 `-30% 0px -45% 0px` 범위로 왕복 진입을 처리합니다. 자동 연결은 768px 이상·reduced motion 아님·saveData 아님에서 사용하고 수동 버튼은 유지합니다. 이 조건을 바꾸면 시작·중간·끝뿐 아니라 역스크롤과 모바일/reduced 조작을 다시 수집해야 합니다. 선택자 존재나 상태 값만으로 자료의 가독성과 전환 품질을 승인하지 않습니다.

## AURA 단일 모델과 자산 관리

- 제작 원본: `onepages/design/render-aura.py`, `aura-concept.blend`. 월넛·샴페인 금속·직물·톱니 노브·후면 연결 구조를 같은 assembly로 만듭니다. hero/detail/living, 소재 접사, 정면·배치·설치 컷이 이 원본을 공유합니다.
- 회전 원본: `onepages/assets/sequence/aura-001.webp`–`aura-060.webp`, 각 1080×810 투명 WebP와 출처 sidecar입니다. 60장을 60fps 영상으로 해석하지 않습니다. 현재 동작은 프레임을 선택하는 이미지 시퀀스입니다.
- 회전 동작: `[data-jwo-sequence]`가 60프레임을 소유하며 range·각도 출력·키보드·자동 스크롤 켜기/끄기를 제공합니다. 모바일/reduced/saveData는 자동 회전을 제한하고 선택한 각도를 읽습니다. no-JS 정지 제품과 프레임 요청 실패 안내도 별도 확인 대상입니다.
- 새/갱신 래스터 등록 조각은 [home14 4개](../plans/seven-assets-home14-2026-09-29.json), [home23 3개](../plans/seven-assets-home23-2026-09-29.json), [onepages 75개](../plans/seven-assets-onepages-2026-09-29.json)입니다. 합계 82개는 새 정지 자료 22개와 갱신 회전 프레임 60개이며, 문서화 시점에 **82/82 원본 SHA가 등록 조각과 일치**했습니다. 별도 안내 SVG는 `src/assets/home-three/wayfinding-atlas.svg`입니다.
- imagegen 자산은 정확한 prompt·생성 원본·취득일·도구·owner·SHA를 sidecar로 보존합니다. Blender 자산은 `blender:` origin과 기존 월넛 texture 출처를 보존합니다. WebP의 `sidecar fallback`을 픽셀 내부 prompt 삽입으로 표현하지 않습니다. 파일명 변경이나 재압축으로 동일 원본을 새 자산처럼 취급하지 않습니다.
- `src/assets/`·`onepages/assets/`가 편집/제작 쪽 원본이며, 빌드된 `theme/assets/`·`theme/onepages/assets/`는 설치 payload입니다. `scripts/build-payload.ts`가 신규 폴더와 60프레임을 복사하고, 이미지 sidecar를 배포 이미지 폴더에 복사하지 않습니다. 출처는 자산 manifest 생성 경로로 연결됩니다. `theme/`를 직접 수정하지 않습니다.
- 고객은 준비된 설치 자산을 사용합니다. Blender·Bun·Node·소스 빌드를 고객 서버에 요구하지 않습니다. 프롬프트, 렌더 원본, 개발 기준 HTML, 품질 증거는 판매 runtime 본문에 노출하지 않습니다.

## 새 수집기와 실제 증거의 경계

수집 절차는 [harness/ui/README.md](../../harness/ui/README.md)가 기준입니다. 출력 경로는 테마 루트 기준 환경 변수로 지정합니다. 재실행 시 새 경로를 사용하며 기존 증거의 날짜·digest를 고쳐 재사용하지 않습니다.

| 수집기 | 읽어 확인한 이번 결과 | 해석 |
| --- | --- | --- |
| `bun run harness/ui/collect-signatures.ts` / `JW_SIGNATURE_OUTPUT` | [최종 signatures manifest](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/signatures/manifest.json): 6페이지 × PC scroll/모바일 키보드/reduced 키보드 = 18기록, 각 3단계로 54상태. 화면과 원본 자료 구간 PNG·표시 문구·이미지 로딩·넘침을 함께 기록합니다. | 결과 값은 `observed-not-visually-approved`입니다. 수집 전후 inputDigest를 비교하는 신규 수집기이며 시각 승인을 내리지 않습니다. |
| `bun run harness/ui/collect-interactions.ts` / `JW_INTERACTION_OUTPUT` | [최종 interactions manifest](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/interactions/manifest.json): 기존 필수 조작 40기록, 모두 `pass`. | 슬라이더·정지·키보드·hover/focus·탭·갤러리 등의 자동 조작 결과입니다. 모든 페이지의 독립 시각 합격은 아닙니다. |
| `bun run harness/ui/collect-rotation.ts` / `JW_ROTATION_OUTPUT` | [최종 rotation manifest](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/rotation/manifest.json): AURA 8기록, 모두 `pass`. | 스크롤 각도·키보드·모바일·reduced/no-JS·요청 실패 대안 증거입니다. 제품 외형 일관성과 시각 완성도 판단은 따로 합니다. |

최종 `revision-2/signatures`의 inputDigest는 `609ca656197948ad78fe9b782faa7e391b70defe57249f559c272ce0ee0ba010`입니다. 이전 `signatures/`는 수집 중 Main 3 동작 시점/자산 sidecar 변경으로 digest가 달라져 [INVALID.md](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/signatures/INVALID.md)에 무효 처리되어 있습니다. 최종 증거로 사용하지 않습니다.

위 manifest를 읽었다는 사실은 본 담당이 54장 전체를 시각 검수했다는 뜻이 아닙니다. IAB 28상태·위험 폭·9+12쌍 비교, 구현 기준 화면과의 차이, 독립 Sol 판정·원장 verified·최종 gate는 root의 마감 증거로 확인해야 합니다. 이후 소스·자산·생성물 변경이 생기면 영향받는 증거와 이 인계도 다시 대조합니다.

## 발견한 기존 문서 차이와 남은 승인

- PRODUCT.md의 “공개 shell 재구축 단계”, 오래된 payload 수량·다음 순서는 현재 7종 구현의 진행 상황과 다릅니다. DESIGN.md가 이미 명시한 대로 상품 대상·독립 설치·지원 범위의 계약만 계승하고 과거 진행 문장을 현재 완료 상태로 사용하지 않았습니다. 상품 문서는 수정하지 않았습니다.
- 기존 surface brief 목록에는 제거된 `index_5.php`와 과거 `onepages/pages/onepage-*.php` 경로가 남아 있습니다. 이번 source 소유권은 실제 `src/php/index_1.php`–`index_4.php`와 `pages/onepage-*.php`를 기준으로 기록했습니다. 기존 brief를 자동 정리하지 않았습니다.
- DESIGN.md와 sidecar는 공용 재사용 기준입니다. 이번 페이지별 자료 전환·작품 지면이 sidecar의 공용 6개 컴포넌트에 추가되지 않은 것은 ordinary extension의 경계입니다. 새로운 전역 token이나 공용 primitive를 확정한 것으로 간주하지 않습니다. 구현자의 수동 detector가 지적한 type-ramp/font-size 권고도 페이지 전용 계층을 일괄 축소하는 근거로 쓰지 않았습니다.
- 회사소개/사업소개에서 기존 `home-hero.webp`, `home-collaboration.webp`, `home-project.webp`의 `PHOTO_REUSE`/`PHOTO_OWNER` **6건**이 교정 시작 시 확인되었습니다. 글로벌 품질 검사에서 범위 밖 실패로 남을 수 있습니다. 별도 범위 확장 지시 없이 사진·owner·검사 기준을 고치지 않으며 실제 최종 실패 수는 root의 마지막 gate 결과를 따릅니다.
- 초기 인계 당시에는 독립 Sol 검토 전이었습니다. `quality:complete home`·`quality:complete onepage` 성공, 원장 42개의 증거 충족, 현재 digest 일치가 확인되기 전에는 “메인 7종 시각 교정 완료”라고 보고하지 않습니다. 자동 수집·개발 반영·문서 인계는 판매 ZIP 설치·업데이트·롤백·로그인 기능 전체 또는 상품 출시 승인과 별개입니다.

구현 세부와 담당 자가 검사 범위는 [메인 1·4 기록](seven-implementation-home14-2026-09-29.md), [메인 2·3 기록](seven-implementation-home23-2026-09-29.md), [원페이지 기록](seven-implementation-onepages-2026-09-29.md)에 남깁니다. 최종 actual verdict는 별도 최종 보고서에서 읽습니다.

## 2026-09-29 최종 구현 보충

- Main 1 전략판은 고객 관찰 E1/E2 → 제품 선택 P1/관리 P2 → 발행 자료의 관계가 있는 PC·모바일 SVG로 교정했습니다. Main 2 우선순위 지면도 기대 효과/실행 부담의 네 영역과 서비스 비교/문의 준비 화면을 포함합니다. 이 네 SVG와 sidecar는 제작 원본에 남습니다.
- ONDO의 발견·비교에는 서로 다른 작업 사진 2개가 추가되어, 자산 감사 합계는 82개입니다. 사진 registry의 source SHA·owner와 일치했습니다.
- 프로젝트 hero의 재생 의도는 `wantsPlayback`으로 hover/focus/drag와 구분합니다. 사용자가 정지하면 다른 구간 이동 뒤에도 정지하며, 명시적 재생만 재개합니다. 실제 Embla fixture 회귀와 G5 PC/모바일의 8.2초 관찰을 남겼습니다.
- 최종 clean worktree commit `8403e2a`에서 frozen install → build → generated:check가 모두 성공했습니다. 고객 서버에는 생성된 payload를 배포했습니다.
- 최종 시각 판정과 미충족 항목은 `seven-independent-review-revision-2-2026-09-29.json` 및 최종 보고서가 우선합니다. 이 인계 문서의 초기 pending 표현은 작성 당시 상태이며, 자동으로 판매 승인으로 바뀌지 않습니다.

최종 판정: [개선·재검수 보고](seven-correction-final-2026-09-29.md). 원장40/42확인, G02/M2-01초광폭 정렬 미해결. home gate8건 실패(시각2+전역사진6), onepage는 선행home으로 차단, 전체23페이지gate31건 실패.
