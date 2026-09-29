<?php
/**
 * Theme: JW-Business 1.0
 * File: index_4.php
 * Author: JW SOFT
 * Role: 메인 4 — 과정과 산출물을 보여주는 에이전시 홈
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) include_once dirname(__DIR__, 2).'/common.php';
if (!defined('_INDEX_')) define('_INDEX_', true);
$g5['title'] = $config['cf_title'];
$jw_home_four_version = (string) filemtime(G5_THEME_PATH.'/css/home-four.min.css');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/home-four.min.css?v='.$jw_home_four_version.'">', 20);
add_javascript('<script src="'.G5_THEME_URL.'/js/home-four.min.js?v='.$jw_home_four_version.'" type="module"></script>', 20);
include_once G5_THEME_PATH.'/head.php';
?>
<article class="jwh4" data-jw-home="4" id="h4-top">
  <!-- 01. 프로젝트 커버: 사진과 문구를 함께 바꿔 사용합니다. -->
  <section class="h4-hero h4-wrap" aria-labelledby="h4-title">
    <div class="h4-hero-copy">

      <h1 id="h4-title">생각을 모아,<br> 결과로 만듭니다.</h1>
      <p>브랜드의 가능성을 함께 발견하고,<br class="h4-desktop-break"> 전략과 디자인으로 하나의 경험을 만듭니다.</p>
      <div class="h4-actions"><a class="tw:d-btn tw:d-btn-primary" href="#h4-process">함께 일하는 방식 <i data-h4-icon="arrow-down" aria-hidden="true"></i></a><a class="h4-text-link" href="<?php echo G5_URL; ?>/pages/contact-1.php">프로젝트 문의 <i data-h4-icon="arrow-up-right" aria-hidden="true"></i></a></div>
      <div class="h4-hero-signature"><span class="h4-signature-icon"><i data-h4-icon="layers" aria-hidden="true"></i></span><p><strong>하나의 생각, 연결되는 경험.</strong><span>전략 · 브랜드 · 디지털</span></p></div>
    </div>
    <figure class="h4-cover"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/hero.webp" alt="FORME의 세이지색 유리 용기와 아이보리 패키지로 완성한 보태니컬 브랜드 디자인" width="1536" height="1024" fetchpriority="high"><figcaption><span>브랜드 프로젝트 예시</span><strong>FORME <span>일상의 작은 균형</span></strong><a href="#h4-brand" aria-label="FORME 브랜드 결과물 살펴보기"><i data-h4-icon="arrow-up-right" aria-hidden="true"></i></a></figcaption></figure>
  </section>

  <!-- 02. 과정 바로가기: 아이콘은 Lucide, 각 카드가 해당 산출물로 연결됩니다. -->
  <section class="h4-process h4-section" id="h4-process" aria-labelledby="h4-process-title">
    <div class="h4-wrap">
      <div class="h4-heading"><div><h2 id="h4-process-title">함께 만드는<br> 네 가지 순간.</h2></div><p>과정마다 질문이 있고, 눈으로 확인할 결과가 있습니다.<br class="h4-desktop-break"> 다음 단계로 넘어가기 전, 같은 방향을 보고 있는지 확인합니다.</p></div>
      <div class="h4-process-grid">
        <a class="h4-process-card" href="#h4-discovery"><span class="h4-step-no">01</span><i class="h4-large-icon" data-h4-icon="search" aria-hidden="true"></i><h3>발견</h3><p>좋은 질문으로<br> 진짜 과제를 찾습니다.</p><span class="h4-card-bottom">리서치 &amp; 브리프 <i data-h4-icon="arrow-down-right" aria-hidden="true"></i></span></a>
        <a class="h4-process-card" href="#h4-strategy"><span class="h4-step-no">02</span><i class="h4-large-icon" data-h4-icon="route" aria-hidden="true"></i><h3>설계</h3><p>고객의 흐름에서<br> 경험의 순서를 정합니다.</p><span class="h4-card-bottom">전략 &amp; 고객 여정 <i data-h4-icon="arrow-down-right" aria-hidden="true"></i></span></a>
        <a class="h4-process-card" href="#h4-digital"><span class="h4-step-no">03</span><i class="h4-large-icon" data-h4-icon="pen-tool" aria-hidden="true"></i><h3>제작</h3><p>브랜드다운 인상을<br> 쓰임새 있는 디자인으로.</p><span class="h4-card-bottom">아이덴티티 &amp; 웹 <i data-h4-icon="arrow-down-right" aria-hidden="true"></i></span></a>
        <a class="h4-process-card" href="#h4-brand"><span class="h4-step-no">04</span><i class="h4-large-icon" data-h4-icon="package-check" aria-hidden="true"></i><h3>완성</h3><p>하나의 인상을<br> 실제 접점까지.</p><span class="h4-card-bottom">브랜드 &amp; 패키지 <i data-h4-icon="arrow-down-right" aria-hidden="true"></i></span></a>
      </div>
    </div>
  </section>

  <!-- 03. 발견: 작업 사진 + 정렬된 관찰/목표 + 인사이트 관계도 -->
  <section class="h4-section h4-wrap h4-discovery" id="h4-discovery" aria-labelledby="h4-discovery-title" data-jwh4-work-product="brief">
    <figure class="h4-workshop h4-reveal"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/discovery.webp" alt="두 디자이너가 FORME의 패키지와 고객 여정 자료를 함께 검토하는 모습" width="1536" height="1024" loading="lazy" decoding="async"><figcaption><i data-h4-icon="messages-square" aria-hidden="true"></i><span>질문하고, 펼쳐 보고, 함께 정리합니다.</span></figcaption></figure>
    <div class="h4-discovery-copy"><span class="h4-stage-label"><b>01</b> 발견 · 프로젝트 브리프</span><h2 id="h4-discovery-title">좋은 질문에서<br> 시작합니다.</h2><p class="h4-summary">무엇을 만들지보다, 왜 필요한지 먼저 묻습니다. 브랜드의 이야기와 고객의 선택이 만나는 지점을 찾습니다.</p>
      <div class="h4-insights"><div><i data-h4-icon="scan-eye" aria-hidden="true"></i><h3>관찰</h3><p>좋은 원료의 이야기가<br> 제품의 첫인상에 드러나지 않습니다.</p></div><div><i data-h4-icon="target" aria-hidden="true"></i><h3>목표</h3><p>자연스러운 일상의 가치를<br> 보이는 경험으로 연결합니다.</p></div></div>
    </div>
  </section>

  <!-- 04. 설계: 장면을 고르는 간결한 브랜드 이야기 -->
<section class="h4-strategy h4-section" id="h4-strategy" aria-labelledby="h4-strategy-title" data-jwh4-work-product="journey"><div class="h4-wrap"><div class="h4-heading"><div><span class="h4-stage-label"><b>02</b> 설계 · 경험의 연결</span><h2 id="h4-strategy-title">하나의 생각이<br>여러 장면으로.</h2></div><p>처음 알아보는 순간부터 포장을 여는 순간까지, 같은 브랜드의 인상이 이어집니다.</p></div><div class="h4-journey-track" data-jw-forme-story data-jw-stage="0"><div class="h4-journey"><div class="h4-material-layout"><div class="h4-material-steps" role="group" aria-label="FORME 브랜드 장면 선택"><button type="button" data-jw-forme-select="0" aria-controls="h4-material-brief" aria-pressed="true"><span>01 · 발견</span><strong>일상의 질문에서.</strong><small>누구의 어떤 순간에 필요한지 살핍니다.</small><i data-h4-icon="arrow-right" aria-hidden="true"></i></button><button type="button" data-jw-forme-select="1" aria-controls="h4-material-screen" aria-pressed="false"><span>02 · 제품</span><strong>고르기 쉬운 모습으로.</strong><small>제품의 쓰임과 차이를 보여줍니다.</small><i data-h4-icon="arrow-right" aria-hidden="true"></i></button><button type="button" data-jw-forme-select="2" aria-controls="h4-material-package" aria-pressed="false"><span>03 · 경험</span><strong>여는 순간까지.</strong><small>색과 촉감을 포장까지 이어갑니다.</small><i data-h4-icon="arrow-right" aria-hidden="true"></i></button></div><div class="h4-material-stage"><figure class="h4-material-panel h4-package-scene" id="h4-material-brief" data-jw-forme-panel="0"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/forme-ritual.webp" width="1536" height="1024" alt="따뜻한 햇살 아래 올리브 가지와 천연 재료가 놓인 보태니컬 케어 장면" loading="lazy"><figcaption><strong>평범한 하루에서<br>시작한 브랜드.</strong><span>FORME / 자연스러운 일상의 감각</span></figcaption></figure><figure class="h4-material-panel h4-package-scene" id="h4-material-screen" data-jw-forme-panel="1"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/journey-products.webp" width="1122" height="1402" alt="FORME 보태니컬 케어 제품을 나란히 보여주는 장면" loading="lazy"><figcaption><strong>쓰임이 보이면,<br>선택은 쉬워집니다.</strong><span>제품을 보여주는 방식</span></figcaption></figure><figure class="h4-material-panel h4-package-scene" id="h4-material-package" data-jw-forme-panel="2"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/experience-pack.webp" width="1536" height="1024" alt="FORME 제품과 포장을 함께 담은 선물 상자" loading="lazy"><figcaption><strong>여는 순간까지<br>이어지는 인상.</strong><span>제품 · 포장 · 동봉 카드</span></figcaption></figure></div></div></div></div></div></section>
  <!-- 05. 제작: 제품 캠페인 사진으로 브랜드 경험을 보여줍니다. -->
<section class="h4-digital h4-section h4-wrap" id="h4-digital" aria-labelledby="h4-digital-title" data-jwh4-work-product="prototype"><div class="h4-digital-copy"><span class="h4-stage-label"><b>03</b> 제작 · 디지털 경험</span><h2 id="h4-digital-title">화면에서도<br>같은 브랜드로.</h2><p class="h4-summary">분위기는 사진이 전하고, 필요한 제품 정보는 짧고 또렷하게. 작은 화면에서도 자연스럽게 이어집니다.</p><ul class="h4-feature-list"><li><i data-h4-icon="image" aria-hidden="true"></i><span><strong>먼저 보이는 인상</strong><small>제품의 분위기를 한 장면으로</small></span></li><li><i data-h4-icon="mouse-pointer-2" aria-hidden="true"></i><span><strong>쉽게 찾는 제품</strong><small>이름과 쓰임을 가까이</small></span></li></ul></div><figure class="h4-digital-scene h4-reveal"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/digital.webp" width="1536" height="1024" alt="빛을 받은 FORME 보태니컬 케어 제품 캠페인 사진" loading="lazy"><figcaption>FORME / 디지털 캠페인 장면</figcaption></figure></section>
  <!-- 06. 브랜드 결과물: 전용 이미지와 디자인 시스템 견본 -->
  <section class="h4-brand h4-section" id="h4-brand" aria-labelledby="h4-brand-title" data-jwh4-work-product="handoff">
    <div class="h4-wrap"><div class="h4-heading"><div><h2 id="h4-brand-title">하나의 인상을,<br> 모든 접점에.</h2></div><p>화면에서 보던 브랜드를 손에 쥐었을 때도.<br class="h4-desktop-break"> 패키지, 인쇄물, 사용 가이드까지 같은 언어로 정리합니다.</p></div>
      <div class="h4-brand-grid"><figure class="h4-brand-photo h4-reveal"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/handoff.webp" alt="FORME의 유리 용기, 패키지, 브랜드 가이드북과 명함을 함께 배치한 완성 산출물" width="1536" height="1024" loading="lazy" decoding="async"><figcaption>FORME · 브랜드 아이덴티티 &amp; 패키지 디자인 예시</figcaption></figure><aside class="h4-brand-spec" aria-label="FORME 디자인 시스템 예시"><div class="h4-brand-wordmark"><i data-h4-icon="sprout" aria-hidden="true"></i><strong>FORME</strong><span>Botanical care. Everyday balance.</span></div><div class="h4-swatches" aria-label="브랜드 컬러: 포레스트, 세이지, 아이보리"><span class="h4-swatch-forest">Forest</span><span class="h4-swatch-sage">Sage</span><span class="h4-swatch-ivory">Ivory</span></div><div class="h4-brand-spec-note"><i data-h4-icon="fingerprint" aria-hidden="true"></i><div><strong>브랜드의 기준을 남깁니다.</strong><p>로고의 여백부터 컬러의 조합까지.<br> 다음 작업에도 같은 인상을 이어갑니다.</p></div></div></aside></div>
    </div>
  </section>


  <!-- 08. 자주 묻는 질문 -->
  <section class="h4-questions h4-section" aria-labelledby="h4-faq-title"><div class="h4-wrap h4-faq-layout"><div><i class="h4-faq-icon" data-h4-icon="messages-square" aria-hidden="true"></i><h2 id="h4-faq-title">시작하기 전에<br> 궁금한 이야기.</h2><p class="h4-summary">프로젝트의 크기보다, 지금 필요한 변화가 무엇인지 먼저 이야기합니다.</p><p class="h4-faq-prep"><strong>처음 대화할 때 있으면 좋은 자료</strong><span>지금 쓰는 소개 자료 · 참고하는 브랜드 · 바꾸고 싶은 장면</span></p></div><div class="h4-faq-list"><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">아이디어만 있어도 시작할 수 있나요?</summary><div class="tw:d-collapse-content"><p>네. 만들고 싶은 결과가 아직 구체적이지 않아도 괜찮습니다. 현재의 고민, 고객, 사업의 방향을 함께 정리하며 필요한 작업 범위를 찾습니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">브랜드와 웹사이트를 함께 맡길 수 있나요?</summary><div class="tw:d-collapse-content"><p>전략과 브랜드 디자인, 웹사이트를 하나의 흐름으로 계획할 수 있습니다. 이미 운영 중인 브랜드라면 기존 자산을 살리는 방향부터 검토합니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">과정 중에는 무엇을 확인하나요?</summary><div class="tw:d-collapse-content"><p>브리프, 경험 설계, 디자인 시안, 최종 전달물을 단계별로 공유합니다. 각 단계의 확인 기준과 의견을 정리한 뒤 다음 작업으로 이어갑니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">프로젝트 문의에는 어떤 내용이 필요한가요?</summary><div class="tw:d-collapse-content"><p>프로젝트의 목적과 필요한 결과물, 희망 일정이 있으면 좋습니다. 참고 자료가 있다면 함께 알려주세요. 아직 정하지 못한 부분은 대화하며 구체화할 수 있습니다.</p></div></details></div></div></section>

  <!-- 09. 마지막 행동 -->
  <section class="h4-contact-section" aria-labelledby="h4-contact-title"><div class="h4-contact h4-wrap"><div class="h4-contact-copy"><i data-h4-icon="send" aria-hidden="true"></i><h2 id="h4-contact-title">우리의 다음 결과물,<br>함께 정해볼까요?</h2><p>아직 답이 없어도 괜찮습니다.<br>지금의 질문을 첫 장의 브리프로 만듭니다.</p></div><div class="h4-contact-brief"><dl><div><dt>어떤 변화를</dt><dd>새롭게 알리고 싶은 브랜드의 모습</dd></div><div><dt>어떤 결과물로</dt><dd>브랜드 · 웹 · 패키지, 필요한 접점부터</dd></div><div><dt>언제부터 함께</dt><dd>희망 시점과 현재 준비된 자료</dd></div></dl><a class="tw:d-btn tw:d-btn-primary" href="<?php echo G5_URL; ?>/pages/contact-1.php">프로젝트 문의하기 <i data-h4-icon="arrow-up-right" aria-hidden="true"></i></a><small>FORME는 작업 방식을 보여주기 위한 가상 브랜드입니다.</small></div></div></section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
