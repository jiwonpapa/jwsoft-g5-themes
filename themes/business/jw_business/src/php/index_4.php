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
                <h1>처음의 질문이<br>마지막 실행까지.</h1>
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
                    <div><strong>실행</strong>
                        <p>현장에서 사용할 결과물과 운영 기준</p>
                    </div>
                </li>
            </ol>
        </div>
    </header>
    <section id="home-process" class="jwh-section jwh-wrap jwh-process-detail" aria-labelledby="home-process-title">
        <div class="jwh-sticky-copy">
            <h2 id="home-process-title">진행 중에도,<br>같은 지도를 봅니다.</h2>
            <p>각 단계에서 결정할 내용과 확인할 자료를 명확히 합니다. 실제 범위와 일정은 상담 후 과제에 맞게 정합니다.</p>
            <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-5')); ?>">과정·산출물 상세 <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        <div class="jwh-deliverables">
            <section>
                <span class="jwh-step-number">01</span>
                <h3>문제를 함께 정의합니다.</h3>
                <p>담당자 인터뷰와 기존 자료 검토를 통해 요청의 배경을 이해합니다. 목표, 제약, 먼저 해결할 일을 정리합니다.</p>
                <dl>
                    <div>
                        <dt>함께 할 일</dt>
                        <dd>현황 공유 · 과제 범위 합의</dd>
                    </div>
                    <div>
                        <dt>확인할 자료</dt>
                        <dd>과제 정의서 · 검토 항목</dd>
                    </div>
                </dl>
            </section>
            <section>
                <span class="jwh-step-number">02</span>
                <h3>선택할 수 있게 설계합니다.</h3>
                <p>핵심 가설을 구체적인 대안으로 바꿉니다. 화면·동선·업무 시나리오를 비교하며 실행 방향을 합의합니다.</p>
                <dl>
                    <div>
                        <dt>함께 할 일</dt>
                        <dd>대안 검토 · 우선순위 결정</dd>
                    </div>
                    <div>
                        <dt>확인할 자료</dt>
                        <dd>구성안 · 시나리오 · 실행 계획</dd>
                    </div>
                </dl>
            </section>
            <section>
                <span class="jwh-step-number">03</span>
                <h3>운영할 수 있도록 남깁니다.</h3>
                <p>합의한 결과물을 확인하고 담당자가 이어갈 수 있게 정리합니다. 운영에 필요한 기준과 남은 과제를 함께 전달합니다.</p>
                <dl>
                    <div>
                        <dt>함께 할 일</dt>
                        <dd>결과 검토 · 담당자 인수인계</dd>
                    </div>
                    <div>
                        <dt>확인할 자료</dt>
                        <dd>최종 결과물 · 운영 가이드</dd>
                    </div>
                </dl>
            </section>
        </div>
    </section>
    <section class="jwh-soft jwh-section" aria-labelledby="home-collaboration-title">
        <div class="jwh-wrap jwh-example">
            <figure>
                <div class="jwh-photo jwh-photo--team" role="img" aria-label="팀이 같은 자료를 보며 검토하는 협업 장면">
                </div>
                <figcaption>결정한 내용과 다음 행동을 함께 기록합니다.</figcaption>
            </figure>
            <div>
                <h2 id="home-collaboration-title">회의가 끝난 뒤에도<br>명확하게.</h2>
                <p>논의한 내용이 다음 작업으로 이어지도록 결정 사항, 담당 범위, 확인 시점을 문서에 남깁니다. 누구나 현재 진행 상황을 이해할 수 있는 협업을 지향합니다.</p>
                <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-list-5')); ?>">협업 가능한 분야 <i data-lucide="arrow-right" aria-hidden="true"></i>
                </a>
            </div>
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
