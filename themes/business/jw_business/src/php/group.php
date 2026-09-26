<?php
/**
 * Theme: JW-Business 1.0
 * File: group.php
 * Role: 게시판 그룹의 최신글 표현형 모음
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;

$jw_group = is_array($group ?? null) ? $group : get_group($gr_id, true);
$jw_group_subject = (string) ($jw_group['gr_subject'] ?? '게시판');
$jw_group_device = (string) ($jw_group['gr_device'] ?? 'both');

if (G5_IS_MOBILE) {
    include_once G5_THEME_MOBILE_PATH.'/group.php';
    return;
}

if (!$is_admin && $jw_group_device === 'mobile') {
    alert($jw_group_subject.' 그룹은 모바일에서만 접근할 수 있습니다.');
}

$g5['title'] = $jw_group_subject;
include_once G5_THEME_PATH.'/head.php';
include_once G5_LIB_PATH.'/latest.lib.php';

$jw_latest_skins = array('basic', 'notice', 'image-list', 'image-grid', 'featured', 'slider', 'tabs', 'video');
$jw_group_id = sql_escape_string($gr_id);
$jw_group_sql = " select bo_table, bo_subject
                    from {$g5['board_table']}
                   where gr_id = '{$jw_group_id}'
                     and bo_list_level <= '{$member['mb_level']}'
                     and bo_device <> 'mobile' ";
if (!$is_admin) $jw_group_sql .= " and bo_use_cert = '' ";
$jw_group_sql .= " order by bo_order, bo_table ";
$jw_group_result = sql_query($jw_group_sql);
?>
<section class="jw-latest-showcase" aria-labelledby="jw-latest-showcase-title">
    <header class="jw-latest-showcase__intro">
        <p>Latest post patterns</p>
        <h1 id="jw-latest-showcase-title"><?php echo get_text($jw_group_subject); ?></h1>
        <span>게시판의 실제 최신 글을 목적에 맞는 여덟 가지 방식으로 보여줍니다.</span>
    </header>
    <div class="jw-latest-showcase__grid">
        <?php for ($jw_index = 0; $jw_board = sql_fetch_array($jw_group_result); $jw_index++) {
            $jw_skin = $jw_latest_skins[$jw_index % count($jw_latest_skins)];
        ?>
        <div class="jw-latest-showcase__item" data-latest-pattern="<?php echo jw_business_escape($jw_skin); ?>">
            <p class="jw-latest-showcase__label"><?php echo str_pad((string) ($jw_index + 1), 2, '0', STR_PAD_LEFT); ?> · <?php echo jw_business_escape($jw_skin); ?></p>
            <?php echo latest('theme/'.$jw_skin, $jw_board['bo_table'], $jw_skin === 'slider' ? 8 : 6, 120); ?>
        </div>
        <?php } ?>
    </div>
</section>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
