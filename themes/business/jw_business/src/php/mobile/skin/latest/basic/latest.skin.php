<?php
/**
 * Theme: JW-Business 1.0
 * File: mobile/skin/latest/basic/latest.skin.php
 * Role: 최신글 표현형 (basic)
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

include_once G5_LIB_PATH.'/thumbnail.lib.php';

$jw_latest_list = is_array($list ?? null) ? $list : array();
$jw_latest_url = get_pretty_url($bo_table);
$jw_latest_id = 'jw-latest-'.preg_replace('/[^a-z0-9_-]/i', '-', $bo_table).'-basic';
?>
<section id="<?php echo jw_business_escape($jw_latest_id); ?>" class="jw-latest jw-latest--basic<?php echo !empty($jw_latest_embedded) ? ' jw-latest--embedded' : ''; ?>"<?php echo empty($jw_latest_embedded) ? ' aria-labelledby="'.jw_business_escape($jw_latest_id).'-title"' : ' aria-label="'.get_text($bo_subject).' 최신글"'; ?>>
    <?php if (empty($jw_latest_embedded)) { ?>
    <header class="jw-latest__header">
        <h2 id="<?php echo jw_business_escape($jw_latest_id); ?>-title"><a href="<?php echo jw_business_escape($jw_latest_url); ?>"><?php echo get_text($bo_subject); ?></a></h2>
        <a class="jw-latest__more" href="<?php echo jw_business_escape($jw_latest_url); ?>">전체 보기<i data-lucide="arrow-right"></i></a>
    </header>
    <?php } ?>

    <?php if (!$jw_latest_list) { ?>
    <p class="jw-latest__empty">등록된 게시물이 없습니다.</p>

    <?php } else { ?>
    <ul class="jw-latest-rows">
        <?php foreach ($jw_latest_list as $item) { ?>
        <li>
            <a href="<?php echo jw_business_escape(get_pretty_url($bo_table, $item['wr_id'])); ?>">
                <span class="jw-latest-rows__subject"><?php if ($item['is_notice']) { ?><em>공지</em><?php } ?><strong><?php echo $item['subject']; ?></strong><?php if ($item['comment_cnt']) { ?><small>댓글 <?php echo (int) $item['wr_comment']; ?></small><?php } ?></span>
                <time datetime="<?php echo jw_business_escape(substr((string) ($item['wr_datetime'] ?? ''), 0, 10)); ?>"><?php echo jw_business_escape($item['datetime2']); ?></time>
            </a>
        </li>
        <?php } ?>
    </ul>
    <?php } ?>
</section>
