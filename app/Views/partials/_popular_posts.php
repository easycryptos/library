<div class="widget-title widget-popular-posts-title">
    <h4 class="title"><?= trans("popular_posts"); ?></h4>
</div>
<div class="col-sm-12 widget-body">
    <div class="row">
        <ul class="widget-list w-popular-list">
            <?php $popularPosts = getPopularPosts(5);
            if (!empty($popularPosts)):
                foreach ($popularPosts as $item): ?>
                    <li>
                        <div class="left">
                            <a href="<?= generatePostUrl($item); ?>">
                                <?= view("post/_post_image", ['postItem' => $item, 'type' => 'imageSmall']); ?>
                            </a>
                        </div>
                        <div class="right">
                            <h3 class="title">
                                <a href="<?= generatePostUrl($item); ?>"><?= esc(limitCharacter($item->title, 55, '...')); ?></a>
                            </h3>
                            <?= view("post/_post_meta", ['item' => $item]); ?>
                        </div>
                    </li>
                <?php endforeach;
            endif; ?>
        </ul>
    </div>
</div>
