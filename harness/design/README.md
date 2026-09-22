# Impeccable detector calibration

Impeccable는 판매 차단 gate가 아니라 디자인 경고 도구입니다. 버전을 바꾸거나 규칙 설정을 수정할 때 다음 명령으로 최소 동작을 확인합니다.

```bash
bun run design:calibrate
```

- `clean.html`: 기본 semantic 구조와 명시적인 focus를 가진 정상 fixture
- `known-bad.html`: gradient text와 과도한 glow를 의도적으로 포함한 탐지 fixture

실제 테마에서 나온 오탐은 규칙 전체를 끄지 않습니다. 먼저 token·markup·rendered page를 확인하고, 필요한 경우 값과 파일까지 제한한 예외만 근거와 함께 기록합니다.
