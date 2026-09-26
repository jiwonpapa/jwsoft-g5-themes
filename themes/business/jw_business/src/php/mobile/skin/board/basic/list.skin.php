<?php
/**
 * Theme: JW-Business 1.0
 * File: mobile/skin/board/basic/list.skin.php
 * Role: 게시판 목록 표현형 (basic)
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

include_once G5_LIB_PATH.'/thumbnail.lib.php';

$jw_board_list = is_array($list ?? null) ? $list : array();
$jw_colspan = 5 + ($is_checkbox ? 1 : 0) + ($is_good ? 1 : 0) + ($is_nogood ? 1 : 0);
?>
<section class="jw-board-list jw-board-list--basic" aria-labelledby="jw-board-list-title">
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

        <div class="jw-board-table-wrap">
            <table class="jw-board-table">
                <caption><?php echo get_text($board['bo_subject']); ?> 목록</caption>
                <thead>
                    <tr>
                        <?php if ($is_checkbox) { ?><th class="jw-board-table__check" scope="col"><input type="checkbox" aria-label="현재 페이지 전체 선택" data-jw-check-all></th><?php } ?>
                        <th class="jw-board-table__number" scope="col">번호</th>
                        <th scope="col">제목</th>
                        <th class="jw-board-table__author" scope="col">작성자</th>
                        <th class="jw-board-table__stat" scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1); ?>조회</a></th>
                        <?php if ($is_good) { ?><th class="jw-board-table__stat" scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1); ?>추천</a></th><?php } ?>
                        <?php if ($is_nogood) { ?><th class="jw-board-table__stat" scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1); ?>비추천</a></th><?php } ?>
                        <th class="jw-board-table__date" scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1); ?>날짜</a></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($jw_board_list as $item) { ?>
                    <tr class="<?php echo $item['is_notice'] ? 'is-notice' : ''; ?><?php echo $wr_id == $item['wr_id'] ? ' is-current' : ''; ?>">
                        <?php if ($is_checkbox) { ?><td class="jw-board-table__check"><input type="checkbox" name="chk_wr_id[]" value="<?php echo (int) $item['wr_id']; ?>" aria-label="<?php echo get_text($item['wr_subject']); ?> 선택" data-jw-row-check></td><?php } ?>
                        <td class="jw-board-table__number">
                            <?php if ($item['is_notice']) { ?><span class="jw-badge">공지</span>
                            <?php } elseif ($wr_id == $item['wr_id']) { ?><span class="jw-badge jw-badge--current">열람중</span>
                            <?php } else { echo $item['num']; } ?>
                        </td>
                        <td class="jw-board-table__subject">
                            <div class="jw-board-subject<?php echo $item['reply'] ? ' is-reply' : ''; ?>">
                                <?php if ($is_category && $item['ca_name']) { ?><a class="jw-board-category" href="<?php echo jw_business_escape($item['ca_name_href']); ?>"><?php echo get_text($item['ca_name']); ?></a><?php } ?>
                                <a class="jw-board-subject__link" href="<?php echo jw_business_escape($item['href']); ?>">
                                    <?php if ($item['reply']) { ?><span aria-hidden="true">↳</span><?php } ?><span><?php echo $item['subject']; ?></span>
                                </a>
                                <?php if ($item['icon_new']) { ?><span class="jw-badge jw-badge--new">새글</span><?php } ?>
                                <?php if ($item['comment_cnt']) { ?><span class="jw-comment-count" aria-label="댓글 <?php echo (int) $item['wr_comment']; ?>개"><?php echo (int) $item['wr_comment']; ?></span><?php } ?>
                            </div>
                            <div class="jw-board-mobile-meta"><span><?php echo $item['name']; ?></span><span><?php echo $item['datetime2']; ?></span><span>조회 <?php echo number_format($item['wr_hit']); ?></span></div>
                        </td>
                        <td class="jw-board-table__author"><?php echo $item['name']; ?></td>
                        <td class="jw-board-table__stat"><?php echo number_format($item['wr_hit']); ?></td>
                        <?php if ($is_good) { ?><td class="jw-board-table__stat"><?php echo number_format($item['wr_good']); ?></td><?php } ?>
                        <?php if ($is_nogood) { ?><td class="jw-board-table__stat"><?php echo number_format($item['wr_nogood']); ?></td><?php } ?>
                        <td class="jw-board-table__date"><?php echo $item['datetime2']; ?></td>
                    </tr>
                <?php } ?>
                <?php if (!$jw_board_list) { ?><tr><td class="jw-board-empty" colspan="<?php echo $jw_colspan; ?>">등록된 게시물이 없습니다.</td></tr><?php } ?>
                </tbody>
            </table>
        </div>

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
