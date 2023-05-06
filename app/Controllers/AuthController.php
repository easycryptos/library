<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\EmailModel;
use App\Models\NewsletterModel;

class AuthController extends BaseController
{
    /**
     * Login
     */
    public function login()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }

        $data['title'] = trans("login");
        $data['description'] = trans("login") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("login") . "," . $this->settings->application_name;

        echo view('partials/_header', $data);
        echo view('auth/login', $data);
        echo view('partials/_footer');
    }

    /**
     * Login Post
     */
    public function loginPost()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('username', trans("username"), 'required|max_length[255]');
        $val->setRule('password', trans("password"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $model = new AuthModel();
            $result = $model->login();
            if ($result == "banned") {
                $this->session->setFlashdata('error', trans("message_ban_error"));
                return redirect()->back()->withInput();
            } elseif ($result == "success") {
                $redirect = inputPost('redirectUrl');
                return redirect()->to($redirect);
            }
        }
        $this->session->setFlashdata('error', trans("login_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Connect with Facebook
     */
    public function connectWithFacebook()
    {
        $state = generateToken();
        $fbUrl = "https://www.facebook.com/v2.10/dialog/oauth?client_id=" . $this->generalSettings->facebook_app_id . "&redirect_uri=" . langBaseUrl() . "/facebook-callback&scope=email&state=" . $state;
        $this->session->set('oauth2state', $state);
        $this->session->set('fbLoginReferrer', previous_url());
        return redirect()->to($fbUrl);
    }

    /**
     * Facebook Callback
     */
    public function facebookCallback()
    {
        require_once APPPATH . "ThirdParty/facebook/vendor/autoload.php";
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' => $this->generalSettings->facebook_app_id,
            'clientSecret' => $this->generalSettings->facebook_app_secret,
            'redirectUri' => langBaseUrl() . '/facebook-callback',
            'graphApiVersion' => 'v2.10',
        ]);
        if (!isset($_GET['code'])) {
            echo 'Error: Invalid Login';
            exit();
            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $this->session->get('oauth2state'))) {
            $this->session->remove('oauth2state');
            echo 'Error: Invalid State';
            exit();
        }
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        try {
            $user = $provider->getResourceOwner($token);
            $fbUser = new \stdClass();
            $fbUser->id = $user->getId();
            $fbUser->email = $user->getEmail();
            $fbUser->name = $user->getName();
            $fbUser->firstName = $user->getFirstName();
            $fbUser->lastName = $user->getLastName();
            $fbUser->pictureURL = $user->getPictureUrl();
            $model = new AuthModel();
            $model->loginWithFacebook($fbUser);
            if (!empty($this->session->get('fbLoginReferrer'))) {
                return redirect()->to($this->session->get('fbLoginReferrer'));
            } else {
                return redirect()->to(langBaseUrl());
            }
        } catch (\Exception $e) {
            echo 'Error: Invalid User';
            exit();
        }
    }

    /**
     * Connect with Google
     */
    public function connectWithGoogle()
    {
        require_once APPPATH . 'ThirdParty/google/vendor/autoload.php';
        $provider = new \League\OAuth2\Client\Provider\Google([
            'clientId' => $this->generalSettings->google_client_id,
            'clientSecret' => $this->generalSettings->google_client_secret,
            'redirectUri' => base_url('connect-with-google'),
        ]);

        if (!empty($_GET['error'])) {
            exit('Got error: ' . esc($_GET['error'], ENT_QUOTES, 'UTF-8'));
        } elseif (empty($_GET['code'])) {
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            $this->session->set('gLoginReferrer', previous_url());
            return redirect()->to($authUrl);
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            try {
                $user = $provider->getResourceOwner($token);
                $gUser = new \stdClass();
                $gUser->id = $user->getId();
                $gUser->email = $user->getEmail();
                $gUser->name = $user->getName();
                $gUser->firstName = $user->getFirstName();
                $gUser->lastName = $user->getLastName();
                $gUser->avatar = $user->getAvatar();

                $model = new AuthModel();
                $model->loginWithGoogle($gUser);
                if (!empty($this->session->get('gLoginReferrer'))) {
                    return redirect()->to($this->session->get('gLoginReferrer'));
                } else {
                    return redirect()->to(langBaseUrl());
                }
            } catch (Exception $e) {
                exit('Something went wrong: ' . $e->getMessage());
            }
        }
    }

    /**
     * Register
     */
    public function register()
    {
        if (authCheck() || $this->generalSettings->registration_system != 1) {
            return redirect()->to(langBaseUrl());
        }

        $data['title'] = trans("register");
        $data['description'] = trans("register") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("register") . "," . $this->settings->application_name;

        echo view('partials/_header', $data);
        echo view('auth/register', $data);
        echo view('partials/_footer');
    }

    /**
     * Register Post
     */
    public function registerPost()
    {
        if (authCheck() || $this->generalSettings->registration_system != 1) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('username', trans("username"), 'required|min_length[4]|max_length[255]|is_unique[users.username]');
        $val->setRule('email', trans("email"), 'required|valid_email|max_length[255]|is_unique[users.email]');
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[255]');
        $val->setRule('confirm_password', trans("confirm_password"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if (reCAPTCHA('validate', $this->generalSettings) == 'invalid') {
                $this->session->setFlashdata('error', trans("msg_recaptcha"));
                return redirect()->back()->withInput();
            } else {
                $model = new AuthModel();
                if ($model->register()) {
                    $this->session->setFlashdata('success', trans("msg_register_success"));
                    return redirect()->to(langBaseUrl('settings'));
                }
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back();
    }

    /**
     * Forgot Password
     */
    public function forgotPassword()
    {
        if (authCheck() || $this->generalSettings->registration_system != 1) {
            return redirect()->to(langBaseUrl());
        }

        $data['title'] = trans("forgot_password");
        $data['description'] = trans("forgot_password") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("forgot_password") . "," . $this->settings->application_name;

        echo view('partials/_header', $data);
        echo view('auth/forgot_password');
        echo view('partials/_footer');
    }

    /**
     * Forgot Password Post
     */
    public function forgotPasswordPost()
    {
        if (authCheck() || $this->generalSettings->registration_system != 1) {
            return redirect()->to(langBaseUrl());
        }
        $email = inputPost('email');
        $user = $this->authModel->getUserByEmail($email);
        if (empty($user)) {
            $this->session->setFlashdata('error', trans("reset_password_error"));
        } else {
            $emailModel = new EmailModel();
            $emailModel->sendEmailResetPassword($user->id);
            $this->session->setFlashdata('success', trans("msg_reset_password_success"));
        }
        return redirect()->to(base_url('forgot-password'));
    }

    /**
     * Reset Password
     */
    public function resetPassword()
    {
        if (authCheck() || $this->generalSettings->registration_system != 1) {
            return redirect()->to(langBaseUrl());
        }

        $data['title'] = trans("reset_password");
        $data['description'] = trans("reset_password") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("reset_password") . "," . $this->settings->application_name;

        $token = inputGet('token', true);
        $data["user"] = $this->authModel->getUserByToken($token);
        $data["pass_reset_completed"] = $this->session->getFlashdata('pass_reset_completed');

        if (empty($data["user"]) && empty($data["pass_reset_completed"])) {
            return redirect()->to(langBaseUrl());
        }

        echo view('partials/_header', $data);
        echo view('auth/reset_password');
        echo view('partials/_footer');
    }


    /**
     * Reset Password Post
     */
    public function resetPasswordPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[255]');
        $val->setRule('password_confirm', trans("confirm_password"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $token = inputPost('token');
            if ($this->authModel->resetPassword($token)) {
                $this->session->setFlashdata('pass_reset_completed', 1);
                $this->session->setFlashdata('success', trans("message_change_password"));
            } else {
                $this->session->set_flashdata('error', trans("change_password_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Unsubscribe
     */
    public function unsubscribe()
    {
        $data['title'] = trans("unsubscribe");
        $data['description'] = trans("unsubscribe");
        $data['keywords'] = trans("unsubscribe");

        $token = inputGet("token");
        $model = new NewsletterModel();
        $subscriber = $model->getSubscriberByToken($token);
        if (empty($subscriber)) {
            return redirect()->to(base_url());
        }
        $model->unsubscribeEmail($subscriber->email);

        echo view('partials/_header', $data);
        echo view('auth/unsubscribe');
        echo view('partials/_footer');
    }
}
