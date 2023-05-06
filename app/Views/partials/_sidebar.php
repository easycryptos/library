<div class="sidebar">
    <?= view('partials/_ad_spaces', ['adSpace' => 'sidebar_1', 'class' => 'm-b-30']); ?>
    <div class="col-sm-12 col-xs-12 sidebar-widget widget-popular-posts">
        <div class="row">
            <?= view('partials/_popular_posts'); ?>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 sidebar-widget">
        <div class="row">
            <?= view('partials/_our_picks'); ?>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 sidebar-widget">
        <div class="row">
            <?= view('partials/_categories'); ?>
        </div>
    </div>
    <?= view('partials/_ad_spaces', ['adSpace' => 'sidebar_2', 'class' => 'm-b-30']); ?>
    <div class="col-sm-12 col-xs-12 sidebar-widget">
        <div class="row">
            <?= view('partials/_random_slider'); ?>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 sidebar-widget">
        <div class="row">
            <?= view('partials/_tags'); ?>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 sidebar-widget">
        <div class="row">
            <?= view('partials/_polls'); ?>
        </div>
    </div>
</div>
