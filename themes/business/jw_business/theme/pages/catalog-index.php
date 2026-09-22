<?php
if (!defined('_GNUBOARD_')) exit;

include_once G5_THEME_PATH.'/lib/jw-business.lib.php';

$g5['title'] = 'JW-Business 페이지 카탈로그';
$g5['document_meta'] = array(
    'description' => 'JW-Business 1.0에 포함된 메인과 일반 페이지 75개 레이아웃의 개발 카탈로그입니다.',
    'canonical' => G5_URL.'/pages/',
    'robots' => 'noindex, nofollow',
);
$jw_catalog = jw_business_page_catalog();
$jw_page_count = 0;
foreach ($jw_catalog['pageTypes'] as $jw_type) {
    $jw_page_count += count((array) ($jw_type['layouts'] ?? array()));
}

include_once G5_PATH.'/head.php';
?>
<section class="jw-page-catalog">
    <header class="jw-page-catalog__intro">
        <p class="jw-page-facade__eyebrow">Development catalog</p>
        <h2><?php echo (int) $jw_page_count; ?>개 라우트가 실제 PHP 파일로 연결됩니다.</h2>
        <p>구매자는 필요한 레이아웃만 메뉴에 남깁니다. 이 카탈로그는 제공 페이지를 빠짐없이 확인하기 위한 개발·데모용 화면입니다.</p>
    </header>

    <div class="jw-page-catalog__groups">
        <?php foreach ($jw_catalog['pageTypes'] as $jw_type) { ?>
        <section class="jw-page-catalog__group">
            <header>
                <p><?php echo jw_business_escape($jw_type['categoryLabel']); ?></p>
                <h3><?php echo jw_business_escape($jw_type['title']); ?></h3>
            </header>
            <ol>
                <?php foreach ((array) $jw_type['layouts'] as $jw_index => $jw_layout) {
                    $jw_page_id = $jw_type['id'].'-'.($jw_index + 1);
                ?>
                <li>
                    <a href="<?php echo jw_business_escape(jw_business_page_url($jw_page_id)); ?>">
                        <span>#<?php echo $jw_index + 1; ?></span>
                        <strong><?php echo jw_business_escape($jw_layout); ?></strong>
                        <i data-lucide="arrow-up-right"></i>
                    </a>
                </li>
                <?php } ?>
            </ol>
        </section>
        <?php } ?>
    </div>
</section>
<?php include_once G5_PATH.'/tail.php'; ?>
