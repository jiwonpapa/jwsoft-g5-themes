# G5 디자인 개발 하네스

이 폴더는 개발 도구입니다. 판매 ZIP에 포함하지 않고 고객 서버에 Bun·Node·Docker를 요구하지 않습니다. 테마의 독립 PHP, G5 게시판·최신글 skin 구조를 그대로 사용합니다.

## 시작

```sh
bun install --frozen-lockfile
bun run foundation:check
bun run ui:install
bun run ui:check --page home-4
bun run ui:capture
```

기본 검사 주소는 사무실 Ubuntu `https://g5themes.test`입니다. `quality/contract.json`에서 메인 4개+원페이지 3개를 읽으며 PC 1440×1000·모바일 390×844 × 라이트·다크 28상태를 수집합니다. viewport에 맞춰 `?device=pc` 또는 `?device=mobile`도 지정하여 G5의 PC·모바일 분기를 실행합니다. 실제 터치 기기 시험을 대신하지 않습니다. 제거된 메인5는 허용하지 않습니다. 결과는 `output/qa/ui/captures/<page>/<state>.*`, Playwright HTML·trace·diff는 `output/qa/ui/runs/<command>-<scope>/report`, `results`에 남습니다. 순서대로 실행하세요. 같은 결과 폴더를 사용하는 실행을 동시에 돌리지 않습니다.

`ui:capture`는 수집만 하며 승인하지 않습니다. `ui:check`는 이미지·아이콘·폰트 정착 후 가로 넘침·뒤집힌 제목·필수 요소·JS 오류·axe WCAG A/AA를 검사합니다. Main4의 카드 제목·본문 정렬, FAQ, 다크 전환 후 아이콘 유지도 검사합니다. 모션 정지 캡처는 동작 품질의 승인이 아닙니다.

메인 7종의 필수 동작 증거는 `bun run harness/ui/collect-interactions.ts`로 별도 수집합니다. PC·모바일 크기에서 슬라이더, 재생·정지, 키보드, 카드 hover/focus, 스크롤 및 줄인 동작, 제품 상세 탭, 공간 갤러리 총 40건을 실제 조작합니다. 결과는 테마 `quality/evidence/main-seven-20260928/interactions/`의 전후 PNG와 manifest입니다. `JW_INTERACTION_VIEWPORT=desktop` 또는 `mobile`로 한 크기만 실행할 수 있으며, 이때 최종 manifest도 해당 실행 범위만 포함합니다. 독립 시각 검토와 실물 터치 기기 검증을 대신하지 않습니다.

제품 상세 탭은 세 패널을 직접 클릭한 화면도 별도로 수집합니다. 아이콘은 실제 SVG 크기·표시 여부를 검사하고, 렌더링 자료에는 CSS 배경 사진도 포함합니다.

## 고정 Linux 환경과 이미지 비교

```sh
bun run ui:runtime up
JW_UI_PAGES=home-4 bun run ui:runtime test check
JW_UI_PAGES=home-4 bun run ui:runtime test compare
bun run ui:runtime test selftest
bun run ui:runtime test gallery
bun run ui:runtime down
```

Compose는 `.runtime/ui/site`에 공식 G5의 고정 commit/archive SHA를 확인해 설치합니다. 코어 파일을 수정하지 않습니다. 랜덤 시험 비밀번호는 무시된 `.runtime/ui/.env`에만 저장합니다. DB 볼륨과 메뉴는 전용 `jw-g5-ui` 환경이며 사무실 DB와 관계없습니다. 브라우저·PHP·Nginx·MySQL 이미지가 고정되어 있습니다. `down`은 DB 볼륨을 지우지 않습니다.

macOS와 Linux 픽셀 기준본은 섞지 않습니다. `ui:compare`는 기준본·검토자·PNG checksum·원본 digest·브라우저 버전·OS를 확인합니다. 기준본이 없거나 달라지면 실패합니다. `--update-snapshots`로 자동 수락하는 명령을 제공하지 않습니다.

새 기준본 절차: 고정 Linux `check`에서 네 상태 후보를 수집 → 구현자와 별개 검토자가 후보와 변경 이유를 확인 → 검토 기록을 저장 → 승인한 PNG만 `baselines/<state>/<page>.png`로 복사하고 `baselines/manifest.json`에 기록 → `compare` 재실행. 승인되지 않은 다른 6개 페이지에 기준본을 억지로 채우지 않습니다. `sourceDigest`는 승인 당시 입력이며 현재 소스와 달라도 픽셀 비교 자체는 실행합니다. 전체 품질 gate는 별개로 현재 입력을 검사합니다.

## 사무실 개발 반영

```sh
bun run dev:g5 --dry-run --page home-4 --gallery
bun run dev:g5 --once --page home-4 --gallery
bun run dev:g5 --page home-4 --gallery
```

마지막 명령은 source 변경을 감지합니다. manifest/Vite/의존성 일치 → 구조·typecheck → 토큰·Vite·payload build → payload 검사 → 사무실의 지정 테마 자산과 선택 PHP만 rsync → HTTP 확인 순서입니다. 빌드 실패 시 전송하지 않습니다. `.runtime/dev-g5.lock`으로 중복 실행을 차단하며 변경을 모아 순차 처리합니다. 비정상 종료 후 lock이 남으면 `pid`의 프로세스 종료를 확인한 뒤 해당 lock만 제거합니다. 삭제 동기화와 DB 변경은 하지 않습니다.

개발 반영은 실패를 고치기 위한 미리보기이며 판매 승인 경로가 아닙니다. `styles:check`, `quality:check`, 브라우저 검사를 통과시키지 않고 판매 ZIP을 만들거나 다음 묶음 완료를 선언할 수 없습니다.

`--page all`은 메인 7종 전체를 선택합니다. 원페이지가 선택되면 독립 `pages/onepage-*.php`와 빌드된 `theme/onepages/assets/`도 전송합니다. 이 폴더의 원본 변경도 감지합니다. 다른 메뉴의 PHP, G5 코어와 DB는 전송 대상이 아닙니다. 빌드 payload에서는 폐기한 NODE 렌더 프레임·포스터와 이미지 출처 sidecar JSON을 제외합니다. 삭제 동기화를 하지 않으므로 사무실 서버에 예전 파일이 남을 수 있지만 새 페이지가 참조하지 않습니다.

## 블록 갤러리

주소: `https://g5themes.test/__jw-dev/`. `--gallery`로만 개발 서버에 배치합니다. 테마 payload·상품 manifest·ZIP allowlist에 포함하지 않습니다. 메인7개 전체 미리보기와 Main4 9개 섹션 탐색, 원본 PHP, 필요 CSS/JS, PC·모바일, 두 모드, 이전 검토 캡처를 함께 제공합니다. 다른 페이지는 참고 이미지가 없음을 표시합니다. Main4 참고 캡처의 출처는 `quality/evidence/main4-20260927/manifest.json`; 사용자 최종 승인이 아닙니다. 작업용 시안은 실제 테마와 별도의 `inc/sections` 구현을 만들지 않습니다.

## 검사와 도구 설정

- `foundation:check`: 계약·토큰·tooling·테마 전체 unit·typecheck·build·구조·payload. 상품 디자인 판정과 별도입니다.
- `generated:check`: 깨끗한 checkout에서 재빌드한 추적 생성물과 HEAD 일치 및 미추적 생성물 검사. 생성물을 직접 고치면 CI에서 실패합니다.
- `styles:check`: 9개 원본 CSS의 잘못된 색·빈 선언·중복 속성·의미 색상 우회 검사. daisyUI palette 정의와 문서화된 Main4 작품 견본만 범위를 구별합니다. 기존 위반은 실패로 유지합니다.
- `stack:check`: 확정 라이브러리의 정확한 버전과 manifest/Vite의 CSS/JS entry 일치를 검사합니다.
- `harness:test`, `ui:selftest`: 잘못된 원본·자가 승인·다른 OS 기준본·빌드 실패 전송·뒤집힘·넘침·누락 이미지를 실제로 거부하는지 검사합니다.
- `.codex/config.toml`: Playwright MCP 0.0.82 고정, Context7 연결. 변경 후 프로젝트 세션을 다시 열어 도구 목록을 갱신합니다. Context7에는 라이브러리 이름·버전·일반 API 질문만 보내며 저장소 소스나 비밀을 전송하지 않습니다. 조회 실패·버전 미지원 시 공식 문서를 확인합니다.
- Impeccable hook은 계속 OFF입니다. 수동 경고나 axe·픽셀 비교를 디자인 승인으로 바꾸지 않습니다.

하네스 TypeScript는 `harness:typecheck`로 별도 검사합니다. 고정 Linux runner의 npm 의존성도 `runner-deps/package-lock.json`으로 잠그며 상품 package에는 배포하지 않습니다.

기반 CI, 스타일 정책, 실제 G5 브라우저, 기존 상품 품질 CI를 각각 표시합니다. 실패를 `continue-on-error`로 감추지 않습니다.

## main 푸시 차단의 한계

2026-09-27 GitHub의 비공개 저장소 branch protection API가 Pro 업그레이드를 요구하며 HTTP 403으로 거절했습니다. 공개 전환이나 결제는 하지 않았습니다. 이 checkout에는 `.githooks/pre-push`를 연결하여 main 직접 푸시 전에 필수 검사를 실행합니다. 다른 checkout은 `git config core.hooksPath .githooks`로 연결해야 합니다. 로컬 hook은 `--no-verify`나 GitHub 웹 병합을 막는 서버 보호가 아닙니다. 서버 강제 보호는 요금제/저장소 설정 조건이 충족되어야 합니다.

## 사용자 화면 교정 회귀 (2026-09-28)

`ui:check`는 2560·1920·1440·1280·768·390 폭을 검사합니다. 1440·390은 라이트/다크를 포함해 총 8상태입니다. 메인1·2의 모든 슬라이드를 캡처하며 메인2의 문장/사진 간격, 전체 중심, CTA 문자·아이콘 수직 중심을 실제 레이아웃으로 검사합니다. 이 수치는 시각 상품 승인과 별개입니다.

`bun run harness/ui/collect-rotation.ts`는 AURA의 스크롤 세 각도, 키보드, 모바일, 동작 줄이기, JS 없음, 프레임 요청 실패의 실제 화면을 수집합니다. 기존 동작 수집기는 `JW_INTERACTION_OUTPUT`으로 새 증거 디렉터리를 지정할 수 있습니다.
