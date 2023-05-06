<?php namespace App\Models;

use CodeIgniter\Model;

class PollModel extends BaseModel
{
    protected $builder;
    protected $builderVotes;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('polls');
        $this->builderVotes = $this->db->table('poll_votes');
    }

    //input values
    public function inputValues()
    {
        return [
            'lang_id' => inputPost('lang_id'),
            'question' => inputPost('question'),
            'option1' => inputPost('option1'),
            'option2' => inputPost('option2'),
            'option3' => inputPost('option3'),
            'option4' => inputPost('option4'),
            'option5' => inputPost('option5'),
            'option6' => inputPost('option6'),
            'option7' => inputPost('option7'),
            'option8' => inputPost('option8'),
            'option9' => inputPost('option9'),
            'option10' => inputPost('option10'),
            'status' => inputPost('status')
        ];
    }

    //add poll
    public function addPoll()
    {
        $data = $this->inputValues();
        $data["created_at"] = date('Y-m-d H:i:s');
        return $this->builder->insert($data);
    }

    //update poll
    public function editPoll($id)
    {
        //set values
        $data = $this->inputValues();
        return $this->builder->where('id', cleanNumber($id))->update($data);
    }

    //get polls
    public function getPolls()
    {
        $this->builder->select('polls.*, (SELECT COUNT(*) FROM poll_votes WHERE poll_votes.poll_id = polls.id) AS num_poll_votes');
        return $this->builder->where('polls.lang_id', $this->activeLangId)->orderBy('polls.id', 'DESC')->get()->getResult();
    }

    //get poll votes
    public function getPollVotes($pollId)
    {
        return $this->builderVotes->where('poll_id', cleanNumber($pollId))->get()->getResult();
    }

    //get all polls
    public function getAllPolls()
    {
        $this->builder->select('polls.*, (SELECT COUNT(*) FROM poll_votes WHERE poll_votes.poll_id = polls.id) AS num_poll_votes');
        return $this->builder->orderBy('polls.id', 'DESC')->get()->getResult();
    }

    //get poll
    public function getPoll($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //add unregistered vote
    public function addUnregisteredVote($pollId, $option)
    {
        if (!empty(helperGetCookie('cookie_poll_' . $pollId))) {
            return "voted";
        } else {
            $data = [
                'poll_id' => $pollId,
                'user_id' => 0,
                'vote' => $option
            ];
            $this->builderVotes->insert($data);
            helperSetCookie('cookie_poll_' . $pollId, '1');
            return "success";
        }
    }

    //delete poll
    public function deletePoll($id)
    {
        $poll = $this->getPoll($id);
        if (!empty($poll)) {
            $this->builderVotes->where('poll_id', $poll->id)->delete();
            return $this->builder->where('id', $poll->id)->delete();
        }
        return false;
    }
}
