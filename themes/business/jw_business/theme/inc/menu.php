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
        <?php foreach ((array) $menu_datas as $row) {
            if (empty($row)) continue;
            $target = isset($row['me_target']) && $row['me_target'] === 'blank' ? '_blank' : '_self';
            $children = isset($row['sub']) ? array_filter((array) $row['sub']) : array();
        ?>
        <li class="jw-nav__item<?php echo $children ? ' has-children' : ''; ?>">
            <a class="jw-nav__link" href="<?php echo jw_business_escape($row['me_link']); ?>" target="<?php echo $target; ?>">
                <?php echo jw_business_escape($row['me_name']); ?>
                <?php if ($children) { ?><i data-lucide="chevron-down"></i><?php } ?>
            </a>
            <?php if ($children) { ?>
            <ul class="jw-nav__submenu">
                <?php foreach ($children as $row2) {
                    $target2 = isset($row2['me_target']) && $row2['me_target'] === 'blank' ? '_blank' : '_self';
                ?>
                <li><a href="<?php echo jw_business_escape($row2['me_link']); ?>" target="<?php echo $target2; ?>"><?php echo jw_business_escape($row2['me_name']); ?></a></li>
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
