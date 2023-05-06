<div class="widget-title">
    <h4 class="title"><?= trans("tags"); ?></h4>
</div>
<div class="col-sm-12 widget-body">
    <div class="row">
        <ul class="widget-list w-tag-list">
            <?php $tags = getRandomTags();
            if (!empty($tags)):
                foreach ($tags as $item): ?>
                    <li><a href="<?= langBaseUrl('tag/' . esc($item->tag_slug)); ?>"><?= esc($item->tag); ?></a></li>
                <?php endforeach;
            endif; ?>
        </ul>
    </div>
</div>