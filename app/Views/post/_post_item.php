<?php if ($generalSettings->layout == "layout_2" || $generalSettings->layout == "layout_5"): ?>
    <div class="post-item-horizontal">
        <div class="item-image">
            <a href="<?= generateCategoryUrl($item->parent_category_slug, $item->category_slug); ?>">
                <span class="label-post-category"><?= esc($item->category_name); ?></span>
            </a>
            <a href="<?= generatePostUrl($item); ?>">
                <?= view("post/_post_image", ['postItem' => $item, 'type' => 'imageSlider']); ?>
            </a>
        </div>
        <div class="item-content">
            <h3 class="title">
                <a href="<?= generatePostUrl($item); ?>"><?= esc(limitCharacter($item->title, 55, '...')); ?></a>
            </h3>
            <?= view("post/_post_meta", ['item' => $item]); ?>
            <p class="summary"><?= esc(limitCharacter($item->summary, 130, '...')); ?></p>
            <div class="post-buttons">
                <a href="<?= generatePostUrl($item); ?>" class="pull-right read-more">
                    <?= trans("readmore"); ?>
                    <i class="icon-arrow-right read-more-i" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
<?php elseif ($generalSettings->layout == "layout_3" || $generalSettings->layout == "layout_6"): ?>
    <div class="col-sm-6 col-xs-12 item-boxed-cnt">
        <div class="col-xs-12 post-item-boxed p0">
            <div class="item-image">
                <a href="<?= generateCategoryUrl($item->parent_category_slug, $item->category_slug); ?>">
                    <span class="label-post-category"><?= esc($item->category_name); ?></span>
                </a>
                <a href="<?= generatePostUrl($item); ?>">
                    <?= view("post/_post_image", ['postItem' => $item, 'type' => 'imageSlider']); ?>
                </a>
            </div>
            <div class="item-content">
                <h3 class="title">
                    <a href="<?= generatePostUrl($item); ?>"><?= esc(limitCharacter($item->title, 50, '...')); ?></a>
                </h3>
                <?= view("post/_post_meta", ['item' => $item]); ?>
                <p class="summary">
                    <?= esc(limitCharacter($item->summary, 130, '...')); ?>
                </p>
                <div class="post-buttons">
                    <a href="<?= generatePostUrl($item); ?>" class="pull-right read-more">
                        <?= trans("readmore"); ?>
                        <i class="icon-arrow-right read-more-i" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-sm-12 post-item">
        <div class="row">
            <div class="post-image">
                <a href="<?= generatePostUrl($item); ?>">
                    <?= view("post/_post_image", ['postItem' => $item, 'type' => 'imageMid']); ?>
                </a>
            </div>
            <div class="post-footer">
                <div class="text-center">
                    <p class="default-post-label-category">
                        <a href="<?= generateCategoryUrl($item->parent_category_slug, $item->category_slug); ?>">
                            <span class="label-post-category"><?= esc($item->category_name); ?></span>
                        </a>
                    </p>
                    <h3 class="title">
                        <a href="<?= generatePostUrl($item); ?>"><?= esc($item->title); ?></a>
                    </h3>
                    <?= view("post/_post_meta", ['item' => $item]); ?>
                </div>
                <p class="summary text-center">
                    <?= esc($item->summary); ?>
                </p>
                <div class="post-buttons">
                    <a href="<?= generatePostUrl($item); ?>" class="pull-right read-more">
                        <?= trans("readmore"); ?>
                        <i class="icon-arrow-right read-more-i" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>