<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/latest/home_one/latest.skin.php
 * Role: 메인 1 전용 최신 소식
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;
?>
<div class="jwh1-updates">
    <header><h2>새로운 소식</h2><a class="jwh1-link" href="<?php echo jw_business_escape(get_pretty_url($bo_table)); ?>">전체 보기<i data-lucide="arrow-right" aria-hidden="true"></i></a></header>
    <?php if (empty($list)) { ?><p class="jwh1-updates__empty">아직 등록된 소식이 없습니다.</p><?php } else { ?>
    <ul><?php foreach ($list as $item) { ?>
        <li><a href="<?php echo htmlspecialchars(get_pretty_url($bo_table, $item['wr_id']), ENT_QUOTES, 'UTF-8', false); ?>"><span><?php echo $item['subject']; ?></span><time><?php echo jw_business_escape($item['datetime2']); ?></time><i data-lucide="arrow-up-right" aria-hidden="true"></i></a></li>
    <?php } ?></ul>
    <?php } ?>
</div>
