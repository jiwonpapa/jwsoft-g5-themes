<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/onepage-services.php
 * Role: 독립 원페이지 — 비즈니스 서비스·상담
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT. All rights reserved.
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) include_once dirname(__DIR__).'/common.php';
$g5['title'] = '함께 정리하는 비즈니스 · 서비스';
$g5['document_meta'] = array('description' => '서비스 범위, 협업 과정, 자주 묻는 질문을 한 페이지에서 확인하는 상담형 시연입니다.', 'canonical' => G5_URL.'/pages/onepage-services.php');
$jw_full_width_page = true;
$jwo_assets = htmlspecialchars(G5_THEME_URL.'/onepages/assets', ENT_QUOTES, 'UTF-8');
$jwo_css_url = htmlspecialchars(get_versioned_asset_url(G5_THEME_URL.'/css/onepages.min.css'), ENT_QUOTES, 'UTF-8');
$jwo_js_url = htmlspecialchars(get_versioned_asset_url(G5_THEME_URL.'/js/onepages.min.js'), ENT_QUOTES, 'UTF-8');
add_stylesheet('<link rel="stylesheet" href="'.$jwo_css_url.'">', 30);
include_once G5_THEME_PATH.'/head.php';
?>
<article class="jwo jwo--services" data-jw-onepage="services">
    <nav class="jwo-nav" aria-label="서비스 소개 목차"><a class="jwo-nav__brand" href="#service-top">비즈니스 파트너</a><div class="jwo-nav__links"><a href="#service-scope">서비스 범위</a><a href="#service-process">고객 여정</a><a href="#service-case">결과물 시안</a></div><a class="jwo-nav__action" href="#service-contact">상담 안내</a></nav>
    <section class="jwo-service-hero jwo-wrap" id="service-top"><div><h1>복잡한 과제에,<br>명확한 다음 한 걸음.</h1><p class="jwo-lead">사업의 방향부터 실제 실행까지.<br>흩어진 생각을 함께 정리합니다.</p><a class="jwo-button" href="#service-scope">함께할 수 있는 일</a><p class="jwo-caption">비즈니스 서비스 소개 시연 · 내용과 사진은 예시입니다.</p></div><figure><img src="<?php echo $jwo_assets; ?>/images/service-workshop.webp" width="1536" height="1024" alt="고객 여정 카드와 태블릿 화면을 함께 검토하는 작업 테이블" fetchpriority="high"><figcaption>고객의 행동과 팀의 결정을 같은 지도로 옮깁니다.</figcaption></figure></section>
    <section class="jwo-section jwo-wrap jwo-service-scope" id="service-scope" aria-labelledby="service-scope-title">
        <div class="jwo-section-head"><h2 id="service-scope-title">필요한 일과<br>남길 자료를 함께 봅니다.</h2><p>가상 프로젝트에서 설명을 비교하는 예시입니다. 실제 제공 범위는 과제에 맞춰 협의합니다.</p></div>
        <div class="jwo-service-board" data-jwo-service-board>
            <article><span>사업과 서비스 기획</span><h3>무엇을 먼저 풀어야 할까요?</h3><p>고객·시장·현재 운영에서 확인할 질문을 좁힙니다.</p><dl><div><dt>살펴볼 자료</dt><dd>고객 여정 · 현재 서비스</dd></div><div><dt>남길 자료</dt><dd>우선순위와 실행 범위</dd></div></dl></article>
            <article><span>디지털 경험 설계</span><h3>고객은 어디에서 멈출까요?</h3><p>첫 방문부터 선택까지 필요한 정보와 화면을 설계합니다.</p><dl><div><dt>살펴볼 자료</dt><dd>탐색 경로 · 주요 질문</dd></div><div><dt>남길 자료</dt><dd>정보 구조와 검토 시안</dd></div></dl></article>
            <article><span>운영과 개선 방향</span><h3>누가 무엇을 이어갈까요?</h3><p>반복되는 문의와 작업을 담당자가 관리할 수 있게 정리합니다.</p><dl><div><dt>살펴볼 자료</dt><dd>업무 흐름 · 관리 항목</dd></div><div><dt>남길 자료</dt><dd>운영 기준과 점검 목록</dd></div></dl></article>
        </div>
    </section>
    <section class="jwo-section jwo-service-journey" id="service-process" data-jwo-customer-journey aria-labelledby="service-process-title">
        <div class="jwo-wrap"><div class="jwo-service-journey__heading"><h2 id="service-process-title">고객의 질문이<br>길을 만듭니다.</h2><p>처음 온 방문자가 서비스를 이해하고, 자신의 상황과 비교한 다음 문의할 수 있도록 읽는 순서를 정합니다.</p></div>
            <ol><li><span>처음</span><strong>“무슨 일을 하나요?”</strong><p>세 서비스를 각각의 질문과 결과물로 소개합니다.</p></li><li><span>비교</span><strong>“내 상황에 맞나요?”</strong><p>필요한 자료와 협의 범위를 나란히 보여 줍니다.</p></li><li><span>행동</span><strong>“어떻게 시작하나요?”</strong><p>문의 전에 준비할 내용을 짧게 안내합니다.</p></li></ol>
        </div>
    </section>
    <section class="jwo-section jwo-wrap jwo-service-proof" id="service-case" aria-labelledby="service-case-title">
        <div class="jwo-service-proof__intro"><h2 id="service-case-title">설명 문서가<br>안내 화면이 되기까지.</h2><p>서비스 설명이 여러 문서에 흩어져 같은 질문을 반복하는 가상의 기업을 설정했습니다. 아래는 실제 수행 실적이 아닌 정보 구조 시안입니다.</p></div>
        <div class="jwo-delivery-sample" data-jwo-delivery-sample aria-label="흩어진 서비스 문서와 고객 질문형 안내 화면의 구성 비교"><div class="jwo-delivery-sample__before"><span>정리 전 / 시연 자료</span><strong>찾기 어려운<br>서비스 설명</strong><ul><li>회사 소개 문서 속 서비스 항목</li><li>별도 파일의 이용 조건</li><li>담당자마다 다른 문의 답변</li></ul></div><div class="jwo-delivery-sample__after"><span>정리 후 / 제안 시안</span><strong>궁금한 순서로<br>읽는 안내</strong><ol><li><b>01</b>할 수 있는 일</li><li><b>02</b>내게 맞는 범위</li><li><b>03</b>상담 전 준비</li></ol></div></div>
        <p class="jwo-caption">실제 납품 사례가 아닌 테마 구성 예시입니다.</p>
    </section>
    <section class="jwo-section jwo-wrap jwo-faq" id="service-faq"><div><h2>대화를 시작하기 전,<br>궁금한 것들.</h2><p>계약 조건과 수행 범위는 상담 후 별도로 협의합니다.</p></div><div><details><summary>아직 기획서가 없어도 문의할 수 있나요?</summary><p>현재 상황과 바꾸고 싶은 점만 정리해도 시작할 수 있습니다. 참고할 화면이나 문서가 있다면 함께 준비해 주세요.</p></details><details><summary>필요한 부분만 협의할 수 있나요?</summary><p>우선 해결하려는 과제와 기존 자료를 확인한 뒤, 분리 가능한 업무 범위를 함께 검토할 수 있습니다.</p></details><details><summary>비용과 일정은 어떻게 정하나요?</summary><p>결과물의 범위, 제공 자료, 검토 횟수와 희망 일정에 따라 달라집니다. 이 시연 페이지에서는 확정 금액이나 납기를 제시하지 않습니다.</p></details><details><summary>상담 전에 무엇을 준비하면 좋을까요?</summary><p>현재 사이트나 소개 자료, 주요 고객, 해결할 문제, 희망 일정과 예산 범위를 준비하면 논의에 도움이 됩니다.</p></details></div></section>
    <section class="jwo-section jwo-service-contact" id="service-contact"><div class="jwo-wrap jwo-intro"><div><h2>지금 고민하는 일을<br>들려주세요.</h2><p>첫 대화에 완성된 답은 필요하지 않습니다.</p></div><div><h3>상담을 준비하는 세 가지 질문</h3><ul class="jwo-checklist"><li>지금 가장 불편한 점은 무엇인가요?</li><li>누구를 위한 변화인가요?</li><li>언제까지 어떤 결과가 필요한가요?</li></ul><a class="jwo-button" href="<?php echo htmlspecialchars(G5_BBS_URL.'/qalist.php', ENT_QUOTES, 'UTF-8'); ?>">비즈니스 상담 문의</a></div></div></section>
</article>
<script type="module" src="<?php echo $jwo_js_url; ?>"></script>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
