<style><?php if(!empty($activeFonts)):
foreach ($activeFonts as $font):
if($font->font_source == 'local' && $font->font_key=='open-sans'):?>
@font-face {font-family: 'Open Sans'; font-style: normal; font-weight: 400; font-display: swap; src: local(''), url('<?= base_url('assets/fonts/open-sans/open-sans-400.woff2'); ?>') format('woff2'), url('<?= base_url('assets/fonts/open-sans/open-sans-400.woff'); ?>') format('woff')}  @font-face {font-family: 'Open Sans'; font-style: normal; font-weight: 600; font-display: swap; src: local(''), url('<?= base_url('assets/fonts/open-sans/open-sans-600.woff2'); ?>') format('woff2'), url('<?= base_url('assets/fonts/open-sans/open-sans-600.woff'); ?>') format('woff')}  @font-face {font-family: 'Open Sans'; font-style: normal; font-weight: 700; font-display: swap; src: local(''), url('<?= base_url('assets/fonts/open-sans/open-sans-700.woff2'); ?>') format('woff2'), url('<?= base_url('assets/fonts/open-sans/open-sans-700.woff'); ?>') format('woff')}
<?php endif;if($font->font_source == 'local' && $font->font_key=='roboto'):?>
@font-face {font-family: 'Roboto'; font-style: normal; font-weight: 400; font-display: swap; src: local(''), url('<?= base_url('assets/fonts/roboto/roboto-400.woff2'); ?>') format('woff2'), url('<?= base_url('assets/fonts/roboto/roboto-400.woff'); ?>') format('woff')}  @font-face {font-family: 'Roboto'; font-style: normal; font-weight: 500; font-display: swap; src: local(''), url('<?= base_url('assets/fonts/roboto/roboto-500.woff2'); ?>') format('woff2'), url('<?= base_url('assets/fonts/roboto/roboto-500.woff'); ?>') format('woff')}  @font-face {font-family: 'Roboto'; font-style: normal; font-weight: 700; font-display: swap; src: local(''), url('<?= base_url('assets/fonts/roboto/roboto-700.woff2'); ?>') format('woff2'), url('<?= base_url('assets/fonts/roboto/roboto-700.woff'); ?>') format('woff')}
<?php endif;endforeach;endif; ?>:root {--inf-font-primary: <?= getFontFamily($activeFonts, 'primary', true); ?>;--inf-font-secondary: <?= getFontFamily($activeFonts, 'secondary', true); ?>;--inf-main-color: <?= esc($generalSettings->site_color); ?>;}</style>
<?= getFontURL($activeFonts,'primary'); ?>
<?= getFontURL($activeFonts,'secondary'); ?>