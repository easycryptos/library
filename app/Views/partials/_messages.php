<?php $session = session();
if ($session->getFlashdata('errors')):
    $errors = $session->getFlashdata('errors'); ?>
    <div class="form-group">
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php endif;
if ($session->getFlashdata('error')): ?>
    <div class="form-group">
        <div class="error-message">
            <p><?= $session->getFlashdata('error'); ?></p>
        </div>
    </div>
<?php elseif ($session->getFlashdata('success')): ?>
    <div class="form-group">
        <div class="success-message">
            <p>
                <i class="icon-check"></i>
                <?= $session->getFlashdata('success'); ?>
            </p>
        </div>
    </div>
<?php endif; ?>