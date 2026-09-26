<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/latest/image-grid/latest.skin.php
 * Role: 최신글 표현형 (image-grid)
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

include_once G5_LIB_PATH.'/thumbnail.lib.php';

$jw_latest_list = is_array($list ?? null) ? $list : array();
$jw_latest_url = get_pretty_url($bo_table);
$jw_latest_id = 'jw-latest-'.preg_replace('/[^a-z0-9_-]/i', '-', $bo_table).'-image-grid';
?>
<section id="<?php echo jw_business_escape($jw_latest_id); ?>" class="jw-latest jw-latest--image-grid<?php echo !empty($jw_latest_embedded) ? ' jw-latest--embedded' : ''; ?>"<?php echo empty($jw_latest_embedded) ? ' aria-labelledby="'.jw_business_escape($jw_latest_id).'-title"' : ' aria-label="'.get_text($bo_subject).' 최신글"'; ?>>
    <?php if (empty($jw_latest_embedded)) { ?>
    <header class="jw-latest__header">
        <h2 id="<?php echo jw_business_escape($jw_latest_id); ?>-title"><a href="<?php echo jw_business_escape($jw_latest_url); ?>"><?php echo get_text($bo_subject); ?></a></h2>
        <a class="jw-latest__more" href="<?php echo jw_business_escape($jw_latest_url); ?>">전체 보기<i data-lucide="arrow-right"></i></a>
    </header>
    <?php } ?>

    <?php if (!$jw_latest_list) { ?>
    <p class="jw-latest__empty">등록된 게시물이 없습니다.</p>

    <?php } else { ?>
    <ul class="jw-latest-image-grid">
        <?php foreach ($jw_latest_list as $item) {
            $thumb = get_list_thumbnail($bo_table, $item['wr_id'], 720, 540, false, true);
        ?>
        <li><a href="<?php echo jw_business_escape(get_pretty_url($bo_table, $item['wr_id'])); ?>"><span class="jw-latest-image-grid__media"><?php if (!empty($thumb['src'])) { ?><img src="<?php echo jw_business_escape($thumb['src']); ?>" alt="<?php echo get_text($thumb['alt'] ?? ''); ?>" width="720" height="540" loading="lazy" decoding="async"><?php } else { ?><i data-lucide="image"></i><?php } ?></span><span class="jw-latest-image-grid__body"><small><?php echo get_text($item['ca_name'] ?? '갤러리'); ?></small><strong><?php echo $item['subject']; ?></strong><time><?php echo jw_business_escape($item['datetime2']); ?></time></span></a></li>
        <?php } ?>
    </ul>
    <?php } ?>
</section>
