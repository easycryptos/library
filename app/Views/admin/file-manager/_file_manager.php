<div id="file_manager" class="modal fade modal-file-manager" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= trans('files'); ?></h4>
                <div class="file-manager-search">
                    <input type="text" id="input_search_file" class="form-control" placeholder="<?= trans("search"); ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="file-manager">
                    <div class="file-manager-left">
                        <div class="dm-uploader-container">
                            <div id="drag-and-drop-zone" class="dm-uploader text-center">
                                <?php if (!empty($generalSettings->allowed_file_extensions)):
                                    $exts = explode(',', $generalSettings->allowed_file_extensions ?? '');
                                    if (!empty($exts) && itemCount($exts) > 0): ?>
                                        <p class="file-manager-file-types">
                                            <?php foreach ($exts as $ext):
                                                $ext = str_replace('"', '', $ext ?? '');
                                                $ext = strtoupper($ext ?? ''); ?>
                                                <span><?= esc($ext); ?></span>
                                            <?php endforeach; ?>
                                        </p>
                                    <?php endif;
                                endif; ?>
                                <p class="dm-upload-icon">
                                    <i class="fa fa-cloud-upload"></i>
                                </p>
                                <p class="dm-upload-text"><?= trans("drag_drop_files_here"); ?></p>
                                <p class="text-center">
                                    <button class="btn btn-default btn-browse-files"><?= trans('browse_files'); ?></button>
                                </p>
                                <a class='btn btn-md dm-btn-select-files'>
                                    <input type="file" name="file" size="40" multiple="multiple">
                                </a>
                                <ul class="dm-uploaded-files" id="files-file"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="file-manager-right">
                        <div class="file-manager-content">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div id="file_upload_response">
                                        <?php if (!empty($files)):
                                            foreach ($files as $file): ?>
                                                <div class="col-file-manager" id="file_col_id_<?= $file->id; ?>">
                                                    <div class="file-box" data-file-id="<?= $file->id; ?>" data-file-name="<?= $file->file_name; ?>">
                                                        <div class="image-container icon-container">
                                                            <div class="file-icon file-icon-lg" data-type="<?= @pathinfo($file->file_name, PATHINFO_EXTENSION); ?>"></div>
                                                        </div>
                                                        <span class="file-name"><?= limitCharacter($file->file_name, 25, '..'); ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="selected_file_id">
                    <input type="hidden" id="selected_file_name">
                </div>
            </div>

            <div class="modal-footer">
                <div class="file-manager-footer">
                    <button type="button" id="btn_file_delete" class="btn btn-danger pull-left btn-file-delete"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?= trans('delete'); ?></button>
                    <button type="button" id="btn_file_select" class="btn bg-olive btn-file-select"><i class="fa fa-check"></i>&nbsp;&nbsp;<?= trans('select_file'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="files-template-file">
    <li class="media">
        <img class="preview-img" src="<?= base_url('assets/admin/plugins/file-manager/file.png'); ?>" alt="">
        <div class="media-body">
            <div class="progress">
                <div class="dm-progress-waiting"><?= trans("waiting"); ?></div>
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </li>
</script>
<?php $extArray = @explode(',', $generalSettings->allowed_file_extensions ?? ''); ?>
<script>
    var txtProcessing = "<?= trans("txt_processing"); ?>";
    $(function () {
        $('#drag-and-drop-zone').dmUploader({
            url: '<?= base_url("FileController/uploadFile"); ?>',
            queue: true,
            <?= !empty($extArray) && !empty($extArray[0]) > 0 ? 'extFilter:' . json_encode($extArray).',' : '';?>
            extraData: function (id) {
                return {
                    'file_id': id,
                    '<?= csrf_token() ?>': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onInit: function () {
            },
            onComplete: function (id) {
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "file");
                if (typeof FileReader !== "undefined") {
                    var reader = new FileReader();
                    var img = $('#uploaderFile' + id).find('img');

                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                refresh_files();
                document.getElementById("uploaderFile" + id).remove();
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
            },
            onFileTypeError: function (file) {
                swal({
                    text: "<?= trans("invalid_file_type");?>",
                    icon: "warning",
                    buttons: true
                });
            },
            onFileExtError: function (file) {
                swal({
                    text: "<?= trans("invalid_file_type");?>",
                    icon: "warning",
                    buttons: true
                });
            }
        });
    });
</script>
