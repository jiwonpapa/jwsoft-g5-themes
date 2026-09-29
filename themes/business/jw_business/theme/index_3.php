<?php
/**
 * Theme: JW-Business 1.0
 * File: index_3.php
 * Role: 결과물과 적용 장면을 보는 독립 포트폴리오 홈
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) include_once dirname(__DIR__, 2).'/common.php';
if (!defined('_INDEX_')) define('_INDEX_', true);
$g5['title'] = $config['cf_title'];
include_once G5_THEME_PATH.'/head.php';
$case_url = jw_business_escape(jw_business_page_url('business-list-3'));
$contact_url = jw_business_escape(jw_business_page_url('contact-1'));
?>
<article class="jwh jwh3" data-jw-home="3">
    <header class="jwh3-hero">
        <div class="jwh-wrap jwh3-hero__copy"><div><span class="jwh3-kicker">SELECTED WORK / 매체에 맞는 디자인</span><h1>아이디어가<br>현장에서 읽힐 때.</h1></div><div><p>이동 공간의 안내, 손에 쥐는 인쇄물, 화면 안의 경험까지. 서로 다른 매체에 맞는 결과물을 살펴보세요.</p><a href="#work-mobility">사례 내려 보기 <i data-lucide="arrow-down" aria-hidden="true"></i></a></div></div>
        <figure class="jwh3-hero__scene"><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/mobility.webp" width="1672" height="941" alt="도시 이동 시설의 큰 파란 안내 표지와 승강장·환승 방향을 보여 주는 가상 브랜드 적용 장면" fetchpriority="high"><figcaption class="jwh-wrap"><strong>CENTRAL EXCHANGE / WAYFINDING</strong><span>시연용 가상 사례 · AI 생성 이미지. 실제 고객 실적이나 성과를 뜻하지 않습니다.</span></figcaption></figure>
    </header>
    <section class="jwh3-intro jwh-wrap" aria-labelledby="jwh3-intro-title"><div><h2 id="jwh3-intro-title">같은 브랜드,<br>서로 다른 만남.</h2><p>보는 거리와 머무는 시간이 달라지면 정보의 순서도 달라집니다.</p></div><nav aria-label="매체별 사례"><a href="#work-mobility"><span>01</span><b>공간 안내</b><i data-lucide="arrow-down" aria-hidden="true"></i></a><a href="#work-print"><span>02</span><b>인쇄와 편집</b><i data-lucide="arrow-down" aria-hidden="true"></i></a><a href="#work-exhibition"><span>03</span><b>전시 그래픽</b><i data-lucide="arrow-down" aria-hidden="true"></i></a><a href="#work-digital"><span>04</span><b>디지털 경험</b><i data-lucide="arrow-down" aria-hidden="true"></i></a></nav></section>
    <section class="jwh3-case jwh3-case--mobility" id="work-mobility" aria-labelledby="jwh3-mobility-title" data-jwh3-wayfinding-scroll data-route-step="a">
        <div class="jwh-wrap jwh3-case__header"><div><span class="jwh3-kicker">01 / WAYFINDING SYSTEM</span><h2 id="jwh3-mobility-title">처음 온 사람도<br>길을 잃지 않도록.</h2></div><p>멀리에서는 방향을, 가까이에서는 장소와 편의시설을 읽습니다. 안내 데스크에서 출구·승강장·환승까지, 평면과 표지를 같은 언어로 연결합니다.</p></div>
        <div class="jwh-wrap jwh3-wayfinding-v2"><svg xmlns="http://www.w3.org/2000/svg" class="jwh3-atlas" viewBox="0 0 1080 720" role="img" aria-labelledby="map-title map-description">
  <title id="map-title">CENTRAL EXCHANGE 층별 안내 체계 시안</title>
  <desc id="map-description">중앙 안내 데스크에서 서쪽 A 출구와 시내 버스, 북쪽 B 승강장 1번과 2번, 동쪽 C 환승으로 연결되는 가상의 1층 평면. 엘리베이터, 화장실, 매표소, 대기 공간과 무단차 이동 경로가 표시되어 있습니다.</desc>
  <rect width="1080" height="720" fill="#f4f1e9"/>
  <g font-family="Arial, sans-serif" fill="#172d3b">
    <path d="M44 99h992" stroke="#172d3b" stroke-width="2"/>
    <text x="44" y="45" font-size="12" letter-spacing="2">CENTRAL EXCHANGE / WAYFINDING SYSTEM</text>
    <text x="44" y="80" font-size="28" font-weight="700">어디로 가시나요?</text><text x="720" y="77" font-size="15">1F · 중앙 홀 / CONCOURSE</text>
    <text x="45" y="129" font-size="11" letter-spacing="1">A / STREET &amp; CITY BUS</text><text x="387" y="129" font-size="11" letter-spacing="1">B / RAIL PLATFORMS</text><text x="809" y="129" font-size="11" letter-spacing="1">C / TRANSFER</text>
    <path d="M213 178h654v342H213Z" fill="#fff" stroke="#bdc6c7" stroke-width="3"/>
    <path d="M284 178v90h136v-90m-136 40h136m233-40v90h142v-90m-142 40h142" fill="#dfe4df" stroke="#a4b2b0" stroke-width="2"/>
    <g fill="#f4f1e9" stroke="#bdc6c7" stroke-width="2"><path d="M234 402h134v93H234Z"/><path d="M405 425h118v70H405Z"/><path d="M565 425h113v70H565Z"/><path d="M719 402h127v93H719Z"/></g>
    <path d="M469 153h134v129H469Z" fill="#d5e2e4" stroke="#728e96" stroke-width="2"/>
    <path d="M483 175h106m-106 13h106m-106 13h106m-106 13h106m-106 13h106m-106 13h106m-106 13h106" stroke="#728e96" stroke-width="3"/>
    <text x="350" y="211" font-size="15" text-anchor="middle">승강장 1</text><text x="723" y="211" font-size="15" text-anchor="middle">승강장 2</text>
    <text x="350" y="246" font-size="11" text-anchor="middle">시내 방면</text><text x="723" y="246" font-size="11" text-anchor="middle">공항 방면</text>
    <text x="302" y="440" font-size="15" text-anchor="middle">매표소</text><text x="302" y="462" font-size="10" text-anchor="middle">TICKETS</text>
    <text x="464" y="456" font-size="14" text-anchor="middle">대기 공간</text><text x="464" y="478" font-size="10" text-anchor="middle">WAITING</text>
    <text x="620" y="456" font-size="14" text-anchor="middle">화장실</text><text x="620" y="478" font-size="10" text-anchor="middle">WC</text>
    <text x="782" y="440" font-size="14" text-anchor="middle">엘리베이터</text><text x="782" y="463" font-size="10" text-anchor="middle">LIFT / STEP-FREE</text>
    <g fill="none" stroke="#1a5270" stroke-width="13" stroke-linecap="round"><path class="jwh3-atlas__route" data-route="a" d="M542 365H133" pathLength="1"/><path class="jwh3-atlas__route" data-route="b" d="M542 365V300" pathLength="1"/><path class="jwh3-atlas__route" data-route="c" d="M542 365h388" pathLength="1"/></g>
    <path d="m157 344-25 21 25 21m364-65 21-23 21 23m343 22 25 21-25 21" fill="none" stroke="#1a5270" stroke-width="6"/>
    <path d="M549 386h247v-102h-77" fill="none" stroke="#b66d3d" stroke-width="4" stroke-dasharray="4 7"/>
    <circle cx="542" cy="365" r="23" fill="#e29b4e" stroke="#fff" stroke-width="5"/><circle cx="542" cy="365" r="5" fill="#172d3b"/>
    <rect x="469" y="538" width="146" height="37" rx="2" fill="#172d3b"/><text x="542" y="562" font-size="14" fill="#fff" text-anchor="middle">현재 위치 / 안내 데스크</text>
    <path d="M542 394v135" stroke="#172d3b" stroke-width="1.5" stroke-dasharray="3 5"/>
    <rect x="44" y="263" width="126" height="62" fill="#172d3b"/><text x="57" y="304" fill="#fff" font-size="33" font-weight="700">← A</text><text x="45" y="413" font-size="17" font-weight="700">거리로 나가기</text><text x="45" y="436" font-size="12">출구 · 시내 버스</text><text x="45" y="456" font-size="12">무단차 출입구</text>
    <rect x="466" y="153" width="141" height="55" fill="#1a5270"/><text x="500" y="190" fill="#fff" font-size="30" font-weight="700">↑ B</text>
    <rect x="907" y="263" width="128" height="62" fill="#1a5270"/><text x="923" y="304" fill="#fff" font-size="33" font-weight="700">C →</text><text x="910" y="413" font-size="17" font-weight="700">다음 노선으로</text><text x="910" y="436" font-size="12">연결 통로 · 환승</text><text x="910" y="456" font-size="12">교통카드 이용</text>
    <path d="M44 610h992" stroke="#a4b2b0"/>
    <circle cx="53" cy="644" r="7" fill="#e29b4e"/><text x="70" y="649" font-size="12">현재 위치</text><path d="M204 644h38" stroke="#1a5270" stroke-width="5"/><text x="251" y="649" font-size="12">주요 이동</text><path d="M390 644h38" stroke="#b66d3d" stroke-width="3" stroke-dasharray="4 5"/><text x="440" y="649" font-size="12">무단차 이동</text>
    <text x="717" y="649" font-size="11">색 + 문자 + 방향을 함께 표시합니다.</text>
    <text x="44" y="687" font-size="10" fill="#566e77">FICTIONAL DESIGN STUDY · 실제 시설의 안내도로 사용하지 않습니다.</text><text x="910" y="687" font-size="10">JW SOFT / 2026</text>
  </g>
</svg>
</div>
        <div class="jwh-wrap jwh3-route-guide" aria-label="안내 지도에서 목적지 확인"><button type="button" data-jwh3-route="a" aria-pressed="true"><span class="jwh3-route-guide__sign"><i data-lucide="arrow-left" aria-hidden="true"></i><b>A</b></span><span><strong>거리로 나가기</strong><small>출구 · 시내 버스 · 무단차 출입구</small></span></button><button type="button" data-jwh3-route="b" aria-pressed="false"><span class="jwh3-route-guide__sign"><i data-lucide="arrow-up" aria-hidden="true"></i><b>B</b></span><span><strong>승강장 찾기</strong><small>1번 시내 방면 · 2번 공항 방면</small></span></button><button type="button" data-jwh3-route="c" aria-pressed="false"><span class="jwh3-route-guide__sign"><b>C</b><i data-lucide="arrow-right" aria-hidden="true"></i></span><span><strong>다음 노선으로</strong><small>연결 통로 · 환승 안내</small></span></button></div>
        <div class="jwh-wrap jwh3-case__meta"><span>색에만 의존하지 않고 문자·방향·시설명을 함께 표시한 시안입니다.</span><a href="<?php echo $case_url; ?>">관련 분야 보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div>
    </section>
    <section class="jwh3-case jwh3-case--print jwh-wrap" id="work-print" aria-labelledby="jwh3-print-title"><figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/print.webp" width="1536" height="1024" alt="테라코타색 조각 사진과 파란 그래픽, 위치 정보가 편집된 문화 공간 브로슈어와 안내 카드" loading="lazy"><figcaption>FIELDNOTE / 인쇄물 콘셉트</figcaption></figure><div><span class="jwh3-kicker">02 / EDITORIAL SYSTEM</span><h2 id="jwh3-print-title">브랜드를<br>손에 쥐는 순간.</h2><p>표지에서는 장소의 인상을, 안쪽에서는 행사와 이동 정보를 전합니다. 작은 안내 카드까지 같은 색과 편집 기준을 이어갑니다.</p><dl class="jwh3-print-notes"><div><dt>먼저 보이는 것</dt><dd>장소의 인상을 담는 사진과 색</dd></div><div><dt>가까이 읽는 것</dt><dd>일정 · 위치 · 짧은 작품 이야기</dd></div><div><dt>다시 찾는 것</dt><dd>섹션 번호와 정보의 고정 위치</dd></div></dl></div></section>
    <section class="jwh3-exhibition jwh-wrap" id="work-exhibition" aria-labelledby="jwh3-exhibition-title"><div><div><span class="jwh3-kicker">03 / EXHIBITION GRAPHICS</span><h2 id="jwh3-exhibition-title">그래픽이 공간을<br>만나는 순간.</h2></div><p>평면의 원과 선이 빛, 재료, 사람의 크기를 만납니다. 앞에서 보던 그래픽을 지나가며 경험하는 전시 콘셉트입니다.</p></div><figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/exhibition.webp" width="1536" height="1024" alt="푸른 반투명 패널과 흰 원형 그래픽, 테라코타색 원을 실제 크기의 공간 설치로 표현한 가상 전시" loading="lazy"><figcaption><strong>빛의 구조 / Structure of Light</strong><span>반투명 패널 · 전시 그래픽 · 공간 적용 시연</span></figcaption></figure></section>
    <section class="jwh3-digital" id="work-digital" aria-labelledby="jwh3-digital-title"><div class="jwh-wrap jwh3-digital__grid"><div><span class="jwh3-kicker">04 / DIGITAL EXPERIENCE</span><h2 id="jwh3-digital-title">발견에서 선택까지,<br>흐름이 있는 화면.</h2><p>분위기를 전하는 대표 장면 뒤에 날짜·장소·유형을 붙입니다. 무엇을 볼지 고르는 데 필요한 정보를 같은 화면에서 읽도록 설계했습니다.</p><a href="<?php echo $case_url; ?>">디지털 분야 살펴보기 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a><dl class="jwh3-digital-notes"><div><dt>장면</dt><dd>프로그램의 성격을 보여주는 사진</dd></div><div><dt>조건</dt><dd>날짜 · 장소 · 전시와 대화의 구분</dd></div><div><dt>다음</dt><dd>관람 준비에 필요한 안내</dd></div></dl></div><div class="jwh3-screen" role="img" aria-label="FIELDNOTE 가상 문화 프로그램 웹 디자인. 가을 대표 사진, 프로그램의 날짜·유형·장소·시간을 나란히 보여 줍니다."><div class="jwh3-screen__top"><strong>FIELDNOTE<span>®</span></strong><span>프로그램　공간　이야기</span><b>MENU +</b></div><div class="jwh3-screen__feature"><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/fieldnote-program.webp" width="1536" height="1024" alt="남색 천과 따뜻한 원형 빛, 관람객 실루엣이 있는 FIELDNOTE의 독립 문화 프로그램 장면" loading="lazy"><small>2026 / AUTUMN PROGRAMME</small><strong>새로운 장면을<br>만나는 계절</strong><span>전시와 대화, 작은 배움의 시간</span></div><div class="jwh3-screen__programme"><div class="jwh3-screen__filters"><b>이달의 프로그램</b><span>전체　전시　대화　워크숍</span></div><div class="jwh3-screen__event"><time>10.03<br><span>— 11.15</span></time><div><small>EXHIBITION</small><strong>빛의 구조</strong><span>갤러리 A · 화–일 10:00–18:00</span></div><i data-lucide="arrow-up-right" aria-hidden="true"></i></div><div class="jwh3-screen__event"><time>10.17<br><span>SAT</span></time><div><small>TALK</small><strong>도시의 감각을 기록하다</strong><span>열린 홀 · 14:00–15:30</span></div><i data-lucide="arrow-up-right" aria-hidden="true"></i></div><div class="jwh3-screen__event"><time>10.24<br><span>SAT</span></time><div><small>WORKSHOP</small><strong>재료의 시간을 만지는 일</strong><span>스튜디오 · 11:00–13:00</span></div><i data-lucide="arrow-up-right" aria-hidden="true"></i></div></div><div class="jwh3-screen__disclosure">FIELDNOTE / 가상 문화 프로그램의 화면 디자인 시안</div></div></div></section>
    <section class="jwh3-index" aria-labelledby="jwh3-index-title"><div class="jwh-wrap"><div class="jwh3-index__heading"><div><span class="jwh3-kicker">DESIGN ACROSS FORMATS</span><h2 id="jwh3-index-title">매체마다 달라지는<br>읽는 거리와 밀도.</h2></div><p>멀리서 알아보는 사인, 넘겨 읽는 지면, 선택을 돕는 화면. 같은 메시지를 그대로 늘리지 않고 사용하는 순간에 맞춰 편집합니다.</p></div><div class="jwh3-editorial-board"><figure><img src="<?php echo G5_THEME_URL; ?>/assets/home-three/correction/fieldnote-editorial.webp" width="1536" height="1024" alt="건축 사진, 두 단 본문, 인용문과 작품 캡션, 행사 일정과 위치 지도를 갖춘 완성 FIELDNOTE 문화 잡지와 접지 안내서" loading="lazy"><figcaption>FIELDNOTE / 완성 지면과 접지 프로그램 가이드</figcaption></figure><div class="jwh3-format-spec"><article><span>SPACE / 이동 중</span><h3>한눈에 읽는 정보</h3><p>방향 → 목적지 → 편의시설의 순서. 거리에서 알아보는 문자와 화살표를 먼저 둡니다.</p><div class="jwh3-format-spec__sign"><i data-lucide="arrow-up" aria-hidden="true"></i><b>승강장 1·2<small>Platforms / 시내·공항 방면</small></b><span>B</span></div></article><article><span>PRINT / 머무는 동안</span><h3>넘기며 발견하는 이야기</h3><p>큰 사진 뒤에 두 단 본문, 인용문, 작품 캡션을 배치합니다. 일정과 위치는 작은 가이드로 분리합니다.</p><dl><div><dt>본문</dt><dd>두 단 편집 · 명확한 인용 위계</dd></div><div><dt>안내</dt><dd>날짜 · 장소 · 지도</dd></div></dl></article><article><span>DIGITAL / 다음 선택</span><h3>조건을 비교하는 흐름</h3><p>사진에서 관심을 찾고, 일정과 장소로 범위를 좁힙니다. 화면 크기가 달라도 읽는 순서를 유지합니다.</p><dl><div><dt>먼저</dt><dd>주제와 프로그램 유형</dd></div><div><dt>다음</dt><dd>시간 · 장소 · 관람 안내</dd></div></dl></article></div></div></div></section>
    <section class="jwh3-close" aria-labelledby="jwh3-close-title"><div class="jwh-wrap jwh3-close__layout"><div><span class="jwh3-kicker">YOUR NEXT PROJECT</span><h2 id="jwh3-close-title">다음 결과물은<br>어떤 모습이어야 할까요?</h2><p>공간과 종이, 화면에 필요한 역할부터 함께 정리합니다.</p><a class="jw-control jw-control--primary" href="<?php echo $contact_url; ?>">프로젝트 문의 안내 <i data-lucide="arrow-up-right" aria-hidden="true"></i></a></div><aside><span>시작할 때 나누면 좋은 이야기</span><ol><li><b>만나는 사람</b><p>누가, 어느 순간에 이 결과물을 만나나요?</p></li><li><b>쓰이는 매체</b><p>공간·인쇄·화면 중 어디에서 시작하나요?</p></li><li><b>준비된 자료</b><p>브랜드 자료와 원하는 일정이 있나요?</p></li></ol><small>정리된 제안서가 없어도 현재 상황을 알려 주세요.</small></aside></div></section>
</article>
<?php include_once G5_THEME_PATH.'/tail.php'; ?>
