<div class="slider-container">
    <div class="container-fluid">
        <div class="row">
            <div class="home-slider-fixer">
                <div class="col-sl">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAooAAAGxAQMAAADf7wU8AAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAADlJREFUGBntwTEBAAAAwiD7p14JT2AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwFOMYwAB7fFpjAAAAABJRU5ErkJggg==" alt="img" width="1" height="1">
                </div>
                <div class="col-sl col-sl-2"></div>
                <div class="col-sl col-sl-3"></div>
                <div class="col-sl col-sl-4"></div>
            </div>
        </div>
    </div>
    <div class="home-slider-container">
        <div id="home-slider" class="home-slider">
            <?php if (!empty($sliderPosts)):
                $i = 0;
                foreach ($sliderPosts as $item) : ?>
                    <div class="home-slider-item dd<?= $i; ?>">
                        <a href="<?= generatePostUrl($item); ?>">
                            <?= view("post/_post_image_slider", ['postItem' => $item, 'type' => 'homeSlider']); ?>
                        </a>
                        <div class="item-info redirect-onclik" data-url="<?= generatePostUrl($item); ?>">
                            <a href="<?= generateCategoryUrl($item->parent_category_slug, $item->category_slug); ?>">
							<span class="label label-danger label-slider-category">
								<?= esc($item->category_name); ?>
							</span>
                            </a>
                            <h2 class="title">
                                <a href="<?= generatePostUrl($item); ?>"><?= esc(limitCharacter($item->title, 70, '...')); ?></a>
                            </h2>
                            <?= view("post/_post_meta", ['item' => $item]); ?>
                        </div>
                    </div>
                    <?php $i++;
                endforeach;
            endif; ?>
        </div>
        <div id="home-slider-nav" class="slider-nav">
            <button class="prev"><i class="icon-arrow-left"></i></button>
            <button class="next"><i class="icon-arrow-right"></i></button>
        </div>
    </div>
</div>
