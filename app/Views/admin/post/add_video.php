<div class="row">
    <div class="col-sm-12">
        <form action="<?= base_url('PostController/addPostPost'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="post_type" value="video">
            <div class="row">
                <div class="col-sm-12 form-header">
                    <h1 class="form-title"><?= trans('add_video'); ?></h1>
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
                            <?= view("admin/post/_form_add_post_left"); ?>
                        </div>
                        <div class="form-post-right">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= view('admin/post/_video_upload_box'); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/post/_upload_file_box'); ?>
                                </div>
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
                                                        <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label"><?= trans('category'); ?></label>
                                                <select id="categories" name="category_id" class="form-control max-600" onchange="getSubCategories(this.value);" required>
                                                    <option value=""><?= trans('select'); ?></option>
                                                    <?php if (!empty($parentCategories)):
                                                        foreach ($parentCategories as $item): ?>
                                                            <option value="<?= esc($item->id); ?>" <?= $item->id == old('category_id') ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                                                        <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label"><?= trans('subcategory'); ?></label>
                                                <select id="subcategories" name="subcategory_id" class="form-control max-600">
                                                    <option value="0"><?= trans('select'); ?></option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/includes/_post_publish_box', ['postType' => $postType]); ?>
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