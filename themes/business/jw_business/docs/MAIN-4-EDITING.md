# Main 4 수정 안내

Main 4는 한 개의 PHP 파일에 본문 9개 섹션을 담은 완성형 홈입니다. **설치된 테마의 문구·링크·사진 교체에는 Bun이나 Node.js가 필요하지 않습니다.** 스타일·아이콘·동작 원본까지 변경할 개발자만 별도 개발 환경에서 빌드합니다. 고객 서버에는 빌드 도구를 설치하지 않습니다.

이 안내는 2026-09-27 Main 4 구현을 대상으로 합니다. 전체 테마 판매 ZIP의 설치·업데이트·복구 검증이나 출시 완료를 뜻하지 않습니다. 디자인 기준은 [MAIN-4-DESIGN.md](MAIN-4-DESIGN.md), 테마 구조는 [STRUCTURE-CONTRACT.md](STRUCTURE-CONTRACT.md)를 따릅니다.

## 1. 수정 전 파일 구분

| 작업 | 저장소·개발 키트의 수정 원본 | 빌드 결과 / 고객 설치 위치 |
| --- | --- | --- |
| 본문·문구·링크 | `src/php/index_4.php` | `theme/index_4.php` / `<G5>/theme/jw_business/index_4.php` |
| 메인 전용 스타일 | `src/styles/home-four.css` | `theme/css/home-four.min.css` / 설치 테마의 `css/home-four.min.css` |
| 아이콘·등장 동작 | `src/scripts/home-four-entry.ts` | `theme/js/home-four.min.js` 및 `theme/js/chunks/` / 설치 테마의 같은 경로 |
| 사진 4장 | `src/assets/home-four/*.webp` | `theme/assets/home-four/*.webp` / 설치 테마의 `assets/home-four/` |
| 사진 출처·프롬프트 | `src/assets/home-four/README.md` | 개발 기록. 사이트 실행 중 로드하지 않음 |
| 테마 의미 토큰 | `tokens/theme.tokens.json` | `generated/`를 거쳐 CSS에 포함 |
| 빌드 연결 | `vite.config.ts`, `scripts/build-payload.ts` | `build/vite/` 중간 결과와 `theme/` 설치 payload |

위 저장소 경로는 `themes/business/jw_business/` 기준입니다. `<G5>`는 고객 사이트의 그누보드 설치 루트입니다.

개발 저장소의 `theme/`, `generated/`, `build/vite/`는 다시 생성되는 결과이므로 손으로 수정하지 않습니다. 고객이 개발 키트 없이 설치본 PHP·사진을 수정할 때는 별도 백업과 변경 기록을 보관합니다. 이후 원본 빌드나 업데이트로 그 파일을 덮어쓰면 고객 변경도 사라질 수 있습니다. 변경한 PHP·사진을 개발 원본에도 반영한 뒤 다음 패키지를 만들어야 합니다.

## 2. 고객: Main 4를 첫 화면으로 선택

1. 설치 테마의 현재 `index.php`와 수정할 사진을 사이트 바깥에 백업합니다.
2. `<G5>/theme/jw_business/index_4.php`를 같은 폴더의 `index.php`로 복사합니다.
3. 사이트 첫 화면에서 문구·사진·문의 링크·모바일 배치를 확인합니다.

새 설정 스위치나 dispatcher를 만들지 않습니다. 복사한 `index.php`가 현재 홈의 독립 본문입니다. 이후 `index_4.php`만 수정하면 복사본에는 자동 반영되지 않으므로, 실제 홈으로 쓰는 `index.php`에도 동일한 수정이 필요합니다. 복사 과정에서 PHP 상단의 G5 초기화·자산 등록과 마지막 `tail.php` 연결을 보존합니다.

## 3. 고객: 문구와 링크 수정

설치본 PHP의 `<!-- 01. ... -->`부터 `<!-- 09. ... -->`까지 주석으로 위치를 찾습니다. 개발 저장소에서는 같은 내용의 `src/php/index_4.php`를 수정합니다.

| 섹션 | 주로 바꿀 내용 | 유지할 연결 |
| --- | --- | --- |
| 01 커버 | 제목, 소개, 사진 설명, 브랜드 이름 | 과정 링크 `#h4-process`, 브랜드 링크 `#h4-brand`, 문의 URL |
| 02 과정 | 네 단계 제목·설명·산출물 | 발견/설계/제작/인계 앵커, `01`–`04` |
| 03 발견 | 질문, 관찰, 목표, 관계도 문구 | `id="h4-discovery"`, `data-jwh4-work-product="brief"` |
| 04 설계 | 고객 여정 네 단계와 접점 | `id="h4-strategy"`, `data-jwh4-work-product="journey"` |
| 05 제작 | 제공 서비스와 HTML 웹 시안의 문구 | `id="h4-digital"`, `data-jwh4-work-product="prototype"` |
| 06 브랜드 | 브랜드 이름, 캡션, 색상 이름 | `id="h4-brand"`, 사진·워드마크·컬러의 일치 |
| 07 인계 | 실제 제공할 파일과 가이드 설명 | `id="h4-handoff"`, `data-jwh4-work-product="handoff"` |
| 08 FAQ | 네 질문과 답변 | `details > summary`와 답변 영역 구조 |
| 09 문의 | 마지막 안내와 문의 링크 | 실제 상담 페이지 URL |

본문 맨 위와 마지막 문의 버튼은 기본적으로 `<?php echo G5_URL; ?>/pages/contact-1.php`로 연결됩니다. 실제 문의 페이지가 달라지면 두 위치를 함께 바꿉니다. 과정 카드 네 개는 각각 `#h4-discovery`, `#h4-strategy`, `#h4-digital`, `#h4-handoff`로 이동합니다. 섹션 ID를 바꿀 경우 링크도 함께 바꿉니다.

FORME 웹 시안의 메뉴·컬렉션 문구와 인계 파일 카드는 설명용입니다. 실제 쇼핑·다운로드 기능이 연결되어 있지 않습니다. 고객 사이트에서 제공하는 서비스와 산출물에 맞게 문구를 바꾸십시오.

문구만 바꿀 때는 `class`, `id`, `data-*`, `aria-*`, PHP 태그를 보존합니다. HTML의 `&`는 `&amp;`로 작성합니다. `<br>` 앞뒤 공백도 확인하십시오. PC에서 보이는 줄바꿈이 모바일에서 숨겨지면서 한국어 단어가 붙을 수 있습니다. 긴 문구는 카드 제목·본문·하단선의 정렬을 다시 확인합니다.

## 4. 고객: 사진 교체

| 설치 테마의 파일 | 화면에서 쓰는 곳 | 현재 원본 규격 |
| --- | --- | --- |
| `assets/home-four/hero.webp` | 첫 화면 제품 사진 | 1536×1024 |
| `assets/home-four/discovery.webp` | 디자이너 작업 사진 | 1536×1024 |
| `assets/home-four/digital.webp` | HTML 웹 시안 안의 캠페인 사진 | 1536×1024 |
| `assets/home-four/handoff.webp` | 브랜드 결과물·패키지 사진 | 1536×1024 |

같은 파일명·형식으로 교체하면 PHP 경로를 바꿀 필요가 없습니다. 다른 파일명이나 크기를 쓰면 해당 `<img>`의 `src`, `width`, `height`, `alt`를 함께 고칩니다. `hero.webp`의 `fetchpriority="high"`, 나머지 사진의 `loading="lazy" decoding="async"`는 유지합니다. 파일명을 바꾸면 브라우저에 남은 이전 이미지 캐시를 피하기 쉽습니다.

현재 사진은 3:2 원본을 각 섹션 틀에서 크롭합니다. 커버는 기본 `object-position:70% center`, 작업 사진은 `45% center`, 디지털 사진은 중앙을 사용합니다. 얼굴·라벨·용기 끝이 잘리지 않는 사진을 준비하고 PC·모바일 양쪽에서 확인합니다. 이미지를 좌우 반전하면 제품 글자도 뒤집힙니다.

네 장은 같은 가상 브랜드를 설명하지만 장면은 각각 다릅니다. 새 브랜드로 바꿀 때 사진뿐 아니라 FORME 문구, 대체텍스트, 워드마크와 색상 견본까지 맞춥니다. 다크 모드에서도 작품 자체의 색은 유지됩니다. 사이트 UI까지 작품 색으로 바꾸는 작업은 별도 스타일 변경입니다.

원본 PNG 보존 위치·생성 프롬프트·출처는 [사진 README](../src/assets/home-four/README.md)에 있습니다. 기존 사진은 Main 4 소유 자산입니다. 다른 페이지 재사용은 [품질 규칙](../quality/README.md)을 위반합니다. 개발자가 사진을 교체하면 `quality/assets.json`에 원본 계열·소유 페이지·새 SHA-256을 기록하고 빌드로 `ASSET-MANIFEST.json`을 재생성합니다. 기존 검토의 해시만 새 값으로 바꿔 승인 기록을 재사용하지 않습니다.

## 5. 개발자: 스타일·아이콘·동작 변경

전용 CSS는 [home-four.css](../src/styles/home-four.css), JavaScript 원본은 [home-four-entry.ts](../src/scripts/home-four-entry.ts)입니다. 공통 색상은 `theme.css`의 `jw-light`/`jw-dark`와 DTCG 의미 연결을 상속합니다. Main 4의 미세 조정은 `.jwh4` 범위에서 처리하며 다른 페이지로 확장하지 않습니다.

아이콘 이름은 PHP의 `data-h4-icon`에서 선택합니다. 현재 import된 Lucide 아이콘 간 교체는 PHP에서 가능하지만, 새 종류를 쓰려면 entry의 import와 `icons` 목록에 추가하고 빌드해야 합니다. `data-h4-icon`용으로 등록하지 않은 이름은 그대로는 표시되지 않습니다. 키보드 focus, `aria-hidden`, 80px/60px 과정 아이콘 크기를 함께 확인합니다.

Motion `inView`는 `.h4-reveal`에 등장 클래스를 붙이고 CSS가 이동을 실행합니다. CSS hover/focus는 카드와 아이콘에만 적용합니다. 제목·사진을 회전시키거나 본문을 JavaScript 실행 전 숨기지 않습니다. 줄인 동작 설정에서 애니메이션이 제거되는 기존 처리를 유지합니다.

현재 Vite entry는 `home-four`이고 CSS 분할을 사용합니다. PHP는 `home-four.min.css`와 `home-four.min.js`를 페이지에서만 등록하며 CSS 수정 시각을 두 URL의 버전값으로 사용합니다. 공통 shell 번들은 따로 필요합니다. 변경된 JS와 `js/chunks/`를 한 묶음으로 배포하십시오. JS만 바꾸는 경우에도 기존 캐시가 남지 않는지 확인합니다.

개발 checkout의 최초 의존성 설치는 저장소 루트에서 실행합니다.

```sh
bun install --frozen-lockfile
```

그다음 `themes/business/jw_business/`에서 빌드·검사합니다. 이 명령은 고객 서버의 실행 요건이 아닙니다.

```sh
bun run structure:check
bun run build
bun run tokens:check
bun run typecheck
bun run test
bun run check:build
bun run quality:check
```

`build`는 토큰 생성 → Vite 자산 생성 → 설치 payload 조립 순서이며 `theme/`를 재생성합니다. 전체 `check`에도 품질 검사가 포함됩니다. 다른 페이지나 묶음 증거 때문에 `quality:check`가 실패하더라도 경고로 바꾸거나 범위를 줄이지 않습니다. 수정 검증과 전체 상품 완료는 별도입니다.

## 6. 수정 후 확인과 복구

- 실제 G5에서 PC·모바일, 라이트·다크로 첫 화면부터 문의까지 확인합니다. 가로 넘침, 카드·발견 메모 정렬, 문구가 붙는 줄바꿈, 사진 크롭을 봅니다.
- 네 과정 카드와 두 문의 링크, 브랜드 결과물 링크를 실제로 열고 FAQ를 펼칩니다. 키보드 focus와 줄인 동작 설정도 확인합니다.
- 브라우저에서 사진·CSS·JS·공유 chunk 오류가 없는지 확인합니다. 파일 수정만으로 배포·실화면 검증을 완료했다고 기록하지 않습니다.
- 문제가 생기면 백업한 PHP와 사진을 복구합니다. CSS·JS까지 바꿨다면 같은 빌드의 관련 자산과 chunk를 함께 복구합니다.

이번 문서 작업은 위 명령이나 ZIP 설치 검사를 새로 실행한 기록이 아닙니다. Main 4의 독립 마감 검토 결과는 디자인 문서에 범위를 명시했으며, 전체 테마 품질 차단과 판매 패키지 검증은 계속 별도로 충족해야 합니다.
