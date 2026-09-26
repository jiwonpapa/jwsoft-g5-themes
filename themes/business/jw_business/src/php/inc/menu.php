<?php
/**
 * Theme: JW-Business 1.0
 * File: inc/menu.php
 * Role: G5 관리자 메뉴를 출력하는 PC 공용 메뉴
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

// 메뉴의 단일 원본은 그누보드 관리자 > 환경설정 > 메뉴설정입니다.
$menu_datas = get_menu_db(0, true);
?>
<nav class="jw-nav" aria-label="주 메뉴">
    <ul class="jw-nav__list">
        <?php foreach ((array) $menu_datas as $jw_menu_index => $row) {
            if (empty($row)) continue;
            $target = isset($row['me_target']) && $row['me_target'] === 'blank' ? '_blank' : '_self';
            $children = isset($row['sub']) ? array_filter((array) $row['sub']) : array();
            $groups = jw_business_menu_groups($children);
            $has_groups = count($groups) < count($children);
        ?>
        <li class="jw-nav__item<?php echo $children ? ' has-children' : ''; ?>">
            <a class="jw-nav__link" href="<?php echo jw_business_escape($row['me_link']); ?>" target="<?php echo $target; ?>">
                <?php echo jw_business_escape($row['me_name']); ?>
                <?php if ($children) { ?><i data-lucide="chevron-down"></i><?php } ?>
            </a>
            <?php if ($children) { ?>
            <ul class="jw-nav__submenu<?php echo $has_groups ? ' jw-nav__mega' : (count($children) > 8 ? ' jw-nav__wide' : ''); ?>">
                <?php if ($has_groups) { ?>
                <li class="jw-nav__mega-intro"><strong><?php echo jw_business_escape($row['me_name']); ?></strong><span>주제를 고른 뒤 페이지를 살펴보세요.</span></li>
                <?php } ?>
                <?php foreach ($groups as $jw_group_index => $group) { ?>
                <?php if (count($group['items']) > 1) { ?>
                <li class="jw-nav__group">
                    <details name="jw-nav-group-<?php echo (int) $jw_menu_index; ?>"<?php echo $jw_group_index === 0 ? ' open' : ''; ?>>
                        <summary class="jw-nav__group-title"><span><?php echo jw_business_escape($group['title']); ?></span><small><?php echo count($group['items']); ?>개 페이지</small><i data-lucide="chevron-down" aria-hidden="true"></i></summary>
                    <ul class="jw-nav__variants">
                        <?php foreach ($group['items'] as $row2) { ?>
                        <li><a href="<?php echo jw_business_escape($row2['me_link']); ?>" target="<?php echo ($row2['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row2['display_name'] ?? $row2['me_name']); ?></a></li>
                        <?php } ?>
                    </ul>
                    </details>
                </li>
                <?php } else { $row2 = $group['items'][0]; ?>
                <li><a href="<?php echo jw_business_escape($row2['me_link']); ?>" target="<?php echo ($row2['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row2['me_name']); ?></a></li>
                <?php } ?>
                <?php } ?>
            </ul>
            <?php } ?>
        </li>
        <?php } ?>
        <?php if (!$menu_datas) { ?>
        <li class="jw-nav__empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자 메뉴설정</a><?php } ?></li>
        <?php } ?>
    </ul>
</nav>
