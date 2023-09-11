<?php	
    $db =& get_instance();
    $userdetails=$db->Product_model->userdetails('user',1);
    $store_setting =$db->Product_model->getSettings('store');
    $SiteSetting =$db->Product_model->getSettings('site');
    $refer_status =$db->Product_model->my_refer_status($userdetails['id']);
    $db->Product_model->ping($userdetails['id']);
    $vendor_setting = $db->Product_model->getSettings('vendor');
    $market_vendor = $db->Product_model->getSettings('market_vendor');
    $membership = $db->Product_model->getSettings('membership');
    $user_side_bar_color = $db->Product_model->getSettings('theme','user_side_bar_color');
    $user_side_bar_text_color = $db->Product_model->getSettings('theme','user_side_bar_text_color');
    $marketvendorpanelmode = $market_vendor['marketvendorpanelmode'] ?? 0;
    $userdashboard_settings = getUserDashboardSettings();

    if (isset($this->session) && $this->session->userdata('userLang') !== FALSE)
	$language_id=$this->session->userdata('userLang');
    $tutorials=$db->Tutorial_model->getAllRecords($language_id); 
 
?>


<div class="left-menu" style="background-color: <?= $user_side_bar_color['user_side_bar_color'] ?>;">
    <div class="collapse d-block">
      	<ul class="navbar-nav scroll-wrap">

      		<li class="nav-item">
        		<a class="nav-link theme-color" href="<?= base_url('usercontrol/dashboard'); ?>" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
        			<i class="bi bi-house-door iconsize"></i>
          			<span><?= __('user.page_title_dashboard') ?></span>
          		</a>
          	</li>


        	<!-------User tutorial------->
				<?php 
			    if(isset($SiteSetting["tutorial_module_status"]) && $SiteSetting["tutorial_module_status"]==1) 
			    {
				    if(isset($tutorials) && is_array($tutorials) && count($tutorials)>0)
				    {
				    	?>
					     <!--Main Category-->
					     <li class="nav-item dropdown">
							  <a id="maintutorial" class="nav-link dropdown-toggle theme-color" href="#submenu1" data-toggle="collapse" data-target="#submenu1" aria-expanded="false" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
							  	<i class="bi bi-info-circle iconsize"></i>
							    <span><?= __('user.page_title_tutorial') ?></span>
							    <div><i class="lni lni-chevron-right"></i></div>
							  </a>
							  <ul class="navbar-nav collapse" id="submenu1" aria-expanded="false">
				      	<?php
						$tutorialCategoryId=0;
				    	$pageString="";
				    	$previousCateroyName="";

				    	foreach($tutorials as $tutorial )
				    	{ 
				    		if($tutorialCategoryId!=$tutorial['category_id'])
					    	{
					    		if($tutorialCategoryId!="" && $tutorialCategoryId!=0)
					    		{
					    			//first category pages
					    			$pageString='<div class="collapse" id="submenu1'.$tutorialCategoryId.'" aria-expanded="false">
									        <ul class="nav">'.$pageString.'</ul>
									      </div></li>';
					    				echo $pageString;
					    				$pageString="";
					    		}
					    	?>
			          		<!--sub-category-->
			          		<li class="nav-item py-2" data-menu="tutorialnav">
						      <a class="nav-link d-flex text-truncate" href="#submenu1<?=$tutorial['category_id']?>" data-toggle="collapse" data-target="#submenu1<?=$tutorial['category_id']?>" aria-expanded="false">
						      	<i class="bi bi-bookmark-plus-fill"></i>
						        <div class="item-name"><?=$tutorial['name'] ?></div>
						        <div><i class="lni lni-chevron-right"></i></div>
						      </a>
				    		<?php
				    		}
				    			//tutorial page
				    			$pageString.='<li class="dropdown-item" data-menu="tutorialnav">
									            <a class="nav-link d-flex dropdown-toggle theme-color" href="'. base_url('usercontrol/tutorial/'.$tutorial['id']).'" style="color: '. $user_side_bar_text_color['user_side_bar_text_color'] .'">
									              <i class="bi bi-info-circle mr-1"></i>'.$tutorial['title'].'</a>
									          </li>';
								//tutorial page

				    	 		$tutorialCategoryId=$tutorial['category_id'];	 
						}
						//other category pages
						if($pageString!="")
						echo '<div class="collapse" id="submenu1'.$tutorialCategoryId.'" aria-expanded="false">
								<ul class="nav">'.$pageString.'</ul>
							  </div></li>';
						//other category pages
						?>
						<!--sub-category-->
							</ul>
						</li>
						<?php	}
					}
				?>
        	<!-------User tutorial------->

        	<!-------Useful Links------->
	            <li class="nav-item dropdown">
			        		<a class="nav-link theme-color" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
			        			<i class="bi bi-person iconsize"></i>
			          			<span><?= __('user.useful_links') ?></span>
			          			<div><i class="lni lni-chevron-right"></i></div>
			          		</a>
		          		<div class="dropdown-menu">
					        <a class="dropdown-item" href="<?= base_url('usercontrol/wallet_requests_list'); ?>">
					         	<?= __('user.usercontrol_wallet_requests_list') ?>	
					         </a>
		          			<a class="dropdown-item" href="<?php echo base_url('ReportController/user_reports');?>">
		          				<?= __('user.page_title_user_reports') ?></a>
		          			<a class="dropdown-item" href="<?= base_url('usercontrol/editProfile'); ?>">
					         	<?= __('user.profile_details') ?>	
					         </a>
		          			<a class="dropdown-item" href="<?= base_url('usercontrol/payment_details');?>">
		          				<?= __('user.payment_details') ?></a>
		          			<a class="dropdown-item" href="<?= base_url('usercontrol/changePassword');?>">
		          				<?= __('user.page_title_changePassword') ?></a>

		          			<?php if(isShowUserControlParts($userdashboard_settings['tickets_page'])){ ?>	
		          			<a class="dropdown-item" href="<?= base_url('usercontrol/tickets');?>">
		          				<?= __('user.page_title_tickets') ?></a>
		          			<?php } ?>

		          			

		          		</div>
		        </li>
	        <!-------Useful Links------->

          	<!-------Admin Marketplace Links------->
          		<?php if($userdetails['is_vendor']==0 || ($userdetails['is_vendor']==1  && $market_vendor['marketvendorpanelmode'] ==0 )) { ?>
          	 	<li class="nav-item dropdown">
		         <a class="nav-link theme-color" href="<?= base_url('usercontrol/store_markettools'); ?>" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
		         	<i class="bi bi-box-arrow-up-right iconsize"></i>
		         	<?= __('user.page_title_my_links') ?>
		         </a>
		        </li>
		    	<?php } ?>
		    <!-------Admin Marketplace Links------->

		    <!-------User commission------->
          	  <li class="nav-item dropdown">
                    <a class="nav-link theme-color" href="<?php echo base_url('usercontrol/mywallet');?>" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
                    	<i class="bi bi-wallet iconsize"></i>
	        		    <?= __('user.page_title_my_wallet') ?>
		            </a>
		      </li>
            <!-------User commission------->

			<!-------User Network------->
			  <?php if($refer_status) { ?>
          	  <li class="nav-item dropdown">
                    <a class="nav-link theme-color" href="<?php echo base_url('usercontrol/my_network');?>" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
                    	<i class="bi bi-diagram-3 iconsize"></i>
	        		    <?= __('user.page_title_my_network') ?>
		            </a>
		      </li>
		      <?php } ?>
			 <!-------User Network------->

			 <!-------User Payments------->
          	  <li class="nav-item dropdown">
                    <a class="nav-link theme-color" href="<?php echo base_url('usercontrol/all_transaction');?>" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
                    	<i class="bi bi-credit-card iconsize"></i>
	        		    <?= __('user.page_title_all_trans_user') ?>
		            </a>
		      </li>
			 <!-------User Payments------->

	        <!-------User membership------->
		        <?php if(($membership['status'] == 1) || (($membership['status'] == 2) && ($userdetails['is_vendor'] == 1)) || (($membership['status'] == 3) && ($userdetails['is_vendor'] == 0))){ ?>
			        	<li class="nav-item dropdown">
			        		<a class="nav-link dropdown-toggle theme-color" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
			        			<i class="bi bi-credit-card-2-front iconsize"></i>
			          			<span><?= __('user.page_title_membership') ?></span>
			          			<div><i class="lni lni-chevron-right"></i></div>
			          		</a>
			          		<div class="dropdown-menu">
			          			<a class="dropdown-item" href="<?= base_url('usercontrol/purchase_plan');?>">
			          				<?= __('user.page_title_buy_membership') ?>
			          				</a>
			          			<a class="dropdown-item" href="<?= base_url('usercontrol/purchase_history');?>">
			          				<?= __('user.page_title_purchase_history') ?>
			          			</a>
			          		</div>
		    			</li>
			    <?php } ?>
			<!-------User membership------->


			<!-------vendor panel items start------->
			<?php if((isset($userdetails['is_vendor']) && $userdetails['is_vendor'])){ ?>
			<li class="nav-item mt-2">
              <a class="nav-link badge-default theme-color" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
                <i class="bi bi-speedometer iconsize"></i>
                <span><?= __('user.page_title_my_vendor_panel') ?></span>
                <div><i class="bi bi-info-square-fill iconsize"></i></div>
              </a>
            </li>
        	<?php }?>
            <!-------vendor panel items start------->


			<!-------vendor store menu------->
    	        <?php if((isset($userdetails['is_vendor']) && $userdetails['is_vendor']) && (int)$vendor_setting['storestatus'] == 1 && (int)$store_setting['status'] == 1){ ?>
		        <li class="nav-item dropdown">
	        		<a class="nav-link dropdown-toggle theme-color" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
	        			<i class="bi bi-shop iconsize"></i>
	          			<span><?= __('user.page_title_vendor_store') ?></span>
	          			<div><i class="lni lni-chevron-right"></i></div>
	          		</a>
		          		<div class="dropdown-menu">
		          			<a class="dropdown-item" href="<?php echo base_url('usercontrol/store_dashboard');?>">
	    		        	    <?= __('user.page_title_store_dashboard') ?>
	    		        	</a>
	    		        	<a class="dropdown-item" href="<?php echo base_url('usercontrol/store_products');?>">
	    		        	    <?= __('user.page_title_store_products') ?>
	    		        	</a>
	    		        	<a class="dropdown-item" href="<?php echo base_url('usercontrol/sales_products');?>">
	    		        	    <?= __('user.page_title_store_sales_products') ?>
	    		        	</a>
	    		        	<a class="dropdown-item" href="<?php echo base_url('usercontrol/store_coupon');?>">
	    		        	    <?= __('user.page_title_store_coupons') ?>
	    		        	</a>
	    		        	<a class="dropdown-item" href="<?php echo base_url('usercontrol/store_venodr_orders');?>">
	    		        	    <?= __('user.vendor_orders_small') ?>
	    		        	</a>
	    		        	<a class="dropdown-item" href="<?php echo base_url('usercontrol/listclients');?>">
	    		        	    <?= __('user.store_clients') ?>
	    		        	</a>
	    		        	<a class="dropdown-item" href="<?php echo base_url('usercontrol/store_setting');?>">
	    		        	    <?= __('user.page_title_store_setting') ?>
	    		        	</a>
		          		</div>
        			</li>
    	        <?php } ?>
       		<!-------vendor store menu------->


			<!-------vendor marketing menu------->
	            <?php if((isset($userdetails['is_vendor']) && $userdetails['is_vendor']) && ((int)$market_vendor['marketvendorstatus'] == 1 )) { ?>
		        <li class="nav-item dropdown">
	        		<a class="nav-link dropdown-toggle theme-color" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
	        			<i class="bi bi-gear iconsize"></i>
	          			<span><?= __('user.page_title_marketing') ?></span>
	          			<div><i class="lni lni-chevron-right"></i></div>
	          		</a>
	          
		            <div class="dropdown-menu">
			            <a class="dropdown-item" href="<?php echo base_url('usercontrol/programs');?>">
	          				<?= __('user.ven_programs') ?>
	          			</a>
						<a class="dropdown-item" href="<?php echo base_url('usercontrol/integration_tools');?>">
						    <?= __('user.page_title_campaigns') ?>
						</a>
						<a class="dropdown-item" href="<?php echo base_url('usercontrol/integration');?>">
					        <?= __('user.page_title_plugins') ?>
					    </a>
					    <a class="dropdown-item" href="<?php echo base_url('usercontrol/mlm_levels');?>">
		        		    <?= __('user.page_title_vendor_setting') ?>
			            </a>
			            <a class="dropdown-item" href="<?php echo base_url('usercontrol/external_vendor_orders');?>">
		        		    <?= __('user.page_title_my_orders') ?>
			            </a>

				    </div>
				</li>
	            <?php } ?>
	        <!-------vendor marketing menu------->


	    	<!-------Vendor deposits------->
	            <?php if((isset($userdetails['is_vendor']) && $userdetails['is_vendor']) == 1){ ?>
	          	  <li class="nav-item dropdown">
	                    <a class="nav-link theme-color" href="<?php echo base_url('usercontrol/my_deposits');?>" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
	                    	<i class="bi bi-wallet iconsize"></i>
		        		    <?= __('user.page_title_my_deposits') ?>
			            </a>
			      </li>
	            <?php } ?>
        	<!-------Vendor deposits------->


	        <!--User contact us page-->
	        <?php if(isShowUserControlParts($userdashboard_settings['contact_us_page'])){ ?>
	        <li class="nav-item dropdown">
        		<a class="nav-link theme-color" href="<?= base_url('usercontrol/contact-us'); ?>" style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
        			<i class="bi bi-envelope-at iconsize"></i>
        			<?= __('user.page_title_contact_admin') ?>
          		</a>
          	</li>
          	<?php } ?> 
          	<!--User contact us page-->

      	</ul>
    </div>
</div>