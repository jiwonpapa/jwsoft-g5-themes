<?php
/**
 * Theme: JW-Business 1.0
 * File: blocks/brand/logo-01.php
 * Role: 헤더·푸터에 직접 복사할 로고 프레임; 런타임 include 금지
 * Author: JW SOFT
 * Copyright: Copyright (c) 2026 JW SOFT
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
?>
<!-- JW BLOCK COPY: blocks/brand/logo-01.php; 각 shell의 독립 복사본입니다. -->
<span class="jw-brand__viewport<?php echo !empty($jw_settings['brand']['logo_animated']) ? ' jw-brand__viewport--animated' : ''; ?>">
    <img class="jw-brand__image jw-brand__image--light" src="<?php echo jw_business_escape($jw_settings['brand']['logo_light']); ?>" alt="<?php echo jw_business_escape($jw_settings['brand']['name']); ?>" width="648" height="<?php echo !empty($jw_settings['brand']['logo_animated']) ? '1080' : '120'; ?>" decoding="async">
    <img class="jw-brand__image jw-brand__image--dark" src="<?php echo jw_business_escape($jw_settings['brand']['logo_dark']); ?>" alt="<?php echo jw_business_escape($jw_settings['brand']['name']); ?>" width="648" height="<?php echo !empty($jw_settings['brand']['logo_animated']) ? '1080' : '120'; ?>" decoding="async">
</span>
