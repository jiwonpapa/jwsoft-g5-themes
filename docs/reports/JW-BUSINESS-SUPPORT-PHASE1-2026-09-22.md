# JW-Business 1차 실제 개선 — FAQ·1:1 문의

2026-09-22. Enfold 비교 보고서 권장 순서 1번 중 FAQ와 1:1 문의 경로를 먼저 구현하고 기존 `g5themes.test`에 반영했다. 전체 G5 레거시 제거 완료 또는 출시 완료를 의미하지 않는다.

## 구현 결과

| 대상 | 변경 |
|---|---|
| FAQ | 구형 CSS·jQuery·viewimageresize 로딩 제거. native details/summary 질문 펼침, 검색/초기화, 분류, 결과 없음, 관리자 링크, 기존 페이징 계약 유지 |
| 문의 목록 | 새 DOM, 분류/검색, 질문 제목·작성일·답변 상태, 전체 선택·선택 삭제 |
| 문의 작성/수정 | native 입력, 일반 텍스트/HTML/줄바꿈 HTML 형식, 연락처·수신 선택, 파일 2개, 기존 파일 개별 삭제 |
| 문의 본문/답변 | 질문과 답변 구분, 첨부 표시/다운로드, 답변 수정/삭제, 추가 질문, 연관 질문, 이전/다음 링크 |
| 저장 | 비동기 금지어 검사 후 QA 전용 토큰 발급. 실패 시 제출 중지·버튼 복구·입력 유지. 중복 클릭 방지 |
| PC·모바일 | 모바일 스킨은 같은 반응형 PHP 구현을 사용. FAQ 모바일 전용 상하단 HTML 계약은 유지 |
| 색상·간격 | 기존 현대화 UI의 버튼/필드와 daisyUI 의미 색상 사용. 입력칸 넘침, 중복 여백, 방문 링크 기본 보라색을 실제 화면 확인 후 수정 |

G5 코어·DB 스키마·서버 인프라는 변경하지 않았다. PHP 원본은 `src/php`, 자산 원본은 `src/styles/support.css`와 `src/scripts/support.ts`이며 `theme/`은 빌드 결과다.

## 검증 근거

- 테마 `bun run check`: 24 tests / 130 assertions 통과. 타입 검사·토큰 검사·Vite build·payload 검사 포함.
- 대상 PHP 14개 파일: 기존 서버 PHP 8.3에서 syntax 검사 통과.
- HTTP 하네스: 실제 로그인, 문의 작성/수정, 파일 2개 업로드/다운로드/개별 삭제, 답변 작성/수정, 추가 질문/연관 질문, 모바일 스킨, 검색, 잘못된 토큰 거부, 토큰 기반 시험 데이터 정리 — 11항목 통과.
- 실제 Edge에서 FAQ 펼침, 검색 결과 1건 및 0건, 문의 직접 작성→답변 직접 등록을 조작했다.
- PC 라이트/다크 FAQ, PC 라이트 문의 작성/본문/답변, 390px 모바일 라이트/다크 FAQ·문의 작성, 모바일 라이트 본문 및 다크 답변·문의 목록을 직접 봤다. 모든 화면×모드 조합을 완전 교차 시험한 것은 아니다.
- 모바일 실측: viewport 390px, 문서 client/scroll width 375px, 문의 폼 left 14/right 361px. 확인 시 가로 넘침 없음.
- 변경 전 FAQ 오류: `jQuery is not defined` 2건 (`viewimageresize.js`, FAQ inline script). 최종 새 브라우저 탭에서 FAQ·문의 목록·작성·본문 4개 경로 탐색 후 console error 0건.
- 확인된 문의 본문 외부 script는 테마 ESM 한 개. 해당 FAQ/문의 PHP는 legacy CSS/JS를 출력하지 않는다.
- 검사 기록: `output/qa/support-2026-09-22/`. HTTP 결과의 preview URL은 자동 정리된 시험 데이터이므로 현재 열람용 URL이 아니다.

## 개발 사이트 데이터 및 확인 주소

- FAQ: https://g5themes.test/bbs/faq.php — 예시 질문 6개. 예시라는 안내 포함.
- 문의: https://g5themes.test/bbs/qalist.php
- 직접 화면 확인용 문의/답변: https://g5themes.test/bbs/qaview.php?qa_id=5 — `[화면 검증] 기업 홈페이지 제작 상담`.
- 자동 시험 문의 및 실패 실행에서 남은 하네스 소유 문의는 정리했다. 기존 사용자 데이터는 정리 대상이 아니다.
- 반영 전 백업: 서버 `backups/jw_business-before-support-20260922.tar.gz`.

## 명시적 경계와 다음 작업

- 문의의 구형 SmartEditor 출력은 사용하지 않는다. 설정이 켜져 있어도 이 테마의 문의 폼은 기본 textarea와 본문 형식 선택을 쓴다. 외부 에디터 통합은 별도 플러그인 범위다.
- 이메일/SMS 실제 발송, 실회원 간 소유권 교차 시험, FAQ 다중 분류·다중 페이지 이동, 실기기 Safari, 판매 ZIP 설치는 이번에 검증하지 않았다.
- 잔여 커뮤니티 payload의 jQuery 후보 8개: PC/모바일 poll 결과, PC outlogin, PC new, PC/모바일 member_cert_refresh, PC popular, 모바일 latest.carousel.js. 정적 잔여 후보이며 모든 항목이 현재 페이지에서 실행된다는 뜻은 아니다.
- 따라서 권장 순서 1번 전체는 아직 진행 중이다. 다음은 위 잔여 경로를 실제 진입·기능 시험하면서 정리하는 작업이다. 기업개요 사진/본문 개선이나 새 일반페이지 양산은 이번 변경에 포함하지 않았다.
