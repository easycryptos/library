<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;"><?= trans('social_login_settings'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Facebook</h3>
            </div>
            <form action="<?= base_url('AdminController/socialLoginSettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="login_type" value="facebook">
                <div class="box-body">
                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('app_id'); ?></label>
                        <input type="text" class="form-control" name="facebook_app_id" placeholder="<?= trans('app_id'); ?>" value="<?= $generalSettings->facebook_app_id; ?>">
                    </div>
                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('app_secret'); ?></label>
                        <input type="text" class="form-control" name="facebook_app_secret" placeholder="<?= trans('app_secret'); ?>" value="<?= $generalSettings->facebook_app_secret; ?>">
                    </div>
                    <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                        <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Google</h3>
            </div>
            <form action="<?= base_url('AdminController/socialLoginSettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="login_type" value="google">
                <div class="box-body">
                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('client_id'); ?></label>
                        <input type="text" class="form-control" name="google_client_id" placeholder="<?= trans('client_id'); ?>" value="<?= $generalSettings->google_client_id; ?>">
                    </div>
                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('client_secret'); ?></label>
                        <input type="text" class="form-control" name="google_client_secret" placeholder="<?= trans('client_secret'); ?>" value="<?= $generalSettings->google_client_secret; ?>">
                    </div>
                    <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                        <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    h4 {
        color: #0d6aad;
        text-align: left;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 30px;
    }
</style>
