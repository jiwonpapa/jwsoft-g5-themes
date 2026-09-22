<?php if (!defined('_GNUBOARD_')) exit; ?>
<section class="jw-popular" aria-label="인기 검색어"><h2>인기 검색어</h2><ul>
<?php foreach (($list ?? array()) as $jw_word) { ?><li><a href="<?php echo G5_BBS_URL; ?>/search.php?sfl=wr_subject&amp;sop=and&amp;stx=<?php echo urlencode($jw_word['pp_word']); ?>"><?php echo get_text($jw_word['pp_word']); ?></a></li><?php } ?>
<?php if (empty($list)) { ?><li>등록된 검색어가 없습니다.</li><?php } ?>
</ul></section>
