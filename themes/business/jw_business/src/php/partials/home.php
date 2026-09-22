<?php
if (!defined('_GNUBOARD_')) exit;

$jw_settings = jw_business_settings();
$jw_home = $jw_settings['home'];
$jw_services = isset($jw_home['services']) ? (array) $jw_home['services'] : array();
$jw_news_board = isset($jw_home['news_board']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $jw_home['news_board']) : 'notice';
?>
<div class="jw-home">
    <section class="jw-hero" aria-labelledby="jw-hero-title">
        <div class="jw-hero__media" role="img" aria-label="넓은 광장과 현대적인 업무 시설"></div>
        <div class="jw-hero__overlay"></div>
        <div class="jw-shell jw-hero__content">
            <p class="jw-eyebrow"><?php echo jw_business_escape($jw_home['eyebrow']); ?></p>
            <h2 id="jw-hero-title"><?php echo nl2br(jw_business_escape($jw_home['title'])); ?></h2>
            <p class="jw-hero__summary"><?php echo jw_business_escape($jw_home['summary']); ?></p>
            <a class="tw:d-btn tw:d-btn-primary jw-button jw-button--primary" href="<?php echo jw_business_escape(jw_business_page_url('business-list-1')); ?>">우리의 사업 보기<i data-lucide="arrow-right"></i></a>
        </div>
    </section>

    <section class="jw-section jw-services" aria-labelledby="jw-services-title" data-jw-reveal>
        <div class="jw-shell jw-services__grid">
            <div class="jw-section-heading">
                <p class="jw-eyebrow">What we do</p>
                <h2 id="jw-services-title">우리가 하는 일</h2>
            </div>
            <ul class="jw-services__list">
                <?php foreach ($jw_services as $service) { ?>
                <li>
                    <a href="<?php echo jw_business_escape($service['url']); ?>">
                        <span><strong><?php echo jw_business_escape($service['title']); ?></strong><small><?php echo jw_business_escape($service['summary']); ?></small></span>
                        <i data-lucide="arrow-up-right"></i>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </section>

    <section class="jw-section jw-section--soft jw-about" aria-labelledby="jw-about-title" data-jw-reveal>
        <div class="jw-shell jw-split">
            <div class="jw-split__copy">
                <p class="jw-eyebrow">About us</p>
                <h2 id="jw-about-title">서로 다른 경험을,<br>하나의 해답으로.</h2>
                <p>분야의 경계를 넘어 함께 생각합니다.<br>현장에 맞는 해답을 찾고 끝까지 실행합니다.</p>
                <dl class="jw-stats" aria-label="회사 주요 실적">
                    <div><dt>18년</dt><dd>축적한 경험</dd></div>
                    <div><dt>320건</dt><dd>완료 프로젝트</dd></div>
                </dl>
                <a class="jw-text-link" href="<?php echo jw_business_escape(jw_business_page_url('company-overview-1')); ?>">회사소개 보기<i data-lucide="arrow-right"></i></a>
            </div>
            <div class="jw-media jw-media--collaboration" role="img" aria-label="업무 자료를 함께 검토하는 두 명의 전문가"></div>
        </div>
    </section>

    <section class="jw-section jw-project" aria-labelledby="jw-project-title" data-jw-reveal>
        <div class="jw-shell jw-split jw-split--media-first">
            <div class="jw-media jw-media--project" role="img" aria-label="자연광이 드는 현대적인 회의 공간"></div>
            <div class="jw-split__copy">
                <p class="jw-eyebrow">Featured project</p>
                <h2 id="jw-project-title">일과 사람이<br>자연스럽게 이어지는 공간.</h2>
                <p>업무의 흐름과 브랜드의 태도가 함께 드러나는 공간을 설계했습니다.</p>
                <a class="jw-text-link" href="<?php echo get_pretty_url('gallery'); ?>">프로젝트 보기<i data-lucide="arrow-right"></i></a>
            </div>
        </div>
    </section>

    <section class="jw-section jw-process" aria-labelledby="jw-process-title" data-jw-reveal>
        <div class="jw-shell">
            <div class="jw-section-heading jw-section-heading--row">
                <div><p class="jw-eyebrow">How we work</p><h2 id="jw-process-title">함께 일하는 방식</h2></div>
                <p>문제를 이해하는 일부터 결과를 개선하는 순간까지 한 흐름으로 연결합니다.</p>
            </div>
            <ol class="jw-process__list">
                <li><span>01</span><strong>이해하고 정의합니다</strong><p>현장의 이야기를 듣고 해결할 과제를 찾습니다.</p></li>
                <li><span>02</span><strong>설계하고 만듭니다</strong><p>계획을 구체적인 실행과 결과로 만듭니다.</p></li>
                <li><span>03</span><strong>실행하고 개선합니다</strong><p>실제 운영을 살피며 더 나은 방향을 찾습니다.</p></li>
            </ol>
        </div>
    </section>

    <section class="jw-section jw-news" aria-labelledby="jw-news-title" data-jw-reveal>
        <div class="jw-shell jw-news__grid">
            <div class="jw-section-heading">
                <p class="jw-eyebrow">News</p>
                <h2 id="jw-news-title">새로운 소식</h2>
                <a class="jw-text-link" href="<?php echo get_pretty_url($jw_news_board); ?>">전체 보기<i data-lucide="arrow-right"></i></a>
            </div>
            <div class="jw-news__feed">
                <?php echo latest('theme/home_news', $jw_news_board, 3, 80); ?>
            </div>
        </div>
    </section>

    <section class="jw-contact" aria-labelledby="jw-contact-title" data-jw-reveal>
        <div class="jw-shell jw-contact__inner">
            <div><p class="jw-eyebrow">Contact</p><h2 id="jw-contact-title">함께 이야기해 볼까요?</h2></div>
            <a class="tw:d-btn tw:d-btn-primary jw-button jw-button--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">문의하기<i data-lucide="arrow-right"></i></a>
        </div>
    </section>
</div>
