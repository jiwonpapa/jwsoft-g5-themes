<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/member/basic/register_form.skin.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;

$jw_captcha_html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', captcha_html());
$jw_cert_page = 'register';
include G5_THEME_PATH.'/skin/member/basic/certification.php';

$jw_can_change_open = empty($member['mb_open_date'])
    || $member['mb_open_date'] <= date('Y-m-d', G5_SERVER_TIME - ((int)$config['cf_open_modify'] * 86400));
$jw_use_member_image = ($member['mb_level'] ?? 1) >= $config['cf_icon_level']
    && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height'];
$jw_use_phone = $config['cf_use_hp'] || ($config['cf_cert_use'] && ($config['cf_cert_hp'] || $config['cf_cert_simple']));
$jw_sms_company = !empty($config['cf_sms_use']) && $config['cf_sms_use'] === 'icode' ? '아이코드' : '';
$jw_use_member_icon = $config['cf_use_member_icon'] && ($member['mb_level'] ?? 1) >= $config['cf_icon_level'];
$jw_has_extra = $config['cf_use_signature'] || $config['cf_use_profile'] || $jw_use_member_icon || $jw_use_member_image || ($w === '' && $config['cf_use_recommend']);
?>
<?php if ($config['cf_use_addr']) echo G5_POSTCODE_JS; ?>

<section class="jw-register jw-register--form" aria-labelledby="jw-member-form-title">
    <?php if ($w === '') { $jw_register_step = 2; include G5_THEME_PATH.'/skin/member/basic/steps.php'; } ?>
    <header class="jw-register__header">
        <h2 id="jw-member-form-title"><?php echo $w === '' ? '회원정보 입력' : '회원정보 수정'; ?></h2>
        <p>필수 항목을 입력해 주세요. 선택 항목은 나중에 수정할 수 있습니다.</p>
    </header>

    <form
        id="fregisterform"
        name="fregisterform"
        class="jw-member-form"
        action="<?php echo $register_action_url; ?>"
        method="post"
        enctype="multipart/form-data"
        autocomplete="off"
        data-jw-member-form
        data-mode="<?php echo $w; ?>"
        data-cert-required="<?php echo ($config['cf_cert_use'] && $config['cf_cert_req']) ? 'true' : 'false'; ?>"
        data-id-url="<?php echo G5_BBS_URL; ?>/ajax.mb_id.php"
        data-nick-url="<?php echo G5_BBS_URL; ?>/ajax.mb_nick.php"
        data-email-url="<?php echo G5_BBS_URL; ?>/ajax.mb_email.php"
        data-phone-url="<?php echo G5_BBS_URL; ?>/ajax.mb_hp.php"
        data-recommend-url="<?php echo G5_BBS_URL; ?>/ajax.mb_recommend.php"
        data-captcha-result-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_result.php">
        <input type="hidden" name="w" value="<?php echo $w; ?>">
        <input type="hidden" name="url" value="<?php echo $urlencode; ?>">
        <input type="hidden" name="agree" value="<?php echo $agree; ?>">
        <input type="hidden" name="agree2" value="<?php echo $agree2; ?>">
        <input type="hidden" name="cert_type" value="<?php echo get_text($member['mb_certify']); ?>">
        <input type="hidden" name="cert_no" value="">
        <?php if ($config['cf_cert_hp'] === 'kcp') { ?><input type="hidden" name="veri_up_hash" value=""><?php } ?>
        <?php if (isset($member['mb_sex'])) { ?><input type="hidden" name="mb_sex" value="<?php echo get_text($member['mb_sex']); ?>"><?php } ?>

        <section class="jw-form-section" aria-labelledby="jw-member-account">
            <div class="jw-form-section__head">
                <p>01</p>
                <div><h3 id="jw-member-account">사이트 이용정보</h3><span>로그인에 사용할 계정 정보입니다.</span></div>
            </div>
            <div class="jw-form-section__body jw-member-fields">
                <label class="jw-field jw-field--wide" for="reg_mb_id">
                    <span>아이디 <em>필수</em></span>
                    <input class="jw-input" type="text" name="mb_id" value="<?php echo get_text($member['mb_id']); ?>" id="reg_mb_id" <?php echo $required; ?> <?php echo $readonly; ?> minlength="3" maxlength="20" pattern="[A-Za-z0-9_]+" autocomplete="username" aria-describedby="jw-help-id jw-status-id">
                    <small id="jw-help-id">영문자, 숫자, 밑줄만 사용해 3~20자로 입력합니다.</small>
                    <span class="jw-field-status" id="jw-status-id" data-jw-field-status="id" aria-live="polite"></span>
                </label>
                <label class="jw-field" for="reg_mb_password">
                    <span>비밀번호 <?php if ($w === '') { ?><em>필수</em><?php } ?></span>
                    <input class="jw-input" type="password" name="mb_password" id="reg_mb_password" <?php echo $required; ?> minlength="3" maxlength="20" autocomplete="new-password">
                </label>
                <label class="jw-field" for="reg_mb_password_re">
                    <span>비밀번호 확인 <?php if ($w === '') { ?><em>필수</em><?php } ?></span>
                    <input class="jw-input" type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required; ?> minlength="3" maxlength="20" autocomplete="new-password">
                </label>
            </div>
        </section>

        <section class="jw-form-section" aria-labelledby="jw-member-profile">
            <div class="jw-form-section__head">
                <p>02</p>
                <div><h3 id="jw-member-profile">기본정보</h3><span>회원 식별과 서비스 안내에 사용합니다.</span></div>
            </div>
            <div class="jw-form-section__body jw-member-fields">
                <?php if ($jw_cert_buttons) { ?>
                <div class="jw-field jw-field--wide jw-certification">
                    <span>본인확인 <?php if ($config['cf_cert_req']) { ?><em>필수</em><?php } ?></span>
                    <div class="jw-certification__actions">
                        <?php foreach ($jw_cert_buttons as $jw_cert_button) { ?>
                        <button type="button" class="jw-control jw-control--quiet" data-jw-certify data-cert-type="<?php echo $jw_cert_button['type']; ?>" data-cert-url="<?php echo $jw_cert_button['url']; ?>" data-window-name="<?php echo $jw_cert_button['window']; ?>"><?php echo $jw_cert_button['label']; ?></button>
                        <?php } ?>
                    </div>
                    <?php if ($member['mb_certify']) { ?><small class="jw-field-status jw-field-status--success">본인확인이 완료된 계정입니다.</small><?php } ?>
                </div>
                <?php } ?>

                <label class="jw-field" for="reg_mb_name">
                    <span>이름 <em>필수</em></span>
                    <input class="jw-input" type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']); ?>" required <?php echo $name_readonly; ?> maxlength="50" autocomplete="name">
                </label>

                <?php if ($req_nick) { ?>
                <label class="jw-field" for="reg_mb_nick">
                    <span>닉네임 <em>필수</em></span>
                    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick'] ?? ''); ?>">
                    <input class="jw-input" type="text" name="mb_nick" value="<?php echo get_text($member['mb_nick'] ?? ''); ?>" id="reg_mb_nick" required maxlength="20" aria-describedby="jw-help-nick jw-status-nick">
                    <small id="jw-help-nick">공백 없이 한글 2자 또는 영문 4자 이상. 변경 후 <?php echo (int)$config['cf_nick_modify']; ?>일 동안 다시 바꿀 수 없습니다.</small>
                    <span class="jw-field-status" id="jw-status-nick" data-jw-field-status="nick" aria-live="polite"></span>
                </label>
                <?php } else { ?>
                <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick'] ?? ''); ?>">
                <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick'] ?? ''); ?>">
                <?php } ?>

                <label class="jw-field jw-field--wide" for="reg_mb_email">
                    <span>이메일 <em>필수</em></span>
                    <input type="hidden" name="old_email" value="<?php echo get_text($member['mb_email']); ?>">
                    <input class="jw-input" type="email" name="mb_email" value="<?php echo get_text($member['mb_email'] ?? ''); ?>" id="reg_mb_email" required maxlength="100" autocomplete="email" aria-describedby="jw-status-email">
                    <?php if ($config['cf_use_email_certify']) { ?><small>주소를 변경하면 새 주소로 발송되는 인증 메일을 확인해야 합니다.</small><?php } ?>
                    <span class="jw-field-status" id="jw-status-email" data-jw-field-status="email" aria-live="polite"></span>
                </label>

                <?php if ($config['cf_use_homepage']) { ?>
                <label class="jw-field jw-field--wide" for="reg_mb_homepage">
                    <span>홈페이지 <?php if ($config['cf_req_homepage']) { ?><em>필수</em><?php } ?></span>
                    <input class="jw-input" type="url" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']); ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage'] ? 'required' : ''; ?> maxlength="255" inputmode="url">
                </label>
                <?php } ?>

                <?php if ($config['cf_use_tel']) { ?>
                <label class="jw-field" for="reg_mb_tel">
                    <span>전화번호 <?php if ($config['cf_req_tel']) { ?><em>필수</em><?php } ?></span>
                    <input class="jw-input" type="tel" name="mb_tel" value="<?php echo get_text($member['mb_tel']); ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel'] ? 'required' : ''; ?> maxlength="20" autocomplete="tel">
                </label>
                <?php } ?>

                <?php if ($jw_use_phone) { ?>
                <label class="jw-field <?php echo $config['cf_use_tel'] ? '' : 'jw-field--wide'; ?>" for="reg_mb_hp">
                    <span>휴대폰번호 <?php if ($hp_required) { ?><em>필수</em><?php } ?></span>
                    <input class="jw-input" type="tel" name="mb_hp" value="<?php echo get_text($member['mb_hp']); ?>" id="reg_mb_hp" <?php echo $hp_required; ?> <?php echo $hp_readonly; ?> maxlength="20" autocomplete="tel" aria-describedby="jw-status-phone">
                    <?php if ($config['cf_cert_use'] && ($config['cf_cert_hp'] || $config['cf_cert_simple'])) { ?><input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']); ?>"><?php } ?>
                    <span class="jw-field-status" id="jw-status-phone" data-jw-field-status="phone" aria-live="polite"></span>
                </label>
                <?php } ?>

                <?php if ($config['cf_use_addr']) { ?>
                <fieldset class="jw-field jw-field--wide jw-address">
                    <legend>주소 <?php if ($config['cf_req_addr']) { ?><em>필수</em><?php } ?></legend>
                    <div class="jw-address__search">
                        <input class="jw-input" type="text" name="mb_zip" value="<?php echo get_text($member['mb_zip1'].$member['mb_zip2']); ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr'] ? 'required' : ''; ?> maxlength="6" inputmode="numeric" placeholder="우편번호" aria-label="우편번호" readonly>
                        <button type="button" class="jw-control jw-control--quiet" data-jw-address-search>주소 검색</button>
                    </div>
                    <input class="jw-input" type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']); ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr'] ? 'required' : ''; ?> placeholder="기본주소" aria-label="기본주소" readonly>
                    <input class="jw-input" type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']); ?>" id="reg_mb_addr2" placeholder="상세주소" aria-label="상세주소">
                    <input class="jw-input" type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']); ?>" id="reg_mb_addr3" placeholder="참고항목" aria-label="참고항목" readonly>
                    <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
                </fieldset>
                <?php } ?>
            </div>
        </section>

        <?php if ($jw_has_extra) { ?>
        <section class="jw-form-section" aria-labelledby="jw-member-extra">
            <div class="jw-form-section__head"><p>03</p><div><h3 id="jw-member-extra">추가정보</h3><span>나를 소개할 정보를 입력해 주세요.</span></div></div>
            <div class="jw-form-section__body jw-member-fields">
                <?php if ($config['cf_use_signature']) { ?><label class="jw-field jw-field--wide" for="reg_mb_signature"><span>서명 <?php if ($config['cf_req_signature']) { ?><em>필수</em><?php } ?></span><textarea class="jw-textarea" name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature'] ? 'required' : ''; ?> rows="4"><?php echo get_text($member['mb_signature']); ?></textarea></label><?php } ?>
                <?php if ($config['cf_use_profile']) { ?><label class="jw-field jw-field--wide" for="reg_mb_profile"><span>자기소개 <?php if ($config['cf_req_profile']) { ?><em>필수</em><?php } ?></span><textarea class="jw-textarea" name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile'] ? 'required' : ''; ?> rows="6"><?php echo get_text($member['mb_profile']); ?></textarea></label><?php } ?>
                <?php if ($jw_use_member_icon) { ?>
                <div class="jw-field jw-upload-field"><label for="reg_mb_icon"><span>회원 아이콘</span><small><?php echo (int)$config['cf_member_icon_width']; ?>×<?php echo (int)$config['cf_member_icon_height']; ?>px 이하, <?php echo number_format($config['cf_member_icon_size']); ?>byte 이하</small></label><input class="jw-file-input" type="file" name="mb_icon" id="reg_mb_icon" accept=".gif,.jpg,.jpeg,.png,image/gif,image/jpeg,image/png"><?php if ($w === 'u' && file_exists($mb_icon_path)) { ?><div class="jw-upload-preview"><img src="<?php echo $mb_icon_url; ?>" alt="현재 회원 아이콘"><label class="jw-check"><input type="checkbox" name="del_mb_icon" value="1"> 삭제</label></div><?php } ?></div>
                <?php } ?>
                <?php if ($jw_use_member_image) { ?>
                <div class="jw-field jw-upload-field"><label for="reg_mb_img"><span>회원 이미지</span><small><?php echo (int)$config['cf_member_img_width']; ?>×<?php echo (int)$config['cf_member_img_height']; ?>px 이하, <?php echo number_format($config['cf_member_img_size']); ?>byte 이하</small></label><input class="jw-file-input" type="file" name="mb_img" id="reg_mb_img" accept=".gif,.jpg,.jpeg,.png,image/gif,image/jpeg,image/png"><?php if ($w === 'u' && file_exists($mb_img_path)) { ?><div class="jw-upload-preview"><img src="<?php echo $mb_img_url; ?>" alt="현재 회원 이미지"><label class="jw-check"><input type="checkbox" name="del_mb_img" value="1"> 삭제</label></div><?php } ?></div>
                <?php } ?>
                <?php if ($w === '' && $config['cf_use_recommend']) { ?><label class="jw-field jw-field--wide" for="reg_mb_recommend"><span>추천인 아이디</span><input class="jw-input" type="text" name="mb_recommend" id="reg_mb_recommend" maxlength="20" aria-describedby="jw-status-recommend"><span class="jw-field-status" id="jw-status-recommend" data-jw-field-status="recommend" aria-live="polite"></span></label><?php } ?>
            </div>
        </section>
        <?php } ?>

        <section class="jw-form-section" aria-labelledby="jw-member-preferences">
            <div class="jw-form-section__head"><p><?php echo $jw_has_extra ? '04' : '03'; ?></p><div><h3 id="jw-member-preferences">공개 및 수신 설정</h3><span>선택 항목은 가입 후에도 변경할 수 있습니다.</span></div></div>
            <div class="jw-form-section__body jw-preference-list">
                <?php if ($jw_can_change_open) { ?>
                <label class="jw-preference"><input type="checkbox" name="mb_open" value="1" <?php echo ($w === '' || $member['mb_open']) ? 'checked' : ''; ?>><span><strong>회원정보 공개</strong><small>다른 회원이 내 공개 정보를 볼 수 있습니다. <?php if ((int)$config['cf_open_modify'] > 0) { ?>변경 후 <?php echo (int)$config['cf_open_modify']; ?>일 동안 다시 바꿀 수 없습니다.<?php } ?></small></span></label>
                <input type="hidden" name="mb_open_default" value="<?php echo (int)$member['mb_open']; ?>">
                <?php } else { ?>
                <input type="hidden" name="mb_open" value="<?php echo (int)$member['mb_open']; ?>">
                <div class="jw-preference jw-preference--locked"><span><strong>회원정보 공개</strong><small><?php echo date('Y년 m월 j일', strtotime($member['mb_open_date'].' 00:00:00') + (int)$config['cf_open_modify'] * 86400); ?> 이후 변경할 수 있습니다.</small></span></div>
                <?php } ?>

                <?php if ($config['cf_use_promotion'] == 1) { ?>
                <label class="jw-preference"><input type="checkbox" name="mb_marketing_agree" value="1" <?php echo $member['mb_marketing_agree'] ? 'checked' : ''; ?>><span><strong>마케팅 목적의 개인정보 수집 및 이용</strong><small>서비스 혜택과 행사 안내에 활용합니다.</small></span><button type="button" data-jw-consent-open="jw-consent-marketing">내용 보기</button></label>
                <input type="hidden" name="mb_marketing_agree_default" value="<?php echo (int)$member['mb_marketing_agree']; ?>">
                <label class="jw-preference"><input type="checkbox" id="reg_mb_promotion_agree" data-jw-promotion-parent><span><strong>광고성 정보 수신</strong><small>선택한 채널로 오전 8시부터 오후 9시까지 안내할 수 있습니다.</small></span><button type="button" data-jw-consent-open="jw-consent-promotion">내용 보기</button></label>
                <div class="jw-preference-channels"><label class="jw-check"><input type="checkbox" name="mb_mailling" value="1" <?php echo $member['mb_mailling'] ? 'checked' : ''; ?> data-jw-promotion-child> 이메일</label><input type="hidden" name="mb_mailling_default" value="<?php echo (int)$member['mb_mailling']; ?>"><?php if ($config['cf_use_hp'] || $config['cf_req_hp']) { ?><label class="jw-check"><input type="checkbox" name="mb_sms" value="1" <?php echo $member['mb_sms'] ? 'checked' : ''; ?> data-jw-promotion-child> SMS·카카오톡</label><input type="hidden" name="mb_sms_default" value="<?php echo (int)$member['mb_sms']; ?>"><?php } ?></div>
                <?php if ($jw_sms_company !== '') { ?><label class="jw-preference"><input type="checkbox" name="mb_thirdparty_agree" value="1" <?php echo $member['mb_thirdparty_agree'] ? 'checked' : ''; ?>><span><strong>개인정보 제3자 제공</strong><small><?php echo $jw_sms_company; ?> 문자 발송 서비스에 필요한 정보를 제공합니다.</small></span><button type="button" data-jw-consent-open="jw-consent-thirdparty">내용 보기</button></label><input type="hidden" name="mb_thirdparty_agree_default" value="<?php echo (int)$member['mb_thirdparty_agree']; ?>"><?php } ?>
                <?php } ?>
            </div>
        </section>

        <section class="jw-form-section jw-form-section--captcha" aria-labelledby="jw-member-captcha">
            <div class="jw-form-section__head"><p>✓</p><div><h3 id="jw-member-captcha">자동등록방지</h3><span>화면의 문자를 정확히 입력해 주세요.</span></div></div>
            <div class="jw-form-section__body"><div class="jw-captcha" data-jw-captcha data-session-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_session.php" data-image-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_image.php" data-audio-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_mp3.php"><?php echo $jw_captcha_html; ?></div></div>
        </section>

        <?php if ($w === 'u' && function_exists('social_member_provider_manage')) { ?><section class="jw-form-section jw-form-section--external"><div class="jw-form-section__head"><p>↗</p><div><h3>연결된 소셜 계정</h3><span>외부 계정 연결 상태를 관리합니다.</span></div></div><div class="jw-form-section__body"><?php social_member_provider_manage(); ?></div></section><?php } ?>

        <div class="jw-register__actions jw-member-form__actions"><a href="<?php echo G5_URL; ?>" class="jw-control jw-control--quiet">취소</a><button type="submit" class="jw-control jw-control--primary" accesskey="s"><?php echo $w === '' ? '가입하기' : '정보 수정'; ?></button></div>
    </form>
</section>

<?php if ($config['cf_use_promotion'] == 1) { ?>
<dialog class="jw-consent-dialog" data-jw-consent-dialog><header><h3 data-jw-consent-title>선택 동의 안내</h3><button type="button" data-jw-consent-close aria-label="닫기">닫기</button></header><div data-jw-consent-content></div></dialog>
<template id="jw-consent-marketing"><p><strong>목적</strong> 서비스 마케팅 및 프로모션</p><p><strong>항목</strong> 이름, 이메일<?php echo $jw_use_phone ? ', 휴대폰번호' : ''; ?></p><p><strong>보유기간</strong> 회원 탈퇴 또는 동의 철회 시까지</p><p>동의를 거부해도 기본 서비스 이용에는 영향이 없습니다.</p></template>
<template id="jw-consent-promotion"><p>동의한 개인정보를 이용해 이메일, SMS 또는 카카오톡으로 광고성 정보를 전송할 수 있습니다. 동의는 회원정보에서 언제든지 철회할 수 있습니다.</p></template>
<?php if ($jw_sms_company !== '') { ?><template id="jw-consent-thirdparty"><p><strong>제공받는 자</strong> <?php echo $jw_sms_company; ?></p><p><strong>목적</strong> 문자 및 알림 발송</p><p><strong>항목</strong> 이름, 휴대폰번호</p><p><strong>보유기간</strong> 제공 목적 종료 또는 동의 철회 시까지</p></template><?php } ?>
<?php } ?>
