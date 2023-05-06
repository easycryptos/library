<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\RssModel;

class RssController extends BaseAdminController
{
    protected $rssModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        checkPermission('rss_feeds');
        $this->rssModel = new RssModel();
    }

    /**
     * Import Feed
     */
    public function importFeed()
    {
        $data['title'] = trans("import_rss_feed");
        $categoryModel = new CategoryModel();
        $data['parentCategories'] = $categoryModel->getParentCategoriesByLang($this->activeLang->id);
        
        echo view('admin/includes/_header', $data);
        echo view('admin/rss/import_feed', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Import Feed Post
     */
    public function importFeedPost()
    {
        $feedId = $this->rssModel->addFeed();
        if (!empty($feedId)) {
            $this->rssModel->addFeedPosts($feedId);
            $this->session->setFlashdata('success', trans("feed") . " " . trans("msg_suc_added"));
            resetCacheDataOnChange();
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('feeds'));
    }

    /**
     * RSS Feeds
     */
    public function rssFeeds()
    {
        $data['title'] = trans("rss_feeds");
        $data['feeds'] = $this->rssModel->getFeeds();
        $data['langSearchColumn'] = 3;
        
        echo view('admin/includes/_header', $data);
        echo view('admin/rss/feeds', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit RSS Feed
     */
    public function editFeed($id)
    {
        $data["feed"] = $this->rssModel->getFeed($id);
        if (empty($data["feed"])) {
            return redirect()->to(adminUrl('feeds'));
        }
        $data['title'] = trans("update_rss_feed");
        $category = getCategory($data["feed"]->category_id);
        $data['parent_category_id'] = $data["feed"]->category_id;
        $data['subcategory_id'] = 0;
        if (!empty($category) && $category->parent_id != 0) {
            $parentCategory = getCategory($category->parent_id);
            if (!empty($parentCategory)) {
                $data['parent_category_id'] = $parentCategory->id;
                $data['subcategory_id'] = $category->id;
            }
        }
        
        $categoryModel = new CategoryModel();
        $data['parentCategories'] = $categoryModel->getParentCategoriesByLang($data['feed']->lang_id);
        $data['subcategories'] = $categoryModel->getSubcategoriesByParentId($data['parent_category_id']);

        echo view('admin/includes/_header', $data);
        echo view('admin/rss/update_feed', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit RSS Feed Post
     */
    public function editFeedPost()
    {
        $id = inputPost('id');
        if ($this->rssModel->editFeed($id)) {
            $this->rssModel->updateFeedPostsButton($id);
            $this->session->setFlashdata('success', trans("feed") . " " . trans("msg_suc_updated"));
            resetCacheDataOnChange();
            return redirect()->to(adminUrl('feeds'));
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back();
    }

    /**
     * Get Feed Posts
     */
    public function checkFeedPosts()
    {
        $id = inputPost('id');
        $this->rssModel->addFeedPosts($id);
        $this->session->setFlashdata('success', trans("feed") . " " . trans("msg_suc_updated"));
        resetCacheDataOnChange();
        return redirect()->to(adminUrl('feeds'));
    }

    /**
     * Delete Feed
     */
    public function deleteFeedPost()
    {
        $id = inputPost('id');
        if ($this->rssModel->deleteFeed($id)) {
            $this->session->setFlashdata('success', trans("feed") . " " . trans("msg_suc_deleted"));
            resetCacheDataOnChange();
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }
}