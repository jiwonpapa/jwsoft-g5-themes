<?php
if (!defined('_GNUBOARD_')) exit;
$jw_qa_values = $jw_qa_answer_form ? array() : ($write ?? array());
$jw_qa_upload_limit = number_format((int)$qaconfig['qa_upload_size'] / 1048576, 1).' MB';
$jw_qa_mode = $jw_qa_answer_form ? 'a' : $w;
$jw_qa_id = $jw_qa_answer_form ? $view['qa_id'] : $qa_id;
?>
<form class="jw-support jw-write-form" name="<?php echo $jw_qa_answer_form ? 'fanswer' : 'fwrite'; ?>" action="<?php echo $jw_qa_answer_form ? G5_BBS_URL.'/qawrite_update.php' : htmlspecialchars($action_url, ENT_QUOTES, 'UTF-8', false); ?>" method="post" enctype="multipart/form-data" data-jw-qa-write data-filter-url="<?php echo G5_BBS_URL; ?>/ajax.filter.php" data-token-url="<?php echo G5_BBS_URL; ?>/ajax.write.token.php">
    <?php foreach (array('w'=>$jw_qa_mode, 'qa_id'=>$jw_qa_id, 'sca'=>$sca, 'stx'=>$stx, 'page'=>$page, 'token'=>$token) as $jw_name=>$jw_value) { ?><input type="hidden" name="<?php echo $jw_name; ?>" value="<?php echo get_text((string)$jw_value); ?>"><?php } ?>
    <p class="jw-support-meta">제목과 내용을 입력해 주세요. 첨부파일은 최대 2개까지 등록할 수 있습니다.</p>
    <?php if (!$jw_qa_answer_form) { ?>
    <div class="jw-write-form__grid">
        <?php if ($category_option) { ?><label class="jw-field">분류 · 필수<select name="qa_category" required><option value="">분류 선택</option><?php echo $category_option; ?></select></label><?php } ?>
        <?php if ($is_email) { ?><div><label class="jw-field">이메일<?php if ($req_email) echo ' · 필수'; ?><input type="email" name="qa_email" value="<?php echo get_text($jw_qa_values['qa_email'] ?? ''); ?>" maxlength="100" <?php echo $req_email; ?> autocomplete="email"></label><label class="jw-support-check"><input type="checkbox" name="qa_email_recv" value="1" <?php if (!empty($jw_qa_values['qa_email_recv'])) echo 'checked'; ?>>답변을 이메일로 받기</label></div><?php } ?>
        <?php if ($is_hp) { ?><div><label class="jw-field">휴대폰<?php if ($req_hp) echo ' · 필수'; ?><input type="tel" name="qa_hp" value="<?php echo get_text($jw_qa_values['qa_hp'] ?? ''); ?>" <?php echo $req_hp; ?> autocomplete="tel"></label><?php if ($qaconfig['qa_use_sms']) { ?><label class="jw-support-check"><input type="checkbox" name="qa_sms_recv" value="1" <?php if (!empty($jw_qa_values['qa_sms_recv'])) echo 'checked'; ?>>답변 등록 문자 알림 받기</label><?php } ?></div><?php } ?>
    </div>
    <?php } ?>
    <label class="jw-field">제목 · 필수<input name="qa_subject" value="<?php echo get_text($jw_qa_values['qa_subject'] ?? ''); ?>" required maxlength="255" placeholder="문의 내용을 간략히 적어 주세요"></label>
    <div class="jw-field"><label for="qa_content">내용 · 필수</label>
        <textarea id="qa_content" name="qa_content" rows="12" required><?php echo $jw_qa_answer_form ? '' : $content; ?></textarea>
    </div>
    <!-- 기본 문의 편집은 native textarea. 외부 에디터는 별도 플러그인 영역입니다. -->
    <label class="jw-field">본문 형식<select name="qa_html"><option value="0" <?php if (empty($jw_qa_values['qa_html'])) echo 'selected'; ?>>일반 텍스트</option><option value="1" <?php if (($jw_qa_values['qa_html'] ?? 0) == 1) echo 'selected'; ?>>HTML</option><option value="2" <?php if (($jw_qa_values['qa_html'] ?? 0) == 2) echo 'selected'; ?>>HTML · 줄바꿈 적용</option></select></label>
    <fieldset class="jw-support-attachments"><legend>첨부파일</legend><p class="jw-support-meta">파일당 <?php echo get_text($jw_qa_upload_limit); ?> 이하</p>
        <?php for ($jw_file=1; $jw_file<=2; $jw_file++) { ?><label class="jw-field">파일 <?php echo $jw_file; ?><input type="file" name="bf_file[<?php echo $jw_file; ?>]"></label>
        <?php if ($jw_qa_mode === 'u' && !empty($jw_qa_values['qa_file'.$jw_file])) { ?><label class="jw-support-check"><input type="checkbox" name="bf_file_del[<?php echo $jw_file; ?>]" value="1"><?php echo get_text($jw_qa_values['qa_source'.$jw_file]); ?> 삭제</label><?php } ?>
        <?php } ?>
    </fieldset>
    <p data-jw-support-status role="alert" tabindex="-1" hidden></p>
    <div class="jw-support-actions"><a class="jw-control" href="<?php echo htmlspecialchars($list_href, ENT_QUOTES, 'UTF-8', false); ?>">목록으로</a><button class="jw-control jw-control--primary" type="submit"><?php echo $jw_qa_answer_form ? '답변 등록' : ($w === 'u' ? '수정 완료' : '문의 등록'); ?></button></div>
</form>
