<?php
	$db 								 =& get_instance(); 
	$products 					 = $db->Product_model; 
	$userdetails         = $products->userdetails('user');
	$SiteSetting 				 = $db->Product_model->getSiteSetting();
	$notifications       = $products->getnotificationnew('user',$userdetails['id'],5);
	$notifications_count = $products->getnotificationnew_count('user',$userdetails['id']);
	$paymentlist         = $products->getPaymentWarning();
	$LanguageHtml        = $products->getLanguageHtml('usercontrol');
	$CurrencyHtml        = $products->getCurrencyHtml('usercontrol');

	$PrimaryPaymentMethodStatus = $products->getUserPaymentMethodStatus($userdetails['id'],$userdetails['primary_payment_method']);

	$loginUser = $_SESSION['user'];
	if(isset($loginUser['is_vendor']) && $loginUser['is_vendor'] == 1) {
   	  $marketVendorStatus= $db->Product_model->getSettings('market_vendor', 'marketvendorstatus');
      $vendoerMinDeposit = $db->Product_model->getSettings('site', 'vendor_min_deposit');
      $userdepbal['vendor_min_deposit'] = isset($vendoerMinDeposit['vendor_min_deposit']) ? $vendoerMinDeposit['vendor_min_deposit'] : 0;

      $db->load->model('Total_model');
      $depbalence = $db->Total_model->getUserBalance($loginUser['id']);

      $userdepbal['show_deposit_warning'] = ($depbalence < $userdepbal['vendor_min_deposit']) ? 1 : 0;
      $userdepbal['vendor_min_deposit_warning'] = __('user.minimum_deposit_warning');

      $vendorDepositStatus = $this->Product_model->getSettings('vendor', 'depositstatus');
      $userdepbal['vendor_deposit_status'] = isset($vendorDepositStatus['depositstatus']) ? $vendorDepositStatus['depositstatus'] : 0;
   }

  $membership = $this->Product_model->getSettings('membership', 'status');
	$award_level = $this->Product_model->getSettings('award_level', 'status');
	$userPlan = App\MembershipUser::select('membership_plans.commission_sale_status','award_level.level_number','award_level.sale_comission_rate')->join('membership_plans','membership_plans.id','=','membership_user.plan_id')->join('award_level','award_level.id','=','membership_plans.level_id','left')->where('is_active',1)->where('user_id',$userdetails['id'])->first();
	$levels = $this->Product_model->getAll('award_level',false,0,'id desc');

	require APPPATH."config/breadcrumb.php";
    $pageKey = $db->Product_model->page_id();

    $site_setting_timeout = $this->Product_model->getSettings('site', 'user_session_timeout');
  	$timeout = (isset($site_setting_timeout['user_session_timeout']) && is_numeric($site_setting_timeout['user_session_timeout'])) ? $site_setting_timeout['user_session_timeout'] : 1800;

  	$user_side_bar_color = $products->getSettings('theme','user_side_bar_color');
  	$user_side_bar_text_color = $products->getSettings('theme','user_side_bar_text_color');
  	$user_side_bar_text_hover_color = $products->getSettings('theme','user_side_bar_text_hover_color');
  	$user_top_bar_color = $products->getSettings('theme','user_top_bar_color');
  	$user_side_bar_clock_text_color = $products->getSettings('theme','user_side_bar_clock_text_color');
?>
<style type="text/css">
	.left-menu ul > li > .dropdown-menu a.theme-color {
	  color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;
	}

	.left-menu ul > li > .dropdown-menu a.active {
	  background-color: unset;
	  color: <?= $user_side_bar_text_hover_color['user_side_bar_text_hover_color'] ?>;
	}

	.left-menu ul > li > .show {
		/*background-color: <?= $user_side_bar_text_hover_color['user_side_bar_text_hover_color'] ?>;*/
	}
 	.left-menu ul > li > .dropdown-menu a:hover {
 		color: <?= $user_side_bar_text_hover_color['user_side_bar_text_hover_color'] ?>;
 	}
 	.left-menu ul > li.show > a:before {
 		background: <?= $user_side_bar_text_hover_color['user_side_bar_text_hover_color'] ?>;
 		width: 383px;
 		content: "";
 	}
</style>
<div class="dashboard-wrap">
    <div class="dashboard-main-right">
    	<div class="dashboard-navbar">
    		<div class="header-top d-flex justify-content-end align-items-center" style="background-color: <?= $user_top_bar_color['user_top_bar_color'] ?>;">
	        	<div class="logo" style="background-color: <?= $user_side_bar_color['user_side_bar_color'] ?>;"> 
	        		<a href="<?= base_url('usercontrol/dashboard') ?>">
	        			<?php $logo = $SiteSetting['admin-side-logo'] ? base_url('assets/images/site/'. $SiteSetting['admin-side-logo'] ) : base_url('assets/template/images/user-logo.png'); ?>
	        			<img <?= ($SiteSetting['custom_logo_size']) ? 'class="customLogoClass"' : '' ?> src="<?= $logo ?>" alt="<?= __('user.logo') ?>"/>
	        		</a>
	          		<div class="logo-line"></div>
	        	</div>
	        	<div class="header-right">
	          		<ul class="d-flex align-items-center justify-content-between" style="background-color: <?= $user_top_bar_color['user_top_bar_color'] ?>;">
	            		<li id="user-currency-top-menu" class="nav-item dropdown user-currency border-0"><?= $CurrencyHtml ?></li>
	            		<li class="nav-item dropdown arrow-position"><?= $LanguageHtml ?></li>
	            		<li class="nav-item dropdown notification-area arrow-position"> 
	            			<a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	            				<span class="bell"></span>
	            				<img src="<?= base_url('assets/template/images/notification-icon.png') ?>" alt=""/>
	            				<span class="notifications-count"><?= $notifications_count > 99 ? "99+": $notifications_count; ?></span>
	            			</a> 
	              			<div class="dropdown-menu dropdown-menu-right shadow user-setting"> 
	              				<i class="arrow"></i>
	                			<div class="heading-notification d-flex justify-content-between align-items-center">
	                  				<h4><?= __('user.notification') ?></h4>
	                  				<strong><?= $notifications_count > 99 ? "99+": $notifications_count; ?></strong> 
	                  			</div>
	                  			<div id="allnotification">
	                  				<?php foreach ($notifications as $key => $notification) { ?>
			            				<a class="dropdown-item" href="javascript:void(0)" onclick="shownofication(<?= $notification['notification_id'].',\''.base_url('usercontrol').$notification['notification_url'] . '\''; ?>)" > 
			            					<?= $notification['notification_title']; ?>
			            					<em><?= $notification['notification_description']; ?></em> 
			            				</a>
			            			<?php } ?>	
	            				</div>
	            				<div class="text-center"> 
	            					<a class="dropdown-item view-area" href="<?= base_url('usercontrol/notification') ?>"><?= __('user.view_all') ?></a> 
	            				</div>
	              			</div>
	           			</li>
	            		<li class="nav-item dropdown user-right border-0"> 
	            			<a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	            				<?php $image = !empty($userdetails['avatar']) ? base_url('assets/images/users/'. $userdetails['avatar']) : base_url('assets/vertical/assets/images/users/avatar-1.jpg') ?>
	            				<img class="profile-image" src="<?= $image ?>" alt=""/>
	            			</a> 
	              			<div class="dropdown-menu dropdown-menu-right shadow user-setting"> 
	              				<i class="arrow"></i> 
	              				<a class="dropdown-item" href="<?= base_url('usercontrol/editProfile'); ?>"><?= __('user.profile') ?></a> 
	              				<a class="dropdown-item" href="<?= base_url('usercontrol/logout'); ?>"><?= __('user.logout') ?></a> 
	              			</div>
	            		</li>
	          		</ul>
	          		<?php if(isset($pageSetting[$pageKey])){ ?>
		          		<ol class="breadcrumb hide-breadcrumb" style="background-color: <?= $user_top_bar_color['user_top_bar_color'] ?>;">
				            <?php 
				           
				             if(count($pageSetting)>0 && isset($pageSetting[$pageKey]) && in_array("breadcrumb", $pageSetting[$pageKey]) )
				            $count = count($pageSetting[$pageKey]['breadcrumb']);
				            else 
				            $count=0; 

		                    foreach ($pageSetting[$pageKey]['breadcrumb'] as $key => $value) { ?>
				                <li class="breadcrumb-item <?= $count == $key ? 'active' : '' ?>">
				                  <a href="<?= $value['link'] ?>"><?= $value['title'] ?></a>
				                </li>
				            <?php } ?>
			          	</ol>
			        <?php } ?>
	        	</div>
	        	<a href="javascript:void(0)" class="menu-button"> 
	        		<span></span> 
	        		<span></span> 
	        		<span></span> 
	        	</a> 
        	</div>
	      	<div class="header-left">
	        	<div class="header-heading d-flex justify-content-between align-items-center">
	          		<h1 style="color: <?= $user_side_bar_text_color['user_side_bar_text_color'] ?>;">
	          			<?= ($setting['top_left_text']) ? $setting['top_left_text'] : ($loginUser['is_vendor']== 1 ? __('user.page_title_my_vendor_panel') : __('user.affiliate_panel'))  ?>

	          			<p class="welcome-message">
	          				<?= __('user.welcome_user') ?><strong><?= $loginUser['username'] ?></strong>
	          			</p>
	          			<p class="session-counter" style="color: <?= $user_side_bar_clock_text_color['user_side_bar_clock_text_color'] ?>;">00:00:00</p>
	          			<p class="user-level-info" style="color: <?= $user_side_bar_clock_text_color['user_side_bar_clock_text_color'] ?>;">
	          				<?php
	          					$user_level;
	          					$user_sale_comission_value;

	          					if($award_level['status']){
		          					if($membership['status'] && $userPlan->commission_sale_status){
		          						if($userPlan->level_number){
		          							$user_level = $userPlan->level_number;
		          							$user_sale_comission_value = '['.$userPlan->sale_comission_rate.'%]';
		          						} else {
		          							$user_level = __('admin.default');
		          						}
		          					} else if($userdetails['level_id']){
		          						foreach ($levels as $key => $value){
		          							if($userdetails['level_id'] == $value['id']){
		          								$user_level = $value['level_number'];
		          								$user_sale_comission_value = '['.$value['sale_comission_rate'].'%]';
		          							}
		          						}
		          					} else {
		          						$user_level = __('admin.default');
		          					}
		          				} else {
		          					$user_level = __('admin.default');
		          				}

		          				echo  $user_level.' '.$user_sale_comission_value;
		          			?>
	          			</p>
	          		</h1>
	          		<div>
	          			<a href="javaScript:location.reload(true);">
	          				<img src="<?= base_url('assets/template/images/refresh-icon.png') ?>" alt="<?= ('admin.refresh_page') ?>">
	          			</a>
	          			<?php if(isset($pageSetting[$pageKey])){ ?>
	          				<span><?= $pageSetting[$pageKey]['title'] ?></span>
	          			<?php } ?>		
	          		</div>
	        	</div>
	      	</div>
    	</div>

    	<div class="container-fluid pt-4 pb-2">
    		<?php if($marketVendorStatus['marketvendorstatus'] == 1){
                if(isset($userdepbal['show_deposit_warning']) && 
                	$userdepbal['show_deposit_warning'] == 1 && 
                $userdepbal['vendor_deposit_status'] == 1 && 
                $userdetails['reg_approved'] == 1){ ?>

          <h4 class="notification_on_pages">
						<span class="badge badge-info">
							<?= $userdepbal['vendor_min_deposit_warning'] ?> <?= c_format($userdepbal['vendor_min_deposit']);?>
							<a href="<?= base_url('usercontrol/my_deposits') ?>">
								<?= __('admin.click_to_deposit') ?>
							</a>
						</span>
					</h4>
              <?php }
            } ?>
 
          <?php
            if(isset($payment_methods) && isset($payment_methods['bank_transfer']['status']) && isset($payment_methods['paypal']['status']) && ($payment_methods['bank_transfer']['status']==1 || $payment_methods['paypal']['status']==1))
           	{
             if($PrimaryPaymentMethodStatus==0 && $userdetails['reg_approved'] == 1) { ?>
							<h4 class="notification_on_pages">
								<span class="badge badge-info"><?=__('user.payment_details_not_set_message');?>
								<a href="<?= base_url('usercontrol/payment_details') ?>"><?=__('user.click_here');?></a>
								</span>
							</h4>	
			 		<?php }
				} ?>
		</div>


 
        <script>
			function sessionTimeout(){
				var dt = new Date();
				let distance = (GlobaleCountDownDate - dt.getTime()) / 1000;

				let h = Math.floor(distance / 3600);
				let m = Math.floor(distance % 3600 / 60);
				let s = Math.floor(distance % 3600 % 60);

				let string = "";

				string += (h > 0) ? ('0'+h).slice(-2)+":" : "00:"; 

				string += (m > 0) ? ('0'+m).slice(-2)+":" : "00:"; 

				string += (s > 0) ? ('0'+s).slice(-2)+"" : "00"; 

				$(".session-counter").text(string);

				if (distance <= 0){
				  window.location.replace('<?= base_url('usercontrol/logout'); ?>');
				  clearInterval(GlobaleCountDownDateInterval);
				}
			}

	      	var dt = new Date();
	      	var GlobaleCountDownDate = dt.setTime(dt.getTime() + (<?= $timeout ?> * 1000));

	      	sessionTimeout();
	      	var GlobaleCountDownDateInterval = setInterval(sessionTimeout,100);

	      	$(document).ajaxComplete(function(event, request, settings) {
	         	let parts = settings.url.split("/");
	         	let last_part = parts[parts.length-1];
	         	if(last_part != "ajax_dashboard"){
	          		var dt = new Date();
	          		var GlobaleCountDownDate = dt.setTime(dt.getTime() + (<?= $timeout ?> * 1000));
	         	}
	      	});
	    </script>   
    	<div class="content-wrapper">

      	