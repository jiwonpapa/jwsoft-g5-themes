<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

const JW_FIXTURE_STATE_DIR = 'jwsoft-fixtures';
const JW_FIXTURE_STATE_FILE = 'jw-business-v1.json';

function fixture_fail(string $message, int $code = 1): void
{
    fwrite(STDERR, "fixture error: {$message}\n");
    exit($code);
}

function fixture_read_json(string $path): array
{
    $raw = @file_get_contents($path);
    if ($raw === false) fixture_fail("cannot read {$path}");

    try {
        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
    } catch (Throwable $error) {
        fixture_fail("invalid JSON in {$path}: {$error->getMessage()}");
    }

    if (!is_array($data)) fixture_fail("JSON root must be an object: {$path}");
    return $data;
}

function fixture_validate_manifest(array $manifest, string $profile): array
{
    $pagination = $manifest['pagination'] ?? array();
    $rows = (int)($pagination['rowsPerPage'] ?? 0);
    $links = (int)($pagination['linksPerBlock'] ?? 0);
    $requiredPages = (int)($pagination['requiredPages'] ?? 0);
    $posts = (int)($pagination['postsPerBoard'] ?? 0);

    if ($rows < 1 || $links < 1 || $requiredPages < 1 || $posts < 1) {
        fixture_fail('pagination values must be positive integers');
    }
    if ((int)ceil($posts / $rows) < $requiredPages) {
        fixture_fail('postsPerBoard does not reach requiredPages');
    }
    if (!isset($manifest['profiles'][$profile]) || !is_array($manifest['profiles'][$profile])) {
        fixture_fail("unknown profile: {$profile}");
    }

    $expectedConfigSkins = array(
        'cf_member_skin', 'cf_mobile_member_skin', 'cf_new_skin', 'cf_mobile_new_skin',
        'cf_search_skin', 'cf_mobile_search_skin', 'cf_connect_skin', 'cf_mobile_connect_skin',
        'cf_faq_skin', 'cf_mobile_faq_skin'
    );
    $expectedQaSkins = array('qa_skin', 'qa_mobile_skin');
    $expectedContentSkins = array('co_skin', 'co_mobile_skin');
    $configSkins = $manifest['skinSettings']['config'] ?? array();
    $qaSkins = $manifest['skinSettings']['qa'] ?? array();
    $contentSkins = $manifest['skinSettings']['content'] ?? array();
    if (array_keys($configSkins) !== $expectedConfigSkins
        || array_keys($qaSkins) !== $expectedQaSkins
        || array_keys($contentSkins) !== $expectedContentSkins) {
        fixture_fail('skinSettings must cover every G5 public PC/mobile skin setting');
    }
    foreach (array_merge($configSkins, $qaSkins, $contentSkins) as $field => $skin) {
        if (!preg_match('#^theme/[a-z0-9_-]+$#', (string)$skin)) {
            fixture_fail("invalid theme skin setting: {$field}");
        }
    }

    $boardMap = array();
    foreach (($manifest['boards'] ?? array()) as $board) {
        $id = (string)($board['id'] ?? '');
        if (!preg_match('/^[a-z0-9_]{1,20}$/', $id)) fixture_fail("invalid board id: {$id}");
        if (isset($boardMap[$id])) fixture_fail("duplicate board id: {$id}");
        if (!preg_match('#^theme/[a-z0-9_-]+$#', (string)($board['skin'] ?? ''))) {
            fixture_fail("invalid theme skin for {$id}");
        }
        $boardMap[$id] = $board;
    }

    $selected = array();
    foreach ($manifest['profiles'][$profile] as $id) {
        if (!isset($boardMap[$id])) fixture_fail("profile {$profile} references missing board {$id}");
        $selected[] = $boardMap[$id];
    }
    return $selected;
}

function fixture_prepare_g5(string $root): string
{
    $common = $root.'/common.php';
    if (!is_file($common)) fixture_fail("G5 common.php not found under {$root}");

    $_SERVER['DOCUMENT_ROOT'] = $root;
    $_SERVER['SCRIPT_FILENAME'] = $root.'/jw-fixture.php';
    $_SERVER['SCRIPT_NAME'] = '/jw-fixture.php';
    $_SERVER['REQUEST_URI'] = '/jw-fixture.php';
    $_SERVER['SERVER_NAME'] = 'g5themes.test';
    $_SERVER['HTTP_HOST'] = 'g5themes.test';
    $_SERVER['SERVER_PORT'] = '443';
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    $_SERVER['SERVER_ADDR'] = '127.0.0.1';
    $_SERVER['SERVER_SOFTWARE'] = 'jw-g5-fixture-cli';

    chdir($root);
    return $common;
}

function fixture_quote($value): string
{
    if ($value === null) return 'NULL';
    return "'".sql_escape_string((string)$value)."'";
}

function fixture_insert(string $table, array $row): void
{
    $columns = array();
    $values = array();
    foreach ($row as $column => $value) {
        if (!preg_match('/^[a-z0-9_]+$/i', (string)$column)) fixture_fail("unsafe column: {$column}");
        $columns[] = '`'.$column.'`';
        $values[] = fixture_quote($value);
    }
    sql_query("insert into `{$table}` (".implode(',', $columns).') values ('.implode(',', $values).')', true);
}

function fixture_update(string $table, array $fields, string $where): void
{
    $sets = array();
    foreach ($fields as $column => $value) {
        if (!preg_match('/^[a-z0-9_]+$/i', (string)$column)) fixture_fail("unsafe column: {$column}");
        $sets[] = '`'.$column.'` = '.fixture_quote($value);
    }
    sql_query("update `{$table}` set ".implode(',', $sets)." where {$where}", true);
}

function fixture_state_path(): string
{
    return G5_DATA_PATH.'/'.JW_FIXTURE_STATE_DIR.'/'.JW_FIXTURE_STATE_FILE;
}

function fixture_write_state(array $state): void
{
    $path = fixture_state_path();
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, G5_DIR_PERMISSION, true) && !is_dir($dir)) {
        fixture_fail("cannot create state directory: {$dir}");
    }
    $json = json_encode($state, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)."\n";
    if (file_put_contents($path, $json, LOCK_EX) === false) fixture_fail("cannot write fixture state: {$path}");
    @chmod($path, G5_FILE_PERMISSION);
}

function fixture_read_state(): ?array
{
    $path = fixture_state_path();
    return is_file($path) ? fixture_read_json($path) : null;
}

function fixture_board_config_fields(): array
{
    return array(
        'bo_subject', 'bo_mobile_subject', 'bo_skin', 'bo_mobile_skin', 'bo_page_rows',
        'bo_mobile_page_rows', 'bo_category_list', 'bo_use_category', 'bo_use_search',
        'bo_include_head', 'bo_include_tail', 'bo_notice', 'bo_upload_count', 'bo_use_good',
        'bo_use_nogood', 'bo_count_write', 'bo_count_comment'
    );
}

function fixture_config_fields(array $manifest): array
{
    return array_merge(array_keys($manifest['skinSettings']['config']), array('cf_write_pages', 'cf_mobile_pages'));
}

function fixture_singleton_fields(string $table, array $fields): array
{
    $safe = array();
    foreach ($fields as $field) {
        if (!preg_match('/^[a-z0-9_]+$/i', (string)$field)) fixture_fail("unsafe column: {$field}");
        $safe[] = '`'.$field.'`';
    }
    $row = sql_fetch('select '.implode(',', $safe)." from `{$table}` limit 1", false);
    if (!$row) fixture_fail("cannot read settings from {$table}");
    return array_intersect_key($row, array_flip($fields));
}

function fixture_content_skin_state(array $manifest): array
{
    global $g5;
    $fields = array_keys($manifest['skinSettings']['content']);
    $result = sql_query("select `co_id`, `".implode('`,`', $fields)."` from `{$g5['content_table']}` order by `co_id`", false);
    $state = array();
    if ($result) {
        while ($row = sql_fetch_array($result)) {
            $state[$row['co_id']] = array_intersect_key($row, array_flip($fields));
        }
    }
    return $state;
}

function fixture_apply_site_settings(array $manifest): void
{
    global $g5, $config;
    $links = (int)$manifest['pagination']['linksPerBlock'];
    $configFields = $manifest['skinSettings']['config'];
    $configFields['cf_write_pages'] = $links;
    $configFields['cf_mobile_pages'] = $links;
    fixture_update($g5['config_table'], $configFields, '1 = 1');
    fixture_update($g5['qa_config_table'], $manifest['skinSettings']['qa'], '1 = 1');
    fixture_update($g5['content_table'], $manifest['skinSettings']['content'], '1 = 1');
    foreach ($configFields as $field => $value) $config[$field] = $value;
}

function fixture_skin_directories(array $manifest): array
{
    $directories = array();
    $types = array(
        'cf_member_skin' => 'member', 'cf_mobile_member_skin' => 'member',
        'cf_new_skin' => 'new', 'cf_mobile_new_skin' => 'new',
        'cf_search_skin' => 'search', 'cf_mobile_search_skin' => 'search',
        'cf_connect_skin' => 'connect', 'cf_mobile_connect_skin' => 'connect',
        'cf_faq_skin' => 'faq', 'cf_mobile_faq_skin' => 'faq',
        'qa_skin' => 'qa', 'qa_mobile_skin' => 'qa',
        'co_skin' => 'content', 'co_mobile_skin' => 'content',
    );
    foreach (array_merge($manifest['skinSettings']['config'], $manifest['skinSettings']['qa'], $manifest['skinSettings']['content']) as $field => $skin) {
        $name = substr($skin, strlen('theme/'));
        $mobile = str_contains($field, 'mobile');
        $root = $mobile ? G5_THEME_MOBILE_PATH : G5_THEME_PATH;
        $directories[$field] = $root.'/'.G5_SKIN_DIR.'/'.$types[$field].'/'.$name;
    }
    return $directories;
}

function fixture_board_row(string $boardId): ?array
{
    global $g5;
    $id = sql_escape_string($boardId);
    $row = sql_fetch("select * from `{$g5['board_table']}` where bo_table = '{$id}'", false);
    return isset($row['bo_table']) ? $row : null;
}

function fixture_create_board(array $definition): void
{
    global $g5;
    $templateId = (string)$definition['template'];
    $template = fixture_board_row($templateId) ?: fixture_board_row('free');
    if (!$template) fixture_fail("cannot create {$definition['id']}: template board is missing");

    $new = $template;
    $new['bo_table'] = $definition['id'];
    $new['bo_subject'] = $definition['subject'];
    $new['bo_mobile_subject'] = $definition['subject'];
    $new['bo_count_write'] = 0;
    $new['bo_count_comment'] = 0;
    $new['bo_notice'] = '';
    $new['bo_1'] = 'jw-business-fixture-board';
    fixture_insert($g5['board_table'], $new);

    $sourceTable = $g5['write_prefix'].$templateId;
    $targetTable = $g5['write_prefix'].$definition['id'];
    sql_query("create table `{$targetTable}` like `{$sourceTable}`", true);

    $boardDir = G5_DATA_PATH.'/file/'.$definition['id'];
    if (!is_dir($boardDir) && !mkdir($boardDir, G5_DIR_PERMISSION, true) && !is_dir($boardDir)) {
        fixture_fail("cannot create board data directory: {$boardDir}");
    }
    @file_put_contents($boardDir.'/index.php', '');
}

function fixture_marker_ids(string $boardId, string $marker): array
{
    global $g5;
    $table = $g5['write_prefix'].$boardId;
    $result = sql_query("select wr_id from `{$table}` where wr_10 = ".fixture_quote($marker), false);
    $ids = array();
    if ($result) {
        while ($row = sql_fetch_array($result)) $ids[] = (int)$row['wr_id'];
    }
    return $ids;
}

function fixture_delete_ids(string $table, string $column, array $ids, string $extra = ''): void
{
    foreach (array_chunk($ids, 500) as $chunk) {
        $numbers = implode(',', array_map('intval', $chunk));
        sql_query("delete from `{$table}` where `{$column}` in ({$numbers}) {$extra}", true);
    }
}

function fixture_refresh_board_counts(string $boardId): void
{
    global $g5;
    $writeTable = $g5['write_prefix'].$boardId;
    $write = sql_fetch("select count(*) as cnt from `{$writeTable}` where wr_is_comment = 0");
    $comment = sql_fetch("select count(*) as cnt from `{$writeTable}` where wr_is_comment = 1");
    fixture_update($g5['board_table'], array(
        'bo_count_write' => (int)$write['cnt'],
        'bo_count_comment' => (int)$comment['cnt'],
    ), 'bo_table = '.fixture_quote($boardId));
    delete_cache_latest($boardId);
}

function fixture_remove_board_rows(string $boardId, string $marker): void
{
    global $g5;
    if (!fixture_board_row($boardId)) return;

    $ids = fixture_marker_ids($boardId, $marker);
    if (!$ids) return;

    $fileRows = sql_query("select bf_file from `{$g5['board_file_table']}` where bo_table = ".fixture_quote($boardId));
    while ($file = sql_fetch_array($fileRows)) {
        if (str_starts_with((string)$file['bf_file'], 'jwfixture-')) {
            @unlink(G5_DATA_PATH.'/file/'.$boardId.'/'.$file['bf_file']);
        }
    }
    fixture_delete_ids($g5['board_file_table'], 'wr_id', $ids, 'and bo_table = '.fixture_quote($boardId));
    fixture_delete_ids($g5['board_new_table'], 'wr_id', $ids, 'and bo_table = '.fixture_quote($boardId));
    fixture_delete_ids($g5['write_prefix'].$boardId, 'wr_id', $ids);

    foreach ((array)glob(G5_DATA_PATH.'/file/'.$boardId.'/thumb-jwfixture-*') as $thumb) @unlink($thumb);
    fixture_refresh_board_counts($boardId);
}

function fixture_reset(?array $state): void
{
    global $g5;
    if (!$state) return;
    $marker = (string)($state['marker'] ?? '');
    if ($marker === '') fixture_fail('fixture state has no marker');

    foreach (($state['boards'] ?? array()) as $boardId) {
        if (fixture_board_row($boardId)) fixture_remove_board_rows($boardId, $marker);
    }

    foreach (($state['originalBoards'] ?? array()) as $boardId => $fields) {
        if (fixture_board_row($boardId)) {
            fixture_update($g5['board_table'], $fields, 'bo_table = '.fixture_quote($boardId));
            fixture_refresh_board_counts($boardId);
        }
    }

    foreach (($state['createdBoards'] ?? array()) as $boardId) {
        if (!preg_match('/^[a-z0-9_]{1,20}$/', $boardId)) continue;
        sql_query("drop table if exists `{$g5['write_prefix']}{$boardId}`", true);
        sql_query("delete from `{$g5['board_table']}` where bo_table = ".fixture_quote($boardId), true);
        @rmdir(G5_DATA_PATH.'/file/'.$boardId);
    }

    if (!empty($state['originalConfig'])) {
        fixture_update($g5['config_table'], $state['originalConfig'], '1 = 1');
    }
    if (!empty($state['originalQaConfig'])) {
        fixture_update($g5['qa_config_table'], $state['originalQaConfig'], '1 = 1');
    }
    foreach (($state['originalContentSkins'] ?? array()) as $contentId => $fields) {
        fixture_update($g5['content_table'], $fields, 'co_id = '.fixture_quote($contentId));
    }

    @unlink(fixture_state_path());
}

function fixture_preflight(array $boards, array $manifest): void
{
    global $config;
    if (($config['cf_theme'] ?? '') !== 'jw_business') {
        fixture_fail('active theme must be jw_business');
    }
    foreach ($boards as $board) {
        $skin = substr($board['skin'], strlen('theme/'));
        $pc = G5_THEME_PATH.'/skin/board/'.$skin;
        $mobile = G5_THEME_MOBILE_PATH.'/skin/board/'.$skin;
        if (!is_dir($pc)) fixture_fail("required PC board skin is missing: {$pc}");
        if (!is_dir($mobile)) fixture_fail("required mobile board skin is missing: {$mobile}");
    }
    foreach (fixture_skin_directories($manifest) as $field => $directory) {
        if (!is_dir($directory)) fixture_fail("required {$field} theme skin is missing: {$directory}");
    }
    if (array_sum(array_column($boards, 'imagePosts')) > 0 && !function_exists('imagecreatetruecolor')) {
        fixture_fail('GD is required for visual fixture images');
    }
}

function fixture_make_images(string $boardId, int $count, string $marker): array
{
    if ($count < 1) return array();
    $dir = G5_DATA_PATH.'/file/'.$boardId;
    if (!is_dir($dir) && !mkdir($dir, G5_DIR_PERMISSION, true) && !is_dir($dir)) {
        fixture_fail("cannot create {$dir}");
    }
    $files = array();
    $palette = array(
        array(34, 73, 112), array(18, 105, 108), array(91, 67, 122), array(122, 81, 45),
        array(42, 91, 65), array(116, 55, 68), array(67, 82, 112), array(77, 77, 77),
        array(38, 96, 128), array(109, 88, 43), array(50, 104, 91), array(92, 59, 104)
    );
    $safeMarker = preg_replace('/[^a-z0-9-]/', '-', strtolower($marker));
    for ($i = 1; $i <= min($count, 12); $i++) {
        $name = sprintf('jwfixture-%s-%02d.jpg', $safeMarker, $i);
        $path = $dir.'/'.$name;
        $image = imagecreatetruecolor(1200, 800);
        $base = $palette[($i - 1) % count($palette)];
        $background = imagecolorallocate($image, $base[0], $base[1], $base[2]);
        $light = imagecolorallocate($image, min(255, $base[0] + 55), min(255, $base[1] + 55), min(255, $base[2] + 55));
        $white = imagecolorallocate($image, 245, 247, 250);
        imagefilledrectangle($image, 0, 0, 1200, 800, $background);
        imagefilledpolygon($image, array(0, 800, 1200, 180, 1200, 800), 3, $light);
        imagestring($image, 5, 60, 60, strtoupper($boardId).' / '.str_pad((string)$i, 2, '0', STR_PAD_LEFT), $white);
        imagejpeg($image, $path, 88);
        imagedestroy($image);
        @chmod($path, G5_FILE_PERMISSION);
        $files[] = $name;
    }
    return $files;
}

function fixture_content(string $boardId, int $index): array
{
    $copy = array(
        'notice' => array('서비스 운영 안내', '정기 점검 일정', '제품 업데이트 안내', '고객지원 운영시간 변경'),
        'free' => array('프로젝트 진행 사례를 공유합니다', '도입 전에 확인할 사항이 궁금합니다', '현장에서 활용한 개선 방법', '협업 과정에서 정리한 질문'),
        'gallery' => array('산업 공간 구축 현장', '제품 디자인 적용 사례', '프로젝트 완료 기록', '협업 워크숍 현장'),
        'qa' => array('서비스 도입 절차 문의', '자료 요청과 사용 범위 질문', '기존 시스템 연동 문의', '유지관리 범위가 궁금합니다'),
        'portfolio' => array('통합 업무환경 구축 프로젝트', '고객 경험 개선 프로젝트', '생산 공정 시각화 사례', '브랜드 공간 설계 사례'),
        'news' => array('신규 사업 협력 소식', '프로젝트 수주 소식', '기술 세미나 개최 안내', '기업 활동 주요 소식'),
        'resources' => array('서비스 소개 자료', '기술 사양서', '프로젝트 체크리스트', '운영 가이드 다운로드'),
        'video' => array('기업 소개 영상', '프로젝트 현장 영상', '전문가 인터뷰', '제품 활용 영상'),
    );
    $subjects = $copy[$boardId] ?? $copy['free'];
    $subject = $subjects[($index - 1) % count($subjects)].' '.str_pad((string)$index, 3, '0', STR_PAD_LEFT);
    $content = '<p>JW-Business 테마의 실제 게시판 화면과 반응형 동작을 검증하기 위한 고정 fixture입니다.</p>'
        .'<p>목록 밀도, 긴 제목, 본문 간격, 댓글, 검색과 페이지 이동을 같은 데이터로 반복 확인합니다.</p>';
    return array($subject, $content);
}

function fixture_insert_board_file(string $boardId, int $wrId, string $file, int $index): void
{
    global $g5;
    $path = G5_DATA_PATH.'/file/'.$boardId.'/'.$file;
    $size = @getimagesize($path);
    fixture_insert($g5['board_file_table'], array(
        'bo_table' => $boardId,
        'wr_id' => $wrId,
        'bf_no' => 0,
        'bf_source' => sprintf('%s-project-%02d.jpg', $boardId, $index),
        'bf_file' => $file,
        'bf_download' => 0,
        'bf_content' => 'JW-Business 시각 회귀용 생성 이미지',
        'bf_fileurl' => '',
        'bf_thumburl' => '',
        'bf_storage' => '',
        'bf_filesize' => (int)@filesize($path),
        'bf_width' => (int)($size[0] ?? 1200),
        'bf_height' => (int)($size[1] ?? 800),
        'bf_type' => (int)($size[2] ?? IMAGETYPE_JPEG),
        'bf_datetime' => G5_TIME_YMDHIS,
    ));
}

function fixture_seed_board(array $definition, array $manifest): array
{
    global $g5, $config;
    $boardId = $definition['id'];
    $marker = $manifest['marker'];
    $pagination = $manifest['pagination'];
    $postCount = (int)$pagination['postsPerBoard'];
    $writeTable = $g5['write_prefix'].$boardId;
    $categories = $definition['categories'];
    $images = fixture_make_images($boardId, (int)$definition['imagePosts'], $marker);
    $admin = get_member($config['cf_admin']);
    $anchor = new DateTimeImmutable($manifest['anchorDatetime'], new DateTimeZone('Asia/Seoul'));
    $minimum = sql_fetch("select min(wr_num) as min_num from `{$writeTable}`");
    $baseNum = min(0, (int)($minimum['min_num'] ?? 0));
    $noticeIds = array();
    $commentCount = 0;

    for ($index = 1; $index <= $postCount; $index++) {
        [$subject, $content] = fixture_content($boardId, $index);
        $datetime = $anchor->modify('-'.(($index - 1) * 6).' hours')->format('Y-m-d H:i:s');
        $wrNum = $baseNum - $postCount + $index - 1;
        $isGuest = ($index % 17) === 0;
        $hasImage = $index <= (int)$definition['imagePosts'] && count($images) > 0;
        $option = ($index % 53) === 0 ? 'html2,secret' : 'html2';

        fixture_insert($writeTable, array(
            'wr_num' => $wrNum,
            'wr_reply' => '',
            'wr_parent' => 0,
            'wr_is_comment' => 0,
            'wr_comment' => 0,
            'wr_comment_reply' => '',
            'ca_name' => $categories[($index - 1) % count($categories)],
            'wr_option' => $option,
            'wr_subject' => $subject,
            'wr_content' => $content,
            'wr_seo_title' => generate_seo_title($subject),
            'wr_link1' => $boardId === 'video' ? 'https://example.com/video/'.$index : '',
            'wr_link2' => '',
            'wr_link1_hit' => 0,
            'wr_link2_hit' => 0,
            'wr_hit' => 20 + (($postCount - $index) % 180),
            'wr_good' => $index % 13,
            'wr_nogood' => 0,
            'mb_id' => $isGuest ? '' : $admin['mb_id'],
            'wr_password' => $isGuest ? get_encrypt_string('jw-fixture') : $admin['mb_password'],
            'wr_name' => $isGuest ? '방문자'.(($index % 9) + 1) : $admin['mb_nick'],
            'wr_email' => $isGuest ? '' : $admin['mb_email'],
            'wr_homepage' => '',
            'wr_datetime' => $datetime,
            'wr_file' => $hasImage ? 1 : 0,
            'wr_last' => $datetime,
            'wr_ip' => '127.0.0.1',
            'wr_facebook_user' => '',
            'wr_twitter_user' => '',
            'wr_1' => 'fixture',
            'wr_2' => '', 'wr_3' => '', 'wr_4' => '', 'wr_5' => '',
            'wr_6' => '', 'wr_7' => '', 'wr_8' => '', 'wr_9' => '',
            'wr_10' => $marker,
        ));
        $wrId = sql_insert_id();
        fixture_update($writeTable, array('wr_parent' => $wrId), 'wr_id = '.(int)$wrId);

        if ($hasImage) {
            $file = $images[($index - 1) % count($images)];
            fixture_insert_board_file($boardId, $wrId, $file, $index);
        }
        if ($index <= (int)$definition['noticePosts']) $noticeIds[] = $wrId;

        fixture_insert($g5['board_new_table'], array(
            'bo_table' => $boardId,
            'wr_id' => $wrId,
            'wr_parent' => $wrId,
            'bn_datetime' => $datetime,
            'mb_id' => $isGuest ? '' : $admin['mb_id'],
        ));

        if ($index <= (int)$definition['commentsOnPosts']) {
            $comments = array(
                array(1, '', '내용을 확인했습니다. 자세한 안내 감사합니다.'),
                array(1, 'A', '추가 질문도 확인해 답변드리겠습니다.'),
                array(2, '', '관련 자료도 함께 살펴보겠습니다.'),
            );
            foreach ($comments as $offset => [$commentNo, $reply, $commentText]) {
                $commentDatetime = (new DateTimeImmutable($datetime, new DateTimeZone('Asia/Seoul')))
                    ->modify('+'.($offset + 1).' minutes')->format('Y-m-d H:i:s');
                fixture_insert($writeTable, array(
                    'wr_num' => $wrNum, 'wr_reply' => '', 'wr_parent' => $wrId,
                    'wr_is_comment' => 1, 'wr_comment' => $commentNo, 'wr_comment_reply' => $reply,
                    'ca_name' => '', 'wr_option' => '', 'wr_subject' => '', 'wr_content' => $commentText,
                    'wr_seo_title' => '', 'wr_link1' => '', 'wr_link2' => '', 'wr_link1_hit' => 0,
                    'wr_link2_hit' => 0, 'wr_hit' => 0, 'wr_good' => 0, 'wr_nogood' => 0,
                    'mb_id' => $admin['mb_id'], 'wr_password' => $admin['mb_password'],
                    'wr_name' => $admin['mb_nick'], 'wr_email' => $admin['mb_email'], 'wr_homepage' => '',
                    'wr_datetime' => $commentDatetime, 'wr_file' => 0, 'wr_last' => $commentDatetime,
                    'wr_ip' => '127.0.0.1', 'wr_facebook_user' => '', 'wr_twitter_user' => '',
                    'wr_1' => 'fixture-comment', 'wr_2' => '', 'wr_3' => '', 'wr_4' => '', 'wr_5' => '',
                    'wr_6' => '', 'wr_7' => '', 'wr_8' => '', 'wr_9' => '', 'wr_10' => $marker,
                ));
                $commentId = sql_insert_id();
                fixture_insert($g5['board_new_table'], array(
                    'bo_table' => $boardId, 'wr_id' => $commentId, 'wr_parent' => $wrId,
                    'bn_datetime' => $commentDatetime, 'mb_id' => $admin['mb_id'],
                ));
                $commentCount++;
            }
            fixture_update($writeTable, array('wr_comment' => 3, 'wr_last' => $commentDatetime), 'wr_id = '.(int)$wrId);
        }
    }

    fixture_update($g5['board_table'], array('bo_notice' => implode(',', $noticeIds)), 'bo_table = '.fixture_quote($boardId));
    fixture_refresh_board_counts($boardId);
    return array('posts' => $postCount, 'comments' => $commentCount, 'images' => count($images));
}

function fixture_configure_board(array $definition, array $manifest): void
{
    global $g5;
    $pagination = $manifest['pagination'];
    fixture_update($g5['board_table'], array(
        'bo_subject' => $definition['subject'],
        'bo_mobile_subject' => $definition['subject'],
        'bo_skin' => $definition['skin'],
        'bo_mobile_skin' => $definition['skin'],
        'bo_page_rows' => (int)$pagination['rowsPerPage'],
        'bo_mobile_page_rows' => (int)$pagination['rowsPerPage'],
        'bo_category_list' => implode('|', $definition['categories']),
        'bo_use_category' => 1,
        'bo_use_search' => 1,
        'bo_include_head' => '_head.php',
        'bo_include_tail' => '_tail.php',
        'bo_upload_count' => 2,
        'bo_use_good' => 1,
        'bo_use_nogood' => 1,
    ), 'bo_table = '.fixture_quote($definition['id']));
}

function fixture_verify(array $boards, array $manifest): array
{
    global $g5, $config;
    $rows = (int)$manifest['pagination']['rowsPerPage'];
    $requiredPages = (int)$manifest['pagination']['requiredPages'];
    $expectedPosts = (int)$manifest['pagination']['postsPerBoard'];
    $marker = $manifest['marker'];
    $result = array();
    foreach ($boards as $definition) {
        $board = fixture_board_row($definition['id']);
        if (!$board) fixture_fail("verify: missing board {$definition['id']}");
        $ids = fixture_marker_ids($definition['id'], $marker);
        $writeTable = $g5['write_prefix'].$definition['id'];
        $post = sql_fetch("select count(*) as cnt from `{$writeTable}` where wr_is_comment = 0 and wr_10 = ".fixture_quote($marker));
        $comments = sql_fetch("select count(*) as cnt from `{$writeTable}` where wr_is_comment = 1 and wr_10 = ".fixture_quote($marker));
        $pages = (int)ceil(((int)$post['cnt']) / $rows);
        if ((int)$post['cnt'] !== $expectedPosts) fixture_fail("verify: {$definition['id']} post count mismatch");
        if ($pages < $requiredPages) fixture_fail("verify: {$definition['id']} has only {$pages} pages");
        if ($board['bo_skin'] !== $definition['skin'] || $board['bo_mobile_skin'] !== $definition['skin']) {
            fixture_fail("verify: {$definition['id']} theme skin mismatch");
        }
        if ((int)$board['bo_page_rows'] !== $rows || (int)$board['bo_mobile_page_rows'] !== $rows) {
            fixture_fail("verify: {$definition['id']} rows per page mismatch");
        }
        $result[$definition['id']] = array(
            'skin' => $board['bo_skin'], 'posts' => (int)$post['cnt'],
            'comments' => (int)$comments['cnt'], 'pages' => $pages, 'markerRows' => count($ids),
        );
    }
    $actualConfig = fixture_singleton_fields($g5['config_table'], fixture_config_fields($manifest));
    $actualQa = fixture_singleton_fields($g5['qa_config_table'], array_keys($manifest['skinSettings']['qa']));
    foreach ($manifest['skinSettings']['config'] as $field => $expected) {
        if (($actualConfig[$field] ?? null) !== $expected) fixture_fail("verify: {$field} is not {$expected}");
    }
    foreach ($manifest['skinSettings']['qa'] as $field => $expected) {
        if (($actualQa[$field] ?? null) !== $expected) fixture_fail("verify: {$field} is not {$expected}");
    }
    $contentState = fixture_content_skin_state($manifest);
    foreach ($contentState as $contentId => $fields) {
        foreach ($manifest['skinSettings']['content'] as $field => $expected) {
            if (($fields[$field] ?? null) !== $expected) fixture_fail("verify: content {$contentId} {$field} is not {$expected}");
        }
    }
    $links = (int)$manifest['pagination']['linksPerBlock'];
    if ((int)$actualConfig['cf_write_pages'] !== $links || (int)$actualConfig['cf_mobile_pages'] !== $links) {
        fixture_fail('verify: PC/mobile paging block settings differ from linksPerBlock');
    }
    return array(
        'siteSkins' => array_merge($manifest['skinSettings']['config'], $manifest['skinSettings']['qa']),
        'contentPages' => array('count' => count($contentState), 'skins' => $manifest['skinSettings']['content']),
        'boards' => $result,
    );
}

$action = $argv[1] ?? 'plan';
$profile = $argv[2] ?? 'shell';
if (!in_array($action, array('plan', 'apply', 'verify', 'reset'), true)) fixture_fail("unknown action: {$action}");

$manifestPath = __DIR__.'/boards.json';
$manifest = fixture_read_json($manifestPath);
$boards = fixture_validate_manifest($manifest, $profile);
$root = rtrim((string)(getenv('JW_G5_ROOT') ?: dirname(__DIR__, 2).'/.runtime/gnuboard5'), '/');
$common = fixture_prepare_g5($root);
require_once $common;

if (in_array($action, array('apply', 'reset'), true) && getenv('JW_G5_FIXTURE_ALLOWED') !== '1') {
    fixture_fail('apply/reset requires JW_G5_FIXTURE_ALLOWED=1');
}

if ($action === 'plan') {
    echo json_encode(array(
        'action' => 'plan', 'profile' => $profile, 'activeTheme' => $config['cf_theme'] ?? '',
        'boards' => array_column($boards, 'id'), 'pagination' => $manifest['pagination'],
        'skinSettings' => $manifest['skinSettings'],
        'allControlsPage' => 11, 'note' => '21 pages are required to show first, previous block, 11-20, next block, and last together.',
    ), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)."\n";
    exit(0);
}

if ($action === 'reset') {
    fixture_reset(fixture_read_state());
    echo "fixture reset complete\n";
    exit(0);
}

fixture_preflight($boards, $manifest);

if ($action === 'apply') {
    fixture_reset(fixture_read_state());
    $state = array(
        'version' => 1, 'marker' => $manifest['marker'], 'profile' => $profile,
        'boards' => array_column($boards, 'id'), 'createdBoards' => array(), 'originalBoards' => array(),
        'originalConfig' => fixture_singleton_fields($g5['config_table'], fixture_config_fields($manifest)),
        'originalQaConfig' => fixture_singleton_fields($g5['qa_config_table'], array_keys($manifest['skinSettings']['qa'])),
        'originalContentSkins' => fixture_content_skin_state($manifest),
    );
    fixture_write_state($state);

    fixture_apply_site_settings($manifest);

    $summary = array();
    foreach ($boards as $definition) {
        $existing = fixture_board_row($definition['id']);
        if ($existing) {
            $state['originalBoards'][$definition['id']] = array_intersect_key($existing, array_flip(fixture_board_config_fields()));
        } else {
            fixture_create_board($definition);
            $state['createdBoards'][] = $definition['id'];
        }
        fixture_write_state($state);
        fixture_configure_board($definition, $manifest);
        $summary[$definition['id']] = fixture_seed_board($definition, $manifest);
    }
    $verified = fixture_verify($boards, $manifest);
    echo json_encode(array('action' => 'apply', 'profile' => $profile, 'seeded' => $summary, 'verified' => $verified), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)."\n";
    exit(0);
}

echo json_encode(array('action' => 'verify', 'profile' => $profile, 'verified' => fixture_verify($boards, $manifest)), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)."\n";
