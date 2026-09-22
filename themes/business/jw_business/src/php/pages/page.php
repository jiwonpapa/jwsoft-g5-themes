<?php
if (!defined('_GNUBOARD_')) exit;

include_once G5_THEME_PATH.'/lib/jw-business.lib.php';

$jw_page = jw_business_page_find($jw_page_id ?? '');
if (!$jw_page) {
    http_response_code(404);
    $g5['title'] = '페이지를 찾을 수 없습니다';
    include_once G5_PATH.'/head.php';
    ?>
    <section class="jw-page-facade jw-page-facade--missing">
        <p>요청한 일반 페이지가 페이지 카탈로그에 없습니다.</p>
        <a class="jw-button jw-button--primary" href="<?php echo jw_business_escape(G5_URL.'/pages/'); ?>">페이지 카탈로그</a>
    </section>
    <?php
    include_once G5_PATH.'/tail.php';
    return;
}

if ($jw_page['id'] === 'company-overview') {
    include G5_THEME_PATH.'/pages/company-overview.php';
    return;
}

if ($jw_page['id'] === 'home' && is_file(G5_THEME_PATH.'/partials/home/'.(int)$jw_page['variant'].'.php')) {
    include G5_THEME_PATH.'/pages/home.php';
    return;
}

if (((int)$jw_page['variant'] === 1 && in_array($jw_page['id'], array('business-list', 'business-detail', 'contact'), true))
    || (in_array((int)$jw_page['variant'], array(2, 3, 4, 5), true) && in_array($jw_page['id'], array('business-list', 'business-detail'), true))) {
    include G5_THEME_PATH.'/pages/business-route.php';
    return;
}

$g5['title'] = $jw_page['title'].' #'.$jw_page['variant'];
$jw_description = $jw_page['categoryLabel'].'의 '.$jw_page['title'].' '.$jw_page['variant'].'번 레이아웃인 '.$jw_page['layout'].' 페이지입니다.';
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

include_once G5_PATH.'/head.php';
?>
<article class="jw-page-facade" data-jw-page-id="<?php echo jw_business_escape($jw_page['pageId']); ?>">
    <header class="jw-page-facade__intro">
        <p class="jw-page-facade__eyebrow"><?php echo jw_business_escape($jw_page['categoryLabel']); ?> · Layout <?php echo (int) $jw_page['variant']; ?></p>
        <h2><?php echo jw_business_escape($jw_page['layout']); ?></h2>
        <p>이 화면은 URL·메뉴·메타·섹션 순서를 먼저 고정한 제작용 파사드입니다. 최종 디자인은 각 레이아웃 recipe에 따라 채웁니다.</p>
    </header>

    <ol class="jw-page-facade__sections" aria-label="구현 예정 섹션">
        <?php foreach ((array) ($jw_page['sections'] ?? array()) as $index => $section) { ?>
        <li>
            <span><?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
            <strong><?php echo jw_business_escape($section); ?></strong>
            <small>공통 섹션 원본과 이 페이지 recipe를 연결할 자리</small>
        </li>
        <?php } ?>
    </ol>

    <footer class="jw-page-facade__actions">
        <a class="jw-text-link" href="<?php echo jw_business_escape(G5_URL.'/pages/'); ?>">75개 페이지 카탈로그 <i data-lucide="arrow-right"></i></a>
    </footer>
</article>
<?php include_once G5_PATH.'/tail.php'; ?>
