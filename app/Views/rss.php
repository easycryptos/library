<?= '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
	<title><?= $feedName; ?></title>
	<link><?= $feedUrl; ?></link>
	<description><?= convertToXmlCharacter(xml_convert($pageDescription)); ?></description>
	<dc:language><?= $pageLanguage; ?></dc:language>
	<dc:creator><?= $creatorEmail; ?></dc:creator>
	<dc:rights><?= convertToXmlCharacter(xml_convert($settings->copyright)); ?></dc:rights>
<?php foreach ($posts as $post): ?>
<item>
<title><?= convertToXmlCharacter(xml_convert($post->title)); ?></title>
<link><?= generatePostUrl($post); ?></link>
<guid><?= generatePostUrl($post); ?></guid>
<description><![CDATA[ <?= $post->summary; ?> ]]></description>
<?php
if (!empty($post->image_url)):
$imagePath = str_replace('https://', 'http://', $post->image_url ?? ''); ?>
<enclosure url="<?= $imagePath; ?>" length="49398" type="image/jpeg"/>
<?php else:
$imagePath = base_url($post->image_mid);
if (!empty($imagePath)) {
$fileSize = @filesize(FCPATH . $post->image_mid);
}
$imagePath = str_replace('https://', 'http://', $imagePath ?? '');
if (!empty($imagePath)):?>
<enclosure url="<?= $imagePath; ?>" length="<?= (isset($fileSize)) ? $fileSize : '12'; ?>" type="image/jpeg"/>
<?php endif;
endif; ?>
<pubDate><?= date('r', strtotime($post->created_at)); ?></pubDate>
<dc:creator><?= convertToXmlCharacter($post->username); ?></dc:creator>
</item>
<?php endforeach; ?>
</channel>
</rss>
