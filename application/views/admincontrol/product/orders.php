		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-blue-payment">
                  		<div class="card-title-white pull-left m-0"><?= __('admin.orders') ?></div>
	                     <div class="pull-right">
	                     <button id="toggle-uploader" class="btn btn-primary">
	                     	<?php echo __( 'admin.total_orders') ?> : <?= $full_local_store_hold_orders ?>
		               	</button>
		                </div>
	            	</div>
					<div class="card-body">
						<div class="table-rep-plugin">
							<div class="table-responsive b-0" data-pattern="priority-columns">

								<section class="empty-div d-none">
	                                <div class="text-center">
	                                <img class="img-responsive" src="<?php echo base_url(); ?>assets/vertical/assets/images/no-data-2.png" style="margin-top:100px;">
	                                 <h3 class="m-t-40 text-center text-muted"><?= __('admin.no_orders') ?></h3></div>
								</section>

								<table id="orders-table" class="table table-striped">
									<thead class="blue-ng-order">
										<tr>
											<th><?= __('admin.order_id') ?></th>
											<th><?= __('admin.username') ?></th>
											<th><?= __('admin.type') ?></th>
											<th><?= __('admin.price') ?></th>
											<th><?= __('admin.payment_method') ?></th>
											<th><?= __('admin.ip') ?></th>
											<th><?= __('admin.transaction') ?></th>
											<th><?= __('admin.commission') ?></th>
											<th><?= __('admin.status') ?></th>
											<th><?= __('admin.action') ?></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
										    <td colspan="100%" class="text-center">
										        <h3 class="text-muted py-4"><?= __("admin.loading_orders_data_text") ?> </h3>
										        <h5 class="text-muted py-4"><?= __("admin.not_taking_longer") ?> </h5>
										    </td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div> 
			</div> 
		</div>

		<div class="modal" id="model-confirmodal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title m-0"><?= __('admin.change_order_status') ?></h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="complete-text">
							<p class="text-center"><?= __('admin.change_order_status_information_1') ?></p> 
							<p class="text-center"><?= __('admin.change_order_status_information_2') ?></p>
							<br>
						</div>
						<p class="text-center"><b><?= __('admin.are_you_sure') ?></b></p>
						<div class="text-center modal-buttons">
							<button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('admin.close') ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript">
	$(document).on('change', ".status-change-rdo", function(e){
		$this = $(this);
		var id = $this.attr("data-id");
		var val = $this.val();

		$("#model-confirmodal .btn-status-change").remove();
		
		$btn = $('<button type="button" class="btn btn-status-change btn-primary">'+'<?= __('admin.yes_sure') ?>'+'</button>');
		$btn.on('click',function(){
			$btn.prop('disabled',true);
			changeStatus($this,id,val,1);
		});
		$btn.prependTo(".modal-buttons");

		if(val == 1)
			$("#model-confirmodal .complete-text").css('display','block');
		else
			$("#model-confirmodal .complete-text").css('display','none');

		$("#model-confirmodal").modal("show");
	});

	function changeStatus(t,id,val){
		$.ajax({
			url: '<?= base_url("admincontrol/order_change_status") ?>',
			type:'POST',
			dataType:'json',
			data:{id:id,val:val},
			success:function(json){
				$("#model-confirmodal").modal("hide");
				if(json['status'])
					location.reload();
				else
					Swal.fire('<?= __('admin.warning') ?>', '<?= __('admin.order_status_not_change') ?>', 'warning');
			},
		})
	}


	function getOrdersRows(){
        $this = $(this);

        $.ajax({
            url:"<?= base_url('admincontrol/listorders'); ?>",
            type:'POST',
            dataType:'json',
            data:{getOrdersRows:1},
            beforeSend:function(){$this.btn("loading");},
            complete:function(){$this.btn("reset");},
            success:function(json){
                if(json['view']){
                    $("#orders-table tbody").html(json['view']);
                    $("#orders-table").show();
                } else {
                    $(".empty-div").removeClass("d-none");
                    $("#orders-table").hide();
                }

                $("#orders-table .pagination-td").html(json['pagination']);
            },
        })
    }

    $(function() {
        getOrdersRows();
    });
</script>