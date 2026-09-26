<?php
/**
 * Theme: JW-Business 1.0
 * File: index_4.php
 * Role: 협업 과정과 산출물을 안내하는 메인 4번 독립 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
// 선택용 파일의 직접 미리보기에서도 G5 기본 초기화만 수행합니다.
if (!defined('_GNUBOARD_')) {
    include_once dirname(__DIR__, 2).'/common.php';
}
if (!defined('_INDEX_')) {
    define('_INDEX_', true);
}
$g5['title'] = $config['cf_title'];
include_once G5_THEME_PATH.'/head.php';
$jw_company = jw_business_settings()['company'];
?>
<article class="jwh jwh--process" data-jw-home="4">
    <header class="jwh-process-hero">
        <div class="jwh-wrap jwh-process-hero__inner">
            <div>
                <p class="jwh4-eyebrow">A CLEAR WAY OF WORKING</p>
                <h1>과정이 보이면,<br>결과도 달라집니다.</h1>
                <p class="jwh-lead">다음 단계가 보이는 협업.<br>해야 할 일과 남길 자료를 함께 정합니다.</p>
                <a class="jw-control jw-control--primary" href="#home-process">함께 일하는 과정 <i data-lucide="arrow-down" aria-hidden="true"></i>
                </a>
            </div>
            <ol class="jwh-path" aria-label="협업 단계와 결과물">
                <li><span>01</span>
                    <div><strong>이해</strong>
                        <p>현황과 목표를 담은 과제 정의서</p>
                    </div>
                </li>
                <li><span>02</span>
                    <div><strong>설계</strong>
                        <p>선택의 이유가 보이는 실행 계획</p>
                    </div>
                </li>
                <li><span>03</span>
                    <div><strong>제작</strong>
                        <p>사용 장면에서 검토할 시안</p>
                    </div>
                </li>
                <li><span>04</span>
                    <div><strong>인계</strong>
                        <p>운영할 수 있는 원본과 관리 기준</p>
                    </div>
                </li>
            </ol>
        </div>
    </header>
    <section id="home-process" class="jwh4-work-intro jwh-section jwh-wrap" aria-labelledby="home-process-title">
        <h2 id="home-process-title">합의가 남는 과정.</h2>
        <p>가상의 서비스 안내 개선 과제입니다. 발견한 문제부터 운영 인계까지, 각 단계에서 확인할 자료가 달라집니다.</p>
        <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-5')); ?>">과정·산출물 상세 <i data-lucide="arrow-right" aria-hidden="true"></i></a>
    </section>
    <section class="jwh4-stage jwh4-stage--brief" aria-labelledby="jwh4-brief-title" data-jwh4-work-product="brief">
        <div class="jwh-wrap jwh4-stage__grid">
            <div class="jwh4-stage__copy"><span class="jwh-step-number">01 / 이해</span><h3 id="jwh4-brief-title">먼저, 문제를 한 장에 적습니다.</h3><p>고객은 정보를 찾기 전에 문의합니다. 담당자 인터뷰와 기존 자료에서 같은 질문이 반복되는 자리를 찾습니다.</p><p class="jwh4-stage__outcome">확인할 자료 · 과제 정의서와 검토 항목</p></div>
            <div class="jwh4-artifact jwh4-artifact--brief" aria-label="가상 과제 정의서 시안"><div class="jwh4-artifact__bar"><span>DISCOVERY BRIEF</span><span>시연 자료</span></div><strong>정보를 찾기 전에<br>문의가 시작된다.</strong><div class="jwh4-artifact__columns"><p><b>관찰</b>서비스마다 설명 방식이 달라 비교하기 어렵습니다.</p><p><b>목표</b>고객의 질문 순서대로 첫 화면을 정리합니다.</p></div></div>
        </div>
    </section>
    <section class="jwh4-stage jwh4-stage--options" aria-labelledby="jwh4-options-title" data-jwh4-work-product="options">
        <div class="jwh-wrap"><div class="jwh4-stage__heading"><span class="jwh-step-number">02 / 설계</span><h3 id="jwh4-options-title">두 방향을 놓고,<br>선택의 이유를 봅니다.</h3><p>대안을 같은 기준에서 읽어야 다음 화면이 흔들리지 않습니다. 여기서는 처음 온 고객이 스스로 답을 찾는 흐름을 선택했습니다.</p></div>
            <div class="jwh4-option-board" aria-label="가상 서비스 안내 구성안 비교"><div><span>방향 A</span><strong>한 화면에 모두 담기</strong><p>익숙한 방문자는 빠르지만 첫 방문자는 어디서 시작할지 다시 고민합니다.</p><small>장점 · 한눈에 많은 정보</small></div><div class="is-selected"><span>방향 B · 시연 선택</span><strong>질문을 따라 탐색하기</strong><p>방문자의 질문을 먼저 보여 주고, 조건과 자료를 순서대로 제시합니다.</p><small>선택 근거 · 처음 온 고객의 판단 순서</small></div></div>
        </div>
    </section>
    <section class="jwh4-stage jwh4-stage--prototype" aria-labelledby="jwh4-prototype-title" data-jwh4-work-product="prototype">
        <div class="jwh-wrap jwh4-stage__grid"><div class="jwh4-stage__copy"><span class="jwh-step-number">03 / 제작</span><h3 id="jwh4-prototype-title">합의한 방향을<br>사용 장면으로.</h3><p>문서 속 설명을 방문자가 실제로 따라갈 수 있는 첫 화면으로 옮깁니다. 제목, 선택지, 다음 행동이 이어지는지 검토합니다.</p><p class="jwh4-stage__outcome">확인할 자료 · 화면 시안과 수정 사항</p></div>
            <div class="jwh4-prototype" aria-label="가상 서비스 안내 화면 시안"><div class="jwh4-prototype__nav"><b>GUIDE / 01</b><span>서비스　 자주 묻는 질문</span></div><p>무엇을<br><strong>도와드릴까요?</strong></p><div class="jwh4-prototype__tiles"><span>서비스를 비교하고 싶어요 <i data-lucide="arrow-up-right" aria-hidden="true"></i></span><span>상담 전에 준비할 것이 있나요? <i data-lucide="arrow-up-right" aria-hidden="true"></i></span></div><small>실제 서비스가 아닌 테마 화면 시안입니다.</small></div>
        </div>
    </section>
    <section class="jwh4-stage jwh4-stage--handoff" aria-labelledby="jwh4-handoff-title" data-jwh4-work-product="handoff">
        <div class="jwh-wrap"><div class="jwh4-stage__heading"><span class="jwh-step-number">04 / 인계</span><h3 id="jwh4-handoff-title">다음 담당자가<br>바로 이어갈 수 있게.</h3><p>최종 화면만 넘기지 않습니다. 고칠 수 있는 원본과 관리 기준, 후속 확인 항목을 함께 남깁니다.</p></div>
            <ol class="jwh4-handoff-rail" aria-label="가상 프로젝트 운영 인계 항목"><li><span>원본</span><strong>수정 가능한 자료</strong><p>화면·문구·이미지의 편집 원본</p></li><li><span>관리</span><strong>담당 범위</strong><p>업데이트할 항목과 담당자</p></li><li><span>점검</span><strong>다음 확인</strong><p>운영 중 다시 볼 질문과 경로</p></li></ol>
        </div>
    </section>
    <section class="jwh4-decision jwh-section" aria-labelledby="home-collaboration-title">
        <div class="jwh-wrap jwh4-decision__grid">
            <div><p class="jwh4-eyebrow">DECISION LOG</p><h2 id="home-collaboration-title">회의가 끝난 뒤에도<br>명확하게.</h2><p>논의한 내용이 다음 작업으로 이어지도록 결정 사항, 담당 범위, 확인 시점을 문서에 남깁니다.</p><a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-list-5')); ?>">협업 가능한 분야 <i data-lucide="arrow-right" aria-hidden="true"></i></a></div>
            <div class="jwh4-log" aria-label="가상 프로젝트 결정 기록 시안"><div><span>DECISION 04</span><strong>방문자의 첫 질문을 첫 화면에 둔다.</strong><small>결정 이유 · 가장 많이 찾는 정보가 깊은 메뉴에 숨어 있음</small></div><div><span>OWNER</span><strong>콘텐츠 담당자</strong><small>다음 확인 · 문구와 연결 경로 점검</small></div><div><span>STATUS</span><strong>검토 완료 → 제작 진행</strong><small>실제 업무 기록이 아닌 테마 시연입니다.</small></div></div>
        </div>
    </section>
    <section class="jwh-section jwh-wrap jwh-questions" aria-labelledby="home-question-title">
        <h2 id="home-question-title">시작하기 전에<br>궁금한 점.</h2>
        <div>
            <details open>
                <summary>요청 범위가 아직 정리되지 않아도 되나요?</summary>
                <p>현재 상황과 바꾸고 싶은 점부터 전달해 주세요. 확인할 질문과 필요한 자료를 정리하는 것에서 시작할 수 있습니다.</p>
            </details>
            <details>
                <summary>일부 단계만 함께 진행할 수 있나요?</summary>
                <p>진단, 기획, 디자인, 운영 기준 정리 등 필요한 범위를 상담에서 확인합니다. 기존에 진행한 작업과의 연결도 함께 살펴봅니다.</p>
            </details>
            <details>
                <summary>무엇을 준비하면 상담에 도움이 되나요?</summary>
                <p>사업 소개, 참고 자료, 예상 일정과 현재 담당자를 알려주세요. 외부 공유가 어려운 자료는 첫 문의에 첨부하지 않으셔도 됩니다.</p>
            </details>
        </div>
    </section>
    <!-- JW BLOCK COPY START: blocks/home/contact-band-01.php; 이 페이지에서 독립 수정합니다. -->
    <section class="jwh-close">
        <div class="jwh-wrap">
            <h2>지금 필요한 단계부터 이야기해 주세요.</h2>
            <a class="jw-control jw-control--primary" href="<?php echo jw_business_escape(jw_business_page_url('contact-1')); ?>">프로젝트 문의 안내 <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
    <!-- JW BLOCK COPY END -->
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
