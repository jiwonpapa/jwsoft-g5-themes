<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/index.php
 * Role: JW-Business 일반 페이지 카탈로그 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = 'JW-Business 일반 페이지 카탈로그';
$jw_description = 'JW-Business 1.0에 포함된 일반 페이지 70개 레이아웃의 개발 카탈로그입니다.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/index.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/index.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<section class="jw-page-catalog">
    <header class="jw-page-catalog__intro"><p class="jw-page-facade__eyebrow">Development catalog</p><h2>70개 독립 PHP 페이지</h2><p>각 파일은 공통 dispatcher 없이 헤더, 본문, 푸터를 직접 구성합니다.</p></header>
    <div class="jw-page-catalog__groups">
        <section class="jw-page-catalog__group"><header><p>회사소개</p><h3>기업개요</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/company-overview-1.php"><span>#1</span><strong>사진·소개 좌우</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-overview-2.php"><span>#2</span><strong>슬라이더·기업 정보표</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-overview-3.php"><span>#3</span><strong>전면 이미지·스크롤 스토리</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-overview-4.php"><span>#4</span><strong>사업·사례 모자이크</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-overview-5.php"><span>#5</span><strong>고정 목차·장문 소개</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>회사소개</p><h3>대표 인사말</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/company-greeting-1.php"><span>#1</span><strong>대표 사진 좌측</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-greeting-2.php"><span>#2</span><strong>사진 상단</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-greeting-3.php"><span>#3</span><strong>제목·긴 본문 분할</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-greeting-4.php"><span>#4</span><strong>인용문·서명 중심</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-greeting-5.php"><span>#5</span><strong>넓은 사진·본문 분리</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>회사소개</p><h3>비전·가치</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/company-vision-1.php"><span>#1</span><strong>비전 상단·가치 다열</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-vision-2.php"><span>#2</span><strong>비전·가치 목록 좌우</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-vision-3.php"><span>#3</span><strong>선언·가치 교차</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-vision-4.php"><span>#4</span><strong>단계별 가치 흐름</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-vision-5.php"><span>#5</span><strong>사진·가치 분할</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>회사소개</p><h3>연혁</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/company-history-1.php"><span>#1</span><strong>세로 단일축</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-history-2.php"><span>#2</span><strong>중앙축 좌우</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-history-3.php"><span>#3</span><strong>연도별 표</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-history-4.php"><span>#4</span><strong>시기별 사진·기록</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-history-5.php"><span>#5</span><strong>연도·상세 열 분할</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>회사소개</p><h3>조직도</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/company-organization-1.php"><span>#1</span><strong>수직 계층</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-organization-2.php"><span>#2</span><strong>수평 계층</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-organization-3.php"><span>#3</span><strong>들여쓰기 조직 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-organization-4.php"><span>#4</span><strong>대표·부서 묶음</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-organization-5.php"><span>#5</span><strong>사업부별 계층 열</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>회사소개</p><h3>인증·수상</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/company-certification-1.php"><span>#1</span><strong>증서 격자</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-certification-2.php"><span>#2</span><strong>증서·설명 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-certification-3.php"><span>#3</span><strong>분야별 구분</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-certification-4.php"><span>#4</span><strong>큰 증서·상세</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-certification-5.php"><span>#5</span><strong>간결한 인증 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>회사소개</p><h3>오시는 길</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/company-location-1.php"><span>#1</span><strong>위치 이미지 상단</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-location-2.php"><span>#2</span><strong>위치·주소 좌우</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-location-3.php"><span>#3</span><strong>교통 안내 중심</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-location-4.php"><span>#4</span><strong>방문 사진·주차 안내</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/company-location-5.php"><span>#5</span><strong>지점별 위치 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>사업분야</p><h3>사업 목록</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/business-list-1.php"><span>#1</span><strong>사진 격자</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-list-2.php"><span>#2</span><strong>사진·설명 교차</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-list-3.php"><span>#3</span><strong>큰 대표 사업·나머지 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-list-4.php"><span>#4</span><strong>번호·사업 설명 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-list-5.php"><span>#5</span><strong>분야별 묶음</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>사업분야</p><h3>사업 상세</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/business-detail-1.php"><span>#1</span><strong>소개·특징·사례 순서</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-detail-2.php"><span>#2</span><strong>사진·설명 교차</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-detail-3.php"><span>#3</span><strong>업무 범위·사양 중심</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-detail-4.php"><span>#4</span><strong>사례·결과 중심</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-detail-5.php"><span>#5</span><strong>과정·산출물 중심</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>사업분야</p><h3>프로세스</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/business-process-1.php"><span>#1</span><strong>가로 단계</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-process-2.php"><span>#2</span><strong>세로 단계</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-process-3.php"><span>#3</span><strong>사진·단계 교차</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-process-4.php"><span>#4</span><strong>단계·산출물 표</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/business-process-5.php"><span>#5</span><strong>시기별 과정 묶음</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>인재채용</p><h3>인재상</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-talent-1.php"><span>#1</span><strong>선언·역량 다열</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-talent-2.php"><span>#2</span><strong>사진·가치 교차</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-talent-3.php"><span>#3</span><strong>행동 원칙 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-talent-4.php"><span>#4</span><strong>역량·업무 사례</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-talent-5.php"><span>#5</span><strong>문화·인재상 좌우</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>인재채용</p><h3>복리후생</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-benefits-1.php"><span>#1</span><strong>항목 격자</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-benefits-2.php"><span>#2</span><strong>주제별 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-benefits-3.php"><span>#3</span><strong>사진·제도 교차</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-benefits-4.php"><span>#4</span><strong>대표 제도·나머지 목록</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/recruit-benefits-5.php"><span>#5</span><strong>제도·설명 표</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>고객지원</p><h3>고객센터 안내</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/support-home-1.php"><span>#1</span><strong>FAQ·공지·문의 요약</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/support-home-2.php"><span>#2</span><strong>문의 목적별 안내</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/support-home-3.php"><span>#3</span><strong>자료실 중심</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/support-home-4.php"><span>#4</span><strong>이용 순서 중심</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/support-home-5.php"><span>#5</span><strong>지원 채널·운영 안내</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
        <section class="jw-page-catalog__group"><header><p>문의</p><h3>연락처·문의 안내</h3></header><ol>
                <li><a href="<?php echo G5_URL; ?>/pages/contact-1.php"><span>#1</span><strong>담당 분야별 연락처</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/contact-2.php"><span>#2</span><strong>문의 목적별 경로</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/contact-3.php"><span>#3</span><strong>업무 시간·연락처 좌우</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/contact-4.php"><span>#4</span><strong>부서별 연락처 표</strong><i data-lucide="arrow-up-right"></i></a></li>
                <li><a href="<?php echo G5_URL; ?>/pages/contact-5.php"><span>#5</span><strong>문의 절차·연락처</strong><i data-lucide="arrow-up-right"></i></a></li>
            </ol></section>
    </div>
</section>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
