# G7 유료 테마 경험의 G5 적용 검토

- 상태: G7 저장소 읽기 전용 검토 완료
- 기준일: 2026-09-20
- 대상: `JW-Business 1.0`과 이후 G5 유료 테마

## 결론

G7 테마 구현을 G5에 그대로 옮기지 않습니다. 두 제품의 템플릿 구조와 런타임이 다르므로, G7에서 효과가 확인된 **상품·소스·검증 원칙만 선별**하고 G5의 공식 `theme/basic`, PHP 템플릿과 PC·모바일 skin 구조로 다시 설계합니다. G7 코드는 복사하지 않습니다.

## 항목별 판단

| G7에서 확인한 경험 | 판단 | G5 적용 |
| --- | --- | --- |
| 공식 basic 소스를 버전 고정해 테마 안으로 반입 | 채택 | 지원할 공식 G5의 `theme/basic` 전체를 새 slug 폴더로 복제하고 기준 버전·파일 inventory를 기록 |
| 활성 테마 하나만으로 선언한 공개 기능 제공 | 채택 | 다른 유료 테마나 개발 package에 런타임 의존하지 않는 독립 ZIP 제공 |
| 메인 외 회원·게시판·검색·상태 화면까지 상품화 | 채택 | 영카트 제외 시에도 G5 커뮤니티 기본 기능과 PC·모바일 skin 전체를 처리 |
| 공통화는 두 번째 테마의 실제 중복 뒤 결정 | 채택 | build·contract는 공통화하되 PHP·JS 런타임은 두 테마에서 재사용을 확인한 뒤 승격 |
| 정적 검사, 실제 설치, 브라우저 확인을 별도 증거로 취급 | 채택 | 검사 통과만으로 G5 설치·화면·판매 준비 완료를 선언하지 않음 |
| 변경 영향에 비례한 검증 | 채택 | 문서 변경 때문에 전체 브라우저 검사를 돌리지 않고, source·package·G5 화면·release gate를 구분 |
| G7 라우트·컴포넌트 목록 | G5식 변환 | G5에서는 `theme/basic` 파일과 skin inventory를 기준으로 `개편·상속·제외`를 기록 |
| G7 레이아웃 편집기의 메뉴·푸터 위젯 | 변환 후 제한 적용 | G5 기본 메뉴관리와 테마 파일을 사용하며 별도 페이지 빌더·범용 관리자 편집기를 만들지 않음 |
| 고객 편집 원본의 keep 정책 | G5식 변환 | 고객 수정 파일 덮어쓰기 위험을 매뉴얼·변경 파일 목록·업데이트 절차로 관리 |
| React·JSON UI·editor-spec·G7 adapter | 제외 | G5 PHP 템플릿과 공개 전역·함수 계약에 맞지 않아 반입하지 않음 |
| Page Builder·Site Part 연동 | 제외 | G5 테마 상품 범위 밖이며 별도 제품 의존성을 만들지 않음 |
| G7 콘텐츠 팩 계약과 모듈 API | 제외 | 현재 G5 테마에는 데이터 주입 제품을 포함하지 않음 |
| G7의 npm·Python 하네스 구현 | 제외 | G5 저장소의 Bun 기반 계약·패키징 도구만 유지하고 실행 환경은 별도 판단 |

## G5에 반영할 실행 규칙

1. 구현 지시를 받은 뒤 공식 G5 `theme/basic` 전체를 `theme/<theme-slug>` 형태의 상품 원본으로 복제합니다.
2. 복제 직후 기준 버전, 원본 파일 목록과 checksum을 기록합니다.
3. 원본 파일마다 `개편`, `그대로 상속`, `상품 범위 제외`를 지정하며 누락을 허용하지 않습니다.
4. 영카트 제외 여부처럼 상품 범위를 `theme.config.php`, 상품 문서와 검증표에 같은 내용으로 기록합니다.
5. G5 코어·DB schema를 수정하지 않고 테마 폴더 안에서 처리합니다.
6. 실제 설치·Ubuntu 배포·브라우저 검증은 형님의 명시적 지시 뒤 현재 환경을 먼저 확인하고 수행합니다.

## 참조한 G7 자료와 한계

읽기 전용으로 다음 현재 문서를 검토했습니다.

- `/Users/neojins/workspace/jwsoft-g7-themes/AGENTS.md`
- `/Users/neojins/workspace/jwsoft-g7-themes/docs/constitution.md`
- `/Users/neojins/workspace/jwsoft-g7-themes/docs/theme-foundation-and-editing-contract.md`
- `/Users/neojins/workspace/jwsoft-g7-themes/docs/theme-harness.md`
- `/Users/neojins/workspace/jwsoft-g7-themes/docs/verification-policy.md`

G7의 과거 구현 경험은 판단 자료이며 G5 호환 증거가 아닙니다. G5 판매 완료 판단은 G5 기준 소스, 실제 설치와 화면 검증으로 새로 확보합니다.
