<?php
/** Development-only G5 menu fixture. Never shipped in the theme. */
if (PHP_SAPI !== 'cli' || getenv('JW_G5_MENU_ALLOWED') !== '1') {
    exit(1);
}
$g5_root = getenv('JW_G5_ROOT') ?: '/var/www/html';
$_SERVER['HTTP_HOST'] = 'g5themes.test';
$_SERVER['SERVER_NAME'] = 'g5themes.test';
$_SERVER['SERVER_PORT'] = '443';
$_SERVER['HTTPS'] = 'on';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_SOFTWARE'] = 'jw-g5-menu-fixture-cli';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $g5_root.'/index.php';
include_once $g5_root.'/common.php';
if (($config['cf_theme'] ?? '') !== 'jw_business') {
    throw new RuntimeException('Fixture requires the active jw_business development theme.');
}
$existing = sql_fetch("select count(*) as count from {$g5['menu_table']}");
if ((int) $existing['count'] !== 0) {
    echo "SKIP: existing administrator menus are preserved.\n";
    exit;
}
$catalog = json_decode(file_get_contents(__DIR__.'/PAGE-CATALOG.json'), true, 512, JSON_THROW_ON_ERROR);
$groups = array(
    'home' => array('메인', G5_URL, array()),
    'company' => array('회사소개', G5_URL.'/pages/company-overview-1.php', array()),
    'business' => array('사업분야', G5_URL.'/pages/business-list-1.php', array()),
    'recruit' => array('인재채용', G5_URL.'/pages/recruit-talent-1.php', array()),
    'support' => array('고객지원', G5_URL.'/pages/support-home-1.php', array()),
    'contact' => array('문의', G5_URL.'/pages/contact-1.php', array()),
);
foreach (range(1, 5) as $variant) {
    $groups['home'][2][] = array('메인 '.$variant, G5_THEME_URL.'/index_'.$variant.'.php');
}
foreach ($catalog['pageTypes'] as $type) {
    foreach (range(1, 5) as $variant) {
        $groups[$type['category']][2][] = array($type['title'].' '.$variant, G5_URL.'/pages/'.$type['id'].'-'.$variant.'.php');
    }
}
$groups['support'][2][] = array('FAQ', G5_BBS_URL.'/faq.php');
$groups['support'][2][] = array('1:1 문의', G5_BBS_URL.'/qalist.php');
$rows = array();
foreach (array_values($groups) as $index => $group) {
    $code = sprintf('%02d', $index + 1);
    $rows[] = array($code, $group[0], $group[1], $index);
    foreach ($group[2] as $child_index => $child) {
        $rows[] = array($code.sprintf('%02d', $child_index + 1), $child[0], $child[1], $child_index);
    }
}
// Empty-table-only insertion uses the stock G5 schema and preserves existing menus.
sql_query('START TRANSACTION');
foreach ($rows as $row) {
    $code = sql_real_escape_string($row[0]);
    $name = sql_real_escape_string($row[1]);
    $link = sql_real_escape_string($row[2]);
    $order = (int) $row[3];
    sql_query("insert into {$g5['menu_table']} set me_code = '{$code}', me_name = '{$name}', me_link = '{$link}', me_target = 'self', me_order = {$order}, me_use = 1, me_mobile_use = 1");
}
sql_query('COMMIT');
echo 'PASS: '.count($rows)." native G5 development menus inserted.\n";
