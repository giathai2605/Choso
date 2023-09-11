<div class="form-group">
	<label class="control-label"><?= __('admin.store_payment_status') ?></label>
	<select class="form-control" name="store">
		<option <?= (int)$setting_data['store']['status'] == '0' ? 'selected' : '' ?> value="0"><?= __('admin.disabled') ?></option>
		<option <?= (int)$setting_data['store']['status'] == '1' ? 'selected' : '' ?> value="1"><?= __('admin.enabled') ?></option>
	</select>
</div>

<div class="form-group">
	<label class="control-label"><?= __('admin.deposit_payment_status') ?></label>
	<select class="form-control" name="deposit">
		<option <?= (int)$setting_data['deposit']['status'] == '0' ? 'selected' : '' ?> value="0"><?= __('admin.disabled') ?></option>
		<option <?= (int)$setting_data['deposit']['status'] == '1' ? 'selected' : '' ?> value="1"><?= __('admin.enabled') ?></option>
	</select>
</div>

<div class="form-group">
	<label class="control-label"><?= __('admin.membership_payment_status') ?></label>
	<select class="form-control" name="membership">
		<option <?= (int)$setting_data['membership']['status'] == '0' ? 'selected' : '' ?> value="0"><?= __('admin.disabled') ?></option>
		<option <?= (int)$setting_data['membership']['status'] == '1' ? 'selected' : '' ?> value="1"><?= __('admin.enabled') ?></option>
	</select>
</div>

<div class="form-group">
	<label class="control-label">E-Mail</label>
	<input class="form-control" name="email" value="<?= $setting_data['email'] ?>">
</div>

<div class="form-group">
	<label class="control-label">Secret</label>
	<input class="form-control" name="secret" value="<?= $setting_data['secret'] ?>">
</div>


<div class="form-group">
	<label class="control-label">Order Status</label>
	<select name="order_status" class="form-control">
		<?php foreach ($order_status as $order_status_id => $name){ 
				if(isset($setting_data['order_status']))
					$selected = ($order_status_id == $setting_data['order_status']) ? 'selected' : '';
				else 
					$selected = ($order_status_id == 1) ? 'selected' : ''; ?>
				
				<option <?= $selected ?>  value="<?= $order_status_id; ?>"><?= $name ?></option>
		<?php } ?>
	</select>
</div>

<div class="form-group">
	<label class="control-label">Failed Status</label>
	<select name="failed_status" class="form-control">
		<?php foreach ($order_status as $order_status_id => $name){ 
				if(isset($setting_data['failed_status']))
					$selected = ($order_status_id == $setting_data['failed_status']) ? 'selected' : '';
				else 
					$selected = ($order_status_id == 5) ? 'selected' : ''; ?>
				
				<option <?= $selected ?>  value="<?= $order_status_id; ?>"><?= $name ?></option>
		<?php } ?>
	</select>
</div>

<div class="form-group">
	<label class="control-label">Pending Status</label>
	<select name="pending_status" class="form-control">
		<?php foreach ($order_status as $order_status_id => $name){ 
				if(isset($setting_data['pending_status']))
					$selected = ($order_status_id == $setting_data['pending_status']) ? 'selected' : '';
				else 
					$selected = ($order_status_id == 6) ? 'selected' : ''; ?>
				
				<option <?= $selected ?>  value="<?= $order_status_id; ?>"><?= $name ?></option>
		<?php } ?>
	</select>
</div>

<div class="form-group">
	<label class="control-label">Canceled Status</label>
	<select name="canceled_status" class="form-control">
		<?php foreach ($order_status as $order_status_id => $name){ 
				if(isset($setting_data['canceled_status']))
					$selected = ($order_status_id == $setting_data['canceled_status']) ? 'selected' : '';
				else 
					$selected = ($order_status_id == 11) ? 'selected' : ''; ?>
				
				<option <?= $selected ?>  value="<?= $order_status_id; ?>"><?= $name ?></option>
		<?php } ?>
	</select>
</div>

<div class="form-group">
	<label class="control-label">Chargeback Status</label>
	<select name="chargeback_status" class="form-control">
		<?php foreach ($order_status as $order_status_id => $name){ 
				if(isset($setting_data['chargeback_status']))
					$selected = ($order_status_id == $setting_data['chargeback_status']) ? 'selected' : '';
				else 
					$selected = ($order_status_id == 7) ? 'selected' : ''; ?>
				
				<option <?= $selected ?>  value="<?= $order_status_id; ?>"><?= $name ?></option>
		<?php } ?>
	</select>
</div>