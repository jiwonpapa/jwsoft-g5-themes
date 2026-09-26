# JW-Business 생성 이미지 기록

메인 화면에 쓰는 프로젝트 전용 이미지입니다. OpenAI 이미지 생성 도구로 만든 뒤 `cwebp`로 변환했습니다. 외부 사이트의 사진을 복제하거나 다운로드하지 않았습니다.

## `home-hero.webp`

- 용도: 메인 히어로 배경
- 방향: 여백이 넓고 차분한 현대 업무 단지, 한국 비즈니스 사이트에 맞는 중립적 기업 이미지
- 프롬프트: `Wide cinematic editorial photograph for a premium modern Korean business website hero. A calm contemporary urban business campus with low concrete architecture, reflecting pool, mature trees, broad open plaza, soft overcast daylight, restrained cool gray and muted blue palette, subtle warm highlights, generous empty space on the left for Korean headline text, architectural photography, realistic materials, sophisticated and timeless, no people close up, no text, no logo, no watermark, 16:9 composition.`

## `home-collaboration.webp`

- 용도: 회사소개 분할 섹션
- 방향: 문서와 도면을 검토하는 전문가, 연출이 과하지 않은 실제 업무 장면
- 프롬프트: `Editorial business photograph for a premium Korean corporate website. Two diverse East Asian professionals in their 30s and 40s reviewing architectural plans and material samples at a long table in a bright restrained studio office, candid collaboration, natural window light, warm neutral wood and concrete, intelligent serious mood, realistic photography, subtle depth of field, clean composition with no visible brand, no text, no watermark, landscape 4:3.`

## `home-project.webp`

- 용도: 주요 프로젝트 분할 섹션
- 방향: 자연광과 재료감이 살아 있는 현대 업무 공간
- 프롬프트: `Premium architectural editorial photograph of a modern collaborative workplace interior in Korea, generous daylight, long communal table, glass walls, textured concrete, warm wood and greenery, a few distant subtle human silhouettes only for scale, refined minimal composition, calm gray and muted teal palette, realistic photography, no logo, no text, no watermark, landscape 4:3.`

## 관리 원칙

## 메인 2 전용 이미지

- `home2-strategy.webp`: 전략 워크숍 장면. [프롬프트](home2-strategy.prompt.txt)
- `home2-digital.webp`: 디지털 서비스 시제품 검증 장면. [프롬프트](home2-digital.prompt.txt)
- `home2-operations.webp`: 실제 고객 접점의 운영 개선 장면. [프롬프트](home2-operations.prompt.txt)
- 생성: 2026-09-22, 내장 OpenAI 이미지 생성 도구. 각 원본 1672×941 PNG를 `cwebp -q 88`로 변환했습니다.
- 세 이미지는 메인 2 전용이며 기존 건축·회의실 사진을 재사용하지 않습니다.

## `company-leader.webp`

- 용도: 대표 인사말 5종의 인물 사진. 실존 대표가 아닌 AI 생성 시연 인물입니다.
- 생성: 2026-09-22, 내장 OpenAI image generation 도구. 원본 1536×1024 PNG를 cwebp로 변환했습니다.
- 프롬프트: [company-leader.prompt.txt](company-leader.prompt.txt). 배포 WebP에도 같은 프롬프트를 메타데이터로 기록합니다.

## 배포 관리 원칙

- 원본 생성 PNG는 판매 ZIP에 넣지 않습니다.
- 배포본에는 화면에서 실제 사용하는 WebP만 넣습니다.
- 파일을 교체하면 이 기록과 `ASSET-MANIFEST.json`을 함께 갱신합니다.
