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
