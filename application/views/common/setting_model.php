<div class="modal-dialog modal-dialog-centered dashboard-setting" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?= $title ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
            <form id="setting-form">
                <input type="hidden" value="<?= $setting_key ?>" name='setting_key'>
                <ul class="switch-wrapp switches">
                    <?php foreach ($settings as $key => $d){ ?>
                        <?php if($d['type'] == 'switch'){
                            $settingK = 'admin_'.$key; 
                            $value = isset($db_value[$settingK]) && $db_value[$settingK] == "1" ? 1 : 0; ?>
                            <li>
                                <div class="switch-toggle">
                                    <div class="switch-group">
                                        <input type="radio" <?= $value == '0' ? 'checked' : '' ?> name="settings[<?= $settingK ?>]" value='0'>
                                        <input type="radio" <?= $value == '1' ? 'checked' : '' ?> name="settings[<?= $settingK ?>]" value='1'>
                                        <label></label>
                                    </div>
                                    <span><?= $d['name'] ?></span>
                                </div>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <?php if($d['type'] == 'number'){
                    $settingK = 'admin_'.$key; 
                    $value = isset($db_value[$settingK]) && $db_value[$settingK] == "1" ? 1 : 0; ?>
                    <div class="dashbord-time">
                        <span><?= $d['name'] ?></span>
                        <input class="form-control allow-number" type="text" name="settings[<?= $settingK ?>]" value='<?= isset($db_value[$settingK]) ? $db_value[$settingK] : '' ?>' >
                        <?php if(isset($d['help'])){ ?>
                            <p class="help-block"><?= $d['help'] ?></p>
                        <?php } ?>
                    </div>
                <?php }  ?>
            </form>    
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary save-settings"><?= __('admin.save') ?></button>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><?= __('admin.close') ?></button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".save-settings").on('click',function(){
        $this = $(this);

        $.ajax({
            url:'<?= base_url('setting/saveSetting') ?>',
            type:'POST',
            dataType:'json',
            data: $("#setting-form").serialize(),
            beforeSend:function(){ $this.btn("loading"); },
            complete:function(){ $this.btn("reset"); },
            success:function(json){
                if(json['success']){
                    $("#setting-widzard").modal("hide");

                    <?php if($setting_key == 'live_dashboard'){ ?>
                        window.location.reload();
                    <?php  } ?>
                    <?php if($setting_key == 'live_log'){ ?>
                        
                        settings_clear = true;
                        last_id_integration_logs = 0;
                        last_id_integration_orders = 0;
                        last_id_newuser = 0;
                        last_id_notifications = 0;

                        $('.btn-count-notification .count-notifications').text(0);
                        $(".ajax-live_window").html('');

                        $(".live-wrap-empty-data").css('display','block');
                        $(".ajax-live_window").css('display','none');

                        getDashboard(false, false,'clearlog');
                    <?php } ?>
                }
            },
        })
    })
</script>