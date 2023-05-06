<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('video'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="form-group">
            <label class="control-label"><?= trans('video_url'); ?>
                <small>(Youtube, Vimeo, Dailymotion, Facebook)</small>
            </label>
            <input type="text" class="form-control" name="video_url" id="video_url" placeholder="<?= trans('video_url'); ?>" value="<?= $post->video_url; ?>">
            <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right btn-get-embed" onclick="getVideoFromURL();"><?= trans('get_video'); ?></a>
        </div>

        <div class="form-group m-t-45">
            <label class="control-label"><?= trans('video_embed_code'); ?></label>
            <textarea class="form-control text-embed"
                      name="video_embed_code" id="video_embed_code" placeholder="<?= trans('video_embed_code'); ?>"><?= $post->video_embed_code; ?></textarea>
        </div>

        <?php if (!empty($post->video_embed_code)): ?>
            <iframe src="<?= $post->video_embed_code; ?>" id="video_embed_preview" frameborder="0" allow="encrypted-media" allowfullscreen class="video-embed-preview" style="display: block"></iframe>
        <?php else: ?>
            <iframe src="" id="video_embed_preview" frameborder="0" allow="encrypted-media" allowfullscreen class="video-embed-preview"></iframe>
        <?php endif; ?>
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('video_thumbnails'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="form-group m0">
            <label class="control-label"><?= trans('video_image'); ?></label>
            <div class="row">
                <div class="col-sm-12">
                    <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#image_file_manager" data-image-type="video_thumbnail">
                        <?= trans('select_image'); ?>
                    </a>
                </div>
                <div class="col-sm-12 m-t-15 m-b-10">
                    <img id="selected_image_file" src="<?= getPostImage($post, 'mid'); ?>" alt="" class="img-responsive"/>
                    <?php if (!empty($post->image_big) || !empty($post->image_url)): ?>
                        <a class="btn btn-danger btn-sm btn-delete-additional-image-database btn-delete-main-img" onclick="delete_video_image('<?= $post->id; ?>');">
                            <i class="fa fa-times"></i>
                        </a>
                    <?php endif; ?>
                    <input type="hidden" name="post_image_id">
                </div>
                <div class="col-sm-12 m-b-10">
                    <label><?= trans('or'); ?><br></label>
                </div>
                <div class="col-sm-12 m-b-15">
                    <?php if (!empty($post->image_url)): ?>
                        <input type="text" class="form-control" name="image_url" id="video_thumbnail_url" placeholder="<?= trans('add_image_url'); ?>"
                               value="<?= $post->image_url; ?>">
                    <?php else: ?>
                        <input type="text" class="form-control" name="image_url" id="video_thumbnail_url" placeholder="<?= trans('add_image_url'); ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
