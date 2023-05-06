<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\LanguageModel;
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
class BaseAdminController extends Controller
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
        //check auth
        if (!isAdmin() && !isAuthor()) {
            redirectToUrl(adminUrl('login'));
            exit();
        }

        $this->settingsModel = new SettingsModel();
        //general settings
        $this->generalSettings = Globals::$generalSettings;
        //settings
        $this->settings = Globals::$settings;
        //languages
        $this->languages = Globals::$languages;
        //set Admin language
        Globals::setActiveLanguage($this->session->get('inf_admin_lang_id'));
        //active language
        $this->activeLang = Globals::$activeLang;

        //view variables
        $view = \Config\Services::renderer();
        $view->setData(['activeLang' => $this->activeLang, 'generalSettings' => $this->generalSettings, 'settings' => $this->settings, 'languages' => $this->languages]);

        //maintenance mode
        if ($this->generalSettings->maintenance_mode_status == 1) {
            $router = \Config\Services::router();
            if (strpos($router->controllerName(), 'CommonController') === false) {
                if (!isAdmin()) {
                    $authModel = new AuthModel();
                    $authModel->logout();
                    redirectToUrl(adminUrl('login'));
                    exit();
                }
            }
        }
    }
}