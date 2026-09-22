# Enfold 2017 Elements 전체 직접 시야 검토

2026-09-22. 대상: [Enfold Elements](https://kriesi.at/themes/enfold-2017/elements/). JW-Business 비교 리포트의 Elements 근거 부록입니다.

## 결론

Enfold에서 참조할 것은 요소 47종이라는 수보다 **같은 요소의 폭·정보 밀도·배치·이미지 비율·배경을 달리한 실제 사용 예시**입니다. Icon Box, Easy Slider, Magazine, Gallery, Tabs, Testimonials는 각각 한 가지 기능을 여러 페이지 분위기에 맞게 배치하는 모습을 직접 보여줍니다. JW-Business의 섹션 재사용도 이 수준의 시각적 선택지를 목표로 삼는 것이 타당합니다. 관리자 빌더나 외부 서비스 연동을 새 범위로 끌어올 근거는 아닙니다.

이 URL은 2017이라는 이름을 사용하지만 Layerslider에 `ENFOLD MODERN 8.0`이 표시됩니다. 따라서 아래 평가는 **현재 제공되는 데모**에 대한 것이며, 모든 요소가 2017 당시 그대로 존재했다고 증명하는 자료는 아닙니다.

## 실제 확인 방법과 경계

- macOS Edge 실제 브라우저, 1440×1000 viewport.
- 상단 Elements 메가메뉴의 링크를 직접 클릭했습니다. 주소만 일괄 요청하거나 HTML 수집으로 시야 검토를 대체하지 않았습니다.
- Elements 인덱스 1개 + 개별 요소 47개 = **48개 고유 경로 전체**를 열었습니다. 같은 슬라이더를 가리키는 Pages 메뉴 중복은 별도 페이지로 세지 않았습니다.
- 각 경로 첫 화면을 캡처하고 800px 안팎의 휠 스크롤로 하단까지 내려 중간 진입 효과를 발생시킨 뒤 전체 페이지 스크린샷을 직접 검토했습니다. 최종 스크롤 위치와 문서 높이를 기록했습니다.
- 일부 초기 캡처는 로딩·진입 애니메이션 중간 상태입니다. 이를 최종 디자인 결함으로 취급하지 않았습니다. 전체 페이지 캡처에 고정 헤더가 현재 스크롤 위치에 들어가는 현상 역시 캡처 특성입니다.
- 스크린샷은 이번 CUA 도구 이력에 있습니다. 별도의 이미지 파일 아카이브를 저장했다고 주장하지 않습니다.
- Elements 페이지 내부의 모든 외부 링크·모든 슬라이드·모든 폼 전송을 검사한 것은 아닙니다. 폼·메일 구독·공유 전송·구매는 실행하지 않았습니다. 모바일 대표 검토와 JW 현재 화면 비교는 통합 리포트 담당이 수행합니다.

## 48개 경로별 관찰 기록

`높이/끝 위치`는 CSS px이며 소수점은 반올림했습니다. viewport 높이는 1000px입니다. 스크롤 횟수는 기본 하단 순회 횟수이며 재검토·추가 상호작용은 제외합니다. 모든 표 항목은 메뉴 클릭·스크롤·시각 확인을 완료했습니다.

| # | 직접 연 메뉴 | 높이/끝 위치 | 스크롤 | 실제 보인 구성과 판단 |
|---|---|---:|---:|---|
| 1 | [Elements](https://kriesi.at/themes/enfold-2017/elements/) | 2365/1366 | 3 | 사진 히어로 위 편집기 이미지, 중앙 소개, 어두운 배경의 요소 목록, 구독 영역. 기능 카탈로그 자체가 제품 시연 페이지입니다. |
| 2 | [Accordion & Toggles](https://kriesi.at/themes/enfold-2017/elements/accordion/) | 2315/1316 | 2 | 기본 열림, 단일 전개, 복수 전개, 분류형 질문 목록을 나눠 제시합니다. 실제 전개·hash 변경 확인. |
| 3 | [Accordion Slider](https://kriesi.at/themes/enfold-2017/elements/accordion-slider/) | 2633/1633 | 3 | 전폭 세로 이미지 패널, 컨테이너 내부 패널, 인물·작품 패널을 구분합니다. 이미지와 문맥에 따른 다른 규모가 핵심입니다. |
| 4 | [Animated Countdown](https://kriesi.at/themes/enfold-2017/elements/animated-countdown/) | 2674/1674 | 3 | 어두운 사진 위 외곽선, 회색 채움, 검은 외곽선, 유색 배경 흰색 숫자. 초 단위 변화 관찰. |
| 5 | [Animated Numbers](https://kriesi.at/themes/enfold-2017/elements/animated-numbers/) | 2548/1549 | 2 | 큰 3열 실적, 작은 2열 반복, 아이콘 결합 변형. 진입 시 숫자 상승 확인. |
| 6 | [Blog Posts](https://kriesi.at/themes/enfold-2017/elements/blog-posts/) | 3950/2951 | 4 | 큰 대표글·인용·본문 후 2열 글 카드. 제목만 나열하지 않고 미디어·요약·날짜가 계층을 이룹니다. |
| 7 | [Buttons](https://kriesi.at/themes/enfold-2017/elements/buttons/) | 2315/1316 | 2 | 크기·채움·외곽선·색·아이콘 유무를 비교합니다. 모든 색을 JW에 복제할 이유는 없으며 의미 기반 색이 우선입니다. |
| 8 | [Catalogue](https://kriesi.at/themes/enfold-2017/elements/catalogue/) | 2315/1316 | 2 | 작은 사진+제목·설명+우측 가격의 행, 분류 구분선, 2열 단순 목록. 카드 이외의 서비스·항목표 패턴입니다. |
| 9 | [Code Block](https://kriesi.at/themes/enfold-2017/elements/code-block/) | 2315/1316 | 2 | iframe 예제. 최초 회색 공백이었으나 재방문·안정 후 Wikipedia HTML 문서 정상 표시. 오류 추정 철회. |
| 10 | [Color Section](https://kriesi.at/themes/enfold-2017/elements/color-section/) | 2224/1225 | 2 | 전폭 단색·사진 오버레이·기울어진 경계·영상 배경 및 아이콘 행. 배경과 폭으로 장면을 바꿉니다. |
| 11 | [Columns](https://kriesi.at/themes/enfold-2017/elements/columns/) | 3585/2586 | 4 | 1/2·1/3·1/4·1/5, 1/3+2/3, 1/4+3/4, 높이가 같은 연속 유색 열. 열 수뿐 아니라 비율 차이를 보여줍니다. |
| 12 | [Comments](https://kriesi.at/themes/enfold-2017/elements/comments/) | 2315/1316 | 2 | 설명 뒤 실제 댓글·입력 폼은 보이지 않았습니다. 이 페이지를 댓글 완성도 근거로 삼으면 안 됩니다. |
| 13 | [Contact Form](https://kriesi.at/themes/enfold-2017/elements/contact-form/) | 2436/1437 | 2 | 가로 구독, 2×2 견적 입력, 긴 문의 폼·약관·계산식 인증. 외관만 확인, 제출 안 함. |
| 14 | [Content Slider](https://kriesi.at/themes/enfold-2017/elements/content-slider/) | 2315/1316 | 2 | 1열·2열 텍스트 슬라이더. 작은 화살표로 본문 전환. Next 클릭 후 다른 제목 표시 확인. |
| 15 | [Easy Slider](https://kriesi.at/themes/enfold-2017/elements/easy-slider/) | 2768/1768 | 3 | 전폭 히어로, 사진+본문 분할, 회색 설명+사진, 컨테이너형, 기기 목업형. 같은 슬라이더의 활용 변형이 가장 명확합니다. |
| 16 | [Featured Image Slider](https://kriesi.at/themes/enfold-2017/elements/featured-image-slider/) | 2170/1170 | 2 | 큰 이미지 위 제목·설명의 슬라이드가 본문에 포함됩니다. 글의 대표 이미지를 정보 입구로 쓰는 방식. |
| 17 | [Fullscreen Slider](https://kriesi.at/themes/enfold-2017/elements/fullscreen-slider/) | 1795/795 | 1 | viewport를 채운 사진, 투명 헤더, 제목과 2개 CTA 뒤 짧은 소개. 한 장면에 집중한 명확한 위계. |
| 18 | [Gallery](https://kriesi.at/themes/enfold-2017/elements/gallery/) | 2315/1316 | 2 | 작은 썸네일 격자, 큰 미리보기+썸네일 띠, 작은 사진 목록, 큰 사진 변형. 확대·다음 사진·닫기 확인. |
| 19 | [Google Maps](https://kriesi.at/themes/enfold-2017/elements/google-maps/) | 2649/1650 | 3 | 지도 미표시, 본문 좌우 여백 붕괴, 요소 링크가 어두운 배경 아래 세로로 노출. 재방문에서도 재현. 원인은 조사하지 않았습니다. |
| 20 | [Grid Row](https://kriesi.at/themes/enfold-2017/elements/grid-row/) | 1341/341 | 1 | 전폭 4칸→3칸→2칸, 사진·본문·중립 배경이 맞붙는 구조. 떠 있는 카드 없이 장면을 분할합니다. |
| 21 | [Headline Rotator](https://kriesi.at/themes/enfold-2017/elements/headline-rotator/) | 2725/1726 | 3 | 어두운 사진 히어로의 큰 문장 일부가 교체되고, 본문 단색·박스형에도 적용. 실제 문구 변화 관찰. |
| 22 | [Icon](https://kriesi.at/themes/enfold-2017/elements/icon/) | 2315/1316 | 2 | 크기·색이 다른 단일 아이콘, 원형 외곽선 아이콘+설명. 단독 장식보다 주변 정보와의 관계가 중요합니다. |
| 23 | [Icon Box](https://kriesi.at/themes/enfold-2017/elements/icon-box/) | 2315/1316 | 2 | 큰 좌측 원형/비원형, 제목 앞 작은 아이콘, 중앙 아이콘+박스, 중앙 아이콘+무배경. 최소 5개 명확한 배치 계열. |
| 24 | [Icon List](https://kriesi.at/themes/enfold-2017/elements/icon-list/) | 2315/1316 | 2 | 원형 아이콘 연결선 목록, 좌우 반전, 작은 아이콘 3열 목록. 과정·연혁·서비스 목록에 응용 가능한 구조. |
| 25 | [Image](https://kriesi.at/themes/enfold-2017/elements/image/) | 2315/1316 | 2 | 기본 사진, 사진 위 캡션, 원형 이미지 행. 같은 이미지 소스에서도 마스크·캡션으로 목적이 달라집니다. |
| 26 | [Image with Hotspots](https://kriesi.at/themes/enfold-2017/elements/image-with-hotspots/) | 3419/2419 | 4 | 기기 그림과 번호 핀·설명 말풍선, 하단 이미지와 다른 색 핀. 복잡한 제품 설명용이며 범용 회사소개 필수 요소는 아닙니다. |
| 27 | [Layerslider](https://kriesi.at/themes/enfold-2017/elements/layerslider/) | 1583/583 | 1 | 사무실 사진 히어로에서 큰 글자들이 단계적으로 등장. 현재 문구에 MODERN 8.0 표시. 유료 플러그인 도입 권고 근거로 사용하지 않습니다. |
| 28 | [Magazine](https://kriesi.at/themes/enfold-2017/elements/magazine/) | 2315/1316 | 2 | 큰 대표글+작은 썸네일 행, 분류 제목, 2열 잡지형. 최신글 정보 밀도를 달리할 수 있는 실용 패턴. |
| 29 | [Mailchimp Signup](https://kriesi.at/themes/enfold-2017/elements/mailchimp-signup/) | 2315/1316 | 2 | 설명과 이메일 입력을 밝고 어두운 2칸으로 분할. 외부 서비스 연동은 JW 범위 밖. 페이지의 요금 설명은 현재 사실로 검증하지 않았습니다. |
| 30 | [Masonry](https://kriesi.at/themes/enfold-2017/elements/masonry/) | 2315/1316 | 2 | 분류 필터, 이미지+하단 캡션 2열, 더 보기. 이미지 톤과 캡션 형식을 통일합니다. |
| 31 | [Masonry Gallery](https://kriesi.at/themes/enfold-2017/elements/masonry-gallery/) | 2315/1316 | 2 | 서로 다른 세로 길이를 유지한 2열 사진. 글 제목 없이 사진 자체에 집중합니다. |
| 32 | [Notification](https://kriesi.at/themes/enfold-2017/elements/notification/) | 2315/1316 | 2 | 채움 색·라벨·부제·실선/점선 외곽선 변형. 알림 의미를 색만으로 전달하지 않는 기준이 별도로 필요합니다. |
| 33 | [Partner/Logo Element](https://kriesi.at/themes/enfold-2017/elements/partnerlogo-element/) | 2315/1316 | 2 | 4×2 로고 격자와 4개씩 보이는 작은 슬라이더. 고정 격자와 이동형의 차이를 즉시 비교할 수 있습니다. |
| 34 | [Portfolio Grid](https://kriesi.at/themes/enfold-2017/elements/portfolio-grid/) | 2315/1316 | 2 | 2열 사진·캡션·분류·페이지 번호. Photography 선택 후 관련 2개 항목으로 줄어드는 동작 확인. |
| 35 | [Post Slider](https://kriesi.at/themes/enfold-2017/elements/post-slider/) | 2315/1316 | 2 | 2열 최신글은 요약·날짜 포함, 3열 포트폴리오는 요약 제외. 같은 목록도 콘텐츠 종류에 따라 정보량이 다릅니다. |
| 36 | [Progress Bars](https://kriesi.at/themes/enfold-2017/elements/progress-bars/) | 2472/1472 | 2 | 얇은 막대, 움직이는 패턴, 두꺼운 막대, 텍스트 내장형. 진입 시 값과 길이 변화 관찰. |
| 37 | [Promo Box](https://kriesi.at/themes/enfold-2017/elements/promo-box/) | 2315/1316 | 2 | 가로 문구+오른쪽 CTA, 버튼 없는 알림, 유색 버전. 사용처는 명확하지만 외관은 단순합니다. |
| 38 | [Separator/Whitespace](https://kriesi.at/themes/enfold-2017/elements/separatorwhitespace/) | 2315/1316 | 2 | 긴 선·짧은 선·장식 선·순수 여백으로 동일 본문을 분리. 섹션 간격도 재사용 사양이라는 근거. |
| 39 | [Social Share Buttons](https://kriesi.at/themes/enfold-2017/elements/social-share-buttons/) | 2315/1316 | 2 | 테두리 분할, 아이콘만, 제목 없는 구성. 공유 실행은 하지 않았습니다. |
| 40 | [Special Heading](https://kriesi.at/themes/enfold-2017/elements/special-heading/) | 2315/1316 | 2 | 옆으로 선이 이어진 제목, serif italic+부제, 중앙형, 좌측형. 페이지 성격을 타이포로 구분합니다. |
| 41 | [Sub Menus](https://kriesi.at/themes/enfold-2017/elements/sub-menus/) | 5498/4499 | 5+1 | 긴 문서에 구간별 하위 메뉴가 있으며 스크롤 중 헤더 아래 고정 상태 관찰. 예제 본문은 반복이라 실제 편집 완성도의 모범은 아닙니다. |
| 42 | [Tab Section](https://kriesi.at/themes/enfold-2017/elements/tab-section/) | 4030/3030 | 4 | 이미지 탭·아이콘 탭·하단 텍스트 탭·배경색 전환의 4계열. bbPress 탭 선택 후 이미지·제목·본문 전환 및 hash 확인. |
| 43 | [Tables](https://kriesi.at/themes/enfold-2017/elements/tables/) | 3700/2701 | 4 | 3열 가격표, 강조 열, 테두리 유무, 좌측 항목명 비교표, 일반 데이터 표. 긴 소개 페이지에서 카드 반복을 피하는 대안. |
| 44 | [Tabs (Content Tabs)](https://kriesi.at/themes/enfold-2017/elements/tabs/) | 2315/1316 | 2 | 상단 가로 탭·좌측 세로·우측 세로·패널 배경 유무. No Icon Tab 2 클릭 후 본문 변경 및 hash 확인. |
| 45 | [Team Member](https://kriesi.at/themes/enfold-2017/elements/team-member/) | 2315/1316 | 2 | 큰 팀 단체사진과 3열 개인 초상, 직책·소개. 사진 촬영 톤이 전체의 일관성을 뒷받침합니다. |
| 46 | [Testimonials](https://kriesi.at/themes/enfold-2017/elements/testimonials/) | 3592/2593 | 4 | 인물+본문 격자, 최소형, 박스형, 작은 슬라이더, 큰 중앙 슬라이더. 동일 콘텐츠의 5가지 배치 계열. |
| 47 | [Text Block](https://kriesi.at/themes/enfold-2017/elements/text-block/) | 2360/1360 | 2 | H1~H6, 본문·목록·드롭캡. 특수 위젯 이외 기본 문서 타이포도 별도 시연합니다. |
| 48 | [Video](https://kriesi.at/themes/enfold-2017/elements/video/) | 2315/1316 | 2 | 첫 영상 영역은 검은 화면, 두 번째 YouTube는 썸네일·재생 버튼 표시. 재생·미디어 호환성까지 확인한 것은 아닙니다. |

## JW에 반영할 수 있는 구체적인 원리

| 관찰 근거 | JW 섹션 설계에서 권고할 기준 | 범위 경계 |
|---|---|---|
| Easy Slider·Fullscreen·Featured Image | 슬라이더 엔진의 개수가 아니라 전폭 히어로·본문 안 이미지·비대칭 이미지/본문이라는 배치 변형을 만듭니다. | 현재 채택한 라이브러리를 활용하며 새 상용 플러그인 도입이 필요하다는 뜻은 아닙니다. |
| Icon Box·Icon List | 아이콘 왼쪽 행·상단 중앙·번호/연결선 목록을 별도 패턴으로 정의합니다. | 모든 서비스를 같은 3열 카드로 출력하지 않습니다. |
| Magazine·Catalogue·Post Slider | 최신글·서비스 정보는 대표 1개+작은 목록, 요약 행, 정보표, 사진 중심형으로 구분합니다. | 기존 게시판 데이터를 표시하는 테마 범위에 머뭅니다. |
| Grid Row·Columns·Color Section | 넓은 장면과 좁은 읽기 영역, 다른 열 비율과 여백을 조합해 리듬을 만듭니다. | 고정 화면 폭·거대한 반복 빈 공간을 그대로 옮기지 않습니다. |
| Gallery·Masonry Gallery | 섹션 사진은 균일 격자·미리보기+썸네일·사진 비율을 유지한 조합 중 목적에 맞게 선택합니다. | 사진 업로더나 미디어 관리 시스템을 함께 개발하지 않습니다. |
| Tab Section·Tabs | 사업군을 병렬로 비교할 때 선택 항목·본문 변화를 명확히 합니다. | 긴 본문을 숨기기 위한 무의미한 탭은 추가하지 않습니다. |
| Testimonials·Team Member | 후기/인물은 이미지·인용·소속의 위계를 유지하고 배치만 바꿉니다. | 실적·고객·후기를 실재 정보처럼 새로 만들지 않습니다. |
| Elements 카탈로그 | 구매자가 화면을 보고 섹션을 고를 수 있게 실제 샘플·식별명·복사할 파일 범위를 함께 제공합니다. | 관리자 페이지 빌더가 아니라 배포 소스와 온라인 매뉴얼입니다. |

일관성은 모든 섹션을 같은 모양으로 만드는 것이 아닙니다. 공통 타이포·색·컨테이너·버튼·이미지 톤을 유지하면서 **정보 구조와 장면 크기**를 바꾸는 방식입니다. 반대로 Enfold의 매우 흐린 본문 색, 긴 전체 사이드바 때문에 생기는 큰 빈 영역, 지도 예제의 표시 이상까지 모범으로 취급해서는 안 됩니다.

## 추가 상호작용 증거

1. Accordion: `Funky`를 클릭하자 기존 패널이 접히고 다른 내용이 열렸으며 URL에 `#toggle-id-2`가 생겼습니다.
2. Gallery: 첫 썸네일을 클릭해 `1 / 10` 라이트박스 확인, 다음 버튼으로 다른 사진 확인, 닫기 버튼으로 본문 복귀.
3. Portfolio Grid: `Photography` 선택 후 두 개 항목과 활성 분류 표기 확인.
4. Content Slider: 첫 Next 클릭 후 다른 제목·본문으로 전환 확인.
5. Tab Section: `bbPress Forums` 선택 후 장치 이미지·제목·본문이 바뀌고 `#bbpress-forums` 확인.
6. Content Tabs: `No Icon Tab 2` 선택 후 본문과 활성 탭 변화, `#tab-id-2` 확인.
7. Countdown·Numbers·Headline Rotator·Progress Bars는 전후 화면에서 값·문구·막대 변화 확인. 모든 설정 조합을 검증한 것은 아닙니다.

## 보조 정적 감지 기록

독립 평가 B로 다음을 실제 실행했습니다. 이 결과는 위 브라우저 평가와 별개입니다.

```text
.agents/skills/impeccable/scripts/impeccable detect --json themes/business/jw_business/src/php/pages/company-overview
exit code: 0
JSON: []
```

검출 0건입니다. 대상은 PHP 본문 5종이 있는 디렉터리이며 공통 CSS/JS·렌더링 결과 전체가 아닙니다. 따라서 디자인 품질, Enfold와의 동등성, 접근성, 모바일, 동작의 통과 증거가 아닙니다. 검출 항목이 없어 항목별 오탐 판정은 해당하지 않습니다. `.impeccable/critique/ignore.md`는 존재하지 않았습니다.

독립 B용 새 Edge 탭에서 실제 `https://g5themes.test/pages/company-overview-1.php`도 열어 본문 계층과 페이지 연결을 확인했습니다. 브라우저 오버레이는 이번 비교 보고서의 수동 보조 검출 범위에 포함하지 않았으며, 오버레이 결과를 생성했다고 주장하지 않습니다. 제품 소스·런타임·설정은 수정하지 않았습니다.
