<?php
if (!defined('_GNUBOARD_')) exit;
$jw_cert_buttons = array();

if ($config['cf_cert_use']) {
    if ($config['cf_cert_simple'] && defined('G5_INICERT_URL')) {
        $jw_cert_buttons[] = array('label' => '간편인증', 'type' => 'simple', 'url' => G5_INICERT_URL.'/ini_request.php?directAgency=&pageType='.$jw_cert_page.'', 'window' => 'sa_popup');
    }
    if ($config['cf_cert_ipin'] && defined('G5_OKNAME_URL')) {
        $jw_cert_buttons[] = array('label' => '아이핀 본인확인', 'type' => 'ipin', 'url' => G5_OKNAME_URL.'/ipin1.php?pageType='.$jw_cert_page.'', 'window' => 'kcbPop');
    }
    if ($config['cf_cert_hp']) {
        $jw_hp_provider = $config['cf_cert_hp'];
        $jw_hp_url = '';
        if ($jw_hp_provider === 'kcb' && defined('G5_OKNAME_URL')) $jw_hp_url = G5_OKNAME_URL.'/hpcert1.php?pageType='.$jw_cert_page.'';
        if ($jw_hp_provider === 'kcp' && defined('G5_KCPCERT_URL')) $jw_hp_url = G5_KCPCERT_URL.'/kcpcert_form.php?pageType='.$jw_cert_page.'';
        if ($jw_hp_provider === 'kcp_v2' && defined('G5_KCPCERT_V2_URL')) $jw_hp_url = G5_KCPCERT_V2_URL.'/kcpcert_form.php?pageType='.$jw_cert_page.'';
        if ($jw_hp_provider === 'lg' && defined('G5_LGXPAY_URL')) $jw_hp_url = G5_LGXPAY_URL.'/AuthOnlyReq.php?pageType='.$jw_cert_page.'';
        if ($jw_hp_url !== '') $jw_cert_buttons[] = array('label' => '휴대폰 본인확인', 'type' => 'hp', 'url' => $jw_hp_url, 'window' => 'auth_popup');
    }
}

