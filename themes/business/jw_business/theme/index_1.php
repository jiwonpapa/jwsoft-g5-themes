<?php
/**
 * Theme: JW-Business 1.0
 * File: index_1.php
 * Role: 기본 메인 홈 완성 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_INDEX_')) define('_INDEX_', true);
// 선택용 파일의 직접 미리보기에서도 G5 기본 초기화만 수행합니다.
if (!defined('_GNUBOARD_')) {
    include_once dirname(__DIR__, 2).'/common.php';
}

if (G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once G5_THEME_SHOP_PATH.'/index.php';
    return;
}

$g5['title'] = $config['cf_title'];
// Main #1 has its own built assets so other home variants stay independent.
$jw_home_one_version = (string) filemtime(G5_THEME_PATH.'/css/home-one.min.css');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/home-one.min.css?v='.$jw_home_one_version.'">', 20);
add_javascript('<script src="'.G5_THEME_URL.'/js/home-one.min.js?v='.$jw_home_one_version.'" type="module"></script>', 20);
include_once G5_THEME_PATH.'/head.php';

$jw_settings = jw_business_settings();
$jw_home = $jw_settings['home'];
$jw_news_board = isset($jw_home['news_board']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $jw_home['news_board']) : 'notice';
?>
<div class="jw-home jwh1-concept" id="jwh1-top" data-jw-home="1">

    <section class="hero" data-jw-hero-slider aria-label="JW Business의 주요 서비스">
      <div class="hero__viewport" data-jw-hero-viewport><div class="hero__container">
      <div class="hero__slide is-active" data-slide="0">
        <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/strategy.webp" alt="팀이 인쇄된 의사결정 지도를 함께 살피는 모습" fetchpriority="high">
        <div class="hero__shade"></div>
        <div class="hero__copy"><p class="hero__topic">비즈니스 전략</p><h1>복잡한 선택을<br>선명한 방향으로.</h1><p class="hero__summary">진단에서 끝내지 않습니다. 다음 결정을 내릴 수 있는 기준을 함께 만듭니다.</p><a href="#strategy" class="hero__link">전략이 만들어지는 과정 <span aria-hidden="true">↗</span></a></div>
      </div>
      <div class="hero__slide" data-slide="1" hidden>
        <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/digital.webp" alt="한 이용자가 모바일 서비스를 사용하는 모습" loading="eager">
        <div class="hero__shade"></div>
        <div class="hero__copy"><p class="hero__topic">디지털 서비스</p><h2>쓰는 순간까지<br>고려한 디지털.</h2><p class="hero__summary">정보의 흐름과 읽는 방식을 하나의 화면 경험으로 설계합니다.</p><a href="#digital" class="hero__link">화면 시안 보기 <span aria-hidden="true">↗</span></a></div>
      </div>
      <div class="hero__slide" data-slide="2" hidden>
        <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/brand.webp" alt="일관된 그래픽 언어로 만든 포장과 인쇄물" loading="eager">
        <div class="hero__shade"></div>
        <div class="hero__copy"><p class="hero__topic">브랜드 경험</p><h2>보이는 순간부터<br>남는 경험까지.</h2><p class="hero__summary">하나의 생각을 화면, 물건, 공간의 접점에서 일관되게 전합니다.</p><a href="#brand" class="hero__link">브랜드 결과물 보기 <span aria-hidden="true">↗</span></a></div>
      </div>
      </div></div>
      <div class="hero__controls">
        <span class="hero__current" aria-live="polite"><b data-current>01</b> <span>/ 03</span></span>
        <div class="hero__dots" role="group" aria-label="슬라이드 선택"><button type="button" class="is-active" data-goto="0" aria-label="전략 장면 보기" aria-current="true"></button><button type="button" data-goto="1" aria-label="디지털 장면 보기"></button><button type="button" data-goto="2" aria-label="브랜드 장면 보기"></button></div>
        <div class="hero__arrows"><button type="button" class="tw:d-btn tw:d-btn-circle" data-dir="-1" aria-label="이전 장면">←</button><button type="button" class="tw:d-btn tw:d-btn-circle" data-dir="1" aria-label="다음 장면">→</button><button type="button" class="tw:d-btn" data-play aria-label="슬라이드 자동 재생">재생</button></div>
      </div>
      <a class="hero__scroll" href="#services">아래로 살펴보기 <span aria-hidden="true">↓</span></a>
    </section>

    <section class="services" id="services">
      <div class="services__intro"><h2>방향을 정하고,<br>경험을 만듭니다.</h2><p>일의 방향부터 쓰는 화면, 브랜드가 닿는 순간까지. 각 문제에 맞는 방법과 결과물을 보여드립니다.</p></div>
      <div class="services__index" aria-label="서비스 바로가기">
        <a href="#strategy"><span class="service-icon jwh1-service-icon" aria-hidden="true"><svg viewBox="0 0 72 72" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="17" cy="36" r="6"/><circle cx="49" cy="17" r="6"/><circle cx="55" cy="53" r="6"/><path d="M23 33l20-13M23 40l26 11M49 23l5 24"/><path d="M32 58l8-8M32 50l8 8"/></svg></span><span class="services__count">01</span><strong>비즈니스 전략</strong><span class="services__hint">판단의 기준을 세웁니다</span></a>
        <a href="#digital"><span class="service-icon jwh1-service-icon" aria-hidden="true"><svg viewBox="0 0 72 72" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="11" y="15" width="50" height="40" rx="3"/><path d="M11 26h50M21 36h14M21 43h28M45 36h6M27 61h18M36 55v6"/></svg></span><span class="services__count">02</span><strong>디지털 서비스</strong><span class="services__hint">정보의 흐름을 설계합니다</span></a>
        <a href="#brand"><span class="service-icon jwh1-service-icon" aria-hidden="true"><svg viewBox="0 0 72 72" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M35 11l21 12v26L35 61 14 49V23z"/><path d="M14 23l21 13 21-13M35 36v25M25 17l21 13"/></svg></span><span class="services__count">03</span><strong>브랜드 경험</strong><span class="services__hint">접점마다 같은 인상을 남깁니다</span></a>
      </div>
    </section>

    <!-- 메인 1 독립 편집 섹션: 업종 적용 예시 -->
    <section class="jwh1-industries" id="industries" aria-labelledby="jwh1-industries-title">
      <div class="jwh1-industries__head">
        <h2 id="jwh1-industries-title">업종마다<br>보여줄 장면이 다릅니다.</h2>
        <p>제품을 만드는 일, 전문 지식을 설명하는 일, 현장에서 경험을 전하는 일. 같은 틀을 반복하기보다 각 사업에서 먼저 보여야 할 것을 고릅니다.</p>
      </div>
      <div class="jwh1-industries__grid">
        <figure class="jwh1-industries__photo">
          <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/industry-ceramics.webp" alt="도자기 작업자가 유약 시험 타일과 완성 중인 그릇을 비교하는 장면" width="1448" height="1086" loading="lazy" decoding="async">
          <figcaption><span>제조와 제품</span><strong>손으로 만든 차이가<br>화면에서도 보이도록.</strong></figcaption>
        </figure>
        <div class="jwh1-industries__expert">
          <svg viewBox="0 0 160 160" fill="none" aria-hidden="true"><circle cx="80" cy="80" r="61"/><circle cx="80" cy="80" r="32"/><path d="M80 3v26M80 131v26M3 80h26M131 80h26M26 26l19 19M115 115l19 19"/></svg>
          <div><h3>전문 서비스</h3><p>보이지 않는 전문성은 과정과 근거를 차례로 보여줄 때 또렷해집니다.</p></div>
        </div>
        <div class="jwh1-industries__strip">
          <div><h3>내용을 담는 방식도<br>사업에 맞게.</h3><p>업종의 재료와 고객의 질문을 먼저 살피면, 화면의 우선순위도 달라집니다.</p></div>
          <div class="jwh1-industries__topics" aria-label="표현 예시"><span>제품의 질감</span><span>서비스의 순서</span><span>브랜드의 목소리</span></div>
        </div>
      </div>
    </section>

    <section class="strategy" id="strategy">
      <div class="strategy__copy"><h2>결론보다 먼저,<br><em>선택의 구조</em>를<br>그립니다.</h2><p>사업의 현재 위치와 고객의 행동을 한 장에 놓고 봅니다. 무엇을 시작하고 무엇을 미룰지, 팀이 같은 기준으로 판단할 수 있게 합니다.</p><a href="#digital" class="text-link">다음으로, 서비스 경험 <span aria-hidden="true">↗</span></a></div>
      <div class="strategy__map" aria-label="전략 산출물 예시">
        <div class="map__top"><span>DEMO DELIVERABLE</span><span>STRATEGY MAP — 01</span></div>
        <h3>복잡한 문제를 한 장의 결정으로</h3>
        <svg viewBox="0 0 780 435" role="img" aria-label="고객 문제에서 서비스 선택과 실행 우선순위로 이어지는 예시 결정 지도">
          <path class="map-line" d="M94 214H249Q276 214 286 150L293 119H455Q483 119 503 175L516 214H675"/>
          <path class="map-line dim" d="M293 119Q299 302 385 313H675"/>
          <circle cx="94" cy="214" r="42" fill="#a9c9d0"/><circle cx="294" cy="119" r="39" fill="#d49d7f"/><circle cx="516" cy="214" r="42" fill="#d8b47c"/><circle cx="675" cy="214" r="43" fill="#e8eee9"/><circle cx="385" cy="313" r="27" fill="#547982"/>
          <text x="94" y="220" text-anchor="middle">질문</text><text x="294" y="125" text-anchor="middle">가설</text><text x="516" y="220" text-anchor="middle">선택</text><text x="675" y="220" text-anchor="middle">실행</text>
          <text class="map-side" x="58" y="287">고객의 문제</text><text class="map-side" x="245" y="62">검증할 방향</text><text class="map-side" x="469" y="285">우선할 경험</text><text class="map-side" x="634" y="285">첫 번째 개선</text><text class="map-side" x="332" y="380">보류할 선택</text>
        </svg>
        <svg class="map__mobile" viewBox="0 0 320 430" role="img" aria-label="고객 문제에서 가설을 세운 뒤, 검증된 선택은 실행하고 근거가 부족한 선택은 보류하는 결정 지도">
          <path class="map-line" d="M160 79V119M160 185V212H80V253M160 212H245V253M80 317V358"/>
          <path class="map-line dim" d="M301 285H312V152H225"/>
          <path d="M153 110l7 9 7-9M73 244l7 10 7-10M238 244l7 10 7-10M73 349l7 9 7-9M234 145l-9 7 9 7" fill="none" stroke="currentColor" stroke-width="3"/>
          <rect x="97" y="15" width="126" height="64" rx="32" fill="var(--color-primary)"/>
          <text class="map__mobile-on-primary" x="160" y="53" text-anchor="middle">고객의 문제</text>
          <rect x="97" y="120" width="126" height="64" rx="8" fill="var(--color-base-200)" stroke="currentColor"/>
          <text x="160" y="158" text-anchor="middle">검증할 가설</text>
          <rect x="17" y="254" width="126" height="64" rx="8" fill="var(--color-base-200)" stroke="currentColor"/>
          <text x="80" y="292" text-anchor="middle">우선할 선택</text>
          <rect x="190" y="254" width="111" height="64" rx="8" fill="var(--color-base-100)" stroke="currentColor" stroke-dasharray="5 4"/>
          <text x="245" y="292" text-anchor="middle">보류할 선택</text>
          <rect x="17" y="359" width="126" height="58" rx="29" fill="var(--color-primary)"/>
          <text class="map__mobile-on-primary" x="80" y="394" text-anchor="middle">첫 개선 실행</text>
          <text class="map__mobile-label" x="247" y="355" text-anchor="middle">추가 근거 수집</text>
        </svg>
        <div class="map__bottom"><span>진단 → 가설 → 선택 → 실행</span><span>가상 사업 사례를 위한 화면 예시</span></div>
      </div>
    </section>

    <!-- 메인 1 독립 편집 섹션: 작업 과정 -->
    <section class="jwh1-process" id="process" aria-labelledby="jwh1-process-title">
      <div class="jwh1-process__head"><h2 id="jwh1-process-title">생각에서 결과물까지,<br>순서가 보이는 일.</h2><p>화려한 결과보다 중요한 건 다음 선택을 할 수 있는 흐름입니다. 네 단계를 거치며 자료가 어떻게 구체화되는지 보여드립니다.</p></div>
      <ol class="jwh1-process__rail">
        <li><span>01</span><h3>질문을 모읍니다</h3><p>누가, 어느 순간에, 무엇을 어려워하는지 먼저 살핍니다.</p></li>
        <li><span>02</span><h3>기준을 세웁니다</h3><p>남길 정보와 덜어낼 정보를 정리해 선택의 축을 만듭니다.</p></li>
        <li><span>03</span><h3>눈에 보이게 만듭니다</h3><p>문장과 화면, 재료를 실제 크기의 시안으로 옮깁니다.</p></li>
        <li><span>04</span><h3>쓰이는 장면을 봅니다</h3><p>읽고 누르고 손에 쥐는 흐름에서 어긋난 곳을 고칩니다.</p></li>
      </ol>
    </section>

    <section class="digital" id="digital">
      <div class="digital__head"><h2>설명보다 빠른 건,<br>직접 보이는 화면입니다.</h2><p>필요한 정보를 어떤 순서로 보여줄지, PC와 모바일에서 어떻게 읽힐지를 설계합니다. 아래는 가상 기업 웹페이지의 디자인 시안입니다.</p></div>
      <div class="digital__stage">
        <div class="web-preview" role="img" aria-label="가상 기업 웹페이지의 PC와 모바일 디자인 시안">
          <div class="web-preview__desktop">
            <div class="web-preview__top"><strong>ATELIER N<span>.</span></strong><span>소개&nbsp;&nbsp;&nbsp;분야&nbsp;&nbsp;&nbsp;이야기</span><small>DESIGN CONCEPT</small></div>
            <div class="web-preview__cover"><span>COMPANY / 01</span><h3>생각을 모아<br>방향을 만듭니다.</h3><p>우리가 하는 일과 그 이유를<br>한눈에 읽을 수 있도록.</p><div class="web-preview__artifact" aria-hidden="true"><svg viewBox="0 0 300 250"><path d="M45 60H150V190H250M150 120h100" fill="none" stroke="currentColor" stroke-width="3"/><rect x="12" y="30" width="74" height="60" rx="8" fill="var(--color-base-100)" stroke="currentColor" stroke-width="2"/><rect x="205" y="92" width="83" height="58" rx="8" fill="var(--color-base-100)" stroke="currentColor" stroke-width="2"/><rect x="205" y="163" width="83" height="58" rx="8" fill="var(--color-base-100)" stroke="currentColor" stroke-width="2"/><circle cx="150" cy="60" r="18" fill="var(--color-primary)"/><text x="49" y="66" text-anchor="middle" fill="currentColor" font-size="16">발견</text><text x="246" y="127" text-anchor="middle" fill="currentColor" font-size="16">경험</text><text x="246" y="198" text-anchor="middle" fill="currentColor" font-size="16">연결</text></svg></div></div>
            <div class="web-preview__index"><span>01 &nbsp; 기업 소개</span><span>02 &nbsp; 전문 분야</span><span>03 &nbsp; 우리의 이야기</span></div>
          </div>
          <div class="web-preview__mobile" aria-hidden="true"><div class="web-preview__mobile-top"><strong>ATELIER N.</strong><span>☰</span></div><span class="web-preview__mobile-kicker">COMPANY / 01</span><strong class="web-preview__mobile-title">생각을 모아<br>방향을 만듭니다.</strong><div class="web-preview__mobile-orbit"></div><span class="web-preview__mobile-bottom">01 &nbsp; 기업 소개 <b>↗</b></span></div>
        </div>
        <div class="digital__note"><div class="digital__arrow">↗</div><h3>같은 내용이,<br>화면에 맞게 읽히도록.</h3><p>사업 소개에서 사례까지 정보의 흐름을 정리한 반응형 웹페이지 예시입니다.</p></div>
      </div>
    </section>

    <!-- 메인 1 독립 편집 섹션: 가상 프로젝트 사례 -->
    <section class="jwh1-showcase" id="showcase" aria-labelledby="jwh1-showcase-title">
      <div class="jwh1-showcase__head"><h2 id="jwh1-showcase-title">하나의 정답 대신,<br>상황에 맞는 장면을.</h2><p>아래 세 사례는 서로 다른 레이아웃을 보여주기 위한 가상 프로젝트입니다. 실제 고객 실적이나 성과를 뜻하지 않습니다.</p></div>
      <div class="jwh1-showcase__grid">
        <article class="jwh1-showcase__feature">
          <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/case-food.webp" alt="식음료 개발팀이 여러 메뉴 시안을 놓고 비교하는 장면" width="1536" height="1024" loading="lazy" decoding="async">
          <div><span>식음료 경험 · 시연 사례</span><h3>메뉴를 고르는 순간부터<br>브랜드를 기억하는 순간까지.</h3></div>
        </article>
        <article class="jwh1-showcase__small jwh1-showcase__small--photo">
          <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/case-learning.webp" alt="학습 자료를 작업대에 펼쳐 구성하는 장면" width="1122" height="1402" loading="lazy" decoding="async">
          <div><span>교육 콘텐츠 · 시연 사례</span><h3>복잡한 내용을<br>손에 잡히는 순서로.</h3></div>
        </article>
        <article class="jwh1-showcase__small jwh1-showcase__small--diagram">
          <div class="jwh1-showcase__diagram" aria-hidden="true"><i></i><i></i><i></i><b></b><b></b><b></b></div>
          <div><span>디지털 서비스 · 시연 사례</span><h3>화면의 정보에도<br>읽는 리듬을.</h3></div>
        </article>
      </div>
    </section>

    <section class="brand" id="brand">
      <div class="brand__image"><img src="<?php echo G5_THEME_URL; ?>/assets/main-one/brand-detail.webp" alt="같은 브랜드 그래픽이 적용된 인쇄물과 작은 포장을 손으로 살피는 장면" width="1448" height="1086" loading="eager" fetchpriority="low" decoding="async"></div>
      <div class="brand__copy"><h2>브랜드는<br>손에 닿을 때<br>완성됩니다.</h2><p>화면의 문장과 손에 잡히는 물건이 다른 목소리를 내지 않도록. 하나의 생각을 여러 접점의 크기와 재료에 맞게 번역합니다.</p><span class="brand__material">Identity <i></i> Digital <i></i> Physical</span></div>
    </section>

    <!-- 메인 1 독립 편집 섹션: 브랜드 접점 시연 자료 -->
    <section class="jwh1-touchpoints" id="touchpoints" aria-labelledby="jwh1-touchpoints-title">
      <div class="jwh1-touchpoints__intro"><h2 id="jwh1-touchpoints-title">한 가지 인상이,<br>여러 크기로 이어집니다.</h2><p>색, 글자, 형태가 화면과 인쇄물에서 같은 목소리를 내도록 연결합니다.</p></div>
      <div class="jwh1-touchpoints__board" aria-label="가상 브랜드의 형태, 글자, 색상 조합">
        <div class="jwh1-touchpoints__poster"><div class="jwh1-touchpoints__mark" aria-hidden="true"><i></i><i></i></div><strong>모양이 먼저<br>기억되도록.</strong><span>FORM / 01</span></div>
        <div class="jwh1-touchpoints__type"><span>TYPE / 02</span><strong>짧은 문장도<br>같은 목소리로.</strong><p>화면에서 읽는 글자와 손에 쥐는 인쇄물의 글자가 하나의 결을 공유합니다.</p></div>
        <div class="jwh1-touchpoints__colors"><span>COLOR / 03</span><div role="img" aria-label="테마의 중립색, 강조색, 밝은 대비색으로 구성한 세 가지 색상 예시"><i></i><i></i><i></i></div><strong>색의 관계까지<br>하나의 체계로.</strong></div>
      </div>
    </section>

    <!-- 메인 1 독립 편집 섹션: 질문 펼침 -->
    <section class="jwh1-questions" id="questions" aria-labelledby="jwh1-questions-title">
      <div class="jwh1-questions__intro"><h2 id="jwh1-questions-title">처음 이야기할 때<br>많이 묻는 것들.</h2><p>프로젝트를 시작하기 전, 서로 확인하면 좋은 질문을 모았습니다.</p></div>
      <div class="jwh1-questions__list">
        <details><summary>이미 만든 자료가 있어도 시작할 수 있나요?</summary><p>기존 자료를 먼저 살펴보고, 유지할 내용과 다시 정리할 부분을 구분합니다.</p></details>
        <details><summary>작은 범위부터 보여줄 수 있나요?</summary><p>한 페이지나 한 접점부터 범위를 정해 방향을 살펴볼 수 있습니다.</p></details>
        <details><summary>업종이 다르면 구성도 달라지나요?</summary><p>제품, 서비스, 정보 중심 사업에 따라 먼저 보여야 할 장면과 콘텐츠의 밀도를 조정하는 방식을 보여드립니다.</p></details>
        <details><summary>결과물은 어디에서 확인하나요?</summary><p>화면 시안, 인쇄물 구성, 사용 흐름처럼 눈으로 검토할 수 있는 자료의 표현형을 이 데모에서 확인할 수 있습니다.</p></details>
      </div>
    </section>


    <section class="jwh1-news" aria-label="새로운 소식"><div class="jwh1-news__inner"><?php echo latest('theme/home_one', $jw_news_board, 3, 80); ?></div></section>

    <section class="contact" id="contact"><div><h2>새로운 방향이<br>필요한 순간이라면.</h2></div><div class="contact__side"><p>업종이나 프로젝트 크기보다, 지금 해결해야 할 질문을 먼저 듣겠습니다. 이 페이지의 회사와 결과물은 테마 시연용 예시입니다.</p><a href="<?php echo G5_BBS_URL; ?>/qalist.php">프로젝트 문의 <span aria-hidden="true">↗</span></a></div></section>
  </div>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
