<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/onepage-showcase.php
 * Role: 독립 원페이지 — 제품·기술 쇼케이스
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT. All rights reserved.
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) include_once dirname(__DIR__).'/common.php';
$g5['title'] = 'NODE · 제품 쇼케이스';
$g5['document_meta'] = array('description' => '제품의 형태부터 도입 상담까지, 한 흐름으로 살펴보는 제품 소개 시연입니다.', 'canonical' => G5_URL.'/pages/onepage-showcase.php');
$jw_full_width_page = true;
$jwo_assets = htmlspecialchars(G5_THEME_URL.'/onepages/assets', ENT_QUOTES, 'UTF-8');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/onepages.min.css">', 30);
include_once G5_THEME_PATH.'/head.php';
?>
<article class="jwo jwo--showcase" data-jw-onepage="showcase">
    <nav class="jwo-nav" aria-label="제품 소개 목차">
        <a class="jwo-nav__brand" href="#node-top">NODE</a>
        <div class="jwo-nav__links"><a href="#node-design">디자인</a><a href="#node-details">상세 구성</a><a href="#node-fit">도입 검토</a></div>
        <a class="jwo-nav__action" href="#node-contact">도입 상담</a>
    </nav>
    <section class="jwo-product-hero" id="node-top">
        <div class="jwo-wrap"><h1>작은 형태.<br>넓은 가능성.</h1><p>현장과 시스템을 잇는 하나의 접점, NODE.</p><a class="jwo-link" href="#node-design">제품을 자세히 살펴보기 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14m-6-6 6 6 6-6"/></svg></a></div>
        <img src="<?php echo $jwo_assets; ?>/images/node-poster.webp" width="1536" height="1024" alt="알루미늄 방열 구조와 전면 연결부를 갖춘 산업용 컴퓨터 콘셉트" fetchpriority="high">
        <p class="jwo-caption">제품 소개 시연 · NODE는 가상 제품이며 이미지와 사양 설명은 예시입니다.</p>
    </section>
    <section class="jwo-section jwo-wrap jwo-intro" id="node-design">
        <h2>설명보다 먼저,<br>직접 보는 구조.</h2><div><p class="jwo-lead">돌려 보고, 가까이 보고.<br>제품을 이해하는 자연스러운 순서입니다.</p><p>형태와 연결부를 한 장면씩 살펴보세요. 화면을 내리면 모델의 각도가 바뀌며 제품의 입체적인 구조가 드러납니다.</p></div>
    </section>
    <section class="jwo-sequence" data-jwo-sequence data-frame-root="<?php echo $jwo_assets; ?>/sequence/node-" data-frame-count="36" aria-labelledby="node-motion-title">
        <div class="jwo-sequence__stage">
            <div class="jwo-wrap jwo-sequence__heading"><h2 id="node-motion-title">각도를 바꾸면,<br>디테일이 보입니다.</h2><p data-jwo-sequence-status role="status">3D 모델의 대표 이미지입니다.</p></div>
            <div class="jwo-sequence__media"><img src="<?php echo $jwo_assets; ?>/sequence/node-001.webp" width="960" height="640" alt="Blender로 제작한 NODE 콘셉트의 입체 모델" loading="lazy" data-jwo-poster><canvas width="960" height="640" aria-hidden="true" hidden></canvas></div>
            <div class="jwo-wrap jwo-sequence__foot"><p>알루미늄 바디 · 방열 핀 · 전면 연결부</p><button class="jwo-button jwo-button--subtle" type="button" data-jwo-motion-toggle hidden aria-pressed="false">회전 멈추기</button></div>
        </div>
    </section>
    <section class="jwo-section jwo-wrap" id="node-details">
        <div class="jwo-section-head"><h2>가까이 볼수록<br>명확해지는 구성.</h2><p>보여 주고 싶은 특징을 선택해 설명과 이미지를 함께 전달합니다.</p></div>
        <div class="jwo-inspector" data-jwo-tabs>
            <div class="jwo-tab-controls" data-jwo-tablist aria-label="제품 구성 선택" hidden><button type="button" data-jwo-tab="node-body">바디 구조</button><button type="button" data-jwo-tab="node-connect">연결부</button><button type="button" data-jwo-tab="node-placement">설치 검토</button></div>
            <section class="jwo-detail" id="node-body" data-jwo-panel><div class="jwo-detail__image"><img src="<?php echo $jwo_assets; ?>/sequence/node-009.webp" width="960" height="640" alt="비스듬한 각도에서 본 제품 상단의 금속 방열 핀" loading="lazy"></div><div><h3>형태가 설명하는 설계.</h3><p>금속의 질감과 반복되는 방열 구조를 크게 보여 줍니다. 재질과 설계 의도를 고객이 직접 확인할 수 있도록 구성한 예시입니다.</p><dl class="jwo-facts"><div><dt>소개 포인트</dt><dd>외관 · 마감 · 구조</dd></div><div><dt>준비할 자료</dt><dd>제품 사진과 검증된 설계 설명</dd></div></dl></div></section>
            <section class="jwo-detail" id="node-connect" data-jwo-panel><div class="jwo-detail__image jwo-detail__image--close"><img src="<?php echo $jwo_assets; ?>/sequence/node-021.webp" width="960" height="640" alt="다른 각도에서 본 제품 전면의 연결부 예시" loading="lazy"></div><div><h3>연결할 대상을 먼저.</h3><p>어떤 장비와 연결하는지, 어디에 포트가 있는지 함께 설명합니다. 실제 판매 제품의 연결 규격과 지원 범위로 바꿔 사용하는 영역입니다.</p><dl class="jwo-facts"><div><dt>소개 포인트</dt><dd>포트 위치 · 연결 환경</dd></div><div><dt>확인할 자료</dt><dd>실제 모델의 규격과 호환 목록</dd></div></dl></div></section>
            <section class="jwo-detail" id="node-placement" data-jwo-panel><div class="jwo-detail__image"><img src="<?php echo $jwo_assets; ?>/sequence/node-036.webp" width="960" height="640" alt="다른 각도에서 살펴본 제품 모델" loading="lazy"></div><div><h3>현장의 조건까지 생각합니다.</h3><p>설치 공간, 전원, 통신 환경을 먼저 확인합니다. 운영 조건을 충분히 이해한 뒤 적합한 구성을 검토하도록 상담으로 연결합니다.</p><dl class="jwo-facts"><div><dt>검토 항목</dt><dd>공간 · 전원 · 네트워크</dd></div><div><dt>상담 준비</dt><dd>현장 사진과 연결할 장비 목록</dd></div></dl></div></section>
        </div>
    </section>
    <section class="jwo-section jwo-surface" id="node-fit"><div class="jwo-wrap jwo-intro"><h2>도입은,<br>현장을 아는 것부터.</h2><div><p class="jwo-lead">정해진 답보다 적합한 구성을 찾습니다.</p><ol class="jwo-process"><li><h3>운영 환경 확인</h3><p>설치 위치와 연결 장비, 사용 조건을 공유합니다.</p></li><li><h3>필요 구성 검토</h3><p>요구사항을 기준으로 지원 범위와 제약을 확인합니다.</p></li><li><h3>적용 계획 협의</h3><p>시험 항목과 적용 일정, 운영 방법을 정리합니다.</p></li></ol></div></div></section>
    <section class="jwo-section jwo-wrap jwo-contact" id="node-contact"><h2>어떤 현장에<br>연결하고 싶으신가요?</h2><p>필요한 기능과 운영 환경부터 이야기해 주세요.</p><a class="jwo-button" href="<?php echo htmlspecialchars(G5_BBS_URL.'/qalist.php', ENT_QUOTES, 'UTF-8'); ?>">제품 도입 문의</a><p class="jwo-caption">실제 제품 정보와 이미지로 교체해 사용하는 쇼케이스형 원페이지입니다.</p></section>
</article>
<script type="module" src="<?php echo G5_THEME_URL; ?>/js/onepages.min.js"></script>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
