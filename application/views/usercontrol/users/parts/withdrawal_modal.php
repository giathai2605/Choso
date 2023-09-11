<?php if(isset($warning)){ ?>
    <div class="modal-header">
        <h5 class="modal-title"><?= __('user.withdrawal_notification_info') ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>
    <div class="modal-body"> 
        <h4 class="notification_on_pages">
            <div class="badge badge-warning text-center"><?= $warning ?></div>
        </h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('user.close') ?></button>
    </div>

<?php } 
else if(isset($danger)){ ?>
    <div class="modal-header">
        <h5 class="modal-title"><?= __('user.withdrawal_notification_info') ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>
    <div class="modal-body">
        <h4 class="notification_on_pages">
            <div class="badge badge-danger"><?= $danger ?></div>
        </h4>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('user.close') ?></button>
    </div>
<?php }
else { ?>
<div class="modal-body p-0">
    <div id="accordion">
        <?php $index = 0; foreach ($payment_methods as $key => $value) { if ($value['status']==1 && $value['is_install']==1) { ?>
            <div class="wpayment border-radius-0">
                <div class="border-bottom border-radius-0 wpayment-header p-3 <?= $index == 0 ? 'active-payment' : '' ?>" data-tab='collapse-<?= $value['code'] ?>'>
                    <h5 class="m-0 font-16" >
                        <?= __('user.'.str_replace(' ','_',strtolower($value['title']))) ?>
                    </h5>
                </div>
            </div>
        <?php $index++; } } ?>

        <div class="wpayment-container">
            <?php $index = 0; foreach ($payment_methods as $key => $value) { if ($value['status']) { ?>
                <div id="collapse-<?= $value['code'] ?>" class="<?= $index == 0 ? '' : 'd-none'  ?> wpayment-body">
                    <h3 class="payment-heading"><?= __('user.get_paid_with') ?> <?= __('user.'.str_replace(' ','_',strtolower($value['title']))) ?></h3>
                    <form id="payment-form-<?= $value['code'] ?>" enctype="multipart/form-data">
                        <input type="hidden" name="ids" value="<?= $ids ?>">
                        <input type="hidden" name="code" value="<?= $value['code'] ?>">
                        <?= $value['user_setting'] ?>

                        <div class="pb-3">
                        
                        <?php
                        if($value['code'] == 'bank_transfer' && $setting_exist_status == 1)
                        {
                            $get_custom_fiels_data = json_decode($get_custom_fiels['bt_custom_field']);
                            $get_custom_fiels_validate = json_decode($get_custom_fiels['response_validate']);

                            foreach ($get_custom_fiels_data as $cus_value) {
                                $lable = str_replace("_"," ",$cus_value);
                                $lable = ucfirst($lable);
                                $filed = str_replace(" ","_",$cus_value);
                                $filed = strtolower($filed);

                                ?>
                                    <label><?=$lable;?></label>
                                    <input class="form-control" placeholder="<?= __('user.please_enter') ?> <?=$lable;?>" name="<?=$filed;?>" rows="5"></input>
                                <?php
                            }

                            if(isset($get_custom_fiels['withdrawal_proof']) && in_array($get_custom_fiels['withdrawal_proof'], [1,2])) {
                                    ?>
                                    <div class="form-group mt-4">
                                        <label><?= __('user.payment_proof') ?></label>
                                        <input type="file" id="payment_proof" name="payment_proof" <?= $get_custom_fiels['withdrawal_proof'] == 2 ? "required" : "" ?>/>
                                    </div>
                                    <div class="text-info mb-4">
                                    <?= __('user.if_admin_asked_you_send_payment_proof') ?>
                                    </div>
                                    <?php
                                }
                        }
                        ?>
                        </div>
                        <?php
                            $get_custom_fiels_validate = isset($get_custom_fiels_validate) && is_array($get_custom_fiels_validate) ? $get_custom_fiels_validate : []; 
                         ?>
                        <input type="hidden" name="get_custom_fiels_validate" value="<?= implode(",",$get_custom_fiels_validate);?>">
                        <div class="text-right">
                            <button class="btn btn-submit btn-primary"><?= __('user.submit') ?></button>
                        </div>
                    </form>
                </div>
            <?php $index++; } } ?>
        </div>

        <?php if ($index == 0) { ?>
            <div class="border-right-0 font-20 mb-0 well">
                <p class="text-center"><?= __('user.warning_no_payment_options_available_contact_assistance') ?></p>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $(".wpayment-header").click(function(){
        $(".wpayment-container .wpayment-body").addClass("d-none");
        var tab = $(this).attr("data-tab");
        $("#" + tab).removeClass("d-none");
        $(".wpayment-header.active-payment").removeClass("active-payment");
        $(this).addClass("active-payment");
    })
</script>

<?php  } ?>