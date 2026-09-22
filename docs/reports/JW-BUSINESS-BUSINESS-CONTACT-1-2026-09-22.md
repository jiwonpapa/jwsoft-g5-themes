# 사업소개·사업상세·연락처 #1 구현

## 반영 URL

- https://g5themes.test/pages/business-list-1.php
- https://g5themes.test/pages/business-detail-1.php
- https://g5themes.test/pages/contact-1.php

이 세 경로의 파사드를 실제 본문으로 교체했습니다. 다른 변형 #2~5는 이번 구현 대상이 아닙니다.

## 구성

사업소개 #1은 사진 격자, 업무 범위, 협업 예시, 상담 과정으로 구성했습니다. 컨설팅은 상세 #1로, 디지털·공간은 연락처의 해당 분야 안내로 연결합니다. 미완성 상세 #2~3으로 새 링크를 만들지 않았습니다. 다른 기존 페이지의 상세 #2~3 링크는 별도 남은 범위입니다.

상세 #1은 소개, 검토 범위/자료, 가상 접근 사례, 준비 내용과 문의 경로입니다. 연락처 #1은 분야별 안내, 대표 연락처, 운영 시간과 기존 1:1 문의 연결입니다. 새 문의 폼·메일 발송·지도/API는 만들지 않았습니다. 분야별 버튼은 동일한 문의 목록으로 이동하며 분류를 자동 선택하지 않습니다.

공통 진입 파일은 허용된 세 타입의 variant=1만 처리합니다. 페이지별 제목·description·canonical·OG를 설정하고 기존 G5 head/tail 조합을 사용합니다.

## 설정

연락처는 `jw_business_settings()['company']`를 사용합니다. 기존 `custom/site.php`의 company.name/phone/email/address 및 선택적 hours로 덮어씁니다. hours가 없으면 별도 확인 안내를 출력합니다. 현재 개발 사이트의 전화·이메일·주소는 기본 시연 값이며 실제 연락처로 검증된 것이 아닙니다. 대표 연락처는 텍스트로 출력합니다.

## 검증

- 테마 check 통과: 26 tests / 135 assertions, 타입·토큰·빌드·산출물 검사.
- 서버 PHP 8.3: 신규 PHP 4개 문법 검사 통과.
- 기존 개발 사이트에 build payload 반영. 코어·DB 변경 없음.
- 실제 클릭: 사업소개 → 컨설팅 상세 → 연락처 #contact-strategy → 1:1 문의 목록.
- PC 1440px 라이트에서 세 페이지 주요 구간 시야 확인.
- 모바일 390px 다크에서 세 페이지 전체 시야 확인. 모두 가로 넘침 없음. 사업소개 격자 1열 전환 확인.
- 상세 페이지 고유 메타 description 출력 확인.
- 확인 중 현재 위치 중복과 상세 제목/설명 간격을 보정 후 재빌드·반영.
- 문의 신규 작성·저장, 비회원 로그인 복귀, 전화·메일 실제 전송은 이번 검증에 포함하지 않음.

## 변경 원본

pages/page.php, pages/business-route.php, pages/business-list-1.php, pages/business-detail-1.php, pages/contact-1.php, styles/company-overview.css.

## 다음

사업소개 #2와 상세 #2를 사진/설명 교차형으로 구현하여 기존 디지털 분야 연결의 파사드를 제거합니다. 이후 공간 사업 상세 #3와 연락처 변형을 확장합니다. 사진은 아직 기존 세 장을 재사용하며, 판매 데모용 사진 다양화는 별도 남은 작업입니다.
