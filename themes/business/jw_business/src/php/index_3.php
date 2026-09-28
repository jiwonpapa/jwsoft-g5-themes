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
        <img src="<?php echo G5_THEME_URL; ?>/assets/home-three/mobility.webp" width="1536" height="1024" alt="도시 이동 시설의 안내 표지와 동선을 보여 주는 가상 브랜드 적용 장면" fetchpriority="high">
        <div class="jwh3-hero__veil"></div>
        <div class="jwh-wrap jwh3-hero__copy">

            <h1>아이디어가<br>현장에서 읽힐 때.</h1>
            <p>이동 공간의 안내, 손에 쥐는 인쇄물, 화면 안의 경험까지.<br>서로 다른 매체에 맞는 결과물을 살펴보세요.</p>
            <a href="#work-mobility">사례 내려 보기 <i data-lucide="arrow-down" aria-hidden="true"></i></a>
        </div>
        <p class="jwh3-hero__credit">실제 고객 실적이 아닌 시연용 가상 사례와 생성 이미지입니다.</p>
    </header>
    <section class="jwh3-intro jwh-wrap" aria-labelledby="jwh3-intro-title">

        <h2 id="jwh3-intro-title">사람이 만나는 순간마다,<br>브랜드의 역할은 달라집니다.</h2>
        <p>이동 중에는 방향을, 손안에서는 이야기를, 화면에서는 다음 선택을 전합니다. 네 가지 가상 사례로 매체별 설계의 차이를 살펴보세요.</p>
    </section>
    <section class="jwh3-case jwh3-case--mobility" id="work-mobility" aria-labelledby="jwh3-mobility-title">
        <div class="jwh-wrap jwh3-case__header"><p class="jwh3-kicker">01 / WAYFINDING</p><h2 id="jwh3-mobility-title">처음 온 사람도<br>길을 잃지 않도록.</h2><p>도시 이동 시설의 가상 안내 체계. 먼 거리에서는 방향을, 가까이에서는 필요한 세부 정보를 읽도록 순서를 설계했습니다.</p></div>
        <div class="jwh3-wayfinding jwh3-wayfinding-v2" role="img" aria-label="중앙 홀에서 출구 A, 승강장 B, 환승 C로 이어지는 세 방향 안내 지도"><div><i data-lucide="compass" aria-hidden="true"></i><strong>목적지가<br>한눈에.</strong><p>색, 방향, 장소를 함께 읽는<br>공간 안내 시스템</p></div><svg viewBox="0 0 560 430" aria-hidden="true"><path d="M95 65h370v290H95Z" fill="none" stroke="currentColor" stroke-opacity=".35" stroke-width="2"/><path d="M135 110h95v105h-95zm195 0h95v105h-95zM135 265h290v50H135z" fill="currentColor" fill-opacity=".08"/><path d="M280 245V95m0 150H95m185 0h185" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round"/><path d="m260 117 20-24 20 24M117 225l-24 20 24 20m325-40 24 20-24 20" fill="none" stroke="currentColor" stroke-width="6"/><circle cx="280" cy="245" r="30" fill="var(--color-primary-content)" stroke="currentColor" stroke-width="3"/><text x="280" y="251" text-anchor="middle" fill="var(--color-primary)" font-size="16">현재 위치</text><text x="280" y="55" text-anchor="middle" fill="currentColor" font-size="24">B 승강장</text><text x="95" y="390" text-anchor="middle" fill="currentColor" font-size="22">A 출구</text><text x="465" y="390" text-anchor="middle" fill="currentColor" font-size="22">C 환승</text></svg></div>
        <div class="jwh-wrap jwh3-case__meta"><span>공간 안내 · 정보 구조 · 표지 디자인</span><a href="<?php echo $case_url; ?>">관련 분야 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div>
    </section>
    <section class="jwh3-case jwh3-case--print jwh-wrap" aria-labelledby="jwh3-print-title">
        <figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/print.webp" width="1536" height="1024" alt="테라코타색과 파란색을 사용한 문화 공간 브로슈어와 인쇄물 콘셉트" loading="lazy"><figcaption>손에 쥐는 매체 / 인쇄물 콘셉트</figcaption></figure>
        <div><p class="jwh3-kicker">02 / EDITORIAL SYSTEM</p><h2 id="jwh3-print-title">브랜드를<br>손에 쥐는 순간.</h2><p>표지의 색과 글자, 안쪽의 정보 밀도를 한 시스템으로 묶었습니다. 포스터부터 작은 안내 카드까지 크기가 달라져도 인상이 이어집니다.</p><ul><li>첫 장에서 장소의 성격을 보여주는 색</li><li>행사 정보를 빠르게 찾는 제목 위계</li><li>작은 카드에도 유지되는 구성 원칙</li></ul></div>
    </section>
<section class="jwh3-exhibition jwh-wrap" aria-labelledby="jwh3-exhibition-title"><div><h2 id="jwh3-exhibition-title">그래픽이 공간을<br>만나는 순간.</h2><p>색과 형태를 평면에서 공간으로 확장한 전시 콘셉트. 같은 조형 언어가 포스터, 설치물, 디지털 화면으로 이어집니다.</p></div><figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/exhibition.webp" width="1536" height="1024" alt="푸른 반투명 패널과 원형 그래픽을 실제 크기의 공간 설치로 표현한 전시 콘셉트" loading="lazy"><figcaption>빛의 구조 · 전시 그래픽 적용 시연</figcaption></figure></section>
    <section class="jwh3-digital" aria-labelledby="jwh3-digital-title"><div class="jwh-wrap jwh3-digital__grid">
        <div><p class="jwh3-kicker">03 / DIGITAL EXPERIENCE</p><h2 id="jwh3-digital-title">필요한 정보를<br>한 화면에서.</h2><p>가상의 문화 프로그램을 주제별로 찾고, 날짜와 장소를 확인한 뒤 다음 선택으로 이어지는 탐색 화면입니다.</p><a href="<?php echo $case_url; ?>">디지털 분야 살펴보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div>
        <div class="jwh3-screen" role="img" aria-label="FIELDNOTE 문화 프로그램 목록의 데스크톱 화면 시안. 이달의 프로그램 세 가지와 탐색 분류를 보여 줍니다.">
            <div class="jwh3-screen__top"><strong>FIELDNOTE<span>®</span></strong><span>프로그램　공간　이야기</span><span>MENU +</span></div>
            <div class="jwh3-screen__feature"><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/exhibition.webp" width="1536" height="1024" alt="FIELDNOTE 프로그램 소개에 적용한 전시 그래픽" loading="lazy"><small>2026 / AUTUMN PROGRAMME</small><strong>새로운 장면을<br>만나는 계절</strong><span>전시와 대화, 작은 배움의 시간을 찾아보세요.</span></div>
            <div class="jwh3-screen__bottom"><span><i data-lucide="image" aria-hidden="true"></i><b>빛의 구조</b>전시 · 갤러리 A</span><span><i data-lucide="message-circle" aria-hidden="true"></i><b>도시의 감각</b>대화 · 열린 홀</span><span><i data-lucide="files" aria-hidden="true"></i><b>재료의 시간</b>워크숍 · 스튜디오</span></div>
        </div>
    </div></section>
    <section class="jwh3-index jwh-wrap" aria-labelledby="jwh3-index-title"><h2 id="jwh3-index-title">한 가지 언어,<br>세 가지 읽는 거리.</h2><div><p><i data-lucide="compass" aria-hidden="true"></i><strong>멀리서</strong><span>공간 표지는 이동 중 한눈에 읽힙니다.</span></p><p><i data-lucide="files" aria-hidden="true"></i><strong>손안에서</strong><span>인쇄물은 넘겨 볼 때 정보의 순서를 만듭니다.</span></p><p><i data-lucide="monitor" aria-hidden="true"></i><strong>화면에서</strong><span>디지털 경험은 선택과 다음 행동을 연결합니다.</span></p></div></section>
    <section class="jwh3-close"><div class="jwh-wrap"><h2>다음 결과물은<br>어떤 모습이어야 할까요?</h2><a class="jw-control jw-control--primary" href="<?php echo $contact_url; ?>">프로젝트 문의 안내 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
