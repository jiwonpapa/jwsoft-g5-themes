<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-detail-2.php
 * Role: 디지털 서비스 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '디지털 서비스';
$jw_description = '정보 구조와 화면 설계, 운영 인계를 연결하는 디지털 서비스의 업무 범위를 소개합니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-detail-2.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-detail-2.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-detail-2">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><a href="<?php echo $jw_link('business-list-1'); ?>">사업분야</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-detail-2.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwc-cinema-title jwc-wrap"><div><p class="jwc-kicker">디지털 서비스</p><h1>찾기 쉬운 정보,<br>이어지는 경험.</h1></div><p>보이는 화면과<br>운영하는 과정을 함께 설계합니다.</p></header>
<div class="jwb-digital-cover jwc-wrap"><div class="jwc-photo jwc-photo--workspace" role="img" aria-label="밝은 업무 공간과 자료를 놓는 테이블"></div><p>사용할 사람과 운영할 환경을 함께 생각합니다. 업무 공간 이미지 예시.</p></div>
<section class="jwb-alternating jwc-wrap" aria-label="디지털 업무 범위">
<article><figure class="jwb-route-figure"><figcaption>이용 흐름 예시</figcaption><ol><li><span>정보 확인</span><strong>어떤 일을 하는 곳인가요?</strong></li><li><span>범위 이해</span><strong>내 과제와 맞는 서비스인가요?</strong></li><li><span>문의</span><strong>어떤 내용을 전달하면 되나요?</strong></li></ol></figure><div><p class="jwc-kicker">Information</p><h2>메뉴보다 먼저,<br>찾는 이유를 봅니다.</h2><p>페이지 수를 늘리기보다 방문자가 찾는 질문을 정리합니다. 정보의 순서와 연결을 기준으로 메뉴와 콘텐츠를 설계합니다.</p><dl class="jwb-inline-facts"><div><dt>검토 범위</dt><dd>주요 이용자 · 콘텐츠 분류 · 문의 경로</dd></div><div><dt>공유 자료</dt><dd>정보 구조도 · 페이지별 내용 목록</dd></div></dl></div></article>
<article><figure><div class="jwc-photo jwc-photo--team" role="img" aria-label="설계 자료를 함께 검토하는 동료"></div><figcaption>자료와 사용 장면을 나란히 놓고 확인합니다.</figcaption></figure><div><p class="jwc-kicker">Experience</p><h2>보기 좋은 화면에서<br>사용할 수 있는 화면으로.</h2><p>PC와 휴대폰에서 읽는 순서, 버튼의 의미, 입력 후 확인할 정보를 점검합니다. 주요 화면은 실제 내용과 함께 검토합니다.</p><dl class="jwb-inline-facts"><div><dt>검토 범위</dt><dd>반응형 구성 · 입력/오류/완료 상태</dd></div><div><dt>공유 자료</dt><dd>주요 화면 · 동작 흐름 · 수정 의견</dd></div></dl></div></article>
</section>
<section class="jwc-soft"><div class="jwc-section jwc-wrap jwc-statement"><div><p class="jwc-kicker">Operation</p><h2>담당자가 이어서<br>관리할 수 있도록.</h2></div><div><p>자주 바뀌는 정보와 수정할 위치를 정리하고, 담당자가 확인해야 할 작업을 안내합니다. 개발이 끝난 뒤에도 참고할 수 있는 기록을 남깁니다.</p><dl class="jwb-inline-facts"><div><dt>인계 자료</dt><dd>콘텐츠 수정 위치 · 기본 사용 안내 · 확인 사항</dd></div><div><dt>별도 협의</dt><dd>외부 서비스 연동, 지속 운영, 추가 기능의 제공 범위</dd></div></dl></div></div></section>
<section class="jwc-section jwc-wrap jwc-question"><h2>지금의 서비스에서<br>바꾸고 싶은 흐름이 있나요?</h2><p>기존 사이트나 참고 자료, 불편한 이용 장면을 알려 주세요.<br>아직 사이트가 없다면 목적과 필요한 정보부터 정리할 수 있습니다.</p><a class="jw-control jw-control--primary" href="<?php echo $jw_link('contact-1'); ?>#contact-digital">디지털 문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
