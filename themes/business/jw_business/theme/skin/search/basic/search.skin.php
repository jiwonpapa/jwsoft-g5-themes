<?php
if (!defined('_GNUBOARD_')) exit;
include_once G5_THEME_PATH.'/lib/jw-community.lib.php';
$jw_group_select = preg_replace('/<label\b[^>]*>.*?<\/label>/is', '', $group_select);
$jw_group_select = preg_replace('/\s(?:id|class|onchange)="[^"]*"/i', '', $jw_group_select);
?>
<section class="jw-support" aria-label="전체 검색">
<form name="fsearch" method="get" data-jw-global-search>
    <input type="hidden" name="srows" value="<?php echo (int)$srows; ?>">
    <div class="jw-support-search">
        <label class="jw-field jw-support-search__filter">게시판 그룹<?php echo $jw_group_select; ?></label>
        <label class="jw-field jw-support-search__filter">검색 대상<select name="sfl"><?php foreach (array('wr_subject||wr_content'=>'제목+내용','wr_subject'=>'제목','wr_content'=>'내용','mb_id'=>'회원 아이디','wr_name'=>'이름') as $jw_value=>$jw_label) { ?><option value="<?php echo $jw_value; ?>" <?php echo get_selected($sfl,$jw_value); ?>><?php echo $jw_label; ?></option><?php } ?></select></label>
        <label class="jw-field">검색어<input type="search" name="stx" value="<?php echo $text_stx; ?>" required minlength="2" maxlength="100" placeholder="두 글자 이상 입력"></label>
        <button class="jw-control jw-control--primary" type="submit">검색</button>
    </div>
    <fieldset class="jw-search-options"><legend>검색어 조합</legend><label class="jw-support-check"><input type="radio" name="sop" value="and" <?php echo $sop !== 'or' ? 'checked' : ''; ?>>모두 포함</label><label class="jw-support-check"><input type="radio" name="sop" value="or" <?php echo $sop === 'or' ? 'checked' : ''; ?>>하나라도 포함</label></fieldset>
    <p data-jw-support-status role="alert" tabindex="-1" hidden></p>
</form>
<?php if ($stx && $board_count) { ?>
<p class="jw-support-meta">게시판 <?php echo (int)$board_count; ?>개 · 게시물 <?php echo number_format($total_count); ?>건 · <?php echo (int)$page; ?> / <?php echo (int)$total_page; ?> 페이지</p>
<nav aria-label="결과 게시판"><ul class="jw-search-boards"><li><a href="?<?php echo $search_query; ?>&amp;gr_id=<?php echo urlencode($gr_id); ?>">전체 게시판</a></li><?php echo str_replace(array('class="sch_on"','class=sch_on','cnt_cmt'),array('aria-current="page"','aria-current="page"','jw-search-count'),$str_board_list); ?></ul></nav>
<?php } ?>
<?php if (!$stx || !$board_count) { ?><div class="jw-support-empty"><h2><?php echo $stx ? '검색 결과가 없습니다' : '찾고 싶은 내용을 검색하세요'; ?></h2><p><?php echo $stx ? '검색어나 게시판 그룹을 변경해 주세요.' : '게시물 제목과 내용, 작성자로 검색할 수 있습니다.'; ?></p></div><?php } ?>
<?php for ($jw_idx=$table_index,$jw_k=0; $jw_idx<count($search_table) && $jw_k<$rows; $jw_idx++) { ?>
<section class="jw-search-results"><div class="jw-support-toolbar"><h2><?php echo $bo_subject[$jw_idx]; ?></h2><a class="jw-control" href="<?php echo get_pretty_url($search_table[$jw_idx],'',$search_query); ?>">게시판에서 보기</a></div><ul class="jw-inquiry-list">
<?php for ($jw_i=0; $jw_i<count($list[$jw_idx]) && $jw_k<$rows; $jw_i++,$jw_k++) { $jw_item=$list[$jw_idx][$jw_i]; $jw_href=$jw_item['href'].($jw_item['wr_is_comment'] ? '#comment-'.(int)$jw_item['wr_id'] : ''); ?>
<li class="jw-inquiry-row"><div class="jw-inquiry-row__body"><a class="jw-inquiry-row__title" href="<?php echo htmlspecialchars($jw_href,ENT_QUOTES,'UTF-8',false); ?>"><?php echo $jw_item['wr_is_comment'] ? '[댓글] ' : ''; ?><?php echo $jw_item['subject']; ?></a><p class="jw-search-excerpt"><?php echo $jw_item['content']; ?></p><div class="jw-support-meta jw-result-author"><?php echo jw_business_author_menu($jw_item); ?> · <?php echo $jw_item['wr_datetime']; ?></div></div><a class="jw-control" href="<?php echo htmlspecialchars($jw_href,ENT_QUOTES,'UTF-8',false); ?>" target="_blank" rel="noopener" aria-label="<?php echo get_text(strip_tags($jw_item['subject'])); ?> 새 창">새 창</a></li>
<?php } ?></ul></section><?php } ?>
<?php echo $write_pages; ?>
</section>
