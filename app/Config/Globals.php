<?php

namespace Config;

use App\Models\PostModel;
use CodeIgniter\Config\BaseConfig;
use \App\Models\AuthModel;

class Globals extends BaseConfig
{
    private static $db = null;
    public static $generalSettings = array();
    public static $settings = array();
    public static $languages = array();
    public static $defaultLang = array();
    public static $languageTranslations = array();
    public static $activeLang = array();
    public static $langBaseUrl = "";
    public static $authCheck = false;
    public static $authUser = null;
    public static $authUserRole = null;

    public static function setGlobals()
    {
        self::$db = \Config\Database::connect();
        $session = \Config\Services::session();
        //set general settings
        self::$generalSettings = self::$db->table('general_settings')->where('id', 1)->get()->getRow();
        //set timezone
        if (!empty(self::$generalSettings->timezone)) {
            date_default_timezone_set(self::$generalSettings->timezone);
        }
        //set languages
        self::$languages = self::$db->table('languages')->where('status', 1)->get()->getResult();
        //set active language
        self::$defaultLang = self::$db->table('languages')->where('id', self::$generalSettings->site_lang)->get()->getRow();
        if (empty(self::$defaultLang)) {
            self::$defaultLang = self::$db->table('languages')->get()->getFirstRow();
        }
        $langSegment = getSegmentValue(1);
        $langId = null;
        if (!empty(self::$languages)) {
            foreach (self::$languages as $lang) {
                if ($langSegment == $lang->short_form) {
                    $langId = $lang->id;
                    break;
                }
            }
        }

        if (empty($langId)) {
            $langId = self::$defaultLang->id;
        }
        self::setActiveLanguage($langId);
        if (empty(self::$activeLang)) {
            self::$activeLang = self::$defaultLang;
        }
        $session->set('activeLangId', self::$activeLang->id);
        //set language base URL
        self::$langBaseUrl = base_url(self::$activeLang->short_form);
        if (self::$activeLang->id == self::$defaultLang->id) {
            self::$langBaseUrl = base_url();
        }
        //set settings
        self::$settings = self::$db->table('settings')->where('lang_id', self::$activeLang->id)->get()->getRow();
        //authentication
        if (!empty($session->get('inf_ses_id')) && !empty($session->get('inf_ses_pass'))) {
            $user = self::$db->table('users')->where('id', cleanNumber($session->get('inf_ses_id')))->get()->getRow();
            if (!empty($user) && md5($user->password ?? '') == $session->get('inf_ses_pass') && $user->status == 1) {
                self::$authCheck = true;
                self::$authUser = $user;
                self::$authUserRole = self::$db->table('roles_permissions')->where('id', $user->role_id)->get()->getRow();
            }
        }
    }

    public static function setActiveLanguage($langId)
    {
        if (!empty(self::$languages)) {
            foreach (self::$languages as $lang) {
                if ($langId == $lang->id) {
                    self::$activeLang = $lang;
                    //set language translations
                    self::$languageTranslations = self::$db->table('language_translations')->where('lang_id', self::$activeLang->id)->get()->getResult();
                    $arrayTranslations = array();
                    if (!empty(self::$languageTranslations)) {
                        foreach (self::$languageTranslations as $item) {
                            $arrayTranslations[$item->label] = $item->translation;
                        }
                    }
                    self::$languageTranslations = $arrayTranslations;
                    break;
                }
            }
        }

    }
}

Globals::setGlobals();
