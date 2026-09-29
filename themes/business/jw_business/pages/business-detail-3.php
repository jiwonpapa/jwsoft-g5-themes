<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-detail-3.php
 * Role: 공간 경험 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '공간 경험';
$jw_description = '방문 동선, 공간 사용, 안내 체계의 검토 범위와 협업 자료를 확인하세요.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-detail-3.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-detail-3.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-detail-3">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><a href="<?php echo $jw_link('business-list-1'); ?>">사업분야</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-detail-3.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwc-cinema-title jwc-wrap"><h1>공간의 쓰임을<br>명확하게 설계합니다.</h1><p>방문 동선 · 공간 사용 · 안내 체계<br>검토할 범위부터 함께 정합니다.</p></header>
<div class="jwb-space-banner jwc-photo jwc-photo--business-detail-3-space" role="img" aria-label="테이블과 창가가 연결된 업무 공간 예시"></div>
<section class="jwc-section jwc-wrap jwb-spec-layout" aria-labelledby="space-scope-title">
    <div><h2 id="space-scope-title">업무 범위</h2><p>공간의 모양을 결정하기 전에<br>사용하는 장면과 조건을 확인합니다.</p><a class="jwc-link" href="#space-preparation">상담 준비 자료<i data-lucide="arrow-down" aria-hidden="true"></i></a></div>
    <dl class="jwb-specifications">
        <div><dt>방문 동선</dt><dd><h3>도착부터 목적지까지</h3><p>진입 위치, 처음 보는 안내, 이동 중의 선택 지점을 살펴봅니다.</p><span>검토 자료 · 동선 기록, 안내 위치 목록</span></dd></div>
        <div><dt>공간 사용</dt><dd><h3>함께 쓰는 곳과 집중하는 곳</h3><p>업무 장면과 사용자 관계를 기준으로 영역의 역할을 정리합니다.</p><span>검토 자료 · 영역 구성, 사용 시나리오</span></dd></div>
        <div><dt>안내 체계</dt><dd><h3>물어보기 전에 알 수 있도록</h3><p>공간 이름과 안내 문구가 서로 일치하는지, 필요한 위치에 정보가 있는지 확인합니다.</p><span>검토 자료 · 안내 항목, 표기 기준</span></dd></div>
    </dl>
</section>
<section class="jwc-soft" id="space-preparation"><div class="jwc-section jwc-wrap jwb-preparation"><div><h2>처음에는 이 자료면<br>충분합니다.</h2><p>모든 자료가 준비되지 않아도 현재 상황부터 이야기할 수 있습니다.</p></div><ul><li><strong>현재 공간</strong><span>사진이나 간단한 도면, 사용 목적</span></li><li><strong>불편한 장면</strong><span>길을 묻는 위치, 붐비는 시간, 자주 바뀌는 안내</span></li><li><strong>진행 조건</strong><span>원하는 일정, 협의 가능한 범위, 담당자</span></li></ul></div></section>
<section class="jwc-section jwc-wrap jwc-statement"><div><h2>제안과 실행의 범위를<br>구분합니다.</h2></div><div><p>이 페이지의 업무 예시는 동선·사용·안내에 대한 검토와 자료 정리입니다. 실제 제공 항목은 현황 확인 후 협의합니다.</p><p>건축 설계, 인허가, 시공, 구조·안전 검토는 별도 전문 업무입니다. 해당 업무가 필요한 경우 담당 주체와 범위를 먼저 확인합니다.</p></div></section>
<section class="jwc-wrap jwb-space-close"><h2>어떤 공간을 바꾸고 싶으신가요?</h2><a class="jw-control jw-control--primary" href="<?php echo $jw_link('contact-1'); ?>#contact-space">공간 문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
