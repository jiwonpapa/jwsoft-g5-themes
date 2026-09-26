# 메인 1 시안 이미지 생성 프롬프트

방식: Codex 내장 `imagegen`. 아래 기존 네 장과 후속 세 장을 각각 다른 장면으로 생성해 WebP로 변환한다. 테마 품질 원장에는 소유 페이지와 WebP 해시를 등록하며, 등록만으로 판매 시각 품질을 승인하지 않는다.

## `strategy.png`

> Photorealistic natural panoramic 16:9 hero photograph for a premium Korean multidisciplinary business agency. A small Korean agency team makes a business decision around a table, with a large professionally designed strategy map on paper as the visible focus: colored blocks, branching lines and priorities but no legible text. One person points to a decision. Contemporary creative studio in Seoul, tactile warm wood, ivory paper, ink-blue working materials. Action and map on the right two-thirds; darker negative space on the left for live HTML headline. Eye-level candid editorial camera, soft late-afternoon daylight. Avoid generic meeting smiles, architecture moodboards, construction, logos, fake UI, watermarks and floating charts.

## `digital.png`

> Photorealistic natural panoramic 16:9 hero photograph for the same premium Korean agency campaign. A Korean woman uses a smartphone to access a service in an ordinary contemporary urban venue; attention and hand gesture make the digital interaction clear. Phone is angled away so the image cannot show a fake interface; real HTML UI will be shown in the page. Subject on right two-thirds, darker uncluttered negative space on left, safe center-right crop for mobile. Dusk light with ink-blue shadows and warm highlights. Avoid hotel desk, architecture showcase, floating UI, holograms, text, logo and watermark.

## `brand.png`

> Refined photorealistic 16:9 product/editorial photograph for the same Korean agency campaign. A coordinated tactile brand identity set: packaging, folded print pieces, small signage and a reusable object with one consistent fictional visual language, no legible name. Dark warm tabletop, textured paper, ink-blue, warm ivory and muted copper. Objects and detail on right two-thirds; clean dark left for live HTML headline; safe mobile crop. Premium believable side lighting. Avoid tea packaging, architecture materials, in-image words, logo, watermark and collage.

## `brand-detail.png`

> Use `brand.png` as visual identity reference. Create a genuinely new horizontal 4:3 close-up photographic view of the same fictional brand system. Designer's hands inspect a folded print piece and small package; show paper edge, foil/embossed detail and material tactility. Preserve ink-blue, warm ivory, muted copper, circular/arc motif and warm studio light. Do not crop or duplicate the wide hero. Avoid readable text, brand name, logo, tea container, architecture board and watermark.

## `industry-ceramics.webp`

> A new overhead editorial scene inside a contemporary ceramics workshop. A craftsperson compares colored glaze test tiles and a partly finished object on a worktable. Tactile cobalt, mineral green and clay red, natural light. No office meeting, packaging, phones, construction, readable text or logos.

원본: Codex 내장 imagegen `exec-1bd5b46c-2ae9-485d-885e-fa35d4a7d504.png`. 독립 업종 모자이크용이며 다른 페이지·섹션에 재사용하지 않는다.

## `case-food.webp`

> A candid Korean food research team in a real test kitchen comparing plated menu prototypes and ingredient notes. Focus on tangible prototypes and hands, rich greens and warm natural color. No pottery, packaging, office meeting, readable writing or logos.

원본: Codex 내장 imagegen `exec-208e793b-9b6b-4668-983b-2df04cc97b1f.png`. 가상 사례 대표 사진 전용.

## `case-learning.webp`

> A community learning studio, close view of hands arranging colorful printed learning cards and tactile materials on a table. Bright daylight, coral, deep teal and cream. No food, ceramics, phones, readable writing or logos.

원본: Codex 내장 imagegen `exec-b91c8202-de14-4f65-a620-425f6dc1f713.png`. 가상 사례 보조 사진 전용.
