<div class="row">
	<div class="col-12">
		<div class="card m-b-30">
		    <div class="card-body">
				<form accept="" action="" method="GET" id='search-form'>
					<div class="row">
						<div class="col-sm-3">
							<div class="input-group mb-3">
								<!-- <label for="countries"><?= __('admin.select_country_filter') ?></label> -->
								<select class="custom-select custom-select-lg mb-3" name="country_id">
									<option value=""><?= __('admin.---select_country---') ?></option>
									<?php foreach ($country_list as $key => $value) { ?>
										<option value="<?= $value->id ?>" 
											<?= (isset($_GET['country_id']) && $_GET['country_id'] == $value->id) ? 'selected' : '' ?> 
										><?= $value->name ?> ( <?= $value->sortname ?> )</option>
									<?php } ?>
								</select>
							</div>
						</div>
						 <div class="col-sm-3">
						 	<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text">#</span>
							  </div>
							  <input type="text" class="form-control" name="name" placeholder="<?= __('admin.serch_by_firstname_or_lastname') ?>">
							</div>
						</div>

						<div class="col-sm-3">
						 	<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <span class="input-group-text">@</span>
							  </div>
							  <input type="text" class="form-control" name="email" placeholder="<?= __('admin.search_by_email') ?>">
							</div>
						</div>

						<div class="col-sm-3">
							<div class="input-group mb-3">
								<label class="control-label d-block">&nbsp;</label>
								<button type="button" class="btn btn-primary" onclick="getPage(1,this)"><?= __('admin.search') ?></button>
								<button type="button" class="btn btn-primary email-to"> <?= __('admin.send_mail') ?> </button>
						</div>
						</div>
					</div>
				</form>

				<div class="selection-message d-none">
					<?= __('admin.all') ?> <span class="selected-count"></span> <?= __('admin.users_on_this_page_are_selected') ?> <a href="javascript:void(0)" class="select-all-users"><?= __('admin.select_all') ?> <span class="total-user"></span> <?= __('admin.users') ?> </a> <a href="javascript:void(0)" class="clear-selection"><?= __('admin.clear_selection') ?></a>
				</div>

				<div class="message-box"></div>

                <div class="dimmer">
                	<div class="loader"></div>
                	<div class="dimmer-content">
						<div class="table-responsive b-0">
							<table class="table table-striped user-table">
								<thead>
									<tr>
										<th><input class="select-all" type="checkbox"></th>
										<th><?= __('admin.first_name') ?></th>
										<th><?= __('admin.last_name') ?></th>
										<th><?= __('admin.country') ?></th>
                                        <th><?= __('admin.email') ?></th>
										<th><?= __('admin.username') ?></th>
										<?php foreach ($data as $key => $value) { if($value['type'] == 'header') continue; ?>
											<th><?= $value['label'] ?></th>
										<?php } ?>
									</tr>  
								</thead> 
								<tbody></tbody>
								<tfoot>
									<tr>
										<td colspan="100%" class="text-right">
											<div class="pagination">
												<?= $pagination ?>
											</div>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
                	</div>
                </div>

			</div>
		</div> 
	</div>
</div>

<div id="affiliateMailModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= __('admin.send_mail') ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="mail-form" method="post" enctype="multipart/form-data">
	      <div class="modal-body">
	        	<div class="form-group">
	        		<label class="control-label"><?= __('admin.to') ?> (<span class="selected-count"></span> <?= __('admin.users_selected') ?>) </label>
	        		<input type="text" name="to" readonly="" class="form-control">
	        	</div>
	        	<div class="form-group">
	        		<label class="control-label"><?= __('admin.subject') ?></label>
	        		<input type="subject" name="subject" class="form-control">
	        	</div>

	        	<div class="form-group">
	        		<label class="control-label"><?= __('admin.message') ?></label>
	        		<textarea name="message" class="form-control summernote"></textarea>
	        	</div>
	        	<div class="form-group">
							<label><?= __('admin.attachment') ?> (*<?= __('admin.optional') ?>):</label>
							<input type="file" id="attachment" name="attachment" />
						</div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary send-affiliate-email" value="<?= __('admin.send') ?>" /><?= __('admin.send') ?></button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('admin.close') ?></button>
	      </div>

	        </form> 
    </div>
  </div>
</div>


<script type="text/javascript" async="">
	var selected = {};
	var all_emails = [];
	$('.clear-selection').on('click',function(){
		selected = {};
		$(".selection-message").addClass('d-none');
		$(".select-all").prop("checked",  false);
		changeViews();
	});

	function changeViews() {
		$(".select-single").prop("checked",  false);

		if(Object.keys(selected).length == 0){
			$(".selection-message").addClass('d-none');
		} else {
			$(".selection-message").removeClass('d-none');
			$(".selected-count").text(Object.keys(selected).length);
		}

		$(".select-all-users").show();
		if(Object.keys(selected).length == all_emails.length){
			$(".select-all-users").hide();
		}

		$.each(selected, function(i,j){
			$('.select-single[value="'+ j +'"]').prop("checked",true);
		})
	}

	$('.select-all').on('change',function(){
		$(".select-single").prop("checked",  $(this).prop("checked"));

		$('.select-single').each(function(){
			var val = $(this).val();
			if($(this).prop("checked")){ selected[val]=val; } 
			else { delete selected[val]; }

		})
		changeViews();
	})

	$(".user-table").delegate(".select-single","change",function(){
		var status = $(this).prop("checked");

		if(!status) delete selected[$(this).val()]
		else selected[$(this).val()] = $(this).val();

		changeViews();
	})

	$(".select-all-users").on('click',function(){
		$this = $(this);
		$.ajax({
			type:'POST',
			dataType:'json',
			data:{action:'get_all_emails'},
			beforeSend:function(){ $this.btn("loading");},
			complete:function(){ $this.btn("reset"); },
			success:function(json){
				$.each(json['emails'],function(i,email){
					selected[email]= email;
				})
				$(".selected-count").text(Object.keys(selected).length);
				all_emails = json['emails'];
				changeViews();
			},
		})
	})

$("form").submit(function(evt){
      evt.preventDefault();
      var formData = new FormData($(this)[0]);
      var thisbtn=$(".send-affiliate-email");
      
      $.ajax({
          url: '<?php echo base_url("admincontrol/sendAffiliateEmail") ?>/',
          type: 'POST',
          data: formData,
          async: false,
          cache: false,
          contentType: false,
          enctype: 'multipart/form-data',
          processData: false,
          dataType:'json',
          beforeSend:function(){thisbtn.btn("loading");},
          complete:function(){thisbtn.btn("reset");},
					success:function(json)
					{
						thisbtn.btn("reset");
						console.log(json);
						if (json['success']) 
						{
							$(".message-box").html('<div class="alert alert-success">'+ json['success'] +'</div>');
							$("#affiliateMailModel").modal("hide");
						}

						$container = $("#affiliateMailModel");
						$container.find(".has-error").removeClass("has-error");
						$container.find("span.text-danger").remove();
						
						if(json['errors'])
						{
						
						    $.each(json['errors'], function(i,j)
						    {
						        $ele = $container.find('[name="'+ i +'"]');
						        if($ele)
						        {
						            $ele.parents(".form-group").addClass("has-error");
						            $ele.after("<span class='text-danger'>"+ j +"</span>");
						        }
						    });
						} 
					}
       });

       return false;

    });

	$(".email-to").on('click',function(){
		if($('.select-single:checked').length){
			$("#affiliateMailModel").modal("show");
			$("#affiliateMailModel input[name=to]").val( Object.keys(selected).join(",") );
			$("#affiliateMailModel input[name=subject]").val('');
			$('#affiliateMailModel .summernote').summernote('reset');
		} else {
			alert('<?= __('admin.select_at_least_one_user_to_send_mail') ?>');
		}
	});

	function getPage(page,t) {
		$this = $(t);
		$.ajax({
			url:'<?= base_url("admincontrol/userslistmail") ?>?per_page=' + page,
			type:'POST',
			dataType:'json',
			data:$("#search-form").serialize(),
			beforeSend:function(){$this.btn("loading");},
			complete:function(){$this.btn("reset");},
			success:function(json){
				$(".user-table tbody").html(json['html']);				
				$(".total-user").html(json['total']);				
				if(json['pagination']){
					$(".pagination").html(json['pagination'])
				}
				changeViews();
			},
		})
	}

	$(".pagination").delegate("a","click", function(e){
		e.preventDefault();
		getPage($(this).attr("data-ci-pagination-page"),$(this));
	})
	getPage(1)
</script>