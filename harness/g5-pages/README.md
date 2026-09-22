# G5 메뉴·독립 홈 검증

사용자가 허용한 `g5themes.test` 개발 환경 전용입니다. 판매 payload에는 포함하지 않습니다.

- `seed-menu.php`: `JW_G5_MENU_ALLOWED=1`, 활성 테마 `jw_business`, **빈 메뉴 테이블**에서 원래 6개 대분류·80개 하위 목적지를 공식 메뉴 테이블에 추가합니다. 기존 메뉴는 기본적으로 보존합니다. `JW_G5_MENU_RESTORE_PREVIOUS=1`은 이번 작업이 만든 이전 83개 fixture와 모든 이름·URL·순서·노출 상태가 일치할 때만 백업 후 86개 구성으로 복구합니다. 관리자 변경이 있으면 중단합니다. 같은 디렉터리에 `PAGE-CATALOG.json`이 필요하며 코어·스키마·서버 설정은 바꾸지 않습니다.
- `capture-homes.js`: Playwright CLI `run-code --filename` 입력 함수입니다. 메인 2~5 × 360/390/768/1440px × 라이트/다크 32조합의 오류·넘침·h1·아이콘·이미지 상태와 대표 PC/모바일 캡처를 반환합니다. 실행 전 `output/playwright/menu-batches` 디렉터리를 준비합니다.
- `member-smoke.py`: 개발 계정으로 로그인하여 4개 홈의 PC/모바일 회원 shell과 문의 목록을 HTTP 검사한 뒤 로그아웃합니다. 글·문의·계정을 만들거나 변경하지 않습니다. `G5_ADMIN_ID`, `G5_ADMIN_PASSWORD` 환경변수와 `--ca <mkcert rootCA.pem>`이 필요합니다. 비밀번호를 명령 인수·Git·결과 로그에 기록하지 않습니다.

파일 복사 방식 홈 전환 검사는 `index_N.php`를 개발 사이트 `index.php`로 복사하여 PC·모바일 본문을 확인한 뒤, 반드시 기존 기본 홈으로 복원합니다. 직접 미리보기만으로 복사 설치 검사를 대체하지 않습니다.

2026-09-22 구조 반영 직전 개발 테마·pages 백업: 서버의 `backups/before-menu-batches-20260922.tar.gz`. 이 백업은 DB 백업이 아닙니다. 전체 메뉴 복구 직전의 83개 DB 행은 서버 `backups/jw-menu-before-restore-20260922-062528.json`에 별도로 보관했습니다.

- `menu-groups-smoke.php <theme-path>`: DB 없이 그룹화·35개 목적지 보존·외부/일반 메뉴·숨김·순서·빈 메뉴를 검사합니다.
- `capture-menu-restoration.js`: PC 3폭×2모드×6대분류와 모바일 2폭×6대분류를 검사합니다. hover 전환 완료를 기다린 뒤 표시·내부 스크롤·잘림을 측정합니다.
