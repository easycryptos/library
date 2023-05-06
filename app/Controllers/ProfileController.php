<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\PostModel;

class ProfileController extends BaseController
{
    protected $userSession;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Profile Page
     */
    public function profile($slug)
    {
        $model = new AuthModel();
        $data['user'] = $model->getUserBySlug($slug);
        if (empty($data["user"])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = $data['user']->username;
        $data['description'] = $data['user']->username . " - " . $this->settings->application_name;
        $data['keywords'] = $data['user']->username . ', ' . $this->settings->application_name;

        $postModel = new PostModel();
        $data['numRows'] = $postModel->getPostCountByUser($data['user']->id);
        $pager = paginate($this->generalSettings->pagination_per_page, $data['numRows']);
        $data['posts'] = $postModel->getUserPostsPaginated($data['user']->id, $this->generalSettings->pagination_per_page, $pager->offset);

        $data["following"] = $model->getFollowingUsers($data['user']->id);
        $data["followers"] = $model->getFollowers($data['user']->id);

        echo view('partials/_header', $data);
        echo view('profile/profile', $data);
        echo view('partials/_footer');
    }

    /**
     * Edit Profile
     */
    public function editProfile()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("update_profile");
        $data['description'] = trans("update_profile") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("update_profile") . "," . $this->settings->application_name;
        $data["user"] = user();
        $data["activeTab"] = "update_profile";

        echo view('partials/_header', $data);
        echo view('settings/edit_profile', $data);
        echo view('partials/_footer');
    }

    /**
     * Edit Profile Post
     */
    public function editProfilePost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('username', trans("username"), 'required|max_length[255]');
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $data = [
                'username' => inputPost('username'),
                'slug' => inputPost('slug'),
                'email' => inputPost('email'),
                'about_me' => inputPost('about_me'),
                'show_email_on_profile' => inputPost('show_email_on_profile')
            ];
            $model = new AuthModel();
            $user = user();
            //is email unique
            if (!$model->isUniqueEmail($data["email"], $user->id)) {
                $this->session->setFlashdata('error', trans("email_unique_error"));
                return redirect()->back();
            }
            //is username unique
            if (!$model->isUniqueUsername($data["username"], $user->id)) {
                $this->session->setFlashdata('error', trans("msg_username_unique_error"));
                return redirect()->back();
            }
            //is slug unique
            if (!$model->isSlugUnique($data["slug"], $user->id)) {
                $this->session->setFlashdata('error', trans("msg_slug_used"));
                return redirect()->back();
            }
            if ($model->updateProfile($data, $user)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
                return redirect()->back();
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->back();
            }
        }
    }

    /**
     * Social Accounts
     */
    public function socialAccounts()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("social_accounts");
        $data['description'] = trans("social_accounts") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("social_accounts") . "," . $this->settings->application_name;;
        $data["user"] = user();
        $data["activeTab"] = "social_accounts";

        echo view('partials/_header', $data);
        echo view('settings/social_accounts', $data);
        echo view('partials/_footer');
    }

    /**
     * Social Accounts Post
     */
    public function socialAccountsPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $model = new AuthModel();
        if ($model->updateSocialAccounts()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("change_password") . "," . $this->settings->application_name;
        $data["user"] = user();
        $data["activeTab"] = "change_password";

        echo view('partials/_header', $data);
        echo view('settings/change_password', $data);
        echo view('partials/_footer');
    }

    /**
     * Change Password Post
     */
    public function changePasswordPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[255]');
        $val->setRule('password_confirm', trans("confirm_password"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $model = new AuthModel();
            if ($model->changePassword()) {
                $this->session->setFlashdata('success', trans("message_change_password"));
            } else {
                $this->session->setFlashdata('error', trans("change_password_error"));
            }
            return redirect()->back();
        }
    }

    /**
     * Follow Unfollow User
     */
    public function followUnfollowUser()
    {
        if (!authCheck()) {
            redirect(langBaseUrl());
        }
        $model = new AuthModel();
        $model->followUnfollowUser();
        return redirect()->back();
    }

}
