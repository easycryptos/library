<div id="main">
    <div class="container">
        <div class="row">
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("rss_feeds"); ?></li>
                </ol>
            </div>
            <div id="content" class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="page-title"><?= trans("rss_feeds"); ?></h1>
                    </div>
                    <div class="col-sm-12">
                        <div class="page-content font-text page-rss">
                            <div class="rss-item">
                                <div class="left">
                                    <a href="<?= langBaseUrl('rss/latest-posts'); ?>" target="_blank"><i class="fa fa-rss"></i>&nbsp;&nbsp;<?= trans("latest_posts"); ?></a>
                                </div>
                                <div class="right">
                                    <p><a href="<?= langBaseUrl('rss/latest-posts'); ?>" target="_blank"><?= langBaseUrl('rss/latest-posts'); ?></a></p>
                                </div>
                            </div>
                            <div class="rss-item">
                                <div class="left">
                                    <a href="<?= langBaseUrl('rss/popular-posts'); ?>" target="_blank"><i class="fa fa-rss"></i>&nbsp;&nbsp;<?= trans("popular_posts"); ?></a>
                                </div>
                                <div class="right">
                                    <p><a href="<?= langBaseUrl('rss/popular-posts'); ?>" target="_blank"><?= langBaseUrl('rss/popular-posts'); ?></a></p>
                                </div>
                            </div>
                            <?php $categories = getCategories();
                            if (!empty($categories)):
                                foreach ($categories as $category):
                                    if ($category->parent_id == 0):?>
                                        <div class="rss-item">
                                            <div class="left">
                                                <a href="<?= langBaseUrl('rss/category/' . esc($category->slug)); ?>" target="_blank"><i class="fa fa-rss"></i>&nbsp;&nbsp;<?= esc($category->name); ?></a>
                                            </div>
                                            <div class="right">
                                                <p>
                                                    <a href="<?= langBaseUrl('rss/category/' . esc($category->slug)); ?>" target="_blank">
                                                        <?= langBaseUrl('rss/category/' . esc($category->slug)); ?>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


