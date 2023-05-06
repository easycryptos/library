<div class="slider-container">
	<div id="post-details-slider" class="random-slider post-details-slider">
		<?php if (!empty($post->image_big)): ?>
			<div class="home-slider-boxed-item">
				<img src="<?= getPostImage($post, 'big'); ?>" alt="<?= esc($post->title); ?>" class="img-responsive"/>
			</div>
		<?php endif; ?>
		<?php if (!empty($additionalImages)):
			foreach ($additionalImages as $image):?>
				<div class="home-slider-boxed-item">
					<img src="<?= base_url( $image->image_path); ?>" alt="<?= esc($post->title); ?>" class="img-responsive"/>
				</div>
			<?php endforeach;
		endif; ?>
	</div>
	<div id="post-details-slider-nav" class="slider-nav random-slider-nav">
		<button class="prev"><i class="icon-arrow-left"></i></button>
		<button class="next"><i class="icon-arrow-right"></i></button>
	</div>
</div>
