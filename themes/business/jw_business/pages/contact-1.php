<?php
/**
 * Theme: JW-Business 1.0
 * File: pages/contact-1.php
 * Role: 연락처·문의 안내 완성형 일반 페이지
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
include_once dirname(__DIR__).'/common.php';
$g5['title'] = '연락처·문의 안내';
$jw_description = '사업별 문의 내용과 연락처를 확인하고 프로젝트 상담을 시작하세요.';
$g5['document_meta'] = array(
    'description' => $jw_description,
    'canonical' => G5_URL.'/pages/contact-1.php',
    'open_graph' => array('type' => 'website', 'title' => $g5['title'], 'description' => $jw_description, 'url' => G5_URL.'/pages/contact-1.php'),
);
$jw_full_width_page = true;
include_once G5_THEME_PATH.'/head.php';
?>
<?php
$jw_link = static function ($id) { return jw_business_escape(jw_business_page_url($id)); };
$jw_company = jw_business_settings()['company'];
?>
<article class="jwc jwb" data-jw-page-id="contact-1">
    <nav class="jwc-trail jwc-wrap" aria-label="현재 위치"><a href="<?php echo G5_URL; ?>">홈</a><span aria-hidden="true">/</span><span aria-current="page">문의</span></nav>
    <!-- JW BLOCK COPY START: legacy src/php/pages/contact-1.php; 이 페이지 안에서만 수정합니다. -->
<header class="jwc-cinema-title jwc-wrap"><h1>어떤 이야기를<br>함께 나눌까요?</h1><p>완성된 제안서가 없어도 괜찮습니다.<br>현재 상황과 필요한 변화를 알려 주세요.</p></header>
<section class="jwc-wrap jwb-contact-routes" aria-label="분야별 문의 안내">
<?php foreach (array(array('strategy','비즈니스 컨설팅','사업 방향, 우선순위, 업무 흐름에 관한 과제','목표 · 현재 상황 · 검토 일정'),array('digital','디지털 서비스','사이트, 콘텐츠, 이용 흐름에 관한 과제','기존 서비스 · 필요한 기능 · 운영 방식'),array('space','공간 경험','동선, 협업 환경, 공간 사용에 관한 과제','공간의 용도 · 불편한 장면 · 참고 자료')) as $jw_topic) { ?>
<section id="contact-<?php echo $jw_topic[0]; ?>"><h2><?php echo $jw_topic[1]; ?></h2><p><?php echo $jw_topic[2]; ?></p><dl><dt>함께 알려 주시면 좋습니다</dt><dd><?php echo $jw_topic[3]; ?></dd></dl><a class="jwc-link" href="<?php echo G5_BBS_URL; ?>/qalist.php"><?php echo $jw_topic[1]; ?> 상담 시작<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></section>
<?php } ?>
</section>
<section class="jwc-soft"><div class="jwc-section jwc-wrap jwc-facts-layout"><div><p class="jwc-kicker">대표 연락처</p><h2>문의 내용을 남기고,<br>답변을 확인하세요.</h2><p>온라인 문의는 회원 로그인 후 이용할 수 있습니다. 작성한 내용과 답변은 1:1 문의에서 확인합니다.</p><a class="jw-control jw-control--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">1:1 문의로 이동<i data-lucide="arrow-right" aria-hidden="true"></i></a></div><dl class="jwc-facts"><div><dt>회사명</dt><dd><?php echo jw_business_escape($jw_company['name']); ?></dd></div><div><dt>전화</dt><dd><?php echo jw_business_escape($jw_company['phone']); ?></dd></div><div><dt>이메일</dt><dd><?php echo jw_business_escape($jw_company['email']); ?></dd></div><div><dt>주소</dt><dd><?php echo jw_business_escape($jw_company['address']); ?></dd></div><div><dt>운영 시간</dt><dd><?php echo jw_business_escape($jw_company['hours'] ?? '운영 시간은 별도 확인해 주세요.'); ?></dd></div></dl></div></section>
<section class="jwc-section jwc-wrap jwc-statement"><h2>문의 전에<br>확인해 주세요.</h2><div><p>비밀번호나 인증번호 같은 민감한 정보는 남기지 마세요. 자료가 있다면 공개할 수 있는 범위로 정리해 주세요.</p><p>접수 내용에 따라 추가 확인이 필요할 수 있습니다. 방문 상담이 필요한 경우에는 사전에 일정과 장소를 확인해 주세요.</p></div></section>
    <!-- JW BLOCK COPY END -->
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
