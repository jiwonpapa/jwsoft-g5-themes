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

function menu_rows($groups)
{
    $rows = array();
    foreach (array_values($groups) as $index => $group) {
        $code = sprintf('%02d', $index + 1);
        $rows[] = array($code, $group[0], $group[1], $index);
        foreach ($group[2] as $child_index => $child) {
            $rows[] = array($code.sprintf('%02d', $child_index + 1), $child[0], $child[1], $child_index);
        }
    }
    return $rows;
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
$previous_rows = menu_rows($groups);

// Restore the original complete navigation, including projects and contact under support.
$restored = array(
    'home' => array('메인', G5_URL, array()),
    'company' => array('회사소개', G5_URL.'/pages/company-overview-1.php', array()),
    'business' => array('사업분야', G5_URL.'/pages/business-list-1.php', array()),
    'project' => array('프로젝트', get_pretty_url('gallery'), array(
        array('프로젝트 갤러리', get_pretty_url('gallery')),
        array('자유게시판', get_pretty_url('free')),
    )),
    'recruit' => array('인재채용', G5_URL.'/pages/recruit-talent-1.php', array()),
    'support' => array('고객지원', G5_URL.'/pages/support-home-1.php', array()),
);
$home_names = array('기업 종합형', '사업 중심형', '프로젝트 중심형', '프로세스 중심형', '원페이지형');
foreach ($home_names as $index => $name) {
    $restored['home'][2][] = array('#'.($index + 1).' '.$name, G5_THEME_URL.'/index_'.($index + 1).'.php');
}
foreach ($catalog['pageTypes'] as $type) {
    $category = $type['category'] === 'contact' ? 'support' : $type['category'];
    foreach ($type['layouts'] as $index => $layout) {
        $restored[$category][2][] = array($type['title'].' '.($index + 1).' · '.$layout, G5_URL.'/pages/'.$type['id'].'-'.($index + 1).'.php');
    }
}
$restored['support'][2][] = array('공지사항', get_pretty_url('notice'));
$restored['support'][2][] = array('FAQ', G5_BBS_URL.'/faq.php');
$restored['support'][2][] = array('1:1 문의', G5_BBS_URL.'/qalist.php');
foreach (array('notice', 'gallery', 'free') as $board_id) {
    $board = sql_fetch("select bo_table from {$g5['board_table']} where bo_table = '{$board_id}'");
    if (empty($board['bo_table'])) {
        throw new RuntimeException('Required development board missing: '.$board_id);
    }
}

$current = array();
$result = sql_query("select * from {$g5['menu_table']} order by me_code");
while ($row = sql_fetch_array($result)) {
    $current[] = $row;
}
if ($current && getenv('JW_G5_MENU_RESTORE_PREVIOUS') !== '1') {
    echo "SKIP: existing administrator menus are preserved.\n";
    exit;
}
if ($current) {
    // Fail closed if any administrator edit differs from our exact previous fixture.
    if (count($current) !== count($previous_rows)) {
        throw new RuntimeException('Menu count changed; refusing to replace user menus.');
    }
    foreach ($previous_rows as $index => $expected) {
        $actual = $current[$index];
        $actual_values = array($actual['me_code'], $actual['me_name'], $actual['me_link'], (int) $actual['me_order']);
        if ($actual_values !== $expected || $actual['me_target'] !== 'self'
            || (int) $actual['me_use'] !== 1 || (int) $actual['me_mobile_use'] !== 1) {
            throw new RuntimeException('Administrator menu differs; no changes made.');
        }
    }
    $backup_path = '/tmp/jw-menu-before-restore-'.gmdate('Ymd-His').'.json';
    $backup = fopen($backup_path, 'x');
    if (!$backup || fwrite($backup, json_encode($current, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)) === false) {
        throw new RuntimeException('Menu backup failed; no changes made.');
    }
    fclose($backup);
    echo 'BACKUP: '.$backup_path."\n";
}
$rows = menu_rows($restored);
sql_query('START TRANSACTION');
if ($current) {
    $ids = implode(',', array_map(static function ($row) { return (int) $row['me_id']; }, $current));
    sql_query("delete from {$g5['menu_table']} where me_id in ({$ids})");
}
foreach ($rows as $row) {
    $code = sql_real_escape_string($row[0]);
    $name = sql_real_escape_string($row[1]);
    $link = sql_real_escape_string($row[2]);
    $order = (int) $row[3];
    sql_query("insert into {$g5['menu_table']} set me_code = '{$code}', me_name = '{$name}', me_link = '{$link}', me_target = 'self', me_order = {$order}, me_use = 1, me_mobile_use = 1");
}
sql_query('COMMIT');
echo 'PASS: '.count($rows)." native G5 menus restored with original groups.\n";
