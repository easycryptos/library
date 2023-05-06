<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('update_page'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/editPagePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= esc($page->id); ?>">
                <input type="hidden" name="redirect_url" value="<?= inputGet('redirect_url'); ?>">
                <div class="box-body">
                    <?= view('admin/includes/_messages'); ?>
                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= trans('title'); ?>" value="<?= esc($page->title); ?>" required>
                    </div>

                    <?php if ($page->is_custom == 1): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("slug"); ?>
                                <small>(<?= trans("slug_exp"); ?>)</small>
                            </label>
                            <input type="text" class="form-control" name="slug" placeholder="<?= trans("slug"); ?>" value="<?= esc($page->slug); ?>">
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="slug" value="<?= esc($page->slug); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="control-label"><?= trans("description"); ?> (<?= trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="page_description" placeholder="<?= trans("description"); ?> (<?= trans('meta_tag'); ?>)" value="<?= esc($page->page_description); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="page_keywords" placeholder="<?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)" value="<?= esc($page->page_keywords); ?>">
                    </div>

                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getMenuLinksByLang(this.value);" style="max-width: 600px;">
                            <?php if (!empty($languages)):
                                foreach ($languages as $language): ?>
                                    <option value="<?= $language->id; ?>" <?= $page->lang_id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <?php if ($page->location == "header"): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans('parent_link'); ?></label>
                            <select id="parent_links" name="parent_id" class="form-control" style="max-width: 600px;">
                                <option value="0"><?= trans('none'); ?></option>
                                <?php foreach ($menuItems as $menuItem): ?>
                                    <?php if ($menuItem->item_type != "category" && $menuItem->item_location == "header" && $menuItem->item_parent_id == "0" && $menuItem->item_id != $page->id): ?>
                                        <option value="<?= $menuItem->item_id; ?>" <?= $menuItem->item_id == $page->parent_id ? 'selected' : ''; ?>><?= $menuItem->item_name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="parent_id" value="<?= esc($page->parent_id); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label><?= trans('order'); ?></label>
                        <input type="number" class="form-control" name="page_order" placeholder="<?= trans('order'); ?>" value="<?= esc($page->page_order); ?>" min="1" style="width: 300px;max-width: 100%;">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('location'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="location_1" name="location" value="top" class="square-purple" <?= $page->location == 'top' ? 'checked' : ''; ?>>
                                <label for="location_1" class="cursor-pointer"><?= trans('top_menu'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="location_2" name="location" value="header" class="square-purple" <?= $page->location == 'header' ? 'checked' : ''; ?>>
                                <label for="location_2" class="cursor-pointer"><?= trans('main_menu'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="location_3" name="location" value="footer" class="square-purple" <?= $page->location == 'footer' ? 'checked' : ''; ?>>
                                <label for="location_3" class="cursor-pointer"><?= trans('footer'); ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ($page->slug != "terms-conditions"): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <label><?= trans('visibility'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="page_active_1" name="page_active" value="1" class="square-purple" <?= ($page->page_active == 1) ? 'checked' : ''; ?>>
                                    <label for="page_active_1" class="cursor-pointer"><?= trans('show'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="page_active_2" name="page_active" value="0" class="square-purple" <?= ($page->page_active == 0) ? 'checked' : ''; ?>>
                                    <label for="page_active_2" class="cursor-pointer"><?= trans('hide'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="page_active" value="<?= esc($page->page_active); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('show_only_registered'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="need_auth_1" name="need_auth" value="1" class="square-purple" <?= ($page->need_auth == 1) ? 'checked' : ''; ?>>
                                <label for="need_auth_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="need_auth_2" name="need_auth" value="0" class="square-purple" <?= ($page->need_auth == 0) ? 'checked' : ''; ?>>
                                <label for="need_auth_2" class="cursor-pointer"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('show_title'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="title_active_1" name="title_active" value="1" class="square-purple" <?= ($page->title_active == 1) ? 'checked' : ''; ?>>
                                <label for="title_active_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="title_active_2" name="title_active" value="0" class="square-purple" <?= ($page->title_active == 0) ? 'checked' : ''; ?>>
                                <label for="title_active_2" class="cursor-pointer"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('show_breadcrumb'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="breadcrumb_active_1" name="breadcrumb_active" value="1" class="square-purple" <?= ($page->breadcrumb_active == 1) ? 'checked' : ''; ?>>
                                <label for="breadcrumb_active_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="breadcrumb_active_2" name="breadcrumb_active" value="0" class="square-purple" <?= ($page->breadcrumb_active == 0) ? 'checked' : ''; ?>>
                                <label for="breadcrumb_active_2" class="cursor-pointer"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('show_right_column'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="right_column_active_1" name="right_column_active" value="1" class="square-purple" <?= ($page->right_column_active == 1) ? 'checked' : ''; ?>>
                                <label for="right_column_active_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="right_column_active_2" name="right_column_active" value="0" class="square-purple" <?= ($page->right_column_active == 0) ? 'checked' : ''; ?>>
                                <label for="right_column_active_2" class="cursor-pointer"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ($page->slug != "gallery" && $page->slug != "contact"): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="control-label"><?= trans('content'); ?></label>
                                    <div class="row">
                                        <div class="col-sm-12 editor-buttons">
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#image_file_manager" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?= trans("add_image"); ?></button>
                                        </div>
                                    </div>
                                    <textarea class="tinyMCE form-control" name="page_content"><?= $page->page_content; ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view('admin/file-manager/_load_file_manager', ['loadImages' => true, 'loadFiles' => false]); ?>
