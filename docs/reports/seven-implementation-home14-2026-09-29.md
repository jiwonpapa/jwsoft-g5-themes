# 메인 1·4 원본 구현 기록 — 2026-09-29

상태: **원본 동결, 예비 배포 8상태 자가 검토와 한 묶음 보완 완료. 통합 재배포·독립 시각 검수 대기**. Astra 구현 담당의 기록이며, 아래 구현 기록을 원장의 verified나 상품 합격으로 대신하지 않습니다. 최종 배포 확인은 root와 별도 Sol 검수 담당이 수행합니다.

## 구현 범위

- 메인1: `src/php/index_1.php`, 현재 복사 방식의 `src/php/index.php`·`src/php/mobile/index.php`, `src/styles/home-one.css`, `src/scripts/home-one.ts`.
- 메인4: `src/php/index_4.php`, `src/styles/home-four.css`, `src/scripts/home-four-entry.ts`.
- 고유 사진 4장과 prompt sidecar. 품질 등록 병합 조각은 [seven-assets-home14](../plans/seven-assets-home14-2026-09-29.json).
- 디자인 기준: [섹션 지도](../plans/seven-correction-home14-2026-09-29.md), [실제 자산 HTML](../prototypes/seven-home14-direction-2026-09-29.html), [PC 기준 화면](../../output/playwright/seven-home14-direction-desktop.png), [모바일 기준 화면](../../output/playwright/seven-home14-direction-mobile.png).
- generated·theme payload·공용 CSS·G5 코어·DB·다른 메뉴는 구현 담당이 수정하지 않았습니다. 배포·빌드·커밋·품질 원장 관리는 root 담당입니다.

## 항목별 조치

| ID | 구현한 내용 | 실제 검수에서 확인할 것 |
| --- | --- | --- |
| M1-01 | 큰 원과 일반 단어를 관찰 질문·근거·우선/보류 이유 3행으로 교체. 단계별 제품 스펙·관리법·콘텐츠 준비의 전후 편집 자료 전환 | 원본 크기에서 근거가 읽히는지, scroll 시작/중간/끝의 실제 자료 차이 |
| M1-02 | ATELIER 컬렉션 PC 시안과 코발트 머그 모바일 상세. 고유 사진 2장, 내비게이션·컬렉션·용량·재료·크기·관리 정보 | 1440·390에서 두 화면 연결과 글자 크기·정보 밀도 |
| M1-03 | 빈 종이·파란 사각형을 DAYLINE 프로젝트 일정 화면으로 교체. 실제 시간·검토 회의·전달물 구성 | F&B·교육 사진 옆의 완성도와 화면 내용 가독성 |
| M1-04 | FAQ 첫 질문 펼침, 기존 자료 준비 메모, 마지막 질문·목표·시점의 문의 브리프. 12개 section·3장 히어로 보존 | FAQ·소식·문의 경계, 실제 G5 latest, 슬라이더 전체 조작 |
| M4-01 | 기존 FORME 제품·협업·웹·브랜드 사진 4장과 브랜드 팔레트 유지. 동일 제품 가족의 추가 사진 2장 | 제품 외형·색·포장 일관성, 모든 사진 로딩 |
| M4-02 | 인계 2×2 아이콘 카드 대신 로고 여백·색상·화면 순서의 가이드 펼침면, 파일 종류별 전달 명세 | 과정 카드와 문구를 가려도 구별되는지, 작은 지면 내용 가독성 |
| M4-03 | Motion scroll로 브랜드 브리프→제품 비교 웹 시안→완성 패키지 자료 전환. 키보드/수동 버튼·mobile/reduced motion 지원 | 실제 시작/중간/끝, 모든 버튼·Arrow/Home/End, reduce/no-JS 내용 보존 |
| M4-04 | FAQ 준비 정보와 문의 브리프 구분, 마지막 구간을 neutral/content 표면으로 마감 | PC/모바일 양 모드의 본문 대비·간격·CTA |

## 공통 항목에 대한 구현 기여

G01·G02: 본문 keep-all·제목 계층·넓은 화면 최대 폭 유지. 메인1 모바일 반복 H2를 34px 수준으로 조정하고 작은 자료 설명을 읽기 크기로 보정. G03: 메인1의 다매체 기업 구성과 메인4 단일 브랜드 과정 구별. G04: 신규 페이지 전용 고유 자산, 동일 경로 본문 반복 없음. G05: 기존 큰 중앙 아이콘 및 아이콘에 한정한 회전 보존. G06: 의미 색상·다크 연결, 작품색은 FORME 자료 내부로 한정. G07: 단순 등장/배경 강조 외 실제 편집 결과·브랜드 자료 전환 추가. G08: 모바일에서 주요 자료 숨김 없이 세로 배치/수동 선택. G09: 기존 12/9개 section 보존. G10: Tailwind4·daisyUI·DTCG·Motion·Embla 및 파일 복사 구조 보존. G11: 모든 브랜드·성과 표현은 가상 시연 문맥 유지, 결제/구독/다운로드 기능을 구현한 것처럼 연결하지 않음. G12: 3슬라이드·아이콘·FAQ·소식·기존4사진·모바일 경로 보존. 공통 항목 전체 verified 판단은 root의 7종 검수에 따릅니다.

## 실행한 검사

- 변경 PHP 4개 `php -l`: 성공.
- 테마 `bun run typecheck`: 성공.
- 테마 `bun run structure:check`: 성공.
- `bun run styles:check -- .../home-one.css .../home-four.css`: 성공.
- 담당 원본 `git diff --check`: 성공.
- 메인1 세 경로의 본문 동등성, 12개 section·3개 hero slide 보존 확인. 메인4 9개 section 보존 확인.
- 기준 HTML은 별도 Playwright `home14` 세션의 1440×1000·390×844에서 캡처했습니다. 실제 G5 화면 검증을 대신하지 않습니다.

## 실제 G5 예비 화면 확인과 보완

root가 신규 사진 복사 목록을 반영하여 재배포한 `g5themes.test`에서 메인1·4 × 1440×1000/390×844 × light/dark 8상태를 별도 Playwright 세션으로 확인했습니다. 첫 화면과 교정 대상 전략·디지털·사례·인계·FAQ·마감 구간을 수집했습니다. 사진 복사 목록 보정 전의 첫 예비 캡처는 증거로 사용하지 않습니다.

- 기록 위치: [예비 화면 수집 스크립트](../../output/playwright/seven-home14-preview-v2/capture.js), [과정 선택 확인 스크립트](../../output/playwright/seven-home14-preview-v2/interact.js). 같은 폴더의 `home1-{1440,390}-{light,dark}-*.png`, `home4-{1440,390}-{light,dark}-*.png`가 각 상태입니다.
- 8상태에서 수평 넘침 0px, 메인1 12개·메인4 9개 section을 확인했습니다. 메인1 신규 사진은 정상 로딩했고, 메인4의 숨겨진 패널 사진은 각 자료 버튼을 선택한 뒤 정상 로딩을 확인했습니다.
- 메인4 자료 0/1/2 버튼을 PC·모바일 각각 선택하여 `data-jw-stage`와 실제 표시 패널이 일치하는 것을 확인했습니다. 예비 캡처는 `home4-{1440,390}-material{0,1,2}.png`입니다.
- **확인 후 원본 보완:** ATELIER 이미지의 HTML 높이 영향 제거(`height:auto`), DAYLINE 사례 하단 캡션 잘림 방지(아래 행 최소 445px), root axe가 발견한 결정보드 글자 대비 2종을 `base-content`로 보정, 인계 명세의 `dl` 자식을 올바른 `dt/dd`로 수정, 모바일에서 감춘 `br` 양옆 단어의 공백 보존.
- **과정 높이 보완:** 메인4 PC 자료 전체 높이가 773/853/969px로 달랐습니다. 원본에서 자료 패널을 590px, 내부 이미지 flex 높이를 제한했습니다. 실제 G5에 같은 CSS를 일시 주입한 사전 점검에서 1440/1280/1000px의 자료 3개 모두 패널 `clientHeight=scrollHeight=590px`, 전체 과정 보드 785px를 확인했습니다. `height-proposed-{0,1,2}.png`는 이 사전 확인이며, 최종 배포 증거가 아닙니다.
- 모바일 FORME 비교 사진은 전체 제품 외형이 보이도록 `contain`으로 수정했습니다. 높이가 짧은 PC 화면은 sticky로 내용을 가리지 않도록 수동 자료 선택을 사용합니다.
- 이 보완 묶음 이후 PHP·typecheck·structure·styles·diff 정적 검사를 다시 통과했습니다. **보완 후 통합 payload의 최종 시각 확인과 axe 재검사는 root/Sol 담당으로 이관했습니다.**

## 동작 수집 선택자

- 메인1: `[data-jw-decision-board]`의 `data-jw-stage=0|1|2`. `[data-jw-decision-select="0|1|2"]` 수동 버튼, `[data-jw-decision-proof="0|1|2"]` 자료. 기존 `.strategy__map.is-visible`, hero와 service hover/focus 선택자 보존.
- 메인4: `[data-jw-forme-story]`의 `data-jw-stage=0|1|2`. `[data-jw-forme-select="0|1|2"]` 수동 버튼, `[data-jw-forme-panel="0|1|2"]` 자료. 너비 1000px 이상·높이 930px 이상·일반 모션에서 sticky/scroll, mobile/짧은 PC/reduce에서는 수동 전환. Arrow/Home/End 키를 구현했습니다. JS 없음에서는 모든 자료를 표시합니다.

## 미실행·승인 경계

source 담당은 빌드·개발 반영·실제 G5 전체 흐름·28상태·판매 ZIP·독립 Sol 검토를 실행하거나 통과로 선언하지 않았습니다. 스크롤 시작/중간/끝의 최종 모션 수집, reduced motion/no-JS/키보드 전체 동작, 히어로 전체 슬라이드 검수도 최종 통합 검수 범위로 남아 있습니다. 위 8상태 예비 자가 점검과 정적 검사는 이를 대신하지 않습니다. 기존 사용자 dirty 파일을 보존했고 구현 담당은 커밋하지 않았습니다.
