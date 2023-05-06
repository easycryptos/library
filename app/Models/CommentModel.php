<?php namespace App\Models;

use CodeIgniter\Model;
use Config\Globals;

class CommentModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('comments');
    }

    //add comment
    public function addComment()
    {
        $data = [
            'parent_id' => inputPost('parent_id'),
            'post_id' => inputPost('post_id'),
            'user_id' => 0,
            'name' => inputPost('name'),
            'email' => inputPost('email'),
            'comment' => inputPost('comment'),
            'status' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ];
        if (authCheck()) {
            $data['user_id'] = user()->id;
        }
        $generalSettings = Globals::$generalSettings;
        if (!empty($generalSettings) && $generalSettings->comment_approval_system == 1) {
            $data["status"] = 0;
        }
        if (!empty($data['post_id']) && !empty(trim($data['comment'] ?? ''))) {
            if ($data['user_id'] != 0) {
                $user = getUser($data['user_id']);
                if (!empty($user)) {
                    $data['name'] = $user->username;
                    $data['email'] = $user->email;
                }
            }
            return $this->builder->insert($data);
        }
    }

    //get comment
    public function getComment($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //post comment count
    public function getPostCommentCount($postId)
    {
        $this->builder->join('posts', 'comments.post_id = posts.id');
        return $this->builder->where('posts.id', cleanNumber($postId))->where('parent_id', 0)->where('comments.status', 1)->countAllResults();
    }

    //get comments
    public function getComments($postId, $limit)
    {
        $this->builder->join('posts', 'comments.post_id = posts.id')->select('comments.*');
        return $this->builder->where('posts.id', cleanNumber($postId))->where('parent_id', 0)->where('comments.status', 1)->orderBy('comments.id', 'DESC')->limit($limit)->get()->getResult();
    }

    //get approved comments
    public function getApprovedComments()
    {
        $this->builder->join('posts', 'comments.post_id = posts.id')->select('comments.*');
        return $this->builder->where('comments.status', 1)->orderBy('comments.id', 'DESC')->get()->getResult();
    }

    //get pending comments
    public function getPendingComments()
    {
        $this->builder->join('posts', 'comments.post_id = posts.id')->select('comments.*');
        return $this->builder->where('comments.status', 0)->orderBy('comments.id', 'DESC')->get()->getResult();
    }

    //get last comments
    public function getLastComments($limit)
    {
        $this->builder->join('posts', 'comments.post_id = posts.id')->select('comments.* , posts.title_slug as post_slug');
        return $this->builder->where('comments.status', 1)->orderBy('comments.id', 'DESC')->get(cleanNumber($limit))->getResult();
    }

    //get last pending comments
    public function getLastPeddingComments($limit)
    {
        $this->builder->join('posts', 'comments.post_id = posts.id')->select('comments.* , posts.title_slug as post_slug');
        return $this->builder->where('comments.status', 0)->orderBy('comments.id', 'DESC')->get(cleanNumber($limit))->getResult();
    }

    //get subcomments
    public function getSubcomments($parentId)
    {
        $this->builder->join('posts', 'comments.post_id = posts.id')->select('comments.*');
        return $this->builder->where('comments.parent_id', cleanNumber($parentId))->where('comments.status', 1)->orderBy('comments.id', 'DESC')->get()->getResult();
    }

    //approve comment
    public function approveComment($id)
    {
        $comment = $this->getComment($id);
        if (!empty($comment)) {
            $data = [
                'status' => 1
            ];
            return $this->builder->where('id', $comment->id)->update($data);
        }
        return false;
    }

    //approve multi comments
    public function approveMultiComments($comment_ids)
    {
        if (!empty($comment_ids)) {
            foreach ($comment_ids as $id) {
                $this->approveComment($id);
            }
        }
    }

    //delete comment
    public function deleteComment($id)
    {
        $comment = $this->getComment($id);
        if (!empty($comment)) {
            if ($this->builder->where('id', $comment->id)->delete()) {
                $this->builder->where('parent_id', $comment->id)->delete();
                return true;
            }
        }
        return false;
    }

    //delete multi comments
    public function deleteMultiComments($commentIds)
    {
        if (!empty($commentIds)) {
            foreach ($commentIds as $id) {
                if ($this->builder->where('id', $id)->delete()) {
                    $this->builder->where('parent_id', $id)->delete();
                }
            }
        }
    }

}
