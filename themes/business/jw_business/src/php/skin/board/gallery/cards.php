<?php
if (!defined('_GNUBOARD_')) exit;
include_once G5_LIB_PATH.'/thumbnail.lib.php';
?>
<div class="jw-gallery-toolbar">
    <?php if ($is_checkbox) { ?><label class="jw-check"><input type="checkbox" data-jw-check-all> 전체 선택</label><?php } ?>
    <nav aria-label="갤러리 정렬"><?php echo subject_sort_link('wr_datetime', $qstr2, 1); ?>날짜순</a><?php echo subject_sort_link('wr_hit', $qstr2, 1); ?>조회순</a></nav>
</div>
<ul class="jw-gallery">
<?php foreach ($list as $i => $item) {
    // 비밀글의 첨부 이미지는 목록에서 노출하지 않습니다.
    $secret = strpos($item['wr_option'], 'secret') !== false;
    $thumb = $secret ? array() : get_list_thumbnail($bo_table, $item['wr_id'], 720, 540, false, true);
?>
    <li class="jw-gallery-card">
        <a class="jw-gallery-card__image" href="<?php echo $item['href']; ?>" aria-label="<?php echo get_text($item['wr_subject']); ?> 보기">
            <?php if (!empty($thumb['src'])) { ?><img src="<?php echo htmlspecialchars($thumb['src'], ENT_QUOTES); ?>" alt="<?php echo get_text($thumb['alt'] ?? ''); ?>" width="720" height="540" loading="lazy" decoding="async">
            <?php } else { ?><span><i data-lucide="<?php echo $secret ? 'lock' : 'image'; ?>"></i><?php echo $secret ? '비밀 게시물' : '등록된 이미지가 없습니다'; ?></span><?php } ?>
        </a>
        <div class="jw-gallery-card__body">
            <div class="jw-gallery-card__labels">
                <?php if ($is_checkbox) { ?><input type="checkbox" name="chk_wr_id[]" value="<?php echo (int)$item['wr_id']; ?>" aria-label="<?php echo get_text($item['wr_subject']); ?> 선택" data-jw-row-check><?php } ?>
                <?php if ($item['is_notice']) { ?><span class="jw-badge">공지</span><?php } ?>
                <?php if ($is_category && $item['ca_name']) { ?><a class="jw-board-category" href="<?php echo $item['ca_name_href']; ?>"><?php echo get_text($item['ca_name']); ?></a><?php } ?>
                <?php if ($item['icon_new']) { ?><span class="jw-badge jw-badge--new">새글</span><?php } ?>
            </div>
            <h3><a href="<?php echo $item['href']; ?>"><?php echo $item['subject']; ?></a><?php if ($item['wr_comment']) { ?><span class="jw-comment-count" aria-label="댓글 <?php echo (int)$item['wr_comment']; ?>개"><?php echo (int)$item['wr_comment']; ?></span><?php } ?></h3>
            <div class="jw-gallery-card__meta"><span><?php echo $item['name']; ?></span><span><?php echo $item['datetime2']; ?></span><span>조회 <?php echo number_format($item['wr_hit']); ?></span></div>
        </div>
    </li>
<?php } ?>
</ul>
<?php if (!$list) { ?><p class="jw-board-empty">등록된 게시물이 없습니다.</p><?php } ?>
