<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$jw_view_title = get_text($view['wr_subject']);
$jw_view_files = isset($view['file']) && is_array($view['file']) ? array_filter($view['file'], 'is_array') : array();
?>
<article class="jw-board-view">
    <header class="jw-board-view__header">
        <?php if ($category_name) { ?><span class="jw-board-category"><?php echo get_text($view['ca_name']); ?></span><?php } ?>
        <h2><?php echo $jw_view_title; ?></h2>
        <dl class="jw-board-view__meta">
            <div><dt>작성자</dt><dd><?php echo $view['name']; ?><?php if ($is_ip_view) { ?> <span>(<?php echo $ip; ?>)</span><?php } ?></dd></div>
            <div><dt>작성일</dt><dd><time datetime="<?php echo date('c', strtotime($view['wr_datetime'])); ?>"><?php echo date('Y.m.d H:i', strtotime($view['wr_datetime'])); ?></time></dd></div>
            <div><dt>조회</dt><dd><?php echo number_format($view['wr_hit']); ?></dd></div>
            <div><dt>댓글</dt><dd><?php echo number_format($view['wr_comment']); ?></dd></div>
        </dl>
        <div class="jw-board-actions jw-board-view__actions">
            <a class="jw-control jw-control--quiet" href="<?php echo $list_href; ?>">목록</a>
            <?php if ($reply_href) { ?><a class="jw-control jw-control--quiet" href="<?php echo $reply_href; ?>">답변</a><?php } ?>
            <?php if ($write_href) { ?><a class="jw-control jw-control--primary" href="<?php echo $write_href; ?>">글쓰기</a><?php } ?>
            <?php if ($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
            <details class="jw-action-menu">
                <summary class="jw-control jw-control--quiet">더보기</summary>
                <div class="jw-action-menu__panel">
                    <?php if ($update_href) { ?><a href="<?php echo $update_href; ?>">수정</a><?php } ?>
                    <?php if ($delete_href) { ?><a href="<?php echo $delete_href; ?>" data-jw-confirm="이 게시물을 삭제하시겠습니까?">삭제</a><?php } ?>
                    <?php if ($copy_href) { ?><a href="<?php echo $copy_href; ?>" data-jw-popup-link="boardmove">복사</a><?php } ?>
                    <?php if ($move_href) { ?><a href="<?php echo $move_href; ?>" data-jw-popup-link="boardmove">이동</a><?php } ?>
                    <?php if ($search_href) { ?><a href="<?php echo $search_href; ?>">검색</a><?php } ?>
                </div>
            </details>
            <?php } ?>
        </div>
    </header>

    <section class="jw-board-view__body" aria-label="본문">
        <?php
        if ($jw_view_files) {
            echo '<div class="jw-board-view__images">';
            foreach ($jw_view_files as $view_file) echo get_file_thumbnail($view_file);
            echo '</div>';
        }
        ?>
        <div class="jw-board-view__content"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php if ($is_signature) { ?><div class="jw-board-view__signature"><?php echo $signature; ?></div><?php } ?>

        <?php if ($good_href || $nogood_href || $board['bo_use_good'] || $board['bo_use_nogood']) { ?>
        <div class="jw-board-reactions">
            <?php if ($good_href) { ?><a href="<?php echo $good_href.'&amp;'.$qstr; ?>" data-jw-reaction><span>추천</span><strong><?php echo number_format($view['wr_good']); ?></strong></a>
            <?php } elseif ($board['bo_use_good']) { ?><span><span>추천</span><strong><?php echo number_format($view['wr_good']); ?></strong></span><?php } ?>
            <?php if ($nogood_href) { ?><a href="<?php echo $nogood_href.'&amp;'.$qstr; ?>" data-jw-reaction><span>비추천</span><strong><?php echo number_format($view['wr_nogood']); ?></strong></a>
            <?php } elseif ($board['bo_use_nogood']) { ?><span><span>비추천</span><strong><?php echo number_format($view['wr_nogood']); ?></strong></span><?php } ?>
        </div>
        <?php } ?>
    </section>

    <?php
    $jw_downloads = array();
    foreach ($jw_view_files as $view_file) {
        if (!empty($view_file['source']) && empty($view_file['view'])) $jw_downloads[] = $view_file;
    }
    ?>
    <?php if ($jw_downloads) { ?>
    <section class="jw-board-resources">
        <h3>첨부파일</h3>
        <ul>
        <?php foreach ($jw_downloads as $view_file) { ?>
            <li>
                <a href="<?php echo $view_file['href']; ?>" data-jw-download data-member="<?php echo $is_member ? 'true' : 'false'; ?>" data-point="<?php echo (int)$board['bo_download_point']; ?>">
                    <strong><?php echo get_text($view_file['source']); ?></strong>
                    <span><?php echo $view_file['size']; ?> · 다운로드 <?php echo number_format($view_file['download']); ?>회</span>
                </a>
            </li>
        <?php } ?>
        </ul>
    </section>
    <?php } ?>

    <?php if (isset($view['link']) && array_filter($view['link'])) { ?>
    <section class="jw-board-resources">
        <h3>관련 링크</h3>
        <ul>
        <?php for ($i = 1; $i <= count($view['link']); $i++) {
            if (empty($view['link'][$i])) continue; ?>
            <li><a href="<?php echo $view['link_href'][$i]; ?>" target="_blank" rel="noopener"><strong><?php echo cut_str($view['link'][$i], 70); ?></strong><span>연결 <?php echo number_format($view['link_hit'][$i]); ?>회</span></a></li>
        <?php } ?>
        </ul>
    </section>
    <?php } ?>

    <?php if ($prev_href || $next_href) { ?>
    <nav class="jw-board-neighbors" aria-label="이전글과 다음글">
        <?php if ($prev_href) { ?><a href="<?php echo $prev_href; ?>"><span>이전글</span><strong><?php echo get_text($prev_wr_subject); ?></strong><time><?php echo str_replace('-', '.', substr($prev_wr_date, 2, 8)); ?></time></a><?php } ?>
        <?php if ($next_href) { ?><a href="<?php echo $next_href; ?>"><span>다음글</span><strong><?php echo get_text($next_wr_subject); ?></strong><time><?php echo str_replace('-', '.', substr($next_wr_date, 2, 8)); ?></time></a><?php } ?>
    </nav>
    <?php } ?>

    <?php include_once(G5_BBS_PATH.'/view_comment.php'); ?>
</article>
