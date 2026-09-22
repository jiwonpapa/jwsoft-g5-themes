<?php
if (!defined('_GNUBOARD_')) exit;

// 이 파일을 theme/jw_business/custom/navigation.php로 복사한 뒤 실제 사용할 메뉴만 남깁니다.
// G5 관리자 메뉴 DB와 무관하며, 테마 업데이트 ZIP은 custom/navigation.php를 덮어쓰지 않습니다.
return array(
    array(
        'me_name' => '회사소개',
        'me_link' => G5_URL.'/pages/company-overview-1.php',
        'me_target' => 'self',
        'sub' => array(
            array('me_name' => '기업개요', 'me_link' => G5_URL.'/pages/company-overview-1.php', 'me_target' => 'self', 'sub' => array()),
            array('me_name' => '대표 인사말', 'me_link' => G5_URL.'/pages/company-greeting-1.php', 'me_target' => 'self', 'sub' => array()),
            array('me_name' => '오시는 길', 'me_link' => G5_URL.'/pages/company-location-1.php', 'me_target' => 'self', 'sub' => array()),
        ),
    ),
    array(
        'me_name' => '사업분야',
        'me_link' => G5_URL.'/pages/business-list-1.php',
        'me_target' => 'self',
        'sub' => array(
            array('me_name' => '사업 목록', 'me_link' => G5_URL.'/pages/business-list-1.php', 'me_target' => 'self', 'sub' => array()),
            array('me_name' => '프로세스', 'me_link' => G5_URL.'/pages/business-process-1.php', 'me_target' => 'self', 'sub' => array()),
        ),
    ),
    array('me_name' => '프로젝트', 'me_link' => get_pretty_url('gallery'), 'me_target' => 'self', 'sub' => array()),
    array('me_name' => '고객지원', 'me_link' => G5_URL.'/pages/support-home-1.php', 'me_target' => 'self', 'sub' => array(
        array('me_name' => '고객센터 안내', 'me_link' => G5_URL.'/pages/support-home-1.php', 'me_target' => 'self', 'sub' => array()),
        array('me_name' => '공지사항', 'me_link' => get_pretty_url('notice'), 'me_target' => 'self', 'sub' => array()),
        array('me_name' => 'FAQ', 'me_link' => G5_BBS_URL.'/faq.php', 'me_target' => 'self', 'sub' => array()),
        array('me_name' => '1:1 문의', 'me_link' => G5_BBS_URL.'/qalist.php', 'me_target' => 'self', 'sub' => array()),
    )),
);
