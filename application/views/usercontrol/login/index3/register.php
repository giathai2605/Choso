<?php
include_once "header.php";
?>
<div class="left-side">
    <div class="outer" id="outer">
        <div class="boxx" id="register">
             <div class="forny-logo">
                <a href="<?=base_url();?>">
                    <img src="<?= base_url($logo) ?>" <?= ($SiteSetting['front_custom_logo_size']) ? 'class="customLogoClass"' : '' ?> alt="<?= __('front.logo') ?>">
                </a>
             </div>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link bg-transparent text-dark" href="<?= base_url() ?>">
                        <span><?= __('front.login') ?></span>
                    </a>
                </li>
                <li class="nav-item">
                <a class="nav-link active bg-transparent text-dark" href="<?= base_url('register') ?>">
                    <span><?= __('front.register') ?></span>
                </a>
                </li>
            </ul>
            <p class="mt-6 mb-6">
                <?= __('front.enter_your_information_to_setup_a_new_account') ?>
            </p>
            <?= $register_fomm ?>
        </div>
        </div>
    </div>
</div>

<div class="right-side">
    <img src="<?= base_url('assets/login/index3') ?>/image/group.png" alt="<?= __('front.image') ?>">
    <div class="affiliate-description">
    </div>
</div>
<?php
include_once "footer.php";
?>