<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\FileModel;

class FileController extends BaseAdminController
{
    protected $fileModel;
    protected $fileCount;
    protected $filePerPage;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->fileModel = new FileModel();
        $this->fileCount = 60;
        $this->filePerPage = 60;
    }

    /*
    *------------------------------------------------------------------------------------------
    * IMAGES
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload Image File
     */
    public function uploadImageFile()
    {
        $this->fileModel->uploadImage();
    }

    /**
     * Get Images
     */
    public function getImages()
    {
        $images = $this->fileModel->getImages($this->fileCount);
        $this->printImages($images);
    }

    /**
     * Select Image File
     */
    public function selectImageFile()
    {
        $fileId = inputPost('file_id');
        $file = $this->fileModel->getImage($fileId);
        if (!empty($file)) {
            echo base_url($file->image_mid);
        }
    }

    /**
     * Laod More Images
     */
    public function loadMoreImages()
    {
        $lastId = inputPost('last_id');
        $images = $this->fileModel->getMoreImages($lastId, $this->filePerPage);
        $this->printImages($images);
    }

    /**
     * Search Images
     */
    public function searchImageFile()
    {
        $search = inputPost('search');
        $images = $this->fileModel->searchImages($search);
        $this->printImages($images);
    }

    /**
     * Print Images
     */
    public function printImages($images)
    {
        if (!empty($images)) {
            foreach ($images as $image) {
                echo '<div class="col-file-manager" id="img_col_id_' . $image->id . '">';
                echo '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . $image->image_mid . '" data-file-path-editor="' . $image->image_big . '">';
                echo '<div class="image-container">';
                echo '<img src="' . base_url() . '/' . $image->image_slider . '" alt="" class="img-responsive">';
                echo '</div>';
                if (!empty($image->file_name)):
                    echo '<span class="file-name">' . limitCharacter($image->file_name . "." . $image->image_mime, 25, "..") . '</span>';
                endif;
                echo '</div> </div>';
            }
        }
    }

    /**
     * Delete File
     */
    public function deleteImageFile()
    {
        $fileId = inputPost('file_id');
        $this->fileModel->deleteImage($fileId);
    }

    /*
    *------------------------------------------------------------------------------------------
    * FILES
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload File
     */
    public function uploadFile()
    {
        $this->fileModel->UploadFile();
    }

    /**
     * Get Files
     */
    public function getFiles()
    {
        $files = $this->fileModel->getFiles($this->fileCount);
        $this->printFiles($files);
    }

    /**
     * Laod More Files
     */
    public function loadMoreFiles()
    {
        $lastId = inputPost('last_id');
        $files = $this->fileModel->getMoreFiles($lastId, $this->filePerPage);
        $this->printFiles($files);
    }

    /**
     * Search Files
     */
    public function searchFile()
    {
        $search = inputPost('search', true);
        $files = $this->fileModel->searchFiles($search);
        $this->printFiles($files);
    }

    /**
     * Print Files
     */
    public function printFiles($files)
    {
        if (!empty($files)) {
            foreach ($files as $file) {
                echo '<div class="col-file-manager" id="file_col_id_' . $file->id . '">';
                echo '<div class="file-box" data-file-id="' . $file->id . '" data-file-name="' . $file->file_name . '">';
                echo '<div class="image-container icon-container">';
                echo '<div class="file-icon file-icon-lg" data-type="' . @pathinfo($file->file_name, PATHINFO_EXTENSION) . '"></div>';
                echo '</div>';
                echo '<span class="file-name">' . limitCharacter($file->file_name, 25, "..") . '</span>';
                echo '</div> </div>';
            }
        }
    }

    /**
     * Delete File
     */
    public function deleteFile()
    {
        $fileId = inputPost('file_id');
        $this->fileModel->deleteFile($fileId);
    }

    /**
     * Download File
     */
    public function downloadFile()
    {
        $path = inputPost('path');
        if(!empty($path)){
            $path = str_replace('../', '', $path);
            if (file_exists($path)) {
                return $this->response->download($path, null);
            }
        }
    }
}
