<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/latest/image-list/latest.skin.php
 * Role: 최신글 표현형 (image-list)
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

include_once G5_LIB_PATH.'/thumbnail.lib.php';

$jw_latest_list = is_array($list ?? null) ? $list : array();
$jw_latest_url = get_pretty_url($bo_table);
$jw_latest_id = 'jw-latest-'.preg_replace('/[^a-z0-9_-]/i', '-', $bo_table).'-image-list';
?>
<section id="<?php echo jw_business_escape($jw_latest_id); ?>" class="jw-latest jw-latest--image-list<?php echo !empty($jw_latest_embedded) ? ' jw-latest--embedded' : ''; ?>"<?php echo empty($jw_latest_embedded) ? ' aria-labelledby="'.jw_business_escape($jw_latest_id).'-title"' : ' aria-label="'.get_text($bo_subject).' 최신글"'; ?>>
    <?php if (empty($jw_latest_embedded)) { ?>
    <header class="jw-latest__header">
        <h2 id="<?php echo jw_business_escape($jw_latest_id); ?>-title"><a href="<?php echo jw_business_escape($jw_latest_url); ?>"><?php echo get_text($bo_subject); ?></a></h2>
        <a class="jw-latest__more" href="<?php echo jw_business_escape($jw_latest_url); ?>">전체 보기<i data-lucide="arrow-right"></i></a>
    </header>
    <?php } ?>

    <?php if (!$jw_latest_list) { ?>
    <p class="jw-latest__empty">등록된 게시물이 없습니다.</p>

    <?php } else { ?>
    <ul class="jw-latest-image-list">
        <?php foreach ($jw_latest_list as $item) {
            $thumb = get_list_thumbnail($bo_table, $item['wr_id'], 640, 420, false, true);
        ?>
        <li>
            <a class="jw-latest-image-list__media" href="<?php echo jw_business_escape(get_pretty_url($bo_table, $item['wr_id'])); ?>"><?php if (!empty($thumb['src'])) { ?><img src="<?php echo jw_business_escape($thumb['src']); ?>" alt="<?php echo get_text($thumb['alt'] ?? ''); ?>" width="640" height="420" loading="lazy" decoding="async"><?php } else { ?><span><i data-lucide="image"></i></span><?php } ?></a>
            <div><span><?php echo get_text($item['ca_name'] ?? '소식'); ?> · <?php echo jw_business_escape($item['datetime2']); ?></span><h3><a href="<?php echo jw_business_escape(get_pretty_url($bo_table, $item['wr_id'])); ?>"><?php echo $item['subject']; ?></a></h3><p><?php echo jw_business_escape(jw_business_excerpt($item['wr_content'] ?? '', 105)); ?></p></div>
        </li>
        <?php } ?>
    </ul>
    <?php } ?>
</section>
