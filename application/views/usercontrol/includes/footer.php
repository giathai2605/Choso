
</div>
</div>
<?php 
$db =& get_instance(); 
$userdetails =$db->Product_model->userdetails('user'); 
$SiteSetting =$db->Product_model->getSiteSetting();
$global_script_status = (array)json_decode($SiteSetting['global_script_status'],1);
if(in_array('affiliate', $global_script_status))
	echo $SiteSetting['global_script'];

$user_footer_color = $db->Product_model->getSettings('theme','user_footer_color');
?>			    		
<div class="dashboard-footer" style="background-color: <?= $user_footer_color['user_footer_color'] ?>;">
	<div class="d-flex align-items-center justify-content-between flex-wrap">
		<div class="footer-rights">
			<?php $logo = $SiteSetting['admin-side-logo'] ? base_url('assets/images/site/'. $SiteSetting['admin-side-logo'] ) : base_url('assets/template/images/user-footer-logo.png'); ?> 
			<img <?= ($SiteSetting['custom_logo_size']) ? 'class="customLogoClass"' : '' ?> src="<?= $logo ?>" alt="<?= __('user.logo') ?>"> 
		</div>
		<div class="text-right script-right"><?= $SiteSetting['footer'] ?></div>
	</div>
</div>
  <!-- flash message -->
  <div class="print-message"><?php print_message($this); ?></div>
  <script>
      window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 4000);
  </script>
  <!-- flash message -->
</div>

<div class="modal fade" id="ip-flag_model">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= __('user.all_api_details'); ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?= __('user.close'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-style" id="logsetting" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered dashboard-setting" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Create Slug</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
					<span aria-hidden="true">&times;</span> 
				</button>
			</div>
			<div class="modal-body">
				<div class="slug-wrapp">
					<h3>Slug</h3>
					<div class="link-area d-flex align-items-center">
						<input placeholder="my-store" type="text">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary">Create</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-style" id="slugtting" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered dashboard-setting" role="document">
		<div class="modal-content">
			<form action="<?= base_url('/usercontrol/create_slug') ?>" method="post">
				<div class="modal-header">
					<h5 class="modal-title"><?= __('user.create_slug'); ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
						<span aria-hidden="true">&times;</span> 
					</button>
				</div>
				<div class="modal-body">
					<div class="slug-wrapp">
						<h3><?= __('user.slug'); ?></h3>
						<div class="link-area d-flex align-items-center">
							<input type="text" name="slug" placeholder="<?= __('user.enter_slug_here') ?>" >
							<input type="hidden" name="type" />
							<input type="hidden" name="related_id" />
							<input type="hidden" name="target" />
						</div>
						<div class="link-area align-items-center slug-url">
							<input type="text" readonly="readonly">
							<a href="javascript:void(0)" copytoclipboard="">
								<img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('user.copy') ?>">
							</a> 
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-secondary"><?= __('user.create'); ?></button>
					<button type="button" class="btn btn-primary" data-dismiss="modal"><?= __('user.close'); ?></button>
					<button type="button" class="btn btn-primary btn-delete-slug"><?= __('user.delete'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<script src="<?= base_url('assets/js/jquery-confirm.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/modernizr.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/detect.js'); ?>"></script>
<script src="<?= base_url('assets/js/fastclick.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.slimscroll.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.blockUI.js'); ?>"></script>
<script src="<?= base_url('assets/js/waves.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.nicescroll.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.scrollTo.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/skycons/skycons.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/raphael/raphael-min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/morris/morris.min.js'); ?>"></script>

<script src="<?= base_url('assets/template/js/app.js'); ?>"></script> 

<script src="<?= base_url('assets/js/jssocials-1.4.0/jssocials.min.js'); ?>"></script>
<link href="<?= base_url('assets/js/jssocials-1.4.0/jssocials.css'); ?>" type="text/css" rel="stylesheet"/>
<link href="<?= base_url('assets/js/jssocials-1.4.0/jssocials-theme-flat.css'); ?>" type="text/css" rel="stylesheet"/>


<!--summNote files-->
<script src="<?= base_url('assets/template/summernote/summernote-bs4.js'); ?>"></script>
<!--summNote files-->



<!--script files for the switch button-->
<script type="text/javascript" src='<?= base_url('assets/js/bootstrap4-toggle.min.js') ?>'></script>
<!--script files for the switch button-->

<!--Remember last tab script-->
  <script>
    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#TabsNav a[href="' + activeTab + '"]').tab('show');
        }
    });
  </script>
  <!--Remember last tab script-->


<script type="text/javascript">
	$(document).delegate('[name="slug"]','keyup',function(){
		var slug = $(this).val();
		var base_url = "<?= base_url() ?>";
		$('#slugtting form').find('.slug-url input').val(base_url+slug);
	});

	$(document).delegate('.btn-model-slug,.dashboard-model-slug', 'click', function(){
		$form = $('#slugtting form');
		$form[0].reset();
		$form.find(".alert").remove();
		$form.find(".has-error").removeClass("has-error");
		$form.find("span.text-danger").remove();

		var type = $(this).attr('data-type');
		var related_id = $(this).attr('data-related-id');
		var target = $(this).attr('data-input-class');

		$this = $(this);
		$.ajax({
			url:"<?php echo base_url('usercontrol/get_slug') ?>",
			type:'POST',
			dataType:'json',
			data:{
				type: type,
				related_id: related_id
			},
			success:function(json){
				$form.find('.slug-url').hide();
				$form.find('.btn-delete-slug').hide();

				if(json['success']){
					$form.find('.slug-url a').attr('copytoclipboard',json.slug_url);
					$form.find('.slug-url input').val(json.slug_url);
					$form.find('.slug-url').show();
					$form.find('.btn-delete-slug').show();
					$('#slugtting').find('[name="slug"]').val(json['slug']);
				}

				$('#slugtting').find('[name="type"]').val(type);
				$('#slugtting').find('[name="related_id"]').val(related_id);
				$('#slugtting').find('[name="target"]').val(target);
				$('#slugtting').modal({'keyboard':false, 'backdrop': 'static'});
			},
		})
	});
	$('#slugtting').delegate('form', 'submit', function(e){
		e.preventDefault();

		$this = $(this);
		$target = $this.find('[name="target"]').val();

		$.ajax({
			url:$this.attr('action'),
			type:'POST',
			dataType:'json',
			data:$this.serialize(),
			success:function(json){
				$container = $this;
				$container.find(".has-error").removeClass("has-error");
				$container.find("span.text-danger").remove();
				$container.find(".alert").remove();

				if(json['errors']){
					$.each(json['errors'], function(i,j){
						$ele = $container.find('[name="'+ i +'"]');
						if($ele){
							$ele.parents(".form-group").addClass("has-error");
							$ele.after("<span class='text-danger'>"+ j +"</span>");
						}
					})
					$this.find('.slug-url').hide();
				}

				if(json['error']){
					$this.find('.modal-body').prepend('<div class="alert bg-danger text-white">'+json['error']+'</div>');
				}

				if(json['success']){
					$.each($('.'+$target), function(k,v){
						if($(v).attr('data-addition-url')){
							var addition_url = $(v).attr('data-addition-url');
							$(v).val(json.slug_url + addition_url);
							$(v).next('[copyToClipboard]').attr('copyToClipboard', json.slug_url + addition_url);
						}else{
							$(v).val(json.slug_url);
							$(v).next('[copyToClipboard]').attr('copyToClipboard', json.slug_url);
						}
					});

					$this.find('.slug-url').show();
					$this.find('.slug-url a').attr('copytoclipboard',json.slug_url);
					$this.find('.slug-url input').val(json.slug_url);
					$this.find('.modal-body').prepend('<div class="alert alert-success">'+json['success']+'</div>');
				}
			},
		})
	});

	$('#slugtting').delegate('.btn-delete-slug', 'click', function(){
		if(!confirm('<?= __('user.are_you_sure') ?>')) return false;

		$this = $('#slugtting form');
		$this_btn = $(this);
		$target = $this.find('[name="target"]').val();

		$.ajax({
			url: '<?php echo base_url('/usercontrol/delete_slug') ?>',
			type:'POST',
			dataType:'json',
			data:$this.serialize(),
			success:function(json){
				$container = $this;
				$container.find(".alert").remove();

				if(json['error']){
					$this.find('.modal-body').prepend('<div class="alert alert-danger">'+json['error']+'</div>');
				}

				if(json['success']){
					$.each($('.'+$target), function(k,v){
						if($(v).attr('data-addition-url')){
							var addition_url = $(v).attr('data-addition-url');
							$(v).val(json.url + addition_url);
							$(v).next('[copyToClipboard]').attr('copyToClipboard', json.url + addition_url);
						}else{
							$(v).val(json.url);
							$(v).next('[copyToClipboard]').attr('copyToClipboard', json.url);
						}
					});

					$this.find('.slug-url').hide();
					$this.find('.slug-url input').val(json.url);
					$this.find('[name="slug"]').val('');
					$this_btn.hide();
					$this.find('.modal-body').prepend('<div class="alert alert-success">'+json['success']+'</div>');
					setTimeout(function(){
						$('#slugtting').modal('hide');
					}, 2000);
				}
			},
		})
	});
</script>

<script type="text/javascript">
	let leftHeight = $(".left-menu").height();
	let navbarHeight = $(".dashboard-navbar").height();
	let errorHeight = $(".server-errors").height();
	let footerHeight = $(".dashboard-footer").height();
	let elTotalheight = navbarHeight + errorHeight + footerHeight;
	let contentHeight = leftHeight - elTotalheight + 146;
	$(".content-wrapper").css('min-height',contentHeight);

	$(".select2-input").select2();

	$(document).delegate(".only-number-allow","keypress",function (e) {
		if (e.which != 46 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	function readURL(input,placeholder) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$(placeholder).attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	function sumNote(element){

		var height = $(element).attr("data-height") ? $(element).attr("data-height") : 500;
		$(element).summernote({
			disableDragAndDrop: true,
			height: height,
			toolbar: [
			['style', ['style']],
			['font', ['bold', 'underline', 'clear']],
			['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['table', ['table']],
			['insert', ['link', 'image', 'video']],
			['view', ['fullscreen', 'codeview', 'help']]
			],
			buttons: {
				image: function() {
					var ui = $.summernote.ui;
                    // create button
                    var button = ui.button({
                    	contents: '<i class="fa fa-image" />',
                    	tooltip: false,
                    	click: function () {
                    		$('#modal-image').remove();

                    		$.ajax({
                    			url: '<?= base_url("filemanager") ?>',
                    			dataType: 'html',
                    			beforeSend: function() {
                    			},complete: function() {
                    			},success: function(html) {
                    				$('body').append('<div id="modal-image" class="modal fade">' + html + '</div>');
                    				$('#modal-image').modal('show');
                    				$('#modal-image').delegate('.image-box .thumbnail','click', function(e) {
                    					e.preventDefault();
                    					$(element).summernote('insertImage', $(this).attr('href'));
                    					$('#modal-image').modal('hide');
                    				});
                    			}
                    		});                     
                    	}
                    });

                    return button.render();
                }
            }
        });
	}
	
	$(document).delegate(".view-all",'click',function(){
		var data = $(this).find("span").html();
		var html = '<table class="table table-hover">';
		data = JSON.parse(data);
		html += '<tr>';
		html += '	<th>IP</th>';
		html += '	<th width="30px">Country</th>';
		html += '</tr>';

		$.each(data, function(i,j){
			html += '<tr>';
			html += '	<td>'+ j['ip'] +'</td>';
			html += '	<td><img style="width: 20px;" src="<?= base_url('assets/vertical/assets/images/flags/') ?>'+ j['country_code'].toLowerCase() +'.png" ></td>';
			html += '</tr>';
		})
		html += '</table>';

		$("#ip-flag_model").modal("show");
		$("#ip-flag_model .modal-body").html(html);
	})
	$(document).delegate(".copy-input input",'click', function(){
		$(this).select();
	})
	$(document).delegate('[copyToClipboard]',"click", function(){
		$this = $(this);
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(this).attr('copyToClipboard')).select();
		document.execCommand("copy");
		$temp.remove();
		$this.tooltip('hide').attr('data-original-title','<?= __('user.copied') ?>').tooltip('show');
		setTimeout(function() { $this.tooltip('hide'); }, 500);
	});
	$('[copyToClipboard]').tooltip({
		trigger: 'click',
		placement: 'bottom'
	});
	/* BEGIN SVG WEATHER ICON */
	if (typeof Skycons !== 'undefined'){
		var icons = new Skycons(
			{"color": "#fff"},
			{"resizeClear": true}
			),
		list  = [
		"clear-day", "clear-night", "partly-cloudy-day",
		"partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
		"fog"
		],
		i;
		
		for(i = list.length; i--; )
			icons.set(list[i], list[i]);
		icons.play();
	};
	
	// scroll
	$( document ).ready(function() {
		if($("#boxscroll").length > 0){
			$("#boxscroll").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true});
		}
		if($("#boxscroll2").length > 0){
			$("#boxscroll2").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true}); 
		}
	});
	
	function shownofication(id,url){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>usercontrol/updatenotify",
			data:{'id':id},
			dataType:'json',
			success: function(data){
				window.location.href=data['location'];
			}
		});
	}
</script>
<?php 
$usercontrol = true;
require APPPATH . 'views/common/setting_widzard.php'; 
?>
<script>
	function start_plan_expiration_timer() {
		if($('span[data-time-remains]').length) {
			let countdown = $('span[data-time-remains]').data('time-remains');
			if(countdown > 0) {
				 
				var d = new Date();
				d.setTime(countdown);
				Window.GlobaleCountDownDate = d;

				var GlobaleCountDownDateInterval = setInterval(function() {
				 
					var distance = Window.GlobaleCountDownDate--;

					var days        = Math.floor(distance/24/60/60);
					var hoursLeft   = Math.floor((distance) - (days*86400));
					var hours       = Math.floor(hoursLeft/3600);
					var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
					var minutes     = Math.floor(minutesLeft/60);
					var remainingSeconds = distance % 60;

					let string = "";
 

					string += (days > 0) ? (''+days)+" days " : ""; 

					string += (hours > 0) ? ('0'+hours).slice(-2)+" Hours " : ""; 

					string += (minutes > 0) ? ('0'+minutes).slice(-2)+" Minutes " : ""; 

					string += (remainingSeconds > 0) ? ('0'+remainingSeconds).slice(-2)+" Seconds " : "00 Seconds"; 

					$('span[data-time-remains]').text(string);
					if (distance <= 0) {
						$('span[data-time-remains]').text('Plan Has Expired');
						window.location.reload();
						clearInterval(GlobaleCountDownDateInterval);
					}
				}, 1000);
			}
		}	
	}

	// scroll sidebar as active link to center
	$(function() {
		if($('.left-menu ul>li>.dropdown-menu a.active').length !=0){	
			let activeMenuItem = $('.left-menu ul>li>.dropdown-menu a.active');
			$('.left-menu div.collapse.d-block').animate({
				scrollTop: activeMenuItem.offset().top - ($('.left-menu div.collapse.d-block').height() / 1.8)
			}, 700);
		}
	});
</script>
</body>
</html>