<?php
/**
 * Theme: JW-Business 1.0
 * File: mobile/skin/latest/tabs/latest.skin.php
 * Role: 최신글 표현형 (tabs)
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

include_once G5_LIB_PATH.'/thumbnail.lib.php';

$jw_latest_list = is_array($list ?? null) ? $list : array();
$jw_latest_url = get_pretty_url($bo_table);
$jw_latest_id = 'jw-latest-'.preg_replace('/[^a-z0-9_-]/i', '-', $bo_table).'-tabs';
?>
<section id="<?php echo jw_business_escape($jw_latest_id); ?>" class="jw-latest jw-latest--tabs<?php echo !empty($jw_latest_embedded) ? ' jw-latest--embedded' : ''; ?>"<?php echo empty($jw_latest_embedded) ? ' aria-labelledby="'.jw_business_escape($jw_latest_id).'-title"' : ' aria-label="'.get_text($bo_subject).' 최신글"'; ?>>
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
        $jw_tab_groups = array();
        foreach ($jw_latest_list as $item) {
            $key = trim((string) ($item['ca_name'] ?? '')) ?: '전체';
            $jw_tab_groups[$key][] = $item;
        }
    ?>
    <div class="jw-latest-tabs" data-jw-latest-tabs>
        <div class="jw-latest-tabs__list" role="tablist" aria-label="<?php echo get_text($bo_subject); ?> 분류">
            <?php foreach (array_keys($jw_tab_groups) as $index => $label) { ?><button type="button" role="tab" id="<?php echo jw_business_escape($jw_latest_id); ?>-tab-<?php echo $index; ?>" aria-controls="<?php echo jw_business_escape($jw_latest_id); ?>-panel-<?php echo $index; ?>" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>" tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"><?php echo get_text($label); ?></button><?php } ?>
        </div>
        <?php foreach ($jw_tab_groups as $label => $items) { $index = array_search($label, array_keys($jw_tab_groups), true); ?>
        <div class="jw-latest-tabs__panel" id="<?php echo jw_business_escape($jw_latest_id); ?>-panel-<?php echo $index; ?>" role="tabpanel" aria-labelledby="<?php echo jw_business_escape($jw_latest_id); ?>-tab-<?php echo $index; ?>"<?php echo $index === 0 ? '' : ' hidden'; ?>><ul><?php foreach ($items as $item) { ?><li><a href="<?php echo jw_business_escape(get_pretty_url($bo_table, $item['wr_id'])); ?>"><strong><?php echo $item['subject']; ?></strong><time><?php echo jw_business_escape($item['datetime2']); ?></time></a></li><?php } ?></ul></div>
        <?php } ?>
    </div>
    <?php } ?>
</section>
