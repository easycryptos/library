<?php
/*
* Library feed reader
*/
require_once APPPATH . "ThirdParty/simplepie/autoloader.php";
require_once APPPATH . "ThirdParty/simplepie/idn/idna_convert.class.php";
require_once APPPATH . "ThirdParty/rss-parser/Feed.php";
require_once APPPATH . "ThirdParty/rss-parser/embed/autoloader.php";

// Load all required Feed classes
use YuzuruS\Rss\Feed;


class RssParser
{
    /**
     * @return  feeds
     **/
    public function getFeeds($url)
    {
        header('Content-type:text/html; charset=utf-8');
        $feed = new SimplePie();
        $feed->set_feed_url($url);
        $feed->enable_cache(false);
        $feed->init();
        $feed->handle_content_type();
        return $feed->get_items();
    }

    //get image
    public function getImage($item, $download = false)
    {
        if ($download == true) {
            $data = [
                'image_big' => "",
                'image_mid' => "",
                'image_small' => "",
                'image_slider' => ""
            ];
            $imgURL = $this->getImageURLFromFeed($item);
            if (empty($imgURL)) {
                return $data;
            }
            $saveTo = FCPATH . "uploads/temp/temp.jpg";
            @copy($imgURL, $saveTo);
            if (!empty($saveTo) && file_exists($saveTo)) {
                $uploadModel = new \App\Models\UploadModel();
                $data['image_big'] = $uploadModel->postBigImageUpload($saveTo);
                $data['image_mid'] = $uploadModel->postMidImageUpload($saveTo);
                $data['image_small'] = $uploadModel->postSmallImageUpload($saveTo);
                $data['image_slider'] = $uploadModel->postSliderImageUpload($saveTo);
                @unlink($saveTo);
                return $data;
            }
        }
        return $this->getImageURLFromFeed($item);
    }

    //get image URL from feed
    public function getImageURLFromFeed($item)
    {
        //enclosure image
        $imgURL = $this->get_post_image_from_enclosure($item);
        if (!empty($imgURL) && (strpos($imgURL, 'http') !== false)) {
            return $imgURL;
        }

        //og image
        $imgURL = $this->getImageFromOG($item);
        if (!empty($imgURL) && (strpos($imgURL, 'http') !== false)) {
            return $imgURL;
        }

        //text image
        $imgURL = "";
        $images = $this->getImageFromText($item);
        if (!empty($images)) {
            $imgURL = @$images[0];
        }
        if (!empty($imgURL) && (strpos($imgURL, 'http') !== false)) {
            return $imgURL;
        }

        //embed og image
        $imgURL = $this->getImageFromEmbedOG($item);
        if (!empty($imgURL) && (strpos($imgURL, 'http') !== false)) {
            return $imgURL;
        }

        return null;
    }

    //get post image from enclosure
    public function get_post_image_from_enclosure($item)
    {
        $imgURL = "";
        if (!empty($item->get_enclosure())) {
            if (!empty($item->get_enclosure()->get_link())) {
                $imgURL = $item->get_enclosure()->get_link();
            }
        }
        return $imgURL;
    }

    //get post image from og tag
    public function getImageFromOG($item)
    {
        if (!empty($item->get_link())) {
            $metaOGImg = null;
            $response = Feed::httpRequest($item->get_link(), NULL, NULL, NULL);
            if (!empty($response)) {
                $html = new DOMDocument();
                @$html->loadHTML($response);
                foreach ($html->getElementsByTagName('meta') as $meta) {
                    if ($meta->getAttribute('property') == 'og:image') {
                        $metaOGImg = $meta->getAttribute('content');
                    }
                }
            }
            return $metaOGImg;
        }
        return "";
    }

    //get post image from description
    public function getImageFromText($item)
    {
        try {
            $text = $item->get_description();
            return Feed::getImgFromText($text);
        } catch (Exception $e) {
            return false;
        }
    }

    //get post image from og tag embed
    public function getImageFromEmbedOG($item)
    {
        try {
            $og_img = "";
            if (!empty($item->get_link())) {
                $og_img = Feed::getImgFromOg($item->get_link());
            }
            return $og_img;
        } catch (Exception $e) {
            return false;
        }
    }

}