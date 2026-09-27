# 디자인 개발 환경·하네스 구현 결과

작성일: 2026-09-27. 대상: JW-Business 개발 환경 및 검수 도구. 판매 상품 전체 완료 보고가 아닙니다.

## 결과

권고한 Playwright/axe·스타일 검사·G5 시험 환경·블록 갤러리·CI·사무실 개발 반영 명령을 구현했습니다. 기존 기술 스택과 독립 PHP/skin 구조를 유지합니다. 갤러리는 판매 payload에 포함하지 않습니다.

- 실행 화면: [사무실 블록 검토실](https://g5themes.test/__jw-dev/)
- 명령·설정·제약: [하네스 안내](../../harness/ui/README.md)
- 이전 사실 감사: [환경 감사](WEB-DESIGN-ENVIRONMENT-HARNESS-MCP-AUDIT-2026-09-27.md)

## 구현 내역

| 항목 | 구현 |
| --- | --- |
| 화면 수집 | quality 계약에서 홈4+원페이지3을 읽고 4상태, 총28개 수집. 제거된 홈5 거부. font/image decode 후 수집 |
| 실제 검사 | 넘침, 이미지, Lucide, 필수 요소, 직접·상위 요소에서 뒤집힌 제목, Main4 카드 정렬·FAQ·모드 전환, axe WCAG A/AA |
| 기준 이미지 | 고정 Linux Chromium, 승인된 Main4 4종만 등록. 리뷰·PNG hash·원본 digest·OS·브라우저·검토 문서 hash 확인. 자동 기준본 갱신 거부 |
| 실제 G5 | 고정 원본 commit + archive SHA, 별도 Docker PHP/MySQL/Nginx, 공식 설치. PC/mobile query로 G5 분기 실행. 사무실 DB 공유 없음 |
| 갤러리 | 메인7 전체 미리보기, Main4 9개 섹션, 이전 캡처 비교, PHP 복사·필요 자산 안내, PC/모바일·두 모드·오류/재시도 |
| 스타일 | Stylelint 17.15.0, 의미 색상 검사. daisyUI 공급자 정의와 명시된 Main4 작품 견본을 UI 소비 코드와 구분 |
| 스택 | 라이브러리 정확한 버전, package/manifest/Vite entry, browser import, 메인 PHP inline 색상 검사 |
| 반복 작업 | dev:g5: lock·변경 모음·순차 빌드·실패 시 전송 중단·지정 office 경로 rsync·신뢰된 TLS HTTP 확인 |
| 검토 비용 | v2 묶음 digest: 다른 묶음의 등록된 독립 PHP만 제외. 공용 PHP/CSS/JS/chunk/토큰/사진/정책은 보수적으로 공유. 전역 사진 중복·출시 집계 유지 |
| CI | 기반/type/unit/build/생성물/PHP, 스타일, 실제 G5 브라우저, 기존 상품 품질을 각각 표시. 실패를 경고로 변경하지 않음 |
| MCP | 프로젝트 Playwright MCP 0.0.82 고정, Context7 추가. CLI 설정 조회와 Context7 초기화·도구 목록·라이브러리 검색 확인. 새 세션에서 활성 도구 목록 갱신 필요 |
| 디자인 문서 | 현재 토큰 기준 DESIGN·패턴 목록·콘텐츠 길이 기준. 상업용 테마의 분량/다양성/큰 아이콘 사용자 요구가 일반 랜딩 스킬 기본 취향보다 우선 |

Playwright Test 1.63.0, axe Playwright 4.13.0, Stylelint 17.15.0을 root 개발 의존성에 정확한 버전으로 고정했습니다. Linux runner의 npm 전이 의존성도 별도 package-lock으로 고정합니다. 고객 서버에 빌드 도구를 추가하지 않습니다.

## 검증

- 기반 unit **100개 통과**: 계약15 + token3 + tooling10 + 신규 하네스8 + 테마64. root 및 theme typecheck, 구조, build, payload 검사 통과.
- PHP **337개 lint 통과**. 원본과 페이지, 새 하네스 PHP 포함.
- 의도적으로 잘못 만든 넘침·반전·아이콘·사진·필수 카드 누락을 실제 브라우저에서 검출하는 selftest **4상태 통과**.
- Main4 **4상태 자동 검사 통과**. 공통 라이트 primary를 읽을 수 있는 농도로 조정하고 footer·기기 전환 링크 대비를 수정한 후 확인.
- 개발 갤러리 **4상태 검사 통과**. office와 Linux fixture에서 확인. 독립 검토자 지적 3건(참고 위치, 오류 복구, 문자 아이콘)을 수정하고 최종 **ship** 판정.
- Main4 Linux 픽셀 비교 **4상태 통과**. 기준본은 독립 검토자 `/root/harness_finish_reviewer`가 full PNG·과정·footer와 hash를 검토해 수락. 모바일 과정 확대 캡처 오류는 전체 PNG에서 실제 rect를 추출해 해소.
- 메인 전체 검사: **28중 16통과·12실패**. Main1/2는 ARIA·대비, 제품 쇼케이스는 필수 설치 도해 표시 문제. 진짜 실패를 유지합니다.
- 전체 원본 스타일 검사: **고정 색 사용 후보 212건으로 실패**. 다른 시안 내부 그래픽의 정당한 고정 색인지 분류가 필요한 부분도 포함합니다. 이를 모두 실제 UI 결함 수로 단정하거나 전부 예외 처리하지 않았습니다. Main4와 새 갤러리의 개별 검사는 통과합니다.
- 기존 상품 품질: **23페이지에서 36건 실패** 유지. 설계미완21, 필수콘텐츠2, 검토누락6, 도입반복1, 사진재사용3, 소유페이지불일치3.

자동 통과는 디자인 승인·판매 ZIP 설치·로그인/관리자 상태·전체 기능 호환 증거가 아닙니다. 390px 검사는 G5 모바일 분기와 반응형 화면 증거이며 실물 터치 기기 시험은 아닙니다. 다른 6개 메인의 픽셀 기준본을 승인한 것처럼 채우지 않았습니다.

## 강제 차단의 현재 한계

GitHub branch protection을 main에 적용하려 했으나 비공개 저장소 요금제 제한으로 **HTTP403**이 반환됐습니다. 관리자 권한 자체는 있으나 Pro 또는 공개 저장소가 필요하다는 응답입니다. 결제·공개 전환은 하지 않았습니다.

로컬 `.githooks/pre-push`를 이 checkout에 연결했습니다. main 푸시 때 품질·스타일·기반·생성물·실제 브라우저·기준본 검사를 요구하며, 현재 품질 실패로 차단되는 것을 시험했습니다. 작업 브랜치 푸시는 허용됩니다. 이는 GitHub 웹 병합이나 다른 checkout까지 막는 서버 보호가 아닙니다. 판매 패키지는 기존 전역 품질 gate를 계속 따릅니다.

## 원본 다운로드 검증

기존 G5 tag 압축파일 SHA가 현재 다운로드와 맞지 않아 바로 사용하지 않았습니다. 공식 annotated tag가 기존 고정 commit `148d748c2d3fe60a536966164d1d7dbbe6f9c477`을 가리키는 것을 확인하고 commit URL로 고정했습니다. 깨끗한 동일 commit checkout과 archive의 **3,176파일 bytes가 모두 일치**했습니다. 그 검증 후 archive SHA를 `8b623bcd61edaa913ae9b6b37d761fa4987a4be47b0f02337c85a7dd0c568669`로 기록했습니다. G5 코어 변경은 없습니다.

## 반영 범위와 후속 순서

사무실 Ubuntu의 JW-Business 빌드 자산·Main4 PHP·개발 갤러리에 범위를 지정해 반영했습니다. DB·메뉴·다른 저장소는 수정하지 않았습니다. checksum 기반 rsync dry-run에서 내용 차이 없이 시간 정보 차이만 확인했습니다.

다음 상품 개선은 이미 검출된 Main1/2/쇼케이스 결함과 스타일 색상 분류를 해소하고, 각 페이지를 새로 디자인 검토한 뒤 기준본을 추가하는 순서입니다. 지금 보고는 제작 장치 구축 결과이며 7종 디자인 개선 완료 선언이 아닙니다.

참고: [Playwright screenshot 비교](https://playwright.dev/docs/test-snapshots), [Context7 공식 연결 안내](https://github.com/upstash/context7), [Playwright MCP](https://github.com/microsoft/playwright-mcp).
