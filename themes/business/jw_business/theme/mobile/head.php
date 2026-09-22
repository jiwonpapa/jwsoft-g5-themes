<?php
if (!defined('_GNUBOARD_')) exit;

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

if (defined('_INDEX_')) jw_business_render_popup_layer('mobile');
include G5_THEME_PATH.'/partials/site-header.php';
?>
<div class="jw-layout<?php echo defined('_INDEX_') ? ' jw-layout--home' : (!empty($jw_full_width_page) ? ' jw-layout--full' : ''); ?>">
    <div class="jw-layout__inner">
        <main id="jw-main" class="jw-main<?php echo defined('_INDEX_') ? ' jw-main--home' : (!empty($jw_full_width_page) ? ' jw-main--full' : ''); ?>">
            <?php if (!defined('_INDEX_') && empty($jw_full_width_page)) { ?>
            <header class="jw-page-head">
                <h1 class="jw-page-title"><?php echo get_head_title($g5['title']); ?></h1>
            </header>
            <?php } ?>
