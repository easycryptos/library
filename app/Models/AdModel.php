<?php namespace App\Models;

use CodeIgniter\Model;

class AdModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('ad_spaces');
    }

    //update ad spaces
    public function updateAdSpaces($id)
    {
        $adSpace = $this->getAdSpaceById($id);
        if (!empty($adSpace)) {
            $uploadModel = new UploadModel();
            $data = [
                'ad_code_desktop' => inputPost('ad_code_desktop'),
                'ad_code_mobile' => inputPost('ad_code_mobile'),
                'desktop_width' => inputPost('desktop_width'),
                'desktop_height' => inputPost('desktop_height'),
                'mobile_width' => inputPost('mobile_width'),
                'mobile_height' => inputPost('mobile_height')
            ];
            $adURL = inputPost('url_ad_code_desktop');
            $file = $uploadModel->adUpload('file_ad_code_desktop');
            if (!empty($file) && !empty($file['path'])) {
                $data['ad_code_desktop'] = $this->createAdCode($adURL, $file['path'], $data['desktop_width'], $data['desktop_height']);
            }
            $adURL = inputPost('url_ad_code_mobile');
            $file = $uploadModel->adUpload('file_ad_code_mobile');
            if (!empty($file) && !empty($file['path'])) {
                $data['ad_code_mobile'] = $this->createAdCode($adURL, $file['path'], $data['mobile_width'], $data['mobile_height']);
            }
            if ($adSpace->ad_space == 'in_article_1' || $adSpace->ad_space == 'in_article_2') {
                $data['paragraph_number'] = inputPost('paragraph_number');
            }
            return $this->builder->where('id', $adSpace->id)->update($data);
        }
        return false;
    }

    //get ad spaces
    public function getAdSpaces()
    {
        return $this->builder->get()->getResult();
    }

    //get ad spaces by lang
    public function getAdSpacesByLang($langId)
    {
        return $this->builder->where('lang_id', cleanNumber($langId))->get()->getResult();
    }

    //get ad spaces by id
    public function getAdSpaceById($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get ad space
    public function getAdSpace($langId, $adSpace)
    {
        $row = $this->builder->where('lang_id', cleanNumber($langId))->where('ad_space', cleanStr($adSpace))->get()->getRow();
        if (!empty($row)) {
            return $row;
        }
        $data = [
            'lang_id' => cleanNumber($langId),
            'ad_space' => strSlug($adSpace),
            'ad_code_desktop' => '',
            'desktop_width' => 728,
            'desktop_height' => 90,
            'ad_code_mobile' => '',
            'mobile_width' => 300,
            'mobile_height' => 250,
            'mobile_width' => 300,
        ];
        if ($adSpace == 'sidebar_1' || $adSpace == 'sidebar_2') {
            $data['desktop_width'] = 336;
            $data['desktop_height'] = 280;
        }
        $this->builder->insert($data);
        return $this->builder->where('lang_id', cleanNumber($langId))->where('ad_space', cleanStr($adSpace))->get()->getRow();
    }

    //create ad code
    public function createAdCode($url, $imgPath, $width, $height)
    {
        return '<a href="' . $url . '" aria-label="link-bn'.'"><img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="' . base_url($imgPath) . '" width="' . $width . '" height="' . $height . '" alt="" class="lazyload"></a>';
    }

    //update google adsense code
    public function updateGoogleAdsenseCode()
    {
        $data = [
            'google_adsense_code' => inputPost('google_adsense_code')
        ];
        return $this->db->table('general_settings')->where('id', 1)->update($data);
    }

}
