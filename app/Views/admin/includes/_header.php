<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= htmlspecialchars($title); ?> - <?= trans("admin"); ?>&nbsp;<?= htmlspecialchars($settings->site_title); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php if (empty($generalSettings->favicon_path)): ?>
        <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/favicon.png'); ?>"/>
    <?php else: ?>
        <link rel="shortcut icon" type="image/png" href="<?= base_url($generalSettings->favicon_path); ?>"/>
    <?php endif; ?>
    <?= csrf_meta(); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables/jquery.dataTables_themeroller.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/icheck/square/purple.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/pace/pace.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/tagsinput/jquery.tagsinput.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/file-manager/file-manager-1.2.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/custom-4.2.css'); ?>">
    <script>var directionality = "ltr";</script>
    <?php if ($activeLang->text_direction == "rtl"): ?>
        <link href="<?= base_url('assets/admin/css/rtl.css'); ?>" rel="stylesheet"/>
        <script>directionality = "rtl";</script>
    <?php endif; ?>
    <script src="<?= base_url('assets/admin/js/jquery.min.js'); ?>"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>var InfConfig = {
            baseUrl: "<?= base_url(); ?>",
            csrfTokenName: '<?= config('App')->CSRFTokenName; ?>',
            sysLangId: '<?= $activeLang->id; ?>',
            textOk: "<?= clrQuotes(trans("ok")); ?>",
            textCancel: "<?= clrQuotes(trans("cancel")); ?>"
        };
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <a href="<?= adminUrl(); ?>" class="logo">
            <span class="logo-mini"></span>
            <span class="logo-lg"><b><?= esc($settings->application_name); ?></b> <?= trans("panel"); ?></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li><a class="btn btn-sm btn-success pull-left btn-site-prev" target="_blank" href="<?= base_url(); ?>"><i class="fa fa-eye"></i> <?= trans("view_site"); ?></a></li>
                    <?php if ($generalSettings->multilingual_system == 1 && itemCount($languages) > 1): ?>
                        <li class="dropdown user-menu">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="fa fa-globe"></i>&nbsp;
                                <?= esc($activeLang->name); ?>
                                <span class="fa fa-caret-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (!empty($languages)):
                                    foreach ($languages as $language): ?>
                                        <li>
                                            <form action="<?= base_url('AdminController/setActiveLanguagePost'); ?>" method="post">
                                                <?= csrf_field(); ?>
                                                <button type="submit" value="<?php echo $language->id; ?>" name="lang_id" class="control-panel-lang-btn"><?php echo limitCharacter($language->name, 20, '...'); ?></button>
                                            </form>
                                        </li>
                                    <?php endforeach;
                                endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?= getUserAvatar(user()); ?>" class="user-image" alt="">
                            <span class="hidden-xs"><?= user()->username; ?> <i class="fa fa-caret-down"></i> </span>
                        </a>
                        <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                            <li><a href="<?= base_url('profile/' . user()->slug); ?>"><i class="fa fa-user"></i> <?= trans("profile"); ?></a></li>
                            <li><a href="<?= base_url('settings'); ?>"><i class="fa fa-cog"></i> <?= trans("update_profile"); ?></a></li>
                            <li><a href="<?= base_url('settings/change-password'); ?>"><i class="fa fa-lock"></i> <?= trans("change_password"); ?></a></li>
                            <li class="divider"></li>
                            <li><a href="<?= base_url('logout'); ?>"><i class="fa fa-sign-out"></i> <?= trans("logout"); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= getUserAvatar(user()); ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?= esc(user()->username); ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?= trans("online"); ?></a>
                </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"><?= trans("main_navigation"); ?></li>
                <li class="nav-home">
                    <a href="<?= adminUrl(); ?>"><i class="fa fa-home"></i><span><?= trans("home"); ?></span></a>
                </li>
                <?php if (hasPermission('themes')): ?>
                    <li class="nav-themes">
                        <a href="<?= adminUrl('themes'); ?>"><i class="fa fa-paint-brush" aria-hidden="true"></i> <span><?= trans("themes"); ?></span></a>
                    </li>
                <?php endif;
                if (hasPermission('navigation')): ?>
                    <li class="nav-navigation">
                        <a href="<?= adminUrl('navigation'); ?>"><i class="fa fa-th"></i><span><?= trans("navigation"); ?></span></a>
                    </li>
                <?php endif;
                if (hasPermission('pages')): ?>
                    <li class="nav-pages">
                        <a href="<?= adminUrl('pages'); ?>"><i class="fa fa-leaf" aria-hidden="true"></i> <span><?= trans("pages"); ?></span></a>
                    </li>
                <?php endif;
                if (hasPermission('add_post')): ?>
                    <li class="treeview<?= isAdminNavActive(['add-post', 'add-video']); ?>">
                        <a href="#">
                            <i class="fa fa-file"></i> <span><?= trans("add_post"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-post">
                                <a href="<?= adminUrl('add-post'); ?>"><?= trans("add_post"); ?></a>
                            </li>
                            <li class="nav-add-video">
                                <a href="<?= adminUrl('add-video'); ?>"><?= trans("add_video"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif;
                if (hasPermission('manage_all_posts') || hasPermission('add_post')): ?>
                    <li class="treeview<?= isAdminNavActive(['posts', 'slider-posts', 'our-picks', 'pending-posts', 'update-post', 'auto-post-deletion']); ?>">
                        <a href="#">
                            <i class="fa fa-bars"></i> <span><?= trans("posts"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-posts">
                                <a href="<?= adminUrl('posts'); ?>"><?= trans("posts"); ?></a>
                            </li>
                            <?php if (hasPermission('manage_all_posts')): ?>
                                <li class="nav-slider-posts">
                                    <a href="<?= adminUrl('slider-posts'); ?>"><?= trans("slider_posts"); ?></a>
                                </li>
                                <li class="nav-our-picks">
                                    <a href="<?= adminUrl('our-picks'); ?>"><?= trans("our_picks"); ?></a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-pending-posts">
                                <a href="<?= adminUrl('pending-posts'); ?>"><?= trans("pending_posts"); ?></a>
                            </li>
                            <?php if (hasPermission('manage_all_posts')): ?>
                                <li class="nav-auto-post-deletion">
                                    <a href="<?= adminUrl('auto-post-deletion'); ?>"><?= trans("auto_post_deletion"); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-drafts">
                        <a href="<?= adminUrl('drafts'); ?>">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> <span><?= trans("drafts"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('rss_feeds')): ?>
                    <li class="treeview<?= isAdminNavActive(['import-feed', 'update-feed', 'feeds']); ?>">
                        <a href="#">
                            <i class="fa fa-rss"></i> <span><?= trans("rss_feeds"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-import-feed">
                                <a href="<?= adminUrl('import-feed'); ?>"><?= trans("import_rss_feed"); ?></a>
                            </li>
                            <li class="nav-feeds">
                                <a href="<?= adminUrl('feeds'); ?>"><?= trans("rss_feeds"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif;
                if (hasPermission('categories')): ?>
                    <li class="treeview<?= isAdminNavActive(['categories', 'subcategories', 'update-category', 'update-subcategory']); ?>">
                        <a href="#">
                            <i class="fa fa-folder-open"></i> <span><?= trans("categories"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-categories">
                                <a href="<?= adminUrl('categories'); ?>">
                                    <?= trans("categories"); ?>
                                </a>
                            </li>
                            <li class="nav-subcategories">
                                <a href="<?= adminUrl('subcategories'); ?>">
                                    <?= trans("subcategories"); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif;
                if (hasPermission('polls')): ?>
                    <li class="nav-polls">
                        <a href="<?= adminUrl('polls'); ?>">
                            <i class="fa fa-list"></i><span><?= trans("polls"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('gallery')): ?>
                    <li class="treeview<?= isAdminNavActive(['gallery', 'gallery-albums', 'gallery-categories', 'update-gallery-image', 'update-gallery-album', 'update-gallery-category']); ?>">
                        <a href="#">
                            <i class="fa fa-image"></i> <span><?= trans("gallery"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-gallery-albums">
                                <a href="<?= adminUrl('gallery-albums'); ?>"><?= trans("albums"); ?></a>
                            </li>
                            <li class="nav-gallery-categories">
                                <a href="<?= adminUrl('gallery-categories'); ?>"><?= trans("categories"); ?></a>
                            </li>
                            <li class="nav-gallery">
                                <a href="<?= adminUrl('gallery'); ?>"><?= trans("images"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif;
                if (hasPermission('comments')): ?>
                    <li class="treeview<?= isAdminNavActive(['pending-comments', 'comments']); ?>">
                        <a href="#">
                            <i class="fa fa-comments"></i> <span><?= trans("comments"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-pending-comments">
                                <a href="<?= adminUrl('pending-comments'); ?>"><?= trans("pending_comments"); ?></a>
                            </li>
                            <li class="nav-comments">
                                <a href="<?= adminUrl('comments'); ?>"><?= trans("approved_comments"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif;
                if (hasPermission('contact_messages')): ?>
                    <li class="nav-contact-messages">
                        <a href="<?= adminUrl('contact-messages'); ?>">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            <span><?= trans("contact_messages"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('newsletter')): ?>
                    <li class="nav-newsletter">
                        <a href="<?= adminUrl('newsletter'); ?>">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <span><?= trans("newsletter"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('ad_spaces')): ?>
                    <li class="nav-ad-spaces">
                        <a href="<?= adminUrl('ad-spaces?type=index_top'); ?>">
                            <i class="fa fa-dollar" aria-hidden="true"></i>
                            <span><?= trans("ad_spaces"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('membership')): ?>
                    <li class="treeview<?= isAdminNavActive(['add-user', 'users']); ?>">
                        <a href="#">
                            <i class="fa fa-users"></i> <span><?= trans("users"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-user">
                                <a href="<?= adminUrl('add-user'); ?>"><?= trans("add_user"); ?></a>
                            </li>
                            <li class="nav-users">
                                <a href="<?= adminUrl('users'); ?>"><?= trans("users"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-roles-permissions">
                        <a href="<?= adminUrl('roles-permissions'); ?>">
                            <i class="fa fa-key"></i>
                            <span><?= trans("roles_permissions"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('cache_system')): ?>
                    <li class="nav-cache-system">
                        <a href="<?= adminUrl('cache-system'); ?>">
                            <i class="fa fa-database"></i><span><?= trans("cache_system"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('seo_tools')): ?>
                    <li class="nav-seo-tools">
                        <a href="<?= adminUrl('seo-tools'); ?>"><i class="fa fa-wrench"></i>
                            <span><?= trans("seo_tools"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('settings')): ?>
                    <li class="nav-social-login-settings">
                        <a href="<?= adminUrl('social-login-settings'); ?>"><i class="fa fa-share-alt"></i>
                            <span><?= trans("social_login_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-email-settings">
                        <a href="<?= adminUrl('email-settings'); ?>">
                            <i class="fa fa-cog"></i><span><?= trans("email_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-language-settings">
                        <a href="<?= adminUrl('language-settings'); ?>">
                            <i class="fa fa-language"></i><span><?= trans("language_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-font-settings">
                        <a href="<?= adminUrl('font-settings'); ?>">
                            <i class="fa fa-font" aria-hidden="true"></i><span><?= trans("font_settings"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (hasPermission('settings')): ?>
                    <li class="nav-settings">
                        <a href="<?= adminUrl('settings'); ?>">
                            <i class="fa fa-cogs"></i><span><?= trans("settings"); ?></span>
                        </a>
                    </li>
                <?php endif;
                if (user()->role_id == 1): ?>
                    <li>
                        <div class="database-backup">
                            <form action="<?= base_url('AdminController/downloadDatabaseBackup'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <button type="submit" class="btn btn-block"><i class="fa fa-download"></i>&nbsp;&nbsp;<?= trans("download_database_backup"); ?></button>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </section>
    </aside>
    <?php
    $segment2 = $segment = getSegmentValue(2);
    $segment3 = $segment = getSegmentValue(3);
    $uriString = $segment2;
    if (!empty($segment3)) {
        $uriString .= '-' . $segment3;
    } ?>
    <style>
        <?php if(!empty($uriString)):
        echo '.nav-'.$uriString.' > a{color: #fff !important;}';
        else:
        echo '.nav-home > a{color: #fff !important;}';
        endif;?>
    </style>
    <div class="content-wrapper">
        <section class="content">