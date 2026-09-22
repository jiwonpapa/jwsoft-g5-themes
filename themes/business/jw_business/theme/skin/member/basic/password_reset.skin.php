<?php if (!defined('_GNUBOARD_')) exit; ?>
<section class="jw-register jw-register--compact"><header class="jw-register__header"><h2>비밀번호 재설정</h2><p>새로운 비밀번호를 입력해 주세요.</p></header>
<form name="fpasswordreset" class="jw-auth-form" action="<?php echo $action_url; ?>" method="post" data-jw-password-reset>
    <p>아이디 <strong><?php echo get_text($_POST['mb_id'] ?? ''); ?></strong></p>
    <label for="jw-reset-password">새 비밀번호<input type="password" name="mb_password" id="jw-reset-password" required minlength="3" maxlength="20" autocomplete="new-password"></label>
    <label for="jw-reset-repeat">새 비밀번호 확인<input type="password" name="mb_password_re" id="jw-reset-repeat" required minlength="3" maxlength="20" autocomplete="new-password"></label>
    <button type="submit" class="jw-control jw-control--primary">비밀번호 변경</button>
</form></section>
