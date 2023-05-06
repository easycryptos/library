<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('update_poll'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/editPollPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <?= view('admin/includes/_messages'); ?>
                    <input type="hidden" name="id" value="<?= esc($poll->id); ?>">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control max-600">
                            <?php foreach ($languages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $poll->lang_id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('question'); ?></label>
                        <textarea class="form-control text-area" name="question" placeholder="<?= trans('question'); ?>" required><?= esc($poll->question); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_1'); ?></label>
                        <input type="text" class="form-control" name="option1" placeholder="<?= trans('option_1'); ?>" value="<?= esc($poll->option1); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_2'); ?></label>
                        <input type="text" class="form-control" name="option2" placeholder="<?= trans('option_2'); ?>" value="<?= esc($poll->option2); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_3'); ?></label>
                        <input type="text" class="form-control" name="option3" placeholder="<?= trans('option_3'); ?> (<?= trans('optional'); ?>)" value="<?= esc($poll->option3); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_4'); ?></label>
                        <input type="text" class="form-control" name="option4" placeholder="<?= trans('option_4'); ?> (<?= trans('optional'); ?>)" value="<?= esc($poll->option4); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_5'); ?></label>
                        <input type="text" class="form-control" name="option5" placeholder="<?= trans('option_5'); ?> (<?= trans('optional'); ?>)" value="<?= esc($poll->option5); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_6'); ?></label>
                        <input type="text" class="form-control" name="option6" placeholder="<?= trans('option_6'); ?> (<?= trans('optional'); ?>)" value="<?= esc($poll->option6); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_7'); ?></label>
                        <input type="text" class="form-control" name="option7" placeholder="<?= trans('option_7'); ?> (<?= trans('optional'); ?>)" value="<?= esc($poll->option7); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_8'); ?></label>
                        <input type="text" class="form-control" name="option8" placeholder="<?= trans('option_8'); ?> (<?= trans('optional'); ?>)" value="<?= esc($poll->option8); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_9'); ?></label>
                        <input type="text" class="form-control" name="option9" placeholder="<?= trans('option_9'); ?> (<?= trans('optional'); ?>)" value="<?= esc($poll->option9); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('option_10'); ?></label>
                        <input type="text" class="form-control" name="option10" placeholder="<?= trans('option_10'); ?> (<?= trans('optional'); ?>)" value="<?= esc($poll->option10); ?>">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_status_1" name="status" value="1" class="square-purple" <?= ($poll->status == "1") ? 'checked' : ''; ?>>
                                <label for="rb_status_1" class="cursor-pointer"><?= trans('active'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_status_2" name="status" value="0" class="square-purple" <?= ($poll->status == "0") ? 'checked' : ''; ?>>
                                <label for="rb_status_2" class="cursor-pointer"><?= trans('inactive'); ?></label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>