<?php
$db = & get_instance();
$products = $db->Product_model;
$SiteSetting =$db->Product_model->getSiteSetting(); 
$timeout = (isset($SiteSetting['session_timeout']) && is_numeric($SiteSetting['session_timeout']) && $SiteSetting['session_timeout'] > 60) ? $SiteSetting['session_timeout'] : 1800;

$page_id = $products->page_id();
$serverReq = checkReq();
require APPPATH."config/breadcrumb.php";
$pageKey = $db->Product_model->page_id();

?>

<div class="dashboard-wrap admin_side_bar_color">
  <div class="dashboard-main-right main-panel">
    <div class="server-errors"> <?php 
    if($serverReq){
      echo "<div class='requirement-error'>";
      foreach($serverReq as $key => $e)
        echo "<p>{$e}</p>";
      echo "</div>";
    }

    $setting_market_vendor_status= $this->Product_model->getSettings('market_vendor', 'marketvendorstatus');
    $setting_vendor_min_deposit = $this->Product_model->getSettings('site', 'vendor_min_deposit');
    $setting_vendor_deposit_status = $this->Product_model->getSettings('vendor', 'depositstatus');

    if($setting_market_vendor_status['marketvendorstatus'] == 1 && $setting_vendor_min_deposit['vendor_min_deposit'] == 0 && $setting_vendor_deposit_status['depositstatus'] == 1){
      echo "<div class='requirement-error'>";
      echo "<p>".__('admin.vendor_min_deposit_alert')." 
      <a href='".base_url('/admincontrol/saas_setting')."'>".__('admin.set_here')."</a>
      </p>";
      echo "</div>";
    }
    ?>
  </div>
  <script>
    function sessionTimeout() {
      var dt = new Date();
      let distance = (GlobaleCountDownDate - dt.getTime()) / 1000;
      let h = Math.floor(distance / 3600);
      let m = Math.floor(distance % 3600 / 60);
      let s = Math.floor(distance % 3600 % 60);
      let string = "";
      string += (h > 0) ? ('0' + h).slice(-2) + ":" : "00:";
      string += (m > 0) ? ('0' + m).slice(-2) + ":" : "00:";
      string += (s > 0) ? ('0' + s).slice(-2) + "" : "00";
      $(".dashboard-refresh em").text(string);
      if (distance <= 0) {
        window.location.replace('<?= base_url('admincontrol/logout'); ?>');
        clearInterval(GlobaleCountDownDateInterval);
      }
    }
    var dt = new Date();
    var GlobaleCountDownDate = dt.setTime(dt.getTime() + (<?= $timeout ?> * 1000));
    sessionTimeout();
    var GlobaleCountDownDateInterval = setInterval(sessionTimeout, 100);
    $(document).ajaxComplete(function(event, request, settings) {
      let parts = settings.url.split("/");
      let last_part = parts[parts.length - 1];
      if (last_part != "ajax_dashboard") {
        var dt = new Date();
        var GlobaleCountDownDate = dt.setTime(dt.getTime() + (<?= $timeout ?> * 1000));
      }
    });

    var localStorageValue = localStorage.getItem("close-sidebar");
    if (localStorageValue) {
      $(".main .logo").addClass("deactive");
      $(".main .dashboard-wrap").addClass('active');
    } else {
      $(".main .logo").removeClass("deactive");
      $(".main .dashboard-wrap").removeClass('active');
    }
  </script>

  <div class="container-fluid">

  <!--breadcrum code start here -->
    <ol class="breadcrumb">
       <?php 
          if( count($pageSetting)>0)
          $count = $pageSetting[$pageKey]['breadcrumb'];
        else
          $count=0;
      foreach($pageSetting[$pageKey]['breadcrumb'] as $key => $value){ ?> 
        <li class="breadcrumb-item <?= $count == $key ? 'active' : '' ?>">
          <a href="<?= $value['link'] ?>"> <?= $value['title'] ?> </a>
        </li> <?php } ?>
    </ol>
    <!--breadcrum code end here -->



     






