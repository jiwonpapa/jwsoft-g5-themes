<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-list-5.php
 * Role: 사업분야 · 목적별 업무 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '사업분야 · 목적별 업무';
$jw_description = '방향을 정하는 업무와 경험을 만드는 업무를 구분해 필요한 서비스를 찾아보세요.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-list-5.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-list-5.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-list-5">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-list-5.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwb-choice-hero jwc-wrap"><div class="jwb-choice-hero__copy"><p class="jwc-kicker">두 갈래의 협업</p><h1>지금 필요한 변화는<br>어디에 있나요?</h1><p>방향을 정하는 일과 경험을 만드는 일로 나누어 살펴봅니다.</p></div><div class="jwc-photo jwc-photo--business-list-5-direction" role="img" aria-label="테이블에 둘러앉아 방향을 함께 논의하는 팀"></div></header>
<nav class="jwc-wrap jwb-group-nav" aria-label="업무 묶음 바로가기"><a href="#business-direction">방향과 계획<i data-lucide="arrow-down" aria-hidden="true"></i></a><a href="#business-experience">정보와 공간<i data-lucide="arrow-down" aria-hidden="true"></i></a></nav>
<section class="jwc-section jwc-wrap jwb-direction" id="business-direction"><div class="jwb-direction__symbol"><i data-lucide="target" aria-hidden="true"></i><span>FOCUS / 01</span></div><div><h2>방향과 계획</h2><p>요구사항이 많을수록 먼저 풀 문제와 이번에 하지 않을 일을 함께 정합니다.</p><div class="jwb-direction__links"><a class="jwc-link" href="<?php echo $jw_link('business-detail-1'); ?>">컨설팅 소개<i data-lucide="arrow-up-right" aria-hidden="true"></i></a><a class="jwc-link" href="<?php echo $jw_link('business-detail-5'); ?>">협업 과정 보기<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></div></section>
<section class="jwc-soft" id="business-experience"><div class="jwc-section jwc-wrap jwb-experience"><div class="jwc-photo jwc-photo--business-list-5-experience" role="img" aria-label="창가와 테이블이 있는 업무 공간"></div><div><p class="jwc-kicker">EXPERIENCE / 02</p><h2>정보와 공간</h2><p>화면에서 찾는 정보와 현장에서 만나는 장면을 하나의 경험으로 잇습니다.</p><div class="jwb-experience__links"><a href="<?php echo $jw_link('business-detail-2'); ?>"><i data-lucide="monitor" aria-hidden="true"></i><span><strong>디지털 서비스</strong><small>정보 구조와 주요 화면</small></span><i data-lucide="arrow-up-right" aria-hidden="true"></i></a><a href="<?php echo $jw_link('business-detail-3'); ?>"><i data-lucide="building-2" aria-hidden="true"></i><span><strong>공간 경험</strong><small>방문 동선과 안내 기준</small></span><i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></div></div></section>
<section class="jwc-section jwc-wrap jwc-question"><h2>분야를 정하지 않아도 괜찮습니다.</h2><p>현재 상황과 바꾸고 싶은 점을 알려 주세요.<br>필요한 업무와 협업 범위를 함께 확인합니다.</p><a class="jw-control jw-control--primary" href="<?php echo $jw_link('contact-1'); ?>">문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
