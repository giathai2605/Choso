<div class="form-horizontal" method="post" action=""  enctype="multipart/form-data">
			<div class="row">
				<div class="col-12">
					<div class="card m-b-30">
						<div class="card-body">
							<ul class="nav nav-tabs border-0">
							  <li class="active mr-1"><a data-toggle="tab" href="#user-edit" class="btn btn-primary"><?= __('admin.user') ?></a></li>
							  <?php if($user['id'] > 0){ ?>
							  	<li><a data-toggle="tab" href="#add-transaction" class="btn btn-primary"><?= __('admin.add_transaction') ?></a></li>
							  <?php } ?>
							</ul>

							<br>

							<div class="tab-content">
							  <div id="user-edit" class="tab-pane active">
								<?= $html_form ?> 
								<button class="btn btn-block btn-default btn-success" id="update-user"><i class="fa fa-save"></i> <?= __('admin.submit') ?></button>
							  </div>
							  <?php if($user['id'] > 0){ ?>
								  <div id="add-transaction" class="tab-pane fade">
								    <h3><?= __('admin.add_transaction') ?></h3>
								   
								    <input type="hidden" name="user_id" class="input-transaction" value="<?= isset($user) ? $user['id'] : '' ?>">
								    <div class="form-group">
								    	<label class="control-label"><?= __('admin.amount') ?> <small>(<?= __('admin.total_commission') ?> <?= c_format($totals['unpaid_commition']) ?>)</small> </label>
								    	<input class="form-control input-transaction" type="number" name="amount" value="" min="1" step="any" oninput="validity.valid||(value='');">
								    </div>

								    <div class="form-group">
								    	<label class="control-label"><?= __('admin.comment') ?></label>
								    	<input class="form-control input-transaction" type="text" name="comment" value="">
								    </div>

								    <button class="btn btn-primary add-transaction"><?= __('admin.add_transaction') ?></button>

								  </div>
								<?php } ?>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
<script>
var state_id = '<?php echo $user->state ?>';

$("#Country").on('change',function(){
    var country = $(this).val();
    $.ajax({
        url: '<?php echo base_url('get_state') ?>',
        type: 'post',
        dataType: 'json',
        data: {
            country_id : country
        },
        success: function (json) {
            if(json){
                var html = '';
                $.each(json, function(k,v){
                    if(v.id == state_id){
                        html += '<option value="'+v.id+'" selected="selected">'+v.name+'</option>';
                    }else{
                        html += '<option value="'+v.id+'">'+v.name+'</option>';
                    }
                });
                $('#states').html(html);
            }
        }
    });
});
$("#Country").trigger('change');
$( document ).ready(function() {

	$("#update-user").on('click',function(){
		$this = $(".reg_form");
		var is_valid = 0;
        var need_valid = 0;

		$(".tel_input").each(function() {

			let this_is_valid = true;

		    $(this).parents(".form-group").removeClass("has-error");
		    
		    $(this).parents(".form-group").find(".text-danger").remove();

		    if(window["tel_input"+$(this).attr('id')]){
		        var errorMap = ['<?= __('user.invalid_number') ?>','<?= __('user.invalid_country_code') ?>','<?= __('user.too_short') ?>','<?= __('user.too_long') ?>','<?= __('user.invalid_number') ?>'];
		        var errorInnerHTML = '';
		        
		        if ($(this).val().trim()) {
		        	need_valid++;
		            if (window["tel_input"+$(this).attr('id')].isValidNumber()) {

						window["tel_input"+$(this).attr('id')].setNumber($(this).val().trim());

		                is_valid++;
		                this_is_valid = true;
		            } else {
		                var errorCode = window["tel_input"+$(this).attr('id')].getValidationError();
		                errorInnerHTML = errorMap[errorCode];
		                this_is_valid = false;
		            }
		        } else {
		        	if($(this).attr('required') !== undefined) {
		        		need_valid++;
		                this_is_valid = false;
			        	errorInnerHTML = 'The Mobile Number field is required.'; 
			        }
		        }

		        if(!this_is_valid){
		            $(this).parents(".form-group").addClass("has-error");
		            $(this).parents(".form-group").find('> div').after("<span class='text-danger'>"+ errorInnerHTML +"</span>");
		        }
		    }
		});

	    if(is_valid == need_valid){
	        var formData = new FormData($this[0]);
	            
            $(".tel_input").each(function() {
		        if ($(this).val().trim() && window["tel_input"+$(this).attr('id')].isValidNumber()) {
		        	country_id = window["tel_input"+$(this).attr('id')].getSelectedCountryData().dialCode;
	                formData.append($(this).attr('name')+'_afftel_input_pre', country_id);
		        }
		    });

			$.ajax({
				url:'',
				type:'post',
				dataType:'json',
				cache:false,
				contentType: false,
				processData: false,
				data:formData,
				beforeSend:function(){ $(".add-transaction").btn("loading") },
				complete:function(){ $(".add-transaction").btn("reset") },
				success:function(json){
					if(json['location']){
						window.location = json['location'];
					}

					$this.find(".has-error").removeClass("has-error");
					$this.find("span.text-danger").remove();
					if(json['errors']){
					    $.each(json['errors'], function(i,j){
					        $ele = $this.find('[name="'+ i +'"]');
					        if($ele){
					            $ele.parents(".form-group").addClass("has-error");
					            $ele.after("<span class='text-danger'>"+ j +"</span>");
					        }
					    })
					}	
				}
			})
	    }
	})

});
$(".add-transaction").on('click',function(){
	$this = $("#add-transaction");
	
	$.ajax({
		url:'<?= base_url("admincontrol/add_transaction") ?>',
		type:'post',
		dataType:'json',
		data:$(".input-transaction"),
		beforeSend:function(){ $(".add-transaction").btn("loading") },
		complete:function(){ $(".add-transaction").btn("reset") },
		success:function(json){
			if(json['location']){
				window.location = json['location'];
			}

			$this.find(".has-error").removeClass("has-error");
			$this.find("span.text-danger").remove();

			if(json['errors']){
			    $.each(json['errors'], function(i,j){
			        $ele = $this.find('#'+ i);
			        if($ele.hasClass('form-group')){
			            $ele.addClass("has-error");
			            $ele.append("<br><span class='text-danger'>"+ j +"</span>");
			        } else {
			        	$ele.parents(".form-group").addClass("has-error");
			            $ele.after("<span class='text-danger'>"+ j +"</span>");
			        }
			    })
			}	
		}
	})
})
</script>