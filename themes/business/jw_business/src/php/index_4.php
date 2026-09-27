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
        <a class="h4-process-card" href="#h4-handoff"><span class="h4-step-no">04</span><i class="h4-large-icon" data-h4-icon="package-check" aria-hidden="true"></i><h3>인계</h3><p>완성된 결과가<br> 계속 잘 쓰이도록.</p><span class="h4-card-bottom">원본 &amp; 사용 가이드 <i data-h4-icon="arrow-down-right" aria-hidden="true"></i></span></a>
      </div>
    </div>
  </section>

  <!-- 03. 발견: 작업 사진 + 정렬된 관찰/목표 + 인사이트 관계도 -->
  <section class="h4-section h4-wrap h4-discovery" id="h4-discovery" aria-labelledby="h4-discovery-title" data-jwh4-work-product="brief">
    <figure class="h4-workshop h4-reveal"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/discovery.webp" alt="두 디자이너가 FORME의 패키지와 고객 여정 자료를 함께 검토하는 모습" width="1536" height="1024" loading="lazy" decoding="async"><figcaption><i data-h4-icon="messages-square" aria-hidden="true"></i><span>질문하고, 펼쳐 보고, 함께 정리합니다.</span></figcaption></figure>
    <div class="h4-discovery-copy"><span class="h4-stage-label"><b>01</b> 발견 · 프로젝트 브리프</span><h2 id="h4-discovery-title">좋은 질문에서<br> 시작합니다.</h2><p class="h4-summary">무엇을 만들지보다, 왜 필요한지 먼저 묻습니다. 브랜드의 이야기와 고객의 선택이 만나는 지점을 찾습니다.</p>
      <div class="h4-insights"><div><i data-h4-icon="scan-eye" aria-hidden="true"></i><h3>관찰</h3><p>좋은 원료의 이야기가<br> 제품의 첫인상에 드러나지 않습니다.</p></div><div><i data-h4-icon="target" aria-hidden="true"></i><h3>목표</h3><p>자연스러운 일상의 가치를<br> 보이는 경험으로 연결합니다.</p></div></div>
      <div class="h4-insight-map" aria-label="사람의 필요와 브랜드의 가치를 연결해 디자인 방향을 찾습니다"><span><i data-h4-icon="users-round" aria-hidden="true"></i>사람의 필요</span><i data-h4-icon="plus" aria-hidden="true"></i><span><i data-h4-icon="sprout" aria-hidden="true"></i>브랜드의 가치</span><i data-h4-icon="arrow-right" aria-hidden="true"></i><span class="h4-insight-result"><i data-h4-icon="lightbulb" aria-hidden="true"></i>디자인 방향</span></div>
    </div>
  </section>

  <!-- 04. 설계: HTML 고객 여정도, 데스크톱 가로 / 모바일 세로 -->
  <section class="h4-strategy h4-section" id="h4-strategy" aria-labelledby="h4-strategy-title" data-jwh4-work-product="journey">
    <div class="h4-wrap"><div class="h4-heading"><div><span class="h4-stage-label"><b>02</b> 설계 · 고객 여정</span><h2 id="h4-strategy-title">고객의 다음 행동을<br> 함께 설계합니다.</h2></div><p>처음 마주치는 장면부터 손에 닿는 순간까지.<br class="h4-desktop-break"> 각 접점의 역할을 정하면 디자인의 이유가 선명해집니다.</p></div>
      <div class="h4-journey h4-reveal"><div class="h4-board-heading"><span><i data-h4-icon="route" aria-hidden="true"></i> FORME · 경험 설계도</span><span>하나의 브랜드, 네 개의 접점</span></div>
        <ol class="h4-journey-nodes"><li><span class="h4-node-icon"><i data-h4-icon="eye" aria-hidden="true"></i></span><small>01 · 발견</small><h3>눈에 머무르다</h3><p>브랜드다운 사진과<br> 짧고 선명한 첫 문장</p><span class="h4-touchpoint"><i data-h4-icon="image" aria-hidden="true"></i> 캠페인 비주얼</span></li><li><span class="h4-node-icon"><i data-h4-icon="leaf" aria-hidden="true"></i></span><small>02 · 이해</small><h3>이야기를 알다</h3><p>원료와 철학을 연결한<br> 읽기 편한 콘텐츠</p><span class="h4-touchpoint"><i data-h4-icon="book-open" aria-hidden="true"></i> 브랜드 스토리</span></li><li><span class="h4-node-icon"><i data-h4-icon="mouse-pointer-2" aria-hidden="true"></i></span><small>03 · 선택</small><h3>나에게 맞추다</h3><p>제품의 차이를 설명하는<br> 명확한 정보 구조</p><span class="h4-touchpoint"><i data-h4-icon="monitor" aria-hidden="true"></i> 제품 웹페이지</span></li><li><span class="h4-node-icon"><i data-h4-icon="gift" aria-hidden="true"></i></span><small>04 · 경험</small><h3>오래 기억하다</h3><p>여는 순간까지 이어지는<br> 일관된 색과 촉감</p><span class="h4-touchpoint"><i data-h4-icon="package" aria-hidden="true"></i> 패키지 &amp; 인쇄물</span></li></ol>
        <p class="h4-board-note"><i data-h4-icon="link" aria-hidden="true"></i> 서로 다른 매체에도, 같은 브랜드의 인상이 이어지도록.</p>
      </div>
    </div>
  </section>

  <!-- 05. 제작: 브라우저형 실제 HTML 시안. 이미지 한 장으로 UI를 대체하지 않습니다. -->
  <section class="h4-digital h4-section h4-wrap" id="h4-digital" aria-labelledby="h4-digital-title" data-jwh4-work-product="prototype">
    <div class="h4-digital-copy"><span class="h4-stage-label"><b>03</b> 제작 · 디지털 경험</span><h2 id="h4-digital-title">보는 인상과<br> 쓰는 경험을 함께.</h2><p class="h4-summary">브랜드의 분위기는 지키고, 정보는 더 쉽게 찾도록. 화면의 크기가 바뀌어도 중요한 이야기는 또렷하게 남깁니다.</p><ul class="h4-feature-list"><li><i data-h4-icon="layout-template" aria-hidden="true"></i><span><strong>내용에 맞는 화면 구조</strong><small>사진, 제목, 정보의 우선순위를 설계합니다.</small></span></li><li><i data-h4-icon="smartphone" aria-hidden="true"></i><span><strong>작은 화면까지 자연스럽게</strong><small>모바일의 여백과 읽는 순서도 다듬습니다.</small></span></li><li><i data-h4-icon="palette" aria-hidden="true"></i><span><strong>접점마다 일관된 표현</strong><small>색과 서체, 사진의 분위기를 연결합니다.</small></span></li></ul></div>
    <div class="h4-browser-stage h4-reveal"><div class="h4-browser"><div class="h4-browser-bar"><span aria-hidden="true"><b></b><b></b><b></b></span><small>FORME — 브랜드 웹사이트 시안</small><i data-h4-icon="panel-top" aria-hidden="true"></i></div><div class="h4-demo-site"><div class="h4-demo-nav"><strong>FORME</strong><span>Our story&nbsp;&nbsp;&nbsp; Collection</span><i data-h4-icon="menu" aria-hidden="true"></i></div><div class="h4-demo-hero"><div><span>Botanical essentials</span><h3>일상에 스며드는<br> 자연의 균형.</h3><p>당신의 하루를 위한 작은 리추얼.</p><span class="h4-demo-link">컬렉션 둘러보기 <i data-h4-icon="arrow-right" aria-hidden="true"></i></span></div><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/digital.webp" alt="부드러운 창가 빛을 받은 FORME 보태니컬 케어 제품의 웹사이트 캠페인 사진" width="1536" height="1024" loading="lazy" decoding="async"></div><div class="h4-demo-values"><span><i data-h4-icon="leaf" aria-hidden="true"></i> 자연에서 온 재료</span><span><i data-h4-icon="droplets" aria-hidden="true"></i> 편안한 데일리 케어</span><span><i data-h4-icon="recycle" aria-hidden="true"></i> 오래 생각한 패키지</span></div></div></div><p class="h4-preview-caption"><i data-h4-icon="monitor-smartphone" aria-hidden="true"></i> 같은 이야기를, 화면에 맞는 구성으로.</p></div>
  </section>

  <!-- 06. 브랜드 결과물: 전용 이미지와 디자인 시스템 견본 -->
  <section class="h4-brand h4-section" id="h4-brand" aria-labelledby="h4-brand-title">
    <div class="h4-wrap"><div class="h4-heading"><div><h2 id="h4-brand-title">하나의 인상을,<br> 모든 접점에.</h2></div><p>화면에서 보던 브랜드를 손에 쥐었을 때도.<br class="h4-desktop-break"> 패키지, 인쇄물, 사용 가이드까지 같은 언어로 정리합니다.</p></div>
      <div class="h4-brand-grid"><figure class="h4-brand-photo h4-reveal"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/handoff.webp" alt="FORME의 유리 용기, 패키지, 브랜드 가이드북과 명함을 함께 배치한 완성 산출물" width="1536" height="1024" loading="lazy" decoding="async"><figcaption>FORME · 브랜드 아이덴티티 &amp; 패키지 디자인 예시</figcaption></figure><aside class="h4-brand-spec" aria-label="FORME 디자인 시스템 예시"><div class="h4-brand-wordmark"><i data-h4-icon="sprout" aria-hidden="true"></i><strong>FORME</strong><span>Botanical care. Everyday balance.</span></div><div class="h4-swatches" aria-label="브랜드 컬러: 포레스트, 세이지, 아이보리"><span class="h4-swatch-forest">Forest</span><span class="h4-swatch-sage">Sage</span><span class="h4-swatch-ivory">Ivory</span></div><div class="h4-brand-spec-note"><i data-h4-icon="fingerprint" aria-hidden="true"></i><div><strong>브랜드의 기준을 남깁니다.</strong><p>로고의 여백부터 컬러의 조합까지.<br> 다음 작업에도 같은 인상을 이어갑니다.</p></div></div></aside></div>
    </div>
  </section>

  <!-- 07. 인계: 파일별 아이콘과 전달물. 실제 파일 다운로드로 오인되지 않도록 링크를 두지 않습니다. -->
  <section class="h4-section h4-wrap h4-handoff" id="h4-handoff" aria-labelledby="h4-handoff-title" data-jwh4-work-product="handoff">
    <div><span class="h4-stage-label"><b>04</b> 인계 · 전달 패키지</span><h2 id="h4-handoff-title">완성 이후에도<br> 잘 쓰이도록.</h2><p class="h4-summary">다음 담당자가 이어서 사용할 수 있는 형태로 정리합니다. 결과물과 함께, 활용하는 방법도 전달합니다.</p><div class="h4-delivery-seal"><i data-h4-icon="package-check" aria-hidden="true"></i><span>정리된 파일.<br> <strong>명확한 사용 기준.</strong></span></div></div>
    <div class="h4-delivery-grid"><div class="h4-file-card"><i data-h4-icon="file-pen-line" aria-hidden="true"></i><span>01 / SOURCE</span><h3>편집 가능한 원본</h3><p>로고, 그래픽, 레이아웃의<br> 원본 파일과 폴더 구조</p></div><div class="h4-file-card"><i data-h4-icon="images" aria-hidden="true"></i><span>02 / ASSETS</span><h3>매체별 이미지</h3><p>웹과 인쇄, 채널의 규격에<br> 맞추어 정리한 자산</p></div><div class="h4-file-card"><i data-h4-icon="book-open-check" aria-hidden="true"></i><span>03 / GUIDE</span><h3>브랜드 사용 가이드</h3><p>색, 서체, 사진의 기준과<br> 반드시 지킬 사용 원칙</p></div><div class="h4-file-card"><i data-h4-icon="list-checks" aria-hidden="true"></i><span>04 / CHECKLIST</span><h3>인계 체크리스트</h3><p>확인한 내용과 남은 과제를<br> 한눈에 보는 최종 기록</p></div></div>
  </section>

  <!-- 08. 자주 묻는 질문 -->
  <section class="h4-questions h4-section" aria-labelledby="h4-faq-title"><div class="h4-wrap h4-faq-layout"><div><i class="h4-faq-icon" data-h4-icon="messages-square" aria-hidden="true"></i><h2 id="h4-faq-title">시작하기 전에<br> 궁금한 이야기.</h2><p class="h4-summary">프로젝트의 크기보다, 지금 필요한 변화가 무엇인지 먼저 이야기합니다.</p></div><div class="h4-faq-list"><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">아이디어만 있어도 시작할 수 있나요?</summary><div class="tw:d-collapse-content"><p>네. 만들고 싶은 결과가 아직 구체적이지 않아도 괜찮습니다. 현재의 고민, 고객, 사업의 방향을 함께 정리하며 필요한 작업 범위를 찾습니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">브랜드와 웹사이트를 함께 맡길 수 있나요?</summary><div class="tw:d-collapse-content"><p>전략과 브랜드 디자인, 웹사이트를 하나의 흐름으로 계획할 수 있습니다. 이미 운영 중인 브랜드라면 기존 자산을 살리는 방향부터 검토합니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">과정 중에는 무엇을 확인하나요?</summary><div class="tw:d-collapse-content"><p>브리프, 경험 설계, 디자인 시안, 최종 전달물을 단계별로 공유합니다. 각 단계의 확인 기준과 의견을 정리한 뒤 다음 작업으로 이어갑니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">프로젝트 문의에는 어떤 내용이 필요한가요?</summary><div class="tw:d-collapse-content"><p>프로젝트의 목적과 필요한 결과물, 희망 일정이 있으면 좋습니다. 참고 자료가 있다면 함께 알려주세요. 아직 정하지 못한 부분은 대화하며 구체화할 수 있습니다.</p></div></details></div></div></section>

  <!-- 09. 마지막 행동 -->
  <section class="h4-contact h4-wrap" aria-labelledby="h4-contact-title"><div class="h4-contact-icon"><i data-h4-icon="send" aria-hidden="true"></i></div><div><h2 id="h4-contact-title">다음 이야기는,<br class="h4-mobile-break"> 함께 시작해 볼까요?</h2><p>지금의 고민을 들려주세요. 첫 질문부터 함께하겠습니다.</p></div><a class="tw:d-btn tw:d-btn-primary" href="<?php echo G5_URL; ?>/pages/contact-1.php">프로젝트 문의하기 <i data-h4-icon="arrow-up-right" aria-hidden="true"></i></a></section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
