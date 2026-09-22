# JW SOFT G5 Themes

그누보드5·영카트5용 업종별 통합 테마를 개발하고 독립 상품으로 배포하기 위한 비공개 저장소입니다.

## 저장소 경계

- `themes/`: 업종별 테마 상품
- `packages/`: manifest 계약과 공통 개발 도구
- `harness/`: 디자인 규칙 보정 fixture와 Ubuntu G5 검증 환경
- `governance/`: 공통화 후보와 결정 기록
- `docs/`: 공통 규약, 기획과 검증 문서
- `.runtime/gnuboard5/`: 공식 그누보드5 로컬 개발 원본. Git에는 포함하지 않습니다.

그누보드5 원본은 수정 배포본이 아니라 테마 개발·호환성 확인용 기준 실행 환경입니다. 테마 상품은 원본 코어 수정 없이 설치할 수 있어야 합니다.

시작 문서: [docs/START-HERE.md](docs/START-HERE.md)

## 현재 기반 검사

```bash
bun install --frozen-lockfile
bun run check
bun run design:calibrate
```

`bun run check`는 여섯 JSON 계약, token 생성·drift, 테마 scaffold와 결정론적 ZIP allowlist 회귀를 검사합니다. 디자인 감지는 아직 경고 전용입니다.

Ubuntu의 G5 기준 환경은 [`harness/runtime/g5themes-test`](harness/runtime/g5themes-test)에 정의되어 있습니다. 현재 `https://g5themes.test`에서 G5 5.6.391, PHP 8.3.33, MySQL 8.4.11 조합을 실행합니다. 설치·검증 결과는 [환경 구축 보고서](docs/reports/G5-LOCAL-RUNTIME-SETUP-2026-09-20.md)에 기록했습니다.
