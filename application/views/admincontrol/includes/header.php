<!doctype html>
<?php
  $db =& get_instance();
  $userdetails=$db->Product_model->userdetails(); 
  $SiteSetting =$db->Product_model->getSiteSetting();
  $db->Product_model->ping($userdetails['id']);
  $products = $db->Product_model;
  $settings = $db->Setting_model;
  $notifications = $products->getnotificationnew('admin', null, 5);
  $notifications_count = $products->getnotificationnew_count('admin', null);
  $license = $products->getLicese();
  $LanguageHtml = $products->getLanguageHtml();
  $CurrencyHtml = $products->getCurrencyHtml();
  $noti_order = $products->hold_noti();
  $admin_side_bar_color = $products->getSettings('theme','admin_side_bar_color');
  $admin_side_bar_scroll_color = $products->getSettings('theme','admin_side_bar_scroll_color');
  $admin_top_bar_color = $products->getSettings('theme','admin_top_bar_color');
  $admin_logo_color = $products->getSettings('theme','admin_logo_color');
  $admin_side_font = $products->getSettings('site','admin_side_font');
  $admin_footer_color = $products->getSettings('theme','admin_footer_color');
  $admin_button_color = $products->getSettings('theme','admin_button_color'); 
  $admin_button_hover_color = $products->getSettings('theme','admin_button_hover_color');
  $allToDo = $settings->allToDo();

  $commonSetting = array(
    'site' => array('notify_email'),
    'store' => array('affiliate_cookie'),
    'email' => array('from_email'),
    'productsetting' => array('product_commission', 'product_ppc', 'product_noofpercommission'),
    'affiliateprogramsetting' => array('affiliate_commission', 'affiliate_ppc'),
    'paymentsetting' => array('api_username', 'api_password', 'api_signature'),
  );

  $allSettings = array();
  foreach ($commonSetting as $key => $value) {
    $allSettings[$key] = $products->getSettings($key);
  }
  $required = '';
  $validate = true;
  foreach ($commonSetting as $key => $fields) {
    $data = $allSettings[$key];
    foreach ($fields as $field) {
      if (!isset($data[$field]) || $data[$field] == '') {
        $required .= "{$key} - {$field} \n";
        $validate = false;
      }
    }
  }

  $page_id = $products->page_id();

  $serverReq = checkReq();
  
  require APPPATH."config/breadcrumb.php";
  $pageKey = $db->Product_model->page_id();

  $site_setting_timeout = $this->Product_model->getSettings('site', 'session_timeout');
  $timeout = (isset($site_setting_timeout['session_timeout']) && is_numeric($site_setting_timeout['session_timeout'])) ? $site_setting_timeout['session_timeout'] : 1800;

  ?>


  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $SiteSetting['name'] ?> - <?= __('admin.menu_admin_panel') ?></title>
    <meta content="<?= $SiteSetting['meta_description'] ?>" name="description" />
    <meta content="<?= $SiteSetting['meta_author'] ?>" name="author" />
    <meta content="<?= $SiteSetting['meta_keywords'] ?>" name="keywords" />
    <?php if($SiteSetting['favicon']){ ?>
    <link rel="icon" href="<?= base_url('assets/images/site/'.$SiteSetting['favicon']) ?>" type="image/*" sizes="16x16">
    <?php } ?>
    
    <link href="<?= base_url('assets/plugins/magnific-popup/magnific-popup.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/js/jquery-confirm.min.css') ?>" rel="stylesheet"/>
    <link href="<?= base_url('assets/plugins/morris/morris.css') ?>" rel="stylesheet"/>
    
    <link href="<?= base_url('assets/css/jquery-ui.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/plugins/chartist/css/chartist.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/vertical/assets/css/icons.css') ?>" rel="stylesheet" type="text/css"/>

    <link href="<?= base_url('assets/vertical/assets/css/style.css?v='.av()); ?> ?>" rel="stylesheet" type="text/css">
    <link href='<?= base_url('assets/css/admin-common.css') ?>?v=<?= av() ?>' rel='stylesheet' type="text/css"/>

    <link href="<?= base_url('assets/template/css/admin.style.css?v='.av()); ?>" rel="stylesheet"/>
    <link href="<?= base_url('assets/template/css/admin.responsive.css?v='.av()); ?>" rel="stylesheet"/>


    <link href="<?= base_url('assets/template/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/template/css/bootstrap-toggle.min.css') ?>" rel="stylesheet"/>
    <link href="<?= base_url('assets/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') ?>" rel="stylesheet" type="text/css" media="screen">

    <link href="<?= base_url('assets/css/jquery.uploadPreviewer.css') ?>" rel="stylesheet" type="text/css" media="screen">
    <link href="<?= base_url('assets/plugins/datetimepicker/jquery.datetimepicker.min.css') ?>" rel="stylesheet"/>
    <link href="<?= base_url('assets/plugins/datatable/select2.css') ?>" rel="stylesheet"/>
    <link href="<?= base_url('assets/plugins/color-picker/spectrum.css') ?>" rel='stylesheet'/>
    <link href="<?= base_url('assets/js/jssocials-1.4.0/jssocials.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?= base_url('assets/js/jssocials-1.4.0/jssocials-theme-flat.css'); ?>" type="text/css" rel="stylesheet"/>
    

    <!--Bootstrap files-->
    <link href="<?= base_url('assets/template/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/template/css/bootstrap-icons.css') ?>" rel="stylesheet" />
    <!--Bootstrap files-->

    <!--summNote css files-->
    <link href="<?= base_url('assets/template/summernote/summernote-bs4.css'); ?>" rel="stylesheet">
    <!--summNote css files-->

    <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/datatable/select2.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js'); ?>"></script>
    
    <style type="text/css">
      .scroll-bar::-webkit-scrollbar-thumb {
        background: <?= $admin_side_bar_scroll_color['admin_side_bar_scroll_color'] ?>;
      }
      .scroll-bar::-webkit-scrollbar-thumb:hover {
        background: <?= $admin_side_bar_scroll_color['admin_side_bar_scroll_color'] ?>;
      }
      .nav-tabs .nav-link, .nav-pills .nav-link {
        font-family: <?= $admin_side_font['admin_side_font'] ?> !important;
      }
      h1, h2, h3, h4, h5, h6, th, label {
        font-family: <?= $admin_side_font['admin_side_font'] ?> !important;
      }
      .form-control {
        font-family: <?= $admin_side_font['admin_side_font'] ?> !important;
      }
      fieldset.custom-design {
        font-family: <?= $admin_side_font['admin_side_font'] ?> !important;
      }
      .admin_side_bar_color {
        background-color: <?= $admin_side_bar_color['admin_side_bar_color'] ?> !important;
      }
      .admin_logo_color {
        background-color: <?= $admin_logo_color['admin_logo_color'] ?> !important;
      }
      .admin_top_bar_color {
        background-color: <?= $admin_top_bar_color['admin_top_bar_color'] ?> !important;
      }
      .admin_footer_color {
        background-color: <?= $admin_footer_color['admin_footer_color'] ?> !important;
      }
      .admin_button_color, .btn-primary {
        background-color: <?= $admin_button_color['admin_button_color'] ?> !important;
        border: 1px solid <?= $admin_button_color['admin_button_color'] ?> !important ;
      }
      .admin_button_color:hover, .btn-primary:hover {
      background-color: <?= $admin_button_hover_color['admin_button_hover_color'] ?> !important;
        border: 1px solid <?= $admin_button_hover_color['admin_button_hover_color'] ?> !important ;
      }
    </style>

    <?php if($SiteSetting['google_analytics'] != '') echo $SiteSetting['google_analytics']; ?>

    <script type="text/javascript">
      window.affiliatePro ={
        base_url:"<?= base_url() ?>"
      }
    </script>

    <!--To Do list script-->
    <script type="text/javascript">
      function gettodoList() {
              $.ajax({
                url:'<?= base_url("todo/getodolist"); ?>',
                type:'GET',
                dataType:'json',
                async:false,
                success:function(data){
                  if(data.length != 0 && data != "null") {
                    var htmllist = "";
                    for (var i = 0; i < data.length; i++) {
                      if(data[i].id){
                        var ichecked= data[i].is_done == 1 ? 'checked':'';
                        var iscompleted= data[i].is_done == 1 ? 'completed':'';
                        htmllist += "<li class='"+iscompleted+" ' title='"+data[i].todo_date+"' ><div class='form-check'><label class='form-check-label'><input class='checkbox completedTodo' data-id='"+data[i].id+"' type='checkbox' "+ichecked+" />" + data[i].notes + "<i class='input-helper'></i></label></div><i class='remove fa fa-times-circle removetodolist' data-id='"+data[i].id+"'></i><i class= 'update fa fa-pencil edittodolist' data-id='"+data[i].id+"' data-note='"+data[i].notes+"' data-date='"+data[i].todo_date+"'></i></li>";
                      }
                    }
                    $('.todo-list').html(htmllist);


                  } else {
                    $('.todo-list').html(`<div class="events py-4 border-bottom px-3">
                      <div class="wrapper d-flex mb-2">
                      <span>No todo list</span>
                      </div>
                      </div>`)
                  }
                },
              })
            }
            (function($) {
              'use strict';
              $(function() {

                $("#datetodoList,#tododateCal").datepicker({
                 autoclose: true, 
                 todayHighlight: true,
                 minDate:new Date(),
                 changeMonth:true,
                 changeYear:true,
                 defaultDate:new Date(),
                 dateFormat:"yy-mm-dd"
               });

                var todoListInput = $('.todo-list-input');
                
                $('.todo-list-add-btn').on("click", function(event) {
                  event.preventDefault();

                  var item = $(this).prevAll('.todo-list-input').val();
                  var id  = $("#todoListItemid").val();
                  if (item) {
                   $.ajax({
                    url:'<?= base_url("todo/addtodolist"); ?>',
                    type:'POST',
                    dataType:'json',
                    async:false,
                    data: { note :item,id:id,todo_date:$("#datetodoList").val()},
                    success:function(data){
                      if(data.status){
                        gettodoList();
                        todoListInput.val("");
                        $("#datetodoList").val('');
                        $("#todoListItemid").val(0);
                        $('#add-task-todo').text('Add');
                        var cuUrl = window.location.href;
                        const lastSegment = cuUrl.split("/").pop();
                        if(lastSegment =="todolist" || lastSegment =="todolist#" || lastSegment=="dashboard" || lastSegment=="dashboard#") {
                          $('#calendar').fullCalendar('prev');
                          $('#calendar').fullCalendar('next'); 
                        }
                      }
                    },
                  });
                 }
               });

                $(document).on('change', '.completedTodo', function() {
                 var id = $(this).data('id');
                 var is_completed = 0;
                 if ($(this).attr('checked')) {
                  $(this).removeAttr('checked');
                  is_completed=0;
                } else {
                  $(this).attr('checked', 'checked');
                  is_completed=1;
                }
                var id = $(this).data('id');
                var $that = $(this);
                $.ajax({
                  url:'<?= base_url("todo/actiontodolist"); ?>',
                  type:'POST',
                  dataType:'json',
                  data:{id:id,action:2,is_completed:is_completed},
                  async:false,
                  success:function(data){
                   if(data.status) {
                    var cuUrl = window.location.href;
                    const lastSegment = cuUrl.split("/").pop();
                    if(lastSegment =="todolist" || lastSegment =="todolist#" || lastSegment=="dashboard" || lastSegment=="dashboard#")  {
                      $('#calendar').fullCalendar('prev');
                      $('#calendar').fullCalendar('next'); 
                    }
                  }
                },
              });
                $(this).closest("li").toggleClass('completed');

              });

                $(document).on('click', '.removetodolist', function() {
                  if(confirm('<?= __('admin.are_you_sure')?>')){
                    var id = $(this).data('id');
                    var $that = $(this);
                    $.ajax({
                      url:'<?= base_url("todo/actiontodolist"); ?>',
                      type:'POST',
                      dataType:'json',
                      data:{id:id,action:1},
                      async:false,
                      success:function(data){
                       if(data.status) {
                        $that.parent().remove();
                        var cuUrl = window.location.href;
                        const lastSegment = cuUrl.split("/").pop();
                        if(lastSegment =="todolist" || lastSegment =="todolist#" || lastSegment=="dashboard" || lastSegment=="dashboard#") { 
                          $('#calendar').fullCalendar('prev');
                          $('#calendar').fullCalendar('next'); 
                        }
                      }
                    },
                  });
                  }
                });
                $(document).on('click', '.edittodolist', function() {

                  var id = $(this).data('id');
                  var note = $(this).data('note');
                  $('.todo-list-input').val(note)
                  $('#add-task-todo').text('Update');
                  $("#todoListItemid").val(id);
                  $("#datetodoList").val($(this).data('date'));
                  
                });

              });
            })(jQuery);
    </script>
    <!--To Do list script-->


  <script type="text/javascript">
      (function ($) {
        $.fn.btn = function (action) {
          var self = $(this);
          var tagName = self.prop("tagName");

          if(tagName == 'A'){
            if(action == 'loading'){
              $(self).addClass("disabled");
              $(self).attr('data-text',$(self).text());
              $(self).text('<?= ('admin.loading') ?>'+"..");
            }

            if(action == 'reset') $(self).text($(self).attr('data-text')); $(self).removeClass("disabled");

          } else {
            if(action == 'loading') $(self).addClass("btn-loading");

            if(action == 'reset')  $(self).removeClass("btn-loading");
          }
        }
      })(jQuery);

      $(document).delegate('a.disabled',"click",function (e){
        e.preventDefault();
      });

      var formDataFilter = function(formData){
        if(!(window.FormData && formData instanceof window.FormData)) return formData

          if(!formData.keys) return formData

            var newFormData = new window.FormData()

          Array.from(formData.entries()).forEach(function(entry){
            var value = entry[1]
            if(value instanceof window.File && value.name === '' && value.size === 0)
              newFormData.append(entry[0], new window.Blob([]), '')
            else
              newFormData.append(entry[0], value)

          })

          return newFormData
        }

        function apply_color(ele){  
          $(ele).spectrum({ 
            preferredFormat: "rgb", 
            showInput: true,  
            className: "full-spectrum", 
            showInitial: true,  
            showPalette: true,  
            showSelectionPalette: true, 
            maxSelectionSize: 10, 
            localStorageKey: "bolly_fashion", 
            allowEmpty:true,  
            palette: [  
            ["transparent"],  
            ["rgb(255, 255, 255)","rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",   
            "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",   
            "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",   
            "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",   
            "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",   
            "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)", 
            "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)", 
            "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",  
            "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",  
            "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]  
            ] 
          }); 
        }

(function($) {
  'use strict';
  $(function() {
    $(".nav-settings").on("click", function() {

      $("#right-sidebar").toggleClass("open"); 

    });
    $(".settings-close").on("click", function() {
      $("#right-sidebar,#theme-settings").removeClass("open");
    });

          //background constants
          var navbar_classes = "navbar-danger navbar-success navbar-warning navbar-dark navbar-light navbar-primary navbar-info navbar-pink";
          var sidebar_classes = "sidebar-light sidebar-dark";
          var $body = $("body")

          var admin_theme_selected = localStorage.getItem("admin_theme");
          if(admin_theme_selected == 1 ){
            $body.removeClass(sidebar_classes);
            $body.addClass("sidebar-dark");
            $(".sidebar-bg-options").removeClass("selected");
            $("#admin_theme").val(1)
          }else {
           $body.removeClass(sidebar_classes);
           $body.addClass("sidebar-light");
           $(".sidebar-bg-options").removeClass("selected");
           $("#admin_theme").val(0)
         }
        //sidebar backgrounds
        $("#sidebar-light-theme").on("click" , function(){
          $body.removeClass(sidebar_classes);
          $body.addClass("sidebar-light");
          $(".sidebar-bg-options").removeClass("selected");
          $(this).addClass("selected");
        });
        $("#sidebar-dark-theme").on("click" , function(){
          $body.removeClass(sidebar_classes);
          $body.addClass("sidebar-dark");
          $(".sidebar-bg-options").removeClass("selected");
          $(this).addClass("selected");
        });


        //Navbar Backgrounds
        $(".tiles.primary").on("click" , function(){
          $(".navbar").removeClass(navbar_classes);
          $(".navbar").addClass("navbar-primary");
          $(".tiles").removeClass("selected");
          $(this).addClass("selected");
        });
        $(".tiles.success").on("click" , function(){
          $(".navbar").removeClass(navbar_classes);
          $(".navbar").addClass("navbar-success");
          $(".tiles").removeClass("selected");
          $(this).addClass("selected");
        });
        $(".tiles.warning").on("click" , function(){
          $(".navbar").removeClass(navbar_classes);
          $(".navbar").addClass("navbar-warning");
          $(".tiles").removeClass("selected");
          $(this).addClass("selected");
        });
        $(".tiles.danger").on("click" , function(){
          $(".navbar").removeClass(navbar_classes);
          $(".navbar").addClass("navbar-danger");
          $(".tiles").removeClass("selected");
          $(this).addClass("selected");
        });
        $(".tiles.light").on("click" , function(){
          $(".navbar").removeClass(navbar_classes);
          $(".navbar").addClass("navbar-light");
          $(".tiles").removeClass("selected");
          $(this).addClass("selected");
        });
        $(".tiles.info").on("click" , function(){
          $(".navbar").removeClass(navbar_classes);
          $(".navbar").addClass("navbar-info");
          $(".tiles").removeClass("selected");
          $(this).addClass("selected");
        });
        $(".tiles.dark").on("click" , function(){
          $(".navbar").removeClass(navbar_classes);
          $(".navbar").addClass("navbar-dark");
          $(".tiles").removeClass("selected");
          $(this).addClass("selected");
        });
        $(".tiles.default").on("click" , function(){
          $(".navbar").removeClass(navbar_classes);
          $(".tiles").removeClass("selected");
          $(this).addClass("selected");
        });
        var body = $('body');
        $('[data-toggle="minimize"]').on("click", function() { 
          if ( (body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
            body.toggleClass('sidebar-hidden');
          } else {
            body.toggleClass('sidebar-icon-only');
          }
        });

      });
})(jQuery);
(function($) {
  'use strict';
  $(function() {
    $('[data-toggle="offcanvas"]').on("click", function() {
      $('.sidebar-offcanvas').toggleClass('active')
    });
  });
})(jQuery);
</script>

<?php if(is_rtl()){ ?>
  <!-- place here your RTL css code -->
<?php } ?>
</head>

<body class="body-common-class admin_side_bar_color" style="font-family: <?= $admin_side_font['admin_side_font'] ?> !important;">
  <?php 
  $fbmessager_status = (array)json_decode($SiteSetting['fbmessager_status'],1);
  if(in_array('admin', $fbmessager_status))
    echo $SiteSetting['fbmessager_script'];
  ?>
  <div class="main">
    <div class="overly"></div>
    <!--  /* code for top nav */ -->

    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center admin_logo_color">
       <a class="navbar-brand brand-logo" href="<?php base_url('admincontrol/dashboard'); ?>">
         <?php $logo = $SiteSetting['admin-side-logo'] ? base_url('assets/images/site/'. $SiteSetting['admin-side-logo'] ) : base_url('assets/template/images/logo.png'); ?> <a href="
         <?= base_url('admincontrol/dashboard'); ?>" class="navbar-brand brand-logo">
         <img src="
         <?= $logo  ?>" alt="
         <?= __('admin.logo') ?>" />
       </a>
       <a class="navbar-brand brand-logo-mini" href="<?php base_url('admincontrol/dashboard'); ?>"><?php $logo = $SiteSetting['admin-side-logo'] ? base_url('assets/images/site/'. $SiteSetting['admin-side-logo'] ) : base_url('assets/images/logo-mini.png'); ?> <a href="
        <?= base_url('admincontrol/dashboard'); ?>" class="navbar-brand brand-logo-mini">
        <img src="
        <?= $logo  ?>" alt="
        <?= __('admin.logo') ?>" /></a>
      </div>

      <div class="navbar-menu-wrapper d-flex align-items-stretch admin_top_bar_color">
       <button class="navbar-toggler navbar-toggler align-self-center d-sm-none d-md-block d-sm-block d-none" type="button" data-toggle="minimize">
         <span class="fas fa-bars"></span>
       </button>
       <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
         <span class="fas fa-bars"></span>
       </button>

       <div class="header-right admin_top_bar_color">

        <ul class="d-flex flex-row bd-highlight pull-right">
          <li>
            <div class="theme-setting-wrapper">
             <div id="settings-trigger">
              <i class="admin_theme_selected" id="admin_theme_selected" onclick="change_admin_theme();" id="admin_theme_action"></i> 
              <input type="hidden" name="admin_theme" id="admin_theme" value="0" />
            </div>
            <div id="admin-theme-icon">
              <i class="admin_theme_icon fas fa-moon"></i> 
            </div>
          </div>    
        </li>
        <li id="admin-currency-top-menu" class="nav-item dropdown border-0 blue-background admin_button_color"> <?= $CurrencyHtml ?> </li>
        <li class="nav-item dropdown arrow-position blue-background admin_button_color"> <?= $LanguageHtml ?> </li>
        <li class="nav-item dropdown notification-area arrow-position"> <?php if ($notifications_count == null) { ?> <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="resetNotify();">
          <span class="bell"></span>
          <i class="fas fa-bell"></i>
          <span class="badge notifications-count ajax-notifications_count"><?= $notifications_count; ?> </span>
        </a> <?php } else { ?> <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="resetNotify();">
          <span class="bell"></span>
          <i class="fas fa-bell"></i>
          <span class="badge notifications-count ajax-notifications_count"> <?= $notifications_count; ?> </span>
        </a> <?php } ?> <div class="dropdown-menu dropdown-menu-right shadow user-setting">
          <i class="arrow"></i>
          <div class="heading-notification d-flex justify-content-between align-items-center">
            <h4> <?= __('admin.notification') ?> </h4>
            <strong class="ajax-top_notifications_count"> <?= $notifications_count; ?> </strong>
          </div>
          <div id="allnotification"> 
            <?php $last_id_notifications = 0;
            foreach($notifications as $key => $notification){
              if($last_id_notifications <= $notification['notification_id']){
                $last_id_notifications = $notification['notification_id'];
              } ?>

              <a class="dropdown-item" href="javascript:void(0)" onclick="shownofication(<?= $notification['notification_id'] . ',\'' . base_url('admincontrol') . $notification['notification_url'] . '\''; ?>)" >
                <?= $notification['notification_title']; ?>
                <em><?= $notification['notification_description']; ?></em> 
              </a>

            <?php } ?> 
            <input type="hidden" id="last_id_notifications" value="<?= $last_id_notifications ?>">
          </div>
          <div class="text-center">
            <a class="dropdown-item view-area" href="
            <?= base_url('admincontrol/notification') ?>"> + <?= __('admin.common_view_all') ?> </a>
          </div>
        </div>
      </li>

      <li class="nav-item dropdown user-right border-0">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php $login_user_profile_avatar =  (!empty($userdetails['avatar'])) ? base_url('assets/images/users/'.$userdetails['avatar']) : base_url('assets/vertical/assets/images/no-image.jpg'); ?> 
        <img class="profile-image" src="
        <?= $login_user_profile_avatar; ?>" alt="
        <?= $this->session->userdata('administrator')['firstname'].' '.$this->session->userdata('administrator')['lastname'] ?>" /><i class="fas fa-chevron-down"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow  user-setting">
        <i class="arrow"></i>
        <a class="dropdown-item" href="
        <?= base_url('admincontrol/editProfile'); ?>"> <?= __('admin.top_profile') ?> </a>
        <a class="dropdown-item" href="
        <?= base_url('admincontrol/changePassword'); ?>"> <?= __('admin.top_change_password') ?> </a>
        <a class="dropdown-item" href="
        <?= base_url('admincontrol/mywallet'); ?>"> <?= __('admin.top_my_wallet') ?> </a>
        <a class="dropdown-item" href="
        <?= base_url('admincontrol/paymentsetting'); ?>"> <?= __('admin.top_settings') ?> </a>
        <a class="dropdown-item" href="
        <?= base_url('admincontrol/logout'); ?>"> <?= __('admin.top_logout') ?> </a>
      </li>
      <li class="nav-item nav-settings d-lg-block">
       <a class="nav-link" href="#">
         <i class="fas fa-ellipsis-h"></i>
       </a>
     </li>
   </ul>
 </div>
</nav>

<div id="right-sidebar" class="settings-panel">
 <i class="settings-close fa fa-times"></i>
 <ul class="nav nav-tabs" id="setting-panel" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true"><?= __('admin.to_do_list') ?></a>
  </li>
</ul>
<div class="tab-content" id="setting-content">
  <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
   <div class="add-items d-flex px-3 mb-0">
    <form class="form w-100">
     <div class="form-group d-flex">
      <input type="text" class="form-control todo-list-input" placeholder="Add To-do"><br>
      <input type="text" class="form-control" id="datetodoList" value="" required placeholder="To-do date">
      <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task-todo">
        <?= __('admin.add') ?>
      </button>
      <input type="hidden" id="todoListItemid" value="0">
    </div>
  </form>
</div>
<div class="list-wrapper px-3">
  <ul class="d-flex flex-column-reverse todo-list">
    <?php   
      if (sizeof($allToDo) > 0) {
        foreach($allToDo as $todo) {
          $ichecked = $todo['is_done'] == 1 ? ' checked':'';
          $iscompleted = $todo['is_done'] == 1 ? 'completed':'';
          ?>
            <li class="<?php echo $iscompleted ?>" title="<?php echo $todo['todo_date'] ?>">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="checkbox completedTodo" data-id="<?php echo $todo['id'] ?>" type="checkbox" <?php echo $ichecked ?>><?php echo $todo['notes'] ?><i class="input-helper"></i>
                </label>
              </div>
              <i class="remove fa fa-times-circle removetodolist" data-id="<?php echo $todo['id'] ?>"></i>
              <i class="update fa fa-pencil edittodolist" data-id="<?php echo $todo['id'] ?>" data-note="<?php echo $todo['notes'] ?>" data-date="<?php echo $todo['todo_date'] ?>"></i>
            </li>
          <?php  
        }
      }else{
        ?>
        <div class="events py-4 border-bottom px-3">
          <div class="wrapper d-flex mb-2">
            <span>No todo list</span>
          </div>
        </div>
        <?php
      }
    ?>
  </ul>
</div>
</div>
<!-- To do section tab ends -->



</div>
<!-- chat tab ends -->
</div>
</div>