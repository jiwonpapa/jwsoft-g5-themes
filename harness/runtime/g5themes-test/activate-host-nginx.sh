#!/bin/sh
set -eu

cd "$(dirname "$0")"
install -d -m 750 /etc/nginx/tls
install -m 644 tls/g5themes.test.pem /etc/nginx/tls/g5themes.test.pem
install -m 600 tls/g5themes.test-key.pem /etc/nginx/tls/g5themes.test-key.pem
install -m 644 host-nginx.conf /etc/nginx/conf.d/50-g5themes.test.conf
nginx -t
systemctl reload nginx

