<?php

/**
 * Video Class
 */

require APPPATH . 'ThirdParty/video-url-parser/vendor/autoload.php';

use \RicardoFiorani\Matcher\VideoServiceMatcher;

class VideoUrlParser
{
    //get video embed code
    public function getEmbedCode($url)
    {
        try {
            $vsm = new VideoServiceMatcher();
            $video = $vsm->parse($url);
            return $video->getEmbedUrl();
        } catch (\RicardoFiorani\Exception\NotEmbeddableException $e) {
            return null;
        }
    }

    //get video thumbnail
    public function getThumbnail($url)
    {
        try {
            $vsm = new VideoServiceMatcher();
            $video = $vsm->parse($url);
            $thumbnail = $video->getLargestThumbnail();
            if (empty($thumbnail)) {
                $thumbnail = $video->getSmallThumbnail();
            }
            return $thumbnail;
        } catch (\RicardoFiorani\Exception\NotEmbeddableException $e) {
            return null;
        }
    }
}
