<h1 class="title-index"><?= esc($homeTitle); ?></h1>
<?php if ($generalSettings->layout == "layout_1" || $generalSettings->layout == "layout_2" || $generalSettings->layout == "layout_3"):
    if (!empty($sliderPosts)):?>
        <section id="slider" style="margin-top: 0px;">
            <div class="container-fluid">
                <div class="row">
                    <?php if ($generalSettings->slider_active == 1):
                        echo view('partials/_slider', $sliderPosts);
                    endif; ?>
                </div>
            </div>
        </section>
    <?php endif;
endif; ?>
<section id="main" class="margin-top-30">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="content">
                    <?php if ($generalSettings->layout == "layout_4" || $generalSettings->layout == "layout_5" || $generalSettings->layout == "layout_6"): ?>
                        <div class="first-tmp-slider">
                            <?php if ($generalSettings->slider_active == 1):
                                echo view('partials/_slider_second', $sliderPosts);
                            endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="col-xs-12 col-sm-12 posts <?= ($generalSettings->layout == "layout_3" || $generalSettings->layout == "layout_6") ? 'p-0 posts-boxed' : ''; ?>">
                        <div class="row">
                            <?php $count = 0;
                            foreach ($posts as $item):
                                if ($count != 0 && $count % 2 == 0): ?>
                                    <div class="col-sm-12 col-xs-12"></div>
                                <?php endif;
                                echo view('post/_post_item', ['item' => $item]);
                                if ($count == 1):
                                    echo view("partials/_ad_spaces", ['adSpace' => 'index_top', 'class'=>'m-b-30']);
                                endif;
                                $count++;
                            endforeach; ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <?= view("partials/_ad_spaces", ['adSpace' => 'index_bottom', 'class'=>'m-b-30']); ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <?= view('partials/_pagination'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <?= view('partials/_sidebar'); ?>
            </div>
        </div>
    </div>
</section>
