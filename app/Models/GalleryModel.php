<?php namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends BaseModel
{
    protected $builder;
    protected $builderAlbums;
    protected $builderCategories;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('photos');
        $this->builderAlbums = $this->db->table('gallery_albums');
        $this->builderCategories = $this->db->table('gallery_categories');
    }

    //input values
    public function inputValues()
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'album_id' => 0,
            'category_id' => 0,
            'title' => inputPost('title'),
            'path_big' => inputPost('path_big'),
            'path_small' => inputPost('path_small')
        ];
        if (!empty(inputPost('album_id'))) {
            $data['album_id'] = inputPost('album_id');
        }
        if (!empty(inputPost('category_id'))) {
            $data['category_id'] = inputPost('category_id');
        }
        $data["created_at"] = date('Y-m-d H:i:s');
        return $data;
    }

    //add image
    public function addImage()
    {
        $data = $this->inputValues();
        $data['is_album_cover'] = 0;
        if (!empty($_FILES['files'])) {
            $uploadModel = new UploadModel();
            $fileCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                if (isset($_FILES['files']['name'])) {
                    $tmpFilePath = $_FILES['files']['tmp_name'][$i];
                    if (isset($tmpFilePath)) {
                        $ext = $uploadModel->getFileExtension($_FILES['files']['name'][$i]);
                        $newName = 'img_temp_' . generateToken() . '.' . $ext;
                        $newPath = FCPATH . "uploads/temp/" . $newName;
                        if (move_uploaded_file($tmpFilePath, FCPATH . "uploads/temp/" . $newName)) {
                            if ($ext == 'gif') {
                                $gifPath = $uploadModel->galleryGifImageUpload($newName);
                                $data["path_big"] = $gifPath;
                                $data["path_small"] = $gifPath;
                            } else {
                                $data["path_big"] = $uploadModel->galleryBigImageUpload($newPath);
                                $data["path_small"] = $uploadModel->gallerySmallImageUpload($newPath);
                            }
                        }
                        $db = \Config\Database::connect(null, false);
                        $db->table('photos')->insert($data);
                        $db->close();
                        $uploadModel->deleteTempFile($newPath);
                    }
                }
            }
            return true;
        }
        return false;
    }

    //edit image
    public function editImage($id)
    {
        $data = $this->inputValues();
        $uploadModel = new UploadModel();
        $tempData = $uploadModel->uploadTempImage('file');
        if (!empty($tempData)) {
            $tempPath = $tempData['path'];
            if ($tempData['ext'] == 'gif') {
                $gifPath = $uploadModel->galleryGifImageUpload($tempData['name']);
                $data["path_big"] = $gifPath;
                $data["path_small"] = $gifPath;
            } else {
                $data["path_big"] = $uploadModel->galleryBigImageUpload($tempPath);
                $data["path_small"] = $uploadModel->gallerySmallImageUpload($tempPath);
            }
            $uploadModel->deleteTempFile($tempPath);
        }
        return $this->builder->where('id', cleanNumber($id))->update($data);
    }

    //get gallery images
    public function getImages()
    {
        return $this->builder->where('lang_id', $this->activeLangId)->orderBy('id', 'DESC')->get()->getResult();
    }

    //get all gallery images
    public function getAllImages()
    {
        $this->builder->select('photos.*, (SELECT name FROM gallery_albums WHERE id = photos.album_id) AS album_name, (SELECT name FROM gallery_categories WHERE id = photos.category_id) AS category_name');
        return $this->builder->orderBy('id', 'DESC')->get()->getResult();
    }

    //get gallery images by album
    public function getImagesByAlbum($albumId)
    {
        return $this->builder->where('album_id', cleanNumber($albumId))->orderBy('id', 'DESC')->get()->getResult();
    }

    //get category image count
    public function getImageCountByCategory($categoryId)
    {
        return $this->builder->where('category_id', cleanNumber($categoryId))->countAllResults();
    }

    //set as album cover
    public function setAsAlbumCover($id)
    {
        $image = $this->getImage($id);
        if (!empty($image)) {
            $data = [
                'is_album_cover' => 0
            ];
            $this->builder->where('album_id', $image->album_id)->update($data);
            $data = [
                'is_album_cover' => 1
            ];
            $this->builder->where('id', $id)->update($data);
        }
    }

    //get gallery album cover image
    public function getGalleryCoverImage($album_id)
    {
        $row = $this->builder->where('album_id', cleanNumber($album_id))->where('is_album_cover', 1)->orderBy('id', 'DESC')->get()->getRow();
        if (empty($row)) {
            $row = $this->builder->where('album_id', cleanNumber($album_id))->orderBy('id', 'DESC')->get()->getRow();
        }
        return $row;
    }

    //get image
    public function getImage($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //delete image
    public function deleteImage($id)
    {
        $image = $this->getImage($id);
        if (!empty($image)) {
            deleteFileFromServer($image->path_big);
            deleteFileFromServer($image->path_small);
            return $this->builder->where('id', $image->id)->delete();
        }
        return false;
    }

    /**
     * --------------------------------------------------------------------
     * Albums
     * --------------------------------------------------------------------
     */

    //add album
    public function addAlbum()
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'name' => inputPost('name'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->builderAlbums->insert($data);
    }

    //edit album
    public function editAlbum($id)
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'name' => inputPost('name')
        ];
        return $this->builderAlbums->where('id', cleanNumber($id))->update($data);
    }

    //get album
    public function getAlbum($id)
    {
        return $this->builderAlbums->where('id', cleanNumber($id))->get()->getRow();
    }

    //get albums
    public function getAlbums()
    {
        return $this->builderAlbums->get()->getResult();
    }

    //get albums by selected lang
    public function getAlbumsBySelectedLang()
    {
        return $this->builderAlbums->where('lang_id', cleanNumber($this->activeLangId))->get()->getResult();
    }

    //get albums by lang
    public function getAlbumsByLang($langId)
    {
        return $this->builderAlbums->where('lang_id', cleanNumber($langId))->get()->getResult();
    }

    //delete album
    public function deleteAlbum($id)
    {
        $album = $this->getAlbum($id);
        if (!empty($album)) {
            return $this->builderAlbums->where('id', $album->id)->delete();
        }
        return false;
    }

    /**
     * --------------------------------------------------------------------
     * Categories
     * --------------------------------------------------------------------
     */

    //add category
    public function addCategory()
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'album_id' => inputPost('album_id'),
            'name' => inputPost('name'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->builderCategories->insert($data);
    }

    //add category
    public function editCategory($id)
    {
        $data = [
            'lang_id' => inputPost('lang_id'),
            'album_id' => inputPost('album_id'),
            'name' => inputPost('name')
        ];
        return $this->builderCategories->where('id', cleanNumber($id))->update($data);
    }

    //get category
    public function getCategory($id)
    {
        return $this->builderCategories->where('id', cleanNumber($id))->get()->getRow();
    }

    //get all gallery categories
    public function getCategories()
    {
        $this->builderCategories->select('gallery_categories.*, (SELECT name FROM gallery_albums WHERE gallery_albums.id = gallery_categories.album_id) AS album_name');
        return $this->builderCategories->get()->getResult();
    }

    //get gallery categories by album
    public function getCategoriesByAlbum($albumId)
    {
        return $this->builderCategories->where('album_id', cleanNumber($albumId))->get()->getResult();
    }

    //get album category count
    public function getCategoryCountByAlbum($albumId)
    {
        return $this->builderCategories->where('album_id', cleanNumber($albumId))->where('lang_id', $this->activeLangId)->countAllResults();
    }

    //delete category
    public function deleteCategory($id)
    {
        $category = $this->getCategory($id);
        if (!empty($category)) {
            return $this->builderCategories->where('id', $category->id)->delete();
        }
        return false;
    }
}
