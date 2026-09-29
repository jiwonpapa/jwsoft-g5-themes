# 메인 2·3 교정 구현 기록 — 2026-09-29

구현 작업: `/root/astra_home23` (지정 Astra/xhigh). 상태: 원본 구현·교정·개발 화면 8상태 재확인 완료. 마지막 지도 동작 시점 재확인과 독립 Sol 검토 대기. 이 문서는 품질 원장이나 독립 검토를 대체하지 않습니다.

## 설계와 자산

- [구현 전 실제 자산 기준·전체 섹션 지도](../plans/seven-correction-home23-2026-09-29.md)
- [신규 래스터 등록 조각](../plans/seven-assets-home23-2026-09-29.json): 3개 고유 원본, home-2 2개와 home-3 1개.
- built-in ImageGen으로 판단 검토 보드·운영 인계 도서·FIELDNOTE 완성 편집물을 제작했습니다. 1536×1024 결과를 원본 크기로 직접 열어 선택한 뒤 cwebp 품질 88로 변환했습니다. 정확한 프롬프트, 실제 생성 원본 경로, sha256, owner, createdAt/acquiredAt/tool을 각 WebP sidecar에 기록했습니다.
- Impeccable `embed-prompt`를 새 3개 WebP에 실행했습니다. 해당 형식의 도구 결과는 `sidecar fallback for this format`이며 `--scan` 결과는 **3 rasters, 0 missing**입니다. 픽셀 파일 안에 프롬프트가 삽입됐다고 보고하지 않습니다.
- 안내 체계는 기존 단순 inline SVG를 새 고유 `src/assets/home-three/wayfinding-atlas.svg`의 완성 평면으로 교체했습니다. 중앙 홀·매표·대기·WC·엘리베이터·무단차 경로와 출구/승강장/환승이 연결됩니다. 실제 시설 안내로 사용하지 않는 가상 시안 표시를 유지합니다.

## 항목별 구현

| ID | 구현한 변경 | 소스 / 상태 |
| --- | --- | --- |
| M2-01 | 재료 테이블 대신 ORBIT 판단 검토 보드를 주인공으로 배치. 질문·서비스·CTA 관계와 1440px 중심 정렬, 세 장 제어 유지 | index_2.php, home-2.css / implemented |
| M2-02 | 4개 과제의 위치·축·근거·범위·판단 시점을 가진 지도 한 번. 인계는 실제 도서 사진과 문서별 명세로 교체 | index_2.php, home-2.css / implemented |
| M2-03 | 실제 내비·분류·프로젝트 사진·서비스 비교표·준비 흐름을 갖춘 ORBIT HTML 시안. 마지막 중복 팀 사진을 삭제하고 해당 사진을 화면의 한 맥락에서만 사용 | index_2.php, home-2.css / implemented |
| M2-04 | 지원하지 않던 아이콘 이름을 실제 번들 Files/ShieldCheck로 교체해 세 열 모두 같은 기준선. 과정은 입력/결과 작업 일지, 문의는 구체적인 상담 준비 브리프로 구성 | index_2.php, home-2.css / implemented |
| M3-01 | 제목을 사진 밖 편집형 제목 띠로 분리. 어두운 오버레이를 삭제해 중요 사인을 보존 | index_3.php, home-variants.css / implemented |
| M3-02 | 잘못된 3열 제목 구도를 넓은 1.3fr/.7fr 두 열로 교체. 제목/자료 사이 공백 정리 | index_3.php, home-variants.css / implemented |
| M3-03 | 시설 위치와 접근성 경로가 있는 안내 지도, 편집된 실제 인쇄물, 사진·날짜·유형·장소·시간이 있는 FIELDNOTE UI | index_3.php, home-variants.css, 신규 자산 / implemented |
| M3-04 | 유지할 네 기존 사진을 각각 한 번 사용. primitive 매체 카드 3개를 실제 편집물과 매체별 설계 명세로 교체. CTA 우측은 작업 의뢰 준비 내용 | index_3.php, home-variants.css / implemented |

## 공통 항목 대응

| ID | 이 작업의 대응 | 남은 검증 |
| --- | --- | --- |
| G01 | Pretendard·제목 keep-all/balance·구간별 글자 위계. 큰 글자로 자료를 대체하지 않음 | 실제 폭별 줄바꿈 |
| G02 | Main 2 중앙 1440px copy/image grid와 36px 이상 간격, CTA inline-flex. Main 3 2열 제목 | 1440/1920/2560 및 768 원본 화면 |
| G03 | M2 판단→시안→도서, M3 사인→인쇄→전시→프로그램으로 구별 | 7종 쌍별 비교는 root |
| G04 | 신규 3개 자산 owner·origin·권리 기록. 기존 파일명 바꿔 복제하지 않음. 네 M3 사진 모두 보존 | 품질 중복 검사와 실제 적합성 |
| G05 | 의미 있는 Lucide만 사용. 증거 3열 전체 지원 아이콘·동일 정렬 | SVG 실제 표시 |
| G06 | 사이트 표면·글자·행동은 daisyUI 의미 색. 고유 작품의 종이/잉크는 자료 내부에만 사용 | 2페이지 전체 다크 |
| G07 | M2 관찰 질문→조건 비교→선택 자료 전환. M3 현 위치→A/B/C 실제 지도 경로와 도착 표지 연결 | 시작·중간·끝 및 버튼 |
| G08 | 390 이하에서 목업 navigation 재배치, 표/지도 정보 보존, 문의 세로 배치 | 360/390/430와 실제 기기 경계 |
| G09 | M2 9개 / M3 8개 최상위 구성과 정보 역할 유지 | 전체 흐름 검토 |
| G10 | 독립 PHP·Tailwind @apply·DTCG·Motion·Embla 유지. 오래된 대상 CSS를 교체하여 누적 override 제거 | root build/stack 검증 |
| G11 | 가상 브랜드·정성 비교·인터뷰 질문·화면 시안 명시. 새로운 예약·거래 기능 없음 | 오인 가능성 시각 검토 |
| G12 | 기존 main5 제거·사용자 dirty files 보존. generated/theme·공유 원장·공유 자산 등록 직접 편집 없음 | 회귀와 최종 원장 갱신은 root |

## 동작 수집 계약

- 신규 entry 연결: `src/scripts/home-three.ts`의 `initializeHomeThree()`를 공통 `theme.ts`에서 호출합니다(root 담당).
- Main 2: `[data-jwh2-priority-scroll]`, 상태 `data-priority-step=0|1|2`. 951px 이상, 일반 동작에서 실제 질문 카드 → 조건 비교표 → 선택 실험 내용이 전환됩니다. `[data-priority-label]` 버튼은 키보드로도 선택할 수 있고 수동 선택 후 스크롤 자동전환을 중단합니다. 모바일·reduced motion·JS 없음에서는 세 자료가 정적 공개됩니다.
- Main 3: `[data-jwh3-wayfinding-scroll]`, 상태 `data-route-step=a|b|c`. 일반 데스크톱 스크롤에서 A 출구 → B 승강장 → C 환승의 경로가 그려지고 해당 도착 표지가 연결됩니다. 모바일은 `[data-jwh3-route]` 버튼 직접 선택. reduced motion·JS 없음은 모든 경로를 정적으로 표시합니다.
- 새 동작에 별도 수제 스크롤 리스너/타이머를 만들지 않았습니다. Motion scroll을 사용합니다. 기존 M2 Embla·autoplay 제어는 보존했습니다.

## 원본 검사

- PHP 문법 2개: 통과.
- `bun run typecheck`: 통과.
- `bun run structure:check`: 통과.
- 루트 `bun run styles:check`: 통과.
- 소유 원본의 `git diff --check`: 통과. root 예비 빌드에 복사된 과거 3줄 trailing whitespace는 다음 build로 없어지는 생성물 차이이며 직접 수정하지 않았습니다.
- Impeccable 수동 detector 1회: DESIGN.md의 제한된 타이포 ramp와 실제 섹션/작품 내부 크기의 불일치 advisory를 반환했습니다. 원본 글자 크기를 일괄 축소해 경고를 숨기거나 예외를 추가하지 않았습니다. detector는 시각 승인 수단이 아닙니다.

## 검증 경계

이 작업은 구현 전 1440/390 light/dark 핵심 기준 화면, 최신 G5 before 확인, 원본 검사와 개발 반영 후 실제 2페이지 8상태를 포함합니다. 넓은 폭과 공식 전체 UI 검사는 root가 별도로 시행합니다. 아래 재확인 결과가 상단의 초기 대기 상태보다 우선합니다. 독립 Sol 검토, quality:complete, 상품 전체 및 ZIP 설치는 별도입니다.

## 개발 화면 예비 검토와 한묶음 교정

- root 예비 배포 후 `g5themes.test`에서 본인 전용 Playwright context로 Main 2/3 × 1440/390 × light/dark의 8개 전체 화면과 각 5개 핵심 구간을 수집했습니다. 원본 크기의 지도·디지털 화면·인쇄물·문의 구간을 확인했습니다. 기록 위치: `output/seven-home23-runtime-20260929/`.
- Main 2 여정/인계 사진의 HTML `height=1024`가 CSS의 비율 설정과 함께 남아 세로로 과도하게 잘리는 결함을 발견했습니다. 두 selector에 `height:auto`를 명시하여 의도한 비율을 복구했습니다.
- root의 예비 axe 결과에 따라 Main 2 선택되지 않은 좌표 전체에 주던 opacity를 제거했습니다. Main 2/3 문의 구간은 primary-content 의미 색을 불투명하게 사용하도록 바꿨습니다.
- 기존 strategy/mobility 이미지의 실제 1672×941 크기를 PHP에 맞췄습니다. Main 2/3의 시연 안내에 “실제 고객 실적이나 성과를 뜻하지 않습니다.”를 복원했습니다.
- 이 묶음 이후 `styles:check`, `typecheck`, PHP 2개 문법과 소유 원본 diff 공백 검사를 다시 통과했습니다. 새 구조 변경 없이 원본을 동결했으며, 재배포 후 최종 화면/동작 검토를 기다립니다.
- 초기 개발 화면 콘솔의 유일한 리소스 오류는 기존 `/favicon.ico` 404였습니다. 페이지 JavaScript 오류와 자산 누락의 최종 측정은 후속 결과에 기록합니다.

## 교정 반영 후 실제 재확인

- `final-home{2,3}-{1440,390}-{light,dark}.png` 8개 전체 화면과 40개 구간 화면을 새로 수집했습니다. 모든 상태에서 실제 테마 속성 일치, 가로 넘침 **0**, 이미지 누락 **0**, 페이지 JavaScript 오류 **0**입니다. 수치 결과: `output/seven-home23-runtime-20260929/final-results.txt`.
- 실물 인계 도서의 비율 복구, 라이트/다크 디지털 시안과 모바일 CTA를 원본 캡처로 재확인했습니다.
- 실제 스크롤에서 M2 `0 → 1 → 2`, M3 `a → b → c` 상태가 순서대로 바뀝니다. 수동 버튼으로 초기 상태 복귀도 확인했습니다. reduced-motion 전환 시 M2 세 자료 모두 노출, M3 세 경로 opacity 모두 1로 노출됩니다. 결과: `motion-results.txt`, 각 페이지 `motion-scroll-{0,1,2}.png`, `motion-reduced.png`.
- M3의 마지막 스크롤 단계가 지도 중심을 지나간 후에 도착 표지만 보여주는 타이밍 한계를 발견하여, 변경 범위를 지도 target/offset에 한정해 추가 교정합니다. 콘텐츠·섹션·자산 변경은 없습니다. 이 새 동작에 대한 마지막 재확인 후 상태를 기록합니다.

- 390px 모바일에서도 M2는 세 판단 자료가 정적으로 표시되고, M3 C 버튼 선택은 `data-route-step=c`와 `aria-pressed=true`로 연결됨을 확인했습니다. `home3-mobile-route-c.png`에 실제 경로와 선택 표지를 기록했습니다.
- M3 추가 교정은 Motion target을 `.jwh3-wayfinding-v2`, offset을 `["start 0.5", "start 0"]`로 한정했습니다. TypeScript 검사 통과 후 재동결했습니다.
