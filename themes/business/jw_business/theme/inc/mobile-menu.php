<?php
/**
 * Theme: JW-Business 1.0
 * File: inc/mobile-menu.php
 * Role: G5 관리자 메뉴를 출력하는 모바일 공용 메뉴
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

// 모바일용 노출 설정을 존중하며 PC 메뉴와 별도로 G5 메뉴 DB를 조회합니다.
$jw_mobile_groups = array_values(array_filter((array) get_menu_db(1, true)));
?>
<dialog id="jw-mobile-menu" class="jw-mobile-menu" data-jw-mobile-menu aria-labelledby="jw-mobile-menu-title">
    <div class="jw-mobile-menu__panel">
        <div class="jw-mobile-menu__head">
            <strong id="jw-mobile-menu-title">전체 메뉴</strong>
            <button type="button" class="jw-mobile-menu__close" data-jw-menu-close aria-label="전체 메뉴 닫기"><span>닫기</span><i data-lucide="x"></i></button>
        </div>
        <div class="jw-mobile-menu__body<?php echo !$jw_mobile_groups ? ' jw-mobile-menu__body--simple' : ''; ?>">
            <nav class="jw-mobile-menu__categories" aria-label="메뉴 대분류">
                <?php foreach ($jw_mobile_groups as $index => $row) {
                    $children = array_filter((array) ($row['sub'] ?? array()));
                ?>
                <?php if ($children) { ?>
                <button type="button" id="jw-menu-category-<?php echo $index; ?>" data-jw-menu-category="<?php echo $index; ?>" aria-controls="jw-menu-section-<?php echo $index; ?>" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>"><?php echo jw_business_escape($row['me_name']); ?></button>
                <?php } else { ?>
                <a href="<?php echo jw_business_escape($row['me_link']); ?>" target="<?php echo ($row['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row['me_name']); ?></a>
                <?php } ?>
                <?php } ?>
            </nav>
            <nav class="jw-mobile-menu__content" aria-label="모바일 하위 메뉴" data-jw-menu-content>
                <?php foreach ($jw_mobile_groups as $index => $row) {
                    $children = array_filter((array) ($row['sub'] ?? array()));
                    if (!$children) continue;
                ?>
                <section id="jw-menu-section-<?php echo $index; ?>" data-jw-menu-section="<?php echo $index; ?>" aria-labelledby="jw-menu-heading-<?php echo $index; ?>"<?php echo $index !== 0 ? ' hidden' : ''; ?>>
                    <h2 id="jw-menu-heading-<?php echo $index; ?>"><?php echo jw_business_escape($row['me_name']); ?></h2>
                    <a class="jw-mobile-menu__destination" href="<?php echo jw_business_escape($row['me_link']); ?>" target="<?php echo ($row['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row['me_name']); ?> 안내<i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                    <ul class="jw-mobile-menu__groups">
                        <?php foreach ($children as $row2) { ?>
                        <li><a class="jw-mobile-menu__destination" href="<?php echo jw_business_escape($row2['me_link']); ?>" target="<?php echo ($row2['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row2['me_name']); ?><i data-lucide="arrow-up-right" aria-hidden="true"></i></a></li>
                        <?php } ?>
                    </ul>
                </section>
                <?php } ?>
                <?php if (!$jw_mobile_groups) { ?><p>등록된 메뉴가 없습니다.</p><?php } ?>
            </nav>
        </div>
        <div class="jw-mobile-menu__footer">
            <div class="jw-mobile-menu__utilities">
                <a href="<?php echo G5_BBS_URL; ?>/search.php"><i data-lucide="search"></i>검색</a>
                <?php if ($is_member) { ?>
                <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=<?php echo G5_BBS_URL; ?>/register_form.php"><i data-lucide="user-round"></i>내 정보</a>
                <a href="<?php echo G5_BBS_URL; ?>/logout.php">로그아웃</a>
                <?php } else { ?>
                <a href="<?php echo G5_BBS_URL; ?>/login.php"><i data-lucide="user-round"></i>로그인</a>
                <a href="<?php echo G5_BBS_URL; ?>/register.php">회원가입</a>
                <?php } ?>
                <button type="button" data-jw-theme-toggle aria-label="다크 모드로 전환" aria-pressed="false"><i data-lucide="moon"></i><span data-jw-theme-label>다크 모드</span></button>
            </div>
            <a class="jw-control jw-control--primary jw-mobile-menu__contact" href="<?php echo G5_BBS_URL; ?>/qalist.php">문의하기<i data-lucide="arrow-up-right"></i></a>
        </div>
    </div>
</dialog>
