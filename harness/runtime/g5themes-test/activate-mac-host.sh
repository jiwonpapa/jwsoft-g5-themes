#!/bin/sh
set -eu

host_line="192.168.0.127 g5themes.test"
if ! awk '$1 == "192.168.0.127" { for (i = 2; i <= NF; i++) if ($i == "g5themes.test") found = 1 } END { exit !found }' /etc/hosts; then
    printf '\n%s\n' "$host_line" >> /etc/hosts
fi

dscacheutil -flushcache
killall -HUP mDNSResponder 2>/dev/null || true
