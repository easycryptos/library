<div class="box">
	<div class="box-header with-border">
		<div class="left">
			<h3 class="box-title"><?= trans('post_details'); ?></h3>
		</div>
	</div>
	<div class="box-body">
		<?= view('admin/includes/_messages'); ?>
		<div class="form-group">
			<label class="control-label"><?= trans('title'); ?></label>
			<input type="text" class="form-control" name="title" placeholder="<?= trans('title'); ?>" value="<?= old('title'); ?>" required>
		</div>

		<div class="form-group">
			<label class="control-label"><?= trans('slug'); ?>
				<small>(<?= trans('slug_exp'); ?>)</small>
			</label>
			<input type="text" class="form-control" name="title_slug" placeholder="<?= trans('slug'); ?>" value="<?= old('title_slug'); ?>">
		</div>

		<div class="form-group">
			<label class="control-label"><?= trans('summary'); ?> & <?= trans("description"); ?> (<?= trans('meta_tag'); ?>)</label>
			<textarea class="form-control text-area" name="summary" placeholder="<?= trans('summary'); ?> & <?= trans("description"); ?> (<?= trans('meta_tag'); ?>)"><?= old('summary'); ?></textarea>
		</div>

		<div class="form-group">
			<label class="control-label"><?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)</label>
			<input type="text" class="form-control" name="keywords" placeholder="<?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)" value="<?= old('keywords'); ?>">
		</div>

		<?php if (isAdmin()): ?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-3 col-xs-12">
						<label><?= trans('add_slider'); ?></label>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 col-option">
						<input type="checkbox" name="is_slider" value="1" class="square-purple">
					</div>
				</div>
			</div>
		<?php else: ?>
			<input type="hidden" name="is_slider" value="0">
		<?php endif; ?>

		<?php if (isAdmin()): ?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-3 col-xs-12">
						<label><?= trans('add_picked'); ?></label>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 col-option">
						<input type="checkbox" name="is_picked" value="1" class="square-purple">
					</div>
				</div>
			</div>
		<?php else: ?>
			<input type="hidden" name="is_picked" value="0">
		<?php endif; ?>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<label><?= trans('show_only_registered'); ?></label>
				</div>
				<div class="col-md-2 col-sm-4 col-xs-12 col-option">
					<input type="checkbox" name="need_auth" value="1" class="square-purple">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label"><?= trans('tags'); ?></label>
					<input id="tags_1" type="text" name="tags" class="form-control tags"/>
					<small>(<?= trans('type_tag'); ?>)</small>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label"><?= trans('optional_url'); ?></label>
					<input type="text" class="form-control" name="optional_url" placeholder="<?= trans('optional_url'); ?>" value="<?= old('optional_url'); ?>">
				</div>
			</div>
		</div>

	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<label class="control-label"><?= trans('content'); ?></label>
		<div class="row">
			<div class="col-sm-12 editor-buttons">
				<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#image_file_manager" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?= trans("add_image"); ?></button>
			</div>
		</div>
		<textarea class="tinyMCE form-control" name="content"><?= old('content'); ?></textarea>
	</div>
</div>