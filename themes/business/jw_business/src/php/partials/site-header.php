<?php
if (!defined('_GNUBOARD_')) exit;

$jw_settings = jw_business_settings();
$menu_datas = jw_business_navigation();
?>
<a class="jw-skip-link" href="#jw-main">본문 바로가기</a>
<header class="jw-header" data-jw-sticky-header>

    <div class="jw-header__inner">
        <a class="jw-brand" href="<?php echo G5_URL; ?>">
            <?php include G5_THEME_PATH.'/partials/brand-image.php'; ?>
        </a>

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
                    <ul class="jw-nav__submenu<?php echo array_filter($children, static function ($item) { return !empty($item['sub']); }) ? ' jw-nav__mega' : ''; ?>">
                        <?php foreach ($children as $row2) {
                            $target2 = isset($row2['me_target']) && $row2['me_target'] === 'blank' ? '_blank' : '_self';
                            $grandchildren = isset($row2['sub']) ? array_filter((array) $row2['sub']) : array();
                        ?>
                        <li class="<?php echo $grandchildren ? 'jw-nav__group' : ''; ?>">
                            <a class="<?php echo $grandchildren ? 'jw-nav__group-title' : ''; ?>" href="<?php echo jw_business_escape($row2['me_link']); ?>" target="<?php echo $target2; ?>"><?php echo jw_business_escape($row2['me_name']); ?></a>
                            <?php if ($grandchildren) { ?>
                            <ul class="jw-nav__variants">
                                <?php foreach ($grandchildren as $row3) { ?>
                                <li><a href="<?php echo jw_business_escape($row3['me_link']); ?>" target="<?php echo isset($row3['me_target']) && $row3['me_target'] === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row3['me_name']); ?></a></li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
        </nav>

        <div class="jw-header__actions">
            <a class="jw-icon-button jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/search.php" aria-label="사이트 검색"><i data-lucide="search"></i></a>
            <button type="button" class="jw-icon-button jw-desktop-action" data-jw-theme-toggle aria-label="다크 모드로 전환" aria-pressed="false"><i data-lucide="moon"></i></button>
            <?php if ($is_member) { ?>
            <a class="jw-account-link jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=<?php echo G5_BBS_URL; ?>/register_form.php">내 정보</a>
            <a class="jw-account-link jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/logout.php">로그아웃</a>
            <?php } else { ?>
            <a class="jw-account-link jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/login.php">로그인</a>
            <?php } ?>
            <a class="tw:d-btn tw:d-btn-primary jw-header__cta jw-desktop-action" href="<?php echo G5_BBS_URL; ?>/qalist.php">문의하기</a>
            <a class="jw-mobile-contact" href="<?php echo G5_BBS_URL; ?>/qalist.php">문의</a>
            <button type="button" class="jw-menu-button" data-jw-menu-open aria-label="전체 메뉴 열기" aria-controls="jw-mobile-menu" aria-expanded="false"><i data-lucide="menu"></i><span>메뉴</span></button>
        </div>
    </div>

    <?php
    $jw_mobile_groups = array_values(array_filter((array) $menu_datas));
    // Parent destinations are retained only when they are not already listed below.
    $jw_menu_urls = static function ($rows) use (&$jw_menu_urls) {
        $urls = array();
        foreach ($rows as $item) {
            $urls[] = $item['me_link'] ?? '';
            $urls = array_merge($urls, $jw_menu_urls((array) ($item['sub'] ?? array())));
        }
        return $urls;
    };
    ?>
    <dialog id="jw-mobile-menu" class="jw-mobile-menu" data-jw-mobile-menu aria-labelledby="jw-mobile-menu-title">
        <div class="jw-mobile-menu__panel">
            <div class="jw-mobile-menu__head">
                <strong id="jw-mobile-menu-title">전체 메뉴</strong>
                <button type="button" class="jw-mobile-menu__close" data-jw-menu-close aria-label="전체 메뉴 닫기"><span>닫기</span><i data-lucide="x"></i></button>
            </div>
            <div class="jw-mobile-menu__body<?php echo !array_filter($jw_mobile_groups, static function ($item) { return !empty($item['sub']); }) ? ' jw-mobile-menu__body--simple' : ''; ?>">
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
                        <?php if (!in_array($row['me_link'], $jw_menu_urls($children), true)) { ?>
                        <a class="jw-mobile-menu__destination" href="<?php echo jw_business_escape($row['me_link']); ?>" target="<?php echo ($row['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row['me_name']); ?> 안내<i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                        <?php } ?>
                        <ul class="jw-mobile-menu__groups">
                            <?php foreach ($children as $row2) {
                                $variants = array_filter((array) ($row2['sub'] ?? array()));
                            ?>
                            <li>
                                <?php if ($variants) { ?>
                                <details data-jw-menu-group>
                                    <summary><?php echo jw_business_escape($row2['me_name']); ?><i data-lucide="chevron-down" aria-hidden="true"></i></summary>
                                    <ul class="jw-mobile-menu__links">
                                        <?php if (!in_array($row2['me_link'], $jw_menu_urls($variants), true)) { ?>
                                        <li><a href="<?php echo jw_business_escape($row2['me_link']); ?>" target="<?php echo ($row2['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row2['me_name']); ?> 안내</a></li>
                                        <?php } ?>
                                        <?php foreach ($variants as $row3) { ?>
                                        <li><a href="<?php echo jw_business_escape($row3['me_link']); ?>" target="<?php echo ($row3['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row3['me_name']); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </details>
                                <?php } else { ?>
                                <a class="jw-mobile-menu__destination" href="<?php echo jw_business_escape($row2['me_link']); ?>" target="<?php echo ($row2['me_target'] ?? '') === 'blank' ? '_blank' : '_self'; ?>"><?php echo jw_business_escape($row2['me_name']); ?><i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
                                <?php } ?>
                            </li>
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
</header>
