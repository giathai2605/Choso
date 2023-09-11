<?php
if(!file_exists(FCPATH."/install/version.php") || !defined('SCRIPT_VERSION') || !defined('CODECANYON_LICENCE') || SCRIPT_VERSION == "" || CODECANYON_LICENCE == "") { ?>

  <script type="text/javascript">
    $("#model-adminpassword").remove();
    $.ajax({
      url:'<?= base_url("installversion/confirm_password") ?>',
      type:'POST',
      dataType:'json',
      data:{for:"license"},
      success:function(json){
        if(json['html']){
          $("body").append(json['html']);
          $("#model-adminpassword").modal("show");
          $('#model-adminpassword').on('hidden.bs.modal', function (){
            $("#model-adminpassword").modal("show");
          });
        }
      }
    });

  </script>
<?php } ?>

<script type="text/javascript">
  function resetNotify(){
    $.ajax({
      url:'<?= base_url('admincontrol/resetnotify') ?>',
      type:'POST',
      dataType:'json',
      beforeSend:function(){},
      success:function(response){
        if(response.status == 1)
          $(".ajax-notifications_count").text(0);
      },
    })
  }
</script>

<?php
$db =& get_instance(); 
$products = $db->Product_model; 
$userdetails=$db->Product_model->userdetails(); 
$SiteSetting =$db->Product_model->getSiteSetting(); 
$license = $products->getLicese();

if(isset($license['is_lifetime']) && $license['is_lifetime'] == false){ ?>

  <div class="license-expire">
    <span><?= __('admin.your_license_expire_in') ?> <span class="timer"><?= $license['remianing_time'] ?></span> </span>
  </div>

  <script type="text/javascript">
    var distance = <?= (float)$license['remianing_time'] ?>;
    var x = setInterval(function() {
      var days = Math.floor(distance / (60 * 60 * 24));
      var hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
      var minutes = Math.floor((distance % (60 * 60)) / (60));
      var seconds = Math.floor((distance % (60)));

      var timer = '';
      if(days > 0) timer += days + "d ";
      if(hours > 0) timer += hours + "h ";

      $(".license-expire .timer").html(timer +  minutes + "m " + seconds + "s ");
      distance--;
      if(distance < 0){
        clearInterval(x);
        $(".license-expire .timer").html('<?= __('admin.expired') ?>');
        window.location.reload();
      }
    }, 1000);
  </script>

<?php } ?>

</div>

<?php
$global_script_status = (array)json_decode($SiteSetting['global_script_status'],1);
if(in_array('admin', $global_script_status))
  echo $SiteSetting['global_script'];
require APPPATH . 'views/common/setting_widzard.php';
?>

    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">


    <div class="dashboard-footer admin_footer_color">
        <div><small><?= $SiteSetting['footer'] ?></div>
          <a href="<?= base_url('admincontrol/script_details') ?>">
            <span><?= __('admin.script_version') ?>
            <?php echo SCRIPT_VERSION ?></small></span>
          </a>
    </div>

  <!-- flash message -->
  <div class="print-message"><?php print_message($this); ?></div>
  <!-- flash message -->

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

  <script>
  /* flash message auto remove script */
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
      });
  }, 4000);
  /* flash message auto remove script */

  /* flash message script */
  function showPrintMessage($message,$type,$redirecturl="")
  {
     $messagestr='';
     if($type=='success') 
     {
          $messagestr= '<div class="alert alert-success  alertjs"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/> </svg> <button type="button" class="close" data-dismiss="alert"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"> <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/> </svg></button> '+ $message+'</div>';
     }
     else if($type=='error') 
     {
          $messagestr= '<div class="alert alert-danger alertjs"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg><button type="button" class="close" data-dismiss="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/> </svg></button> '+ $message+'</div>';
     }
    $(".print-message").html($messagestr);
    
    window.setTimeout(function() {
        $(".alertjs").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 4000); 

    if($redirecturl!="")
    {
      window.setTimeout(function() {
        window.location.href =$redirecturl;
      },2000);
      
    }
  }
 /* flash message script */

  /* confirmpopup script */
  function confirmpopup(url)
    { 
       Swal.fire({
       icon: 'warning',
       text: '<?= __('admin.are_you_sure_to_edit') ?>',
       showCancelButton: true,
       cancelButtonText: 'cancel'
    }).then(function(dismiss){
        if(dismiss.value==true)
        {
          window.location=url;
          return true;
        }
        else
        {
          return false;
        }
    });
    return false;
  };
  /* confirmpopup script */
  </script>
  

<!--script files for the switch button-->
<script type="text/javascript" src='<?= base_url('assets/js/bootstrap4-toggle.min.js') ?>'></script>
<!--script files for the switch button-->


<script src="<?= base_url('assets/js/jquery-ui.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery-confirm.min.js'); ?>"></script>
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
<script src="<?= base_url('assets/plugins/magnific-popup/jquery.magnific-popup.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jssocials-1.4.0/jssocials.min.js'); ?>"></script>
<script src='<?= base_url('assets/sweetalert/sweetalert.min.js') ?>'></script>
<script src='<?= base_url('assets/plugins/color-picker/spectrum.js') ?>'></script>



<!--summNote files-->
<script src="<?= base_url('assets/template/summernote/summernote-bs4.js'); ?>"></script>
<!--summNote files-->


<!--JS files-->
<script src="<?= base_url('assets/template/js/jscolor.js'); ?>"></script>
<script src="<?= base_url('assets/template/js/darkmode.js'); ?>"></script>
<script src="<?= base_url('assets/template/js/colorsmode.js'); ?>"></script>
<script src="<?= base_url('assets/template/js/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/template/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/template/js/app.js'); ?>"></script>
<!--JS files-->


<?php if(true || count($status) > 0){ ?>
  <script type="text/javascript">
    $(document).delegate(".only-number-allow","keypress",function (e) {
      if (e.which != 46 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        return false;
    });

    $(document).ready(function(){
      if(getCookie('hide_welcome') != 'true')
        $("#welcome-modal").modal("show");
    })

    function setCookie(cname, cvalue, exdays){
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

      var expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function readURLAndSetValue(input,name,placeholder){
      if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
          $("input[name='"+name+"']").val('image.jpg');
          $(placeholder).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    function readURL(input,placeholder){
      if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
          $(placeholder).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    function getCookie(cname){
      var name = cname + "=";
      var ca = document.cookie.split(';');

      for(var i = 0; i < ca.length; i++){
        var c = ca[i];

        while (c.charAt(0) == ' '){
          c = c.substring(1);
        }
        if(c.indexOf(name) == 0)
          return c.substring(name.length, c.length);
      }
      return "";
    }

    $('.hide-welcome').on('click',function(){
      setCookie("hide_welcome","true", 365)
      $("#welcome-modal").modal("hide");

    })
  </script>  
<?php } ?>

<div class="modal" id="model-shorturl"></div>

<script type="text/javascript">
  $(".btn-delete").on('click',function(){
    return confirm('<?= __('admin.are_you_sure') ?>');
  })
</script>

<script type="text/javascript">
  let leftHeight = $(".left-menu").height();
  let navbarHeight = $(".dashboard-navbar").height();
  let errorHeight = $(".server-errors").height();
  let footerHeight = $(".dashboard-footer").height();
  let elTotalheight = navbarHeight + errorHeight + footerHeight;
  let contentHeight = leftHeight - elTotalheight - 26;
  $(".content-wrapper").css('min-height',contentHeight);

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

    $this.tooltip('hide').attr('data-original-title','<?= __('admin.copied') ?>').tooltip('show');

    setTimeout(function() { $this.tooltip('hide'); }, 500);
  });

  $('[copyToClipboard]').tooltip({
    trigger: 'click',
    placement: 'bottom'

  });

  (function ($) {
    $.fn.button = function (action){
      var self = $(this);
      if(action == 'loading'){
        if($(self).attr("disabled") == "disabled"){
            //e.preventDefault();
          }
          $(self).attr("disabled", "disabled");
          $(self).attr('data-btn-text', $(self).html());
          $(self).html('<i class="fa fa-spinner fa-spin"></i>' + $(self).text());
        }
        if(action == 'reset'){
          $(self).html($(self).attr('data-btn-text'));
          $(self).removeAttr("disabled");
        }
      }
    })(jQuery);
  </script>

  <div class="modal fade" id="ip-flag_model">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?= __('admin.all_ips_details') ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('admin.close') ?></button>
        </div>
      </div>
    </div>
  </div>

<!--summNote without image and video-->
 <script>
    $(document).ready(function() {
      $('.summernote-img').summernote({
        tabsize: 2,
        height: 400,
        toolbar: [
        // [groupName, [list of button]]
        ['image', ['image']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', []],
        ['insert', ['link']],
        ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    });
  </script>
<!--summNote without image and video-->

<!--summNote full-->
 <script>
    $(document).ready(function() {
      $('.summernote').summernote({
        tabsize: 2,
        height: 400,
      });
    });
  </script>
<!--summNote full-->



<script>
    $(".select2-input").select2();
    $(document).delegate(".view-all",'click',function(){
      var data = $(this).find("span").html();
      var html = '<table class="table table-hover">';

      data = JSON.parse(data);

      html += '<tr>';

      html += ' <th>'+'<?= ('admin.ip') ?>'+'</th>';

      html += ' <th width="30px">'+'<?= ('admin.country') ?>'+'</th>';

      html += '</tr>';

      $.each(data, function(i,j){
        html += '<tr>';

        html += ' <td>'+ j['ip'] +'</td>';

        html += ' <td><img style="width: 20px;" src="<?= base_url('assets/vertical/assets/images/flags/') ?>'+ j['country_code'].toLowerCase() +'.png" ></td>';

        html += '</tr>';
      })

      html += '</table>';

      $("#ip-flag_model").modal("show");

      $("#ip-flag_model .modal-body").html(html);
    })
    $('[data-toggle="tooltip"]').tooltip();   
    if($('#morris-area-chart').length > 0){
      var areaData = [

      {y: '2011', a: 10, b: 15},

      {y: '2012', a: 30, b: 35},

      {y: '2013', a: 10, b: 25},

      {y: '2014', a: 55, b: 45},

      {y: '2015', a: 30, b: 20},

      {y: '2016', a: 40, b: 35},

      {y: '2017', a: 10, b: 25},

      {y: '2018', a: 25, b: 30}

      ];

      Morris.Area({

        element: 'morris-area-chart',

        pointSize: 3,

        lineWidth: 2,

        data: areaData,

        xkey: 'y',

        ykeys: ['a', 'b'],

        labels: ['Orders', 'Sales'],

        resize: true,

        hideHover: 'auto',

        gridLineColor: '#eef0f2',

        lineColors: ['#00c292', '#03a9f3'],

        lineWidth: 0,

        fillOpacity: 0.1,

        xLabelMargin: 10,

        yLabelMargin: 10,

        grid: false,

        axes: false,

        pointSize: 0

      });
    }
    $(document).ready(function(){
      if($('#morris-donut-chart').length > 0){
        var donutData = [
        <?php $str = '';
        $country_list = isset($country_list)?$country_list:[];
        foreach($country_list as $key => $one_item){ 
          $str .= '{label: "' . $one_item->name . '", value: ' . (int)$one_item->num . '},'; 
        }
        echo rtrim($str,", ");
        ?>
        ];
        Morris.Donut({
          element: 'morris-donut-chart',
          data: donutData,
          resize: true,
          colors: ['#40a4f1', '#5b6be8', '#c1c5e2', '#e785da', '#00bcd2']
        });
      }

      if($("#boxscroll").length > 0)
        $("#boxscroll").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true});

      if($("#boxscroll2").length > 0)
        $("#boxscroll2").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true}); 

      if($(".clickable-row").length > 0){
        $(".clickable-row").on('click',function(){
          window.location = $(this).data("href");
        });
      }
      if($("#Country").length > 0){
        $('#Country').on('change', function(){
          country_id = $(this).val();

          $.ajax({

            type: "POST",

            url: "<?= base_url();?>admincontrol/getstate",

            data:'country_id='+country_id,

            success: function(data){

              $("#StateProvince").html(data);

            }

          });

        });
      }
    });

    function shownofication(id,url){
      $.ajax({
        type: "POST",
        url: "<?= base_url('admincontrol/updatenotify');?>",
        data:'id='+id,
        dataType:'json',
        success: function(data){
        window.location.href=data['location'];
        }
      });
    }
</script>


<script type="text/javascript">
  // scroll sidebar as active link to center
  $(function() { 
    if($('.left-menu ul>li>.dropdown-menu a.active').length!=0){
      let activeMenuItem = $('.left-menu ul>li>.dropdown-menu a.active');
      $('.left-menu div.scroll-bar').animate({
        scrollTop: activeMenuItem.offset().top - ($('.left-menu div.scroll-bar').height() / 1.7)
      }, 700);
    }
  });
</script>

</body>
</html>