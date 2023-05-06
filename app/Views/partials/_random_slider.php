<div class="widget-title">
    <h4 class="title"><?= trans("random_posts"); ?></h4>
</div>
<div class="col-sm-12 widget-body">
    <div class="row">
        <?php $randomPosts = getRandomPosts(5);
        if (!empty($randomPosts)):?>
            <div class="slider-container">
                <div class="random-slider-fixer">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAooAAAGxAQMAAADf7wU8AAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAADlJREFUGBntwTEBAAAAwiD7p14JT2AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwFOMYwAB7fFpjAAAAABJRU5ErkJggg==" alt="img" width="1" height="1" style="width: 100% !important; height: auto !important;">
                </div>
                <div class="random-slider-container">
                    <div id="random-slider" class="random-slider">
                        <?php foreach ($randomPosts as $item) : ?>
                            <div class="home-slider-boxed-item">
                                <a href="<?= generatePostUrl($item); ?>">
                                    <?= view("post/_post_image_slider", ['postItem' => $item, 'type' => 'randomSlider']); ?>
                                </a>
                                <div class="item-info redirect-onclik" data-url="<?= generatePostUrl($item); ?>">
                                    <a href="<?= generateCategoryUrl($item->parent_category_slug, $item->category_slug); ?>">
										<span class="label label-danger label-slider-category">
											<?= esc($item->category_name); ?>
										</span>
                                    </a>
                                    <h3 class="title">
                                        <a href="<?= generatePostUrl($item); ?>"><?= esc(limitCharacter($item->title, 70, '...')); ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="random-slider-nav" class="slider-nav random-slider-nav">
                        <button class="prev"><i class="icon-arrow-left"></i></button>
                        <button class="next"><i class="icon-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
