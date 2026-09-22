<?php
if (!defined('_GNUBOARD_')) exit;
$jw_brand = $jw_settings['brand'];
?>
<span class="jw-brand__viewport<?php echo !empty($jw_brand['logo_animated']) ? ' jw-brand__viewport--animated' : ''; ?>">
    <img class="jw-brand__image jw-brand__image--light" src="<?php echo jw_business_escape($jw_brand['logo_light']); ?>" alt="<?php echo jw_business_escape($jw_brand['name']); ?>" width="648" height="<?php echo !empty($jw_brand['logo_animated']) ? '1080' : '120'; ?>" decoding="async">
    <img class="jw-brand__image jw-brand__image--dark" src="<?php echo jw_business_escape($jw_brand['logo_dark']); ?>" alt="<?php echo jw_business_escape($jw_brand['name']); ?>" width="648" height="<?php echo !empty($jw_brand['logo_animated']) ? '1080' : '120'; ?>" decoding="async">
</span>
