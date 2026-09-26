<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/latest/featured/latest.skin.php
 * Role: 최신글 표현형 (featured)
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

include_once G5_LIB_PATH.'/thumbnail.lib.php';

$jw_latest_list = is_array($list ?? null) ? $list : array();
$jw_latest_url = get_pretty_url($bo_table);
$jw_latest_id = 'jw-latest-'.preg_replace('/[^a-z0-9_-]/i', '-', $bo_table).'-featured';
?>
<section id="<?php echo jw_business_escape($jw_latest_id); ?>" class="jw-latest jw-latest--featured<?php echo !empty($jw_latest_embedded) ? ' jw-latest--embedded' : ''; ?>"<?php echo empty($jw_latest_embedded) ? ' aria-labelledby="'.jw_business_escape($jw_latest_id).'-title"' : ' aria-label="'.get_text($bo_subject).' 최신글"'; ?>>
    <?php if (empty($jw_latest_embedded)) { ?>
    <header class="jw-latest__header">
        <h2 id="<?php echo jw_business_escape($jw_latest_id); ?>-title"><a href="<?php echo jw_business_escape($jw_latest_url); ?>"><?php echo get_text($bo_subject); ?></a></h2>
        <a class="jw-latest__more" href="<?php echo jw_business_escape($jw_latest_url); ?>">전체 보기<i data-lucide="arrow-right"></i></a>
    </header>
    <?php } ?>

    <?php if (!$jw_latest_list) { ?>
    <p class="jw-latest__empty">등록된 게시물이 없습니다.</p>

    <?php } else { ?>
    <?php
        $featured = array_shift($jw_latest_list);
        $featured_thumb = get_list_thumbnail($bo_table, $featured['wr_id'], 960, 640, false, true);
    ?>
    <div class="jw-latest-featured">
        <article class="jw-latest-featured__lead"><a class="jw-latest-featured__media" href="<?php echo jw_business_escape(get_pretty_url($bo_table, $featured['wr_id'])); ?>"><?php if (!empty($featured_thumb['src'])) { ?><img src="<?php echo jw_business_escape($featured_thumb['src']); ?>" alt="<?php echo get_text($featured_thumb['alt'] ?? ''); ?>" width="960" height="640" loading="lazy" decoding="async"><?php } else { ?><span><i data-lucide="image"></i></span><?php } ?></a><div><span><?php echo get_text($featured['ca_name'] ?? '대표 소식'); ?></span><h3><a href="<?php echo jw_business_escape(get_pretty_url($bo_table, $featured['wr_id'])); ?>"><?php echo $featured['subject']; ?></a></h3><p><?php echo jw_business_escape(jw_business_excerpt($featured['wr_content'] ?? '', 150)); ?></p><time><?php echo jw_business_escape($featured['datetime2']); ?></time></div></article>
        <ul><?php foreach ($jw_latest_list as $item) { ?><li><a href="<?php echo jw_business_escape(get_pretty_url($bo_table, $item['wr_id'])); ?>"><strong><?php echo $item['subject']; ?></strong><span><?php echo get_text($item['ca_name'] ?? '소식'); ?> · <?php echo jw_business_escape($item['datetime2']); ?></span></a></li><?php } ?></ul>
    </div>
    <?php } ?>
</section>
