<?php if (!empty($settings->facebook_url)) : ?>
    <li><a class="facebook" href="<?= esc($settings->facebook_url); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
<?php endif;
if (!empty($settings->twitter_url)) : ?>
    <li><a class="twitter" href="<?= esc($settings->twitter_url); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
<?php endif;
if (!empty($settings->pinterest_url)) : ?>
    <li><a class="pinterest" href="<?= esc($settings->pinterest_url); ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
<?php endif;
if (!empty($settings->instagram_url)) : ?>
    <li><a class="instgram" href="<?= esc($settings->instagram_url); ?>" target="_blank"><i class="icon-instagram"></i></a></li>
<?php endif;
if (!empty($settings->linkedin_url)) : ?>
    <li><a class="linkedin" href="<?= esc($settings->linkedin_url); ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
<?php endif;
if (!empty($settings->vk_url)) : ?>
    <li><a class="vk" href="<?= esc($settings->vk_url); ?>" target="_blank"><i class="icon-vk"></i></a></li>
<?php endif;
if (!empty($settings->youtube_url)) : ?>
    <li><a class="youtube" href="<?= esc($settings->youtube_url); ?>" target="_blank"><i class="icon-youtube"></i></a></li>
<?php endif;
if (!empty($settings->telegram_url)) : ?>
    <li><a class="telegram" href="<?= esc($settings->telegram_url); ?>" target="_blank"><i class="icon-telegram"></i></a></li>
<?php endif;
if ($generalSettings->show_rss == 1) : ?>
    <li><a class="rss" href="<?= langBaseUrl('rss-feeds'); ?>"><i class="icon-rss"></i></a></li>
<?php endif; ?>