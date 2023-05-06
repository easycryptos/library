<div class="row">
    <div class="container">
        <div class="nav-top">
            <ul class="left">
                <?php if (!empty($menuLinks)):
                    foreach ($menuLinks as $item):
                        if ($item->item_location == "top"):?>
                            <li><a href="<?= generateMenuItemUrl($item); ?>"><?= esc($item->item_name); ?> </a></li>
                        <?php endif;
                    endforeach;
                endif; ?>
            </ul>
            <ul class="right">
                <?php if (authCheck()) : ?>
                    <li class="dropdown profile-dropdown nav-item-right">
                        <a href="#" class="dropdown-toggle image-profile-drop" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?= getUserAvatar(user()); ?>" alt="<?= esc(user()->username); ?>" width="24" height="24">
                            <?= esc(limitCharacter(user()->username, 20, '...')); ?>&nbsp;
                            <i class="icon-arrow-down"></i>
                        </a>
                        <ul class="dropdown-menu top-dropdown">
                            <?php if (isAdmin() || isAuthor()): ?>
                                <li><a href="<?= adminUrl(); ?>"><i class="icon-dashboard"></i>&nbsp;<?= trans("admin_panel"); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?= langBaseUrl('profile/' . user()->slug); ?>"><i class="icon-user"></i>&nbsp;<?= trans("profile"); ?></a></li>
                            <li><a href="<?= langBaseUrl('reading-list'); ?>"><i class="icon-star-o"></i>&nbsp;<?= trans("reading_list"); ?></a></li>
                            <li><a href="<?= langBaseUrl('settings'); ?>"><i class="icon-settings"></i>&nbsp;<?= trans("settings"); ?></a></li>
                            <li><a href="<?= langBaseUrl('logout'); ?>"><i class="icon-logout"></i>&nbsp;<?= trans("logout"); ?></a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <?php if ($generalSettings->registration_system == 1): ?>
                        <li><a href="<?= langBaseUrl('login'); ?>"><?= trans("login"); ?></a></li>
                        <li><span class="span-sep">/</span></li>
                        <li><a href="<?= langBaseUrl('register'); ?>"><?= trans("register"); ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($generalSettings->multilingual_system == 1 && itemCount($languages) > 1): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle image-profile-drop" data-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#666666" class="inf-svg-icon svg-lang-icon" viewBox="0 0 16 16">
                                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/>
                            </svg>
                            <?= esc($activeLang->name); ?>
                            <i class="icon-arrow-down"></i>
                        </a>
                        <ul class="dropdown-menu top-dropdown top-lang-dropdown">
                            <?php if (!empty($languages)):
                                foreach ($languages as $language):
                                    $langUrl = base_url() . '/' . $language->short_form . '/';
                                    if ($language->id == $generalSettings->site_lang):
                                        $langUrl = base_url();
                                    endif; ?>
                                    <li><a href="<?= $langUrl; ?>"><?= esc($language->name); ?></a></li>
                                <?php endforeach;
                            endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="li-dark-mode-sw">
                    <form action="<?= base_url('inf-switch-mode'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <?php if ($darkMode == 1): ?>
                            <button type="submit" name="theme_mode" value="light" class="btn-switch-mode">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#666666" class="inf-svg-icon bi bi-sun-fill" viewBox="0 0 16 16">
                                    <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                                </svg>
                            </button>
                        <?php else: ?>
                            <button type="submit" name="theme_mode" value="dark" class="btn-switch-mode">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#666666" class="inf-svg-icon bi bi-moon-fill dark-mode-icon" viewBox="0 0 16 16">
                                    <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                                </svg>
                            </button>
                        <?php endif; ?>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>