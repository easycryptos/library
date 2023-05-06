<?php $arrayLang = array();
$arrayLang[] = array("short" => "ar", "name" => "Arabic");
$arrayLang[] = array("short" => "hy", "name" => "Armenian");
$arrayLang[] = array("short" => "az", "name" => "Azerbaijani");
$arrayLang[] = array("short" => "eu", "name" => "Basque");
$arrayLang[] = array("short" => "be", "name" => "Belarusian");
$arrayLang[] = array("short" => "bn_BD", "name" => "Bengali (Bangladesh)");
$arrayLang[] = array("short" => "bs", "name" => "Bosnian");
$arrayLang[] = array("short" => "bg_BG", "name" => "Bulgarian");
$arrayLang[] = array("short" => "ca", "name" => "Catalan");
$arrayLang[] = array("short" => "zh_CN", "name" => "Chinese (China)");
$arrayLang[] = array("short" => "zh_TW", "name" => "Chinese (Taiwan)");
$arrayLang[] = array("short" => "hr", "name" => "Croatian");
$arrayLang[] = array("short" => "cs", "name" => "Czech");
$arrayLang[] = array("short" => "da", "name" => "Danish");
$arrayLang[] = array("short" => "dv", "name" => "Divehi");
$arrayLang[] = array("short" => "nl", "name" => "Dutch");
$arrayLang[] = array("short" => "en", "name" => "English");
$arrayLang[] = array("short" => "et", "name" => "Estonian");
$arrayLang[] = array("short" => "fo", "name" => "Faroese");
$arrayLang[] = array("short" => "fi", "name" => "Finnish");
$arrayLang[] = array("short" => "fr_FR", "name" => "French");
$arrayLang[] = array("short" => "gd", "name" => "Gaelic, Scottish");
$arrayLang[] = array("short" => "gl", "name" => "Galician");
$arrayLang[] = array("short" => "ka_GE", "name" => "Georgian");
$arrayLang[] = array("short" => "de", "name" => "German");
$arrayLang[] = array("short" => "el", "name" => "Greek");
$arrayLang[] = array("short" => "he", "name" => "Hebrew");
$arrayLang[] = array("short" => "hi_IN", "name" => "Hindi");
$arrayLang[] = array("short" => "hu_HU", "name" => "Hungarian");
$arrayLang[] = array("short" => "is_IS", "name" => "Icelandic");
$arrayLang[] = array("short" => "id", "name" => "Indonesian");
$arrayLang[] = array("short" => "it", "name" => "Italian");
$arrayLang[] = array("short" => "ja", "name" => "Japanese");
$arrayLang[] = array("short" => "kab", "name" => "Kabyle");
$arrayLang[] = array("short" => "kk", "name" => "Kazakh");
$arrayLang[] = array("short" => "km_KH", "name" => "Khmer");
$arrayLang[] = array("short" => "ko_KR", "name" => "Korean");
$arrayLang[] = array("short" => "ku", "name" => "Kurdish");
$arrayLang[] = array("short" => "lv", "name" => "Latvian");
$arrayLang[] = array("short" => "lt", "name" => "Lithuanian");
$arrayLang[] = array("short" => "lb", "name" => "Luxembourgish");
$arrayLang[] = array("short" => "ml", "name" => "Malayalam");
$arrayLang[] = array("short" => "mn", "name" => "Mongolian");
$arrayLang[] = array("short" => "nb_NO", "name" => "Norwegian Bokmål (Norway)");
$arrayLang[] = array("short" => "fa", "name" => "Persian");
$arrayLang[] = array("short" => "pl", "name" => "Polish");
$arrayLang[] = array("short" => "pt_BR", "name" => "Portuguese (Brazil)");
$arrayLang[] = array("short" => "pt_PT", "name" => "Portuguese (Portugal)");
$arrayLang[] = array("short" => "ro", "name" => "Romanian");
$arrayLang[] = array("short" => "ru", "name" => "Russian");
$arrayLang[] = array("short" => "sr", "name" => "Serbian");
$arrayLang[] = array("short" => "si_LK", "name" => "Sinhala (Sri Lanka)");
$arrayLang[] = array("short" => "sk", "name" => "Slovak");
$arrayLang[] = array("short" => "sl_SI", "name" => "Slovenian (Slovenia)");
$arrayLang[] = array("short" => "es", "name" => "Spanish");
$arrayLang[] = array("short" => "es_MX", "name" => "Spanish (Mexico)");
$arrayLang[] = array("short" => "sv_SE", "name" => "Swedish (Sweden)");
$arrayLang[] = array("short" => "tg", "name" => "Tajik");
$arrayLang[] = array("short" => "ta", "name" => "Tamil");
$arrayLang[] = array("short" => "tt", "name" => "Tatar");
$arrayLang[] = array("short" => "th_TH", "name" => "Thai");
$arrayLang[] = array("short" => "tr", "name" => "Turkish");
$arrayLang[] = array("short" => "ug", "name" => "Uighur");
$arrayLang[] = array("short" => "uk", "name" => "Ukrainian");
$arrayLang[] = array("short" => "vi", "name" => "Vietnamese");
$arrayLang[] = array("short" => "cy", "name" => "Welsh"); ?>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("update_language"); ?></h3>
            </div>
            <form action="<?= base_url('LanguageController/editLanguagePost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= esc($language->id); ?>">

                <div class="box-body">
                    <?= view('admin/includes/_messages'); ?>

                    <div class="form-group">
                        <label><?= trans("language_name"); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans("language_name"); ?>" value="<?= $language->name; ?>" maxlength="200" required>
                        <small>(Ex: English)</small>
                    </div>

                    <?php if ($language->short_form == "en"): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("short_form"); ?> </label>
                            <input type="text" class="form-control" name="short_form" placeholder="<?= trans("short_form"); ?>" value="<?= $language->short_form; ?>" maxlength="200" readonly required>
                            <small>(Ex: en)</small>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("short_form"); ?> </label>
                            <input type="text" class="form-control" name="short_form" placeholder="<?= trans("short_form"); ?>" value="<?= $language->short_form; ?>" maxlength="200" required>
                            <small>(Ex: en)</small>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="control-label"><?= trans("language_code"); ?> </label>
                        <input type="text" class="form-control" name="language_code" placeholder="<?= trans("language_code"); ?>" value="<?= $language->language_code; ?>" maxlength="200" required>
                        <small>(Ex: en_us)</small>
                    </div>

                    <div class="form-group">
                        <label><?= trans('order'); ?></label>
                        <input type="number" class="form-control" name="language_order" placeholder="<?= trans('order'); ?>" value="<?= $language->language_order; ?>" min="1" required>
                    </div>

                    <div class="form-group">
                        <label><?= trans('text_editor_language'); ?></label>
                        <select name="text_editor_lang" class="form-control" required>
                            <?php foreach ($arrayLang as $item): ?>
                                <option value="<?= $item['short']; ?>" <?= $item['short'] == $language->text_editor_lang ? 'selected' : ''; ?>><?= $item['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('text_direction'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_type_1" name="text_direction" value="ltr" class="square-purple" <?= $language->text_direction == "ltr" ? 'checked' : ''; ?>>
                                <label for="rb_type_1" class="cursor-pointer"><?= trans("left_to_right"); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_type_2" name="text_direction" value="rtl" class="square-purple" <?= $language->text_direction == "rtl" ? 'checked' : ''; ?>>
                                <label for="rb_type_2" class="cursor-pointer"><?= trans("right_to_left"); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="1" id="status1" class="square-purple" <?= $language->status == "1" ? 'checked' : ''; ?>>&nbsp;&nbsp;
                                <label for="status1" class="option-label"><?= trans('active'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="0" id="status2" class="square-purple" <?= $language->status != "1" ? 'checked' : ''; ?>>&nbsp;&nbsp;
                                <label for="status2" class="option-label"><?= trans('inactive'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>