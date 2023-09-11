<?php
$db =& get_instance();
$userdetails = get_object_vars($db->user_info());
$products = $db->Product_model;
$notifications_count = $products->getnotificationnew_count('admin',null);
?>

<?php
    $integration_data_per_page = 10;
    $page_count = ceil(count($integration_data['array']) / $integration_data_per_page);
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/flag/css/main.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/table/datatables.min.css") ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/wallet.css?v='. time()) ?>">

<div>
    <div class="row sectiontwo">
        <div class="col-12">
            <div class="card card-statistics">
             <div class="card-body">
              <div class="row">
               <div class="col-md-2 statistics-item">
                <p>
                 <i class="icon-sm fas fa-user-check mr-2"></i>
                 <?= __('admin.admin_balance') ?>
                </p>
                 <h2 class="ajax-admin_balance"><?= $fun_c_format($admin_totals['admin_balance']) ?></h2>
                 <label class="badge badge-outline-success badge-pill"><span class="ajax-admin_balance_growth"><?= $admin_totals['admin_balance_growth']; ?></span>% <?= __('admin.increase') ?></label>
                </div>
                 <div class="col-md-2 statistics-item">
                    <p>
                     <i class="icon-sm fas fa-user-cog mr-2"></i>
                     <?= __('admin.all_actions') ?>
                 </p>
                 <h2>
                    <span class="ajax-click_action_total"><?= (int)$admin_totals['click_action_total'] ?></span>
                    / 
                    <span class="ajax-click_action_commission"><?= $fun_c_format($admin_totals['click_action_commission']) ?></span>
                </h2>
                <label class="badge badge-outline-success badge-pill"><span class="ajax-click_action_commission_growth"><?= $admin_totals['click_action_commission_growth']; ?></span>% <?= __('admin.increase') ?></label>
                </div>

                <div class="col-md-2 statistics-item">
                    <p>
                     <i class="fas fa-bullseye mr-2 icon-sm"></i>
                     <?= __('admin.admin_all_clicks') ?>
                 </p>
                 <h2>
                    <span class="ajax-all_click_total">  <?= (int)($admin_totals['click_localstore_total'] + 
                        $admin_totals['click_integration_total'] + 
                        $admin_totals['click_form_total']   ) ?>
                    </span>
                    / 
                    <span class="ajax-all_click_commission">
                        <?= $fun_c_format(
                            $admin_totals['click_localstore_commission'] +
                            $admin_totals['click_integration_commission'] +
                            $admin_totals['click_form_commission']
                        ) ?>
                    </span>
                </h2>
                <label class="badge badge-outline-success badge-pill"><span class="ajax-all_clicks_comission_growth"><?= $admin_totals['all_clicks_comission_growth']; ?></span>% <?= __('admin.increase') ?></label>
                </div>
                <div class="col-md-2 statistics-item">
                    <p>
                     <i class="icon-sm fas fa-chart-line mr-2"></i>
                     <?= __('admin.admin_sales') ?>
                 </p>
                 <h2 class="ajax-sale_total_admin_store">
                    <?= $fun_c_format($admin_totals['sale_localstore_total'] + $admin_totals['order_external_total']) ?>
                </h2>
                <label class="badge badge-outline-success badge-pill"><span class="ajax-admin_all_sales_growth"><?= $admin_totals['admin_all_sales_growth']; ?></span>% <?= __('admin.increase') ?></label>
                </div>
                <div class="col-md-2 statistics-item">
                    <p>
                     <i class="icon-sm fas fa-balance-scale mr-2"></i>
                     <?= __('admin.admin_vendor_sales') ?>
                 </p>
                 <h2 class="ajax-sale_localstore_vendor_total">
                    <?= $fun_c_format($admin_totals['sale_localstore_vendor_total']) ?></h2>
                    <label class="badge badge-outline-success badge-pill"><span class="ajax-vendor_all_sales_growth"><?= $admin_totals['vendor_all_sales_growth']; ?></span>% <?= __('admin.increase') ?></label>
                </div>
                <div class="col-md-2 statistics-item">
                    <p><i class="icon-sm fas fa-balance-scale mr-2"></i>
                     <?= __('admin.admin_total_online') ?> 
                    </p>
                     <ul class="d-flex total-area">
                        <li class="text-center"><?= __('admin.admin_admin') ?>
                        <strong class="ajax-online-admin"><?= (int)$online_count['admin']['online'] ?></strong>
                    </li>
                    <li class="text-center"><?= __('admin.admin_affiliate') ?>
                    <strong class="ajax-online-affiliate"><?= (int)$online_count['user']['online'] ?></strong>
                    </li>
                    <li class="text-center border-0"><?= __('admin.admin_vendor') ?>
                    <strong class="ajax-online-vendor"><?= (int)$online_count['vendor']['online'] ?></strong>
                    </li>
                    <li class="text-center border-0"><?= __('admin.admin_client') ?>
                    <strong class="ajax-online-client"><?= (int)$online_count['client']['online'] ?></strong>
                    </li>
                    </ul>
                </div>
              </div>
             </div>
            </div>
        </div>
    </div>

    <div class="row sectionone">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0"><?= __('admin.auto_reload') ?></h4>
            <div class="d-flex justify-content-between align-items-center">
            <div class="d-inline-block pt-3">
            <div class="d-md-flex">
               <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                <i class="far fa-clock text-muted"></i>
                <small class="ml-1 mb-0">
                    <?= __('admin.last_updated') ?>
                    <span class="server-last-update">
                        <?= date("h:i:s A") ?>
                    </span>
                </small>
                <i class="far fa-clock text-muted"></i>
                <small class="ml-1 mb-0">
                    <?= __('admin.session_timeout') ?>:
                    <span class="dashboard-refresh">
                       <em>00:01:00</em>
                   </span>
                </small>
               <i class="far fa-clock text-muted"></i>
               <small class="ml-1 mb-0">
                    <?= __('admin.version_number') ?>:
                    <span class="">
                         <a href="<?= base_url('admincontrol/script_details') ?>"></a>
                       <?php echo SCRIPT_VERSION ?>
                   </span>
               </small>
                </div>
            </div>
            </div>
                <div>
                <?php if(is_countable($serverReq) && count($serverReq) == 0){ ?>
                <a href="javascript:void(0);"><i class="fas fa-check icon-lg"></i></a> 
                <?php } else { ?> 
                <a href="javascript:void(0);"><i class="fas fa-close icon-lg"></i></a>
                <?php } ?>
                <a href="<?= base_url($front_url_slug) ?>" target="_blank"><i class="fas fa-eye icon-lg"></i></a>
                <a href="javascript:void(0);"><i class="fas fa-cog icon-lg btn_setting" data-key='live_dashboard' data-type='admin'></i></a>
                <a href="javaScript:location.reload(true);" class="reload-btn" title="<?= ('admin.refresh_page') ?>">
                <i class="fas fa-redo icon-lg"></i>
                </a>                                
                </div>
                </div>
                    <div class="progress">
                        <div class="color"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
            <?php 
            $top_user = isset($populer_users[0]) ? $populer_users[0] : false;
            if(isset($top_user)){
            $users_pic =  (!empty($products->getAvatar($top_user['avatar']))) ? ($products->getAvatar($top_user['avatar'])) : base_url('assets/vertical/assets/images/no-image.jpg'); ?>

            <div class="d-flex justify-content-between align-items-center">
                    <div class="admin-balance sectionone-right">
                        <div class="user-info"> 
                            <img src="<?= $users_pic ?>" alt="<?= $top_user['firstname'].' '.$top_user['lastname'] ?>">
                            <div class="country-flag"> 
                                <?php if($top_user['sortname']){ ?>
                                    <img src="<?= base_url('assets/vertical/assets/images/flags/' . strtolower($top_user['sortname']) . '.png') ?>" alt="<?= strtolower($top_user['sortname']) ?>"> 
                                <?php } ?>
                            </div>
                        </div>
                        <div class="separate-border"> 
                            <span><?= __( 'admin.top_user' ) ?> <h2><?= $top_user['firstname'].' '.$top_user['lastname'] ?>
                        </h2></span> 
                    </div>
                    <div class="separate-border"> 
                        <span><?= __( 'admin.admin_balance' ) ?> <h2><?= $fun_c_format($top_user['amount']) ?></h2></span> 
                    </div>
                    <div class="separate-border"> 
                        <span><?= __( 'admin.admin_commission' ) ?> <h2><?= $fun_c_format($top_user['all_commition']) ?></h2></span> 
                    </div>
                    </div>
            </div>
            <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!--invite vendor + affiliate-->
    <div class="row sectionone">
         <div class="col">
            <div class="card">
                <div class="card-body">
                    <div>
                      <?php $share_url = base_url('register/' . base64_encode($userdetails['id'])); ?>
                      <div class="user-header d-flex align-items-center border-0 p-0">
                          <div>
                              <div class="card-title"><?= __('admin.register_new_affiliate_account_link') ?></div>
                          </div>
                      </div>
                      <div class="link-area d-flex">
                          <input id="unique_re_link" type="text" readonly="readonly" value="<?= $share_url ?>">
                          <a href="javascript:void(0);" copyToClipboard="<?= $share_url ?>">
                              <img src="<?= base_url('assets/template/images/copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                          </a>
                          <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>" data-share-title=""              data-share-desc="">
                              <img src="<?= base_url('assets/template/images/user-share-icon1.png') ?>" alt="<?= __('admin.share') ?>"> 
                          </a>
                      </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                   <div>
                  <?php $share_url = base_url('register/vendor'); ?>
                  <div class="user-header d-flex align-items-center border-0 p-0">
                      <div>
                          <div class="card-title"><?= __('admin.register_new_vendor_account_link') ?></div>
                      </div>
                  </div>
                  <div class="link-area d-flex">
                      <input id="unique_re_link" type="text" readonly="readonly" value="<?= $share_url ?>">
                      <a href="javascript:void(0);" copyToClipboard="<?= $share_url ?>">
                          <img src="<?= base_url('assets/template/images/copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                      </a>
                      <a href="javascript:void(0)" data-social-share data-share-url="<?= $share_url; ?>" data-share-title=""              data-share-desc="">
                          <img src="<?= base_url('assets/template/images/user-share-icon1.png') ?>" alt="<?= __('admin.share') ?>"> 
                      </a>
                  </div>
              </div>
                </div>
            </div>
        </div>
    </div>
    <!--invite vendor + affiliate-->

    <!--graph + map-->
    <div class="row sectionfour">
         <div class="col-lg-6 p-0"> <div class="dashboard-div pl-4 pr-4 pt-5 pb-4">
            <div class="graph-header d-flex flex-wrap align-items-center justify-content-between">
                <ul class="d-flex flex-wrap">
                    <li class="d-flex admin-balance">
                        <div class="arrow-div"> <span></span> </div>
                        <div class="earning-text"> 
                            <span>
                                <?= __('admin.weekly_earnings') ?>
                                <em class="ajax-weekly_balance"><?= $admin_totals_week ?></em> 
                            </span> 
                        </div>
                    </li>
                    <li class="d-flex arrow-red admin-balance  graph-header-li">
                        <div class="arrow-div"> <span></span> </div>
                        <div class="earning-text"> 
                            <span>
                                <?= __('admin.monthly_earnings') ?>
                                <em class="rad-color ajax-monthly_balance"><?= $admin_totals_month ?></em> 
                            </span> 
                        </div>
                    </li>
                    <li class="d-flex admin-balance">
                        <div class="arrow-div"> <span></span> </div>
                        <div class="earning-text"> 
                            <span>
                                <?= __('admin.yearly_earnings') ?>
                                <em class="ajax-yearly_balance"><?= $admin_totals_year ?></em> 
                            </span> 
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

                <select onchange="loadDashboardChart()" class="yearSelection chart-input form-control" name='year'>
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
                        '<?= __('admin.january') ?>',
                        '<?= __('admin.february') ?>',
                        '<?= __('admin.march') ?>',
                        '<?= __('admin.april') ?>',
                        '<?= __('admin.may') ?>',
                        '<?= __('admin.june') ?>',
                        '<?= __('admin.july') ?>',
                        '<?= __('admin.august') ?>',
                        '<?= __('admin.september') ?>',
                        '<?= __('admin.october') ?>',
                        '<?= __('admin.november') ?>',
                        '<?= __('admin.december') ?>',
                        ];

                        var chart = new Chart(ctx, {
                            type: 'line',
                            data: {},
                            options: {
                                tooltips: {
                                    mode: 'index',
                                    intersect: false
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
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
                                datasets: [
                                {
                                    label: '<?= __('admin.action_count') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(54, 162, 235)',
                                    backgroundColor: 'rgb(54, 162, 235)',
                                    data: Object.values(chartData['action_count']),
                                    pointStyle: 'line'
                                },
                                {

                                    label: '<?= __('admin.order_count') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(255, 205, 86)',
                                    backgroundColor: 'rgb(255, 205, 86)',
                                    data: Object.values(chartData['order_count']),
                                    pointStyle: 'line'
                                },
                                {
                                    label: '<?= __('admin.order_commission') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(29, 201, 183)',
                                    backgroundColor: 'rgb(29, 201, 183)',
                                    data: Object.values(chartData['order_commission']),
                                    pointStyle: 'line'
                                },
                                {
                                    label: '<?= __('admin.action_commission') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(75, 192, 192)',
                                    backgroundColor: 'rgb(75, 192, 192)',
                                    data: Object.values(chartData['action_commission']),
                                    pointStyle: 'line'
                                },

                                {
                                    label: '<?= __('admin.order_total') ?>',
                                    fill: false,
                                    borderWidth: 3,
                                    borderColor: 'rgb(253, 57, 122)',
                                    backgroundColor: 'rgb(253, 57, 122)',
                                    data: Object.values(chartData['order_total']),
                                    pointStyle: 'line'
                                },
                                ]
                            }

                            chart.update();
                        }

                        function loadDashboardChart(){
                            $.ajax({
                                url:'<?= base_url("admincontrol/dashboard?getChartData=1") ?>',
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
        </div></div>

        <div class="col-lg-6 p-0">

            <!--Admin users map-->
            <div class="dashboard-div world-map pl-4 pr-4 pt-5 pb-4">
                <script type="text/javascript" src="<?= base_url('assets/plugins/jmap/jquery-jvectormap-2.0.3.min.js') ?>">
                </script>
                <script type="text/javascript" src="<?= base_url('assets/plugins/jmap/jquery-jvectormap-world-mill.js') ?>">
                </script>
                <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/jmap/css.css') ?>">
                <div class="orders-header">
                    <h2><?= __("admin.affiliates_map") ?></h2>
                    <div class="world-map-users"></div>
                </div>
                <script type="text/javascript">
                    function load_userworldmap(_data) {
                        $('.world-map-users').html('<div class="map"><div id="world-map-users" class="map-content"></div></div>');
                        var data = {};
                        $.each(_data,function(i,j){
                            data[j['code']] = j['total']; 
                        })

                        $('.world-map-users #world-map-users').vectorMap({
                            map: 'world_mill',
                            zoomButtons : 1,
                            zoomOnScroll: false,
                            panOnDrag: 1,
                            backgroundColor: 'transparent',
                            markerStyle: {
                                initial: {
                                    fill: '#ff00ff',
                                    stroke: '#ffff00',
                                    "stroke-width": 1,
                                    r: 5
                                },
                            },
                            onRegionTipShow: function(e, el, code, f){
                                el.html(el.html() + (data[code] ? ': <small>' + data[code]+'</small>' : ''));
                            },
                            series: {
                                regions: [{
                                    values: data,
                                    scale: ['#ff846e'],
                                    normalizeFunction: 'polynomial'
                                }]
                            },
                            regionStyle: {
                                initial: {
                                    fill: '#2e4765'
                                },
                                hover: {
                                  "fill-opacity": 0.8
                              }
                          },
                          markers:false,
                      });
                    };

                    load_userworldmap(<?= json_encode($userworldmap) ?>);
                </script>
            </div>
            <!--Admin users map-->
        </div>
    </div>
    <!--graph + map-->

    <!--5 latest orders + 5 latest to do list-->
    <div class="row sectionone">
         <div class="col">
            <div class="card">
                <div class="card-body" style="height:500px;">
                    <div>
                      <?php $share_url = base_url('register/' . base64_encode($userdetails['id'])); ?>
                      <div class="user-header d-flex align-items-center border-0 p-0">
                          <div>
                              <div class="card-title"><?= __('admin.latest_orders') ?></div>
                          </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table orders-table-new">
                            <thead>
                                <tr>
                                    <th><?= __('admin.order_id') ?></th>
                                    <th><?= __('admin.total') ?></th>
                                    <th><?= __('admin.country') ?></th>
                                    <th><?= __('admin.store') ?></th>
                                    <th><?= __('admin.status') ?></th>
                                    <th><?= __('admin.commission') ?></th>
                                    <th><?= __('admin.date') ?></th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="100%" class="text-center">
                                        <h3 class="text-muted py-4"><?= __("admin.loading_orders_data_text") ?> </h3>
                                        <h5 class="text-muted py-4"><?= __("admin.not_taking_longer") ?> </h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body" style="height:500px;">
                   <div>
                  <?php $share_url = base_url('register/vendor'); ?>
                  <div class="user-header d-flex align-items-center border-0 p-0">
                      <div>
                          <div class="card-title"><?= __('admin.latest_to_do_list') ?></div>
                      </div>
                  </div>

                  <div class="table-responsive">
                        <table class="table todolist-table-new">
                            <thead>
                                <tr>
                                    <th><?= __('admin.id') ?></th>
                                    <th><?= __('admin.notes') ?></th>
                                    <th><?= __('admin.todo_date') ?></th>
                                    <th><?= __('admin.is_done') ?></th>
                                    <th><?= __('admin.created_at') ?></th>
                                    <th><?= __('admin.updated_at') ?></th> 
                                </tr>
                            </thead> 
                         <tbody>
                                <tr>
                                    <td colspan="100%" class="text-center">
                                        <h3 class="text-muted py-4"><?= __("admin.loading_todolist_data_text") ?> </h3>
                                        <h5 class="text-muted py-4"><?= __("admin.not_taking_longer") ?> </h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>   
                  </div>
              </div>
                </div>
            </div>
        </div>
    </div>
    <!--5 latest orders + 5 latest to do list-->
 
    <!--to do list-->
    <div class="row m-0">
        <script src="<?= base_url('assets/js') ?>/moment.js" type="text/javascript" ></script>
        <script src="<?= base_url('assets/js') ?>/main.min.js"></script>
        <script src="<?= base_url('assets/js') ?>/fullcalendar.min.js"></script>
        <link rel="stylesheet" href="<?= base_url('assets/css') ?>/fullcalendar.min.css"/>
        <div class="col-lg-12 p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?= __('admin.to_do_list') ?></h4>
                </div>
                <div class="card-body">
                    <div id="calendar">
                        
                    </div>
                </div>
            </div>    
        </div>
        <div id="modal-add-todo" class="modal modal-top fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title h4" id="to_do_list_title"><?= __('admin.add_to_do_list') ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group  mr-1">
                                <input type="text" class="form-control" id="todonotesCal" placeholder="Add To-do note">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="tododateCal" placeholder=" To-do date">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="btnAddCalnote"><?= __('admin.add') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--to do list-->
        
    <!--top affiliates + live logs-->
    <div class="row sectionsix">
         <div class="col-lg-6 p-0"> 
            <div class="dashboard-div p-0">
                <div class="dashboard-user-details">
                    <div class="d-flex align-items-center user-header p-3">
                        <div class="affiliate-img"> 
                            <img src="<?= base_url('assets/template/images/affiliate-icon.png') ?>" alt="<?= __('admin.popular_affiliates') ?>"> 
                        </div>
                        <div>
                            <h2><?= __('admin.popular_affiliates') ?></h2>
                        </div>
                    </div>
                    <div class="affiliate-table scroll-bar">
                        <table>
                            <thead>
                                <tr>
                                    <th><?= __( 'admin.admin_name' ) ?></th>
                                    <th><?= __( 'admin.admin_country' ) ?></th>
                                    <th><?= __( 'admin.admin_balance' ) ?></th>
                                    <th><?= __( 'admin.admin_commission' ) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($populer_users as $key => $users) { ?>
                                    <tr>
                                        <?php
                                        $flag = '';
                                        if ($users['sortname'] != '') {
                                            $flag = base_url('assets/vertical/assets/images/flags/' . strtolower($users['sortname']) . '.png');
                                        }
                                        ?>
                                        <td><img class="top-affiliate-image" src="<?= $products->getAvatar($users['avatar']); ?>" alt="<?= $users['firstname'].' '.$users['lastname']; ?>" /><?= $users['firstname'].' '.$users['lastname']; ?></td>
                                        <td><img class="top-affiliate-country-flag" src="<?= $flag; ?>" alt="<?= strtoupper($users['sortname']) ?>"></td>
                                        <td><?= $fun_c_format($users['amount']); ?></td>
                                        <td><?= $fun_c_format($users['all_commition']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 part-six p-0">
            <div class="dashboard-div  pl-2 pt-3 pr-2 pb-3">
                    <div class="user-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2><?= __('admin.live_logs') ?></h2>
                            <div class="setting-area"> 
                                <a href="javascript:void(0);" class="btn-count-notification" data-key='live_log' data-type='admin'>
                                    <span class="count-notifications"><?= count($live_window) ?></span>
                                    <img src="<?= base_url('assets/template/images/notifications-icon.png') ?>" alt="<?= __('admin.notification') ?><">
                                    </a> 
                                    <a href="javascript:void(0);" class="log-setting btn-setting" data-key='live_log' data-type='admin'> 
                                        <i class="fas fa-cog"></i>
                                    </a> 
                                </div>
                        </div>
                    </div>
                    <div class="live-wrap scroll-bar">
                        <div class="live-wrap-empty-data" style="display: <?= !empty($live_window) ? 'none' : 'block'; ?>">
                            <img src="<?= base_url("assets/vertical/assets/images/no-data-2.png"); ?>">
                            <h3><?= __('admin.not_activity_yet') ?></h3>
                        </div>
                        <ul class="ajax-live_window" style="display: <?= empty($live_window) ? 'none' : 'table'; ?>;width: 100%">
                            <?php foreach($live_window as $key => $value){ ?>
                                <?= $value['title'] ?>
                            <?php } ?>
                        </ul>
                    </div>
            </div>
        </div>
    </div>
    <!--top affiliates + live logs-->

    <!--4 bottom blocks-->
    <div class="row sectionseven">
        <div class="col-lg-3"> 
                <div class="dashboard-user-details ">
                <div class="user-header d-flex align-items-center">
                    <div class="header-img"> 
                        <img src="<?= base_url('assets/template/images/click-icon.png') ?>" alt="<?= __('admin.admin_all_clicks') ?>"> 
                    </div>
                    <div>
                        <h2><?= __( 'admin.admin_all_clicks' ) ?></h2>
                        <span><?= __('admin.total') ?> 
                        <span class="ajax-click_all_total">
                            <?= (int)(
                                $admin_totals['click_localstore_total'] +
                                $admin_totals['click_integration_total'] +
                                $admin_totals['click_form_total'] 
                            ) ?>
                        </span>
                        / 
                        <span class="click_all_commission">
                            <?= $fun_c_format(
                                $admin_totals['click_localstore_commission'] +
                                $admin_totals['click_integration_commission'] +
                                $admin_totals['click_form_commission']
                            ) ?>
                        </span>
                    </span> 
                </div>
                </div>
                    <ul>
                        <li class="d-flex"> 
                            <span><?= __( 'admin.admin_ecommerce' ) ?></span> 
                            <strong>
                                <strong class="ajax-click_localstore_total"><?= (int)$admin_totals['click_localstore_total'] ?></strong> 
                                / 
                                <strong class="ajax-click_localstore_commission"><?= $fun_c_format($admin_totals['click_localstore_commission']) ?></strong>
                            </strong> 
                        </li>
                        <li class="d-flex"> 
                            <span><?= __( 'admin.admin_external' ) ?></span> 
                            <strong>
                                <strong class="ajax-click_integration_total"><?= (int)$admin_totals['click_integration_total'] ?></strong>
                                / 
                                <strong class="ajax-click_integration_commission"><?= $fun_c_format($admin_totals['click_integration_commission']) ?></strong>  
                            </strong> 
                        </li>
                        <li class="d-flex"> 
                            <span><?= __( 'admin.admin_forms' ) ?></span> 
                            <strong>
                                <strong class="ajax-click_form_total"><?= (int)$admin_totals['click_form_total'] ?></strong>
                                / 
                                <strong class="ajax-click_form_commission"><?= $fun_c_format($admin_totals['click_form_commission']) ?></strong>
                            </strong> 
                        </li>
                    </ul>
                </div>
        </div>

        <div class="col-lg-3">
            <div class="dashboard-user-details">
                <div class="user-header d-flex align-items-center">
                    <div class="header-img"> 
                        <img src="<?= base_url('assets/template/images/percentage-icon.png') ?>" alt="<?= __( 'admin.admin_order_commission' ) ?>"> 
                    </div>
                    <div>
                        <h2><?= __( 'admin.admin_order_commission' ) ?></h2>
                        <span><?= __('admin.total') ?> 
                        <span class="ajax-all_sale_count">
                            <?= (int)(
                                $admin_totals['sale_localstore_count'] +
                                $admin_totals['order_external_count'] +
                                $admin_totals['sale_localstore_vendor_count']

                            ) ?>
                        </span>
                        / 
                        <span class="ajax-all_sale_commission">
                            <?= $fun_c_format(
                                $admin_totals['sale_localstore_commission'] +
                                $admin_totals['order_external_commission'] +
                                $admin_totals['sale_localstore_vendor_commission']

                            ) ?>
                        </span>
                        </span>
                    </div>
                </div>
                    <ul>
                        <li class="d-flex"> 
                            <span><?= __( 'admin.admin_ecommerce' ) ?></span> 
                            <strong>
                                <strong class="ajax-sale_localstore_count"><?= (int)$admin_totals['sale_localstore_count'] ?></strong>
                                / 
                                <strong class="ajax-sale_localstore_commission"><?= $fun_c_format($admin_totals['sale_localstore_commission']) ?></strong>
                            </strong> 
                        </li>
                        <li class="d-flex"> 
                            <span><?= __( 'admin.admin_vendor' ) ?></span> 
                            <strong>
                                <strong class="ajax-sale_localstore_vendor_count"><?= (int)$admin_totals['sale_localstore_vendor_count'] ?></strong>
                                / 
                                <strong class="ajax-sale_localstore_vendor_commission"><?= $fun_c_format($admin_totals['sale_localstore_vendor_commission']) ?></strong>
                            </strong> 
                        </li>
                        <li class="d-flex"> 
                            <span><?= __( 'admin.admin_external' ) ?></span> 
                            <strong>
                                <strong class="ajax-order_external_count"><?= (int)$admin_totals['order_external_count'] ?></strong>
                                / 
                                <strong class="ajax-order_external_commission"><?= $fun_c_format($admin_totals['order_external_commission']) ?></strong>
                            </strong> 
                        </li>
                    </ul>
                </div>
        </div>

        <div class="col-lg-3"> 
            <div class="dashboard-user-details scroll-bar">
                <div class="user-header d-flex align-items-center">
                <div class="header-img"> 
                    <img src="<?= base_url('assets/template/images/wallet-icon.png') ?>" alt="<?= __( 'admin.admin_wallet_statistics' ) ?>"> 
                </div>
                <div>
                    <h2><?= __( 'admin.admin_wallet_statistics' ) ?></h2>
                </div>
            </div>
            <ul>
                <li class="d-flex"> 
                    <span><?= __( 'admin.admin_hold' ) ?></span> 
                    <strong>
                        <strong class="ajax-wallet_unpaid_amounton_hold_count"><?= (int)$admin_totals['wallet_unpaid_amounton_hold_count'] ?></strong>
                        / 
                        <strong class="ajax-wallet_on_hold_amount"><?= $fun_c_format($admin_totals['wallet_on_hold_amount']) ?></strong>
                    </strong> 
                </li>
                <li class="d-flex"> 
                    <span><?= __( 'admin.admin_unpaid' ) ?></span> 
                    <strong>
                        <strong class='ajax-wallet_unpaid_count'><?= (int)$admin_totals['wallet_unpaid_count'] ?></strong>
                        / 
                        <strong class='ajax-wallet_unpaid_amount'><?= $fun_c_format($admin_totals['wallet_unpaid_amount']) ?></strong>
                    </strong> 
                </li>
                <li class="d-flex"> 
                    <span><?= __( 'admin.admin_request' ) ?></span> 
                    <strong>
                        <strong class="ajax-wallet_request_sent_count"><?= (int)$admin_totals['wallet_request_sent_count'] ?></strong>
                        / 
                        <strong class="ajax-wallet_request_sent_amount"><?= $fun_c_format($admin_totals['wallet_request_sent_amount']) ?></strong>
                    </strong> 
                </li>
                <li class="d-flex"> 
                    <span><?= __( 'admin.admin_paid' ) ?></span> 
                    <strong>
                        <strong class="ajax-wallet_accept_count"><?= (int)$admin_totals['wallet_accept_count'] ?></strong>
                        / 
                        <strong class="ajax-wallet_accept_amount"><?= $fun_c_format($admin_totals['wallet_accept_amount']) ?></strong>
                    </strong> 
                </li>
                <li class="d-flex"> 
                    <span><?= __( 'admin.admin_cancel' ) ?></span> 
                    <strong>
                        <strong class="ajax-wallet_cancel_count"><?= (int)$admin_totals['wallet_cancel_count'] ?></strong>
                        / 
                        <strong class="ajax-wallet_cancel_amount"><?= $fun_c_format($admin_totals['wallet_cancel_amount']) ?></strong>
                    </strong> 
                </li>
                <li class="d-flex"> 
                    <span><?= __( 'admin.trash' ) ?></span> 
                    <strong>
                        <strong class="ajax-wallet_trash_count"><?= (int)$admin_totals['wallet_trash_count'] ?></strong>
                        / 
                        <strong class="ajax-wallet_trash_amount"><?= $fun_c_format($admin_totals['wallet_trash_amount']) ?></strong>
                    </strong> 
                </li>
            </ul>
        </div></div>

        <div class="col-lg-3"> 
            <div class="dashboard-user-details">
                <div class="user-header d-flex align-items-center">
                    <div class="header-img"> 
                        <img src="<?= base_url('assets/template/images/vendor-icon.png') ?>" alt="<?= __( 'admin.admin_vendor_order_statistics' ) ?>"> 
                    </div>
                    <div>
                        <h2><?= __( 'admin.admin_vendor_order_statistics' ) ?></h2>
                    </div>
                </div>
                <ul>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_paid' ) ?></span> 
                        <strong>
                            <strong class="ajax-vendor_wallet_accept_count"><?= (int)$admin_totals['vendor_wallet_accept_count'] ?></strong>
                            / 
                            <strong class="ajax-vendor_wallet_accept_amount"><?= $fun_c_format($admin_totals['vendor_wallet_accept_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_request' ) ?></span> 
                        <strong>
                            <strong class="ajax-vendor_wallet_request_sent_count"><?= (int)$admin_totals['vendor_wallet_request_sent_count'] ?></strong>
                            / 
                            <strong class="ajax-vendor_wallet_request_sent_amount"><?= $fun_c_format($admin_totals['vendor_wallet_request_sent_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <span><?= __( 'admin.admin_unpaid' ) ?></span> 
                        <strong>
                            <strong class="ajax-vendor_wallet_unpaid_count"><?= (int)$admin_totals['vendor_wallet_unpaid_count'] ?></strong>
                            / 
                            <strong class="ajax-vendor_wallet_unpaid_amount"><?= $fun_c_format($admin_totals['vendor_wallet_unpaid_amount']) ?></strong>
                        </strong> 
                    </li>
                    <li class="d-flex"> 
                        <strong><?= __( 'admin.admin_total_orders' ) ?></strong> 
                        <strong>
                            <strong class="ajax-order_vendor_total"><?= (int)$admin_totals['order_vendor_total'] ?></strong>
                            / 
                            <strong class="ajax-order_vendor_total"><?= (int)$admin_totals['order_vendor_total'] ?></strong>
                        </strong> 
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--4 bottom blocks-->

    <div id="wallet-details-model" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?= __('admin.order_details') ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </div>
    </div>

<?= $social_share_modal ?>
<?php
$last_id_integration_logs = 0;
$last_id_integration_orders = 0;
$last_id_store_orders = 0;
$last_id_newuser = 0;
$last_id_notifications = 0;
foreach ($integration_logs as $key => $log){
    if($last_id_integration_logs <= $log['id']){ $last_id_integration_logs = $log['id']; }
}
foreach ($integration_orders as $key => $order) {
    if($last_id_integration_orders <= $order['id']){ $last_id_integration_orders = $order['id']; }
}
foreach ($store_orders as $key => $order) {
    if($last_id_store_orders <= $order['id']){ $last_id_store_orders = $order['id']; }
}
foreach ($newuser as $users) {
    if($last_id_newuser <= $users['id']){ $last_id_newuser = $users['id']; }
}
foreach ($notifications as $key => $notification) {
    if($last_id_notifications <= $notification['notification_id']){ $last_id_notifications = $notification['notification_id']; }
}

?>


<script type="text/javascript" src="<?= base_url("assets/plugins/table/datatables.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/plugins/table/dataTables.responsive.min.js") ?>"></script>

<script type="text/javascript">

        var DTexternal_site_order =  $("#external-site-order").dataTable({
           lengthMenu: [
           [5,10, 25, 50, -1],
           [5,10, 25, 50, 'All'],
           ],
       })
        var ajax_interval = 2000;
        <?php  if((float)$live_dashboard['admin_data_load_interval'] >= 2){ ?>
            ajax_interval  = <?= (float)$live_dashboard['admin_data_load_interval'] * 1000 ?>;
        <?php } ?>

        var dashboard_xhr;
        var last_id_integration_logs = <?= (int)$last_id_integration_logs ?>;
        var last_id_integration_orders = <?= (int)$last_id_integration_orders ?>;
        var last_id_store_orders = <?= (int)$last_id_store_orders ?>;
        var last_id_newuser = <?= (int)$last_id_newuser ?>;
        var last_id_notifications = <?= (int)$last_id_notifications ?>;
        var total_commision_filter_year = '<?= date('Y') ?>';
        var total_commision_filter_month = '<?= date('m') ?>';
        var settings_clear = false;
        var homepage_integration_data = JSON.parse('<?= json_encode($integration_data['array']); ?>');
        var integration_data_per_page = <?= $integration_data_per_page ?>;

        function playSound(notification_sound){
            var audio = '<?= base_url('/assets/notify/') ?>'+notification_sound;
            $("body").append('<iframe id="noti-sound-iframe" src="'+audio+'"></iframe>')
            $("#noti-sound-iframe").on('load',function(){
                setTimeout(function(){
                    $("#noti-sound-iframe").remove();
                },1000)
            });
        }

        function setTimeout2(callnexttime,show_popup) {
            $("<div />").css("height","0px").animate({height:'100px'},{
                duration: ajax_interval,
                step: function(now){
                    $(".progress").css('width',now+"%");
                },
                complete: function(){
                    getDashboard(callnexttime,show_popup);
                    getLatestOrders(1);
                }
            });
        } 

        var checkdata = {
            '.ajax-admin_balance'                     : 'admin_balance',
            '.ajax-sale_total_admin_store'            : 'sale_total_admin_store',
            '.ajax-sale_localstore_vendor_total'      : 'sale_localstore_vendor_total',
            '.ajax-click_action_total'                : 'click_action_total',
            '.ajax-click_action_commission'           : 'click_action_commission',
            '.ajax-all_click_total'                   : 'all_click_total',
            '.ajax-all_click_commission'              : 'all_click_commission',
            '.ajax-click_localstore_total'            : 'click_localstore_total',
            '.ajax-click_localstore_commission'       : 'click_localstore_commission',
            '.ajax-click_integration_total'           : 'click_integration_total',
            '.ajax-click_integration_commission'      : 'click_integration_commission',
            '.ajax-click_form_total'                  : 'click_form_total',
            '.ajax-click_form_commission'             : 'click_form_commission',
            '.ajax-click_all_total'                   : 'click_all_total',
            '.ajax-click_all_commission'              : 'click_all_commission',
            '.ajax-sale_localstore_count'             : 'sale_localstore_count',
            '.ajax-sale_localstore_commission'        : 'sale_localstore_commission',
            '.ajax-sale_localstore_vendor_count'      : 'sale_localstore_vendor_count',
            '.ajax-sale_localstore_vendor_commission' : 'sale_localstore_vendor_commission',
            '.ajax-order_external_count'              : 'order_external_count',
            '.ajax-order_external_commission'         : 'order_external_commission',
            '.ajax-all_sale_count'                    : 'all_sale_count',
            '.ajax-all_sale_commission'               : 'all_sale_commission',
            '.ajax-wallet_unpaid_amounton_hold_count' : 'wallet_unpaid_amounton_hold_count',
            '.ajax-wallet_on_hold_amount'             : 'wallet_on_hold_amount',
            '.ajax-wallet_unpaid_count'               : 'wallet_unpaid_count',
            '.ajax-wallet_unpaid_amount'              : 'wallet_unpaid_amount',
            '.ajax-wallet_request_sent_count'         : 'wallet_request_sent_count',
            '.ajax-wallet_request_sent_amount'        : 'wallet_request_sent_amount',
            '.ajax-wallet_accept_count'               : 'wallet_accept_count',
            '.ajax-wallet_accept_amount'              : 'wallet_accept_amount',
            '.ajax-wallet_cancel_count'               : 'wallet_cancel_count',
            '.ajax-wallet_cancel_amount'              : 'wallet_cancel_amount',
            '.ajax-wallet_trash_count'                : 'wallet_trash_count',
            '.ajax-wallet_trash_amount'               : 'wallet_trash_amount',
            '.ajax-vendor_wallet_accept_count'        : 'vendor_wallet_accept_count',
            '.ajax-vendor_wallet_accept_amount'       : 'vendor_wallet_accept_amount',
            '.ajax-vendor_wallet_request_sent_count'  : 'vendor_wallet_request_sent_count',
            '.ajax-vendor_wallet_request_sent_amount' : 'vendor_wallet_request_sent_amount',
            '.ajax-vendor_wallet_unpaid_count'        : 'vendor_wallet_unpaid_count',
            '.ajax-vendor_wallet_unpaid_amount'       : 'vendor_wallet_unpaid_amount',
            '.ajax-order_vendor_total'                : 'order_vendor_total',
            '.ajax-admin_balance_growth'              : 'admin_balance_growth',
            '.ajax-click_action_commission_growth'    : 'click_action_commission_growth',
            '.ajax-all_clicks_comission_growth'       : 'all_clicks_comission_growth',
            '.ajax-admin_all_sales_growth'            : 'admin_all_sales_growth',
            '.ajax-vendor_all_sales_growth'           : 'vendor_all_sales_growth',
        }

        function setColors() {
            $.each(checkdata,function(ele,Key){
                if($(ele).length){
                    var val =  parseInt($(ele).html().toString().replace(/[^0-9-.]/g, '') || 0);

                    $(ele).removeClass("text-primary")
                    $(ele).removeClass("text-danger")
                    if(val >= 0){
                        $(ele).addClass("text-primary");
                    } else{
                        $(ele).addClass("text-danger");
                    }
                }
            })
        }

    function getDashboard(callnexttime,show_popup,actions){
        if(dashboard_xhr && dashboard_xhr.readyState != 4) dashboard_xhr.abort();

        if(actions == 'clearlog'){
            settings_clear = true;
            last_id_integration_logs = 0;
            last_id_integration_orders = 0;
            last_id_store_orders = 0;
            last_id_newuser = 0;
            last_id_notifications = 0;
        }

        dashboard_xhr = $.ajax({
            url:'<?= base_url('admincontrol/ajax_dashboard') ?>',
            type:'POST',
            dataType:'json',
            data:{
                renderChart  : $(".renderChart").val(),
                selectedyear :$('.yearSelection').val(),
                last_id_integration_logs :last_id_integration_logs,
                last_id_integration_orders :last_id_integration_orders,
                last_id_store_orders :last_id_store_orders,
                last_id_newuser :last_id_newuser,
                last_id_notifications :last_id_notifications,
                last_id_top_notifications :$("#last_id_notifications").val(),
                total_commision_filter_year : $('select[name="filter_commission[year]"]').val(),
                total_commision_filter_month : $('select[name="filter_commission[month]"]').val(),
                integration_data_year : $('select[name="filter_integration[year]"]').val(),
                integration_data_month : $('select[name="filter_integration[month]"]').val(),
                integration_data_selected : $("#integration-chart-type").val(),
            },
            beforeSend:function(){},
            complete:function(){
                if(callnexttime){
                    setTimeout2(true,true);
                }
            },
            success:function(json){
                setTimeout(function(){
                    $('.ajax-live_window .fa-bell').removeClass('blink-icon');
                    $(".mini-stat-icon i").removeClass("blink-icon");
                }, 5000);

                var play_sound = false;
                
                var sound_on = false;

                $(".server-last-update").text(json['time']);
                sessionTimeout(json['timeout']);

                $.each(checkdata,function(ele,Key){
                    if($.trim($(ele).html()) != json['admin_totals'][Key]){
                        play_sound = true;
                        $(ele).html(json['admin_totals'][Key]);
                    }
                })

                if(json['online_count']){
                    if (typeof json['online_count']['admin'] == 'object' && json['online_count']['admin']['online'] ) {
                        $(".ajax-online-admin").html( json['online_count']['admin']['online']);
                    }
                    if (typeof json['online_count']['user'] == 'object' && json['online_count']['user']['online'] ) {
                        $(".ajax-online-affiliate").html(json['online_count']['user']['online']);
                    }
                    if (typeof json['online_count']['vendor'] == 'object' && json['online_count']['vendor']['online'] ) {
                        $(".ajax-online-vendor").html(json['online_count']['vendor']['online']);
                    }
                    if (typeof json['online_count']['client'] == 'object' && json['online_count']['client']['online'] ) {
                        $(".ajax-online-client").html(json['online_count']['client']['online']);
                    }
                }

                $(".ajax-weekly_balance").html(json['admin_totals_week']);
                $(".ajax-monthly_balance").html(json['admin_totals_month']);
                $(".ajax-yearly_balance").html(json['admin_totals_year']);

                if(json['chart']){
                    $("#dashboard-chart-empty").addClass('d-none');
                    $("#dashboard-chart").removeClass('d-none');
                    
                    renderDashboardChart(json['chart']);
                } else {
                    $("#dashboard-chart-empty").removeClass('d-none');
                    $("#dashboard-chart").addClass('d-none');
                }
                
                load_userworldmap(json['userworldmap']);

                homepage_integration_data = json['integration_data']['array'];
                let homepage_integration_pagination_template = createIntegrationPaginationTemplate(1);
                $(".dashboard-div .pagination-div ul").html(homepage_integration_pagination_template);
                
                let homepage_integration_data_template = createIntegrationDataTemplate(1);
                $("#external-site-order tbody").html(homepage_integration_data_template);
                $("#external-site-order").dataTable().fnDestroy();
                $("#external-site-order").dataTable({
                   lengthMenu: [
                   [5,10, 25, 50, -1],
                   [5,10, 25, 50, 'All'],
                   ],
               })
                $('.popover.bs-popover-top').remove();
                $('[data-toggle="popover"]').popover();

                if($.trim($(".ajax-notifications_count").html()) != json['notifications_count']){
                    play_sound = true;
                }
                $(".ajax-notifications_count").html(parseInt(json['notifications_count']) > 99 ? "99+" : json['notifications_count']);
                if(parseInt(json['notifications_count']) > 99) {

                    $(".bell");
                    $(".notifications-count");
                } else {
                    $(".bell");
                    $(".notifications-count");
                }

                if(json['ajax_newuser']){
                    $.each(json['ajax_newuser'], function(i,j){
                        last_id_newuser = last_id_newuser <= parseInt(j['id']) ? parseInt(j['id']) : last_id_newuser;
                        if(show_popup && json['live_dashboard']['admin_affiliate_register_status']){
                            sound_on = true;
                            show_tost("success",'<?= __('admin.new_affiliate_register') ?>','<?= __('admin.new_affiliate') ?>'+" "+ j['firstname'] +" "+ j['lastname'] +'<?= __('admin.register_just_now') ?>');
                        }
                    })
                }

                var count = 0;
                if(json['live_window']){
                    var notifications='';
                    $.each(json['live_window'], function(i,j){
                        play_sound = true;
                        count++;
                        notifications += j['title'];
                    })
                    if(notifications){
                        $('.btn-count-notification .count-notifications').text(count);
                        $(".ajax-live_window").html(notifications);

                        $(".live-wrap-empty-data").css('display','none');
                        $(".ajax-live_window").css('display','table');
                    }
                }

                if(json['ajax_integration_logs']){
                    $.each(json['ajax_integration_logs'], function(i,j){
                        last_id_integration_logs = last_id_integration_logs <= parseInt(j['id']) ? parseInt(j['id']) : last_id_integration_logs;
                        if(j['click_type'] == 'Action'){
                            if(show_popup && json['live_dashboard']['admin_action_status']){
                                sound_on = true;
                                show_tost("success",'<?= __('admin.new_action') ?>','<?= __('admin.new_action_click_done_just_now') ?>');
                            }
                        }
                    })
                }

                if(json['ajax_integration_orders']){
                    $.each(json['ajax_integration_orders'], function(i,j){
                        last_id_integration_orders = last_id_integration_orders <= parseInt(j['id']) ? parseInt(j['id']) : last_id_integration_orders;
                        if(show_popup && json['live_dashboard']['admin_integration_order_status']){
                            sound_on = true;
                            show_tost("success",'<?= __('admin.new_integration_order') ?>','<?= __('admin.new_integration_order_place_just_now') ?>');
                        }
                    })
                }

                var top_notifications = '';
                if(json['notifications']){
                    $.each(json['notifications'], function(i,j){
                        top_notifications += '<a href="javascript:void(0)" onclick="shownofication('+ j['notification_id'] +',\'<?= base_url('admincontrol') ?>'+ j['notification_url'] + '\')" class="dropdown-item notify-item">\
                        <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>\
                        <p class="notify-details"><b>'+ j['notification_title'] +'</b><small class="text-muted">'+ j['notification_description'] +'</small></p>\
                        </a>';
                    })
                }
                
                if(json['last_id_notifications']){
                    $.each(json['last_id_notifications'], function(i,j){
                        if(j['notification_type'] == 'order'){
                            if(show_popup && json['live_dashboard']['admin_local_store_order_status']){
                                sound_on = true;
                                show_tost("success",'<?= __('admin.new_local_store_order') ?>', j['notification_title'] + '<?= __('admin.just_now') ?>');
                            }
                        }

                        last_id_notifications = last_id_notifications <= parseInt(j['notification_id']) ? parseInt(j['notification_id']) : last_id_notifications;
                    })
                }

                $("#last_id_top_notifications").val(last_id_notifications);
                $(".ajax-notifications_count").html(json['notifications'].length);
                $(".ajax-top_notifications_count").html(json['notifications'].length);
                $('#allnotification').html(top_notifications);

                if(play_sound && json['sound_status'] == "1" && show_popup && sound_on){
                    playSound(json['notification_sound']);
                }
            },
        })
}

$(function() {
    $(".progress").on('each',function() {
        var value = $(this).attr('data-value');
        var left = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');
        if (value > 0) {
            if (value <= 50) {
                right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
            } else {
                right.css('transform', 'rotate(180deg)')
                left.css('transform', 'rotate(180deg)')
            }
        }
    })
    function percentageToDegrees(percentage) {
        return percentage / 100 * 360
    }
});

setTimeout2(true,true);

$(document).on('click','.dashboard-div .pagination-div ul li a',function(e){
    e.preventDefault();

    let page = $(this).data('page');
    $('.dashboard-div .pagination-div ul li.prev a').attr('data-page',page-1);
    $('.dashboard-div .pagination-div ul li.next a').attr('data-page',page+1);

    let homepage_integration_pagination_template = createIntegrationPaginationTemplate(page);
    $("#order-listing_paginate > ul").html(homepage_integration_pagination_template);

    let homepage_integration_data_template = createIntegrationDataTemplate(page);
    $(".dashboard-div #external-site-order tbody").html(homepage_integration_data_template);

    $('.popover.bs-popover-top').remove();
    $('[data-toggle="popover"]').popover();
})  

function createIntegrationPaginationTemplate(page){
    let template = '';
    let count = homepage_integration_data.length;
    let page_count = Math.ceil(count/integration_data_per_page);

    let diff = page_count - page;
    let i = 1;

    if(diff < 3)
        i = page + diff - 3;
    else 
        i = page;

    if(page > 2 && ((page + 2) < page_count))
        i--;

    if(i < 1)
        i = 1;

    if(page != 1)
        template += '<li class="prev"><a href="javascript:void(0)" data-page="' + (page - 1) +'"><i class="lni lni-chevron-left"></i></a></li>';

    let counter = 1;
    for(i; i < page_count+1; i++){
        if(counter < 5){
            let activeClass = (i == page) ? 'class="active"' : '';
            template += '<li ' + activeClass + '><a href="javascript:void(0)" data-page="' + i +'">' + i + '</a></li>';
        }
        counter++;
    }

    if(page != page_count && diff > 2)
        template += '<li class="next"><a href="javascript:void(0)" data-page="' + (page + 1) +'"><i class="lni lni-chevron-right"></i></a></li>';

    return template;
}

function createIntegrationDataTemplate(page){
    let template = '';
    let offset = (page - 1) * integration_data_per_page;
    for(let i = 0; i < homepage_integration_data.length; i++){
        if(homepage_integration_data[i]){
            template += '<tr>';
            template += '<td class="no-wrap" data-container="body" data-toggle="popover" data-trigger="hover"data-placement="top" data-content="'+homepage_integration_data[i].website+'" copyToClipboard="'+homepage_integration_data[i].website+'">'+stringLimiter(homepage_integration_data[i].website,20)+'</td>';
            template += '<td class="no-wrap">'+homepage_integration_data[i].balance+'</td>';
            template += '<td class="no-wrap">'+homepage_integration_data[i].total_count_sale+'</td>';
            template += '<td class="no-wrap">'+homepage_integration_data[i].click_count_amount+'</td>';
            template += '<td class="no-wrap">'+homepage_integration_data[i].action_count_amount+'</td>';
            template += '<td class="no-wrap">'+homepage_integration_data[i].total_commission+'</td>';
            template += '<td class="no-wrap">'+homepage_integration_data[i].total_orders+'</td>';
            template += '</tr>';
        }
    }

    return template;
}

function stringLimiter(text,length){
    if(text.length <= length){
        return text;
    } else {
        text = text.substr(text,length) + '...';
        return text;
    }
}

$(".btn_setting").on('click',function(){
    $this = $(this);
    $("#setting-widzard").modal({
        backdrop: 'static',
        keyboard: false
    });

    $("#setting-widzard").html('Loading');

    $.ajax({
        url:'<?= base_url('setting/getModal') ?>',
        type:'POST',
        dataType:'json',
        data:{
            'key' : $this.attr('data-key'),
            'type' : $this.attr('data-type'),
        },
            success:function(json){
                if(json['html']){
                    $("#setting-widzard").html(json['html']);
                }
            },
        })
})

function getodolistonly()
{
    var data ={
        action:'todolist'
    }
    $.ajax({
        url:'<?= base_url("todo/getodolistonly") ?>',
        type:'POST',
        dataType:'json',
        data:data,
        beforeSend:function(){$this.btn("loading");},
        complete:function(){$this.btn("reset");},
        success:function(json){
            $(".todolist-table-new tbody").html(json['html']);
            $(".card-footer").hide();
             
        },
    })
}  

function getLatestOrders(page,t) {
    $this = $(t);
    var data ={
        page:page,
        filter_status:$(".filter_status").val(),
        action:'dashboard'
    }
    $.ajax({
        url:'<?= base_url("admincontrol/get_latest_dashboard_orders") ?>/' + page,
        type:'POST',
        dataType:'json',
        data:data,
        beforeSend:function(){$this.btn("loading");},
        complete:function(){$this.btn("reset");},
        success:function(json){
            $(".orders-table-new tbody").html(json['html']);
            $(".card-footer").hide();
           
        },
    })
}


/*$(".card-footer .pagination").delegate("a","click", function(e){
    e.preventDefault();
    getPage($(this).attr("data-ci-pagination-page"),$(this));
})*/


$(function() {
    getLatestOrders(1); 
    getodolistonly();
});

/*$(document).delegate(".remove-order", "click", function(){
    $this = $(this);
    $.ajax({
        url: '<?php echo base_url("admincontrol/info_remove_order") ?>',
        type:'POST',
        dataType:'json',
        data:{id:$this.attr("data-order_id"), type:$this.attr("data-order_type")},
        beforeSend:function(){ $this.button("loading"); },
        complete:function(){ $this.button("reset"); },
        success:function(json){
            $("#modal-confirm .modal-body").html(json['html']);
            $("#modal-confirm").modal("show");
        },
    })
})

$("#modal-confirm .modal-body").delegate("[delete-order-confirm]","click",function(){
    $this = $(this);
    $.ajax({
        url: '<?php echo base_url("admincontrol/confirm_remove_order") ?>',
        type:'POST',
        dataType:'json',
        data:{
            id:$this.attr("delete-order-confirm"), 
            sale_commission: $('input[name="sale_commission"]').prop('checked'),
            order_type: $('input[name="order_type"]').val()
        },
        beforeSend:function(){ $this.button("loading"); },
        complete:function(){ $this.button("reset"); },
        success:function(json){
            window.location.reload();
        },
    })
})

$(document).delegate(".order-detail", "click",function(){
    let order_type = $(this).data('order_type');
    let order_id = $(this).data('order_id');

    if(order_type == 'ex')
        $("#modal-order-detail .modal-dialog").removeClass('modal-xl').addClass('modal-lg');
    else 
        $("#modal-order-detail .modal-dialog").removeClass('modal-lg').addClass('modal-xl');
        
    let template = jsOrders[order_type][order_id];

    $("#modal-order-detail .modal-body").html('');
    $("#modal-order-detail .modal-body").html(template);
    $("#modal-order-detail").modal("show");
})

$(document).on('click', '.view-tran-details', function () {
    let data = {
        type : $(this).data('comm_from'),
        ref1 : $(this).data('ref_id_1'),
        ref2 : $(this).data('ref_id_2')
    };

    $.ajax({
        url:'<?= base_url('admincontrol/getOrderDetails') ?>',
        type:'POST',
        dataType:'html',
        data:data,
        success:function(response){
            $('#wallet-details-model .modal-body').html(response);
            $('#wallet-details-model').modal('show');
        },
    });
});
*/


$(document).ready(function() {
        
        var calendar = $('#calendar').fullCalendar({
            themeSystem: 'bootstrap4',
            defaultView: 'month',
            editable: false,
            disableDragging:true,
            header: {
                left: 'today',
                center: 'title ',
                right: ' prev,next,month'
            },
            buttonText : {
                prev : 'Prev',
                next : 'Next',
                month : 'Month',
                today : 'Today',
            },
            events:'<?=base_url()?>'+"todo/getodolist?isCalView=1",
            eventRender: function(event, element) {
                if(event.is_done=="1"){
                    element.find('.fc-title').addClass('isTodaCompleted').attr('title','Click to view/update');
                }
                var isTodoDone = event.is_done=="1" ? 'checked':'';
                element.find(".fc-title").prepend("<input type='checkbox' data-id='"+event.id+"' class='completedTodoCalView mr-3' "+isTodoDone+">");
                element.find(".fc-title").append("<div class='float-right'><a class='removetodolisCalView' data-id='"+event.id+"' ><i class=' fa fa-trash'></i></a></div>")
            },
            dayClick: function(events) {

                var check = moment(events._d).format('YYYY-MM-DD');
                var today = moment(new Date()).format('YYYY-MM-DD');
                if(check < today)
                {
                    return alert("You can't select past date(s)");
                }
                ;
                $("#tododateCal").val(check)
                $("#todoListItemid").val(0);
                $('#btnAddCalnote').text('Add');
                $('#modal-add-todo').modal();
            },
            eventClick: function(event, jsEvent, view) {

                $('#todonotesCal').val(event.notes)

                $("#todoListItemid").val(event.id);
                $("#tododateCal").val( moment(event.start).format('YYYY-MM-DD'));
                $('#modal-add-todo').modal();
                $('#btnAddCalnote').text('Update');

            },
        });
        $(document).on('click','.completedTodoCalView',function(){
            var id = $(this).data('id');
            var is_completed = 0;
            if ($(this).attr('checked')) {
                $(this).removeAttr('checked');
                is_completed=0;
            } else {
                $(this).attr('checked', 'checked');
                is_completed=1;
                $(this).parent().addClass('isTodaCompleted')
            }
            var id = $(this).data('id');
            var $that = $(this);
            $.ajax({
                url:'<?= base_url('todo/actiontodolist') ?>',
                type:'POST',
                dataType:'json',
                data:{id:id,action:2,is_completed:is_completed},
                async:false,
                success:function(data){
                    if(data.status) {
                        gettodoList();
                    }
                },
            });
        });
        $(document).on('click', '.removetodolisCalView', function() {
            if(confirm('<?= __('admin.are_you_sure')?>')){
                var id = $(this).data('id');
                var $that = $(this);
                $.ajax({
                    url:'<?= base_url('todo/actiontodolist') ?>',
                    type:'POST',
                    dataType:'json',
                    data:{id:id,action:1},
                    async:false,
                    success:function(data){
                        if(data.status) {
                            gettodoList();
                            $that.parent().remove();
                        }
                    },
                });
            }
        });
        $("#btnAddCalnote").click(function(){
            var todo_date = $("#tododateCal").val();
            var todonotesCal = $("#todonotesCal").val();
            var id = $("#todoListItemid").val();

            if (todonotesCal && todo_date) {
                $.ajax({
                    url:'<?= base_url('todo/addtodolist') ?>',
                    type:'POST',
                    dataType:'json',
                    async:false,
                    data: { note :todonotesCal,id:id,todo_date:todo_date},
                    success:function(data){
                        if(data.status){
                            gettodoList();
                            $("#tododateCal,#todonotesCal").val('');

                            $("#todoListItemid").val(0);
                            $('#btnAddCalnote').text('Add');
                            $('#modal-add-todo').modal('hide');
                            $('#calendar').fullCalendar('prev');
                            $('#calendar').fullCalendar('next'); 
                        }
                    },
                });

            }
        })
    });

</script>
