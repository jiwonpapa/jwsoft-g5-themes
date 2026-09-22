# ADR-0001: JW-Business의 daisyUI 신규 배포 유예 적용

- 상태: 승인
- 날짜: 2026-09-21
- 영향 테마: `business/jw_business`
- 관련 후보: 없음

## 문제

공통 기술 표준의 초기 조사표는 daisyUI 5.7.42를 기록했으나 실제 설치 시점에 이 버전은 `bunfig.toml`의 `minimumReleaseAge = 259200` 조건을 충족하지 못했다. 유예를 해제하면 새 패키지를 즉시 상품 build에 넣게 된다.

## 결정

동일한 5.7 계열에서 3일 유예를 통과한 최신 버전 5.7.40을 `JW-Business 1.0`에 exact pin한다. `corporate`와 `business` theme, 허용한 컴포넌트만 생성 CSS에 포함한다. 5.7.42 이상 전환은 유예 통과 뒤 build·G5 화면 gate를 다시 실행하는 별도 변경으로 다룬다.

## 검토한 대안

- `minimumReleaseAge` 예외: 저장소의 공급망 완충 정책을 이 테마 때문에 약화하므로 채택하지 않았다.
- daisyUI 제거: 라이트·다크 의미 색상과 공통 form·button 기반을 다시 구현하게 되어 기존 결정과 맞지 않는다.
- 5.7.40 채택: 같은 minor 계열이고 현재 정책을 통과하므로 채택했다.

## 영향

공통 표준의 조사 당시 최신 버전과 이 테마의 구현 버전이 patch 2개 차이 난다. 고객 서버에는 패키지를 설치하지 않으며 생성 CSS만 배포한다. 버전 차이는 `theme.manifest.json`, lockfile, NOTICE에서 확인할 수 있다.

## 검증

- Bun/Vite build와 lockfile 재현
- `corporate`·`business` 외 theme 미포함 검사
- `tw:`·`d-` 접두사와 G5 기존 CSS 충돌 검사
- 전체 라이트·다크 브라우저 회귀
- 업데이트 전 `bun audit --audit-level=high`
