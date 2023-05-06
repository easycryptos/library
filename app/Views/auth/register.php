<section id="main">
    <div class="container">
        <div class="row">
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("register"); ?></li>
                </ol>
            </div>
            <div class="page-content">
                <div class="col-xs-12 col-sm-6 col-md-4 center-box">
                    <div class="content page-contact page-login">
                        <h1 class="page-title text-center"><?= trans("register"); ?></h1>
                        <form action="<?= base_url('register-post'); ?>" method="post" id="form_validate" class="validate_terms">
                            <?= csrf_field(); ?>
                            <?php if (!empty($generalSettings->facebook_app_id)): ?>
                                <a href="<?= base_url('connect-with-facebook'); ?>" class="btn btn-social btn-social-facebook">
                                    <svg width="24" height="24" viewBox="0 0 14222 14222">
                                        <circle cx="7111" cy="7112" r="7111" fill="#ffffff"/>
                                        <path d="M9879 9168l315-2056H8222V5778c0-562 275-1111 1159-1111h897V2917s-814-139-1592-139c-1624 0-2686 984-2686 2767v1567H4194v2056h1806v4969c362 57 733 86 1111 86s749-30 1111-86V9168z" fill="#1877f2"/>
                                    </svg>
                                    <span><?= trans("connect_with_facebook"); ?></span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($generalSettings->google_client_id)): ?>
                                <a href="<?= base_url('connect-with-google'); ?>" class="btn btn-social btn-social-google">
                                    <svg width="24" height="24" viewBox="0 0 128 128">
                                        <rect clip-rule="evenodd" fill="none" fill-rule="evenodd" height="128" width="128"/>
                                        <path clip-rule="evenodd" d="M27.585,64c0-4.157,0.69-8.143,1.923-11.881L7.938,35.648    C3.734,44.183,1.366,53.801,1.366,64c0,10.191,2.366,19.802,6.563,28.332l21.558-16.503C28.266,72.108,27.585,68.137,27.585,64" fill="#FBBC05" fill-rule="evenodd"/>
                                        <path clip-rule="evenodd" d="M65.457,26.182c9.031,0,17.188,3.2,23.597,8.436L107.698,16    C96.337,6.109,81.771,0,65.457,0C40.129,0,18.361,14.484,7.938,35.648l21.569,16.471C34.477,37.033,48.644,26.182,65.457,26.182" fill="#EA4335" fill-rule="evenodd"/>
                                        <path clip-rule="evenodd" d="M65.457,101.818c-16.812,0-30.979-10.851-35.949-25.937    L7.938,92.349C18.361,113.516,40.129,128,65.457,128c15.632,0,30.557-5.551,41.758-15.951L86.741,96.221    C80.964,99.86,73.689,101.818,65.457,101.818" fill="#34A853" fill-rule="evenodd"/>
                                        <path clip-rule="evenodd" d="M126.634,64c0-3.782-0.583-7.855-1.457-11.636H65.457v24.727    h34.376c-1.719,8.431-6.397,14.912-13.092,19.13l20.474,15.828C118.981,101.129,126.634,84.861,126.634,64" fill="#4285F4" fill-rule="evenodd"/>
                                    </svg>
                                    <span><?= trans("connect_with_google"); ?></span>
                                </a>
                            <?php endif;
                            if (!empty($generalSettings->facebook_app_id) || !empty($generalSettings->google_client_id)): ?>
                                <p class="p-auth-modal-or">
                                    <span><?= trans("or_register_with_email"); ?></span>
                                </p>
                            <?php endif; ?>
                            <?= view('partials/_messages'); ?>
                            <div class="form-group has-feedback">
                                <input type="text" name="username" class="form-control" placeholder="<?= trans("username"); ?>" value="<?= old("username"); ?>" required maxlength="150">
                            </div>
                            <div class="form-group has-feedback">
                                <input type="email" name="email" class="form-control" placeholder="<?= trans("email"); ?>" value="<?= old("email"); ?>" required>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" name="password" class="form-control" placeholder="<?= trans("password"); ?>" value="<?= old("password"); ?>" required>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" name="confirm_password" class="form-control" placeholder="<?= trans("confirm_password"); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="custom-checkbox">
                                    <input type="checkbox" class="checkbox_terms_conditions" required>
                                    <span class="checkbox-icon"><i class="icon-check"></i></span>
                                    <?= trans("terms_conditions_exp"); ?>&nbsp;<a href="<?= langBaseUrl('terms-conditions'); ?>" class="link-terms" target="_blank"><strong><?= trans("terms_conditions"); ?></strong></a>
                                </label>
                            </div>
                            <div class="form-group">
                                <?php reCaptcha('generate', $generalSettings); ?>
                            </div>
                            <div class="col-sm-12 p0 form-group has-feedback">
                                <button type="submit" class="btn btn-block btn-custom margin-top-15">
                                    <?= trans("register"); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

