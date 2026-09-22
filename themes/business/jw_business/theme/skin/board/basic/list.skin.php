<?php
if (!defined('_GNUBOARD_')) exit;

$colspan = 5 + ($is_checkbox ? 1 : 0) + ($is_good ? 1 : 0) + ($is_nogood ? 1 : 0);
?>
<section class="jw-board-list" aria-labelledby="jw-board-list-title">
    <h2 id="jw-board-list-title" class="sound_only"><?php echo get_text($board['bo_subject']); ?> 목록</h2>

    <?php if ($is_category) { ?>
    <nav class="jw-board-categories" aria-label="<?php echo get_text($board['bo_subject']); ?> 분류">
        <ul><?php echo $category_option; ?></ul>
    </nav>
    <?php } ?>

    <form name="fboardlist" class="jw-board-form" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" method="post" data-jw-board-list>
        <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
        <input type="hidden" name="stx" value="<?php echo $stx; ?>">
        <input type="hidden" name="spt" value="<?php echo $spt; ?>">
        <input type="hidden" name="sca" value="<?php echo $sca; ?>">
        <input type="hidden" name="sst" value="<?php echo $sst; ?>">
        <input type="hidden" name="sod" value="<?php echo $sod; ?>">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="hidden" name="sw" value="">

        <div class="jw-board-toolbar">
            <p class="jw-board-count"><strong><?php echo number_format($total_count); ?></strong>개의 글 <span><?php echo number_format($page); ?>페이지</span></p>
            <div class="jw-board-actions">
                <?php if ($rss_href) { ?><a class="jw-control jw-control--quiet" href="<?php echo $rss_href; ?>">RSS</a><?php } ?>
                <?php if ($admin_href) { ?><a class="jw-control jw-control--quiet" href="<?php echo $admin_href; ?>">관리</a><?php } ?>
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
                <?php if ($write_href) { ?><a class="jw-control jw-control--primary" href="<?php echo $write_href; ?>">글쓰기</a><?php } ?>
            </div>
        </div>

        <?php if (!empty($jw_gallery)) { include G5_THEME_PATH.'/skin/board/gallery/cards.php'; } else { ?>
        <div class="jw-board-table-wrap">
            <table class="jw-board-table">
                <caption><?php echo get_text($board['bo_subject']); ?> 목록</caption>
                <thead>
                    <tr>
                        <?php if ($is_checkbox) { ?>
                        <th class="jw-board-table__check" scope="col"><input type="checkbox" aria-label="현재 페이지 전체 선택" data-jw-check-all></th>
                        <?php } ?>
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
                <?php for ($i = 0; $i < count($list); $i++) { ?>
                    <tr class="<?php echo $list[$i]['is_notice'] ? 'is-notice' : ''; ?><?php echo $wr_id == $list[$i]['wr_id'] ? ' is-current' : ''; ?>">
                        <?php if ($is_checkbox) { ?>
                        <td class="jw-board-table__check"><input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id']; ?>" aria-label="<?php echo get_text($list[$i]['subject']); ?> 선택" data-jw-row-check></td>
                        <?php } ?>
                        <td class="jw-board-table__number">
                            <?php if ($list[$i]['is_notice']) { ?><span class="jw-badge">공지</span>
                            <?php } elseif ($wr_id == $list[$i]['wr_id']) { ?><span class="jw-badge jw-badge--current">열람중</span>
                            <?php } else { echo $list[$i]['num']; } ?>
                        </td>
                        <td class="jw-board-table__subject">
                            <div class="jw-board-subject<?php echo $list[$i]['reply'] ? ' is-reply' : ''; ?>">
                                <?php if ($is_category && $list[$i]['ca_name']) { ?><a class="jw-board-category" href="<?php echo $list[$i]['ca_name_href']; ?>"><?php echo get_text($list[$i]['ca_name']); ?></a><?php } ?>
                                <a class="jw-board-subject__link" href="<?php echo $list[$i]['href']; ?>">
                                    <?php if ($list[$i]['reply']) { ?><span aria-hidden="true">↳</span><?php } ?>
                                    <span><?php echo $list[$i]['subject']; ?></span>
                                </a>
                                <?php if ($list[$i]['icon_new']) { ?><span class="jw-badge jw-badge--new">새글</span><?php } ?>
                                <?php if ($list[$i]['comment_cnt']) { ?><span class="jw-comment-count" aria-label="댓글 <?php echo (int)$list[$i]['wr_comment']; ?>개"><?php echo (int)$list[$i]['wr_comment']; ?></span><?php } ?>
                            </div>
                            <div class="jw-board-mobile-meta">
                                <span><?php echo $list[$i]['name']; ?></span>
                                <span><?php echo $list[$i]['datetime2']; ?></span>
                                <span>조회 <?php echo number_format($list[$i]['wr_hit']); ?></span>
                            </div>
                        </td>
                        <td class="jw-board-table__author"><?php echo $list[$i]['name']; ?></td>
                        <td class="jw-board-table__stat"><?php echo number_format($list[$i]['wr_hit']); ?></td>
                        <?php if ($is_good) { ?><td class="jw-board-table__stat"><?php echo number_format($list[$i]['wr_good']); ?></td><?php } ?>
                        <?php if ($is_nogood) { ?><td class="jw-board-table__stat"><?php echo number_format($list[$i]['wr_nogood']); ?></td><?php } ?>
                        <td class="jw-board-table__date"><?php echo $list[$i]['datetime2']; ?></td>
                    </tr>
                <?php } ?>
                <?php if (!$list) { ?><tr><td class="jw-board-empty" colspan="<?php echo $colspan; ?>">등록된 게시물이 없습니다.</td></tr><?php } ?>
                </tbody>
            </table>
        </div>

        <?php } ?>
        <div class="jw-pagination"><?php echo $write_pages; ?></div>
    </form>

    <details class="jw-board-search"<?php echo $stx ? ' open' : ''; ?>>
        <summary>게시판 검색</summary>
        <form method="get" class="jw-board-search__form">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
            <input type="hidden" name="sca" value="<?php echo $sca; ?>">
            <input type="hidden" name="sop" value="and">
            <label class="sound_only" for="jw-board-sfl">검색 대상</label>
            <select name="sfl" id="jw-board-sfl"><?php echo get_board_sfl_select_options($sfl); ?></select>
            <label class="sound_only" for="jw-board-stx">검색어</label>
            <input type="search" name="stx" value="<?php echo get_text(stripslashes($stx)); ?>" required id="jw-board-stx" maxlength="20" placeholder="검색어를 입력하세요">
            <button class="jw-control jw-control--primary" type="submit">검색</button>
        </form>
    </details>
</section>
