<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= esc($title); ?> - <?= trans("admin"); ?>&nbsp;<?= esc($settings->site_title); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?= getFavicon($generalSettings); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/custom.css'); ?>">
    <style>.error-message p {color: #dc3545 !important; text-align: center}</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="<?= adminUrl('login'); ?>"><b><?= esc($settings->application_name); ?></b>&nbsp;<?= trans("panel"); ?></a>
    </div>
    <div class="login-box-body">
        <h4 class="login-box-msg"><?= trans("login"); ?></h4>
        <?= view('partials/_messages'); ?>
        <form action="<?= adminUrl('login-post'); ?>" method="post" id="form_validate" class="validate_terms">
            <?= csrf_field(); ?>
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control form-input" placeholder="<?= trans("username_or_email"); ?>" value="<?= old('username'); ?>" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control form-input" placeholder="<?= trans("password"); ?>" value="<?= old('password'); ?>" required>
                <span class=" glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-sm-8 col-xs-12"></div>
                <div class="col-sm-4 col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <?= trans("login"); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="text-center" style="margin-top: 15px;">
        <a href="<?= langBaseUrl(); ?>"><?= trans("go_to_home"); ?></a>
    </div>
</div>
</body>
</html>