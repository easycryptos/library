<input type="hidden" value="<?= $commentLimit; ?>" id="post_comment_limit">
<div class="row">
    <div class="col-sm-12">
        <div class="comments">
            <?php if ($commentCount > 0): ?>
                <div class="row-custom comment-total">
                    <label class="label-comment"><?= trans("comments"); ?> (<?= $commentCount; ?>)</label>
                </div>
            <?php endif; ?>
            <ul class="comment-list">
                <?php foreach ($comments as $comment):
                    $commentUser = null;
                    if (!empty($comment->user_id)) {
                        $commentUser = getUser($comment->user_id);
                    } ?>
                    <li>
                        <div class="left">
                            <?php if (!empty($commentUser)): ?>
                                <a href="<?= generateProfileUrl($commentUser); ?>">
                                    <img src="<?= getUserAvatarById($comment->user_id); ?>" alt="<?= esc($comment->name); ?>">
                                </a>
                            <?php else: ?>
                                <img src="<?= getUserAvatarById($comment->user_id); ?>" alt="<?= esc($comment->name); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="right">
                            <div class="row-custom">
                                <?php if (!empty($commentUser)): ?>
                                    <a href="<?= generateProfileUrl($commentUser); ?>">
                                        <span class="username"><?= esc($comment->name); ?></span>
                                    </a>
                                <?php else: ?>
                                    <span class="username"><?= esc($comment->name); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="row-custom comment">
                                <?= esc($comment->comment); ?>
                            </div>
                            <div class="row-custom">
                                <span class="date"><?= timeAgo($comment->created_at); ?></span>
                                <a href="javascript:void(0)" class="btn-reply" onclick="showCommentBox('<?= $comment->id; ?>');"><i class="icon-reply"></i> <?= trans('reply'); ?></a>
                                <?php if (authCheck()):
                                    if ($comment->user_id == user()->id || hasPermission('comments')): ?>
                                        <a href="javascript:void(0)" class="btn-delete-comment" onclick="deleteComment('<?= $comment->id; ?>','<?= $post->id; ?>','<?= trans("confirm_comment"); ?>');"><?= trans("delete"); ?></a>
                                    <?php endif;
                                endif; ?>
                            </div>
                            <div id="sub_comment_form_<?= $comment->id; ?>" class="row-custom row-sub-comment visible-sub-comment"></div>
                            <div class="row-custom row-sub-comment">
                                <?= view('post/_subcomments', ['parentComment' => $comment]); ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php if ($commentCount > $commentLimit): ?>
    <div class="row">
        <div id="load_comment_spinner" class="col-sm-12 load-more-spinner">
            <div class="row">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="btn-load-more" onclick="loadMoreComment('<?= $post->id; ?>');">
                <?= trans("load_more_comments"); ?>
            </button>
        </div>
    </div>
<?php endif; ?>

