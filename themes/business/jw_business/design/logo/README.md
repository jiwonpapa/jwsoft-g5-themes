# JW-Business 입체 이미지 로고

- Blender 5.2.2 LTS에서 만든 실제 돌출 글자 모델입니다. Pretendard Bold(OFL-1.1)로 `JW-Business`를 조형했습니다.
- `render.py`는 투명 배경 648×120 PNG를 각 모드별 9장 생성합니다. `jw-business.blend`는 편집 원본입니다.
- 웹에서는 라이트·다크 WebP 세로 프레임 이미지를 사용합니다. WebGL, jQuery, 추가 JavaScript가 필요하지 않습니다. 브라우저에서 실제 3D 모델을 자유 회전시키는 방식은 아닙니다.
- 마우스 호버/키보드 포커스 시 360ms에 8단계 회전, 해제 시 역방향 복귀합니다. 모바일 터치·동작 줄이기 환경은 첫 프레임을 유지합니다.
- 기본 Bun 빌드는 완성된 WebP를 복사합니다. 고객 서버와 일반 개발 작업에 Blender/ImageMagick를 요구하지 않습니다.

저장소 루트에서 원본 재생성:

```sh
/Applications/Blender.app/Contents/MacOS/Blender --background --python themes/business/jw_business/design/logo/render.py
magick output/blender/jw-business-logo/light-*.png -append -quality 92 themes/business/jw_business/src/assets/brand/jw-business-light.webp
magick output/blender/jw-business-logo/dark-*.png -append -quality 92 themes/business/jw_business/src/assets/brand/jw-business-dark.webp
bun run --cwd themes/business/jw_business build
```

## 구매자 로고 교체

`custom.example/site.php`를 참고해 `custom/site.php`의 `brand`만 지정합니다. 일반 정지 로고는 아래처럼 `logo_animated`를 반드시 `false`로 지정합니다. PNG/WebP/SVG 등 브라우저 이미지 경로를 사용하고 두 모드의 투명 여백을 맞춥니다. 표시 박스는 PC 216×40, 모바일 189×35이며 정지 이미지는 비율을 유지해 맞춰집니다.

```php
<?php
if (!defined('_GNUBOARD_')) exit;
return array('brand' => array(
    'name' => '회사명',
    'logo_light' => G5_THEME_URL.'/custom/logo-light.webp',
    'logo_dark' => G5_THEME_URL.'/custom/logo-dark.webp',
    'logo_animated' => false,
));
```

기본 입체 로고는 테마명 표시용입니다. 고객이 일반 로고를 교체할 때 3D 모델 제작은 필요하지 않습니다. 프레임 수·출력 비율을 변경하면 `theme.css`의 프레임 높이·이동 비율도 함께 맞춥니다.

## 적용 확인 — 2026-09-22

- 기존 `g5themes.test` 개발 환경의 헤더·푸터에 적용했습니다.
- Edge PC에서 이미지 로드와 호버 이동 `none → translateY(-320px)`를 확인했습니다. `prefers-reduced-motion: reduce`에서는 이동하지 않습니다.
- 390×844 모바일 크기에서 라이트/다크 이미지 전환과 가로 넘침 없음, 헤더·푸터 이미지 로드를 확인했습니다. 확인 후 뷰포트와 라이트 모드를 복원했습니다.
- 테마 check 16개, typecheck, build, 산출물 검사, PHP partial 문법 검사, 수동 Impeccable 감지 통과. 판매 ZIP 설치 시험은 이번 범위가 아닙니다.
