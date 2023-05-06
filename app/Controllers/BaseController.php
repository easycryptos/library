<?php

namespace App\Controllers;

use App\Models\AdModel;
use App\Models\AuthModel;
use App\Models\LanguageModel;
use App\Models\PostAdminModel;
use App\Models\SettingsModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Globals;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['text', 'security', 'cookie'];

    public $session;
    public $authModel;
    public $settingsModel;
    public $generalSettings;
    public $settings;
    public $languages;
    public $activeLang;
    public $activeFonts;
    public $darkMode;
    public $rtl;
    public $menuLinks;

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload Services
        //--------------------------------------------------------------------
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();

        $this->authModel = new AuthModel();
        $this->settingsModel = new SettingsModel();
        //general settings
        $this->generalSettings = Globals::$generalSettings;
        //settings
        $this->settings = Globals::$settings;
        //languages
        $this->languages = Globals::$languages;
        //active lang
        $this->activeLang = Globals::$activeLang;
        //site fonts
        $this->activeFonts = $this->settingsModel->getSelectedFonts($this->settings);
        //dark mode
        $this->darkMode = $this->generalSettings->dark_mode;
        if (!empty(helperGetCookie('theme_mode'))) {
            if (helperGetCookie('theme_mode') == 'dark') {
                $this->darkMode = 1;
            } else {
                $this->darkMode = 0;
            }
        }

        //dark mode
        $this->rtl = false;
        //menu links
        $this->menuLinks = getMenuLinks($this->activeLang->id);
        //ad spaces
        $adModel = new AdModel();
        $adSpaces = $adModel->getAdSpacesByLang($this->activeLang->id);

        if (checkCronTime(1)) {
            //delete old sessions
            $this->settingsModel->deleteOldSessions();
            //delete old posts
            if ($this->generalSettings->auto_post_deletion == 1) {
                $postModel = new PostAdminModel();
                $postModel->deleteOldPosts();
            }
        }

        //update last seen
        $this->authModel->updateLastSeen();

        //view variables
        $view = \Config\Services::renderer();
        $view->setData(['activeLang' => $this->activeLang, 'generalSettings' => $this->generalSettings, 'settings' => $this->settings, 'languages' => $this->languages, 'activeFonts' => $this->activeFonts, 'darkMode' => $this->darkMode, 'rtl' => $this->rtl, 'menuLinks' => $this->menuLinks, 'adSpaces' => $adSpaces]);

        //maintenance mode
        if ($this->generalSettings->maintenance_mode_status == 1) {
            $router = \Config\Services::router();
            if (strpos($router->controllerName(), 'CommonController') === false) {
                if (!isAdmin()) {
                    echo view('maintenance');
                }
            }
        }
    }
}