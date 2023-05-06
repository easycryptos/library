<?php namespace App\Models;

use CodeIgniter\Model;

class ReactionModel extends BaseModel
{
    protected $builder;
    protected $arrayReactions;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('reactions');
        $this->arrayReactions = ['like', 'dislike', 'love', 'funny', 'angry', 'sad', 'wow'];
    }

    //save reaction
    public function saveReaction($postId, $reaction)
    {
        if (in_array($reaction, $this->arrayReactions)) {
            if (isReactionVoted($postId, $reaction)) {
                $this->session->set('reaction_' . $reaction . '_' . $postId, '0');
                helperSetCookie('reaction_' . $reaction . '_' . $postId, '0');
                $this->decreaseReactionVote($postId, $reaction);
                $this->decreasePostVoteSession($postId);
            } else {
                $this->session->set('reaction_' . $reaction . '_' . $postId, '1');
                helperSetCookie('reaction_' . $reaction . '_' . $postId, '1');
                $this->increaseReactionVote($postId, $reaction);
                $this->increasePostVoteSession($postId);
            }
        }
    }

    //increase reaction vote
    public function increaseReactionVote($postId, $reaction)
    {
        if (in_array($reaction, $this->arrayReactions)) {
            $row = $this->getReaction($postId);
            if (!empty($row)) {
                $re = 're_' . $reaction;
                $data = [
                    're_' . $reaction => $row->$re + 1,
                ];
                $this->builder->where('post_id', cleanNumber($postId))->update($data);
            }
        }
    }

    //decrease reaction vote
    public function decreaseReactionVote($postId, $reaction)
    {
        if (in_array($reaction, $this->arrayReactions)) {
            $row = $this->getReaction($postId);
            if (!empty($row)) {
                $re = 're_' . $reaction;
                $data = [
                    're_' . $reaction => $row->$re - 1,
                ];
                $this->builder->where('post_id', cleanNumber($postId))->update($data);
            }
        }
    }

    //get reaction
    public function getReaction($postId)
    {
        $row = $this->builder->where('post_id', cleanNumber($postId))->get()->getRow();
        if (empty($row)) {
            $data = [
                'post_id' => $postId,
                're_like' => 0,
                're_dislike' => 0,
                're_love' => 0,
                're_funny' => 0,
                're_angry' => 0,
                're_sad' => 0,
                're_wow' => 0
            ];
            $this->builder->insert($data);
            $row = $this->builder->where('post_id', cleanNumber($postId))->get()->getRow();
        }
        return $row;
    }

    //increase post vote session
    public function increasePostVoteSession($postId)
    {
        $key = 'reaction_vote_count_' . $postId;
        $count = $this->session->get($key);
        if (empty($count)) {
            $count = 0;
        }
        $this->session->set($key, $count + 1);
        helperSetCookie($key, $count + 1);
    }

    //decrease post vote session
    public function decreasePostVoteSession($postId)
    {
        $key = 'reaction_vote_count_' . $postId;
        $count = $this->session->get($key);
        if (empty($count)) {
            $count = 0;
        } else {
            $count = $count - 1;
        }
        $this->session->set($key, $count);
        helperSetCookie($key, $count);
    }

    //set voted reactions session
    public function setVotedReactionsSession($postId)
    {
        //vote count
        $key = 'reaction_vote_count_' . $postId;
        if (!empty(helperGetCookie($key))) {
            $this->session->set($key, helperGetCookie($key));
        } else {
            $this->session->set($key, 0);
        }
        //like
        $key = 'reaction_like_' . $postId;
        $this->setReactionSession($key);
        //dislike
        $key = 'reaction_dislike_' . $postId;
        $this->setReactionSession($key);
        //love
        $key = 'reaction_love_' . $postId;
        $this->setReactionSession($key);
        //funny
        $key = 'reaction_funny_' . $postId;
        $this->setReactionSession($key);
        //angry
        $key = 'reaction_angry_' . $postId;
        $this->setReactionSession($key);
        //sad
        $key = 'reaction_sad_' . $postId;
        $this->setReactionSession($key);
        //wow
        $key = 'reaction_wow_' . $postId;
        $this->setReactionSession($key);
    }

    //set reaction value session
    public function setReactionSession($key)
    {
        if (!empty(helperGetCookie($key)) && helperGetCookie($key) == '1') {
            $this->session->set($key, '1');
        } else {
            $this->session->set($key, '0');
        }
    }
}