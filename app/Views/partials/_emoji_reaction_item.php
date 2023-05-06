<?php if (getSession('reaction_vote_count_' . $reactions->post_id) < 3): ?>
    <div class="col-reaction col-reaction-like" onclick="addReaction('<?= $reactions->post_id; ?>', '<?= $reaction; ?>');">
        <div class="col-sm-12">
            <div class="row">
                <div class="icon-cnt">
                    <img src="<?= base_url(); ?>/assets/img/reactions/<?= $reaction; ?>.png" alt="<?= $reaction; ?>" class="img-reaction">
                    <label class="label reaction-num-votes"><?= $reaction_vote; ?></label>
                </div>
            </div>
            <div class="row">
                <p class="text-center">
                    <label class="label label-reaction <?= isReactionVoted($reactions->post_id, $reaction) == true ? 'label-reaction-voted' : ''; ?>"><?= trans($reaction); ?></label>
                </p>
            </div>
        </div>
    </div>
<?php else:
    if (isReactionVoted($reactions->post_id, $reaction) == true): ?>
        <div class="col-reaction col-reaction-like" onclick="addReaction('<?= $reactions->post_id; ?>', '<?= $reaction; ?>');">
            <div class="col-sm-12">
                <div class="row">
                    <div class="icon-cnt">
                        <img src="<?= base_url(); ?>/assets/img/reactions/<?= $reaction; ?>.png" alt="<?= $reaction; ?>" class="img-reaction">
                        <label class="label reaction-num-votes"><?= $reaction_vote; ?></label>
                    </div>
                </div>
                <div class="row">
                    <p class="text-center">
                        <label class="label label-reaction <?= isReactionVoted($reactions->post_id, $reaction) == true ? 'label-reaction-voted' : ''; ?>"><?= trans($reaction); ?></label>
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-reaction col-reaction-like col-disable-voting">
            <div class="col-sm-12">
                <div class="row">
                    <div class="icon-cnt">
                        <img src="<?= base_url(); ?>/assets/img/reactions/<?= $reaction; ?>.png" alt="<?= $reaction; ?>" class="img-reaction">
                        <label class="label reaction-num-votes"><?= $reaction_vote; ?></label>
                    </div>
                </div>
                <div class="row">
                    <p class="text-center">
                        <label class="label label-reaction"><?= trans($reaction); ?></label>
                    </p>
                </div>
            </div>
        </div>
    <?php endif;
endif; ?>
