<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/member/basic/register_result.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */ if (!defined('_GNUBOARD_')) exit; ?>
<section class="jw-register jw-register--complete">
    <?php $jw_register_step = 3; include G5_THEME_PATH.'/skin/member/basic/steps.php'; ?>
    <header class="jw-register__header"><p class="jw-success-mark" aria-hidden="true">✓</p><h2>회원가입이 완료되었습니다</h2><p><?php echo get_text($mb['mb_name']); ?>님, 환영합니다.</p></header>
    <div class="jw-member-section">
        <dl class="jw-account-summary"><div><dt>아이디</dt><dd><?php echo get_text($mb['mb_id']); ?></dd></div><div><dt>이메일</dt><dd><?php echo get_text($mb['mb_email']); ?></dd></div></dl>
        <?php if (is_use_email_certify()) { ?><p class="jw-field-help">입력하신 이메일로 발송된 인증메일을 확인해 주세요. 이메일 인증을 완료한 뒤 로그인하실 수 있습니다.</p><?php } else { ?><p>가입하신 계정으로 게시판과 회원 서비스를 이용하실 수 있습니다.</p><?php } ?>
    </div>
    <div class="jw-register__actions"><a class="jw-control jw-control--quiet" href="<?php echo G5_URL; ?>/">홈으로</a><?php if (!$is_member) { ?><a class="jw-control jw-control--primary" href="<?php echo G5_BBS_URL; ?>/login.php">로그인</a><?php } ?></div>
</section>
