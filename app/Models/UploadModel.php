<?php

namespace App\Models;

require_once APPPATH . "ThirdParty/intervention-image/vendor/autoload.php";

use CodeIgniter\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;


class UploadModel extends BaseModel
{
    protected $quality;

    public function __construct()
    {
        parent::__construct();
        $this->quality = 85;
    }

    //upload file
    public function upload($inputName, $directory, $namePrefix, $allowedExtensions = null, $keepOrjName = false)
    {
        if ($allowedExtensions != null && is_array($allowedExtensions) && !empty($allowedExtensions[0])) {
            if (!$this->checkAllowedFileTypes($inputName, $allowedExtensions)) {
                return null;
            }
        }
        $file = $this->request->getFile($inputName);
        if (!empty($file) && !empty($file->getName())) {
            $orjName = $file->getName();
            $ext = $this->getFileExtension($file->getName());
            $newName = $namePrefix . generateToken() . '.' . $ext;
            if ($keepOrjName == true) {
                if (file_exists(FCPATH . $directory . '/' . $orjName)) {
                    $orjName = pathinfo($orjName, PATHINFO_FILENAME) . '-' . uniqid() . '.' . pathinfo($orjName, PATHINFO_EXTENSION);
                }
                $newName = $orjName;
            }
            $path = $directory . $newName;
            if (!$file->hasMoved()) {
                if ($file->move(FCPATH . $directory, $newName)) {
                    return ['name' => $newName, 'orj_name' => $orjName, 'path' => $path, 'ext' => $ext];
                }
            }
        }
        return null;
    }

    //upload temp image
    public function uploadTempImage($inputName)
    {
        return $this->upload($inputName, "uploads/temp/", "img_temp_", ['jpg', 'jpeg', 'png', 'gif']);
    }

    //upload temp file
    public function uploadTempFile($inputName)
    {
        return $this->upload($inputName, "uploads/temp/", "file_temp_");
    }

    //upload file
    public function uploadFile($inputName)
    {
        $extArray = @explode(',', $this->generalSettings->allowed_file_extensions ?? '');
        return $this->upload($inputName, "uploads/files/", "file_", $extArray, true);
    }

    //post gif image upload
    public function postGifImageupload($fileName)
    {
        $directory = $this->createUploadDirectory('images');
        rename(FCPATH . 'uploads/temp/' . $fileName, FCPATH . 'uploads/images/' . $directory . $fileName);
        return 'uploads/images/' . $directory . $fileName;
    }

    //post big image upload
    public function postBigImageUpload($path)
    {
        $newName = $this->createUploadDirectory('images') . 'image_750x_' . uniqid() . '.jpg';
        $newPath = 'uploads/images/' . $newName;
        $img = Image::make($path)->orientate();
        $img->resize(750, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save(FCPATH . $newPath, $this->quality);
        return $newPath;
    }

    //post mid image upload
    public function postMidImageUpload($path)
    {
        $newName = $this->createUploadDirectory('images') . 'image_750x415_' . uniqid() . '.jpg';
        $newPath = 'uploads/images/' . $newName;
        $img = Image::make($path)->orientate();
        $img->fit(750, 415);
        $img->save(FCPATH . $newPath, $this->quality);
        return $newPath;
    }

    //post small image upload
    public function postSmallImageUpload($path)
    {
        $newName = $this->createUploadDirectory('images') . 'image_100x75_' . uniqid() . '.jpg';
        $newPath = 'uploads/images/' . $newName;
        $img = Image::make($path)->orientate();
        $img->fit(100, 75);
        $img->save(FCPATH . $newPath, $this->quality);
        return $newPath;
    }

    //post slider image upload
    public function postSliderImageUpload($path)
    {
        $newName = $this->createUploadDirectory('images') . 'image_650x433_' . uniqid() . '.jpg';
        $newPath = 'uploads/images/' . $newName;
        $img = Image::make($path)->orientate();
        $img->fit(650, 433);
        $img->save(FCPATH . $newPath, $this->quality);
        return $newPath;
    }

    //gallery big image upload
    public function galleryBigImageUpload($path)
    {
        $newName = $this->createUploadDirectory('gallery') . 'image_1920x_' . uniqid() . '.jpg';
        $newPath = 'uploads/gallery/' . $newName;
        $img = Image::make($path)->orientate();
        $img->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save(FCPATH . $newPath, $this->quality);
        return $newPath;
    }

    //gallery small image upload
    public function gallerySmallImageUpload($path)
    {
        $newName = $this->createUploadDirectory('gallery') . 'image_500x_' . uniqid() . '.jpg';
        $newPath = 'uploads/gallery/' . $newName;
        $img = Image::make($path)->orientate();
        $img->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(FCPATH . $newPath, $this->quality);
        return $newPath;
    }

    //gallery gif image upload
    public function galleryGifImageUpload($file_name)
    {
        $directory = $this->createUploadDirectory('gallery');
        rename(FCPATH . 'uploads/temp/' . $file_name, FCPATH . 'uploads/gallery/' . $directory . $file_name);
        return 'uploads/gallery/' . $directory . $file_name;
    }

    //logo upload
    public function uploadLogo($inputName)
    {
        return $this->upload($inputName, "uploads/logo/", "logo_", ['jpg', 'jpeg', 'png', 'gif']);
    }

    //favicon upload
    public function uploadFavicon()
    {
        return $this->upload("favicon", "uploads/logo/", "favicon_", ['jpg', 'jpeg', 'png', 'gif']);
    }

    //avatar image upload
    public function uploadAvatar($userId, $path)
    {
        $newName = 'avatar_' . $userId . '_' . uniqid() . '.jpg';
        $newPath = 'uploads/profile/' . $newName;
        $img = Image::make($path)->orientate()->fit(200, 200)->save(FCPATH . $newPath, $this->quality);
        return $newPath;
    }

    //ad upload
    public function adUpload($inputName)
    {
        return $this->upload($inputName, "uploads/blocks/", "block_", ['jpg', 'jpeg', 'png', 'gif']);
    }

    //get file original name
    public function getFileOriginalName($path)
    {
        if (!empty($path)) {
            return pathinfo($path, PATHINFO_FILENAME);
        }
        return '';
    }

    //delete temp file
    public function deleteTempFile($path)
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    //create upload directory
    public function createUploadDirectory($folder)
    {
        $directory = date("Ym");
        $directory_path = FCPATH . 'uploads/' . $folder . '/' . $directory . '/';

        //If the directory doesn't already exists.
        if (!is_dir($directory_path)) {
            //Create directory.
            @mkdir($directory_path, 0755, true);
        }
        //add index.html if does not exist
        if (!file_exists($directory_path . "index.html")) {
            @copy(FCPATH . "uploads/index.html", $directory_path . "index.html");
        }
        return $directory . "/";
    }

    //check allowed file types
    public function checkAllowedFileTypes($fileName, $allowedTypes)
    {
        if (!isset($_FILES[$fileName])) {
            return false;
        }
        if (empty($_FILES[$fileName]['name'])) {
            return false;
        }

        $ext = pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION);
        $ext = strtolower($ext ?? '');

        $extArray = array();
        if (!empty($allowedTypes) && is_array($allowedTypes)) {
            foreach ($allowedTypes as $item) {
                $item = trim($item ?? '', '"');
                $item = trim($item ?? '', "'");
                array_push($extArray, $item);
            }
        }
        if (!empty($extArray) && in_array($ext, $extArray)) {
            return true;
        }
        return false;
    }

    //check allowed file types
    public function getFileExtension($name)
    {
        $ext = "";
        if (!empty($name)) {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $ext = strtolower($ext ?? '');
        }
        return $ext;
    }
}
