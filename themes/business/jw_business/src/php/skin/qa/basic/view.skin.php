<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/qa/basic/view.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;
include_once G5_LIB_PATH.'/thumbnail.lib.php';
?>
<article class="jw-support jw-inquiry">
    <header class="jw-inquiry-heading"><p class="jw-support-meta"><?php echo $view['category']; ?> · <?php echo $view['qa_status'] ? '답변 완료' : '답변 대기'; ?></p><h2><?php echo $view['subject']; ?></h2><p class="jw-support-meta"><?php echo $view['name']; ?> · <?php echo $view['datetime']; ?></p>
        <?php if ($view['email'] || $view['hp']) { ?><p class="jw-support-meta"><?php echo $view['email']; ?> <?php echo $view['hp']; ?></p><?php } ?>
    </header>
    <div class="jw-support-content jw-inquiry-content"><?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?><?php $jw_qa_record=$view; include G5_THEME_PATH.'/skin/qa/basic/attachments.php'; ?></div>
    <div class="jw-support-actions">
        <a class="jw-control" href="<?php echo htmlspecialchars($list_href, ENT_QUOTES, 'UTF-8', false); ?>">목록으로</a>
        <?php if ($update_href) { ?><a class="jw-control" href="<?php echo htmlspecialchars($update_href, ENT_QUOTES, 'UTF-8', false); ?>">문의 수정</a><?php } ?>
        <?php if ($delete_href) { ?><a class="jw-control" href="<?php echo htmlspecialchars($delete_href, ENT_QUOTES, 'UTF-8', false); ?>" data-jw-confirm="문의를 삭제하시겠습니까? 삭제한 문의는 복구할 수 없습니다.">문의 삭제</a><?php } ?>
        <?php if ($view['qa_type'] && $rewrite_href) { ?><a class="jw-control" href="<?php echo htmlspecialchars($rewrite_href, ENT_QUOTES, 'UTF-8', false); ?>">추가 질문</a><?php } ?>
        <?php if ($write_href) { ?><a class="jw-control jw-control--primary" href="<?php echo htmlspecialchars($write_href, ENT_QUOTES, 'UTF-8', false); ?>">새 문의</a><?php } ?>
    </div>
    <?php if (!$view['qa_type']) {
        include __DIR__.($view['qa_status'] && !empty($answer['qa_id']) ? '/view.answer.skin.php' : '/view.answerform.skin.php');
    } ?>
    <?php if ($view['rel_count']) { ?><section class="jw-support-related"><h2>연관 질문</h2><ul class="jw-inquiry-list"><?php foreach ($rel_list as $jw_related) { ?><li class="jw-inquiry-row"><div class="jw-inquiry-row__body"><a class="jw-inquiry-row__title" href="<?php echo htmlspecialchars($jw_related['view_href'], ENT_QUOTES, 'UTF-8', false); ?>"><?php echo $jw_related['subject']; ?></a><p class="jw-support-meta"><?php echo $jw_related['date']; ?></p></div><span class="jw-support-status" data-complete="<?php echo $jw_related['qa_status'] ? 'true' : 'false'; ?>"><?php echo $jw_related['qa_status'] ? '답변 완료' : '답변 대기'; ?></span></li><?php } ?></ul></section><?php } ?>
    <nav class="jw-support-actions" aria-label="이전 다음 문의"><?php if ($prev_href) { ?><a class="jw-control" href="<?php echo htmlspecialchars($prev_href, ENT_QUOTES, 'UTF-8', false); ?>">이전 문의</a><?php } ?><?php if ($next_href) { ?><a class="jw-control" href="<?php echo htmlspecialchars($next_href, ENT_QUOTES, 'UTF-8', false); ?>">다음 문의</a><?php } ?></nav>
</article>
