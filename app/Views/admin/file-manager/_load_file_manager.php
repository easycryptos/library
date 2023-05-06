<link rel="stylesheet" href="<?= base_url('assets/admin/plugins/file-uploader/css/jquery.dm-uploader.min.css'); ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/admin/plugins/file-uploader/css/styles.css'); ?>"/>
<script src="<?= base_url('assets/admin/plugins/file-uploader/js/jquery.dm-uploader.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/file-uploader/js/demo-ui.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/admin/plugins/file-manager/fileicon.css'); ?>"/>

<?php if (!empty($loadImages)) {
    $images = getFileManagerImages(60);
    echo view("admin/file-manager/_file_manager_image", ['images' => $images]);
}
if (!empty($loadFiles)) {
    $files = getFileManagerFiles(60);
    echo view("admin/file-manager/_file_manager", ['files' => $files]);
} ?>