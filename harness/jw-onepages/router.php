<?php
/** JW SOFT: loopback-only fixture, never ship this directory to customers. */
if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', array('127.0.0.1', '::1'), true)) { http_response_code(403); exit; }
$root = dirname(__DIR__, 2);
$bundle = $root.'/themes/business/jw_business';
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path === '/capture') {
    $names = array('showcase-desktop','showcase-mobile','services-desktop','services-mobile','projects-desktop','projects-mobile','showcase-rotation','projects-gallery','services-dark');
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($_POST['name'] ?? '', $names, true)) {
        $bytes = base64_decode($_POST['image'] ?? '', true);
        if ($bytes !== false && substr($bytes, 0, 8) === "\x89PNG\r\n\x1a\n" && strlen($bytes) < 12000000) {
            $dir = $root.'/.impeccable/review/onepages';
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            file_put_contents($dir.'/'.$_POST['name'].'.png', $bytes);
            echo '<p>캡처 저장 완료: '.htmlspecialchars($_POST['name']).'</p>';
        }
    }
    echo '<form method="post"><label>캡처 이름<select name="name">';
    foreach ($names as $name) echo '<option>'.htmlspecialchars($name).'</option>';
    echo '</select></label><label>PNG 데이터<textarea name="image"></textarea></label><button>캡처 저장</button></form>';
    exit;
}
if ($path === '/bbs/qalist.php') {
    echo '<h1>문의 경로 확인</h1><p>G5 1:1 문의 연결 대상입니다. 이 로컬 미리보기는 DB를 연결하지 않아 실제 문의는 접수되지 않습니다.</p>';
    exit;
}
$mounts = array('/theme/onepages/assets/' => $bundle.'/onepages/assets/', '/theme/css/onepages.min.css' => $bundle.'/theme/css/onepages.min.css', '/theme/js/onepages.min.js' => $bundle.'/theme/js/onepages.min.js', '/base/' => $root.'/themes/business/jw_business/theme/');
foreach ($mounts as $prefix => $directory) {
    if (strpos($path, $prefix) !== 0) continue;
    $file = realpath($directory.substr($path, strlen($prefix)));
    $base = realpath(is_dir($directory) ? $directory : dirname($directory));
    if (!$file || !$base || strpos($file, $base.DIRECTORY_SEPARATOR) !== 0 || !is_file($file)) { http_response_code(404); exit; }
    $types = array('css'=>'text/css','js'=>'text/javascript','webp'=>'image/webp','woff2'=>'font/woff2','svg'=>'image/svg+xml');
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    if (!isset($types[$extension])) { http_response_code(404); exit; }
    if (isset($_GET['broken']) && $extension === 'webp') { http_response_code(404); exit; }
    header('Content-Type: '.$types[$extension]);
    readfile($file);
    exit;
}
$allowed = array('showcase','services','projects');
$variant = basename($path);
if (!in_array($variant, $allowed, true)) { http_response_code(404); echo 'Use /showcase, /services or /projects'; exit; }
define('_GNUBOARD_', true);
define('G5_URL', '');
define('G5_BBS_URL', '/bbs');
define('G5_THEME_URL', '/theme');
define('G5_THEME_PATH', __DIR__.'/shell');
$styles = array();
function add_stylesheet($html, $order) { global $styles; $styles[] = $html; }
function get_versioned_asset_url($url) { return $url.'?ver=fixture'; }
include $bundle.'/pages/onepage-'.$variant.'.php';
