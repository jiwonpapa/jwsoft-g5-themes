# Theme Contracts Agent Guide

- 이 package는 테마 상품 구조의 기계 판독 계약만 담당합니다.
- schema는 JSON Schema Draft 2020-12와 Ajv strict mode에서 통과해야 합니다.
- 새 필드는 실제 소비자와 검증 목적이 없으면 추가하지 않습니다.
- schema 변경에는 통과 fixture와 실패 fixture를 함께 추가합니다.
- 오류 메시지는 파일 경로, instance path와 실패 이유를 포함합니다.
- 테마 런타임 코드와 디자인 값을 이 package에 넣지 않습니다.

필수 검사:

- `bun run contracts:check`
- `bun run contracts:test`
