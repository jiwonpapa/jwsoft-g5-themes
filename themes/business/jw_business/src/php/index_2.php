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
                    <div class="jwh2-slide__image jwh2-slide__image--strategy" role="img" aria-label="가상 ORBIT의 고객 관찰 사진, 서비스 여정, 선택지 비교와 판단 근거가 함께 편집된 완성 의사결정 보드"></div>

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
    <section class="jwh2-matrix" aria-labelledby="jwh2-matrix-title" data-jwh2-decision-matrix data-jwh2-priority-scroll data-priority-step="0">
        <div class="jwh2-shell">
            <div class="jwh2-section-heading"><div><span class="jwh2-kicker">ORBIT / DECISION NOTE 04</span><h2 id="jwh2-matrix-title">급한 일과 중요한 일을<br>같은 자리에 놓습니다.</h2></div><p>가상 서비스 개선 과제입니다. 고객의 불편, 기대 효과, 실행에 필요한 준비를 비교해 먼저 확인할 일을 고릅니다.</p></div>
            <div class="jwh2-matrix__steps" aria-label="판단 순서"><button type="button" data-priority-label="0" aria-pressed="true" aria-controls="jwh2-priority-detail-0">01 관찰을 모으고</button><button type="button" data-priority-label="1" aria-pressed="false" aria-controls="jwh2-priority-detail-1">02 조건을 비교한 뒤</button><button type="button" data-priority-label="2" aria-pressed="false" aria-controls="jwh2-priority-detail-2">03 먼저 검증할 일 선택</button></div>
            <div class="jwh2-matrix__layout">
                <div class="jwh2-priority-study" aria-label="고객 질문과 과제의 연결, 착수에 필요한 조건을 함께 비교한 가상 판단 자료">
  <div class="jwh2-study-title"><strong>질문과 과제를 연결해 봅니다.</strong><span>고객 여정 3장면 · 정성 비교</span></div>
  <div class="jwh2-study-evidence"><div><b>E1 / 첫 방문</b><p>“내 일과 어떻게<br>연결되나요?”</p></div><div><b>E2 / 비교 중</b><p>“두 서비스는<br>무엇이 다른가요?”</p></div><div><b>E3 / 문의 준비</b><p>“어떤 자료를<br>먼저 보내나요?”</p></div></div>
  <div class="jwh2-evidence-map"><svg xmlns="http://www.w3.org/2000/svg" class="priority-map priority-map--desktop" viewBox="0 0 680 495" role="img" aria-label="세로 기대 효과, 가로 실행 부담. 서비스 탐색은 세 고객 질문에 연결되어 기존 콘텐츠로 먼저 검증합니다. 문구 정리는 보조 작업이며 시스템 교체와 전체 재제작에는 운영과 범위 조사가 선행합니다."><defs><marker id="priority-arrow" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="5" markerHeight="5" orient="auto"><path d="M1 1L9 5L1 9" fill="none" stroke="var(--jw-link-ink)" stroke-width="1.7"/></marker></defs><text x="0" y="16" class="body">기대 효과</text><text x="621" y="16" class="small">높음 ↑</text><rect x="0" y="37" width="680" height="417" class="paper"/><rect x="0" y="37" width="340" height="205" class="chosen priority-first"/><path d="M340 37V454M0 242H680" class="rule"/><circle cx="36" cy="75" r="14" class="dot"/><text x="28" y="79" class="label on">01</text><text x="61" y="80" class="strong">서비스 탐색 개선</text><text x="18" y="107" class="small ink">E1 + E2 + E3 → 세 선택 질문을 함께</text><path d="M36 90V130H67" class="line"/><rect x="74" y="127" width="244" height="76" class="soft"/><text x="86" y="146" class="label ink">서비스 비교 지면</text><text x="86" y="169" class="small">방향 정하기</text><text x="197" y="169" class="small">관찰 → 판단</text><text x="86" y="192" class="small">경험 바꾸기</text><text x="197" y="192" class="small">화면 → 시안</text><text x="74" y="225" class="small">기존 콘텐츠 → 비교 시안으로 검증</text><circle cx="378" cy="94" r="14" class="dot"/><text x="370" y="98" class="label on">02</text><text x="403" y="99" class="strong">운영 시스템 교체</text><text x="362" y="126" class="small muted">운영 자료를 먼저 확인해야 함</text><rect x="367" y="150" width="73" height="36" class="soft"/><rect x="470" y="150" width="73" height="36" class="soft"/><rect x="573" y="150" width="85" height="36" class="soft"/><text x="387" y="173" class="body">도구</text><text x="490" y="173" class="body">권한</text><text x="597" y="173" class="body">교육</text><path d="M442 168H466" class="line" marker-end="url(#priority-arrow)"/><path d="M545 168H569" class="line" marker-end="url(#priority-arrow)"/><text x="366" y="222" class="small">도구 목록·권한 구조·교육 범위가 선행</text><circle cx="36" cy="291" r="14" class="dot"/><text x="28" y="295" class="label on">03</text><text x="61" y="296" class="strong">안내 문구 정리</text><text x="18" y="323" class="small ink">E1 + E3 / 설명을 빠르게 정리</text><rect x="19" y="346" width="117" height="34" class="soft"/><text x="33" y="368" class="small muted">자세히 보기</text><path d="M30 364H123" class="rule"/><path d="M142 363H169" class="line" marker-end="url(#priority-arrow)"/><rect x="177" y="346" width="144" height="34" class="chosen"/><text x="191" y="368" class="small ink">내 상황과 비교</text><text x="19" y="411" class="small">문장은 바뀌지만 선택 구조는 유지</text><text x="19" y="434" class="label ink">01과 함께 정리할 보조 작업</text><path d="M10 107V267" class="scope"/><circle cx="378" cy="316" r="14" class="dot"/><text x="370" y="320" class="label on">04</text><text x="403" y="321" class="strong">전체 화면 재제작</text><text x="361" y="347" class="small muted">전체 접점을 바꾸기 전 범위 확인</text><rect x="362" y="375" width="83" height="34" class="soft"/><rect x="467" y="375" width="83" height="34" class="soft"/><rect x="572" y="375" width="88" height="34" class="soft"/><text x="386" y="397" class="body">탐색</text><text x="491" y="397" class="body">사례</text><text x="597" y="397" class="body">문의</text><path d="M403 369V363H617V369M508 353V363" class="scope"/><text x="362" y="434" class="small">넓은 변경 범위 → 근거 보강 필요</text><text x="0" y="481" class="small">낮음</text><text x="465" y="481" class="body">실행 부담</text><text x="621" y="481" class="small">높음 →</text></svg><svg xmlns="http://www.w3.org/2000/svg" class="priority-map priority-map--mobile" viewBox="0 0 360 540" role="img" aria-label="세로 기대 효과, 가로 실행 부담. 서비스 탐색은 세 고객 질문에 연결되어 기존 콘텐츠로 먼저 검증합니다. 문구 정리는 보조 작업이며 시스템 교체와 전체 재제작에는 운영과 범위 조사가 선행합니다."><defs><marker id="priority-arrow-mobile" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="5" markerHeight="5" orient="auto"><path d="M1 1L9 5L1 9" fill="none" stroke="var(--jw-link-ink)" stroke-width="1.7"/></marker></defs><text x="0" y="16" class="body">기대 효과</text><text x="303" y="16" class="small">높음 ↑</text><rect x="0" y="36" width="360" height="462" class="paper"/><rect x="0" y="36" width="180" height="212" class="chosen priority-first"/><path d="M180 36V498M0 248H360" class="rule"/><circle cx="20" cy="71" r="14" class="dot"/><text x="12" y="75" class="label on">01</text><text x="42" y="76" class="body">서비스 탐색</text><text x="15" y="103" class="small ink">E1 + E2 + E3</text><rect x="17" y="120" width="148" height="84" class="soft"/><text x="27" y="142" class="small">방향 정하기</text><text x="27" y="159" class="small muted">관찰 → 판단</text><text x="27" y="182" class="small">경험 바꾸기</text><text x="27" y="199" class="small muted">화면 → 시안</text><text x="16" y="229" class="small ink">기존 콘텐츠로 검증</text><path d="M7 92V116H16" class="line"/><circle cx="200" cy="94" r="14" class="dot"/><text x="192" y="98" class="label on">02</text><text x="222" y="99" class="body">시스템 교체</text><rect x="197" y="127" width="58" height="29" class="soft"/><rect x="285" y="127" width="59" height="29" class="soft"/><text x="213" y="147" class="small">도구</text><text x="300" y="147" class="small">권한</text><path d="M257 141H279" class="line" marker-end="url(#priority-arrow-mobile)"/><rect x="285" y="185" width="59" height="29" class="soft"/><text x="300" y="205" class="small">교육</text><path d="M315 159V180" class="line" marker-end="url(#priority-arrow-mobile)"/><text x="197" y="229" class="small muted">운영 조사부터</text><circle cx="20" cy="293" r="14" class="dot"/><text x="12" y="297" class="label on">03</text><text x="42" y="298" class="body">안내 문구</text><text x="15" y="323" class="small ink">E1 + E3 / 빠른 정리</text><rect x="15" y="342" width="147" height="30" class="soft"/><text x="30" y="362" class="small muted">자세히 보기</text><path d="M28 358H126" class="rule"/><path d="M88 375V394" class="line" marker-end="url(#priority-arrow-mobile)"/><rect x="15" y="401" width="147" height="32" class="chosen"/><text x="29" y="422" class="small ink">내 상황과 비교</text><text x="15" y="457" class="small">구조 변화는 제한적</text><text x="15" y="479" class="small ink">01과 함께 정리</text><path d="M6 231V269" class="scope"/><circle cx="200" cy="316" r="14" class="dot"/><text x="192" y="320" class="label on">04</text><text x="222" y="321" class="body">전체 재제작</text><text x="194" y="348" class="small muted">전체 접점 변경</text><rect x="197" y="374" width="44" height="29" class="soft"/><rect x="250" y="374" width="44" height="29" class="soft"/><rect x="303" y="374" width="44" height="29" class="soft"/><text x="207" y="394" class="small">탐색</text><text x="260" y="394" class="small">사례</text><text x="313" y="394" class="small">문의</text><path d="M219 369V360H325V369M272 353V360" class="scope"/><text x="194" y="449" class="small">넓은 범위 확인</text><text x="194" y="479" class="small ink">추가 근거가 필요</text><text x="0" y="525" class="small">낮음</text><text x="216" y="525" class="body">실행 부담</text><text x="303" y="525" class="small">높음 →</text></svg></div>
  <div class="jwh2-study-output"><div class="jwh2-study-output__lead"><span>01</span><strong>기존 콘텐츠로 먼저 검증할 두 지면</strong><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v17m-6-6 6 6 6-6"/></svg></div><div class="jwh2-study-specimens">
  <figure><figcaption><b>ORBIT</b><span>서비스 비교</span></figcaption><h4>어디에서 시작할까요?</h4><div class="jwh2-study-service"><b>방향 정하기</b><span>관찰 자료 → 판단 기준</span></div><div class="jwh2-study-service"><b>경험 바꾸기</b><span>현재 화면 → 비교 시안</span></div><p>함께 정할 것과 남는 자료를 같은 위치에서 비교합니다.</p></figure>
  <figure><figcaption><b>ORBIT</b><span>문의 준비</span></figcaption><h4>첫 대화에 필요한 것</h4><dl><div><dt>현재 자료</dt><dd>웹사이트 · 소개서 주소</dd></div><div><dt>막힌 장면</dt><dd>고객이 어려워하는 선택</dd></div><div><dt>다음 결정</dt><dd>이번에 확인하려는 질문</dd></div></dl><p>별도 시스템 교체 없이 문의 준비 흐름을 시험합니다.</p></figure>
  </div></div>
</div>

                <aside class="jwh2-decision-note" aria-label="관찰에서 선택으로 이어지는 판단 자료">
                    <article id="jwh2-priority-detail-0" data-priority-detail="0"><span class="jwh2-kicker">FIELD NOTES / 관찰</span><h3>세 장면에서<br>같은 질문이 나왔습니다.</h3><div class="jwh2-observation"><span>첫 방문</span><blockquote>“서비스 이름은 알겠는데,<br>제 일과 어떻게 연결되나요?”</blockquote><span>비교 중</span><blockquote>“두 서비스의 차이를<br>어디에서 확인하나요?”</blockquote><span>문의 준비</span><blockquote>“어떤 자료를<br>먼저 보내면 좋을까요?”</blockquote></div><p>시연용 가상 고객 질문 · 실제 인터뷰 인용이 아닙니다.</p></article>
                    <article id="jwh2-priority-detail-1" data-priority-detail="1"><span class="jwh2-kicker">OPTIONS REVIEW / 비교</span><h3>효과와 준비를<br>함께 비교합니다.</h3><div class="jwh2-option-table"><div><b>과제</b><b>기대 효과</b><b>실행 부담</b></div><div class="is-selected"><strong>01 탐색 개선</strong><span>높음</span><span>낮음</span></div><div><strong>02 시스템 교체</strong><span>높음</span><span>높음</span></div><div><strong>03 문구 정리</strong><span>제한적</span><span>낮음</span></div><div><strong>04 전체 재제작</strong><span>확인 필요</span><span>높음</span></div></div><p>기존 자료로 확인할 수 있는 범위를 먼저 고릅니다. 가상의 정성 비교입니다.</p></article>
                    <article id="jwh2-priority-detail-2" data-priority-detail="2"><span class="jwh2-kicker">NEXT EXPERIMENT / 선택</span><h3>선택의 기준을<br>앞에서 보여주기</h3><div class="jwh2-selected-task"><span>01</span><div><strong>서비스 탐색 개선</strong><small>먼저 검증할 과제</small></div><i data-lucide="arrow-down" aria-hidden="true"></i></div><dl><div><dt>선택한 이유</dt><dd>기존 콘텐츠로 비교 순서를 바꿔볼 수 있고, 전체 재제작 전에 확인할 수 있습니다.</dd></div><div><dt>다음 검증</dt><dd>같은 질문으로 두 시안을 살펴보고, 차이를 설명할 수 있는지 확인합니다.</dd></div></dl><p>이 판단을 다음 디지털 화면 시안으로 옮깁니다.</p></article>
                </aside>
            </div>
            <div class="jwh2-matrix__ledger"><div><b>함께 정한 범위</b><span>서비스 비교와 문의 준비 화면</span></div><div><b>지금 바꾸지 않는 것</b><span>운영 시스템과 전체 사이트 구조</span></div><div><b>다시 판단할 시점</b><span>고객이 시안을 읽고 선택한 뒤</span></div></div>
        </div>
    </section>

    <section class="jwh2-result" aria-labelledby="jwh2-result-title">
        <div class="jwh2-shell jwh2-result__grid">
            <div class="jwh2-result__copy">
                <h2 id="jwh2-result-title">문서로 끝나지 않는<br>디지털 결과물</h2>
                <p>가설은 고객이 직접 읽고 선택할 수 있는 화면으로 옮깁니다. 가상 브랜드 ORBIT의 서비스 탐색 시안에서, 준비된 자료와 필요한 결과를 나란히 비교합니다.</p>
                <dl>
                    <div><dt>발견</dt><dd>고객 여정과 병목 지점</dd></div>
                    <div><dt>검증</dt><dd>사용 가능한 프로토타입</dd></div>
                    <div><dt>운영</dt><dd>판단 지표와 실행 기준</dd></div>
                </dl>
                <a class="jw-text-link" href="<?php echo $solutions_url; ?>">솔루션 전체 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
            </div>

            <div class="jwh2-product" data-jw-digital-artifact aria-label="가상 ORBIT 서비스 비교 화면 시안">
                <div class="jwh2-product__bar"><strong>ORBIT<span>일의 다음 방향</span></strong><span>서비스　사례　이야기</span><b>상담 준비 ↗</b></div>
                <div class="jwh2-explorer">
                    <aside class="jwh2-explorer__aside"><small>서비스 탐색</small><strong>지금의 과제</strong><span class="is-selected"><i data-lucide="compass" aria-hidden="true"></i> 방향 정하기</span><span><i data-lucide="monitor" aria-hidden="true"></i> 경험 바꾸기</span><span><i data-lucide="shield-check" aria-hidden="true"></i> 운영 이어가기</span><p>이름보다 해결할 일에서<br>시작합니다.</p></aside>
                    <div class="jwh2-explorer__main"><div class="jwh2-explorer__path">서비스 / 방향 정하기</div><h3>우리에게 맞는<br>시작을 비교해 보세요.</h3><p>필요한 근거와 준비된 자료에 따라 함께할 범위를 고릅니다.</p>
                        <figure class="jwh2-explorer__feature"><img src="<?php echo G5_THEME_URL; ?>/assets/images/home2-strategy.webp" width="1672" height="941" alt="고객 관찰 자료를 함께 살펴보는 가상 컨설팅 팀" loading="lazy"><figcaption><span>BUSINESS DISCOVERY</span><strong>문제의 이름부터,<br>함께 찾는 과정</strong></figcaption></figure>
                        <div class="jwh2-explorer__comparison" role="table" aria-label="서비스 범위 시안"><div role="row"><b role="columnheader">함께할 일</b><b role="columnheader">남는 자료</b></div><div role="row"><span role="cell"><strong>문제 발견</strong>인터뷰 · 현황 정리</span><span role="cell">고객 질문 지도<br>우선 확인 과제</span></div><div role="row" class="is-selected"><span role="cell"><strong>서비스 방향</strong>선택 조건 · 화면 검토</span><span role="cell">비교 시안<br>판단 기준서</span></div></div>
                        <div class="jwh2-explorer__next"><span>상담 전에<br><b>현재 자료와 막힌 장면을 준비해 주세요.</b></span><i data-lucide="arrow-up-right" aria-hidden="true"></i></div>
                    </div>
                </div>
                <p class="jwh2-product__disclosure">가상 브랜드의 화면 디자인 시안입니다. 화면 안의 메뉴는 시연 이미지 요소입니다.</p>
            </div>
        </div>
    </section>

    <section class="jwh2-evidence" aria-labelledby="jwh2-evidence-title" data-jwh2-decision-evidence>
        <div class="jwh2-shell">
            <div class="jwh2-evidence__heading"><h2 id="jwh2-evidence-title">결정마다 남기는<br>확인 가능한 근거.</h2><p>같은 가상 과제에서 우선순위를 정할 때 쓰는 자료 형식입니다. 숫자는 실적이 아닌 작성 예시입니다.</p></div>
            <figure class="jwh2-evidence__photo"><img src="<?php echo G5_THEME_URL; ?>/assets/images/home2-evidence-retail.webp" width="1536" height="1024" alt="가상 리테일 서비스의 고객 질문 카드와 선택 화면 시안을 나란히 놓은 검토 자료" loading="lazy"><figcaption>가상 서비스 개선 자료 · AI 생성 이미지</figcaption></figure>
            <ol class="jwh2-evidence__decisions" aria-label="자료에서 다음 결정으로 이어지는 세 가지 예시">
                <li><i data-lucide="search" aria-hidden="true"></i><div><strong>처음 온 방문자의 질문</strong><p>문의 내용과 탐색 경로를 분류합니다.</p><span>자주 찾는 답부터 앞에 배치</span></div></li>
                <li><i data-lucide="files" aria-hidden="true"></i><div><strong>서비스 선택 전 멈춤</strong><p>비교에 필요한 조건과 문구를 살펴봅니다.</p><span>설명 순서를 바꾼 시안 검증</span></div></li>
                <li><i data-lucide="shield-check" aria-hidden="true"></i><div><strong>상담 준비의 빈칸</strong><p>반복 질문과 필요한 자료를 확인합니다.</p><span>문의 전 준비 항목 정의</span></div></li>
            </ol>
        </div>
    </section>

    <section class="jwh2-delivery" aria-labelledby="jwh2-delivery-title"><div class="jwh2-shell">
        <div class="jwh2-section-heading"><div><span class="jwh2-kicker">ORBIT / HANDOVER EDITION</span><h2 id="jwh2-delivery-title">담당자가 이어 쓸<br>결과물까지.</h2></div><p>선택의 이유부터 공개 전 점검까지. 같은 사분면을 다시 담는 대신, 다음 담당자가 펼쳐 읽는 자료를 남깁니다.</p></div>
        <div class="jwh2-handover"><figure><img src="<?php echo G5_THEME_URL; ?>/assets/images/home2-correction/operations-playbook.webp" width="1536" height="1024" alt="체크리스트, 서비스 사이트맵, 화면 주석과 담당 절차가 편집된 가상 ORBIT 운영 인계 도서" loading="lazy"><figcaption>ORBIT 운영 인계 키트 · 시연용 생성 이미지</figcaption></figure>
            <div class="jwh2-delivery-board" data-jwh2-delivery-board><article><span>01 / DECISION RECORD</span><h3>판단 기록</h3><p>무엇을 선택했고 무엇을 보류했는지, 다시 판단할 조건과 함께 정리합니다.</p><dl><div><dt>기록</dt><dd>선택 범위 · 관찰 근거</dd></div><div><dt>다음</dt><dd>검증 질문 · 판단 시점</dd></div></dl></article><article><span>02 / SCREEN SPEC</span><h3>화면 명세</h3><p>비교 정보의 순서와 연결, 문구 작성 기준을 화면 위 주석으로 남깁니다.</p><dl><div><dt>구성</dt><dd>정보 순서 · 이동 경로</dd></div><div><dt>관리</dt><dd>콘텐츠별 수정 위치</dd></div></dl></article><article><span>03 / OPERATIONS</span><h3>운영 점검표</h3><p>담당자·검토자·공개 절차를 나누고, 수정 후 확인할 항목을 붙입니다.</p><dl><div><dt>담당</dt><dd>작성 → 검토 → 공개</dd></div><div><dt>점검</dt><dd>링크 · 문구 · 기기별 화면</dd></div></dl></article></div>
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
