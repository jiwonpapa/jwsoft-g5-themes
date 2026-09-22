<?php
if (!defined('_GNUBOARD_')) exit;

// Keep the core's permission-filtered links; replace its inline-script sideview shell.
function jw_business_author_menu(array $row): string
{
    $name = get_text($row['wr_name'] ?? '');
    $source = preg_replace('#<noscript\\b[^>]*>.*?</noscript>#is', '', $row['name'] ?? '');
    preg_match_all('#<a\\b[^>]*href="([^"]+)"[^>]*>(.*?)</a>#is', $source, $links, PREG_SET_ORDER);
    if (count($links) < 2) return $name;
    $html = '<details class="jw-author"><summary>'.$name.'</summary><div class="jw-author__menu">';
    foreach (array_slice($links, 1) as $link) {
        $url = html_entity_decode($link[1], ENT_QUOTES, 'UTF-8');
        if (!preg_match('#^(https?://|/|\\./)#i', $url)) continue;
        $html .= '<a href="'.htmlspecialchars($url, ENT_QUOTES, 'UTF-8').'" rel="nofollow">'.get_text(strip_tags($link[2])).'</a>';
    }
    return $html.'</div></details>';
}
