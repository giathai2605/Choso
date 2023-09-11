<!DOCTYPE html>
<?php 
  $db =& get_instance();
  $userdetails = $db->Product_model->userdetails('user', true); 
  $SiteSetting = $db->Product_model->getSiteSetting();
  $MembershipSetting =$db->Product_model->getSettings('membership');
  $user_side_font = $db->Product_model->getSettings('site','user_side_font');
  $user_button_color = $db->Product_model->getSettings('theme','user_button_color'); 
  $user_button_hover_color = $db->Product_model->getSettings('theme','user_button_hover_color');
  $loginUser = $_SESSION['user'];

  if($userdetails['reg_approved'] != 1 && !isset($notcheckapproval)){
    redirect('usercontrol/approval_status');die;
  }

  if($MembershipSetting['status']){
    
    $user = App\User::auth();

    if((int)$user->plan_id == 0){
    
      if(!isset($notcheckmember)){
        redirect('usercontrol/purchase_plan');die;
      }
    
    } else if($user->plan_id == -1){

    } else if($user){
        
      $plan = $user->plan();

      if(!$plan){

        if(!isset($notcheckmember)){
          redirect('usercontrol/purchase_plan');die;
        }

      } else if(!isset($notcheckmember) && $plan->status_id != 1){
          redirect('usercontrol/purchase_plan_expire');
      }else if($plan->isExpire() || !$plan->strToTimeRemains() > 0){

        $lifetime = ($plan->is_lifetime && $plan->status_id) ? true : false;
        if(!isset($notcheckmember) && !$lifetime){
          redirect('usercontrol/purchase_plan_expire');
          die;
        }

      }

    }

  }
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?= $SiteSetting['name'] ?> - <?= $loginUser['is_vendor']== 1 ? __('user.top_title_vendor') : __('user.top_title_affiliate') ?>
    </title>
    <meta content="<?= $SiteSetting['meta_author'] ?>" name="author" />
    <meta content="<?= $SiteSetting['meta_description'] ?>" name="description" />
    <meta content="<?= $SiteSetting['meta_keywords'] ?>" name="keywords" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="<?= base_url('assets/plugins/magnific-popup/magnific-popup.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/js/jquery-confirm.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/morris/morris.css') ?>" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous" rel="stylesheet">
    <link href="<?= base_url('assets/css/bootstrap4-toggle.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/template/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vertical/assets/css/icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vertical/assets/css/style.css?v='.av()); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/template/css/user.style.css?v='.av()); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/template/css/user.responsive.css?v='.av()); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/chartist/css/chartist.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') ?>" rel="stylesheet" media="screen">

    <!--summNote css files-->
    <link href="<?= base_url('assets/template/summernote/summernote-bs4.css') ?>" rel="stylesheet">
    <!--summNote css files-->

    <!--Bootstrap files-->
    <link href="<?= base_url('assets/template/css/bootstrap-icons.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/template/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <!--Bootstrap files-->
    

    <link href="<?= base_url('assets/css/jquery.uploadPreviewer.css') ?>" rel="stylesheet" media="screen">
    <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/template/js/jquery-migrate-3.0.0.min.js'); ?>"></script>

    
    <?php if($SiteSetting['custom_logo_size']): ?>
        .customLogoClass{
            width: <?= (int) $SiteSetting['log_custom_width'] ?>px !important;
            height: <?= (int) $SiteSetting['log_custom_height'] ?>px !important;
        }
    <?php endif ?>
    <?php if($SiteSetting['favicon']){ ?>
    <link rel="icon" href="<?= base_url('assets/images/site/'.$SiteSetting['favicon']) ?>" type="image/*" sizes="16x16">
    <?php } ?>
    <?php if($SiteSetting['google_analytics'] != ''){ ?><?= $SiteSetting['google_analytics'] ?><?php } ?>

    <?php if (is_rtl()) { ?>
      <!-- place here your RTL css code -->
    <?php } ?>
  
  <style>
      #preloader{
          background: #fff !important;
          color: rgba(0,0,0,0.8);
      }
      .lds-roller {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
      }
      .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 40px 40px;
      }
      .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #6362bb ;
        margin: -4px 0 0 -4px;
      }
      .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
      }
      .lds-roller div:nth-child(1):after {
        top: 63px;
        left: 63px;
      }
      .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
      }
      .lds-roller div:nth-child(2):after {
        top: 68px;
        left: 56px;
      }
      .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
      }
      .lds-roller div:nth-child(3):after {
        top: 71px;
        left: 48px;
      }
      .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
      }
      .lds-roller div:nth-child(4):after {
        top: 72px;
        left: 40px;
      }
      .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
      }
      .lds-roller div:nth-child(5):after {
        top: 71px;
        left: 32px;
      }
      .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
      }
      .lds-roller div:nth-child(6):after {
        top: 68px;
        left: 24px;
      }
      .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
      }
      .lds-roller div:nth-child(7):after {
        top: 63px;
        left: 17px;
      }
      .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
      }
      .lds-roller div:nth-child(8):after {
        top: 56px;
        left: 12px;
      }
      @keyframes lds-roller {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
  </style>

    <link href="<?= base_url('assets/plugins/datetimepicker/jquery.datetimepicker.min.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js') ?>"></script>
    <link href="<?= base_url('assets/plugins/datatable/select2.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/plugins/datatable/select2.min.js') ?>"></script>
    <link rel='stylesheet' href='<?= base_url('assets/css/usercontrol-common.css?v='.av()) ?>' />
    <script type="text/javascript" src='<?= base_url('assets/sweetalert/sweetalert.min.js') ?>'></script>

    <script type="text/javascript">
        (function ($) {
            $.fn.btn = function (action) {
                var self = $(this);
                var tagName = self.prop("tagName");
                if(tagName == 'A'){
                    if (action == 'loading') {
                        $(self).attr('data-text',$(self).text());
                        $(self).text("Loading..");
                    }
                    if (action == 'reset') { $(self).text($(self).attr('data-text')); }
                }
                else {
                    if (action == 'loading') { $(self).addClass("btn-loading"); }
                    if (action == 'reset') { $(self).removeClass("btn-loading"); }
                }
            }
        })(jQuery);

        var formDataFilter = function(formData) {
            if (!(window.FormData && formData instanceof window.FormData)) return formData
            if (!formData.keys) return formData
            var newFormData = new window.FormData()
            Array.from(formData.entries()).forEach(function(entry) {
                var value = entry[1]
                if (value instanceof window.File && value.name === '' && value.size === 0) {
                    newFormData.append(entry[0], new window.Blob([]), '')
                } else {
                    newFormData.append(entry[0], value)
                }
            })
            return newFormData
        }
    </script>



    <style type="text/css">
      .nav-tabs .nav-link, .nav-pills .nav-link {
        font-family: <?= $user_side_font['user_side_font'] ?> !important;
      }
      h1, h2, h3, h4, h5, h6, th, label {
        font-family: <?= $user_side_font['user_side_font'] ?> !important;
      }
      .form-control {
        font-family: <?= $user_side_font['user_side_font'] ?> !important;
      }
      .user_button_color, .btn-primary {
        background-color: <?= $user_button_color['user_button_color'] ?> !important;
        border: 1px solid <?= $user_button_color['user_button_color'] ?> !important ;
      }

      .user_button_color:hover, .btn-primary:hover {
      background-color: <?= $user_button_hover_color['user_button_hover_color'] ?> !important;
        border: 1px solid <?= $user_button_hover_color['user_button_hover_color'] ?> !important ;
      }
    </style>
</head>
<body style="font-family: <?= $user_side_font['user_side_font'] ?> !important;">
<?php 
  $fbmessager_status = (array)json_decode($SiteSetting['fbmessager_status'],1);
  if(in_array('affiliate', $fbmessager_status)){
    echo $SiteSetting['fbmessager_script'];
  }
?>
<div class="main">
  <div class="overly"></div>
