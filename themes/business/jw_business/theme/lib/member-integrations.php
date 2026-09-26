<?php
/**
 * Theme: JW-Business 1.0
 * File: lib/member-integrations.php
 * Role: 공식 본인확인과 소셜 확장에 필요한 자산의 경로 판별
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

function jw_member_needs_legacy_bridge(array $config, string $script, string $root): bool
{
    $root = rtrim(str_replace('\\', '/', $root), '/');
    $script = str_replace('\\', '/', $script);
    if (!str_starts_with($script, $root.'/')) return false;
    $route = substr($script, strlen($root));
    if (!empty($config['cf_cert_use'])) {
        if (in_array($route, array('/bbs/register_form.php', '/bbs/member_cert_refresh.php', '/bbs/password_lost.php'), true)) return true;
        if (preg_match('#^/plugin/(inicert|okname|kcpcert|kcpcert_v2|lgxpay)/[^/]+\.php$#D', $route)) return true;
    }
    if (!empty($config['cf_social_login_use'])) {
        if (in_array($route, array('/bbs/register.php', '/bbs/register_form.php', '/bbs/login.php'), true)) return true;
        if (str_starts_with($route, '/plugin/social/')) return true;
    }
    return false;
}
