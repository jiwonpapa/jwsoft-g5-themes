<?php
/**
 * Theme: JW-Business 1.0
 * File: head.php
 * Role: 공개 화면 헤더와 메뉴 골격
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if (G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_THEME_PATH.'/lib/jw-business.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

if (defined('_INDEX_')) jw_business_render_popup_layer('pc');
$jw_settings = jw_business_settings();
?>
<a class="jw-skip-link" href="#jw-main">본문 바로가기</a>
<header class="jw-header" data-jw-sticky-header>
    <div class="jw-header__inner">
        <a class="jw-brand" href="<?php echo G5_URL; ?>">
            <!-- JW BLOCK COPY: blocks/brand/logo-01.php; 각 shell의 독립 복사본입니다. -->
            <span class="jw-brand__viewport<?php echo !empty($jw_settings['brand']['logo_animated']) ? ' jw-brand__viewport--animated' : ''; ?>">
                <img class="jw-brand__image jw-brand__image--light" src="<?php echo jw_business_escape($jw_settings['brand']['logo_light']); ?>" alt="<?php echo jw_business_escape($jw_settings['brand']['name']); ?>" width="648" height="<?php echo !empty($jw_settings['brand']['logo_animated']) ? '1080' : '120'; ?>" decoding="async">
                <img class="jw-brand__image jw-brand__image--dark" src="<?php echo jw_business_escape($jw_settings['brand']['logo_dark']); ?>" alt="<?php echo jw_business_escape($jw_settings['brand']['name']); ?>" width="648" height="<?php echo !empty($jw_settings['brand']['logo_animated']) ? '1080' : '120'; ?>" decoding="async">
            </span>
        </a>

        <?php // 공용 허용 #1: G5 관리자 메뉴 DB 기반 PC 메뉴입니다. ?>
        <?php include G5_THEME_PATH.'/inc/menu.php'; ?>

        <div class="jw-header__actions">
            <a class="jw-icon-button jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/search.php" aria-label="사이트 검색"><i data-lucide="search"></i></a>
            <button type="button" class="jw-icon-button jw-desktop-action" data-jw-theme-toggle aria-label="다크 모드로 전환" aria-pressed="false"><i data-lucide="moon"></i></button>
            <?php if ($is_member) { ?>
            <a class="jw-account-link jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=<?php echo G5_BBS_URL; ?>/register_form.php">내 정보</a>
            <a class="jw-account-link jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/logout.php">로그아웃</a>
            <?php } else { ?>
            <a class="jw-account-link jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/login.php">로그인</a>
            <?php } ?>
            <a class="tw:d-btn tw:d-btn-primary jw-header__cta jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/qalist.php">문의하기</a>
            <a class="jw-mobile-contact" href="<?php echo G5_BBS_URL; ?>/qalist.php">문의</a>
            <button type="button" class="jw-menu-button" data-jw-menu-open aria-label="전체 메뉴 열기" aria-controls="jw-mobile-menu" aria-expanded="false"><i data-lucide="menu"></i><span>메뉴</span></button>
        </div>
    </div>

    <?php // 공용 허용 #2: G5 관리자 메뉴 DB 기반 모바일 메뉴입니다. ?>
    <?php include G5_THEME_PATH.'/inc/mobile-menu.php'; ?>
</header>
<div class="jw-layout<?php echo defined('_INDEX_') ? ' jw-layout--home' : (!empty($jw_full_width_page) ? ' jw-layout--full' : ''); ?>">
    <div class="jw-layout__inner">
        <main id="jw-main" class="jw-main<?php echo defined('_INDEX_') ? ' jw-main--home' : (!empty($jw_full_width_page) ? ' jw-main--full' : ''); ?>">
            <?php if (!defined('_INDEX_') && empty($jw_full_width_page)) { ?>
            <header class="jw-page-head">
                <h1 class="jw-page-title"><?php echo get_head_title($g5['title']); ?></h1>
            </header>
            <?php } ?>
