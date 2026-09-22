<?php
if (!defined('_GNUBOARD_')) exit;
?>
<section class="jw-support-answer">
<?php if ($is_admin === 'super') {
    echo '<h2>답변 작성</h2>';
    $jw_qa_answer_form = true;
    include __DIR__.'/form.fields.php';
} else { ?>
    <h2>답변을 준비하고 있습니다</h2><p>답변이 등록되면 이 페이지에서 확인하실 수 있습니다.</p>
<?php } ?>
</section>
