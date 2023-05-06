<div class="footer-widget f-widget-random">
    <div class="col-sm-12">
        <div class="row">
            <h4 class="title"><?= trans("latest_posts"); ?></h4>
            <div class="title-line"></div>
            <ul class="f-random-list">
                <?php $latestPosts = getLatestPosts(3);
                if (!empty($latestPosts)):
                    foreach ($latestPosts as $item): ?>
                        <li>
                            <div class="left">
                                <a href="<?= langBaseUrl(esc($item->title_slug)); ?>"><?= view("post/_post_image", ['postItem' => $item, 'type' => 'imageSmall']); ?></a>
                            </div>
                            <div class="right">
                                <h5 class="title">
                                    <a href="<?= langBaseUrl(esc($item->title_slug)); ?>"><?= esc(limitCharacter($item->title, 55, '...')); ?></a>
                                </h5>
                            </div>
                        </li>
                    <?php endforeach;
                endif; ?>
            </ul>
        </div>
    </div>
</div>
