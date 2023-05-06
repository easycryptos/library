<?php namespace App\Models;

use CodeIgniter\Model;

class TagModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('tags');
    }

    //add post tags
    public function addPostTags($postId)
    {
        $tags = inputPost('tags');
        $tagsArray = explode(",", $tags ?? '');
        if (!empty($tagsArray)) {
            foreach ($tagsArray as $tag) {
                $tag = trim($tag ?? '');
                if (strlen($tag ?? '') > 1) {
                    $data = [
                        'post_id' => $postId,
                        'tag' => $tag,
                        'tag_slug' => strSlug($tag)
                    ];
                    if (empty($data["tag_slug"]) || $data["tag_slug"] == "-") {
                        $data["tag_slug"] = "tag-" . uniqid();
                    }
                    $this->builder->insert($data);
                }
            }
        }
    }

    //edit post tags
    public function editPostTags($postId)
    {
        //delete old tags
        $this->deletePostTags($postId);
        //add new tags
        $tags = inputPost('tags');
        $tagsArray = explode(",", $tags ?? '');
        if (!empty($tagsArray)) {
            foreach ($tagsArray as $tag) {
                $tag = trim($tag ?? '');
                if (strlen($tag ?? '') > 1) {
                    $data = [
                        'post_id' => $postId,
                        'tag' => $tag,
                        'tag_slug' => strSlug($tag)
                    ];
                    if (empty($data["tag_slug"]) || $data["tag_slug"] == "-") {
                        $data["tag_slug"] = "tag-" . uniqid();
                    }
                    $this->builder->insert($data);
                }
            }
        }
    }

    //get random tags
    public function getRandomTags()
    {
        return $this->builder->join('posts', 'posts.id = tags.post_id')->join('users', 'posts.user_id = users.id')
            ->select('tags.tag_slug, tags.tag')->groupBy('tags.tag_slug, tags.tag')
            ->where('posts.status', 1)->where('posts.lang_id', $this->activeLangId)->where('posts.visibility', 1)
            ->orderBy('rand()')->limit(15)->get()->getResult();
    }

    //get tag
    public function getTag($tagSlug)
    {
        return $this->builder->join('posts', 'posts.id = tags.post_id')->join('users', 'posts.user_id = users.id')
            ->select('tags.*, posts.lang_id as tag_lang_id')->where('tags.tag_slug', cleanSlug($tagSlug))->where('posts.status', 1)->where('posts.visibility', 1)->get()->getRow();
    }

    //get posts tags
    public function getPostTags($postId)
    {
        return $this->builder->where('post_id', cleanNumber($postId))->get()->getResult();
    }

    //delete tags
    public function deletePostTags($postId)
    {
        $this->builder->where('post_id', cleanNumber($postId))->delete();
    }
}
