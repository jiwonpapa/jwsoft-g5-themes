<?php
if (!defined('_GNUBOARD_')) exit;

if (G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>
        </main>
    </div>
</div>
<?php
include G5_THEME_PATH.'/partials/site-footer.php';
if ($config['cf_analytics']) echo $config['cf_analytics'];
?>
<?php include_once(G5_THEME_PATH.'/tail.sub.php'); ?>
