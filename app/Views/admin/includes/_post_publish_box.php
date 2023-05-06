<div class="box">
	<div class="box-header with-border">
		<div class="left">
			<h3 class="box-title"><?= trans('publish'); ?></h3>
		</div>
	</div>
	<div class="box-body">
		<div class="form-group">
			<?php if ($postType == 'video'): ?>
				<button type="submit" name="status" value="1" class="btn btn-primary pull-right"><?= trans('add_video'); ?></button>
			<?php else: ?>
				<button type="submit" name="status" value="1" class="btn btn-primary pull-right"><?= trans('add_post'); ?></button>
			<?php endif; ?>
			<button type="submit" name="status" value="0" class="btn btn-warning btn-draft pull-right"><?= trans('save_draft'); ?></button>
		</div>
	</div>
</div>
