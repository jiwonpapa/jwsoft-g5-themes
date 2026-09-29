<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-list-4.php
 * Role: 사업분야 · 업무 안내 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '사업분야 · 업무 안내';
$jw_description = '전략, 디지털, 공간 분야의 주요 과제와 검토 내용을 목록으로 확인하세요.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-list-4.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-list-4.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-list-4">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-list-4.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwb-index-hero jwc-wrap"><div><p class="jwc-kicker">분야별 업무 안내</p><h1>필요한 일부터,<br>명확하게.</h1><p>해결하려는 과제를 기준으로 각 분야의 업무를 살펴보세요.</p><a class="jwc-link" href="#business-index">업무 범위 살펴보기<i data-lucide="arrow-down" aria-hidden="true"></i></a></div><div class="jwc-photo jwc-photo--business-list-4-team" role="img" aria-label="공간 모형과 자료를 함께 검토하는 팀"></div></header>
<section class="jwc-wrap jwb-numbered" id="business-index" aria-label="사업 분야 목록">
    <article><span class="jwb-business-number" aria-hidden="true">01</span><div><h2>비즈니스 컨설팅</h2><p>무엇을 먼저 바꿀지 결정합니다.</p></div><div class="jwb-index-result"><i data-lucide="target" aria-hidden="true"></i><p>여러 요구 가운데 지금 해결할 한 가지 과제를 고릅니다.</p><strong>남는 것 / 우선순위와 실행 범위</strong><a class="jwc-link" href="<?php echo $jw_link('business-detail-1'); ?>">컨설팅 업무 범위<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></article>
    <article><span class="jwb-business-number" aria-hidden="true">02</span><div><h2>디지털 서비스</h2><p>찾는 정보에서 다음 행동까지 연결합니다.</p></div><div class="jwb-index-result"><div class="jwb-index-screen" aria-label="서비스 선택 화면 예시"><span>나에게 필요한 서비스</span><strong>어떤 도움이 필요하신가요?</strong><small>사업 정리　↗</small><small>화면 개선　↗</small></div><strong>남는 것 / 정보 순서와 주요 화면</strong><a class="jwc-link" href="<?php echo $jw_link('business-detail-4'); ?>">디지털 개선 사례<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></article>
    <article><span class="jwb-business-number" aria-hidden="true">03</span><div><h2>공간 경험</h2><p>사람이 움직이는 길을 살핍니다.</p></div><div class="jwb-index-result"><i data-lucide="building-2" aria-hidden="true"></i><p>도착하고, 이동하고, 머무는 장면에서 필요한 안내를 찾습니다.</p><strong>남는 것 / 공간별 쓰임과 안내 기준</strong><a class="jwc-link" href="<?php echo $jw_link('business-detail-3'); ?>">공간 업무 범위<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></article>
</section>
<section class="jwc-section jwc-wrap jwb-index-close"><i data-lucide="handshake" aria-hidden="true"></i><div><h2>하나의 과제에<br>여러 분야가 필요할 때.</h2><p>먼저 바꾸고 싶은 상황을 공유해 주세요. 필요한 분야와 협업 범위를 함께 정리합니다.</p><a class="jwc-link" href="<?php echo $jw_link('contact-1'); ?>">문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></div></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
