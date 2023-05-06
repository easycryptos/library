<div class="post-meta">
    <p class="post-meta-inner">
        <a href="<?= langBaseUrl('profile/' . esc($item->user_slug)); ?>"><?= esc($item->username); ?></a>
        <span><i class="icon-clock"></i>&nbsp;&nbsp;<?= dateFormatDefault($item->created_at); ?></span>
        <?php if ($generalSettings->comment_system == 1) : ?>
            <span><i class="icon-comment"></i>&nbsp;<?= $item->comment_count; ?></span>
        <?php endif; ?>
        <?php if ($generalSettings->show_pageviews == 1) : ?>
            <span><i class="icon-eye"></i>&nbsp;<?= $item->hit; ?></span>
        <?php endif; ?>
    </p>
</div>