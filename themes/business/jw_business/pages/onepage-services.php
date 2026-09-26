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
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/css/onepages.min.css">', 30);
include_once G5_THEME_PATH.'/head.php';
?>
<article class="jwo jwo--services" data-jw-onepage="services">
    <nav class="jwo-nav" aria-label="서비스 소개 목차"><a class="jwo-nav__brand" href="#service-top">비즈니스 파트너</a><div class="jwo-nav__links"><a href="#service-scope">서비스</a><a href="#service-process">진행 과정</a><a href="#service-faq">자주 묻는 질문</a></div><a class="jwo-nav__action" href="#service-contact">상담 안내</a></nav>
    <section class="jwo-service-hero jwo-wrap" id="service-top"><div><p class="jwo-service-eyebrow">SERVICE DESIGN / BUSINESS SUPPORT</p><h1>복잡한 과제에,<br>명확한 다음 한 걸음.</h1><p class="jwo-lead">사업의 방향부터 실제 실행까지.<br>흩어진 생각을 함께 정리합니다.</p><a class="jwo-button" href="#service-scope">함께할 수 있는 일</a><p class="jwo-caption">비즈니스 서비스 소개 시연 · 내용과 사진은 예시입니다.</p></div><figure><img src="<?php echo $jwo_assets; ?>/images/service-workshop.webp" width="1536" height="1024" alt="고객 여정 카드와 태블릿 화면을 함께 검토하는 작업 테이블" fetchpriority="high"><figcaption>고객의 행동과 팀의 결정을 같은 지도로 옮깁니다.</figcaption></figure></section>
    <section class="jwo-section jwo-wrap" id="service-scope"><div class="jwo-section-head"><h2>지금 필요한 일부터<br>함께 시작합니다.</h2><p>큰 계획을 한 번에 맡기지 않아도 괜찮습니다.<br>현재의 과제에 맞춰 범위를 정할 수 있습니다.</p></div><div class="jwo-service-list">
        <details open><summary><span>사업과 서비스 기획</span><span class="jwo-plus" aria-hidden="true"></span></summary><div><p>고객에게 전달할 가치와 서비스의 우선순위를 정리합니다. 막연한 아이디어를 함께 판단할 수 있는 계획으로 구체화합니다.</p><ul><li>현재 서비스와 고객 여정 검토</li><li>핵심 과제와 우선순위 정의</li><li>실행 범위 및 결과물 협의</li></ul></div></details>
        <details><summary><span>디지털 경험 설계</span><span class="jwo-plus" aria-hidden="true"></span></summary><div><p>방문자가 찾는 정보와 해야 할 행동을 연결합니다. 화면을 그리기 전에 실제 사용하는 흐름을 먼저 살핍니다.</p><ul><li>정보 구조와 이용 흐름 정리</li><li>웹사이트·서비스 화면 기획</li><li>실제 사용 상황을 기준으로 검토</li></ul></div></details>
        <details><summary><span>운영과 개선 방향</span><span class="jwo-plus" aria-hidden="true"></span></summary><div><p>출시 뒤의 운영도 서비스의 일부입니다. 반복되는 문의와 작업을 살펴보고 지금 바꿀 수 있는 것부터 정리합니다.</p><ul><li>운영 과정과 반복 업무 파악</li><li>콘텐츠 관리 방식 검토</li><li>개선 항목과 확인 기준 정의</li></ul></div></details>
    </div></section>
    <section class="jwo-section jwo-surface" id="service-process"><div class="jwo-wrap jwo-intro"><div class="jwo-sticky-copy"><h2>처음의 질문이<br>실행으로 이어지도록.</h2><p>각 단계에서 무엇을 확인하고<br>무엇을 남기는지 명확하게 공유합니다.</p></div><ol class="jwo-process"><li><h3>듣고 이해합니다.</h3><p>현재 상황, 불편한 지점, 기대하는 변화를 함께 살펴봅니다.</p><span>남기는 것 · 과제와 목표</span></li><li><h3>범위를 정합니다.</h3><p>우선순위와 진행 범위, 일정 및 검토 방식을 협의합니다.</p><span>남기는 것 · 실행 계획</span></li><li><h3>만들고 확인합니다.</h3><p>중간 결과를 공유하고 실제 사용 흐름에 맞춰 검토합니다.</p><span>남기는 것 · 검토한 결과물</span></li><li><h3>다음 운영을 준비합니다.</h3><p>사용 방법과 인수 범위를 정리하고 후속 과제를 확인합니다.</p><span>남기는 것 · 운영 안내</span></li></ol></div></section>
    <section class="jwo-section jwo-wrap jwo-case" id="service-case"><div class="jwo-blueprint" role="img" aria-label="고객 질문에서 서비스 탐색, 상담 준비까지 이어지는 가상 서비스 청사진"><div class="jwo-blueprint__top"><span>SERVICE BLUEPRINT / DEMO</span><strong>고객의 질문이<br>길이 되도록.</strong></div><ol><li><b>01</b><strong>무엇을 하나요?</strong><span>서비스를 이해하는 첫 질문</span></li><li><b>02</b><strong>내게 맞나요?</strong><span>사례와 범위를 비교하는 단계</span></li><li><b>03</b><strong>어떻게 시작하나요?</strong><span>상담을 준비하는 다음 행동</span></li></ol><p>가상 적용 시나리오 · 실제 수행 실적이 아닙니다.</p></div><div><h2>찾기 어려운 소개를,<br>상담으로 이어지는 안내로.</h2><p>여러 문서에 흩어진 서비스 설명 때문에 같은 문의가 반복되는 기업을 가정했습니다.</p><dl class="jwo-facts"><div><dt>시작점</dt><dd>서비스마다 다른 설명과 모호한 문의 경로</dd></div><div><dt>검토 방향</dt><dd>고객 질문 순서로 정보 재구성</dd></div><div><dt>제안 결과물</dt><dd>서비스 소개 페이지와 상담 준비 안내</dd></div></dl></div></section>
    <section class="jwo-section jwo-wrap jwo-faq" id="service-faq"><div><h2>대화를 시작하기 전,<br>궁금한 것들.</h2><p>계약 조건과 수행 범위는 상담 후 별도로 협의합니다.</p></div><div><details><summary>아직 기획서가 없어도 문의할 수 있나요?</summary><p>현재 상황과 바꾸고 싶은 점만 정리해도 시작할 수 있습니다. 참고할 화면이나 문서가 있다면 함께 준비해 주세요.</p></details><details><summary>필요한 부분만 협의할 수 있나요?</summary><p>우선 해결하려는 과제와 기존 자료를 확인한 뒤, 분리 가능한 업무 범위를 함께 검토할 수 있습니다.</p></details><details><summary>비용과 일정은 어떻게 정하나요?</summary><p>결과물의 범위, 제공 자료, 검토 횟수와 희망 일정에 따라 달라집니다. 이 시연 페이지에서는 확정 금액이나 납기를 제시하지 않습니다.</p></details><details><summary>상담 전에 무엇을 준비하면 좋을까요?</summary><p>현재 사이트나 소개 자료, 주요 고객, 해결할 문제, 희망 일정과 예산 범위를 준비하면 논의에 도움이 됩니다.</p></details></div></section>
    <section class="jwo-section jwo-service-contact" id="service-contact"><div class="jwo-wrap jwo-intro"><div><h2>지금 고민하는 일을<br>들려주세요.</h2><p>첫 대화에 완성된 답은 필요하지 않습니다.</p></div><div><h3>상담을 준비하는 세 가지 질문</h3><ul class="jwo-checklist"><li>지금 가장 불편한 점은 무엇인가요?</li><li>누구를 위한 변화인가요?</li><li>언제까지 어떤 결과가 필요한가요?</li></ul><a class="jwo-button" href="<?php echo htmlspecialchars(G5_BBS_URL.'/qalist.php', ENT_QUOTES, 'UTF-8'); ?>">비즈니스 상담 문의</a></div></div></section>
</article>
<script type="module" src="<?php echo G5_THEME_URL; ?>/js/onepages.min.js"></script>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
