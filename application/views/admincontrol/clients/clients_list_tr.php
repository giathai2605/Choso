<?php foreach($clientslist as $clients){ ?>
<tr>
    <td class="txt-cntr"><?php echo $clients['id'];?></td>
    <td>
        <?php 
            $clientFullName = $clients['firstname']." ".$clients['lastname'];
            echo strlen($clientFullName) > 20 ? substr($clientFullName,0,20)."..." : $clientFullName;
        ?>
    </td>
    <td><?php echo $clients['ref_user'];?></td>
    <td class="txt-cntr"><?php echo $clients['email'];?></td>
    <td class="txt-cntr"><?php echo $clients['phone'];?></td>
    <td class="txt-cntr"><?php echo $clients['username'];?></td>
    <td class="txt-cntr"><?php echo $clients['total_sale'] ?> / <?php echo c_format($clients['amount']); ?></td>
    <td class="txt-cntr"><?php echo __('admin.type_'. $clients['type']);?></td>
    <td class="txt-cntr"> 
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#clientModel<?= $clients['id']?>">
          <i class="fa fa-info" aria-hidden="true" style="color:#ffffff"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="clientModel<?= $clients['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?= __('admin.client_info') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <ul class="list-group list-group-flush text-left">
                    <li class="list-group-item">
                        <strong><?= __('admin.firstname') ?></strong>
                        <?php echo $clients['firstname'];?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.lastname') ?></strong>
                        <?php echo $clients['lastname'];?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.refer_user') ?></strong>
                        <?php echo $clients['ref_user'];?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.email') ?></strong>
                        <?php echo $clients['email'];?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.phone') ?></strong>
                        <?php echo $clients['phone'];?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.username') ?></strong>
                        <?php echo $clients['username'];?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.sales') ?></strong>
                        <?php echo $clients['total_sale']." / ".c_format($clients['amount']); ?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.type') ?></strong>
                        <?php echo __('admin.type_'. $clients['type']);?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.country') ?></strong>
                        <?php echo !empty($clients['country_name']) ? $clients['country_name'] : "<i class='text-muted'>".__('admin.not_available')."</i>";?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.state') ?></strong>
                        <?php echo !empty($clients['state_name']) ? $clients['state_name'] : "<i class='text-muted'>".__('admin.not_available')."</i>";?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.city') ?></strong>
                        <?php echo !empty($clients['City']) ? $clients['City'] : "<i class='text-muted'>".__('admin.not_available')."</i>";?>
                    </li>
                    <li class="list-group-item">
                        <strong><?= __('admin.postal_code') ?></strong>
                        <?php echo !empty($clients['Zip']) ? $clients['Zip'] : "<i class='text-muted'>".__('admin.not_available')."</i>";?>
                    </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <a class="btn btn-info viewShipping" data-id="<?php echo $clients['id'];?>" href="#" title="Click to view Shiping detatils"><i class="fa fa-shopping-cart" aria-hidden="true" style="color:#ffffff"></i></a> 
        <a class="btn btn-danger deleteuser" data-url="<?php echo base_url();?>admincontrol/deleteusers/<?php echo $clients['id'];?>/<?php echo $clients['type'];?>" href="#"><i class="fa  fa-trash-o cursors" aria-hidden="true" style="color:#ffffff"></i></a> 

        <a class="btn btn-primary" onclick="return confirm(<?= __('admin.are_you_sure_to_edit') ?>);" href="<?php echo base_url();?>admincontrol/addclients/<?php echo $clients['id'];?>"><i class="fa fa-edit cursors" aria-hidden="true" style="color:#ffffff"></i></a>
    </td>
</tr>
<?php } ?>