<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('add_image'); ?></h3>
            </div>
            <form action="<?= base_url('GalleryController/addGalleryImagePost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getAlbumsByLang(this.value);" required>
                            <?php foreach ($languages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= trans("album"); ?></label>
                        <select name="album_id" id="albums" class="form-control" required onchange="getCategoriesByAlbums(this.value);">
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($albums)):
                                foreach ($albums as $album): ?>
                                    <option value="<?= $album->id; ?>"><?= $album->name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('category'); ?></label>
                        <select id="categories" name="category_id" class="form-control">
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($categories)):
                                foreach ($categories as $item):?>
                                    <option value="<?= esc($item->id); ?>"><?= esc($item->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="<?= trans('title'); ?>" value="<?= old('title'); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('image'); ?></label>
                        <div class="col-sm-12">
                            <div class="row">
                                <a class='btn btn-success btn-sm btn-file-upload'>
                                    <?= trans('select_image'); ?>
                                    <input type="file" id="Multifileupload" name="files[]" size="40" accept=".png, .jpg, .jpeg, .gif" multiple="multiple" required>
                                </a>
                                <span>(<?= trans("select_multiple_images"); ?>)</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div id="MultidvPreview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_image'); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('gallery'); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('image'); ?></th>
                                    <th><?= trans('title'); ?></th>
                                    <th><?= trans('language'); ?></th>
                                    <th><?= trans('album'); ?></th>
                                    <th><?= trans('category'); ?></th>
                                    <th><?= trans('date'); ?></th>
                                    <th class="max-width-120"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($images)):
                                    foreach ($images as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td>
                                                <div style="position: relative">
                                                    <img src="<?= base_url($item->path_small); ?>" alt="" class="img-responsive" style="max-width: 140px; max-height: 140px;">
                                                    <?php if ($item->is_album_cover): ?>
                                                        <label class="label label-success" style="position: absolute;left: 0;top: 0;"><?= trans("album_cover"); ?></label>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?= esc($item->title); ?></td>
                                            <td>
                                                <?php $lang = getLanguageById($item->lang_id);
                                                if (!empty($lang)) {
                                                    echo esc($lang->name);
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($item->album_name)):
                                                    echo esc($item->album_name);
                                                endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($item->category_name)):
                                                    echo esc($item->category_name);
                                                endif; ?>
                                            </td>
                                            <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <?php if ($item->is_album_cover == 0): ?>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="setAsAlbumCover('<?= $item->id; ?>');"><i class="fa fa-check option-icon"></i><?= trans('set_as_album_cover'); ?></a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <li>
                                                            <a href="<?= adminUrl('edit-gallery-image/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="deleteItem('GalleryController/deleteGalleryImagePost','<?= $item->id; ?>','<?= trans("confirm_image"); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
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
    </div>
</div>