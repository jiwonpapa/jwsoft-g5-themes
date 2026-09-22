<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/member/basic/password.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */ if (!defined('_GNUBOARD_')) exit; ?>
<main class="jw-auth" id="jw-main"><section class="jw-auth-card"><header class="jw-register__header"><h2><?php echo get_text($g5['title']); ?></h2><p>글 작성 시 입력한 비밀번호를 확인해 주세요.</p></header>
<form name="fboardpassword" class="jw-auth-form" action="<?php echo $action; ?>" method="post">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">

<label for="jw-post-password">비밀번호<input type="password" name="wr_password" id="jw-post-password" required maxlength="20" autocomplete="current-password"></label><button type="submit" class="jw-control jw-control--primary">확인</button></form></section><a class="jw-auth__home" href="<?php echo G5_URL; ?>">홈으로 돌아가기</a></main>
