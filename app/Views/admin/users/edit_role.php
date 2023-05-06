<div class="row">
    <div class="col-sm-10">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("edit_role"); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('roles-permissions'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans("roles"); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/editRolePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $role->id ?>">
                <div class="box-body">
                    <?= view('admin/includes/_messages'); ?>
                    <?php foreach ($languages as $language):
                        $roleName = parseSerializedNameArray($role->role_name, $language->id, false); ?>
                        <div class="form-group">
                            <label><?= trans("role_name"); ?> (<?= $language->name; ?>)</label>
                            <input type="text" class="form-control" name="role_name_<?= $language->id; ?>" value="<?= esc($roleName); ?>" placeholder="<?= trans("role_name"); ?>" maxlength="255" required>
                        </div>
                    <?php endforeach;
                    if ($role->is_default != 1): ?>
                        <div class="form-group">
                            <label class="m-b-15"><?= trans("permissions"); ?></label>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <?php $permissions = getPermissionsArray();
                                    if (!empty($permissions)):
                                        $i = 0;
                                        $rolePermissions = explode(',', $role->permissions);
                                        foreach ($permissions as $key => $value):
                                            if ($i <= 17):?>
                                                <div class="m-b-15">
                                                    <?php if (is_array($rolePermissions) && in_array($key, $rolePermissions)): ?>
                                                        <input type="checkbox" name="permissions[]" value="<?= $key; ?>" id="per_<?= $key; ?>" class="square-purple" checked>&nbsp;&nbsp;&nbsp;
                                                    <?php else: ?>
                                                        <input type="checkbox" name="permissions[]" value="<?= $key; ?>" id="per_<?= $key; ?>" class="square-purple">&nbsp;&nbsp;&nbsp;
                                                    <?php endif; ?>
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
                                        $rolePermissions = explode(',', $role->permissions);
                                        if (!empty($rolePermissions)):
                                            foreach ($permissions as $key => $value):
                                                if ($i > 17):?>
                                                    <div class="m-b-15">
                                                        <?php if (is_array($rolePermissions) && in_array($key, $rolePermissions)): ?>
                                                            <input type="checkbox" name="permissions[]" value="<?= $key; ?>" id="per_<?= $key; ?>" class="square-purple" checked>&nbsp;&nbsp;&nbsp;
                                                        <?php else: ?>
                                                            <input type="checkbox" name="permissions[]" value="<?= $key; ?>" id="per_<?= $key; ?>" class="square-purple">&nbsp;&nbsp;&nbsp;
                                                        <?php endif; ?>
                                                        <label for="per_<?= $key; ?>" class="control-label cursor-pointer"><?= trans($value); ?></label>
                                                    </div>
                                                <?php endif;
                                                $i++;
                                            endforeach;
                                        endif;
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans("save_changes"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>