<div class="row">
    <?php if (hasPermission('manage_all_posts') || hasPermission('add_post')): ?>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box admin-small-box bg-success">
                <div class="inner">
                    <h3 class="increase-count"><?= $postCount; ?></h3>
                    <a href="<?= adminUrl('posts'); ?>">
                        <p><?= trans("posts"); ?></p>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?= adminUrl('posts'); ?>">
                        <i class="fa fa-file"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box admin-small-box bg-danger">
                <div class="inner">
                    <h3 class="increase-count"><?= $pendingPostCount; ?></h3>
                    <a href="<?= adminUrl('pending-posts'); ?>">
                        <p><?= trans("pending_posts"); ?></p>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?= adminUrl('pending-posts'); ?>">
                        <i class="fa fa-low-vision"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box admin-small-box bg-purple">
                <div class="inner">
                    <h3 class="increase-count"><?= $draftCount; ?></h3>
                    <a href="<?= adminUrl('drafts'); ?>">
                        <p><?= trans("drafts"); ?></p>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?= adminUrl('drafts'); ?>">
                        <i class="fa fa-file-text-o"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif;
    if (hasPermission('membership')): ?>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box admin-small-box bg-warning">
            <div class="inner">
                <h3 class="increase-count"><?= $userCount; ?></h3>
                <a href="<?= adminUrl('users'); ?>">
                    <p><?= trans("users"); ?></p>
                </a>
            </div>
            <div class="icon">
                <a href="<?= adminUrl('users'); ?>">
                    <i class="fa fa-users"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-sm-12 no-padding">
        <?php if (hasPermission('comments')):
            if ($generalSettings->comment_approval_system != 1): ?>
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= trans("comments"); ?></h3>
                            <br>
                            <small><?= trans("recently_added_comments"); ?></small>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body index-table">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th><?= trans("id"); ?></th>
                                        <th><?= trans("name"); ?></th>
                                        <th style="width: 60%"><?= trans("comment"); ?></th>
                                        <th style="min-width: 13%"><?= trans("date"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($lastComments)):
                                        foreach ($lastComments as $item): ?>
                                            <tr>
                                                <td> <?= esc($item->id); ?> </td>
                                                <td><?= esc($item->name); ?></td>
                                                <td style="width: 60%" class="break-word">
                                                    <?= esc($item->comment); ?>
                                                </td>
                                                <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                            </tr>
                                        <?php endforeach;
                                    endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <a href="<?= adminUrl('comments'); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= trans("view_all"); ?></a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= trans("pending_comments"); ?></h3>
                            <br>
                            <small><?= trans("recently_added_unapproved_comments"); ?></small>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body index-table">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th><?= trans("id"); ?></th>
                                        <th><?= trans("name"); ?></th>
                                        <th style="width: 60%"><?= trans("comment"); ?></th>
                                        <th style="min-width: 13%"><?= trans("date"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($lastPendingComments)):
                                        foreach ($lastPendingComments as $item): ?>
                                            <tr>
                                                <td><?= esc($item->id); ?></td>
                                                <td><?= esc($item->name); ?></td>
                                                <td style="width: 60%" class="break-word"><?= esc($item->comment); ?></td>
                                                <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                            </tr>
                                        <?php endforeach;
                                    endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <a href="<?= adminUrl('pending-comments'); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= trans("view_all"); ?></a>
                        </div>
                    </div>
                </div>
            <?php endif;
        endif;
        if (hasPermission('contact_messages')):?>
            <div class="col-lg-6 col-sm-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= trans("contact_messages"); ?></h3>
                        <br>
                        <small><?= trans("recently_added_contact_messages"); ?></small>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body index-table">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th><?= trans("id"); ?></th>
                                    <th><?= trans("name"); ?></th>
                                    <th style="width: 60%"><?= trans("message"); ?></th>
                                    <th style="min-width: 13%"><?= trans("date"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($lastContacts)):
                                    foreach ($lastContacts as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td style="width: 60%" class="break-word"><?= esc($item->message); ?></td>
                                            <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <a href="<?= adminUrl('contact-messages'); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= trans("view_all"); ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php if (hasPermission('membership')): ?>
    <div class="row">
        <div class="col-sm-12 no-padding margin-bottom-20">
            <div class="col-lg-6 col-sm-12 col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= trans("users"); ?></h3>
                        <br>
                        <small><?= trans("recently_registered_users"); ?></small>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="users-list clearfix">
                            <?php if (!empty($lastUsers)):
                                foreach ($lastUsers as $item) : ?>
                                    <li>
                                        <a><img src="<?= getUserAvatar($item); ?>" alt="user" class="img-responsive"></a>
                                        <a class="users-list-name"><?= esc($item->username); ?></a>
                                        <span class="users-list-date"><td class="nowrap"><?= formatDate($item->created_at); ?></td></span>
                                    </li>
                                <?php endforeach;
                            endif; ?>
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="<?= adminUrl('users'); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= trans("view_all"); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>