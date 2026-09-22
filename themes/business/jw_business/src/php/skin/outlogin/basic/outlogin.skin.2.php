<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/outlogin/basic/outlogin.skin.2.php
 * Role: GnuBoard5 공개 화면 스킨
 * Original: GnuBoard5 Basic 3.0.0 by SIR
 * Modified by: JW SOFT
 * Copyright: Copyright (c) SIR and JW SOFT contributors
 * License: LGPL-2.1-only; see LICENSES/gnuboard5-LGPL-2.1.txt
 */ if (!defined('_GNUBOARD_')) exit; ?>
<section class="jw-widget" aria-label="내 회원정보"><h2><?php echo $nick; ?>님</h2>
<div class="jw-widget-links"><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php">정보 수정</a><?php if ($is_admin === 'super' || $is_auth) { ?><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">관리자</a><?php } ?></div>
<ul class="jw-widget-stats"><li><a href="<?php echo G5_BBS_URL; ?>/point.php" data-jw-popup-link="jw-point">포인트 <strong><?php echo $point; ?></strong></a></li><li><a href="<?php echo G5_BBS_URL; ?>/memo.php" data-jw-popup-link="jw-memo">안 읽은 쪽지 <strong><?php echo $memo_not_read; ?></strong></a></li><li><a href="<?php echo G5_BBS_URL; ?>/scrap.php" data-jw-popup-link="jw-scrap">스크랩 <strong><?php echo $mb_scrap_cnt; ?></strong></a></li></ul>
<a class="jw-control" href="<?php echo G5_BBS_URL; ?>/logout.php">로그아웃</a></section>
