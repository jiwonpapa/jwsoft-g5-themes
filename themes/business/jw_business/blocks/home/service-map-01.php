<?php
/**
 * Theme: JW-Business 1.0
 * File: blocks/home/service-map-01.php
 * Role: 홈의 사업 분야 링크 목록 복사용 블록
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 * Requires: $jw_home, $jw_services, jw_business_escape()
 * Runtime: include 금지. 완성형 홈 파일에 복사하여 사용합니다.
 */
if (!defined('_GNUBOARD_')) exit;
?>
<section class="jw-home-section jw-service-map" aria-labelledby="jw-home-services">
    <div class="jw-shell">
        <header class="jw-home-heading jw-home-heading--split">
            <h2 id="jw-home-services">필요한 전문성을<br>한 흐름으로 연결합니다.</h2>
            <p><?php echo jw_business_escape($jw_home['summary']); ?></p>
        </header>
        <ul class="jw-service-map__list">
            <?php foreach ($jw_services as $service) { ?>
            <li><a href="<?php echo jw_business_escape($service['url']); ?>"><strong><?php echo jw_business_escape($service['title']); ?></strong><span><?php echo jw_business_escape($service['summary']); ?></span><i data-lucide="arrow-up-right"></i></a></li>
            <?php } ?>
        </ul>
    </div>
</section>
