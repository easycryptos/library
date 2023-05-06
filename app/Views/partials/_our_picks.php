<div class="widget-title widget-popular-posts-title">
	<h4 class="title"><?= trans("our_picks"); ?></h4>
</div>
<div class="col-sm-12 widget-body">
	<div class="row">
		<ul class="widget-list w-our-picks-list">
			<?php $ourPicks = getOurPicks(5);
			if (!empty($ourPicks)):
				foreach ($ourPicks as $item): ?>
					<li>
						<div class="post-image">
							<a href="<?= generateCategoryUrl($item->parent_category_slug, $item->category_slug); ?>">
                            <span class="label-post-category"><?= esc($item->category_name); ?></span>
							</a>
							<a href="<?= generatePostUrl($item); ?>"><?= view("post/_post_image", ['postItem' => $item, 'type' => 'imageMid']); ?></a>
						</div>
						<h3 class="title">
							<a href="<?= generatePostUrl($item); ?>"><?= esc(limitCharacter($item->title, 55, '...')); ?></a>
						</h3>
						<?= view("post/_post_meta", ['item' => $item]); ?>
					</li>
				<?php endforeach;
			endif; ?>
		</ul>
	</div>
</div>
