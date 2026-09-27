<?php
/**
 * Role: Disposable G5 UI fixture installation, CLI only.
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT.
 * License: Internal development harness, not a product payload.
 */
if (PHP_SAPI !== 'cli' || !is_file('/var/www/html/.jw-ui-fixture')) exit(2);
$root = '/var/www/html';
$password = getenv('JW_UI_DB_PASSWORD');
if (!$password) exit(3);
$_SERVER = array_merge($_SERVER, array(
    'DOCUMENT_ROOT'=>$root, 'SCRIPT_FILENAME'=>$root.'/install/install_db.php',
    'SCRIPT_NAME'=>'/install/install_db.php', 'REQUEST_URI'=>'/install/install_db.php',
    'SERVER_NAME'=>'web', 'HTTP_HOST'=>'web:8080', 'SERVER_PORT'=>'8080',
    'REMOTE_ADDR'=>'127.0.0.1', 'REQUEST_METHOD'=>'POST', 'SERVER_SOFTWARE'=>'jw-ui-fixture'
));
if (!is_file($root.'/data/dbconfig.php')) {
    @mkdir($root.'/data', 0777, true);
    chmod($root.'/data', 0777);
    $_POST = array('mysql_host'=>'db', 'mysql_user'=>'root', 'mysql_pass'=>$password,
        'mysql_db'=>'g5_ui', 'table_prefix'=>'g5_', 'admin_id'=>'ui_admin',
        'admin_pass'=>substr(hash('sha256', $password),0,18), 'admin_name'=>'시연 관리자',
        'admin_email'=>'fixture@example.test', 'g5_install'=>1, 'g5_shop_install'=>0,
        'agree'=>1, 'license'=>1);
    chdir($root.'/install');
    ob_start();
    require './install_db.php';
    ob_end_clean();
}
if (!is_file($root.'/data/dbconfig.php')) throw new RuntimeException('Official installation did not complete');
$db = new mysqli('db','root',$password,'g5_ui');
$db->set_charset('utf8mb4');
$db->query("UPDATE g5_config SET cf_theme='jw_business', cf_title='JW-Business', cf_visit='', cf_analytics='', cf_add_meta=''");
$contract = json_decode(file_get_contents('/harness/routes.json'), true);
$db->query('DELETE FROM g5_menu');
$order=1;
$insert=$db->prepare("INSERT INTO g5_menu (me_code,me_name,me_link,me_target,me_order,me_use,me_mobile_use) VALUES (?,?,?,'self',?,1,1)");
foreach ($contract as $item) {
    $code=$item['code'];$name=$item['name'];$route=$item['route'];$sort=$order++;
    $insert->bind_param('sssi',$code,$name,$route,$sort);$insert->execute();
}
echo "Disposable G5 UI fixture ready\n";
