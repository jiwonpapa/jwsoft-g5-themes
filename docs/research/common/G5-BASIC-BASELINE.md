# 공식 G5 `theme/basic` 기준선

- 확인일: 2026-09-20
- 로컬 공식 checkout: G5 `v5.6.391`, commit `148d748c2d3f`
- 테마 표기 버전: Basic Theme `3.0.0`
- 라이선스 표기: LGPL-2.1
- 파일 수: 460개
- 상태: 읽기 전용 조사, 상품 테마 복제 미실행

## 조사 결과

공식 `theme/basic`은 메인 PHP 몇 개만 있는 골격이 아닙니다. PC·모바일 공통 골격, 커뮤니티 skin, 영카트 skin과 자산을 함께 가진 전체 기준 테마입니다.

| 영역 | 공식 기준선에서 확인한 내용 |
| --- | --- |
| 공통 골격 | `_common.php`, `index.php`, `group.php`, `head.php`, `tail.php`, sub head·tail, `theme.config.php` |
| PC 커뮤니티 skin | board basic·gallery, connect, content, FAQ, latest 5종, member, new, outlogin, poll, popular, QA, search, visit |
| 모바일 커뮤니티 skin | board basic·gallery, connect, content, FAQ, latest 3종, member, new, outlogin, poll, popular, QA, search, visit |
| 영카트 | PC·모바일 shop 골격, 상품·분류·검색·배너·후기·문의·관련상품 skin |
| 자산 | PC·모바일 CSS, 이미지와 테마용 JavaScript |

## 구현 때 적용할 방법

1. 형님의 구현 지시를 받은 시점의 지원 G5 버전을 다시 확인합니다.
2. 그 버전의 `theme/basic` 전체를 새 테마 slug로 복제합니다. 현재 460개라는 파일 수는 버전이 바뀌면 다시 산출합니다.
3. 원본 경로와 checksum을 `THEME-INVENTORY.md`로 생성합니다.
4. 각 파일을 `개편`, `그대로 상속`, `상품 범위 제외`로 분류합니다.
5. `JW-Business 1.0`은 영카트를 상품 범위에서 제외하되, 제외 파일과 `theme.config.php` 설정을 명시적으로 기록합니다.
6. 테마 폴더 밖에서 제공되는 CAPTCHA·에디터·알림·권한 오류 같은 G5 공통 흐름도 실제 화면 검증표에 포함합니다. 이를 처리하려고 G5 코어를 수정하지 않습니다.

파일 수와 디렉터리 목록은 구현 완료 증거가 아닙니다. 판매 완료는 분류 누락이 없고, 선언한 PC·모바일 기능과 상태가 실제 G5에서 같은 디자인 체계로 동작할 때 판정합니다.
