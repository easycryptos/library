<div class="profile-details">
    <div class="left">
        <img src="<?= getUserAvatar($user); ?>" alt="<?= esc($user->username); ?>" class="img-profile">
    </div>
    <div class="right">
        <div class="row-custom">
            <h1 class="username"><?= esc($user->username); ?></h1>
        </div>
        <div class="row-custom">
            <p class="p-last-seen">
                <span class="last-seen <?= isUserOnline($user->last_seen) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <?= trans("last_seen"); ?>&nbsp;<?= timeAgo($user->last_seen); ?></span>
            </p>
        </div>
        <div class="row-custom">
            <p class="description">
                <?= esc($user->about_me); ?>
            </p>
        </div>
        <div class="row-custom user-contact">
            <span class="info"><?= trans("member_since"); ?>&nbsp;<?= dateFormatDefault($user->created_at); ?></span>
            <?php if ($user->show_email_on_profile): ?>
                <span class="info"><i class="icon-envelope"></i><?= esc($user->email); ?></span>
            <?php endif; ?>
        </div>
        <div class="row-custom profile-buttons">
            <?php if (authCheck()): ?>
                <?php if (user()->id != $user->id): ?>
                    <form action="<?= base_url('follow-unfollow-user'); ?>" method="post" class="form-inline">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="following_id" value="<?= $user->id; ?>">
                        <?php if (isUserFollows($user->id, user()->id)): ?>
                            <button class="btn btn-md btn-custom btn-follow"><i class="icon-user-minus"></i><?= trans("unfollow"); ?></button>
                        <?php else: ?>
                            <button class="btn btn-md btn-custom btn-follow"><i class="icon-user-plus"></i><?= trans("follow"); ?></button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= langBaseUrl('login'); ?>" class="btn btn-md btn-custom btn-follow"><i class="icon-user-plus"></i><?= trans("follow"); ?></a>
            <?php endif; ?>
            <div class="social">
                <ul>
                    <?php if (!empty($user->facebook_url)): ?>
                        <li><a href="<?= esc($user->facebook_url); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                    <?php endif;
                    if (!empty($user->twitter_url)): ?>
                        <li><a href="<?= esc($user->twitter_url); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                    <?php endif;
                    if (!empty($user->instagram_url)): ?>
                        <li><a href="<?= esc($user->instagram_url); ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                    <?php endif;
                    if (!empty($user->pinterest_url)): ?>
                        <li><a href="<?= esc($user->pinterest_url); ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                    <?php endif;
                    if (!empty($user->linkedin_url)): ?>
                        <li><a href="<?= esc($user->linkedin_url); ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                    <?php endif;
                    if (!empty($user->vk_url)): ?>
                        <li><a href="<?= esc($user->vk_url); ?>" target="_blank"><i class="icon-vk"></i></a></li>
                    <?php endif;
                    if (!empty($user->telegram_url)): ?>
                        <li><a href="<?= esc($user->telegram_url); ?>" target="_blank"><i class="icon-telegram"></i></a></li>
                    <?php endif;
                    if (!empty($user->youtube_url)): ?>
                        <li><a href="<?= esc($user->youtube_url); ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
