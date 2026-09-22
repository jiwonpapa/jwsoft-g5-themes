<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/member/basic/password_lost.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;
$jw_cert_page = 'find';
include G5_THEME_PATH.'/skin/member/basic/certification.php';
$jw_captcha_html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', captcha_html());
?>
<section class="jw-register jw-register--compact">
    <header class="jw-register__header"><h2>아이디·비밀번호 찾기</h2><p>가입하신 이메일로 계정 확인 안내를 보내드립니다.</p></header>
    <form name="fpasswordlost" class="jw-auth-form" action="<?php echo $action_url; ?>" method="post">
        <input type="hidden" name="cert_no" value="">
        <label for="jw-find-email">이메일<input type="email" name="mb_email" id="jw-find-email" required autocomplete="email"></label>
        <div data-jw-captcha data-session-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_session.php" data-image-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_image.php" data-audio-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_mp3.php"><?php echo $jw_captcha_html; ?></div>
        <button type="submit" class="jw-control jw-control--primary">안내메일 받기</button>
    </form>
    <?php if ($config['cf_cert_use'] && $config['cf_cert_find'] && $jw_cert_buttons) { ?>
    <section class="jw-member-section"><h3>본인확인으로 찾기</h3><div class="jw-board-actions">
    <?php foreach ($jw_cert_buttons as $button) { ?><button type="button" class="jw-control jw-control--quiet" data-jw-find-certify data-cert-url="<?php echo $button['url']; ?>" data-window-name="<?php echo $button['window']; ?>"><?php echo $button['label']; ?></button><?php } ?>
    </div></section><?php } ?>
    <div class="jw-register__actions"><a class="jw-control jw-control--quiet" href="<?php echo G5_BBS_URL; ?>/login.php">로그인으로 돌아가기</a></div>
</section>
