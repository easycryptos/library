<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_user"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/addUserPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <?= view('admin/includes/_messages'); ?>
                    <div class="form-group">
                        <label><?= trans("username"); ?></label>
                        <input type="text" name="username" class="form-control auth-form-input" placeholder="<?= trans("username"); ?>" value="<?= old("username"); ?>" required>
                    </div>
                    <div class="form-group">
                        <label><?= trans("email"); ?></label>
                        <input type="email" name="email" class="form-control auth-form-input" placeholder="<?= trans("email"); ?>" value="<?= old("email"); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("role"); ?></label>
                        <select name="role_id" class="form-control" required>
                            <option value=""><?= trans("select"); ?></option>
                            <?php if (!empty($roles)):
                                foreach ($roles as $item):
                                    $roleName = @parseSerializedNameArray($item->role_name, $activeLang->id, true); ?>
                                    <option value="<?= $item->id; ?>"><?= esc($roleName); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= trans("password"); ?></label>
                        <input type="password" name="password" class="form-control auth-form-input" placeholder="<?= trans("password"); ?>" value="<?= old("password"); ?>" required>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_user'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>