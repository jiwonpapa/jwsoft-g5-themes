<?php
/** JW SOFT development regression: pure menu data, no DB or server mutation. */
define('_GNUBOARD_', true);
define('G5_URL', 'https://g5themes.test/subdir');
require $argv[1].'/lib/jw-business.lib.php';

function check($condition, $message)
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}
function item($title, $route, $target = 'self')
{
    return array('me_name' => $title, 'me_link' => $route, 'me_target' => $target);
}
$input = array();
foreach (array('overview', 'greeting', 'vision', 'history', 'organization', 'certification', 'location') as $type) {
    foreach (range(1, 5) as $number) {
        $input[] = item($type.' '.$number.' · 디자인 '.$number, G5_URL.'/pages/company-'.$type.'-'.$number.'.php');
    }
}
$groups = jw_business_menu_groups($input);
check(count($groups) === 7, 'Company must have seven visible groups, not one scrolling column');
$flattened = array();
foreach ($groups as $group) {
    check(count($group['items']) === 5, 'Every company group retains five designs');
    foreach ($group['items'] as $row) {
        check(strpos($row['display_name'], '#') === 0, 'Descriptive variant label retained');
        unset($row['display_name']);
        $flattened[] = $row;
    }
}
check($input === $flattened, 'Names, URLs, order and link targets must remain unchanged');

$custom = array(
    item('서울 지점', G5_URL.'/pages/location-1.php'),
    item('부산 지점', G5_URL.'/pages/location-2.php'),
    item('외부 1', 'https://other.test/subdir/pages/demo-1.php', 'blank'),
    item('외부 2', 'https://other.test/subdir/pages/demo-2.php', 'blank'),
    item('검색 1', G5_URL.'/pages/demo-1.php?search=one'),
    item('검색 2', G5_URL.'/pages/demo-2.php?search=two'),
    item('앵커 1', G5_URL.'/pages/demo-1.php#one'),
    item('앵커 2', G5_URL.'/pages/demo-2.php#two'),
);
check(count(jw_business_menu_groups($custom)) === 8, 'Ordinary/custom/external/query/hash menus must not be regrouped');
$sparse = array($input[0], $input[4]);
check(count(jw_business_menu_groups($sparse)[0]['items']) === 2, 'Hidden variants must never be reintroduced');
$separated = array($input[0], $custom[0], $input[1]);
check(count(jw_business_menu_groups($separated)) === 3, 'Nonadjacent menu items must not move');
check(jw_business_menu_groups(array()) === array(), 'Empty menus must stay empty');
echo "PASS: grouping, 35 destinations, labels, custom/external URLs, visibility, ordering and empty menus\n";
