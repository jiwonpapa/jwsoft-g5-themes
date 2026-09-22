<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/member/basic/register.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;
?>
<section class="jw-register" aria-labelledby="jw-register-title">
    <?php { $jw_register_step = 1; include G5_THEME_PATH.'/skin/member/basic/steps.php'; } ?>
    <header class="jw-register__header">
        <h2 id="jw-register-title">회원가입 약관</h2>
        <p>필수 약관을 확인하고 동의해 주세요.</p>
    </header>

    <?php @include_once(get_social_skin_path().'/social_register.skin.php'); ?>

    <form name="fregister" class="jw-register-terms" action="<?php echo $register_action_url; ?>" method="post" autocomplete="off" data-jw-register-terms>
        <section class="jw-terms-card" aria-labelledby="jw-terms-service">
            <div class="jw-terms-card__heading">
                <h3 id="jw-terms-service">회원가입약관 <span>필수</span></h3>
                <label class="jw-check"><input type="checkbox" name="agree" value="1" data-jw-required-agreement> 동의합니다</label>
            </div>
            <textarea readonly aria-label="회원가입약관 내용"><?php echo get_text($config['cf_stipulation']); ?></textarea>
        </section>

        <section class="jw-terms-card" aria-labelledby="jw-terms-privacy">
            <div class="jw-terms-card__heading">
                <h3 id="jw-terms-privacy">개인정보 수집 및 이용 <span>필수</span></h3>
                <label class="jw-check"><input type="checkbox" name="agree2" value="1" data-jw-required-agreement> 동의합니다</label>
            </div>
            <div class="jw-terms-table-wrap">
                <table class="jw-terms-table">
                    <caption>개인정보 수집 및 이용 안내</caption>
                    <thead><tr><th>목적</th><th>수집 항목</th><th>보유 기간</th></tr></thead>
                    <tbody>
                        <tr>
                            <td>이용자 식별 및 본인 여부 확인</td>
                            <td>아이디, 이름, 비밀번호<?php echo $config['cf_cert_use'] ? ', 본인인증 정보' : ''; ?></td>
                            <td>회원 탈퇴 시까지</td>
                        </tr>
                        <tr>
                            <td>서비스 통지와 고객지원</td>
                            <td>이메일, 휴대전화번호</td>
                            <td>회원 탈퇴 시까지</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <label class="jw-register-terms__all jw-check"><input type="checkbox" data-jw-agree-all> 필수 약관에 모두 동의합니다</label>

        <div class="jw-register__actions">
            <a href="<?php echo G5_URL; ?>" class="jw-control jw-control--quiet">취소</a>
            <button type="submit" class="jw-control jw-control--primary">다음 단계</button>
        </div>
    </form>
</section>
