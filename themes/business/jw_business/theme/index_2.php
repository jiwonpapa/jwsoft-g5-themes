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
                    <figcaption>판단 자료를 함께 검토하는 시연 장면 · AI 생성 이미지</figcaption>
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
        <div class="jwh2-shell">
            <div class="jwh2-matrix__heading">
                <h2 id="jwh2-matrix-title">급한 일과 중요한 일을<br>같은 자리에 놓습니다.</h2>
                <p>가상 서비스 개선 과제입니다. 기대 효과와 실행 부담을 함께 비교하면, 먼저 검증할 일이 보입니다.</p>
            </div>
            <div class="jwh2-matrix__body" role="img" aria-label="기대 효과가 높고 실행 부담이 낮은 서비스 탐색 개선을 먼저 검증합니다. 운영 시스템 교체는 장기 과제, 안내 문구 정리는 빠른 유지 관리, 전체 화면 재제작은 보류로 배치한 가상 우선순위 지도입니다.">
                <div class="jwh2-matrix__axis-head"><strong>기대 효과</strong><span>높음 ↑</span></div>
                <div class="jwh2-matrix__field">
                    <div class="jwh2-matrix__quadrant jwh2-matrix__quadrant--lead"><span class="jwh2-matrix__point">01</span><div><small>먼저 검증</small><strong>서비스 탐색 개선</strong><span>효과 ↑ · 부담 ↓</span></div></div>
                    <div class="jwh2-matrix__quadrant"><span class="jwh2-matrix__point">02</span><div><small>장기 과제</small><strong>운영 시스템 교체</strong><span>효과 ↑ · 준비 필요</span></div></div>
                    <div class="jwh2-matrix__quadrant"><span class="jwh2-matrix__point">03</span><div><small>빠른 정리</small><strong>안내 문구 정리</strong><span>작게 실행해 불편 축소</span></div></div>
                    <div class="jwh2-matrix__quadrant"><span class="jwh2-matrix__point">04</span><div><small>범위 재검토</small><strong>전체 화면 재제작</strong><span>문제 확인 뒤 결정</span></div></div>
                </div>
                <div class="jwh2-matrix__axis-foot"><span>낮음</span><strong>실행 부담</strong><span>높음 →</span></div>
            </div>
            <p class="jwh2-matrix__note">시연을 위한 판단 예시이며 실제 고객 프로젝트의 평가가 아닙니다.</p>
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
                    <div class="jwh2-product__chart" role="img" aria-label="최근 7일 개선 추세를 나타낸 예시 차트">
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

    <section class="jwh2-evidence" aria-labelledby="jwh2-evidence-title" data-jwh2-decision-evidence>
        <div class="jwh2-shell">
            <div class="jwh2-evidence__heading"><h2 id="jwh2-evidence-title">결정마다 남기는<br>확인 가능한 근거.</h2><p>같은 가상 과제에서 우선순위를 정할 때 쓰는 자료 형식입니다. 숫자는 실적이 아닌 작성 예시입니다.</p></div>
            <figure class="jwh2-evidence__photo"><img src="<?php echo G5_THEME_URL; ?>/assets/images/home2-evidence-retail.webp" width="1536" height="1024" alt="가상 리테일 서비스의 고객 질문 카드와 선택 화면 시안을 나란히 놓은 검토 자료" loading="lazy"><figcaption>가상 서비스 개선 자료 · AI 생성 이미지</figcaption></figure>
            <ol class="jwh2-evidence__decisions" aria-label="자료에서 다음 결정으로 이어지는 세 가지 예시">
                <li><i data-lucide="search" aria-hidden="true"></i><div><strong>처음 온 방문자의 질문</strong><p>문의 내용과 탐색 경로를 분류합니다.</p><span>자주 찾는 답부터 앞에 배치</span></div></li>
                <li><i data-lucide="git-compare-arrows" aria-hidden="true"></i><div><strong>서비스 선택 전 멈춤</strong><p>비교에 필요한 조건과 문구를 살펴봅니다.</p><span>설명 순서를 바꾼 시안 검증</span></div></li>
                <li><i data-lucide="clipboard-check" aria-hidden="true"></i><div><strong>상담 준비의 빈칸</strong><p>반복 질문과 필요한 자료를 확인합니다.</p><span>문의 전 준비 항목 정의</span></div></li>
            </ol>
        </div>
    </section>

<section class="jwh2-delivery"><div class="jwh2-shell"><div class="jwh2-evidence__heading"><h2>담당자가 이어 쓸<br>결과물까지.</h2><p>판단의 근거와 운영 기준을 한 세트로 남깁니다. 문서 제목만이 아닌 자료의 구성을 함께 보여 드립니다.</p></div><div class="jwh2-delivery-board" data-jwh2-delivery-board><article><i data-lucide="compass" aria-hidden="true"></i><h3>의사결정 지도</h3><div class="jwh2-mini-matrix" aria-hidden="true"><span>먼저 검증</span><span>준비 후 실행</span><span>빠른 정리</span><span>범위 재검토</span></div><p>효과와 부담을 비교하는 기준</p></article><article><i data-lucide="monitor" aria-hidden="true"></i><h3>서비스 시안</h3><div class="jwh2-mini-screen" aria-hidden="true"><b>서비스 찾기</b><span>현재 상황 → 서비스 범위</span><span>사례 확인 → 상담 준비</span></div><p>검토 가능한 화면과 정보 구조</p></article><article><i data-lucide="shield-check" aria-hidden="true"></i><h3>운영 점검표</h3><ul><li>담당자와 수정 범위</li><li>콘텐츠의 작성 기준</li><li>공개 전 확인 항목</li></ul><p>다음 작업에도 남는 실행 기준</p></article></div></div></section>
    <section class="jwh2-method" aria-labelledby="jwh2-method-title">
        <div class="jwh2-shell">
            <div class="jwh2-method__head">
                <h2 id="jwh2-method-title">한 번의 제안보다,<br>이어지는 판단을 만듭니다.</h2>
                <p>질문을 좁히고 빠르게 확인한 뒤, 팀이 스스로 이어갈 수 있는 기준까지 남깁니다.</p>
            </div>
            <div class="jwh2-method__scene"><figure><img src="<?php echo G5_THEME_URL; ?>/assets/images/home2-strategy.webp" width="1536" height="1024" alt="가상 팀이 조사 자료를 펼쳐 놓고 우선순위를 함께 검토하는 장면" loading="lazy"><figcaption>판단을 함께 만드는 과정 · 시연 이미지</figcaption></figure><ol aria-label="프로젝트 진행 방식"><li><b>01</b><div><strong>질문을 좁힙니다</strong><span>현장 인터뷰 · 데이터 확인</span></div></li><li><b>02</b><div><strong>작게 검증합니다</strong><span>여정 설계 · 프로토타입</span></div></li><li><b>03</b><div><strong>운영에 남깁니다</strong><span>측정 기준 · 실행 도구</span></div></li></ol></div>
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
