<?php namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('pages');
    }

    //input values
    public function inputValues()
    {
        return [
            'lang_id' => inputPost('lang_id'),
            'title' => inputPost('title'),
            'slug' => inputPost('slug'),
            'page_description' => inputPost('page_description'),
            'page_keywords' => inputPost('page_keywords'),
            'page_content' => inputPost('page_content'),
            'page_order' => inputPost('page_order'),
            'parent_id' => inputPost('parent_id'),
            'page_active' => inputPost('page_active'),
            'title_active' => inputPost('title_active'),
            'breadcrumb_active' => inputPost('breadcrumb_active'),
            'right_column_active' => inputPost('right_column_active'),
            'need_auth' => inputPost('need_auth'),
            'location' => inputPost('location')
        ];
    }

    //add page
    public function addPage()
    {
        $data = $this->inputValues();
        if (empty($data["slug"])) {
            $data["slug"] = strSlug($data["title"]);
            if (empty($data["slug"])) {
                $data["slug"] = "page-" . uniqid();
            }
        }
        $data["created_at"] = date('Y-m-d H:i:s');
        return $this->builder->insert($data);
    }

    //edit page
    public function editPage($id)
    {
        $data = $this->inputValues();
        if (empty($data["slug"])) {
            $data["slug"] = strSlug($data["title"]);
            if (empty($data["slug"])) {
                $data["slug"] = "page-" . uniqid();
            }
        }
        $page = $this->getPage($id);
        if (!empty($page)) {
            return $this->builder->where('id', $page->id)->update($data);
        }
        return false;
    }

    //get pages
    public function getPages()
    {
        return $this->builder->orderBy('page_order')->get()->getResult();
    }

    //get pages by language
    public function getPagesByLang()
    {
        return $this->builder->where('lang_id', cleanNumber($this->activeLangId))->orderBy('page_order')->get()->getResult();
    }

    //get page
    public function getPageBySlug($slug)
    {
        return $this->builder->where('slug', cleanSlug($slug))->get()->getRow();
    }

    //get page by lang
    public function getPageByLang($slug, $langId)
    {
        return $this->builder->where('lang_id', cleanNumber($langId))->where('slug', cleanSlug($slug))->get()->getRow();
    }

    //get page by id
    public function getPage($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //delete page
    public function deletePage($id)
    {
        $page = $this->getPage($id);
        if (!empty($page)) {
            return $this->builder->where('id', $page->id)->delete();
        }
        return false;
    }
}
