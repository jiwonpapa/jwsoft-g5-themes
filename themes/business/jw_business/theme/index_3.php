<?php
/**
 * Theme: JW-Business 1.0
 * File: index_3.php
 * Role: 사례와 결과물 중심의 메인 3번 독립 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
// 선택용 파일의 직접 미리보기에서도 G5 기본 초기화만 수행합니다.
if (!defined('_GNUBOARD_')) {
    include_once dirname(__DIR__, 2).'/common.php';
}
if (!defined('_INDEX_')) {
    define('_INDEX_', true);
}
$g5['title'] = $config['cf_title'];
include_once G5_THEME_PATH.'/head.php';
$jw_company = jw_business_settings()['company'];
?>
<article class="jwh jwh--projects" data-jw-home="3">
    <header class="jwh-project-heading jwh-wrap">
        <h1>생각을 넘어,<br>경험으로 남기는 일.</h1>
        <div>
            <p class="jwh-lead">공간과 서비스, 팀의 일하는 방식까지.<br>과제에서 결과물로 이어지는 과정을 소개합니다.</p>
            <a class="jwh-link" href="#home-projects">프로젝트 살펴보기 <i data-lucide="arrow-down" aria-hidden="true"></i>
            </a>
        </div>
    </header>
    <section id="home-projects" class="jwh-wrap" aria-labelledby="home-featured-title">
        <a class="jwh-featured-case" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-4')); ?>">
            <div class="jwh-photo jwh-photo--workspace" role="img" aria-label="자연광과 협업 테이블이 있는 업무 공간의 시연 이미지">
            </div>
            <div class="jwh-case-caption">
                <div>
                    <h2 id="home-featured-title">일과 사람이 만나는 업무 공간</h2>
                    <p>공간 기획 · 이용 흐름 · 운영 시나리오</p>
                </div>
                <span>사례 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></span>
            </div>
        </a>
        <p class="jwh-demo-note">이 페이지의 모든 프로젝트는 테마 활용을 보여주는 시연 사례이며 실제 고객·수행 실적을 뜻하지 않습니다.</p>
        <div class="jwh-case-pair">
            <a class="jwh-case" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-1')); ?>">
                <div class="jwh-photo jwh-photo--team" role="img" aria-label="함께 문서와 기획안을 검토하는 업무 장면">
                </div>
                <h3>팀의 질문을 하나의 실행안으로</h3>
                <p>비즈니스 컨설팅 · 워크숍·의사결정 자료</p>
                <span class="jwh-link">기획 과정 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></span>
            </a>
            <a class="jwh-case jwh-case--offset" href="<?php echo jw_business_escape(jw_business_page_url('business-detail-3')); ?>">
                <div class="jwh-photo jwh-photo--campus" role="img" aria-label="방문자의 이동과 휴식 공간이 연결된 업무 시설">
                </div>
                <h3>첫 방문부터 이어지는 브랜드 경험</h3>
                <p>공간·브랜드 · 동선과 안내 접점</p>
                <span class="jwh-link">공간 기획 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></span>
            </a>
        </div>
    </section>
    <section class="jwh-section jwh-soft" aria-labelledby="home-project-method">
        <div class="jwh-wrap jwh-project-method">
            <h2 id="home-project-method">결과를 설명하는<br>세 가지 질문.</h2>
            <dl>
                <div>
                    <dt>무엇을 해결했는가</dt>
                    <dd>멋진 사진만으로는 알 수 없는 시작점입니다. 현장의 불편과 바꾸고 싶은 상황을 기록합니다.</dd>
                </div>
                <div>
                    <dt>어떻게 판단했는가</dt>
                    <dd>대안과 선택의 이유를 정리합니다. 결과를 이해하고 다음 작업에서도 활용할 수 있게 합니다.</dd>
                </div>
                <div>
                    <dt>무엇을 남겼는가</dt>
                    <dd>화면, 공간 구성안, 운영 문서처럼 담당자가 실제로 사용할 수 있는 결과물을 남깁니다.</dd>
                </div>
            </dl>
        </div>
    </section>
    <section class="jwh-section jwh-wrap jwh-project-invitation">
        <h2>비슷한 과제를<br>준비하고 계신가요?</h2>
        <div>
            <p>사업 단계와 고민을 알려주시면 필요한 분야부터 함께 살펴봅니다. 준비된 자료가 있다면 문의에 함께 남겨주세요.</p>
            <a class="jw-control jw-control--primary" href="<?php echo jw_business_escape(jw_business_page_url('contact-1')); ?>">상담 방법 확인 <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
            <a class="jwh-link" href="<?php echo jw_business_escape(jw_business_page_url('business-list-3')); ?>">전체 사업 분야 <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
