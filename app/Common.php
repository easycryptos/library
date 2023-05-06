<?php

use \Config\Globals;
use \App\Models\AuthModel;
use \App\Models\NavigationModel;
use \App\Models\PostModel;
use \App\Models\CategoryModel;
use \App\Models\PollModel;
use \App\Models\LanguageModel;
use \App\Models\FileModel;

if (strpos($_SERVER['REQUEST_URI'], '/index.php') !== false) {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (!empty($url)) {
        $url = str_replace('/index.php', '', $url);
        header('Location: ' . $url);
        exit();
    }
}

//auth check
if (!function_exists('langBaseUrl')) {
    function langBaseUrl($route = null)
    {
        if (!empty($route)) {
            return Globals::$langBaseUrl . '/' . $route;
        }
        return Globals::$langBaseUrl;
    }
}

//generate base url by language
if (!function_exists('generateBaseUrl')) {
    function generateBaseUrl($langId)
    {
        if ($langId == Globals::$generalSettings->site_lang) {
            return base_url();
        } else {
            $shortForm = "";
            if (!empty(Globals::$languages)) {
                foreach (Globals::$languages as $language) {
                    if ($langId == $language->id) {
                        $shortForm = $language->short_form;
                    }
                }
            }
            if (!empty($shortForm)) {
                return base_url($shortForm . "/");
            }
        }
        return base_url();
    }
}

//generate base url by language short name
if (!function_exists('generateBaseUrlByShortForm')) {
    function generateBaseUrlByShortForm($shortForm)
    {
        if ($shortForm == Globals::$activeLang->short_form) {
            return base_url();
        }
        return base_url($shortForm . "/");
    }
}

//admin url
if (!function_exists('adminUrl')) {
    function adminUrl($route = null)
    {
        if (!empty($route)) {
            $route = Globals::$generalSettings->admin_route . '/' . $route;
            return base_url($route);
        }
        return base_url(Globals::$generalSettings->admin_route);
    }
}

//redirect to back URL
if (!function_exists('redirectToBackURL')) {
    function redirectToBackURL()
    {
        $backURL = inputPost('back_url');
        if (!empty($backURL) && strpos($backURL, base_url()) !== false) {
            redirectToUrl($backURL);
            exit();
        }
        redirectToUrl(langBaseUrl());
        exit();
    }
}

//get languages
if (!function_exists('getLanguages')) {
    function getLanguages()
    {
        return Globals::$languages;
    }
}

//get language by id
if (!function_exists('getLanguageById')) {
    function getLanguageById($id)
    {
        $model = new LanguageModel();
        return $model->getLanguage($id);
    }
}

//get active lang
if (!function_exists('getActiveLang')) {
    function getActiveLang()
    {
        return Globals::$activeLang;
    }
}

//get active lang id
if (!function_exists('getActiveLangId')) {
    function getActiveLangId()
    {
        $lang = getActiveLang();
        if (!empty($lang)) {
            return $lang->id;
        }
        return 1;
    }
}

//auth check
if (!function_exists('authCheck')) {
    function authCheck()
    {
        return Globals::$authCheck;
    }
}

//user
if (!function_exists('user')) {
    function user()
    {
        return Globals::$authUser;
    }
}

//check admin
if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (!empty(Globals::$authUserRole)) {
            if (Globals::$authUserRole->is_super_admin == 1 || Globals::$authUserRole->is_admin == 1) {
                return true;
            }
        }
        return false;
    }
}

//check author
if (!function_exists('isAuthor')) {
    function isAuthor()
    {
        if (!empty(Globals::$authUserRole)) {
            if (Globals::$authUserRole->is_author == 1) {
                return true;
            }
        }
        return false;
    }
}

//get user by id
if (!function_exists('getUser')) {
    function getUser($id)
    {
        $model = new AuthModel();
        return $model->getUser($id);
    }
}

if (!function_exists('isUserOnline')) {
    function isUserOnline($timestamp)
    {
        if (!empty($timestamp)) {
            $timeAgo = strtotime($timestamp);
            $currentTime = time();
            $timeDifference = $currentTime - $timeAgo;
            $seconds = $timeDifference;
            $minutes = round($seconds / 60);
            if ($minutes <= 2) {
                return true;
            } else {
                return false;
            }
        }
    }
}

//check user follows
if (!function_exists('isUserFollows')) {
    function isUserFollows($followingId, $followerId)
    {
        $model = new AuthModel();
        return $model->isUserFollows($followingId, $followerId);
    }
}

//get request
if (!function_exists('inputGet')) {
    function inputGet($input_name, $removeForbidden = false)
    {
        $input = \Config\Services::request()->getGet($input_name);
        if (isset($input) && !is_array($input)) {
            $input = trim($input ?? '');
        }
        if ($removeForbidden) {
            $input = removeForbiddenCharacters($input);
        }
        return $input;
    }
}

//post request
if (!function_exists('inputPost')) {
    function inputPost($input_name, $removeForbidden = false)
    {
        $input = \Config\Services::request()->getPost($input_name);
        if (isset($input) && !is_array($input)) {
            $input = trim($input ?? '');
        }
        if ($removeForbidden) {
            $input = removeForbiddenCharacters($input);
        }
        return $input;
    }
}

//current full url
if (!function_exists('currentFullUrl')) {
    function currentFullUrl()
    {
        $current_url = current_url();
        if (!empty($_SERVER['QUERY_STRING'])) {
            $current_url = $current_url . "?" . $_SERVER['QUERY_STRING'];
        }
        return $current_url;
    }
}

//limit character
if (!function_exists('limitCharacter')) {
    function limitCharacter($str, $limit, $postfix)
    {
        if (!empty($str)) {
            if (empty($postfix)) {
                $postfix = '...';
            }
            if (isset($str)) {
                if (strlen($str) > $limit) {
                    return mb_substr($str, 0, $limit, 'UTF-8') . $postfix;
                }
            }
            return $str;
        }
    }
}

//unserialize data
if (!function_exists('unserializeData')) {
    function unserializeData($serializedData)
    {
        if (!empty($serializedData)) {
            $data = @unserialize($serializedData);
            if (empty($data) && preg_match('/^[aOs]:/', $serializedData)) {
                $serializedData = preg_replace_callback('/s\:(\d+)\:\"(.*?)\";/s', function ($matches) {
                    return 's:' . strlen($matches[2] ?? '') . ':"' . $matches[2] . '";';
                }, $serializedData);
                $data = @unserialize($serializedData);
            }
            return $data;
        }
    }
}

//parse serialized name array
if (!function_exists('parseSerializedNameArray')) {
    function parseSerializedNameArray($nameArray, $langId, $getMainName = true)
    {
        if (!empty($nameArray)) {
            $nameArray = unserializeData($nameArray);
            if (!empty($nameArray)) {
                foreach ($nameArray as $item) {
                    if ($item['lang_id'] == $langId && !empty($item['name'])) {
                        return $item['name'];
                    }
                }
            }
            //if not exist
            if ($getMainName == true) {
                if (!empty($nameArray)) {
                    foreach ($nameArray as $item) {
                        if ($item['lang_id'] == Globals::$generalSettings->site_lang && !empty($item['name'])) {
                            return $item['name'];
                        }
                    }
                }
            }
        }
        return '';
    }
}

//get logo
if (!function_exists('getLogo')) {
    function getLogo($generalSettings)
    {
        if (!empty($generalSettings)) {
            if (!empty($generalSettings->logo_path) && file_exists(FCPATH . $generalSettings->logo_path)) {
                return base_url($generalSettings->logo_path);
            }
        }
        return base_url("assets/img/logo.png");
    }
}

//get mobile logo
if (!function_exists('getMobileLogo')) {
    function getMobileLogo($generalSettings)
    {
        if (!empty($generalSettings)) {
            if (!empty($generalSettings->mobile_logo_path) && file_exists(FCPATH . $generalSettings->mobile_logo_path)) {
                return base_url($generalSettings->mobile_logo_path);
            }
        }
        return base_url("assets/img/logo-mobile.png");
    }
}

//get favicon
if (!function_exists('getFavicon')) {
    function getFavicon($generalSettings)
    {
        if (!empty($generalSettings)) {
            if (!empty($generalSettings->favicon_path) && file_exists(FCPATH . $generalSettings->favicon_path)) {
                return base_url($generalSettings->favicon_path);
            }
        }
        return base_url("assets/img/favicon.png");
    }
}

//get user avatar
if (!function_exists('getUserAvatar')) {
    function getUserAvatar($user)
    {
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url($user->avatar);
            } elseif (!empty($user->avatar)) {
                return $user->avatar;
            } else {
                return base_url("assets/img/user.png");
            }
        }
        return base_url("assets/img/user.png");
    }
}

//get user avatar by id
if (!function_exists('getUserAvatarById')) {
    function getUserAvatarById($userId)
    {
        $user = getUser($userId);
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url($user->avatar);
            } elseif (!empty($user->avatar)) {
                return $user->avatar;
            } else {
                return base_url("assets/img/user.png");
            }
        }
        return base_url("assets/img/user.png");
    }
}

//delete file from server
if (!function_exists('deleteFileFromServer')) {
    function deleteFileFromServer($path)
    {
        if (!empty($path)) {
            $fullPath = FCPATH . $path;
            if (strlen($path) > 15 && file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
    }
}

//get menu links
if (!function_exists('getMenuLinks')) {
    function getMenuLinks($langId)
    {
        $navModel = new NavigationModel();
        return $navModel->getMenuLinks($langId);
    }
}

//get sub menu links
if (!function_exists('getSubMenuLinks')) {
    function getSubMenuLinks($menuLinks, $parentId, $type)
    {
        $subLinks = array();
        if (!empty($menuLinks)) {
            $subLinks = array_filter($menuLinks, function ($item) use ($parentId, $type) {
                return $item->item_type == $type && $item->item_parent_id == $parentId;
            });
        }
        return $subLinks;
    }
}

//get parent link
if (!function_exists('getParentLink')) {
    function getParentLink($parentId, $type)
    {
        $model = new NavigationModel();
        return $model->getParentLink($parentId, $type);
    }
}


//translation
if (!function_exists('trans')) {
    function trans($string)
    {
        if (isset(Globals::$languageTranslations[$string])) {
            return Globals::$languageTranslations[$string];
        }
        return "";
    }
}

//generate category url
if (!function_exists('generateCategoryUrl')) {
    function generateCategoryUrl($parentSlug, $slug)
    {
        if (!empty($parentSlug)) {
            return langBaseUrl($parentSlug . "/" . $slug);
        } else {
            return langBaseUrl($slug);
        }
    }
}

//generate menu item url
if (!function_exists('generateMenuItemUrl')) {
    function generateMenuItemUrl($item)
    {
        if (empty($item)) {
            return langBaseUrl('#');
        }
        if ($item->item_type == 'page') {
            if (!empty($item->item_link)) {
                return $item->item_link;
            } else {
                return langBaseUrl($item->item_slug);
            }
        } elseif ($item->item_type == 'category') {
            if (!empty($item->item_parent_slug)) {
                return langBaseUrl($item->item_parent_slug . "/" . $item->item_slug);
            } else {
                return langBaseUrl($item->item_slug);
            }
        } else {
            return langBaseUrl('#');
        }
    }
}

//generate post url
if (!function_exists('generatePostUrl')) {
    function generatePostUrl($post, $baseUrl = null)
    {
        if ($baseUrl == null) {
            $baseUrl = langBaseUrl();
        }
        if (isset($baseUrl)) {
            $baseUrl = trim($baseUrl, '/');
            if (!empty($post)) {
                return $baseUrl . '/' . $post->title_slug;
            }
        }
        return "#";
    }
}

//generate profile url
if (!function_exists('generateProfileUrl')) {
    function generateProfileUrl($user)
    {
        if (!empty($user)) {
            return langBaseUrl("profile/" . $user->slug);
        }
        return "#";
    }
}

//get post by id
if (!function_exists('getPostById')) {
    function getPostById($id)
    {
        $model = new PostModel();
        return $model->getPost($id);
    }
}

//get latest posts
if (!function_exists('getLatestPosts')) {
    function getLatestPosts($limit)
    {
        $latestPosts = getCachedData('latest_posts_limit_' . $limit);
        if (empty($latestPosts)) {
            $model = new PostModel();
            $latestPosts = $model->getLatestPosts($limit);
            setCachedData('latest_posts_limit_' . $limit, $latestPosts);
        }
        return $latestPosts;
    }
}

//get popular posts
if (!function_exists('getPopularPosts')) {
    function getPopularPosts($limit)
    {
        $popularPosts = getCachedData('popular_posts');
        if (empty($popularPosts)) {
            $model = new PostModel();
            $popularPosts = $model->getPopularPosts($limit);
            setCachedData('popular_posts', $popularPosts);
        }
        return $popularPosts;
    }
}

//get our picks
if (!function_exists('getOurPicks')) {
    function getOurPicks($limit)
    {
        $ourPicks = getCachedData('our_picks');
        if (empty($ourPicks)) {
            $model = new PostModel();
            $ourPicks = $model->getOurPicks($limit);
            setCachedData('our_picks', $ourPicks);
        }
        return $ourPicks;
    }
}

//get random posts
if (!function_exists('getRandomPosts')) {
    function getRandomPosts($limit)
    {
        $randomPosts = getCachedData('random_posts');
        if (empty($randomPosts)) {
            $model = new PostModel();
            $randomPosts = $model->getRandomPosts($limit);
            setCachedData('random_posts', $randomPosts);
        }
        return $randomPosts;
    }
}


//get polls
if (!function_exists('getPolls')) {
    function getPolls()
    {
        $model = new PollModel();
        return $model->getPolls();
    }
}

//get poll votes
if (!function_exists('getPollVotes')) {
    function getPollVotes($pollId)
    {
        $model = new PollModel();
        return $model->getPollVotes($pollId);
    }
}

//calculate poll option votes
if (!function_exists('calcPollOptionVotes')) {
    function calcPollOptionVotes($votes, $option = 'total')
    {
        if (!empty($votes)) {
            if ($option == 'total') {
                return itemCount($votes);
            } else {
                $numVotes = 0;
                foreach ($votes as $vote) {
                    if ($vote->vote == $option) {
                        $numVotes += 1;
                    }
                }
                return $numVotes;
            }
        }
        return 0;
    }
}

//get post image
if (!function_exists('getPostImage')) {
    function getPostImage($post, $size)
    {
        if (!empty($post)) {
            if (!empty($post->image_url)) {
                return $post->image_url;
            } else {
                $img = "image_" . $size;
                if (!empty($post->$img)) {
                    return base_url($post->$img);
                }
            }
        }
        return "";
    }
}

//get post additional images
if (!function_exists('getPostAdditionalImages')) {
    function getPostAdditionalImages($postId)
    {
        $model = new PostModel();
        return $model->getPostAdditionalImages($postId);
    }
}

//get categories
if (!function_exists('getCategories')) {
    function getCategories()
    {
        $model = new CategoryModel();
        return $model->getCategories();
    }
}

//get category
if (!function_exists('getCategory')) {
    function getCategory($id)
    {
        $model = new CategoryModel();
        return $model->getCategory($id);
    }
}

//get subcategories by parent id
if (!function_exists('getSubcategoriesClient')) {
    function getSubcategoriesClient($categories, $parentId)
    {
        if (!empty($categories) && $parentId > 0) {
            return array_filter($categories, function ($item) use ($parentId) {
                return $item->parent_id == $parentId;
            });
        }
    }
}

//get categories
if (!function_exists('getCategories')) {
    function getCategories()
    {
        $model = new CategoryModel();
        return $model->getCategories();
    }
}


//get category array
if (!function_exists('getCategoryArray')) {
    function getCategoryArray($id)
    {
        $model = new CategoryModel();
        return $model->getCategoryArray($id);
    }
}

//get category tree
if (!function_exists('getCategoryTree')) {
    function getCategoryTree($id)
    {
        $model = new CategoryModel();
        return $model->getCategoryTree($id);
    }
}

//get category tree
if (!function_exists('getCategoryTreeIdsArray')) {
    function getCategoryTreeIdsArray($id)
    {
        $model = new CategoryModel();
        return $model->getCategoryTreeIdsArray($id);
    }
}

//get random tags
if (!function_exists('getRandomTags')) {
    function getRandomTags()
    {
        $randomTags = getCachedData('tags');
        if (empty($randomTags)) {
            $model = new \App\Models\TagModel();
            $randomTags = $model->getRandomTags();
            setCachedData('tags', $randomTags);
        }
        return $randomTags;
    }
}

//get gallery cover image
if (!function_exists('getGalleryCoverImage')) {
    function getGalleryCoverImage($albumId)
    {
        $model = new \App\Models\GalleryModel();
        return $model->getGalleryCoverImage($albumId);
    }
}

//get post files
if (!function_exists('getPostFiles')) {
    function getPostFiles($postId)
    {
        $model = new PostModel();
        return $model->getPostFiles($postId);
    }
}

//get feed posts count
if (!function_exists('getFeedPostsCount')) {
    function getFeedPostsCount($feedId)
    {
        $model = new \App\Models\RssModel();
        return $model->getFeedPostsCount($feedId);
    }
}

//is reaction voted
if (!function_exists('isReactionVoted')) {
    function isReactionVoted($postId, $reaction)
    {
        $session = \Config\Services::session();
        if (!empty($session->get("reaction_" . $reaction . "_" . $postId)) && $session->get("reaction_" . $reaction . "_" . $postId) == '1') {
            return true;
        }
        return false;
    }
}

//set session
if (!function_exists('setSession')) {
    function setSession($name, $value)
    {
        $session = \Config\Services::session();
        $session->set($name, $value);
    }
}

//get session
if (!function_exists('getSession')) {
    function getSession($name)
    {
        $session = \Config\Services::session();
        if ($session->get($name) !== null) {
            return $session->get($name);
        }
        return null;
    }
}

//delete session
if (!function_exists('deleteSession')) {
    function deleteSession($name)
    {
        $session = \Config\Services::session();
        if ($session->get($name) !== null) {
            $session->remove($name);
        }
    }
}

//set cookie
if (!function_exists('helperSetCookie')) {
    function helperSetCookie($name, $value, $time = null)
    {
        if ($time == null) {
            $time = time() + (86400 * 30);
        }
        $config = config('App');
        $params = [
            'expires' => $time,
            'path' => $config->cookiePath,
            'domain' => $config->cookieDomain,
            'secure' => $config->cookieSecure,
            'httponly' => $config->cookieHTTPOnly,
            'samesite' => $config->cookieSameSite,
        ];
        if (!empty(getenv('cookie.prefix'))) {
            $name = getenv('cookie.prefix') . $name;
        }
        setcookie($name, $value, $params);
    }
}

//get cookie
if (!function_exists('helperGetCookie')) {
    function helperGetCookie($name)
    {
        if (!empty(getenv('cookie.prefix'))) {
            $name = getenv('cookie.prefix') . $name;
        }
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return false;
    }
}

//delete cookie
if (!function_exists('helperDeleteCookie')) {
    function helperDeleteCookie($name)
    {
        if (!empty(getenv('cookie.prefix'))) {
            $name = getenv('cookie.prefix') . $name;
        }
        if (!empty(helperGetCookie($name))) {
            helperSetCookie($name, '', time() - 3600);
        }
    }
}

//get cached data by lang
if (!function_exists('getCachedData')) {
    function getCachedData($key)
    {
        $key = $key . "_lang" . Globals::$activeLang->id;
        if (Globals::$generalSettings->cache_system == 1) {
            $cache = \Config\Services::cache();
            if ($data = cache($key)) {
                return $data;
            }
        }
        return false;
    }
}

//set cached data by lang
if (!function_exists('setCachedData')) {
    function setCachedData($key, $data)
    {
        $key = $key . "_lang" . Globals::$activeLang->id;
        if (Globals::$generalSettings->cache_system == 1) {
            $cache = \Config\Services::cache();
            cache()->save($key, $data, Globals::$generalSettings->cache_refresh_time);
        }
    }
}

//reset cache data
if (!function_exists('resetCacheData')) {
    function resetCacheData()
    {
        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . '*');
        if (!empty($files)) {
            foreach ($files as $file) {
                if (!empty($file)) {
                    if (strpos($file, 'index.html') === false) {
                        @unlink($file);
                    }
                }
            }
        }
    }
}

//reset cache data on change
if (!function_exists('resetCacheDataOnChange')) {
    function resetCacheDataOnChange()
    {
        if (Globals::$generalSettings->refresh_cache_database_changes == 1) {
            resetCacheData();
        }
    }
}

//redirect
if (!function_exists('redirectToUrl')) {
    function redirectToUrl($url)
    {
        if (!empty($url)) {
            header('Location: ' . $url);
        }
        exit();
    }
}

//clean quotes
if (!function_exists('clrQuotes')) {
    function clrQuotes($str)
    {
        $str = str_replace('"', '', $str ?? '');
        $str = str_replace("'", '', $str ?? '');
        return $str;
    }
}

//generate slug
if (!function_exists('strSlug')) {
    function strSlug($str)
    {
        $str = trim($str ?? '');
        if (isset($str)) {
            return url_title(convert_accented_characters($str), '-', TRUE);
        }
    }
}

//clean slug
if (!function_exists('cleanSlug')) {
    function cleanSlug($slug)
    {
        $slug = trim($slug ?? '');
        if (isset($slug)) {
            $slug = urldecode($slug);
        }
        if (isset($slug)) {
            $slug = strip_tags($slug);
        }
        return removeSpecialCharacters($slug);
    }
}

//clean string
if (!function_exists('cleanStr')) {
    function cleanStr($str)
    {
        $str = trim($str ?? '');
        $str = removeSpecialCharacters($str);
        return esc($str);
    }
}

//clean number
if (!function_exists('cleanNumber')) {
    function cleanNumber($num)
    {
        $num = trim($num ?? '');
        $num = esc($num);
        if (isset($num)) {
            return intval($num);
        }
        return 0;
    }
}

//generate unique id
if (!function_exists('generateToken')) {
    function generateToken()
    {
        $id = uniqid("", TRUE);
        $id = str_replace(".", "-", $id);
        return $id . "-" . rand(10000000, 99999999);
    }
}

//count items
if (!function_exists('itemCount')) {
    function itemCount($items)
    {
        if (!empty($items) && is_array($items)) {
            return count($items);
        }
        return 0;
    }
}

//paginate
if (!function_exists('paginate')) {
    function paginate($perPage, $total)
    {
        $page = @intval(inputGet('page') ?? '');
        if (empty($page) || $page < 1) {
            $page = 1;
        }
        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $total);
        $pageObject = new stdClass();
        $pageObject->page = $page;
        $pageObject->offset = ($page - 1) * $perPage;
        return $pageObject;
    }
}

//remove forbidden characters
if (!function_exists('removeForbiddenCharacters')) {
    function removeForbiddenCharacters($str)
    {
        if (!empty($str)) {
            $str = trim($str ?? '');
            $str = str_replace(';', '', $str ?? '');
            $str = str_replace('"', '', $str ?? '');
            $str = str_replace('$', '', $str ?? '');
            $str = str_replace('%', '', $str ?? '');
            $str = str_replace('*', '', $str ?? '');
            $str = str_replace('/', '', $str ?? '');
            $str = str_replace('\'', '', $str ?? '');
            $str = str_replace('<', '', $str ?? '');
            $str = str_replace('>', '', $str ?? '');
            $str = str_replace('=', '', $str ?? '');
            $str = str_replace('?', '', $str ?? '');
            $str = str_replace('[', '', $str ?? '');
            $str = str_replace(']', '', $str ?? '');
            $str = str_replace('\\', '', $str ?? '');
            $str = str_replace('^', '', $str ?? '');
            $str = str_replace('`', '', $str ?? '');
            $str = str_replace('{', '', $str ?? '');
            $str = str_replace('}', '', $str ?? '');
            $str = str_replace('|', '', $str ?? '');
            $str = str_replace('~', '', $str ?? '');
            $str = str_replace('+', '', $str ?? '');
            return $str;
        }
    }
}

//remove special characters
if (!function_exists('removeSpecialCharacters')) {
    function removeSpecialCharacters($str)
    {
        $str = removeForbiddenCharacters($str);
        $str = str_replace('#', '', $str ?? '');
        $str = str_replace('!', '', $str ?? '');
        $str = str_replace('(', '', $str ?? '');
        $str = str_replace(')', '', $str ?? '');
        return $str;
    }
}

//get ad codes
if (!function_exists('getAdCodes')) {
    function getAdCodes($adSpace)
    {
        $adModel = new \App\Models\AdModel();
        return $adModel->getAdCodes($adSpace);
    }
}

//get ad codes client
if (!function_exists('getAdCodesClient')) {
    function getAdCodesClient($adSpaces, $key)
    {
        if (!empty($adSpaces)) {
            foreach ($adSpaces as $adSpace) {
                if ($adSpace->ad_space == $key) {
                    return $adSpace;
                }
            }
        }
    }
}

//get comment count
if (!function_exists('getPostCommentCount')) {
    function getPostCommentCount($postId)
    {
        $model = new \App\Models\CommentModel();
        return $model->getPostCommentCount($postId);
    }
}

//get subcomments
if (!function_exists('getSubcomments')) {
    function getSubcomments($parentId)
    {
        $model = new \App\Models\CommentModel();
        return $model->getSubcomments($parentId);
    }
}


//is recaptcha enabled
if (!function_exists('isRecaptchaEnabled')) {
    function isRecaptchaEnabled($generalSettings)
    {
        if (!empty($generalSettings->recaptcha_site_key) && !empty($generalSettings->recaptcha_secret_key)) {
            return true;
        }
        return false;
    }
}

//get recaptcha
if (!function_exists('reCaptcha')) {
    function reCaptcha($action, $generalSettings)
    {
        if (isRecaptchaEnabled($generalSettings)) {
            include(APPPATH . 'Libraries/reCAPTCHA.php');
            $reCAPTCHA = new reCAPTCHA($generalSettings->recaptcha_site_key, $generalSettings->recaptcha_secret_key);
            $reCAPTCHA->setLanguage(Globals::$activeLang->short_form);
            if ($action == "generate") {
                echo $reCAPTCHA->getScript();
                echo $reCAPTCHA->getHtml();
            } elseif ($action == "validate") {
                if (!$reCAPTCHA->isValid($_POST['g-recaptcha-response'])) {
                    return 'invalid';
                }
            }
        }
    }
}

if (!function_exists('addHttpsToUrl')) {
    function addHttpsToUrl($url)
    {
        if (!empty($url)) {
            $url = trim($url);
            if (!empty($url)) {
                if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                    $url = "https://" . $url;
                }
            }
            return $url;
        }
    }
}

//generate keywords
if (!function_exists('generateKeywordsFromTitle')) {
    function generateKeywordsFromTitle($title)
    {
        $array = explode(" ", $title ?? '');
        $keywords = "";
        $i = 0;
        if (!empty($array)) {
            foreach ($array as $item) {
                $item = trim($item ?? '');
                $item = trim($item ?? '', ",");
                if (!empty($item) && strlen($item) > 2) {
                    $item = removeSpecialCharacters($item);
                    if ($i == 0) {
                        $keywords = $item;
                    } else {
                        $keywords .= ", " . $item;
                    }
                }
                $i++;
            }
        }
        return $keywords;
    }
}

//date format
if (!function_exists('formatDate')) {
    function formatDate($timestamp)
    {
        if (!empty($timestamp)) {
            return date("Y-m-d / H:i", strtotime($timestamp));
        }
    }
}

//date format for posts
if (!function_exists('dateFormatDefault')) {
    function dateFormatDefault($datetime)
    {
        if (!empty($datetime)) {
            $date = date("M j, Y", strtotime($datetime));
            $date = str_replace("Jan", trans("January"), $date ?? '');
            $date = str_replace("Feb", trans("February"), $date ?? '');
            $date = str_replace("Mar", trans("March"), $date ?? '');
            $date = str_replace("Apr", trans("April"), $date ?? '');
            $date = str_replace("May", trans("May"), $date ?? '');
            $date = str_replace("Jun", trans("June"), $date ?? '');
            $date = str_replace("Jul", trans("July"), $date ?? '');
            $date = str_replace("Aug", trans("August"), $date ?? '');
            $date = str_replace("Sep", trans("September"), $date ?? '');
            $date = str_replace("Oct", trans("October"), $date ?? '');
            $date = str_replace("Nov", trans("November"), $date ?? '');
            $date = str_replace("Dec", trans("December"), $date ?? '');
            return $date;
        }
    }
}

//date difference in hours
if (!function_exists('dateDifferenceInHours')) {
    function dateDifferenceInHours($date1, $date2)
    {
        if (!empty($date1) && !empty($date2)) {
            $datetime1 = date_create($date1);
            $datetime2 = date_create($date2);
            $diff = date_diff($datetime1, $datetime2);
            $days = $diff->format('%a');
            $hours = $diff->format('%h');
            return $hours + ($days * 24);
        }
    }
}

//check time difference in hours
if (!function_exists('checkCronTime')) {
    function checkCronTime($hour)
    {
        if (empty(Globals::$generalSettings->last_cron_update) || dateDifferenceInHours(date('Y-m-d H:i:s'), Globals::$generalSettings->last_cron_update) >= $hour) {
            return true;
        }
        return false;
    }
}

//calculate passed time
if (!function_exists('timeAgo')) {
    function timeAgo($timestamp)
    {
        if (!empty($timestamp)) {
            $timeAgo = strtotime($timestamp);
            $currentTime = time();
            $timeDifference = $currentTime - $timeAgo;
            $seconds = $timeDifference;
            $minutes = round($seconds / 60);
            $hours = round($seconds / 3600);
            $days = round($seconds / 86400);
            $weeks = round($seconds / 604800);
            $months = round($seconds / 2629440);
            $years = round($seconds / 31553280);
            if ($seconds <= 60) {
                return trans("just_now");
            } else if ($minutes <= 60) {
                if ($minutes == 1) {
                    return "1 " . trans("minute_ago");
                } else {
                    return "$minutes " . trans("minutes_ago");
                }
            } else if ($hours <= 24) {
                if ($hours == 1) {
                    return "1 " . trans("hour_ago");
                } else {
                    return "$hours " . trans("hours_ago");
                }
            } else if ($days <= 30) {
                if ($days == 1) {
                    return "1 " . trans("day_ago");
                } else {
                    return "$days " . trans("days_ago");
                }
            } else if ($months <= 12) {
                if ($months == 1) {
                    return "1 " . trans("month_ago");
                } else {
                    return "$months " . trans("months_ago");
                }
            } else {
                if ($years == 1) {
                    return "1 " . trans("year_ago");
                } else {
                    return "$years " . trans("years_ago");
                }
            }
        }
    }
}

//check newsletter modal
if (!function_exists('checkNewsletterModal')) {
    function checkNewsletterModal()
    {
        if (!authCheck() && Globals::$generalSettings->newsletter_status == 1 && Globals::$generalSettings->newsletter_popup == 1) {
            if (empty(helperGetCookie('newsletter_mdl'))) {
                helperSetCookie('newsletter_mdl', '1');
                return true;
            }
        }
        return false;
    }
}

//convert xml characters
if (!function_exists('convertToXmlCharacter')) {
    function convertToXmlCharacter($str)
    {
        if (!empty($str)) {
            $str = str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $str);
        }
        if (!empty($str)) {
            $str = str_replace('&#45;', '-', $str);
        }
        if (!empty($str)) {
            $str = str_replace('&amp;#45;', '-', $str);
        }
        return $str;
    }
}

//get segment value
if (!function_exists('getSegmentValue')) {
    function getSegmentValue($segmentNumber)
    {
        try {
            $uri = service('uri');
            if ($uri->getSegment($segmentNumber) !== null) {
                return $uri->getSegment($segmentNumber);
            }
        } catch (Exception $e) {
        }
        return null;
    }
}

//check admin nav
if (!function_exists('isAdminNavActive')) {
    function isAdminNavActive($arrayNavItems)
    {
        $segment = getSegmentValue(2);
        if (!empty($segment) && !empty($arrayNavItems)) {
            if (in_array($segment, $arrayNavItems)) {
                echo ' ' . 'active';
            }
        }
    }
}

//get file manager images
if (!function_exists('getFileManagerImages')) {
    function getFileManagerImages($limit)
    {
        $model = new FileModel();
        return $model->getImages($limit);
    }
}

//get file manager files
if (!function_exists('getFileManagerFiles')) {
    function getFileManagerFiles($limit)
    {
        $model = new FileModel();
        return $model->getFiles($limit);
    }
}

//get font family
if (!function_exists('getFontFamily')) {
    function getFontFamily($activeFonts, $key, $removeFamilyText = false)
    {
        if (!empty($activeFonts[$key]) && !empty($activeFonts[$key]->font_family)) {
            $fontFamily = $activeFonts[$key]->font_family;
            if (!empty($fontFamily)) {
                if ($removeFamilyText) {
                    $fontFamilyArray = explode(':', $fontFamily);
                    if (!empty($fontFamilyArray[1])) {
                        return $fontFamilyArray[1];
                    }
                }
                return $activeFonts[$key]->font_family;
            }


        }
        return '';
    }
}

//get font url
if (!function_exists('getFontURL')) {
    function getFontURL($activeFonts, $key)
    {
        if (!empty($activeFonts[$key]) && !empty($activeFonts[$key]->font_url) && $activeFonts[$key]->font_source != 'local') {
            return $activeFonts[$key]->font_url;
        }
        return '';
    }
}

//get validation rules
if (!function_exists('getValRules')) {
    function getValRules($val)
    {
        $rules = $val->getRules();
        $newRules = array();
        if (!empty($rules)) {
            foreach ($rules as $key => $rule) {
                $newRules[$key] = [
                    'label' => $rule['label'],
                    'rules' => $rule['rules'],
                    'errors' => [
                        'required' => trans("form_validation_required"),
                        'min_length' => trans("form_validation_min_length"),
                        'max_length' => trans("form_validation_max_length"),
                        'matches' => trans("form_validation_matches"),
                        'is_unique' => trans("form_validation_is_unique")
                    ]
                ];
            }
        }
        return $newRules;
    }
}

//get social links array
if (!function_exists('getSocialLinksArray')) {
    function getSocialLinksArray($settings)
    {
        $array = array();
        if (!empty($settings->facebook_url)) {
            array_push($array, ['name' => 'facebook', 'url' => $settings->facebook_url]);
        }
        if (!empty($settings->twitter_url)) {
            array_push($array, ['name' => 'twitter', 'url' => $settings->twitter_url]);
        }
        if (!empty($settings->pinterest_url)) {
            array_push($array, ['name' => 'pinterest', 'url' => $settings->pinterest_url]);
        }
        if (!empty($settings->instagram_url)) {
            array_push($array, ['name' => 'instagram', 'url' => $settings->instagram_url]);
        }
        if (!empty($settings->linkedin_url)) {
            array_push($array, ['name' => 'linkedin', 'url' => $settings->linkedin_url]);
        }
        if (!empty($settings->vk_url)) {
            array_push($array, ['name' => 'vk', 'url' => $settings->vk_url]);
        }
        if (!empty($settings->telegram_url)) {
            array_push($array, ['name' => 'telegram', 'url' => $settings->telegram_url]);
        }
        if (!empty($settings->youtube_url)) {
            array_push($array, ['name' => 'youtube', 'url' => $settings->youtube_url]);
        }
        return $array;
    }
}

//get permissions array
if (!function_exists('getPermissionsArray')) {
    function getPermissionsArray()
    {
        return ['1' => 'manage_all_posts', '2' => 'add_post', '3' => 'themes', '4' => 'navigation', '5' => 'pages', '6' => 'rss_feeds',
            '7' => 'categories', '8' => 'polls', '9' => 'gallery', '10' => 'comments', '11' => 'contact_messages', '12' => 'newsletter',
            '13' => 'ad_spaces', '14' => 'membership', '15' => 'seo_tools', '16' => 'settings'];
    }
}

//get permission index key
if (!function_exists('getPermissionIndex')) {
    function getPermissionIndex($permission)
    {
        $array = getPermissionsArray();
        foreach ($array as $key => $value) {
            if ($value == $permission) {
                return $key;
            }
        }
        return null;
    }
}

//get permission by index
if (!function_exists('getPermissionByIndex')) {
    function getPermissionByIndex($index)
    {
        $array = getPermissionsArray();
        if (isset($array[$index])) {
            return $array[$index];
        }
        return null;
    }
}

//has permission
if (!function_exists('hasPermission')) {
    function hasPermission($permission, $permissions = null)
    {
        if (!empty($permission)) {
            if ($permissions == null) {
                if (!empty(Globals::$authUserRole->permissions)) {
                    $permissions = Globals::$authUserRole->permissions;
                }
            }
            if (!empty($permissions)) {
                if ($permissions == 'all') {
                    return true;
                }
                $array = explode(',', $permissions);
                $index = getPermissionIndex($permission);
                if (!empty($index) && in_array($index, $array)) {
                    return true;
                }
            }
        }
        return false;
    }
}

//check permission
if (!function_exists('checkPermission')) {
    function checkPermission($permission)
    {
        if (!hasPermission($permission)) {
            redirectToUrl(base_url());
            exit();
        }
    }
}