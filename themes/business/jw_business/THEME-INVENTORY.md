# 공식 basic 반입 기록

- 반입일: 2026-09-21
- 원본: [gnuboard5 v5.6.391](https://github.com/gnuboard/gnuboard5/tree/v5.6.391/theme/basic)
- commit: `148d748c2d3fe60a536966164d1d7dbbe6f9c477`
- 위치: 공식 `theme/basic/` → 이 테마의 `src/php/`
- 전체 **460개** 파일 반입. 459개는 원본 SHA-256과 같고 `readme.txt` 1개만 표시명·개발 버전·설명을 변경했습니다.
- 파일별 경로·원본 hash·반입 hash·분류·검토 상태: [BASIC-INVENTORY.json](docs/BASIC-INVENTORY.json)

| 분류 | 파일 수 | 반입 상태 | 이후 처리 |
| --- | ---: | --- | --- |
| 공통 골격·자산 | 33 | 그대로 상속, readme만 개명 | 개편·출처 검토. 원본 screenshot은 payload 제외 |
| PC 커뮤니티 skin | 103 | 그대로 상속 | 기능 보존·UI 개편 |
| 모바일 골격 | 5 | 그대로 상속 | 공통 제품 규칙 적용 |
| 모바일 커뮤니티 skin | 145 | 그대로 상속 | 모바일 PHP 경로 별도 검증 |
| 영카트 관련 | 174 | 원본 비교용 상속 | `shop_basic`, `shop_side`, 쇼핑 CSS·JS 포함. 빌드 payload 제외 |
| 합계 | 460 | 누락 없이 반입 | 반입 당시 화면 개편 전 |

## 해석 기준

- `theme/basic` 스킨 지정은 현재 테마의 `skin/<기능>/basic`을 가리키는 G5 규칙입니다. `theme/jw_business`로 일괄 치환하지 않았습니다.
- 기본 CSS·이미지·screenshot.png는 원본 확인용이며 최종 디자인·관리자 미리보기가 아닙니다.
- `free`, `qa`, `notice`, `gallery` 등 예시 게시판 선택은 메인 개편 때 사이트 입력 계약으로 대체합니다.
- `theme/` 설치 payload는 build 때 다시 생성합니다. 원본 복제·payload 생성과 실제 G5 설치·실행 확인은 별개입니다.
- `ASSET-MANIFEST.json`은 build된 판매 payload의 정적 자산 270개와 출처·라이선스·SHA-256을 기록합니다.

## 제작 순서

1. 완료: Bun/Vite 빌드로 원본·생성물 경계 확정. 커뮤니티 누락과 영카트 제외 검사.
2. 완료: Tailwind·DaisyUI, Pretendard·Lucide 로컬 자산 연결. 의미 색상·공통 UI 구현.
3. source 완료: 메인 1종, 공통 헤더·G5 메뉴·모바일 메뉴·스크롤 방향별 헤더·푸터 구현. 실제 G5 화면 조정은 설치 시험 지시 때 수행.
4. 다음: 게시판 목록→본문/댓글→쓰기→회원가입 순서로 G5 기능과 UI 구현.
5. 이후: 검증한 섹션과 UI를 재사용해 나머지 페이지·기능·매뉴얼 확장.

Ubuntu 배포·시험은 별도 명시 지시 때 진행합니다.

## 2026-09-21 반입 검사 결과

- 파일 집합·원본/반입 SHA-256: 460개 전부 일치. 의도한 readme 변경 1개를 별도 기록.
- 공식 원본 checkout: `git status --short` 출력 없음, 원본 변경 없음.
- `bun install --frozen-lockfile`: 통과.
- `bun run check`: 계약 15개·토큰 3개·도구 9개, 총 27개 테스트 통과. 계약 검사와 Impeccable 무결성 검사 통과.
- 테마 `tokens:check`: 통과. DaisyUI 색상 변수 참조가 생성 CSS에 유지됨.
- 현재 PHP 208개 `php -l`: Mac CLI PHP **8.5.3**에서 문법 통과. 기준 PHP 8.3 실행 증거가 아님.
- 테마 build: Vite 8.3.0을 Bun 1.4.2로 실행. community 원본 285개와 생성 파일을 합쳐 payload 388개 생성.
- 영카트 174개와 기존 basic `screenshot.png` 제외, 커뮤니티 payload 누락 없음.
- 생성 자산: CSS gzip 21,873 bytes, JavaScript gzip 3,024 bytes, Pretendard WOFF2 92개, 메인 WebP 3개. 자산 manifest 270개 등록.
- `bun run hash:payload`는 경로와 파일 내용을 정렬해 payload 집합 SHA-256을 계산합니다. 같은 source·lockfile에서 build를 두 번 실행한 결과가 `189a722cbb962cc60ded69f35f62361ef8f4e94badb1003896fd2a3e8d3820e4`로 일치했습니다.
- 테마 test 5개 통과. `bun audit --audit-level=high`: 203개 package에서 취약점 없음.
- Impeccable 수동 감지는 신규 스타일의 layout transition 경고 1개를 찾아 수정했습니다. 나머지 15개는 아직 개편하지 않은 basic skin 또는 payload에서 제외하는 영카트 원본입니다.
- 실제 G5 화면·판매 ZIP·Ubuntu 배포: 이번 단계에서 실행하지 않음.
