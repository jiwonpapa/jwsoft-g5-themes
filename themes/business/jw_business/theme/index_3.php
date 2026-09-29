<?php
/**
 * Theme: JW-Business 1.0
 * File: index_3.php
 * Role: 결과물과 적용 장면을 보는 독립 포트폴리오 홈
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) include_once dirname(__DIR__, 2).'/common.php';
if (!defined('_INDEX_')) define('_INDEX_', true);
$g5['title'] = $config['cf_title'];
include_once G5_THEME_PATH.'/head.php';
$case_url = jw_business_escape(jw_business_page_url('business-list-3'));
$contact_url = jw_business_escape(jw_business_page_url('contact-1'));
?>
<article class="jwh jwh3" data-jw-home="3">
    <header class="jwh3-hero">
        <div class="jwh-wrap jwh3-hero__copy"><div><span class="jwh3-kicker">SELECTED WORK / 매체에 맞는 디자인</span><h1>아이디어가<br>현장에서 읽힐 때.</h1></div><div><p>이동 공간의 안내, 손에 쥐는 인쇄물, 화면 안의 경험까지. 서로 다른 매체에 맞는 결과물을 살펴보세요.</p><a href="#work-mobility">사례 내려 보기 <i data-lucide="arrow-down" aria-hidden="true"></i></a></div></div>
        <figure class="jwh3-hero__scene"><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/mobility.webp" width="1672" height="941" alt="도시 이동 시설의 큰 파란 안내 표지와 승강장·환승 방향을 보여 주는 가상 브랜드 적용 장면" fetchpriority="high"><figcaption class="jwh-wrap"><strong>CENTRAL EXCHANGE / WAYFINDING</strong><span>시연용 가상 사례 · AI 생성 이미지. 실제 고객 실적이나 성과를 뜻하지 않습니다.</span></figcaption></figure>
    </header>
    <section class="jwh3-intro jwh-wrap" aria-labelledby="jwh3-intro-title"><div><h2 id="jwh3-intro-title">같은 브랜드,<br>서로 다른 만남.</h2><p>보는 거리와 머무는 시간이 달라지면 정보의 순서도 달라집니다.</p></div><nav aria-label="매체별 사례"><a href="#work-mobility"><span>01</span><b>공간 안내</b><i data-lucide="arrow-down" aria-hidden="true"></i></a><a href="#work-print"><span>02</span><b>인쇄와 편집</b><i data-lucide="arrow-down" aria-hidden="true"></i></a><a href="#work-exhibition"><span>03</span><b>전시 그래픽</b><i data-lucide="arrow-down" aria-hidden="true"></i></a><a href="#work-digital"><span>04</span><b>디지털 경험</b><i data-lucide="arrow-down" aria-hidden="true"></i></a></nav></section>
<section class="jwh3-case jwh3-case--mobility" id="work-mobility" aria-labelledby="jwh3-mobility-title">
      <div class="jwh-wrap jwh3-case__header"><div><span class="jwh3-kicker">01 / WAYFINDING</span><h2 id="jwh3-mobility-title">처음 온 사람도<br>길을 잃지 않도록.</h2></div><p>이동하는 순간에는 긴 설명보다 방향이 먼저 보입니다. 색과 문자, 화살표로 공간의 성격을 전합니다.</p></div>
      <div class="jwh-wrap"><div class="jwh3-signpost" aria-label="가상 교통 공간의 방향 안내 시안"><div><span>A / EXIT</span><strong>← 거리로</strong><small>출구 · 시내 버스</small></div><div><span>B / PLATFORM</span><strong>↑ 승강장</strong><small>1·2번 플랫폼</small></div><div><span>C / TRANSFER</span><strong>환승 →</strong><small>다음 노선으로</small></div></div><p class="jwh3-signpost__caption">CENTRAL EXCHANGE · 가상 공간 안내 디자인 시연</p></div>
    </section>
    <section class="jwh3-case jwh3-case--print jwh-wrap" id="work-print" aria-labelledby="jwh3-print-title"><figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/print.webp" width="1536" height="1024" alt="테라코타색 조각 사진과 파란 그래픽, 위치 정보가 편집된 문화 공간 브로슈어와 안내 카드" loading="lazy"><figcaption>FIELDNOTE / 인쇄물 콘셉트</figcaption></figure><div><span class="jwh3-kicker">02 / EDITORIAL SYSTEM</span><h2 id="jwh3-print-title">브랜드를<br>손에 쥐는 순간.</h2><p>표지에서는 장소의 인상을, 안쪽에서는 행사와 이동 정보를 전합니다. 작은 안내 카드까지 같은 색과 편집 기준을 이어갑니다.</p><dl class="jwh3-print-notes"><div><dt>먼저 보이는 것</dt><dd>장소의 인상을 담는 사진과 색</dd></div><div><dt>가까이 읽는 것</dt><dd>일정 · 위치 · 짧은 작품 이야기</dd></div><div><dt>다시 찾는 것</dt><dd>섹션 번호와 정보의 고정 위치</dd></div></dl></div></section>
    <section class="jwh3-exhibition jwh-wrap" id="work-exhibition" aria-labelledby="jwh3-exhibition-title"><div><div><span class="jwh3-kicker">03 / EXHIBITION GRAPHICS</span><h2 id="jwh3-exhibition-title">그래픽이 공간을<br>만나는 순간.</h2></div><p>평면의 원과 선이 빛, 재료, 사람의 크기를 만납니다. 앞에서 보던 그래픽을 지나가며 경험하는 전시 콘셉트입니다.</p></div><figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/exhibition.webp" width="1536" height="1024" alt="푸른 반투명 패널과 흰 원형 그래픽, 테라코타색 원을 실제 크기의 공간 설치로 표현한 가상 전시" loading="lazy"><figcaption><strong>빛의 구조 / Structure of Light</strong><span>반투명 패널 · 전시 그래픽 · 공간 적용 시연</span></figcaption></figure></section>
<section class="jwh3-digital" id="work-digital" aria-labelledby="jwh3-digital-title"><div class="jwh-wrap jwh3-digital-scene"><div><span class="jwh3-kicker">04 / DIGITAL EXPERIENCE</span><h2 id="jwh3-digital-title">사진 한 장에서<br>다음 발견으로.</h2><p>첫 화면은 행사 분위기를 전하고, 필요한 정보는 짧고 분명하게 이어집니다.</p><a href="<?php echo $case_url; ?>">디지털 분야 살펴보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div><figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/fieldnote-program.webp" width="1536" height="1024" alt="푸른 패널과 관람객이 어우러진 FIELDNOTE 전시 프로그램 장면" loading="lazy"><figcaption>FIELDNOTE / 가상 문화 프로그램의 대표 장면</figcaption></figure></div></section>
<section class="jwh3-index jwh3-editorial-scene" aria-labelledby="jwh3-index-title"><div class="jwh-wrap"><div><span class="jwh3-kicker">DESIGN ACROSS FORMATS</span><h2 id="jwh3-index-title">넘겨 보고,<br>다시 찾아보는 이야기.</h2><p>인쇄물에서는 사진과 여백이 장소의 기억을 천천히 이어갑니다.</p></div><figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/correction/fieldnote-editorial.webp" width="1536" height="1024" alt="FIELDNOTE의 사진과 편집물이 펼쳐진 문화 잡지" loading="lazy"><figcaption>FIELDNOTE / 가상 문화 프로그램의 편집물</figcaption></figure></div></section>
    <section class="jwh3-close" aria-labelledby="jwh3-close-title"><div class="jwh-wrap jwh3-close__layout"><div><span class="jwh3-kicker">YOUR NEXT PROJECT</span><h2 id="jwh3-close-title">다음 결과물은<br>어떤 모습이어야 할까요?</h2><p>공간과 종이, 화면에 필요한 역할부터 함께 정리합니다.</p><a class="jw-control jw-control--primary" href="<?php echo $contact_url; ?>">프로젝트 문의 안내 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div><aside><span>시작할 때 나누면 좋은 이야기</span><ol><li><b>만나는 사람</b><p>누가, 어느 순간에 이 결과물을 만나나요?</p></li><li><b>쓰이는 매체</b><p>공간·인쇄·화면 중 어디에서 시작하나요?</p></li><li><b>준비된 자료</b><p>브랜드 자료와 원하는 일정이 있나요?</p></li></ol><small>정리된 제안서가 없어도 현재 상황을 알려 주세요.</small></aside></div></section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
