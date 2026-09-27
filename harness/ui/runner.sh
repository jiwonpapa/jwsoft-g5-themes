#!/usr/bin/env bash
set -euo pipefail
cd /work
if ! cmp -s harness/ui/runner-deps/package-lock.json node_modules/.jw-harness-lock; then
  mkdir -p /tmp/jw-ui-deps
  cp harness/ui/runner-deps/package*.json /tmp/jw-ui-deps/
  npm ci --prefix /tmp/jw-ui-deps --ignore-scripts --no-audit --no-fund
  cp -a /tmp/jw-ui-deps/node_modules/. /work/node_modules/
  cp harness/ui/runner-deps/package-lock.json node_modules/.jw-harness-lock
fi
exec node node_modules/@playwright/test/cli.js test -c harness/ui/playwright.config.ts
