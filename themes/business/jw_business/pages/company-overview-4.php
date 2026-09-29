<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/company-overview-4.php
 * Role: 기업개요 #4 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '기업개요 #4';
$jw_description = '전략·디지털·공간의 세 가지 관점으로 사업과 프로젝트 접근 방식을 소개합니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/company-overview-4.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/company-overview-4.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_settings = jw_business_settings();
$jw_company_name = jw_business_escape($jw_settings['brand']['name']);
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_photo = static function ($type, $label, $classes = '') {
    ?><div class="jwc-photo jwc-photo--<?php echo jw_business_escape($type); ?> <?php echo jw_business_escape($classes); ?>" role="img" aria-label="<?php echo jw_business_escape($label); ?>"></div><?php
};
?>
<article class="jwc jwc--4" data-jw-company-page="4">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span>회사소개</span><span aria-hidden="true">/</span><span aria-current="page">기업개요</span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/company-overview/4.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwc-mosaic-title jwc-wrap"><h1>기업을 이해하는<br><span>세 가지 관점.</span></h1><p>전략으로 방향을 찾고,<br>기술과 공간으로 변화를 만듭니다.</p></header>
<div class="jwc-mosaic jwc-wrap"><figure><?php $jw_photo('co4-retail','고객이 상품을 살펴보는 자연광 가득한 쇼룸'); ?><figcaption>사람을 위한 환경</figcaption></figure><figure><?php $jw_photo('co4-material','다양한 포장 재료와 색상 표본을 비교하는 장면'); ?><figcaption>함께 만드는 과정</figcaption></figure><div class="jwc-mosaic__note"><p>한 가지 답보다,<br>목적에 맞는 조합.</p><a href="#company-fields" aria-label="사업 영역으로 이동"><i data-lucide="arrow-down"></i></a></div></div>
<section class="jwc-section jwc-wrap jwc-field-list" id="company-fields"><h2>전문성은 다르게.<br>목표는 같게.</h2><div class="jwc-field"><h3>Strategy</h3><div><strong>복잡함 속에서 방향을 찾습니다.</strong><p>조직의 과제와 사용자 요구를 정리해 실행할 수 있는 계획을 만듭니다.</p></div><a href="<?php echo $jw_link('business-detail-1'); ?>" aria-label="전략 사업 자세히 보기"><i data-lucide="arrow-up-right"></i></a></div><div class="jwc-field"><h3>Digital</h3><div><strong>기술을 경험으로 바꿉니다.</strong><p>서비스의 구조부터 작은 사용 흐름까지, 실제 쓰임을 중심으로 설계합니다.</p></div><a href="<?php echo $jw_link('business-detail-2'); ?>" aria-label="디지털 사업 자세히 보기"><i data-lucide="arrow-up-right"></i></a></div><div class="jwc-field"><h3>Space</h3><div><strong>공간의 새로운 역할을 만듭니다.</strong><p>일과 사람의 관계를 살피고, 브랜드의 태도가 드러나는 환경을 만듭니다.</p></div><a href="<?php echo $jw_link('business-detail-3'); ?>" aria-label="공간 사업 자세히 보기"><i data-lucide="arrow-up-right"></i></a></div></section>
<!-- The case connects an observed problem to review decisions and tangible outputs. -->
<section class="jwc-soft" id="company-case"><div class="jwc-section jwc-wrap">
    <header class="jwc-case-heading"><div><p class="jwc-kicker">협업 사례 · 가상 프로젝트</p><h2>같은 사무실,<br>서로 다른 업무 방식.</h2></div><p>회의와 집중 업무가 서로 방해하는 상황을 가정했습니다. 넓이를 늘리기 전에 공간을 사용하는 방식을 다시 살펴봅니다.</p></header>
    <dl class="jwc-case-meta"><div><dt>검토 대상</dt><dd>팀 협업 공간</dd></div><div><dt>핵심 과제</dt><dd>회의·집중 동선 구분</dd></div><div><dt>참여 관점</dt><dd>업무 · 공간 · 운영</dd></div></dl>
    <div class="jwc-case">
        <div><h3>문제를 하나의 질문으로.</h3><p class="jwc-lead">“이야기가 필요한 사람과<br>집중이 필요한 사람이<br>함께 일하려면?”</p><p>단순히 조용한 공간을 만드는 것이 목표는 아닙니다. 대화가 필요한 순간에도 서로의 업무를 방해하지 않는 방법을 찾습니다.</p><ul class="jwc-case-observations"><li>짧은 대화가 집중 좌석 주변에서 이어지는 상황</li><li>회의실을 찾기 위해 업무 영역을 가로지르는 동선</li><li>공간 사용 기준이 사람마다 다른 상태</li></ul></div>
        <div class="jwc-case__details"><details open><summary>01 · 업무 장면을 나누어 보기<i data-lucide="chevron-down" aria-hidden="true"></i></summary><p>회의 시간과 개별 업무, 방문 응대가 일어나는 위치를 표시합니다. 소음 자체뿐 아니라 이동이 겹치는 지점을 함께 확인합니다.</p><div class="jwc-case-output"><strong>남기는 자료</strong><span>업무 장면 목록 · 동선 관찰 기록</span></div></details><details><summary>02 · 배치안을 함께 검토하기<i data-lucide="chevron-down" aria-hidden="true"></i></summary><p>짧은 대화와 정식 회의가 필요한 영역을 구분하고, 집중 영역을 통과하지 않는 접근을 검토합니다. 담당자와 실제 이동 순서로 확인합니다.</p><div class="jwc-case-output"><strong>남기는 자료</strong><span>영역 구성안 · 배치 검토 의견</span></div></details><details><summary>03 · 사용할 때의 기준 정하기<i data-lucide="chevron-down" aria-hidden="true"></i></summary><p>예약이 필요한 공간과 자유롭게 사용할 자리를 구분합니다. 바뀐 배치만 전달하지 않고 안내 방식과 점검할 항목을 함께 정리합니다.</p><div class="jwc-case-output"><strong>남기는 자료</strong><span>사용 안내 · 운영 점검 항목</span></div></details></div>
    </div>
</div></section>
<section class="jwc-section jwc-wrap jwc-case-evidence">
    <figure class="jwc-case-photo"><?php $jw_photo('co4-workplace','협업 테이블과 조용한 개별 업무 자리가 나뉜 사무실'); ?><figcaption>서로 다른 업무가 함께 이어지는 공간의 시연 장면입니다.</figcaption></figure>
    <div><p class="jwc-kicker">변화의 장면 · 가상 사례</p><h2>회의와 집중이<br>함께 가능하도록.</h2><p>모든 자리를 똑같이 바꾸기보다 대화가 필요한 곳과 몰입할 곳의 관계를 살핍니다. 사진은 이 방향을 보여 주는 장면 예시입니다.</p><a class="jwc-link" href="<?php echo $jw_link('business-detail-3'); ?>">공간 업무 살펴보기<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div>
</section>
<section class="jwc-section jwc-wrap jwc-partnership"><h2>각자의 전문성을,<br>공동의 결과로.</h2><p>기획 · 디자인 · 개발 · 운영<br>필요한 역할이 연결된 하나의 프로젝트 팀으로 움직입니다.</p><a class="jw-control jw-control--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">협업 문의<i data-lucide="arrow-up-right"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap" aria-label="테마 시연 안내"><p><?php echo $jw_company_name; ?>의 기업 소개 예시입니다. 사진과 사례는 실제 기업의 실적을 나타내지 않습니다.</p><nav aria-label="기업개요 디자인 비교"><span>다른 디자인</span><?php for ($i=1; $i<=5; $i++) { ?><a href="<?php echo $jw_link('company-overview-'.$i); ?>"<?php echo $i === 4 ? ' aria-current="page"' : ''; ?>>#<?php echo $i; ?></a><?php } ?></nav></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
