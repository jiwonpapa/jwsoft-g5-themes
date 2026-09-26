# 메인 1 전용 시각 자료

2026-09-22 내장 imagegen으로 생성한 독립 장면 4종입니다. 실제 고객이나 소속 직원 사진이 아닌 테마 시연 자료입니다.

| 파일 | 장면 | 사용 위치 |
|---|---|---|
| digital.webp | 스마트폰을 사용하는 이용자 | 히어로 1 |
| technology.webp | 정밀 기술과 현장 | 히어로 2 |
| brand.webp | 차 제품과 브랜드 패키지 | 히어로 3 |
| team.webp | 함께 시안을 검토하는 동료 | 협업 소개 |

각 파일의 정확한 생성 프롬프트는 같은 이름의 `.prompt.txt`와 WebP 메타데이터에 보존했습니다. WebP는 sharp quality 86으로 변환했습니다. `quality/assets.json`의 owner는 home-1입니다. 다른 페이지로 복사하거나 재압축·크롭하여 재사용하지 않습니다.

배포는 `vite.home-one.config.ts`가 생성한 `assets/home-one-*` 파일을 사용합니다. 수정 원본을 생성 payload에서 직접 고치지 않습니다.
