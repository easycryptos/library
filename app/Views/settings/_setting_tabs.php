<div class="profile-tabs">
    <ul class="nav">
        <li class="nav-item <?= $activeTab == 'update_profile' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= langBaseUrl('settings'); ?>">
                <span><?= trans("update_profile"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'social_accounts' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= langBaseUrl('settings/social-accounts'); ?>">
                <span><?= trans("social_accounts"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'change_password' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= langBaseUrl('settings/change-password'); ?>">
                <span><?= trans("change_password"); ?></span>
            </a>
        </li>
    </ul>
</div>