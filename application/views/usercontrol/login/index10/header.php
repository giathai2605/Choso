<!doctype html>
<html lang="en">
<head>
<?php
    if($SiteSetting['google_analytics']){ echo $SiteSetting['google_analytics']; }
    if($SiteSetting['faceboook_pixel']){ echo $SiteSetting['faceboook_pixel']; }
    $logo = ($SiteSetting['front-side-themes-logo'] ? 'assets/images/site/'.$SiteSetting['front-side-themes-logo'] : 'assets/login/index10/img/logo.png');
    if($SiteSetting['favicon']){ echo '<link rel="icon" href="'. base_url('assets/images/site/'.$SiteSetting['favicon']) .'" type="image/*" sizes="16x16">'; }
    else{ echo '<link rel="icon" href="'. base_url('assets/images/fav.png') .'" type="image/*" sizes="16x16">'; }
    $global_script_status = (array)json_decode($SiteSetting['global_script_status'],1);
    if(in_array('front', $global_script_status)){ echo $SiteSetting['global_script']; }
    $db =& get_instance();
    $products = $db->Product_model;
    $googlerecaptcha =$db->Product_model->getSettings('googlerecaptcha');
    $front_side_font =$db->Product_model->getSettings('site','front_side_font');
    if ($front_side_font) {
        $front_side_font_value = $front_side_font['front_side_font'];
    }else{
        $front_side_font_value = '';
    }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <meta name="author" content="<?= $meta_author ?>">
    <meta name="keywords" content="<?= $meta_keywords ?>">
    <meta name="description" content="<?= $meta_description ?>">

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/common.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/login/index10/css/') ?>/main.css?v=<?= av() ?>" rel="stylesheet">

    <script src="<?= base_url('assets') ?>/js/jquery.min.js"></script>

    <?php if($SiteSetting['front_custom_logo_size']): ?>
    <style type="text/css">
        .customLogoClass{
            width: <?= (int) $SiteSetting['front_log_custom_width'] ?>px !important;
            height: <?= (int) $SiteSetting['front_log_custom_height'] ?>px !important;
        }
    </style>
    <?php endif ?>
    
    <?php if (is_rtl()) { ?>
      <!-- place here your RTL css code -->
      <!-- <link href="<?= base_url('assets/login/index1') ?>/css/rtl.css?v=<?= av() ?>" rel="stylesheet"> -->
    <?php } ?>

    <style type="text/css">
        .forny-container {
            font-family: <?= $front_side_font['front_side_font'] ?> !important;
        }
        .login100-form-title {
            font-family: <?= $front_side_font['front_side_font'] ?> !important;
        }
        .label-input100 {
            font-family: <?= $front_side_font['front_side_font'] ?> !important;
        }
        .input100 {
            font-family: <?= $front_side_font['front_side_font'] ?> !important;
        }
        .login100-form-btn {
            font-family: <?= $front_side_font['front_side_font'] ?> !important;
        }
        .txt3 {
            font-family: <?= $front_side_font['front_side_font'] ?> !important;
        }
    </style>
</head>
<body style="background-color: #999999;font-family: <?= $front_side_font['front_side_font'] ?> !important;">
    <div class="limiter">
        <div class="container-login100">
            <!--left side + footer-->
            <div class="login100-more">
                <!--left side-->
                <div class="row justify-content-center">
                    <div class="col-10 col-sm-6">
                        <div class="row justify-content-center">
                            <div class="forny-logo">
                                <a href="<?= base_url() ?>">
                                    <img src="<?= base_url($logo) ?>" <?= ($SiteSetting['front_custom_logo_size']) ? 'class="customLogoClass"' : '' ?> alt="<?= __('front.logo') ?>">
                                </a>
                            </div>
                        </div>
                        <div class="affiliate-description">
                            <br>
                            <h3><?= $setting['heading'] ?></h3>
                            <br>
                            <?= $setting['content'] ?>
                            <br>
                        </div>
                    </div>
                </div>
                <!--left side-->

                <!-- Footer -->
                <div class="footer">
                    <nav class="navbar navbar-expand-sm navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footernav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="navbar-collapse collapse" id="footernav">
                        <ul class="navbar-nav footer-items-center-x">
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#termOfUse">
                                    <?= __('front.temrs_of_use') ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#about">
                                    <?= __('front.about') ?>
                                </a>
                            </li>
                            <?php 
                            $store_setting = $this->Product_model->getSettings('store');
                            if($store_setting['menu_on_front']){ ?>
                            <li class="nav-item <?php if(base_url(uri_string()) == base_url('/store')){ echo 'active'; } ?>">
                                <a class="nav-link" href="<?= base_url('/store') ?>" <?= ($store_setting['menu_on_front_blank']) ? 'target="_blank"' : ''; ?>><?= __('front.my_store') ?></a>
                            </li>
                             <?php } ?>
                        </ul>
                    </div>
                    </nav>
                    <div class="mt-4 mb-1"><?= $footer ?></div>
                </div>
            </div>
            <!--left side + footer-->