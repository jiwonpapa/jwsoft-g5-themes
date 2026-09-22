<?php
if (!defined('_GNUBOARD_')) exit;
$jw_variant = (int) $jw_page['variant'];
$jw_settings = jw_business_settings();
$jw_company_name = jw_business_escape($jw_settings['brand']['name']);
$jw_descriptions = array(
    1 => '전략과 기술, 공간을 연결하는 기업. 사람과 현장을 중심으로 일하는 방식을 소개합니다.',
    2 => '기업의 현장과 협업 공간을 살펴보고 사업 영역, 프로젝트 방식, 기업 정보를 확인하세요.',
    3 => '일하는 공간에서 시작되는 변화. 발견하고 연결하고 이어가는 기업의 이야기를 만나보세요.',
    4 => '전략·디지털·공간의 세 가지 관점으로 사업과 프로젝트 접근 방식을 소개합니다.',
    5 => '좋은 질문에서 지속되는 관계까지, 기업이 일하는 철학과 원칙을 깊이 있게 소개합니다.',
);
$g5['title'] = '기업개요 #'.$jw_variant;
$g5['document_meta'] = array('description' => $jw_descriptions[$jw_variant], 'canonical' => $jw_page['url'], 'open_graph' => array('type'=>'website', 'title'=>$g5['title'], 'description'=>$jw_descriptions[$jw_variant], 'url'=>$jw_page['url']));
$jw_full_width_page = true;
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_photo = static function ($type, $label, $classes = '') {
    ?><div class="jwc-photo jwc-photo--<?php echo jw_business_escape($type); ?> <?php echo jw_business_escape($classes); ?>" role="img" aria-label="<?php echo jw_business_escape($label); ?>"></div><?php
};
include_once G5_PATH.'/head.php';
?>
<article class="jwc jwc--<?php echo $jw_variant; ?>" data-jw-company-page="<?php echo $jw_variant; ?>">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span>회사소개</span><span aria-hidden="true">/</span><span aria-current="page">기업개요</span></nav>
    <?php include G5_THEME_PATH.'/pages/company-overview/'.$jw_variant.'.php'; ?>
    <aside class="jwc-demo jwc-wrap" aria-label="테마 시연 안내">
        <p><?php echo $jw_company_name; ?>의 기업 소개 예시입니다. 사진과 사례는 실제 기업의 실적을 나타내지 않습니다.</p>
        <nav aria-label="기업개요 디자인 비교"><span>다른 디자인</span><?php for ($i=1; $i<=5; $i++) { ?><a href="<?php echo $jw_link('company-overview-'.$i); ?>"<?php echo $i === $jw_variant ? ' aria-current="page"' : ''; ?>>#<?php echo $i; ?></a><?php } ?></nav>
    </aside>
</article>
<?php include_once G5_PATH.'/tail.php'; ?>
