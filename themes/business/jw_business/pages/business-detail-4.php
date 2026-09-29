<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/business-detail-4.php
 * Role: 디지털 서비스 · 개선 사례 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '디지털 서비스 · 개선 사례';
$jw_description = '시연용 사이트 개선 사례를 통해 문제, 변경안, 결과물과 검수 기준을 소개합니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/business-detail-4.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/business-detail-4.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="business-detail-4">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><a href="<?php echo $jw_link('business-list-1'); ?>">사업분야</a><span aria-hidden="true">/</span><span aria-current="page"><?php echo jw_business_escape($g5['title']); ?></span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/business-detail-4.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwc-wrap jwb-case-header"><h1>소개는 있었지만,<br>다음 길은 없었습니다.</h1><p class="jwc-lead">기업 사이트의 정보 탐색과 문의 흐름을 정리하는 개선 사례.</p><p class="jwb-example-note">설계 과정을 설명하기 위한 가상 사례입니다. 실제 고객 실적이나 측정된 성과가 아닙니다.</p></header>
<figure class="jwc-wrap jwb-case-cover"><div class="jwc-photo jwc-photo--business-detail-4-case" role="img" aria-label="노트북의 웹 화면을 함께 살펴보는 고객과 디자이너"></div><figcaption>기업 서비스의 정보와 운영 흐름을 함께 검토하는 상황을 가정했습니다.</figcaption></figure>
<section class="jwc-section jwc-wrap jwc-statement"><h2>문제는 정보의 양보다<br>연결 방식이었습니다.</h2><div><p>회사 소개와 사업 설명은 있었지만, 방문자는 자신에게 맞는 업무와 문의 방법을 여러 페이지에서 찾아야 했습니다.</p><dl class="jwb-inline-facts"><div><dt>가정한 상황</dt><dd>사업별 제공 범위가 불분명하고 문의 정보가 흩어진 기업 사이트</dd></div><div><dt>검토 목표</dt><dd>사업 이해 → 업무 범위 확인 → 문의 준비로 이어지는 경로</dd></div><div><dt>작업 범위</dt><dd>정보 구조 · 주요 화면 · 콘텐츠 안내</dd></div></dl></div></section>
<section class="jwc-soft"><div class="jwc-section jwc-wrap"><div class="jwc-section-head"><h2>무엇을 바꾸었는지,<br>나란히 확인합니다.</h2><p>가상 기업 사이트의<br>한 화면을 간추린 시안입니다.</p></div><div class="jwb-case-comparison" data-jw-digital-artifact><figure><div class="jwb-case-screen jwb-case-screen--before"><div class="jwb-case-screen__bar"><span>변경 전</span><span aria-hidden="true">•••</span></div><div class="jwb-case-screen__content"><strong>사업 분야</strong><div>컨설팅</div><div>디지털</div><div>공간</div><small>자세한 내용은 문의하세요</small></div></div><figcaption>이름만으로는 업무 범위를 알기 어렵습니다.</figcaption></figure><figure><div class="jwb-case-screen jwb-case-screen--after"><div class="jwb-case-screen__bar"><span>변경안</span><span aria-hidden="true">•••</span></div><div class="jwb-case-screen__content"><strong>어떤 도움이 필요하신가요?</strong><div><i data-lucide="monitor" aria-hidden="true"></i><span><b>디지털 서비스</b><small>정보 구조 · 주요 화면 · 운영 안내</small></span></div><div><i data-lucide="arrow-up-right" aria-hidden="true"></i><span><b>업무 범위 살펴보기</b><small>필요한 자료와 문의 방법까지</small></span></div></div></div><figcaption>설명과 다음 행동을 같은 흐름에 놓습니다.</figcaption></figure></div></div></section>
<section class="jwc-section jwc-wrap jwb-outcome-layout"><div><h2>결과물은<br>확인할 수 있어야 합니다.</h2><p>좋아졌다는 표현 대신,<br>무엇으로 확인할지 남깁니다.</p></div><ol class="jwb-outcomes"><li><h3>정보 구조와 페이지 목록</h3><p>사업 목록에서 상세, 상세에서 문의 안내로 이동하는 경로를 문서화합니다.</p><strong>검수 기준</strong><span>각 사업의 업무 범위와 다음 행동을 찾을 수 있는가</span></li><li><h3>PC·모바일 주요 화면</h3><p>같은 내용을 화면 크기에 맞춰 읽을 수 있도록 배치합니다.</p><strong>검수 기준</strong><span>가로 넘침 없이 제목·본문·링크가 순서대로 읽히는가</span></li><li><h3>운영 인계 안내</h3><p>담당자가 사업 설명과 연락처를 수정할 위치를 정리합니다.</p><strong>검수 기준</strong><span>수정 대상과 반영 후 확인할 항목이 명확한가</span></li></ol></section>
<section class="jwc-wrap jwb-space-close"><div><h2>비슷한 불편이 있으신가요?</h2><p>현재 사이트와 불편한 장면부터 알려 주세요.</p></div><a class="jw-control jw-control--primary" href="<?php echo $jw_link('contact-1'); ?>#contact-digital">디지털 문의 안내<i data-lucide="arrow-right" aria-hidden="true"></i></a></section>
    <!-- JW BLOCK COPY END -->
    <aside class="jwc-demo jwc-wrap"><p>테마 시연용 사업 안내입니다. 실제 제공 범위와 연락처는 운영자의 정보로 설정합니다.</p></aside>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
