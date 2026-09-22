#!/usr/bin/env bash
set -euo pipefail

action="${1:-plan}"
profile="${2:-shell}"

case "$action" in
  plan|apply|verify|reset) ;;
  *) echo "unsupported action: $action" >&2; exit 2 ;;
esac

case "$profile" in
  shell|full) ;;
  *) echo "unsupported profile: $profile" >&2; exit 2 ;;
esac

fixture_host="${JW_G5_FIXTURE_SSH_HOST:-localubuntu}"
service_root="${JW_G5_FIXTURE_SERVICE_ROOT:-/home/neojins/services/g5themes-test}"
remote_dir="$service_root/site/data/.jw-harness"
script_dir="$(cd "$(dirname "$0")" && pwd)"

ssh -o BatchMode=yes "$fixture_host" "mkdir -p '$remote_dir' && chmod 700 '$remote_dir'"
rsync -a --chmod=F600 "$script_dir/seed.php" "$script_dir/boards.json" "$fixture_host:$remote_dir/"

allow="0"
if [[ "$action" == "apply" || "$action" == "reset" ]]; then
  allow="1"
fi

ssh -o BatchMode=yes "$fixture_host" "cd '$service_root' && docker compose exec -T -e JW_G5_ROOT=/var/www/html -e JW_G5_FIXTURE_ALLOWED=$allow php php /var/www/html/data/.jw-harness/seed.php '$action' '$profile'"
