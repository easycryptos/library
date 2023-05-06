<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('publish'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12 ">
                    <label><?= trans('date_publish'); ?></label>
                </div>
                <div class="col-sm-12">
                    <div class='input-group date' id='datetimepicker'>
                        <input type='text' class="form-control" name="date_published" placeholder="<?= trans("date_publish"); ?>" value="<?= $post->created_at; ?>"/>
                        <span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php if ($post->status == 0): ?>
                <button type="submit" name="publish" value="1" class="btn btn-warning pull-right" style="margin-left: 10px;"><?= trans('publish'); ?></button>
            <?php endif; ?>
            <button type="submit" name="publish" value="0" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
        </div>
    </div>
</div>
