<?php
/**
 * Theme: JW-Business 1.0
 * File: mobile/skin/latest/video/latest.skin.php
 * Role: 최신글 표현형 (video)
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

include_once G5_LIB_PATH.'/thumbnail.lib.php';

$jw_latest_list = is_array($list ?? null) ? $list : array();
$jw_latest_url = get_pretty_url($bo_table);
$jw_latest_id = 'jw-latest-'.preg_replace('/[^a-z0-9_-]/i', '-', $bo_table).'-video';
?>
<section id="<?php echo jw_business_escape($jw_latest_id); ?>" class="jw-latest jw-latest--video<?php echo !empty($jw_latest_embedded) ? ' jw-latest--embedded' : ''; ?>"<?php echo empty($jw_latest_embedded) ? ' aria-labelledby="'.jw_business_escape($jw_latest_id).'-title"' : ' aria-label="'.get_text($bo_subject).' 최신글"'; ?>>
    <?php if (empty($jw_latest_embedded)) { ?>
    <header class="jw-latest__header">
        <h2 id="<?php echo jw_business_escape($jw_latest_id); ?>-title"><a href="<?php echo jw_business_escape($jw_latest_url); ?>"><?php echo get_text($bo_subject); ?></a></h2>
        <a class="jw-latest__more" href="<?php echo jw_business_escape($jw_latest_url); ?>">전체 보기<i data-lucide="arrow-right"></i></a>
    </header>
    <?php } ?>

    <?php if (!$jw_latest_list) { ?>
    <p class="jw-latest__empty">등록된 게시물이 없습니다.</p>

    <?php } else { ?>
    <ul class="jw-latest-video-grid">
        <?php foreach ($jw_latest_list as $item) {
            $thumb = get_list_thumbnail($bo_table, $item['wr_id'], 960, 540, false, true);
            $video = jw_business_video_source($item);
            $poster = !empty($thumb['src']) ? $thumb['src'] : $video['poster'];
        ?>
        <li><a href="<?php echo jw_business_escape(get_pretty_url($bo_table, $item['wr_id'])); ?>"><span class="jw-latest-video-grid__media"><?php if ($poster) { ?><img src="<?php echo jw_business_escape($poster); ?>" alt="<?php echo get_text($thumb['alt'] ?? $item['wr_subject']); ?>" width="960" height="540" loading="lazy" decoding="async"><?php } else { ?><i data-lucide="monitor"></i><?php } ?><em><i data-lucide="play"></i></em></span><span class="jw-latest-video-grid__body"><small><?php echo jw_business_escape($video['provider']); ?></small><strong><?php echo $item['subject']; ?></strong><time><?php echo jw_business_escape($item['datetime2']); ?></time></span></a></li>
        <?php } ?>
    </ul>
    <?php } ?>
</section>
