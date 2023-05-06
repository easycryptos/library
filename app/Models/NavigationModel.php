<?php namespace App\Models;

use CodeIgniter\Model;

class NavigationModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    //input values
    public function inputValues()
    {
        return [
            'lang_id' => inputPost('lang_id'),
            'title' => inputPost('title'),
            'link' => inputPost('link'),
            'page_order' => inputPost('page_order'),
            'page_active' => inputPost('page_active'),
            'parent_id' => inputPost('parent_id'),
            'location' => "header"
        ];
    }

    //add link
    public function addLink()
    {
        $data = $this->inputValues();
        if (empty($data["slug"])) {
            $data["slug"] = strSlug($data["title"]);
        }
        if (empty($data['link'])) {
            $data['link'] = "#";
        }
        return $this->db->table('pages')->insert($data);
    }

    //update link
    public function editLink($id)
    {
        $data = $this->inputValues();
        if (empty($data["slug"])) {
            $data["slug"] = strSlug($data["title"]);
        }
        return $this->db->table('pages')->where('id', cleanNumber($id))->update($data);
    }

    //get parent link
    public function getParentLink($parentId, $type)
    {
        if ($type == "page") {
            return $this->db->table('pages')->where('id', cleanNumber($parentId))->get()->getRow();
        }
        if ($type == "category") {
            return $this->db->table('categories')->where('id', cleanNumber($parentId))->get()->getRow();
        }
    }

    //get menu links
    public function getMenuLinks($langId)
    {
        $sql = "SELECT * FROM (
        (SELECT categories.id AS item_id, categories.lang_id AS item_lang_id, categories.name AS item_name, categories.slug AS item_slug, categories.category_order AS item_order, 'header' 
        AS item_location, 'category' AS item_type, '#' AS item_link, categories.parent_id AS item_parent_id,
        (SELECT slug FROM categories WHERE id = item_parent_id) as item_parent_slug
        FROM categories WHERE categories.lang_id = ? AND categories.show_on_menu = 1) 
        UNION
        (SELECT pages.id AS item_id, pages.lang_id AS item_lang_id, pages.title AS item_name, pages.slug AS item_slug, pages.page_order AS item_order, pages.location AS item_location, 'page' 
        AS item_type, pages.link AS item_link, pages.parent_id AS item_parent_id,
        (SELECT slug FROM pages WHERE id = item_parent_id) as item_parent_slug 
        FROM pages WHERE pages.lang_id = ? AND pages.page_active = 1)) AS menu_items ORDER BY item_order, item_name";
        return $this->db->query($sql, array($langId, $langId))->getResult();
    }

    //get all menu links
    public function getAllMenuLinks()
    {
        $sql = "SELECT * FROM (
        (SELECT categories.id AS item_id, categories.lang_id AS item_lang_id, categories.name AS item_name, categories.slug AS item_slug, categories.category_order AS item_order, 'header' 
        AS item_location, 'category' AS item_type, '#' AS item_link, categories.parent_id AS item_parent_id, categories.show_on_menu AS item_visibility,
        (SELECT slug FROM categories WHERE id = item_parent_id) as item_parent_slug 
        FROM categories) 
        UNION
        (SELECT pages.id AS item_id, pages.lang_id AS item_lang_id, pages.title AS item_name, pages.slug AS item_slug, pages.page_order AS item_order, pages.location AS item_location, 'page' 
        AS item_type, pages.link AS item_link, pages.parent_id AS item_parent_id, pages.page_active AS item_visibility,
        (SELECT slug FROM pages WHERE id = item_parent_id) as item_parent_slug 
        FROM pages)) AS menu_items ORDER BY item_order";
        return $this->db->query($sql)->getResult();
    }

    //update menu limit
    public function updateMenuLimit()
    {
        $data = [
            'menu_limit' => inputPost('menu_limit')
        ];
        return $this->db->table('general_settings')->where('id', 1)->update($data);
    }
}
