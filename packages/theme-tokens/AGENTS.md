# Theme tokens package

- 루트 `AGENTS.md`와 공통 플랫폼 표준을 먼저 따릅니다.
- DTCG subset의 검증 계약은 `packages/theme-contracts/schemas/theme-tokens.schema.json`이 소유합니다.
- 생성 파일에는 원본 SHA-256과 직접 수정 금지 문구를 넣습니다.
- Tailwind 변수는 token 원본의 `dev.jwsoft.g5-theme.tailwind` allowlist만 출력합니다.
- 테마별 값과 시각 방향을 이 package에 넣지 않습니다.
