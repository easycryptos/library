<?php namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends BaseModel
{
    protected $builderContact;

    public function __construct()
    {
        parent::__construct();
        $this->builderContact = $this->db->table('contacts');
    }

    /**
     * --------------------------------------------------------------------
     * Contact
     * --------------------------------------------------------------------
     */

    //add contact message
    public function addContactMessage()
    {
        $data = [
            'name' => inputPost('name'),
            'email' => inputPost('email'),
            'message' => inputPost('message'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        //send email
        if ($this->generalSettings->send_email_contact_messages == 1) {
            $emailModel = new EmailModel();
            $emailModel->sendEmailContactMessage($data["name"], $data["email"], $data["message"]);
        }
        return $this->builderContact->insert($data);
    }

    //get contact messages
    public function getContactMessages()
    {
        return $this->builderContact->orderBy('id', 'DESC')->get()->getResult();
    }

    //get last contact messages
    public function getLastContactMessages()
    {
        return $this->builderContact->orderBy('id', 'DESC')->get(5)->getResult();
    }

    //delete contact message
    public function deleteContactMessage($id)
    {
        return $this->builderContact->where('id', cleanNumber($id))->delete();
    }
}
