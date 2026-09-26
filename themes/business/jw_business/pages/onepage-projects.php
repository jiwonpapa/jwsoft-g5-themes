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
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/onepages.min.css">', 30);
include_once G5_THEME_PATH.'/head.php';
?>
<article class="jwo jwo--projects" data-jw-onepage="projects">
    <nav class="jwo-nav" aria-label="프로젝트 소개 목차"><a class="jwo-nav__brand" href="#project-top">일과 쉼 사이</a><div class="jwo-nav__links"><a href="#project-intent">공간의 의도</a><a href="#project-scenes">장면들</a><a href="#project-gallery">갤러리</a></div><a class="jwo-nav__action" href="#project-contact">프로젝트 문의</a></nav>
    <section class="jwo-project-hero" id="project-top"><div class="jwo-wrap jwo-project-title"><h1>머무는 시간이<br>좋아지는 공간.</h1><p>일과 쉼 사이.<br>사람의 하루에서 시작한 공간 이야기.</p></div><figure><img src="<?php echo $jwo_assets; ?>/images/courtyard.webp" width="1536" height="1024" alt="정원과 수공간을 사이에 둔 콘크리트와 유리의 업무 공간 콘셉트" fetchpriority="high"><figcaption class="jwo-wrap">공간·브랜드 소개 시연 · AI 콘셉트 이미지이며 실제 완공 프로젝트가 아닙니다.</figcaption></figure></section>
    <section class="jwo-section jwo-wrap jwo-intro" id="project-intent"><h2>건물보다 먼저,<br>그 안의 하루를 봅니다.</h2><div><p class="jwo-lead">집중하는 시간과 잠깐의 여유.<br>서로 다른 리듬이 함께 머물 수 있도록.</p><p>좋은 공간에 대한 질문은 단순한 형태에서 끝나지 않습니다. 어디에서 만나고, 얼마나 머물며, 어떤 장면에서 편안함을 느끼는지. 사람의 경험을 따라 공간의 방향을 정리합니다.</p><dl class="jwo-facts"><div><dt>프로젝트 유형</dt><dd>업무·문화 공간 콘셉트</dd></div><div><dt>살펴볼 주제</dt><dd>동선 · 자연광 · 함께 쓰는 공간</dd></div><div><dt>자료 구분</dt><dd>테마 시연용 가상 기획</dd></div></dl></div></section>
    <section class="jwo-project-story" id="project-scenes"><figure class="jwo-project-story__photo" data-jwo-depth><img src="<?php echo $jwo_assets; ?>/images/courtyard-interior.webp" width="1536" height="1024" alt="유리 너머 정원을 바라보는 콘크리트 실내와 긴 테이블" loading="lazy"></figure><div class="jwo-wrap jwo-project-story__copy"><h2>바깥의 여유가<br>안으로 이어질 때.</h2><p>정원이 보이는 실내에서 멈추고 쉬어 갈 수 있습니다.<br>공간의 첫인상은 작은 여백에서 시작됩니다.</p></div></section>
    <section class="jwo-section jwo-wrap jwo-project-editorial"><div><h2>재료와 빛이<br>만드는 리듬.</h2><p>콘크리트의 거친 표면, 유리에 비친 정원, 물 위로 움직이는 빛을 하나의 공간 언어로 묶었습니다.</p><p>가구 하나의 배치보다 중요한 것은 그 주변에서 일어날 하루의 모습입니다.</p></div><figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-detail.webp" width="1536" height="1024" alt="콘크리트와 유리, 수공간이 만나는 건축 디테일" loading="lazy"><figcaption>공간 재료와 채광을 보여주는 동일 콘셉트의 생성 이미지입니다.</figcaption></figure></section>
    <section class="jwo-section jwo-gallery-section" id="project-gallery"><div class="jwo-wrap jwo-section-head"><h2>다른 장면,<br>하나의 방향.</h2><p>정원에서 업무 공간, 대화의 자리까지.<br>각 장면이 전하는 경험을 살펴보세요.</p></div><div class="jwo-gallery" data-jwo-gallery>
        <div class="jwo-gallery__track" tabindex="0" aria-label="프로젝트 이미지 갤러리. 좌우 방향키 또는 스와이프로 이동합니다.">
            <figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-colonnade.webp" width="1536" height="1024" alt="정원을 향해 열린 그늘진 회랑" loading="lazy"><figcaption><strong>이어지는 회랑</strong><span>밖과 안을 천천히 연결하는 길</span></figcaption></figure>
            <figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-lounge.webp" width="1536" height="1024" alt="정원이 보이는 따뜻한 실내 라운지" loading="lazy"><figcaption><strong>머무는 라운지</strong><span>조용한 대화와 휴식을 위한 자리</span></figcaption></figure>
            <figure><img src="<?php echo $jwo_assets; ?>/images/courtyard-terrace.webp" width="1536" height="1024" alt="저녁빛이 비치는 정원 테라스와 수공간" loading="lazy"><figcaption><strong>저녁의 테라스</strong><span>하루의 끝에도 열려 있는 여백</span></figcaption></figure>
        </div>
        <div class="jwo-wrap jwo-gallery__controls" hidden data-jwo-gallery-controls><p data-jwo-gallery-status role="status" aria-live="polite">1 / 3 · 머무는 정원</p><div><button class="jwo-button jwo-button--subtle" type="button" data-jwo-prev aria-label="이전 이미지">이전</button><button class="jwo-button jwo-button--subtle" type="button" data-jwo-next aria-label="다음 이미지">다음</button></div></div>
    </div></section>
    <section class="jwo-section jwo-wrap jwo-contact" id="project-contact"><h2>어떤 시간을<br>담고 싶으신가요?</h2><p>만들고 싶은 공간과 그 안에서 일어날 이야기를 들려주세요.</p><a class="jwo-button" href="<?php echo htmlspecialchars(G5_BBS_URL.'/qalist.php', ENT_QUOTES, 'UTF-8'); ?>">공간·브랜드 프로젝트 문의</a><p class="jwo-caption">프로젝트명, 이미지, 설명을 실제 작업 자료로 교체해 사용하는 원페이지입니다.</p></section>
</article>
<script type="module" src="<?php echo G5_THEME_URL; ?>/js/onepages.min.js"></script>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
