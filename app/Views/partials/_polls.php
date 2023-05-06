<?php $polls = getPolls();
if (!empty($polls)): ?>
    <div class="widget-title widget-popular-posts-title">
        <h4 class="title"><?= trans("voting_poll"); ?></h4>
    </div>
    <div class="col-sm-12 widget-body">
        <div class="row">
            <?php foreach ($polls as $poll):
                $pollVotes = getPollVotes($poll->id); ?>
                <?php if ($poll->status == 1): ?>
                <div id="poll_<?= $poll->id; ?>" class="poll">
                    <div class="question">
                        <form id="formPoll_<?= $poll->id; ?>" data-form-id="<?= $poll->id; ?>" class="poll-form" method="post">
                            <input type="hidden" name="poll_id" value="<?= $poll->id; ?>">
                            <h5 class="title"><?= esc($poll->question); ?></h5>
                            <?php for ($i = 1; $i <= 10; $i++):
                                $option = "option" . $i;
                                if (!empty($poll->$option)): ?>
                                    <p class="option">
                                        <label class="custom-checkbox custom-radio">
                                            <input type="radio" name="option" id="option<?= $poll->id; ?>-<?= $i; ?>" value="<?= $option; ?>">
                                            <span class="checkbox-icon"><i class="icon-check"></i></span>
                                            <span class="label-poll-option"><?= esc($poll->$option); ?></span>
                                        </label>
                                    </p>
                                <?php endif;
                            endfor; ?>
                            <p class="button-cnt">
                                <button type="submit" class="btn btn-sm btn-custom"><?= trans("vote"); ?></button>
                                <a onclick="viewPollResults('<?= $poll->id; ?>');" class="a-view-results"><?= trans("view_results"); ?></a>
                            </p>
                            <div id="poll-required-message-<?= $poll->id; ?>" class="poll-error-message">
                                <?= trans("please_select_option"); ?>
                            </div>
                            <div id="poll-error-message-<?= $poll->id; ?>" class="poll-error-message">
                                <?= trans("voted_message"); ?>
                            </div>
                        </form>
                    </div>
                    <div class="result" id="poll-results-<?= $poll->id; ?>">
                        <h5 class="title"><?= esc($poll->question); ?></h5>
                        <?php $numTotalVote = calcPollOptionVotes($pollVotes, 'total'); ?>
                        <p class="total-vote">Total Vote: <?= $numTotalVote; ?></p>
                        <?php for ($i = 1; $i <= 10; $i++):
                            $option = "option" . $i;
                            $percent = 0;
                            if (!empty($poll->$option)):
                                $optionVote = calcPollOptionVotes($pollVotes, $option);
                                if ($numTotalVote > 0) {
                                    $percent = round(($optionVote * 100) / $numTotalVote, 1);
                                } ?>
                                <span><?= esc($poll->$option); ?></span>
                                <?php if ($percent == 0): ?>
                                <div class="progress">
                                    <span><?= $percent; ?>&nbsp;%</span>
                                    <div class="progress-bar progress-bar-0" role="progressbar" aria-valuenow="<?= $numTotalVote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percent; ?>%"></div>
                                </div>
                            <?php else: ?>
                                <div class="progress">
                                    <span><?= $percent; ?>&nbsp;%</span>
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $numTotalVote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percent; ?>%"></div>
                                </div>
                            <?php endif;
                            endif;
                        endfor; ?>
                        <p>
                            <a onclick="viewPollOptions('<?= $poll->id; ?>');" class="a-view-results m-0"><?= trans("view_options"); ?></a>
                        </p>
                    </div>
                </div>
            <?php endif;
            endforeach; ?>
        </div>
    </div>
<?php endif; ?>
