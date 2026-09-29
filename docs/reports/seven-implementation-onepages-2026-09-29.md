# 원페이지 3종 교정 구현 인계 — 2026-09-29

구현자: Astra `/root/astra_onepages`. SH01–04, SV01–04, PJ01–04 및 해당 공통 G 교정 소스를 인계합니다. 아래 자가 검사는 독립 시각 승인이나 판매 ZIP 승인에 해당하지 않습니다. 최종 원본 반영 후 root의 새 증거 수집과 Sol 독립 검토가 남아 있습니다.

## 구현 결과

| 항목 | 소스 변경과 보존한 기능 |
| --- | --- |
| SH01 | 한 Blender master의 월넛·샴페인 금속·직물·톱니 노브를 hero/detail/living/60회전 프레임에 통일했습니다. 60장 투명 WebP 1080×810, range·키보드·스크롤·reduced-motion·JS 미사용 대안을 보존했습니다. |
| SH02 | CSS 줄무늬 재질표를 같은 제품의 독립 카메라 접사 3장으로 바꿨습니다. 소재/크기/설치 3탭 구조는 유지합니다. |
| SH03 | 동일 제품 정면 치수, 선반 배치, 후면 케이블·벽면 콘센트 연결 렌더를 사용합니다. |
| SH04 | 회전 무대를 넓히고 FAQ/문의의 역할을 분리했습니다. 기존 11섹션을 보존했습니다. |
| SV01 | 첫 화면을 가상 고객사 ONDO의 완성된 서비스 탐색 화면으로 구성했습니다. 메인2의 판단 도구와 구별되는 고객 결과 화면입니다. |
| SV02 | 반복 워크숍 사진을 줄이고 스튜디오 1장·업종 모자이크 3장을 보존했습니다. 나머지는 탐색·운영·인계의 구체적인 자료로 대체했습니다. |
| SV03 | 발견/비교/준비 3단계 화면, 운영 매뉴얼 지면, 고객 경험 지도·안내 예문·반응형 화면 명세·운영 점검표를 실제 내용으로 구현했습니다. |
| SV04 | 12섹션과 설명을 유지하면서 모바일 목차 52px 한 줄, FAQ와 상담 구분을 적용했습니다. |
| PJ01 | 기존 hero 3장·gallery 5장, 큰 이전/다음·swipe·카운터·정지 기능을 보존했습니다. hero에도 키보드 조작을 보강했습니다. |
| PJ02 | 가구·기둥·계단·출입구·수공간·3단계 동선을 담은 개념 평면을 실제 장면과 연결했습니다. 도착 사진을 새로 제작하고 기존 실내/중정 사진은 중복 없이 재배치했습니다. |
| PJ03 | 새 재료 견본 사진, 도면과 마감 명세·사인 배치 내용을 가진 인계 지면을 구현했습니다. |
| PJ04 | 단면/채광 설명, 건축 문의 준비 항목, FAQ 밀도를 조정하고 기존 12섹션을 유지했습니다. |

디자인 선행 자료: `docs/plans/seven-correction-onepages-2026-09-29.md`, `docs/prototypes/seven-onepages-20260929.html`, 같은 이름의 `.css`. 실제 자산 화면을 먼저 구성한 뒤 PHP/CSS/JS로 옮겼습니다.

## 소유 파일과 자산

- `themes/business/jw_business/pages/onepage-{showcase,services,projects}.php`
- `themes/business/jw_business/src/styles/onepages.css`
- `themes/business/jw_business/src/scripts/onepages.js`
- `themes/business/jw_business/onepages/design/render-aura.py`, `aura-concept.blend`
- `themes/business/jw_business/onepages/assets/sequence/aura-001.webp`부터 `aura-060.webp` 및 각 sidecar
- `themes/business/jw_business/onepages/assets/correction/`: AURA 정지 렌더 10장, 서비스/프로젝트 새 imagegen 사진 3장 및 각 sidecar
- `docs/plans/seven-assets-onepages-2026-09-29.json`: 총 73개 source asset path/SHA/origin/owner 조각

제품 이미지는 Blender 5.2.2 LTS + WebP로 제작했습니다. 기존 생성 목재 텍스처 출처를 유지하고, 갱신 60프레임 sidecar에는 이전 생성 prompt/tool/date도 보존했습니다. 서비스/프로젝트 사진 3장은 OpenAI built-in imagegen으로 각각 새로 제작했습니다. 모든 새 sidecar는 취득일 2026-09-29·도구·소유 페이지·SHA·origin을 기록했습니다. native 제품 렌더는 `blender:` origin을 사용합니다. global registry와 생성 theme는 root가 통합합니다.

## 수행한 검사와 관찰

- 3개 PHP 문법 검사, `styles:check`, theme 디렉터리의 `structure:check`, 소유 텍스트 파일 `git diff --check` 통과. 마지막 서비스 예문 변경 후 PHP·styles·diff 검사를 다시 통과했습니다.
- Impeccable 수동 감지는 경고용으로 수행했습니다. 기존 스타일을 포함한 type-ramp/font-size 권고 132개이며 이것을 승인 근거로 삼지 않았습니다.
- 독립 Playwright context로 실제 `g5themes.test` 예비 배포본 3페이지 × PC 1440×1000/모바일 390×844 × light/dark = 12상태를 수집했습니다. 측정상 가로 넘침·깨진 이미지 0, section 11/12/12, 모바일 목차 52px, 프로젝트 hero 3장/gallery 5장입니다.
- 실제 제품 소재/크기/설치 탭을 선택하고 회전 키보드 0/90/180/270도 상태를 확인했습니다. 프로젝트 hero 3상태·gallery 5상태를 조작해 카운터 변화와 해당 화면을 수집했습니다.
- 예비 전체 화면, 제품 탭·회전 장면을 열어 본 결과 설치 컷의 콘센트 가림과 서비스 인계 지면의 빈 공간을 발견하여 이번 마지막 변경으로 교정했습니다.
- 수정 원본을 로컬 렌더하여 서비스 스크롤 0→1→2→0 재진입을 확인했습니다. 모바일 단계 목록 flex·아이콘 20px·가로 넘침 0을 확인했습니다. 마지막 안내 예문은 PC/모바일 화면을 별도로 열어 배치와 한글 줄바꿈을 확인했습니다.
- root가 수행한 예비 `ui:check` 24/24는 root의 자동 검사 결과이며 본 문서의 독립 시각 승인으로 간주하지 않습니다.

증거 위치: `output/seven-onepages-20260929/`. `g5-*.png`는 예비 배포본이며 최종 CSS 충돌 교정과 마지막 설치/예문 변경 이전 증거입니다. `local-services-mobile-corrected.png`, `local-service-handoff-final-{desktop,mobile}.png`는 변경 원본의 보조 확인입니다. 최종 actual-G5 증거는 root가 새로 수집해야 합니다.

## 스크롤·수동 검사 계약

서비스 `.jwo-journey-study[data-jwo-narrative]`, 프로젝트 `.jwo-space-atlas[data-jwo-narrative]`는 `data-active-step="0|1|2"`를 사용합니다. `[data-jwo-narrative-step]` 3개와 `[data-jwo-narrative-button="0|1|2"]` 수동 버튼이 대응합니다. 서비스 `[data-jwo-narrative-panel]`은 1개만 보이고 프로젝트 `[data-jwo-floor-stop="0|1|2"]`에는 활성 `.is-active`가 붙습니다.

Motion `inView` margin은 `-30% 0px -45% 0px`이며 종료 콜백을 반환해 역스크롤 재진입도 유지합니다. 자동 스크롤 연동은 PC 768px 이상·reduced-motion false·saveData false에서 사용하고 모든 상태에서 수동 버튼을 남깁니다. 프로젝트 hero viewport는 tabindex와 방향키/Home/End 조작을 지원합니다.

## 마지막 변경과 남은 범위

마지막 교정 대상은 `render-aura.py`, `aura-setup.webp`, 그 sidecar, asset registry 조각, `onepage-services.php`, `onepages.css`, 본 보고서입니다. 설치 렌더의 콘센트/케이블 관계와 서비스 인계의 고객 안내 예문만 추가 교정했습니다. 최종 setup SHA는 registry 및 sidecar의 동일 필드에서 확인합니다.

원본 동결 이후 수정은 중단합니다. root의 최종 빌드/개발 배포, 새 28상태·변형쌍·대표 시그니처 수집, 독립 Sol 판정, ledger/digest/필수 gate 반영, 커밋이 남습니다. 요청 범위 밖 회사·사업 사진 재사용 6건 때문에 품질 gate가 막히는 상태를 예외나 경고로 바꾸지 않습니다. 판매 ZIP, 로그인 기능 전체, 실제 상품 출시 승인은 이번 자가 검사로 주장하지 않습니다.

## Sol 독립 검수 후 1회 묶음 교정 인계

SV-03/G07 및 프로젝트 모바일 hero 캡션 두 지적만 교정했습니다. 서비스 여정은 300/840px 두 열(1440 viewport), 260px씩의 결정 단계와 실제 물레 수업·완성 작품 사진이 있는 발견/비교 화면, 일정·준비물의 상담 준비 화면으로 바꿨습니다. 이전 선택과 다음 판단을 같은 값으로 연결했습니다. 작품 내부 사진도 재사용하지 않고 신규 2장을 각 1회 사용합니다. 화면 안에 `수업 일정 시안 · 실제 신청 기능 아님`을 표시하며 마지막 항목은 `상담 준비 내용`입니다.

프로젝트 캡션은 neutral/neutral-content의 불투명 표면을 사용합니다. 기존 Embla transformed track 밖의 shade가 캡션까지 어둡게 만들던 원인을 확인하여 같은 사진 그라데이션을 각 figure의 pseudo-element로 옮겼습니다. 캡션은 그 위에 놓습니다. 실제 렌더에서 글자/배경 대비 light 21:1, dark 9.52:1, opacity 1을 확인했습니다.

이번 변경 파일:

- `pages/onepage-services.php`, `src/styles/onepages.css` (theme source 기준)
- `onepages/assets/correction/service-ondo-first-cup.webp`와 `.webp.json`
- `onepages/assets/correction/service-ondo-course-works.webp`와 `.webp.json`
- `docs/plans/seven-assets-onepages-2026-09-29.json` (순수 AssetRecord 75개)
- `docs/plans/seven-correction-onepages-2026-09-29.md`
- `docs/prototypes/seven-onepages-sol-review-20260929.html`, `.css`
- 본 보고서

AURA/Blender/60프레임, 프로젝트 PHP, JS, 생성 theme는 이번 교정에서 변경하지 않았습니다.

신규 자산 owner는 모두 `onepage-services`, tool은 `OpenAI built-in imagegen`, acquiredAt은 `2026-09-29`입니다. 실제 생성 호출의 전체 원문 prompt와 `$CODEX_HOME/generated_images` 원본 파일 경로를 sidecar에 기록했습니다.

| 자산 | SHA256 |
| --- | --- |
| service-ondo-first-cup.webp | af0a901fe48bdcd33dbb86775c0a51511513a1785abf89b6c7a06a68a9e01149 |
| service-ondo-course-works.webp | 1750e5fa0fd3027892798cfb37e9551151faef65f326b982c0c31934a04ce624 |

Impeccable `embed-prompt`는 두 WebP에 대해 sidecar fallback을 사용했습니다. `embed-prompt --scan onepages/assets/correction` 결과는 15 rasters / 0 missing입니다. 이 결과는 픽셀 파일 내부 메타데이터 증명이 아닙니다. RIFF를 직접 읽은 결과 두 파일은 VP8 청크만 있고 EXIF/XMP가 없습니다. 따라서 `embeddedPrompt:false`, `promptStorage:sidecar`로 기록했습니다. 75개 asset 파일·sidecar·registry의 SHA가 모두 일치합니다.

자가 검수: PHP 문법·styles:check·diff check 통과. 로컬 소스 렌더 1440/390 × light/dark × 3단계 12상태에서 active 0/1/2, visible panel 1, 가로 넘침 0을 확인했습니다. PC/모바일 원본 캡처를 실제로 열어 사진/선택 상태/완성물/시안 표시와 한글 줄바꿈을 확인했습니다. 프로젝트 모바일 light/dark hero 원본 캡처에서 캡션 가독성을 확인했습니다. 소스 raw CSS 캐시가 남았던 초기 캡처는 폐기하고 `?sol-review=2/3`으로 새 소스를 수집하여 확인했습니다.

증거: `output/seven-onepages-20260929/review-final-services-{1440,390}-{light,dark}-{0,1,2}.png`, `review-final-projects-mobile-{light,dark}.png`, `review-embed-scan.txt`. 이는 로컬 source 자가 확인이며 root의 새 G5 배포·독립 Sol 재검수를 대체하지 않습니다. 기획/시안과 실제 예약 기능을 구분하는 G11도 독립 재검수 대상으로 남깁니다.

이번 source/asset/sidecar/registry 동결: 2026-09-29 11:34 KST. 이후 변경은 root의 명시적인 교정 지시가 있을 때만 진행합니다.
