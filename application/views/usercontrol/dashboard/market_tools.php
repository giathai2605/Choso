<?php
  $db =& get_instance();
  $userdetails = $db->userdetails();

  if(!isset($fun_c_format))
    $fun_c_format = 'c_format';

  $pro_setting    = $this->Product_model->getSettings('productsetting');
  $form_setting   = $this->Product_model->getSettings('formsetting');
  $vendor_setting = $this->Product_model->getSettings('vendor');
?>
<?php if($data_list == null){ ?>
  <div class="text-center">
      <img class="img-responsive" src="<?= base_url('assets/vertical/assets/images/no-data-2.png'); ?>" style="margin-top:25px;">
      <h3 class="m-t-40 text-center"><?= __('user.no_banners_to_share_yet') ?></h3>
  </div>
<?php } else { ?>
  <?php foreach($data_list as $index => $product){
      if(isset($product['is_form'])){ ?>
        <div class="card">
          <div class="card-header" id="headingOne"> 
            <span data-toggle="collapse" data-target="#accordion<?= $index ?>" aria-controls="collapseOne" class="collapsed "></span>
            <div class="accordioni-containt">
              <ul>
                <li>
                  <img class="accordion-image" src="<?= base_url('assets/images/share-icon.png') ?>" 
                  alt="<?= $product['title'] ?>">
                </li>
                <li class="name-text">
                  <h6><?= $product['title'] ?>
                    <span>
                      <a href="<?= $product['public_page'] ?>" target="_blank"><?= __('user.public_page'); ?></a>
                      / 
                      <a href="javascript:void(0);" onclick="generateCodeForm(<?= $product['form_id'];?>,this);">
                        <?= __('user.get_ncode') ?>
                      </a>
                    </span>
                  </h6>
                </li>
                <li class="offer-text">
                  <p>
                    <strong><?= __('user.you_will_get') ?> : </strong> 
                    <?php
                      if($product['sale_commision_type'] == 'default'){
                          $commissionType = $form_default_commission['product_commission_type'];
                          if($form_default_commission['product_commission_type'] == 'percentage'){
                             if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $form_default_commission['product_commission'])
                                $product_commission = $userComission['value'];
                            else
                                $product_commission = $form_default_commission['product_commission'];

                            echo $product_commission .'% '.__('user.per_sale');
                          } else if($form_default_commission['product_commission_type'] == 'Fixed'){
                            echo $fun_c_format($form_default_commission['product_commission']) .' '.__('user.per_sale');
                          }
                      } else if($product['sale_commision_type'] == 'percentage'){
                          if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $product['sale_commision_value'])
                              $sale_commision_value = $userComission['value'];
                          else
                              $sale_commision_value = $product['sale_commision_value'];

                          echo $sale_commision_value .'% '.__('user.per_sale');
                      } else if($product['sale_commision_type'] == 'fixed'){
                          echo $fun_c_format($product['sale_commision_value']) .' '.__('user.per_sale');
                      }
                    ?>
                  </p>
                  <p>
                    <strong><?= __('user.you_will_get') ?> : </strong> 
                    <?php 
                      if($product['click_commision_type'] == 'default'){
                          if((int)$product['vendor_id']){
                              $vendor_setting = $this->db->query("SELECT * FROM vendor_setting WHERE user_id=". (int)$product['vendor_id'] ." ")->row();
                              echo $fun_c_format($vendor_setting->form_affiliate_click_amount) .' '.__('user.of_per').' '. (int)$vendor_setting->form_affiliate_click_count .' '.__('user.click');
                          } else {
                              $commissionType = $form_default_commission['product_commission_type'];
                              if($form_default_commission['product_commission_type'] == 'percentage')
                                  echo $fun_c_format($form_default_commission['product_ppc']) .' '.__('user.of_per').' '. $form_default_commission['product_noofpercommission'] .' '.__('user.click');
                              else if($form_default_commission['product_commission_type'] == 'Fixed')
                                  echo $fun_c_format($form_default_commission['product_ppc']) .' '.__('user.of_per').' '. $form_default_commission['product_noofpercommission'] .' '.__('user.click');
                          }
                      } else if($product['click_commision_type'] == 'custom') {
                        echo $fun_c_format($product['click_commision_per']) .' '.__('user.of_per').' '. $product['click_commision_ppc'] .' '.__('user.click');
                      }
                    ?>
                  </p>
                  <?php 
                    if($product['form_recursion_type']){
                        if($product['form_recursion_type'] == 'custom'){
                            if ($product['form_recursion'] == 'custom_time') {
                                $form_recursion = __("admin.custom_time");
                            }elseif ($product['form_recursion'] == 'every_day') {
                                $form_recursion = __("admin.every_day");
                            }elseif ($product['form_recursion'] == 'every_week') {
                                $form_recursion = __("admin.every_week");
                            }elseif ($product['form_recursion'] == 'every_month') {
                                $form_recursion = __("admin.every_month");
                            }elseif ($product['form_recursion'] == 'every_year') {
                                $form_recursion = __("admin.every_year");
                            }else{
                                $form_recursion = $product['form_recursion'];
                            }

                            if($product['form_recursion'] != 'custom_time')
                                echo '<p><strong>'.__('user.recurring').' : </strong>'.$form_recursion.'</p>';
                            else
                                echo '<p><strong>'.__('user.recurring').' : </strong>'.timetosting($product['recursion_custom_time']).'</p>';
                        } else {
                            if ($form_setting['form_recursion'] == 'custom_time') {
                                $form_recursion = __("admin.custom_time");
                            }elseif ($form_setting['form_recursion'] == 'every_day') {
                                $form_recursion = __("admin.every_day");
                            }elseif ($form_setting['form_recursion'] == 'every_week') {
                                $form_recursion = __("admin.every_week");
                            }elseif ($form_setting['form_recursion'] == 'every_month') {
                                $form_recursion = __("admin.every_month");
                            }elseif ($form_setting['form_recursion'] == 'every_year') {
                                $form_recursion = __("admin.every_year");
                            }else{
                                $form_recursion = $form_setting['form_recursion'];
                            }

                            if($form_setting['form_recursion'] == 'custom_time')
                                echo '<p><strong>'.__('user.recurring').' : </strong>'.timetosting($form_setting['recursion_custom_time']).'</p>';
                            else
                                echo '<p><strong>'.__('user.recurring').' : </strong>'.$form_recursion.'</p>';
                        }
                    }
                  ?>
                </li>
                <li>
                  <div class="link-area d-flex align-items-center"> 
                    <i class="lni lni-link"></i>
                    <?php
                      if($product['slug'])
                          $shareUrl = base_url($product['slug']);
                      else
                          $shareUrl = $product['public_page'];
                    ?>
                    <input readonly="readonly" value="<?= $shareUrl ?>" class="input-form-url-<?= $product['form_id'] ?>">

                    <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $shareUrl ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                    <a href="javascript:void(0)" class="copy-w-icon" copyToClipboard="<?= $shareUrl ?>">
                      <img src="<?= base_url('assets/template/images/user-copy-w-icon.png') ?>" alt="<?= __('user.copy') ?>">
                    </a> 
                    <a href="javascript:void(0)" class="log-setting settings-w-icon dashboard-model-slug" data-type="form" 
                      data-related-id="<?= $product['form_id'] ?>" data-input-class="input-form-url-<?= $product['form_id'] ?>"> 
                      <img src="<?= base_url('assets/template/images/user-settings-w-icon.png') ?>" alt="">
                    </a>
                    <a href="javascript:void(0)" class="social-share-icon" data-social-share data-share-url="<?= $product['public_page'].'?id='.$userdetails['id'] ?>" data-share-title="<?= $product['product_name'] ?>" data-share-desc="<?= $product['product_short_description']?>">
                      <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
                    </a> 
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div id="accordion<?= $index ?>" class="collapse " 
            aria-labelledby="headingOne" data-parent="#affiliate-accordion">
            <div class="card-body affiliate-body">
              <ul class=" d-flex align-items-center justify-content-between">
                <li>
                  <div>
                    <p>
                      <strong><?= __('user.coupon_code') ?>:</strong>
                      <?= $product['coupon_code'] ? $product['coupon_code'] : __('user.n_a') ?> 
                    </p>
                  </div>
                </li>
                <li>
                  <div>
                    <p>
                      <strong><?= __('user.coupon_use') ?>:</strong> 
                      <?= ($product['coupon_name'] ? $product['coupon_name'] : '-').' / '.$product['count_coupon'] ?> 
                    </p>
                  </div>
                </li>
                <li>
                  <div>
                    <p>
                      <strong><?= __('user.sales') ?>:</strong> 
                      <?= (int)$product['count_commission'].' / '.c_format($product['total_commission']) ?>
                      <em><?= __('user.commission') ?></em> 
                    </p>
                  </div>
                </li>
                <li>
                  <div>
                    <p>
                      <strong><?= __('user.clicks') ?>:</strong> 
                      <?= (int)$product['commition_click_count'].' / '.c_format($product['commition_click']); ?>
                      <em><?= __('user.commission') ?></em> 
                    </p>
                  </div>
                </li>
                <li>
                  <div class="bg-green">
                    <p>
                      <strong><?= __('user.total'); ?>:</strong> 
                      <?= $fun_c_format($product['total_commission']+$product['commition_click']) ?>
                    </p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      <?php } else if(isset($product['is_product'])) { 
        if($product['is_campaign_product']) {
            $af_id = _encrypt_decrypt($userdetails['id']."-".$product['product_id']);
            $productLink = addParams($product['product_url'],"af_id",$af_id);
        } else {
            $productLink = base_url('store/'. base64_encode($userdetails['id']) .'/product/'.$product['product_slug'] );
        } ?>
        <div class="card">
          <div class="card-header" id="headingOne"> 
            <span data-toggle="collapse" data-target="#accordion<?= $index ?>" aria-controls="collapseOne" class="collapsed "></span>
            <div class="accordioni-containt">
              <ul>
                <li>
                  <img class="accordion-image" src="<?= base_url('assets/images/product/upload/thumb/'.$product['product_featured_image']) ?>" 
                  alt="<?= $product['product_name'] ?>">
                </li>
                <li class="name-text">
                  <h6><?= $product['product_name'] ?>
                    <span>
                      <a href="<?= $productLink ?>" target="_blank"><?= __('user.public_npage'); ?></a>
                      / 
                      <a href="javascript:void(0);" onclick="generateCode(<?= $product['product_id'];?>,this);">
                        <?= __('user.get_ncode') ?>
                      </a>
                    </span>
                  </h6>
                </li>
                <li class="offer-text">
                    <?php 
                      if($product['seller_id']){
                        $seller = $this->Product_model->getSellerFromProduct($product['product_id']);
                        $seller_setting = $this->Product_model->getSellerSetting($seller->user_id);

                        $commnent_line = "";
                        if($seller->affiliate_sale_commission_type == 'default'){ 
                            if($seller_setting->affiliate_sale_commission_type == ''){
                              $commnent_line .= __('user.warning_default_commission_not_set');
                            } else if($seller_setting->affiliate_sale_commission_type == 'percentage'){
                              if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $seller_setting->affiliate_commission_value)
                                $affiliate_commission_value = $userComission['value'];
                              else
                                $affiliate_commission_value = (float) $seller_setting->affiliate_commission_value;

                              $commnent_line .=  $affiliate_commission_value .'%';
                            } else if($seller_setting->affiliate_sale_commission_type == 'fixed'){
                              $commnent_line .= $fun_c_format($seller_setting->affiliate_commission_value);
                            }
                        } else if($seller->affiliate_sale_commission_type == 'percentage'){
                            if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $seller->affiliate_commission_value)
                              $affiliate_commission_value = $userComission['value'];
                            else
                              $affiliate_commission_value = (float) $seller->affiliate_commission_value;

                            $commnent_line .=  $affiliate_commission_value.'%';
                        } else if($seller->affiliate_sale_commission_type == 'fixed'){
                            $commnent_line .= $fun_c_format($seller->affiliate_commission_value);
                        } 

                        echo '<p><strong>'.__('user.you_will_get').' : </strong>' .$commnent_line.' '.__('user.per_sale').'</p>';

                        $commnent_line = "";
                        if($seller->affiliate_click_commission_type == 'default'){ 
                            $commnent_line .= $fun_c_format($seller_setting->affiliate_click_amount) ." ".__('user.per')." ". (int)$seller_setting->affiliate_click_count ." ".__('user.clicks');
                        } else{
                            $commnent_line .= $fun_c_format($seller->affiliate_click_amount) ." ".__('user.per')." ". (int)$seller->affiliate_click_count ." ".__('user.clicks');
                        } 
                        echo '<p><strong>'.__('user.you_will_get').' : </strong>' .$commnent_line.'</p>';
                      } else {
                        echo '<p><strong>'.__('user.you_will_get').' : </strong>';
                        if($product['product_commision_type'] == 'default'){
                            if($default_commition['product_commission_type'] == 'percentage'){
                              if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $default_commition['product_commission'])
                                  $product_commission = $userComission['value'];
                              else
                                  $product_commission = $default_commition['product_commission'];

                              echo $product_commission. "% ".__('user.per_sale');
                            } else {
                              echo $fun_c_format($default_commition['product_commission']) ." ".__('user.per_sale');
                            }
                        } else if($product['product_commision_type'] == 'percentage'){
                            if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $product['product_commision_value'])
                              $product_commision_value = $userComission['value'];
                            else
                              $product_commision_value = $product['product_commision_value'];

                            echo $product_commision_value. "% ".__('user.per_sale');
                        } else {
                            echo $fun_c_format($product['product_commision_value']) ." ".__('user.per_sale');
                        }
                        echo '</p>';
                        echo '<p><strong>'.__('user.you_will_get').' : </strong>';
                        if($product['product_click_commision_type'] == 'default')
                            echo $fun_c_format($default_commition['product_ppc']) ." ".__('user.per')." {$default_commition['product_noofpercommission']} ".__('user.click');
                        else
                            echo $fun_c_format($product['product_click_commision_ppc'])." ".__('user.per')." {$product['product_click_commision_per']} ".__('user.click');
                        echo '</p>';
                      } ?>
                  <?php 
                    if($product['product_recursion_type']){
                      if($product['product_recursion_type'] == 'custom'){
                          if($product['product_recursion'] != 'custom_time')
                              echo '<p><strong>'.__('user.recurring').' : </strong>'.$product['product_recursion'].'</p>';
                          else
                              echo '<p><strong>'.__('user.recurring').' : </strong>'.timetosting($product['recursion_custom_time']).'</p>';
                      } else {
                          if($pro_setting['product_recursion'] == 'custom_time')
                              echo '<p><strong>'.__('user.recurring').' : </strong>'.timetosting($pro_setting['recursion_custom_time']).'</p>';
                          else
                              echo '<p><strong>'.__('user.recurring').' : </strong>'.$pro_setting['product_recursion'].'</p>';
                      }
                    }
                  ?>
                </li>
                <li>
                  <div class="link-area d-flex align-items-center"> 
                    <i class="lni lni-link"></i>
                    <?php
                      if($product['slug'])
                          $shareUrl = base_url($product['slug']);
                      else
                          $shareUrl = $productLink;
                    ?>
                    <input readonly="readonly" value="<?= $shareUrl ?>" class="input-product-url-<?= $product['product_id'] ?>">
                    
                     <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $shareUrl ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                    <a href="javascript:void(0)" class="copy-w-icon" copyToClipboard="<?= $shareUrl ?>">
                      <img src="<?= base_url('assets/template/images/user-copy-w-icon.png') ?>" alt="<?= __('user.copy') ?>">
                    </a> 
                    <a href="javascript:void(0)" class="log-setting settings-w-icon dashboard-model-slug" data-type="product" 
                      data-related-id="<?= $product['product_id'] ?>" data-input-class="input-product-url-<?= $product['product_id'] ?>"> 
                      <img src="<?= base_url('assets/template/images/user-settings-w-icon.png') ?>" alt="">
                    </a>
                    <a href="javascript:void(0)" class="social-share-icon" data-social-share data-share-url="<?= $productLink.'?id='.$userdetails['id'] ?>" data-share-title="<?= $product['product_name'] ?>" data-share-desc="<?= $product['product_short_description']?>">
                      <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
                    </a> 
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div id="accordion<?= $index ?>" class="collapse " 
            aria-labelledby="headingOne" data-parent="#affiliate-accordion">
            <div class="card-body affiliate-body">
              <ul class=" d-flex align-items-center justify-content-between">
                <li>
                  <div>
                    <p>
                      <strong><?= __('user.price') ?>:</strong>
                      <?= $fun_c_format($product['product_price']) ?> 
                    </p>
                  </div>
                </li>
                <li>
                  <div>
                    <p>
                      <strong><?= __('user.sku') ?>:</strong> 
                      <?= $product['product_sku'] ?> 
                    </p>
                  </div>
                </li>
                <li>
                  <div>
                    <p>
                      <strong><?= __('user.sales') ?>:</strong> 
                      <?= $product['order_count'].' / '.$fun_c_format($product['commission']) ?>
                      <em><?= __('user.commission') ?></em> 
                    </p>
                  </div>
                </li>
                <li>
                  <div>
                    <p>
                      <strong><?= __('user.clicks') ?>:</strong> 
                      <?= (int)$product['commition_click_count'].' / '.$fun_c_format($product['commition_click']); ?>
                      <em><?= __('user.commission') ?></em> 
                    </p>
                  </div>
                </li>
                <li>
                  <div class="bg-green">
                    <p>
                      <strong><?= __('user.total'); ?>:</strong> 
                      <?= $fun_c_format((float)$product['commition_click'] + (float)$product['commission']) ?>
                    </p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div class="card">
          <div class="card-header" id="headingOne"> 
            <span data-toggle="collapse" data-target="#accordion<?= $index ?>" aria-controls="collapseOne" class="collapsed "></span>
            <div class="accordioni-containt">
              <ul>
                <li>
                  <img class="accordion-image" src="<?= base_url('assets/images/product/upload/thumb/'.$product['featured_image']) ?>" 
                  alt="<?= $product['name'] ?>">
                </li>
                <li class="name-text">
                  <h6><?= $product['name'] ?>
                    <span>
                      <a class="get-code" href="javascript:void(0)" data-id="<?= $product['id'] ?>">
                        <?= __('user.get_code') ?>
                      </a>
                      / 
                      <a class="get-terms" href="javascript:void(0)" data-id="<?= $product['id'] ?>">
                        <?= __('user.get-terms') ?>
                      </a>
                    </span>
                  </h6>
                </li>
                <li class="offer-text">
                  <?php 
                    if($product['_tool_type'] == 'program' && $product['sale_status']){
                      $comm = '';
                      if($product['commission_type'] == 'percentage'){
                        if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $product['commission_sale'])
                          $commission_sale = $userComission['value'];
                        else
                          $commission_sale = $product['commission_sale'];
                        
                        $comm = $commission_sale.'%';
                      } else if($product['commission_type'] == 'fixed'){
                        $comm = $fun_c_format($product['commission_sale']);
                      }
                      
                      echo "<p><strong>".__('user.you_will_get')." : </strong> {$comm} ".__('user.per_sale')."<p>";
                    }

                    if($product['_tool_type'] == 'program' && $product['click_status']){
                      echo "<p><strong>".__('user.you_will_get')." : </strong>";
                      echo $fun_c_format($product["commission_click_commission"]). " ".__('user.per')." ".
                          $product['commission_number_of_click']." ".__('user.clicks')."</p>";
                    }

                    if($product['_tool_type'] == 'general_click'){
                       echo "<p><strong>".__('user.you_will_get')." : </strong>";
                       echo $fun_c_format($product["general_amount"])." ".__('user.per')." ".$product['general_click']." ".
                          __('user.general_clicks')."</p>";
                    }

                    if($product['_tool_type'] == 'action' || $product['_tool_type'] == 'single_action'){
                      echo "<p><strong>".__('user.you_will_get')." : </strong>";
                      echo $fun_c_format($product["action_amount"]). " ".__('user.per')." ".$product['action_click']." ".
                          __('user.actions')." </p>";
                    }
                  ?>
                  <?php 
                    if($product['recursion']){
                        if($product['recursion'] != 'custom_time')
                            echo '<p><strong>'.__('user.recurring').' : </strong>'.$product['recursion'].'</p>';
                        else
                            echo '<p><strong>'.__('user.recurring').' : </strong>'.timetosting($product['recursion_custom_time']).'</p>';
                    }
                  ?>
                </li>
                <li>
                  <div class="link-area d-flex align-items-center"> 
                    <i class="lni lni-link"></i>
                    <?php
                      if($product['slug'])
                        $shareUrl = base_url($product['slug']);
                      else
                        $shareUrl = $product['redirectLocation'][0];
                    ?>
                    <input readonly="readonly" value="<?= $shareUrl ?>" class="input-<?= $product['_tool_type'].'-url-'.$product['id']  ?>">
                    
                    <a href="javascript:void(0)" class="btn-secondary  btn btn-sm btn-info qrcode  mr-1"  data-id="<?= $shareUrl ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                    
                    <a href="javascript:void(0)" class="copy-w-icon" copyToClipboard="<?= $shareUrl ?>">
                      <img src="<?= base_url('assets/template/images/user-copy-w-icon.png') ?>" alt="<?= __('user.copy') ?>">
                    </a> 
                    <a href="javascript:void(0)" class="log-setting settings-w-icon dashboard-model-slug" data-type="<?= $product['_tool_type'] ?>" data-related-id="<?= $product['id'] ?>" data-input-class="input-<?= $product['_tool_type'].'-url-'.$product['id'] ?>"> 
                      <img src="<?= base_url('assets/template/images/user-settings-w-icon.png') ?>" alt="">
                    </a>
                    <a href="javascript:void(0)" class="social-share-icon" data-social-share data-share-url="<?= $product['redirectLocation'][0].'?id='.$userdetails['id'] ?>" data-share-title="<?= $product['product_name'] ?>" data-share-desc="<?= $product['product_short_description'] ?>">
                      <img src="<?= base_url('assets/template/images/user-share-icon.png') ?>" alt="<?= __('user.share') ?>"> 
                    </a> 
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div id="accordion<?= $index ?>" class="collapse " aria-labelledby="headingOne" data-parent="#affiliate-accordion">
            <div class="card-body affiliate-body">
              <ul class=" d-flex align-items-center justify-content-between">
                <?php 
                  if($product['_tool_type'] == 'program' && $product['sale_status']){
                    echo "<li><div><p><strong>".__('user.sale_count')." : </strong>".(int)$product['total_sale_count']."</p></div></li>";
                    echo "<li><div><p><strong>".__('user.sale_amount')." : </strong>".$product['total_sale_amount']."</p></div></li>";
                  }

                  if($product['_tool_type'] == 'program' && $product['click_status']){
                    echo "<li><div><p><strong>".__('user.click_count')." : </strong>".(int)$product['total_click_count']."</p></div></li>";
                    echo "<li><div><p><strong>".__('user.click_amount')." : </strong>".$product['total_click_amount']."</p></div></li>";
                  }

                  if($product['_tool_type'] == 'general_click'){
                    echo "<li><div><p><strong>".__('user.general_count')." : </strong>".(int)$product['total_general_click_count']."</p></div></li>";
                    echo "<li><div><p><strong>".__('user.general_amount')." : </strong>".$product['total_general_click_amount']."</p></div></li>";
                  }

                  if($product['_tool_type'] == 'action'){
                    echo "<li><div><p><strong>".__('user.action_count')." : </strong>".(int)$product['total_action_click_count']."</p></div></li>";
                    echo "<li><div><p><strong>".__('user.action_amount')." : </strong>".$product['total_action_click_amount']."</p></div></li>";
                  }
                ?>
                <li>
                  <div class="bg-green">
                    <p>
                      <strong><?= __('user.total'); ?>:</strong> 
                      <?= $product['total_amount'] ?>
                    </p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      <?php }
      } ?>  

<?php } ?>  
