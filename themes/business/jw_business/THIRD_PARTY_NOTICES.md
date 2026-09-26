# 외부 소스 반입 기록

- GnuBoard5 `v5.6.391`의 SIR Basic 3.0.0 전체를 `src/php/`로 반입했습니다.
- 원본: https://github.com/gnuboard/gnuboard5/tree/v5.6.391/theme/basic
- 공식 라이선스 원문은 `LICENSES/gnuboard5-LGPL-2.1.txt`에 수정 없이 보존했습니다.
- 수정하지 않은 원본은 원문과 hash로 추적하며, 수정한 원본 PHP에는 SIR 원저작자·LGPL과 JW SOFT 수정 정보를 함께 표시합니다.
- 커뮤니티 payload에 남는 G5 이미지·CSS·JS와 생성 자산을 `ASSET-MANIFEST.json`에 경로·checksum·라이선스와 함께 기록합니다. 영카트 자산과 기존 basic 미리보기 이미지는 payload에서 제외합니다.
- Vite 8.3.0, TypeScript 7.0.2, Tailwind CSS 4.3.3, `@tailwindcss/vite` 4.3.3은 개발 도구입니다. 판매 ZIP에는 생성 CSS·JavaScript만 들어갑니다.
- daisyUI 5.7.40의 `corporate`·`business` 의미 색상을 바탕으로 정의한 `jw-light`·`jw-dark`와 선택한 컴포넌트 CSS만 생성 CSS에 포함합니다. 5.7.42는 저장소의 3일 신규 배포 유예에 걸려 이번 build에서 채택하지 않았습니다.
- Lucide 1.47.0은 실제 사용하는 아이콘만 JavaScript bundle에 포함합니다. 전체 아이콘 font·sprite는 배포하지 않습니다.
- Embla Carousel 8.6.0과 공식 Autoplay·Fade plugin은 메인 슬라이더에 포함합니다. 저작권자는 David Jerleke이며 MIT 원문은 `LICENSES/embla-carousel-MIT.txt`에 보존합니다.
- Motion 13.4.0은 메인 1의 필요한 스크롤 함수만 포함합니다. 저작권자는 Motion B.V.이며 MIT 원문은 `LICENSES/motion-MIT.txt`에 보존합니다.
- Pretendard 1.3.9의 Variable 다이내믹 서브셋 CSS와 WOFF2 92개를 자체 호스팅합니다. 원격 font 요청은 없습니다.
- 메인 화면의 사진 3장은 JW SOFT의 지시에 따라 OpenAI 이미지 생성 도구로 새로 만들고 WebP로 최적화했습니다. 생성 의도와 프롬프트는 `src/assets/images/README.md`에 기록합니다.
- 각 원문은 `LICENSES/`에 보존합니다. `@types/node`·`@types/bun`은 검사 전용이며 판매 ZIP에 포함하지 않습니다.
- JW SOFT 독자 저작물에는 `LICENSE.txt`의 상용 라이선스를 적용합니다. 이 조건은 GnuBoard5 및 제3자 저작물의 기존 라이선스를 대체하거나 제한하지 않습니다.
