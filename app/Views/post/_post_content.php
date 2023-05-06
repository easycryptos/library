<?php
$arrayContent = array();
$articleAd1 = array();
$articleAd2 = array();
if (!empty($adSpaces)) {
    foreach ($adSpaces as $item) {
        if ($item->ad_space == 'in_article_1') {
            $articleAd1 = $item;
        }
        if ($item->ad_space == 'in_article_2') {
            $articleAd2 = $item;
        }
    }
}
if (!empty($post->content)) {
    $arrayContent = explode('</p>', $post->content);
}
if (!empty($arrayContent)) {
    $i = 1;
    foreach ($arrayContent as $p) {
        echo $p;
        if (!empty($articleAd1) && !empty($articleAd1->paragraph_number) && $articleAd1->paragraph_number == $i) {
            echo view('partials/_ad_spaces', ['adSpace' => 'in_article_1', 'class' => 'container-bn-article m-t-5 m-b-15']);
        }
        if (!empty($articleAd2) && !empty($articleAd2->paragraph_number) && $articleAd2->paragraph_number == $i) {
            echo view('partials/_ad_spaces', ['adSpace' => 'in_article_2', 'class' => 'container-bn-article m-t-5 m-b-15']);
        }
        $i++;
    }
} ?>