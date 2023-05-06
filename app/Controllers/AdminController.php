<?php

namespace App\Controllers;

use App\Models\AdModel;
use App\Models\AuthModel;
use App\Models\CommentModel;
use App\Models\CommonModel;
use App\Models\EmailModel;
use App\Models\NavigationModel;
use App\Models\NewsletterModel;
use App\Models\PageModel;
use App\Models\PollModel;
use App\Models\PostAdminModel;
use App\Models\SettingsModel;
use App\Models\SitemapModel;

class AdminController extends BaseAdminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Index Page
     */
    public function index()
    {
        $data['title'] = trans("index");
        $data['userCount'] = $this->authModel->getUserCount();
        $commentModel = new CommentModel();
        $data['lastComments'] = $commentModel->getLastComments(5);
        $data['lastPendingComments'] = $commentModel->getLastPeddingComments(5);
        $commonModel = new CommonModel();
        $data['lastContacts'] = $commonModel->getLastContactMessages();
        $data['lastUsers'] = $this->authModel->getLastAddedUsers();
        $postAdminModel = new PostAdminModel();
        
        $data['pendingPostCount'] = $postAdminModel->getPendingPostsCount();
        $data['postCount'] = $postAdminModel->getPostsCount();
        $data['draftCount'] = $postAdminModel->getDraftsCount();

        echo view('admin/includes/_header', $data);
        echo view('admin/index', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Themes
     */
    public function themes()
    {
        checkPermission('themes');
        $data['title'] = trans("themes");
        echo view('admin/includes/_header', $data);
        echo view('admin/themes', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Set Mode Post
     */
    public function setModePost()
    {
        checkPermission('themes');
        $this->settingsModel->setThemeMode();
        return redirect()->to(adminUrl('themes'));
    }

    /**
     * Set Theme Post
     */
    public function setThemePost()
    {
        checkPermission('themes');
        $this->settingsModel->setTheme();
        return redirect()->to(adminUrl('themes'));
    }

    /**
     * Navigation
     */
    public function navigation()
    {
        checkPermission('navigation');
        $data['title'] = trans("navigation");
        $model = new NavigationModel();
        $data['menuItems'] = $model->getAllMenuLinks();
        
        $data['langSearchColumn'] = 3;

        echo view('admin/includes/_header', $data);
        echo view('admin/navigation/navigation', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Menu Link Post
     */
    public function addMenuLinkPost()
    {
        checkPermission('navigation');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $model = new NavigationModel();
            if ($model->addLink()) {
                $this->session->setFlashdata('success', trans("link") . " " . trans("msg_suc_added"));
                return redirect()->back();
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Edit Menu Link
     */
    public function editMenuLink($id)
    {
        checkPermission('navigation');
        $data['title'] = trans("navigation");
        $model = new PageModel();
        $data['page'] = $model->getPage($id);
        if (empty($data['page'])) {
            return redirect()->back();
        }
        $navModel = new NavigationModel();
        $data['menuItems'] = $navModel->getMenuLinks($data['page']->lang_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/navigation/update_navigation', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Menü Link Post
     */
    public function editMenuLinkPost()
    {
        checkPermission('navigation');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            $model = new NavigationModel();
            if ($model->editLink($id)) {
                $this->session->setFlashdata('success', trans("link") . " " . trans("msg_suc_updated"));
                return redirect()->to(adminUrl('navigation'));
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back();
    }

    /**
     * Delete Navigation Post
     */
    public function deleteNavigationPost()
    {
        checkPermission('navigation');
        $id = inputPost('id');
        $model = new PageModel();
        if ($model->deletePage($id)) {
            $this->session->setFlashdata('success', trans("link") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Menu Limit Post
     */
    public function menuLimitPost()
    {
        checkPermission('navigation');
        $model = new NavigationModel();
        if ($model->updateMenuLimit()) {
            $this->session->setFlashdata('success', trans("menu_limit") . " " . trans("msg_suc_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    //get menu links by language
    public function getMenuLinksByLang()
    {
        $langId = inputPost('lang_id');
        if (!empty($langId)):
            $model = new NavigationModel();
            $menuItems = $model->getMenuLinks($langId);
            foreach ($menuItems as $menuItem):
                if ($menuItem->item_type != "category" && $menuItem->item_location == "header" && $menuItem->item_parent_id == "0"):
                    echo '<option value="' . $menuItem->item_id . '">' . $menuItem->item_name . '</option>';
                endif;
            endforeach;
        endif;
    }

    /**
     * -------------------------------------------------------------------------------------------
     * PAGES
     * -------------------------------------------------------------------------------------------
     */

    /**
     * Add Page
     */
    public function addPage()
    {
        checkPermission('pages');
        $data['title'] = trans("add_page");
        $model = new NavigationModel();
        $data['menuItems'] = $model->getMenuLinks($this->activeLang->id);
        
        echo view('admin/includes/_header', $data);
        echo view('admin/page/add', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Page Post
     */
    public function addPagePost()
    {
        checkPermission('pages');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $model = new PageModel();
            if ($model->addPage()) {
                $this->session->setFlashdata('success', trans("page") . " " . trans("msg_suc_added"));
                return redirect()->back();
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Pages
     */
    public function pages()
    {
        checkPermission('pages');
        $data['title'] = trans("pages");
        $model = new PageModel();
        $data['pages'] = $model->getPages();
        
        $data['langSearchColumn'] = 2;

        echo view('admin/includes/_header', $data);
        echo view('admin/page/pages', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Page
     */
    public function editPage($id)
    {
        checkPermission('pages');
        $data['title'] = trans("update_page");
        $model = new PageModel();
        $data['page'] = $model->getPage($id);
        if (empty($data['page'])) {
            return redirect()->back();
        }
        $navigationModel = new NavigationModel();
        
        $data['menuItems'] = $navigationModel->getMenuLinks($data['page']->lang_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/page/update', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Page Post
     */
    public function editPagePost()
    {
        checkPermission('pages');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            $redirectUrl = inputPost('redirect_url');
            $model = new PageModel();
            if ($model->editPage($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
                if (!empty($redirectUrl)) {
                    return redirect()->to(adminUrl($redirectUrl));
                }
                return redirect()->to(adminUrl('pages'));
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Delete Page Post
     */
    public function deletePagePost()
    {
        checkPermission('pages');
        $id = inputPost('id');
        $model = new PageModel();
        if ($model->deletePage($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Comments
     */
    public function comments()
    {
        checkPermission('comments');
        $data['title'] = trans("approved_comments");
        $model = new CommentModel();
        
        $data['comments'] = $model->getApprovedComments();
        $data['top_button_text'] = trans("pending_comments");
        $data['top_button_url'] = adminUrl("pending-comments");
        $data['show_approve_button'] = false;

        echo view('admin/includes/_header', $data);
        echo view('admin/comments', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Pending Comments
     */
    public function pendingComments()
    {
        checkPermission('comments');
        $data['title'] = trans("pending_comments");
        $model = new CommentModel();
        
        $data['comments'] = $model->getPendingComments();
        $data['top_button_text'] = trans("approved_comments");
        $data['top_button_url'] = adminUrl("comments");
        $data['show_approve_button'] = true;

        echo view('admin/includes/_header', $data);
        echo view('admin/comments', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Aprrove Comment Post
     */
    public function approveCommentPost()
    {
        checkPermission('comments');
        $id = inputPost('id');
        $model = new CommentModel();
        if ($model->approveComment($id)) {
            $this->session->setFlashdata('success', trans("msg_comment_approved"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('pending-comments'));
    }

    /**
     * Delete Comment Post
     */
    public function deleteCommentPost()
    {
        checkPermission('comments');
        $id = inputPost('id');
        $model = new CommentModel();
        if ($model->deleteComment($id)) {
            $this->session->setFlashdata('success', trans("comment") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Comments
     */
    public function deleteSelectedComments()
    {
        checkPermission('comments');
        $commentIds = inputPost('comment_ids');
        $model = new CommentModel();
        $model->deleteMultiComments($commentIds);
    }

    /**
     * Approve Selected Comments
     */
    public function approveSelectedComments()
    {
        checkPermission('comments');
        $commentIds = inputPost('comment_ids');
        $model = new CommentModel();
        $model->approveMultiComments($commentIds);
    }

    /**
     * Contact Messages
     */
    public function contactMessages()
    {
        checkPermission('contact_messages');
        $data['title'] = trans("contact_messages");
        $model = new CommonModel();
        
        $data['messages'] = $model->getContactMessages();

        echo view('admin/includes/_header', $data);
        echo view('admin/contact_messages', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Delete Contact Message Post
     */
    public function deleteContactMessagePost()
    {
        checkPermission('contact_messages');
        $id = inputPost('id');
        $model = new CommonModel();
        if ($model->deleteContactMessage($id)) {
            $this->session->setFlashdata('success', trans("message") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Ads
     */
    public function adSpaces()
    {
        checkPermission('ad_spaces');
        $adModel = new AdModel();
        $data['title'] = trans("ad_spaces");
        $data['adSpaceKey'] = inputGet('ad_space');
        $data['langId'] = inputGet('lang');
        if (empty($data['adSpaceKey'])) {
            $data['adSpaceKey'] = 'index_top';
        }
        
        $lang = getLanguageById($data['langId']);
        if (empty($lang)) {
            $data['langId'] = $this->activeLang->id;
        }
        $data['adSpace'] = $adModel->getAdSpace($data['langId'], $data['adSpaceKey']);
        if (empty($data['adSpace'])) {
            return redirect()->to(adminUrl('ad-spaces'));
        }
        $data['arrayAdSpaces'] = [
            'index_top' => trans('ad_space_index_top'),
            'index_bottom' => trans('ad_space_index_bottom'),
            'post_top' => trans('ad_space_post_top'),
            'post_bottom' => trans('ad_space_post_bottom'),
            'posts_top' => trans('ad_space_posts_top'),
            'posts_bottom' => trans('ad_space_posts_bottom'),
            'sidebar_1' => trans('sidebar') . '-1',
            'sidebar_2' => trans('sidebar') . '-2',
            'in_article_1' => trans('ad_space_in_article') . '-1',
            'in_article_2' => trans('ad_space_in_article') . '-2'
        ];

        echo view('admin/includes/_header', $data);
        echo view('admin/ad_spaces', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Ad Spaces Post
     */
    public function adSpacesPost()
    {
        checkPermission('ad_spaces');
        $id = inputPost('id');
        $model = new AdModel();
        if ($model->updateAdSpaces($id)) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        redirectToBackURL();
    }

    /**
     * Google Adsense Code Post
     */
    public function googleAdsenseCodePost()
    {
        checkPermission('ad_spaces');
        $model = new AdModel();
        if ($model->updateGoogleAdsenseCode()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Settings
     */
    public function settings()
    {
        checkPermission('settings');
        $data["settingsLangId"] = inputGet("lang", true);
        if (empty($data["settingsLangId"])) {
            $data["settingsLangId"] = $this->generalSettings->site_lang;
            return redirect()->to(adminUrl("settings?lang=" . $data["settingsLangId"]));
        }
        
        $data['title'] = trans("settings");
        $data['formSettings'] = $this->settingsModel->getSettings($data["settingsLangId"]);

        echo view('admin/includes/_header', $data);
        echo view('admin/settings', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Settings Post
     */
    public function settingsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateSettings()) {
            $this->settingsModel->updateGeneralSettings();
            $this->session->setFlashdata('success', trans("settings") . " " . trans("msg_suc_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        $settings = $this->settingsModel->getGeneralSettings();
        if (!empty($settings)) {
            $lang = cleanNumber(inputPost('lang_id'));
            return redirect()->to(base_url($settings->admin_route . "/settings?lang=" . $lang));
        }
        return redirect()->back();
    }

    /**
     * Recaptcha Settings Post
     */
    public function recaptchaSettingsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateRecaptchaSettings()) {
            $this->session->setFlashdata('success', trans("settings") . " " . trans("msg_suc_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Maintenance Mode Post
     */
    public function maintenanceModePost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateMaintenanceModeSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Allowed File Extensions Post
     */
    public function allowedFileExtensionsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateAllowedFileExtensions()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Seo Tools
     */
    public function seoTools()
    {
        checkPermission('seo_tools');
        $data['title'] = trans("seo_tools");
        $data["toolsLang"] = inputGet('lang', true);
        if (empty($data["toolsLang"])) {
            $data["toolsLang"] = $this->generalSettings->site_lang;
            return redirect()->to(adminUrl("seo-tools?lang=" . $data["toolsLang"]));
        }
        
        $data['settingsTools'] = $this->settingsModel->getSettings($data["toolsLang"]);

        echo view('admin/includes/_header', $data);
        echo view('admin/seo_tools', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Seo Tools Post
     */
    public function seoToolsPost()
    {
        checkPermission('seo_tools');
        if ($this->settingsModel->updateSeoSettings()) {
            $this->session->setFlashdata('success', trans("seo_options") . " " . trans("msg_suc_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Generate Sitemap Post
     */
    public function generateSitemapPost()
    {
        checkPermission('seo_tools');
        $sitemapModel = new SitemapModel();
        $sitemapModel->updateSitemapSettings();
        $sitemapModel->generateSitemap();
        $this->session->setFlashdata('success', trans("sitemap") . " " . trans("msg_suc_updated"));
        return redirect()->back();
    }

    /**
     * Delete Sitemap Post
     */
    public function deleteSitemapPost()
    {
        checkPermission('seo_tools');
        $path = inputPost('path');
        if (file_exists($path)) {
            @unlink($path);
        }
        return redirect()->back();
    }

    /**
     * Social Login Settings
     */
    public function socialLoginSettings()
    {
        checkPermission('settings');
        $data['title'] = trans("social_login_settings");
        

        echo view('admin/includes/_header', $data);
        echo view('admin/social_login_settings', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Social Login Post
     */
    public function socialLoginSettingsPost()
    {
        checkPermission('settings');
        $model = new SettingsModel();
        if ($model->editSocialSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('social-login-settings'));
    }

    /**
     * Cache System
     */
    public function cacheSystem()
    {
        checkPermission('settings');
        $data['title'] = trans("cache_system");
        
        echo view('admin/includes/_header', $data);
        echo view('admin/cache_system', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Cache System Post
     */
    public function cacheSystemPost()
    {
        checkPermission('settings');
        $action = inputPost('action');
        if ($action == 'reset') {
            resetCacheData();
            $this->session->setFlashdata('success', trans("msg_reset_cache"));
        } else {
            if ($this->settingsModel->updateCacheSystem()) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('cache-system'));
    }

    /**
     * Email Settings
     */
    public function emailSettings()
    {
        checkPermission('settings');
        $data['title'] = trans("email_settings");
        
        $data['service'] = inputGet('service');
        $data['protocol'] = inputGet('protocol');
        if (empty($data['service'])) {
            $data['service'] = $this->generalSettings->mail_service;
        }
        if ($data['service'] != 'swift' && $data['service'] != 'php' && $data['service'] != 'mailjet') {
            $data['service'] = 'swift';
        }
        if (empty($data['protocol'])) {
            $data['protocol'] = $this->generalSettings->mail_protocol;
        }
        if ($data['protocol'] != 'smtp' && $data['protocol'] != 'mail') {
            $data['protocol'] = 'smtp';
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/email_settings', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Email Settings Post
     */
    public function emailSettingsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateEmailSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('email-settings'));
    }

    /**
     * Email Options Post
     */
    public function emailOptionsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateEmailOptions()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Send Test Email Post
     */
    public function sendTestEmailPost()
    {
        checkPermission('settings');
        $email = inputPost('email');
        $subject = "Infinite Test Email";
        $message = "<p>This is a test email.</p>";
        if (!empty($email)) {
            $emailModel = new EmailModel();
            if (!$emailModel->sendTestEmail($email, $subject, $message)) {
                $this->session->setFlashdata('error', trans("msg_error"));
            } else {
                $this->session->setFlashdata('success', trans("msg_email_sent"));
            }
        }
        return redirect()->back();
    }

    /**
     * -------------------------------------------------------------------------------------------
     * POLLS
     * -------------------------------------------------------------------------------------------
     */

    /**
     * Add Poll
     */
    public function addPoll()
    {
        checkPermission('polls');
        $data['title'] = trans("add_poll");
        
        echo view('admin/includes/_header', $data);
        echo view('admin/poll/add', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Poll Post
     */
    public function addPollPost()
    {
        checkPermission('polls');
        $val = \Config\Services::validation();
        $val->setRule('question', trans("question"), 'required');
        $val->setRule('option1', trans("option_1"), 'required');
        $val->setRule('option2', trans("option_2"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $model = new PollModel();
            if ($model->addPoll()) {
                $this->session->setFlashdata('success', trans("poll") . " " . trans("msg_suc_added"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Polls
     */
    public function polls()
    {
        checkPermission('polls');
        $data['title'] = trans("polls");
        $model = new PollModel();
        $data['polls'] = $model->getAllPolls();
        
        $data['langSearchColumn'] = 2;
        echo view('admin/includes/_header', $data);
        echo view('admin/poll/polls', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Poll
     */
    public function editPoll($id)
    {
        checkPermission('polls');
        $data['title'] = trans("update_poll");
        
        $model = new PollModel();
        //find poll
        $data['poll'] = $model->getPoll($id);
        if (empty($data['poll'])) {
            return redirect()->back();
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/poll/update', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Poll Post
     */
    public function editPollPost()
    {
        checkPermission('polls');
        $val = \Config\Services::validation();
        $val->setRule('question', trans("question"), 'required');
        $val->setRule('option1', trans("option_1"), 'required');
        $val->setRule('option2', trans("option_2"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $model = new PollModel();
            $id = inputPost('id');
            if ($model->editPoll($id)) {
                $this->session->setFlashdata('success', trans("poll") . " " . trans("msg_suc_updated"));
                return redirect()->to(adminUrl('polls'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Delete Poll Post
     */
    public function deletePollPost()
    {
        checkPermission('polls');
        $id = inputPost('id');
        $model = new PollModel();
        if ($model->deletePoll($id)) {
            $this->session->setFlashdata('success', trans("poll") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * -------------------------------------------------------------------------------------------
     * USERS
     * -------------------------------------------------------------------------------------------
     */

    /**
     * Users
     */
    public function users()
    {
        checkPermission('membership');
        $data['title'] = trans("users");
        $data['users'] = $this->authModel->getUsers();
        $data['roles'] = $this->authModel->getRoles();
        

        echo view('admin/includes/_header', $data);
        echo view('admin/users/users', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add User
     */
    public function addUser()
    {
        checkPermission('membership');
        $data['title'] = trans("add_user");
        
        $data['roles'] = $this->authModel->getRoles();

        echo view('admin/includes/_header', $data);
        echo view('admin/users/add_user');
        echo view('admin/includes/_footer');
    }

    /**
     * Add User Post
     */
    public function addUserPost()
    {
        checkPermission('membership');
        $val = \Config\Services::validation();
        $val->setRule('username', trans("username"), 'required|min_length[4]|max_length[255]|is_unique[users.username]');
        $val->setRule('email', trans("email"), 'required|valid_email|max_length[255]|is_unique[users.email]');
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->authModel->addUser()) {
                $this->session->setFlashdata('success', trans("msg_user_added"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Edit User
     */
    public function editUser($id)
    {
        checkPermission('membership');
        $data['title'] = trans("edit_user");
        $data['user'] = getUser($id);
        if (empty($data['user'])) {
            return redirect()->to(adminUrl('users'));
        }
        
        $data['role'] = $this->authModel->getRole($data['user']->role_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/users/edit_user');
        echo view('admin/includes/_footer');
    }

    /**
     * Edit User Post
     */
    public function editUserPost()
    {
        checkPermission('membership');
        $val = \Config\Services::validation();
        $val->setRule('username', trans("username"), 'required|min_length[4]|max_length[255]');
        $val->setRule('email', trans("email"), 'required|valid_email|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            $user = getUser($id);
            if (empty($user)) {
                return redirect()->back();
            }
            $data = [
                'email' => inputPost('email'),
                'username' => inputPost('username'),
                'slug' => inputPost('slug')
            ];
            //is email unique
            if (!$this->authModel->isUniqueEmail($data["email"], $user->id)) {
                $this->session->setFlashdata('error', trans("email_unique_error"));
                return redirect()->back();
            }
            //is username unique
            if (!$this->authModel->isUniqueUsername($data["username"], $user->id)) {
                $this->session->setFlashdata('error', trans("msg_username_unique_error"));
                return redirect()->back();
            }
            //is slug unique
            if (!$this->authModel->isSlugUnique($data["slug"], $user->id)) {
                $this->session->setFlashdata('error', trans("msg_slug_used"));
                return redirect()->back();
            }
            if ($this->authModel->editUser($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Change User Role
     */
    public function changeUserRolePost()
    {
        checkPermission('membership');
        $id = inputPost('user_id');
        $roleId = inputPost('role_id');
        $user = $this->authModel->getUser($id);
        if (empty($user)) {
            return redirect()->back();
        } else {
            if ($this->authModel->changeUserRole($id, $roleId)) {
                $this->session->setFlashdata('success', trans("msg_role_changed"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * User Options Post
     */
    public function userOptionsPost()
    {
        checkPermission('membership');
        $option = inputPost('option');
        $id = inputPost('id');
        if ($option == 'ban') {
            if ($this->authModel->banUser($id)) {
                $this->session->setFlashdata('success', trans("msg_user_banned"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        if ($option == 'remove_ban') {
            if ($this->authModel->removeUserBan($id)) {
                $this->session->setFlashdata('success', trans("msg_ban_removed"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Delete User Post
     */
    public function deleteUserPost()
    {
        checkPermission('membership');
        $id = inputPost('id');
        if ($this->authModel->deleteUser($id)) {
            $this->session->setFlashdata('success', trans("user") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Roles Permissions
     */
    public function rolesPermissions()
    {
        checkPermission('membership');
        $data['title'] = trans("roles_permissions");
        $data['roles'] = $this->authModel->getRoles();
        

        echo view('admin/includes/_header', $data);
        echo view('admin/users/roles_permissions');
        echo view('admin/includes/_footer');
    }

    /**
     * Add Role
     */
    public function addRole()
    {
        checkPermission('membership');
        $data['title'] = trans("add_role");
        

        echo view('admin/includes/_header', $data);
        echo view('admin/users/add_role');
        echo view('admin/includes/_footer');
    }


    /**
     * Add Role Post
     */
    public function addRolePost()
    {
        checkPermission('membership');
        if ($this->authModel->addRole()) {
            $this->session->setFlashdata('success', trans("msg_item_added"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('add-role'));
    }

    /**
     * Edit Role
     */
    public function editRole($id)
    {
        checkPermission('membership');
        $data['title'] = trans("edit_role");
        $data['role'] = $this->authModel->getRole($id);
        if (empty($data['role'])) {
            return redirect()->to(adminUrl('roles-permissions'));
        }
        
        echo view('admin/includes/_header', $data);
        echo view('admin/users/edit_role');
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Role Post
     */
    public function editRolePost()
    {
        checkPermission('membership');
        $id = inputPost('id');
        if ($this->authModel->editRole($id)) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('edit-role/' . cleanNumber($id)));
    }

    /**
     * Delete Role Post
     */
    public function deleteRolePost()
    {
        checkPermission('membership');
        $id = inputPost('id');
        if ($this->authModel->deleteRole($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Newsletter
     */
    public function newsletter()
    {
        checkPermission('newsletter');
        $data['title'] = trans("newsletter");
        $model = new NewsletterModel();
        
        $data['subscribers'] = $model->getSubscribers();
        $data['users'] = $this->authModel->getUsers();
        //reset temp emails
        $model = new NewsletterModel();
        $model->resetTempEmails();

        echo view('admin/includes/_header', $data);
        echo view('admin/newsletter/newsletter', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Newsletter Post
     */
    public function newsletterPost()
    {
        checkPermission('newsletter');
        $emails = inputPost('email');
        $submit = inputPost('submit');
        if (empty($emails)) {
            $this->session->setFlashdata('error', trans("newsletter_email_error"));
            return redirect()->back();
        }
        $model = new NewsletterModel();
        $model->addTempEmails($emails);
        $type = 'subscribers';
        if ($submit == 'users') {
            $type = 'users';
        }
        return redirect()->to(adminUrl('newsletter-send-email') . '?type=' . $type);
    }

    /**
     * Send Email
     */
    public function newsletterSendEmail()
    {
        checkPermission('newsletter');
        $data['title'] = trans("newsletter");
        $data['emails'] = unserializeData($this->generalSettings->newsletter_temp_emails);
        if (empty($data['emails'])) {
            $this->session->setFlashdata('error', trans("newsletter_email_error"));
            return redirect()->to(adminUrl('newsletter'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/newsletter/send_email', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Send Email Post
     */
    public function newsletterSendEmailPost()
    {
        $model = new NewsletterModel();
        if (@$model->sendEmail()) {
            echo json_encode(['result' => 1]);
            exit();
        }
        echo json_encode(['result' => 0]);
    }

    /**
     * Newsletter Settings Post
     */
    public function newsletterSettingsPost()
    {
        checkPermission('newsletter');
        $model = new NewsletterModel();
        if ($model->updateSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Delete Newsletter Post
     */
    public function deleteNewsletterPost()
    {
        checkPermission('newsletter');
        $id = inputPost('id');
        $model = new NewsletterModel();
        $data['newsletter'] = $model->getSubscriberById($id);
        if (empty($data['newsletter'])) {
            $this->session->setFlashdata('error', trans("msg_error"));
        } else {
            if ($model->deleteFromSubscribers($id)) {
                $this->session->setFlashdata('success', trans("email") . " " . trans("msg_suc_deleted"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Font Settings
     */
    public function fontSettings()
    {
        checkPermission('settings');
        $data["fontLangId"] = cleanNumber(inputGet('lang'));
        if (empty($data["fontLangId"]) || empty(getLanguageById($data["fontLangId"]))) {
            $data["fontLangId"] = $this->generalSettings->site_lang;
            return redirect()->to(adminUrl("font-settings?lang=" . $data["fontLangId"]));
        }
        
        $data['title'] = trans("font_settings");
        $data['fonts'] = $this->settingsModel->getFonts();
        $data['settings'] = $this->settingsModel->getSettings($data["fontLangId"]);

        echo view('admin/includes/_header', $data);
        echo view('admin/font/fonts', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Set Site Font Post
     */
    public function setSiteFontPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->setDefaultFonts()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        $langId = inputPost('lang_id');
        return redirect()->to(adminUrl('font-settings?lang=' . cleanNumber($langId)));
    }

    /**
     * Add Font Post
     */
    public function addFontPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->addFont()) {
            $this->session->setFlashdata('success', trans("msg_item_added"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Edit Font
     */
    public function editFont($id)
    {
        checkPermission('settings');
        $data['title'] = trans("update_font");
        $data['font'] = $this->settingsModel->getFont($id);
        if (empty($data['font'])) {
            return redirect()->back();
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/font/update', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Font Post
     */
    public function editFontPost()
    {
        checkPermission('settings');
        $id = inputPost('id');
        if ($this->settingsModel->editFont($id)) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl("font-settings?lang=" . $this->generalSettings->site_lang));
    }

    /**
     * Delete Font Post
     */
    public function deleteFontPost()
    {
        checkPermission('settings');
        $id = inputPost('id');
        if ($this->settingsModel->deleteFont($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Set Active Language Post
     */
    public function setActiveLanguagePost()
    {
        $id = cleanNumber(inputPost('lang_id'));
        if (!empty($this->languages)) {
            foreach ($this->languages as $language) {
                if ($language->id == $id) {
                    $this->session->set('inf_admin_lang_id', $id);
                    break;
                }
            }
        }
        return redirect()->back();
    }


    /**
     * Download Database Backup
     */
    public function downloadDatabaseBackup()
    {
        if (user()->role_id != 1) {
            return redirect()->to(adminUrl());
        }
        $response = \Config\Services::response();
        $data = $this->settingsModel->downloadBackup();
        $name = 'db_backup-' . date('Y-m-d H-i-s') . '.sql';
        return $response->download($name, $data);
    }
}
