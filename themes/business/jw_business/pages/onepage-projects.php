<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/onepage-projects.php
 * Role: 독립 원페이지 — 공간·브랜드 프로젝트
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT. All rights reserved.
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) include_once dirname(__DIR__).'/common.php';
$g5['title'] = '일과 쉼 사이 · 프로젝트';
$g5['document_meta'] = array('description' => '공간의 의도와 장면, 사용자의 경험을 이어서 보여 주는 프로젝트 소개 시연입니다.', 'canonical' => G5_URL.'/pages/onepage-projects.php');
$jw_full_width_page = true;
$jwo_assets = htmlspecialchars(G5_THEME_URL.'/onepages/assets', ENT_QUOTES, 'UTF-8');
$jwo_css_url = htmlspecialchars(get_versioned_asset_url(G5_THEME_URL.'/css/onepages.min.css'), ENT_QUOTES, 'UTF-8');
$jwo_js_url = htmlspecialchars(get_versioned_asset_url(G5_THEME_URL.'/js/onepages.min.js'), ENT_QUOTES, 'UTF-8');
add_stylesheet('<link rel="stylesheet" href="'.$jwo_css_url.'">', 30);
include_once G5_THEME_PATH.'/head.php';
?>
<article class="jwo jwo--projects" data-jw-onepage="projects">
    <nav class="jwo-nav" aria-label="프로젝트 소개 목차"><a class="jwo-nav__brand" href="#project-top">일과 쉼 사이</a><div class="jwo-nav__links"><a href="#project-studio">스튜디오</a><a href="#project-intent">공간의 의도</a><a href="#project-scenes">장면들</a><a href="#project-gallery">갤러리</a></div><a class="jwo-nav__action" href="#project-contact">프로젝트 문의</a></nav>
    <section class="jwo-project-hero" id="project-top" aria-label="공간 콘셉트 장면 슬라이드" data-jwo-project-hero>
      <div class="jwo-project-hero__viewport" data-jwo-project-hero-viewport><div class="jwo-project-hero__track">
        <figure><img src="<?php echo $jwo_assets; ?>/images/courtyard.webp" width="1536" height="1024" alt="정원과 수공간을 사이에 둔 콘크리트와 유리의 업무 공간 콘셉트" fetchpriority="high"><figcaption>01 / COURTYARD · 정원과 물의 중정</figcaption></figure>
        <figure><img src="<?php echo $jwo_assets; ?>/images/project-hero-walkway.webp" width="1908" height="824" alt="유리 건물과 중정을 연결하는 긴 회랑과 그늘진 보행로" loading="eager"><figcaption>02 / WALKWAY · 걸음을 늦추는 회랑</figcaption></figure>
        <figure><img src="<?php echo $jwo_assets; ?>/images/project-hero-dusk.webp" width="1672" height="941" alt="저녁 조명이 켜진 중정과 유리 건물, 잔잔한 수공간" loading="eager"><figcaption>03 / EVENING · 하루를 마무리하는 정원</figcaption></figure>
      </div></div>
      <div class="jwo-project-hero__shade" aria-hidden="true"></div>
      <div class="jwo-wrap jwo-project-hero__content"><span class="jwo-project-hero__eyebrow">SAI STUDIO / SPACE EXPERIENCE</span><h1>머무는 시간이<br>좋아지는 공간.</h1><p>일과 쉼 사이, 하루를 담은 공간 이야기.</p><a class="jwo-button" href="#project-intent">공간 이야기 보기 <i data-jwo-icon="arrow-down" aria-hidden="true"></i></a></div>
      <div class="jwo-wrap jwo-project-hero__bottom"><p>공간·브랜드 소개 시연 · AI 콘셉트 이미지이며 실제 완공 프로젝트가 아닙니다.</p><div class="jwo-project-hero__controls" hidden data-jwo-project-hero-controls><button type="button" data-jwo-project-hero-prev aria-label="이전 장면">←</button><span data-jwo-project-hero-status role="status" aria-live="polite">01 / 03</span><button type="button" data-jwo-project-hero-next aria-label="다음 장면">→</button><button type="button" data-jwo-project-hero-toggle aria-label="자동 슬라이드 일시 정지">일시 정지</button></div></div>
    </section>
    <section class="jwo-section jwo-wrap jwo-space-studio" id="project-studio" data-jwo-company-profile><div><h2>공간을 만드는<br>우리의 관점.</h2><p class="jwo-lead">사이 스튜디오는 사람의 동선과 브랜드의 태도를 함께 설계하는 공간 디자인 팀입니다.</p><p>보기 좋은 한 장면보다 매일 쓰이는 여러 장면을 생각합니다. 기획과 재료, 안내 체계를 함께 검토해 공간 전체에 같은 생각이 흐르도록 합니다.</p><a class="jwo-button jwo-button--subtle" href="#project-scope">함께할 수 있는 일 <i data-jwo-icon="arrow-down" aria-hidden="true"></i></a></div><figure><img src="<?php echo $jwo_assets; ?>/images/space-studio.webp" width="1536" height="1024" alt="재료 견본과 중정 모형으로 공간을 검토하는 가상 스튜디오" loading="lazy"><figcaption>사이 스튜디오의 작업 장면 시연 · AI 생성 이미지</figcaption></figure></section>
<section class="jwo-section jwo-wrap jwo-intro" id="project-intent"><h2>건물보다 먼저,<br>그 안의 하루를 봅니다.</h2><div><p class="jwo-lead">집중하는 시간과 잠깐의 여유.<br>서로 다른 리듬이 함께 머물 수 있도록.</p><p>좋은 공간에 대한 질문은 단순한 형태에서 끝나지 않습니다. 어디에서 만나고, 얼마나 머물며, 어떤 장면에서 편안함을 느끼는지. 사람의 경험을 따라 공간의 방향을 정리합니다.</p><dl class="jwo-facts"><div><dt>프로젝트 유형</dt><dd>업무·문화 공간 콘셉트</dd></div><div><dt>살펴볼 주제</dt><dd>동선 · 자연광 · 함께 쓰는 공간</dd></div><div><dt>자료 구분</dt><dd>테마 시연용 가상 기획</dd></div></dl></div></section>
    <section class="jwo-project-flow jwo-section jwo-project-journey" aria-labelledby="project-flow-title" data-jwo-project-flow><div class="jwo-wrap"><div class="jwo-section-head"><h2 id="project-flow-title">걸음마다 달라지는<br>공간의 표정.</h2><p>입구, 정원, 라운지. 같은 장소를 서로 다른 거리에서 만납니다.</p></div><div class="jwo-project-journey__grid"><figure><img src="<?php echo $jwo_assets; ?>/correction/project-arrival.webp" width="1536" height="1024" alt="유리 입구 너머 정원을 바라보는 도착 장면" loading="lazy"><figcaption><span>01 / 도착</span><strong>첫 방향이 보이는 입구.</strong></figcaption></figure><figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-detail.webp" width="1536" height="1024" alt="중정의 콘크리트와 유리 수공간이 만나는 디테일" loading="lazy"><figcaption><span>02 / 사이</span><strong>빛과 물을 따라 잠깐의 여유.</strong></figcaption></figure><figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-interior.webp" width="1536" height="1024" alt="정원을 향한 라운지의 긴 테이블" loading="lazy"><figcaption><span>03 / 머묾</span><strong>함께 앉아 정원을 바라보는 곳.</strong></figcaption></figure></div></div></section>

<section class="jwo-section jwo-wrap jwo-project-editorial"><div><h2>재료와 빛이<br>만드는 리듬.</h2><p>콘크리트의 거친 표면, 유리에 비친 정원, 물 위로 움직이는 빛을 하나의 공간 언어로 묶었습니다.</p><p>가구 하나의 배치보다 중요한 것은 그 주변에서 일어날 하루의 모습입니다.</p></div><figure><img src="<?php echo $jwo_assets; ?>/correction/project-material-study.webp" width="1536" height="1024" alt="콘크리트 월넛 금속 유리 직물을 실제 견본으로 편집한 SAI 마감 재료판" loading="lazy"><figcaption>표면·접촉감·빛의 관계를 함께 검토하는 가상 재료 견본입니다.</figcaption></figure></section>
    <section class="jwo-section jwo-gallery-section" id="project-gallery"><div class="jwo-wrap jwo-section-head"><h2>다른 장면,<br>하나의 방향.</h2><p>정원에서 업무 공간, 대화의 자리까지.<br>각 장면이 전하는 경험을 살펴보세요.</p></div><div class="jwo-gallery" data-jwo-gallery>
        <div class="jwo-gallery__viewport" data-jwo-gallery-viewport tabindex="0" aria-label="프로젝트 이미지 갤러리. 좌우 방향키 또는 스와이프로 이동합니다."><div class="jwo-gallery__track">
            <figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-colonnade.webp" width="1536" height="1024" alt="정원을 향해 열린 그늘진 회랑" loading="lazy"><figcaption><strong>이어지는 회랑</strong><span>밖과 안을 천천히 연결하는 길</span></figcaption></figure>
            <figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-lounge.webp" width="1536" height="1024" alt="정원이 보이는 따뜻한 실내 라운지" loading="lazy"><figcaption><strong>머무는 라운지</strong><span>조용한 대화와 휴식을 위한 자리</span></figcaption></figure>
            <figure><img src="<?php echo $jwo_assets; ?>/images/project-gallery-stair.webp" width="1536" height="1024" alt="정원이 내려다보이는 넓은 계단형 쉼터" loading="lazy"><figcaption><strong>내려다보는 계단</strong><span>이동과 휴식이 겹치는 자리</span></figcaption></figure>
            <figure><img src="<?php echo $jwo_assets; ?>/images/project-gallery-workroom.webp" width="1536" height="1024" alt="중정과 맞닿은 공유 작업실과 긴 테이블" loading="lazy"><figcaption><strong>함께 일하는 방</strong><span>빛과 대화가 들어오는 작업실</span></figcaption></figure>
            <figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-terrace.webp" width="1536" height="1024" alt="저녁빛이 비치는 정원 테라스와 수공간" loading="lazy"><figcaption><strong>저녁의 테라스</strong><span>하루의 끝에도 열려 있는 여백</span></figcaption></figure>
        </div></div>
        <div class="jwo-wrap jwo-gallery__controls" hidden data-jwo-gallery-controls><p data-jwo-gallery-status role="status" aria-live="polite">1 / 5 · 이어지는 회랑</p><div><button class="jwo-button jwo-button--subtle" type="button" data-jwo-prev aria-label="이전 이미지">이전</button><button class="jwo-button jwo-button--subtle" type="button" data-jwo-next aria-label="다음 이미지">다음</button></div></div>
    </div></section>
<section class="jwo-section jwo-space-scope" id="project-scope" data-jwo-service-scope><div class="jwo-wrap"><div class="jwo-section-head"><h2>하나의 장소를,<br>여러 시선으로.</h2><p>공간의 목적부터 사용자에게 닿는 마지막 안내까지.<br>필요한 분야를 함께 연결합니다.</p></div><div class="jwo-space-disciplines"><article><i data-jwo-icon="landmark" aria-hidden="true"></i><h3>공간 기획</h3><p>사용자와 운영 방식에서 출발하는 배치·동선·공간 콘셉트.</p><span>업무 / 문화 / 브랜드 공간</span></article><article><i data-jwo-icon="layers" aria-hidden="true"></i><h3>인테리어·재료</h3><p>표면의 촉감과 빛, 가구의 쓰임을 함께 검토하는 실내 설계.</p><span>재료 / 조명 / 가구 계획</span></article><article><i data-jwo-icon="signpost" aria-hidden="true"></i><h3>브랜드 경험</h3><p>공간의 성격을 자연스럽게 전하는 안내와 시각 언어.</p><span>사인 / 그래픽 / 콘텐츠</span></article></div></div></section>
<section class="jwo-section jwo-space-process" id="project-process" data-jwo-delivery-process data-jwo-project-deliverables><div class="jwo-wrap"><div class="jwo-section-head"><h2>질문에서 시작해,<br>쓰이는 장소까지.</h2><p>도면과 실제 재료를 같은 테이블에 놓고,<br>처음의 의도가 마지막 인계까지 이어지게 합니다.</p></div><figure class="jwo-space-process__visual"><img src="<?php echo $jwo_assets; ?>/images/space-process.webp" width="1536" height="1024" alt="가상 공간의 동선 도면과 돌, 나무, 금속, 직물 샘플을 함께 검토하는 작업 테이블" loading="lazy"><figcaption>공간 설계 과정 시연 · AI 생성 이미지</figcaption></figure><ol class="jwo-space-process__ledger"><li><b>01</b><div><h3>관찰</h3><p>사용자와 현장 조건</p></div><i data-jwo-icon="scan-search" aria-hidden="true"></i></li><li><b>02</b><div><h3>동선</h3><p>평면과 장면의 관계</p></div><i data-jwo-icon="route" aria-hidden="true"></i></li><li><b>03</b><div><h3>재료</h3><p>빛과 표면의 조합</p></div><i data-jwo-icon="layers" aria-hidden="true"></i></li><li><b>04</b><div><h3>인계</h3><p>선택의 근거와 기준</p></div><i data-jwo-icon="folder-check" aria-hidden="true"></i></li></ol></div></section>

<section class="jwo-section jwo-wrap jwo-faq" id="project-faq"><div><h2>프로젝트를<br>준비하고 계신가요?</h2><p>지금 가진 조건부터 함께 확인합니다.</p></div><div><details><summary>아직 장소가 정해지지 않아도 되나요?</summary><p>예상 용도와 규모, 운영 목적을 바탕으로 필요한 공간 조건부터 정리할 수 있습니다.</p></details><details><summary>기존 공간의 일부만 개선할 수 있나요?</summary><p>바꾸려는 구역과 기존 설비, 운영 중인 동선을 먼저 살펴보고 설계 범위를 협의합니다.</p></details><details><summary>처음 문의할 때 어떤 자료가 필요한가요?</summary><p>현장 사진과 도면, 공간의 용도, 희망 일정이 있으면 좋습니다. 없는 자료는 상담 과정에서 확인합니다.</p></details><details><summary>설계와 시공이 모두 포함되나요?</summary><p>소개된 시연은 공간 디자인의 업무 흐름입니다. 실제 진행 시 설계·시공·인허가의 담당과 계약 범위를 각각 확인합니다.</p></details></div></section>
    <section class="jwo-section jwo-wrap jwo-contact" id="project-contact"><h2>공간의 다음 장면을<br>함께 그려봅니다.</h2><p>현장 사진과 도면, 공간의 용도, 희망 일정.<br>지금 준비된 자료에서 출발합니다.</p><a class="jwo-button" href="<?php echo htmlspecialchars(G5_BBS_URL.'/qalist.php', ENT_QUOTES, 'UTF-8'); ?>">공간·브랜드 프로젝트 문의</a><p class="jwo-caption">가상 스튜디오와 공간 콘셉트로 구성한 테마 시연입니다.</p></section>
</article>
<script type="module" src="<?php echo $jwo_js_url; ?>"></script>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
