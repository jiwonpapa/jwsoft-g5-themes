# JW SOFT 구매자 개발 키트 표준 v1.0

- 상태: JW-Business 1.0부터 적용
- 목적: 구매자가 서버 구축 없이 테마 source를 안전하게 수정·build하도록 지원
- 기준 도구: Bun 1.4.2

## 1. 배포 구조

상품 다운로드는 역할이 다른 두 산출물을 제공합니다.

| 산출물 | 대상 | 포함 | 필요 환경 |
| --- | --- | --- | --- |
| 설치 ZIP | 일반 구매자·운영 서버 | 완성된 G5 테마, 라이선스, checksum, 설치 안내 | G5가 지원하는 PHP 환경 |
| 개발 키트 ZIP | 직접 수정하는 구매자·개발자·AI 도구 | source, 고정 lockfile, 필요한 공통 package, 개발 헌법, 계약, 하네스 | 로컬 Bun 1.4.2 |

설치 ZIP은 계속 독립 실행형입니다. 개발 키트는 선택 사항이며 운영 서버에 업로드하지 않습니다. 두 ZIP을 섞어 `node_modules`, 내부 문서, 테스트 fixture가 운영 서버에 들어가지 않게 합니다.

## 2. 자동 구축 경계

개발 키트는 Bun 설치 이후를 한 명령으로 구축합니다.

```sh
bun run setup
```

`setup`의 고정 순서는 다음과 같습니다.

1. Bun 정확한 버전과 개발 계약 확인
2. `bun install --frozen-lockfile`
3. token·CSS·JavaScript·G5 payload build
4. typecheck·unit test·payload·자산·용량 검사
5. 생성 위치 안내

Bun 자체를 개발 키트가 자동으로 내려받거나 관리자 권한으로 설치하지 않습니다. 공식 설치 절차는 OS와 보안 정책에 따라 구매자가 한 번 수행합니다. Docker, PHP, DB, Nginx, Apache, mkcert와 G5 서버는 이 명령의 범위가 아닙니다.

## 3. AI 개발 구성

각 개발 키트는 다음 세 계층을 반드시 포함합니다.

### 사람과 AI가 읽는 헌법

루트 `AGENTS.md`에 읽기 순서, 직접 수정 위치, 생성 파일, 코어 금지, 외부 의존성, 검사와 완료 보고 형식을 적습니다. 내부 개발용 `AGENTS.md`를 그대로 유출하지 않고 구매자에게 필요한 내용만 배포합니다.

### 기계 판독 계약

`DEVELOPMENT-CONTRACT.json`에 다음을 고정합니다.

- 상품 slug·버전과 Bun 버전
- setup·doctor·build·check 명령
- 필수·수정 가능·생성·금지 경로
- AI가 남겨야 할 증거
- 원본 개발 키트 지원 범위와 커스터마이징 제외 범위

### 실행 하네스

- `bun run doctor`: 버전·lockfile·파일·명령·다른 package manager lockfile을 읽기 전용 검사
- `bun run check`: source에서 payload를 다시 만들고 계약·type·test·용량 검사
- `bun run hash:payload`: 수정 결과의 재현 가능한 집합 hash 출력

문서의 금지 문구만 믿지 않고 doctor와 check가 가능한 항목은 실제로 실패시킵니다.

## 4. 개발 키트 디렉터리

```text
jw-business-developer-kit/
├── AGENTS.md
├── DEVELOPMENT-CONTRACT.json
├── README.md
├── package.json
├── bun.lock
├── bunfig.toml
├── packages/
│   ├── theme-contracts/
│   └── theme-tokens/
└── themes/business/jw_business/
    ├── PRODUCT.md
    ├── package.json
    ├── theme.manifest.json
    ├── src/
    ├── tokens/
    ├── scripts/
    ├── tests/
    ├── generated/
    ├── theme/
    └── docs/manual/LOCAL-DEVELOPMENT.md
```

공통 package는 해당 테마 build가 실제 사용하는 것만 넣습니다. 다른 상품 source, 내부 연구, 운영 주소·계정, `.runtime`, 디자인 원본, release credential은 넣지 않습니다.

## 5. 지원과 CS

지원 대상은 배포한 원본 개발 키트의 명령 오류, lockfile 불일치, 필수 파일 누락과 문서 오류입니다. 다음은 테마 결함 CS에서 제외합니다.

- Bun과 운영체제 설치·복구 대행
- 구매자 또는 AI가 수정한 코드의 구현·디버깅
- 외부 package 추가와 버전 변경
- 웹서버·PHP·DB·G5·도메인·SSL 구성
- 수정본의 접근성·보안·브라우저 호환성 보증

AI 사용 여부로 지원을 구분하지 않습니다. 원본 개발 키트에서 재현되는지로 판정합니다.

## 6. 릴리스 게이트

- macOS·Ubuntu·Windows 중 지원한다고 명시한 OS에서 `bun run setup` 실제 실행
- 네트워크가 필요한 최초 설치와 이후 재build를 구분해 기록
- 동일 source·lockfile의 payload hash 반복 일치
- 개발 키트에 다른 상품·비밀값·운영 정보·`node_modules` 없음
- 설치 ZIP에 개발 키트 파일 없음
- 구매자용 `AGENTS.md`와 `DEVELOPMENT-CONTRACT.json` 명령 일치
- 온라인 매뉴얼을 처음 보는 사람이 문서만으로 setup·build·원복 수행

현재 JW-Business는 macOS에서 하네스 명령을 구축한 단계입니다. 최종 개발 키트 ZIP 조립과 OS별 실사용 검증은 상품화 단계에서 완료합니다.

## 7. 근거

- [Bun 설치](https://bun.sh/docs/installation): macOS·Linux·Windows 설치와 특정 버전 설치
- [bun install](https://bun.sh/docs/pm/cli/install): `--frozen-lockfile` 재현 설치와 `bunfig.toml`
- [Bun lockfile](https://bun.sh/docs/pm/lockfile): `bun.lock` 커밋 권고와 lockfile 동작
