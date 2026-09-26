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
            <p class="jwh3-kicker">SELECTED WORK / 01—03</p>
            <h1>아이디어가<br>현장에서 읽힐 때.</h1>
            <p>이동 공간의 안내, 손에 쥐는 인쇄물, 화면 안의 경험까지.<br>서로 다른 매체에 맞는 결과물을 살펴보세요.</p>
            <a href="#work-mobility">사례 내려 보기 <i data-lucide="arrow-down" aria-hidden="true"></i></a>
        </div>
        <p class="jwh3-hero__credit">실제 고객 실적이 아닌 시연용 가상 사례와 생성 이미지입니다.</p>
    </header>
    <section class="jwh3-intro jwh-wrap" aria-labelledby="jwh3-intro-title">
        <p class="jwh3-kicker">THREE DIFFERENT OUTCOMES</p>
        <h2 id="jwh3-intro-title">사람이 만나는 순간마다,<br>브랜드의 역할은 달라집니다.</h2>
        <p>이동 중에는 방향을, 손안에서는 이야기를, 화면에서는 다음 선택을 전합니다. 세 가지 가상 사례로 매체별 설계의 차이를 살펴보세요.</p>
    </section>
    <section class="jwh3-case jwh3-case--mobility" id="work-mobility" aria-labelledby="jwh3-mobility-title">
        <div class="jwh-wrap jwh3-case__header"><p class="jwh3-kicker">01 / WAYFINDING</p><h2 id="jwh3-mobility-title">처음 온 사람도<br>길을 잃지 않도록.</h2><p>도시 이동 시설의 가상 안내 체계. 먼 거리에서는 방향을, 가까이에서는 필요한 세부 정보를 읽도록 순서를 설계했습니다.</p></div>
        <div class="jwh3-wayfinding" role="img" aria-label="출구 A, 승강장 B, 환승 C를 세 단계로 나눠 표시한 안내 표지 시안"><div><span>FIELD / CITY TRANSIT</span><strong>어디로<br>가시나요?</strong></div><ol><li><b>A ↗</b><span>출구 · 도심 방면</span></li><li><b>B ↑</b><span>승강장 · 북측 노선</span></li><li><b>C ↖</b><span>환승 · 연결 통로</span></li></ol></div>
        <div class="jwh-wrap jwh3-case__meta"><span>공간 안내 · 정보 구조 · 표지 디자인</span><a href="<?php echo $case_url; ?>">관련 분야 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div>
    </section>
    <section class="jwh3-case jwh3-case--print jwh-wrap" aria-labelledby="jwh3-print-title">
        <figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/print.webp" width="1536" height="1024" alt="테라코타색과 파란색을 사용한 문화 공간 브로슈어와 인쇄물 콘셉트" loading="lazy"><figcaption>손에 쥐는 매체 / 인쇄물 콘셉트</figcaption></figure>
        <div><p class="jwh3-kicker">02 / EDITORIAL SYSTEM</p><h2 id="jwh3-print-title">브랜드를<br>손에 쥐는 순간.</h2><p>표지의 색과 글자, 안쪽의 정보 밀도를 한 시스템으로 묶었습니다. 포스터부터 작은 안내 카드까지 크기가 달라져도 인상이 이어집니다.</p><ul><li>첫 장에서 장소의 성격을 보여주는 색</li><li>행사 정보를 빠르게 찾는 제목 위계</li><li>작은 카드에도 유지되는 구성 원칙</li></ul></div>
    </section>
    <section class="jwh3-digital" aria-labelledby="jwh3-digital-title"><div class="jwh-wrap jwh3-digital__grid">
        <div><p class="jwh3-kicker">03 / DIGITAL EXPERIENCE</p><h2 id="jwh3-digital-title">필요한 정보를<br>한 화면에서.</h2><p>가상의 문화 프로그램을 주제별로 찾고, 날짜와 장소를 확인한 뒤 다음 선택으로 이어지는 탐색 화면입니다.</p><a href="<?php echo $case_url; ?>">디지털 분야 살펴보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div>
        <div class="jwh3-screen" role="img" aria-label="FIELDNOTE 문화 프로그램 목록의 데스크톱 화면 시안. 이달의 프로그램 세 가지와 탐색 분류를 보여 줍니다.">
            <div class="jwh3-screen__top"><strong>FIELDNOTE<span>®</span></strong><span>프로그램　공간　이야기</span><span>MENU +</span></div>
            <div class="jwh3-screen__feature"><small>2026 / AUTUMN PROGRAMME</small><strong>새로운 장면을<br>만나는 계절</strong><span>전시와 대화, 작은 배움의 시간을 찾아보세요.</span></div>
            <div class="jwh3-screen__bottom"><span>01　 전시　｜　빛의 구조</span><span>02　 대화　｜　도시의 감각</span><span>03　 워크숍　｜　재료의 시간</span></div>
        </div>
    </div></section>
    <section class="jwh3-index jwh-wrap" aria-labelledby="jwh3-index-title"><h2 id="jwh3-index-title">한 가지 언어,<br>세 가지 읽는 거리.</h2><div><p><strong>멀리서</strong><span>공간 표지는 이동 중 한눈에 읽힙니다.</span></p><p><strong>손안에서</strong><span>인쇄물은 넘겨 볼 때 정보의 순서를 만듭니다.</span></p><p><strong>화면에서</strong><span>디지털 경험은 선택과 다음 행동을 연결합니다.</span></p></div></section>
    <section class="jwh3-close"><div class="jwh-wrap"><p class="jwh3-kicker">NEXT PROJECT</p><h2>다음 결과물은<br>어떤 모습이어야 할까요?</h2><a class="jw-control jw-control--primary" href="<?php echo $contact_url; ?>">프로젝트 문의 안내 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
