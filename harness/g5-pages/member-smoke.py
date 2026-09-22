#!/usr/bin/env python3
"""Read-only page checks using a real G5 login on the approved development host."""
import argparse
import html
import http.cookiejar
import json
import os
import re
import ssl
import urllib.parse
import urllib.request
from html.parser import HTMLParser


class LoginForm(HTMLParser):
    def __init__(self, source):
        super().__init__()
        self.active = False
        self.action = None
        self.values = {}
        self.feed(source)

    def handle_starttag(self, tag, attrs):
        attrs = dict(attrs)
        if tag == "form":
            self.active = attrs.get("name") == "flogin" or attrs.get("id") == "flogin"
            if self.active:
                self.action = attrs["action"]
        if tag == "input" and self.active and attrs.get("name"):
            self.values[attrs["name"]] = attrs.get("value", "")

    def handle_endtag(self, tag):
        if tag == "form":
            self.active = False


parser = argparse.ArgumentParser()
parser.add_argument("--ca", required=True)
args = parser.parse_args()
base = "https://g5themes.test"
client = urllib.request.build_opener(
    urllib.request.HTTPCookieProcessor(http.cookiejar.CookieJar()),
    urllib.request.HTTPSHandler(context=ssl.create_default_context(cafile=args.ca)),
)


def request(path, data=None):
    url = urllib.parse.urljoin(base, html.unescape(path))
    assert urllib.parse.urlparse(url).netloc == "g5themes.test"
    req = urllib.request.Request(
        url,
        data=urllib.parse.urlencode(data).encode() if data is not None else None,
        headers={"Referer": base + "/bbs/login.php"},
    )
    with client.open(req, timeout=30) as response:
        body = response.read().decode("utf-8")
        assert not re.search(r"Fatal error|Parse error|Warning:|Deprecated:", body), path
        return body


login = LoginForm(request("/bbs/login.php"))
assert login.action, "Login form not found"
login.values.update(mb_id=os.environ["G5_ADMIN_ID"], mb_password=os.environ["G5_ADMIN_PASSWORD"])
logged = request(login.action, login.values)
assert "logout.php" in logged, "Login failed"
checks = []
try:
    for variant in range(2, 6):
        for device in ("pc", "mobile"):
            route = f"/theme/jw_business/index_{variant}.php?device={device}"
            body = request(route)
            assert f'data-jw-home="{variant}"' in body, route
            assert "logout.php" in body and "내 정보" in body, route
            checks.append({"variant": variant, "device": device, "member_shell": True})
    qa = request("/bbs/qalist.php")
    assert "qawrite.php" in qa and "logout.php" in qa, "Member inquiry list missing"
finally:
    request("/bbs/logout.php")
print(json.dumps({"login": True, "checks": checks, "member_inquiry_list": True, "logout": True}, ensure_ascii=False))
