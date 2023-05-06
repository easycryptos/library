<?php namespace App\Models;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $builder;
    protected $builderTranslations;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('languages');
        $this->builderTranslations = $this->db->table('language_translations');
    }

    //input values
    public function inputValues()
    {
        return [
            'name' => inputPost('name'),
            'short_form' => inputPost('short_form'),
            'language_code' => inputPost('language_code'),
            'language_order' => inputPost('language_order'),
            'text_direction' => inputPost('text_direction'),
            'text_editor_lang' => inputPost('text_editor_lang'),
            'status' => inputPost('status')
        ];
    }

    //add language
    public function addLanguage()
    {
        $data = $this->inputValues();
        if ($this->builder->insert($data)) {
            $langId = $this->db->insertID();
            $translations = $this->getLanguageTranslations(1);
            if (!empty($translations)) {
                foreach ($translations as $translation) {
                    $dataTranslation = array(
                        'lang_id' => $langId,
                        'label' => $translation->label,
                        'translation' => $translation->translation
                    );
                    $this->builderTranslations->insert($dataTranslation);
                }
            }
            return $langId;
        }
        return false;
    }

    //add language rows
    public function addLanguageSettings($langId)
    {
        $settings = [
            'lang_id' => $langId,
            'application_name' => "Infinite",
            'site_title' => "Infinite - Blog Magazine",
            'home_title' => "Index",
            'site_description' => "Infinite - Blog Magazine",
            'keywords' => "Infinite, Blog, Magazine",
            'primary_font' => 19,
            'secondary_font' => 25,
            'facebook_url' => "",
            'twitter_url' => "",
            'instagram_url' => "",
            'pinterest_url' => "",
            'linkedin_url' => "",
            'vk_url' => "",
            'telegram_url' => "",
            'youtube_url' => "",
            'optional_url_button_name' => "Click Here To See More",
            'about_footer' => "",
            'contact_text' => "",
            'contact_address' => "",
            'contact_email' => "",
            'contact_phone' => "",
            'cookies_warning' => 0,
            'cookies_warning_text' => "",
            'copyright' => "Copyright 2020 Infinite - All Rights Reserved."
        ];
        $this->db->table('settings')->insert($settings);
    }

    //add language pages
    public function addLanguagePages($langId)
    {
        $page = [
            'lang_id' => $langId, 'title' => "Gallery", 'slug' => "gallery", 'page_description' => "Infinite Gallery Page", 'page_keywords' => "infinite, gallery , page", 'is_custom' => 0, 'page_content' => "", 'page_order' => 2, 'page_active' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => "header", 'parent_id' => 0
        ];
        $this->db->table('pages')->insert($page);
        $page = [
            'lang_id' => $langId, 'title' => "Contact", 'slug' => "contact", 'page_description' => "Infinite Contact Page", 'page_keywords' => "infinite, contact, page", 'is_custom' => 0, 'page_content' => "", 'page_order' => 0, 'page_active' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => "header", 'parent_id' => 0
        ];
        $this->db->table('pages')->insert($page);
        $page = [
            'lang_id' => $langId, 'title' => "Terms & Conditions", 'slug' => "terms-conditions", 'page_description' => "Terms & Conditions Page", 'page_keywords' => "infinite, terms, conditions, page", 'is_custom' => 0, 'page_content' => "", 'page_order' => 0, 'page_active' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => "footer", 'parent_id' => 0
        ];
        $this->db->table('pages')->insert($page);
    }

    //edit language
    public function editLanguage($id)
    {
        $language = $this->getLanguage($id);
        if (!empty($language)) {
            $data = $this->inputValues();
            return $this->builder->where('id', $language->id)->update($data);
        }
    }

    //get language
    public function getLanguage($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get first language
    public function getFirstLanguage()
    {
        return $this->builder->get()->getFirstRow();
    }

    //get languages
    public function getLanguages()
    {
        return $this->builder->orderBy('language_order')->get()->getResult();
    }

    //get language translations
    public function getLanguageTranslations($langId)
    {
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->get()->getResult();
    }

    //get paginated translations
    public function getTranslationsPaginated($langId, $perPage, $offset)
    {
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builderTranslations->groupStart()->like('label', $q)->orLike('translation', $q)->groupEnd();
        }
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->orderBy('id')->limit($perPage, $offset)->get()->getResult();
    }

    //get translations count
    public function getTranslationCount($langId)
    {
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builderTranslations->groupStart()->like('label', $q)->orLike('translation', $q)->groupEnd();
        }
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->countAllResults();
    }

    //get active languages
    public function getActiveLanguages()
    {
        return $this->builder->where('status', 1)->get()->getResult();
    }

    //set default language
    public function setDefaultLanguage()
    {
        $data = [
            'site_lang' => inputPost('site_lang'),
        ];
        $lang = $this->getLanguage($data["site_lang"]);
        if (!empty($lang)) {
            return $this->db->table('general_settings')->where('id', 1)->update($data);
        }
        return false;
    }

    //delete language
    public function deleteLanguage($id)
    {
        $language = $this->getLanguage($id);
        if (!empty($language)) {
            //delete translations
            $this->builderTranslations->where('lang_id', $language->id)->delete();
            //delete settings
            $this->db->table('settings')->where('lang_id', $language->id)->delete();
            //delete pages
            $this->db->table('pages')->where('lang_id', $language->id)->delete();
            //delete language
            return $this->builder->where('id', $language->id)->delete();
        }
        return false;
    }

    //update translation
    public function editTranslations($langId, $id, $translation)
    {
        $data = [
            'translation' => $translation
        ];
        return $this->builderTranslations->where('lang_id', cleanNumber($langId))->where('id', cleanNumber($id))->update($data);
    }

    //import language
    public function importLanguage()
    {
        $uploadModel = new UploadModel();
        $uploadedFile = $uploadModel->uploadTempFile('file');
        if (!empty($uploadedFile) && !empty($uploadedFile['path'])) {
            $json = file_get_contents($uploadedFile['path']);
            if (!empty($json)) {
                $count = itemCount($this->getLanguages());
                $jsonArray = json_decode($json);
                $language = $jsonArray->language;
                //add language
                if (isset($jsonArray->language)) {
                    $data = array(
                        'name' => isset($jsonArray->language->name) ? $jsonArray->language->name : 'language',
                        'short_form' => isset($jsonArray->language->short_form) ? $jsonArray->language->short_form : 'ln',
                        'language_code' => isset($jsonArray->language->language_code) ? $jsonArray->language->language_code : 'cd',
                        'text_direction' => isset($jsonArray->language->text_direction) ? $jsonArray->language->text_direction : 'ltr',
                        'text_editor_lang' => isset($jsonArray->language->text_editor_lang) ? $jsonArray->language->text_editor_lang : 'ln',
                        'status' => 1,
                        'language_order' => $count + 1
                    );
                    $this->builder->insert($data);
                    $insertId = $this->db->insertID();
                    $this->addLanguageSettings($insertId);
                    $this->addLanguagePages($insertId);
                    //add translations
                    if (isset($jsonArray->translations)) {
                        foreach ($jsonArray->translations as $translation) {
                            $dataTranslation = array(
                                'lang_id' => $insertId,
                                'label' => $translation->label,
                                'translation' => $translation->translation
                            );
                            $this->builderTranslations->insert($dataTranslation);
                        }
                    }
                }
            }
            @unlink($uploadedFile['path']);
            return true;
        }
        return false;
    }

    //export language
    public function exportLanguage()
    {
        $langId = inputPost("lang_id");
        $language = $this->getLanguage($langId);
        if (!empty($language)) {
            $arrayLang = array();
            $objLang = new \stdClass();
            $objLang->name = $language->name;
            $objLang->short_form = $language->short_form;
            $objLang->language_code = $language->language_code;
            $objLang->text_direction = $language->text_direction;
            $objLang->text_editor_lang = $language->text_editor_lang;
            $arrayLang['language'] = $objLang;
            //translations
            $arrayLang['translations'] = $this->builderTranslations->select('label,translation')->where('lang_id', cleanNumber($langId))->orderBy('id')->get()->getResult();
            return $arrayLang;
        }
        return null;
    }
}
