<?php
/**
 * Theme: JW-Business 1.0
 * File: index_2.php
 * Role: 주요 사업을 탐색하는 메인 2번 독립 페이지
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
<article class="jwh jwh--business" data-jw-home="2">
    <header class="jwh-business-hero jwh-wrap">
        <div>
            <h1>사업의 다음 단계,<br>함께 구체화합니다.</h1>
            <p class="jwh-lead">방향을 정하는 전략부터 디지털 서비스와 공간 경험까지. 지금 필요한 전문성을 만나보세요.</p>
            <a class="jw-control jw-control--primary" href="#home-services">사업 분야 살펴보기 <i data-lucide="arrow-down" aria-hidden="true"></i>
            </a>
        </div>
        <figure>
            <div class="jwh-photo jwh-photo--team" role="img" aria-label="도면과 자료를 함께 검토하는 두 전문가">
            </div>
            <figcaption>서로 다른 관점을 모아, 실행할 수 있는 답을 찾습니다.</figcaption>
        </figure>
    </header>
    <nav class="jwh-service-nav jwh-wrap" aria-label="사업 바로가기">
        <a href="#home-strategy">비즈니스 컨설팅 <i data-lucide="arrow-down" aria-hidden="true"></i>
        </a>
        <a href="#home-digital">디지털 서비스 <i data-lucide="arrow-down" aria-hidden="true"></i>
        </a>
        <a href="#home-space">공간·브랜드 경험 <i data-lucide="arrow-down" aria-hidden="true"></i>
        </a>
    </nav>
    <section id="home-services" class="jwh-section jwh-wrap" aria-labelledby="home-services-title">
        <header class="jwh-heading">
            <h2 id="home-services-title">무엇을 바꾸고 싶으신가요?</h2>
            <p>과제에 맞는 분야에서 시작하고, 필요한 지점에서 전문성을 연결합니다.</p>
        </header>
        <div class="jwh-business-rows">
            <section id="home-strategy" class="jwh-business-row">
                <h3>비즈니스 <br>컨설팅</h3>
                <div>
                    <p>막연한 목표를 팀이 함께 판단할 수 있는 기준으로 바꿉니다. 고객과 현장을 살펴 지금 해결할 문제부터 정리합니다.</p>
                    <ul>
                        <li>현황 진단과 고객 경험 분석</li>
                        <li>사업 방향·실행 우선순위 수립</li>
                        <li>협업 워크숍과 의사결정 자료</li>
                    </ul>
                </div>
                <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-1')); ?>">컨설팅 자세히 <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            </section>
            <section id="home-digital" class="jwh-business-row">
                <h3>디지털 <br>서비스</h3>
                <div>
                    <p>사람이 사용하는 흐름을 먼저 설계합니다. 화면을 만드는 일과 운영하는 일을 함께 살펴 서비스의 일관성을 만듭니다.</p>
                    <ul>
                        <li>사용자 여정과 정보 구조</li>
                        <li>웹 서비스·브랜드 접점 디자인</li>
                        <li>콘텐츠와 운영 기준 정리</li>
                    </ul>
                </div>
                <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-2')); ?>">디지털 자세히 <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            </section>
            <section id="home-space" class="jwh-business-row">
                <h3>공간·브랜드 <br>경험</h3>
                <div>
                    <p>일하는 방식과 방문자의 움직임을 공간에 담습니다. 브랜드가 말하는 가치가 현장에서 같은 경험으로 이어지도록 설계합니다.</p>
                    <ul>
                        <li>공간 이용 흐름과 접점 조사</li>
                        <li>업무 공간·방문 경험 기획</li>
                        <li>안내 체계와 운영 가이드</li>
                    </ul>
                </div>
                <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-3')); ?>">공간 경험 자세히 <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            </section>
        </div>
    </section>
    <section class="jwh-soft jwh-section" aria-labelledby="home-example-title">
        <div class="jwh-wrap jwh-example">
            <figure>
                <div class="jwh-photo jwh-photo--workspace" role="img" aria-label="회의와 집중 업무 공간이 연결된 업무 환경의 시연 이미지">
                </div>
                <figcaption>공간 경험 프로젝트 시연 이미지 · 실제 고객 실적이 아닙니다.</figcaption>
            </figure>
            <div>
                <h2 id="home-example-title">공간을 바꾸기 전에,<br>일하는 흐름부터.</h2>
                <p>집중 업무와 짧은 협의가 자주 교차하는 팀을 위한 공간 기획 예시입니다. 좌석 수보다 이동과 대화의 흐름을 먼저 살핍니다.</p>
                <dl class="jwh-facts">
                    <div>
                        <dt>살펴볼 문제</dt>
                        <dd>집중 공간과 협의 공간의 충돌</dd>
                    </div>
                    <div>
                        <dt>검토할 내용</dt>
                        <dd>이용 시간·동선·안내 접점</dd>
                    </div>
                    <div>
                        <dt>남기는 자료</dt>
                        <dd>공간 구성안과 운영 시나리오</dd>
                    </div>
                </dl>
                <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-4')); ?>">사례 구성 살펴보기 <i data-lucide="arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>
    <section class="jwh-section jwh-wrap jwh-company-note" aria-labelledby="home-company-title">
        <h2 id="home-company-title">함께 일할 파트너를<br>알아보세요.</h2>
        <div>
            <p><?php echo jw_business_escape($jw_company['name']); ?>는 전략, 기술, 공간의 관점을 연결합니다. 각 분야의 결과물이 다음 단계에서도 쓰일 수 있도록 과정과 판단을 기록합니다.</p>
            <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('company-overview-1')); ?>">회사소개 <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
    <!-- JW BLOCK COPY START: blocks/home/contact-band-01.php; 이 페이지에서 독립 수정합니다. -->
    <section class="jwh-close">
        <div class="jwh-wrap">
            <h2>아직 정리되지 않은 과제도 괜찮습니다.</h2>
            <a class="jw-control jw-control--primary" href="<?php echo jw_business_escape(jw_business_page_url('contact-1')); ?>">프로젝트 문의 안내 <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
    <!-- JW BLOCK COPY END -->
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
