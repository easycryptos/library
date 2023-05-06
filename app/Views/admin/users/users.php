<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('users'); ?></h3>
        </div>
    </div>
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('avatar'); ?></th>
                            <th><?= trans('username'); ?></th>
                            <th><?= trans('email'); ?></th>
                            <th><?= trans('role'); ?></th>
                            <th><?= trans('status'); ?></th>
                            <th><?= trans('date_added'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($users)):
                            foreach ($users as $user):
                                $roleName = @parseSerializedNameArray($user->role_name, $activeLang->id, true);?>
                                <tr>
                                    <td><?= esc($user->id); ?></td>
                                    <td>
                                        <img src="<?= getUserAvatar($user); ?>" alt="user" class="img-responsive" style="width: 70px; border-radius: 1px;">
                                    </td>
                                    <td><?= esc($user->username); ?></td>
                                    <td><?= esc($user->email); ?></td>
                                    <td>
                                        <?php if ($user->is_admin): ?>
                                            <label class="label bg-olive"><?= esc($roleName); ?></label>
                                        <?php elseif ($user->is_author): ?>
                                            <label class="label label-warning"><?= esc($roleName); ?></label>
                                        <?php else: ?>
                                            <label class="label label-default"><?= esc($roleName); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user->status == 1): ?>
                                            <label class="label label-success"><?= trans('active'); ?></label>
                                        <?php else: ?>
                                            <label class="label label-danger"><?= trans('banned'); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td class="nowrap"><?= formatDate($user->created_at); ?></td>
                                    <td>
                                        <form action="<?= base_url('AdminController/userOptionsPost'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?= esc($user->id); ?>">
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <button type="button" class="btn-list-button" data-toggle="modal" data-target="#myModal" onclick="$('#modal_user_id').val('<?= esc($user->id); ?>');">
                                                            <i class="fa fa-user option-icon"></i><?= trans('change_user_role'); ?>
                                                        </button>
                                                    </li>
                                                    <?php if ($user->status == "1"): ?>
                                                        <li>
                                                            <button type="submit" name="option" value="ban" class="btn-list-button">
                                                                <i class="fa fa-stop-circle option-icon"></i><?= trans('ban_user'); ?>
                                                            </button>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <button type="submit" name="option" value="remove_ban" class="btn-list-button">
                                                                <i class="fa fa-stop-circle option-icon"></i><?= trans('remove_ban'); ?>
                                                            </button>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="<?= adminUrl(); ?>/edit-user/<?= esc($user->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteUserPost','<?= $user->id; ?>','<?= trans("confirm_user"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= trans('change_user_role'); ?></h4>
            </div>
            <form action="<?= base_url('AdminController/changeUserRolePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="user_id" id="modal_user_id" value="">
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?= trans('save'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>