<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/company-organization-3.php
 * Role: 조직도 #3 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '조직도 #3';
$jw_description = '회사소개의 조직도 3번 레이아웃인 들여쓰기 조직 목록 페이지입니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/company-organization-3.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/company-organization-3.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<article class="jw-page-facade" data-jw-page-id="company-organization-3">
    <header class="jw-page-facade__intro">
        <p class="jw-page-facade__eyebrow">회사소개 · Layout 3</p>
        <h2>들여쓰기 조직 목록</h2>
        <p>공통 renderer를 호출하지 않는 독립 PHP 페이지입니다. 아래 섹션을 이 파일 안에서 직접 구현하고 수정합니다.</p>
    </header>
    <ol class="jw-page-facade__sections" aria-label="페이지 구성 섹션">
        <li><span>01</span><strong>조직 소개</strong><small>이 파일 안에서 완성할 독립 섹션</small></li>
        <li><span>02</span><strong>조직 구조</strong><small>이 파일 안에서 완성할 독립 섹션</small></li>
        <li><span>03</span><strong>부서 안내</strong><small>이 파일 안에서 완성할 독립 섹션</small></li>
        <li><span>04</span><strong>업무 연락처</strong><small>이 파일 안에서 완성할 독립 섹션</small></li>
    </ol>
    <footer class="jw-page-facade__actions"><a class="jw-text-link" href="<?php echo jw_business_escape(G5_URL.'/pages/'); ?>">일반 페이지 카탈로그 <i data-lucide="arrow-right"></i></a></footer>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
