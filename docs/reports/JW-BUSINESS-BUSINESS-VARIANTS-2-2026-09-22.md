# 사업소개·사업상세 #2 구현 결과

## 반영 범위

- `/pages/business-list-2.php`: 전략·디지털·공간을 사진과 설명의 좌우 교차형으로 구성. 검토 내용과 제공 자료를 구분하고 상세 또는 분야별 문의 안내로 연결.
- `/pages/business-detail-2.php`: 디지털 서비스의 정보 흐름, 화면 검토, 운영 인계를 서로 다른 블록으로 구성. 정보 흐름은 이미지 속 글자 대신 HTML로 출력.
- 사업소개 #1의 디지털 링크도 새 상세 페이지로 변경.
- 페이지별 제목·설명 메타를 적용. 모바일에서는 교차 순서를 해제하고 사진 다음 설명으로 통일.
- 기존 사진 자산·색상 토큰·페이지 shell을 사용. 신규 JavaScript나 라이브러리는 추가하지 않음. 코어와 DB 스키마 변경 없음.

## 수정 원본

- `themes/business/jw_business/src/php/pages/page.php`
- `themes/business/jw_business/src/php/pages/business-route.php`
- `themes/business/jw_business/src/php/pages/business-list-1.php`
- `themes/business/jw_business/src/php/pages/business-list-2.php`
- `themes/business/jw_business/src/php/pages/business-detail-2.php`
- `themes/business/jw_business/src/styles/company-overview.css`

생성된 `theme/`는 Bun 빌드 결과로 갱신하고 기존 `g5themes.test` 개발 환경에 반영했다.

## 검증 결과

- 테마 `check` 통과: 26 tests / 135 assertions. 토큰·타입·빌드·payload 검사 포함.
- PHP 8.3 문법 검사: 페이지 라우터·공통 사업 shell·신규 본문 2개 통과.
- 실제 Edge 1440×1000 라이트: 사업소개 좌우 교차와 상세 정보 흐름 블록을 직접 스크롤하여 확인.
- 실제 클릭: 사업소개 #2 → 디지털 상세 #2 → 연락처 #1의 디지털 안내 이동 확인.
- 390×844 다크: 두 페이지 전체 화면을 직접 확인. 사진·설명 순서, 문장 줄바꿈, CTA 확인. 두 페이지 모두 문서 가로 넘침 없음.
- 기존 사업소개 #1의 디지털 상세 링크 변경 확인.
- 시험 후 화면 크기 override 해제, 기존 라이트 모드 복원.

## 한계와 다음 작업

이번 완료 범위는 두 페이지 본문과 연결이다. 전체 테마 완료나 판매 ZIP 설치 검증을 의미하지 않는다. 문의 제출은 이번 시험 범위에 포함하지 않았다.

사진은 기존 3개 자산을 재사용하므로 페이지별 사진 다양성은 아직 제한적이다. 사업소개·상세 #3~5와 연락처 #2~5는 별도 구현 대상이다.

다음은 **사업소개 #3 + 공간 사업상세 #3**이다. 소개는 큰 대표 사업과 나머지 목록, 상세는 업무 범위·사양 중심으로 구성해 #1의 격자, #2의 교차형과 구별한다. 공간 상세 구현 후 기존 소개 페이지의 공간 문의 직행 링크를 상세 경유로 정리한다.
