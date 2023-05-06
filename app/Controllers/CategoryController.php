<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\PostAdminModel;

class CategoryController extends BaseAdminController
{
    protected $categoryModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Categories
     */
    public function categories()
    {
        checkPermission('categories');
        $data['title'] = trans("categories");
        
        $data['categories'] = $this->categoryModel->getParentCategories();
        $data['langSearchColumn'] = 2;

        echo view('admin/includes/_header', $data);
        echo view('admin/category/categories', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Category Post
     */
    public function addCategoryPost()
    {
        checkPermission('categories');
        $val = \Config\Services::validation();
        $val->setRule('name', trans("category_name"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->categoryModel->addCategory()) {
                $this->session->setFlashdata('success', trans("category") . " " . trans("msg_suc_added"));
                return redirect()->back();
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Update Category
     */
    public function editCategory($id)
    {
        checkPermission('categories');
        $data['title'] = trans("update_category");
        $data['category'] = $this->categoryModel->getCategory($id);
        
        if (empty($data['category'])) {
            return redirect()->back();
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/category/update_category', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Category Post
     */
    public function editCategoryPost()
    {
        checkPermission('categories');
        $val = \Config\Services::validation();
        $val->setRule('name', trans("category_name"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            $redirectUrl = inputPost('redirect_url');
            if ($this->categoryModel->editCategory($id)) {
                $this->session->setFlashdata('success', trans("category") . " " . trans("msg_suc_updated"));
                if (!empty($redirectUrl)) {
                    return redirect()->to(adminUrl($redirectUrl));
                }
                return redirect()->to(adminUrl('categories'));
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Subcategories
     */
    public function subcategories()
    {
        checkPermission('categories');
        $data['title'] = trans("subcategories");
        $data['categories'] = $this->categoryModel->getAllSubcategories();
        $data['parentCategories'] = $this->categoryModel->getParentCategoriesByLang($this->activeLang->id);
        
        $data['langSearchColumn'] = 2;

        echo view('admin/includes/_header', $data);
        echo view('admin/category/subcategories', $data);
        echo view('admin/includes/_footer');
    }


    /**
     * Add Subcategory Post
     */
    public function addSubcategoryPost()
    {
        checkPermission('categories');
        $val = \Config\Services::validation();
        $val->setRule('name', trans("category_name"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->categoryModel->addSubCategory()) {
                $this->session->setFlashdata('success', trans("category") . " " . trans("msg_suc_added"));
                return redirect()->back();
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }


    /**
     * Edit Subcategory
     */
    public function editSubcategory($id)
    {
        checkPermission('categories');
        $data['title'] = trans("update_category");
        
        $data['category'] = $this->categoryModel->getCategory($id);
        if (empty($data['category'])) {
            return redirect()->back();
        }
        $data['parentCategories'] = $this->categoryModel->getParentCategoriesByLang($data['category']->lang_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/category/update_subcategory', $data);
        echo view('admin/includes/_footer');
    }


    /**
     * Edit Subcategory Post
     */
    public function editSubcategoryPost()
    {
        checkPermission('categories');
        $val = \Config\Services::validation();
        $val->setRule('name', trans("category_name"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            if ($this->categoryModel->editCategory($id)) {
                $this->session->setFlashdata('success', trans("category") . " " . trans("msg_suc_updated"));
                return redirect()->to(adminUrl('subcategories'));
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    //get parent categories by language
    public function getParentCategoriesByLang()
    {
        $langId = inputPost('lang_id');
        if (!empty($langId)):
            $categories = $this->categoryModel->getParentCategoriesByLang($langId);
            if (!empty($categories)) {
                foreach ($categories as $item) {
                    echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                }
            }
        endif;
    }

    //get subcategories
    public function getSubCategories()
    {
        $parentId = inputPost('parent_id');
        if (!empty($parentId)):
            $subCategories = $this->categoryModel->getAllSubcategoriesByParentId($parentId);
            if (!empty($subCategories)) {
                foreach ($subCategories as $item) {
                    echo '<option value="' . $item->id . '">' . $item->name . '</option>';
                }
            }
        endif;
    }

    /**
     * Delete Category Post
     */
    public function deleteCategoryPost()
    {
        checkPermission('categories');
        $id = inputPost('id');
        //check subcategories
        if (itemCount($this->categoryModel->getAllSubcategoriesByParentId($id)) > 0) {
            $this->session->setFlashdata('error', trans("msg_delete_subcategories"));
            exit();
        }
        //check posts
        $postModel = new PostAdminModel();
        if ($postModel->getPostCountByCategory($id) > 0) {
            $this->session->setFlashdata('error', trans("msg_delete_posts"));
            exit();
        }
        if ($this->categoryModel->deleteCategory($id)) {
            $this->session->setFlashdata('success', trans("category") . " " . trans("msg_suc_deleted"));
            exit();
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
            exit();
        }
    }
}
