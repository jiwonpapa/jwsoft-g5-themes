<?php
if (!defined('_GNUBOARD_')) exit;
?>
<section class="jw-comments" aria-labelledby="jw-comments-title">
    <div class="jw-comments__heading">
        <h3 id="jw-comments-title">댓글 <span><?php echo number_format($view['wr_comment']); ?></span></h3>
        <button type="button" class="jw-control jw-control--quiet" data-jw-comments-toggle aria-expanded="true">댓글 접기</button>
    </div>

    <div class="jw-comments__body" data-jw-comments-body>
        <div class="jw-comment-list">
        <?php
        $cmt_amt = count($list);
        for ($i = 0; $i < $cmt_amt; $i++) {
            $comment_id = (int)$list[$i]['wr_id'];
            $depth = min(5, strlen($list[$i]['wr_comment_reply']));
            $comment = $list[$i]['content'];
            $c_reply_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=c#jw-comment-form-wrap';
            $c_edit_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=cu#jw-comment-form-wrap';
            $has_actions = $list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del'];
        ?>
            <article class="jw-comment jw-comment--depth-<?php echo $depth; ?>" id="comment-<?php echo $comment_id; ?>">
                <div class="jw-comment__avatar"><?php echo get_member_profile_img($list[$i]['mb_id']); ?></div>
                <div class="jw-comment__content">
                    <header>
                        <strong><?php echo $list[$i]['name']; ?></strong>
                        <?php if ($is_ip_view) { ?><span><?php echo $list[$i]['ip']; ?></span><?php } ?>
                        <time datetime="<?php echo date('c', strtotime($list[$i]['datetime'])); ?>"><?php echo $list[$i]['datetime']; ?></time>
                    </header>
                    <div class="jw-comment__text">
                        <?php if (strstr($list[$i]['wr_option'], 'secret')) { ?><span class="jw-badge">비밀글</span><?php } ?>
                        <?php echo $comment; ?>
                    </div>
                    <div class="jw-comment__slot" id="jw-comment-reply-<?php echo $comment_id; ?>"></div>
                    <div class="jw-comment__slot" id="jw-comment-edit-<?php echo $comment_id; ?>"></div>
                    <textarea hidden id="jw-comment-saved-<?php echo $comment_id; ?>"><?php echo get_text($list[$i]['content1'], 0); ?></textarea>
                    <input type="hidden" id="jw-comment-secret-<?php echo $comment_id; ?>" value="<?php echo strstr($list[$i]['wr_option'], 'secret') ? 'secret' : ''; ?>">
                </div>
                <?php if ($has_actions) { ?>
                <details class="jw-action-menu jw-comment__actions">
                    <summary class="jw-control jw-control--quiet">댓글 작업</summary>
                    <div class="jw-action-menu__panel">
                        <?php if ($list[$i]['is_reply']) { ?><a href="<?php echo $c_reply_href; ?>" data-jw-comment-action="reply" data-comment-id="<?php echo $comment_id; ?>">답변</a><?php } ?>
                        <?php if ($list[$i]['is_edit']) { ?><a href="<?php echo $c_edit_href; ?>" data-jw-comment-action="edit" data-comment-id="<?php echo $comment_id; ?>">수정</a><?php } ?>
                        <?php if ($list[$i]['is_del']) { ?><a href="<?php echo $list[$i]['del_link']; ?>" data-jw-confirm="이 댓글을 삭제하시겠습니까?">삭제</a><?php } ?>
                    </div>
                </details>
                <?php } ?>
            </article>
        <?php } ?>
        <?php if (!$cmt_amt) { ?><p class="jw-board-empty">등록된 댓글이 없습니다.</p><?php } ?>
        </div>

        <?php if ($is_comment_write) {
            if ($w == '') $w = 'c';
            $jw_captcha_html = $is_guest
                ? preg_replace('#<script\b[^>]*>.*?</script>#is', '', $captcha_html)
                : '';
        ?>
        <aside class="jw-comment-form-wrap" id="jw-comment-form-wrap">
            <h3>댓글 쓰기</h3>
            <form name="fviewcomment" class="jw-comment-form" action="<?php echo $comment_action_url; ?>" method="post" autocomplete="off"
                data-jw-comment-form
                data-filter-url="<?php echo G5_BBS_URL; ?>/ajax.filter.php"
                data-token-url="<?php echo G5_BBS_URL; ?>/ajax.comment_token.php"
                data-captcha-result-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_result.php"
                data-min="<?php echo (int)$comment_min; ?>"
                data-max="<?php echo (int)$comment_max; ?>">
                <input type="hidden" name="w" value="<?php echo $w; ?>" data-jw-comment-work>
                <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
                <input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
                <input type="hidden" name="comment_id" value="<?php echo $c_id; ?>" data-jw-comment-id>
                <input type="hidden" name="sca" value="<?php echo $sca; ?>">
                <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
                <input type="hidden" name="stx" value="<?php echo $stx; ?>">
                <input type="hidden" name="spt" value="<?php echo $spt; ?>">
                <input type="hidden" name="page" value="<?php echo $page; ?>">
                <input type="hidden" name="is_good" value="">

                <label for="jw-comment-content">내용</label>
                <textarea id="jw-comment-content" name="wr_content" maxlength="10000" required placeholder="댓글 내용을 입력하세요"><?php echo get_text($c_wr_content ?? ''); ?></textarea>
                <p class="jw-field-help" data-jw-comment-count>
                    <?php if ($comment_min) echo (int)$comment_min.'자 이상 · '; if ($comment_max) echo (int)$comment_max.'자 이하 · '; ?><span>0</span>자
                </p>

                <?php if ($is_guest) { ?>
                <div class="jw-comment-form__guest">
                    <label>이름 <input type="text" name="wr_name" value="<?php echo get_cookie('ck_sns_name'); ?>" required maxlength="20"></label>
                    <label>비밀번호 <input type="password" name="wr_password" required maxlength="20"></label>
                </div>
                <div class="jw-comment-form__captcha"
                    data-jw-captcha
                    data-session-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_session.php"
                    data-image-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_image.php"
                    data-audio-url="<?php echo G5_CAPTCHA_URL; ?>/kcaptcha_mp3.php"><?php echo $jw_captcha_html; ?></div>
                <?php } ?>

                <div class="jw-comment-form__footer">
                    <label class="jw-check"><input type="checkbox" name="wr_secret" value="secret" data-jw-comment-secret> 비밀글</label>
                    <button type="button" class="jw-control jw-control--quiet" data-jw-comment-cancel hidden>취소</button>
                    <button type="submit" class="jw-control jw-control--primary">댓글 등록</button>
                </div>
            </form>
        </aside>
        <?php } ?>
    </div>
</section>
