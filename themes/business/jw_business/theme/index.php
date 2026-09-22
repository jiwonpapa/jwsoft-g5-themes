<?php
/**
 * Theme: JW-Business 1.0
 * File: index.php
 * Role: 기본 메인 홈 완성 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit;

if (G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once G5_THEME_SHOP_PATH.'/index.php';
    return;
}

$g5['title'] = $config['cf_title'];
include_once G5_THEME_PATH.'/head.php';

$jw_settings = jw_business_settings();
$jw_home = $jw_settings['home'];
$jw_services = isset($jw_home['services']) ? (array) $jw_home['services'] : array();
$jw_news_board = isset($jw_home['news_board']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $jw_home['news_board']) : 'notice';
?>
<!-- JW BLOCK COPY: legacy src/php/partials/home/1.php; 이 파일에 복사된 독립 본문이며 원본 수정이 전파되지 않습니다. -->
<div class="jw-home jw-home--1">
    <section class="jw-hero" aria-labelledby="jw-hero-title">
        <div class="jw-hero__media" role="img" aria-label="넓은 광장과 현대적인 업무 시설"></div>
        <div class="jw-hero__overlay"></div>
        <div class="jw-shell jw-hero__content">
            <p class="jw-hero__meta"><?php echo jw_business_escape($jw_home['eyebrow']); ?></p>
            <h2 id="jw-hero-title"><?php echo nl2br(jw_business_escape($jw_home['title'])); ?></h2>
            <p class="jw-hero__summary"><?php echo jw_business_escape($jw_home['summary']); ?></p>
            <div class="jw-hero__actions">
                <a class="tw:d-btn tw:d-btn-primary jw-button jw-button--primary" href="<?php echo jw_business_escape(jw_business_page_url('business-list-1')); ?>">사업 분야 보기<i data-lucide="arrow-right"></i></a>
                <a class="jw-hero__quiet-link" href="<?php echo jw_business_escape(jw_business_page_url('company-overview-1')); ?>">회사 알아보기<i data-lucide="arrow-right"></i></a>
            </div>
        </div>
        <div class="jw-shell jw-hero__caption" aria-hidden="true">
            <span>Integrated business partner</span>
            <span>Seoul · Korea</span>
        </div>
    </section>

    <section class="jw-home-section jw-service-map" aria-labelledby="jw-services-title">
        <div class="jw-shell">
            <header class="jw-home-heading jw-home-heading--split">
                <h2 id="jw-services-title">서로 다른 전문성을<br>하나의 방향으로<span class="jw-mobile-break"><br></span> 연결합니다.</h2>
                <p>과제를 정의하는 일부터 실제 경험을 만드는 순간까지, 필요한 전문성을 한 흐름 안에서 설계합니다.</p>
            </header>
            <ul class="jw-service-map__list">
                <?php foreach ($jw_services as $service) { ?>
                <li>
                    <a href="<?php echo jw_business_escape($service['url']); ?>">
                        <strong><?php echo jw_business_escape($service['title']); ?></strong>
                        <span><?php echo jw_business_escape($service['summary']); ?></span>
                        <i data-lucide="arrow-up-right"></i>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </section>

    <section class="jw-home-section jw-story" aria-labelledby="jw-story-title">
        <div class="jw-shell jw-story__grid">
            <div class="jw-story__visual" data-jw-reveal>
                <div class="jw-story__photo" role="img" aria-label="업무 자료를 함께 검토하는 두 명의 전문가"></div>
                <dl class="jw-story__figures" aria-label="회사 주요 실적">
                    <div><dt>18년</dt><dd>축적한 경험</dd></div>
                    <div><dt>320건</dt><dd>완료 프로젝트</dd></div>
                </dl>
            </div>
            <div class="jw-story__content">
                <h2 id="jw-story-title">좋은 결과는<br>함께 보는 방식에서<br>시작됩니다.</h2>
                <p>분야의 경계를 넘어 질문을 공유하고, 실행할 수 있는 언어로 정리합니다. 각 단계의 판단이 다음 단계에서도 이어지도록 만듭니다.</p>
                <ul class="jw-story__principles">
                    <li><strong>질문을 함께 정의합니다</strong><span>목표와 현장의 차이를 먼저 확인합니다.</span></li>
                    <li><strong>과정을 보이게 만듭니다</strong><span>결정과 실행의 근거를 함께 남깁니다.</span></li>
                    <li><strong>운영까지 연결합니다</strong><span>결과가 실제 환경에서 작동하는지 살핍니다.</span></li>
                </ul>
                <a class="jw-text-link" href="<?php echo jw_business_escape(jw_business_page_url('company-overview-1')); ?>">회사소개 보기<i data-lucide="arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section class="jw-home-section jw-project" aria-labelledby="jw-project-title">
        <div class="jw-shell">
            <div class="jw-project__stage">
                <div class="jw-project__copy">
                    <p>Selected project</p>
                    <h2 id="jw-project-title">일과 사람이 자연스럽게<br>이어지는 공간.</h2>
                    <span>업무의 흐름과 브랜드의 태도를 하나의 장면으로 구성합니다.</span>
                    <a class="jw-project__link" href="<?php echo get_pretty_url('gallery'); ?>">프로젝트 보기<i data-lucide="arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section class="jw-home-section jw-system" aria-labelledby="jw-system-title">
        <div class="jw-shell">
            <header class="jw-system__heading">
                <h2 id="jw-system-title">복잡한 일을,<br>결정 가능한 구조로.</h2>
                <p>각 분야의 결과물을 따로 쌓지 않습니다. 방향, 경험, 실행이 서로 맞물리는 구조를 만듭니다.</p>
            </header>
            <dl class="jw-system__list">
                <div><dt>Direction</dt><dd><strong>무엇을 먼저 결정할지</strong><span>목표와 우선순위를 정리해 실행의 기준을 세웁니다.</span></dd></div>
                <div><dt>Experience</dt><dd><strong>사람이 어떻게 경험할지</strong><span>서비스와 공간의 접점을 한 흐름으로 설계합니다.</span></dd></div>
                <div><dt>Delivery</dt><dd><strong>현장에서 어떻게 이어갈지</strong><span>운영에 필요한 기준과 다음 행동을 함께 남깁니다.</span></dd></div>
            </dl>
        </div>
    </section>

    <section class="jw-home-section jw-process" aria-labelledby="jw-process-title">
        <div class="jw-shell">
            <header class="jw-home-heading jw-home-heading--split">
                <h2 id="jw-process-title">함께 일하는 방식</h2>
                <p>처음의 질문이 마지막 운영까지 이어지도록 세 단계의 확인 지점을 둡니다.</p>
            </header>
            <ol class="jw-process__list">
                <li><span>01</span><strong>이해하고 정의합니다</strong><p>현장의 이야기를 듣고 해결할 과제를 찾습니다.</p></li>
                <li><span>02</span><strong>설계하고 만듭니다</strong><p>합의한 방향을 구체적인 경험과 결과로 만듭니다.</p></li>
                <li><span>03</span><strong>실행하고 개선합니다</strong><p>실제 운영을 살피며 다음 판단의 기준을 남깁니다.</p></li>
            </ol>
        </div>
    </section>

    <section class="jw-home-section jw-home-close" aria-label="소식과 문의">
        <div class="jw-shell jw-home-close__grid">
            <div class="jw-news" aria-labelledby="jw-news-title">
                <header class="jw-news__heading">
                    <h2 id="jw-news-title">새로운 소식</h2>
                    <a class="jw-text-link" href="<?php echo get_pretty_url($jw_news_board); ?>">전체 보기<i data-lucide="arrow-right"></i></a>
                </header>
                <div class="jw-news__feed">
                    <?php echo latest('theme/home_news', $jw_news_board, 3, 80); ?>
                </div>
            </div>
            <aside class="jw-contact" aria-labelledby="jw-contact-title">
                <div>
                    <p>새로운 프로젝트를 준비하고 계신가요?</p>
                    <h2 id="jw-contact-title">함께 이야기해<br>볼까요?</h2>
                </div>
                <a class="tw:d-btn tw:d-btn-primary jw-button jw-button--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">문의하기<i data-lucide="arrow-right"></i></a>
            </aside>
        </div>
    </section>
</div>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
