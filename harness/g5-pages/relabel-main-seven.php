<?php
/** JW SOFT: development-only, exact-link menu relabel. Run inside the office G5 PHP container. */
if (PHP_SAPI !== 'cli') exit(1);
$mode = $argv[1] ?? 'inspect';
if (!in_array($mode, array('inspect', 'apply', 'verify'), true)) throw new RuntimeException('Unknown mode');
$root = '/var/www/html';
define('_GNUBOARD_', true);
require $root.'/data/dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD, G5_MYSQL_DB);
$db->set_charset('utf8mb4');
$table = $g5['menu_table'];
$configTable = $g5['config_table'];
if (!preg_match('/^[a-zA-Z0-9_]+$/', $table) || !preg_match('/^[a-zA-Z0-9_]+$/', $configTable)) throw new RuntimeException('Invalid G5 table');
$config = $db->query('SELECT cf_theme FROM '.$configTable)->fetch_assoc();
if (($config['cf_theme'] ?? '') !== 'jw_business') throw new RuntimeException('Wrong active theme');
$read = static function () use ($db, $table) { return $db->query('SELECT * FROM '.$table.' ORDER BY me_id')->fetch_all(MYSQLI_ASSOC); };
$digest = static function ($rows) { return hash('sha256', json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)); };
$expected = array(
    'https://g5themes.test/theme/jw_business/index_1.php' => array('#1 기업 종합형', '#1 종합 에이전시'),
    'https://g5themes.test/theme/jw_business/index_2.php' => array('#2 사업 중심형', '#2 전략·의사결정'),
    'https://g5themes.test/theme/jw_business/index_3.php' => array('#3 프로젝트 중심형', '#3 결과물 포트폴리오'),
    'https://g5themes.test/theme/jw_business/index_4.php' => array('#4 프로세스 중심형', '#4 과정·산출물'),
    'https://g5themes.test/pages/onepage-showcase.php' => array('원페이지 · 제품형', '원페이지 · 제품 쇼케이스'),
    'https://g5themes.test/pages/onepage-services.php' => array('원페이지 · 서비스형', '원페이지 · 서비스 상담'),
    'https://g5themes.test/pages/onepage-projects.php' => array('원페이지 · 프로젝트형', '원페이지 · 공간 프로젝트'),
);
$before = $read();
$main = array_values(array_filter($before, static function ($row) { return $row['me_name'] === '메인' && strlen($row['me_code']) === 2 && $row['me_link'] === 'https://g5themes.test'; }));
if (count($main) !== 1) throw new RuntimeException('Expected one main parent');
$parentCode = $main[0]['me_code'];
$targets = array();
foreach ($expected as $url => $names) {
    $matches = array_values(array_filter($before, static function ($row) use ($url) { return $row['me_link'] === $url; }));
    if (count($matches) !== 1) throw new RuntimeException('Missing or duplicate menu: '.$url);
    $row = $matches[0];
    if (substr($row['me_code'], 0, 2) !== $parentCode || strlen($row['me_code']) !== 4
        || !in_array($row['me_name'], $names, true) || $row['me_target'] !== 'self'
        || (int)$row['me_use'] !== 1 || (int)$row['me_mobile_use'] !== 1) {
        throw new RuntimeException('Administrator menu differs; no changes made: '.$url);
    }
    $targets[] = array('id' => (int)$row['me_id'], 'old' => $row['me_name'], 'new' => $names[1]);
}
$remaining = array_values(array_filter($targets, static function ($row) { return $row['old'] !== $row['new']; }));
if ($mode === 'inspect') {
    echo json_encode(array('count' => count($before), 'snapshot' => $digest($before), 'remaining' => $remaining), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
    exit;
}
if ($mode === 'verify') {
    if ($remaining) throw new RuntimeException('Seven menu labels are not all updated');
    echo 'PASS: seven distinct main menu labels, existing row count '.count($before).PHP_EOL;
    exit;
}
if (getenv('JW_MAIN_SEVEN_MENU_APPLY') !== '1') throw new RuntimeException('Explicit apply flag required');
if (!$remaining) { echo "NOOP: seven labels already match.\n"; exit; }
if (!hash_equals(getenv('JW_MAIN_SEVEN_MENU_EXPECTED_HASH') ?: '', $digest($before))) throw new RuntimeException('Menu changed since inspection');
$backup = '/tmp/jw-main-seven-menu-'.gmdate('Ymd-His').'-'.bin2hex(random_bytes(3)).'.json';
$handle = fopen($backup, 'x');
if (!$handle) throw new RuntimeException('Cannot create menu backup');
fwrite($handle, json_encode($before, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
fclose($handle);
chmod($backup, 0600);
$changed = array();
$db->query('LOCK TABLES '.$table.' WRITE');
try {
    if ($digest($read()) !== $digest($before)) throw new RuntimeException('Concurrent menu edit detected');
    $stmt = $db->prepare('UPDATE '.$table.' SET me_name = ? WHERE me_id = ? AND me_name = ?');
    foreach ($remaining as $row) {
        $stmt->bind_param('sis', $row['new'], $row['id'], $row['old']);
        $stmt->execute();
        if ($stmt->affected_rows !== 1) throw new RuntimeException('Menu update was not exact');
        $changed[] = $row;
    }
    $after = $read();
    if (count($after) !== count($before)) throw new RuntimeException('Menu row count changed');
    foreach ($before as $index => $row) {
        $expectedRow = $row;
        foreach ($changed as $change) if ((int)$row['me_id'] === $change['id']) $expectedRow['me_name'] = $change['new'];
        if ($after[$index] !== $expectedRow) throw new RuntimeException('Unexpected menu field changed');
    }
} catch (Throwable $error) {
    if ($changed) {
        $undo = $db->prepare('UPDATE '.$table.' SET me_name = ? WHERE me_id = ? AND me_name = ?');
        foreach ($changed as $row) {
            $undo->bind_param('sis', $row['old'], $row['id'], $row['new']);
            $undo->execute();
        }
    }
    throw $error;
} finally { $db->query('UNLOCK TABLES'); }
echo json_encode(array('renamed' => count($changed), 'rows_preserved' => count($after), 'backup' => $backup), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
