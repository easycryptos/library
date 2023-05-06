<?php if (isset($postItem)):
	$postImageUrl = "";
	$postImageBg = base_url('assets/img/bg_slider.png');
	$videoIconClass = "post-icon-lg";
	$iconSize = ' width="48" height="48"';
	if ($type == 'homeSlider') {
        $postImageUrl = getPostImage($postItem, 'slider');
        $imgSize = ' width="650" height="433"';
	} elseif ($type == 'homeSliderSecond') {
        $postImageUrl = getPostImage($postItem, 'mid');
        $postImageBg = base_url('assets/img/bg_mid.png');
        $imgSize = ' width="750" height="415"';
	} elseif ($type == 'randomSlider') {
        $postImageUrl = getPostImage($postItem, 'slider');
        $videoIconClass = "post-icon-md";
        $imgSize = ' width="650" height="433"';
        $iconSize = ' width="42" height="42"';
	}
	if (!empty($postItem->image_url) || $postItem->image_mime == 'gif' || $postItem->post_type == 'video'):?>
		<div class="external-image-container">
			<?php if ($postItem->post_type == 'video'): ?>
				<img src="<?= base_url('assets/img/icon_play.svg'); ?>" alt="icon" class="post-icon <?= $videoIconClass; ?>"<?= !empty($iconSize) ? $iconSize : ''; ?>/>
			<?php endif; ?>
			<img src="<?= $postImageBg; ?>" class="img-responsive" alt="fixer"<?= !empty($imgSize) ? $imgSize : ''; ?>>
			<img src="<?= $postImageBg; ?>" data-lazy="<?= $postImageUrl; ?>" class="img-responsive img-slider img-external" alt="<?= esc($postItem->title); ?>"<?= !empty($imgSize) ? $imgSize : ''; ?>>
		</div>
	<?php else: ?>
		<img src="<?= $postImageBg; ?>" class="img-responsive" alt="fixer"<?= !empty($imgSize) ? $imgSize : ''; ?>>
		<img src="<?= $postImageBg; ?>" data-lazy="<?= $postImageUrl; ?>" class="img-responsive img-slider img-external" alt="<?= esc($postItem->title); ?>"<?= !empty($imgSize) ? $imgSize : ''; ?>>
	<?php endif;
endif; ?>