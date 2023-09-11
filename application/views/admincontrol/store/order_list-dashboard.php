<?php foreach($orders as $index => $order){ ?>
	<?php if($order['type'] == 'store'){ ?>
		<tr>
			<td><?= orderId($order['id']);?></td>
			<td class="txt-cntr"><?php echo c_format($order['total']); ?></td>
			<td class="txt-cntr"><?php echo $order['order_country_flag'];?></td>
			<td class="txt-cntr"><img width="30" height="30" src="<?= base_url('assets/images/wallet-icon/local_store.png') ?>"></td>
			<?php 
				$icon = strtolower(str_replace(" ", "_", $status[$order['status']])) .'.png';
			?>
			<td class="txt-cntr">
				<div class="badge <?= ($order['status'] == 1) ? 'badge-success' : 'badge-warning' ?>">
					<?= $status[$order['status']] ?>
				</div>
			</td>
			<td class="txt-cntr">
				<?php
				if($order['wallet_commission_status'] == 0) {
					?>
					<span class="badge <?php if((int)$order['wallet_status'] > 0){ ?>badge-success<?php }else{ ?>badge-warning<?php } ?>"><?= $wallet_status[(int)$order['wallet_status']] ?></span>
					<?php
			 	} else {
					echo commission_status($order['wallet_commission_status']);
			 	}

				?>
				<br>
				<?php echo c_format($order['commission_amount']); ?>
			</td>
			<td class="txt-cntr"><?= date("d-m-Y h:i A",strtotime($order['created_at'])); ?></td>
		</tr>
		 <?php
	} else { ?>
		<tr>
			<td><?= orderId($order['order_id']);?></td>
			<td class="txt-cntr"><?php echo c_format($order['total']); ?></td>
			<td class="txt-cntr"><?php echo $order['order_country_flag'];?></td>
			<td class="txt-cntr"><img width="30" height="30" src="<?= base_url('assets/images/wallet-icon/external_store.png') ?>"></td>
			<td class="txt-cntr">
				<div class="badge <?= ($order['status'] == 1) ? 'badge-success' : 'badge-warning' ?>">
					<?= $status[$order['status']] ?>
				</div>
			</td>
			<td class="txt-cntr">
				<?php

				if($order['wallet_commission_status'] == 0) {
					?>
					<span class="badge <?php if((int)$order['wallet_status'] > 0){ ?>badge-success<?php }else{ ?>badge-warning<?php } ?>"><?= $wallet_status[(int)$order['wallet_status']] ?></span>
					<?php
			 	} else {
					echo commission_status($order['wallet_commission_status']);
			 	}

			 	
				?>
				<br>
				<?= c_format($order['commission']) ?>
			</td>
			<td class="txt-cntr"><?php echo date("d-m-Y h:i A",strtotime($order['created_at'])); ?></td>
			 
		</tr>
		 <?php
	}
} ?>


<?php if(empty($orders)){ ?>
    <tr>
        <td colspan="100%" class="text-center">
            <h3 class="text-muted py-4"><?= __("admin.no_orders") ?> </h3>
            <h5 class="text-muted py-4">
            </h5>
        </td>
    </tr>
<?php } ?>
 