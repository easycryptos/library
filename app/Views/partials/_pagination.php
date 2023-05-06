<?php if (itemCount($pager->links()) > 1): ?>
    <nav aria-label="<?= lang('Pager.pageNavigation') ?>">
        <ul class="pagination">
            <?php if ($pager->hasPreviousPage()) : ?>
                <li>
                    <a href="<?= $pager->getFirst() ?>" aria-label="">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $pager->getPreviousPage() ?>" aria-label="">
                        <span aria-hidden="true">&lsaquo;</span>
                    </a>
                </li>
            <?php endif;
            foreach ($pager->links() as $link) : ?>
                <li <?= $link['active'] ? 'class="active"' : '' ?>>
                    <a href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach;
            if ($pager->hasNextPage()) : ?>
                <li>
                    <a href="<?= $pager->getNextPage() ?>" aria-label="">
                        <span aria-hidden="true">&rsaquo;</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $pager->getLast() ?>" aria-label="">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>