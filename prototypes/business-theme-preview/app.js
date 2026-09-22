const screen = new URLSearchParams(location.search).get('screen') || 'home';

const icon = (name, size = 20) => {
  const paths = {
    arrow: '<path d="M5 12h14M13 6l6 6-6 6"/>',
    chevron: '<path d="m9 18 6-6-6-6"/>',
    down: '<path d="m6 9 6 6 6-6"/>',
    search: '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>',
    user: '<circle cx="12" cy="8" r="4"/><path d="M4.5 20c.8-4 3.1-6 7.5-6s6.7 2 7.5 6"/>',
    menu: '<path d="M4 7h16M4 12h16M4 17h16"/>',
    calendar: '<rect x="3" y="5" width="18" height="16" rx="1"/><path d="M7 3v4M17 3v4M3 10h18"/>',
    eye: '<path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/>',
    comment: '<path d="M5 18.5 3 21l.7-4A8.5 8.5 0 1 1 7 20"/>',
    clip: '<path d="m20.5 11.5-8.4 8.4a6 6 0 0 1-8.5-8.5l9.2-9.2a4 4 0 1 1 5.7 5.7l-9.2 9.2a2 2 0 0 1-2.8-2.8l8.4-8.4"/>',
    link: '<path d="M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1l-1.1 1.1M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1.1-1.1"/>',
    upload: '<path d="M12 16V4M7 9l5-5 5 5M5 20h14"/>',
    check: '<path d="m5 12 4 4L19 6"/>',
    lock: '<rect x="4" y="10" width="16" height="11" rx="1"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
    info: '<circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7h.01"/>',
    reply: '<path d="m9 17-5-5 5-5M4 12h9a7 7 0 0 1 7 7"/>',
    bold: '<path d="M7 5h6a3.5 3.5 0 0 1 0 7H7zM7 12h7a3.5 3.5 0 0 1 0 7H7z"/>',
    image: '<rect x="3" y="4" width="18" height="16" rx="1"/><circle cx="8.5" cy="9" r="1.5"/><path d="m3 17 5-5 4 4 3-3 6 6"/>',
    quote: '<path d="M5 11h5v7H4v-5c0-4 2-7 6-8M15 11h5v7h-6v-5c0-4 2-7 6-8"/>',
    list: '<path d="M9 6h11M9 12h11M9 18h11M4 6h.01M4 12h.01M4 18h.01"/>'
  };
  return `<svg class="icon" aria-hidden="true" width="${size}" height="${size}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">${paths[name] || ''}</svg>`;
};

const header = () => `
  <header class="site-header">
    <div class="header-inner">
      <a class="brand" href="?screen=home" aria-label="JW FOLIO 홈">
        <span class="brand-mark"><i></i><i></i><i></i></span>
        <span class="brand-name">JW FOLIO</span>
        <small>CORPORATE SYSTEM</small>
      </a>
      <nav class="global-nav" aria-label="주요 메뉴">
        <a href="#">회사소개</a><a href="#">사업영역</a><a href="#">프로젝트</a>
        <a class="${['list','view','write'].includes(screen) ? 'is-current' : ''}" href="?screen=list">인사이트</a><a href="#">채용</a>
      </nav>
      <div class="header-actions">
        <button class="icon-button" aria-label="검색">${icon('search')}</button>
        <a class="inquiry-link" href="#">문의하기 ${icon('arrow',18)}</a>
        <button class="menu-button" aria-label="전체 메뉴">${icon('menu')}</button>
      </div>
    </div>
  </header>`;

const footer = () => `
  <footer class="site-footer">
    <div class="footer-grid">
      <div><strong class="footer-logo">JW FOLIO</strong><p>명확한 기준으로 더 나은 일을 만듭니다.</p></div>
      <div><b>CONTACT</b><p>02 1234 5678<br>hello@jwfolio.co.kr</p></div>
      <div><b>OFFICE</b><p>서울특별시 성동구 성수이로 00<br>월–금 09:00–18:00</p></div>
      <div class="footer-links"><a href="#">개인정보처리방침</a><a href="#">이용약관</a><span>© 2026 JW FOLIO</span></div>
    </div>
  </footer>`;

const crumbs = (current) => `<div class="crumbs"><a href="?screen=home">HOME</a>${icon('chevron',13)}<span>${current}</span></div>`;

const pageHead = (eyebrow, title, desc = '') => `
  <section class="page-head">
    ${crumbs(title)}
    <p class="eyebrow">${eyebrow}</p>
    <h1>${title}</h1>
    ${desc ? `<p class="page-description">${desc}</p>` : ''}
  </section>`;

const button = (label, kind = 'primary', arrow = false) => `<button class="button button-${kind}">${label}${arrow ? icon('arrow',18) : ''}</button>`;

const home = () => `
  <main id="content">
    <section class="hero">
      <img src="./assets/hero.webp" alt="한 팀이 건축 모형을 중심으로 프로젝트를 검토하는 모습">
      <div class="hero-shade"></div>
      <div class="hero-copy">
        <p class="hero-index">JW FOLIO / CORPORATE EDITION 01</p>
        <h1>복잡한 일을<br>선명한 기준으로.</h1>
        <p>기술과 공간, 사람을 연결해 오래 작동하는 비즈니스의 기반을 설계합니다.</p>
        <div class="button-row">${button('프로젝트 보기','light',true)}${button('회사 소개','ghost-light',true)}</div>
      </div>
      <div class="hero-facts"><span><b>18</b> YEARS</span><span><b>126</b> PROJECTS</span><span><b>09</b> SECTORS</span></div>
      <a class="scroll-cue" href="#statement"><span>SCROLL</span><i></i></a>
    </section>

    <section class="statement section" id="statement">
      <div class="section-tag"><span>01</span> WHO WE ARE</div>
      <div class="statement-copy">
        <p class="lead">우리는 보기 좋은 결과보다<br><em>오래 작동하는 기준</em>을 만듭니다.</p>
        <div><p>JW FOLIO는 전략, 설계, 실행을 하나의 흐름으로 연결합니다. 현장의 언어와 사용자의 경험을 함께 읽고, 복잡한 요구를 누구나 이해할 수 있는 구조로 정리합니다.</p><a class="text-link" href="#">우리의 방식 ${icon('arrow',18)}</a></div>
      </div>
    </section>

    <section class="project-feature section">
      <div class="feature-media"><img src="./assets/project.webp" alt="현대적인 기업 공간을 걷는 구성원들"><span class="image-no">01 / 04</span></div>
      <div class="feature-copy">
        <div class="section-tag"><span>02</span> SELECTED PROJECT</div>
        <p class="project-meta">WORKPLACE · 2026</p>
        <h2>일하는 방식이<br>공간의 기준이 되도록</h2>
        <p>분산된 조직의 동선을 다시 연결하고, 집중과 협업이 자연스럽게 전환되는 업무 환경을 설계했습니다.</p>
        <dl><div><dt>CLIENT</dt><dd>NEO LABS</dd></div><div><dt>SCOPE</dt><dd>STRATEGY · DESIGN · DELIVERY</dd></div><div><dt>AREA</dt><dd>4,820㎡</dd></div></dl>
        <a class="round-link" href="#" aria-label="프로젝트 자세히 보기">${icon('arrow',24)}</a>
      </div>
    </section>

    <section class="capabilities section">
      <div class="section-tag"><span>03</span> CAPABILITIES</div>
      <div class="capability-list">
        <a href="#"><span>01</span><h3>전략과 리서치</h3><p>조직과 시장의 문제를 실행 가능한 기준으로 정의합니다.</p>${icon('arrow',22)}</a>
        <a href="#"><span>02</span><h3>브랜드와 경험</h3><p>브랜드가 고객과 만나는 모든 접점을 일관되게 설계합니다.</p>${icon('arrow',22)}</a>
        <a href="#"><span>03</span><h3>공간과 환경</h3><p>운영의 효율과 사람의 경험을 함께 담는 환경을 만듭니다.</p>${icon('arrow',22)}</a>
        <a href="#"><span>04</span><h3>구축과 운영</h3><p>기획의 의도가 실제 현장에서 지속되도록 끝까지 관리합니다.</p>${icon('arrow',22)}</a>
      </div>
    </section>

    <section class="insight-home section">
      <div class="section-heading"><div class="section-tag"><span>04</span> INSIGHTS</div><h2>지금, 우리가<br>살펴보는 변화</h2><a class="text-link" href="?screen=list">전체 인사이트 ${icon('arrow',18)}</a></div>
      <div class="home-articles">
        <a href="?screen=view"><span>WORK & CULTURE</span><h3>좋은 업무 공간을 결정하는 것은 면적이 아니라 전환의 속도입니다</h3><time>2026.09.18</time>${icon('arrow',20)}</a>
        <a href="#"><span>TECHNOLOGY</span><h3>도구가 많아질수록 조직에 단순한 운영 원칙이 필요한 이유</h3><time>2026.09.02</time>${icon('arrow',20)}</a>
        <a href="#"><span>FIELD NOTE</span><h3>현장의 질문을 설계 기준으로 바꾸는 세 가지 관찰법</h3><time>2026.08.21</time>${icon('arrow',20)}</a>
      </div>
    </section>

    <section class="cta-band"><p>새로운 기준이 필요한 프로젝트가 있으신가요?</p><h2>함께 답을 찾아보겠습니다.</h2>${button('프로젝트 문의','light',true)}</section>
  </main>`;

const list = () => `
  <main id="content" class="content-shell">
    ${pageHead('THINKING & FIELD NOTES','인사이트','현장에서 발견한 질문과 더 나은 일의 기준을 공유합니다.')}
    <section class="board-tools">
      <div class="category-tabs" role="tablist"><button class="active">전체 <span>48</span></button><button>프로젝트 <span>16</span></button><button>워크 & 컬처 <span>12</span></button><button>기술 <span>11</span></button><button>필드노트 <span>9</span></button></div>
      <label class="search-field"><span class="sr-only">게시물 검색</span><input type="search" placeholder="검색어를 입력하세요">${icon('search',20)}</label>
    </section>
    <section class="featured-article">
      <a class="featured-image" href="?screen=view"><img src="./assets/project.webp" alt="밝은 아트리움과 업무 공간"></a>
      <div><p class="article-type">FEATURED · WORK & CULTURE</p><h2><a href="?screen=view">좋은 업무 공간을 결정하는 것은<br>면적이 아니라 전환의 속도입니다</a></h2><p>집중, 협업, 회복이 자연스럽게 이어지는 환경은 어떻게 만들어질까요. 네 번의 리서치와 현장 관찰에서 발견한 기준을 정리했습니다.</p><div class="article-meta"><time>2026.09.18</time><span>${icon('eye',16)} 384</span><span>${icon('comment',16)} 3</span></div><a class="text-link" href="?screen=view">글 읽기 ${icon('arrow',18)}</a></div>
    </section>
    <section class="board-list" aria-label="게시물 목록">
      <div class="list-head"><span>번호</span><span>분류</span><span>제목</span><span>작성일</span><span>조회</span></div>
      <a class="board-row notice" href="#"><span><b>공지</b></span><span>NOTICE</span><strong>JW FOLIO 인사이트 운영 안내</strong><time>2026.09.19</time><em>126</em></a>
      <a class="board-row" href="?screen=view"><span>48</span><span>WORK & CULTURE</span><strong>좋은 업무 공간을 결정하는 것은 면적이 아니라 전환의 속도입니다 <small>3</small></strong><time>2026.09.18</time><em>384</em></a>
      <a class="board-row" href="#"><span>47</span><span>TECHNOLOGY</span><strong>도구가 많아질수록 조직에 단순한 운영 원칙이 필요한 이유</strong><time>2026.09.02</time><em>291</em></a>
      <a class="board-row" href="#"><span>46</span><span>FIELD NOTE</span><strong>현장의 질문을 설계 기준으로 바꾸는 세 가지 관찰법 <small>1</small></strong><time>2026.08.21</time><em>205</em></a>
      <a class="board-row" href="#"><span>45</span><span>PROJECT</span><strong>네오랩스 통합 오피스 구축 프로젝트 기록</strong><time>2026.08.09</time><em>452</em></a>
      <a class="board-row" href="#"><span>44</span><span>WORK & CULTURE</span><strong>팀의 집중을 돕는 공간 운영 원칙 일곱 가지</strong><time>2026.07.28</time><em>173</em></a>
      <a class="board-row" href="#"><span>43</span><span>TECHNOLOGY</span><strong>복잡한 업무 흐름을 한 장의 지도로 정리하는 방법</strong><time>2026.07.11</time><em>318</em></a>
    </section>
    <div class="board-bottom"><div></div><nav class="pagination" aria-label="페이지"><button aria-label="이전 페이지">‹</button><button class="active">1</button><button>2</button><button>3</button><button>4</button><button>5</button><button aria-label="다음 페이지">›</button></nav>${button('글쓰기','primary',false)}</div>
  </main>`;

const detail = () => `
  <main id="content" class="article-shell">
    ${crumbs('인사이트')}
    <article>
      <header class="article-header"><p class="article-type">WORK & CULTURE</p><h1>좋은 업무 공간을 결정하는 것은<br>면적이 아니라 전환의 속도입니다</h1><p class="article-deck">집중, 협업, 회복이 자연스럽게 이어지는 환경은 어떻게 만들어질까요.</p><div class="byline"><div class="avatar">JW</div><div><b>JW FOLIO 편집팀</b><span>2026.09.18 · 읽는 시간 6분</span></div><div class="view-count">${icon('eye',17)} 384</div></div></header>
      <div class="article-hero"><img src="./assets/project.webp" alt="밝은 아트리움과 연결된 업무 공간"><p>NEO LABS 통합 오피스, 서울 · 2026</p></div>
      <div class="article-body">
        <p class="article-lead">좋은 업무 공간은 넓은 공간이 아닙니다. 서로 다른 일의 상태를 방해 없이 오갈 수 있는 공간입니다.</p>
        <p>최근의 업무는 한 자리에서 끝나지 않습니다. 개인의 깊은 집중, 빠른 의견 교환, 온라인 회의, 잠깐의 회복이 하루에도 여러 번 교차합니다. 그런데 공간이 이 변화를 따라가지 못하면 구성원은 장소를 찾고 준비하는 데 더 많은 에너지를 씁니다.</p>
        <h2>공간의 크기보다 중요한 세 가지 전환</h2>
        <p>우리는 프로젝트 초기에 좌석 수부터 계산하지 않습니다. 하루 동안 어떤 일이 얼마나 자주 바뀌는지 먼저 관찰합니다. 그 결과를 바탕으로 세 가지 전환을 설계의 기준으로 삼았습니다.</p>
        <ol class="key-points"><li><span>01</span><div><b>집중에서 협업으로</b><p>개인의 몰입을 끊지 않으면서 짧은 논의를 바로 시작할 수 있어야 합니다.</p></div></li><li><span>02</span><div><b>온라인에서 오프라인으로</b><p>회의 방식이 바뀌어도 음성과 화면의 품질이 일정하게 유지되어야 합니다.</p></div></li><li><span>03</span><div><b>업무에서 회복으로</b><p>긴 이동 없이 잠시 호흡을 바꾸고 다시 일로 돌아올 수 있어야 합니다.</p></div></li></ol>
        <blockquote>공간은 사람에게 행동을 요구하기보다, 필요한 행동이 자연스럽게 일어나도록 도와야 합니다.</blockquote>
        <p>완성 후 세 달 동안 이용 패턴을 다시 관찰했습니다. 협업 공간의 회전율은 높아졌고 예약 없이 사용할 수 있는 짧은 대화 공간이 가장 자주 선택되었습니다. 설계의 가치는 완성 사진보다 실제 사용에서 확인됩니다.</p>
        <div class="tags"><a href="#">#업무공간</a><a href="#">#조직문화</a><a href="#">#공간전략</a></div>
      </div>
    </article>
    <nav class="article-nav"><a href="#"><span>이전 글</span><b>현장의 질문을 설계 기준으로 바꾸는 세 가지 관찰법</b></a><a href="#"><span>다음 글</span><b>도구가 많아질수록 단순한 운영 원칙이 필요한 이유</b></a></nav>
    <section class="comments"><div class="comments-head"><h2>댓글 <em>3</em></h2><p>의견을 나누어 주세요.</p></div>
      <div class="comment"><div class="avatar cobalt">MK</div><div class="comment-main"><div><b>김민경</b><time>2026.09.19 10:24</time></div><p>규모보다 전환을 먼저 본다는 관점이 인상적입니다. 저희 팀의 공간을 점검할 때도 세 가지 기준을 활용해 보겠습니다.</p><button>${icon('reply',16)} 답글</button></div></div>
      <div class="comment reply"><div class="avatar">JW</div><div class="comment-main"><div><b>JW FOLIO 편집팀 <small>작성자</small></b><time>2026.09.19 13:08</time></div><p>읽어주셔서 감사합니다. 실제 점검에서는 각 전환에 걸리는 시간과 방해 요소를 함께 기록하면 우선순위를 정하기 좋습니다.</p><button>${icon('reply',16)} 답글</button></div></div>
      <div class="comment"><div class="avatar sand">SH</div><div class="comment-main"><div><b>박성호</b><time>2026.09.20 09:42</time></div><p>완성 후 실제 이용 패턴을 다시 확인했다는 부분이 좋네요. 후속 측정 방식도 다음 글에서 다뤄주시면 좋겠습니다.</p><button>${icon('reply',16)} 답글</button></div></div>
      <form class="comment-form"><div><label for="comment">댓글 작성</label><span>0 / 1,000</span></div><textarea id="comment" placeholder="서로를 존중하는 의견을 남겨주세요."></textarea><div><label class="check-label"><input type="checkbox"><span></span>비밀글</label>${button('댓글 등록','primary')}</div></form>
    </section>
  </main>`;

const field = (label, id, placeholder, help = '', required = false, type = 'text') => {
  const autocomplete = ({'user-id':'username','password':'new-password','password-confirm':'new-password','name':'name','nickname':'nickname','email':'email','phone':'tel'})[id] || 'off';
  return `<div class="form-field"><label for="${id}">${label}${required ? '<em>필수</em>' : ''}</label><input id="${id}" type="${type}" autocomplete="${autocomplete}" placeholder="${placeholder}">${help ? `<p>${icon('info',15)}${help}</p>` : ''}</div>`;
};

const editor = () => `<div class="editor"><div class="editor-toolbar"><button aria-label="굵게">${icon('bold')}</button><select aria-label="문단 스타일"><option>본문</option></select><button aria-label="목록">${icon('list')}</button><button aria-label="인용">${icon('quote')}</button><button aria-label="이미지">${icon('image')}</button><button aria-label="링크">${icon('link')}</button></div><textarea aria-label="내용" placeholder="내용을 입력하세요.&#10;&#10;읽는 사람이 이해하기 쉽도록 문단을 나누어 작성해 주세요."></textarea><div class="editor-status"><span>0자</span><span>임시저장 없음</span></div></div>`;

const write = () => `
  <main id="content" class="form-shell">
    ${pageHead('INSIGHT BOARD','글쓰기','인사이트 게시판에 새로운 글을 작성합니다.')}
    <section class="form-card">
      <div class="form-intro"><h2>게시물 정보</h2><p><em>*</em> 표시는 필수 입력 항목입니다.</p></div>
      <form>
        <div class="form-grid compact"><div class="form-field"><label for="category">분류<em>필수</em></label><select id="category"><option>분류를 선택하세요</option><option>프로젝트</option><option>워크 & 컬처</option><option>기술</option><option>필드노트</option></select></div><div class="form-field"><label>게시 옵션</label><div class="inline-checks"><label class="check-label"><input type="checkbox"><span></span>공지</label><label class="check-label"><input type="checkbox"><span></span>비밀글</label><label class="check-label"><input type="checkbox"><span></span>답변메일 받기</label></div></div></div>
        ${field('제목','subject','제목을 입력하세요','검색과 목록에서 내용을 분명히 알 수 있는 제목을 권장합니다.',true)}
        <div class="form-field"><label>내용<em>필수</em></label>${editor()}</div>
        <div class="form-field"><label>파일 첨부</label><div class="upload-zone">${icon('upload',25)}<div><b>파일을 끌어 놓거나 선택하세요</b><p>이미지·문서 파일, 파일당 최대 20MB · 최대 5개</p></div><button type="button" class="button button-outline">파일 선택</button></div><div class="file-row"><span>${icon('clip',17)}workplace-plan.pdf <small>2.4MB</small></span><button type="button" aria-label="첨부 파일 삭제">×</button></div></div>
        <div class="form-grid">${field('링크 1','link1','https://', '', false, 'url')}${field('링크 2','link2','https://', '', false, 'url')}</div>
        <div class="form-field"><label for="captcha">자동등록방지<em>필수</em></label><div class="captcha-row"><div class="captcha">7 · 4 · K · 2</div><input id="captcha" type="text" placeholder="왼쪽 문자를 입력하세요"><button class="button button-outline" type="button">새로고침</button></div></div>
        <div class="form-actions"><button type="button" class="button button-quiet">취소</button><button type="button" class="button button-outline">임시저장</button>${button('게시물 등록','primary',true)}</div>
      </form>
    </section>
  </main>`;

const register = () => `
  <main id="content" class="register-shell">
    <div class="register-head">${crumbs('회원가입')}<p class="eyebrow">CREATE YOUR ACCOUNT</p><h1>회원가입</h1><p>필수 정보를 입력하고 JW FOLIO의 새로운 소식을 받아보세요.</p></div>
    <ol class="steps"><li class="done"><span>${icon('check',16)}</span><div><b>01</b><p>약관 동의</p></div></li><li class="active"><span>02</span><div><b>02</b><p>정보 입력</p></div></li><li><span>03</span><div><b>03</b><p>가입 완료</p></div></li></ol>
    <section class="register-card"><div class="form-intro"><h2>기본 정보</h2><p><em>*</em> 표시는 필수 입력 항목입니다.</p></div><form>
      <div class="id-row">${field('아이디','user-id','영문 소문자와 숫자 4–20자','가입 후에는 변경할 수 없습니다.',true)}<button type="button" class="button button-outline">중복 확인</button></div>
      <div class="form-grid">${field('비밀번호','password','영문·숫자·특수문자 8자 이상','안전한 비밀번호를 사용해 주세요.',true,'password')}${field('비밀번호 확인','password-confirm','비밀번호를 한 번 더 입력하세요','',true,'password')}</div>
      <div class="password-strength"><span></span><span></span><span></span><span></span><p>${icon('lock',15)} 비밀번호 안전도</p></div>
      <div class="form-grid">${field('이름','name','실명을 입력하세요','',true)}${field('닉네임','nickname','게시판에 표시할 이름','공백 없이 한글·영문·숫자 2–12자',true)}</div>
      <div class="form-grid">${field('이메일','email','name@example.com','계정 확인과 중요 알림에 사용합니다.',true,'email')}${field('휴대전화','phone','010-0000-0000','하이픈 없이 입력해도 됩니다.',true,'tel')}</div>
      <div class="address-field"><label>주소</label><div><input type="text" placeholder="우편번호" aria-label="우편번호"><button type="button" class="button button-outline">주소 검색</button></div><input type="text" placeholder="기본 주소" aria-label="기본 주소"><input type="text" placeholder="상세 주소를 입력하세요" aria-label="상세 주소"></div>
      <fieldset class="preferences"><legend>정보 수신</legend><label class="check-label"><input type="checkbox" checked><span></span><div><b>이메일로 새 소식 받기</b><p>프로젝트 소식과 새로운 인사이트를 월 1–2회 보내드립니다. 선택 동의입니다.</p></div></label><label class="check-label"><input type="checkbox"><span></span><div><b>SMS 알림 받기</b><p>중요한 서비스 안내와 이벤트 소식을 받습니다. 선택 동의입니다.</p></div></label></fieldset>
      <div class="form-field"><label for="register-captcha">자동등록방지<em>필수</em></label><div class="captcha-row"><div class="captcha">P · 8 · 3 · M</div><input id="register-captcha" type="text" placeholder="왼쪽 문자를 입력하세요"><button class="button button-outline" type="button">새로고침</button></div></div>
      <div class="register-actions"><p>가입 버튼을 누르면 <a href="#">이용약관</a>과 <a href="#">개인정보처리방침</a>에 동의한 것으로 봅니다.</p>${button('회원가입 완료','primary',true)}</div>
    </form></section>
    <p class="login-prompt">이미 계정이 있으신가요? <a href="#">로그인</a></p>
  </main>`;

const pages = { home, list, view: detail, write, register };
document.getElementById('app').innerHTML = `${header()}${(pages[screen] || home)()}${footer()}`;
document.body.dataset.screen = screen;
