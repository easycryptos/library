<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EBOOK - Installer</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <!-- Font-awesome CSS -->
    <link href="../assets/admin/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">
            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>EBOOK</h1>
                    <p>Welcome to the Installer</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="install-box">
                        <div class="steps">
                            <div class="step-progress">
                                <div class="step-progress-line" data-now-value="60" data-number-of-steps="5" style="width: 60%;"></div>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-code"></i></div>
                                <p>Start</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-gear"></i></div>
                                <p>System Requirements</p>
                            </div>
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-folder-open"></i></div>
                                <p>Folder Permissions</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-database"></i></div>
                                <p>Database</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-user"></i></div>
                                <p>Settings</p>
                            </div>
                        </div>
                        <div class="step-contents">
                            <div class="tab-1">
                                <h1 class="step-title">Folder Permissions</h1>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><i class="fa fa-folder-open"></i> writable</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/blocks</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/files</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/gallery</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/images</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/logo</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/profile</p>
                                        <p><i class="fa fa-folder-open"></i> uploads/temp</p>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <p><?php if (is_writable('../writable')) { ?><i class="fa fa-check color-success"></i><?php } else { ?><i class="fa fa-close text-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/blocks')) { ?><i class="fa fa-check color-success"></i><?php } else { ?><i class="fa fa-close color-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/files')) { ?><i class="fa fa-check color-success"></i><?php } else { ?><i class="fa fa-close color-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/gallery')) { ?><i class="fa fa-check color-success"></i><?php } else { ?><i class="fa fa-close color-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/images')) { ?><i class="fa fa-check color-success"></i><?php } else { ?><i class="fa fa-close color-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/logo')) { ?><i class="fa fa-check color-success"></i><?php } else { ?><i class="fa fa-close color-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/profile')) { ?><i class="fa fa-check color-success"></i><?php } else { ?><i class="fa fa-close color-danger"></i><?php } ?></p>
                                        <p><?php if (is_writable('../uploads/temp')) { ?><i class="fa fa-check color-success"></i><?php } else { ?><i class="fa fa-close color-danger"></i><?php } ?></p>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <a href="system-requirements.php" class="btn btn-success btn-custom pull-left">Prev</a>
                                    <a href="database.php" class="btn btn-success btn-custom pull-right">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

