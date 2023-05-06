<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\PostAdminModel;
use App\Models\CategoryModel;
use App\Models\PostFile1Model;
use App\Models\TagModel;

class PostController extends BaseAdminController
{
    protected $postModel;
    protected $postAdminModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->postModel = new PostModel();
        $this->postAdminModel = new PostAdminModel();
    }

    /**
     * Add Post
     */
    public function addPost()
    {
        checkPermission('add_post');
        $data['title'] = trans("add_post");
        $model = new CategoryModel();
        $data['parentCategories'] = $model->getParentCategoriesByLang($this->activeLang->id);
        
        $data['postType'] = "post";

        echo view('admin/includes/_header', $data);
        echo view('admin/post/add_post', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Post Post
     */
    public function addPostPost()
    {
        checkPermission('add_post');
        $backUrl = adminUrl('add-post');
        if (inputPost('post_type') == 'video') {
            $backUrl = adminUrl('add-video');
        }
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        $val->setRule('summary', trans("summary"), 'max_length[5000]');
        $val->setRule('category_id', trans("category"), 'required');
        $val->setRule('optional_url', trans("optional_url"), 'max_length[1000]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to($backUrl)->withInput();
        } else {
            $postId = $this->postAdminModel->addPost();
            if (!empty($postId)) {
                $this->postAdminModel->updateSlug($postId);
                $tagModel = new TagModel();
                $tagModel->addPostTags($postId);
                $this->postAdminModel->addPostAdditionalImages($postId);
                $this->postAdminModel->addPostFiles($postId);

                resetCacheDataOnChange();
                $this->session->setFlashdata('success', trans("post") . " " . trans("msg_suc_added"));
                return redirect()->to($backUrl);
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->to($backUrl)->withInput();
    }

    /**
     * Edit Post
     */
    public function editPost($id)
    {
        $this->checkRolePermission();
        $data['title'] = trans("update_post");
        $data['post'] = $this->postAdminModel->getPost($id);
        if (empty($data['post'])) {
            return redirect()->to(adminUrl('posts'));
        }
        
        //check if author
        if (!isAdmin()) {
            if ($data['post']->user_id != user()->id) {
                return redirect()->to(adminUrl());
            }
        }
        //combine post tags
        $tags = "";
        $count = 0;
        $tagModel = new TagModel();
        $tagsArray = $tagModel->getPostTags($id);
        if (!empty($tagsArray)) {
            foreach ($tagsArray as $item) {
                if ($count > 0) {
                    $tags .= ",";
                }
                $tags .= $item->tag;
                $count++;
            }
        }

        $data['tags'] = $tags;
        $data['post_images'] = getPostAdditionalImages($id);
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->getParentCategoriesByLang($data['post']->lang_id);
        $data['users'] = $this->authModel->getAuthors();
        $data['category_id'] = '';
        $data['subcategory_id'] = '';
        $categoryArray = getCategoryArray($data['post']->category_id);
        if (!empty($categoryArray['parentCategory'])) {
            $data['category_id'] = $categoryArray['parentCategory']->id;
        }
        if (!empty($categoryArray['subcategory'])) {
            $data['subcategory_id'] = $categoryArray['subcategory']->id;
        }
        $data['subcategories'] = $categoryModel->getAllSubcategoriesByParentId($data['category_id']);

        echo view('admin/includes/_header', $data);
        if ($data['post']->post_type == "video") {
            echo view('admin/post/edit_video', $data);
        } else {
            echo view('admin/post/edit_post', $data);
        }
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Post Post
     */
    public function editPostPost()
    {
        $this->checkRolePermission();
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        $val->setRule('summary', trans("summary"), 'max_length[5000]');
        $val->setRule('category_id', trans("category"), 'required');
        $val->setRule('optional_url', trans("optional_url"), 'max_length[1000]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $postId = inputPost('id');
            $post = $this->postAdminModel->getPost($postId);
            if(empty($post)){
                return redirect()->to(adminUrl('posts'));
            }
            //check if author
            if (!isAdmin()) {
                if ($post->user_id != user()->id) {
                    return redirect()->to(adminUrl());
                }
            }
            if ($this->postAdminModel->editPost($postId)) {
                //update slug
                $this->postAdminModel->updateSlug($postId);
                $tagModel = new TagModel();
                $tagModel->editPostTags($postId);
                $this->postAdminModel->addPostAdditionalImages($postId);
                $this->postAdminModel->addPostFiles($postId);

                resetCacheDataOnChange();
                $this->session->set('msg_success', trans("post") . " " . trans("msg_suc_updated"));
                return redirect()->to(adminUrl('edit-post') . '/' . $postId);
            }
        }
        $this->session->set('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Add Video
     */
    public function addVideo()
    {
        checkPermission('add_post');
        $data['title'] = trans("add_video");
        $model = new CategoryModel();
        
        $data['parentCategories'] = $model->getParentCategoriesByLang($this->activeLang->id);
        $data['postType'] = "video";

        echo view('admin/includes/_header', $data);
        echo view('admin/post/add_video', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Posts
     */
    public function posts()
    {
        $this->checkRolePermission();
        $data['title'] = trans('posts');
        $data['authors'] = $this->authModel->getAuthors();
        $data['formAction'] = adminUrl("posts");
        $data['listType'] = "posts";
        
        $numRows = $this->postAdminModel->getPostsPaginatedCount($data['listType']);
        $pager = paginate($this->getPostsPerPage(), $numRows);
        $data['posts'] = $this->postAdminModel->getPostsPaginated($this->getPostsPerPage(), $pager->offset, $data['listType']);

        echo view('admin/includes/_header', $data);
        echo view('admin/post/posts', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Slider Posts
     */
    public function sliderPosts()
    {
        checkPermission('manage_all_posts');
        $data['title'] = trans('slider_posts');
        $data['authors'] = $this->authModel->getAuthors();
        $data['formAction'] = adminUrl("slider-posts");
        $data['listType'] = "slider_posts";
        
        $numRows = $this->postAdminModel->getPostsPaginatedCount($data['listType']);
        $pager = paginate($this->getPostsPerPage(), $numRows);
        $data['posts'] = $this->postAdminModel->getPostsPaginated($this->getPostsPerPage(), $pager->offset, $data['listType']);

        echo view('admin/includes/_header', $data);
        echo view('admin/post/posts', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Our Picks
     */
    public function ourPicks()
    {
        checkPermission('manage_all_posts');
        $data['title'] = trans('our_picks');
        $data['authors'] = $this->authModel->getAuthors();
        $data['formAction'] = adminUrl("our-picks");
        $data['listType'] = "our_picks";
        
        $numRows = $this->postAdminModel->getPostsPaginatedCount($data['listType']);
        $pager = paginate($this->getPostsPerPage(), $numRows);
        $data['posts'] = $this->postAdminModel->getPostsPaginated($this->getPostsPerPage(), $pager->offset, $data['listType']);

        echo view('admin/includes/_header', $data);
        echo view('admin/post/posts', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Pending Posts
     */
    public function pendingPosts()
    {
        $this->checkRolePermission();
        $data['title'] = trans('pending_posts');
        $data['authors'] = $this->authModel->getAuthors();
        $data['formAction'] = adminUrl("pending-posts");
        
        $numRows = $this->postAdminModel->getPendingPostsPaginatedCount();
        $pager = paginate($this->getPostsPerPage(), $numRows);
        $data['posts'] = $this->postAdminModel->getPendingPostsPaginated($this->getPostsPerPage(), $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/post/pending_posts', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Drafts
     */
    public function drafts()
    {
        $this->checkRolePermission();
        $data['title'] = trans('drafts');
        $data['authors'] = $this->authModel->getAuthors();
        $data['formAction'] = adminUrl("drafts");
        $numRows = $this->postAdminModel->getDraftsPaginatedCount();
        $pager = paginate($this->getPostsPerPage(), $numRows);
        $data['posts'] = $this->postAdminModel->getDraftsPaginated($this->getPostsPerPage(), $pager->offset);
        
        echo view('admin/includes/_header', $data);
        echo view('admin/post/drafts', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Auto Post Deletion
     */
    public function autoPostDeletion()
    {
        checkPermission('manage_all_posts');
        $data['title'] = trans('auto_post_deletion');
        echo view('admin/includes/_header', $data);
        echo view('admin/post/auto_post_deletion', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Post Options Post
     */
    public function postOptionsPost()
    {
        $option = inputPost('option');
        $id = inputPost('id');
        $data["post"] = $this->postAdminModel->getPost($id);
        if (empty($data['post'])) {
            return redirect()->back();
        }
        //if option add remove from slider
        if ($option == 'add-remove-from-slider') {
            checkPermission('manage_all_posts');
            $result = $this->postAdminModel->postAddRemoveSlider($id);
            if ($result == "removed") {
                $this->session->setFlashdata('success', trans("msg_remove_slider"));
            }
            if ($result == "added") {
                $this->session->setFlashdata('success', trans("msg_add_slider"));
            }
        }
        //if option add remove from picked
        if ($option == 'add-remove-from-picked') {
            checkPermission('manage_all_posts');
            $result = $this->postAdminModel->postAddRemovePicked($id);
            if ($result == "removed") {
                $this->session->setFlashdata('success', trans("msg_remove_picked"));
            }
            if ($result == "added") {
                $this->session->setFlashdata('success', trans("msg_add_picked"));
            }
        }
        //if option approve
        if ($option == 'approve') {
            checkPermission('manage_all_posts');
            if (isAdmin()) {
                if ($this->postAdminModel->approvePost($id)) {
                    $this->session->setFlashdata('success', trans("msg_post_approved"));
                } else {
                    $this->session->setFlashdata('error', trans("msg_error"));
                }
            }
        }
        //if option publish
        if ($option == 'publish') {
            checkPermission('manage_all_posts');
            if ($this->postAdminModel->publishPost($id)) {
                $this->session->setFlashdata('success', trans("msg_published"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        //if option publish draft
        if ($option == 'publish_draft') {
            $this->checkRolePermission();
            if ($this->postAdminModel->publishDraft($id)) {
                $this->session->setFlashdata('success', trans("msg_published"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }

        resetCacheDataOnChange();
        return redirect()->back();
    }

    /**
     * Auto Post Deletion Post
     */
    public function autoPostDeletionPost()
    {
        checkPermission('manage_all_posts');
        if ($this->settingsModel->updateAutoPostDeletionSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('auto-post-deletion'));
    }

    /**
     * Delete Post
     */
    public function deletePost()
    {
        $this->checkRolePermission();
        $id = inputPost('id');
        if ($this->postAdminModel->deletePost($id)) {
            resetCacheDataOnChange();
            $this->session->setFlashdata('success', trans("post") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Posts
     */
    public function deleteSelectedPosts()
    {
        $this->checkRolePermission();
        $postIds = inputPost('post_ids');
        $this->postAdminModel->deleteMultiPosts($postIds);
        resetCacheDataOnChange();
    }

    /**
     * Save Home Slider Post Order
     */
    public function homeSliderPostsOrderPost()
    {
        checkPermission('manage_all_posts');
        $postId = inputPost('id');
        $order = inputPost('slider_order');
        $this->postAdminModel->saveHomeSliderPostOrder($postId, $order);
        resetCacheDataOnChange();
        return redirect()->to(adminUrl('slider-posts'));
    }

    /**
     * Get Video from URL
     */
    public function getVideoFromURL()
    {
        include(APPPATH . 'Libraries/VideoUrlParser.php');
        $parser = new \VideoUrlParser();
        $url = inputPost('url');
        $data = array(
            'video_embed_code' => $parser->getEmbedCode($url),
            'video_thumbnail' => $parser->getThumbnail($url)
        );
        echo json_encode($data);
    }

    /**
     * Delete Post Main Image
     */
    public function deletePostMainImage()
    {
        $this->checkRolePermission();
        $postId = inputPost('post_id');
        $this->postAdminModel->deletePostMainImage($postId);
    }

    /**
     * Delete Additional Image
     */
    public function deletePostAdditionalImage()
    {
        $this->checkRolePermission();
        $fileId = inputPost('file_id');
        $this->postAdminModel->deletePostAdditionalImage($fileId);
    }

    /**
     * Delete Post File
     */
    public function deletePostFile()
    {
        $this->checkRolePermission();
        $fileId = inputPost('file_id');
        $this->postAdminModel->deletePostFile($fileId);
    }

    //get perpage
    public function getPostsPerPage()
    {
        if (!empty(inputGet('show', true))) {
            return cleanNumber(inputGet('show', true));
        }
        return 15;
    }

    //check role permission
    public function checkRolePermission()
    {
        if (!hasPermission('manage_all_posts') && !hasPermission('add_post')) {
            redirectToUrl(base_url());
            exit();
        }
    }
}
