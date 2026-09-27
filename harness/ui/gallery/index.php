<?php
/**
 * Developer-only G5 section comparison gallery. Never part of a sale ZIP.
 * Author: JW SOFT. Copyright (c) JW SOFT. License: repository development tools license.
 */
if (!is_file(__DIR__ . '/.enabled')) { http_response_code(404); exit; }
include_once dirname(__DIR__) . '/common.php';
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');
?>
<!doctype html><html lang="ko" data-theme="jw-light"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>블록 검토실 · JW Business</title><link rel="stylesheet" href="/theme/jw_business/css/jw-business.min.css"><link rel="stylesheet" href="gallery.css"></head>
<body><header class="gallery-header"><div><h1>블록 검토실</h1><p>실제 G5 화면과 참고 자료를 비교하고 원본을 가져옵니다.</p></div><span>개발 도구 · 상품 미포함</span></header>
<main class="gallery-layout"><aside><label for="page-select">메인 템플릿</label><select id="page-select"></select><h2>섹션</h2><nav id="sections" aria-label="섹션 선택"></nav></aside>
<div class="gallery-workspace"><div class="gallery-controls"><label>화면<select id="device"><option value="1440">PC 1440</option><option value="390">모바일 390</option></select></label><label>색상<select id="mode"><option value="jw-light">라이트</option><option value="jw-dark">다크</option></select></label><a id="open-page" target="_blank" rel="noopener">실제 페이지 열기 <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 7h10v10M7 17 17 7"/></svg></a></div>
<h2 id="section-title">불러오는 중</h2><p id="purpose"></p><div class="gallery-panes"><section><h3>현재 구현 <span id="scale"></span></h3><div class="live-viewport"><iframe id="live" title="실제 G5 페이지 미리보기"></iframe></div></section><section><h3>이전 검토 화면</h3><div class="reference-viewport" tabindex="0" role="region" aria-label="이전 화면 스크롤 비교"><img id="reference" alt="이전 검토 당시 전체 페이지"><p id="reference-empty">등록된 참고 이미지가 없습니다.<br>현재 구현을 승인 기준으로 자동 등록하지 않습니다.</p></div><p id="reference-note">참고용 캡처이며 사용자 최종 승인을 뜻하지 않습니다.</p></section></div>
<details class="source-panel"><summary>PHP 원본 및 사용 조건</summary><p id="dependencies"></p><p id="source-path"></p><button id="copy" type="button">PHP 복사</button><span id="copy-state" role="status"></span><pre tabindex="0" aria-label="복사용 PHP 원본"><code id="source"></code></pre></details><p id="status" role="status"></p></div></main><script type="module" src="gallery.js"></script></body></html>
