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
                    <div class="jwh2-slide__image jwh2-slide__image--strategy" role="img" aria-label="의사결정 질문과 선택지를 한 장의 전략 자료로 정리한 시연 장면"></div>
                    <div class="jwh2-slide__shade" aria-hidden="true"></div>
                    <div class="jwh2-shell jwh2-slide__content">
                        <h1>무엇부터 바꿀지,<br>함께 결정합니다.</h1>
                        <p>사업의 문제를 현장의 언어로 다시 정의하고, 실행할 수 있는 우선순위와 방법을 만듭니다.</p>
                        <div class="jwh2-slide__actions">
                            <a class="jw-btn jw-btn--solid" href="<?php echo $service_url; ?>">컨설팅 살펴보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                            <span>비즈니스 컨설팅</span>
                        </div>
                    </div>
                </section>

                <section class="jwh2-slide" data-jwh2-slide aria-label="디지털 서비스" aria-hidden="true">
                    <div class="jwh2-slide__image jwh2-slide__image--digital" role="img" aria-label="제품 연구실에서 디지털 서비스 시제품을 검증하는 팀"></div>
                    <div class="jwh2-slide__shade" aria-hidden="true"></div>
                    <div class="jwh2-shell jwh2-slide__content">
                        <h2>화면이 아니라,<br>쓰이는 흐름을 만듭니다.</h2>
                        <p>고객이 망설이는 지점을 찾고, 검증 가능한 프로토타입과 운영 가능한 서비스로 연결합니다.</p>
                        <div class="jwh2-slide__actions">
                            <a class="jw-btn jw-btn--solid" href="<?php echo $solutions_url; ?>">디지털 솔루션 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                            <span>디지털 서비스</span>
                        </div>
                    </div>
                </section>

                <section class="jwh2-slide" data-jwh2-slide aria-label="서비스 운영" aria-hidden="true">
                    <div class="jwh2-slide__image jwh2-slide__image--operations" role="img" aria-label="고객 접점에서 태블릿으로 서비스 흐름을 개선하는 운영팀"></div>
                    <div class="jwh2-slide__shade" aria-hidden="true"></div>
                    <div class="jwh2-shell jwh2-slide__content">
                        <h2>현장에서 계속되는<br>경험을 설계합니다.</h2>
                        <p>좋은 기획이 문서에 머물지 않도록 기준, 도구, 운영 흐름을 실제 고객 접점에 정착시킵니다.</p>
                        <div class="jwh2-slide__actions">
                            <a class="jw-btn jw-btn--solid" href="<?php echo $contact_url; ?>">운영 과제 상담하기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                            <span>서비스 운영</span>
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
                    <span>방향이 흐릴 때</span>
                    <strong>사업의 우선순위를 다시 정합니다.</strong>
                    <p>시장·고객·조직의 신호를 모아 실행할 문제를 선명하게 만듭니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
                <a href="<?php echo $solutions_url; ?>">
                    <span>서비스가 멈출 때</span>
                    <strong>고객이 실제로 쓰는 흐름을 검증합니다.</strong>
                    <p>핵심 여정을 빠르게 시제품으로 만들고 행동 데이터로 판단합니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
                <a href="<?php echo $contact_url; ?>">
                    <span>실행이 이어지지 않을 때</span>
                    <strong>현장에 남는 운영 기준을 만듭니다.</strong>
                    <p>팀이 반복해서 사용할 기준과 도구를 일하는 흐름 안에 정착시킵니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="jwh2-result" aria-labelledby="jwh2-result-title">
        <div class="jwh2-shell jwh2-result__grid">
            <div class="jwh2-result__copy">
                <h2 id="jwh2-result-title">문서로 끝나지 않는<br>디지털 결과물</h2>
                <p>가설은 화면으로, 화면은 측정 가능한 운영 흐름으로 바꿉니다. 오른쪽은 서비스 개선 프로젝트에서 사용하는 결과물 구성을 재현한 예시입니다.</p>
                <dl>
                    <div><dt>발견</dt><dd>고객 여정과 병목 지점</dd></div>
                    <div><dt>검증</dt><dd>사용 가능한 프로토타입</dd></div>
                    <div><dt>운영</dt><dd>판단 지표와 실행 기준</dd></div>
                </dl>
                <a class="jw-text-link" href="<?php echo $solutions_url; ?>">솔루션 전체 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
            </div>

            <div class="jwh2-product" data-jw-digital-artifact aria-label="디지털 서비스 결과물 예시">
                <div class="jwh2-product__bar">
                    <span>Service Pulse</span>
                    <span>시연 데이터 · 실제 고객 실적이 아닙니다</span>
                </div>
                <div class="jwh2-product__body">
                    <div class="jwh2-product__summary">
                        <p>이번 주 핵심 신호</p>
                        <strong>첫 행동까지 걸린 시간</strong>
                        <div><b>2분 18초</b><span>지난주보다 24초 단축</span></div>
                    </div>
                    <div class="jwh2-product__chart" aria-label="최근 7일 개선 추세를 나타낸 예시 차트">
                        <span style="--value: 38%"></span><span style="--value: 51%"></span><span style="--value: 46%"></span><span style="--value: 64%"></span><span style="--value: 58%"></span><span style="--value: 76%"></span><span style="--value: 84%"></span>
                    </div>
                    <div class="jwh2-product__flow">
                        <div><span>고객 행동</span><strong>첫 방문</strong><b>100%</b></div>
                        <div><span>핵심 행동</span><strong>서비스 선택</strong><b>68%</b></div>
                        <div><span>완료 행동</span><strong>상담 요청</strong><b>41%</b></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="jwh2-method" aria-labelledby="jwh2-method-title">
        <div class="jwh2-shell">
            <div class="jwh2-method__head">
                <h2 id="jwh2-method-title">한 번의 제안보다,<br>이어지는 판단을 만듭니다.</h2>
                <p>질문을 좁히고 빠르게 확인한 뒤, 팀이 스스로 이어갈 수 있는 기준까지 남깁니다.</p>
            </div>
            <div class="jwh2-method__flow" aria-label="프로젝트 진행 방식">
                <div><strong>질문을 좁힙니다</strong><span>현장 인터뷰 · 데이터 확인</span></div>
                <i data-lucide="arrow-right" aria-hidden="true"></i>
                <div><strong>작게 검증합니다</strong><span>여정 설계 · 프로토타입</span></div>
                <i data-lucide="arrow-right" aria-hidden="true"></i>
                <div><strong>운영에 남깁니다</strong><span>측정 기준 · 실행 도구</span></div>
            </div>
        </div>
    </section>

    <section class="jwh2-close" aria-labelledby="jwh2-close-title">
        <div class="jwh2-shell jwh2-close__inner">
            <div>
                <h2 id="jwh2-close-title">지금 막힌 지점부터<br>함께 살펴보겠습니다.</h2>
                <p>정리되지 않은 문제도 괜찮습니다. 첫 대화에서 필요한 질문부터 함께 정리합니다.</p>
            </div>
            <div class="jwh2-close__actions">
                <a class="jw-btn jw-btn--solid" href="<?php echo $contact_url; ?>">프로젝트 문의 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                <a class="jw-text-link" href="<?php echo $overview_url; ?>">회사 소개 보기 <i data-lucide="arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>
</article>

<?php
require_once G5_THEME_PATH . '/tail.php';
?>
