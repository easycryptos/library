<?php namespace App\Models;

use CodeIgniter\Model;

class SitemapModel extends BaseModel
{
    protected $urls;
    protected $settingsModel;
    protected $languageModel;
    protected $langArray;

    public function __construct()
    {
        parent::__construct();
        $this->urls = array();
        $this->settingsModel = new SettingsModel();
        $this->languageModel = new LanguageModel();

        $this->langArray = array();
        $languages = $this->languageModel->getLanguages();
        foreach ($languages as $lang) {
            $this->langArray[$lang->id][] = $lang->short_form;
        }
    }

    //get pages
    public function getPages()
    {
        return $this->db->table('pages')->orderBy('id')->get()->getResult();
    }

    //get categories
    public function getCategories()
    {
        return $this->db->table('categories')
            ->select('categories.*, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_slug')
            ->orderBy('category_order')->get()->getResult();
    }

    //get posts
    public function getPosts($db)
    {
        return $db->table('posts')
            ->join('users', 'posts.user_id = users.id')
            ->where('posts.visibility', 1)->where('posts.status', 1)->orderBy('posts.created_at DESC')->get()->getResult();
    }

    //get post tags
    public function getPostTags($db)
    {
        return $db->table('tags')->join('posts', 'posts.id = tags.post_id')->join('users', 'posts.user_id = users.id')
            ->select('tags.tag_slug, tags.tag')
            ->groupBy('tags.tag_slug, tags.tag')->orderBy('tags.tag')
            ->where('posts.status', 1)->where('posts.visibility', 1)->get()->getResult();
    }

    //update sitemap settings
    public function updateSitemapSettings()
    {
        $data = [
            'sitemap_frequency' => inputPost('frequency'),
            'sitemap_last_modification' => inputPost('last_modification'),
            'sitemap_priority' => inputPost('priority')
        ];
        $this->db->table('general_settings')->where('id', 1)->update($data);
    }

    //add item to sitemap
    public function add($loc, $changefreq = NULL, $lastmod = NULL, $priority = NULL, $priorityValue = NULL, $lastmodTime = NULL)
    {
        $item = new \stdClass();
        $item->loc = $loc;
        $item->lastmod = $lastmod;
        $item->lastmod_time = $lastmodTime;
        $item->changefreq = $changefreq;
        $item->priority = $priority;
        $item->priority_value = $priorityValue;
        $this->urls[] = $item;
        return true;
    }

    //add page urls
    public function addPageURLs($frequency, $lastModification, $priority, $lastmodTime)
    {
        $pages = $this->getPages();
        if (!empty($pages)) {
            foreach ($pages as $page) {
                if (empty($page->link)) {
                    $baseURL = generateBaseUrl($page->lang_id) . "/";
                    $this->add($baseURL . $page->slug, $frequency, $lastModification, $priority, 0.8, $lastmodTime);
                }
            }
        }
    }

    //add post urls
    public function addPostURLs($frequency, $lastModification, $priority, $lastmodTime)
    {
        $db = \Config\Database::connect(null, false);
        $posts = $this->getPosts($db);
        $db->close();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $baseURL = generateBaseUrl($post->lang_id) . "/";
                $this->add($baseURL . $post->title_slug, $frequency, $lastModification, $priority, 0.8, $lastmodTime);
            }
        }
    }

    //add category urls
    public function addCategoryURLs($frequency, $lastModification, $priority, $lastmodTime)
    {
        $categories = $this->getCategories();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $baseURL = generateBaseUrl($category->lang_id) . "/";
                $catURL = $baseURL;
                if (!empty($category->parent_slug)) {
                    $catURL = $baseURL . $category->parent_slug . "/" . $category->slug;
                } else {
                    $catURL = $baseURL . $category->slug;
                }
                $this->add($catURL, $frequency, $lastModification, $priority, 0.8, $lastmodTime);
            }
        }
    }

    //add tag urls
    public function addTagURLs($frequency, $lastModification, $priority, $lastmodTime)
    {
        $db = \Config\Database::connect(null, false);
        $tags = $this->getPostTags($db);
        $db->close();
        if (!empty($tags)) {
            foreach ($tags as $item) {
                $tagModel = new TagModel();
                $tag = $tagModel->getTag($item->tag_slug);
                if (!empty($tag)) {
                    $baseURL = generateBaseUrl($tag->tag_lang_id) . "/";
                    $this->add($baseURL . "tag/" . $tag->tag_slug, $frequency, $lastModification, $priority, 0.8, $lastmodTime);
                }
            }
        }
    }

    //generate sitemap
    public function generateSitemap()
    {
        $settings = $this->settingsModel->getGeneralSettings();
        if (!empty($settings)) {
            $frequency = $settings->sitemap_frequency;
            $lastModification = $settings->sitemap_last_modification;
            $priority = $settings->sitemap_priority;

            $this->add(base_url(), $frequency, $lastModification, $priority, '1', NULL);
            $this->addPageURLs($frequency, $lastModification, $priority, NULL);
            $this->addCategoryURLs($frequency, $lastModification, $priority, NULL);
            $this->addPostURLs($frequency, $lastModification, $priority, NULL);
            $this->addTagURLs($frequency, $lastModification, $priority, NULL);

            if (itemCount($this->urls) > 49999) {
                $arrayURLs = array_chunk($this->urls, 49000);
                $i = 0;
                if (!empty($arrayURLs)) {
                    foreach ($arrayURLs as $arrayURL) {
                        $fullPath = FCPATH . "sitemap.xml";
                        if ($i != 0) {
                            $fullPath = FCPATH . "sitemap-" . $i . ".xml";
                        }
                        $this->exportSitemap($fullPath, $arrayURL);
                        $i++;
                    }
                }
            } else {
                $fullPath = FCPATH . "sitemap.xml";
                $this->exportSitemap($fullPath, $this->urls);
            }

        }
    }

    //export sitemap
    public function exportSitemap($fullPath, $array)
    {
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        foreach ($array as $url) {
            $child = $xml->addChild('url');
            $child->addChild('loc', htmlspecialchars(strtolower($url->loc ?? '')));

            if (isset($url->lastmod) && $url->lastmod != 'none') {
                if ($url->lastmod == 'server_response') {
                    $child->addChild('lastmod', date("Y-m-d"));
                } else {
                    $child->addChild('lastmod', $url->lastmod_time);
                }
            }

            if (isset($url->changefreq) && $url->changefreq != 'none') {
                $child->addChild('changefreq', $url->changefreq);
            }

            if (isset($url->priority) && $url->priority != 'none') {
                $child->addChild('priority', $url->priority_value);
            }
        }
        $xml->saveXML($fullPath);
    }

}
