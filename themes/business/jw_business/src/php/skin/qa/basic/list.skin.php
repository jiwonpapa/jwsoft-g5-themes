<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/qa/basic/list.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;
?>
<section class="jw-support" aria-label="문의 목록">
    <div class="jw-support-toolbar"><p>문의 내역과 답변을 확인하세요.</p><div class="jw-support-actions">
        <?php if ($admin_href) { ?><a class="jw-control" href="<?php echo htmlspecialchars($admin_href, ENT_QUOTES, 'UTF-8', false); ?>">문의 관리</a><?php } ?>
        <?php if ($write_href) { ?><a class="jw-control jw-control--primary" href="<?php echo htmlspecialchars($write_href, ENT_QUOTES, 'UTF-8', false); ?>">문의 작성</a><?php } ?>
    </div></div>
    <nav class="jw-support-tabs" aria-label="문의 분류">
        <?php foreach (array_merge(array(''), array_filter(array_map('trim', explode('|', $qaconfig['qa_category'])))) as $jw_category) { ?>
        <a href="<?php echo G5_BBS_URL; ?>/qalist.php?sca=<?php echo urlencode($jw_category); ?>" <?php if ($sca === $jw_category) echo 'aria-current="page"'; ?>><?php echo $jw_category === '' ? '전체' : get_text($jw_category); ?></a>
        <?php } ?>
    </nav>
    <form class="jw-support-search" name="fsearch" method="get">
        <input type="hidden" name="sca" value="<?php echo get_text($sca); ?>"><input type="hidden" name="sop" value="and">
        <label class="jw-field jw-support-search__filter">검색 대상<select name="sfl"><?php echo get_qa_sfl_select_options($sfl); ?></select></label>
        <label class="jw-field">검색어<input type="search" name="stx" value="<?php echo get_text(stripslashes($stx)); ?>" maxlength="100" placeholder="문의 검색"></label>
        <button class="jw-control" type="submit">검색</button>
        <?php if ($stx !== '') { ?><a class="jw-control" href="<?php echo G5_BBS_URL; ?>/qalist.php?sca=<?php echo urlencode($sca); ?>">초기화</a><?php } ?>
    </form>
    <form name="fqalist" action="<?php echo G5_BBS_URL; ?>/qadelete.php" method="post" data-jw-qa-delete>
        <?php foreach (array('stx'=>$stx, 'sca'=>$sca, 'page'=>$page, 'token'=>$token) as $jw_name=>$jw_value) { ?><input type="hidden" name="<?php echo $jw_name; ?>" value="<?php echo get_text((string)$jw_value); ?>"><?php } ?>
        <div class="jw-support-toolbar"><p class="jw-support-meta">총 <?php echo number_format($total_count); ?>건 · <?php echo (int)$page; ?> 페이지</p>
            <?php if ($is_checkbox && $list) { ?><label class="jw-support-check"><input type="checkbox" data-jw-qa-select-all>현재 페이지 전체 선택</label><?php } ?>
        </div>
        <ul class="jw-inquiry-list">
        <?php foreach ($list as $jw_item) { ?>
            <li class="jw-inquiry-row">
                <?php if ($is_checkbox) { ?><label class="jw-support-check"><input type="checkbox" name="chk_qa_id[]" value="<?php echo (int)$jw_item['qa_id']; ?>"><span class="sound_only"><?php echo get_text(strip_tags($jw_item['subject'])); ?> 선택</span></label><?php } ?>
                <div class="jw-inquiry-row__body"><span class="jw-support-meta"><?php echo $jw_item['category']; ?></span><a class="jw-inquiry-row__title" href="<?php echo htmlspecialchars($jw_item['view_href'], ENT_QUOTES, 'UTF-8', false); ?>"><?php echo $jw_item['subject']; ?></a><p class="jw-support-meta"><?php echo $jw_item['name']; ?> · <?php echo $jw_item['date']; ?><?php if ($jw_item['icon_file']) echo ' · 첨부파일'; ?></p></div>
                <span class="jw-support-status" data-complete="<?php echo $jw_item['qa_status'] ? 'true' : 'false'; ?>"><?php echo $jw_item['qa_status'] ? '답변 완료' : '답변 대기'; ?></span>
            </li>
        <?php } ?>
        </ul>
        <?php if (!$list) { ?><div class="jw-support-empty"><h2><?php echo $stx !== '' ? '검색 결과가 없습니다' : '등록된 문의가 없습니다'; ?></h2><p><?php echo $stx !== '' ? '검색어 또는 분류를 변경해 주세요.' : '궁금한 내용을 문의하시면 이곳에서 답변을 확인할 수 있습니다.'; ?></p></div><?php } ?>
        <?php echo $list_pages; ?>
        <?php if ($is_checkbox && $list) { ?><div class="jw-support-actions"><button class="jw-control" type="submit" name="btn_submit" value="선택삭제">선택 삭제</button></div><?php } ?>
        <p data-jw-support-status role="alert" hidden></p>
    </form>
</section>
