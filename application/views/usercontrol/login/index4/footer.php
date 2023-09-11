        </div>
    </div>
</div>
<!-- Footer -->
<div class="footer">
    <nav class="navbar navbar-expand-sm navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footernav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="footernav">
        <ul class="navbar-nav footer-items-center-x">
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#termOfUse">
                    <?= __('front.temrs_of_use') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#about">
                    <?= __('front.about') ?>
                </a>
            </li>
            <?php 
            $store_setting = $this->Product_model->getSettings('store');
            if($store_setting['menu_on_front']){ ?>
            <li class="nav-item <?php if(base_url(uri_string()) == base_url('/store')){ echo 'active'; } ?>">
                <a class="nav-link" href="<?= base_url('/store') ?>" <?= ($store_setting['menu_on_front_blank']) ? 'target="_blank"' : ''; ?>><?= __('front.my_store') ?></a>
            </li>
             <?php } ?>
        </ul>
    </div>
    </nav>
    <div class="mt-4 mb-1"><?= $footer ?></div>
</div>
    
<!-- Policy Modal -->
<div class="modal fade" id="termOfUse" tabindex="-1" role="dialog" aria-labelledby="termsOfUseTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?= $tnc['heading'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 modal-row">
                            <h5 class="modal-h5"><?= $tnc['content'] ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('front.close') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- About Modal -->
<div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="aboutTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?= __('front.about') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 modal-row">
                            <h5 class="modal-h5"><?= $setting['about_content'] ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('front.close') ?></button>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/main.js') ?>"></script>

<!-- login-form script -->
<script type="text/javascript">
    var grecaptcha = undefined;
    $('#login-form').on('submit',function(){
        $this = $(this);
        $.ajax({
            url:'<?= base_url('auth/login') ?>',
            type:'POST',
            dataType:'json',
            data: $this.serialize() + '&type=user',
            success:function(json){
                $this.find(".is-valid").removeClass("is-valid");
                $this.find(".has-error").removeClass("has-error");
                $this.find("span.text-danger").remove();
                if(json['errors']){
                    $.each(json['errors'], function(i,j){
                        if(i == 'captch_response' && grecaptcha){ grecaptcha.reset(); }
                        $ele = $this.find('[name="'+ i +'"]');
                        if($ele){
                            $formGroup = $ele.parents(".form-group");
                            $formGroup.addClass("has-error");
                            if($formGroup.find(".input-group").length){
                                $formGroup.find(".input-group").after("<span class='bg-white d-block text-danger'>"+ j +"</span>");
                            } else {
                                $ele.after("<span class='text-danger'>"+ j +"</span>");
                            }
                        }
                    })
                }
                if(json['redirect']){ window.location = json['redirect']; }
            },
        })
        return false;
    });
</script>
<!-- login-form script -->

<!-- reset-password-form script -->
<script type="text/javascript">
    var grecaptcha = undefined;
    $('.reset-password-form').on('submit',function(){
        $this = $(this);
        $.ajax({
            url:'<?= base_url('auth/forget') ?>',
            type:'POST',
            dataType:'json',
            data: $this.serialize(),
            success:function(json){
                $this.find(".has-error").removeClass("has-error");
                $this.find("span.text-danger,.success-msg").remove();
                if(json['success']){
                    $this.find('[name="email"]').after("<div class='alert success-msg alert-success'> " + json['success'] + "</div>");
                }

                if(json['errors']){
                    $.each(json['errors'], function(i,j){
                        if(i == 'captch_response' && grecaptcha){ grecaptcha.reset(); }

                        $ele = $this.find('[name="'+ i +'"]');
                        if($ele){
                            $formGroup = $ele.parents(".form-group");
                            $formGroup.addClass("has-error");

                            if($formGroup.find(".input-group").length){
                                $formGroup.find(".input-group").after("<span class='text-danger'>"+ j +"</span>");
                            } else {
                                $ele.after("<span class='text-danger'>"+ j +"</span>");
                            }
                        }
                    })
                }

                if(json['redirect']){ window.location = json['redirect']; }
            },
        })
        return false;
    });
</script>
<!-- reset-password-form script -->

</body>
</html>

