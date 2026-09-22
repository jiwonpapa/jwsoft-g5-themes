# 시작하기

## 목적

이 프로젝트는 그누보드5·영카트5에서 설치 가능한 업종별 통합 테마를 제작하고 판매하기 위한 작업 공간입니다. 각 상품은 디자인만 바꾸는 스킨 묶음이 아니라 헤더·푸터·메뉴·일반 페이지·게시판·회원 기능과 필요한 경우 쇼핑몰 화면까지 하나의 일관된 UI로 제공합니다.

## 현재 상태

- **사용자 지시로 작업 중단(2026-09-22).** 전체 메뉴의 기존 분류 구조를 PC·모바일 모두 복구했습니다. 회사소개 새 페이지는 반영하지 않았으며 재개 지시를 기다립니다. [메뉴 복구·중단 상태](reports/JW-BUSINESS-MENU-RESTORE-2026-09-22.md)

- 메인 2~5 메뉴 묶음 구현·개발 사이트 반영 완료. 독립 PHP 4종, 파일 복사 홈 전환, PC·모바일/라이트·다크 32조합, 회원 HTTP 8경로 검증. 다음은 회사소개 전체 묶음입니다. [메인 결과](reports/JW-BUSINESS-HOME-BATCH-2026-09-22.md)

- 2026-09-22 현재 우선 작업: 독립 PHP 구조 개편 후 미완성 페이지를 **메뉴별 묶음**으로 구현·검증·자동 커밋·푸시합니다. 아래 과거 기록의 partial/recipe/navigation catalog 방식은 폐기되었습니다. 최신 구조는 테마 `docs/STRUCTURE-CONTRACT.md`, 진행 상태는 [메뉴별 구현 목표](plans/JW-BUSINESS-MENU-BATCHES.md)를 따릅니다.

- 사업소개 #5·사업상세 #5 구현·반영. 분야 묶음/과정·산출물 구성, PC·모바일 및 단계·문의 연결 검증. 사업소개·상세 각각 5종 본문 구현 완료(전체 테마 완료 아님). [5차 결과와 다음 범위](reports/JW-BUSINESS-BUSINESS-VARIANTS-5-2026-09-22.md) 참고

- 사업소개 #4·사업상세 #4 구현·반영. 번호형 목록/시연 사례·결과물 구성, PC 라이트·모바일 다크 및 문의 연결 확인. [4차 결과](reports/JW-BUSINESS-BUSINESS-VARIANTS-4-2026-09-22.md) 참고

- 사업소개 #3·공간 사업상세 #3 구현·반영. 대표 사진/사업 목록과 업무 명세형 구성, PC·모바일 시야 및 문의 연결 검증. [3차 결과](reports/JW-BUSINESS-BUSINESS-VARIANTS-3-2026-09-22.md) 참고

- 사업소개 #2·디지털 사업상세 #2 교차형 본문 구현 및 개발 사이트 반영. PC 라이트·모바일 다크와 문의 연결 검증. [구현 결과와 다음 범위](reports/JW-BUSINESS-BUSINESS-VARIANTS-2-2026-09-22.md) 참고

- 사업소개 #1·사업상세 #1·연락처 #1 본문 구현 및 실제 문의 연결 검증. [구현·검증·설정 안내](reports/JW-BUSINESS-BUSINESS-CONTACT-1-2026-09-22.md) 참고

- 기업개요 #5 기록형 개선·반영. #1~5 개별 개선 완료(전체 테마 완료 아님). [5차 결과·다음 사업페이지 순서](reports/JW-BUSINESS-ENFOLD-APPLICATION-5-2026-09-22.md) 참고

- 기업개요 #4 사례형 개선·반영. 문제/검토/남기는 자료와 공간 개념도 구성, PC·모바일 다크 검증. [4차 적용 결과](reports/JW-BUSINESS-ENFOLD-APPLICATION-4-2026-09-22.md) 참고. 다음은 #5 기록형

- 기업개요 #3 현장형 개선·반영. 세 장면 목차·전폭 사진·관찰 내용으로 재구성. PC/모바일 및 reduced-motion 검증. [3차 적용 결과](reports/JW-BUSINESS-ENFOLD-APPLICATION-3-2026-09-22.md) 참고. 다음은 #4 사례형

- 기업개요 #2 자료형 개선·반영. 비교표/준비 목록/상담 펼침과 슬라이더 검증. [2차 적용 결과](reports/JW-BUSINESS-ENFOLD-APPLICATION-2-2026-09-22.md) 참고. 다음은 #3 현장형

- Enfold 연구 적용을 일반페이지 구현으로 전환. 기업개요 #1 정보 띠·사례·협업 과정 개편 및 모바일 체크박스 겹침 수정 반영. [적용 결과·다음 제작 순서](reports/JW-BUSINESS-ENFOLD-APPLICATION-1-2026-09-22.md) 참고

- 검색 정렬 재검증 및 모바일 게시판 검색행 보정 완료. 관리자 모바일 목록 체크박스/분류 겹침 발견. [재검증 결과와 다음 작업 순서](reports/JW-BUSINESS-VERIFICATION-NEXT-2026-09-22.md) 참고

- 입력·버튼 높이를 48px 토큰으로 통일하고 전체검색·새글을 현대화. PC/모바일 실측과 다크 화면 확인 완료. [2차 개선 결과와 남은 범위](reports/JW-BUSINESS-CONTROL-ALIGNMENT-PHASE2-2026-09-22.md) 참고

- 권장 순서 1번의 첫 구현으로 FAQ·1:1 문의 목록/작성/본문/답변을 현대화하고 개발 사이트 반영. 실제 저장·답변·첨부 검증 완료. [1차 개선 결과와 남은 범위](reports/JW-BUSINESS-SUPPORT-PHASE1-2026-09-22.md) 참고. 나머지 G5 레거시 경로 정리는 진행 중

- Enfold의 전체 탐색 메뉴를 직접 클릭·스크롤하여 현재 JW-Business와 비교. [직접 시야 비교 보고서와 URL별 근거](reports/ENFOLD-VS-JW-BUSINESS-VISUAL-2026-09-22.md) 참고. 조사·문서화이며 제품 구현 변경은 없음

- 모바일 메뉴를 전체 화면·대분류 고정·단일 하위 펼침으로 개선하고 실제 G5에 반영. [모바일 메뉴 개선 결과](reports/JW-BUSINESS-MOBILE-MENU-2026-09-22.md) 참고

- 갤러리·가입 단계·로그인 주변 화면·글쓰기·본문·댓글 기본 기능을 개선하고 기존 개발 사이트에 반영. [기본 기능 검증 결과와 미검증 범위](reports/JW-BUSINESS-COMMUNITY-REVIEW-2026-09-21.md) 참고

- 비공개 테마 저장소 초기화
- 공식 `gnuboard/gnuboard5` 원본을 `.runtime/gnuboard5`에 내려받음
- 업종별 테마 디렉터리 `themes/` 준비
- 공통 기술스택·외부 자산·Bun 빌드·테마별 `AGENTS.md` 기준 문서화
- 테마 설치·수정 CS를 줄이기 위한 버전별 온라인 매뉴얼 운영 기준 문서화
- 향후 별도 저장소에서 진행할 `jw-editor` G5 전환 인계 자료 문서화
- 개발 헌법과 여섯 JSON 계약, Ajv strict 검증, 공통 후보 registry와 ADR 골격 구현 완료
- Bun 1.4.2 workspace, DTCG token 생성·drift 검사, 테마 scaffold와 결정론적 ZIP 조립기 구현 완료
- Impeccable 4.3.1 프로젝트 스킬과 수동 디자인 감지 보정 fixture 도입, 자동 hook은 OFF
- 디자인·웹 MCP 평가 완료, Figma 무료 Starter 연결과 Playwright 역할 분리 확정, 실제 Figma 파일 왕복 시험은 아직 전
- 첫 상품 `JW-Business 1.0` 제작 착수(2026-09-21): 공식 basic 전체를 `themes/business/jw_business/src/php`에 반입하고 표시명·개발 버전을 변경
- JW-Business의 Bun/Vite·Tailwind CSS·daisyUI build와 로컬 Pretendard·Lucide 자산 연결 완료. 기존 공통 화면·메인 source는 레거시 G5 CSS·DOM·JavaScript 위에 겹쳐 실제 화면 품질 기준을 충족하지 못해 구현 기준선에서 제외
- 메인용 생성 이미지 3개를 WebP로 최적화하고 프롬프트·출처·checksum을 기록. 외부 사진 다운로드 없음
- 작업 중인 개발 payload 422개를 `g5themes.test`에 적용. 공개 head·공통 shell·기본 게시판 목록/본문/댓글/쓰기·로그인·회원가입 약관/정보입력을 새 DOM과 하나의 ESM으로 교체하고 PC·모바일·라이트/다크 실제 화면을 확인. 개발환경 반영이며 판매 ZIP 설치 시험과 출시 완료 증거는 아님
- 메인 #1을 서로 다른 역할의 7개 섹션으로 재구성하고 루트와 `/pages/home-1.php`가 같은 전용 화면을 사용하도록 연결. 첫 메뉴 `메인`에 #1~#5를 노출하며 #2~#5는 차후 별도 방향으로 제작할 파사드 상태. PC·모바일·라이트/다크와 Astra 재검증 통과
- 공개 영역 레거시 감사와 현대화 실행 계획 작성. 새 화면 양산을 중단하고 route 계약표 → `head.sub.php`/자산 → token/공통 DOM → 네이티브 메뉴 → G5 adapter 순으로 재구축
- 설치 ZIP과 분리할 구매자 개발 키트 표준 수립. Bun 설치 후 `bun run setup`으로 고정 의존성·build·검사를 일괄 수행하고, 구매자용 AI 헌법·기계 판독 계약·doctor 하네스를 JW-Business에 구현
- 출시 구현 범위 확정: 75개 페이지 레이아웃, 게시판 6개·최신글 8개 표현형, G5 커뮤니티 전체, 재사용 섹션·온라인 매뉴얼. 시각 방향은 승인 전
- 기존 판매중단 상품 페이지를 `JW-Business 1.0`으로 교체하는 상품 운영 방향 확정
- 2차와 구성이 다른 3차 PC 라이트 이미지 초안 5장 생성 완료. 두 시안 모두 후보이며 최종 시각 방향은 미승인
- 1·2·3차 비교 후 만든 4차 최초 메인과 상·중·하단 수정본 모두 밀도·여백 문제로 반려. 기능 화면 4장은 보류
- 5차 메인은 깔끔함에 긍정 평가를 받았으나 섹션이 적어 허전하다는 사용자 피드백. 최종 미승인
- 6차 메인 PC 라이트 이미지를 첫 구현 참고로 사용. 이미지 검토에서 실제 제작으로 진행하라는 사용자 지시 반영; 최종 시각 승인을 뜻하지 않음
- 일반 페이지와 함께 배포할 재사용 섹션 라이브러리 구현 초안 작성
- 기존 ASKTHEME B3 상품의 PC·모바일 이미지를 Edge에서 직접 검토해 최신글·게시판·섹션 구성 참고 자료 작성. 데모 도메인 접속 불가로 실제 동작 검증은 제외
- 해외 상위 WordPress 테마의 페이지 제공 방식 조사. 기업개요·인사말·연혁 등 하위 페이지 각각에 4~5개 레이아웃을 제공하도록 정정. 상위 메뉴 6분류를 기준으로 한 30종 집계는 폐기
- Avada·Divi의 사용권·업데이트·지원 기간 비교 완료. SIR 구독형 판매 제한과 기존 구매자 다운로드 권한 확인 전까지 선택적 연장 상품은 미확정
- 월척 운영 결과를 반영해 게시판 목록·본문·댓글 Microdata와 일반 페이지 최소 meta를 출력하는 범위·설정 저장 구조 확정
- 일반 페이지를 G5 내용관리와 분리. catalog에서 `/pages/<page-id>-<1~5>.php` 75개 실 route와 카탈로그를 생성하고, 테마 직접 메뉴·구매자용 `custom/navigation.php` 예시로 연결하는 파사드 구현
- 사무실 Ubuntu에 기존 서비스와 분리된 G5 5.6.391·PHP 8.3.33·MySQL 8.4.11 검증 환경 구축
- Mac mini의 `g5themes.test` hosts·mkcert 신뢰와 Ubuntu Nginx TLS 연결 완료

## 필수 기준 문서

- [JW-Business 테마 작업 지침](../themes/business/jw_business/AGENTS.md)
- [JW-Business 공개 영역 레거시 감사](reports/JW-BUSINESS-LEGACY-AUDIT-2026-09-21.md)
- [JW-Business 레거시 제거·현대화 실행 계획](plans/JW-BUSINESS-LEGACY-MODERNIZATION-PLAN.md)
- [공식 basic 반입·파일 분류·첫 제작 순서](../themes/business/jw_business/THEME-INVENTORY.md)
- [JW-Business 1.0 출시 구현 범위 — 수량·기능·완료 기준](plans/JW-BUSINESS-1.0-IMPLEMENTATION-SCOPE.md)
- [3차 이미지 초안 — 메인·목록·본문/댓글·쓰기·가입](../output/imagegen/jw-business-v3/README.md)
- [1·2·3차 시안 비교와 추천](reports/JW-BUSINESS-DESIGN-COMPARISON-2026-09-21.md)
- [4차 반려 사항·메인 수정본·기능 화면 보류](../output/imagegen/jw-business-v4/README.md)
- [5차 메인 이미지 — 다른 화면은 이번 범위에서 제외](../output/imagegen/jw-business-v5/README.md)
- [6차 메인 이미지 — 5차에 기업 소개·진행 과정 추가](../output/imagegen/jw-business-v6/README.md)
- [JW-Business 1.0 기본 상품 기획안](plans/JW-BUSINESS-1.0-PRODUCT-PLAN.md)
- [재사용 섹션 라이브러리 구현 방안 초안](plans/REUSABLE-SECTION-LIBRARY-DRAFT.md)
- [기존 ASKTHEME B3 화면 직접 검토](research/business/ASKTHEME-B3-VISUAL-REFERENCE-2026-09-21.md)
- [해외 상위 테마의 페이지 변형 조사·방향](research/business/WORDPRESS-TOP-SELLERS-PAGE-VARIANTS-2026-09-21.md)
- [Avada·Divi 라이선스와 JW 업데이트 정책 검토](research/business/AVADA-LICENSE-AND-JW-UPDATE-POLICY-2026-09-21.md)
- [테마 구조화 데이터 출력 계획](plans/STRUCTURED-DATA-OUTPUT-PLAN.md)
- [G5 테마 공통 플랫폼 표준](standards/G5-THEME-PLATFORM-STANDARD.md)
- [테마별 AGENTS.md 템플릿](standards/THEME-AGENTS.template.md)
- [온라인 매뉴얼 운영 표준](standards/ONLINE-MANUAL-STANDARD.md)
- [구매자 개발 키트·AI 개발 헌법·자동 구축 표준](standards/CUSTOMER-DEVELOPMENT-KIT-STANDARD.md)
- [상품 지원 정책](PRODUCT-SUPPORT-POLICY.md)
- [테마 개발 헌법·하네스·공통화 기반 연구](research/common/THEME-DEVELOPMENT-FOUNDATION-RESEARCH.md)
- [공식 G5 theme/basic 기준선](research/common/G5-BASIC-BASELINE.md)
- [G7 유료 테마 경험의 G5 적용 검토](research/common/G7-THEME-LESSONS-TRANSFER-REVIEW.md)
- [디자인·웹 MCP 도입 연구](research/common/WEB-DESIGN-MCP-RESEARCH.md)
- [Impeccable 디자인 스킬 도입 평가](research/common/IMPECCABLE-DESIGN-GOVERNANCE.md)
- [G5 로컬 검증 환경 구축 보고서](reports/G5-LOCAL-RUNTIME-SETUP-2026-09-20.md)

## 별도 제품 인계 자료

- [`jw-editor for G5` 전환 연구](research/common/JWSOFT-EDITOR-G5-PORT-RESEARCH.md)

## 디렉터리 원칙

```text
jwsoft-g5-themes/
├── .agents/skills/       # 고정된 프로젝트용 AI 스킬
├── governance/           # 공통 후보와 변경 거버넌스
├── harness/              # 계약·디자인 보정 fixture
├── packages/             # 공통 계약·tooling·token package
├── .runtime/gnuboard5/   # 공식 원본 로컬 실행본, Git 제외
├── apps/manual/          # 테마 설치·수정 온라인 매뉴얼
├── docs/                 # 공통 정책과 기획
└── themes/               # themes/<category>/<theme-slug>
```

## 다음 작업

1. 메인 2~5 → 회사소개 → 사업 프로세스 → 인재채용 → 고객지원 → 문의 순서로 미완성 페이지를 메뉴별 구현·검증합니다. 홈은 테마의 `index_N.php`, 일반 페이지 70종은 웹루트 `/pages/`입니다.
2. 갤러리·문의·FAQ와 나머지 회원 화면을 같은 기준으로 수직 현대화합니다.
3. 각 게시판 표현형과 회원 skin 설정을 테마 경로로 고정하고 PC·모바일·로그인 상태를 실제 화면에서 확인합니다.
4. 페이지 본문은 각 PHP에서 독립 수정합니다. 재사용 블록은 런타임 밖에서 복사하고 출처 주석을 남깁니다. 본문 partial·dispatcher를 다시 도입하지 않습니다.
5. 남아 있는 공식 basic 상속 파일은 route별 사용 여부를 확인한 뒤 교체하거나 상품 payload에서 제외합니다.
6. 전체 기능 gate와 브라우저 검토 후 판매 ZIP 설치·업데이트·롤백 시험을 별도 실행합니다.

`jw-editor for G5` 구현은 이 저장소의 다음 작업에 포함하지 않습니다. 별도 저장소·상품·CS 범위를 열기로 결정한 때 연구 문서를 인계합니다.
