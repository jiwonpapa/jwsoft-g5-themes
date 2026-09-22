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
<header class="jwc-cinema-title jwc-wrap"><h1>필요한 일부터,<br>명확하게.</h1><p>해결하려는 과제를 기준으로<br>각 분야의 업무를 살펴보세요.</p></header>
<section class="jwc-wrap jwb-numbered" aria-label="사업 분야 목록">
    <article><span class="jwb-business-number" aria-hidden="true">01</span><div><h2>비즈니스 컨설팅</h2><p>어디에 집중해야 할지 정하는 일</p></div><div><p>여러 요구를 한 번에 추진하기보다 목표와 조건을 정리합니다. 이번에 해결할 과제와 이후에 검토할 일을 구분합니다.</p><ul><li>현황과 이해관계자 요구 확인</li><li>주요 과제·우선순위 정리</li><li>실행 범위와 역할 협의</li></ul><a class="jwc-link" href="<?php echo $jw_link('business-detail-1'); ?>">컨설팅 업무 범위<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></article>
    <article><span class="jwb-business-number" aria-hidden="true">02</span><div><h2>디지털 서비스</h2><p>정보와 다음 행동을 연결하는 일</p></div><div><p>방문자의 질문에 맞춰 콘텐츠를 정리하고, 정보를 이해한 뒤 문의까지 이어지는 경로를 설계합니다.</p><ul><li>메뉴와 콘텐츠 구조</li><li>주요 화면과 이용 흐름</li><li>운영 안내와 확인 기준</li></ul><a class="jwc-link" href="<?php echo $jw_link('business-detail-4'); ?>">디지털 개선 사례<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></article>
    <article><span class="jwb-business-number" aria-hidden="true">03</span><div><h2>공간 경험</h2><p>사람과 장소의 관계를 살피는 일</p></div><div><p>사람들이 도착하고 이동하고 머무는 장면을 관찰합니다. 공간별 쓰임과 안내 정보가 자연스럽게 연결되는지 확인합니다.</p><ul><li>방문·업무 동선 검토</li><li>공간별 사용 목적 정리</li><li>안내 항목과 표기 기준</li></ul><a class="jwc-link" href="<?php echo $jw_link('business-detail-3'); ?>">공간 업무 범위<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></article>
</section>
<section class="jwc-section jwc-wrap jwb-index-close"><div class="jwc-photo jwc-photo--team" role="img" aria-label="도면과 자료를 함께 검토하는 협업 장면"></div><div><h2>하나의 과제에<br>여러 분야가 필요할 때.</h2><p>먼저 바꾸고 싶은 상황을 공유해 주세요. 필요한 분야와 협업 범위를 함께 정리합니다.</p><a class="jwc-link" href="<?php echo $jw_link('contact-1'); ?>">문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></div></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
