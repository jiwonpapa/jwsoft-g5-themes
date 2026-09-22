<?php
/**
 * Theme: JW-Business 1.0
 * File: index_3.php
 * Role: 메인 홈 3번 완성 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit;

if (G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once G5_THEME_SHOP_PATH.'/index.php';
    return;
}

$g5['title'] = $config['cf_title'];
include_once G5_THEME_PATH.'/head.php';

$jw_settings = jw_business_settings();
$jw_home = $jw_settings['home'];
$jw_services = isset($jw_home['services']) ? (array) $jw_home['services'] : array();
$jw_news_board = isset($jw_home['news_board']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $jw_home['news_board']) : 'notice';
?>
<!-- JW BLOCK COPY: 루트 출시 구현 범위의 home 3번 구성; 이 파일에 복사된 독립 본문입니다. -->
<div class="jw-home jw-home--3">
    <section class="jw-hero" aria-labelledby="jw-home-3-title">
        <div class="jw-hero__media" role="img" aria-label="현대적인 기업 업무 공간"></div>
        <div class="jw-hero__overlay"></div>
        <div class="jw-shell jw-hero__content">
            <p class="jw-hero__meta">Home 3 · 프로젝트 중심</p>
            <h2 id="jw-home-3-title"><?php echo nl2br(jw_business_escape($jw_home['title'])); ?></h2>
            <p class="jw-hero__summary">대표 프로젝트와 결과를 중심으로 읽는 구성</p>
            <div class="jw-hero__actions"><a class="tw:d-btn tw:d-btn-primary jw-button jw-button--primary" href="<?php echo jw_business_escape(jw_business_page_url('business-list-1')); ?>">사업 분야 보기<i data-lucide="arrow-right"></i></a></div>
        </div>
    </section>
    <!-- JW BLOCK COPY START: blocks/home/service-map-01.php; 이 홈에 복사된 독립본입니다. -->
    <section class="jw-home-section jw-service-map" aria-labelledby="jw-home-3-services">
        <div class="jw-shell">
            <header class="jw-home-heading jw-home-heading--split"><h2 id="jw-home-3-services">필요한 전문성을<br>한 흐름으로 연결합니다.</h2><p><?php echo jw_business_escape($jw_home['summary']); ?></p></header>
            <ul class="jw-service-map__list"><?php foreach ($jw_services as $service) { ?><li><a href="<?php echo jw_business_escape($service['url']); ?>"><strong><?php echo jw_business_escape($service['title']); ?></strong><span><?php echo jw_business_escape($service['summary']); ?></span><i data-lucide="arrow-up-right"></i></a></li><?php } ?></ul>
        </div>
    </section>
    <!-- JW BLOCK COPY END -->
    <section class="jw-home-section jw-process" aria-labelledby="jw-home-3-process"><div class="jw-shell"><header class="jw-home-heading jw-home-heading--split"><h2 id="jw-home-3-process">함께 일하는 방식</h2><p>이해, 설계, 실행의 세 단계로 프로젝트를 진행합니다.</p></header><ol class="jw-process__list"><li><span>01</span><strong>이해</strong><p>현재 상황과 목표를 확인합니다.</p></li><li><span>02</span><strong>설계</strong><p>필요한 경험과 결과를 구체화합니다.</p></li><li><span>03</span><strong>실행</strong><p>운영에 필요한 기준을 남깁니다.</p></li></ol></div></section>
    <section class="jw-home-section jw-home-close" aria-label="문의"><div class="jw-shell jw-home-close__grid"><aside class="jw-contact"><div><p>새로운 프로젝트를 준비하고 계신가요?</p><h2>함께 이야기해<br>볼까요?</h2></div><a class="tw:d-btn tw:d-btn-primary jw-button jw-button--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">문의하기<i data-lucide="arrow-right"></i></a></aside></div></section>
</div>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
