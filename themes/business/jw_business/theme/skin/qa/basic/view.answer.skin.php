<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/qa/basic/view.answer.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;
?>
<section class="jw-support-answer">
    <p class="jw-support-status" data-complete="true">답변 완료</p><h2><?php echo get_text($answer['qa_subject']); ?></h2><p class="jw-support-meta"><?php echo get_text($answer['qa_datetime']); ?></p>
    <div class="jw-support-content"><?php echo get_view_thumbnail(conv_content($answer['qa_content'], $answer['qa_html']), $qaconfig['qa_image_width']); ?><?php $jw_qa_record=$answer; include G5_THEME_PATH.'/skin/qa/basic/attachments.php'; ?></div>
    <div class="jw-support-actions">
        <?php if ($answer_update_href) { ?><a class="jw-control" href="<?php echo htmlspecialchars($answer_update_href, ENT_QUOTES, 'UTF-8', false); ?>">답변 수정</a><?php } ?>
        <?php if ($answer_delete_href) { ?><a class="jw-control" data-jw-confirm="답변을 삭제하시겠습니까? 삭제한 답변은 복구할 수 없습니다." href="<?php echo htmlspecialchars($answer_delete_href, ENT_QUOTES, 'UTF-8', false); ?>">답변 삭제</a><?php } ?>
        <?php if ($rewrite_href) { ?><a class="jw-control jw-control--primary" href="<?php echo htmlspecialchars($rewrite_href, ENT_QUOTES, 'UTF-8', false); ?>">추가 질문</a><?php } ?>
    </div>
</section>
