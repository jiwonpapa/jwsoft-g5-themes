<?php
/**
 * Theme: JW-Business 1.0
 * File: index_2.php
 * Role: 사업 탐색형 메인 홈 완성 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) {
    include_once dirname(__DIR__, 2).'/common.php';
}

$g5['title'] = $config['cf_title'];
require_once G5_THEME_PATH . '/head.php';

$overview_url = jw_business_page_url('company-overview-1');
$service_url = jw_business_page_url('business-detail-1');
$solutions_url = jw_business_page_url('business-detail-2');
$contact_url = jw_business_page_url('contact-1');
?>

<article class="jwh jwh--business jwh2" data-jw-home="2">
    <section class="jwh2-hero" data-jw-home2-slider aria-label="JW Business 주요 사업">
        <div class="jwh2-hero__viewport" data-jwh2-viewport tabindex="0">
            <div class="jwh2-hero__track" data-jwh2-track>
                <section class="jwh2-slide is-active" data-jwh2-slide aria-label="비즈니스 컨설팅">
                    <div class="jwh2-slide__image jwh2-slide__image--strategy" role="img" aria-label="팀이 고객의 경험을 함께 살피는 전략 워크숍 장면"></div>

                    <div class="jwh2-shell jwh2-slide__content">
                        <span class="jwh2-slide__eyebrow">DECISION REVIEW / 비즈니스 컨설팅</span>
                        <h1>무엇부터 바꿀지,<br>함께 결정합니다.</h1>
                        <p>사업의 문제를 현장의 언어로 다시 정의하고, 실행할 수 있는 우선순위와 방법을 만듭니다.</p>
                        <div class="jwh2-slide__actions">
                            <a class="jw-btn jw-btn--solid" href="<?php echo $service_url; ?>">컨설팅 살펴보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                            <span>문제 정의 → 선택 기준</span>
                        </div>
                    </div>
                </section>

                <section class="jwh2-slide" data-jwh2-slide aria-label="디지털 서비스" aria-hidden="true">
                    <div class="jwh2-slide__image jwh2-slide__image--digital" role="img" aria-label="제품 연구실에서 디지털 서비스 시제품을 검증하는 팀"></div>

                    <div class="jwh2-shell jwh2-slide__content">
                        <span class="jwh2-slide__eyebrow">SERVICE PROTOTYPE / 디지털 서비스</span>
                        <h2>화면이 아니라,<br>쓰이는 흐름을 만듭니다.</h2>
                        <p>고객이 망설이는 지점을 찾고, 검증 가능한 프로토타입과 운영 가능한 서비스로 연결합니다.</p>
                        <div class="jwh2-slide__actions">
                            <a class="jw-btn jw-btn--solid" href="<?php echo $solutions_url; ?>">디지털 솔루션 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                            <span>사용자 여정 → 검증 화면</span>
                        </div>
                    </div>
                </section>

                <section class="jwh2-slide" data-jwh2-slide aria-label="서비스 운영" aria-hidden="true">
                    <div class="jwh2-slide__image jwh2-slide__image--operations" role="img" aria-label="고객 접점에서 태블릿으로 서비스 흐름을 개선하는 운영팀"></div>

                    <div class="jwh2-shell jwh2-slide__content">
                        <span class="jwh2-slide__eyebrow">OPERATING STANDARD / 서비스 운영</span>
                        <h2>현장에서 계속되는<br>경험을 설계합니다.</h2>
                        <p>좋은 기획이 문서에 머물지 않도록 기준, 도구, 운영 흐름을 실제 고객 접점에 정착시킵니다.</p>
                        <div class="jwh2-slide__actions">
                            <a class="jw-btn jw-btn--solid" href="<?php echo $contact_url; ?>">운영 과제 상담하기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                            <span>담당자 → 실행 기준</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="jwh2-hero__nav-wrap">
            <div class="jwh2-shell jwh2-hero__nav">
                <div class="jwh2-hero__tabs" role="group" aria-label="주요 사업 선택">
                    <button type="button" class="is-active" data-jwh2-dot="0" aria-pressed="true">컨설팅</button>
                    <button type="button" data-jwh2-dot="1" aria-pressed="false">디지털</button>
                    <button type="button" data-jwh2-dot="2" aria-pressed="false">운영</button>
                </div>
                <div class="jwh2-hero__controls">
                    <button type="button" data-jwh2-prev aria-label="이전 슬라이드"><i data-lucide="arrow-left" aria-hidden="true"></i></button>
                    <p aria-live="polite"><strong data-jwh2-current>01</strong><span>/ 03</span></p>
                    <button type="button" data-jwh2-next aria-label="다음 슬라이드"><i data-lucide="arrow-right" aria-hidden="true"></i></button>
                    <button type="button" class="jwh2-hero__play" data-jwh2-play aria-label="슬라이드 자동 전환 멈춤">멈춤</button>
                </div>
            </div>
        </div>
    </section>

    <section class="jwh2-choices" aria-labelledby="jwh2-choices-title">
        <div class="jwh2-shell jwh2-choices__grid">
            <div class="jwh2-choices__intro">
                <h2 id="jwh2-choices-title">지금 필요한<br>시작점을 고르세요.</h2>
                <p>정답을 미리 정하지 않습니다. 현재 막힌 지점에서 시작해 다음 의사결정에 필요한 근거를 만듭니다.</p>
            </div>
            <div class="jwh2-choices__list">
                <a href="<?php echo $service_url; ?>">
                    <span class="jwh2-choice-icon"><i data-lucide="compass" aria-hidden="true"></i></span><span>방향이 흐릴 때</span>
                    <strong>사업의 우선순위를 정합니다.</strong>
                    <p>시장·고객·조직의 신호를 모아 실행할 문제를 선명하게 만듭니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
                <a href="<?php echo $solutions_url; ?>">
                    <span class="jwh2-choice-icon"><i data-lucide="monitor" aria-hidden="true"></i></span><span>서비스가 멈출 때</span>
                    <strong>고객의 흐름을 검증합니다.</strong>
                    <p>핵심 여정을 빠르게 시제품으로 만들고 행동 데이터로 판단합니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
                <a href="<?php echo $contact_url; ?>">
                    <span class="jwh2-choice-icon"><i data-lucide="target" aria-hidden="true"></i></span><span>실행이 이어지지 않을 때</span>
                    <strong>현장의 운영 기준을 만듭니다.</strong>
                    <p>팀이 반복해서 사용할 기준과 도구를 일하는 흐름 안에 정착시킵니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="jwh2-journey" aria-labelledby="jwh2-journey-title">
        <div class="jwh2-shell jwh2-journey__layout">
            <div class="jwh2-journey__story">
                <h2 id="jwh2-journey-title">회의실의 의견을<br>확인할 장면으로.</h2>
                <p>가상의 서비스 개선 과제에서, 추상적인 의견 대신 고객이 실제로 지나가는 세 순간을 살펴봅니다.</p>
                <figure>
                    <img src="<?php echo G5_THEME_URL; ?>/assets/images/home2-decision-workshop.webp" width="1536" height="1024" alt="가상 전략 워크숍에서 고객 여정 자료와 선택지를 놓고 검토하는 장면" loading="lazy">
                    <figcaption>판단 자료를 함께 검토하는 시연 장면 · AI 생성 이미지. 실제 고객 실적이나 성과를 뜻하지 않습니다.</figcaption>
                </figure>
            </div>
            <div class="jwh2-journey-map" data-jwh2-journey-map>
                <div class="jwh2-journey-map__head"><strong>살펴볼 고객의 순간</strong><span>가상 고객 여정</span></div>
                <ol>
                    <li><i data-lucide="search" aria-hidden="true"></i><div><b>첫 방문</b><span>찾는 답이 첫 화면에 있는가</span></div></li>
                    <li><i data-lucide="files" aria-hidden="true"></i><div><b>비교</b><span>서비스의 차이를 읽을 수 있는가</span></div></li>
                    <li><i data-lucide="message-circle" aria-hidden="true"></i><div><b>문의 준비</b><span>무엇을 보내야 할지 아는가</span></div></li>
                </ol>
                <p class="jwh2-journey-map__conclusion">이 세 장면에서 확인한 질문을 다음 우선순위 판단에 사용합니다.</p>
            </div>
        </div>
    </section>
    <section class="jwh2-matrix" aria-labelledby="jwh2-matrix-title" data-jwh2-decision-matrix>
      <div class="jwh2-shell jwh2-focus">
        <div class="jwh2-focus__copy"><h2 id="jwh2-matrix-title">지금 가장 중요한<br>한 장면부터.</h2><p>전체를 한 번에 바꾸기 전에 고객이 멈추는 순간을 찾습니다. 작은 변화로 방향을 확인할 수 있습니다.</p><div class="jwh2-focus__points"><span><i data-lucide="scan-eye" aria-hidden="true"></i>고객이 처음 보는 것</span><span><i data-lucide="mouse-pointer-2" aria-hidden="true"></i>선택을 망설이는 곳</span><span><i data-lucide="circle-check" aria-hidden="true"></i>먼저 시험할 변화</span></div></div>
        <figure class="jwh2-focus__photo" data-jwh2-decision-evidence><img src="<?php echo G5_THEME_URL; ?>/assets/images/home2-evidence-retail.webp" width="1536" height="1024" alt="고객 경험을 함께 살피는 카드와 화면 자료" loading="lazy"><figcaption>가상 서비스 개선을 위한 시연 장면 · AI 생성 이미지</figcaption></figure>
      </div>
    </section>

    <section class="jwh2-result" aria-labelledby="jwh2-result-title">
      <div class="jwh2-shell jwh2-result__grid"><div class="jwh2-result__copy"><h2 id="jwh2-result-title">고객의 다음 선택이<br>보이는 화면.</h2><p>핵심 정보를 먼저 보여주면 복잡한 설명 없이도 자신에게 맞는 출발점을 찾을 수 있습니다.</p><a class="jw-text-link" href="<?php echo $solutions_url; ?>">디지털 서비스 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div>
        <figure class="jwh2-result-scene" data-jw-digital-artifact><img src="<?php echo G5_THEME_URL; ?>/assets/images/home2-strategy.webp" width="1672" height="941" alt="서비스의 다음 선택을 함께 검토하는 팀" loading="lazy"><figcaption><span>ORBIT / SERVICE EXPERIENCE</span><strong>필요한 도움을<br>쉽게 발견하도록.</strong></figcaption></figure>
      </div>
    </section>


    <section class="jwh2-delivery" aria-labelledby="jwh2-delivery-title"><div class="jwh2-shell">
      <div class="jwh2-section-heading"><h2 id="jwh2-delivery-title">다음 사람이 이어갈 수 있는<br>결과를 남깁니다.</h2><p>선택한 방향을 화면과 현장에 적용할 수 있도록 정리합니다.</p></div>
      <div class="jwh2-delivery-board jwh2-delivery-cards" data-jwh2-delivery-board>
        <article><i data-lucide="compass" aria-hidden="true"></i><h3>방향</h3><p>고객에게 무엇을 먼저 전할지.</p></article>
        <article><i data-lucide="monitor-smartphone" aria-hidden="true"></i><h3>화면</h3><p>실제로 읽고 선택하는 순서.</p></article>
        <article><i data-lucide="handshake" aria-hidden="true"></i><h3>운영</h3><p>팀이 일관되게 이어갈 기준.</p></article>
      </div>
    </div></section>

    <section class="jwh2-method" aria-labelledby="jwh2-method-title"><div class="jwh2-shell">
        <div class="jwh2-section-heading"><h2 id="jwh2-method-title">한 번의 제안보다,<br>이어지는 판단을 만듭니다.</h2><p>각 단계의 질문과 확인할 자료를 함께 정합니다. 다음 단계는 앞선 판단을 바탕으로 이어집니다.</p></div>
        <ol class="jwh2-method__journal" aria-label="프로젝트 진행 방식"><li><span class="jwh2-method__number">01</span><div><i data-lucide="search" aria-hidden="true"></i><h3>질문을 좁힙니다</h3><p>현재 서비스와 고객의 말을 함께 살펴보고, 이번에 확인할 문제를 정합니다.</p></div><dl><div><dt>살펴볼 것</dt><dd>현재 화면 · 반복 문의 · 팀의 질문</dd></div><div><dt>남기는 것</dt><dd>관찰 기록과 검증할 질문</dd></div></dl></li><li><span class="jwh2-method__number">02</span><div><i data-lucide="monitor" aria-hidden="true"></i><h3>작게 검증합니다</h3><p>전체를 바꾸기 전에 선택한 장면을 시안으로 만들고, 같은 질문으로 비교합니다.</p></div><dl><div><dt>살펴볼 것</dt><dd>비교 시안 · 이해한 내용 · 멈춘 지점</dd></div><div><dt>남기는 것</dt><dd>화면 명세와 다음 판단</dd></div></dl></li><li><span class="jwh2-method__number">03</span><div><i data-lucide="shield-check" aria-hidden="true"></i><h3>운영에 남깁니다</h3><p>선택의 이유와 수정 기준을 담당자에게 전하고, 다음 점검 시점을 합의합니다.</p></div><dl><div><dt>살펴볼 것</dt><dd>담당 역할 · 수정 범위 · 검토 절차</dd></div><div><dt>남기는 것</dt><dd>운영 도서와 공개 전 점검표</dd></div></dl></li></ol>
    </div></section>

    <section class="jwh2-close" aria-labelledby="jwh2-close-title">
        <div class="jwh2-shell jwh2-close__inner">
            <div>
                <h2 id="jwh2-close-title">지금 막힌 지점부터<br>함께 살펴보겠습니다.</h2>
                <p>정리되지 않은 문제도 괜찮습니다. 첫 대화에서 필요한 질문부터 함께 정리합니다.</p>
            </div>
            <div class="jwh2-close__brief"><span class="jwh2-kicker">첫 대화를 위한 작은 브리프</span><ol><li><b>현재의 장면</b><span>어떤 고객이 무엇을 하려고 하나요?</span></li><li><b>막힌 지점</b><span>어디에서 설명이나 선택이 어려운가요?</span></li><li><b>다음 결정</b><span>이번에 무엇을 확인하고 싶으신가요?</span></li></ol><div class="jwh2-close__actions">
                <a class="jw-btn jw-btn--solid" href="<?php echo $contact_url; ?>">프로젝트 문의 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                <a class="jw-text-link" href="<?php echo $overview_url; ?>">회사 소개 보기 <i data-lucide="arrow-right" aria-hidden="true"></i></a>
            </div></div>
        </div>
    </section>
</article>

<?php
require_once G5_THEME_PATH . '/tail.php';
?>
