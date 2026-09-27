# G5 개발용 블록 갤러리

Mode: Operate. 테마 제작자가 밝은 작업실과 저녁 개발 환경에서 같은 G5 화면을 비교하고 원본을 복사합니다. 테마의 Pretendard·daisyUI 의미 색상·공통 컨트롤을 유지합니다.

## Direction contract

THESIS: 왼쪽에서 페이지와 섹션을 선택하고, 오른쪽에서 실화면·이전 검토 화면·원본을 확인하는 작업대. 판매용 랜딩 페이지처럼 꾸미지 않습니다.

OWN-WORLD: 기존 jw-light/jw-dark 토큰, Pretendard, 얇은 구분선, 명확한 선택 상태, 텍스트가 읽히는 작업창. 자체 브랜드 컬러를 추가하지 않습니다.

STORY: 메인 7종의 현재 구현을 열고, 메인4의 9개 섹션을 실제 G5에서 탐색합니다. 복사한 PHP는 페이지 안에 독립 배치하며 런타임 include는 생성하지 않습니다.

FIRST VIEWPORT: 224px 선택 목록, 상단 기기·모드·실제 페이지 열기, 두 개의 비교창. 원본 코드는 비교창 아래에서 펼칩니다. 모바일은 선택 목록과 두 창을 세로로 배치합니다.

FORM: 사용자가 승인한 개발용 나란히 비교 갤러리. 기존 토큰을 사용하는 도구 확장이므로 별도 시각 세계 추첨은 적용하지 않습니다. 참고 이미지가 없는 페이지에는 명시적 빈 상태를 표시합니다.

FINISH: unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, DESIGN.md, and every shipping raster carrying its provenance
