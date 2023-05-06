<?php $subcomments = getSubcomments($parentComment->id); ?>
<?php if (!empty($subcomments)): ?>
	<div class="row-custom">
		<div class="comments">
			<ul class="comment-list">
				<?php foreach ($subcomments as $subcomment):
					$subcommentUser = null;
					if (!empty($subcomment->user_id)) {
						$subcommentUser = getUser($subcomment->user_id);
					} ?>
					<li>
						<div class="left">
							<?php if (!empty($subcommentUser)): ?>
								<a href="<?= generateProfileUrl($subcommentUser); ?>">
									<img src="<?= getUserAvatar($subcommentUser); ?>" alt="<?= esc($subcommentUser->username); ?>">
								</a>
							<?php else: ?>
								<img src="<?= getUserAvatarById($subcomment->user_id); ?>" alt="<?= esc($subcomment->name); ?>">
							<?php endif; ?>
						</div>
						<div class="right">
							<div class="row-custom">
								<?php if (!empty($subcommentUser)):  ?>
									<a href="<?= generateProfileUrl($subcommentUser); ?>">
										<span class="username"><?= esc($subcommentUser->username); ?></span>
									</a>
								<?php else: ?>
									<span class="username"><?= esc($subcomment->name); ?></span>
								<?php endif; ?>
							</div>
							<div class="row-custom comment">
								<?= esc($subcomment->comment); ?>
							</div>
							<div class="row-custom">
								<span class="date"><?= timeAgo($subcomment->created_at); ?></span>
								<?php if (authCheck()):
									if ($subcomment->user_id == user()->id || hasPermission('comments')): ?>
										<a href="javascript:void(0)" class="btn-delete-comment" onclick="deleteComment('<?= $subcomment->id; ?>','<?= $subcomment->post_id; ?>','<?= trans("confirm_comment"); ?>');"><?= trans("delete"); ?></a>
									<?php endif;
								endif; ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>