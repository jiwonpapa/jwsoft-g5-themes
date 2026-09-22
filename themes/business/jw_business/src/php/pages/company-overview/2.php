<?php if (!defined('_GNUBOARD_')) exit; ?>
<header class="jwc-cinema-title jwc-wrap"><h1>우리가 일하는 방식이<br>우리의 소개입니다.</h1><p>사업 영역과 협업 범위를 살펴보고,<br>필요한 정보를 확인하세요.</p></header>
<section class="jwc-cinema" aria-label="기업 현장 소개" aria-roledescription="슬라이드 쇼" data-jwc-slider>
    <div class="jwc-slider__viewport" data-jwc-viewport tabindex="0" aria-label="기업 현장 사진. 좌우 화살표 키로 이동할 수 있습니다.">
        <div class="jwc-slider__track">
            <?php $slides = array(array('campus','외관에서 시작하는 현장 이해','접근 동선과 주변 환경부터 살펴보는 공간 소개 예시입니다.','현대적인 업무 시설과 광장'),array('team','도면을 함께 읽는 검토 시간','기획 의도와 현장의 조건을 같은 자료 위에서 확인합니다.','도면을 검토하는 동료들'),array('workspace','회의와 집중을 담는 업무 환경','함께 논의하는 자리와 개별 업무가 이어지는 공간 예시입니다.','자연광이 들어오는 협업 공간')); foreach ($slides as $i=>$slide) { ?>
            <div class="jwc-slide" role="group" aria-roledescription="슬라이드" aria-label="<?php echo $i+1; ?> / 3">
                <?php $jw_photo($slide[0],$slide[3]); ?>
                <div class="jwc-slide__caption"><h2><?php echo $slide[1]; ?></h2><p><?php echo $slide[2]; ?></p></div>
            </div><?php } ?>
        </div>
    </div>
    <div class="jwc-slider__controls jwc-wrap"><span data-jwc-status aria-live="polite" aria-atomic="true">1 / 3</span><div><button type="button" data-jwc-prev aria-label="이전 사진"><i data-lucide="arrow-left"></i></button><button type="button" data-jwc-next aria-label="다음 사진"><i data-lucide="arrow-right"></i></button><button type="button" data-jwc-play aria-pressed="false">자동 재생</button></div></div>
</section>
<section class="jwc-section jwc-wrap jwc-facts-layout"><div><h2>한눈에 보는<br><?php echo $jw_company_name; ?></h2><p>우리가 하는 일과<br>함께하는 방식을 소개합니다.</p></div><dl class="jwc-facts"><div><dt>기업명</dt><dd><?php echo $jw_company_name; ?></dd></div><div><dt>사업 영역</dt><dd>비즈니스 컨설팅 · 디지털 서비스 · 공간 경험</dd></div><div><dt>프로젝트 범위</dt><dd>기획 · 설계 · 제작 · 운영 개선</dd></div><div><dt>협업 방식</dt><dd>분야별 전문가가 함께하는 프로젝트 팀</dd></div><div><dt>주요 관점</dt><dd>사용자 경험, 현장 적합성, 지속 가능한 운영</dd></div></dl></section>
<!-- Service matrix: compare scope and review materials without repeating a process diagram. -->
<section class="jwc-soft"><div class="jwc-section jwc-wrap">
    <div class="jwc-section-head"><div><p class="jwc-kicker">사업별 검토 항목</p><h2>필요한 분야를<br>구체적으로 살펴보세요.</h2></div><p>같은 프로젝트라도<br>다루는 문제와 확인할 자료는 다릅니다.</p></div>
    <div class="jwc-matrix" role="region" aria-label="사업별 지원 범위 비교" tabindex="0">
    <table><caption>사업 영역별 과제 · 검토 범위 · 공유 자료</caption><thead><tr><th scope="col">사업 영역</th><th scope="col">이런 과제가 있을 때</th><th scope="col">함께 검토할 범위</th><th scope="col">공유 자료 예시</th></tr></thead><tbody>
    <tr><th scope="row">비즈니스 컨설팅</th><td>새로운 서비스의 방향과 우선순위를 정해야 할 때</td><td>목표 고객, 현재 운영 흐름, 단계별 실행 범위</td><td>현황 정리 · 과제 목록 · 실행 계획</td></tr>
    <tr><th scope="row">디지털 서비스</th><td>흩어진 정보를 정리하고 이용 흐름을 개선할 때</td><td>메뉴 구조, 주요 화면, 관리와 운영 방식</td><td>정보 구조도 · 화면 설계 · 운영 안내</td></tr>
    <tr><th scope="row">공간 경험</th><td>이용 목적에 맞게 공간의 쓰임을 바꿀 때</td><td>방문 동선, 업무 방식, 공간별 사용 조건</td><td>동선 검토 · 공간 구성 · 사용 시나리오</td></tr>
    </tbody></table></div><p class="jwc-matrix-note">협업 범위를 설명하기 위한 예시이며, 구체적인 제공 자료는 프로젝트 상담에서 정합니다.</p>
</div></section>
<section class="jwc-section jwc-wrap jwc-documents">
    <div><p class="jwc-kicker">상담 준비</p><h2>처음부터 모든 자료가<br>완성되어 있지 않아도 됩니다.</h2><p>이미 정리된 내용부터 공유해 주세요. 아직 결정하지 못한 부분은 질문으로 남겨 주셔도 좋습니다.</p><a class="jwc-link" href="<?php echo G5_BBS_URL; ?>/qalist.php">상담 내용 남기기<i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div>
    <ul class="jwc-document-list"><li><i data-lucide="target" aria-hidden="true"></i><div><h3>목표와 배경</h3><p>시작하게 된 이유, 해결하려는 문제, 이용할 사람을 알려 주세요.</p></div></li><li><i data-lucide="files" aria-hidden="true"></i><div><h3>현재 사용 중인 자료</h3><p>기존 사이트, 소개서, 메뉴 구조나 현장 사진이 있다면 참고할 수 있습니다.</p></div></li><li><i data-lucide="calendar" aria-hidden="true"></i><div><h3>일정과 우선순위</h3><p>희망 일정과 먼저 필요한 범위, 내부 검토 절차를 공유해 주세요.</p></div></li></ul>
</section>
<section class="jwc-section jwc-wrap jwc-consultation">
    <div><p class="jwc-kicker">자주 확인하는 내용</p><h2>협업 전에<br>궁금한 점을 확인하세요.</h2></div>
    <div class="jwc-consultation__items">
    <details open><summary>여러 사업 영역을 함께 상담할 수 있나요?</summary><p>프로젝트의 목적을 기준으로 필요한 분야를 함께 검토합니다. 예를 들어 디지털 서비스와 현장 이용 동선을 하나의 흐름으로 살펴볼 수 있습니다.</p></details>
    <details><summary>진행 범위가 아직 정해지지 않았습니다.</summary><p>현재 상황과 원하는 변화를 먼저 전달해 주세요. 목표에 필요한 범위와 추후 검토할 내용을 나누어 상담할 수 있습니다.</p></details>
    <details><summary>운영과 인계는 어떻게 확인하나요?</summary><p>사용할 담당자와 운영 환경을 함께 확인합니다. 필요한 안내 자료, 인계 범위와 이후 지원 조건은 시작 전에 협의합니다.</p></details>
    </div>
</section>
<section class="jwc-contact jwc-wrap"><div><h2>검토하신 내용을<br>이야기로 이어가세요.</h2><p>목표와 현재 상황을 남겨 주시면 상담에 도움이 됩니다.</p></div><a class="jw-control jw-control--primary" href="<?php echo G5_BBS_URL; ?>/qalist.php">프로젝트 문의<i data-lucide="arrow-right" aria-hidden="true"></i></a></section>
