<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-detail-5.php
 * Role: 컨설팅 · 과정과 산출물 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '컨설팅 · 과정과 산출물';
$jw_description = '현황 정리부터 실행 인계까지 단계별 협업 내용과 산출물을 소개합니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-detail-5.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-detail-5.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-detail-5">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><a href="<?php echo $jw_link('business-list-1'); ?>">사업분야</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-detail-5.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwc-wrap jwb-process-header"><h1>함께 확인하고,<br>다음 단계로 넘깁니다.</h1><p class="jwc-lead">컨설팅의 각 단계에 논의할 내용과 남길 자료를 정해 둡니다.</p><p>아래는 협업 과정의 예시입니다. 실제 단계와 산출물은 과제의 범위에 따라 협의합니다.</p></header>
<nav class="jwc-wrap jwb-process-nav" aria-label="협업 단계 바로가기"><a href="#process-discover">01 현황 정리</a><a href="#process-decide">02 방향 합의</a><a href="#process-plan">03 실행 계획</a><a href="#process-handoff">04 인계 확인</a></nav>
<div class="jwc-wrap jwb-process-stages">
<section id="process-discover"><header><span>01</span><h2>현황 정리</h2></header><div><h3>같은 문제를 보고 있는지 확인합니다.</h3><p>현재 업무와 이용자, 기존 자료를 함께 살펴봅니다. 서로 다르게 이해한 부분과 추가 확인이 필요한 질문을 기록합니다.</p><dl><div><dt>함께 확인</dt><dd>현재 업무 · 주요 이용자 · 불편한 장면</dd></div><div><dt>남기는 자료</dt><dd>현황 요약 · 요구사항 목록 · 확인 질문</dd></div><div><dt>다음 단계 조건</dt><dd>핵심 문제와 추가 확인 항목 공유</dd></div></dl></div></section>
<section id="process-decide"><header><span>02</span><h2>방향 합의</h2></header><div><h3>이번에 할 일의 경계를 정합니다.</h3><p>여러 대안을 목표와 제약에 비추어 검토합니다. 먼저 할 일과 이후 검토할 일을 구분하고 선택한 이유를 남깁니다.</p><dl><div><dt>함께 확인</dt><dd>목표 · 우선순위 · 일정과 자원 제약</dd></div><div><dt>남기는 자료</dt><dd>대안 비교 · 범위 합의 · 결정 기록</dd></div><div><dt>다음 단계 조건</dt><dd>제공 범위와 제외 항목 합의</dd></div></dl></div></section>
<section id="process-plan"><header><span>03</span><h2>실행 계획</h2></header><div><h3>누가 무엇을 확인할지 구체화합니다.</h3><p>작업을 담당자와 검토 시점에 연결합니다. 준비할 자료와 의존 관계를 확인해 진행 중 필요한 결정을 예상합니다.</p><dl><div><dt>함께 확인</dt><dd>담당 역할 · 검토 일정 · 준비 자료</dd></div><div><dt>남기는 자료</dt><dd>실행 항목 · 역할 분담 · 검토 기준</dd></div><div><dt>다음 단계 조건</dt><dd>담당자와 확인 일정 공유</dd></div></dl></div></section>
<section id="process-handoff"><header><span>04</span><h2>인계 확인</h2></header><div><h3>다음 담당자가 이어갈 수 있게 정리합니다.</h3><p>합의한 자료와 미결 항목을 함께 검토합니다. 문서가 있다는 사실보다 필요한 내용을 찾고 활용할 수 있는지 확인합니다.</p><dl><div><dt>함께 확인</dt><dd>제공 자료 · 미결 항목 · 후속 담당자</dd></div><div><dt>남기는 자료</dt><dd>인계 목록 · 결정 이력 · 후속 과제</dd></div><div><dt>마무리 조건</dt><dd>자료 전달과 남은 업무의 담당 주체 확인</dd></div></dl></div></section>
</div>
<section class="jwc-soft"><div class="jwc-section jwc-wrap jwc-statement"><h2>중간에 조건이<br>바뀌면 어떻게 하나요?</h2><div><p>새로운 요구가 생기면 합의한 범위와 영향을 먼저 확인합니다. 변경할 항목, 일정, 추가로 필요한 협의를 기록한 뒤 다음 작업을 정합니다.</p><p>실제 구축·지속 운영의 포함 여부는 별도 협의합니다. 이 과정 안내가 모든 실행 업무의 제공을 의미하지는 않습니다.</p></div></div></section>
<section class="jwc-section jwc-wrap jwc-question"><h2>첫 대화는 현재 상황부터.</h2><p>완성된 요구사항 문서가 없어도 됩니다.<br>검토 중인 과제와 참고 자료를 알려 주세요.</p><a class="jw-control jw-control--primary" href="<?php echo $jw_link('contact-1'); ?>#contact-strategy">컨설팅 문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
