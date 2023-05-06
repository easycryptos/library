<?php namespace App\Models;

use CodeIgniter\Model;

class FileModel extends BaseModel
{
    protected $uploadModel;
    protected $builderImages;
    protected $builderFiles;

    public function __construct()
    {
        parent::__construct();
        $this->uploadModel = new UploadModel();
        $this->builderImages = $this->db->table('images');
        $this->builderFiles = $this->db->table('files');
    }

    /*
    *------------------------------------------------------------------------------------------
    * IMAGES
    *------------------------------------------------------------------------------------------
    */

    //upload image
    public function uploadImage()
    {
        $tempData = $this->uploadModel->uploadTempImage('file');
        if (!empty($tempData)) {
            $tempPath = $tempData['path'];
            if ($tempData['ext'] == 'gif') {
                $gifPath = $this->uploadModel->postGifImageupload($tempData['name']);
                $data["image_big"] = $gifPath;
                $data["image_mid"] = $gifPath;
                $data["image_small"] = $gifPath;
                $data["image_slider"] = $gifPath;
                $data["image_mime"] = 'gif';
                $data["file_name"] = $tempData['orj_name'];
            } else {
                $data["image_big"] = $this->uploadModel->postBigImageUpload($tempPath);
                $data["image_mid"] = $this->uploadModel->postMidImageUpload($tempPath);
                $data["image_small"] = $this->uploadModel->postSmallImageUpload($tempPath);
                $data["image_slider"] = $this->uploadModel->postSliderImageUpload($tempPath);
                $data["image_mime"] = 'jpg';
                $data["file_name"] = $tempData['orj_name'];
            }
            $data['user_id'] = user()->id;
            $db = \Config\Database::connect(null, false);
            $db->table('images')->insert($data);
            $db->close();
            $this->uploadModel->deleteTempFile($tempPath);
        }
    }

    //get image
    public function getImage($id)
    {
        return $this->builderImages->where('id', cleanNumber($id))->get()->getRow();
    }

    //get images
    public function getImages($limit)
    {
        if ($this->generalSettings->file_manager_show_all_files != 1) {
            $this->builderImages->where('user_id', user()->id);
        }
        return $this->builderImages->orderBy('id', 'DESC')->get($limit)->getResult();
    }

    //get more images
    public function getMoreImages($lastId, $limit)
    {
        if ($this->generalSettings->file_manager_show_all_files != 1) {
            $this->builderImages->where('user_id', user()->id);
        }
        return $this->builderImages->where('id <', cleanNumber($lastId))->orderBy('id', 'DESC')->get($limit)->getResult();
    }

    //search images
    public function searchImages($search)
    {
        if ($this->generalSettings->file_manager_show_all_files != 1) {
            $this->builderImages->where('user_id', user()->id);
        }
        return $this->builderImages->like('file_name', cleanStr($search))->orderBy('id', 'DESC')->get()->getResult();
    }

    //delete image
    public function deleteImage($id)
    {
        $image = $this->getImage($id);
        if ($this->generalSettings->file_manager_show_all_files != 1) {
            if ($image->user_id != user()->id) {
                return false;
            }
        }
        if (!empty($image)) {
            deleteFileFromServer($image->image_big);
            deleteFileFromServer($image->image_mid);
            deleteFileFromServer($image->image_small);
            deleteFileFromServer($image->image_slider);
            $this->builderImages->where('id', $image->id)->delete();
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * FILES
    *------------------------------------------------------------------------------------------
    */

    //upload file
    public function UploadFile()
    {
        $file = $this->uploadModel->uploadFile('file');
        if (!empty($file)) {
            $data["file_name"] = $file['orj_name'];
            $data['user_id'] = user()->id;
            $db = \Config\Database::connect(null, false);
            $db->table('files')->insert($data);
            $db->close();
        }
    }

    //get files
    public function getFiles($limit)
    {
        if ($this->generalSettings->file_manager_show_all_files != 1) {
            $this->builderFiles->where('user_id', user()->id);
        }
        return $this->builderFiles->orderBy('id', 'DESC')->get($limit)->getResult();
    }

    //get file
    public function getFile($id)
    {
        return $this->builderFiles->where('id', cleanNumber($id))->get()->getRow();
    }

    //get more files
    public function getMoreFiles($lastId, $limit)
    {
        if ($this->generalSettings->file_manager_show_all_files != 1) {
            $this->builderFiles->where('user_id', user()->id);
        }
        return $this->builderFiles->where('id <', cleanNumber($lastId))->orderBy('id', 'DESC')->get($limit)->getResult();
    }

    //search files
    public function searchFiles($search)
    {
        if ($this->generalSettings->file_manager_show_all_files != 1) {
            $this->builderFiles->where('user_id', user()->id);
        }
        return $this->builderFiles->like('file_name', cleanStr($search))->orderBy('id', 'DESC')->get()->getResult();
    }

    //delete file
    public function deleteFile($id)
    {
        $file = $this->getFile($id);
        if ($this->generalSettings->file_manager_show_all_files != 1) {
            if ($file->user_id != user()->id) {
                return false;
            }
        }
        if (!empty($file)) {
            deleteFileFromServer("uploads/files/" . $file->file_name);
            return $this->builderFiles->where('id', cleanNumber($id))->delete();
        }
        return false;
    }
}
