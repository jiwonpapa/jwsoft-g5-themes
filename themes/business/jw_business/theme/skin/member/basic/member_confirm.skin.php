<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/member/basic/member_confirm.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */ if (!defined('_GNUBOARD_')) exit; ?>
<main class="jw-auth" id="jw-main">
    <div class="jw-auth__top"><a class="jw-brand" href="<?php echo G5_URL; ?>"><span class="jw-brand__mark" aria-hidden="true">JW</span><span class="jw-brand__name"><?php echo get_text($config['cf_title']); ?></span></a><button type="button" class="jw-icon-button" data-jw-theme-toggle aria-label="다크 모드로 전환" aria-pressed="false"><i data-lucide="moon"></i></button></div>
    <section class="jw-auth-card" aria-labelledby="jw-confirm-title">
        <header><h1 id="jw-confirm-title"><?php echo get_text($g5['title']); ?></h1><p><?php echo $url === 'member_leave.php' ? '비밀번호를 입력하고 확인하면 회원탈퇴가 진행됩니다.' : '회원정보 보호를 위해 비밀번호를 다시 확인합니다.'; ?></p></header>
        <form name="fmemberconfirm" action="<?php echo $url; ?>" method="post" class="jw-auth-form">
            <input type="hidden" name="mb_id" value="<?php echo get_text($member['mb_id']); ?>"><input type="hidden" name="w" value="u">
            <p>아이디 <strong><?php echo get_text($member['mb_id']); ?></strong></p>
            <label for="jw-confirm-password">비밀번호<input type="password" name="mb_password" id="jw-confirm-password" required maxlength="20" autocomplete="current-password"></label>
            <button type="submit" class="jw-control jw-control--primary">확인</button>
        </form>
    </section><a class="jw-auth__home" href="<?php echo G5_URL; ?>">홈으로 돌아가기</a>
</main>
