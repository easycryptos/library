<section id="main">
    <div class="container">
        <div class="row">
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("forgot_password"); ?></li>
                </ol>
            </div>
            <div class="page-content">
                <div class="col-xs-12 col-sm-6 col-md-4 center-box">
                    <div class="content page-contact page-login">
                        <h1 class="page-title text-center"><?= trans("forgot_password"); ?></h1>
                        <?= view('partials/_messages'); ?>
                        <form action="<?= base_url('forgot-password-post'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-group has-feedback">
                                <input type="email" name="email" class="form-control" placeholder="<?= trans("email"); ?>" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-custom"><?= trans("reset_password"); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



