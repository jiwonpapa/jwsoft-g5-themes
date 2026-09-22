<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/board/basic/write.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;

$jw_upload_limit = (int)$board['bo_upload_size'] >= 1048576
    ? rtrim(rtrim(number_format((int)$board['bo_upload_size'] / 1048576, 1), '0'), '.').' MB'
    : number_format((int)$board['bo_upload_size'] / 1024, 0).' KB';

$jw_captcha_html = $is_use_captcha
    ? preg_replace('#<script\b[^>]*>.*?</script>#is', '', $captcha_html)
    : '';
?>
<section class="jw-board-write" aria-labelledby="jw-board-write-title">
    <header class="jw-board-write__header">
        <h2 id="jw-board-write-title" class="sound_only"><?php echo $w === 'u' ? '게시물 수정' : ($w === 'r' ? '답글 쓰기' : '새 글 쓰기'); ?></h2>
        <p>필수 항목을 입력한 뒤 작성 완료를 눌러 주세요.</p>
    </header>

    <form name="fwrite" class="jw-write-form" action="<?php echo $action_url; ?>" method="post" enctype="multipart/form-data" autocomplete="off"
        data-jw-write-form
        data-filter-url="<?php echo G5_BBS_URL; ?>/ajax.filter.php"
        data-token-url="<?php echo G5_BBS_URL; ?>/write_token.php"
        data-captcha-result-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_result.php"
        data-min="<?php echo (int)$write_min; ?>"
        data-max="<?php echo (int)$write_max; ?>">
        <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
        <input type="hidden" name="w" value="<?php echo $w; ?>">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
        <input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
        <input type="hidden" name="sca" value="<?php echo $sca; ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
        <input type="hidden" name="stx" value="<?php echo $stx; ?>">
        <input type="hidden" name="spt" value="<?php echo $spt; ?>">
        <input type="hidden" name="sst" value="<?php echo $sst; ?>">
        <input type="hidden" name="sod" value="<?php echo $sod; ?>">
        <input type="hidden" name="page" value="<?php echo $page; ?>">

        <?php if ($is_dhtml_editor) { ?><input type="hidden" name="html" value="html1"><?php } ?>
        <?php if (!$is_admin && $is_secret == 2) { ?><input type="hidden" name="secret" value="secret"><?php } ?>

        <div class="jw-write-form__grid">
            <?php if ($is_category) { ?>
            <label class="jw-field">분류
                <select name="ca_name" required>
                    <option value="">분류를 선택하세요</option>
                    <?php echo $category_option; ?>
                </select>
            </label>
            <?php } ?>

            <?php if ($is_name) { ?>
            <label class="jw-field">이름
                <input type="text" name="wr_name" value="<?php echo $name; ?>" required maxlength="20" autocomplete="name">
            </label>
            <?php } ?>

            <?php if ($is_password) { ?>
            <label class="jw-field">비밀번호
                <input type="password" name="wr_password" <?php echo $password_required; ?> maxlength="20" autocomplete="new-password">
            </label>
            <?php } ?>

            <?php if ($is_email) { ?>
            <label class="jw-field">이메일
                <input type="email" name="wr_email" value="<?php echo $email; ?>" maxlength="100" autocomplete="email">
            </label>
            <?php } ?>

            <?php if ($is_homepage) { ?>
            <label class="jw-field">홈페이지
                <input type="url" name="wr_homepage" value="<?php echo $homepage; ?>" placeholder="https://">
            </label>
            <?php } ?>
        </div>

        <?php if ($is_notice || (!$is_dhtml_editor && $is_html) || ($is_secret && ($is_admin || $is_secret == 1)) || $is_mail) { ?>
        <fieldset class="jw-write-options">
            <legend>글 옵션</legend>
            <?php if ($is_notice) { ?><label class="jw-check"><input type="checkbox" name="notice" value="1" <?php echo $notice_checked; ?>> 공지</label><?php } ?>
            <?php if (!$is_dhtml_editor && $is_html) { ?><label class="jw-check"><input type="checkbox" name="html" value="<?php echo $html_value; ?>" <?php echo $html_checked; ?> data-jw-html-mode> HTML</label><?php } ?>
            <?php if ($is_secret && ($is_admin || $is_secret == 1)) { ?><label class="jw-check"><input type="checkbox" name="secret" value="secret" <?php echo $secret_checked; ?>> 비밀글</label><?php } ?>
            <?php if ($is_mail) { ?><label class="jw-check"><input type="checkbox" name="mail" value="mail" <?php echo $recv_email_checked; ?>> 답변 메일 받기</label><?php } ?>
        </fieldset>
        <?php } ?>

        <label class="jw-field jw-field--subject">제목
            <span class="jw-write-subject">
                <input type="text" name="wr_subject" value="<?php echo $subject; ?>" required maxlength="255" placeholder="제목을 입력하세요">
                <?php if ($is_member) { ?>
                <button type="button" class="jw-control jw-control--quiet" data-jw-autosave-open>임시저장 <span data-jw-autosave-count><?php echo (int)$autosave_count; ?></span></button>
                <?php } ?>
            </span>
        </label>

        <?php if ($is_member) { ?>
        <dialog class="jw-autosave-dialog" data-jw-autosave-dialog
            data-save-url="<?php echo G5_BBS_URL; ?>/ajax.autosave.php"
            data-list-url="<?php echo G5_BBS_URL; ?>/ajax.autosavelist.php"
            data-load-url="<?php echo G5_BBS_URL; ?>/ajax.autosaveload.php"
            data-delete-url="<?php echo G5_BBS_URL; ?>/ajax.autosavedel.php">
            <div class="jw-autosave-dialog__head"><strong>임시 저장된 글</strong><button type="button" data-jw-autosave-close>닫기</button></div>
            <ul data-jw-autosave-list></ul>
        </dialog>
        <?php } ?>

        <div class="jw-field jw-field--content">
            <label for="wr_content">내용</label>
            <?php if ($is_dhtml_editor) { echo $editor_html; } else { ?><textarea name="wr_content" id="wr_content" required rows="14" placeholder="내용을 입력하세요"><?php echo $content; ?></textarea><?php } ?>
            <?php if ($write_min || $write_max) { ?><p class="jw-field-help">내용은 <?php echo (int)$write_min; ?>자 이상 <?php echo (int)$write_max; ?>자 이하 · <span data-jw-write-count>0</span>자</p><?php } ?>
        </div>

        <?php if ($is_link) { ?>
        <fieldset class="jw-write-group">
            <legend>관련 링크</legend>
            <?php for ($i = 1; $i <= G5_LINK_COUNT; $i++) { ?>
            <label class="jw-field">링크 <?php echo $i; ?>
                <input type="url" name="wr_link<?php echo $i; ?>" value="<?php echo $w === 'u' ? get_text($write['wr_link'.$i]) : ''; ?>" placeholder="https://">
            </label>
            <?php } ?>
        </fieldset>
        <?php } ?>

        <?php if ($is_file) { ?>
        <fieldset class="jw-write-group">
            <legend>파일 첨부 <span>파일당 최대 <?php echo $jw_upload_limit; ?></span></legend>
            <?php for ($i = 0; $i < $file_count; $i++) { ?>
            <div class="jw-file-field">
                <label class="jw-field">파일 <?php echo $i + 1; ?>
                    <input type="file" name="bf_file[]" accept="image/*,.pdf,.zip,.hwp,.hwpx,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                </label>
                <?php if ($is_file_content) { ?><label class="jw-field">파일 설명
                    <input type="text" name="bf_content[]" value="<?php echo $w === 'u' ? get_text($file[$i]['bf_content']) : ''; ?>" placeholder="첨부파일 설명">
                </label><?php } ?>
                <?php if ($w === 'u' && $file[$i]['file']) { ?><label class="jw-check"><input type="checkbox" name="bf_file_del[<?php echo $i; ?>]" value="1"> <?php echo get_text($file[$i]['source']); ?> 삭제</label><?php } ?>
            </div>
            <?php } ?>
        </fieldset>
        <?php } ?>

        <?php if ($is_use_captcha) { ?>
        <div class="jw-comment-form__captcha"
            data-jw-captcha
            data-session-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_session.php"
            data-image-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_image.php"
            data-audio-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_mp3.php"><?php echo $jw_captcha_html; ?></div>
        <?php } ?>

        <div class="jw-write-form__actions">
            <a href="<?php echo get_pretty_url($bo_table); ?>" class="jw-control jw-control--quiet">취소</a>
            <button type="submit" class="jw-control jw-control--primary">작성 완료</button>
        </div>
    </form>
</section>
