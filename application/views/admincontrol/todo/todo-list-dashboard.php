
<?php foreach($todolist as $index=>$list){ ?>
    <tr>
        <td class="txt-cntr"><?=$list['id'] ?></td>
        <td class="txt-cntr"><?=$list['title'] ?></td>
        <td class="txt-cntr"><?=$list['start'] ?></td>
        <td class="txt-cntr"><?=$list['is_done']==1 ? 'Complete ':'Processed' ?></td>
        <td class="txt-cntr"><?=$list['created_at'] ?></td>
        <td class="txt-cntr"><?=$list['updated_at'] ?></td>
    </tr>
  <?php  } ?>


  <?php if(empty($todolist)){ ?>
    <tr>
        <td colspan="100%" class="text-center">
            <h3 class="text-muted py-4"><?= __("admin.no_todo_list_yet") ?> </h3>
            <h5 class="text-muted py-4">
                <a href="<?= base_url('admincontrol/todolist') ?>" target="_blank">
                    <?= __("admin.add_new_task_here") ?>
                </a>
            </h5>
        </td>
    </tr>
<?php } ?>