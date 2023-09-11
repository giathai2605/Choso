<div class="form-group">
	<label class="control-label"><?= __('admin.store_payment_status') ?></label>
	<select class="form-control" name="store">
		<option <?= (int) $setting_data['store']['status'] == '0' ? 'selected' : '' ?> value="0"><?= __('admin.disabled') ?></option>
		<option <?= (int) $setting_data['store']['status'] == '1' ? 'selected' : '' ?> value="1"><?= __('admin.enabled') ?></option>
	</select>
</div>

<div class="form-group">
	<label class="control-label"><?= __('admin.deposit_payment_status') ?></label>
	<select class="form-control" name="deposit">
		<option <?= (int) $setting_data['deposit']['status'] == '0' ? 'selected' : '' ?> value="0"><?= __('admin.disabled') ?></option>
		<option <?= (int) $setting_data['deposit']['status'] == '1' ? 'selected' : '' ?> value="1"><?= __('admin.enabled') ?></option>
	</select>
</div>

<div class="form-group">
	<label class="control-label"><?= __('admin.membership_payment_status') ?></label>
	<select class="form-control" name="membership">
		<option <?= (int) $setting_data['membership']['status'] == '0' ? 'selected' : '' ?> value="0"><?= __('admin.disabled') ?></option>
		<option <?= (int) $setting_data['membership']['status'] == '1' ? 'selected' : '' ?> value="1"><?= __('admin.enabled') ?></option>
	</select>
</div>

<div class="form-group">
	<label class="control-label"><?= __('admin.upload_proof_status') ?></label>
	<select class="form-control" name="proof">
		<option <?= (int)$setting_data['proof'] == '0' ? 'selected' : '' ?> value="0"><?= __('admin.disabled') ?></option>
		<option <?= (int)$setting_data['proof'] == '1' ? 'selected' : '' ?> value="1"><?= __('admin.enabled_and_optional') ?></option>
		<option <?= (int)$setting_data['proof'] == '2' ? 'selected' : '' ?> value="2"><?= __('admin.enabled_and_required') ?></option>
	</select>
</div>

<?php 
	$bank_names = [];

	if(isset($setting_data['bank_names']) && ! empty($setting_data['bank_names'])){
		$bank_names = (array)json_decode($setting_data['bank_names'],1);
	}
?>

<div class="form-group">
	<label class="control-label"><?= __('admin.bank_details_1') ?></label>
	<input class="form-control required" type="text" name="bank_names[]" value="<?= isset($bank_names[0]) ? $bank_names[0] : ""; ?>" placeholder="<?= __('admin.bank_details_1') ?>">
	<textarea class="form-control required" rows="8" name="bank_details"><?= $setting_data['bank_details'] ?></textarea>
</div>

<div class="additional-bank">
	<?php
		if(isset($setting_data['additional_bank_details'])){
			$additional_bank_details = (array)json_decode($setting_data['additional_bank_details'],1);
			foreach ($additional_bank_details as $key => $value) {
				echo '<div class="form-group">';
				echo '	<label class="control-label w-100">'.__('admin.bank_details').' '. ($key+2) .' <span class="text-danger cursor-pointer pull-right remove-bank">'.__('admin.remove').'</span></label>';
				?>
				<input class="form-control required" type="text" name="bank_names[]" value="<?= isset($bank_names[$key+1]) ? $bank_names[$key+1] : "" ?>" placeholder="<?= __('admin.bank_name') ?> <?= ($key+2) ?>">
				<?php
				echo '	<textarea class="form-control required" rows="8" name="additional_bank_details[]">'. $value .'</textarea>';
				echo '</div>';
			}
		}
	?>
</div>

<div class="text-right">	
	<button type="button" class="btn btn-add-bank btn-primary"><?= __('admin.add_bank') ?></button>
</div>

<script type="text/javascript">
	$(".btn-add-bank").on("click", function(){
		let blengths = $(".additional-bank > div").length;
		var html = '';
		html += '<div class="form-group">';
		html += '	<label class="control-label w-100">Bank Details '+ (blengths + 2) +' <span class="text-danger cursor-pointer pull-right remove-bank">Remove</span></label>';
		html += '	<input class="form-control required" type="text" name="bank_names[]" placeholder="Bank Name '+(blengths + 2)+'">';
		html += '	<textarea class="form-control required" rows="8" name="additional_bank_details[]"></textarea>';
		html += '</div>';

		$(".additional-bank").append(html)
	})

	$(".additional-bank").delegate(".remove-bank","click",function(){
		$(this).parents(".form-group").remove();
	})
</script>