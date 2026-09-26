<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/board/gallery/list.skin.php
 * Role: 게시판 목록 표현형 (gallery)
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

include_once G5_LIB_PATH.'/thumbnail.lib.php';

$jw_board_list = is_array($list ?? null) ? $list : array();
?>
<section class="jw-board-list jw-board-list--gallery" aria-labelledby="jw-board-list-title">
    <h2 id="jw-board-list-title" class="sound_only"><?php echo get_text($board['bo_subject']); ?> 목록</h2>

    <?php if ($is_category) { ?>
    <nav class="jw-board-categories" aria-label="<?php echo get_text($board['bo_subject']); ?> 분류">
        <ul><?php echo $category_option; ?></ul>
    </nav>
    <?php } ?>

    <form name="fboardlist" class="jw-board-form" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" method="post" data-jw-board-list>
        <input type="hidden" name="bo_table" value="<?php echo jw_business_escape($bo_table); ?>">
        <input type="hidden" name="sfl" value="<?php echo jw_business_escape($sfl); ?>">
        <input type="hidden" name="stx" value="<?php echo jw_business_escape($stx); ?>">
        <input type="hidden" name="spt" value="<?php echo jw_business_escape($spt); ?>">
        <input type="hidden" name="sca" value="<?php echo jw_business_escape($sca); ?>">
        <input type="hidden" name="sst" value="<?php echo jw_business_escape($sst); ?>">
        <input type="hidden" name="sod" value="<?php echo jw_business_escape($sod); ?>">
        <input type="hidden" name="page" value="<?php echo (int) $page; ?>">
        <input type="hidden" name="sw" value="">

        <div class="jw-board-toolbar">
            <p class="jw-board-count"><strong><?php echo number_format($total_count); ?></strong>개의 글 <span><?php echo number_format($page); ?>페이지</span></p>
            <div class="jw-board-actions">
                <?php if ($rss_href) { ?><a class="jw-control jw-control--quiet" href="<?php echo jw_business_escape($rss_href); ?>">RSS</a><?php } ?>
                <?php if ($admin_href) { ?><a class="jw-control jw-control--quiet" href="<?php echo jw_business_escape($admin_href); ?>">관리</a><?php } ?>
                <?php if ($is_checkbox) { ?>
                <details class="jw-action-menu">
                    <summary class="jw-control jw-control--quiet">선택 작업</summary>
                    <div class="jw-action-menu__panel">
                        <button type="submit" name="btn_submit" value="선택삭제" data-jw-list-action="delete">선택삭제</button>
                        <button type="submit" name="btn_submit" value="선택복사" data-jw-list-action="copy">선택복사</button>
                        <button type="submit" name="btn_submit" value="선택이동" data-jw-list-action="move">선택이동</button>
                    </div>
                </details>
                <?php } ?>
                <?php if ($write_href) { ?><a class="jw-control jw-control--primary" href="<?php echo jw_business_escape($write_href); ?>">글쓰기</a><?php } ?>
            </div>
        </div>

        <?php if ($is_checkbox) { ?>
        <label class="jw-board-select-all"><input type="checkbox" data-jw-check-all> 현재 목록 전체 선택</label>
        <?php } ?>

        <ul class="jw-content-grid jw-content-grid--gallery">
            <?php foreach ($jw_board_list as $item) {
                $secret = strpos((string) ($item['wr_option'] ?? ''), 'secret') !== false;
                $thumb = $secret ? array() : get_list_thumbnail($bo_table, $item['wr_id'], 960, 720, false, true);
            ?>
            <li class="jw-content-card">
                <?php if ($is_checkbox) { ?><input class="jw-content-card__check" type="checkbox" name="chk_wr_id[]" value="<?php echo (int) $item['wr_id']; ?>" aria-label="<?php echo get_text($item['wr_subject']); ?> 선택" data-jw-row-check><?php } ?>
                <a class="jw-content-card__media" href="<?php echo jw_business_escape($item['href']); ?>">
                    <?php if (!empty($thumb['src'])) { ?><img src="<?php echo jw_business_escape($thumb['src']); ?>" alt="<?php echo get_text($thumb['alt'] ?? ''); ?>" width="960" height="720" loading="lazy" decoding="async">
                    <?php } else { ?><span><i data-lucide="<?php echo $secret ? 'lock' : 'image'; ?>"></i><?php echo $secret ? '비밀 게시물' : '등록된 이미지가 없습니다'; ?></span><?php } ?>

                </a>
                <div class="jw-content-card__body">
                    <div class="jw-content-card__labels"><?php if ($item['is_notice']) { ?><span class="jw-badge">공지</span><?php } ?><?php if ($is_category && $item['ca_name']) { ?><a class="jw-board-category" href="<?php echo jw_business_escape($item['ca_name_href']); ?>"><?php echo get_text($item['ca_name']); ?></a><?php } ?></div>
                    <h3><a href="<?php echo jw_business_escape($item['href']); ?>"><?php echo $item['subject']; ?></a></h3>

                    <div class="jw-content-card__meta"><span><?php echo $item['name']; ?></span><time><?php echo $item['datetime2']; ?></time><span>조회 <?php echo number_format($item['wr_hit']); ?></span></div>
                </div>
            </li>
            <?php } ?>
        </ul>

        <?php if (!$jw_board_list) { ?><p class="jw-board-empty">등록된 게시물이 없습니다.</p><?php } ?>
        <div class="jw-pagination"><?php echo $write_pages; ?></div>
    </form>

    <details class="jw-board-search"<?php echo $stx ? ' open' : ''; ?>>
        <summary>게시판 검색</summary>
        <form method="get" class="jw-board-search__form">
            <input type="hidden" name="bo_table" value="<?php echo jw_business_escape($bo_table); ?>">
            <input type="hidden" name="sca" value="<?php echo jw_business_escape($sca); ?>">
            <input type="hidden" name="sop" value="and">
            <label class="sound_only" for="jw-board-sfl">검색 대상</label>
            <select name="sfl" id="jw-board-sfl"><?php echo get_board_sfl_select_options($sfl); ?></select>
            <label class="sound_only" for="jw-board-stx">검색어</label>
            <input type="search" name="stx" id="jw-board-stx" value="<?php echo jw_business_escape($stx); ?>" required maxlength="20" placeholder="검색어를 입력하세요">
            <button class="jw-control jw-control--primary" type="submit">검색</button>
        </form>
    </details>
</section>
