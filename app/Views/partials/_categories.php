<?php $categories = getCategories();
$numCatPosts = array();
if (!empty($categories)) {
    foreach ($categories as $category) {
        if ($category->parent_id > 0) {
            if (!isset($numCatPosts[$category->parent_id])) {
                $numCatPosts[$category->parent_id] = 0;
            }
            $numCatPosts[$category->parent_id] = $numCatPosts[$category->parent_id] + $category->number_of_posts;
        }
    }
} ?>
<div class="widget-title">
    <h4 class="title"><?= trans("categories"); ?></h4>
</div>
<div class="col-sm-12 widget-body">
    <div class="row">
        <ul class="widget-list w-category-list">
            <?php $categories = getCategories();
            foreach ($categories as $item):
                if ($item->parent_id == 0):
                    $number_of_posts = $item->number_of_posts;
                    if (isset($numCatPosts[$item->id])):
                        $number_of_posts += $numCatPosts[$item->id];
                    endif; ?>
                    <li><a href="<?= generateCategoryUrl($item->parent_slug, $item->slug); ?>"><?= esc($item->name); ?></a><span>(<?= $number_of_posts; ?>)</span></li>
                    <?php $subcategories = getSubcategoriesClient($categories, $item->id); ?>
                    <?php if (!empty($subcategories)): ?>
                    <?php foreach ($subcategories as $subcategory) : ?>
                        <li><a href="<?= generateCategoryUrl($subcategory->parent_slug, $subcategory->slug); ?>"><?= esc($subcategory->name); ?></a><span>(<?= $subcategory->number_of_posts; ?>)</span></li>
                    <?php endforeach; ?>
                <?php endif;
                endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
