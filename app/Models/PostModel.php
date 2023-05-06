<?php namespace App\Models;

use CodeIgniter\Model;

class PostModel extends BaseModel
{
    protected $builder;
    protected $builderReadingLists;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('posts');
        $this->builderReadingLists = $this->db->table('reading_lists');
    }

    public function setFilterQuery()
    {
        $this->builder->join('users', 'posts.user_id = users.id')->join('categories', 'posts.category_id = categories.id');
        $this->builder->select('posts.* , users.username as username, users.slug as user_slug, categories.name as category_name, categories.slug as category_slug, categories.parent_id as category_parent_id, 
		(SELECT slug FROM categories WHERE id = category_parent_id) as parent_category_slug, (SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id AND comments.parent_id = 0 AND status = 1) as comment_count');
        $this->builder->where('posts.visibility', 1)->where('posts.status', 1)->where('posts.lang_id', $this->activeLangId);
    }

    //get post
    public function getPostBySlug($slug)
    {
        $this->setFilterQuery();
        return $this->builder->where('title_slug', cleanSlug($slug))->get()->getRow();
    }

    //get post by id
    public function getPost($id)
    {
        $this->setFilterQuery();
        return $this->builder->where('posts.id', cleanNumber($id))->get()->getRow();
    }

    //get posts paginated
    public function getPostsPaginated($perPage, $offset)
    {
        $this->setFilterQuery();
        return $this->builder->orderBy('posts.created_at', 'DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get latest posts
    public function getLatestPosts($limit)
    {
        $this->setFilterQuery();
        return $this->builder->orderBy('posts.created_at', 'DESC')->limit($limit)->get()->getResult();
    }

    //get post count
    public function getPostCount()
    {
        $this->setFilterQuery();
        return $this->builder->countAllResults();
    }

    //get slider posts
    public function getSliderPosts()
    {
        $this->setFilterQuery();
        return $this->builder->where('is_slider', 1)->orderBy('slider_order')->limit(20)->get()->getResult();
    }

    //get popular posts
    public function getPopularPosts($limit)
    {
        $this->setFilterQuery();
        return $this->builder->orderBy('hit', 'DESC')->limit($limit)->get()->getResult();
    }

    //get picked posts
    public function getOurPicks($limit)
    {
        $this->setFilterQuery();
        return $this->builder->where('is_picked', 1)->orderBy('posts.created_at', 'DESC')->limit($limit)->get()->getResult();
    }

    //get random posts
    public function getRandomPosts($limit)
    {
        $this->setFilterQuery();
        return $this->builder->orderBy('rand()')->limit($limit)->get()->getResult();
    }

    //get category post count
    public function getPostCountByCategory($categoryTree)
    {
        if (!empty($categoryTree)) {
            $this->setFilterQuery();
            return $this->builder->whereIn('posts.category_id', $categoryTree, false)->where('posts.visibility', 1)->where('posts.status', 1)->countAllResults();
        }
        return 0;
    }

    //get posts by category
    public function getPostsByCategory($categoryTree)
    {
        if (!empty($categoryTree)) {
            $this->setFilterQuery();
            return $this->builder->whereIn('posts.category_id', $categoryTree, false)->where('posts.visibility', 1)->where('posts.status', 1)
                ->orderBy('posts.created_at', 'DESC')->get()->getResult();
        }
        return array();
    }

    //get paginated category posts
    public function getCategoryPostsPaginated($categoryTree, $perPage, $offset)
    {
        if (!empty($categoryTree)) {
            $this->setFilterQuery();
            return $this->builder->whereIn('posts.category_id', $categoryTree, false)->where('posts.visibility', 1)->where('posts.status', 1)
                ->orderBy('posts.created_at', 'DESC')->limit($perPage, $offset)->get()->getResult();
        }
        return array();
    }

    //get posts by user
    public function getUserPostsPaginated($userId, $perPage, $offset)
    {
        $this->setFilterQuery();
        return $this->builder->where('posts.user_id', cleanNumber($userId))->orderBy('posts.created_at', 'DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get post count by user
    public function getPostCountByUser($userId)
    {
        $this->setFilterQuery();
        return $this->builder->where('posts.user_id', cleanNumber($userId))->countAllResults();
    }

    //get related posts
    public function getRelatedPosts($categoryId, $postId)
    {
        $this->setFilterQuery();
        return $this->builder->where('posts.id !=', $postId)->where('category_id', $categoryId)->orderBy('rand()', 'DESC')->limit(3)->get()->getResult();
    }

    //get post count by tag
    public function getTagPostCount($tag_slug)
    {
        $this->setFilterQuery();
        $this->builder->join('tags', 'posts.id = tags.post_id');
        return $this->builder->where('tags.tag_slug', cleanSlug($tag_slug))->countAllResults();
    }

    //get posts by tag
    public function getTagPostsPaginated($tagSlug, $perPage, $offset)
    {
        $this->setFilterQuery();
        $this->builder->join('tags', 'posts.id = tags.post_id');
        return $this->builder->where('tags.tag_slug', cleanSlug($tagSlug))->orderBy('posts.created_at', 'DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get search posts
    public function getSearchPostsPaginated($q, $perPage, $offset)
    {
        $this->setFilterQuery();
        return $this->builder->groupStart()->like('posts.title', $q)->orLike('posts.content', $q)->orLike('posts.summary', $q)->groupEnd()
            ->orderBy('posts.created_at', 'DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get search post count
    public function getSearchPostCount($q)
    {
        $this->setFilterQuery();
        return $this->builder->groupStart()->like('posts.title', $q)->orLike('posts.content', $q)->orLike('posts.summary', $q)->groupEnd()->countAllResults();
    }

    //increase post hit
    public function increasePostPageViews($post)
    {
        if (!empty($post)) {
            if (!isset($_COOKIE['post_' . $post->id])) {
                if ($this->builder->where('id', $post->id)->update(['hit' => $post->hit + 1])) {
                    helperSetCookie('post_' . $post->id, '1');
                }
            }
        }
    }

    /**
     * --------------------------------------------------------------------
     * FILES
     * --------------------------------------------------------------------
     */

    //get post additional images
    public function getPostAdditionalImages($postId)
    {
        return $this->db->table('post_images')->where('post_id', cleanNumber($postId))->get()->getResult();
    }

    //get post files
    public function getPostFiles($postId)
    {
        return $this->db->table('post_files')->join('files', 'files.id = post_files.file_id')->select('files.*, post_files.id as post_file_id')->where('post_id', cleanNumber($postId))->get()->getResult();
    }


    /**
     * --------------------------------------------------------------------
     * READIN LIST
     * --------------------------------------------------------------------
     */

    //get reading list post count
    public function getReadingListCount($userId)
    {
        $this->builder->join('reading_lists', 'posts.id = reading_lists.post_id')->join('users', 'posts.user_id = users.id')->join('categories', 'posts.category_id = categories.id');
        $this->builder->select('posts.* , users.username as username, users.slug as user_slug, categories.name as category_name, categories.slug as category_slug, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_category_slug');
        return $this->builder->where('reading_lists.user_id', cleanNumber($userId))->where('posts.lang_id', $this->activeLangId)->countAllResults();
    }

    //get paginated posts by tag
    public function getReadingListPaginated($userId, $perPage, $offset)
    {
        $this->builder->join('reading_lists', 'posts.id = reading_lists.post_id')->join('users', 'posts.user_id = users.id')->join('categories', 'posts.category_id = categories.id');
        $this->builder->select('posts.* , users.username as username, users.slug as user_slug, categories.name as category_name, categories.slug as category_slug, categories.parent_id as category_parent_id, 
		(SELECT slug FROM categories WHERE id = category_parent_id) as parent_category_slug,  (SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id AND comments.parent_id = 0 AND status = 1) as comment_count');
        return $this->builder->where('reading_lists.user_id', cleanNumber($userId))->where('posts.lang_id', $this->activeLangId)->orderBy('posts.id', 'DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //check post is in the reading list or not
    public function isPostInReadingList($postId)
    {
        if (authCheck()) {
            $user = user();
            if (!empty($user)) {
                if (!empty($this->builderReadingLists->where('post_id', cleanNumber($postId))->where('user_id', $user->id)->get()->getRow())) {
                    return true;
                }
            }
        }
        return false;
    }

    //add to reading list
    public function addToReadingList($postId)
    {
        if (authCheck() && !empty($postId)) {
            $data = [
                'post_id' => $postId,
                'user_id' => user()->id
            ];
            return $this->builderReadingLists->insert($data);
        }
        return false;
    }

    //delete from reading list
    public function deleteFromReadingList($postId)
    {
        if (authCheck() && !empty($postId)) {
            return $this->builderReadingLists->where('post_id', cleanNumber($postId))->where('user_id', user()->id)->delete();
        }
        return false;
    }
}
