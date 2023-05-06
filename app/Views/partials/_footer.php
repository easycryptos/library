<?= view('partials/_json_ld'); ?>
<footer id="footer">
    <div class="container">
        <div class="row footer-widgets">
            <div class="col-sm-4 col-xs-12">
                <div class="footer-widget f-widget-about">
                    <div class="col-sm-12">
                        <div class="row">
                            <h4 class="title"><?= trans("about"); ?></h4>
                            <div class="title-line"></div>
                            <p><?= esc($settings->about_footer); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <?= view('partials/_footer_latest_posts'); ?>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="footer-widget f-widget-follow">
                            <div class="col-sm-12">
                                <div class="row">
                                    <h4 class="title"><?= trans("social_media"); ?></h4>
                                    <div class="title-line"></div>
                                    <ul>
                                        <?= view("partials/_social_links"); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($generalSettings->newsletter_status == 1): ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="widget-newsletter">
                                <p><?= trans("newsletter_exp"); ?></p>
                                <form id="form_newsletter_footer" class="form-newsletter">
                                    <div class="newsletter">
                                        <input type="email" name="email" class="newsletter-input" maxlength="199" placeholder="<?= trans("email"); ?>">
                                        <button type="submit" name="submit" value="form" class="newsletter-button"><?= trans("subscribe"); ?></button>
                                    </div>
                                    <input type="text" name="url">
                                    <div id="form_newsletter_response"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-bottom-left">
                        <p><?= $settings->copyright; ?></p>
                    </div>
                    <div class="footer-bottom-right">
                        <ul class="nav-footer">
                            <?php if (!empty($menuLinks)):
                                foreach ($menuLinks as $item):
                                    if ($item->item_location == "footer"):?>
                                        <li><a href="<?= generateMenuItemUrl($item); ?>"><?= esc($item->item_name); ?> </a></li>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php if (empty(helperGetCookie('cookies_warning')) && $settings->cookies_warning == 1): ?>
    <div class="cookies-warning">
        <div class="text"><?= $settings->cookies_warning_text; ?></div>
        <a href="javascript:void(0)" onclick="hideCookiesWarning();" class="icon-cl"> <i class="icon-close"></i></a>
    </div>
<?php endif; ?>
<a href="#" class="scrollup"><i class="icon-arrow-up"></i></a>
<script src="<?= base_url('assets/js/jquery-1.12.4.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/slick/slick.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/plugins.js'); ?>"></script>
<script src="<?= base_url('assets/js/script-4.3.min.js'); ?>"></script>
<script>$('<input>').attr({type: 'hidden', name: 'lang', value: InfConfig.sysLangId}).appendTo('form');</script>
<?php if (checkNewsletterModal()):?>
<script>$(window).on('load', function () {$('#modal_newsletter').modal('show');});</script>
<?php endif; ?>
<?= view('partials/_js_footer'); ?>
<?= $generalSettings->google_analytics; ?>
<?= $generalSettings->custom_javascript_codes; ?>
</body>
</html>