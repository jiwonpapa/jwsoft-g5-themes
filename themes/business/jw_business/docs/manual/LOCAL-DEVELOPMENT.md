# 로컬 빌드 환경 구축

- 적용 대상: JW-Business 1.0 개발 키트
- 기준 도구: Bun 1.4.2
- 범위: 테마 source 수정·검사·설치 payload 생성
- 제외: 웹서버·PHP·DB·그누보드5 설치와 운영 서버 배포

## 완료 모습

개발 키트를 푼 뒤 한 번의 `bun run setup`으로 고정된 의존성을 설치하고, 테마를 build하고, 자동 검사를 통과해 `themes/business/jw_business/theme/`을 생성합니다.

## 시작 전

1. 개발 키트 원본 ZIP을 보관합니다.
2. macOS·Linux·Windows에 **Bun 1.4.2**를 설치합니다.
3. `bun --version` 결과가 `1.4.2`인지 확인합니다.

Bun은 공식 설치 문서가 안내하는 특정 버전 설치 방식을 사용합니다. 설치 스크립트를 실행할 권한이 없는 환경에서는 시스템 관리자에게 요청합니다.

## 일괄 구축

개발 키트에서 `themes/business/jw_business`로 이동한 뒤 실행합니다.

```sh
bun run setup
```

이 명령은 다음 작업만 순서대로 수행합니다.

1. 개발 키트의 `bun.lock`과 `package.json`을 확인합니다.
2. `bun install --frozen-lockfile`로 정확한 버전을 설치합니다.
3. token, CSS, JavaScript와 G5 테마 payload를 build합니다.
4. TypeScript·unit test·payload 누락·영카트 제외·용량·로컬 자산 계약을 검사합니다.

운영체제 package, Docker, 웹서버, PHP, DB, G5를 설치하거나 시스템 설정을 변경하지 않습니다.

## 명령표

| 명령 | 결과 |
| --- | --- |
| `bun run doctor` | Bun 버전·lockfile·필수 파일·명령·서버 경계를 읽기 전용으로 진단 |
| `bun run setup` | 최초 의존성 설치부터 build·검사까지 일괄 실행 |
| `bun run build` | 수정 source로 `theme/` 재생성 |
| `bun run check` | token drift, typecheck, build, unit test, payload 계약 검사 |
| `bun run hash:payload` | 생성된 `theme/`의 경로·내용 집합 SHA-256 출력 |

## 수정 위치

- PHP·스킨: `src/php/**`
- CSS 원본: `src/styles/**`
- TypeScript 원본: `src/scripts/**`
- 디자인 token: `tokens/theme.tokens.json`

`generated/**`, `build/**`, `theme/**`, `ASSET-MANIFEST.json`은 생성 결과입니다. 직접 수정하면 다음 build에서 사라지며 검사도 실패할 수 있습니다.

## AI 도구로 수정할 때

AI 작업을 시작할 때 개발 키트 루트의 `AGENTS.md`를 읽도록 지정합니다. AI는 `DEVELOPMENT-CONTRACT.json`의 수정·생성·금지 경계와 필수 증거를 따라야 합니다. 비밀번호, DB dump, 회원 자료, SSH key와 운영 서버 접속 정보를 AI 입력이나 source에 넣지 않습니다.

## 확인과 원복

1. `bun run check`가 통과했는지 확인합니다.
2. `bun run hash:payload` 결과를 작업 기록에 남깁니다.
3. 실제 사이트 적용 전 기존 `theme/jw_business`와 사용자 수정 파일을 백업합니다.
4. 문제가 있으면 수정본을 배포하지 않고 보관한 원본 ZIP으로 되돌립니다.

자동 검사는 실제 G5 화면 확인을 대신하지 않습니다. PC·모바일, 라이트·다크, 로그인 상태와 수정한 기능 화면은 별도로 확인합니다.

## 지원 경계

배포된 원본 개발 키트에서 `setup`, `doctor`, `build` 자체가 실패하거나 필수 파일이 누락된 문제는 제품 오류로 접수합니다. Bun 설치 대행, 운영체제 문제, 구매자·AI가 변경한 코드, 외부 패키지 충돌과 웹서버 구축은 제품 지원 범위가 아닙니다.

참고: [Bun 공식 설치 문서](https://bun.sh/docs/installation), [고정 lockfile 설치](https://bun.sh/docs/pm/cli/install), [Bun lockfile 문서](https://bun.sh/docs/pm/lockfile)
