<?php
	$db =& get_instance();
	$userdetails=$db->userdetails();
	$store_setting =$db->Product_model->getSettings('store');
	$Product_model =$db->Product_model;
?>

<div id="overlay"></div>
<div class="popupbox" style="display: none;">
	<div class="backdrop box">
		<div class="modalpopup" style="display:block;">
			<a href="javascript:void(0)" class="close js-menu-close" onclick="closePopup();"><i class="fa fa-times"></i></a>
			<div class="modalpopup-dialog">
				<div class="modalpopup-content">
					<div class="modalpopup-body">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header bg-blue-payment">
					<div class="card-title-white pull-left m-0"><?= __('admin.tutorial') ?></div>
			</div>
			<div class="card-body">
				<div class="tab-pane p-3" id="store-setting orange-store-form" role="tabpanel">
				   <div role="tabpanel">
				      <ul class="nav nav-pills orange-color-bg" role="tablist" id="TabsNav">
				      	<li role="presentation" class="active nav-item">
				            <input class="btn-switch update_all_settings" type="checkbox" <?= $site['tutorial_module_status']==1 ? 'checked' : '' ?> data-toggle="toggle" data-size="normal" data-on="<?= __('admin.status_on') ?>" data-off="<?= __('admin.status_off') ?>" data-setting_key="tutorial_module_status" data-setting_type="site">
				         </li> 
				         <li role="presentation" class="active nav-item">
				            <a class="nav-link active show category_tab_option" href="#category_tab" aria-controls="category_tab" role="tab" data-toggle="tab"><?= __('admin.category') ?></a>
				         </li>
				         <li role="presentation" class="nav-item">
				            <a class="nav-link product-part tutorial_tab_option" href="#tutorial_tab_option" aria-controls="tutorial_tab_option" role="tab" data-toggle="tab"><?= __('admin.pages') ?></a>
				         </li>
				      </ul>
				   </div>
				</div>   

				<div class="tab-content">
               <div role="tabpanel" class="tab-pane active" id="category_tab">
               	<div class="filter">
							<form id="form2" name="form2">
								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
	                                <label class="control-label"><?= __('admin.select_language') ?></label>
	                                <select class="form-control" name="language_id2" id="drpLanguage2" onchange="return changeLanguage2();">
	                                    <?php 
	                                    if(isset($languages))
	                                    {
	                                        $language_id=1;
	                                        foreach($languages as $language)
	                                        {?>
	                                        <option <?php 

	                                        if(isset($userlangid) && $userlangid==$language['id'])
	                                        {echo 'selected';}	
	                                        //if($language['is_default']==1) {echo 'selected';} 
	                                    	?> value="<?=$language['id']?>"><?=$language['name'] ?></option>
	                                      
	                                       <?php  }     
	                                    }?>
	                                    
	                                </select>
                            	</div>
									</div>
									<div class="col-sm-1">
										 
									</div>
									<div class="col-sm-6">

									</div>	
									<div class="col-sm-3">
										<div class="form-group pull-right mb-2"> 
											 <a class="btn btn-primary" href="<?= base_url('admincontrol/manage_tutorial_catgory/')  ?>"><?= __('admin.add_new_category'); ?></a> 
										</div>
									</div>	
								</div>
							</form>
						</div>
				 
                	<div class="table-responsive" id="table-category">

                	</div> 

               </div>
               <div role="tabpanel" class="tab-pane" id="tutorial_tab_option">  	

						<div class="filter">
							<form id="form1" name="form1">
								<div class="row">
									<div class="col-sm-2">
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
	                                         if(isset($userlangid) && $userlangid==$language['id'])
	                                        {echo 'selected';}
	                                    
	                                        //if($language['is_default']==1) {echo 'selected';} 
	                                    	?> value="<?=$language['id']?>"><?=$language['name'] ?></option>
	                                      
	                                       <?php  }     
	                                    }?>
	                                    
	                                </select>
                            	</div>
									</div>
									<div class="col-sm-1">
										<div class="form-group">
											<label class="control-label d-block">&nbsp;</label>
										</div>
									</div>
									<div class="col-sm-6">

									</div>	
									<div class="col-sm-3">
										<div class="form-group pull-right mb-2"> 
											 <a class="btn btn-primary" href="<?= base_url('admincontrol/manage_tutorial/')  ?>"><?= __('admin.add_new_page'); ?></a> 
										</div>
									</div>	
								</div>
							</form>
						</div>
				 
                	<div class="table-responsive" id="table-tutorial">

                	</div> 
               </div> 	
            </div>   

			</div>
		</div>
	</div>
</div>
<script type="text/javascript" async="">
	function changeLanguage()
	{
		getTutorials('<?= base_url("admincontrol/listTutorals_ajax")?>');
		return false;
	}

	$("#table-tutorial .pagination-td").delegate("a","click",function(){
         getTutorials($(this).attr("href"));
         return false;
    })

    function getTutorials(url)
    {
      $this = $(this);
       $.ajax({
            url:url,
            type:'POST',
            dataType:'json',
            data:$("#form1").serialize(),
            beforeSend:function(){$this.btn("loading");},
            complete:function(){$this.btn("reset");},
            success:function(json){ 
               if(json['view']){
                  $("#table-tutorial").html(json['view']); 
               } else {
                 
               }
        
               $("#table-tutorial .pagination-td").html(json['pagination']);
            },
       });
    }
    $( document ).ready(function() {
       getTutorials('<?= base_url("admincontrol/listTutorals_ajax")?>');
    });
 
	 /*----*/

	function changeLanguage2()
	{
		getCategory('<?= base_url("admincontrol/listTutorialCategory_ajax")?>');
		return false;
	}

	$("#table-category .pagination-td").delegate("a","click",function(){
         getCategory($(this).attr("href"));
         return false;
    })

    function getCategory(url)
    {
      $this = $(this);
       $.ajax({
            url:url,
            type:'POST',
            dataType:'json',
            data:$("#form2").serialize(),
            beforeSend:function(){$this.btn("loading");},
            complete:function(){$this.btn("reset");},
            success:function(json){ 
               if(json['view']){
                  $("#table-category").html(json['view']); 
               } else {
                 
               }
               $("#table-category .pagination-td").html(json['pagination']);
            },
       });
    }
    $( document ).ready(function() {
       getCategory('<?= base_url("admincontrol/listTutorialCategory_ajax")?>');
    });

    $('.update_all_settings').on('change', function()
    {
        
        var checked = $(this).prop('checked');
        var setting_key = $(this).data('setting_key');
        var setting_type = $(this).data('setting_type');

        var controle_id=$(this).attr('id');
    
        if (checked == true) {
            var status = 1;
         }
        else
        {
            var status = 0; 
        } 

       $.ajax({
            url:'<?= base_url("admincontrol/update_all_settings") ?>',
            type:'POST',
            dataType:'json',
            data:{'action':'update_all_settings', status:status, setting_key:setting_key, setting_type:setting_type},
            success:function(json)
            {
 
            },
        }); 
    });

</script>			