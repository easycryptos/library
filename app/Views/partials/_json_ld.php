<?php $socialArray = getSocialLinksArray($settings);
$i = 0; ?>
<script type="application/ld+json">[{
        "@context": "http://schema.org",
        "@type": "Organization",
        "url": "<?= base_url(); ?>",
        "logo": {"@type": "ImageObject","width": 180,"height": 50,"url": "<?= getLogo($generalSettings); ?>"}<?= !empty($socialArray) ? ',' : ''; ?>

<?php if (!empty($socialArray) && itemCount($socialArray)): ?>
        "sameAs": [<?php foreach ($socialArray as $item):if (isset($item['url'])): ?><?= $i != 0 ? ',' : ''; ?>"<?= $item['url']; ?>"<?php endif;
        $i++;endforeach; ?>]
<?php endif; ?>
    },
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "url": "<?= base_url(); ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?= base_url(); ?>/search?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }]
    </script>
<?php if (!empty($postJSONLD)):
    $dateModified = $postJSONLD->created_at;
if ($postJSONLD->post_type == "video"):?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "VideoObject",
            "name": "<?= esc($postJSONLD->title); ?>",
            "description": "<?= esc($postJSONLD->summary); ?>",
            "thumbnailUrl": [
                "<?= getPostImage($postJSONLD, "big"); ?>"
              ],
            "uploadDate": "<?= date(DATE_ISO8601, strtotime($postJSONLD->created_at)); ?>",
            "contentUrl": "<?= $postJSONLD->video_url; ?>",
            "embedUrl": "<?= $postJSONLD->video_embed_code; ?>"
        }
    </script>
<?php else: ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "<?= generatePostUrl($postJSONLD); ?>"
            },
            "headline": "<?= esc($postJSONLD->title); ?>",
            "name": "<?= esc($postJSONLD->title); ?>",
            "articleSection": "<?= $postJSONLD->category_name; ?>",
            "image": {
                "@type": "ImageObject",
                "url": "<?= getPostImage($postJSONLD, "big"); ?>",
                "width": 750,
                "height": 500
            },
            "datePublished": "<?= date(DATE_ISO8601, strtotime($postJSONLD->created_at)); ?>",
            "dateModified": "<?= date(DATE_ISO8601, strtotime($dateModified)); ?>",
            "inLanguage": "<?= $activeLang->language_code; ?>",
            "keywords": "<?= $postJSONLD->keywords; ?>",
            "author": {
                "@type": "Person",
                "name": "<?= $postJSONLD->username; ?>"
            },
            "publisher": {
                "@type": "Organization",
                "name": "<?= $settings->application_name; ?>",
                "logo": {
                "@type": "ImageObject",
                "width": 180,
                "height": 50,
                "url": "<?= getLogo($generalSettings); ?>"
                }
            },
            "description": "<?= esc($postJSONLD->summary); ?>"
        }
    </script>
    <?php endif;
endif;
if (!empty($categoryArray) && !empty($categoryArray['parentCategory'])):
    if(!empty($categoryArray['subcategory'])):?>
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "<?= esc($categoryArray['parentCategory']->name); ?>",
            "item": "<?= generateCategoryUrl(null, $categoryArray['parentCategory']->slug); ?>"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "<?= esc($categoryArray['subcategory']->name); ?>",
            "item": "<?= generateCategoryUrl($categoryArray['parentCategory']->slug, $categoryArray['subcategory']->slug); ?>"
        }]
    }
    </script>
<?php else: ?>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "<?= esc($categoryArray['parentCategory']->name); ?>",
                "item": "<?= generateCategoryUrl(null, $categoryArray['parentCategory']->slug); ?>"
            }]
        }
    </script>
    <?php endif;
endif; ?>
