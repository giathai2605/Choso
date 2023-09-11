<?php
$db =& get_instance();
$userdetails = $db->userdetails();
$products = $db->Product_model;
$notifications_count = $products->getnotificationnew_count('admin',null);
$payment_details=json_decode($plan->payment_details);
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/flag/css/main.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/table/datatables.min.css") ?>">
<script type="text/javascript" src="<?= base_url("assets/plugins/table/datatables.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/plugins/table/dataTables.responsive.min.js") ?>"></script>
<script src="<?= base_url('assets/plugins/qrcode.min.js') ?>"></script>

<div class="admin-balance-main <?= ($userdetails['is_vendor']) ? 'vendor-balance' : '' ?>">
  <div class="admin-balance-main-left-bar">
    <div class="admin-width admin-area">
      <div class="admin-balance ml-0">
        <div class="admin-top-img">
          <img src="<?= base_url('assets/template/images/user-admin-1.png') ?>" alt="<?= __('user.balance') ?>">
        </div>
        <div class="action-top">
          <span> <?= __('user.balance') ?> 
          <em><?= $fun_c_format($user_totals['user_balance']) ?></em>
        </span>
        <label> <?= __('user.paid_balance') ?> </label>
        <i><?= $fun_c_format($user_totals['wallet_accept_amount']) ?></i> 
      </div>
    </div>
  </div>
  <div class="admin-width admin-area">
    <div class="admin-balance">
      <div class="admin-top-img">
        <img src="<?= base_url('assets/template/images/user-admin-2.png') ?>" alt="<?= __('user.actions') ?>">
      </div>
      <div class="action-top"> 
        <span> <?= __('user.actions') ?> 
        <em>
          <?= (int)$user_totals['click_action_total'] + (int)$user_totals['vendor_action_external_total'] ?>
          /
          <?= $fun_c_format($user_totals['click_action_commission'] + $user_totals['vendor_action_external_commission']) ?>
        </em>
      </span>
      <label><?= ($userdetails['is_vendor']) ? __('user.vendor_pay') : '' ?></label>
      <i><?= ($userdetails['is_vendor']) ? $fun_c_format($user_totals['vendor_action_external_commission_pay']) : '' ?></i>
    </div>
  </div>
</div>
<div class="admin-width admin-area">
  <div class="admin-balance">
    <div class="admin-top-img">
      <img src="<?= base_url('assets/template/images/user-admin-click.png') ?>" alt="<?= __('user.clicks') ?>">
    </div>
    <div class="action-top"> 
      <span> <?= __('user.clicks') ?>
      <em>
       <?= (int)($user_totals['total_clicks_count']) ?>
       /
       <?= $fun_c_format($user_totals['total_clicks_commission']) ?>
     </em> 
   </span>
   <label><?= ($userdetails['is_vendor']) ? __('user.vendor_pay') : '' ?></label>
   <i>
    <?= ($userdetails['is_vendor']) ? $fun_c_format(
      $user_totals['vendor_click_localstore_commission_pay'] +
      $user_totals['vendor_click_external_commission_pay']
    ) : '' ?>
  </i> 
</div>
</div>
</div>
</div>
<?php if($userdetails['is_vendor']): ?>
  <div class="admin-balance-main-right-bar">
    <div class="sales-width admin-area  total-bg">
      <div class="total-area admin-balance">
        <div>
          <h4><?= __('user.total_sale') ?></h4>
          <ul class="d-flex">
            <li class="border-0">
              <strong>
                <?= $fun_c_format($user_totals['vendor_sale_localstore_total'] + $user_totals['vendor_order_external_total']) ?>
              </strong> 
              <?= __('user.vendor_store') ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>
</div>


<div class="d-flex justify-content-between dashboard-area">
  <div class="dashboard-left">
    <?php if($MembershipSetting['status']){ ?>
      <div class="dashboard-div p-4 dashboard-user-details">
        <div class="membership-header">
          <h2><?= __('user.membership_plan') ?></h2>
        </div>
        <?php if((isset($is_lifetime_plan) && $is_lifetime_plan) || !$isMembershipAccess){ ?>
          <div class="membership-lifetime">
            <h4><?= __('user.lifetime_free_membership') ?></h4>
            <p><?= __('user.lifetime_free_membership_access_all_system_functions') ?></p>
          </div>
        <?php }
        if(isset($plan) && $plan){
          $checkDay = max((int)$MembershipSetting['notificationbefore'],1);
          if($plan->remainDay() != 'lifetime' && $plan->remainDay() <= $checkDay && !$plan->is_lifetime && $isMembershipAccess){ ?>
            <div class="membership-alert"><?= __('user.your_account_will_expire_in') ?> 
            <span data-time-remains="<?= $plan->strToTimeRemains(); ?>"><?= $plan->remainDay() ?></span> 
            <a href="<?= base_url('/usercontrol/purchase_plan/') ?>">
              <?= __('user.click_here') ?>
            </a> 
            <?= __('user.to_renew_plan') ?>
          </div>
        <?php }
        if($isMembershipAccess){
          $remain = $plan->remainDay();
          $planto = ($plan->is_lifetime) ? __('user.lifetime') : dateFormat($plan->expire_at,'d F Y h:i A'); ?>
          <div class="d-flex align-items-center justify-content-between user-information">
            <div class="user-information-left">
              <div class="membership-icon">
                <?php $image = !empty($userdetails['avatar']) ? base_url('assets/images/users/'. $userdetails['avatar']) : base_url('assets/vertical/assets/images/users/avatar-1.jpg') ?> 
                <img src="<?= $image ?>" alt=""> 
              </div>
              <span>
                <i><?= $userdetails['firstname'].' '.$userdetails['lastname'] ?></i> 
                <?= __('user.plan') ?>: <em><?= $plan->plan ? $plan->plan->name : '' ?></em>
              </span> 
            </div>
            <div class="user-information-right"> 
              <span><?= dateFormat($plan->started_at,'d F Y h:i A') ?></span> 
              <span><?= __('user.to') ?></span> 
              <span><?= $planto ?></span> 
            </div>
          </div>
          <ul>
            <li class="d-flex"> 
              <span><?= __('user.remaining_time') ?></span> 
              <?php if($plan->is_lifetime){ ?>
                <strong>&infin;</strong>
              <?php } else { ?>
                <strong data-time-remains="<?= $plan->strToTimeRemains() ?>"><?= $remain ?></strong>
              <?php } ?>
            </li>
            <li class="d-flex">
            <?php if(isset($payment_details)) { ?>
            <span><?= __('user.payment_status') ?></span>
            <strong>
              <i class="lni lni-checkmark"></i>
              <?= $payment_details->payment_status ?>
            </strong>
            <?php } ?>
            </li>
            <li class="text-center description-link"> 
              <a href="javascript:void(0)" data-toggle="modal" data-target="#descriptionid">+ <?= __('user.description') ?></a>
            </li>
          </ul>
        <?php } 
      } 
      if($isMembershipAccess){ ?>    
        <div class="modal fade modal-style" id="descriptionid" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered dashboard-setting" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?= __('user.description') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                  <span aria-hidden="true">&times;</span> 
                </button>
              </div>
              <div class="modal-body">
                <div class="description-wrapp">
                  <?= $plan->plan ? $plan->plan->description : '' ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
  <div class="dashboard-div">
    <div class="dashboard-user-details wallet-details">
      <div class="user-header d-flex align-items-center">
        <div class="header-img"> 
          <img src="<?= base_url('assets/template/images/wallet-icon.png') ?>" alt="<?= __('user.wallet_statistics') ?>"> 
        </div>
        <div>
          <h2><?= __('user.wallet_statistics') ?></h2>
        </div>
      </div>
      <ul>
        <li class="d-flex"> 
          <span><?= __('user.hold') ?></span> 
          <strong>
            <?= (int)$user_totals['wallet_unpaid_amounton_hold_count'] ?>
            / 
            <?= $fun_c_format($user_totals['wallet_on_hold_amount']) ?>
          </strong> 
        </li>
        <li class="d-flex"> 
          <span><?= __('user.unpaid') ?></span> 
          <strong>
            <?= (int)$user_totals['wallet_unpaid_count'] ?>
            / 
            <?= $fun_c_format($user_totals['wallet_unpaid_amount']) ?>
          </strong> 
        </li>
        <li class="d-flex"> 
          <span><?= __('user.request') ?></span> 
          <strong>
            <?= (int)$user_totals['wallet_request_sent_count'] ?> 
            / 
            <?= $fun_c_format($user_totals['wallet_request_sent_amount']) ?>
          </strong> 
        </li>
        <li class="d-flex"> 
          <span><?= __('user.paid') ?></span> 
          <strong>
            <?= (int)$user_totals['wallet_accept_count'] ?> 
            / 
            <?= $fun_c_format($user_totals['wallet_accept_amount']) ?>
          </strong> 
        </li>
        <li class="d-flex"> 
          <span><?= __('user.cancel') ?></span> 
          <strong>
            <?= (int)$user_totals['wallet_cancel_count'] ?>  
            / 
            <?= $fun_c_format($user_totals['wallet_cancel_amount']) ?>
          </strong> 
        </li>
        <li class="d-flex"> 
          <span><?= __('user.trash') ?></span> 
          <strong>
            <?= (int)$user_totals['wallet_trash_count'] ?>  
            / 
            <?= $fun_c_format($user_totals['wallet_trash_amount']) ?>
          </strong> 
        </li>
      </ul>
      <div class="click-here-link"> -  <?= __('user.check_all_transactions') ?>
        <a href="<?= base_url('usercontrol/mywallet') ?>">
          <i class="lni lni-arrow-right"></i> <?= __('user.click_here') ?>
        </a> 
      </div>
    </div>
  </div>
<div class="dashboard-div">
  <div class="dashboard-user-details wallet-details">
    <div class="user-header d-flex align-items-center">
      <div class="header-img"> 
        <img src="<?= base_url('assets/template/images/click-icon.png') ?>" alt="<?= __('user.all_clicks') ?>"> 
      </div>
      <div>
        <h2><?= __('user.all_clicks') ?></h2>
        <span><?= __('user.total') ?> 
        <?= (int)(
          $user_totals['click_localstore_total'] +
          $user_totals['click_external_total'] +
          $user_totals['click_form_total'] 
        ) ?>
        / 
        <?= $fun_c_format(
          $user_totals['click_localstore_commission'] +
          $user_totals['click_external_commission'] +
          $user_totals['click_form_commission']
        ) ?>
      </span> 
    </div>
  </div>
  <ul>
    <li class="d-flex"> 
      <span><?= __('user.local_store') ?></span>
      <strong>
        <?= (int)$user_totals['click_localstore_total'] ?>
        / 
        <?= $fun_c_format($user_totals['click_localstore_commission']) ?>
      </strong>
    </li>
    <li class="d-flex"> 
      <span><?= __('user.external') ?></span>
      <strong>
        <?= (int)$user_totals['click_external_total'] ?>
        / 
        <?= $fun_c_format($user_totals['click_external_commission']) ?>
      </strong>
    </li>
    <li class="d-flex"> 
      <span><?= __('user.forms') ?></span>
      <strong>
        <?= (int)$user_totals['click_form_total'] ?>
        / 
        <?= $fun_c_format($user_totals['click_form_commission']) ?>
      </strong>
    </li>
    <li class="d-flex"> 
      <span><?= __('user.vendor_local_store') ?></span>
      <strong>
        <?= (int)$user_totals['vendor_click_localstore_total'] ?>
        / 
        <?= $fun_c_format($user_totals['vendor_click_localstore_commission_pay']) ?>
      </strong>
    </li>
    <li class="d-flex"> 
      <span><?= __('user.vendor_external') ?></span>
      <strong>
        <?= (int)$user_totals['vendor_click_external_total'] ?>
        / 
        <?= $fun_c_format($user_totals['vendor_click_external_commission_pay']) ?>
      </strong>
    </li>
  </ul>
</div>
</div>
<div class="dashboard-div">
  <div class="dashboard-user-details wallet-details">
    <div class="user-header d-flex align-items-center">
      <div class="header-img"> 
        <img src="<?= base_url('assets/template/images/percentage-icon.png') ?>" alt="<?= __('user.order_commission') ?>"> 
      </div>
      <div>
        <h2><?= __('user.order_commission') ?></h2>
        <span><?= __('user.total') ?> 
        <?= (int)(
          $user_totals['sale_localstore_count'] +
          $user_totals['order_external_count'] 
        ) ?> 
        / 
        <?= $fun_c_format(
          $user_totals['sale_localstore_commission'] +
          $user_totals['order_external_commission'] 
        ) ?>
      </span> 
    </div>
  </div>
  <ul>
    <li class="d-flex"> 
      <span><?= __('user.local_store') ?></span> 
      <strong>
        <?= (int)$user_totals['sale_localstore_count'] ?>
        / 
        <?= $fun_c_format($user_totals['sale_localstore_commission']) ?>
      </strong>
    </li>
    <li class="d-flex"> 
      <span><?= __('user.external') ?></span> 
      <strong>
        <?= (int)$user_totals['order_external_count'] ?>
        / 
        <?= $fun_c_format($user_totals['order_external_commission']) ?>
      </strong>
    </li>
    <li class="d-flex"> 
      <span><?= __('user.vendor_local_store') ?></span> 
      <strong>
        <?= (int)$user_totals['vendor_sale_localstore_count'] ?>
        / 
        <?= $fun_c_format($user_totals['vendor_sale_localstore_commission_pay']) ?>
      </strong>
    </li>
    <li class="d-flex"> 
      <span><?= __('user.vendor_external') ?></span> 
      <strong>
        <?= (int)$user_totals['vendor_order_external_count'] ?>
        / 
        <?= $fun_c_format($user_totals['vendor_order_external_commission_pay']) ?>
      </strong>
    </li>
  </ul>
</div>
</div>
<?php if($refer_status){ ?>
  <div class="dashboard-div">
    <div class="dashboard-user-details wallet-details">
      <div class="user-header d-flex align-items-center">
        <div class="header-img"> 
          <img src="<?= base_url('assets/template/images/vendor-icon.png') ?>" alt="<?= __('user.refered_levels') ?>"> 
        </div>
        <div>
          <h2><?= __('user.refered_levels') ?></h2>
        </div>
      </div>
      <ul>
        <li class="d-flex"> 
          <span><?= __('user.product_click') ?></span> 
          <strong>
            <?= (int)$refer_total['total_product_click']['clicks'] ?> 
            / 
            <?= $fun_c_format($refer_total['total_product_click']['amounts']) ?>
          </strong> 
        </li>
        <li class="d-flex"> 
          <span><?= __('user.sale') ?></span> 
          <strong>
            <?= (int)$refer_total['total_product_sale']['counts'] ?> 
            / 
            <?= $fun_c_format($refer_total['total_product_sale']['amounts']) ?>
          </strong> 
        </li>
        <li class="d-flex"> 
          <span><?= __('user.general_click') ?></span> 
          <strong>
            <?= (int)$refer_total['total_ganeral_click']['total_clicks'] ?> 
            / 
            <?= $fun_c_format($refer_total['total_ganeral_click']['total_amount']) ?>
          </strong> 
        </li>
        <li class="d-flex"> 
          <span><?= __('user.action') ?></span> 
          <strong>
            <?= (int)$refer_total['total_action']['click_count'] ?> 
            / 
            <?= $fun_c_format($refer_total['total_action']['total_amount']) ?>
          </strong> 
        </li>
      </ul>
    </div>
  </div>
<?php } ?>
<?php if(isShowUserControlParts($userdashboard_settings['top_affiliate']) && allowMarketVendorPanelSections($marketvendorpanelmode, $userdetails['is_vendor'])){ ?>
  <div class="dashboard-div p-0">
    <div class="dashboard-user-details wallet-details top-affiliates">
      <div class="d-flex align-items-center user-header p-3">
        <div>
          <h2><?= __('user.popular_affiliates') ?></h2>
        </div>
      </div>
      <div class="affiliate-table">
        <table>
          <thead>
            <tr>
              <th><?= __('user.name') ?></th>
              <th><?= __('user.country') ?></th>
              <th><?= __('user.commission') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($populer_users as $key => $users){
              $flag = '';
              if($users['sortname'] != '')
                $flag = base_url('assets/vertical/assets/images/flags/' . strtolower($users['sortname']) . '.png'); ?>
              <tr>
                <td>
                  <img src="<?= $products->getAvatar($users['avatar']) ?>" alt=""> 
                  <?= $users['firstname'].' '.$users['lastname']; ?>
                </td>
                <td><img src="<?= $flag; ?>" alt="<?= __('user.flag') ?>"></td>
                <td><?= $fun_c_format($users['all_commition']); ?></td>
              </tr>
            <?php } ?>  
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php } ?>  
</div>
<div class="dashboard-right">
  <div class="dashboard-div p-4">
    <div class="graph-header d-flex flex-wrap align-items-center justify-content-between">
      <h2><?= __('user.user_overview') ?></h2>
      <ul class="d-flex flex-wrap">
        <li class="d-flex admin-balance">
          <div class="arrow-div"> <span></span> </div>
          <div class="earning-text"> 
            <span><?= __('admin.weekly_earnings') ?><em class="orange-color"><?= $user_totals_week ?></em> </span> 
          </div>
        </li>
        <li class="d-flex arrow-red admin-balance">
          <div class="arrow-div"> <span></span> </div>
          <div class="earning-text"> 
            <span><?= __('admin.monthly_earnings') ?><em class="rad-color"><?= $user_totals_month ?></em> </span>
          </div>
        </li>
        <li class="d-flex admin-balance">
          <div class="arrow-div"> <span></span> </div>
          <div class="earning-text"> 
            <span><?= __('admin.yearly_earnings') ?><em class="orange-color"><?= $user_totals_year ?></em> </span> 
          </div>
        </li>
      </ul>
    </div>
    <div class="graph-filter">
      <select onchange="loadDashboardChart()" class="renderChart chart-input form-control" name="group">
        <option value="day" ><?= __('admin.day') ?></option>
        <option value="week"><?= __('admin.week') ?></option>
        <option value="month" selected=""><?= __('admin.month') ?></option>
        <option value="year"><?= __('admin.year') ?></option>
      </select>

      <select onchange="loadDashboardChart()" class="yearSelection chart-input form-control" name="year">
        <?php for($i=2016; $i<= date("Y"); $i++){ ?>
          <option value="<?= $i ?>" <?php echo $i==date("Y") ? "selected='selected'" : '' ?>><?= $i ?></option>
        <?php  } ?>
      </select>
    </div> 
    <div class="graph-chart">
      <script src="<?= base_url('assets/plugins/chart/chart.min.js') ?>"></script>
      <canvas id="dashboard-chart" class="ct-chart ct-golden-section"></canvas>
      <div id="dashboard-chart-empty" class="ct-chart d-none ct-golden-section">
        <img src="<?= base_url('assets/vertical/assets/images/no-data-2.png'); ?>">
        <h3><?= __('admin.not_activity_yet') ?></h3>
      </div>
      <script type="text/javascript">
        var ctx = document.getElementById('dashboard-chart').getContext('2d');
        var chartData = <?= json_encode($chart) ?>;

        var months = [
        '<?= __('user.january') ?>',
        '<?= __('user.february') ?>',
        '<?= __('user.march') ?>',
        '<?= __('user.april') ?>',
        '<?= __('user.may') ?>',
        '<?= __('user.june') ?>',
        '<?= __('user.july') ?>',
        '<?= __('user.august') ?>',
        '<?= __('user.september') ?>',
        '<?= __('user.october') ?>',
        '<?= __('user.november') ?>',
        '<?= __('user.december') ?>',
        ];

        var chart = new Chart(ctx,{
          type: 'line',
          data: {},
          options: {
            tooltips: {
              mode: 'index',
              intersect: false
            },
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  usePointStyle: true,
                },
              }
            },
            responsive: true,
          }
        });

        function renderDashboardChart(chartData){
          chart.data = {
            labels: months,
            position: 'bottom',
            datasets: [
            {
              label: '<?= __('user.action_count') ?>',
              fill: false,
              borderWidth: 3,
              backgroundColor: 'rgb(54, 162, 235)',
              borderColor: 'rgb(54, 162, 235)',
              data: Object.values(chartData['action_count']),
              pointStyle: 'line'
            },
            {

              label: '<?= __('user.order_count') ?>',
              fill: false,
              borderWidth: 3,
              backgroundColor: 'rgb(255, 205, 86)',
              borderColor: 'rgb(255, 205, 86)',
              data: Object.values(chartData['order_count']),
              pointStyle: 'line'
            },
            {
              label: '<?= __('user.order_commission') ?>',
              fill: false,
              borderWidth: 3,
              backgroundColor: 'rgb(29, 201, 183)',
              borderColor: 'rgb(29, 201, 183)',
              data: Object.values(chartData['order_commission']),
              pointStyle: 'line'
            },
            {
              label: '<?= __('user.action_commission') ?>',
              fill: false,
              borderWidth: 3,
              backgroundColor: 'rgb(75, 192, 192)',
              borderColor: 'rgb(75, 192, 192)',
              data: Object.values(chartData['action_commission']),
              pointStyle: 'line'
            },
            {
              label: '<?= __('user.order_total') ?>',
              fill: false,
              borderWidth: 3,
              backgroundColor: 'rgb(253, 57, 122)',
              borderColor: 'rgb(253, 57, 122)',
              data: Object.values(chartData['order_total']),
              pointStyle: 'line'
            },
            ]
          }

          chart.update();
        }

        function loadDashboardChart(){
          $.ajax({
            url:'<?= base_url("usercontrol/dashboard?getChartData=1") ?>',
            type:'POST',
            dataType:'json',
            data:$(".chart-input"),
            beforeSend:function(){},
            complete:function(){},
            success:function(json){
              if(json['chart']){
                $("#dashboard-chart-empty").addClass('d-none');
                $("#dashboard-chart").removeClass('d-none');

                renderDashboardChart(json['chart']);
              } else {
                $("#dashboard-chart-empty").removeClass('d-none');
                $("#dashboard-chart").addClass('d-none');
              }
            },
          })
        }

        loadDashboardChart()
      </script>
    </div>
  </div>
  <div class="dashboard-div p-4">
    <div class="link-details">
      <div class="user-header d-flex align-items-center justify-content-between  p-0">
        <?php 
        if($store['status'] || $refer_status){ 

          $invitationlinkid=0;
          if(isset($userdashboard_settings) && isset($userdashboard_settings['invitation_link_id']))
          {
            $invitationlinkidarray=$userdashboard_settings['invitation_link_id'];
            $invitationlinkid=$invitationlinkidarray['setting_value'];
          }

          if($invitationlinkid==0)
          {
          ?>
          <div>
            <h2><?= __('user.your_affiliate_id') ?> : <?= $userdetails['id'] ?></h2>
          </div>
          <div class="checkbox-wrapp">
            <label> <?= __('user.show_my_id') ?>
            <input id="show_my_id" type="checkbox">
            <span class="checkmark"></span> 
          </label>
        </div>
      <?php
        } 
    } 
      else { ?>
        <div>
          <h2><?= __('user.your_affiliate_id').' : '.$userdetails['id'] ?></h2></br>
          <h5><?= __('user.affiliate_username').' : '.$userdetails['username'] ?></h5>
          <h5><?= __('user.affiliate_name').' : '.$userdetails['firstname'].' '.$userdetails['lastname'] ?></h5>
          <h5><?= __('user.affiliate_email').' : '.$userdetails['email'] ?></h5>
        </div>
      <?php } ?>
    </div>
    <?php if($store['status'] || $refer_status){ ?>
      <?php if(($store['status'])){
        $share_url = ($store_slug) ? base_url($store_slug) : base_url('store/' . base64_encode($userdetails['id'])); ?>
        <div class="affiliate-id-main">
          <p><?= __('user.affiliate_store_url') ?></p>
          <div class="link-area show-tiny-link <?php if($invitationlinkid==1) { echo 'd-none';} ?>" >

            <input type="text" readonly="readonly" value="<?= $share_url ?>" class="input-store-url-0">
           
            <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $share_url ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

            <a href="<?= $share_url ?>" class="target-share-link" target="_blank">
              <i class="fas fa-link"></i>
            </a> 
            <a href="javascript:void(0)" copyToClipboard="<?= $share_url ?>">
              <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('user.copy') ?>">
            </a> 
            <a href="javascript:void(0)" class="dashboard-model-slug" data-type="store" data-related-id="0" data-input-class="input-store-url-0">
              <img src="<?= base_url('assets/template/images/user-settings-icon.png') ?>" alt="<?= __('user.setting') ?>">
            </a> 
            <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>?id=<?= $userdetails['id'] ?>" data-share-title="" data-share-desc="">
              <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
            </a> 
          </div>
          <div class="link-area show-mega-link  <?php if($invitationlinkid==0) { echo 'd-none';} ?>">
            <input type="text" readonly="readonly" value="<?= $share_url.'/?id='.$userdetails['id'] ?>" class="input-store-url-0" data-addition-url="/?id=<?= $userdetails['id'] ?>">

             <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $share_url.'/?id='.$userdetails['id'] ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

            <a href="<?= $share_url.'/?id='.$userdetails['id'] ?>" class="target-share-link" target="_blank">
              <i class="fas fa-link"></i>
            </a>
            <a href="javascript:void(0)" copyToClipboard="<?= $share_url.'/?id='.$userdetails['id'] ?>">
              <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('user.copy') ?>">
            </a> 
            <a href="javascript:void(0)" class="dashboard-model-slug" data-type="store" data-related-id="0" data-input-class="input-store-url-0">
              <img src="<?= base_url('assets/template/images/user-settings-icon.png') ?>" alt="<?= __('user.setting') ?>">
            </a>
            <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>?id=<?= $userdetails['id'] ?>" data-share-title="" data-share-desc="">
              <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
            </a>  
          </div>
        </div>    

        <?php 
        if(isset($userdetails['store_slug']) && !empty($userdetails['store_slug'])){
          $store_page_url = base_url('store/' .$userdetails['store_slug'].'/'.base64_encode($userdetails['id'])); ?>
          <div class="affiliate-id-main last p-0 m-0">
            <p><?= __('user.your_store_page') ?></p>
            <div class="link-area show-tiny-link <?php if($invitationlinkid==1) { echo 'd-none';} ?>">
              <input type="text" readonly="readonly" value="<?= $store_page_url ?>" class="input-store-url-0">
              
               <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $store_page_url ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

              <a href="javascript:void(0)" copyToClipboard="<?= $store_page_url ?>">
                <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('user.copy') ?>">
              </a> 
              <a href="javascript:void(0)" class="dashboard-model-slug" data-type="store" data-related-id="0" data-input-class="input-store-url-0">
                <img src="<?= base_url('assets/template/images/user-settings-icon.png') ?>" alt="<?= __('user.setting') ?>">
              </a>
              <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>?id=<?= $userdetails['id'] ?>" data-share-title="" data-share-desc="">
                <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
              </a>  
            </div>
            <div class="link-area show-mega-link <?php if($invitationlinkid==0) { echo 'd-none';} ?>">
              <input type="text" readonly="readonly" value="<?= $store_page_url.'/?id='.$userdetails['id'] ?>" class="input-store-url-0" data-addition-url="/?id=<?= $userdetails['id'] ?>">

               <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $store_page_url.'/?id='.$userdetails['id'] ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>  

              <a href="javascript:void(0)" copyToClipboard="<?= $store_page_url.'/?id='.$userdetails['id'] ?>">
                <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('user.copy') ?>">
              </a> 
              <a href="javascript:void(0)" class="dashboard-model-slug" data-type="store" data-related-id="0" data-input-class="input-store-url-0">
                <img src="<?= base_url('assets/template/images/user-settings-icon.png') ?>" alt="<?= __('user.setting') ?>">
              </a>
              <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>?id=<?= $userdetails['id'] ?>" data-share-title="" data-share-desc="">
                <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
              </a> 
            </div>
          </div>
        <?php }
      } ?>

      <?php if($refer_status && allowMarketVendorPanelSections($marketvendorpanelmode, $userdetails['is_vendor'])){
        if($register_slug)
          $share_url = base_url($register_slug);
        else
          $share_url = base_url('register/' . base64_encode($userdetails['id']));?>
        <div class="affiliate-id-main">
          <p><?= __('user.your_unique_reseller_link') ?></p>
          <div class="link-area show-tiny-link <?php if($invitationlinkid==1) { echo 'd-none';} ?>" >
            <input type="text" readonly="readonly" value="<?= $share_url ?>" class="input-register-url-0">
            <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $share_url ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

            <a href="javascript:void(0)" copyToClipboard="<?= $share_url ?>">
              <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('user.copy') ?>">
            </a> 
            <a href="javascript:void(0)" class="dashboard-model-slug" data-type="register" data-related-id="0" data-input-class="input-register-url-0">
              <img src="<?= base_url('assets/template/images/user-settings-icon.png') ?>" alt="<?= __('user.setting') ?>">
            </a>
            <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>?id=<?= $userdetails['id'] ?>" data-share-title="" data-share-desc="">
              <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
            </a> 
          </div>
          <div class="link-area show-mega-link <?php if($invitationlinkid==0) { echo 'd-none';} ?>">
            <input type="text" readonly="readonly" value="<?= $share_url.'/?id='.$userdetails['id'] ?>" class="input-register-url-0" data-addition-url="/?id=<?= $userdetails['id'] ?>">
           <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $share_url.'/?id='.$userdetails['id'] ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

            <a href="javascript:void(0)" copyToClipboard="<?= $share_url.'/?id='.$userdetails['id'] ?>">
              <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('user.copy') ?>">
            </a> 
            <a href="javascript:void(0)" class="dashboard-model-slug" data-type="register" data-related-id="0" data-input-class="input-register-url-0">
              <img src="<?= base_url('assets/template/images/user-settings-icon.png') ?>" alt="<?= __('user.setting') ?>">
            </a>
            <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>?id=<?= $userdetails['id'] ?>" data-share-title="" data-share-desc="">
              <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
            </a>  
          </div>
        </div>
      <?php } ?>

     
    <?php } ?>
  </div>
</div>
<?php if(allowMarketVendorPanelSections($marketvendorpanelmode, $userdetails['is_vendor'])) { ?>
<div class="dashboard-div affiliate-links">
  <script type="text/javascript">
    $(".display-vendor-links").change(function(){
      getMarketTools();
    })

    function getMarketTools(page) {
      $this = $(this);
      $.ajax({
        url:'<?= base_url('usercontrol/dashboard') ?>',
        type:'POST',
        dataType:'json',
        data:{
          get_tools:true,
          page:page
        },
        beforeSend:function(){
          $(".site-order #affiliate-accordion").html("<p class='text-center'>"+'<?= __('user.loading') ?>'+"....</p>");
        },
        complete:function(){
        },
        success:function(json){
          if(json['html']){
            $(".site-order .pagination-div").html(json['pagination']);
            $(".site-order #affiliate-accordion").html(json['html']);
          }
        },
      })
    }

    getMarketTools(1);

    $(document).on('click','.site-order .pagination-div ul li a',function(e){
      e.preventDefault();

      let page = $(this).data('ci-pagination-page');
      if(page)
        getMarketTools(page);
    })
    $(document).on('click','.qrcode',function(){
        $('#model-codemodal .modal-body').html("<span id='QRDataModal'></span>");
        $("#model-codemodal").modal("show");
        var qrdata = $(this).attr('data-id');
        var qrcode = new QRCode(document.getElementById("QRDataModal"), {
            text: qrdata,
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

    })
  </script>
  <div class="site-order">
    <div class="user-header display-header p-0">
      <div class="user-header">
        <h2><?= __('user.affiliates_links...') ?></h2>
        <div class="site-order-wrapp d-flex align-items-center justify-content-between flex-wrap">
          <div>
            <div class="pagination-div bg-area"></div>
          </div>
        </div>
      </div>
      <div class="accordion-section">
        <div class="accordion-wrap">
          <div class="accordioni-containt accordion-head">
            <ul>
              <li><?= __('user.image') ?></li>
              <li class="name-text"><?= __('user.name') ?></li>
              <li class="offer-text"><?= __('user.commission') ?></li>
              <li><?= __('user.link') ?></li>
            </ul>
          </div>
          <div class="accordion" id="affiliate-accordion">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
</div>

<div class="modal fade" id="model-codemodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= __('user.close') ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="model-codeformmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= __('user.close') ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="model-codeprogrammodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= __('user.close') ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="integration-code">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= __('user.close') ?></button>
      </div>
    </div>
  </div>
</div>



<?= $social_share_modal ?>

<?php if(isset($welcome['show_popup']) && $welcome['show_popup']=='enable' ) { ?>
<div id="welcome-model" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center w-100"><?=$welcome['heading']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
         <iframe class="embed-responsive-item" allowfullscreen id="ifrm_id"></iframe>
        </div>
         <br/>
        <div style="height: 150px;overflow:auto;">
            <div>
              <?php echo nl2br($welcome['content']); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= __('user.close') ?></button>
        <button type="button" class="btn btn-primary" onclick="return closeWelcomePopup()" ><?= __('user.close_forever') ?></button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function loadIframe(iframeName, url) {
    var $iframe = $('#' + iframeName);
    if ( $iframe.length ) {
        $iframe.attr('src',url);   
        return false;
    }
    return true;
}
   $(document).ready(function() { 

     var welcome_popup = localStorage.getItem("welcome_popup_"+<?=$userdetails['id'];?>); 
     if(welcome_popup!=1)
      {
        $("#welcome-model").modal('show');   
         var url = '<?=$welcome['video_link']?>';
        if(url.toLowerCase().includes("youtube") && !url.toLowerCase().includes("embed")){
          $id = url.split("v=");
          url = 'https://www.youtube.com/embed/'+$id[1];
        } else if(url.toLowerCase().includes("youtu") && !url.toLowerCase().includes("embed")){
          $id = url.split("/");
          url = 'https://www.youtube.com/embed/'+$id[3];
        }
          loadIframe('ifrm_id',url);
     } 
});

   function closeWelcomePopup()
   { 
    var ans=confirm('<?=__('user.are_you_sure');?>');
    if(ans)
      localStorage.setItem("welcome_popup_"+<?=$userdetails['id'];?>, 1);

    $("#welcome-model").modal('hide');   
   }
 </script>

<?php } ?>

<script type="text/javascript">

  $("#show_my_id").change(function(){
    if($(this).prop("checked")){
      $(".show-mega-link").removeClass("d-none");
      $(".show-tiny-link").addClass("d-none");
    } else {
      $(".show-mega-link").addClass("d-none");
      $(".show-tiny-link").removeClass("d-none");
    }
  })

  function setColors() {
    $(".set-color").each(function(i,ele){
      var val =  parseInt($(ele).html().toString().replace(/[^0-9-.]/g, '') || 0);

      $(ele).removeClass("text-primary")
      $(ele).removeClass("text-danger")
      if(val >= 0){
        $(ele).addClass("text-primary");
      } else{
        $(ele).addClass("text-danger");
      }
    })
  }

  setColors();

  $(".card-toggle .open-close-button").click(function(){
    $(this).parents(".card-toggle").toggleClass("open")
  });

  function generateCode(affiliate_id,t){
    $this = $(t);
    $.ajax({
      url:'<?= base_url('usercontrol/generateproductcode/') ?>'+affiliate_id,
      type:'POST',
      dataType:'html',
      success:function(json){
        $('#model-codemodal .modal-body').html(json)
        $("#model-codemodal").modal("show")
      },
    })
  }

  function generateCodeForm(form_id,t){ 
    $this = $(t);
    $.ajax({
      url:'<?= base_url('usercontrol/generateformcode/') ?>'+form_id,
      type:'POST',
      dataType:'html',
      success:function(json){
        $('#model-codeformmodal .modal-body').html(json)
        $("#model-codeformmodal").modal("show")
      },
    })
  }

  $(document).delegate(".get-code",'click',function(){
    $this = $(this);
    $.ajax({
      url:'<?= base_url('integration/tool_get_code/usercontrol') ?>',
      type:'POST',
      dataType:'json',
      data:{id:$this.attr("data-id")},
      success:function(json){
        if(json['html']){
          $("#model-codeprogrammodal .modal-content").html(json['html']);
          $("#model-codeprogrammodal").modal("show");
        }
      },
    })
  })

  $(document).delegate(".get-terms",'click',function(){
    $this = $(this);
    $.ajax({
      url:'<?= base_url('integration/tool_get_terms/usercontrol') ?>',
      type:'POST',
      dataType:'json',
      data:{id:$this.attr("data-id")},
      success:function(json){
        if(json['html']){
          $("#integration-code .modal-content").html(json['html']);
          $("#integration-code").modal("show");
        }
      },
    })
  });

</script>
