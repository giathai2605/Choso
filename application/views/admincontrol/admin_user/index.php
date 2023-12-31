<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
			<div class="card-header">
				<h4 class="card-title pull-left"><?= __('admin.manage_admin')?></h4>
				<div class="pull-right">
					<a class="btn btn-primary" href="<?= base_url('admincontrol/admin_user_form/')  ?>"><?= __('admin.add_new_admin')?></a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table-hover table-striped table">
						<thead>
							<tr>
								<th><?= __('admin.first_last')?></th>
								<th><?= __('admin.country')?></th>
                                <th><?= __('admin.email')?></th>
								<th><?= __('admin.username')?></th>                                
								<th><?= __('admin.phone')?></th>
								<th><?= __('admin.action')?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(empty($users)){ ?>
								<tr>
									<td colspan="100%" class="text-center"><?= __('admin.empty_admin_list') ?></td>
								</tr>
							<?php } ?>
							<?php foreach ($users as $key => $user) { ?>
								<tr>
									<td><?= $user->firstname ?> <?= $user->lastname ?></td>
									<td>
										 <?php
                                          	if ($user->Country != '') {
                                           		$flag = 'flags/' . strtolower($user->sortname) . '.png';
                                         	} else {
                                            	$flag = 'users/avatar-1.png';
                                          	}
                                         ?>
                                         <img class="rounded-circle" src="<?php echo base_url('assets/vertical/assets/images/'.$flag); ?>" style="width:20px;height: 20px">
									</td>
									<td><?= $user->email ?></td>
									<td><?= $user->username ?></td>
									<td><?= $user->PhoneNumber ?></td>
									<td>
										<a class="btn btn-primary btn-sm" href="<?= base_url('admincontrol/admin_user_form/'. $user->id) ?>"><i class="fa fa-edit"></i></a>
										<a class="btn confirm btn-danger btn-sm" href="<?= base_url('admincontrol/admin_user_delete/'. $user->id) ?>"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div> 
	</div> 
</div>

<script type="text/javascript">
	$(".confirm").on('click',function(){
		if(!confirm('<?= __('admin.are_you_sure') ?>')) return false;

		return 1;
	})
</script>