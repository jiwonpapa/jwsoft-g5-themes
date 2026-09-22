<?php
if (!defined('_GNUBOARD_')) exit;

return array(
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
