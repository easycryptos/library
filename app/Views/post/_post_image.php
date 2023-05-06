<?php if (isset($postItem)):
    $imgSize = ' width="750" height="415"';
	if ($type == 'imageSlider') {
		$imgUrl = getPostImage($postItem, 'slider');
		$bg = base_url('assets/img/bg_slider.png');
		$icon = "post-icon-md";
        $imgSize = ' width="650" height="433"';
	} elseif ($type == 'imageSmall') {
		$imgUrl = getPostImage($postItem, 'small');
		$bg = base_url('assets/img/bg_small.png');
		$icon = "post-icon-sm";
        $imgSize = ' width="100" height="75"';
	} else {
		$imgUrl = getPostImage($postItem, 'mid');
		$bg = base_url('assets/img/bg_mid.png');
		$icon = "post-icon-md";
	}
	if (!empty($postItem->image_url) || $postItem->image_mime == 'gif' || $postItem->post_type == 'video'):?>
		<div class="external-image-container">
			<?php if ($postItem->post_type == 'video'): ?>
				<img src="<?= base_url('assets/img/icon_play.svg'); ?>" alt="icon" class="post-icon <?= $icon; ?>" width="42" height="42"/>
			<?php endif; ?>
			<img src="<?= $bg; ?>" class="img-responsive" alt="<?= esc($postItem->title); ?>"<?= !empty($imgSize) ? $imgSize : ''; ?>>
			<img src="<?= $bg; ?>" data-src="<?= $imgUrl; ?>" alt="<?= esc($postItem->title); ?>" class="lazyload img-external" onerror='<?= $bg; ?>'<?= !empty($imgSize) ? $imgSize : ''; ?>>
		</div>
	<?php else: ?>
		<img src="<?= $bg; ?>" data-src="<?= $imgUrl; ?>" class="lazyload img-responsive" alt="<?= esc($postItem->title); ?>" onerror="javascript:this.src='<?= $bg; ?>'"<?= !empty($imgSize) ? $imgSize : ''; ?>>
	<?php endif;
endif; ?>
