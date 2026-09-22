<?php
if (!defined('_GNUBOARD_')) exit;
$jw_route = $jw_page['id'];
$jw_route_variant = (int)$jw_page['variant'];
$jw_route_meta = array(
    'business-list' => array('사업분야', '비즈니스 컨설팅, 디지털 서비스, 공간 경험의 업무 범위와 협업 방식을 소개합니다.'),
    'business-detail' => array('비즈니스 컨설팅', '현황 진단에서 실행 계획까지, 비즈니스 컨설팅의 업무 범위와 검토 자료를 확인하세요.'),
    'contact' => array('연락처·문의 안내', '사업별 문의 내용과 연락처를 확인하고 프로젝트 상담을 시작하세요.'),
);
if ($jw_route_variant === 2) {
    $jw_route_meta['business-list'] = array('사업분야 · 협업의 접점', '전략, 디지털, 공간이 만나는 장면과 분야별 업무를 살펴보세요.');
    $jw_route_meta['business-detail'] = array('디지털 서비스', '정보 구조와 화면 설계, 운영 인계를 연결하는 디지털 서비스의 업무 범위를 소개합니다.');
}
if ($jw_route_variant === 3) {
    $jw_route_meta['business-list'] = array('사업분야 · 공간에서 시작하는 변화', '공간 경험을 중심으로 전략과 디지털 업무를 연결하는 사업 구성을 소개합니다.');
    $jw_route_meta['business-detail'] = array('공간 경험', '방문 동선, 공간 사용, 안내 체계의 검토 범위와 협업 자료를 확인하세요.');
}
if ($jw_route_variant === 4) {
    $jw_route_meta['business-list'] = array('사업분야 · 업무 안내', '전략, 디지털, 공간 분야의 주요 과제와 검토 내용을 목록으로 확인하세요.');
    $jw_route_meta['business-detail'] = array('디지털 서비스 · 개선 사례', '시연용 사이트 개선 사례를 통해 문제, 변경안, 결과물과 검수 기준을 소개합니다.');
}
if ($jw_route_variant === 5) {
    $jw_route_meta['business-list'] = array('사업분야 · 목적별 업무', '방향을 정하는 업무와 경험을 만드는 업무를 구분해 필요한 서비스를 찾아보세요.');
    $jw_route_meta['business-detail'] = array('컨설팅 · 과정과 산출물', '현황 정리부터 실행 인계까지 단계별 협업 내용과 산출물을 소개합니다.');
}
$g5['title'] = $jw_route_meta[$jw_route][0];
$g5['document_meta'] = array('description'=>$jw_route_meta[$jw_route][1], 'canonical'=>$jw_page['url'], 'open_graph'=>array('type'=>'website','title'=>$g5['title'],'description'=>$jw_route_meta[$jw_route][1],'url'=>$jw_page['url']));
$jw_full_width_page = true;
$jw_link = static function($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
include_once G5_PATH.'/head.php';
?>
<article class="jwc jwb" data-jw-page-id="<?php echo jw_business_escape($jw_page['pageId']); ?>">
<nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><?php if ($jw_route === 'business-detail') { ?><span aria-hidden="true">/</span><a href="<?php echo $jw_link('business-list-1'); ?>">사업분야</a><?php } ?><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
<?php include G5_THEME_PATH.'/pages/'.$jw_route.'-'.$jw_route_variant.'.php'; ?>
<aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업·문의 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_PATH.'/tail.php'; ?>
