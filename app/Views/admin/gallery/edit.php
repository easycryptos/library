<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('update_image'); ?></h3>
            </div>
            <form action="<?= base_url('GalleryController/editGalleryImagePost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <input type="hidden" name="id" value="<?= esc($image->id); ?>">
                    <input type="hidden" name="path_big" value="<?= esc($image->path_big); ?>">
                    <input type="hidden" name="path_small" value="<?= esc($image->path_small); ?>">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getAlbumsByLang(this.value);">
                            <?php foreach ($languages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $image->lang_id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= trans("album"); ?></label>
                        <select name="album_id" id="albums" class="form-control" required onchange="getCategoriesByAlbums(this.value);">
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($albums)):
                                foreach ($albums as $album): ?>
                                    <option value="<?= $album->id; ?>" <?= $image->album_id == $album->id ? 'selected' : ''; ?>><?= $album->name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('category'); ?></label>
                        <select id="categories" name="category_id" class="form-control">
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($categories)):
                                foreach ($categories as $item): ?>
                                    <option value="<?= esc($item->id); ?>" <?= $item->id == $image->category_id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="<?= trans('title'); ?>" value="<?= esc($image->title); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('image'); ?> </label>
                        <div class="row">
                            <div class="col-sm-4">
                                <img src="<?= base_url($image->path_small); ?>" alt="" class="thumbnail img-responsive">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class='btn btn-success btn-sm btn-file-upload'>
                                    <?= trans('select_image'); ?>
                                    <input type="file" id="Multifileupload" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" style="cursor: pointer;">
                                </a>
                            </div>
                        </div>
                        <div id="MultidvPreview"></div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>