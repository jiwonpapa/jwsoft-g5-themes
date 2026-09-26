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
                <div class="jwh4-artifact jwh4-artifact--brief" aria-label="과제 정의서 시안">
                    <div class="jwh4-artifact__bar"><span>01 / DISCOVERY BRIEF</span><span>시연 자료</span></div>
                    <strong>무엇을 먼저<br>풀어야 하는가?</strong>
                    <div class="jwh4-artifact__columns"><p><b>현재의 문제</b>정보를 찾기 전 문의가 반복됩니다.</p><p><b>이번의 목표</b>고객 질문 순서로 안내를 바꿉니다.</p></div>
                </div>
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
                <div class="jwh4-artifact jwh4-artifact--plan" aria-label="실행 방향 비교 시안">
                    <div class="jwh4-artifact__bar"><span>02 / OPTION MAP</span><span>시연 자료</span></div>
                    <div class="jwh4-option"><span>방향 A</span><strong>정보를 한 화면에서 찾기</strong><small>먼저 필요한 항목부터 간결하게</small></div>
                    <div class="jwh4-option is-selected"><span>방향 B · 선택</span><strong>질문 흐름을 따라 탐색하기</strong><small>처음 온 고객의 판단 순서에 맞게</small></div>
                </div>
            </section>
            <section>
                <span class="jwh-step-number">03</span>
                <h3>사용할 장면까지 만듭니다.</h3>
                <p>합의한 방향을 실제 화면과 콘텐츠에 적용합니다. 보기 좋은 시안에 그치지 않고 필요한 정보를 찾을 수 있는지 확인합니다.</p>
                <dl>
                    <div>
                        <dt>함께 할 일</dt>
                        <dd>시안 제작 · 사용 흐름 검토</dd>
                    </div>
                    <div>
                        <dt>확인할 자료</dt>
                        <dd>화면 시안 · 수정 사항</dd>
                    </div>
                </dl>
                <div class="jwh4-artifact jwh4-artifact--prototype" aria-label="디지털 화면 시안">
                    <div class="jwh4-artifact__bar"><span>03 / WORKING PROTOTYPE</span><span>시연 자료</span></div>
                    <div class="jwh4-prototype__screen">
                        <div class="jwh4-prototype__nav"><b>FIELDNOTE</b><span>프로그램　 방문 안내</span></div>
                        <p>오늘의 경험을<br><strong>가까운 곳에서.</strong></p>
                        <div class="jwh4-prototype__tiles"><span>지금 볼 수 있는 프로그램 <b>↗</b></span><span>방문 전에 알아둘 내용 <b>↗</b></span></div>
                    </div>
                </div>
            </section>
            <section>
                <span class="jwh-step-number">04</span>
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
                <div class="jwh4-artifact jwh4-artifact--handoff" aria-label="운영 인수인계 목록 시안">
                    <div class="jwh4-artifact__bar"><span>04 / HANDOFF CHECK</span><span>시연 자료</span></div>
                    <ul><li><span>✓</span>수정할 수 있는 원본 전달</li><li><span>✓</span>담당자별 관리 항목 확인</li><li><span>✓</span>후속 점검 기준 합의</li></ul>
                </div>
            </section>
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
