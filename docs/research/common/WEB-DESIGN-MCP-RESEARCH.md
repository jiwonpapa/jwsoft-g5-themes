# G5 테마 디자인·웹 MCP 도입 연구

- 문서 상태: 도입 전 조사·권고안
- 기준일: 2026-09-20
- 대상: `jwsoft-g5-themes`의 디자인 결정, 구현, 실제 화면 검증

## 결론

현재 저장소에는 **무료 Figma 연동을 디자인 보조 도구로 쓰고, Playwright MCP는 개발 중 실제 화면 탐색에 사용**하는 조합이 가장 적합합니다. 다만 MCP를 디자인 시스템이나 릴리스 하네스의 단일 원본으로 만들지는 않습니다.

- Figma: 시안, frame·component·variable 문맥, 디자인 검토와 code-to-canvas 왕복에 사용
- 저장소: 승인된 token, page inventory, component contract와 디자인 참조 기록의 단일 원본
- Playwright MCP: AI가 실제 G5 화면을 보고 탐색·진단하는 개발 도구
- `@playwright/test`: 고정 fixture와 브라우저 image에서 반복 실행하는 release gate
- Impeccable: MCP 바깥의 프로젝트 디자인 skill과 정적 경고 도구

Figma 플러그인은 현재 Codex에 설치됐습니다. 계정·파일 접근 시험을 마친 뒤 첫 테마의 시안 비교부터 사용합니다. Storybook MCP와 Chrome DevTools MCP는 조건부 보류하고, shadcn MCP는 현재 제품 스택에 도입하지 않습니다.

## 1. MCP가 맡을 일과 맡지 않을 일

MCP는 AI가 외부 디자인 자료와 실행 화면을 읽는 통로입니다. 상품 품질을 결정하는 규칙 자체는 버전 관리되는 저장소에 남아야 합니다.

| 책임 | 단일 원본 | MCP 역할 |
| --- | --- | --- |
| 색·간격·서체·radius·motion token | `tokens/*.tokens.json` | Figma variable과 시안 문맥을 읽고 비교 |
| 메뉴·페이지·상태 목록 | theme manifest와 page inventory | 선택 frame이 목록을 빠뜨렸는지 검토 |
| 승인 시안 | `DESIGN-REFERENCE.json`과 고정 preview | Figma frame을 만들고 수정·조회 |
| 실제 G5 동작 | G5 fixture와 source | Playwright MCP로 탐색·원인 확인 |
| 반복 회귀 | Playwright test와 고정 Linux baseline | MCP가 아닌 CI runner가 판정 |
| 릴리스 승인 | manifest, gate 결과, 사람의 diff 검토 | MCP 단독 승인 금지 |

외부 MCP가 잠시 중단되거나 계정 권한이 없어도 build, test, package와 설치가 가능해야 합니다.

## 2. 후보 평가

### 2.1 Figma 플러그인·MCP — 우선 도입

Figma 공식 MCP는 frame에서 디자인 문맥을 읽고, component·variable·layout을 다루며, 실행 중인 웹 UI를 편집 가능한 Figma layer로 보내는 code-to-canvas 흐름을 제공합니다. G5 테마에서는 다음 용도로 제한합니다.

- 첫 테마마다 2~3개 시각 방향을 같은 page inventory로 비교
- 선택된 hero, header, mobile menu, board list/detail, form 상태를 frame으로 고정
- Figma variable과 저장소 semantic token의 누락·이름 차이 검토
- 구현 화면을 Figma로 다시 보내 원안과 나란히 검토
- 디자인 frame 링크와 node ID를 구현 작업에 전달

Figma가 코드를 생성해도 그대로 상품 source로 취급하지 않습니다. 기존 Tailwind·daisyUI·G5 markup 계약으로 다시 구현하고 source diff, 접근성, 반응형, JS OFF, 실제 G5 검사를 통과시킵니다.

Figma 공식 문서는 remote MCP를 권장하며, Codex도 code-to-canvas 지원 client에 포함합니다. 이 저장소에서는 **무료 Starter 범위만 사용**합니다. MCP 읽기 호출 월 20회는 시안 확정·변수 확인·최종 대조처럼 가치가 큰 지점에만 쓰고, 한도 소진 시 저장소 token·preview와 Playwright workflow로 계속 개발합니다. 유료 좌석이나 추가 결제를 개발 전제로 두지 않습니다.

### 2.2 Playwright MCP — 즉시 활용, CI와 역할 분리

현재 Codex 작업 환경에는 Playwright MCP가 제공됩니다. AI가 실제 페이지의 접근성 tree, DOM 상태, console, network와 screenshot을 확인하는 데 사용합니다.

반복 가능한 통과 판정은 `@playwright/test` source로 남깁니다. MCP 대화에서 한 번 확인한 화면을 회귀 검사의 증거로 대체하지 않습니다. 조사 중 재현된 결함은 고정 fixture와 test scenario로 승격합니다.

### 2.3 Chrome DevTools MCP — 성능 문제가 생길 때 도입

Chrome DevTools for agents는 performance trace와 DevTools 수준 진단에 강점이 있습니다. 하지만 초기 기능·반응형·시각 검증은 Playwright와 겹칩니다.

다음 조건 중 하나가 실제로 발생할 때만 추가합니다.

- LCP·long task·layout shift 원인을 trace로 분석해야 함
- network waterfall과 rendering pipeline을 함께 진단해야 함
- Playwright trace만으로 재현 원인을 찾지 못함

사용할 때는 로그인되지 않은 전용 browser profile과 로컬 fixture만 연결합니다. 공식 문서도 연결한 browser의 내용과 인증 상태를 agent가 읽고 조작할 수 있다고 경고합니다.

### 2.4 Storybook MCP — 두 번째 테마 이후 재평가

Storybook MCP는 component 문서, story와 test를 agent에게 제공하는 장점이 있지만 AI 기능은 현재 preview입니다. 공식 component manifest 지원도 React, 일부 Angular·Vue 구성에 집중되어 있고 Web Components는 문서 toolset 이점이 제한됩니다.

G5 PHP template에 지금 Storybook을 넣으면 실제 G5 markup과 분리된 예제 layer를 한 벌 더 유지할 가능성이 큽니다. 두 테마에서 동일한 component contract가 확인되고 `theme-behaviors`나 독립 preview renderer가 생긴 뒤 spike합니다. 그전에는 G5 fixture gallery와 Playwright scenario가 component 상태표 역할을 맡습니다.

### 2.5 shadcn MCP — 도입하지 않음

shadcn MCP의 핵심은 registry에서 React 계열 component와 block을 검색·설치하는 것입니다. 현재 기준은 G5 PHP template, Tailwind 4와 daisyUI 5입니다. 이를 함께 쓰면 markup, token, 접근성 pattern과 dependency 체계가 둘로 갈라집니다.

시각 참고 자료로 웹 문서를 보는 것은 가능하지만 shadcn MCP가 source를 설치하거나 registry component를 복사하게 하지 않습니다.

### 2.6 Impeccable — MCP가 아닌 보조 skill로 제한 도입

Impeccable 4.3.1은 Codex가 읽는 디자인 skill과 61개 결정론적 감지 규칙을 제공합니다. 프로젝트에 version과 archive hash를 고정해 설치했고 정상·의도적 문제 fixture로 engine을 보정했습니다.

감지 규칙에는 브랜드 취향 판단도 섞여 있으므로 자동 hook과 release 차단은 사용하지 않습니다. 테마 source의 수동 경고 검사로 사용하고 token·실제 G5 화면·Playwright·사람 검토를 우선합니다. 상세 결정은 [Impeccable 디자인 스킬 도입 평가](IMPECCABLE-DESIGN-GOVERNANCE.md)에 기록했습니다.

## 3. Figma와 저장소의 동기화 규칙

### 3.1 저장소가 최종 원본인 항목

- primitive·semantic·component token 이름과 값
- 지원 viewport와 responsive rule
- G5 surface, 상태와 page inventory
- 접근성·motion·asset·library 제한
- 실제 source와 release artifact

Figma에서 값을 바꿨다는 사실만으로 구현 기준이 바뀌지 않습니다. 승인한 변경은 token JSON과 관련 문서에 명시적인 diff로 반영합니다.

### 3.2 `DESIGN-REFERENCE.json`

각 테마 manifest가 다음 참조 파일을 가리키게 합니다.

```json
{
  "$schema": "../../../packages/theme-contracts/schemas/design-reference.schema.json",
  "provider": "figma",
  "fileUrl": "https://www.figma.com/design/...",
  "frames": {
    "home-desktop": "1:100",
    "home-mobile": "1:200",
    "board-list": "2:100",
    "board-detail": "2:200"
  },
  "approvedAt": "2026-09-20",
  "tokenSourceSha256": "...",
  "previewSha256": "..."
}
```

계정 token, OAuth 정보와 개인 식별 정보는 저장하지 않습니다. URL과 node ID는 공개 정보가 아니라는 전제로 private 저장소에서만 관리합니다. 승인 시각과 hash가 달라지면 visual gate의 재검토 대상으로 표시합니다.

### 3.3 디자인 왕복 절차

1. 저장소에서 page inventory, content 길이, 상태, token 이름과 접근성 조건을 확정합니다.
2. Figma에서 같은 입력으로 2~3개 방향을 만듭니다.
3. 형님이 선택한 방향의 desktop·mobile·상태 frame을 승인 대상으로 고정합니다.
4. `DESIGN-REFERENCE.json`과 preview hash를 기록합니다.
5. G5 source로 구현하고 Playwright MCP로 실제 화면을 탐색합니다.
6. 고정 Playwright test와 visual baseline을 통과시킵니다.
7. 필요하면 구현 화면을 code-to-canvas로 보내 차이를 검토합니다.
8. 디자인 변경은 Figma와 token/source diff를 함께 갱신합니다.

## 4. UI·UX 일관성 장치

MCP가 일관성을 자동으로 보장하지 않습니다. 아래 자료가 함께 있어야 합니다.

- `tokens/*.tokens.json`: 색, 서체, 간격, radius, shadow, motion
- `PATTERN-INVENTORY.md`: header, mobile navigation, CTA, form, table/list, empty/error/loading 상태
- `CONTENT-BOUNDS.json`: 제목·메뉴·버튼·주소·진료시간 등 현실적인 최소·최대 길이
- `DESIGN-REFERENCE.json`: 승인 frame과 token hash
- Playwright scenario: desktop, mobile, keyboard, reduced motion, 200% zoom, JS OFF
- visual baseline: 390·768·1440px의 대표 실제 G5 화면

공통화하는 것은 token 이름, 상태 계약, 접근성 pattern과 검증법입니다. 모든 업종 테마의 hero 구성과 시각 분위기를 동일 component로 강제하지 않습니다.

## 5. MCP 거버넌스

### 5.1 허용 기준

새 MCP는 다음을 모두 기록한 뒤 사용합니다.

- 공급자와 공식 문서
- 읽기·쓰기 tool 범위
- 인증 방식과 접근 가능한 자료
- source 또는 artifact를 변경하는지 여부
- 기존 도구와 겹치는 기능
- 장애·rate limit 때 대체 경로
- 저장소와 CI에서 version을 고정할 수 있는지 여부

공식 공급자 또는 검토한 source의 MCP만 허용합니다. `latest` 실행 명령을 영구 설정이나 CI에 그대로 저장하지 않습니다.

### 5.2 권한과 데이터

- 디자인 전용 Figma project와 필요한 파일만 허용합니다.
- 실제 고객사, 환자, 회원, 주문 정보는 Figma나 외부 MCP에 전달하지 않습니다.
- 운영 관리자 로그인 browser를 MCP에 연결하지 않습니다.
- 쓰기 tool은 명시된 디자인 파일과 frame에서만 사용합니다.
- MCP가 내려받은 image·font·SVG도 `ASSET-MANIFEST.json`과 license gate를 거칩니다.
- agent가 만든 디자인·코드는 사람의 diff 검토 없이 기준본이나 release에 들어갈 수 없습니다.

### 5.3 재현성과 감사

remote MCP의 결과는 같은 요청에도 바뀔 수 있습니다. 릴리스 근거는 외부 대화가 아니라 저장소의 token, preview hash, source diff, Playwright 결과와 release manifest로 남깁니다. MCP 호출 기록 전체를 상품 ZIP에 포함하지 않습니다.

## 6. 도입 순서

### 기반 1단계

- `DESIGN-REFERENCE.json` schema 추가
- 허용 MCP와 역할을 root 문서에 명시
- token hash와 design preview hash 검사기 정의
- 무료 Starter로 Figma 플러그인을 연결하고 전용 테스트 파일로 읽기·쓰기 범위 확인
- 월 20회 읽기 호출은 시안 확정·변수 확인·최종 대조에만 배정하고 한도 소진 fallback 확인

### 첫 테마

- Figma에서 2~3개 시안 방향 비교
- 선택 frame과 variable을 저장소 token·inventory에 매핑
- Playwright MCP로 실제 G5 화면 확인
- 고정 `@playwright/test`와 visual baseline으로 완료 판정

### 두 번째 테마 이후

- 반복되는 pattern과 상태 계약을 비교해 공통화
- component preview 수요가 실제로 생기면 Storybook MCP spike
- 성능 결함의 재현 사례가 생기면 Chrome DevTools MCP 추가

## 7. 채택 결정

| 후보 | 결정 | 시점 |
| --- | --- | --- |
| Figma 플러그인·remote MCP | 무료 범위 도입 | 시안 확정·변수 확인·최종 대조에 제한 사용 |
| Playwright MCP | 활용 | 개발·조사 시 |
| `@playwright/test` | 필수 | 하네스 3단계부터 |
| Chrome DevTools MCP | 조건부 보류 | trace가 필요한 실제 성능 문제 발생 시 |
| Storybook MCP | 보류 | 두 테마에서 공통 component preview 필요가 증명된 뒤 |
| shadcn MCP | 제외 | G5 PHP+daisyUI 기준과 불일치 |
| Impeccable 4.3.1 | 제한 도입 | 프로젝트 skill·수동 경고 검사, hook OFF |
| 비공식 디자인 생성 MCP 다수 | 제외 | 권한·출처·일관성·재현성 비용이 이익보다 큼 |

## 8. 공식 근거

- [Figma MCP 소개와 remote server 권고](https://developers.figma.com/docs/figma-mcp-server/)
- [Figma remote MCP 설정](https://developers.figma.com/docs/figma-mcp-server/remote-server-installation/)
- [Figma code-to-canvas와 Codex 지원](https://developers.figma.com/docs/figma-mcp-server/code-to-canvas/)
- [Figma MCP tool 목록](https://developers.figma.com/docs/figma-mcp-server/tools-and-prompts/)
- [Figma MCP plan·seat별 접근과 rate limit](https://developers.figma.com/docs/figma-mcp-server/rate-limits-access/)
- [Storybook MCP 개요와 preview 상태](https://storybook.js.org/docs/ai/mcp/overview)
- [Storybook AI manifest 지원 범위](https://storybook.js.org/docs/ai/manifests)
- [shadcn MCP의 registry component 설치 방식](https://ui.shadcn.com/docs/mcp)
- [Chrome DevTools for agents와 보안 주의](https://developer.chrome.com/docs/devtools/agents/get-started)
- [Playwright visual comparison](https://playwright.dev/docs/test-snapshots)
- [Impeccable 공식 저장소](https://github.com/pbakaus/impeccable)

## 9. 현재 확인 상태

- Codex Figma 플러그인: 설치됨, 계정·파일 접근 시험 전
- Playwright MCP: 현재 작업 환경에서 사용 가능
- 저장소 `DESIGN-REFERENCE.json` schema와 무료 범위 MCP 정책: 구현 완료
- Figma 파일·frame·variable의 실제 연동 시험: 아직 미실행
- Storybook·Chrome DevTools·shadcn MCP: 설치하지 않음
- Impeccable 4.3.1 project skill·engine 0.1.5: 설치·보정 완료, 자동 hook OFF

이 문서는 도입 판단과 운영 경계를 정한 연구 결과입니다. 외부 계정 연결, dependency 설치와 실제 디자인 생성이 완료됐다는 뜻은 아닙니다.
