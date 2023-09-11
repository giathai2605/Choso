<?php
include_once "header.php";
?>
<div class="left-side">
    <div class="outer" id="outer">
        <div class="boxx" id="login">
            <form method="POST" action="" id="login-form">
                <div class="forny-logo">
                    <a href="<?=base_url();?>">
                    <img src="<?= base_url($logo) ?>" <?= ($SiteSetting['front_custom_logo_size']) ? 'class="customLogoClass"' : '' ?> alt="<?= __('front.logo') ?>">
                    </a>
                </div>
                <div class="row">
                    <div class="col-12 text-center"><?= $title ?></div>
                </div>
                <br>
                <div class="input-box">
                    <img class="icon" src="<?= base_url('assets/login/index3') ?>/image/user.png" alt="<?= __('front.icon') ?>">
                    <input type="text" class="box" name="username" placeholder="<?= __('front.username_email') ?>"><br>
                </div>

                <div class="input-box">
                    <img class="icon" src="<?= base_url('assets/login/index3') ?>/image/padlock.png" alt="<?= __('front.icon') ?>">
                    <input type="password" class="box" name="password" id="loginpassowrd" value="" placeholder="*************">
                </div>  

                <div>
                    <?php if (isset($googlerecaptcha['affiliate_login']) && $googlerecaptcha['affiliate_login']) { ?>
                        <div class="captch  mb-3">
                            <script src='https://www.google.com/recaptcha/api.js'></script>
                            <div class="g-recaptcha" data-sitekey="<?= $googlerecaptcha['sitekey'] ?>"></div>
                        </div>
                    <?php } ?>
                </div>                      

                <button class="button btn-submit" type="submit" ><?= __('front.login') ?></button>
                <p class="text forget-text">
                    <a href="<?= base_url('forget-password') ?>"><?= __('front.forget_password') ?>?</a>
                </p>

                 <?php if(isset($store['registration_status']) &&  $store['registration_status']==0) {} 
                else if( ($vendor_marketstatus["marketvendorstatus"]==1 || $vendor_storestatus['storestatus']) && $store['registration_status']!=3 ) 
                    { ?> 
                    <p class="text"><?= __('front.dont_have_an_account') ?>
                        <a href="<?= base_url('register') ?>"><?= __('front.register') ?></a> 
                    </p>
                    <?php }else if($store['registration_status']!=2){ ?>
                        <p class="text"><?= __('front.dont_have_an_account') ?>
                        <a href="<?= base_url('register') ?>"><?= __('front.register') ?></a> 
                    </p>

                <?php } 
                        ?>
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