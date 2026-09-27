# 메인 4 개선·재감사 — 2026-09-27

**메인 4를 이미지·아이콘·실제 결과물 중심의 9개 섹션으로 다시 구성하고 사무실 Ubuntu에 반영했습니다. 메인 4의 시각 재검수는 통과했으며 전체 테마의 판매 승인은 아닙니다.**

실제 페이지: [메인 4 · 과정과 산출물](https://g5themes.test/theme/jw_business/index_4.php)

## 바뀐 결과

기존 화면은 사진 없이 큰 제목과 설명문으로 산출물을 대신했습니다. 이번에는 FORME라는 가상 보태니컬 브랜드 프로젝트를 따라, 각 단계에서 무엇을 만드는지 눈으로 확인하도록 바꿨습니다.

| 구간 | 적용한 표현 |
| --- | --- |
| 첫 화면 | 전용 제품 사진 + 간결한 제목 + 과정/문의 행동 |
| 과정 안내 | 제목 위 중앙 Lucide 대형 아이콘 4개, PC 80px·모바일 60px |
| 발견 | 디자이너 작업 사진 + 관찰/목표 메모 + 인사이트 관계도 |
| 설계 | 네 접점의 아이콘 고객 여정도, 모바일에서는 세로 연결 |
| 디지털 제작 | 전용 캠페인 사진을 담은 실제 HTML 웹사이트 시안 |
| 브랜드 제작 | 패키지·가이드북 사진 + 로고·컬러 견본 |
| 인계 | 파일 유형을 구분한 아이콘 전달물 카드 |
| FAQ | 펼쳐 읽는 질문 4개 |
| 문의 | 큰 아이콘과 최종 문의 행동 |

사진 4장은 이 페이지를 위해 생성했습니다. 다른 페이지의 사진은 사용하지 않았습니다. 패키지 외형을 맞추기 위해 디지털 캠페인 생성에 커버를 참조했으며, 복사한 사진이 아닌 새 장면입니다. 자산 소유·원본 계열·SHA-256·생성 프롬프트를 기록했습니다.

## 실제 화면에서 발견하고 수정한 것

1. 웹 시안의 사진 상단에서 제품 펌프가 잘리는 크롭을 수정했습니다.
2. 다크 모드의 기본 primary가 아이콘·작은 글자에 어두워, 기존 semantic token의 혼합으로 대비를 높였습니다.
3. 모바일에서 숨긴 줄바꿈 때문에 붙던 단어와 작은 카드 라벨을 정리했습니다.
4. 제목 위의 중복 보조 문구 3개를 제거했습니다. 실제 단계 표시는 유지했습니다.
5. 테마 전환 때 공용 Lucide 초기화가 메인 4 아이콘까지 다시 처리하던 경고를 수정했습니다. 페이지 아이콘의 소유 범위를 분리했고 전환 후 경고·오류가 없습니다.
6. 전체 캡처 중 사진 일부가 비거나 메뉴가 겹친 증거는 폐기하고 다시 수집했습니다. 실제 모바일 사진은 정상임을 별도 화면과 좌표로 확인했습니다. 최종 자료는 전체 폭과 좌우 여백까지 독립 재검수했습니다.

## 재감사 결과

- 실제 G5의 1440px PC·390px 모바일에서 라이트/다크 전체 페이지를 확인했습니다. 768px·320px 추가 검사에서도 가로 넘침은 0입니다.
- 과정 카드 4개의 제목·설명·하단 링크 기준선이 일치합니다. 발견의 관찰/목표 제목도 같은 문서 Y 좌표로 정렬됩니다.
- 아이콘 hover 회전을 실제 브라우저에서 확인했습니다. 제목 transform은 `none`입니다. 줄인 동작 설정에서는 회전·등장 애니메이션이 없어지고 콘텐츠는 그대로 표시됩니다.
- FAQ 펼침, 과정 앵커 이동, 모바일 메뉴의 모드 전환을 확인했습니다. 메인 4 사진 4장과 아이콘 50개가 표시됩니다.
- 독립 finish reviewer `/root/main4_finish_reviewer`의 최종 판정은 **ship**입니다. 사진 띠·메뉴 겹침·좌우 잘림 해소와 카드 정렬, 모바일·다크 가독성을 확인했으며 남은 시각 수정 지적은 없습니다. 이 판정의 범위는 메인 4 화면입니다.

최종 증거:

- [PC 라이트 전체](../../themes/business/jw_business/quality/evidence/main4-20260927/desktop-light.png) · [PC 다크 전체](../../themes/business/jw_business/quality/evidence/main4-20260927/desktop-dark.png)
- [모바일 라이트 전체](../../themes/business/jw_business/quality/evidence/main4-20260927/mobile-light.png) · [모바일 다크 전체](../../themes/business/jw_business/quality/evidence/main4-20260927/mobile-dark.png)
- [수정 전](../../themes/business/jw_business/quality/evidence/main4-20260927/before-desktop.jpg) · [캡처 메타데이터](../../themes/business/jw_business/quality/evidence/main4-20260927/manifest.json)

## 구현·배포 검증

Tailwind 4/Vite 빌드, daisyUI semantic token, Pretendard, Lucide, Motion 스택을 유지합니다. Main 4 스타일·스크립트는 `home-four.min.css/js`로 분리하고 해당 페이지에서만 불러옵니다. 공유 라이브러리 분리로 다른 entry의 import 경로도 재생성됐으나 다른 메인의 PHP·디자인은 바꾸지 않았습니다. 사이트 UI는 라이트/다크를 따르며 FORME 작품 견본의 고유 색은 사진처럼 유지합니다.

`build`, `structure:check`, `typecheck`, `tokens:check`, `check:build`, `contracts:check`, 테마 회귀 **64개**, 서버 PHP lint, `git diff --check`를 확인했습니다. 배포 파일은 checksum 기반 rsync dry-run으로 내용 차이 없음을 확인했습니다.

- 개발 서버: 사무실 Ubuntu `g5themes.test`
- 배포 범위: 메인 4 PHP·전용 사진·빌드 CSS/JS와 공유 chunk
- 복구 백업: `/home/neojins/services/g5themes-test/backups/main4-redesign-20260927/before.tgz`
- 고객의 테마 실행에 Node/Bun 설치는 필요하지 않습니다. [편집 안내](../../themes/business/jw_business/docs/MAIN-4-EDITING.md)와 [실제 디자인 계약](../../themes/business/jw_business/docs/MAIN-4-DESIGN.md)을 작성했습니다.

## 남은 상품 차단

`quality:check`는 전체 작성 23종을 검사하고 **실패**합니다. `DESIGN_NOT_READY` 21, `REQUIRED_CONTENT` 2, `REVIEW_MISSING_OR_INVALID` 6, `REPEATED_OPENING` 1, `PHOTO_REUSE` 3, `PHOTO_OWNER` 3입니다. 메인 4 자체의 콘텐츠·사진 검사는 통과하지만 홈 전체 4종의 비교 승인 기록은 충족되지 않았습니다. [원본 검사 결과](../../themes/business/jw_business/quality/evidence/main4-20260927/quality-check.json)

메인 4의 `ready`는 첫 화면·9개 섹션·실제 사진을 구체화하고 구현한 설계 상태를 반영합니다. 전체 품질 gate를 우회하거나 홈 묶음 승인으로 바꾸지 않았습니다. ZIP 설치·업데이트·롤백, 기본 index로 복사한 설치 상태, 로그인별 공용 기능 검사는 이번 시각 개선 범위에서 실행하지 않았습니다.

**판정: 메인 4에서 지적된 텍스트 편중·빈약한 산출물·아이콘 부재·정렬 문제는 개선됐습니다. 다른 6종의 방향은 형님이 이 화면을 확인하신 뒤 결정합니다.**
