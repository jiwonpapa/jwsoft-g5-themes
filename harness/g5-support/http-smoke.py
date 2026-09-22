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

p=argparse.ArgumentParser();p.add_argument('--base-url', default='https://g5themes.test');p.add_argument('--ca', required=True);p.add_argument('--allow-test-writes', action='store_true');p.add_argument('--keep-fixtures', action='store_true');args=p.parse_args()
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

_,qa_settings=request('/adm/qa_config.php');settings=form(qa_settings,'fqaconfigform')['values']
assert not settings.get('qa_admin_email') and not settings.get('qa_admin_hp'), 'Disable external QA notifications before running the development test'
report={'login':True,'checks':[]};marker='JW_SUPPORT_'+uuid.uuid4().hex[:10]
def qa_token(): return json.loads(request('/bbs/ajax.write.token.php',{'token_case':'qa_write'})[1])['token']
def view_link(source, subject):
    links=re.findall(r'<a[^>]+href="([^"]*qaview.php[^"]*)"[^>]*>(.*?)</a>',source,re.S)
    return next(html.unescape(url) for url,text in links if subject in text)
def upload(f, attach=True):
    boundary='JWBoundary'+uuid.uuid4().hex
    chunks=[]
    for key,value in f['values'].items():
        chunks.append(f'--{boundary}\r\nContent-Disposition: form-data; name="{key}"\r\n\r\n{value}\r\n'.encode())
    for index in [1,2]:
        chunks.append(f'--{boundary}\r\nContent-Disposition: form-data; name="bf_file[{index}]"; filename="{("support-"+str(index)+".txt") if attach else ""}"\r\nContent-Type: text/plain\r\n\r\n{("JW support attachment "+str(index)) if attach else ""}\r\n'.encode())
    chunks.append(f'--{boundary}--\r\n'.encode())
    req=urllib.request.Request(f['action'],data=b''.join(chunks),headers={'Referer':base+'/bbs/','Content-Type':'multipart/form-data; boundary='+boundary})
    with client.open(req,timeout=30) as r:return r.geturl(),r.read().decode()
def save(f,subject,content,w=None):
    f['values'].update(qa_subject=subject,qa_content=content,qa_html='0',token=qa_token())
    f['values'].pop('qa_email_recv',None);f['values'].pop('qa_sms_recv',None)
    if w is not None:f['values']['w']=w
    return request(f['action'],f['values'])
_,source=request('/bbs/qawrite.php');f=form(source,'fwrite')
_,listing=save(f,marker,'첫 줄\n둘째 줄 <태그> & 문자 검증')
link=view_link(listing,marker);_,view=request(link)
assert '&lt;태그&gt;' in view,'Escaped text missing'
report['checks'].append('question create and escaped body')
update=deletion(view,'qawrite.php?w=u');_,source=request(update);f=form(source,'fwrite')
assert '첫 줄' in source and '<태그>' not in source,'Edit body or escaping missing'
_,listing=save(f,marker+'_EDIT','수정한 문의 내용')
_,view=request(link);assert marker+'_EDIT' in view
report['checks'].append('question update')
_,source=request(deletion(view,'qawrite.php?w=u'));f=form(source,'fwrite')
f['values'].update(qa_content='첨부파일 검증',token=qa_token())
_,listing=upload(f);_,view=request(link)
assert 'support-1.txt' in view and 'support-2.txt' in view,'Two attachments missing'
for href in re.findall(r'href="([^"]*qadownload.php[^"]*)"',view):
    assert 'JW support attachment' in request(html.unescape(href))[1],'Download failed'
report['checks'].append('two-file upload and authorized download')
_,source=request(deletion(view,'qawrite.php?w=u'));f=form(source,'fwrite');f['values']['bf_file_del[1]']='1'
f['values'].update(qa_subject=marker+'_EDIT',qa_content='첨부 1 삭제 확인',token=qa_token())
_,listing=upload(f,False);_,view=request(link)
assert 'support-1.txt' not in view and 'support-2.txt' in view,'Attachment deletion failed'
report['checks'].append('individual attachment removal')
f=form(view,'fanswer');_,view=save(f,marker+'_ANSWER','답변 검증 내용')
assert marker+'_ANSWER' in view,'Answer missing'
report['checks'].append('administrator answer')
answer_update=next(html.unescape(href) for href in re.findall(r'href="([^"]+)"[^>]*>답변 수정',view))
_,source=request(answer_update);f=form(source,'fwrite');_,view=save(f,marker+'_ANSWER_EDIT','수정된 답변')
assert marker+'_ANSWER_EDIT' in view
report['checks'].append('answer update')
rewrite=next(html.unescape(href) for href in re.findall(r'href="([^"]+)"[^>]*>추가 질문',view))
_,source=request(rewrite);f=form(source,'fwrite');_,listing=save(f,marker+'_FOLLOWUP','추가 질문 내용')
follow=view_link(listing,marker+'_FOLLOWUP');_,related=request(follow)
assert marker+'_EDIT' in related,'Related question missing'
report['checks'].append('follow-up and related question')
_,mobile=request(link+'&device=mobile');assert marker+'_ANSWER_EDIT' in mobile and 'jw-support' in mobile
report['checks'].append('mobile skin contract')
_,search=request('/bbs/qalist.php?'+urllib.parse.urlencode({'sfl':'qa_subject','stx':marker}));assert marker+'_EDIT' in search
report['checks'].append('search')
# A stale token is rejected before a record can be created.
_,source=request('/bbs/qawrite.php');f=form(source,'fwrite');f['values'].update(qa_subject=marker+'_INVALID',qa_content='invalid token',token='invalid')
_,rejected=request(f['action'],f['values']);assert '올바른 방법' in rejected
report['checks'].append('invalid token rejected')
report['preview']={'question':link,'followup':follow,'marker':marker}
if not args.keep_fixtures:
    for target in [follow,link]:
        _,source=request(target)
        assert marker in source
        delete_url=deletion(source,'/qadelete.php?')
        target_id=urllib.parse.parse_qs(urllib.parse.urlparse(target).query)['qa_id'][0]
        deleted_id=urllib.parse.parse_qs(urllib.parse.urlparse(delete_url).query)['qa_id'][0]
        request(delete_url)
        if deleted_id != target_id:
            _,source=request(target)
            request(deletion(source,'/qadelete.php?'))
    _,remaining=request('/bbs/qalist.php?'+urllib.parse.urlencode({'sfl':'qa_subject','stx':marker}))
    assert marker+'_EDIT' not in remaining and marker+'_FOLLOWUP' not in remaining
    report['checks'].append('native token-protected cleanup')
print(json.dumps(report,ensure_ascii=False,indent=2))
