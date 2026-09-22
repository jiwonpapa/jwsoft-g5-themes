<?php
if (!defined('_GNUBOARD_')) exit;

$jw_variant = max(1, min(5, (int) ($jw_page['variant'] ?? 1)));
$jw_partial = G5_THEME_PATH.'/partials/home/'.$jw_variant.'.php';

if (!is_file($jw_partial)) {
    http_response_code(404);
    return;
}

$g5['title'] = '메인 #'.$jw_variant;
$jw_description = 'JW-Business '.$jw_page['layout'].' 메인 레이아웃입니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => $jw_page['url'],
    'open_graph' => array(
        'type' => 'website',
        'title' => $g5['title'],
        'description' => $jw_description,
        'url' => $jw_page['url'],
    ),
);

// 메인 변형 URL도 루트 메인과 같은 전체폭 쉘을 사용합니다.
$jw_full_width_page = true;

include_once G5_PATH.'/head.php';
include $jw_partial;
include_once G5_PATH.'/tail.php';
