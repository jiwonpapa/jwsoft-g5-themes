<?php
if (!defined('_GNUBOARD_')) exit;
$list_count = is_array($list) ? count($list) : 0;
?>
<div class="jw-latest-news">
    <ul>
        <?php for ($i = 0; $i < $list_count; $i++) {
            $date_value = isset($list[$i]['wr_datetime']) ? $list[$i]['wr_datetime'] : '';
            $date_label = $date_value ? date('Y.m.d', strtotime($date_value)) : '';
        ?>
        <li>
            <a href="<?php echo get_pretty_url($bo_table, $list[$i]['wr_id']); ?>">
                <span><?php echo $list[$i]['subject']; ?><?php if ($list[$i]['comment_cnt']) { ?><small><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?></small><?php } ?></span>
                <time datetime="<?php echo jw_business_escape(substr($date_value, 0, 10)); ?>"><?php echo jw_business_escape($date_label); ?></time>
            </a>
        </li>
        <?php } ?>
        <?php if ($list_count === 0) { ?><li class="jw-latest-news__empty">등록된 소식이 없습니다.</li><?php } ?>
    </ul>
</div>
