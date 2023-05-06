<section id="main">
    <div class="container">
        <div class="row">
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= esc($title); ?></li>
                </ol>
            </div>
            <div class="page-content">
                <div class="col-xs-12 col-sm-6 col-md-4 center-box">
                    <div class="content page-contact page-login">
                        <h1 class="page-title text-center"><?= esc($title); ?></h1>
                        <?= view('partials/_messages'); ?>
                        <form action="<?= base_url('reset-password-post'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <?php if (!empty($user)): ?>
                                <input type="hidden" name="token" value="<?= esc($user->token); ?>">
                            <?php endif;
                            if (!empty($pass_reset_completed)): ?>
                                <div class="form-group m-t-30">
                                    <a href="<?= langBaseUrl('login'); ?>" class="btn btn-md btn-custom btn-block"><?= trans("login"); ?></a>
                                </div>
                            <?php else: ?>
                                <div class="form-group">
                                    <label><?= trans("new_password"); ?></label>
                                    <input type="password" name="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("new_password"); ?>" required>
                                </div>
                                <div class="form-group m-b-30">
                                    <label><?= trans("confirm_password"); ?></label>
                                    <input type="password" name="password_confirm" class="form-control form-input" value="<?= old("password_confirm"); ?>" placeholder="<?= trans("confirm_password"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-custom btn-block"><?= trans("submit"); ?></button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>