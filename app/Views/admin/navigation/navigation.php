<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_link"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/addMenuLinkPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getMenuLinksByLang(this.value);">
                            <?php if (!empty($languages)):
                                foreach ($languages as $language): ?>
                                    <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= trans("title"); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= trans("title"); ?>" value="<?= old('title'); ?>" maxlength="200" required>
                    </div>

                    <div class="form-group">
                        <label><?= trans("link"); ?></label>
                        <input type="text" class="form-control" name="link" placeholder="<?= trans("link"); ?>" value="<?= old('link'); ?>">
                    </div>
                    <div class="form-group">
                        <label><?= trans('order'); ?></label>
                        <input type="number" class="form-control" name="page_order" placeholder="<?= trans('order'); ?>" value="1" min="1">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans('parent_link'); ?></label>
                        <select id="parent_links" name="parent_id" class="form-control">
                            <option value="0"><?= trans('none'); ?></option>
                            <?php if (!empty($menuItems)):
                                foreach ($menuItems as $menuItem): ?>
                                    <?php if ($menuItem->item_lang_id == $activeLang->id && $menuItem->item_type != "category" && $menuItem->item_location == "header" && $menuItem->item_parent_id == "0"): ?>
                                        <option value="<?= $menuItem->item_id; ?>"><?= $menuItem->item_name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?= trans('show_on_menu'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_show_on_menu_1" name="page_active" value="1" class="square-purple" checked>
                                <label for="rb_show_on_menu_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_show_on_menu_2" name="page_active" value="0" class="square-purple">
                                <label for="rb_show_on_menu_2" class="cursor-pointer"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_link'); ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("menu_limit"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/menuLimitPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans('menu_limit'); ?></label>
                        <input type="number" class="form-control" name="menu_limit" placeholder="<?= trans('menu_limit'); ?>" value="<?= $generalSettings->menu_limit; ?>" min="1" max="99999" required>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('navigation'); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th style="max-width: 75px;"><?= trans('order'); ?></th>
                                    <th><?= trans('title'); ?></th>
                                    <th><?= trans('parent_link'); ?></th>
                                    <th class="th-lang"><?= trans('language'); ?></th>
                                    <th><?= trans('visibility'); ?></th>
                                    <th class="max-width-120"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($menuItems)):
                                    foreach ($menuItems as $menuItem): ?>
                                        <?php if ($menuItem->item_location == "header"): ?>
                                            <tr>
                                                <td><?= $menuItem->item_order; ?></td>
                                                <td>
                                                    <?= esc($menuItem->item_name);

                                                    if ($menuItem->item_type == "category"): ?>
                                                        <span class="nav-item-type">(<?= trans("category"); ?>)</span>
                                                    <?php elseif ($menuItem->item_type == "page" && empty($menuItem->item_link)): ?>
                                                        <span class="nav-item-type">(<?= trans("page"); ?>)</span>
                                                    <?php else: ?>
                                                        <span class="nav-item-type">(<?= trans("link"); ?>)</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php $parent = getParentLink($menuItem->item_parent_id, $menuItem->item_type); ?>
                                                    <?php if (!empty($parent)): ?>
                                                        <?php if ($menuItem->item_type == "page"):
                                                            echo $parent->title;
                                                        endif; ?>
                                                        <?php if ($menuItem->item_type == "category"):
                                                            echo $parent->name;
                                                        endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $lang = getLanguageById($menuItem->item_lang_id);
                                                    if (!empty($lang)) {
                                                        echo esc($lang->name);
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php if ($menuItem->item_visibility == 0): ?>
                                                        <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                                    <?php else: ?>
                                                        <label class="label label-success"><i class="fa fa-eye"></i></label>
                                                    <?php endif; ?>
                                                </td>

                                                <?php if ($menuItem->item_type == "category"): ?>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu options-dropdown">
                                                                <li>
                                                                    <a href="<?= adminUrl(); ?>/edit-category/<?= $menuItem->item_id; ?>?redirect_url=navigation"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" onclick="deleteItem('CategoryController/deleteCategoryPost','<?= $menuItem->item_id; ?>','<?= trans("confirm_category"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                <?php elseif ($menuItem->item_type == "page" && empty($menuItem->item_link)): ?>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu options-dropdown">
                                                                <li>
                                                                    <a href="<?= adminUrl(); ?>/edit-page/<?= $menuItem->item_id; ?>?redirect_url=navigation"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" onclick="deleteItem('AdminController/deletePagePost','<?= $menuItem->item_id; ?>','<?= trans("confirm_page"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                <?php else: ?>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu options-dropdown">
                                                                <li>
                                                                    <a href="<?= adminUrl('edit-menu-link/' . $menuItem->item_id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteNavigationPost','<?= $menuItem->item_id; ?>','<?= trans("confirm_link"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
