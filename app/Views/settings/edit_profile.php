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
                        <form action="<?= base_url('edit-profile-post'); ?>" method="post" enctype="multipart/form-data" id="form_validate">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <div class="row m-b-10">
                                    <div class="col-sm-12">
                                        <img src="<?= getUserAvatar($user); ?>" alt="<?= $user->username; ?>" class="form-avatar">
                                    </div>
                                </div>
                                <div class="row m-b-10">
                                    <div class="col-sm-12">
                                        <a class='btn btn-md btn-info btn-file-upload btn-profile-file-upload'>
                                            <?= trans('select_image'); ?>
                                            <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, '..'));">
                                        </a>
                                    </div>
                                </div>
                                <p class='label label-info' id="upload-file-info"></p>
                            </div>
                            <div class="form-group m-t-30">
                                <label><?= trans("email"); ?></label>
                                <input type="email" name="email" class="form-control form-input" value="<?= esc($user->email); ?>" placeholder="<?= trans("email_address"); ?>" maxlength="255" required>
                            </div>
                            <div class="form-group">
                                <label><?= trans("username"); ?></label>
                                <input type="text" name="username" class="form-control form-input" value="<?= esc($user->username); ?>" placeholder="<?= trans("username"); ?>" maxlength="255" required>
                            </div>
                            <div class="form-group">
                                <label><?= trans("slug"); ?></label>
                                <input type="text" name="slug" class="form-control form-input" value="<?= esc($user->slug); ?>" placeholder="<?= trans("slug"); ?>" maxlength="255" required>
                            </div>
                            <div class="form-group">
                                <label><?= trans("about_me"); ?></label>
                                <textarea name="about_me" class="form-control form-textarea" placeholder="<?= trans("about_me"); ?>" maxlength="4999"><?= esc($user->about_me); ?></textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label><?= trans('show_email_on_profile'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-option">
                                        <label class="custom-checkbox custom-radio">
                                            <input type="radio" name="show_email_on_profile" value="1" <?= $user->show_email_on_profile == 1 ? 'checked' : ''; ?> required>
                                            <span class="checkbox-icon"><i class="icon-check"></i></span>
                                            <span><?= trans("yes"); ?></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-option">
                                        <label class="custom-checkbox custom-radio">
                                            <input type="radio" name="show_email_on_profile" value="0" <?= $user->show_email_on_profile == 0 ? 'checked' : ''; ?> required>
                                            <span class="checkbox-icon"><i class="icon-check"></i></span>
                                            <span><?= trans("no"); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?= trans("save_changes") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
