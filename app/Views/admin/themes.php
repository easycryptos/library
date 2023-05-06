<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border"></div>
            <div class="box-body">
                <?= view('admin/includes/_messages'); ?>
                <form action="<?= base_url('AdminController/setModePost'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <ul class="nav nav-tabs layout-nav-tabs">
                        <li class="<?= $generalSettings->dark_mode == 0 ? 'active' : ''; ?>">
                            <button type="submit" name="theme_mode" value="light"><?= trans("light_mode"); ?></button>
                        </li>
                        <li class="<?= $generalSettings->dark_mode == 1 ? 'active' : ''; ?>">
                            <button type="submit" name="theme_mode" value="dark"><?= trans("dark_mode"); ?></button>
                        </li>
                    </ul>
                </form>
                <div class="tab-content tab-content-layout-items">
                    <div id="light_mode" class="tab-pane fade in active">
                        <input type="hidden" name="layout" id="light_layout" value="<?= $generalSettings->layout; ?>">
                        <div class="row row-layout-items">
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?= $generalSettings->layout == 'layout_1' ? 'active' : ''; ?>" data-val="layout_1" onclick="setTheme('layout_1');">
                                <img src="<?= base_url('assets/admin/img/layout_1.jpg'); ?>" alt="" class="img-responsive">
                                <button type="button" class="btn btn-block"><?= $generalSettings->layout == 'layout_1' ? trans("activated") : trans("activate"); ?></button>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?= $generalSettings->layout == 'layout_2' ? 'active' : ''; ?>" data-val="layout_2" onclick="setTheme('layout_2');">
                                <img src="<?= base_url('assets/admin/img/layout_2.jpg'); ?>" alt="" class="img-responsive">
                                <button type="button" class="btn btn-block"><?= $generalSettings->layout == 'layout_2' ? trans("activated") : trans("activate"); ?></button>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?= $generalSettings->layout == 'layout_3' ? 'active' : ''; ?>" data-val="layout_3" onclick="setTheme('layout_3');">
                                <img src="<?= base_url('assets/admin/img/layout_3.jpg'); ?>" alt="" class="img-responsive">
                                <button type="button" class="btn btn-block"><?= $generalSettings->layout == 'layout_3' ? trans("activated") : trans("activate"); ?></button>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?= $generalSettings->layout == 'layout_4' ? 'active' : ''; ?>" data-val="layout_4" onclick="setTheme('layout_4');">
                                <img src="<?= base_url('assets/admin/img/layout_4.jpg'); ?>" alt="" class="img-responsive">
                                <button type="button" class="btn btn-block"><?= $generalSettings->layout == 'layout_4' ? trans("activated") : trans("activate"); ?></button>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?= $generalSettings->layout == 'layout_5' ? 'active' : ''; ?>" data-val="layout_5" onclick="setTheme('layout_5');">
                                <img src="<?= base_url('assets/admin/img/layout_5.jpg'); ?>" alt="" class="img-responsive">
                                <button type="button" class="btn btn-block"><?= $generalSettings->layout == 'layout_5' ? trans("activated") : trans("activate"); ?></button>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?= $generalSettings->layout == 'layout_6' ? 'active' : ''; ?>" data-val="layout_6" onclick="setTheme('layout_6');">
                                <img src="<?= base_url('assets/admin/img/layout_6.jpg'); ?>" alt="" class="img-responsive">
                                <button type="button" class="btn btn-block"><?= $generalSettings->layout == 'layout_6' ? trans("activated") : trans("activate"); ?></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="box-footer"></div>
        </div>
    </div>
</div>

<script>
    function setTheme(layout) {
        var data = {
            'layout': layout
        };
        $.ajax({
            type: "POST",
            url: InfConfig.baseUrl + "/AdminController/setThemePost",
            data: setAjaxData(data),
            success: function (response) {
                location.reload();
            }
        });
    }
</script>


