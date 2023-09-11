<?php 
$db =& get_instance();
$userdetails=$db->userdetails();
?>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/ui/jquery-ui.min.css") ?>">
<script type="text/javascript" src="<?= base_url('assets/plugins/ui/jquery-ui.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/select2/select2.min.css") ?>">
<script type="text/javascript" src="<?= base_url('assets/plugins/select2/select2.full.min.js') ?>"></script>
<style>
	.jscolor-picker-wrap{
		z-index:999999 !important;
	}

	 
</style>

<form class="form-horizontal" method="post" action=""  enctype="multipart/form-data" id="form_form">
<div class="row">
<div class="col-sm-12">
<div class="card">
<div class="card-header bg-blue-payment">
	<div class="card-title-white pull-left m-0"><?= (int)$tutorial['id'] == 0 ? __('admin.add_tutorial') : __('admin.edit_tutorial') ?></div>
</div>
<div class="card-body">
	 
	<input type="hidden" id="id" name="id" value="<?php echo $tutorial['id'] ?>">
 	<div class="row">
 		
		<div class="col-sm-4">
			<div class="form-group">
	            <label class="control-label"><?= __('admin.select_language') ?></label>
	            <select class="form-control" name="language_id" id="drpLanguage" onchange="return changeLanguage();">
	                <?php 
	                if(isset($languages))
	                {
	                    $language_id=1;
	                    foreach($languages as $language)
	                    {?>
	                    <option <?php 

	                    if($tutorial['language_id']==$language['id'])
	                    {
	                    	echo 'selected';
	                    }
	                    else if(!isset($tutorial) && $language['is_default']==1) {echo 'selected';} ?> value="<?=$language['id']?>"><?=$language['name'] ?></option>
	                  
	                   <?php  }     
	                }?>
	                
	            </select>
	    	</div>
			 <div class="form-group">
				<label class="control-label"><?= __('admin.category') ?></label>
				<div id="category_dropdown">
					<select name="category_id" id="category_id" class="form-control"> 
						<option value=""><?=__('admin.all_category');?></option>
					</select>
				</div>	
			</div>
		</div>			 
		 
	   	<div class="col-sm-12"> 
	   		<div class="form-group">
                <label  class="control-label"><?= __('admin.page_title') ?></label>
                <input placeholder="<?= __('admin.enter_page_title') ?>" name="title" value="<?php echo $tutorial['title']; ?>" class="form-control"  type="text">
            </div>
            <div class="form-group">
                <label  class="control-label"><?= __('admin.page_content') ?></label>
                <textarea name="content" id="content" class="form-control summernote"><?php echo $tutorial['content']; ?></textarea>
            </div>
            <div class="form-group">
	            <label class="control-label"><?= __('admin.status') ?></label>
	            <select class="form-control" name="status" id="drpStatus">
	            	<option value="0" <?= $tutorial['status']==0 ? 'selected' : ''?>><?= __('admin.deactive') ?></option>
	            	<option value="1" <?= $tutorial['status']==1 ? 'selected' : ''?>><?= __('admin.active') ?></option>
	            </select>
	    	</div>
		</div>
		
		<div class="col-sm-12">
 			 <div class="form-group">
				<button type="submit" class="btn btn-lg btn-default btn-submit btn-success" name="save"><?= __('admin.save') ?></button>
			</div> 
		</div>	
	</div>
</div>
 <script type="text/javascript"> 
 	$selected_category=0;
	<?php if(isset($tutorial)) {?>
		$selected_category='<?=$tutorial['category_id']?>';
		<?php }?>

	function changeLanguage()
    {
       $(".alert-dismissable").remove();
        $this = $(this);
        $.ajax({
            url:'<?= base_url("admincontrol/getTutorialCategory") ?>',
            type:'POST',
            dataType:'json',
            data:{language_id:$("#drpLanguage").val()},
            beforeSend:function(){ $this.btn("loading"); },
            complete:function(){$this.btn("reset"); },
            success:function(json){
            	$("#category_dropdown").html(json.html); 
                
                	if($selected_category!=0)
                	{
                		$("#category_id").val($selected_category);
                		$selected_category=0;
                	}
                	else
                		$("#category_id").val('');
				 	 
             },
        });
        
       return false;
        
    }


	$(document).ready(function() {
		 changeLanguage();

	});


	var cache = {};
 	$(".btn-submit").on('click',function(evt){
		evt.preventDefault();
		$btn = $(this);
		var formData = new FormData($("#form_form")[0]);
		formData.append("action", $(this).attr("name"));
		$this = $("#form_form");	       
		$btn.btn("loading");
		$.ajax({
			url:'<?= base_url('admincontrol/manage_tutorial') ?>',
			type:'POST',
			dataType:'json',
			cache:false,
			contentType: false,
			processData: false,
			data:formData,
			error:function(){ $btn.btn("reset"); },
			success:function(result){            	
				$btn.btn("reset");
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
		});

		return false;
	});
 
</script>
