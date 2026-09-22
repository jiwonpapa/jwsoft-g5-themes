<?php
/**
 * Theme: JW-Business 1.0
 * File: index_5.php
 * Role: 회사·사업·사례·연락처를 한 흐름으로 읽는 메인 5번 독립 페이지
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
<article class="jwh jwh--onepage" data-jw-home="5">
    <header class="jwh-one-hero">
        <div class="jwh-photo jwh-photo--campus" role="img" aria-label="건축과 조경이 어우러진 현대 업무 공간">
        </div>
        <div class="jwh-wrap jwh-one-hero__copy">
            <h1>함께 생각하고,<br>가치를 만듭니다.</h1>
            <p>전략과 기술, 공간을 연결하는<br><?php echo jw_business_escape($jw_company['name']); ?>입니다.</p>
            <a class="jwh-light-link" href="#one-about">우리 회사 알아보기 <i data-lucide="arrow-down" aria-hidden="true"></i>
            </a>
        </div>
    </header>
    <nav class="jwh-one-nav" aria-label="이 페이지 목차">
        <div class="jwh-wrap">
            <a href="#one-about">회사소개</a>
            <a href="#one-services">사업분야</a>
            <a href="#one-work">업무 사례</a>
            <a href="#one-contact">연락처</a>
        </div>
    </nav>
    <section id="one-about" class="jwh-section jwh-wrap jwh-company-note" aria-labelledby="one-about-title">
        <h2 id="one-about-title">다른 전문성,<br>하나의 방향.</h2>
        <div>
            <p class="jwh-lead">사람이 실제로 경험하는 변화를 만듭니다.</p>
            <p>비즈니스의 방향과 서비스를 사용하는 순간, 공간에서 머무는 경험은 서로 연결되어 있습니다. 분야의 경계보다 해결해야 할 과제에 집중합니다.</p>
            <p>질문을 함께 정의하고, 판단의 근거를 남기며, 운영으로 이어질 수 있는 결과물을 만듭니다.</p>
            <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('company-overview-5')); ?>">회사 이야기 더 읽기 <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
    <section id="one-services" class="jwh-soft jwh-section" aria-labelledby="one-services-title">
        <div class="jwh-wrap">
            <header class="jwh-heading">
                <h2 id="one-services-title">우리가 하는 일</h2>
                <p>지금 필요한 관점에서 시작합니다.</p>
            </header>
            <div class="jwh-one-services">
                <a href="<?php echo jw_business_escape(jw_business_page_url('business-detail-1')); ?>">
                    <h3>비즈니스 컨설팅</h3>
                    <p>현재를 이해하고 실행의 우선순위를 정합니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
                <a href="<?php echo jw_business_escape(jw_business_page_url('business-detail-2')); ?>">
                    <h3>디지털 서비스</h3>
                    <p>사람과 기술이 만나는 흐름을 설계합니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
                <a href="<?php echo jw_business_escape(jw_business_page_url('business-detail-3')); ?>">
                    <h3>공간·브랜드 경험</h3>
                    <p>브랜드의 가치가 현장에서 느껴지도록 만듭니다.</p>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>
    <section id="one-work" class="jwh-section jwh-wrap jwh-one-work" aria-labelledby="one-work-title">
        <div>
            <h2 id="one-work-title">일하는 방식을 담은<br>공간의 변화.</h2>
            <p>집중과 협업이 자연스럽게 이어지는 업무 환경. 사용자의 움직임에서 출발해 공간과 운영을 함께 기획하는 사례입니다.</p>
            <p class="jwh-demo-note">테마 시연 사례 · 실제 고객 실적이 아닙니다.</p>
            <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-4')); ?>">사례의 과정과 결과물 <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        <figure>
            <div class="jwh-photo jwh-photo--workspace" role="img" aria-label="채광이 풍부한 협업 공간의 시연 이미지">
            </div>
        </figure>
    </section>
    <section id="one-contact" class="jwh-one-contact jwh-section">
        <div class="jwh-wrap jwh-company-note">
            <div>
                <h2>새로운 이야기를<br>기다립니다.</h2>
                <p>사업의 고민부터 협업 제안까지.<br>편한 방법으로 이야기해 주세요.</p>
                <a class="jw-control jw-control--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">온라인 문의하기 <i data-lucide="arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <dl class="jwh-facts">
                <div>
                    <dt>회사</dt>
                    <dd><?php echo jw_business_escape($jw_company['name']); ?></dd>
                </div>
                <div>
                    <dt>이메일</dt>
                    <dd>
                        <a href="mailto:<?php echo jw_business_escape($jw_company['email']); ?>"><?php echo jw_business_escape($jw_company['email']); ?></a>
                    </dd>
                </div>
                <div>
                    <dt>전화</dt>
                    <dd>
                        <a href="tel:<?php echo jw_business_escape(preg_replace('/[^+0-9]/', '', $jw_company['phone'])); ?>"><?php echo jw_business_escape($jw_company['phone']); ?></a>
                    </dd>
                </div>
                <div>
                    <dt>주소</dt>
                    <dd><?php echo jw_business_escape($jw_company['address']); ?></dd>
                </div>
            </dl>
        </div>
    </section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
