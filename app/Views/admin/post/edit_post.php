<div class="row">
    <div class="col-sm-12">
        <form action="<?= base_url('PostController/editPostPost'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="post_type" value="post">
            <div class="row">
                <div class="col-sm-12 form-header">
                    <h1 class="form-title"><?= trans('update_post'); ?></h1>
                    <a href="<?= adminUrl('posts'); ?>" class="btn btn-success btn-add-new pull-right">
                        <i class="fa fa-bars"></i>
                        <?= trans('posts'); ?>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-post">
                        <div class="form-post-left">
                            <?= view("admin/post/_form_update_post_left"); ?>
                        </div>

                        <div class="form-post-right">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= view('admin/post/_upload_image_box'); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/post/_upload_additional_image_box'); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/post/_upload_file_box'); ?>
                                </div>
                                <?php if (isAdmin()): ?>
                                    <div class="col-sm-12">
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <div class="left">
                                                    <h3 class="box-title"><?= trans('post_owner'); ?></h3>
                                                </div>
                                            </div>
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <select name="user_id" class="form-control">
                                                        <?php if (!empty($users)):
                                                            foreach ($users as $user):
                                                                $roleName = @parseSerializedNameArray($user->role_name, $activeLang->id, true); ?>
                                                                <option value="<?= $user->id; ?>" <?= $post->user_id == $user->id ? 'selected' : ''; ?>><?= esc($user->username); ?>&nbsp;(<?= esc($roleName); ?>)</option>
                                                            <?php endforeach;
                                                        endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <input type="hidden" name="user_id" value="<?= $post->user_id; ?>">
                                <?php endif; ?>

                                <div class="col-sm-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <div class="left">
                                                <h3 class="box-title"><?= trans('category'); ?></h3>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label><?= trans("language"); ?></label>
                                                <select name="lang_id" class="form-control" onchange="getParentCategoriesByLang(this.value);">
                                                    <?php foreach ($languages as $language): ?>
                                                        <option value="<?= $language->id; ?>" <?= ($post->lang_id == $language->id) ? 'selected' : ''; ?>><?= $language->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?= trans('category'); ?></label>
                                                <select id="categories" name="category_id" class="form-control" onchange="getSubCategories(this.value);" required>
                                                    <option value=""><?= trans('select'); ?></option>
                                                    <?php if (!empty($categories)):
                                                        foreach ($categories as $item): ?>
                                                            <option value="<?= esc($item->id); ?>" <?= $item->id == $category_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                                                        <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label"><?= trans('subcategory'); ?></label>
                                                <select id="subcategories" name="subcategory_id" class="form-control">
                                                    <option value="0"><?= trans('select'); ?></option>
                                                    <?php if (!empty($subcategories)):
                                                        foreach ($subcategories as $item): ?>
                                                            <option value="<?= esc($item->id); ?>" <?= $item->id == $subcategory_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                                                        <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/includes/_post_publish_edit_box'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?= view('admin/file-manager/_load_file_manager', ['loadImages' => true, 'loadFiles' => true]); ?>