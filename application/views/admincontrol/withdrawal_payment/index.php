<div class="plugin-uploader">
	<p class="text-center text-help"><?= __('admin.if_have_plugin_in_zip_format_you_masy_insttall') ?> <br> <?= __('admin.if_want_to_creat_custom_payment_gateway') ?> <a href="<?= base_url('admincontrol/withdrawal_payment_gateways_doc') ?>"><?= __('admin.documentation') ?></a></p>

	<div class="contain">
		<div class="div-input">
			<input type="file" id="plugin-file" name="plugin">
			<div class="bg-danger px-2 py-1 text-left text-light warning d-none"></div>
		</div>
		<div class="div-button">
			<button class="btn btn-primary btn-sm" id="plugin-file-button" disabled=""><?= __('admin.install_now') ?></button>
		</div>
	</div>
	
</div>

<div class="card">
	<div class="card-header bg-blue-payment">
		<div class="card-title-white pull-left m-0"><?= __('admin.payments') ?></div>
		<div class="pull-right">
			<button id="toggle-uploader" class="btn btn-primary"><?= __('admin.install_payment_gateway') ?></button>
		</div>
	</div>
	<div class="card-body p-0">
 
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th class="col-md-3"><?= __('admin.payment_method') ?></th>
						<th class="col-md-2"><?= __('admin.icon') ?></th>
						<th class="col-md-3"><?= __('admin.status') ?></th>
						<th class="col-md-4"><?= __('admin.action') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if(count($payment_methods) == 0){ ?>
						<tr>
							<td class="text-center" colspan="100%"><?= __('admin.no_payment_methods_available') ?></td>
						</tr>
					<?php } ?>
					<?php foreach ($payment_methods as $key => $payment) { ?>
						<tr>
							<td><?= __('admin.'.$payment['code']) ?></td>
							<td><img src="<?= base_url($payment['icon']) ?>"></td>
							<td>					 
							<input class="paymentstatus" type="checkbox" <?= $payment['status']==1 ? 'checked' : '' ?> data-toggle="toggle" data-size="normal" data_code="<?=$payment['code']?>" data-on="<?= __('admin.status_on') ?>" data-off="<?= __('admin.status_off') ?>"/>
							</td>

							<td>
								<?php if($payment['is_install'] == '1'){ ?>
									<a href="<?= base_url('admincontrol/withdrawal_payment_gateways_edit/'. $payment['code']) ?>" class="btn btn-sm btn-info"><?= __('admin.edit') ?></a>
								<?php } ?>
								<a onclick="return confirm('<?= __('admin.are_you_sure') ?>')" href="<?= base_url('admincontrol/withdrawal_payment_gateways_status_change/'. $payment['code']) ?>" class="btn btn-sm btn-<?= $payment['is_install'] == "1" ? "danger" : "success" ?>"><?= $payment['is_install'] == "1" ? __('admin.un_install') : __('admin.install') ?></a>

								<a onclick="return confirm('<?= __('admin.are_you_sure') ?>')" href="<?= base_url('payment/delete_plugin/'.$payment['code']) ?>" class="btn btn-sm btn-danger"><?= __('admin.delete') ?></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#toggle-uploader").on("click",function(){
		$(".plugin-uploader").slideToggle();
	})

	$("#plugin-file").on("change",function(){
		if($(this).val() == ''){
			$("#plugin-file-button").prop("disabled",1)
		} else{
			$("#plugin-file-button").prop("disabled",0)
		}
	})

	$("#plugin-file-button").on("click", function(evt){
		evt.preventDefault();
        $btn = $(this);

        $(".plugin-uploader .warning").addClass('d-none');

        var formData = new FormData();
        formData.append("plugin", $("#plugin-file")[0].files[0]);
       	$btn.btn("loading");
        
        $.ajax({
            url:'<?= base_url('payment/installPayementGateway') ?>',
            type:'POST',
            dataType:'json',
            cache:false,
            contentType: false,
            processData: false,
            data:formData,
            error:function(){ $btn.btn("reset"); },
            success:function(result){            	
            	$btn.btn("reset");
                
                if(result['location']){
                    window.location.reload();
                }
                if(result['warning']){
                    $(".plugin-uploader .warning").html(result['warning']);
                    $(".plugin-uploader .warning").removeClass('d-none');
                }
            },
        });
	})

	$('.paymentstatus').on('change', function()
    {
        var checked = $(this).prop('checked');
        var code = $(this).attr('data_code');
        console.log(code);
        
        if (checked == true) {
          var status = 1;
        }
        else
        {
          var status = 0;
        }
        $.ajax({
            url:'<?= base_url("admincontrol/withdrawal_payment_gateways_setting_save_ajax") ?>',
            type:'POST',
            dataType:'json',
            data:{"status":status,"code":code},
            success:function(json)
            { 
            	if(json.status=='true')
            		showPrintMessage(json.msg,'success');
            	else
            		showPrintMessage(json.msg,'error'); 
            },
        });
    });
</script>