<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/company-overview-3.php
 * Role: 기업개요 #3 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '기업개요 #3';
$jw_description = '일하는 공간에서 시작되는 변화. 발견하고 연결하고 이어가는 기업의 이야기를 만나보세요.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/company-overview-3.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/company-overview-3.php'),
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
<article class="jwc jwc--3" data-jw-company-page="3">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span>회사소개</span><span aria-hidden="true">/</span><span aria-current="page">기업개요</span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/company-overview/3.php; 이 페이지 안에서만 수정합니다. -->
<!-- Three scenes, each with one photo and a distinct reading rhythm. -->
<section class="jwc-landscape" data-jwc-parallax>
    <?php $jw_photo('campus','현대적인 업무 시설 앞의 광장과 나무','jwc-parallax-image'); ?>
    <div class="jwc-landscape__copy jwc-wrap"><p class="jwc-scene-label">현장을 읽는 세 가지 장면</p><h1>사람이 움직이는 곳에서,<br>일의 방향을 찾습니다.</h1><p>건물의 바깥에서 업무 공간으로,<br>그리고 함께 검토하는 테이블까지.</p><a class="jwc-link" href="#company-arrival">현장 이야기 읽기<i data-lucide="arrow-down" aria-hidden="true"></i></a></div>
</section>
<nav class="jwc-scene-nav jwc-wrap" aria-label="현장 이야기 목차"><a href="#company-arrival"><span>01</span> 도착하는 경험</a><a href="#company-workplace"><span>02</span> 머무는 환경</a><a href="#company-review"><span>03</span> 함께 확인하는 일</a></nav>
<section class="jwc-section jwc-wrap jwc-observation" id="company-arrival">
    <div><p class="jwc-kicker">01 · 외관과 접근</p><h2>처음 방문한 사람의<br>시선으로 걷습니다.</h2></div>
    <div><p class="jwc-lead">공간의 경험은 문을 열기 전부터 시작됩니다.</p><p>입구를 찾는 과정, 안내를 읽는 위치, 사람과 차량이 만나는 지점. 방문자가 자연스럽게 다음 행동을 선택할 수 있는지 살펴봅니다.</p><dl class="jwc-observation-notes"><div><dt>살펴보는 장면</dt><dd>진입로에서 입구까지 이어지는 동선</dd></div><div><dt>함께 묻는 질문</dt><dd>처음 온 사람도 도움 없이 목적지를 찾을 수 있을까요?</dd></div></dl></div>
</section>
<section class="jwc-workplace-scene" id="company-workplace">
    <div class="jwc-immersive" data-jwc-parallax><?php $jw_photo('workspace','햇빛과 식물, 긴 테이블이 있는 열린 업무 공간','jwc-parallax-image'); ?><div class="jwc-wrap"><p class="jwc-scene-label">02 · 업무 공간</p><h2>함께 이야기하는 자리와<br>집중하는 시간을 생각합니다.</h2></div></div>
    <div class="jwc-wrap jwc-space-notes"><p>업무 공간 구성 예시</p><div><h3>회의가 끝난 뒤에도<br>일은 이어져야 하니까.</h3><p>어떤 대화가 필요한지, 자료를 어디서 확인하는지, 혼자 집중할 자리가 있는지. 가구의 배치보다 실제 하루의 흐름을 먼저 살핍니다.</p></div><ul><li><strong>대화</strong><span>자료를 함께 펼쳐 보고 의견을 나눌 수 있는 자리</span></li><li><strong>집중</strong><span>이동과 소음의 영향을 덜 받는 업무 환경</span></li><li><strong>전환</strong><span>회의와 개별 업무 사이를 자연스럽게 잇는 동선</span></li></ul></div>
</section>
<section class="jwc-section jwc-wrap jwc-review-scene" id="company-review">
    <figure><?php $jw_photo('team','도면을 펼치고 내용을 함께 확인하는 두 동료'); ?><figcaption>현장 조건과 계획을 같은 자료 위에서 검토하는 장면 예시입니다.</figcaption></figure>
    <div><p class="jwc-kicker">03 · 공동 검토</p><h2>생각이 같아졌는지,<br>자료를 펼쳐 확인합니다.</h2><p>같은 설명을 들어도 서로 다른 장면을 떠올릴 수 있습니다. 도면과 화면, 실제 사용 상황을 함께 보며 이해의 차이를 줄입니다.</p><blockquote>“이 공간을 처음 사용하는 사람은<br>어디에서 멈추게 될까요?”<cite>검토 회의에서 나눌 수 있는 질문 예시</cite></blockquote><p>확인한 내용은 결정 사항과 다음 질문으로 나누어 기록합니다. 기획 의도가 실제 쓰임으로 이어지는지 다시 살펴보기 위해서입니다.</p></div>
</section>
<section class="jwc-scene-close"><div class="jwc-section jwc-wrap"><p class="jwc-kicker">현장에서 시작하는 대화</p><h2>지금의 환경에서<br>바꾸고 싶은 장면이 있나요?</h2><p>완성된 계획이 없어도 괜찮습니다.<br>현재의 사진 한 장과 불편했던 경험부터 이야기를 시작할 수 있습니다.</p><a class="jw-control jw-control--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">프로젝트 문의<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap" aria-label="테마 시연 안내"><p><?php echo $jw_company_name; ?>의 기업 소개 예시입니다. 사진과 사례는 실제 기업의 실적을 나타내지 않습니다.</p><nav aria-label="기업개요 디자인 비교"><span>다른 디자인</span><?php for ($i=1; $i<=5; $i++) { ?><a href="<?php echo $jw_link('company-overview-'.$i); ?>"<?php echo $i === 3 ? ' aria-current="page"' : ''; ?>>#<?php echo $i; ?></a><?php } ?></nav></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
