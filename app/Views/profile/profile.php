<section id="main">
    <div class="container">
        <div class="row">
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= esc($user->username); ?></li>
                    </li>
                </ol>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile-page-top">
                            <?= view("profile/_profile_user_info"); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile-page">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <div class="widget-followers">
                                        <div class="widget-head">
                                            <h3 class="title"><?= trans("following"); ?>&nbsp;(<?= count($following); ?>)</h3>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-content custom-scrollbar">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <?php if (!empty($following)):
                                                            foreach ($following as $item):?>
                                                                <div class="img-follower">
                                                                    <a href="<?= langBaseUrl('profile/' . esc($item->slug)); ?>">
                                                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?= getUserAvatar($item); ?>" alt="<?= esc($item->username); ?>" class="img-responsive lazyload">
                                                                    </a>
                                                                </div>
                                                            <?php endforeach;
                                                        endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-followers">
                                        <div class="widget-head">
                                            <h3 class="title"><?= trans("followers"); ?>&nbsp;(<?= count($followers); ?>)</h3>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-content custom-scrollbar-followers">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <?php if (!empty($followers)):
                                                            foreach ($followers as $item):?>
                                                                <div class="img-follower">
                                                                    <a href="<?= langBaseUrl('profile/' . esc($item->slug)); ?>">
                                                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?= getUserAvatar($item); ?>" alt="<?= esc($item->username); ?>" class="img-responsive lazyload">
                                                                    </a>
                                                                </div>
                                                            <?php endforeach;
                                                        endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <div class="col-xs-12 col-sm-12 posts p-0 posts-boxed">
                                        <div class="row">
                                            <?php $count = 0; ?>
                                            <?php foreach ($posts as $item): ?>
                                                <?php if ($count != 0 && $count % 2 == 0): ?>
                                                    <div class="col-sm-12 col-xs-12"></div>
                                                <?php endif; ?>
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
                                                                <a href="<?= generatePostUrl($item); ?>">
                                                                    <?= esc(limitCharacter($item->title, 40, '...')); ?>
                                                                </a>
                                                            </h3>
                                                            <?= view("post/_post_meta", ['item' => $item]); ?>
                                                            <p class="summary">
                                                                <?= esc(limitCharacter($item->summary, 130, '...')); ?>
                                                            </p>
                                                            <div class="post-buttons">
                                                                <a href="<?= generatePostUrl($item); ?>"
                                                                   class="pull-right read-more">
                                                                    <?= trans("readmore"); ?>
                                                                    <i class="icon-angle-right read-more-i" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($count == 1):
                                                    echo view('partials/_ad_spaces', ['adSpace' => 'posts_top', 'class' => 'm-b-30']);
                                                endif;
                                                $count++;
                                            endforeach; ?>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <?= view('partials/_ad_spaces', ['adSpace' => 'posts_bottom', 'class' => 'm-b-30']); ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <?= view('partials/_pagination'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>