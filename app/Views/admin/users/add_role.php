<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-sm-10">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("add_role"); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('roles-permissions'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans("roles"); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/addRolePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <?= view('admin/includes/_messages');
                    foreach ($languages as $language): ?>
                        <div class="form-group">
                            <label><?= trans("role_name"); ?> (<?= $language->name; ?>)</label>
                            <input type="text" class="form-control" name="role_name_<?= $language->id; ?>" placeholder="<?= trans("role_name"); ?>" maxlength="255" required>
                        </div>
                    <?php endforeach; ?>
                    <div class="form-group">
                        <label class="m-b-15"><?= trans("permissions"); ?></label>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <?php $permissions = getPermissionsArray();
                                if (!empty($permissions)):
                                    $i = 0;
                                    foreach ($permissions as $key => $value):
                                        if ($i <= 17):?>
                                            <div class="m-b-15">
                                                <input type="checkbox" name="permissions[]" value="<?= $key; ?>" id="per_<?= $key; ?>" class="square-purple">&nbsp;&nbsp;&nbsp;
                                                <label for="per_<?= $key; ?>" class="control-label cursor-pointer"><?= trans($value); ?></label>
                                            </div>
                                        <?php endif;
                                        $i++;
                                    endforeach;
                                endif; ?>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <?php if (!empty($permissions)):
                                    $i = 0;
                                    foreach ($permissions as $key => $value):
                                        if ($i > 17):?>
                                            <div class="m-b-15">
                                                <input type="checkbox" name="permissions[]" value="<?= $key; ?>" id="per_<?= $key; ?>" class="square-purple">&nbsp;&nbsp;&nbsp;
                                                <label for="per_<?= $key; ?>" class="control-label cursor-pointer"><?= trans($value); ?></label>
                                            </div>
                                        <?php endif;
                                        $i++;
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans("add_role"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>