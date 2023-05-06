<section id="main">
    <div class="container">
        <div class="row">
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl('settings'); ?>"><?= trans("settings"); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                </ol>
            </div>
            <div class="page-content">
                <div class="col-sm-12">
                    <h1 class="page-title"><?= trans("settings"); ?></h1>
                </div>
                <div class="col-sm-12 col-md-3">
                    <?= view("settings/_setting_tabs"); ?>
                </div>
                <div class="col-sm-12 col-md-9">
                    <div class="profile-tab-content">
                        <?= view('partials/_messages'); ?>
                        <form action="<?= base_url('change-password-post'); ?>" method="post" id="form_validate">
                            <?= csrf_field(); ?>
                            <?php if (!empty($user->password)): ?>
                                <div class="form-group">
                                    <label><?= trans("old_password"); ?></label>
                                    <input type="password" name="old_password" class="form-control form-input" value="<?= old("old_password"); ?>" placeholder="<?= trans("old_password"); ?>" required>
                                </div>
                                <input type="hidden" value="1" name="is_pass_exist">
                            <?php else: ?>
                                <input type="hidden" value="0" name="is_pass_exist">
                            <?php endif; ?>
                            <div class="form-group">
                                <label><?= trans("password"); ?></label>
                                <input type="password" name="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("password"); ?>" required>
                            </div>
                            <div class="form-group">
                                <label><?= trans("confirm_password"); ?></label>
                                <input type="password" name="password_confirm" class="form-control form-input" value="<?= old("password_confirm"); ?>" placeholder="<?= trans("confirm_password"); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-md btn-custom"><?= trans("change_password") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>