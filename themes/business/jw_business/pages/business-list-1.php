<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-list-1.php
 * Role: 사업분야 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '사업분야';
$jw_description = '비즈니스 컨설팅, 디지털 서비스, 공간 경험의 업무 범위와 협업 방식을 소개합니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-list-1.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-list-1.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-list-1">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-list-1.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwc-cinema-title jwc-wrap"><h1>과제에 맞는 전문성을<br>연결합니다.</h1><p>방향을 정하는 일부터<br>실제 사용하는 경험을 만드는 일까지.</p></header>
<section class="jwc-wrap jwb-services" aria-label="사업 분야">
<article><div class="jwc-photo jwc-photo--business-list-1-strategy" role="img" aria-label="메모를 펼쳐 놓고 우선순위를 함께 정리하는 두 동료"></div><p class="jwc-kicker">전략과 방향</p><h2>비즈니스 컨설팅</h2><p>현재의 과제와 고객 경험을 정리하고 실행할 우선순위를 세웁니다.</p><ul><li>현황·요구사항 정리</li><li>서비스 구조와 실행 범위 검토</li><li>실행 계획·운영 기준</li></ul><a class="jwc-link" href="<?php echo $jw_link('business-detail-1'); ?>">업무 범위 자세히 보기<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></article>
<article><div class="jwc-photo jwc-photo--business-list-1-digital" role="img" aria-label="태블릿과 노트북에서 시각 자료를 제작하는 작업 장면"></div><p class="jwc-kicker">기술과 사용 경험</p><h2>디지털 서비스</h2><p>방문자가 정보를 찾고 원하는 행동으로 이어지는 흐름을 설계합니다.</p><ul><li>정보 구조·화면 설계</li><li>콘텐츠와 이용 동선 정리</li><li>운영·관리 방식 검토</li></ul><a class="jwc-link" href="<?php echo $jw_link('business-detail-2'); ?>">디지털 업무 자세히 보기<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></article>
<article><div class="jwc-photo jwc-photo--business-list-1-space" role="img" aria-label="관람객이 서로 다른 전시 공간을 이동하는 갤러리 내부"></div><p class="jwc-kicker">공간과 관계</p><h2>공간 경험</h2><p>사람이 이동하고 머무는 장면을 살펴 공간의 쓰임을 구체화합니다.</p><ul><li>방문·업무 동선 관찰</li><li>공간별 사용 목적 정리</li><li>안내·운영 방식 검토</li></ul><a class="jwc-link" href="<?php echo $jw_link('business-detail-3'); ?>">공간 업무 자세히 보기<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></article>
</section>
<section class="jwc-soft"><div class="jwc-section jwc-wrap jwc-statement"><h2>분야를 고르기 전에,<br>목표부터 함께 봅니다.</h2><div><p>하나의 과제에 여러 분야가 필요할 수 있습니다. 회사 소개를 정리하는 일과 문의 흐름을 바꾸는 일, 현장 안내를 개선하는 일을 같은 목적에서 살펴봅니다.</p><a class="jwc-link" href="<?php echo $jw_link('company-overview-4'); ?>#company-case">협업 접근 예시 보기<i data-lucide="arrow-right" aria-hidden="true"></i></a></div></div></section>
<section class="jwc-section jwc-wrap"><h2>처음 상담은 이렇게 시작합니다.</h2><ol class="jwc-flow"><li><strong>상황 공유</strong><p>현재의 업무와 불편한 점을 알려 주세요.</p></li><li><strong>범위 확인</strong><p>이번에 필요한 변화와 제약을 정리합니다.</p></li><li><strong>방향 검토</strong><p>가능한 접근과 필요한 자료를 확인합니다.</p></li><li><strong>진행 협의</strong><p>일정과 역할, 제공 범위를 협의합니다.</p></li></ol></section>
<section class="jwc-contact jwc-wrap"><h2>어디서 시작할지<br>함께 정리해 보세요.</h2><a class="jw-control jw-control--primary" href="<?php echo $jw_link('contact-1'); ?>">문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
