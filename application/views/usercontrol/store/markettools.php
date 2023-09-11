<?php
$db =& get_instance();
$userdetails=$db->userdetails();
?>

<style type="text/css">

    #product-list tr td {

        vertical-align: middle;
    } 

</style>
<script src="<?= base_url('assets/plugins/qrcode.min.js') ?>"></script>
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-20">
            <div class="card-body">
                <div class="col-12">
                    <div>
                       <div class="row mb-3">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?= __('user.search_by_vendor') ?></label>
                                <select class="form-control user_id" name="user_id">
                                    <option value=""><?= __('user.all_ads') ?></option>
                                    <?php foreach ($vendors_list as $key => $value) { ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['username'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label"><?= __('user.search_by_campaign_category') ?></label>
                            <select class="form-control category_id" >
                                <option value=""><?= __('user.all_categories') ?></option>
                               
                                    <?php 
                                    if(count($categories)>0)
                                    {
                                        $parentcategoyrid=0;
                                            foreach ($categories as $key => $value)
                                            {
                                                if($parentcategoyrid!=0 && $parentcategoyrid!=$value['pid'])
                                                { 
                                                    ?>
                                                    <?php        
                                                }
                                                if($parentcategoyrid!=$value['pid'])
                                                {
                                                    ?>
                                                  <option value="<?= $value['value'] ?>"><?= $value['label'] ?></option>  
                                                    <?php
                                                }
                                                else 
                                                {
                                                    ?>
                                                    <option value="<?= $value['value'] ?>">--<?= $value['label'] ?></option>
                                                    <?php 
                                                }
                                                    $parentcategoyrid=$value['pid'];

                                            } ?>
                                        
                                        <?php
                                    }
                                   ?>
                                 
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label"><?= __('user.search_by_campaign') ?></label>
                            <input class="table-search form-control ads_name" placeholder="Search" type="search">
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label"><?= __('user.search_by_store_category') ?></label>
                            <select class="form-control market_category_id" >
                                <option value=""><?= __('user.all_categories') ?></option>
                                <?php foreach ($store_categories as $key => $value) { ?>
                                    <option value="<?= $value['value'] ?>"><?= $value['label'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="card-body p-0" style="height: 100%;overflow: auto;">
                <div class="text-center empty-div d-none">
                    <img class="img-responsive" src="<?php echo base_url(); ?>assets/vertical/assets/images/no-data-2.png" style="margin-top:25px;">
                    <h3 class="m-t-40 text-center"><?= __('user.no_banners_to_share_yet') ?></h3>
                </div>
                
                <div class="table-responsive b-0" >
                    <table id="product-list" class="table table-no-wrap table-white-space-normal">
                        <thead>
                            <tr>
                                <th class="text-center" width="1"></th>
                                <th><?= __('user.image') ?></th>
                                <th><?= __('user.name') ?></th>
                                <th><?= __('user.commission') ?></th>
                                <th><?= __('user.view') ?></th>
                                <th><?= __('user.ratio') ?></th>
                                <th class="text-center"><?= __('user.actions') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal" id="model-codemodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('user.close') ?></button>
    </div>
</div>
</div>
</div>
<div class="modal" id="model-codeformmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('user.close') ?></button>
    </div>
</div>
</div>
</div>
<div class="modal fade" id="integration-code"><div class="modal-dialog"><div class="modal-content"></div></div></div>
<?= $social_share_modal ?>
<script type="text/javascript">

    var xhr;
    function getPage(url){
        $this = $(this);

        if(xhr && xhr.readyState != 4) xhr.abort();
        xhr = $.ajax({
            url:url,
            type:'POST',
            dataType:'json',
            data:{
                market_category_id: $(".market_category_id").val(),
                category_id: $(".category_id").val(),
                ads_name: $(".ads_name").val(),
                vendor_id: $(".user_id").val(),
                dvl: 1,
            },
            beforeSend:function(){$(".btn-search").btn("loading");},
            complete:function(){$(".btn-search").btn("reset");},
            success:function(json){
                if(json['view']){
                    $("#product-list tbody").html(json['view']);
                    $("#product-list").show();
                    $(".empty-div").addClass("d-none");

                } else {
                    $(".empty-div").removeClass("d-none");
                    $("#product-list").hide();
                }
            },
        })
    }

    $(".user_id,.category_id,.market_category_id, .display-vendor-links").on("change",function(){
        getPage('<?= base_url("usercontrol/store_markettools/") ?>/1');
    });
    $(".ads_name").on("keyup",function(){
        getPage('<?= base_url("usercontrol/store_markettools/") ?>/1');
    });
    
    getPage('<?= base_url("usercontrol/store_markettools/") ?>/1');



    $("#product-list").delegate(".get-code",'click',function(){
        $this = $(this);
        $.ajax({
            url:'<?= base_url("integration/tool_get_code/usercontrol") ?>',
            type:'POST',
            dataType:'json',
            data:{id:$this.attr("data-id")},
            beforeSend:function(){ $this.btn("loading"); },
            complete:function(){ $this.html("<i class='fa fa-code'></i>"); },
            success:function(json){
                if(json['html']){
                    $("#integration-code .modal-content").html(json['html']);
                    $("#integration-code").modal("show");
                }
            },
        })
    });

    $("#product-list").delegate(".get-terms",'click',function(){
        $this = $(this);
        $.ajax({
            url:'<?= base_url("integration/tool_get_terms/usercontrol") ?>',
            type:'POST',
            dataType:'json',
            data:{id:$this.attr("data-id")},
            beforeSend:function(){ $this.btn("loading"); },
            complete:function(){ $this.html("<i class='fa fa-info'></i>"); },
            success:function(json){
                if(json['html']){
                    $("#integration-code .modal-content").html(json['html']);
                    $("#integration-code").modal("show");
                }
            },
        })
    });

    $("#product-list").delegate(".toggle-child-tr",'click',function(){
        $tr = $(this).parents("tr");
        $ntr = $tr.next("tr.detail-tr");

        if($ntr.css("display") == 'table-row'){
            $ntr.hide();
            $(this).find("i").attr("class","fa fa-plus");
        }else{
            $(this).find("i").attr("class","fa fa-minus");
            $ntr.show();
        }
    })
    $("#product-list").delegate(".show-more",'click',function(){
        $(this).parents("tfoot").remove();
        $("#product-list tr.d-none").hide().removeClass('d-none').fadeIn();
    });

    function generateCode(affiliate_id,t){
        $this = $(t);
        $.ajax({
            url:'<?php echo base_url();?>usercontrol/generateproductcode/'+affiliate_id,
            type:'POST',
            dataType:'html',
            beforeSend:function(){
                $this.btn("loading");
            },
            complete:function(){
             $this.html("<i class='fa fa-code'></i>");
         },
         success:function(json){
            $('#model-codemodal .modal-body').html(json);
            $("#model-codemodal").modal("show");
        },
    })
    }

    function generateCodeForm(form_id,t){ 
        $this = $(t);
        $.ajax({
            url:'<?php echo base_url();?>usercontrol/generateformcode/'+form_id,
            type:'POST',
            dataType:'html',
            beforeSend:function(){
                $this.btn("loading");
            },
            complete:function(){
                $this.html("<i class='fa fa-code'></i>");
            },
            success:function(json){
                $('#model-codeformmodal .modal-body').html(json);
                $("#model-codeformmodal").modal("show");
            },
        })
    }

    function downloadCode(t, id, type){
        $this = $(t);
        $.ajax({
            url:'<?php echo base_url();?>usercontrol/downloadToolCode/'+id+'/'+type,
            type:'POST',
            dataType:'html',
            beforeSend:function(){
                $this.btn("loading");
            },
            complete:function(){
                $this.html("<i class='fa fa-download'></i>");
            },
            success:function(res){
                window.location.href = res;
            },
        })
    }

    $("#show_my_id").change(function(){
        if($(this).prop("checked")){
            $(".show-mega-link").removeClass("d-none");
            $(".show-tiny-link").addClass("d-none");
        } else {
            $(".show-mega-link").addClass("d-none");
            $(".show-tiny-link").removeClass("d-none");
        }
    })
    $(document).on('click','.qrcode',function(){
        $('#model-codemodal .modal-body').html("<span id='QRDataModal'></span>");
        $("#model-codemodal").modal("show");
        var qrdata = $(this).attr('data-id');
        var qrcode = new QRCode(document.getElementById("QRDataModal"), {
            text: qrdata,
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

    })
</script>