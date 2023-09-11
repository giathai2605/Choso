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