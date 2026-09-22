#!/usr/bin/env python3
"""Explicitly opt-in dev-site write test; no CAPTCHA bypass and no site config changes."""
import argparse, http.cookiejar, html, json, os, re, ssl, urllib.parse, urllib.request, uuid
from html.parser import HTMLParser

class Forms(HTMLParser):
    def __init__(self, source):
        super().__init__(convert_charrefs=True)
        self.forms = {}; self.current = None; self.select = None
        self.feed(source)
    def handle_starttag(self, tag, attrs):
        a = dict(attrs)
        if tag == 'form':
            self.current = {'action': a.get('action', ''), 'values': {}}
            self.forms[a.get('name', a.get('id', ''))] = self.current
        elif self.current is not None:
            values = self.current['values']
            if tag == 'input' and a.get('name') and a.get('type', '') not in ('file', 'submit', 'button'):
                if a.get('type') not in ('checkbox','radio') or 'checked' in a:
                    values[a['name']] = a.get('value','')
            if tag == 'select': self.select = a.get('name')
            if tag == 'option' and self.select and a.get('value'):
                if 'selected' in a or self.select not in values: values[self.select] = a['value']
    def handle_endtag(self, tag):
        if tag == 'form': self.current = None
        if tag == 'select': self.select = None

p=argparse.ArgumentParser();p.add_argument('--base-url', default='https://g5themes.test');p.add_argument('--ca', required=True);p.add_argument('--allow-test-writes', action='store_true');args=p.parse_args()
assert args.allow_test_writes, 'Pass --allow-test-writes for isolated development data'
assert urllib.parse.urlparse(args.base_url).hostname == 'g5themes.test', 'Only the approved development host is allowed'
password=os.environ['JW_G5_TEST_PASSWORD'];user=os.environ.get('JW_G5_TEST_USER','admin')
base=args.base_url.rstrip('/');cookies=http.cookiejar.CookieJar()
client=urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cookies),urllib.request.HTTPSHandler(context=ssl.create_default_context(cafile=args.ca)))
def request(path, data=None):
    url=urllib.parse.urljoin(base+'/', html.unescape(path))
    assert urllib.parse.urlparse(url).netloc==urllib.parse.urlparse(base).netloc
    req=urllib.request.Request(url, data=urllib.parse.urlencode(data).encode() if data is not None else None,headers={'Referer':base+'/bbs/','X-Requested-With':'XMLHttpRequest'})
    with client.open(req,timeout=30) as r: return r.geturl(),r.read().decode('utf-8')
def form(source,name):
    found=Forms(source).forms
    assert name in found, 'Missing form '+name
    return found[name]
def token(board):return json.loads(request('/bbs/write_token.php',{'bo_table':board})[1])['token']
def deletion(source,pattern):
    for href in re.findall(r'href="([^"]+)"',source):
        if pattern in html.unescape(href):return html.unescape(href)
    raise AssertionError('Missing deletion link')

_,login=request('/bbs/login.php');f=form(login,'flogin');f['values'].update(mb_id=user,mb_password=password)
_,logged=request(f['action'],f['values']);assert 'logout.php' in logged, 'Login failed'
report={'login':True,'boards':[]};marker='JW_SMOKE_'+uuid.uuid4().hex[:10]
# Each created record is deleted through the native, token-protected endpoint.
for board in ['free','gallery']:
    cleanup=None
    try:
        _,source=request('/bbs/write.php?bo_table='+board);f=form(source,'fwrite')
        f['values'].update(w='',wr_subject=marker,wr_content='첫 줄\n둘째 줄 <태그> & 문자 검증',token=token(board))
        location,view=request(f['action'],f['values']);assert marker in view, 'Write failed'
        wr_id=urllib.parse.parse_qs(urllib.parse.urlparse(location).query).get('wr_id',[''])[0]
        assert wr_id, 'Missing saved post ID'
        cleanup=deletion(view,'/delete.php?')
        cf=form(view,'fviewcomment');cf['values'].update(w='c',comment_id='',wr_content=marker+'_COMMENT',token=json.loads(request('/bbs/ajax.comment_token.php')[1])['token'])
        _,comment_view=request(cf['action'],cf['values']);assert marker+'_COMMENT' in comment_view,'Comment failed'
        comment_id=re.search(r'id="comment-(\d+)"',comment_view).group(1)
        cf=form(comment_view,'fviewcomment');cf['values'].update(w='cu',comment_id=comment_id,wr_content=marker+'_EDITED_COMMENT',token=json.loads(request('/bbs/ajax.comment_token.php')[1])['token'])
        _,edited_comment=request(cf['action'],cf['values']);assert marker+'_EDITED_COMMENT' in edited_comment,'Comment edit failed'
        _,source=request('/bbs/write.php?'+urllib.parse.urlencode({'bo_table':board,'wr_id':wr_id,'w':'u'}));f=form(source,'fwrite')
        assert '&lt;태그&gt;' in source, 'Text was not escaped for editing'
        f['values'].update(w='u',wr_subject=marker+'_EDITED',wr_content='수정된 본문\n둘째 줄',token=token(board))
        _,edited=request(f['action'],f['values']);assert marker+'_EDITED' in edited and '수정된 본문' in edited,'Post edit failed'
        cleanup=deletion(edited,'/delete.php?')
        report['boards'].append({'board':board,'write':True,'view':True,'comment':True,'comment_edit':True,'post_edit':True})
    finally:
        if cleanup:
            _,deleted=request(cleanup)
            assert marker not in deleted, 'Test record cleanup failed'
print(json.dumps(report,ensure_ascii=False,indent=2))
