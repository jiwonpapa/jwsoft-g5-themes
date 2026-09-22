<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/member/basic/login.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;
?>
<main class="jw-auth" id="jw-main">
    <div class="jw-auth__top">
        <a class="jw-brand" href="<?php echo G5_URL; ?>" aria-label="<?php echo get_text($config['cf_title']); ?> 홈">
            <span class="jw-brand__mark" aria-hidden="true">JW</span>
            <span class="jw-brand__name"><?php echo get_text($config['cf_title']); ?></span>
        </a>
        <button type="button" class="jw-icon-button" data-jw-theme-toggle aria-label="다크 모드로 전환" aria-pressed="false"><i data-lucide="moon"></i></button>
    </div>

    <section class="jw-auth-card" aria-labelledby="jw-login-title">
        <header>
            <p>다시 오신 것을 환영합니다.</p>
            <h1 id="jw-login-title">로그인</h1>
        </header>

        <form name="flogin" action="<?php echo $login_action_url; ?>" method="post" class="jw-auth-form" data-jw-login-form>
            <input type="hidden" name="url" value="<?php echo $login_url; ?>">
            <label for="login_id">아이디
                <input type="text" name="mb_id" id="login_id" required maxlength="20" autocomplete="username" placeholder="아이디를 입력하세요">
            </label>
            <label for="login_pw">비밀번호
                <input type="password" name="mb_password" id="login_pw" required maxlength="20" autocomplete="current-password" placeholder="비밀번호를 입력하세요">
            </label>
            <div class="jw-auth-form__options">
                <label class="jw-check"><input type="checkbox" name="auto_login" value="1" data-jw-auto-login> 자동 로그인</label>
                <a href="<?php echo G5_BBS_URL; ?>/password_lost.php">아이디·비밀번호 찾기</a>
            </div>
            <button type="submit" class="jw-control jw-control--primary jw-auth-form__submit">로그인</button>
        </form>

        <?php @include_once(get_social_skin_path().'/social_login.skin.php'); ?>

        <footer class="jw-auth-card__footer">
            <span>아직 회원이 아니신가요?</span>
            <a href="<?php echo G5_BBS_URL; ?>/register.php">회원가입</a>
        </footer>
    </section>

    <a class="jw-auth__home" href="<?php echo G5_URL; ?>">홈으로 돌아가기</a>
</main>
