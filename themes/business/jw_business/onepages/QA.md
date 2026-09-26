# 원페이지 작성본 검증 — 2026-09-22

후속 사용자 지시로 개발 사이트 배포·메뉴 추가와 실제 G5 확인을 수행했습니다. 아래는 작성 단계의 검증 이력이며, 현재 배포 상태는 [배포 보고서](../../../../docs/reports/JW-BUSINESS-ONEPAGES-DEPLOY-2026-09-22.md)를 따릅니다.

## 완료 범위

| 구분 | 결과 |
| --- | --- |
| PHP 3종 문법·독립 엔트리·G5 head/tail 계약 | 통과 |
| fixture HTML 생성·중복 ID·내부 앵커·이미지/스크립트 참조 | 통과 |
| JavaScript 문법·CSS/JS 용량·전용 CSS 이름공간 계약 | 통과 |
| Blender 시퀀스 | 36장, 960×640, 합계 551.6KiB |
| 자동 계약 검사 | `node harness/jw-onepages/check.mjs` 14건 통과 |
| 첫 화면 | 3종 각각 PC 1440×1000 / 모바일 390×844, 가로 넘침 없음 |
| 쇼케이스 | 스크롤에 따라 canvas frame 33→36 등 변경, 정지 버튼 상태 변경, 방향키 탭 전환 확인 |
| 서비스 | FAQ 내용 펼침과 고정 목차 확인, jw-dark 화면 확인 |
| 프로젝트 | 다음 버튼으로 1→2, End 키로 3/3 도달, 마지막 다음 버튼 비활성 확인 |
| 동작 줄이기 | 대표 이미지 표시, canvas 숨김, 긴 회전 구간 비활성 확인 |
| 모바일 | 대표 이미지와 기본 내용 유지 확인 |
| 프레임 실패 | `node-017.webp` 요청을 브라우저 개발 도구에서 차단하여 정적 대체 확인; 시험 후 차단 해제 |
| JavaScript 없음 | 실행을 꺼서 3개 상세 패널 모두 보임·탭 컨트롤 숨김·대표 이미지 유지 확인; 시험 후 복구 |
| 경고용 디자인 감지 | 한 차례 실행, 결과 `[]` |

자료 요청 차단·화면 크기·동작 줄이기·스크립트 비활성은 테스트 탭에만 적용했으며 시험 후 복구합니다. 데이터 절약 설정은 코드 분기를 확인했으나 실제 단말의 해당 모드에서는 시험하지 않았습니다.

## 독립 마감 검토

impeccable finish reviewer의 최초 판정은 `fix`였습니다.

1. AI 제품 사진과 Blender 모델의 형태 불일치 → 대표/상세/회전을 동일 Blender 모델로 통일.
2. 탐색 화살표의 Unicode glyph → 자체 SVG로 교체.

같은 PC·모바일 크기에서 다시 캡처했고, 재검토에서 두 항목 모두 `resolved`, 해당 수정 범위의 판정은 `ship`입니다. 전체 실제 G5 런타임 승인이라는 의미는 아닙니다.

캡처: 저장소 `.impeccable/review/onepages/`의 `showcase-desktop.png`, `showcase-mobile.png`, `services-desktop.png`, `services-mobile.png`, `projects-desktop.png`, `projects-mobile.png`, `showcase-rotation.png`, `projects-gallery.png`, `services-dark.png`.

## 미실행 및 남은 연결 검증

실제 G5 DB·회원 상태·게시판 권한, PC/모바일 실제 공통 shell, Youngcart, 외부 브라우저/실제 폰 전체 조합, 고객 ZIP 설치·업데이트·롤백, Ubuntu 및 운영 배포는 검증하지 않았습니다. 로컬 fixture 검증을 이들 결과로 대신 보고하지 않습니다.

기존 메뉴·홈·공용 CSS/JS·빌드 manifest는 변경하지 않았습니다. 내부 목차만 포함된 작성본으로 보관하며, 등록과 배포는 다음 사용자 지시를 기다립니다.
