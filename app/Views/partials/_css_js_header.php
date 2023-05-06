<?php if (!empty($adSpaces)):?>
<style><?php
foreach ($adSpaces as $item):
if (!empty($item->desktop_width) && !empty($item->desktop_height)):
echo '.bn-ds-' . $item->id . '{width: ' . $item->desktop_width . 'px; height: ' . $item->desktop_height . 'px;}';
echo '.bn-mb-' . $item->id . '{width: ' . $item->mobile_width . 'px; height: ' . $item->mobile_height . 'px;}';
endif;
endforeach;?>
</style><?php endif; ?>
<script>var InfConfig = {baseUrl: '<?= base_url(); ?>', csrfTokenName: '<?= config('App')->CSRFTokenName; ?>', sysLangId: '<?= $activeLang->id; ?>', isRecaptchaEnabled: '<?= isRecaptchaEnabled($generalSettings) ? 1 : 0; ?>', textOk: "<?= clrQuotes(trans("ok")); ?>", textCancel: "<?= clrQuotes(trans("cancel")); ?>"};</script>