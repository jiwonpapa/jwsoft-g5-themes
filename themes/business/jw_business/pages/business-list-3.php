<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-list-3.php
 * Role: 사업분야 · 공간에서 시작하는 변화 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '사업분야 · 공간에서 시작하는 변화';
$jw_description = '공간 경험을 중심으로 전략과 디지털 업무를 연결하는 사업 구성을 소개합니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-list-3.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-list-3.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-list-3">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-list-3.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwb-place-hero"><div class="jwc-photo jwc-photo--business-list-3-arrival" role="img" aria-label="계단과 보행 공간이 이어지는 복합 공간의 내부"></div><div class="jwc-wrap jwb-place-hero__copy"><p class="jwc-kicker">Space-led services</p><h1>사업의 변화는<br>사람의 자리에서.</h1><p>공간에서 발견한 질문을 전략과 디지털 경험으로 연결합니다.</p></div></header>
<section class="jwb-feature jwc-wrap" aria-labelledby="space-feature-title">
    <div class="jwb-feature-summary"><h2 id="space-feature-title">도착부터 만남까지</h2><div><p>방문자가 어느 순간에 멈추고 무엇을 찾는지 살핍니다. 공간의 쓰임은 그 순서에서 드러납니다.</p><a class="jwc-link" href="<?php echo $jw_link('business-detail-3'); ?>">공간 업무 범위 보기<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></div>
    <ol class="jwb-visit-journey"><li><i data-lucide="building-2" aria-hidden="true"></i><span>01 / 도착</span><strong>들어갈 곳이<br>한눈에 보이도록</strong></li><li><i data-lucide="compass" aria-hidden="true"></i><span>02 / 이동</span><strong>다음 장소를<br>헤매지 않도록</strong></li><li><i data-lucide="handshake" aria-hidden="true"></i><span>03 / 만남</span><strong>사람과 서비스가<br>이어지도록</strong></li></ol>
</section>
<section class="jwc-section jwc-wrap jwb-service-directory jwb-service-directory--visual" aria-labelledby="related-services-title">
    <h2 id="related-services-title">함께 연결하는 전문성</h2>
    <article><h3>비즈니스 컨설팅</h3><p>공간을 바꾸기 전, 해결할 과제와 실행 조건부터 정리합니다. 목표와 우선순위를 공유하는 일입니다.</p><a class="jwc-link" href="<?php echo $jw_link('business-detail-1'); ?>">컨설팅 상세<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></article>
    <article><h3>디지털 서비스</h3><p>방문 전의 정보 탐색과 현장의 경험이 이어지도록 메뉴, 콘텐츠, 문의 경로를 설계합니다.</p><a class="jwc-link" href="<?php echo $jw_link('business-detail-2'); ?>">디지털 상세<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></article>
</section>
<section class="jwc-soft"><div class="jwc-section jwc-wrap jwc-statement"><h2>하나의 장소,<br>연결되는 여러 접점.</h2><div><p>사이트에서 위치를 확인하고, 현장에서 입구를 찾고, 담당자를 만나는 과정은 하나의 방문 경험입니다. 필요한 분야를 따로 나열하기보다 이 흐름에서 함께 검토합니다.</p><a class="jwc-link" href="<?php echo $jw_link('contact-1'); ?>">상담 준비와 연락처<i data-lucide="arrow-right" aria-hidden="true"></i></a></div></div></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
