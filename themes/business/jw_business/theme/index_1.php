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
        <div class="hero__copy"><h1>복잡한 선택을<br>선명한 방향으로.</h1><p class="hero__summary">진단에서 끝내지 않습니다. 다음 결정을 내릴 수 있는 기준을 함께 만듭니다.</p><a href="#strategy" class="hero__link">전략이 만들어지는 과정 <span aria-hidden="true">↗</span></a></div>
      </div>
      <div class="hero__slide" data-slide="1" hidden>
        <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/digital.webp" alt="한 이용자가 모바일 서비스를 사용하는 모습" loading="eager">
        <div class="hero__shade"></div>
        <div class="hero__copy"><h2>쓰는 순간까지<br>고려한 디지털.</h2><p class="hero__summary">정보의 흐름과 읽는 방식을 하나의 화면 경험으로 설계합니다.</p><a href="#digital" class="hero__link">화면 시안 보기 <span aria-hidden="true">↗</span></a></div>
      </div>
      <div class="hero__slide" data-slide="2" hidden>
        <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/brand.webp" alt="일관된 그래픽 언어로 만든 포장과 인쇄물" loading="eager">
        <div class="hero__shade"></div>
        <div class="hero__copy"><h2>보이는 순간부터<br>남는 경험까지.</h2><p class="hero__summary">하나의 생각을 화면, 물건, 공간의 접점에서 일관되게 전합니다.</p><a href="#brand" class="hero__link">브랜드 결과물 보기 <span aria-hidden="true">↗</span></a></div>
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
      <div class="strategy__map" data-jw-decision-board data-jw-stage="0" aria-label="ATELIER N.의 관찰 근거와 우선순위 결정 기록">
        <div class="map__top"><strong>ATELIER N. · 첫 방문 설계</strong><span>가상 사례 / 판단 기록</span></div>
        <h3>첫 방문자는 무엇을 보고 고를까요?</h3>
        <figure class="decision-diagram"><svg xmlns="http://www.w3.org/2000/svg" class="decision-logic decision-logic--desktop" viewBox="0 0 640 460" role="img" aria-label="두 관찰이 제품 선택 자료와 재료 안내에 연결되고, 두 자료가 발행 콘텐츠의 선행 조건이 됩니다. 알림은 운영 담당자와 발행 주기가 정해진 뒤 검토합니다."><defs><marker id="logic-arrow" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse"><path d="M1 1L9 5L1 9" fill="none" stroke="var(--jw-link-ink)" stroke-width="1.7"/></marker></defs><rect x="0" y="0" width="282" height="63" class="soft"/><text x="14" y="21" class="label ink">E1 / 크기 판단</text><text x="14" y="44" class="small">사진만으로 실제 쓰임을 가늠하기 어려움</text><rect x="358" y="0" width="282" height="63" class="soft"/><text x="372" y="21" class="label ink">E2 / 재료 이해</text><text x="372" y="44" class="small">유약의 차이와 관리 방법이 궁금함</text><path d="M141 63V98" class="line"/><path d="M141 63V98" fill="none" stroke="transparent" marker-end="url(#logic-arrow)"/><path d="M499 63V98" class="line"/><path d="M499 63V98" fill="none" stroke="transparent" marker-end="url(#logic-arrow)"/><path d="M423 63V79H256V98" class="line"/><text x="285" y="89" class="small muted">재료 표기에도 연결</text><g data-decision-node="0"><rect x="0" y="103" width="282" height="176" class="node"/><text x="14" y="128" class="label ink">P1 / 먼저 반영</text><text x="14" y="153" class="strong">제품을 고르는 기준</text><g transform="translate(18 176)"><path d="M18 16h61v55q0 9-9 9H27q-9 0-9-9z" class="rule"/><path d="M79 27h8q19 0 19 16T87 59h-8" class="rule"/><path d="M18 3h61M18 0v6M79 0v6M4 16v64M1 16h6M1 80h6" class="line"/><text x="35" y="-4" class="small ink">Ø82</text><text x="12" y="94" class="small">H88mm · 280ml</text></g><text x="155" y="191" class="body">일상 머그</text><text x="155" y="216" class="small muted">커피와 따뜻한 차</text><text x="155" y="242" class="small">크기 · 용량 · 재료</text><text x="155" y="262" class="small muted">같은 위치에서 비교</text></g><g data-decision-node="1"><rect x="358" y="103" width="282" height="176" class="node"/><text x="372" y="128" class="label ink">P2 / 함께 반영</text><text x="372" y="153" class="strong">사용을 이어가는 안내</text><text x="372" y="184" class="small ink">세척</text><text x="421" y="184" class="body">부드러운 스펀지</text><path d="M372 197H626" class="rule"/><text x="372" y="218" class="small ink">온도</text><text x="421" y="218" class="body">급격한 변화 피하기</text><path d="M372 230H626" class="rule"/><text x="372" y="252" class="small ink">보관</text><text x="421" y="252" class="body">물기를 말린 뒤 보관</text></g><path d="M141 279V304H379M499 279V304H379" class="line"/><path d="M379 304V327" class="line"/><path d="M379 304V327" fill="none" stroke="transparent" marker-end="url(#logic-arrow)"/><text x="13" y="320" class="small ink">두 자료를 먼저 갖춘 뒤</text><rect x="0" y="332" width="405" height="82" class="soft"/><text x="14" y="355" class="label ink">발행할 콘텐츠</text><text x="14" y="380" class="strong">컬렉션 소개  +  사용·관리 안내</text><text x="14" y="402" class="small muted">첫 소식을 구성할 실제 자료가 먼저입니다.</text><path d="M405 373H457" class="line"/><path d="M436 361V385" class="line"/><text x="413" y="348" class="small">조건</text><g data-decision-node="2"><rect x="463" y="332" width="177" height="82" class="node gate"/><text x="477" y="355" class="label ink">보류 / 알림 기능</text><text x="477" y="381" class="body">담당 · 발행 주기 미정</text><text x="477" y="402" class="small muted">E3 운영 조건 확인 후</text></g><text x="0" y="447" class="small muted">실선: 자료의 선행 관계</text><text x="245" y="447" class="small muted">점선: 아직 충족하지 못한 조건</text></svg><svg xmlns="http://www.w3.org/2000/svg" class="decision-logic decision-logic--mobile" viewBox="0 0 320 846" role="img" aria-label="두 관찰이 제품 선택 자료와 재료 안내에 연결되고, 두 자료가 발행 콘텐츠의 선행 조건이 됩니다. 알림은 운영 담당자와 발행 주기가 정해진 뒤 검토합니다."><defs><marker id="logic-arrow-mobile" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse"><path d="M1 1L9 5L1 9" fill="none" stroke="var(--jw-link-ink)" stroke-width="1.7"/></marker></defs><rect x="0" y="0" width="320" height="63" class="soft"/><text x="14" y="22" class="label ink">E1 / 크기 판단</text><text x="14" y="46" class="body">사진만으로 쓰임을 가늠하기 어려움</text><path d="M38 63V100" class="line"/><path d="M38 63V100" fill="none" stroke="transparent" marker-end="url(#logic-arrow-mobile)"/><g data-decision-node="0"><rect x="0" y="106" width="320" height="188" class="node"/><text x="14" y="131" class="label ink">P1 / 먼저 반영</text><text x="14" y="157" class="strong">제품을 고르는 기준</text><g transform="translate(22 181)"><path d="M18 16h61v55q0 9-9 9H27q-9 0-9-9z" class="rule"/><path d="M79 27h8q19 0 19 16T87 59h-8" class="rule"/><path d="M18 3h61M18 0v6M79 0v6M4 16v64M1 16h6M1 80h6" class="line"/><text x="35" y="-4" class="small ink">Ø82</text><text x="12" y="94" class="small">H88mm · 280ml</text></g><text x="164" y="201" class="body">일상 머그</text><text x="164" y="229" class="small muted">커피와 따뜻한 차</text><text x="164" y="258" class="small">크기 · 용량 · 재료</text><text x="164" y="279" class="small muted">같은 위치에서 비교</text></g><rect x="0" y="325" width="320" height="63" class="soft"/><text x="14" y="347" class="label ink">E2 / 재료 이해</text><text x="14" y="371" class="body">유약의 차이와 관리 방법이 궁금함</text><path d="M296 325V83H274V100" class="line"/><text x="50" y="87" class="small ink">재료 표기는 P1에도 연결</text><path d="M38 388V417" class="line"/><path d="M38 388V417" fill="none" stroke="transparent" marker-end="url(#logic-arrow-mobile)"/><g data-decision-node="1"><rect x="0" y="422" width="320" height="161" class="node"/><text x="14" y="447" class="label ink">P2 / 함께 반영</text><text x="14" y="474" class="strong">사용을 이어가는 안내</text><text x="14" y="506" class="body">세척 · 부드러운 스펀지</text><text x="14" y="536" class="body">온도 · 급격한 변화 피하기</text><text x="14" y="566" class="body">보관 · 물기를 말린 뒤 보관</text></g><path d="M160 583V615" class="line"/><path d="M160 583V615" fill="none" stroke="transparent" marker-end="url(#logic-arrow-mobile)"/><rect x="0" y="620" width="320" height="83" class="soft"/><text x="14" y="643" class="label ink">P1 + P2 → 발행할 콘텐츠</text><text x="14" y="669" class="strong">컬렉션 소개 + 사용·관리 안내</text><text x="14" y="692" class="small muted">첫 소식을 구성할 실제 자료를 먼저 준비</text><path d="M160 703V731" class="line"/><path d="M151 721H169" class="line"/><g data-decision-node="2"><rect x="0" y="738" width="320" height="72" class="node gate"/><text x="14" y="761" class="label ink">보류 / 신제품 알림 기능</text><text x="14" y="787" class="body">E3 담당자 · 발행 주기 확정이 먼저</text></g><text x="0" y="836" class="small muted">실선: 선행 자료  /  점선: 미충족 조건</text></svg></figure>
        <div class="decision-proof-stage" aria-label="질문에 따라 달라지는 편집 결과 예시">
          <div class="decision-proof-controls" role="group" aria-label="반영한 자료 선택"><button type="button" data-jw-decision="0" data-jw-decision-select="0" aria-pressed="true">크기와 쓰임</button><button type="button" data-jw-decision="1" data-jw-decision-select="1" aria-pressed="false">재료와 관리</button><button type="button" data-jw-decision="2" data-jw-decision-select="2" aria-pressed="false">콘텐츠 준비</button></div>
          <div class="decision-proof" data-jw-decision-proof="0"><div class="decision-before"><span>이전 정보</span><strong>MUG_03</strong><small>제품명만으로는 크기와 쓰임이 보이지 않습니다.</small></div><div class="decision-after"><span>반영할 정보</span><strong>코발트 머그 · 매일의 한 잔</strong><dl><div><dt>용량</dt><dd>280ml</dd></div><div><dt>크기</dt><dd>Ø82 × H88mm</dd></div><div><dt>쓰임</dt><dd>커피와 따뜻한 차</dd></div></dl></div></div>
          <div class="decision-proof" data-jw-decision-proof="1"><div class="decision-before"><span>이전 안내</span><strong>취급에 주의하세요.</strong><small>일반적인 문구로는 구체적인 관리 방법을 알기 어렵습니다.</small></div><div class="decision-after"><span>반영할 안내</span><strong>자연스러운 유약을 오래 쓰는 법</strong><ol><li>부드러운 스펀지로 세척합니다.</li><li>급격한 온도 변화를 피합니다.</li><li>사용 뒤 물기를 말려 보관합니다.</li></ol></div></div>
          <div class="decision-proof" data-jw-decision-proof="2"><div class="decision-before"><span>보류한 제안</span><strong>신제품 알림 신청</strong><small>기능보다 먼저, 꾸준히 전할 내용을 준비합니다.</small></div><div class="decision-after"><span>먼저 준비할 자료</span><strong>첫 소식을 위한 콘텐츠 순서</strong><ol><li><b>첫 이야기</b> 컬렉션의 쓰임과 형태</li><li><b>다음 이야기</b> 유약과 관리 방법</li><li><b>운영 기준</b> 담당자와 발행 주기 확정</li></ol></div></div>
        </div>
        <div class="map__bottom"><span>질문 → 근거 → 반영 자료</span><span>아래 ATELIER 시안으로 이어집니다</span></div>
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
        <div class="atelier-preview" aria-label="ATELIER N. 컬렉션과 모바일 제품 상세의 디자인 시안">
          <div class="atelier-desktop">
            <div class="atelier-nav"><strong>ATELIER N.</strong><span>컬렉션　 스튜디오　 관리 안내</span><small>디자인 시안</small></div>
            <div class="atelier-intro"><h3>매일 쓰는 물건의,<br>조용한 차이.</h3><p>손으로 빚은 형태와 자연스러운 유약.<br>우리의 하루를 담는 작은 컬렉션.</p><span>컬렉션 살펴보기 <b aria-hidden="true">↗</b></span></div>
            <img class="atelier-collection" src="<?php echo G5_THEME_URL; ?>/assets/main-one/atelier-collection.webp" alt="ATELIER N.의 아이보리 그릇, 코발트 머그와 흰 화병 컬렉션" width="1536" height="1024" loading="lazy" decoding="async">
            <div class="atelier-collection-index"><div><span>Daily table</span><strong>손에 익는 그릇과 머그</strong><small>매일 쓰는 6가지 형태</small></div><div><span>Objects</span><strong>공간에 놓이는 작은 형태</strong><small>화병과 오브제 컬렉션</small></div></div>
          </div>
          <div class="atelier-mobile">
            <div class="atelier-mobile-nav"><strong>ATELIER N.</strong><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg></div>
            <img src="<?php echo G5_THEME_URL; ?>/assets/main-one/atelier-mug.webp" alt="자연스러운 푸른 유약이 드러나는 코발트 머그 상세 사진" width="1254" height="1254" loading="lazy" decoding="async">
            <div class="atelier-product"><span>DAILY TABLE · 03</span><h4>코발트 머그</h4><p>280ml · 손으로 바른 유약<br>손에 편안히 감기는 곡선.</p><dl><div><dt>소재</dt><dd>고온 소성 도자기</dd></div><div><dt>크기</dt><dd>Ø82 × H88mm</dd></div><div><dt>관리</dt><dd>부드러운 스펀지 세척</dd></div></dl><span class="atelier-product-note">하나씩 다른 유약의 표정을 살펴보세요.</span></div>
          </div>
        </div>
        <div class="digital__note"><h3>무엇인지 알게 하고,<br>차이를 살펴보게 합니다.</h3><p>컬렉션에서 제품으로, 제품에서 재료와 쓰임으로. 앞에서 정한 우선순위를 화면의 읽는 순서에 담았습니다.</p><dl class="digital-decisions"><div><dt>처음 보는 화면</dt><dd>컬렉션과 사용 장면</dd></div><div><dt>더 살펴보는 화면</dt><dd>용량·재료·관리 방법</dd></div></dl><small>가상 브랜드의 탐색 화면 시안입니다.</small></div>
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
        <article class="jwh1-showcase__small jwh1-showcase__small--digital">
          <div class="dayline-preview" aria-label="DAYLINE 프로젝트 일정 화면 디자인 시안"><div class="dayline-top"><strong>DAYLINE</strong><span>나의 작업실</span></div><div class="dayline-date"><span>수요일, 9월 16일</span><strong>오늘의 흐름</strong><small>디자인 프로젝트 · 시안 검토 주간</small></div><div class="dayline-event"><time>10:00</time><div><strong>브랜드 방향 함께 보기</strong><span>리서치 요약 · 온라인 미팅</span></div></div><div class="dayline-event"><time>14:00</time><div><strong>첫 화면 시안 검토</strong><span>PC·모바일 2종 · 검토 자료 준비</span></div></div><div class="dayline-progress"><span>다음 전달물</span><strong>검토 의견을 반영한 화면 2종</strong></div></div>
          <div class="jwh1-digital-case-caption"><span>디지털 서비스 · 시연 사례</span><h3>정보를 찾는 시간보다,<br>일에 쓰는 시간이 길도록.</h3></div>
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
      <div class="jwh1-questions__intro"><h2 id="jwh1-questions-title">처음 이야기할 때<br>많이 묻는 것들.</h2><p>프로젝트를 시작하기 전, 서로 확인하면 좋은 질문을 모았습니다.</p><aside class="jwh1-prep-note"><strong>잘 정리된 제안서보다,<br>지금 쓰는 자료 한 장.</strong><p>소개서, 웹사이트 주소, 손으로 적은 메모도 괜찮습니다. 현재의 모습을 함께 보는 데서 시작합니다.</p></aside></div>
      <div class="jwh1-questions__list">
        <details open><summary>이미 만든 자료가 있어도 시작할 수 있나요?</summary><p>기존 자료를 먼저 살펴보고, 유지할 내용과 다시 정리할 부분을 구분합니다.</p></details>
        <details><summary>작은 범위부터 보여줄 수 있나요?</summary><p>한 페이지나 한 접점부터 범위를 정해 방향을 살펴볼 수 있습니다.</p></details>
        <details><summary>업종이 다르면 구성도 달라지나요?</summary><p>제품, 서비스, 정보 중심 사업에 따라 먼저 보여야 할 장면과 콘텐츠의 밀도를 조정하는 방식을 보여드립니다.</p></details>
        <details><summary>결과물은 어디에서 확인하나요?</summary><p>화면 시안, 인쇄물 구성, 사용 흐름처럼 눈으로 검토할 수 있는 자료의 표현형을 이 데모에서 확인할 수 있습니다.</p></details>
      </div>
    </section>


    <section class="jwh1-news" aria-label="새로운 소식"><div class="jwh1-news__inner"><?php echo latest('theme/home_one', $jw_news_board, 3, 80); ?></div></section>

    <section class="contact" id="contact"><div><h2>다음 방향의 출발점,<br>지금의 질문 한 가지.</h2><p class="contact__intro">전략, 디지털, 브랜드.<br>필요한 변화부터 차례로 이야기하겠습니다.</p></div><div class="contact__side"><dl class="contact__brief"><div><dt>지금의 모습</dt><dd>현재 사용 중인 소개서나 웹사이트</dd></div><div><dt>바꾸고 싶은 것</dt><dd>불편한 순간과 기대하는 결과물</dd></div><div><dt>함께 정할 것</dt><dd>작업의 범위와 시작 시점</dd></div></dl><a href="<?php echo G5_BBS_URL; ?>/qalist.php">프로젝트 문의 <span aria-hidden="true">↗</span></a><small class="contact__demo">회사·프로젝트·제품은 테마 시연용 가상 사례입니다.</small></div></section>
  </div>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
