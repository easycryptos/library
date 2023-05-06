<?php

require_once 'functions.php';
require_once('includes/core_class.php');
require_once('includes/database_class.php');

if (isset($_POST["btn_install"])) {
    
    $data = [
        'db_host' => $_POST['db_host'],
        'db_name' => $_POST['db_name'],
        'db_user' => $_POST['db_user'],
        'db_password' => $_POST['db_password']
    ];
    $message = '';
    $installing = 0;
    try {
        $mysqli = new mysqli($data['db_host'], $data['db_user'], $data['db_password'], $data['db_name']);

        if (mysqli_connect_errno()) {
            $message = "The database could not be created, please check your database credentials!";
        }

        $core = new Core($mysqli);
        $database = new Database($mysqli);
        if ($database->create_database($data)) {
            if ($database->create_tables($data)) {
                if ($core->write_config($data)) {
                    $installing = 1;
                } else {
                    $message = "Unable to write config!";
                }
            } else {
                $message = "Unable to create database tables!";
            }
        } else {
            $message = "The database could not be created, please check your database credentials!";
        }
        $mysqli->close();

        // If no errors redirect
        if ($installing == 1) {
            header("Refresh: 10; admin.php");
        }
    } catch (Exception $e) {
        $message = "The database could not be created, please check your database credentials!";
    }
} else {
   
} ?>
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
                                <div class="step-progress-line" data-now-value="80" data-number-of-steps="5" style="width: 80%;"></div>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-code"></i></div>
                                <p>Start</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-gear"></i></div>
                                <p>System Requirements</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-folder-open"></i></div>
                                <p>Folder Permissions</p>
                            </div>
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-database"></i></div>
                                <p>Database</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-user"></i></div>
                                <p>Settings</p>
                            </div>
                        </div>
                        <div class="messages">
                            <?php if (!empty($message)) { ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $message; ?></strong>
                                </div>
                            <?php } ?>
                            <?php if (!empty($installing)) { ?>
                                <div class="alert alert-success">
                                    <strong>The database is being created. Please wait!</strong>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (!empty($installing)) { ?>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="spinner">
                                        <div class="rect1"></div>
                                        <div class="rect2"></div>
                                        <div class="rect3"></div>
                                        <div class="rect4"></div>
                                        <div class="rect5"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="step-contents">
                            <div class="tab-1">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    
                                    <div class="tab-content">
                                        <div class="tab_1">
                                            <h1 class="step-title">Database</h1>
                                            <div class="form-group">
                                                <label for="email">Host</label>
                                                <input type="text" class="form-control form-input" name="db_host" placeholder="Host" value="<?php echo isset($db_host) ? @$db_host : 'localhost'; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Database Name</label>
                                                <input type="text" class="form-control form-input" name="db_name" placeholder="Database Name" value="<?php echo @$db_name; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Username</label>
                                                <input type="text" class="form-control form-input" name="db_user" placeholder="Username" value="<?php echo @$db_user; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Password</label>
                                                <input type="text" class="form-control form-input" name="db_password" placeholder="Password" value="<?php echo @$db_password; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="folder-permissions.php?license_code=<?php echo $license_code; ?>&purchase_code=<?php echo $purchase_code; ?>" class="btn btn-success btn-custom pull-left">Prev</a>
                                        <button type="submit" name="btn_install" class="btn btn-success btn-custom pull-right">Next</button>
                                    </div>
                                </form>
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

