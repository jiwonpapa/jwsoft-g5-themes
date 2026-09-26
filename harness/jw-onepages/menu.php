<?php
/** JW SOFT — CLI-only, additive development menu deployment. Never web-deploy. */
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
if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) throw new RuntimeException('Invalid table');
$config = $db->query('SELECT cf_theme FROM '.$g5['config_table'])->fetch_assoc();
if (($config['cf_theme'] ?? '') !== 'jw_business') throw new RuntimeException('Wrong active theme');
$read = static function () use ($db, $table) {
    return $db->query('SELECT * FROM '.$table.' ORDER BY me_id')->fetch_all(MYSQLI_ASSOC);
};
$hash = static function ($rows) { return hash('sha256', json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)); };
$before = $read();
$parent = array_values(array_filter($before, static function ($row) { return $row['me_name'] === '메인' && strlen($row['me_code']) === 2 && $row['me_link'] === 'https://g5themes.test'; }));
if (count($parent) !== 1) throw new RuntimeException('Expected one existing main menu');
$parentCode = $parent[0]['me_code'];
$wanted = array('showcase' => '원페이지 · 제품 쇼케이스', 'services' => '원페이지 · 서비스 상담', 'projects' => '원페이지 · 공간 프로젝트');
$expected = array();
$order = -1;
$suffix = 0;
foreach ($before as $row) {
    if (strlen($row['me_code']) === 4 && substr($row['me_code'], 0, 2) === $parentCode) {
        $suffix = max($suffix, (int) substr($row['me_code'], 2));
        $order = max($order, (int) $row['me_order']);
    }
}
$found = array();
foreach ($wanted as $slug => $name) {
    $url = 'https://g5themes.test/pages/onepage-'.$slug.'.php';
    $matches = array_values(array_filter($before, static function ($row) use ($url) { return $row['me_link'] === $url; }));
    if (count($matches) > 1) throw new RuntimeException('Duplicate existing onepage menu');
    if ($matches) {
        $row = $matches[0];
        if (substr($row['me_code'], 0, 2) !== $parentCode || $row['me_name'] !== $name || $row['me_target'] !== 'self' || (int)$row['me_use'] !== 1 || (int)$row['me_mobile_use'] !== 1) throw new RuntimeException('Existing menu differs; preserve administrator change');
        $found[] = $row['me_id'];
    } else {
        if (++$suffix > 99) throw new RuntimeException('No child menu slots');
        $expected[] = array('code'=>$parentCode.sprintf('%02d', $suffix), 'name'=>$name, 'url'=>$url, 'order'=>++$order);
    }
}
if ($mode === 'inspect') {
    echo json_encode(array('count'=>count($before), 'snapshot'=>$hash($before), 'existing'=>count($found), 'append'=>$expected), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL;
    exit;
}
if ($mode === 'verify') {
    if ($expected) throw new RuntimeException('Onepage menus missing');
    echo 'PASS: all 3 onepage menus visible for PC and mobile under main; total '.count($before).PHP_EOL;
    exit;
}
if (getenv('JW_ONEPAGE_MENU_APPLY') !== '1') throw new RuntimeException('Explicit apply flag required');
if (!$expected) { echo 'NOOP: already installed; no rows changed.'.PHP_EOL; exit; }
if ($found) throw new RuntimeException('Partial prior install; inspect before retry');
if (!hash_equals(getenv('JW_ONEPAGE_MENU_EXPECTED_HASH') ?: '', $hash($before))) throw new RuntimeException('Menu changed since inspection');
foreach ($wanted as $slug => $name) {
    if (!is_file($root.'/pages/onepage-'.$slug.'.php')) throw new RuntimeException('Deploy pages before menus');
}
$backup = '/tmp/jw-onepage-menu-before-'.gmdate('Ymd-His').'-'.bin2hex(random_bytes(3)).'.json';
$handle = fopen($backup, 'x');
if (!$handle) throw new RuntimeException('Cannot create menu backup');
fwrite($handle, json_encode($before, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
fclose($handle);
chmod($backup, 0600);
$inserted = array();
// MyISAM is possible in G5. A brief table lock also protects additive verification.
$db->query('LOCK TABLES '.$table.' WRITE');
try {
    if ($hash($read()) !== $hash($before)) throw new RuntimeException('Concurrent menu edit detected');
    $stmt = $db->prepare('INSERT INTO '.$table.' (me_code, me_name, me_link, me_target, me_order, me_use, me_mobile_use) VALUES (?, ?, ?, \'self\', ?, 1, 1)');
    foreach ($expected as $row) {
        $stmt->bind_param('sssi', $row['code'], $row['name'], $row['url'], $row['order']);
        $stmt->execute();
        $inserted[] = (string)$db->insert_id;
    }
    $after = $read();
    $preserved = array_values(array_filter($after, static function ($row) use ($inserted) { return !in_array((string)$row['me_id'], $inserted, true); }));
    if ($hash($preserved) !== $hash($before) || count($after) !== count($before) + 3) throw new RuntimeException('Post-write preservation check failed');
} catch (Throwable $error) {
    // Only revert IDs inserted by this attempt; never replace pre-existing menu rows.
    if ($inserted) $db->query('DELETE FROM '.$table.' WHERE me_id IN ('.implode(',', array_map('intval', $inserted)).')');
    throw $error;
} finally { $db->query('UNLOCK TABLES'); }
echo json_encode(array('added_ids'=>$inserted, 'before_count'=>count($before), 'after_count'=>count($after), 'existing_rows_unchanged'=>true, 'backup'=>$backup), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL;
