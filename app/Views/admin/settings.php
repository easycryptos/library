<div class="row">
    <div class="col-md-12">
        <form action="<?= base_url('AdminController/settingsPost'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label><?= trans("settings_language"); ?></label>
                <select name="lang_id" class="form-control max-400" onchange="window.location.href = '<?= adminUrl(); ?>'+'/settings?lang='+this.value;">
                    <?php foreach ($languages as $language): ?>
                        <option value="<?= $language->id; ?>" <?= $settingsLangId == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?= view('admin/includes/_messages'); ?>
            <input type="hidden" name="logo_path" value="<?= esc($generalSettings->logo_path); ?>">
            <input type="hidden" name="favicon_path" value="<?= esc($generalSettings->favicon_path); ?>">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?= trans('general_settings'); ?></a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><?= trans('visual_settings'); ?></a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><?= trans('contact_settings'); ?></a></li>
                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><?= trans('social_media_settings'); ?></a></li>
                    <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><?= trans('facebook_comments'); ?></a></li>
                    <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false"><?= trans('cookies_warning'); ?></a></li>
                    <li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false"><?= trans('custom_css_codes'); ?></a></li>
                    <li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false"><?= trans('custom_javascript_codes'); ?></a></li>
                </ul>
                <div class="tab-content settings-tab-content">

                    <div class="tab-pane active" id="tab_1">
                        <div class="form-group">
                            <label class="control-label"><?= trans('timezone'); ?></label>
                            <select name="timezone" class="form-control max-600">
                                <?php $timezones = timezone_identifiers_list();
                                if (!empty($timezones)):
                                    foreach ($timezones as $timezone):?>
                                        <option value="<?= $timezone; ?>" <?= $timezone == $generalSettings->timezone ? 'selected' : ''; ?>><?= $timezone; ?></option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('app_name'); ?></label>
                            <input type="text" class="form-control max-600" name="application_name" placeholder="<?= trans('app_name'); ?>" value="<?= esc($formSettings->application_name); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('admin_panel_link'); ?></label>
                            <input type="text" class="form-control max-600" name="admin_route" placeholder="<?= trans('admin_panel_link'); ?>" value="<?= $generalSettings->admin_route; ?>">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('multilingual_system'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="multilingual_system" value="1" id="multilingual_system_1" class="square-purple" <?= $generalSettings->multilingual_system == 1 ? 'checked' : ''; ?>>
                                    <label for="multilingual_system_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="multilingual_system" value="0" id="multilingual_system_2" class="square-purple" <?= $generalSettings->multilingual_system != 1 ? 'checked' : ''; ?>>
                                    <label for="multilingual_system_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('registration_system'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="registration_system" value="1" id="registration_system_1" class="square-purple" <?= $generalSettings->registration_system == 1 ? 'checked' : ''; ?>>
                                    <label for="registration_system_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="registration_system" value="0" id="registration_system_2" class="square-purple" <?= $generalSettings->registration_system != 1 ? 'checked' : ''; ?>>
                                    <label for="registration_system_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('approve_posts_before_publishing'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="approve_posts_before_publishing" value="1" id="approve_posts_before_publishing_1" class="square-purple" <?= $generalSettings->approve_posts_before_publishing == 1 ? 'checked' : ''; ?>>
                                    <label for="approve_posts_before_publishing_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="approve_posts_before_publishing" value="0" id="approve_posts_before_publishing_2" class="square-purple" <?= $generalSettings->approve_posts_before_publishing != 1 ? 'checked' : ''; ?>>
                                    <label for="approve_posts_before_publishing_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('comment_system'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="comment_system" value="1" id="comment_system_1" class="square-purple" <?= $generalSettings->comment_system == 1 ? 'checked' : ''; ?>>
                                    <label for="comment_system_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="comment_system" value="0" id="comment_system_2" class="square-purple" <?= $generalSettings->comment_system != 1 ? 'checked' : ''; ?>>
                                    <label for="comment_system_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('comment_approval_system'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="comment_approval_system" value="1" id="comment_approval_system_1" class="square-purple" <?= $generalSettings->comment_approval_system == 1 ? 'checked' : ''; ?>>
                                    <label for="comment_approval_system_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="comment_approval_system" value="0" id="comment_approval_system_2" class="square-purple" <?= $generalSettings->comment_approval_system != 1 ? 'checked' : ''; ?>>
                                    <label for="comment_approval_system_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('slider'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="slider_active" value="1" id="slider_active_1" class="square-purple" <?= $generalSettings->slider_active == 1 ? 'checked' : ''; ?>>
                                    <label for="slider_active_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="slider_active" value="0" id="slider_active_2" class="square-purple" <?= $generalSettings->slider_active != 1 ? 'checked' : ''; ?>>
                                    <label for="slider_active_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('emoji_reactions'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="emoji_reactions_1" name="emoji_reactions" value="1" class="square-purple" checked>
                                    <label for="emoji_reactions_1" class="cursor-pointer" <?= $generalSettings->emoji_reactions == "1" ? 'checked' : ''; ?>><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="emoji_reactions_2" name="emoji_reactions" value="0" class="square-purple" <?= $generalSettings->emoji_reactions != "1" ? 'checked' : ''; ?>>
                                    <label for="emoji_reactions_2" class="cursor-pointer"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('show_post_view_counts'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="show_pageviews" value="1" id="show_pageviews_1" class="square-purple" <?= $generalSettings->show_pageviews == 1 ? 'checked' : ''; ?>>
                                    <label for="show_pageviews_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="show_pageviews" value="0" id="show_pageviews_2" class="square-purple" <?= $generalSettings->show_pageviews != 1 ? 'checked' : ''; ?>>
                                    <label for="show_pageviews_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('rss'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="show_rss" value="1" id="show_rss_1" class="square-purple" <?= $generalSettings->show_rss == 1 ? 'checked' : ''; ?>>
                                    <label for="show_rss_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="show_rss" value="0" id="show_rss_2" class="square-purple" <?= $generalSettings->show_rss != 1 ? 'checked' : ''; ?>>
                                    <label for="show_rss_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('file_manager'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="file_manager_show_files_1" name="file_manager_show_all_files" value="1" class="square-purple" <?= $generalSettings->file_manager_show_all_files == "1" ? 'checked' : ''; ?>>
                                    <label for="file_manager_show_files_1" class="cursor-pointer"><?= trans('show_all_files'); ?></label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="file_manager_show_files_2" name="file_manager_show_all_files" value="0" class="square-purple" <?= $generalSettings->file_manager_show_all_files != "1" ? 'checked' : ''; ?>>
                                    <label for="file_manager_show_files_2" class="cursor-pointer"><?= trans('show_only_own_files'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('pagination_number_posts'); ?></label>
                            <input type="number" class="form-control" name="pagination_per_page" value="<?= esc($generalSettings->pagination_per_page); ?>" required style="max-width: 300px;">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('optional_url_name'); ?></label>
                            <input type="text" class="form-control" name="optional_url_button_name" placeholder="<?= trans('optional_url_name'); ?>" value="<?= esc($formSettings->optional_url_button_name); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('footer_about_section'); ?></label>
                            <textarea class="form-control text-area" name="about_footer" placeholder="<?= trans('footer_about_section'); ?>" style="min-height: 70px;"><?= esc($formSettings->about_footer); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('copyright'); ?></label>
                            <input type="text" class="form-control" name="copyright" placeholder="<?= trans('copyright'); ?>" value="<?= esc($formSettings->copyright); ?>">
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_2">
                        <div class="form-group">
                            <label><?= trans("site_color"); ?></label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="clrpicker" class="color-picker">
                                        <input type="text" name="site_color" value="<?= $generalSettings->site_color; ?>" class="form-control" style="width: 150px;" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="form-group" style="margin-top: 45px;">
                            <label class="control-label"><?= trans('logo'); ?> (180x50 px)</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <?php if (!empty($generalSettings->logo_path)): ?>
                                        <img src="<?= base_url($generalSettings->logo_path); ?>" alt="" style="max-width: 200px; background-color: #f7f7f7; padding: 10px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-sm-12">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?= trans('change_logo'); ?>
                                        <input type="file" name="logo" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info1').html($(this).val());">
                                    </a>
                                </div>
                            </div>
                            <span class='label label-info' id="upload-file-info1"></span>
                        </div>

                        <div class="form-group" style="margin-top: 45px;">
                            <label class="control-label"><?= trans('mobile_logo'); ?> (<?= trans("dark_mode"); ?>) (180x50 px)</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <?php if (!empty($generalSettings->mobile_logo_path)): ?>
                                        <img src="<?= base_url($generalSettings->mobile_logo_path); ?>" alt="" style="max-width: 200px; background-color: #f7f7f7; padding: 10px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-sm-12">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?= trans('change_logo'); ?>
                                        <input type="file" name="mobile_logo" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info2').html($(this).val());">
                                    </a>
                                </div>
                            </div>
                            <span class='label label-info' id="upload-file-info2"></span>
                        </div>

                        <br>
                        <div class="form-group" style="margin-top: 15px;">
                            <label class="control-label" style="margin-top: 10px;"><?= trans('favicon'); ?></label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <?php if (!empty($generalSettings->favicon_path)): ?>
                                        <img src="<?= base_url($generalSettings->favicon_path); ?>" alt="" style="max-width: 200px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-sm-12">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?= trans('change_favicon'); ?>
                                        <input type="file" name="favicon" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info3').html($(this).val());">
                                    </a>
                                </div>
                            </div>
                            <span class='label label-info' id="upload-file-info3"></span>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_3">
                        <div class="form-group">
                            <label class="control-label"><?= trans('address'); ?></label>
                            <input type="text" class="form-control" name="contact_address" placeholder="<?= trans('address'); ?>" value="<?= esc($formSettings->contact_address); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('email'); ?></label>
                            <input type="text" class="form-control" name="contact_email" placeholder="<?= trans('email'); ?>" value="<?= esc($formSettings->contact_email); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('phone'); ?></label>
                            <input type="text" class="form-control" name="contact_phone" placeholder="<?= trans('phone'); ?>" value="<?= esc($formSettings->contact_phone); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('contact_text'); ?></label>
                            <textarea class="tinyMCE form-control" name="contact_text"><?= $formSettings->contact_text; ?></textarea>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_4">
                        <div class="form-group">
                            <label class="control-label">Facebook <?= trans('url'); ?></label>
                            <input type="text" class="form-control" name="facebook_url" placeholder="Facebook <?= trans('url'); ?>" value="<?= esc($formSettings->facebook_url); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Twitter <?= trans('url'); ?></label>
                            <input type="text" class="form-control" name="twitter_url" placeholder="Twitter <?= trans('url'); ?>" value="<?= esc($formSettings->twitter_url); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Instagram <?= trans('url'); ?></label>
                            <input type="text" class="form-control" name="instagram_url" placeholder="Instagram <?= trans('url'); ?>" value="<?= esc($formSettings->instagram_url); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Pinterest <?= trans('url'); ?></label>
                            <input type="text" class="form-control" name="pinterest_url" placeholder="Pinterest <?= trans('url'); ?>" value="<?= esc($formSettings->pinterest_url); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">LinkedIn <?= trans('url'); ?></label>
                            <input type="text" class="form-control" name="linkedin_url" placeholder="LinkedIn <?= trans('url'); ?>" value="<?= esc($formSettings->linkedin_url); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">VK <?= trans('url'); ?></label>
                            <input type="text" class="form-control" name="vk_url" placeholder="VK <?= trans('url'); ?>" value="<?= esc($formSettings->vk_url); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Telegram <?= trans('url'); ?></label>
                            <input type="text" class="form-control" name="telegram_url" placeholder="Telegram <?= trans('url'); ?>" value="<?= esc($formSettings->telegram_url); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Youtube <?= trans('url'); ?></label>
                            <input type="text" class="form-control" name="youtube_url" placeholder="Youtube <?= trans('url'); ?>" value="<?= esc($formSettings->youtube_url); ?>">
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_5">
                        <div class="form-group">
                            <label class="control-label"><?= trans('facebook_comments_code'); ?></label>
                            <textarea class="form-control text-area" name="facebook_comment" placeholder="<?= trans('facebook_comments_code'); ?>" style="min-height: 140px;"><?= esc($generalSettings->facebook_comment); ?></textarea>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <label><?= trans('show_cookies_warning'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="cookies_warning" value="1" id="cookies_warning_1" class="square-purple" <?= $formSettings->cookies_warning == 1 ? 'checked' : ''; ?>>
                                    <label for="cookies_warning_1" class="option-label"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="cookies_warning" value="0" id="cookies_warning_2" class="square-purple" <?= $formSettings->cookies_warning != 1 ? 'checked' : ''; ?>>
                                    <label for="cookies_warning_2" class="option-label"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?= trans('cookies_warning_text'); ?></label>
                            <textarea class="tinyMCE form-control" name="cookies_warning_text"><?= $formSettings->cookies_warning_text; ?></textarea>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_7">
                        <div class="form-group">
                            <label class="control-label"><?= trans('custom_css_codes'); ?></label>&nbsp;<small class="small-title-inline">(<?= trans("custom_css_codes_exp"); ?>)</small>
                            <textarea class="form-control text-area" name="custom_css_codes" placeholder="<?= trans('custom_css_codes'); ?>" style="height: 200px;"><?= $generalSettings->custom_css_codes; ?></textarea>
                        </div>
                        E.g. <?= esc("<style> body {background-color: #00a65a;} </style>"); ?>
                    </div>

                    <div class="tab-pane" id="tab_8">
                        <div class="form-group">
                            <label class="control-label"><?= trans('custom_javascript_codes'); ?></label>&nbsp;<small class="small-title-inline">(<?= trans("custom_javascript_codes_exp"); ?>)</small>
                            <textarea class="form-control text-area" name="custom_javascript_codes" placeholder="<?= trans('custom_javascript_codes'); ?>" style="height: 200px;"><?= $generalSettings->custom_javascript_codes; ?></textarea>
                        </div>
                        E.g. <?= esc("<script> alert('Hello!'); </script>"); ?>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('google_recaptcha'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/recaptchaSettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('site_key'); ?></label>
                        <input type="text" class="form-control" name="recaptcha_site_key" placeholder="<?= trans('site_key'); ?>" value="<?= $generalSettings->recaptcha_site_key; ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('secret_key'); ?></label>
                        <input type="text" class="form-control" name="recaptcha_secret_key" placeholder="<?= trans('secret_key'); ?>" value="<?= $generalSettings->recaptcha_secret_key; ?>">
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
                <h3 class="box-title"><?= trans('maintenance_mode'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/maintenanceModePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control" name="maintenance_mode_title" placeholder="<?= trans('title'); ?>" value="<?= $generalSettings->maintenance_mode_title; ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('description'); ?></label>
                        <textarea class="form-control text-area" name="maintenance_mode_description" placeholder="<?= trans('description'); ?>" style="min-height: 100px;"><?= esc($generalSettings->maintenance_mode_description); ?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="maintenance_mode_status" value="1" id="maintenance_mode_status_1" class="square-purple" <?= $generalSettings->maintenance_mode_status == 1 ? 'checked' : ''; ?>>
                                <label for="maintenance_mode_status_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="maintenance_mode_status" value="0" id="maintenance_mode_status_2" class="square-purple" <?= $generalSettings->maintenance_mode_status != 1 ? 'checked' : ''; ?>>
                                <label for="maintenance_mode_status_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= trans('image'); ?></label>: assets/img/maintenance_bg.jpg
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('allowed_file_extensions'); ?>&nbsp;(<?= trans("file_manager") ?>)</h3>
            </div>
            <form action="<?= base_url('AdminController/allowedFileExtensionsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans("file_extensions"); ?></label>
                        <div class="row">
                            <div class="col-sm-12">
                                <input id="input_allowed_file_extensions" type="text" name="allowed_file_extensions" value="<?= str_replace('"', '', $generalSettings->allowed_file_extensions ?? ''); ?>" class="form-control tags"/>
                                <small>(<?= trans('type_extension'); ?>&nbsp;E.g. zip, jpg, doc, pdf..)</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="post_deletion" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .tox-tinymce {
        height: 340px !important;
    }
</style>
<script>
    $(function () {
        $('#clrpicker').colorpicker({
            popover: false,
            inline: true,
            container: '#clrpicker',
            format: 'hex'
        });
        $('#clrpicker-block').colorpicker({
            popover: false,
            inline: true,
            container: '#clrpicker-block',
            format: 'hex'
        });
    });
</script>

