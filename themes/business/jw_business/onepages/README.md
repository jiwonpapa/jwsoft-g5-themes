# JW Business — 독립 원페이지 3종

7종 메인 메뉴의 개발 시연본이며 **`https://g5themes.test` 사무실 개발 환경의 메인 메뉴에 3종을 연결했습니다.** 기본 홈과 공통 헤더를 사용합니다. 판매 품질 검사는 미통과입니다. [7종 개선·실제 화면 확인 기록](../../../../docs/reports/JW-BUSINESS-MAIN-SEVEN-IMPROVEMENT-2026-09-26.md)

| 파일 | 구성 | 주요 동작 |
| --- | --- | --- |
| `../pages/onepage-showcase.php` | 제품 소개 → 디자인 → 구성 → 도입 검토 → 문의 | Blender 3D 36프레임 스크롤 회전, 회전 정지, 키보드 지원 상세 탭 |
| `../pages/onepage-services.php` | 서비스 범위 비교 → 고객 질문 여정 → 전후 구성 시안 → FAQ → 상담 | 전용 고객 여정 사진, 열린 범위 비교, 고객 관점의 탐색 흐름 |
| `../pages/onepage-projects.php` | 한 공간의 의도 → 개념 동선 → 실내·재료 → 전용 갤러리 → 문의 | 동일 콘셉트의 독립 장면 6장, 동선 도해, Embla 스와이프·버튼·키보드 갤러리 |

각 PHP는 독립된 전체 본문이며 `common.php`, 기존 G5 테마 `head.php`·`tail.php`만 사용합니다. `.jwo` 전용 CSS, 페이지 안으로 제한한 JS를 사용하며 사이트 메뉴 DB는 읽거나 쓰지 않습니다. 페이지 내부 목차는 해당 원페이지 안에서만 이동합니다.

## 배포 경로

- `../pages/onepage-*.php` → G5 웹 루트의 `/pages/`
- `../src/styles/onepages.css`·`../src/scripts/onepages.js` → Tailwind/daisyUI 토큰 및 Vite 빌드 → `/theme/jw_business/css/onepages.min.css`·`js/onepages.min.js`
- CSS·JS URL은 G5의 `get_versioned_asset_url()`로 파일 수정 시각을 붙여 배포 후 브라우저 캐시를 갱신합니다.
- `assets/images/`·`assets/sequence/` → payload 복사 → `/theme/jw_business/onepages/assets/`
- 메뉴에 등록할 주소: `/pages/onepage-showcase.php`, `/pages/onepage-services.php`, `/pages/onepage-projects.php`
- `design/`, 이 README, 개발용 harness와 검토 캡처는 고객 웹 공개 경로에 넣지 않습니다.
- 70개 일반 페이지와 구분하여 원페이지 3종을 카탈로그에 등록했습니다. 상품 빌드는 PHP 3종과 빌드된 CSS·JS·이미지·36프레임을 ZIP 허용 경로에 포함합니다. 실제 판매 ZIP 생성·설치·업데이트·롤백은 전체 품질 차단이 통과한 뒤 검증해야 합니다.

고객 서버에서 Blender, Node, Bun 또는 빌드는 필요 없습니다. 작성된 PHP와 CSS·JS·WebP를 그대로 사용합니다. 문의 버튼은 기존 G5 `/bbs/qalist.php`를 가리키며 실제 접수·회원 권한은 해당 G5 기능을 따릅니다. 새 문의 백엔드나 허위 전송 성공 화면은 만들지 않았습니다.

## 이미지·3D

- `assets/images/node-poster.webp`: 회전 장면과 동일한 Blender 모델의 고품질 대표 이미지.
- `assets/images/courtyard.webp`: 내장 imagegen으로 제작한 가상 공간 콘셉트.
- `assets/images/service-workshop.webp`: 서비스형 전용 고객 여정 작업 장면. 서비스 청사진은 HTML/CSS로 작성했습니다.
- `assets/images/courtyard-interior.webp`, `courtyard-detail.webp`, `courtyard-colonnade.webp`, `courtyard-lounge.webp`, `courtyard-terrace.webp`: 프로젝트형의 한 가상 공간을 서로 다른 거리·시간에서 보여주는 전용 장면입니다.
- 새 이미지 프롬프트: [IMAGE-PROMPTS.md](design/IMAGE-PROMPTS.md). 기존 이미지의 출처·프롬프트는 `../src/assets/images/README.md`에 있습니다.
- `design/node-concept.blend`: Blender 5.2.2에서 만든 독립 편집 원본.
- `design/render-node.py`: 모델·조명·카메라·36프레임을 재생성하는 제작 스크립트. 실행하면 이 폴더의 `.blend`와 중간 PNG를 다시 생성하므로 수정한 모델은 먼저 별도 보관합니다.
- `design/render-node-poster.py`: 같은 모델에서 대표 이미지를 렌더링합니다. 두 렌더 작업 후 `node design/prepare-assets.mjs`로 WebP를 다시 만듭니다(작업 위치: 이 원페이지 폴더, 개발자 도구 `cwebp` 필요).
- `assets/sequence/node-001.webp`–`node-036.webp`: 960×640 회전 장면, 총 약 552KiB. 웹에서는 WebGL·실시간 3D가 아니라 렌더된 이미지를 스크롤 위치에 맞춰 그립니다.

제품 대표 이미지·상세 탭·회전 시퀀스는 동일한 Blender 모델을 사용합니다. 연결부는 부분 확대하고 설치 검토는 반복 각도 대신 공간 관계를 보여 주는 HTML 도해로 구성합니다. 초기 imagegen 제품 콘셉트는 화면에서 사용하지 않고 `design/node-study.webp`에 참고용으로 보관합니다. 판매 제품에 적용할 때는 실제 제품의 사진·동일 모델 렌더·검증된 규격으로 교체합니다. 프로젝트 이미지는 같은 가상 콘셉트의 생성 장면이며 실제 완공 기록이 아닙니다.

## 접근성과 성능

- 3D 묶음은 해당 구간이 가까워졌을 때만 최대 4장씩 동시 로드합니다. 첫 화면에서 36장 전체를 받지 않습니다.
- 767px 이하, `prefers-reduced-motion`, 지원 브라우저의 데이터 절약 설정에서는 회전 묶음을 요청하지 않고 대표 이미지를 보여 줍니다.
- 프레임 로딩 실패·시간 초과 때도 본문과 대표 이미지를 유지합니다. 로딩 완료 뒤에만 긴 고정 회전 구간을 활성화합니다.
- JavaScript가 없으면 탭의 모든 설명이 펼쳐지고, FAQ와 목차·문의 링크 및 수동 가로 스크롤 갤러리는 HTML만으로 사용 가능합니다.
- 자동 갤러리 재생·스크롤 강제 이동·스크롤 가로채기는 없습니다. Embla 갤러리는 이전/다음, 방향키, Home/End 및 스와이프를 지원합니다. 스크롤 연동은 Motion을 사용합니다.
- 회전 정지 버튼, 키보드 포커스, 탭 ARIA 상태, 동작 줄이기 설정 변경에 대한 대체 처리를 포함합니다.

## 검증 및 로컬 확인

저장소 루트에서:

```sh
node harness/jw-onepages/check.mjs
node --check themes/business/jw_business/src/scripts/onepages.js
php -d post_max_size=16M -S 127.0.0.1:8766 harness/jw-onepages/router.php
```

로컬 주소는 `/showcase`, `/services`, `/projects`이며 `?theme=dark`로 기존 다크 토큰을 확인합니다. 이 미리보기는 실제 원페이지와 기존 테마 CSS를 사용하지만 공통 shell은 시험용이고 G5 DB는 연결하지 않습니다. `/capture`는 개발 캡처 저장용이며 loopback에만 바인딩하고 절대 배포하지 않습니다.

기본 확인 범위: PHP 3종 문법, 독립 경로·앵커·이미지 소유 및 상품 경로 등 15개 계약 검사. 화면 및 상호작용 증거는 수정 후 다시 수집해야 하며 이전 결과는 [기존 QA 기록](QA.md)에 구분해 둡니다.

후속 배포 확인: Ubuntu의 실제 G5에서 기본 홈과 메인 7종의 PC·모바일 16경로, 원페이지 자산 46개의 내용 일치를 검증했습니다. 기존 공통 shell에서 3종을 열고 PC·모바일 메뉴를 확인했습니다. 테마·DB 전체 기능, 로그인/게시판 권한 조합, 영카트, ZIP 설치/업데이트/롤백은 여전히 미검증입니다.

디자인 작업에는 impeccable과 frontend-skill을, 신규 시연 이미지에는 내장 imagegen을 사용했습니다. 최종 검토 증거는 저장소 `.impeccable/review/onepages/`에 보관합니다.

상세 기록: [검증 결과](QA.md) · [최종 디자인·경계 기록](DESIGN-NOTES.md).
