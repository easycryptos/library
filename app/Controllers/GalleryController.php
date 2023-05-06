<?php

namespace App\Controllers;

use App\Models\GalleryModel;

class GalleryController extends BaseAdminController
{
    protected $galleryModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        checkPermission('gallery');
        $this->galleryModel = new GalleryModel();
    }

    /**
     * Gallery
     */
    public function gallery()
    {
        $data['title'] = trans("gallery");
        $data['images'] = $this->galleryModel->getAllImages();
        $data['albums'] = $this->galleryModel->getAlbumsBySelectedLang();
        
        $data['langSearchColumn'] = 3;

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/gallery', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Image Post
     */
    public function addGalleryImagePost()
    {
        $val = \Config\Services::validation();
        $val->setRule('album_id', trans("album"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->galleryModel->addImage()) {
                $this->session->setFlashdata('success', trans("image") . " " . trans("msg_suc_added"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('gallery'));
    }

    /**
     * Edit Image
     */
    public function editGalleryImage($id)
    {
        $data['title'] = trans("update_image");
        $data['image'] = $this->galleryModel->getImage($id);
        if (empty($data['image'])) {
            return redirect()->back();
        }
        
        $data['albums'] = $this->galleryModel->getAlbumsByLang($data['image']->lang_id);
        $data['categories'] = $this->galleryModel->getCategoriesByAlbum($data['image']->album_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/edit', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Image Post
     */
    public function editGalleryImagePost()
    {
        $val = \Config\Services::validation();
        $val->setRule('album_id', trans("album"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            if ($this->galleryModel->editImage($id)) {
                $this->session->setFlashdata('success', trans("image") . " " . trans("msg_suc_updated"));
                return redirect()->to(adminUrl('gallery'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Delete Image Post
     */
    public function deleteGalleryImagePost()
    {
        $id = inputPost('id');
        if ($this->galleryModel->deleteImage($id)) {
            $this->session->setFlashdata('success', trans("image") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * -----------------------------------------------------------------------------------------------------------
     * ALBUMS
     * -----------------------------------------------------------------------------------------------------------
     */

    /**
     * Albums
     */
    public function galleryAlbums()
    {
        $data['title'] = trans("albums");
        $data['categories'] = $this->galleryModel->getAlbums();
        
        $data['langSearchColumn'] = 2;

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/albums', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Album Post
     */
    public function addGalleryAlbumPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("album_name"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->galleryModel->addAlbum()) {
                $this->session->setFlashdata('success', trans("album") . " " . trans("msg_suc_added"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Edit Gallery Album
     */
    public function editGalleryAlbum($id)
    {
        $data['title'] = trans("update_album");
        $data['album'] = $this->galleryModel->getAlbum($id);
        
        if (empty($data['album'])) {
            return redirect()->back();
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/edit_album', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Gallery Album Post
     */
    public function editGalleryAlbumPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("album_name"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            if ($this->galleryModel->editAlbum($id)) {
                $this->session->setFlashdata('success', trans("album") . " " . trans("msg_suc_updated"));
                return redirect()->to(adminUrl('gallery-albums'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->back();
            }
        }
    }

    /**
     * Delete Gallery Album Post
     */
    public function deleteGalleryAlbumPost()
    {
        $id = inputPost('id');
        //check if album has categories
        if ($this->galleryModel->getCategoryCountByAlbum($id) > 0) {
            $this->session->setFlashdata('error', trans("msg_delete_album"));
            exit();
        }
        if ($this->galleryModel->deleteAlbum($id)) {
            $this->session->setFlashdata('success', trans("album") . " " . trans("msg_suc_deleted"));
            exit();
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        exit();
    }

    //get albums by lang
    public function galleryAlbumsByLang()
    {
        $langId = inputPost('lang_id');
        if (!empty($langId)) {
            $albums = $this->galleryModel->getAlbumsByLang($langId);
            if (!empty($albums)) {
                foreach ($albums as $item) {
                    echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                }
            }
        }
    }

    //set as album cover
    public function setAsAlbumCover()
    {
        $imageId = inputPost('image_id');
        $this->galleryModel->setAsAlbumCover($imageId);
    }

    /**
     * -----------------------------------------------------------------------------------------------------------
     * CATEGORIES
     * -----------------------------------------------------------------------------------------------------------
     */

    /**
     * Gallery Categories
     */
    public function galleryCategories()
    {
        $data['title'] = trans("gallery_categories");
        $data['albums'] = $this->galleryModel->getAlbumsBySelectedLang();
        $data['categories'] = $this->galleryModel->getCategories();
        
        $data['langSearchColumn'] = 2;

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/categories', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Gallery Category Post
     */
    public function addGalleryCategoryPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("category_name"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->galleryModel->addCategory()) {
                $this->session->setFlashdata('success', trans("category") . " " . trans("msg_suc_added"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Edit Gallery Category
     */
    public function editGallerCategory($id)
    {
        $data['title'] = trans("update_category");
        $data['category'] = $this->galleryModel->getCategory($id);
        
        if (empty($data['category'])) {
            return redirect()->back();
        }
        $data['albums'] = $this->galleryModel->getAlbumsByLang($data['category']->lang_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/gallery/edit_category', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Gallery Category Post
     */
    public function editGalleryCategoryPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("category_name"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            if ($this->galleryModel->editCategory($id)) {
                $this->session->setFlashdata('success', trans("category") . " " . trans("msg_suc_updated"));
                return redirect()->to(adminUrl('gallery-categories'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Delete Gallery Category Post
     */
    public function deleteGalleryCategoryPost()
    {
        $id = inputPost('id');
        //check if category has posts
        if ($this->galleryModel->getImageCountByCategory($id) > 0) {
            $this->session->setFlashdata('error', trans("msg_delete_images"));
            exit();
        }
        if ($this->galleryModel->deleteCategory($id)) {
            $this->session->setFlashdata('success', trans("category") . " " . trans("msg_suc_deleted"));
            exit();
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        exit();
    }

    //get categories by album
    public function galleryCategoriesByAlbum()
    {
        $categoryId = inputPost('category_id');
        if (!empty($categoryId)) {
            $categories = $this->galleryModel->getCategoriesByAlbum($categoryId);
            if (!empty($categories)) {
                foreach ($categories as $item) {
                    echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                }
            }
        }
    }
}
