<?php namespace App\Models;

use CodeIgniter\Model;

class RssModel extends BaseModel
{
    protected $builder;
    protected $builderPost;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('rss_feeds');
        $this->builderPost = $this->db->table('posts');
    }

    //input values
    public function inputValues()
    {
        return [
            'lang_id' => inputPost('lang_id'),
            'feed_name' => inputPost('feed_name'),
            'feed_url' => inputPost('feed_url'),
            'post_limit' => inputPost('post_limit'),
            'category_id' => inputPost('category_id'),
            'image_saving_method' => inputPost('image_saving_method'),
            'generate_keywords_from_title' => inputPost('generate_keywords_from_title'),
            'auto_update' => inputPost('auto_update'),
            'read_more_button' => inputPost('read_more_button'),
            'read_more_button_text' => inputPost('read_more_button_text'),
            'add_posts_as_draft' => inputPost('add_posts_as_draft')
        ];
    }

    //add feed
    public function addFeed()
    {
        $data = $this->inputValues();
        $subcategoryId = inputPost('subcategory_id');
        if (!empty($subcategoryId)) {
            $data['category_id'] = $subcategoryId;
        }
        $data["is_cron_updated"] = 0;
        $data["user_id"] = user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->builder->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    //update feed
    public function editFeed($id)
    {
        $feed = $this->getFeed($id);
        if (!empty($feed)) {
            $data = $this->inputValues();
            $subcategoryId = inputPost('subcategory_id');
            if (!empty($subcategoryId)) {
                $data['category_id'] = $subcategoryId;
            }
            return $this->builder->where('id', $feed->id)->update($data);
        }
        return false;
    }

    //update feed posts button
    public function updateFeedPostsButton($feedId)
    {
        $feed = $this->getFeed($feedId);
        if (!empty($feed)) {
            $data = [
                'show_post_url' => $feed->read_more_button
            ];
            $this->builderPost->where('feed_id', $feed->id)->update($data);
        }
    }

    //get feed
    public function getFeed($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get feeds
    public function getFeeds()
    {
        return $this->builder->get()->getResult();
    }

    //get feeds cron
    public function getFeedsCron()
    {
        return $this->builder->where('auto_update', 1)->orderBy('is_cron_updated, id')->limit(3)->get()->getResult();
    }

    //get feeds not updated
    public function getFeedsNotUpdated()
    {
        return $this->builder->where('is_cron_updated', 0)->get()->getResult();
    }

    //set feeds as not updated
    public function resetCronFlag()
    {
        $this->builder->update(['is_cron_updated' => 0]);
    }

    //set as feed updated
    public function setFeedAsUpdated($id)
    {
        $this->builder->where('id', cleanNumber($id))->update(['is_cron_updated' => 1]);
    }

    //check post exists
    public function checkPostExists($title, $titleHash)
    {
        if ($this->builderPost->where('title', $title)->orWhere('title_hash', $titleHash)->countAllResults() > 0) {
            return true;
        }
        return false;
    }

    //get feed posts count
    public function getFeedPostsCount($feedId)
    {
        return $this->builderPost->where('feed_id', cleanNumber($feedId))->countAllResults();
    }

    //delete feed
    public function deleteFeed($id)
    {
        $feed = $this->getFeed($id);
        if (!empty($feed)) {
            return $this->builder->where('id', $feed->id)->delete();
        }
        return false;
    }

    //add rss feed posts
    public function addFeedPosts($feedId)
    {
        require_once APPPATH . 'Libraries/RssParser.php';
        $parser = new \RssParser();
        $feed = $this->getFeed($feedId);
        if (!empty($feed)) {
            $response = $parser->getFeeds($feed->feed_url);
            $i = 0;
            if (!empty($response)) {
                foreach ($response as $item) {
                    if ($feed->post_limit == $i) {
                        break;
                    }
                    $title = $this->characterConvert($item->get_title());
                    $description = $this->characterConvert($item->get_description());
                    $content = $this->characterConvert($item->get_content());
                    $titleHash = md5($title ?? '');
                    if ($this->checkPostExists($title, $titleHash) == false) {
                        $data = array();
                        $data['lang_id'] = $feed->lang_id;
                        $data['title'] = $title;
                        $data['title_slug'] = strSlug($title);
                        $data['title_hash'] = $titleHash;
                        $data['summary'] = strip_tags($description ?? '');
                        if (empty($data['summary'])) {
                            $summary = strip_tags($content ?? '');
                            $summary = trim($summary ?? '');
                            $data['summary'] = limitCharacter($summary, 240, '...');
                        }
                        $data['content'] = $content;
                        $data['keywords'] = '';
                        if ($feed->generate_keywords_from_title == 1) {
                            $data['keywords'] = generateKeywordsFromTitle($data['title']);
                        }
                        $data['user_id'] = $feed->user_id;
                        $data['category_id'] = $feed->category_id;
                        $data['is_slider'] = 0;
                        $data['is_picked'] = 0;
                        $data['hit'] = 0;
                        $data['slider_order'] = 1;
                        $data['optional_url'] = "";
                        $data['post_type'] = "post";
                        $data['video_url'] = "";
                        $data['video_embed_code'] = "";
                        $data['image_url'] = "";
                        $data['need_auth'] = 0;
                        $data['feed_id'] = $feed->id;
                        $data['post_url'] = $item->get_link();
                        $data['show_post_url'] = $feed->read_more_button;
                        $data['visibility'] = 1;
                        if ($feed->add_posts_as_draft == 1) {
                            $data['status'] = 0;
                        } else {
                            $data['status'] = 1;
                        }
                        $data['created_at'] = date('Y-m-d H:i:s');
                        //add image
                        if ($feed->image_saving_method == "download") {
                            $dataImage = $parser->getImage($item, true);
                            if (!empty($dataImage) && is_array($dataImage)) {
                                $data['image_big'] = $dataImage['image_big'];
                                $data['image_mid'] = $dataImage['image_mid'];
                                $data['image_small'] = $dataImage['image_small'];
                                $data['image_slider'] = $dataImage['image_slider'];
                                $data['image_mime'] = "jpg";
                                $dataImage['file_name'] = $data['title_slug'];
                                $dataImage['user_id'] = $feed->user_id;
                                $db = \Config\Database::connect(null, false);
                                $db->table('images')->insert($dataImage);
                                $db->close();
                            }
                        } else {
                            $data['image_url'] = $parser->getImage($item, false);
                        }
                        $this->builderPost->insert($data);
                        $postAdminModel = new PostAdminModel();
                        $postAdminModel->updateSlug($this->db->insertID());
                    }
                    $i++;
                }

                //delete dublicated posts
                $sql = "SELECT title_hash FROM posts GROUP BY title_hash HAVING COUNT(title_hash) > 1";
                $query = $this->db->query($sql);
                $postTitleHashs = $query->getResult();
                if (!empty($postTitleHashs)) {
                    foreach ($postTitleHashs as $titleHash) {
                        $this->builderPost->where('title_hash', $titleHash->title_hash)->orderBy('id', 'DESC')->limit(1)->delete();
                    }
                }
                return true;
            }
        }
    }

    //convert character
    public function characterConvert($str)
    {
        $str = trim($str ?? '');
        $str = str_replace("&amp;", "&", $str ?? '');
        $str = str_replace("&lt;", "<", $str ?? '');
        $str = str_replace("&gt;", ">", $str ?? '');
        $str = str_replace("&quot;", '"', $str ?? '');
        $str = str_replace("&apos;", "'", $str ?? '');
        return $str;
    }

}
