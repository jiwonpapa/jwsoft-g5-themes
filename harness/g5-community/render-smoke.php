<?php
// Pure skin rendering: no account, database, session, mail or CAPTCHA mutation.
if (PHP_SAPI !== 'cli') exit(1);
error_reporting(E_ALL);
set_error_handler(function ($severity, $message) { throw new ErrorException($message, 0, $severity); });
define('_GNUBOARD_', true);
define('G5_THEME_PATH', dirname(__DIR__, 2).'/themes/business/jw_business/src/php');
define('G5_URL', 'https://g5themes.test');
define('G5_BBS_URL', G5_URL.'/bbs');
function get_text($text) { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
function is_use_email_certify() { return $GLOBALS['certify']; }
$mb = array('mb_id' => 'fixture', 'mb_name' => '<가입 확인>', 'mb_email' => 'fixture@example.invalid');
foreach (array(false, true) as $certify) {
    foreach (array(false, true) as $is_member) {
        ob_start();
        include G5_THEME_PATH.'/skin/member/basic/register_result.skin.php';
        $html = ob_get_clean();
        if (!str_contains($html, 'aria-current="step"') || !str_contains($html, '&lt;가입 확인&gt;')) throw new RuntimeException('Result output or escaping failed');
        if ($certify !== str_contains($html, '이메일 인증을 완료')) throw new RuntimeException('Email-certification guidance failed');
        if (str_contains($html, '<script') || str_contains($html, 'style.css')) throw new RuntimeException('Legacy output restored');
    }
}
echo "PASS: registration result, email on/off, member/guest, escaping (4 cases)\n";
