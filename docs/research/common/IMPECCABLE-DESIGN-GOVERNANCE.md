# Impeccable 디자인 스킬 도입 평가와 운영 기준

- 문서 상태: 평가 완료, 제한 도입
- 기준일: 2026-09-20
- 적용 버전: skill 4.3.1, detector engine 0.1.5

## 결론

Impeccable은 MCP가 아니라 **AI 디자인 지침, 명령 모음, 정적 감지 CLI와 선택적 편집 hook**입니다. G5 테마의 시각 품질과 AI 상투 표현을 점검하는 데 도움이 되므로 프로젝트 스킬로 도입합니다.

다만 다음 경계를 둡니다.

- DTCG token JSON, 테마 manifest와 실제 G5 화면이 최종 기준입니다.
- Impeccable 감지는 첫 두 테마에서 오탐을 보정할 때까지 경고 전용입니다.
- 자동 Codex hook은 설치하지 않습니다.
- detector는 `tools/impeccable` wrapper로만 실행해 선택 telemetry를 끕니다.
- 사용자 brief와 테마별 `AGENTS.md`가 Impeccable의 일반 취향보다 우선합니다.

## 1. 확인한 기능

공식 skill 4.3.1은 다음을 제공합니다.

- shape, critique, audit, polish, harden, adapt 등 24개 디자인 명령
- typography, color, spacing, motion, interaction, responsive, UX writing 지침
- gradient text, colored glow, 반복적인 AI palette, 과도하게 흔한 font 등 61개 결정론적 규칙
- Codex 프로젝트 skill 지원
- HTML·CSS·TS·JS와 설정한 server template 확장자 감지
- Apache-2.0 라이선스

규칙은 유용하지만 모든 브랜드에 보편적인 법칙은 아닙니다. 예를 들어 특정 font나 시각 표현을 상투적이라고 판단하는 규칙은 의도된 브랜드 선택과 충돌할 수 있습니다. 따라서 탐지 결과를 자동 수정하거나 바로 release 실패로 만들지 않습니다.

## 2. 설치 방식 결정

### 채택

- 공식 GitHub `skill-v4.3.1` release archive를 SHA-256으로 검증
- Codex 프로젝트 skill인 `.agents/skills/impeccable`만 vendoring
- source tag, commit, archive hash와 engine version을 `third_party/impeccable/LOCK.json`에 고정
- Apache-2.0 전문과 NOTICE를 저장소에 포함
- engine 0.1.5 launcher의 checksum 검증 다운로드 경로 확인

### 채택하지 않음

- `npx ...@latest` 설치
- npm package와 skill release version을 같은 version으로 가정
- `.codex/hooks.json` 자동 편집 hook
- detector 결과의 즉시 release 차단
- root 하나의 `DESIGN.md`로 모든 업종 테마를 통일

2026-09-20 확인 시 npm package는 4.1.0이고 최신 skill release는 4.3.1이었습니다. 배포 채널 version이 다르므로 npm version 대신 실제 설치한 skill release와 archive hash를 기록합니다.

## 3. 모노레포 적용 방식

root `.impeccable/config.json`은 `themes/*/*`를 project root로 선언합니다. 각 테마는 다음 파일을 가집니다.

- `PRODUCT.md`: 사용자, 방문 목적, 운영 맥락과 상품 제약
- `DESIGN.md`: 구현된 시각 체계의 설명
- `tokens/*.tokens.json`: 편집하는 디자인 token 단일 원본
- `.impeccable/design.json`: 필요할 때 token에서 생성하는 Impeccable sidecar
- `.impeccable/surfaces/*.md`: 특정 화면의 승인된 방향 계약

`DESIGN.md`의 machine-readable token은 DTCG token JSON에서 생성합니다. 두 파일을 사람이 따로 수정하지 않습니다. Impeccable가 제안한 시각 방향도 형님이 선택하고 token/source diff에 반영돼야 효력이 있습니다.

## 4. G5 PHP 대응

Impeccable built-in 대상에는 일반 `.php`가 없으므로 root 설정에 다음 확장자를 추가했습니다.

```json
{
  "ext": ".php",
  "engine": "html"
}
```

PHP 제어문과 G5 include가 HTML parser 오탐을 만들 수 있습니다. 실제 테마가 생기면 다음 순서로 보정합니다.

1. `src/php`와 실제 render URL 결과를 각각 검사합니다.
2. source에만 발생한 항목과 render에도 발생한 항목을 구분합니다.
3. 실제 결함은 token·markup에서 수정합니다.
4. 의도된 선택이나 parser 오탐만 rule+value+file 범위로 제한해 예외 처리합니다.
5. 전체 rule 또는 theme 전체 ignore는 형님 지시 없이 추가하지 않습니다.

## 5. 실행 정책

```bash
bun run design:calibrate
bun run design:detect -- themes/<category>/<slug>/src
```

자동 hook은 OFF입니다. 디자인 작업의 검사 순서는 다음과 같습니다.

1. Impeccable detector로 정적 상투 표현과 명백한 문제 확인
2. 실제 G5 runtime을 Playwright MCP로 탐색
3. 고정 Linux `@playwright/test`로 기능·시각 회귀 확인
4. 형님이 승인한 Figma frame 또는 local preview와 최종 비교

Impeccable 통과만으로 현대적 디자인이나 UI·UX 완성을 선언하지 않습니다.

## 6. 구현·검증 결과

- skill archive SHA-256 일치
- local Bun 1.4.2로 갱신
- engine 0.1.5 `engine-probe` 통과
- 정상 HTML fixture: 0건, exit 0
- 의도적 문제 fixture: gradient text, dark glow, overused font와 AI palette 감지, exit 2
- 자동 Codex hook: 미설치
- 실제 G5 PHP theme 검증: 첫 테마 전이므로 미실행

## 7. 공식 근거

- [Impeccable 공식 사이트](https://impeccable.style/)
- [공식 GitHub 저장소와 설치·hook 설명](https://github.com/pbakaus/impeccable)
- [skill-v4.3.1 release](https://github.com/pbakaus/impeccable/releases/tag/skill-v4.3.1)
- [공식 skill source](https://github.com/pbakaus/impeccable/blob/skill-v4.3.1/skill/SKILL.md)
- [Apache-2.0 license](https://github.com/pbakaus/impeccable/blob/skill-v4.3.1/LICENSE)
