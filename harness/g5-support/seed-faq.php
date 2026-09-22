<?php
// Opt-in, development-host-only sample FAQ. Never replaces existing questions.
if (PHP_SAPI !== 'cli' || getenv('JW_G5_FIXTURE_ALLOWED') !== '1') exit(1);
$root = '/var/www/html';
$_SERVER = array_merge($_SERVER, array('DOCUMENT_ROOT'=>$root,'SCRIPT_FILENAME'=>$root.'/jw-fixture.php','SCRIPT_NAME'=>'/jw-fixture.php','REQUEST_URI'=>'/jw-fixture.php','SERVER_NAME'=>'g5themes.test','HTTP_HOST'=>'g5themes.test','SERVER_PORT'=>'443','HTTPS'=>'on','REMOTE_ADDR'=>'127.0.0.1','SERVER_ADDR'=>'127.0.0.1','SERVER_SOFTWARE'=>'jw-g5-fixture-cli'));
chdir($root);
include $root.'/common.php';
$master=sql_fetch("select fm_id from {$g5['faq_master_table']} order by fm_order, fm_id limit 1");
if (!$master) exit("No FAQ category; no changes.\n");
$samples=array(
 '사업 제안은 어디로 보내면 되나요?'=>'<p>고객지원의 1:1 문의에서 제안 내용을 남겨 주세요. 프로젝트 목적과 희망 일정을 함께 적으면 상담에 도움이 됩니다.</p><p>이 내용은 테마 화면 확인용 예시이며 실제 운영 정책은 사이트 운영자가 설정합니다.</p>',
 '진행 중인 문의의 답변은 어떻게 확인하나요?'=>'<p>로그인 후 문의 내역에서 해당 제목을 선택하세요. 답변이 등록되면 상태가 답변 완료로 바뀝니다.</p>',
 '문의에 자료를 첨부할 수 있나요?'=>'<p>문의 작성 화면에서 파일을 최대 두 개 첨부할 수 있습니다. 파일별 허용 용량은 작성 화면에 표시됩니다.</p>',
 '기존 문의에 내용을 추가하고 싶습니다.'=>'<p>답변이 등록된 문의의 추가 질문 버튼을 이용하세요. 관련 질문은 문의 본문 아래에서 함께 확인할 수 있습니다.</p>',
 '휴대폰에서도 서비스를 이용할 수 있나요?'=>'<p>별도 앱 설치 없이 휴대폰 브라우저에서 이용하실 수 있습니다. 상단 메뉴에서 필요한 페이지를 선택하세요.</p>',
 '화면을 어둡게 변경할 수 있나요?'=>'<p>상단의 화면 모드 전환 버튼을 사용하세요. 선택한 모드는 게시판과 문의 화면에도 함께 적용됩니다.</p>'
);
$added=0;
foreach ($samples as $subject=>$body) {
 $subject=sql_escape_string($subject);$body=sql_escape_string($body);$id=(int)$master['fm_id'];
 if (sql_fetch("select fa_id from {$g5['faq_table']} where fm_id=$id and fa_subject='$subject'")) continue;
 sql_query("insert into {$g5['faq_table']} set fm_id=$id, fa_subject='$subject', fa_content='$body', fa_order=0");$added++;
}
echo json_encode(array('added'=>$added,'category'=>(int)$master['fm_id'],'editor'=>$config['cf_editor'],'qa_editor'=>get_qa_config()['qa_use_editor'],'external_notification_configured'=>(bool)(get_qa_config()['qa_admin_email'] || get_qa_config()['qa_admin_hp'])),JSON_UNESCAPED_UNICODE)."\n";
