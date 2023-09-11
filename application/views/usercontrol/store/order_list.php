<?php foreach($orders as $index => $order){ ?>

	<?php if($order['type'] == 'store'){ ?>
	<tr>
		<td>
			<button type="button" class="d-inline-block toggle-child-tr"><i class="fa fa-plus"></i></button>
			<?php echo $start_from + $index; ?>
		</td>
		<td><?php echo $order['id'];?></td>
		<td class="txt-cntr"><?php echo c_format($order['total_sum']); ?></td>
		<td class="txt-cntr"><?php echo $order['order_country_flag'];?></td>
		<td class="txt-cntr"><img width="30px" height="30px" src="<?= base_url('assets/images/wallet-icon/local_store.png') ?>"></td>
		<?php 
			$icon = strtolower(str_replace(" ", "_", $status[$order['status']])) .'.png';
		?>
		<td class="txt-cntr"><img width="30px" height="30px" title="<?= $status[$order['status']] ?>" alt="<?php echo $icon; ?>" src="<?= base_url('assets/images/wallet-icon/'. $icon) ?>"></td>
		<td class="txt-cntr">
			<?php echo c_format($order['commission_amount']); ?>
				<br>
			<?php

			if($order['wallet_commission_status'] == 0) {
				?>
				<span class="badge <?php if((int)$order['wallet_status'] > 0){ ?>badge-success<?php }else{ ?>badge-warning<?php } ?>"><?= $wallet_status[(int)$order['wallet_status']] ?></span>
				<?php
		 	} else {
				echo commission_status($order['wallet_commission_status']);
		 	}

			?>
		</td>
		<td><?php echo wallet_paid_status($order['wallet_status']);?></td>
		<td class="txt-cntr"><?php echo date("d-m-Y h:i A",strtotime($order['created_at'])); ?></td>
		
	</tr>
	<tr class="detail-tr">
		<td colspan="100%">
            <div>
                <ul>
					<li><b><?= __('user.payment_method') ?> :</b> <span><?= $order['payment_method']; ?></span> </li>
					<li><b><?= __('user.transaction') ?> :</b> <span><?= $order['txn_id'] ?></span> </li>
					<li><b><?= __('user.ip') ?> :</b> <span><?= $order['ip'] ?></span> </li>
					<li><b><?= __('user.country_code') ?> :</b> <span><?= $order['country_code'] ?></span> </li>
					<li><b><?= __('user.currency_code') ?> :</b> <span><?= $order['currency_code'] ?></span> </li>
					<li><br>
						<b>Products</b>
						<table class="detail-table">
							<tr>
								<th colspan="2"><?= __('user.name') ?></th>
								<th><?= __('user.unit_price') ?></th>
								<th><?= __('user.variation_price') ?></th>
								<th><?= __('user.quantity') ?></th>
								<th><?= __('user.commission_type') ?></th>
								
								<th><?= __('user.total_discount') ?></th>
								<th><?= __('user.total') ?></th>
							</tr>
							<?php foreach ($order['products'] as $key => $product) { ?>
								<tr>
									<td><img src="<?= $product['image'] ?>" style="width: 40px;height: 40px"></td>
									<td>
										<?php
											$combinationString = "";
											if(isset($product['variation']) && !empty($product['variation'])) {
												$variation = json_decode($product['variation']);
												foreach ($variation as $key => $value) {
													if($key == 'colors') {
														$combinationString .= ($combinationString == "") ? explode("-",$value)[1] : ",".explode("-",$value)[1];
													} else {
														$combinationString .= ($combinationString == "") ? $value : ",".$value;
													}
												}
											}
										?>
										<?= $product['product_name'] ?> <?= ($combinationString != "") ? "(".$combinationString.")" : "" ?>
										<?php if($product['coupon_discount'] > 0){ ?>
			                                <p class="couopn-code-text">
			                                	<?= __('user.code') ?> : <span class="c-name"> <?= $product['coupon_code'] ?></span> <?= __('user.applied') ?>
			                                </p>
		                                <?php } ?>
									</td>
									<td><?php echo c_format($product['price']); ?></td>
									<td><?php echo c_format(json_decode($product['variation'])->price); ?></td>
									<td><?php echo $product['quantity']; ?></td>
									<td><?php echo $product['commission_type']; ?></td>
									<td><?php echo c_format($product['coupon_discount']);  ?></td>
									<td><?php echo c_format($product['total']); ?></td>
								</tr>
							<?php } ?>
							<?php foreach ($order['totals'] as $key => $total) { ?>
								<tr>
									<td colspan="5"></td>
									<td><?= $total['text'] ?></td>
									<td><?php echo c_format($total['value']); ?></td>
								</tr>
							<?php } ?>
						</table>
					</li>

					<li>
						<b>Payment Info</b>
						<table class="detail-table">
							<thead>
								<th class="border-top-0"><?= __('user.mode') ?></th>
								<th class="border-top-0"><?= __('user.transaction_id') ?></th>
								<th class="border-top-0"><?= __('user.payment_status') ?></th>
							</thead>
							<tbody>
								<?php if($order['status'] == 0){ ?>
									<tr>
										<td colspan="100%">
											<p class="text-muted text-center"> <?= __('user.waiting_for_payment_status') ?> </p>
										</td>
									</tr>
								<?php } ?>
								<?php foreach ($order['payment_history'] as $key => $value) { ?>
								<tr>
									<td><?php echo $value['payment_mode'];?></td>
									<td><?php echo $order['txn_id'];?></td>
									<td><?php echo $value['paypal_status'] ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</li>

					<li>
						<b>Order Info</b>
						<table class="detail-table">
							<thead>
								<tr>
									<th width="50px">#</th>
									<th width="150px"><?= __('user.status') ?></th>
									<th><?= __('user.comment') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if(!$order['order_history']){ ?>
									<tr>
										<td colspan="100%">
											<p class="text-muted text-center"><?= __('user.no_any_order_status') ?></p>
										</td>
									</tr>
								<?php } ?>
								<?php foreach ($order['order_history'] as $key => $value) { ?>
								<tr>
									<td>#<?= $key ?></td>
									<td><?= $status[$value['order_status_id']] ?></td>
									<td style="white-space: pre-line;"><?= $value['comment'] ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</li>

					<?php if($order['custom_data']) {
						$order['custom_data'] = json_decode($order['custom_data']);
		            	foreach ($order['custom_data'] as $key => $value) { ?>
		            	<li><b><?= $value->key ?></b>: <?= $value->value ?></li>
		            	<?php }
		            	} ?>
                </ul>
           	</div>
      	</td>
	</tr>
	<?php } else { ?>
		<tr>
			<td>
				<button type="button" class="d-inline-block toggle-child-tr"><i class="fa fa-plus"></i></button>				
				<?php echo $start_from + $index; ?>
			</td>
			<td><?php echo $order['id'];?></td>
			<td class="txt-cntr"><?php echo c_format($order['total']); ?></td>
			<td class="txt-cntr"><?php echo $order['order_country_flag'];?></td>
			<td class="txt-cntr"><img width="30px" height="30px" src="<?= base_url('assets/images/wallet-icon/external_store.png') ?>"></td>
			<td class="txt-cntr"><img width="30px" height="30px" title="Complete" src="<?= base_url('assets/images/wallet-icon/complete.png') ?>"></td>
			<td class="txt-cntr">
				<?= c_format($order['commission']) ?>
					<br>
				<?php

			if($order['wallet_commission_status'] == 0) {
				?>
				<span class="badge <?php if((int)$order['wallet_status'] > 0){ ?>badge-success<?php }else{ ?>badge-warning<?php } ?>"><?= $wallet_status[(int)$order['wallet_status']] ?></span>
				<?php
		 	} else {
				echo commission_status($order['wallet_commission_status']);
		 	}

			?>
			</td>
			<td><?php echo wallet_paid_status($order['wallet_status']);?></td>
			<td class="txt-cntr"><?php echo date("d-m-Y h:i A",strtotime($order['created_at'])); ?></td>
			
		</tr>
		<tr class="detail-tr">
			<td colspan="100%">
	            <div>
	                <ul>
						<li><b><?= __('user.product_ids') ?> :</b> <span><?= $order['product_ids'] ?></span></li>
						<li><b><?= __('user.total') ?> :</b> <span><?= $order['total'] ?></span></li>
						<li><b><?= __('user.currency') ?> :</b> <span><?= $order['currency'] ?></span></li>
						<li><b><?= __('user.commission_type') ?> :</b> <span><?= $order['commission_type'] ?></span></li>
						<li><b><?= __('user.ip') ?> :</b> <span><?= $order['ip'] ?></span></li>
						<li><b><?= __('user.country_code') ?> :</b> <span><?= $order['country_code'] ?>&nbsp;<img title="<?= $order['country_code'] ?>" src="<?= base_url('assets/vertical/assets/images/flags/'. strtolower($order['country_code'])) ?>.png" width='25' height='15'></span></li>
						<li><b><?= __('user.website') ?> :</b> <span><a href="//<?= $order['base_url'] ?>" target='_blank'><?= $order['base_url'] ?></a></span></li>
						<li><b><?= __('user.script_name') ?> :</b> <span><?= ucfirst($order['script_name']) ?></span></li>
						<?php if($order['custom_data']) {
							$order['custom_data'] = json_decode($order['custom_data']);
		            	foreach ($order['custom_data'] as $key => $value) { ?>
		            	<li><b><?= $value->key ?></b>: <?= $value->value ?></li>
		            	<?php }
		            	} ?>
	                </ul>
	           	</div>
	      	</td>
		</tr>
	<?php } ?>
<?php } ?>