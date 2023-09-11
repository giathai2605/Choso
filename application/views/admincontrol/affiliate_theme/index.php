<div class="card">
	<div class="card-body">
		<form autocomplete="off" method="post" enctype="multipart/form-data" id="setting-form">
			<div class="theme-container form-row">
				<?php foreach ($front_themes as $theme) {  ?>
				<div class="col-sm-4 mb-3">
					<div class="theme-box <?= $login['front_template'] == $theme['id'] ? 'selected' : '' ?> ">
						<img class="theme-image" src="<?= base_url('assets/images/themes/'.$theme['image']) ?>">
						
						<div class="form-row text-center mt-2">
							
						   <div class="col">
						      <button type="button" class="btn-primary form-control active">
						      <?= $theme['name'] ?>
						   	</button>
						    </div> 

						   <div class="col">
								<?php
									if(in_array($theme['name'],['Index 1','Index 2','Index 3','Index 4','Index 5','Index 6','Index 7','Index 8','Index 9','Index 10','Index 11'])) { ?>
									<button type="button" data-id='<?= $theme['id'] ?>' 
										class="btn-primary theme-btn form-control active" data-toggle="modal" data-target="#title-and-content-form-modal">
										<i class="bi bi-pencil-square"></i>
									</button>
								<?php } ?>
								<?php
									if(!empty($theme['id']) && $theme['id'] == "multiple_pages"){
									?>
									<a class="btn-primary theme-btn form-control active" href="<?= base_url('themes/multiple_theme') ?>"><i class="bi bi-pencil-square"></i></a>
					         <?php } ?>
						   </div>

						   <div class="col">
							   <button type="button" data-id='<?= $theme['id'] ?>' class="btn-primary theme-btn btn-theme-active form-control">
									<?= __('admin.active') ?>
								</button>
						   </div>

						   <div class="col">
							   <a href="<?= base_url('?tmp_theme='. $theme['id']) ?>" target="_blank" class="btn-primary theme-btn form-control active"><?= __('admin.preview') ?>
								</a>
						   </div>
						</div>

					</div>
				</div>
				<?php } ?>
			</div>
		</form>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="title-and-content-form-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-dark m-0">
					<?= __('admin.update_home_about_policy') ?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
	<div class="modal-body">
	<div class="form-group">
          <label class="control-label pull-left"><?= __('admin.select_language') ?></label>
          <select class="form-control" name="language_id" id="drpLanguage" onchange="return changeLanguage();">
              <?php 
              if(isset($languages))
              {
                  $language_id=1;
                  foreach($languages as $language)
                  {?>
                  <option 
                  <?php 
                  	if($language['is_default']==1) {echo 'selected';} ?> value="<?=$language['id']?>">
                  	<?=$language['name'] ?>
                  </option>
                 <?php  }     
              }?>
          </select>
   		</div>
   		<br>

		<div class="form-group text-left text-dark">
			<label><?= __('admin.home_heading') ?></label>
			<input id="loginclient_heading" type="text" class="form-control" value="<?= (isset($loginclient['heading'])) ? $loginclient['heading'] : ""; ?>"/>
		</div>
		<div class="form-group text-left text-dark">
			<label><?= __('admin.home_content') ?></label>
			<textarea id="loginclient_content" class="form-control" rows="3"><?= (isset($loginclient['content'])) ? $loginclient['content'] : ""; ?></textarea>
		</div>

		<div class="form-group text-left text-dark">
			<label><?= __('admin.about_content') ?></label>
			<textarea id="loginclient_about_content" class="form-control" rows="3"><?= (isset($loginclient['about_content'])) ? $loginclient['about_content'] : ""; ?></textarea>
		</div>
		<div class="form-group text-left text-dark">
			<label><?= __('admin.policy_heading') ?></label>
			<input name="policy_heading" id="policy_heading" type="text" class="form-control" value="<?= (isset($tnc['heading'])) ? $tnc['heading'] : ""; ?>" />
			</div>

		<div class="form-group text-left text-dark">
			<label><?= __('admin.policy_content') ?></label>
			<textarea name="policy_content" id="policy_content" class="form-control summernote"><?= (isset($tnc['content'])) ? $tnc['content'] : ""; ?></textarea>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">
			<?= __('admin.close') ?>
		</button>
		<button id="loginclient_details_submit" type="button" class="btn btn-primary">
			<?= __('admin.save_changes') ?>
		</button>
	</div>
		</div>
	</div>
</div>


<script type="text/javascript">

	function error_function($cname,$msg)
	{
			$ele=$("#"+ $cname); 
      		$ele.parents(".form-group").addClass("has-error");
			$ele.after("<span class='text-danger'>"+$msg +"</span>");
	}
	$('#loginclient_details_submit').on('click', function(){
		$this = $(this);
      	let data = {
      		loginclient:true,
      		tnc:true,
      		language_id : $('#drpLanguage').val(),
      		heading : $('#loginclient_heading').val(),
      		content : $('#loginclient_content').val(),
      		about_content : $('#loginclient_about_content').val(),
      		policy_heading : $('#policy_heading').val(),
      		policy_content : $('#policy_content').val()
      	};

      	if(data.heading=='')
      	{
      		error_function('loginclient_heading','<?= __('admin.home_heading_is_required') ?>');  
      	}

      	if(data.content=='')
      	{
      		error_function('loginclient_content','<?= __('admin.home_content_is_required') ?>');  
      	}
      	
      	if(data.about_content=='')
      	{
      		error_function('loginclient_about_content','<?= __('admin.about_content_is_required') ?>');  
      	}

      	if(data.policy_heading=='')
      	{
      		error_function('policy_heading','<?= __('admin.policy_heading_is_required') ?>'); 
      	}
      	 
      	if(data.policy_content=='')
      	{
      		error_function('policy_content','<?= __('admin.policy_content_is_required') ?>');  
      	}

		$this.btn("loading");
 		 if(data.heading != "" && data.content != "" && data.about_content != "" && data.policy_heading != "" && data.policy_content != "") {
			$.ajax({
				type:'POST',
				dataType:'json',
				data:data,
				complete:function(){
					$this.btn("reset");
				},
				success:function(response){
					if(response.success) {
						$('#title-and-content-form-modal').modal('hide');
						showPrintMessage(response['success'],'success');
					} else {
						Swal.fire({
							icon: 'error',
							text: response.message,
						});
					} 
				},
			});
		} else {
			$this.btn("reset");
				console.log(json);
				if(json['errors']){
				    $.each(json['errors'], function(i,j){
				    	console.log(i);
				        $ele = $this.find('[name="'+ i +'"]');
				        if($ele){
				            $ele.parents(".form-group").addClass("has-error");
				            $ele.after("<span class='text-danger'>"+ j +"</span>");
				        }
				    })
				}
		}
	});

	$(".theme-container").delegate(".btn-theme-active","click",function(evt){
		$this = $(this);
		$.ajax({
	        type:'POST',
	        dataType:'json',
	        data:{
	        	id: $this.attr("data-id"),
	        	action:'active_theme',
	        },
	        beforeSend:function(){ $this.btn("loading"); },
					complete:function(){$this.btn("reset"); },
	        success:function(result){
	            $(".alert-dismissable").remove();

	            $this.find(".has-error").removeClass("has-error");
	            $this.find("span.text-danger").remove();
	            
	            if(result['success']){
		            $(".theme-box.selected").removeClass('selected');
		            $this.parents('.theme-box').addClass('selected')

	                showPrintMessage(result['success'],'success');
	                var body = $("html, body");
					body.stop().animate({scrollTop:0}, 500, 'swing', function() { });

					var div = $(".theme-box.selected").parents(".col-sm-4").clone()
					$(".theme-box.selected").parents(".col-sm-4").remove();
					div.prependTo(".theme-container");

					$(".btn-theme-active").removeClass("btn-loading");
	            }
	        },
	    })
	});

	function changeLanguage()
	{
		getContent('<?= base_url("admincontrol/getLoginContent_ajax")?>');
		return false;
	}

	function getContent(url)
    {
		$("#loginclient_heading").val('');
		$("#loginclient_content").val(''); 
		$("#loginclient_about_content").val('');
		$("#policy_heading").val('');
		$("#policy_content").val('');
		$('.summernote').summernote('code', '');
		$('.summernote').html('');

      $this = $(this);
      let data = {
				loginclient : true,
				tnc : true,
				language_id : $('#drpLanguage').val() 
			};
       $.ajax({
            url:url,
            type:'POST',
            dataType:'json',
            data:data,
            beforeSend:function(){$this.btn("loading");},
            complete:function(){$this.btn("reset");},
            success:function(json){ 
               if(json){
                  $("#loginclient_heading").val(json['home_heading']); 
                  $("#loginclient_content").val(json['home_content']); 
                  $("#loginclient_about_content").val(json['about_content']);
                  $("#policy_heading").val(json['policy_heading']);
                  $("#policy_content").val(json['policy_content']);
                  $('.summernote').summernote('code', '')
                  $('.summernote').html(escape($('.summernote').summernote('code', json.policy_content)))
               } else {
                 
               }
            },
       });
    }
</script>
