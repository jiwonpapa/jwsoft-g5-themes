# F1–F3 한 묶음 교정 결과 — 2026-09-29

구현: 지정 Astra/xhigh. 원본 동결 **2026-09-29 11:42:31 KST / 02:42:31Z**. 독립 Sol의 1회 수정 기회에 따른 교정이며, 아래 source 렌더는 실제 G5 재배포·독립 승인 증거를 대신하지 않습니다.

## 교정 결과

| 검토 항목 | 반영한 내용 | 보존 범위 |
| --- | --- | --- |
| F1 / M1-01 | E1 크기 판단·E2 재료 이해가 P1 제품 명세·P2 관리 안내로 분기하고, 두 자료가 발행 콘텐츠로 합류하는 관계도. Ø82×H88mm/280ml 치수 도해와 실제 세척·온도·보관 정보를 포함. 운영 담당·발행 주기가 미정인 알림 기능은 선행 조건과 연결된 보류 위치에 배치 | 전략 섹션 밖은 변경하지 않음. 기존 결과 자료 3종과 버튼·스크롤 hook 유지 |
| F2 / M2-01 | 1800px 이상에서 첫 ORBIT 사진을 원본 3:2 비율과 contain으로 표시. 1920·2560 모두 807.3125×538.203125px로 좌측 ORBIT 제목/문서 경계를 보존 | 다른 슬라이드와 copy/image gap, 기존 제어 유지 |
| F3 / M2-02 | 기대 효과/실행 부담의 올바른 두 축과 공간 관계 유지. 각 영역에 서비스 비교 지면, 도구→권한→교육 의존 사슬, 문구 전후, 전체 페이지 범위 관계를 배치. 관찰 E1/E2/E3·03→01 보조 관계·두 검증 지면을 연결 | 우측 관찰→비교→선택 자료와 고유 인계 도서 유지. 오른쪽 자료가 새 왼쪽 높이만큼 빈 상자로 늘어나지 않도록 enhanced 상태에서 고유 높이+sticky 사용 |

[구현 전 디자인 카드](../plans/seven-correction-boards-sol-2026-09-29.md)와 [실제 벡터·내용을 넣은 기준 화면](../prototypes/seven-boards-sol-20260929.html)을 먼저 작성했습니다. ATELIER 사진이나 기존 사진 수를 새 보드의 품질 증거로 사용하지 않았습니다.

## 정확한 제품 파일

- `src/php/index_1.php`, `src/php/index.php`, `src/php/mobile/index.php` — 전략 섹션 동일 복사. 해당 section SHA-256 세 파일 모두 `badd1b4985a85764e3eeb33a3a055b03487737e5dcfd3c0374a780f716b29858`.
- `src/php/index_2.php` — 우선순위 자료 영역.
- `src/styles/home-one.css`, `src/styles/home-2.css` — 교체한 이전 도식 규칙 제거, 새 도해·반응형·wide 비율 스타일.
- `src/assets/main-one/decision-logic.svg`, `decision-logic-mobile.svg` 및 각 `.json` sidecar.
- `src/assets/images/home2-correction/priority-evidence.svg`, `priority-evidence-mobile.svg` 및 각 `.json` sidecar.

TypeScript·공유 token·원장·자산 사진 registry·generated/theme 파일은 이번 교정에서 수정하지 않았습니다.

## 벡터 출처와 빌드 경계

네 SVG는 직접 작성한 고유 벡터 기하·관계도 원본입니다. ImageGen 래스터나 제3자 그림이 아니며, 래스터 개수/owner 등록으로 우회하지 않습니다. sidecar에는 `kind: vector-diagram`, `source: JW SOFT authored vector geometry`, 작성 방식·소유 페이지·날짜·SHA-256·`LicenseRef-JWSOFT`를 남겼습니다. 실제 PHP는 해당 그림의 기하를 직접 포함하고 사이트 스타일은 `src/styles/`의 의미 색을 사용합니다.

현재 `build-payload.ts`의 main-one은 WebP 명시 목록이므로 decision-logic 두 SVG는 자동 복사되지 않습니다. root가 두 파일의 명시 복사를 반영합니다. priority-evidence 두 SVG는 이미 `home2-correction` 재귀 복사 대상입니다. 네 SVG 모두 원본 벡터로 manifest 분류가 필요하다고 root에 전달했습니다. 빌드 스크립트는 root만 수정합니다.

## 자체 확인과 남은 범위

- PHP 4개 문법, `styles:check`, `typecheck`, `structure:check`, 소유 파일 `git diff --check`: 통과.
- 원본 section·CSS를 현재 payload의 동일 로컬 자산과 조합한 렌더에서 Main1/2 × 1440/390 × light/dark의 8장: 가로 넘침 0, 각 폭의 올바른 SVG 1개 표시.
- source 렌더 위치: `output/seven-sol-boards-20260929/source-main{1,2}-{1440,390}-{light,dark}.png`. `source-main2-1920-hero.png`, `source-main2-2560-hero.png`에서 제목/문서 왼쪽 보존을 원본폭으로 확인했습니다.
- 처음 로컬 미리보기에서 원격 폰트/모듈이 CORS로 차단되어, 같은 payload의 로컬 자산 경로로 바로잡은 뒤 다시 확인했습니다. 이 초기 실패를 G5 페이지 오류로 집계하지 않았습니다.
- SVG의 muted fill은 존재하지 않는 legacy CSS 변수에 기대지 않고 base-content/base-100 의미 색 혼합으로 보정했습니다. 최종 라이트·다크 그림을 직접 열어 확인했습니다.
- 기존 M1 `[data-jw-decision-select]` 3버튼과 결과 3개, M2 `[data-priority-label]` 3단계가 유지됩니다. PHP의 data-jw-decision은 관계도의 현재 강조와 같은 결과를 선택하는 실제 버튼으로 이동했습니다. 검사 수를 속이는 추가 숨김 항목은 없습니다.
- root가 새 digest로 전체 빌드·개발 반영·최신 28 IAB/동작 증거를 수집하고 Sol이 F1–F3을 재판정합니다. 상품 전체 또는 판매 ZIP 완료로 확장하지 않습니다.
