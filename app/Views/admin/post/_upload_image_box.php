<script>var txt_select_image = "<?= trans("select_image"); ?>";</script>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('image'); ?>
                <small class="small-title"><?= trans('main_post_image'); ?></small>
            </h3>
        </div>
    </div>
    <div class="box-body">
        <div class="form-group m-0">
            <?php if (!empty($post) && !empty($post->image_mid)):
                $postImgUrl = base_url($post->image_mid);
                if (empty($post->image_mid)) {
                    $postImgUrl = $post->image_url;
                } ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?php if (!empty($postImgUrl)): ?>
                            <div id="post_select_image_container" class="post-select-image-container">
                                <img src="<?= $postImgUrl; ?>" id="selected_image_file" alt="">
                                <a id="btn_delete_post_main_image_database" class="btn btn-danger btn-sm btn-delete-selected-file-image" data-post-id="<?= $post->id; ?>">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <div id="post_select_image_container" class="post-select-image-container">
                                <a class="btn-select-image" data-toggle="modal" data-target="#image_file_manager" data-image-type="main">
                                    <div class="btn-select-image-inner">
                                        <i class="fa fa-image"></i>
                                        <button class="btn"><?= trans("select_image"); ?></button>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="post_image_id" id="post_image_id">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label><?= trans('or'); ?>&nbsp;<?= trans('add_image_url'); ?></label>
                    </div>
                </div>
                <div class="row m-b-15">
                    <div class="col-sm-12 m-b-5">
                        <input type="text" class="form-control" name="image_url" id="input_image_url" placeholder="<?= trans('add_image_url'); ?>" value="<?= $post->image_url; ?>">
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="post_select_image_container" class="post-select-image-container">
                            <a class="btn-select-image" data-toggle="modal" data-target="#image_file_manager" data-image-type="main">
                                <div class="btn-select-image-inner">
                                    <i class="fa fa-image"></i>
                                    <button class="btn"><?= trans("select_image"); ?></button>
                                </div>
                            </a>
                        </div>
                        <input type="hidden" name="post_image_id" id="post_image_id">
                    </div>
                </div>
                <div class="row m-b-15">
                    <div class="col-sm-12">
                        <label><?= trans('or'); ?>&nbsp;<?= trans('add_image_url'); ?></label>
                    </div>
                    <div class="col-sm-12 m-b-5">
                        <input type="text" class="form-control" name="image_url" id="input_image_url" placeholder="<?= trans('add_image_url'); ?>">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>