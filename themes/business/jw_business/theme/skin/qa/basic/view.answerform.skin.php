<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/qa/basic/view.answerform.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;
?>
<section class="jw-support-answer">
<?php if ($is_admin === 'super') {
    echo '<h2>답변 작성</h2>';
    $jw_qa_answer_form = true;
    include G5_THEME_PATH.'/skin/qa/basic/form.fields.php';
} else { ?>
    <h2>답변을 준비하고 있습니다</h2><p>답변이 등록되면 이 페이지에서 확인하실 수 있습니다.</p>
<?php } ?>
</section>
