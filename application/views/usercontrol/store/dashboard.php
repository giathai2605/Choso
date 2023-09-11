<?php
    $db =& get_instance();
    $userdetails=$db->userdetails();
    $unique_url= base_url().'register/'.base64_encode( $userdetails['id']);
    $ShareUrl = urlencode($unique_url);
    $store_setting =$db->Product_model->getSettings('store');
    $products = $db->Product_model;
?>

<link rel="stylesheet" type="text/css" href="<?= base_url('/assets/plugins/chartist/css/chartist.min.css') ?>?v=<?= av() ?>">
<script type="text/javascript" src="<?= base_url('assets/plugins/chartist/js/chartist.min.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?= base_url('/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') ?>?v=<?= av() ?>">
<script src="<?= base_url('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jvectormap/gdp-data.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jvectormap/jquery-jvectormap-uk-mill-en.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jvectormap/jquery-jvectormap-us-il-chicago-mill-en.js') ?>"></script> 

<script src="<?= base_url(); ?>assets/plugins/chartist/js/chartist-plugin-tooltip.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jquery-knob/excanvas.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jquery-knob/jquery.knob.js"></script>


<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-4">
                <div class="mini-stat clearfix bg-white">
                    <div class="mini-stat-info text-center">
                        <h6 class="mt-0 header-title"><?= __( 'admin.total_sale') ?></h6>
                        <h4 class="counter mt-0 text-primary ajax-total_sale">
                            <?= c_format($vendor_store_statistic['total_sale']) ?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="mini-stat clearfix bg-white">
                    <div class="mini-stat-info text-center">
                        <h6 class="mt-0 header-title"><?= __( 'admin.clicks_statistic' ) ?></h6>
                        <h4 class="counter mt-0 text-primary ajax-all_clicks_comm">
                            <?= $vendor_store_statistic['count_click'] ?>
                        </h4>
                    </div>
                    <button class="btn-sm btn-window" data-log='vendor_click'><i class="fa fa-eye"></i></button>
                </div>
            </div>
           
            <div class="col-xl-4">
                <div class="mini-stat clearfix bg-white">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mini-stat-info text-center">
                                <h6 class="mt-0 header-title"><?= __('admin.h_orders') ?></h6>
                                <h4 class="counter mt-0 text-primary ajax-total_sale">
                                    <?= $vendor_store_statistic['count_order'] ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title">
                    <?= __( 'admin.total_products') ?> (<?= $vendor_store_statistic['count_product'] ?>)
                </h6> 
                <a href="<?= base_url('admincontrol/listproduct') ?>"></a>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="mini-stat clearfix bg-white">
            <div class="mini-stat-info text-center">
                <h6 class="mt-0 header-title">
                    <?= __( 'admin.total_products_coupons') ?> (<?= $vendor_store_statistic['count_coupon'] ?>)
                </h6>
            </div>
        </div>
    </div>
            
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive b-0" data-pattern="priority-columns">
            <table id="store-dashboard-orders" class="table  table-striped">
                <thead>
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
                <tbody></tbody>
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

    getPage('<?= base_url("usercontrol/store_dashboard_order_list?page=1") ?>');
    $("#store-dashboard-orders").delegate(".pagination-td a","click",function(e){
        e.preventDefault();
        getPage($(this).attr("href"));
        return false;
    })
    </script>
</div>
