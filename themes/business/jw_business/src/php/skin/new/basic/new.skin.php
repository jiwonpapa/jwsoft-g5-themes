<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/new/basic/new.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;
include_once G5_THEME_PATH.'/lib/jw-community.lib.php';
$jw_group_select = preg_replace('/<label\b[^>]*>.*?<\/label>/is', '', $group_select);
$jw_group_select = preg_replace('/\s(?:id|class|onchange)="[^"]*"/i', '', $jw_group_select);
$jw_group_select = str_replace('value="'.get_text($gr_id).'"', 'value="'.get_text($gr_id).'" selected', $jw_group_select);
?>
<section class="jw-support" aria-label="새글 목록">
<form class="jw-support-search" name="fnew" method="get">
    <label class="jw-field jw-support-search__filter">게시판 그룹<?php echo $jw_group_select; ?></label>
    <label class="jw-field jw-support-search__filter">글 유형<select name="view"><?php foreach (array(''=>'전체 게시물','w'=>'원글','c'=>'댓글') as $jw_value=>$jw_label) { ?><option value="<?php echo $jw_value; ?>" <?php echo get_selected($view, $jw_value); ?>><?php echo $jw_label; ?></option><?php } ?></select></label>
    <label class="jw-field">회원 아이디<input name="mb_id" value="<?php echo get_text($mb_id); ?>" placeholder="전체 회원" maxlength="20"></label>
    <button class="jw-control jw-control--primary" type="submit">검색</button>
</form>
<p class="jw-support-meta">총 <?php echo number_format($total_count); ?>건</p>
<form name="fnewlist" method="post" action="<?php echo G5_BBS_URL; ?>/new_delete.php" data-jw-new-delete>
    <?php foreach (array('sw'=>'move','view'=>$view,'sfl'=>$sfl,'stx'=>$stx,'page'=>$page,'pressed'=>'선택삭제') as $jw_name=>$jw_value) { ?><input type="hidden" name="<?php echo $jw_name; ?>" value="<?php echo get_text((string)$jw_value); ?>"><?php } ?>
    <?php if ($is_admin === 'super' && $list) { ?><label class="jw-support-check"><input type="checkbox" data-jw-new-select-all>현재 페이지 전체 선택</label><?php } ?>
    <ul class="jw-inquiry-list">
    <?php foreach ($list as $jw_i=>$jw_item) { ?>
        <li class="jw-inquiry-row">
            <?php if ($is_admin === 'super') { ?><label class="jw-support-check"><input name="chk_bn_id[]" type="checkbox" value="<?php echo $jw_i; ?>"><span class="sound_only"><?php echo get_text($jw_item['wr_subject']); ?> 선택</span></label><input type="hidden" name="bo_table[<?php echo $jw_i; ?>]" value="<?php echo get_text($jw_item['bo_table']); ?>"><input type="hidden" name="wr_id[<?php echo $jw_i; ?>]" value="<?php echo (int)$jw_item['wr_id']; ?>"><?php } ?>
            <div class="jw-inquiry-row__body"><p class="jw-support-meta"><?php echo get_text($jw_item['gr_subject']); ?> · <a href="<?php echo get_pretty_url($jw_item['bo_table']); ?>"><?php echo get_text($jw_item['bo_subject']); ?></a></p><a class="jw-inquiry-row__title" href="<?php echo htmlspecialchars(str_replace('#c_', '#comment-', $jw_item['href']),ENT_QUOTES,'UTF-8',false); ?>"><?php echo $jw_item['comment'] ? '[댓글] ' : ''; ?><?php echo get_text($jw_item['wr_subject']); ?></a><div class="jw-support-meta jw-result-author"><?php echo jw_business_author_menu($jw_item); ?> · <?php echo $jw_item['datetime2']; ?></div></div>
        </li>
    <?php } ?>
    </ul>
    <?php if (!$list) { ?><div class="jw-support-empty"><h2>표시할 새글이 없습니다</h2><p>그룹이나 회원 아이디 조건을 변경해 주세요.</p></div><?php } ?>
    <?php echo $write_pages; ?>
    <?php if ($is_admin === 'super' && $list) { ?><div class="jw-support-actions"><button class="jw-control" type="submit">선택 삭제</button></div><?php } ?>
    <p data-jw-support-status role="alert" tabindex="-1" hidden></p>
</form>
</section>
