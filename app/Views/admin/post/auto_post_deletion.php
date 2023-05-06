<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("auto_post_deletion"); ?></h3>
                </div>
            </div>
            <form action="<?= base_url('PostController/autoPostDeletionPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="auto_post_deletion" value="1" id="auto_post_deletion_1"
                                       class="square-purple" <?= $generalSettings->auto_post_deletion == 1 ? 'checked' : ''; ?>>
                                <label for="auto_post_deletion_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="auto_post_deletion" value="0" id="auto_post_deletion_2"
                                       class="square-purple" <?= $generalSettings->auto_post_deletion != 1 ? 'checked' : ''; ?>>
                                <label for="auto_post_deletion_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('posts'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="auto_post_deletion_delete_all" value="1" id="auto_post_deletion_delete_all_1"
                                       class="square-purple" <?= $generalSettings->auto_post_deletion_delete_all == 1 ? 'checked' : ''; ?>>
                                <label for="auto_post_deletion_delete_all_1" class="option-label"><?= trans('delete_all_posts'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="auto_post_deletion_delete_all" value="0" id="auto_post_deletion_delete_all_2"
                                       class="square-purple" <?= $generalSettings->auto_post_deletion_delete_all != 1 ? 'checked' : ''; ?>>
                                <label for="auto_post_deletion_delete_all_2" class="option-label"><?= trans('delete_only_rss_posts'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= trans('number_of_days'); ?>&nbsp;<small>(E.g. <?= trans("number_of_days_exp") ?>)</small></label>
                        <input type="number" class="form-control" name="auto_post_deletion_days" value="<?= esc($generalSettings->auto_post_deletion_days); ?>" min="1" max="99999999" required>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans("save_changes"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>