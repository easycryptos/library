<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\CommonModel;
use App\Models\GalleryModel;
use App\Models\NewsletterModel;
use App\Models\PageModel;
use App\Models\PollModel;
use App\Models\PostModel;
use App\Models\ReactionModel;
use App\Models\RssModel;
use App\Models\TagModel;
use Config\Globals;

class HomeController extends BaseController
{
    protected $postsPerPage;
    protected $commentLimit;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->postsPerPage = $this->generalSettings->pagination_per_page;
        $this->commentLimit = 5;
    }

    /*
     * Index
     */
    public function index()
    {
        $data['title'] = $this->settings->home_title;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $data['homeTitle'] = $this->settings->home_title;

        $postModel = new PostModel();
        //slider posts
        $data['sliderPosts'] = getCachedData('slider_posts');
        
        if (empty($data['sliderPosts'])) {
            $data['sliderPosts'] = $postModel->getSliderPosts();
            setCachedData('slider_posts', $data['sliderPosts']);
        }
        $numRows = getCachedData('posts_count');
        if (empty($numRows)) {
            $numRows = $postModel->getPostCount();
            setCachedData('posts_count', $numRows);
        }
        $pager = paginate($this->postsPerPage, $numRows);
        $data['posts'] = getCachedData('posts_page_' . $pager->page);
        if (empty($data['posts'])) {
            $data['posts'] = $postModel->getPostsPaginated($this->postsPerPage, $pager->offset);
            setCachedData('posts_page_' . $pager->page, $data['posts']);
        }

        echo view('partials/_header', $data);
        echo view('index', $data);
        echo view('partials/_footer');
    }

    /**
     * Gallery Page
     */
    public function gallery()
    {
        $model = new PageModel();
        $data['page'] = $model->getPageBySlug('gallery');
        $data['isGalleryPage'] = true;
        //check page auth
        $this->checkPageAuth($data['page']);
        if ($data['page']->page_active == 0) {
            $this->error404();
        } else {
            $data['title'] = $data['page']->title;
            $data['description'] = $data['page']->page_description;
            $data['keywords'] = $data['page']->page_keywords;
            
            //get gallery categories
            $model = new GalleryModel();
            $data['galleryAlbums'] = $model->getAlbumsBySelectedLang();

            echo view('partials/_header', $data);
            echo view('gallery/gallery', $data);
            echo view('partials/_footer');
        }
    }

    /**
     * Gallery Album Page
     */
    public function galleryAlbum($id)
    {
        $model = new PageModel();
        $data['page'] = $model->getPageBySlug('gallery');
        $data['isGalleryPage'] = true;
        //check page auth
        $this->checkPageAuth($data['page']);
        if ($data['page']->page_active == 0) {
            $this->error404();
        } else {
            $data['title'] = $data['page']->title;
            $data['description'] = $data['page']->page_description;
            $data['keywords'] = $data['page']->page_keywords;
            
            //get album
            $model = new GalleryModel();
            $data['album'] = $model->getAlbum($id);
            if (empty($data['album'])) {
                return redirect()->back();
            }
            //get gallery images
            $data['galleryImages'] = $model->getImagesByAlbum($data['album']->id);
            $data['galleryCategories'] = $model->getCategoriesByAlbum($data['album']->id);

            echo view('partials/_header', $data);
            echo view('gallery/gallery_album', $data);
            echo view('partials/_footer');
        }
    }

    /**
     * Contact Page
     */
    public function contact()
    {
        $model = new PageModel();
        $data['page'] = $model->getPageBySlug('contact');
        //check page auth
        $this->checkPageAuth($data['page']);
        if ($data['page']->page_active == 0) {
            $this->error404();
        } else {
            $data['title'] = $data['page']->title;
            $data['description'] = $data['page']->page_description;
            $data['keywords'] = $data['page']->page_keywords;
            

            echo view('partials/_header', $data);
            echo view('contact', $data);
            echo view('partials/_footer');
        }
    }

    /**
     * Contact Page Post
     */
    public function contactPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("name"), 'required|max_length[200]');
        $val->setRule('email', trans("email"), 'required|valid_email|max_length[200]');
        $val->setRule('message', trans("message"), 'required|max_length[5000]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if (reCAPTCHA('validate', $this->generalSettings) == 'invalid') {
                $this->session->setFlashdata('error', trans("msg_recaptcha"));
                return redirect()->back()->withInput();
            }
            $model = new CommonModel();
            if ($model->addContactMessage()) {
                $this->session->setFlashdata('success', trans("message_contact_success"));
            } else {
                $this->session->setFlashdata('error', trans("message_contact_error"));
            }
        }
        return redirect()->back();
    }


    /**
     * Tag Page
     */
    public function tag($tagSlug)
    {
        $model = new TagModel();
        $postModel = new PostModel();
        $data['tag'] = $model->getTag($tagSlug);
        if (empty($data['tag'])) {
            return redirect()->back();
        }
        $data['title'] = esc($data['tag']->tag);
        $data['description'] = trans("tag") . ': ' . esc($data['tag']->tag);
        $data['keywords'] = trans("tag") . ', ' . esc($data['tag']->tag);
        
        $numRows = $postModel->getTagPostCount($tagSlug);
        $pager = paginate($this->postsPerPage, $numRows);
        $data['posts'] = $postModel->getTagPostsPaginated($tagSlug, $this->postsPerPage, $pager->offset);

        echo view('partials/_header', $data);
        echo view('tag', $data);
        echo view('partials/_footer');
    }

    /**
     * Reading List Page
     */
    public function readingList()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("reading_list");
        $data['description'] = trans("reading_list") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("reading_list") . "," . $this->settings->application_name;
        
        $postModel = new PostModel();
        $data['numRows'] = $postModel->getReadingListCount(user()->id);
        $pager = paginate($this->postsPerPage, $data['numRows']);
        $data['posts'] = $postModel->getReadingListPaginated(user()->id, $this->postsPerPage, $pager->offset);

        echo view('partials/_header', $data);
        echo view('reading_list', $data);
        echo view('partials/_footer');
    }

    /**
     * Search Page
     */
    public function search()
    {
        $q = inputGet('q', true);
        $q = strip_tags($q ?? '');
        if (empty($q)) {
            return redirect()->back();
        }
        $data['q'] = $q;
        $data['title'] = trans("search") . ': ' . esc($q);
        $data['description'] = trans("search") . ': ' . esc($q);
        $data['keywords'] = trans("search") . ', ' . esc($q);
        $postModel = new PostModel();
        $data['numRows'] = $postModel->getSearchPostCount($q);
        $pager = paginate($this->postsPerPage, $data['numRows']);
        $data['posts'] = $postModel->getSearchPostsPaginated($q, $this->postsPerPage, $pager->offset);
        

        echo view('partials/_header', $data);
        echo view('search', $data);
        echo view('partials/_footer');
    }

    /**
     * Dynamic Page by Name Slug
     */
    public function any($slug)
    {
        $slug = cleanSlug($slug);
        if (empty($slug)) {
            return redirect()->to(langBaseUrl());
        }
        if ($slug == $this->activeLang->short_form) {
            return redirect()->to(base_url());
        }
        
        $pageModel = new PageModel();
        $data['page'] = $pageModel->getPageByLang($slug, $this->activeLang->id);
        if (!empty($data['page'])) {
            $this->page($data['page']);
        } else {
            $categoryModel = new CategoryModel();
            $data['category'] = $categoryModel->getCategoryBySlug($slug);
            if (!empty($data['category'])) {
                $this->category($data['category']);
            } else {
                $this->post($slug);
            }
        }
    }

    /**
     * Page
     */
    private function page($page)
    {
        $data['page'] = $page;
        $this->checkPageAuth($data['page']);
        if (empty($data['page']) || $data['page'] == null) {
            $this->error_404();
        } else if ($data['page']->page_active == 0 || $data['page']->link != '') {
            $this->error_404();
        } else {
            $data['title'] = $data['page']->title;
            $data['description'] = $data['page']->page_description;
            $data['keywords'] = $data['page']->page_keywords;

            echo view('partials/_header', $data);
            echo view('page', $data);
            echo view('partials/_footer');
        }
    }

    /**
     * Post Page
     */
    private function post($slug)
    {
        $model = new PostModel();
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        $commentModel = new CommentModel();
        $reactionModel = new ReactionModel();

        $data['post'] = $model->getPostBySlug($slug);
        if (empty($data['post'])) {
            $this->error404();
        } else {
            $id = $data['post']->id;
            if (!authCheck() && $data['post']->need_auth == 1) {
                $this->session->setFlashdata('error', trans("message_post_auth"));
                redirectToUrl(langBaseUrl('login'));
                exit();
            }
            if ($data['post']->visibility != 1) {
                return redirect()->to(langBaseUrl());
            }

            $data['category'] = $categoryModel->getCategory($data['post']->category_id);
            $data['categoryArray'] = getCategoryArray($data['post']->category_id);
            $data['additionalImages'] = $model->getPostAdditionalImages($id);
            $data['postUser'] = $this->authModel->getUser($data['post']->user_id);

            $data['relatedPosts'] = getCachedData('related_posts_' . $id);
            if (empty($data['relatedPosts'])) {
                $data['relatedPosts'] = $model->getRelatedPosts($data['post']->category_id, $id);
                setCachedData('related_posts_' . $id, $data['relatedPosts']);
            }

            $data['postTags'] = getCachedData('post_tags_' . $id);
            if (empty($data['postTags'])) {
                $data['postTags'] = $tagModel->getPostTags($id);
                setCachedData('post_tags_' . $id, $data['postTags']);
            }

            $data['commentCount'] = $commentModel->getPostCommentCount($id);
            $data['comments'] = $commentModel->getComments($id, $this->commentLimit);
            $data['commentLimit'] = $this->commentLimit;

            $data['is_reading_list'] = $model->isPostInReadingList($id);

            $data['pageType'] = "post";
            //set og tags
            $data['ogType'] = "article";
            $data['ogUrl'] = generatePostUrl($data['post']);
            $data['ogImage'] = getPostImage($data['post'], 'mid');
            $data['ogTags'] = $data['postTags'];
            if (!empty($data['post']->image_url)) {
                $data['ogImage'] = $data['post']->image_url;
            }

            $data['title'] = $data['post']->title;
            $data['description'] = $data['post']->summary;
            $data['keywords'] = $data['post']->keywords;

            $reactionModel->setVotedReactionsSession($id);
            $data["reactions"] = $reactionModel->getReaction($id);

            if (!empty($data['post']->feed_id)) {
                $rssModel = new RssModel();
                $data['feed'] = $rssModel->getFeed($data['post']->feed_id);
            }
            $data['postJSONLD'] = $data['post'];

            echo view('partials/_header', $data);
            echo view('post/post', $data);
            echo view('partials/_footer', $data);
            //increase post hit
            $model->increasePostPageViews($data['post']);
        }
    }

    /**
     * Category Page
     */
    private function category($category, $type = 'parent')
    {
        //check category exists
        if (empty($category)) {
            return redirect()->to(langBaseUrl());
        }
        if ($category->parent_id != 0 && $type == 'parent') {
            $this->error404();
        } else {
            $data['category'] = $category;
            $data['title'] = $data['category']->name;
            $data['description'] = $data['category']->description;
            $data['keywords'] = $data['category']->keywords;
            $postModel = new PostModel();
            $categoryTree = getCategoryTreeIdsArray($category->id);

            $key = 'posts_count_category_' . $category->id;
            $numRows = getCachedData($key);
            if (empty($numRows)) {
                $numRows = $postModel->getPostCountByCategory($categoryTree);
                setCachedData($key, $numRows);
            }

            $pager = paginate($this->postsPerPage, $numRows);
            $keyPosts = 'posts_category_' . $category->id . '_page_' . $pager->page;
            $data['posts'] = getCachedData($keyPosts);
            if (empty($data['posts'])) {
                $data['posts'] = $postModel->getCategoryPostsPaginated($categoryTree, $this->postsPerPage, $pager->offset);
                setCachedData($keyPosts, $data['posts']);
            }
            $data['categoryArray'] = getCategoryArray($category->id);

            echo view('partials/_header', $data);
            echo view('category', $data);
            echo view('partials/_footer');
        }
    }

    /**
     * Subcategory Page
     */
    public function subcategory($parentSlug, $slug)
    {
        $model = new CategoryModel();
        $category = $model->getCategoryBySlug($slug);
        
        if (empty($category)) {
            return redirect()->to(langBaseUrl());
        }
        $this->category($category, 'subcategory');
    }

    /**
     * Rss Page
     */
    public function rssFeeds()
    {
        if ($this->generalSettings->show_rss == 0) {
            $this->error404();
        } else {
            $data['title'] = trans("rss_feeds");
            $data['description'] = trans("rss_feeds") . " - " . $this->settings->application_name;
            $data['keywords'] = trans("rss_feeds") . "," . $this->settings->application_name;
            
            echo view('partials/_header', $data);
            echo view('rss_feeds', $data);
            echo view('partials/_footer');
        }
    }

    /**
     * Rss All Posts
     */
    public function rssLatestPosts()
    {
        if ($this->generalSettings->show_rss == 1) {
            helper('xml');
            $data['feedName'] = $this->settings->site_title . " - " . trans("latest_posts");
            $data['encoding'] = 'utf-8';
            $data['feedUrl'] = langBaseUrl("rss/posts");
            $data['pageDescription'] = $this->settings->site_title;
            $data['pageLanguage'] = $this->activeLang->short_form;
            $data['creatorEmail'] = '';
            $model = new PostModel();
            $data['posts'] = $model->getLatestPosts(30);
            header("Content-Type: application/rss+xml; charset=utf-8");
            echo view('rss', $data);
        }
    }

    /**
     * Rss All Posts
     */
    public function rssPopularPosts()
    {
        if ($this->generalSettings->show_rss == 1) {
            helper('xml');
            $data['feedName'] = $this->settings->site_title . " - " . trans("popular_posts");
            $data['encoding'] = 'utf-8';
            $data['feedUrl'] = langBaseUrl("rss/popular-posts");
            $data['pageDescription'] = $this->settings->site_title;
            $data['pageLanguage'] = $this->activeLang->short_form;
            $data['creatorEmail'] = '';
            $model = new PostModel();
            $data['posts'] = $model->getPopularPosts(5);
            header("Content-Type: application/rss+xml; charset=utf-8");
            echo view('rss', $data);
        }
    }

    /**
     * Rss By Category
     */
    public function rssByCategory($slug)
    {
        if ($this->generalSettings->show_rss == 1) {
            $categoryModel = new CategoryModel();
            $data['category'] = $categoryModel->getCategoryBySlug($slug);
            if (empty($data['category'])) {
                return redirect()->to(langBaseUrl());
            }
            helper('xml');
            $data['feedName'] = $this->settings->site_title . " - " . trans("category") . ": " . $data['category']->name;
            $data['encoding'] = 'utf-8';
            $data['feedUrl'] = langBaseUrl("rss/category/" . $data['category']->slug);
            $data['pageDescription'] = $this->settings->site_title;
            $data['pageLanguage'] = $this->activeLang->short_form;
            $data['creatorEmail'] = '';
            $model = new PostModel();
            $categoryTree = getCategoryTreeIdsArray($data['category']->id);
            $data['posts'] = $model->getPostsByCategory($categoryTree);
            header("Content-Type: application/rss+xml; charset=utf-8");
            echo view('rss', $data);
        }
    }

    /**
     * Add or Delete from Reading List
     */
    public function addRemoveFromReadingListPost()
    {
        $postId = inputPost('post_id');
        if (empty($postId)) {
            return redirect()->back();
        }
        $model = new PostModel();
        $inList = $model->isPostInReadingList($postId);
        if ($inList == true) {
            $model->deleteFromReadingList($postId);
        } else {
            $model->addToReadingList($postId);
        }
        return redirect()->back();
    }

    /**
     * Download File
     */
    public function downloadFile()
    {
        $name = inputPost('name');
        if (!empty($name)) {
            $name = sanitize_filename($name);
            $path = FCPATH . 'uploads/files/' . $name;
            if (file_exists($path)) {
                return $this->response->download($path, null)->setFileName($name);
            }
        }
        return redirect()->back();
    }

    /**
     * Save Reaction
     */
    public function saveReaction()
    {
        $postId = inputPost('postId');
        $reaction = inputPost('reaction');

        $model = new PostModel();
        $reactionModel = new ReactionModel();

        $data["post"] = $model->getPost($postId);
        if (!empty($data["post"])) {
            $reactionModel->saveReaction($postId, $reaction);
        }
        $data["reactions"] = $reactionModel->getReaction($postId);

        $data = array(
            'result' => 1,
            'content' => view('partials/_emoji_reactions', $data),
        );
        echo json_encode($data);
    }

    /**
     * Add Comment
     */
    public function addCommentPost()
    {
        if ($this->generalSettings->comment_system != 1) {
            exit();
        }
        $limit = inputPost('limit');
        $postId = inputPost('post_id');
        $model = new CommentModel();
        if (authCheck()) {
            $model->addComment();
        } else {
            if (reCAPTCHA('validate', $this->generalSettings) != 'invalid') {
                $model->addComment();
            }
        }
        if ($this->generalSettings->comment_approval_system == 1) {
            $data = [
                'type' => 'message',
                'message' => "<p class='comment-success-message'><i class='icon-check'></i>&nbsp;&nbsp;" . trans("msg_comment_sent_successfully") . "</p>"
            ];
            echo json_encode($data);
        } else {
            $postModel = new PostModel();
            $data["post"] = $postModel->getPost($postId);
            $data['commentCount'] = $model->getPostCommentCount($postId);
            $data['comments'] = $model->getComments($postId, $limit);
            $data['commentLimit'] = $limit;

            $dataJson = [
                'type' => 'comments',
                'message' => view('post/_comments', $data)
            ];
            echo json_encode($dataJson);
        }
    }

    //load subcomment box
    public function loadSubcommentBox()
    {
        $commentId = inputPost('comment_id');
        $limit = inputPost('limit');

        $model = new CommentModel();
        $data["parentComment"] = $model->getComment($commentId);
        $data["commentLimit"] = $limit;
        $dataJson = [
            'result' => 1,
            'content' => view('post/_add_subcomment', $data)
        ];
        echo json_encode($dataJson);
    }


    //delete comment
    public function deleteCommentPost()
    {
        $commentId = inputPost('id');
        $postId = inputPost('post_id');
        $limit = inputPost('limit');

        $model = new CommentModel();
        $comment = $model->getComment($commentId);
        if (authCheck() && !empty($comment)) {
            if (hasPermission('comments') || user()->id == $comment->user_id) {
                $model->deleteComment($commentId);
            }
        }

        $postModel = new PostModel();
        $data["post"] = $postModel->getPost($postId);
        $data['commentCount'] = $model->getPostCommentCount($postId);
        $data['comments'] = $model->getComments($postId, $limit);
        $data['commentLimit'] = $limit;
        $dataJson = [
            'result' => 1,
            'content' => view('post/_comments', $data)
        ];
        echo json_encode($dataJson);
    }


    //load more comment
    public function loadMoreCommentPost()
    {
        $postId = inputPost('post_id');
        $limit = inputPost('limit');
        $newLimit = $limit + $this->commentLimit;

        $model = new CommentModel();
        $postModel = new PostModel();
        $data["post"] = $postModel->getPost($postId);
        $data['commentCount'] = $model->getPostCommentCount($postId);
        $data['comments'] = $model->getComments($postId, $newLimit);
        $data['commentLimit'] = $newLimit;
        $dataJson = [
            'result' => 1,
            'content' => view('post/_comments', $data)
        ];
        echo json_encode($dataJson);
    }

    //add poll vote
    public function addPollVotePost()
    {
        $pollId = inputPost('poll_id');
        $option = inputPost('option');
        $response = "";
        if (empty($option)) {
            $response = "required";
        } else {
            $model = new PollModel();
            $result = $model->addUnregisteredVote($pollId, $option);
            if ($result == "success") {
                $data["poll"] = $model->getPoll($pollId);
                $response = view('partials/_poll_results', $data);
            } else {
                $response = "voted";
            }
        }
        $dataJson = [
            'result' => 1,
            'response' => $response
        ];
        echo json_encode($dataJson);
    }

    /**
     * Add to Newsletter
     */
    public function addToNewsletterPost()
    {
        $vld = inputPost('url');
        if (!empty($vld)) {
            exit();
        }
        $data = [
            'result' => 0,
            'response' => "",
            'is_success' => "",
        ];
        $email = cleanStr(inputPost('email'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['response'] = '<p class="text-danger m-t-5">' . trans("message_invalid_email") . '</p>';
        } else {
            if ($email) {
                $model = new NewsletterModel();
                if (empty($model->getSubscriber($email))) {
                    if ($model->addSubscriber($email)) {
                        $data['response'] = '<p class="text-success m-t-5">' . trans("message_newsletter_success") . '</p>';
                        $data['is_success'] = 1;
                    }
                } else {
                    $data['response'] = '<p class="text-danger m-t-5">' . trans("message_newsletter_error") . '</p>';
                }
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    //check page auth
    private function checkPageAuth($page)
    {
        if (!empty($page)) {
            if (!authCheck() && $page->need_auth == 1) {
                $this->session->setFlashdata('error', trans("message_page_auth"));
                redirectToUrl(langBaseUrl('login'));
            }
        }
    }

    //cookies warning
    public function cookiesWarningPost()
    {
        helperSetCookie('cookies_warning', '1');
    }

    //error 404
    public function error404()
    {
        header("HTTP/1.0 404 Not Found");
        $data['title'] = $this->settings->home_title;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $data['homeTitle'] = $this->settings->home_title;
        $data['isPage404'] = true;

        echo view('partials/_header', $data);
        echo view('errors/html/error_404', $data);
        echo view('partials/_footer', $data);
    }
}
