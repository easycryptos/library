<!DOCTYPE html>
<html lang="<?= $activeLang->short_form; ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title); ?> - <?= esc($settings->site_title); ?></title>
<meta name="description" content="<?= esc($description); ?>"/>
<meta name="keywords" content="<?= esc($keywords); ?>"/>
<meta name="author" content="<?= esc($settings->application_name); ?>"/>
<meta name="robots" content="all"/>
<meta name="revisit-after" content="1 Days"/>
<meta property="og:locale" content="<?= $activeLang->language_code ?>"/>
<meta property="og:site_name" content="<?= esc($settings->application_name); ?>"/>
<?php if (isset($pageType)): ?>
<meta property="og:type" content="<?= $ogType; ?>"/>
<meta property="og:title" content="<?= esc($post->title); ?>"/>
<meta property="og:description" content="<?= esc($post->summary); ?>"/>
<meta property="og:url" content="<?= $ogUrl; ?>"/>
<meta property="og:image" content="<?= $ogImage; ?>"/>
<meta property="og:image:width" content="750"/>
<meta property="og:image:height" content="415"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="<?= esc($settings->application_name); ?>"/>
<meta name="twitter:title" content="<?= esc($post->title); ?>"/>
<meta name="twitter:description" content="<?= esc($post->summary); ?>"/>
<meta name="twitter:image" content="<?= $ogImage; ?>"/>
<?php foreach ($ogTags as $tag): ?>
<meta property="article:tag" content="<?= esc($tag->tag); ?>"/>
<?php endforeach;
else: ?>
<meta property="og:image" content="<?= getLogo($generalSettings); ?>"/>
<meta property="og:image:width" content="180"/>
<meta property="og:image:height" content="50"/>
<meta property="og:type" content=website/>
<meta property="og:title" content="<?= esc($title); ?> - <?= esc($settings->site_title); ?>"/>
<meta property="og:description" content="<?= esc($description); ?>"/>
<meta property="og:url" content="<?= base_url(); ?>"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="<?= esc($settings->application_name); ?>"/>
<meta name="twitter:title" content="<?= esc($title); ?> - <?= esc($settings->site_title); ?>"/>
<meta name="twitter:description" content="<?= esc($description); ?>"/>
<meta name="twitter:image" content="<?= getLogo($generalSettings); ?>"/>
<?php endif; ?>
<?= csrf_meta(); ?>
<link rel="shortcut icon" type="image/png" href="<?= getFavicon($generalSettings); ?>"/>
<link rel="canonical" href="<?= currentFullUrl(); ?>"/>
<link rel="alternate" href="<?= currentFullUrl(); ?>" hreflang="<?= $activeLang->language_code; ?>"/>
<?= view('partials/_fonts'); ?>
<link rel="stylesheet" href="<?= base_url('assets/vendor/font-icons/css/icons.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
<link href="<?= base_url('assets/vendor/slick/slick.min.css'); ?>" rel="stylesheet"/>
<link href="<?= base_url('assets/css/magnific-popup.min.css'); ?>" rel="stylesheet"/>
<link href="<?= base_url('assets/css/style-4.3.min.css'); ?>" rel="stylesheet"/>
<?php if ($darkMode == 1) : ?>
<link href="<?= base_url('assets/css/dark-4.3.min.css'); ?>" rel="stylesheet"/>
<?php endif;
if ($activeLang->text_direction == "rtl"): ?>
<script>var rtl = true;</script>
<link href="<?= base_url('assets/css/rtl-4.3.min.css'); ?>" rel="stylesheet"/>
<?php else: ?>
<script>var rtl = false;</script>
<?php endif; ?>
<?= view('partials/_css_js_header'); ?>
<?= $generalSettings->custom_css_codes; ?>
<?= $generalSettings->google_adsense_code; ?>

</head>
<body>
<header id="header">
<nav class="navbar navbar-inverse" role="banner">
<div class="container-fluid nav-top-container">
<?= view("partials/_nav_top"); ?>
</div>
<div class="container nav-container">
<?= view("partials/_nav"); ?>
</div>
<div class="mobile-nav-container">
<?= view("partials/_nav_mobile.php"); ?>
</div>
</nav>
<div class="modal-search">
<form action="<?= langBaseUrl('search'); ?>" method="get">
<div class="container">
<input type="text" name="q" class="form-control" maxlength="300" pattern=".*\S+.*" placeholder="<?= trans("search_exp"); ?>" required>
<i class="icon-close s-close"></i>
</div>
</form>
</div>
</header>

<div id="overlay_bg" class="overlay-bg"></div>

<div id="modal_newsletter" class="modal fade modal-center modal-newsletter" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-body">
<button type="button" class="close" data-dismiss="modal"><i class="icon-close" aria-hidden="true"></i></button>
<h4 class="modal-title"><?= trans("join_newsletter"); ?></h4>
<p class="modal-desc"><?= trans("newsletter_desc"); ?></p>
<form id="form_newsletter_modal" class="form-newsletter" data-form-type="modal">
<div class="form-group">
<div class="modal-newsletter-inputs">
<input type="email" name="email" class="form-control form-input newsletter-input" placeholder="<?= trans('email_address') ?>">
<button type="submit" id="btn_modal_newsletter" class="btn btn-custom"><?= trans("subscribe"); ?></button>
</div>
</div>
<input type="text" name="url">
<div id="modal_newsletter_response" class="text-center modal-newsletter-response">
<div class="form-group text-center m-b-0 text-close">
<button type="button" class="text-close" data-dismiss="modal"><?= trans("no_thanks"); ?></button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>