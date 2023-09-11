<?php
include_once "header.php";
?>
<div class="left-side">
    <div class="outer" id="outer">
        <div class="boxx" id="fog-pass">
             <div class="forny-logo mb-3">
                <a href="<?=base_url();?>">
                    <img src="<?= base_url($logo) ?>" <?= ($SiteSetting['front_custom_logo_size']) ? 'class="customLogoClass"' : '' ?> alt="<?= __('front.logo') ?>">
                </a>
             </div>
            <form method="POST" action="" class="reset-password-form">
                <input class="box " name="email" placeholder="<?= __('front.email') ?>" type="email">

                <button class="button sign-in" type="button" onclick="window.location='<?= base_url() ?>'"><?= __('front.back_to_login') ?></button>
                <button class="button btn-submit submit" type="submit" ><?= __('front.submit') ?></button>
            </form>
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