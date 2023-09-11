<?php
$db =& get_instance();
$userdetails = get_object_vars($db->user_info());
$store_setting =$db->Product_model->getSettings('store');
$products = $db->Product_model;
$notifications_count = $products->getnotificationnew_count('admin',null);
?>

<div class="row">
    <div class="col-xl-12">
        <div class="row total-balance card-statistics">
         <div class="mini-stat clearfix col-md-2 statistics-item">
            <div class="mini-stat-info text-center ">
                <h6 class="mt-0"><?php echo __( 'admin.total_balance') ?></h6>
                <h4 class="counter mt-0 ajax-total_balance"><?php echo $totals['full_total_balance'] ?></h4>
            </div>
        </div>
        <div class="mini-stat clearfix col-md-2 statistics-item">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0"><?php echo __( 'admin.total_sales' ) ?></h6>
                <h4 class="counter mt-0 ajax-total_balance"><?php echo $totals['total_sale_balance'] ?></h4>
            </div>
            <button class="btn-sm btn-window" data-log='sale'><i class="fa fa-eye"></i></button>
        </div>

        <div class="mini-stat clearfix col-md-2 statistics-item">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0"><?php echo __( 'admin.shipping' ) ?> / <?php echo __( 'admin.tax' ) ?></h6>
                <h4 class="counter mt-0 ajax-total_balance">
                    <?= c_format ($local_store_shipping_cost) ?> /
                    <?= c_format ($local_store_tax_cost) ?>

                </h4>
            </div>
        </div>


        <div class="mini-stat clearfix col-md-2 statistics-item">
            <div class="mini-stat-info text-center ">
                <h6 class="mt-0"><?php echo __( 'admin.clicks_statistic' ) ?></h6>
                <h4 class="counter mt-0 ajax-all_clicks_comm"> <?php echo $totals['full_all_clicks_comm'] ?></h4>
            </div>
            <button class="btn-sm btn-window" data-log='click'><i class="fa fa-eye"></i></button>
        </div>


        <div class="mini-stat clearfix col-md-2 statistics-item">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0"><b><a class="text-white" href="<?= base_url ('admincontrol/listclients')?>">
                    <?php echo __( 'admin.total_clients' ).' / '; echo __( 'admin.total_guests' ) ?></a></b>
                </h6>
                <h4 class="counter mt-0">
                    <?php echo !empty($client_count) ? count($client_count) : '0'; ?> / 
                    <?php echo !empty($guest_count) ? count($guest_count) : '0'; ?>


            </h4>
            </div>
            <button class="btn-sm btn-window" data-log='member'><i class="fa fa-eye"></i></button>
        </div>


        <div class="mini-stat clearfix col-md-2 statistics-item">
            <div class="row">
                <div class="col-sm-12">
                    <div class="mini-stat-info text-center">
                        <h4 class="mt-0 header-title"><?php echo __('admin.h_orders') ?></h4>
                        <a class="counter mt-0 text-success" href="<?= base_url('admincontrol/listorders') ?>" role="button" data-toggle="tooltip" data-original-title="<?php echo __('admin.h_orders') ?>">
                            <span class="badge badge-setting badge-danger float-center ajax-hold_orders blink_me">
                                <?= $totals['full_local_store_hold_orders'] ?></span>
                        </a>
                    </div>
                </div>
                <button class="btn-sm btn-window" data-log='hold_orders'><i class="fa fa-eye"></i></button>
            </div>
        </div>


        <div class="mini-stat clearfix col-md-2 statistics-item">
            <div class="mini-stat-info text-center">
                <?php $store_url = base_url('store'); ?>
                <a class="btn btn-lg btn-default btn-success" href="<?php echo $store_url ?>" target="_blank">
                    <?= __('admin.view_store') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
   <div class="col-xl-12 mt-5 p-0 dashboard-middle">
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex justify-content-between align-items-center">

                <div class="col-xl-2">
                    <div class="mini-stat clearfix bg-white">
                        <div class="mini-stat-info text-center">
                            <h6 class="mt-0 header-title"><?php echo __( 'admin.total_products') ?> (<?= (int)$product_count ?>)</h6> 
                            <a href="<?= base_url('admincontrol/listproduct') ?>"></a>
                 <!-- <h6 class="mt-0 header-title"><?php echo __( 'admin.total_category') ?> (<?= (int)$category_count ?>)</h6>
                    <a href="<?= base_url('admincontrol/store_category') ?>" ></a> -->
                </div>
            </div>
        </div>

        <div class="col-xl-2">
            <div class="mini-stat clearfix bg-white">
                <div class="mini-stat-info text-center">
                    <h6 class="mt-0 header-title"><?php echo __( 'admin.total_forms') ?> (<?= $form_count ?>)</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="mini-stat clearfix bg-white">
                <div class="mini-stat-info text-center">
                    <h6 class="mt-0 header-title"><?php echo __( 'admin.total_orders') ?> (<?php echo $ordercount; ?>)</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="mini-stat clearfix bg-white">
                <div class="mini-stat-info text-center">
                    <h6 class="mt-0 header-title"><?php echo __( 'admin.total_products_coupons') ?> (<?= $coupon_count ?>)</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="mini-stat clearfix bg-white">
                <div class="mini-stat-info text-center">
                    <h6 class="mt-0 header-title"><?php echo __( 'admin.total_forms_coupons') ?> (<?= $form_coupon_count ?>)</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="mini-stat clearfix bg-white">
                <div class="mini-stat-info text-center">
                    <h6 class="mt-0 header-title"><?php echo __( 'admin.payment_getaway') ?> (<?= $payment_gateway_count ?>)</h6>
                </div>
            </div>
        </div>
    </div></div>
</div>   
</div> 
</div>



<div class="row"> 
    <div class="col-lg-6 grid-margin stretch-card sale-data">
        <div id="chartContainer" style="height: 400px; max-width: 920px; margin: 0px auto;"></div>
    </div>   

    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card" style="height: 500px;">
         <div class="card-body">
          <div class="template-dashboard">
           <button type="button" class="btn btn-primary btn-fw mb-3">CLIENTS WORLD MAP</button>
       </div>
       <div class="world-map-users"></div>
   </div>
</div>
</div>

</div>
<div class="row payment-icon">
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_paypal_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/paypal.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_paytm_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/paytm.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_opay_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/opay.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_skrill_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/skrill.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_stripe_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/stripe.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_bank_transfer_cod') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/bank-transfer.png') ?>">
            </div>
        </div>
    </div>
</div>

<div class="row payment-icon">
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_yookassa_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/yookassa.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_paystack_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/paystack.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_xendit_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/xendit.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_flutterwave_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/flutterwave.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_razorpay_getaway') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/razorpay.png') ?>">
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title"><?php echo __( 'admin.support_bank_transfer_cod') ?></h6>
                <img height:100% width:100% src="<?= base_url('assets/payment_gateway/cod.png') ?>">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive b-0" data-pattern="priority-columns">
            <table id="store-dashboard-orders" class="table  table-striped">
                <thead class="bg-blue">
                    <tr>
                        <th><?= __('admin.order_id') ?></th>
                        <th><?= __('admin.price') ?></th>
                        <th class="txt-cntr"><?= __('admin.order_status') ?></th>
                        <th><?= __('admin.payment_method') ?></th>
                        <th><?= __('admin.ip') ?></th>
                        <th><?= __('admin.transaction') ?></th>
                        <th><?= __('admin.status') ?></th>
                        <th></th>
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

    <script type="text/javascript">
        function getPage(url){
            $this = $(this);

            $.ajax({
                url:url,
                type:'POST',
                dataType:'json',
                data:$("#filter-form").serialize(),
                beforeSend:function(){$this.btn("loading");},
                complete:function(){$this.btn("reset");},
                success:function(json){
                    if(json['view']){
                        $("#store-dashboard-orders tbody").html(json['view']);
                        $("#store-dashboard-orders").show();
                    } else {
                        $(".empty-div").removeClass("d-none");
                        $("#store-dashboard-orders").hide();
                    }

                    $("#store-dashboard-orders .pagination-td").html(json['pagination']);
                },
            })
        }
        $(function() {
            getPage('<?= base_url("admincontrol/store_dashboard_order_list?page=1") ?>');
        });
        $("#store-dashboard-orders").delegate(".pagination-td a","click",function(e){
            e.preventDefault();
            getPage($(this).attr("href"));
            return false;
        })
    </script>

    <script>
       function renderStackedBarChart(group) {
        var group = group ? group : 'month';
        var selectedyear = $('.yearSelection').val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {renderChart: group,selectedyear:selectedyear},
            success: function (json) {
                loadChartData(json);
            },
        })
    }
    function toArray(myObj) {
        return $.map(myObj, function(value, index) {
            return [value];
        });
    }

    $( document ).ready(function() {
        renderStackedBarChart();
    });
    
    function loadChartData(json) {
        var saleHigh = toArray(json['series_new']['sale']);
        var orderHigh = toArray(json['series_new']['order']);
        var commissionsHigh = toArray(json['series_new']['commissions']);

        var months = [
        '',
        '<?= substr(__('admin.january'),0,3) ?>',
        '<?= substr(__('admin.february'),0,3) ?>',
        '<?= substr(__('admin.march'),0,3) ?>',
        '<?= substr(__('admin.april'),0,3) ?>',
        '<?= substr(__('admin.may'),0,3) ?>',
        '<?= substr(__('admin.june'),0,3) ?>',
        '<?= substr(__('admin.july'),0,3) ?>',
        '<?= substr(__('admin.august'),0,3) ?>',
        '<?= substr(__('admin.september'),0,3) ?>',
        '<?= substr(__('admin.october'),0,3) ?>',
        '<?= substr(__('admin.november'),0,3) ?>',
        '<?= substr(__('admin.december'),0,3) ?>',
        ];
        
        var dataPoints=[];
        for (var j = 1; j <=12; j++) {
            dataPoints.push({y:j,a:saleHigh[j],b:orderHigh[j],c:commissionsHigh[j]})
        }

        Morris.Line({
          element: 'chartContainer',
          lineColors: ['#fc836e', '#3d5674', '#3d5674'],
          data: dataPoints,
          parseTime: false,
          xkey: 'y',
          ykeys: ['a','b','c'],
          xLabelFormat: function (x) {
            var index = parseInt(x.src.y);
            return months[index];
          },
          labels: ['Sales (<?=$CurrencySymbol?>)', 'Orders','Commission (<?=$CurrencySymbol?>)'],
    });
    }


</script>



<script src="<?= base_url('assets/template/js/jquery-jvectormap-2.0.5.min.js'); ?>"></script>
<!-- <script src="http://jvectormap.com/js/jquery-jvectormap-world-mill.js"></script> --> 
<script type="text/javascript" src="<?= base_url('assets/plugins/jmap/jquery-jvectormap-world-mill.js') ?>">
</script>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/jmap/css.css') ?>">

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
