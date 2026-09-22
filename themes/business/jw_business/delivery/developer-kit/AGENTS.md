# JW-Business 1.0 구매자 개발 헌법

이 파일은 구매자가 AI 코딩 도구로 JW-Business를 수정할 때 사용하는 최상위 작업 지침입니다.

## 작업 전 순서

1. 이 파일을 읽습니다.
2. `themes/business/jw_business/PRODUCT.md`에서 상품 범위를 확인합니다.
3. `themes/business/jw_business/delivery/developer-kit/DEVELOPMENT-CONTRACT.json`에서 명령과 경계를 확인합니다.
4. 요청에 필요한 source만 읽고 수정 대상·완료 조건·검사를 먼저 정합니다.
5. `bun run doctor`가 실패하면 구현을 시작하지 않습니다.

## 수정 헌법

- 직접 수정은 `src/**`와 `tokens/theme.tokens.json`에서 합니다.
- `generated/**`, `build/**`, `theme/**`, `ASSET-MANIFEST.json`은 명령으로 생성하며 손으로 고치지 않습니다.
- 그누보드5 코어와 DB schema를 수정하지 않습니다.
- 사이트별 도메인·전화번호·게시판 ID·비밀번호·API key를 source에 고정하지 않습니다.
- 원격 CDN과 새 외부 패키지는 명시적인 검토 없이 추가하지 않습니다.
- 테마 기능을 페이지 빌더·예약·CRM·에디터·업로더로 확대하지 않습니다.
- 기존 동작을 지우거나 파일을 대량 교체하기 전에 변경 이유와 원복 방법을 남깁니다.
- AI가 실행하지 않은 build·검사·브라우저 확인을 완료했다고 기록하지 않습니다.

## 표준 명령

```sh
bun run setup
bun run doctor
bun run build
bun run check
bun run hash:payload
```

`setup`은 lockfile 설치, build, 자동 검사를 한 번에 실행합니다. 웹서버·PHP·DB·그누보드5는 설치하지 않습니다.

## 완료 보고

- 무엇을 왜 바꿨는지
- 직접 수정한 source 파일
- 생성된 파일과 payload hash
- 통과한 자동 검사
- 실제 G5에서 확인한 화면과 확인하지 않은 화면
- 업데이트 때 보존하거나 다시 적용할 사용자 수정

AI가 수정한 결과는 구매자가 검토해야 합니다. 구매자 또는 AI가 만든 커스터마이징의 설계·디버깅은 테마 제품 결함 지원에 포함되지 않습니다.
