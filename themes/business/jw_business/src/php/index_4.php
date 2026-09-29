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
      <div class="h4-journey-track" data-jw-forme-story data-jw-stage="0">
        <div class="h4-journey">
          <div class="h4-board-heading"><span><i data-h4-icon="route" aria-hidden="true"></i> FORME · 질문에서 경험으로</span><span>가상 브랜드의 실제 디자인 자료</span></div>
          <div class="h4-material-layout">
            <div class="h4-material-steps" role="group" aria-label="FORME 과정 자료 선택">
              <button type="button" data-jw-forme-select="0" aria-controls="h4-material-brief" aria-pressed="true"><span>01 · 발견 자료</span><strong>무엇을 먼저<br>말할 것인가.</strong><small>관찰한 질문을 브랜드의 언어로 정리합니다.</small><i data-h4-icon="arrow-right" aria-hidden="true"></i></button>
              <button type="button" data-jw-forme-select="1" aria-controls="h4-material-screen" aria-pressed="false"><span>02 · 선택 화면</span><strong>나에게 맞는<br>제품을 찾도록.</strong><small>같은 정보를 제품에 맞게 비교할 수 있게 합니다.</small><i data-h4-icon="arrow-right" aria-hidden="true"></i></button>
              <button type="button" data-jw-forme-select="2" aria-controls="h4-material-package" aria-pressed="false"><span>03 · 경험 결과</span><strong>여는 순간까지<br>이어지는 인상.</strong><small>웹에서 본 색과 이야기를 포장까지 연결합니다.</small><i data-h4-icon="arrow-right" aria-hidden="true"></i></button>
            </div>
            <div class="h4-material-stage">
              <div class="h4-material-panel h4-brief-sheet h4-demo-artwork" id="h4-material-brief" data-jw-forme-panel="0">
                <header><strong>FORME</strong><span>브랜드 브리프 · 시연 자료</span></header>
                <h3>일상의 작은 균형.</h3><p class="h4-brief-lead">자연스러운 데일리 케어를 찾는 사람에게,<br> 매일 쓰기 편안한 제품의 이유를 전합니다.</p>
                <div class="h4-brief-observation"><span>고객의 질문</span><blockquote>“좋은 재료라는 건 알겠어요.<br> 그런데 언제, 어떻게 쓰면 될까요?”</blockquote></div>
                <dl class="h4-brief-decisions"><div><dt>먼저 보여줄 것</dt><dd>씻고, 바르고, 쉬는 일상의 사용 장면</dd></div><div><dt>그다음 알려줄 것</dt><dd>제품의 용도와 용량, 주요 재료의 특징</dd></div><div><dt>남길 인상</dt><dd>담백한 사진 · 짧은 설명 · 편안한 색</dd></div></dl>
                <footer><span>질문에서 정한 세 가지 기준</span><strong>일상 / 명료함 / 자연스러움</strong></footer>
              </div>
              <div class="h4-material-panel h4-choice-screen h4-demo-artwork" id="h4-material-screen" data-jw-forme-panel="1">
                <header><strong>FORME</strong><span>Our story　 Collection　 Care guide</span></header>
                <div class="h4-choice-content"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/journey-products.webp" alt="FORME 핸드 앤 바디 워시와 핸드크림의 형태·용량을 함께 보여주는 제품 사진" width="1122" height="1402" loading="lazy" decoding="async"><div><span class="h4-choice-label">나의 일상에 맞는 케어</span><h3>씻는 순간,<br> 바르는 순간.</h3><dl><div><dt>Hand &amp; body wash</dt><dd>300ml · 샤워와 손 씻기<br>베티버 잎 · 베르가모트</dd></div><div><dt>Nourishing hand cream</dt><dd>75ml · 건조한 손의 데일리 케어<br>시어버터 · 올리브 잎</dd></div></dl><p>용도와 재료를 같은 순서로.<br>나에게 필요한 제품을 쉽게 비교합니다.</p></div></div>
                <footer><span>일상에 스며드는 자연의 균형.</span><small>제품 탐색 화면 디자인 시안</small></footer>
              </div>
              <figure class="h4-material-panel h4-package-scene" id="h4-material-package" data-jw-forme-panel="2"><img src="<?php echo G5_THEME_URL; ?>/assets/home-four/experience-pack.webp" alt="FORME 제품, 포레스트 포장지, 아이보리 동봉 카드를 같은 선물 상자에 정리한 경험 디자인" width="1536" height="1024" loading="lazy" decoding="async"><figcaption><strong>만나는 곳이 달라도,<br>같은 브랜드로 기억되도록.</strong><span>제품 · 포장 · 동봉 카드가 공유하는 색과 촉감</span></figcaption></figure>
            </div>
          </div>
          <p class="h4-board-note"><i data-h4-icon="link" aria-hidden="true"></i> 자료를 선택하거나 스크롤하며, 생각이 결과로 이어지는 과정을 살펴보세요.</p>
        </div>
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
    <div class="h4-delivery-folio" aria-label="FORME 브랜드 사용 가이드와 전달 파일 명세 시안">
      <div class="h4-guide-spread h4-demo-artwork">
        <div class="h4-guide-page"><div class="h4-guide-running"><span>FORME / BRAND GUIDE</span><b>08</b></div><h3>로고가 숨 쉴 공간</h3><div class="h4-guide-wordmark"><span>최소 여백 = 로고 높이의 ½</span><strong>FORME</strong><span>주변 요소와 충분한 거리를 둡니다</span></div><p>형태와 자간을 그대로 사용합니다.<br>사진 위에서는 명암 차이가 충분한 면을 고릅니다.</p><div class="h4-guide-colors"><span>Forest</span><span>Sage</span><span>Ivory</span></div><small>주조색 · 보조색 · 배경색의 역할을 지킵니다.</small></div>
        <div class="h4-guide-page"><div class="h4-guide-running"><span>FORME / DIGITAL GUIDE</span><b>09</b></div><h3>화면마다 같은 순서</h3><ol class="h4-guide-content"><li><span>01</span><div><strong>제품이 쓰이는 순간</strong><p>생활 장면과 한 문장으로 시작합니다.</p></div></li><li><span>02</span><div><strong>고르는 데 필요한 정보</strong><p>용도 · 용량 · 주요 재료를 나란히.</p></div></li><li><span>03</span><div><strong>오래 쓰기 위한 안내</strong><p>사용법 · 보관 · 패키지 안내로 이어집니다.</p></div></li></ol><div class="h4-guide-rule"><i data-h4-icon="check" aria-hidden="true"></i><span>제품 정보가 바뀌면 모바일 문구와 인쇄물도 함께 확인합니다.</span></div></div>
      </div>
      <div class="h4-file-register"><div><i data-h4-icon="folder-open" aria-hidden="true"></i><strong>정리해서 전달하는 네 가지</strong><span>구성 예시</span></div><dl><div><dt>브랜드 원본</dt><dd>로고 · 그래픽 · 컬러 기준</dd><dd class="h4-file-format">SVG / PDF</dd></div><div><dt>매체별 자산</dt><dd>웹 · 인쇄 · 채널별 규격</dd><dd class="h4-file-format">WEBP / PDF</dd></div><div><dt>화면과 사용 가이드</dt><dd>PC·모바일 시안 · 편집 안내</dd><dd class="h4-file-format">FIG / PDF</dd></div><div><dt>최종 확인 기록</dt><dd>검토 내용 · 운영 시 확인할 것</dd><dd class="h4-file-format">CHECKLIST</dd></div></dl></div>
    </div>
  </section>

  <!-- 08. 자주 묻는 질문 -->
  <section class="h4-questions h4-section" aria-labelledby="h4-faq-title"><div class="h4-wrap h4-faq-layout"><div><i class="h4-faq-icon" data-h4-icon="messages-square" aria-hidden="true"></i><h2 id="h4-faq-title">시작하기 전에<br> 궁금한 이야기.</h2><p class="h4-summary">프로젝트의 크기보다, 지금 필요한 변화가 무엇인지 먼저 이야기합니다.</p><p class="h4-faq-prep"><strong>처음 대화할 때 있으면 좋은 자료</strong><span>지금 쓰는 소개 자료 · 참고하는 브랜드 · 바꾸고 싶은 장면</span></p></div><div class="h4-faq-list"><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">아이디어만 있어도 시작할 수 있나요?</summary><div class="tw:d-collapse-content"><p>네. 만들고 싶은 결과가 아직 구체적이지 않아도 괜찮습니다. 현재의 고민, 고객, 사업의 방향을 함께 정리하며 필요한 작업 범위를 찾습니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">브랜드와 웹사이트를 함께 맡길 수 있나요?</summary><div class="tw:d-collapse-content"><p>전략과 브랜드 디자인, 웹사이트를 하나의 흐름으로 계획할 수 있습니다. 이미 운영 중인 브랜드라면 기존 자산을 살리는 방향부터 검토합니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">과정 중에는 무엇을 확인하나요?</summary><div class="tw:d-collapse-content"><p>브리프, 경험 설계, 디자인 시안, 최종 전달물을 단계별로 공유합니다. 각 단계의 확인 기준과 의견을 정리한 뒤 다음 작업으로 이어갑니다.</p></div></details><details class="tw:d-collapse tw:d-collapse-arrow"><summary class="tw:d-collapse-title">프로젝트 문의에는 어떤 내용이 필요한가요?</summary><div class="tw:d-collapse-content"><p>프로젝트의 목적과 필요한 결과물, 희망 일정이 있으면 좋습니다. 참고 자료가 있다면 함께 알려주세요. 아직 정하지 못한 부분은 대화하며 구체화할 수 있습니다.</p></div></details></div></div></section>

  <!-- 09. 마지막 행동 -->
  <section class="h4-contact-section" aria-labelledby="h4-contact-title"><div class="h4-contact h4-wrap"><div class="h4-contact-copy"><i data-h4-icon="send" aria-hidden="true"></i><h2 id="h4-contact-title">우리의 다음 결과물,<br>함께 정해볼까요?</h2><p>아직 답이 없어도 괜찮습니다.<br>지금의 질문을 첫 장의 브리프로 만듭니다.</p></div><div class="h4-contact-brief"><dl><div><dt>어떤 변화를</dt><dd>새롭게 알리고 싶은 브랜드의 모습</dd></div><div><dt>어떤 결과물로</dt><dd>브랜드 · 웹 · 패키지, 필요한 접점부터</dd></div><div><dt>언제부터 함께</dt><dd>희망 시점과 현재 준비된 자료</dd></div></dl><a class="tw:d-btn tw:d-btn-primary" href="<?php echo G5_URL; ?>/pages/contact-1.php">프로젝트 문의하기 <i data-h4-icon="arrow-up-right" aria-hidden="true"></i></a><small>FORME는 작업 방식을 보여주기 위한 가상 브랜드입니다.</small></div></div></section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
