<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/company-overview-1.php
 * Role: 기업개요 #1 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '기업개요 #1';
$jw_description = '전략과 기술, 공간을 연결하는 기업. 사람과 현장을 중심으로 일하는 방식을 소개합니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/company-overview-1.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/company-overview-1.php'),
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
<article class="jwc jwc--1" data-jw-company-page="1">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span>회사소개</span><span aria-hidden="true">/</span><span aria-current="page">기업개요</span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/company-overview/1.php; 이 페이지 안에서만 수정합니다. -->
<section class="jwc-split-hero jwc-wrap">
    <div class="jwc-split-hero__copy">
        <h1>기업의 내일을,<br>더 가깝게.</h1>
        <p class="jwc-lead">다른 전문성이 만나<br>하나의 좋은 변화를 만듭니다.</p>
        <p>전략을 세우는 일부터 디지털 경험과 공간을 만드는 일까지. <?php echo $jw_company_name; ?>는 현장을 이해하고, 필요한 것을 연결하며, 실행 이후까지 함께합니다.</p>
        <a class="jwc-link" href="#company-approach">우리가 일하는 방식<i data-lucide="arrow-down" aria-hidden="true"></i></a>
    </div>
    <figure class="jwc-split-hero__figure"><?php $jw_photo('co1-workshop', '밝은 작업실에서 디자인 자료를 함께 검토하는 팀'); ?><figcaption>사람과 일이 자연스럽게 이어지는 환경을 생각합니다.</figcaption></figure>
</section>
<!-- Company summary: keep short facts between the hero and detailed services. -->
<section class="jwc-profile jwc-wrap" aria-label="기업 소개 요약">
    <div><span>기업명</span><strong><?php echo $jw_company_name; ?></strong></div>
    <div><span>사업 영역</span><strong>전략 · 디지털 · 공간</strong></div>
    <div><span>협업 범위</span><strong>기획부터 운영 개선까지</strong></div>
</section>
<section class="jwc-section jwc-wrap jwc-statement" id="company-approach">
    <div><p class="jwc-kicker">우리의 역할</p><h2>사업의 방향과<br>실행을 연결합니다.</h2></div>
    <div><p>새로운 서비스를 준비할 때, 업무 방식을 바꿀 때, 공간의 쓰임을 다시 정할 때. 먼저 해결할 과제를 함께 정리합니다.</p><p>목표와 사용 환경을 기준으로 필요한 분야를 연결하고, 기획 문서가 실제 운영으로 이어질 때까지 각 단계의 결정을 함께 확인합니다.</p></div>
</section>
<section class="jwc-soft">
    <div class="jwc-section jwc-wrap">
        <div class="jwc-section-head"><h2>함께 연결하는<br>세 가지 전문성</h2><p>분야를 나누기보다,<br>목표에 맞는 조합을 찾습니다.</p></div>
        <div class="jwc-expertise">
            <section><i data-lucide="compass" aria-hidden="true"></i><h3>전략과 방향</h3><p>복잡한 요구를 정리하고 실행 가능한 계획을 세웁니다.</p><a class="jwc-link" href="<?php echo $jw_link('business-detail-1'); ?>">컨설팅 살펴보기<i data-lucide="arrow-up-right"></i></a></section>
            <section><i data-lucide="monitor" aria-hidden="true"></i><h3>기술과 경험</h3><p>사람의 행동을 이해하고 디지털 서비스의 접점을 설계합니다.</p><a class="jwc-link" href="<?php echo $jw_link('business-detail-2'); ?>">디지털 사업 보기<i data-lucide="arrow-up-right"></i></a></section>
            <section><i data-lucide="building-2" aria-hidden="true"></i><h3>공간과 관계</h3><p>업무와 일상의 흐름을 담아 공간의 쓰임을 새롭게 만듭니다.</p><a class="jwc-link" href="<?php echo $jw_link('business-detail-3'); ?>">공간 사업 보기<i data-lucide="arrow-up-right"></i></a></section>
        </div>
    </div>
</section>
<!-- A photo and a project brief explain one example instead of repeating a slogan. -->
<section class="jwc-section jwc-wrap jwc-example">
    <figure><?php $jw_photo('co1-consultation', '고객과 함께 프로젝트 내용을 검토하는 상담 장면'); ?><figcaption>프로젝트의 출발점은 같은 문제를 함께 이해하는 일입니다.</figcaption></figure>
    <div class="jwc-example__copy"><p class="jwc-kicker">프로젝트 접근 예시</p><h2>흩어진 고객 접점을<br>하나의 경험으로.</h2><p>기업 홈페이지와 상담 과정이 따로 운영되는 상황을 가정한 협업 예시입니다.</p>
    <dl class="jwc-brief"><div><dt>출발점</dt><dd>방문자가 사업 정보를 찾고 담당자에게 문의하기까지의 흐름을 살핍니다.</dd></div><div><dt>함께 할 일</dt><dd>정보 구조, 화면 설계, 문의 분류와 운영자의 응대 과정을 함께 정리합니다.</dd></div><div><dt>확인할 자료</dt><dd>메뉴 구조도, 주요 화면, 문의 처리 기준을 단계별로 공유합니다.</dd></div></dl></div>
</section>
<section class="jwc-soft"><div class="jwc-section jwc-wrap">
    <div class="jwc-section-head"><div><p class="jwc-kicker">협업 과정</p><h2>각 단계에서<br>무엇을 함께 결정할까요?</h2></div><p>진행 상황뿐 아니라<br>다음 결정에 필요한 자료를 공유합니다.</p></div>
    <ol class="jwc-delivery"><li><span>01</span><h3>과제 정리</h3><p>목표와 현재 상황을 듣고 이번 프로젝트에서 다룰 범위를 정합니다.</p><small>공유 자료 · 요구사항과 범위</small></li><li><span>02</span><h3>방향 제안</h3><p>가능한 방안을 비교하고 사용 환경에 맞는 접근을 선택합니다.</p><small>공유 자료 · 구조와 설계안</small></li><li><span>03</span><h3>제작과 확인</h3><p>중간 결과를 직접 확인하며 실제 사용에 필요한 부분을 다듬습니다.</p><small>공유 자료 · 시안과 검토 기록</small></li><li><span>04</span><h3>운영 인계</h3><p>담당자가 이어서 관리할 수 있도록 사용법과 수정 위치를 정리합니다.</p><small>공유 자료 · 운영 안내</small></li></ol>
</div></section>
<section class="jwc-contact jwc-wrap"><h2>다음 이야기를<br>함께 시작해 볼까요?</h2><a class="jw-control jw-control--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">프로젝트 문의<i data-lucide="arrow-up-right"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap" aria-label="테마 시연 안내"><p><?php echo $jw_company_name; ?>의 기업 소개 예시입니다. 사진과 사례는 실제 기업의 실적을 나타내지 않습니다.</p><nav aria-label="기업개요 디자인 비교"><span>다른 디자인</span><?php for ($i=1; $i<=5; $i++) { ?><a href="<?php echo $jw_link('company-overview-'.$i); ?>"<?php echo $i === 1 ? ' aria-current="page"' : ''; ?>>#<?php echo $i; ?></a><?php } ?></nav></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
