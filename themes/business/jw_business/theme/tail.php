<?php
/**
 * Theme: JW-Business 1.0
 * File: tail.php
 * Role: 공개 화면 푸터와 문서 종료
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if (G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>
        </main>
    </div>
</div>
<?php
$jw_settings = jw_business_settings();
$jw_company = $jw_settings['company'];
?>
<footer class="jw-footer">
    <div class="jw-shell jw-footer__top">
        <a class="jw-brand jw-brand--footer" href="<?php echo G5_URL; ?>">
            <img class="jw-brand__mark jw-brand__mark--light" src="<?php echo jw_business_escape($jw_settings['brand']['logo_light']); ?>" alt="<?php echo jw_business_escape($jw_settings['brand']['name']); ?>">
            <img class="jw-brand__mark jw-brand__mark--dark" src="<?php echo jw_business_escape($jw_settings['brand']['logo_dark']); ?>" alt="" aria-hidden="true">
        </a>
        <nav class="jw-footer__links" aria-label="하단 메뉴">
            <a href="<?php echo jw_business_escape(jw_business_page_url('company-overview-1')); ?>">회사소개</a>
            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a>
            <a href="<?php echo get_pretty_url('content', 'provision'); ?>">이용약관</a>
            <a href="<?php echo G5_BBS_URL; ?>/qalist.php">문의하기</a>
        </nav>
    </div>
    <div class="jw-shell jw-footer__meta">
        <address>
            <span><?php echo jw_business_escape($jw_company['name']); ?></span>
            <span>대표 <?php echo jw_business_escape($jw_company['representative']); ?></span>
            <span><?php echo jw_business_escape($jw_company['address']); ?></span>
            <span><?php echo jw_business_escape($jw_company['phone']); ?></span>
            <a href="mailto:<?php echo jw_business_escape($jw_company['email']); ?>"><?php echo jw_business_escape($jw_company['email']); ?></a>
            <span>사업자등록번호 <?php echo jw_business_escape($jw_company['business_number']); ?></span>
        </address>
        <p>© <?php echo date('Y'); ?> <?php echo jw_business_escape($jw_company['name']); ?></p>
    </div>
    <?php if (G5_DEVICE_BUTTON_DISPLAY) { ?><a class="jw-device-link" href="<?php echo get_device_change_url(); ?>"><?php echo G5_IS_MOBILE ? 'PC 버전' : '모바일 버전'; ?></a><?php } ?>
    <button type="button" class="jw-back-to-top" data-jw-back-to-top aria-label="페이지 맨 위로"><i data-lucide="arrow-up"></i></button>
</footer>
<?php
if ($config['cf_analytics']) echo $config['cf_analytics'];
?>
<?php include_once(G5_THEME_PATH.'/tail.sub.php'); ?>
