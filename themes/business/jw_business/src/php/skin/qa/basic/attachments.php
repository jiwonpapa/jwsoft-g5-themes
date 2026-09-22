<?php
/**
 * Theme: JW-Business 1.0
 * File: skin/qa/basic/attachments.php
 * Role: GnuBoard5 공개 화면 스킨
 * Author: JW SOFT
 * Copyright: Copyright (c) JW SOFT. All rights reserved.
 * License: JW SOFT Commercial License; see LICENSE.txt
 */
if (!defined('_GNUBOARD_')) exit;
for ($jw_i=0; $jw_i<($jw_qa_record['img_count'] ?? 0); $jw_i++) {
    echo get_view_thumbnail($jw_qa_record['img_file'][$jw_i], $qaconfig['qa_image_width']);
}
if (!empty($jw_qa_record['download_count'])) { ?>
<div class="jw-support-downloads"><h3>첨부파일</h3><ul>
<?php for ($jw_i=0; $jw_i<$jw_qa_record['download_count']; $jw_i++) { ?><li><a href="<?php echo htmlspecialchars($jw_qa_record['download_href'][$jw_i], ENT_QUOTES, 'UTF-8', false); ?>" download><?php echo get_text($jw_qa_record['download_source'][$jw_i]); ?></a></li><?php } ?>
</ul></div>
<?php } ?>
