<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-detail-1.php
 * Role: 비즈니스 컨설팅 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '비즈니스 컨설팅';
$jw_description = '현황 진단에서 실행 계획까지, 비즈니스 컨설팅의 업무 범위와 검토 자료를 확인하세요.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-detail-1.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-detail-1.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-detail-1">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><a href="<?php echo $jw_link('business-list-1'); ?>">사업분야</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-detail-1.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwc-split-hero jwc-wrap"><div class="jwc-split-hero__copy"><p class="jwc-kicker">비즈니스 컨설팅</p><h1>복잡한 과제를,<br>실행할 수 있는 계획으로.</h1><p>여러 요구가 한꺼번에 쌓일 때, 무엇부터 바꿔야 할지 정리합니다. 고객과 운영자의 관점을 함께 살펴 실제로 추진할 범위를 구체화합니다.</p><a class="jwc-link" href="#business-scope">업무 범위 확인<i data-lucide="arrow-down" aria-hidden="true"></i></a></div><figure class="jwc-split-hero__figure"><div class="jwc-photo jwc-photo--business-detail-1-consulting" role="img" aria-label="함께 자료를 검토하는 협업 장면"></div><figcaption>현황과 목표를 같은 자료 위에서 확인하는 협업 예시입니다.</figcaption></figure></header>
<section class="jwc-section jwc-wrap" id="business-scope"><div class="jwc-section-head"><h2>검토할 내용과<br>남길 자료를 함께 정합니다.</h2><p>범위를 먼저 합의하고,<br>결정의 이유가 남도록 정리합니다.</p></div><div class="jwb-scope"><section><h3>현황 진단</h3><p>현재의 서비스·업무 흐름과 반복되는 불편을 확인합니다.</p><strong>현황 정리 · 주요 과제</strong></section><section><h3>방향 설계</h3><p>목표 고객과 사용 상황을 기준으로 가능한 대안을 비교합니다.</p><strong>구조안 · 우선순위</strong></section><section><h3>실행 준비</h3><p>역할과 일정, 다음 검토에 필요한 내용을 구체화합니다.</p><strong>실행 계획 · 검토 기준</strong></section></div></section>
<section class="jwc-soft"><div class="jwc-section jwc-wrap jwc-case"><div><p class="jwc-kicker">접근 사례 · 가상 예시</p><h2>문의가 반복되는 이유를<br>안내 흐름에서 찾습니다.</h2><p>사업 소개를 읽어도 문의할 내용을 정하기 어렵다는 상황을 가정했습니다.</p></div><dl class="jwc-facts"><div><dt>발견한 과제</dt><dd>사업 설명과 상담 안내가 서로 떨어져 있음</dd></div><div><dt>검토할 방향</dt><dd>업무 범위 뒤에 준비 자료와 문의 경로 연결</dd></div><div><dt>남기는 자료</dt><dd>정보 구조, 안내 문구, 문의 분류 기준</dd></div><div><dt>후속 확인</dt><dd>반복 질문과 누락되는 정보가 무엇인지 운영 중 확인</dd></div></dl></div></section>
<section class="jwc-section jwc-wrap jwc-statement"><h2>시작 전에<br>이 내용을 공유해 주세요.</h2><div><p>프로젝트의 목적, 현재 운영 중인 서비스나 자료, 희망 일정과 내부 검토 절차를 알려 주세요. 아직 정해지지 않은 사항은 상담에서 함께 정리할 수 있습니다.</p><p>제공 자료와 수행 범위는 상담을 통해 확정합니다. 구현·운영 대행 등 추가 범위를 자동으로 포함하지 않습니다.</p></div></section>
<section class="jwc-contact jwc-wrap"><h2>현재의 과제부터<br>이야기해 주세요.</h2><a class="jw-control jw-control--primary" href="<?php echo $jw_link('contact-1'); ?>#contact-strategy">컨설팅 문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
