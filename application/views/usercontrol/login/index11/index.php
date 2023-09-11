<?php
include_once "header.php";
?>
<div class="container main-con">
    <div class="row">
        <div class="col-xl-6"><img src="<?=base_url()?>assets/login/index11/images/login-side-image.jpg" draggable="false" class="img-fluid d-none d-lg-none d-xl-block" alt="Login side image"/></div>
        <div class="col-xl-6 text-center pad-40">
            <h4 class="font-weight-bold"><?= __('front.have_an_account') ?></h4>
            <h3 class="h3-blue"><?= __('front.login_now') ?></h3>
            <div class="col-xl-12 pad-30">
                <form id="login-form" class="needs-validation text-left" novalidate>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="<?= __('front.username_email') ?>">
                    </div>
                    <div class="form-group pad-bot-20">
                        <input type="password" class="form-control" name="password" placeholder="<?= __('front.password') ?>">
                        <a href="forgot-password"><small id="emailHelp" class="form-text text-muted text-right pad-10"><?= __('front.forget_password') ?>?</small></a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block font-weight-bold"><?= __('front.login') ?></button>
                </form>
                <div class="separator"><?= __('front.or') ?></div>
                <a href="register" class="btn btn-outline-primary btn-block second-btn"><?= __('front.create_account') ?></a>
            </div>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
?>