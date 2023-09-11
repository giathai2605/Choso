<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="post" action=""  enctype="multipart/form-data" id="setting-form">
			<div class="row">
				<div class="col-sm-12">
 					<div class="withdrawal_to_wallet_panel"> 
						<div class="form-group">
							<label class="control-label"><?= __('admin.withdrawal_to_wallet') ?></label>
							<select class="form-control" id="wallet_auto_withdrawal_select" name="site[wallet_auto_withdrawal]">
								<option value="0" <?= (int)$site['wallet_auto_withdrawal'] == 0 ? 'selected' : '' ?>><?= __('admin.manually_withdrawal') ?></option>
								<option value="1" <?= $site['wallet_auto_withdrawal'] == 1 ? 'selected' : '' ?>><?= __('admin.auto_withdrawal_using_cron_job') ?></option>
							</select>
						</div>
						<div class="withdrawal_to_wallet_sub_panel" style="display: none;">
							<div class="form-group">
								<label  class="control-label"><?= __('admin.days_records_old_from_today') ?></label>
								<input name="site[wallet_auto_withdrawal_days]" value="<?php echo $site['wallet_auto_withdrawal_days']; ?>" class="form-control" type="number">
							</div>
							<div class="form-group">
								<label  class="control-label"><?= __('admin.limit_of_record_auto_withdrawal_per_time') ?></label>
								<input name="site[wallet_auto_withdrawal_limit]" value="<?php echo $site['wallet_auto_withdrawal_limit']; ?>" class="form-control" 
								type="number" min="1" max="1000000">
							</div>
						</div>	
					</div>	
						 
					<div class="form-group">
						<label class="control-label"><?= __('admin.default_action_status') ?></label>
						<select class="form-control" name="referlevel[default_action_status]">
							<option value="0" <?= (int)$referlevel['default_action_status'] == 0 ? 'selected' : '' ?>><?= __('admin.on_hold') ?></option>
							<option value="1" <?= (int)$referlevel['default_action_status'] == 1 ? 'selected' : '' ?>><?= __('admin.in_wallet') ?></option>
						</select>
					</div>
					<div class="form-group">
						<label class="control-label"><?= __('admin.default_external_order_status') ?></label>
						<select class="form-control" name="referlevel[default_external_order_status]">
							<option value="0" <?= (int)$referlevel['default_external_order_status'] == 0 ? 'selected' : '' ?>><?= __('admin.on_hold') ?></option>
							<option value="1" <?= (int)$referlevel['default_external_order_status'] == 1 ? 'selected' : '' ?>><?= __('admin.in_wallet') ?></option>
						</select>
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.minimum_withdraw') ?> ( <?= __('admin.set_to_zero_or_empty_to_Disable') ?> )</label>
						<input name="site[wallet_min_amount]" value="<?php echo $site['wallet_min_amount']; ?>" class="form-control" type="number" onblur="return onWallentMinamountChange()" id="txt_wallet_min_amount">
					</div>

					<div class="form-group" id="wallet_min_message_panel">
						<label  class="control-label"><?= __('admin.minimum_withdraw_message') ?></label>
						<input  name="site[wallet_min_message_new]" class="form-control" 
						value="<?php if($site['wallet_min_message_new']!="") { echo $site['wallet_min_message_new'];} else { echo __('admin.the_minimum_limit_is'); } ?>" />
						 
					</div>
					<div class="form-group">
						<label  class="control-label"><?= __('admin.maximum_withdraw_amount') ?> ( <?= __('admin.set_to_zero_or_empty_to_Disable') ?> )</label>
						<input name="site[wallet_max_amount]" value="<?php echo $site['wallet_max_amount']; ?>" class="form-control" type="number" onblur="return onWallentMaxamountChange()" id="txt_wallet_max_amount">
					</div> 

				</div>
				<div class="col-sm-12 text-right">
					<button type="submit" class="btn btn-sm btn-primary btn-submit"><?= __('admin.save_settings') ?></button>
				</div>
			</div>
		</form>
	</div>
</div>


<script type="text/javascript">

	$( document ).ready(function() {
		ShowHideAutoWithdrawalPanel();
	});
 

	function ShowHideAutoWithdrawalPanel()
	{
		if($("#wallet_auto_withdrawal_select").val()>0)
		{
			$(".withdrawal_to_wallet_sub_panel").show();
			$("#wallet_min_message_panel").hide();
			
		}
		else
		{
			$(".withdrawal_to_wallet_sub_panel").hide();
			$("#wallet_min_message_panel").show();
		}
	}

	$("#wallet_auto_withdrawal_select").on('change',function(evt){

		ShowHideAutoWithdrawalPanel();
		return false;
	});

	$(".btn-submit").on('click',function(evt){
	    evt.preventDefault();
	    var formData = new FormData($("#setting-form")[0]);

	    $(".btn-submit").btn("loading");
	    formData = formDataFilter(formData);
	    $this = $("#setting-form");
	    
	    $.ajax({
	        type:'POST',
	        dataType:'json',
	        cache:false,
	        contentType: false,
	        processData: false,
	        data:formData,
	        success:function(result){
	            $(".btn-submit").btn("reset");
	            $(".alert-dismissable").remove();

	            $this.find(".has-error").removeClass("has-error");
	            $this.find("span.text-danger").remove();
	            
	            if(result['location']){
	                window.location = result['location'];
	            }

	            if(result['success']){
	                showPrintMessage(result['success'],'success');
	                var body = $("html, body");
					body.stop().animate({scrollTop:0}, 500, 'swing', function() { });
	            }

	            if(result['errors']){
	            	showPrintMessage(result['error'],'error');
	            }
	        },
	    })
	    return false;
	});

</script>
<style type="text/css">
	
.withdrawal_to_wallet_panel{}	
.withdrawal_to_wallet_sub_panel{background: #f0ecec;
    padding: 20px;
    margin-bottom: 20px;}	
</style>