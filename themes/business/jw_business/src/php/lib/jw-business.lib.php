<?php
/**
 * Theme: JW-Business 1.0
 * File: lib/jw-business.lib.php
 * Role: 테마 설정과 순수 공용 함수
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;

if (!function_exists('jw_business_menu_groups')) {
    /**
     * 같은 독립 페이지의 연속된 디자인 선택 메뉴만 화면에서 묶습니다.
     * DB의 이름·URL·순서·노출 권한은 바꾸지 않으며 일반 메뉴는 그대로 둡니다.
     */
    function jw_business_menu_groups($children)
    {
        $groups = array();
        $site = parse_url(G5_URL);
        $site_path = rtrim($site['path'] ?? '', '/');

        foreach (array_filter((array) $children) as $item) {
            $url = parse_url($item['me_link'] ?? '');
            $path = is_array($url) ? ($url['path'] ?? '') : '';
            $same_site = is_array($url)
                && (!isset($url['host']) || strcasecmp($url['host'], $site['host'] ?? '') === 0)
                && (!isset($url['port']) || $url['port'] === ($site['port'] ?? null));
            $title = trim((string) ($item['me_name'] ?? ''));
            $stem = '';
            if ($same_site && empty($url['query']) && empty($url['fragment'])
                && preg_match('~^'.preg_quote($site_path, '~').'/pages/([a-z][a-z0-9-]*)-([1-5])\.php$~', $path, $match)
                && preg_match('/^(.+?)\s+#?'.$match[2].'(?:\s+·\s+(.+))?$/u', $title, $name)) {
                $stem = $match[1].'|'.$name[1];
                $title = $name[1];
                if (!empty($name[2])) {
                    $item['display_name'] = '#'.$match[2].' '.$name[2];
                }
            }

            $last = count($groups) - 1;
            if ($stem !== '' && $last >= 0 && $groups[$last]['key'] === $stem) {
                $groups[$last]['items'][] = $item;
            } else {
                $groups[] = array('key' => $stem, 'title' => $title, 'items' => array($item));
            }
        }

        return $groups;
    }
}

if (!function_exists('jw_business_settings')) {
    function jw_business_settings()
    {
        global $config;

        static $settings;
        if (isset($settings)) return $settings;

        $settings = array(
            'brand' => array(
                'logo_light' => G5_THEME_URL.'/assets/brand/jw-business-light.webp',
                'logo_dark' => G5_THEME_URL.'/assets/brand/jw-business-dark.webp',
                'logo_animated' => true,
                'name' => 'JW-Business',
            ),
            'home' => array(
                'eyebrow' => 'Strategy · Technology · Space',
                'title' => "더 나은 방향을,\n함께 만듭니다.",
                'summary' => '전략과 기술, 공간을 연결하는 비즈니스 파트너.',
                'services' => array(
                    array('title' => '비즈니스 컨설팅', 'summary' => '방향을 정하고 실행을 설계합니다.', 'url' => G5_URL.'/pages/business-detail-1.php'),
                    array('title' => '디지털 서비스', 'summary' => '사람과 기술의 연결을 만듭니다.', 'url' => G5_URL.'/pages/business-detail-2.php'),
                    array('title' => '공간·브랜드 경험', 'summary' => '브랜드의 가치를 공간에 담습니다.', 'url' => G5_URL.'/pages/business-detail-3.php'),
                ),
                'news_board' => 'notice',
            ),
            'company' => array(
                'name' => 'JW NEXUS',
                'representative' => '대표자명',
                'address' => '서울특별시 중구 세종대로 00',
                'phone' => '02-0000-0000',
                'email' => 'hello@example.com',
                'business_number' => '000-00-00000',
            ),
        );

        $custom_path = G5_THEME_PATH.'/custom/site.php';
        if (is_file($custom_path)) {
            $custom = include $custom_path;
            if (is_array($custom)) $settings = array_replace_recursive($settings, $custom);
        }

        return $settings;
    }
}

if (!function_exists('jw_business_page_url')) {
    function jw_business_page_url($page_id)
    {
        $page_id = preg_replace('/[^a-z0-9-]/', '', strtolower((string) $page_id));
        return G5_URL.'/pages/'.$page_id.'.php';
    }
}

if (!function_exists('jw_business_escape')) {
    function jw_business_escape($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('jw_business_excerpt')) {
    /**
     * 게시판 원문에서 목록용 평문 요약을 만듭니다.
     */
    function jw_business_excerpt($content, $length = 150)
    {
        $text = html_entity_decode(strip_tags((string) $content), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(preg_replace('/\s+/u', ' ', $text));
        if ($text === '') return '';
        return cut_str($text, max(20, (int) $length), '…');
    }
}

if (!function_exists('jw_business_video_source')) {
    /**
     * 허용된 영상 URL만 식별합니다. iframe HTML을 목록에서 직접 출력하지 않습니다.
     */
    function jw_business_video_source($item)
    {
        $candidates = array(
            (string) ($item['wr_link1'] ?? ''),
            (string) ($item['wr_link2'] ?? ''),
            (string) ($item['wr_content'] ?? ''),
        );

        foreach ($candidates as $candidate) {
            if (preg_match('#(?:youtube(?:-nocookie)?\.com/(?:watch\?[^\s"\']*v=|embed/|shorts/)|youtu\.be/)([a-zA-Z0-9_-]{6,15})#i', $candidate, $match)) {
                $id = $match[1];
                return array(
                    'provider' => 'YouTube',
                    'url' => 'https://www.youtube.com/watch?v='.$id,
                    'poster' => 'https://i.ytimg.com/vi/'.$id.'/hqdefault.jpg',
                );
            }

            if (preg_match('#https?://(?:www\.)?vimeo\.com/(?:video/)?([0-9]{6,12})#i', $candidate, $match)) {
                return array(
                    'provider' => 'Vimeo',
                    'url' => 'https://vimeo.com/'.$match[1],
                    'poster' => '',
                );
            }
        }

        return array('provider' => 'Video', 'url' => '', 'poster' => '');
    }
}

if (!function_exists('jw_business_render_popup_layer')) {
    function jw_business_render_popup_layer($device)
    {
        global $g5;

        $device = $device === 'mobile' ? 'mobile' : 'pc';
        $sql = " select * from {$g5['new_win_table']}
                  where '".G5_TIME_YMDHIS."' between nw_begin_time and nw_end_time
                    and nw_device IN ( 'both', '{$device}' )
                    and nw_division IN ( 'both', 'comm' )
                  order by nw_id asc ";
        $result = sql_query($sql, false);
        $popups = array();

        while ($popup = sql_fetch_array($result)) {
            $cookie_name = 'hd_pops_'.(int)$popup['nw_id'];
            if (!empty($_COOKIE[$cookie_name])) continue;
            $popups[] = $popup;
        }

        if (!$popups) return;
        ?>
        <section class="jw-popup-layer" data-jw-popup-layer data-cookie-domain="<?php echo jw_business_escape(G5_COOKIE_DOMAIN); ?>" aria-label="사이트 알림">
            <?php foreach ($popups as $popup) {
                $popup_id = 'jw-popup-'.(int)$popup['nw_id'];
                $cookie_name = 'hd_pops_'.(int)$popup['nw_id'];
                $disable_hours = max(0, (int)$popup['nw_disable_hours']);
                $position = sprintf(
                    '--jw-popup-top:%dpx;--jw-popup-left:%dpx;--jw-popup-width:%dpx;--jw-popup-height:%dpx',
                    (int)$popup['nw_top'],
                    (int)$popup['nw_left'],
                    max(280, (int)$popup['nw_width']),
                    max(180, (int)$popup['nw_height'])
                );
                ?>
                <article id="<?php echo $popup_id; ?>" class="jw-popup" data-jw-popup data-cookie-name="<?php echo $cookie_name; ?>" style="<?php echo $position; ?>" role="dialog" aria-label="사이트 알림">
                    <div class="jw-popup__content"><?php echo conv_content($popup['nw_content'], 1); ?></div>
                    <footer class="jw-popup__footer">
                        <button type="button" class="jw-popup__snooze" data-jw-popup-dismiss="snooze" data-hours="<?php echo $disable_hours; ?>">
                            <strong><?php echo $disable_hours; ?></strong>시간 동안 보지 않기
                        </button>
                        <button type="button" class="jw-popup__close" data-jw-popup-dismiss="close">
                            닫기 <i data-lucide="x"></i>
                        </button>
                    </footer>
                </article>
            <?php } ?>
        </section>
        <?php
    }
}
