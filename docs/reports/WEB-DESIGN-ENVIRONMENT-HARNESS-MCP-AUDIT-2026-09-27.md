# 웹디자인 개발환경·하네스·MCP 감사

기준: 2026-09-27, `codex/main-seven-distinct`, 커밋 `08bdee50e17a01d8c7275b8a24fe75d1ed520394`와 현재 작업 트리. 분석 요청에 따른 보고서이며 개발 설정·상품 소스·서버는 변경하지 않았습니다.

## 판단

**제작에 필요한 도구는 대부분 있습니다. 판매용 템플릿의 디자인 품질을 반복해서 보장하는 제작·검수 연결은 미완성입니다.** 새 디자인 생성 MCP를 여러 개 추가하는 것보다 기존 도구를 실제 G5 화면과 버전 관리되는 검사에 연결하는 일이 우선입니다.

2026-09-20의 [MCP 연구](../research/common/WEB-DESIGN-MCP-RESEARCH.md)는 이미 `@playwright/test`, 고정 시각 기준본, 콘텐츠 길이 계약을 권고했습니다. 현재 구현에는 그중 일부만 있습니다. 도구 부족만으로 지난 디자인 실패를 설명할 수 없으며, 시안과 산출물을 대조하는 작업 및 완료 판정이 충분히 실행되지 않았다는 문제가 있습니다.

## 실제 확인한 구성

| 구분 | 현재 상태 | 판단 |
| --- | --- | --- |
| 제작 스택 | Bun 1.4.2, Vite 8.3.0, Tailwind 4.3.3, daisyUI 5.7.40, TypeScript 7.0.2 | 유지. 버전과 lockfile 존재 |
| 디자인 토큰 | DTCG JSON → 생성 CSS·Tailwind 매핑, jw-light/jw-dark | 유지. 이번 token 검사 통과 |
| 아이콘·효과 | Lucide 1.47.0, Embla 8.6.0, Motion 13.4.0 | 유지. 같은 기능의 라이브러리 추가 불필요 |
| 실제 G5 환경 | 사무실 Ubuntu의 Nginx·PHP 8.3·MySQL 8.4 컨테이너 | 현재 실행 중, PHP/DB healthy 확인 |
| 고객 개발 키트 | setup·doctor·build·check·원본/생성 파일 계약 | 있음. doctor 통과. 고객 서버의 Node/Bun 실행은 필요하지 않은 구조 |
| 디자인 스킬 | 프로젝트 Impeccable 4.3.1, 감지기 0.1.5 | 설치·무결성 검사 존재. hook OFF는 의도된 정책 |
| 이미지 생성 | 내장 생성 도구, 자산 소유·원본 계열·해시 기록 | 있음. 직전 Main 4에 실제 사용 및 원본 기록 |
| 내장 브라우저 | Codex 도구 제공, Main 4의 PC/모바일·두 모드 캡처 보관 | 사람 시야의 최종 확인에 계속 사용 |
| Playwright MCP | 전역 설정에 등록, 이번 탭 목록 호출 성공 | 사용 가능. 버전은 `@latest`여서 재현성 보완 필요 |
| Figma | 이번 계정 조회 성공, Starter / View | 인증 확인. 이번 감사에서 파일 읽기·수정은 수행하지 않음 |
| 자체 품질 차단 | 구조 반복, 사진 재사용, 필수 콘텐츠, 검토 증거·해시, 판매 ZIP 차단 | 존재하고 실제 실패를 반환함 |
| 자동 시각 회귀 | `@playwright/test`, 테스트 설정, `toHaveScreenshot` 시나리오 없음 | 우선 보완 |
| 접근성·스타일 검사 | axe·Stylelint 통합 없음 | 필요한 범위를 기존 gate에 연결 |

Figma의 현재 계정은 Starter/View이며, 공식 문서상 해당 읽기 도구 호출은 월 최대 20회입니다. 계정 연결이 모든 제품 파일 접근이나 검수 완료를 뜻하지 않습니다. 시안의 중요한 결정에 한정해 쓰고 매 수정마다 왕복하는 필수 경로로 두지 않는 편이 적합합니다. [Figma 공식 제한](https://developers.figma.com/docs/figma-mcp-server/rate-limits-access/)

## 우선 고쳐야 할 공백

### 1. 시각 회귀가 문서에만 있고 실행 경로에 빠져 있음 — P0

[package.json](../../themes/business/jw_business/package.json), [루트 check](../../packages/theme-contracts/src/check-all.ts), [CI](../../.github/workflows/product-quality.yml)에 고정 브라우저의 화면 비교가 없습니다. 기존 capture 스크립트는 탐색 결과를 반환하는 일회성 함수이며 테스트 assertion·기준본 비교·자동 실패 판정이 아닙니다.

권고: `@playwright/test`를 개발 의존성으로 추가하고 고정 Linux/브라우저/폰트/fixture에서 화면 비교를 실행합니다. 승인한 기준본과 변경 결과·차이 이미지를 함께 보관합니다. 내장 브라우저 검수는 계속 별도로 수행합니다. OS·브라우저 차이로 렌더링이 달라지므로 Mac 캡처를 Linux의 픽셀 기준본으로 그대로 쓰지 않습니다. [Playwright 공식 시각 비교](https://playwright.dev/docs/test-snapshots)

화면 비교는 회귀를 찾는 수단입니다. 처음부터 좋지 않은 화면을 기준본으로 승인하면 그 상태만 보존하므로, 최초 기준본에는 별도의 디자인 검토가 필요합니다.

### 2. 캡처 대상과 실제 상품 구성이 어긋남 — P0

- [capture-homes.js](../../harness/g5-pages/capture-homes.js)의 대상은 `[2, 3, 4, 5]`입니다. 제거된 5번을 포함하고 기본 1번을 제외합니다.
- PC 라이트와 모바일 다크만 파일로 저장합니다. 필수 PC/모바일 × 라이트/다크 4종 증거를 모두 남기지 않습니다.
- `document.fonts.ready`는 기다리지만 모든 이미지의 decode·lazy image 표시까지 기다리는 절차가 없습니다.
- `missingIcons`는 `i[data-lucide]`만 검사하므로 Main 4의 별도 아이콘 마커를 일반적으로 검증하지 못합니다.
- [comparison.ts](../../themes/business/jw_business/scripts/quality/comparison.ts)는 모든 묶음을 “다섯 변형”, 5열로 표시합니다. 실제 홈은 4개, 원페이지는 3개입니다.

권고: 검사 목록과 요구 선택자를 기존 `quality/contract.json`에서 읽습니다. 메인 메뉴 전체는 홈 4개+원페이지 3개로 생성하고, 단일 페이지 검수와 묶음 비교를 같은 수집기로 처리합니다. 이미지 decode, 폰트, 초기 효과 정착을 확인한 뒤 캡처합니다. 모션 자체의 동작 검사는 정지된 시각 기준본과 별도의 시나리오로 둡니다.

### 3. CI의 검사 범위와 강제력이 부족함 — P0

현재 workflow는 `quality:test`, `tooling:test`, `quality:check`만 실행합니다. 테마의 전체 typecheck·build·64개 회귀·생성물 일치·PHP lint·실제 G5 브라우저 검사가 연결돼 있지 않습니다. 루트 `check`도 테마 전체 `check`와 같은 명령이 아닙니다.

최근 3개 실행 모두 실패입니다. 최신 `08bdee5` 실행은 설치와 두 테스트 단계는 통과했고 `quality:check`에서 실패했습니다. [실제 GitHub 실행](https://github.com/jiwonpapa/jwsoft-g5-themes/actions/runs/36297321335)

GitHub branch API에서 `main`과 작업 브랜치 모두 `protected: false`입니다. 현재 설정은 실패 표시를 남기지만 보호 브랜치의 필수 검사로 병합을 통제하는 상태는 아닙니다.

권고: 기반 검사, 실제 브라우저 회귀, 상품 준비 상태를 구분해 표시하고 모두 필요한 완료 경로에 연결합니다. 기존 품질 실패를 경고로 낮추지 않습니다. 깨끗한 checkout에서 build 후 생성 파일 diff가 없어야 통과하도록 만듭니다. `main`에는 필수 검사·검토 규칙을 적용하고 검사 정책 변경도 검토 대상으로 둡니다. CI용 G5는 기존 Compose 정의를 이용한 별도 fixture로 실행해 사무실 공유 DB에 의존하지 않게 합니다.

### 4. 시안과 블록의 구현 기준이 흩어져 있음 — P0

[DESIGN-REFERENCE.json](../../themes/business/jw_business/DESIGN-REFERENCE.json)은 여전히 단일 시작 이미지의 `draft`입니다. 개별 Main 4 등 디자인 문서는 있지만 테마 수준 `DESIGN.md`, `PATTERN-INVENTORY.md`, `CONTENT-BOUNDS.json`은 없습니다. `blocks/`의 실제 복사용 PHP도 현재 3개뿐입니다. 페이지마다 다시 생성하는 비용을 줄일 만큼의 시각 카탈로그는 아닙니다.

권고: 새 프레임워크 대신 **G5에서 직접 렌더링하는 개발용 블록 갤러리**를 만듭니다. 각 블록에 원안 이미지·실제 구현·PC/모바일·두 모드·사용 파일·필요 라이브러리를 함께 표시합니다. 갤러리는 기존 독립 PHP와 복사용 블록을 보여주며 상품의 런타임 `inc` 구조를 바꾸지 않습니다.

각 페이지의 기존 계약에는 섹션 목적, 선택한 패턴, 실제 사용할 사진/아이콘, 제목·본문 길이 범위, CTA 위치를 연결합니다. 사진·큰 아이콘은 목적에 맞게 명시하고 모든 페이지에 같은 개수·모양의 카드를 강제하지 않습니다. 기본 타이포·간격·색·모션은 토큰을 단일 원본으로 하고 설명 문서는 그 값과 연결합니다.

전역 `frontend-skill`은 카드 없는 구성과 Hero→Support→Detail→CTA를 기본으로 권합니다. 이는 다양한 블록을 제거·조합해 쓰는 판매용 테마의 목표와 다릅니다. 프로젝트용 제작 지침에서 **상업용 다목적 템플릿의 분량·다양성과 명시된 대형 아이콘 요구가 일반 스킬의 취향보다 우선**임을 분명히 해야 합니다. 이것이 과거 실패의 유일한 원인임을 입증한 것은 아니며, 기존 사용자 지시를 따르지 않아도 된다는 뜻도 아닙니다.

### 5. 기술 스택을 선택한 것과 일관되게 사용하는 것은 다름 — P1

현재 CSS 9개는 빌드 경로에 있으며 토큰을 사용합니다. 일부 파일은 `@apply` 중심이고 다른 파일은 직접 선언이 많습니다. 직접 CSS나 `@apply` 개수만으로 스택 위반을 판단해서는 안 됩니다. 필요한 grid·복잡한 시안 그래픽에는 직접 CSS가 적합합니다.

보완할 것은 UI의 의미 색상·공통 컨트롤·간격 기준을 벗어난 구현을 기계적으로 찾는 장치입니다. 코드에는 고정 색도 존재하지만 작품 시안·사진 오버레이와 사이트 UI를 구분해 판단해야 합니다. Main 4의 작품 견본 색을 무조건 사이트 다크 색으로 바꾸는 방식도 잘못입니다.

권고: Stylelint에 Tailwind 4 문법과 토큰 정책을 반영하고, PHP inline style과 라이브러리 import 검사는 기존 검사기에 보완합니다. 작품 견본은 허용된 범위와 이유를 기록하고 사이트 UI 전체를 예외로 만들지 않습니다. 생성 파일 직접 수정은 재빌드 후 diff로 잡습니다. [Stylelint 속성·값 검사](https://stylelint.io/user-guide/rules/declaration-property-value-allowed-list/)

추가로 `theme.manifest.json`의 `externalLibraries`에는 실제 사용하는 Embla·Motion이 빠져 있고 CSS/JS entry도 기본 한 개씩만 기록돼 있습니다. 라이선스 파일은 존재하므로 “미등록 라이선스”로 단정할 일은 아니지만, package·Vite·manifest 사이의 일치 검사가 필요합니다.

### 6. 검토 유지 비용과 개발 반복 작업을 줄여야 함 — P1

[inputDigest](../../themes/business/jw_business/scripts/quality/files.ts)는 테마 전체 source·page·생성물·정책을 한 번에 묶습니다. 한 페이지의 작은 변경도 다른 묶음의 검토 digest를 바꿉니다. 현재는 보수적이고 안전하지만 페이지 수가 늘수록 재검토 비용이 큽니다.

권고: 페이지 단독 입력과 공통 shell/토큰/공유 chunk/정책 입력을 구분해 변경 영향에 맞춰 재검토합니다. 공통 변경은 모든 소비 페이지의 승인을 무효화해야 하며, 사진의 페이지 간 재사용 검사는 항상 전체 범위를 유지합니다. 최종 출시에는 전체 집계 검사를 유지합니다. 실제 재검토 없이 digest만 갱신하는 기능은 만들지 않습니다.

현재 표준 명령에는 `dev`/`watch`가 없고 build·범위별 전송·새로고침을 작업마다 조합합니다. `dev:g5` 하나로 변경 감지→공식 빌드→정해진 사무실 테마 경로 동기화→미리보기 확인을 연결하는 것이 적합합니다. 빌드 실패 시 전송하지 않고 작업 동시 실행을 직렬화합니다. 고객 서버에 새 빌드 도구를 요구하지 않습니다.

## 추가 도구 추천

| 도구 | 결정 | 이 레포에서 맡을 역할 |
| --- | --- | --- |
| `@playwright/test` | 우선 추가 | 고정 환경의 screenshot diff, 반응형·정렬·이미지·메뉴·다크 전환 회귀 |
| `@axe-core/playwright` | 함께 추가 | 대비·이름·라벨 등 자동 검출 가능한 접근성 문제. 디자인 평가를 대신하지 않음 |
| Stylelint | 추가 | UI 토큰·CSS 규칙·Tailwind 문법 검사 |
| Context7 | 선택 추가 추천 | 설치 버전에 맞는 Tailwind/daisyUI/Motion 등의 문서 조회 |
| Figma·내장 이미지 생성·내장 브라우저·Lucide·Embla·Motion | 기존 유지 | 현재 목적에 필요한 기능이 이미 있음 |
| Chrome DevTools MCP | 조건부 보류 | 실제 LCP·layout shift·긴 작업의 trace 분석이 필요할 때 |
| Storybook·React/shadcn 기반 도구 | 현재 도입 보류 | PHP 실화면과 별도의 구현층을 추가하는 비용이 큼. G5 갤러리부터 |
| Percy/Chromatic 등 외부 시각 회귀 서비스 | 현재 구매 추천 안 함 | 먼저 로컬/CI Playwright 기준본과 보고서로 검수 흐름 검증 |

Playwright 공식 문서는 axe 통합을 제공하며 자동 검사로 모든 접근성 문제를 검출할 수는 없다고 설명합니다. [공식 접근성 검사](https://playwright.dev/docs/accessibility-testing)

Context7은 플러그인 검색에서 제공되지만 **현재 미설치**입니다. 버전별 라이브러리 문서 조회가 목적이며 디자인의 미적 품질을 보장하는 도구는 아닙니다. 실제 도입 시 고정된 각 버전의 문서가 제공되는지 작은 조회부터 검증합니다. 추천만 제시했고 설치·연결하지 않았습니다. [Context7 공식 문서](https://github.com/upstash/context7)

Chrome DevTools는 성능 trace 분석을 지원합니다. 일반 브라우저 탐색은 이미 있는 두 도구와 겹치므로 필요한 상황에서만 추가하는 것이 적합합니다. [Chrome 공식 문서](https://developer.chrome.com/docs/devtools/agents/get-started)

## 권장 개발 설정과 도입 순서

1. **기존 누락부터 정정:** 캡처 대상·4가지 화면·동적 비교판, package/Vite/manifest 일치, 프로젝트의 판매용 테마 디자인 지침을 맞춥니다.
2. **메인 4로 검수 경로 입증:** 실제 G5용 `@playwright/test`와 axe, 시안/실화면 나란히 보기, 검토된 기준본·차이 보고서를 구성합니다. Main 4 검토 기록은 다른 페이지의 승인을 대신하지 않습니다.
3. **기존 검사와 결합:** `ui:check`, `ui:capture`, `ui:compare`, `styles:check` 등의 명령을 추가하고 기존 전체 품질·판매 ZIP 차단과 연결합니다. 명령 이름은 제안이며 현재 존재하는 명령이 아닙니다.
4. **제작 속도 보완:** 개발용 블록 갤러리와 `dev:g5`, 페이지 영향 범위를 이용한 증거 갱신을 추가합니다. 결과 캡처 JSON의 파일 해시·크기·모드·DOM 수집은 자동화하되 시각 평가 문구를 자동 합격으로 채우지 않습니다.
5. **MCP 재현성:** 전역 Playwright `@latest`를 검증한 정확한 버전으로 고정하고 프로젝트에 필요한 MCP 설정 예시·역할·대체 경로를 기록합니다. 인증 정보는 설정 예시에 넣지 않습니다. Context7은 선택 사항입니다.

Codex는 사용자 전역 설정 외에 신뢰한 프로젝트의 `.codex/config.toml`로 MCP를 범위 지정할 수 있습니다. 현재 레포에는 이 파일이 없고 Playwright는 사용자 전역 설정에 의존합니다. 내장 앱 도구를 프로젝트 MCP로 중복 등록할 필요는 없습니다. [OpenAI 공식 MCP 설정](https://learn.chatgpt.com/docs/extend/mcp?surface=cli)

## 추가 후 입증해야 할 완료 조건

- 삭제된 페이지가 캡처 목록에 나타나지 않고 현재 메인 7개에서 4가지 화면 증거가 생성됩니다.
- 카드 제목/버튼 정렬, 글자 뒤집힘, 가로 넘침, 이미지 미표시 같은 결함을 의도적으로 넣은 fixture가 실패합니다.
- 사진 재사용, 필수 아이콘 삭제, 사이트 UI의 임의 색상 도입이 해당 검사에서 실패합니다.
- 이미지/폰트/애니메이션이 안정된 동일 화면을 반복 캡처했을 때 불필요한 차이가 발생하지 않습니다.
- 실패한 차이는 원안·기준본·실제 화면을 함께 보고 판단하며, 기준본 자동 갱신으로 통과시키지 않습니다.
- 공통 헤더 변경은 관련 페이지의 재검토를 요구하고, 무관한 단일 페이지 수정 때문에 전체 이미지를 다시 생성하지 않습니다.
- 빌드/테스트 실패와 상품 준비 미완료가 CI에서 별도로 보이며 최종 판매 차단은 유지됩니다.

## 이번 감사에서 실행한 확인

- `bun run doctor`: 통과.
- `tokens:check`, `typecheck`, `check:build`: 통과. payload 504개, 페이지 파일 74개, 등록 자산 332개 확인.
- 루트 `bun run check`: 기반 구조·계약·Impeccable 검증 및 42개 테스트 통과 후 품질 검사에서 종료 코드 1.
- `quality:check`: 현재 작성 23종, 실패 항목 36개. `DESIGN_NOT_READY` 21, `REQUIRED_CONTENT` 2, `REVIEW_MISSING_OR_INVALID` 6, `REPEATED_OPENING` 1, `PHOTO_REUSE` 3, `PHOTO_OWNER` 3. 이 항목 수는 각각 별개의 시각 결함 개수와 동일하지 않습니다.
- GitHub 최신 실행의 실제 단계와 두 브랜치 보호 상태 확인.
- 사무실 G5 컨테이너 실행 상태, Playwright MCP 응답, Figma 인증 상태 확인.
- 이번에는 7종의 화면 디자인을 새로 전수 평가하거나 Figma 파일을 수정하지 않았습니다. 분석 보고서 외의 소스·설정·배포 변경은 없습니다.

**권장 결정: 현재 제작 스택 유지. 우선 투자 대상은 Playwright Test·axe·Stylelint와 G5 블록/검토 갤러리입니다. 추가 MCP는 Context7 한 개를 선택적으로 검증하고, 나머지 도구 확대는 보류합니다.**
