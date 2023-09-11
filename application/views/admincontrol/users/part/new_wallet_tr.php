<tr class="transaction-table-tr <?= ($class == 'child' || $class == 'child-recurring') ? 'child-row' : '' ?> wallet-id-<?= $value['id'] ?> <?= $recurring ? 'recurring recurringof-'.$recurring : '' ?>" group_id='<?= $value['group_id'] ?>' data-id="<?= $value['id'] ?>">
	

	<?php if($recurring){ ?>
		<td class="escape-middle">
			<div class="checkbox-td">
				<label>
					<input type="checkbox" class="wallet-checkbox" value="<?= $value['id'] ?>">
				</label>
			</div>
		</td>
		<td class="text-center p-relative child-arrow-rec escape-middle">
		</td>
	<?php } else { ?>
		<td class="escape-middle">
			<div class="checkbox-td">
				<label>
					<input type="checkbox" class="wallet-checkbox" value="<?= $value['id'] ?>">
				</label>
			</div>
		</td>
		<td class="escape-middle text-center p-relative <?= $force_class ?> <?= $class == 'child' ? 'child-arrow' : '' ?>">
			<?php if($has_child && $class != 'child'){ ?>
				<button class="show-child-transaction"><i class="fa fa-angle-down"></i></button>
				<div class="button-line"></div>
			<?php } ?>
		</td>
	<?php }  ?>

	<td>
		<div class="no-wrap"><?= dateFormat($value['created_at'],'d F Y') ?></div>
		<div class="no-wrap">
			<span class="badge badge-secondary">ID: <?= $value['id'] ?></span>
		</div>
	</td>

	<td>
		<div class="no-wrap">
			<?php if($value['is_vendor']){ ?>
				<span class="badge badge-blue-grey"><?= __('admin.vendor') ?></span>
			<?php } else { ?>
				<span class="badge badge-secondary"><?= __('admin.admin') ?></span>
			<?php } ?>
		</div>
	</td>

	<td>
		<?php echo $value['username']; ?>
		<div>
			<span class="badge badge-default font-weight-normal"><?= wallet_whos_commission($value) ?></span>
		</div>	

	</td>
	<td>
		<?= $order_type = wallet_ex_type($value,$class) ?>
		<?php if(!$order_type){ ?>
			<?= wallet_type($value) ?>
		<?php } ?>
		<?php if(!$value['parent_id'] && $class != "child"){
				if(($value['type'] == 'sale_commission' || $value['type'] == 'admin_sale_commission' || $value['type'] == 'vendor_sale_commission') && ($value['comm_from'] == 'store' || $value['comm_from'] == 'ex') && !empty($value['reference_id_2'])){ ?>
				
				<button class="hover-danger wallet-btn ml-2 mr-0 view-tran-details" data-ref_id_1="<?= $value['reference_id'] ?>" data-ref_id_2="<?= $value['reference_id_2'] ?>" data-comm_from="<?= $value['comm_from'] ?>">
				<i class="fa fa-info-circle" style="font-size:24px; overflow: hidden; vertical-align: middle;"></i>
				</button>
		<?php }
		} ?>

		<?php if($class != 'child' && $class != 'child-recurring'): ?>
			<div>
				<?php if($value['integration_orders_total']){ ?>
					<small class="badge badge-default payment-method"><?= c_format($value['integration_orders_total']) ?></small>
				<?php } ?>
				<?php if($value['local_orders_total']){ ?>
					<small class="badge badge-default payment-method"><?= c_format($value['local_orders_total']) ?></small>
				<?php } ?>

				<?php if($value['payment_method']){ ?>
				 	<small class="badge badge-default payment-method"><?= payment_method($value['payment_method']) ?></small>
				<?php } ?>
			</div>
		<?php endif ?>
	</td>
	<td style="min-width: 180px !important; vertical-align: middle;">
		<div class="no-wrap">
			<div class="dpopver-content d-none">
				<?php
					list($message, $ip_details) = parseMessage($value['comment'],$value,'admincontrol',true);
					echo "<div>". $message ."</div>";
				?>
			</div>
			<div class="badge badge-<?= is_need_to_pay($value) ? 'danger' : 'secondary' ?> py-1 pl-2 font-14" 
				toggle="popover"> 
				<?= c_format($value['amount']) ?> 
			</div>
			<button toggle="popover" class="wallet-popover btn-wallet-info">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
			</button>
			<?php
				$ip_details2 = json_decode($value['ip_details'], true);
			?>
			<ul class="ip-list list-inline float-right mb-0">
				<li class="list-inline-item dropdown">
					<a href="javascript:void(0)" title="" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-align-justify"></i>
					</a>

					<ul class="dropdown-menu country-dropdown">
						<?php foreach ($ip_details2 as  $ip2) { ?>
					    	<li>
					    		<span class="flag"><i class="flag-sm m-auto d-block flag-sm-<?= strtoupper($ip2['country_code']) ?>"></i> </span>
					    		<span class="ip"> <?= $ip2['country_code'] ?> <?= (!empty($ip2['ip'])) ? $ip2['ip'] : '<i>'.__('admin.ip_not_available').'</i>' ?></span>
					    	</li>
					    <?php } ?>
					  </ul>
				</li>
			</ul>
		</div>
	</td>

	<?php $wallet_type_action = wallet_type($value, 'code'); ?>

	<td><div class="transaction-type"><?= $wallet_type_action; ?></div></td>

	<td class="text-center z-index-1">
		<?php
		if($value['user_id'] == 1 && $value['status'] == 1)
			$value['status'] = 3;

		if(!isset($hideStaticStatus)) { 
			$id = (!empty($child_id) && $value['amount'] < 0) ? $child_id : $value['id'];

			$req_query = $this->db->query("SELECT * from wallet_requests WHERE FIND_IN_SET($id,tran_ids)");
			$req_query = $req_query->row_array();

			if($value['amount'] < 0 && ! sizeof($req_query) > 0) {
				$goups_res = $this->db->query("SELECT id from wallet WHERE group_id=".$value['group_id']."")->result();
				foreach ($goups_res as $res) {
					$req_query = $this->db->query("SELECT * from wallet_requests WHERE FIND_IN_SET(".$res->id.",tran_ids)");
					$req_query = $req_query->row_array();
					if(sizeof($req_query) > 0) {break;}
				}
			}

			if($req_query['status'] != ''){
				$fixed_status = array(2,3,4,5,7,8,9,10,11,12,13);

				if(in_array(intval($req_query['status']), $fixed_status, TRUE)){
					echo withdrwal_status($req_query['status']);
				} else {
					if($value['commission_status'] == 0)
				 		echo $status_icon[$value['status']];
				}	
			} else {
				if($value['commission_status'] == 0)
			 		echo $status_icon[$value['status']];
			}
		 
			echo commission_status($value['commission_status']);
		 } ?>
	</td>

	

	<td>
		<?php
			if($value['user_id'] == 1) {
				echo '<small style="font-size:15px;" class="badge badge-success">'.__('admin.paid').'</small>';
			
			} else {
				if(isset($req_query) && sizeof($req_query) > 0)
				{
					echo withdrwal_status($req_query['status']);
				}
				else
				{
					echo wallet_paid_status($value['status']);
				}
			}
		?>
	</td>

	<td>
		<select id="tran-<?=$value['id']?>" class="form-control change-status" 
			onchange="changeStatus(this,'<?=$value['id']?>','<?= $value['status'] ?>');" >

			<option value="" disabled selected><?= __('admin.select_status') ?></option>
			
			<option <?= ($req_query['status'] == 1) ? "disabled" : "" ?>
					value="1" data-type="comission"><?= __('admin.cancel') ?></option>

			<option <?= ($req_query['status'] == 1) ? "disabled" : "" ?>  
					value="2" data-type="comission"><?= __('admin.trash') ?></option>

			<option value="0" data-type="wallet"><?= __('admin.on_hold') ?></option>

			<option value="1" data-type="wallet"><?= __('admin.in_wallet') ?></option>

			<option value="" data-type="remove"><?= __('admin.remove') ?></option>

			<?php if(!$value['parent_id'] && $class != 'child' && $value['is_vendor'] == 0): ?>
				<option value="" data-type="recursion"><?= __('admin.recursion') ?></option>
			<?php endif ?>		
		</select>
	</td>

	<td class="text-right">
		<div class="text-center actions no-wrap">
			<?php if($value['wallet_recursion_id']){ ?>
                <?php if($class != "child"){  ?>
				<button type="button" class="wallet-btn" title="<?= cycle_details($value['total_recurring'], $value['wallet_recursion_next_transaction'], $value['wallet_recursion_endtime'], $value['total_recurring_amount']) ?>" data-toggle="tooltip" data-id="<?= $value['id'] ?>" >
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
				</button>
    			<?php } ?>

			<?php } ?>
			
			 <?php if($value['has_recursion_records'] > 0) { ?>
		        <button data-toggle="tooltip" title="<?= __('admin.show_recurring_transition') ?>" class="wallet-btn show-recurring-transition" data-id="<?= $value['id'] ?>" style="color:#EB940D !important">
						<span class="plus">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
						</span>
						<span class="minus">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
						</span>
					</button>
		    <?php } ?>
		</div>
	</td>
</tr>


