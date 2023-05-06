<section id="main">
    <div class="container">
        <div class="row">
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active"><?= esc($page->title); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="page-breadcrumb m-t-45"></div>
            <?php endif; ?>
            <div class="page-content">
                <?php if ($page->right_column_active == 0): ?>
                    <div class="col-sm-12">
                        <div class="content page-about page-res">
                            <?php if ($page->title_active == 1): ?>
                                <h1 class="page-title"><?= esc($page->title); ?></h1>
                            <?php endif; ?>
                            <div class="text-style">
                                <?= $page->page_content; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-sm-12 col-md-8">
                        <div class="content page-about page-res">
                            <?php if ($page->title_active == 1): ?>
                                <h1 class="page-title"><?= esc($page->title); ?></h1>
                            <?php endif; ?>
                            <div class="text-style">
                                <?= $page->page_content; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <?= view('partials/_sidebar'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
