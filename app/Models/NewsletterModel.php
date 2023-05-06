<?php namespace App\Models;

use CodeIgniter\Model;

class NewsletterModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('subscribers');
    }

    //add to subscriber
    public function addSubscriber($email)
    {
        $data = [
            'email' => $email,
            'token' => generateToken(),
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->builder->insert($data);
    }

    //update subscriber token
    public function updateSubscriberToken($email)
    {
        $subscriber = $this->getSubscriber($email);
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $data = [
                    'token' => generateToken()
                ];
                $this->builder->where('email', $email)->update($data);
            }
        }
    }

    //update settings
    public function updateSettings()
    {
        $data = [
            'newsletter_status' => inputPost('newsletter_status'),
            'newsletter_popup' => inputPost('newsletter_popup')
        ];
        return $this->db->table('general_settings')->where('id', 1)->update($data);
    }

    //get subscribers
    public function getSubscribers()
    {
        return $this->builder->get()->getResult();
    }

    //get subscriber
    public function getSubscriber($email)
    {
        return $this->builder->where('email', cleanStr($email))->get()->getRow();
    }

    //get subscriber by id
    public function getSubscriberById($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //delete from subscribers
    public function deleteFromSubscribers($id)
    {
        return $this->builder->where('id', cleanNumber($id))->delete();
    }

    //get subscriber by token
    public function getSubscriberByToken($token)
    {
        $token = removeSpecialCharacters($token);
        return $this->builder->where('token', $token)->get()->getRow();
    }

    //unsubscribe email
    public function unsubscribeEmail($email)
    {
        return $this->builder->where('email', $email)->delete();
    }

    //add temp emails
    public function addTempEmails($emails)
    {
        $array = array();
        if (!empty($emails)) {
            foreach ($emails as $email) {
                array_push($array, $email);
            }
        }
        $data = [
            'newsletter_temp_emails' => serialize($array)
        ];
        return $this->db->table('general_settings')->where('id', 1)->update($data);
    }

    //reset temp emails
    public function resetTempEmails()
    {
        $data = [
            'newsletter_temp_emails' => ''
        ];
        return $this->db->table('general_settings')->where('id', 1)->update($data);
    }

    //send email
    public function sendEmail()
    {
        $emailModel = new EmailModel();
        $email = inputPost('email');
        $subject = inputPost('subject');
        $body = inputPost('body');
        $submit = inputPost('submit');
        if ($submit == "subscribers") {
            $subscriber = $this->getSubscriber($email);
            if (!empty($subscriber)) {
                if ($emailModel->sendEmailNewsletter($subscriber, $subject, $body)) {
                    return true;
                }
            }
        } else {
            $data = [
                'subject' => $subject,
                'message' => $body,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => '',
            ];
            return $emailModel->sendEmail($data);
        }
        return false;
    }
}
