<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/outlogin/basic/outlogin.skin.1.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */ if (!defined('_GNUBOARD_')) exit; ?>
<section class="jw-widget" aria-label="회원 로그인"><h2>로그인</h2>
<form name="foutlogin" class="jw-auth-form" action="<?php echo $outlogin_action_url; ?>" method="post">
<input type="hidden" name="url" value="<?php echo $outlogin_url; ?>">
<label class="jw-field">아이디<input name="mb_id" required maxlength="20" autocomplete="username"></label>
<label class="jw-field">비밀번호<input type="password" name="mb_password" required autocomplete="current-password"></label>
<label class="jw-support-check"><input type="checkbox" name="auto_login" value="1" data-jw-auto-login>자동 로그인</label>
<button type="submit" class="jw-control jw-control--primary">로그인</button>
</form><div class="jw-widget-links"><a href="<?php echo G5_BBS_URL; ?>/register.php">회원가입</a><a href="<?php echo G5_BBS_URL; ?>/password_lost.php">아이디·비밀번호 찾기</a></div>
<?php @include_once(get_social_skin_path().'/social_login.skin.php'); ?>
</section>
