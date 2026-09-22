<?php
/**
 * Theme: JW-Business 1.0
 * File: head.sub.php
 * Role: GnuBoard5 테마 실행 파일
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */
if (!defined('_GNUBOARD_')) exit;

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
} else {
    $g5_head_title = implode(' | ', array_filter(array($g5['title'], $config['cf_title'])));
}

$g5['title'] = strip_tags((string)$g5['title']);
$g5_head_title = strip_tags((string)$g5_head_title);

// G5의 현재 접속자 기록에 필요한 위치와 URL 계약만 유지합니다.
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location']) {
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI'] ?? '/'));
}
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI'] ?? '/'));
if (str_contains($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || ($is_admin ?? '') === 'super') {
    $g5['lo_url'] = '';
}

$jw_escape = static function ($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
};
$jw_meta_text = static function ($value): string {
    return trim(preg_replace('/\s+/u', ' ', strip_tags((string)$value)) ?? '');
};
$jw_meta_url = static function ($value): string {
    $url = trim((string)$value);
    return filter_var($url, FILTER_VALIDATE_URL) && preg_match('#^https?://#i', $url) ? $url : '';
};

// 각 route adapter가 실제 페이지 데이터로 채우는 선택적 문서 메타 계약입니다.
$jw_document_meta = isset($g5['document_meta']) && is_array($g5['document_meta'])
    ? $g5['document_meta']
    : array();
$jw_description = $jw_meta_text($jw_document_meta['description'] ?? '');
$jw_canonical = $jw_meta_url($jw_document_meta['canonical'] ?? '');
$jw_robots = $jw_meta_text($jw_document_meta['robots'] ?? '');
$jw_og = isset($jw_document_meta['open_graph']) && is_array($jw_document_meta['open_graph'])
    ? $jw_document_meta['open_graph']
    : array();
$jw_og_type = $jw_meta_text($jw_og['type'] ?? '');
$jw_og_title = $jw_meta_text($jw_og['title'] ?? '');
$jw_og_description = $jw_meta_text($jw_og['description'] ?? '');
$jw_og_url = $jw_meta_url($jw_og['url'] ?? '');
$jw_og_image = $jw_meta_url($jw_og['image'] ?? '');

$jw_css_url = get_versioned_asset_url(G5_THEME_CSS_URL.'/jw-business.min.css');
$jw_module_url = get_versioned_asset_url(G5_THEME_JS_URL.'/jw-business.min.js');
?>
<!doctype html>
<html lang="ko" class="jw-theme" data-theme="jw-light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="color-scheme" content="light dark">
<meta name="theme-color" media="(prefers-color-scheme: light)" content="#ffffff">
<meta name="theme-color" media="(prefers-color-scheme: dark)" content="#202020">
<script>
(() => {
    const root = document.documentElement;
    const light = 'jw-light';
    const dark = 'jw-dark';
    let theme;

    try {
        const saved = window.localStorage.getItem('jw-business-theme');
        theme = saved === light || saved === dark
            ? saved
            : window.matchMedia('(prefers-color-scheme: dark)').matches ? dark : light;
    } catch {
        theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? dark : light;
    }

    root.dataset.theme = theme;
    root.style.colorScheme = theme === dark ? 'dark' : 'light';
})();
</script>
<title><?php echo $jw_escape($g5_head_title); ?></title>
<?php if ($jw_description !== '') { ?>
<meta name="description" content="<?php echo $jw_escape($jw_description); ?>">
<?php } ?>
<?php if ($jw_canonical !== '') { ?>
<link rel="canonical" href="<?php echo $jw_escape($jw_canonical); ?>">
<?php } ?>
<?php if ($jw_robots !== '') { ?>
<meta name="robots" content="<?php echo $jw_escape($jw_robots); ?>">
<?php } ?>
<?php if ($jw_og_type !== '') { ?>
<meta property="og:type" content="<?php echo $jw_escape($jw_og_type); ?>">
<?php } ?>
<?php if ($jw_og_title !== '') { ?>
<meta property="og:title" content="<?php echo $jw_escape($jw_og_title); ?>">
<?php } ?>
<?php if ($jw_og_description !== '') { ?>
<meta property="og:description" content="<?php echo $jw_escape($jw_og_description); ?>">
<?php } ?>
<?php if ($jw_og_url !== '') { ?>
<meta property="og:url" content="<?php echo $jw_escape($jw_og_url); ?>">
<?php } ?>
<?php if ($jw_og_image !== '') { ?>
<meta property="og:image" content="<?php echo $jw_escape($jw_og_image); ?>">
<?php } ?>
<link rel="stylesheet" href="<?php echo $jw_escape($jw_css_url); ?>">
<script type="module" src="<?php echo $jw_escape($jw_module_url); ?>"></script>
</head>
<body class="jw-document">
