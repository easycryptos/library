<div class="slider-container">
	<div class="home-slider-boxed-container">
		<div class="home-slider-boxed-fixer">
			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAGfAQMAAAA6RcVwAAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAADxJREFUGBntwQENAAAAwiD7p34PBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4E2aAQABq8lSAgAAAABJRU5ErkJggg==" class="img-responsive img-slider-second" alt="img" width="1" height="1">
		</div>
		<div id="home-slider-boxed" class="home-slider-boxed">
			<?php if (!empty($sliderPosts)):
				foreach ($sliderPosts as $item) : ?>
					<div class="home-slider-boxed-item">
						<a href="<?= generatePostUrl($item); ?>">
							<?= view("post/_post_image_slider", ['postItem' => $item, 'type' => 'homeSliderSecond']); ?>
						</a>
						<div class="item-info redirect-onclik" data-url="<?= generatePostUrl($item); ?>">
							<a href="<?= generateCategoryUrl($item->parent_category_slug, $item->category_slug); ?>">
							<span class="label label-danger label-slider-category">
								<?= esc($item->category_name); ?>
							</span>
							</a>
							<h2 class="title">
								<a href="<?= generatePostUrl($item); ?>">
									<?= esc(limitCharacter($item->title, 70, '...')); ?>
								</a>
							</h2>
							<?= view("post/_post_meta", ['item' => $item]); ?>
						</div>
					</div>
				<?php endforeach;
			endif; ?>
		</div>
		<div id="home-slider-boxed-nav" class="slider-nav">
			<button class="prev"><i class="icon-arrow-left"></i></button>
			<button class="next"><i class="icon-arrow-right"></i></button>
		</div>
	</div>
</div>