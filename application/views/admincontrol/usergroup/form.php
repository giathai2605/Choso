<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
			<div class="card-header">
				<h4 class="card-title pull-left"><?= __('admin.manage_group') ?></h4>
				<div class="pull-right">
					<a class="btn btn-primary" href="<?= base_url('admincontrol/usergroup/')  ?>"><?= __('admin.cancel') ?></a>
				</div>
			</div>
			<div class="card-body">
				<form id="admin-form">
					<input type="hidden" name="group_id" value="<?= (!empty($group)?(int)$group->id:'') ?>">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?= __('admin.group_name') ?></label>
								<input placeholder="<?= __('admin.enter_your_group_name') ?>" name="group_name" value="<?php echo !empty($group)?$group->group_name:''; ?>" class="form-control" type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?= __('admin.group_description') ?></label>
								<textarea  rows="8" placeholder="<?= __('admin.enter_group_description') ?>" name="group_description" class="form-control"><?php echo !empty($group)?$group->group_description:''; ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label"><?= __('admin.group_image') ?></label>
								<div class="fileUpload btn btn-sm btn-primary">
									<span><?= __('admin.choose_file') ?></span>
									<input id="uploadBtn" name="avatar" class="upload" type="file">
								</div>
								<?php $avatar = $group->avatar != '' ? 'site/'.$group->avatar : 'no_image_available.png' ; ?>
								<img src="<?php echo base_url();?>assets/images/<?php echo $avatar; ?>" id="group_img" class="thumbnail" border="0" width="220px">
								<input type="hidden" name="oldfile" value="<?php echo !empty($group)?$group->avatar :''; ?>">
							</div>
						</div>
					</div>
					<br>
					<div class="row text-center">
						<div class="col-sm-12">
							<div class="form-group">
								<button type="button" class="btn btn-primary btn-submit"> <?= __('admin.submit') ?></button>
								<span class="loading-submit"></span>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div> 
	</div> 
</div>

<script type="text/javascript">
	
	$("#uploadBtn").change(function(e) {
	  if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				jQuery('#group_img').attr('src', e.target.result);
			}
			reader.readAsDataURL(this.files[0]);
		}
	});

	$(".btn-submit").on('click',function(evt){
        $this = $("#admin-form");
        $(".btn-submit").btn("loading");
		$('.loading-submit').show();

        evt.preventDefault();
        var formData = new FormData($("#admin-form")[0]);

        formData = formDataFilter(formData);
        
        $.ajax({
            url:'<?= base_url('admincontrol/admin_group_form') ?>',
            type:'POST',
            dataType:'json',
            cache:false,
            contentType: false,
            processData: false,
            data:formData,
            xhr: function (){
                var jqXHR = null;

                if ( window.ActiveXObject ){
                    jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
                }else {
                    jqXHR = new window.XMLHttpRequest();
                }
                
                jqXHR.upload.addEventListener( "progress", function ( evt ){
                    if ( evt.lengthComputable ){
                        var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                        $('.loading-submit').text(percentComplete + "% "+'<?= __('admin.loading') ?>');
                    }
                }, false );

                jqXHR.addEventListener( "progress", function ( evt ){
                    if ( evt.lengthComputable ){
                        var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                        $('.loading-submit').text('<?= __('admin.save') ?>');
                    }
                }, false );
                return jqXHR;
            },
            complete:function(result){
            	$(".btn-submit").btn("reset");
            },
            success:function(result){
                $('.loading-submit').hide();
                $this.find(".has-error").removeClass("has-error");
                $this.find("span.text-danger").remove();
                
                if(result['location']){
                    window.location = result['location'];
                }
                if(result['errors']){
                    $.each(result['errors'], function(i,j){
                        $ele = $this.find('[name="'+ i +'"]');
                        if($ele){
                            $ele.parents(".form-group").addClass("has-error");
                            $ele.after("<span class='text-danger'>"+ j +"</span>");
                        }
                    });
                }
            },
        })
        return false;
    });
</script>
