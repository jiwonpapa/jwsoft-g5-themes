# 메인 7종 교정 인계 — 2026-09-28

메인 1–4와 제품·서비스·공간 원페이지의 정렬·제목·콘텐츠·제품 회전을 교정하고, 후속 AURA 재질 수정까지 사무실 Ubuntu `g5themes.test`에 반영했습니다. **이번 7개 공개 화면의 독립 검토 최종 판정은 `ship`입니다. 전체 품질 gate와 메인 묶음 완료 gate는 여전히 실패입니다.** 자동 검사·개발 반영·한정된 화면 판정을 상품 전체 승인으로 사용하지 않습니다.

독립 검토자 `correction_finish_reviewer`는 최종 회전 이미지 13장(PC·모바일 10변형과 정면·후면·되돌림 3장)을 다시 열어 AURA 월넛 R1을 해소로 판정했습니다. 실제 검토 시각은 `2026-09-28T04:52:10+00:00`이며, 7페이지의 목적·이미지·구성 **21항목 pass**, 9쌍 차별성 **9항목 pass**, `material_fixes`는 빈 목록입니다. [독립 검토 문서](MAIN-SEVEN-CORRECTION-INDEPENDENT-REVIEW-2026-09-28.md)의 마지막 `verdict`·`remaining`·`disposition: ship`과 [판정 JSON](MAIN-SEVEN-CORRECTION-INDEPENDENT-REVIEW-2026-09-28.json)이 최종 근거입니다. 첫 `fix` 판정과 `initialReview`는 이력으로 보존됐습니다.

최초 빈 포스터는 decode/paint 이전 수집 문제로 확인되어 영구 화면 결함 판단이 철회됐고, 다크 그림자 사각 경계와 장식 라벨은 교정 뒤 검토에서 해소됐습니다. 최종 검토의 범위와 열람 한계는 독립 문서에 유지되어 있으며, 40개 상호작용 개별 이미지를 전수 정독하거나 검토자가 직접 재실행한 승인으로 확대하지 않습니다.

## 범위와 원인

- 대상은 `src/php/index_1.php`–`index_4.php`와 `pages/onepage-showcase.php`, `onepage-services.php`, `onepage-projects.php`의 **비회원 공개 화면 7종**입니다. 기본·모바일 인덱스는 기존 홈 연결을 유지합니다.
- 메인 2의 사진과 제목은 서로 다른 좌표 기준으로 배치되어 넓은 화면의 중심축과 중간 폭의 간격이 어긋났습니다. 제목만 줄이거나 사진 위치만 이동하는 보정 대신 동일한 중앙 그리드로 묶었습니다.
- 메인 2 CTA는 버튼 자체에 inline flex와 수직 중앙 정렬이 없어 문자와 화살표가 같은 축에 놓이지 않았습니다. 버튼에 정렬 규칙을 직접 부여했습니다.
- 메인 1·3의 큰 제목은 시각 자료와 본문 흐름을 압도했습니다. 페이지별 제목 크기를 낮췄으며, 공통 타이포그래피 토큰을 일괄 축소하지 않았습니다.
- 제품 교체 요구를 회전 효과 삭제로 해석하지 않습니다. AURA의 월넛·패브릭·메탈 제품 형태를 직접 작성한 Blender 모형과 60개 각도로 연결했습니다.

방향 계약은 [교정 brief](MAIN-SEVEN-CORRECTION-BRIEF-2026-09-28.md)입니다. 원래 사용자 변경을 포함한 다른 페이지·전역 문서의 작업 트리는 별도 범위이며, 이 문서화 작업은 이 인계 파일만 작성했습니다.

## 실제 변경

| 대상 | 현재 원본의 변경 |
| --- | --- |
| 메인 1 | 전폭 사진을 유지하고 제목·슬라이더 제어 및 주요 본문에 1440px 중앙 독해축을 적용했습니다. 히어로 제목은 최대 91→72px, 모바일 최대 60→48px로 조정했습니다. 주요 본문 제목도 페이지별 54–60px 수준으로 낮췄습니다. 후속 검토에서 히어로 3장의 장식 주제 라벨을 제거했습니다. |
| 메인 2 | 최대 1440px 안에 `0.9fr / 1.1fr` 두 열과 `clamp(32px, 4vw, 72px)` 간격을 두었습니다. 800px 이하에서는 제목 다음 사진의 한 열로 전환합니다. 히어로 제목은 `clamp(40px, 3.5vw, 60px)`이며 좁은 폭에 별도 규칙을 둡니다. CTA는 Tailwind inline flex·items-center·justify-center, 12px 간격과 48px 최소 높이를 사용합니다. |
| 메인 3 | 히어로 제목 최대 112→76px, 행간 1.03→1.15로 조정했습니다. 모바일 최대 76→54px, 사례·마무리 제목 최대 70–72→56px로 조정했습니다. 후속 검토에서 사례 위의 번호·영문 장식 kicker 3개를 제거했습니다. |
| 메인 4 | 이번 교정을 이유로 구도나 CTA를 다시 설계하지 않았습니다. 기존 페이지를 함께 수집하고 회귀 확인 범위에 포함했습니다. |
| 제품 원페이지 | 브랜드 소개, 입체 회전, 처음 설치·관리 안내를 보완해 본문 최상위 섹션 11개로 구성했습니다. 제품 상세 탭의 하위 `<section>` 3개는 독립 섹션 수에 더하지 않습니다. |
| 서비스 원페이지 | 팀 작업 사진과 역할 소개, 진행 로드맵, 협업 범위 표를 보완해 12개 섹션으로 구성했습니다. 회사·제공 범위·설계 자료·과정·결과물·FAQ·문의가 이어집니다. |
| 공간 원페이지 | 스튜디오·모형 검토 사진, 업무 분야, 진행 절차, 도면·재료·인계 자료를 보완해 12개 섹션으로 구성했습니다. 공간 사례와 갤러리의 기존 역할을 유지합니다. |

레이아웃·제목 원본은 `src/styles/home-one.css`, `home-2.css`, `home-variants.css`입니다. 원페이지 본문은 각 완성형 PHP, 스타일은 `src/styles/onepages.css`, 동작은 `src/scripts/onepages.js`와 `onepages-entry.ts`가 소유합니다. `theme/`의 CSS·JS·이미지는 Vite와 payload 빌드 산출물입니다.

## AURA 회전과 자산 출처

- 편집 가능한 제작 원본은 [render-aura.py](../onepages/design/render-aura.py)와 [aura-concept.blend](../onepages/design/aura-concept.blend)입니다. 월넛 외장, 직조 패브릭, 금속 상판·오른쪽 다이얼, 후면 연결부를 실제 입체 형상으로 작성했습니다. 히어로 제품과 형태를 맞추기 위해 초기 모형의 받침 발·왼쪽 조작부·전면 로고를 제거했습니다.
- Blender Cycles에서 1080×810 RGBA, 투명 배경으로 60개 각도를 렌더링했습니다. 후속 교정에서 바닥 mesh의 렌더를 숨겨 shadow catcher의 사각 경계를 제거했습니다. `onepages/assets/sequence/aura-001.webp`–`aura-060.webp`는 최종 합계 **1,655,958 bytes**의 WebP 배포 프레임입니다. 평면 사진에 CSS 회전을 적용한 효과가 아닙니다.
- 남은 월넛 재질 R1을 교정하기 위해 OpenAI 이미지 생성으로 [aura-walnut-albedo.png](../onepages/design/aura-walnut-albedo.png)를 제작하고, 불규칙한 목재 결·무광 거칠기·미세 요철을 Blender 재질에 연결했습니다. [texture 출처 파일](../onepages/design/aura-walnut-albedo.png.json)에 전체 프롬프트·도구·작성자·라이선스를 기록했으며, `.blend`에는 texture를 pack했습니다. 제품 형상과 렌더는 직접 작성한 Blender 원본이고, 생성형 이미지 사용 범위는 재질 texture입니다.
- Motion `inView`·`scroll`이 데스크톱의 프레임 준비와 스크롤 회전을 담당합니다. 명시적 자동 회전 토글과 native range의 키보드 조작을 제공합니다. 모바일·동작 줄이기에서는 정적 배치와 수동 각도 선택을 사용합니다. 수동 전환만으로 준비된 스크롤 영역 높이가 축소되지 않도록 상태를 나눴습니다.
- 프레임 로드는 동시 4개로 제한하며 decode 실패 시 현재 이미지와 안내 문구를 유지합니다. 기본 poster에 `decoding="sync"`를 부여하고, 수집기는 이미지 decode와 100ms paint 대기 후 캡처하도록 교정했습니다. 검토자는 새 PC·모바일 실패 상태의 poster를 직접 확인해 최초 blank를 수집 시점 문제로 분리했습니다. 첫 프레임 `filemtime` 기반 query를 poster와 후속 프레임 URL에 함께 적용하고, 페이지 CSS·JS에도 버전 URL을 사용해 이전 자산 cache와 새 배포의 혼합을 줄였습니다.
- AURA 60프레임마다 `.webp.json` 출처 파일이 존재합니다. 제작 도구, JW SOFT 작성자, Python·packed Blender 원본, walnut texture 경로, 프레임·각도, 바닥 없는 투명 배경, 생성 재질을 포함한 라이선스가 기록돼 있습니다. `ASSET-MANIFEST.json`과 `quality/assets.json`에도 자산과 사용 범위를 기록했습니다.
- `service-studio.webp`와 `space-studio.webp`는 각 페이지용으로 생성한 별도 데모 사진입니다. 두 출처 파일에 생성 프롬프트·도구·작성자·라이선스와 가상 팀이라는 성격을 기록했습니다. 실제 고객사나 실제 팀의 실적으로 해석하지 않습니다.
- `scripts/build-payload.ts`는 AURA 프레임만 설치 payload에 복사합니다. `scripts/check-build.ts`는 60프레임 존재와 폐기한 NODE 시퀀스·포스터의 payload 제외를 검사합니다. 현재 payload에서 AURA 60개와 NODE 0개를 확인했습니다. Blender·Python·JSON 출처 원본을 고객 런타임 의존성으로 추가하지 않습니다.
- `provenance.log`의 전체 스캔에는 기존 NODE 원본 32개의 출처 누락이 남아 있습니다. 이 로그를 출처 검사 전체 통과로 보고하지 않습니다. 해당 파일은 현재 AURA 설치 payload에서 제외되며 이번 문서화에서 기존 파일을 수선하지 않았습니다.

## 유지한 설계와 구현 경계

이번 작업은 기존 체계의 확장·교정입니다. [DESIGN.md](../DESIGN.md)와 [.impeccable/design.json](../.impeccable/design.json)은 변경하지 않았습니다.

1. **색:** daisyUI `jw-light`·`jw-dark`와 DTCG 의미 색상·content 색상 짝을 유지했습니다. AURA 재질을 전역 팔레트로 승격하지 않았습니다.
2. **글자:** 로컬 Pretendard를 유지하고 제목 크기는 각 페이지 스타일에서 조정했습니다. 이번 제목 수치를 모든 페이지의 새 display scale로 기록하지 않았습니다.
3. **레이아웃:** 공용 shell과 독립 페이지의 소유권은 유지하고, 메인 1·2의 1440px 독해축은 해당 화면의 규칙으로 제한했습니다.
4. **동작:** 기존 Tailwind 4 `tw:`·daisyUI 5 `tw:d-*`·DTCG·Vite 경로, 슬라이더의 Embla, 필요한 스크롤·등장의 Motion을 유지했습니다. 새 슬라이더·스크롤 감지 라이브러리를 도입하지 않았습니다.
5. **G5:** 완성형 PHP와 G5 네이티브 메뉴·스킨 경계를 유지했습니다. G5 코어·DB schema·`.runtime/gnuboard5`를 이번 교정 해법으로 변경하지 않았습니다. 고객 서버에 Bun·Node.js·Composer·Blender 실행을 요구하지 않습니다.

기존 문서 드리프트는 별도입니다. `PRODUCT.md`에는 과거 기반 재설계 단계와 이전 미검증 상태가 남아 있고, 이전 surface brief 후보에는 과거 `onepages/pages/` 및 제거된 `index_5.php` 대상이 남아 있습니다. 현재 화면·검증의 사실로 재사용하거나 이 작업의 부수 변경으로 고치지 않았습니다. 기존 과대 제목·장식 kicker·출처 누락·사진 재사용·렌더 경계를 새로운 디자인 규칙으로 정당화하지 않습니다. 철회된 blank 증거도 현행 화면의 결함으로 남기지 않습니다.

## 확인한 증거와 한계

`output/qa/`는 저장소 루트, `quality/`는 테마 루트 기준입니다. 아래는 이미 실행된 기록을 확인한 결과이며, 문서화 작업에서 검사를 다시 실행한 결과가 아닙니다.

| 증거 | 확인된 결과 | 판정 범위 |
| --- | --- | --- |
| `output/qa/main-seven-correction-20260928/ui-reviewed.log` | 56 passed | 장식 라벨·alpha 등 1차 검토 교정 뒤 7페이지 × 8상태. 라이트는 2560·1920·1440·1280·768·390px, 다크는 1440·390px입니다. 모든 폭의 다크를 검사했다고 확대하지 않습니다. |
| `output/qa/main-seven-correction-20260928/ui-material-final.log` | 제품 페이지 8 passed | 마지막 월넛 재질 배포 뒤 영향을 받은 제품 페이지의 같은 8상태를 새로 확인했습니다. |
| `quality/evidence/main-seven-correction-20260928/captures/` | 56개 전체 화면 PNG와 JSON | JSON의 상태는 `collected-not-approved`입니다. 메인 1·2 모든 슬라이드의 별도 캡처도 검토 자료에 포함합니다. |
| `output/qa/main-seven-correction-20260928/rotation-material-final.log` | 데스크톱·모바일 각각 normal·reduced·no-js·dark·network-failure, 총 10변형 pass | 최종 재질과 decode/paint 대기 수집기를 사용한 재수집입니다. 독립 검토자는 이 10변형과 정면·후면·되돌림 3장을 다시 열어 R1 해소와 회귀 없음을 판정했습니다. |
| `quality/evidence/main-seven-correction-20260928/rotation/manifest.json` | 8개 before/after 기록 | 스크롤/모바일 정적 대체, 키보드, 줄인 동작, JS 없음 대체 상태를 기록했습니다. |
| `output/qa/main-seven-correction-20260928/interactions-material-final.log` 및 `quality/evidence/main-seven-correction-20260928/interactions/manifest.json` | 회전 외 실제 상호작용 40개 | 최종 재질 배포 뒤 데스크톱·모바일 제어·탭·FAQ·갤러리 등을 다시 수집했습니다. 별도 manifest를 중복 합산하지 않습니다. |
| `output/qa/main-seven-correction-20260928/foundation.log` | 이전 전체 foundation pass | 최종 배포 전의 기반 검사 증거입니다. 마지막 자산·후속 수정까지 모두 다시 검사한 증거로 바꾸지 않습니다. |
| `output/qa/main-seven-correction-20260928/theme-tests-reviewed.log` | 64 pass, 0 fail, 501 assertions | 갱신된 테마 회귀 검사이며 전체 상품 품질 판정과는 별개입니다. |
| `output/qa/main-seven-correction-20260928/deploy-material-final.log` | 최종 stack·구조·타입·token/Vite/payload 빌드·배포 기록 | 마지막 월넛 재질까지 사무실 개발 환경에 반영했습니다. |
| `output/qa/main-seven-correction-20260928/deploy-hashes.json` | 234개 local/remote hash 일치, 불일치 0 | 기록된 배포 파일의 바이트 일치이며 전체 상품 기능·시각 승인이 아닙니다. |
| `quality/reviews/home.json`·`onepage.json` | 최종 독립 판정·새 캡처·상호작용 48개 등록 | 각각 28·20개 상호작용 기록과 정확한 페이지·비교 사유를 담았습니다. 독립 검토 시각과 현재 input digest를 사용하며 과거 승인을 재사용하지 않았습니다. |
| `output/qa/main-seven-correction-20260928/quality-final.log` | `quality:check` fail, 29개 | `DESIGN_NOT_READY` 16, `REQUIRED_CONTENT` 2, `REVIEW_MISSING_OR_INVALID` 4, `REPEATED_OPENING` 1, `PHOTO_REUSE` 3, `PHOTO_OWNER` 3입니다. 이번 7페이지의 시각 판정·검토·캡처·상호작용 관련 결함은 0개지만 전체 차단은 유지됩니다. |
| `output/qa/main-seven-correction-20260928/quality-home-final.log` | `quality:complete home` fail, 6개 | 다른 회사·사업 페이지에 걸친 사진 3개의 재사용·소유 위반(`PHOTO_REUSE` 3 + `PHOTO_OWNER` 3)으로 전역 차단됩니다. 메인 묶음 완료를 선언하지 않습니다. |

최신 검사 로그 10개는 `quality/evidence/main-seven-correction-20260928/checks/`에도 보관했습니다. 마지막 내장 브라우저 화면은 `output/qa/main-seven-correction-20260928/iab/product-material-final.png`이며, `quality/evidence/main-seven-correction-20260928/iab/product-material-final.png`에 영구 증거를 보관했습니다.

R1의 구현·배포·재수집·독립 재검토는 마쳤습니다. 이후 영향을 주는 source·style·image·생성물이 변경되면 해당 화면을 다시 수집하고 독립 판정을 받아야 합니다. 이전 `ship` 판정이나 기존 digest를 변경 후 승인 증거로 재사용하지 않습니다.

이 기록은 **7개 공개 템플릿의 교정·개발 반영과 해당 화면의 독립 검토 인계**입니다. 전체 테마 품질 통과, 메인 묶음 완료, 다음 묶음 착수 승인, 판매 ZIP 설치·업데이트·롤백, 로그인 상태·회원 전체 흐름, 영카트, 실물 기기, 상품 출시 승인은 포함하지 않습니다.
