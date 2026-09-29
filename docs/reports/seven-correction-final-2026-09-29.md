# 메인 7종 개선·재검수 보고 — 2026-09-29

**7종 개선과 사무실 Ubuntu 반영은 실행했습니다. 메인2의 초광폭 정렬이 미달이므로 7종 시각 교정 완료·판매 승인은 아닙니다.** 자동 검사를 통과한 사실로 이 판정을 덮지 않습니다.

## 구현 결과

| 페이지 | 주요 변경 | 확인한 선택 이유 |
|---|---|---|
| 메인1 | 전략의 근거·분기·합류 보드, ATELIER PC/모바일 시안, 일정 자료, 후반 문의 흐름 | 여러 업종과 매체를 보여 주는 기업형. 3장 히어로·12개 섹션과 기본/모바일 인덱스 유지 |
| 메인2 | ORBIT 판단 자료, 효과/부담 매트릭스의 실제 비교 자료, 인계 도서, 3장 히어로 | 컨설팅 의사결정형. **2560px 디지털·운영 슬라이드의 우측 쏠림 미해결** |
| 메인3 | 안내 동선 A/B/C와 실제 사인, 인쇄·웹의 서로 다른 결과물, 제목 충돌 교정 | 매체별 작업을 고르는 포트폴리오형 |
| 메인4 | FORME 브리프→제품 비교→패키지 자료 전환, 과정/인계 표현 분리 | 하나의 브랜드 과정을 따라가는 사례형 |
| 제품형 | 같은 Blender 모델의 대표 이미지·접사·생활 컷·설치 그림·60개 회전 프레임 | 제품의 재료·형태·배치를 읽는 쇼케이스. 11개 섹션 |
| 서비스형 | ONDO 실자산 목업, 발견→비교→방문 준비 전환, 탐색·인계 시안, 후반 경계 | 실제 서비스 여정과 남는 자료를 보여 주는 회사형. 12개 섹션 |
| 프로젝트형 | 3장 히어로·5장 갤러리 보존, 사진과 연결한 개념평면, 재료판·설계 도서 | 공간 경험과 설계 자료를 보여 주는 프로젝트형. 12개 섹션 |

새 래스터·갱신 프레임 82개는 원본 SHA·소유 페이지·출처 기록과 대조했습니다. 이미지·프레임을 새 이름으로 복사해 중복을 회피하지 않았습니다. 메인1·2 관계도는 별도 PC/모바일 SVG이며 실제 근거와 관계를 담습니다.

Tailwind 4·daisyUI 5·DTCG 토큰, Motion·Embla·Lucide와 G5의 페이지별 책임을 유지했습니다. 생성 CSS/JS·payload는 원본에서 빌드했습니다. 고객 서버에 Bun·Node·Blender를 요구하지 않습니다. 실제 예약·판매 기능을 새로 구현한 것처럼 표시하지 않았습니다.

## 재검수와 증거

- 구현: GPT-6 Astra / xhigh의 세 작업. 독립 검토: GPT-6 Sol / xhigh `/root/impeccable_finish_reviewer_20260929`.
- 내장 브라우저: 1440×1000·390×844 × 라이트/다크 × 7종의 28개 전체 흐름을 순차 탐색했습니다. 원본 화면과 섹션별 자료를 대조했습니다.
- 자동 UI: 7종 × 8개 폭/모드 상태 **56건 통과**. 추가 360/430px 위험 폭 14상태도 수집했습니다.
- 강조 장면: 6페이지 × PC 스크롤/모바일 키보드/reduced motion의 18개 환경에서 시작·중간·끝 54상태. 제품 회전·fallback은 별도 8기록입니다.
- 실제 IAB 추가 조작: AURA 0/90/180/270도, 제품 3탭, 프로젝트 히어로 3장·갤러리 5장, 메인2 2560px 세 장면, 기본 인덱스 PC/모바일.
- 마지막 발견 결함: 프로젝트 슬라이드가 정지 후 다른 섹션 이동/마우스 이탈로 재개되던 문제를 고쳤습니다. 실제 Embla 회귀 2건, 실제 G5 PC·모바일 8.2초 정지 유지·재생 복귀·키보드·reduced motion을 확인했습니다. IAB에서도 26초 후 정지 유지 확인을 남겼습니다.
- 기존 9쌍과 묶음 간 12쌍, 합계 21쌍은 [독립 검토](seven-independent-review-revision-2-2026-09-29.md)에 있습니다. 목적·자료·구성의 차별성과 화면 완성도는 별도로 판정했습니다.

[최종 증거 설명](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/README.md) · [내장 브라우저 28상태](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/iab/manifest.json) · [수정 원장](../plans/JW-BUSINESS-MAIN-SEVEN-CORRECTION-LEDGER-2026-09-29.json)

최종 원본 digest는 `609ca656197948ad78fe9b782faa7e391b70defe57249f559c272ce0ee0ba010`입니다. `quality/reviews`의 schema v2에는 각 묶음의 groupDigest가 들어가므로 전체 digest와 값이 다릅니다. 자동 캡처 메타데이터·동작 수집·배포 checksum은 전체 digest와 대조했습니다.

IAB 수집기는 REPL closure에 이전 출력 폴더가 남아 새 최종 캡처를 그곳에 썼습니다. 실제 동결 이후 시각의 28기록과 PNG 원본을 최종 폴더에 옮겨 정리했으며, [기록](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/iab/collection-path-note.md)을 남겼습니다. 덮인 과거 IAB 파일을 이전 revision의 원본 증거로 주장하지 않습니다.

## 미완료와 다음 교정 단위

메인2의 2560px 슬라이드 2·3은 글자 침범과 버튼 정렬이 나아졌지만, 내용 전체의 시각 중심이 오른쪽으로 치우칩니다. **G02·M2-01을 미해결로 남깁니다.** 공통 CSS 숫자를 덧대는 재작업 대신 메인2 히어로 세 장면을 하나의 명시적 2열 구도로 다시 정하고 1440/1920/2560의 좌우 경계를 같은 기준으로 검토하는 것이 다음 단위입니다. 다른 6종이나 새 메뉴로 범위를 넓힐 이유는 없습니다.

[미해결 실제 화면](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/iab/main2-wide-2.png)

다른 메뉴의 기존 사진 3종 재사용·소유 오류는 이번 범위 밖입니다. `home-hero.webp`, `home-collaboration.webp`, `home-project.webp`의 글로벌 차단을 예외 처리하거나 소유 기록만 바꾸지 않았습니다. 상품 전체·ZIP 설치/업데이트/롤백·로그인/게시판 전체 승인은 이번 검수 범위가 아닙니다.

## 기술 검증·배포

- `foundation:check`, `styles:check`, `stack:check`: 통과.
- `ui:check`: 56/56 통과. 필수 interaction 수집 40건, 회전 8건 통과.
- 깨끗한 별도 checkout `8403e2a`: frozen install → theme build → `generated:check` 모두 통과. [기록](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/logs/generated-check.log)
- 사무실 Ubuntu `g5themes.test`에 빌드 자산을 반영했고, 15개 동기화 대상의 checksum 차이 0건. [기록](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/deployment-checksums.json)
- 최종 품질 gate 결과와 원장 집계는 아래 마감 기록에 추가합니다. 실패는 삭제하거나 경고로 낮추지 않습니다.

## 커밋

- `0daa581`: 메인 4종 시각 자료·구도·전환.
- `0fa5ea4`: 원페이지 3종·AURA 렌더·일시 정지 회귀.
- `8403e2a`: 빌드 자산·자산 등록·동작 증거 수집기.
- 검토·원장·최종 증거는 별도 후속 커밋입니다. 기존 사용자 변경은 포함하지 않았습니다.

## 최종 마감 집계

- 원장 42개: **verified 40 / blocked 2** (`G02`, `M2-01`). 신규 `PJ-05` 모바일 히어로 대비와 `PJ-06` 정지 유지 결함은 검증했습니다.
- 독립 시각 판정: 6종 `ship-candidate`, 메인2 `fix`. 이는 정해둔 최소 시각 기준에 대한 판단이며 고객 구매·판매 성과를 보장하는 점수가 아닙니다.
- `quality:check`: **31건 실패**. 다른 메뉴의 설계 미준비 16, 필수 콘텐츠 2, 검토 누락/무효 4, 도입 반복 1, 전역 사진 재사용/소유 6, 이번 home 검토 실패 2입니다.
- `quality:complete home`: **8건 실패** — 독립 검토 미통과와 메인2 구성 거절 2건 + 범위 밖 사진 오류 6건.
- `quality:complete onepage`: **선행 home 미통과로 차단**. 원페이지 3종의 독립 시각 검토가 통과해도 이 순서를 우회하지 않습니다.
- [실제 품질 검사 결과](../../themes/business/jw_business/quality/evidence/seven-correction-20260929/revision-2/quality-results.json)

따라서 이번 결과는 **7종 개선·배포·재검수 실행, 메인2 정렬 보류**입니다. “모두 판매 가능”, “7종 최종 완료”, “전체 상품 승인”으로 보고하지 않습니다.
