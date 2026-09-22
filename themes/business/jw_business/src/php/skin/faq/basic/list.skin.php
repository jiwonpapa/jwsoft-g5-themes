<?php
if (!defined('_GNUBOARD_')) exit;
$jw_faq_html_prefix = G5_IS_MOBILE ? 'fm_mobile_' : 'fm_';
?>
<section class="jw-support" aria-label="자주 묻는 질문">
    <?php if (!empty($himg_src)) { ?><img class="jw-support-banner" src="<?php echo htmlspecialchars($himg_src, ENT_QUOTES, 'UTF-8', false); ?>" alt=""><?php } ?>
    <div class="jw-support-content"><?php echo conv_content($fm[$jw_faq_html_prefix.'head_html'] ?? '', 1); ?></div>
    <form class="jw-support-search" name="faq_search_form" method="get">
        <input type="hidden" name="fm_id" value="<?php echo (int)$fm_id; ?>">
        <label class="jw-field">궁금한 내용을 검색하세요
            <input type="search" name="stx" value="<?php echo get_text($stx); ?>" maxlength="100" placeholder="질문 또는 답변 검색">
        </label>
        <button class="jw-control jw-control--primary" type="submit">검색</button>
        <?php if ($stx !== '') { ?><a class="jw-control" href="?fm_id=<?php echo (int)$fm_id; ?>">검색 초기화</a><?php } ?>
    </form>
    <nav class="jw-support-tabs" aria-label="질문 분류">
        <?php foreach ($faq_master_list as $jw_category) { ?>
        <a href="<?php echo htmlspecialchars($category_href, ENT_QUOTES, 'UTF-8', false); ?>?fm_id=<?php echo (int)$jw_category['fm_id']; ?>" <?php if ($jw_category['fm_id'] == $fm_id) echo 'aria-current="page"'; ?>><?php echo get_text($jw_category['fm_subject']); ?></a>
        <?php } ?>
    </nav>
    <p class="jw-support-meta">총 <?php echo number_format($total_count); ?>개의 질문</p>
    <div class="jw-faq-list">
        <?php foreach ($faq_list as $jw_faq) { ?>
        <details class="jw-faq" name="jw-faq">
            <summary><span><?php echo strip_tags(conv_content($jw_faq['fa_subject'], 1), '<mark><strong><b><em><span>'); ?></span><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></summary>
            <div class="jw-faq__answer jw-support-content"><?php echo conv_content($jw_faq['fa_content'], 1); ?></div>
        </details>
        <?php } ?>
        <?php if (!$faq_list) { ?><div class="jw-support-empty"><h2><?php echo $stx !== '' ? '검색 결과가 없습니다' : '등록된 질문이 없습니다'; ?></h2><p><?php echo $stx !== '' ? '다른 검색어를 입력하거나 검색을 초기화해 주세요.' : '자주 묻는 질문이 등록되면 여기에서 확인할 수 있습니다.'; ?></p></div><?php } ?>
    </div>
    <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
    <div class="jw-support-content"><?php echo conv_content($fm[$jw_faq_html_prefix.'tail_html'] ?? '', 1); ?></div>
    <?php if (!empty($timg_src)) { ?><img class="jw-support-banner" src="<?php echo htmlspecialchars($timg_src, ENT_QUOTES, 'UTF-8', false); ?>" alt=""><?php } ?>
    <?php if ($admin_href) { ?><div class="jw-support-actions"><a class="jw-control" href="<?php echo htmlspecialchars($admin_href, ENT_QUOTES, 'UTF-8', false); ?>">FAQ 관리</a></div><?php } ?>
</section>
