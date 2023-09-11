<?php
$db =& get_instance();
$userdetails=$db->userdetails();
$pro_setting = $this->Product_model->getSettings('productsetting');
$form_setting = $this->Product_model->getSettings('formsetting');
?>
<?php foreach($data_list as $index => $product){ ?>
    <?php
        //$display_class = $index >= $pagination ? 'd-none' : '';
    $display_class = '';
    if ($product['on_store'] == 0 && $product['product_created_by'] == 1) {
        $display_class = 'd-none';
    }else{
        $display_class = '';
    }
    
    ?>
    <?php if(isset($product['is_form'])){ ?>
        <tr class="<?= $display_class ?>">
            <td class="text-center">
                <button type="button" class="toggle-child-tr"><i class="fa fa-plus"></i></button>
            </td>
            <td><img width="50px" height="50px" src="<?php echo base_url($product['fevi_icon']) ?>" ></td>
            <td class="max-width-300"><?= $product['title'] ?></td>
            <td>
                <?php
                echo "<b>".__('user.you_will_get'). "</b>";
                if($product['sale_commision_type'] == 'default'){
                    $commissionType = $form_default_commission['product_commission_type'];
                    if($form_default_commission['product_commission_type'] == 'percentage'){
                        if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $form_default_commission['product_commission'])
                            $product_commission = $userComission['value'];
                        else
                            $product_commission = $form_default_commission['product_commission'];

                        echo $product_commission .'% '.__('user.per_sale');
                    }
                    else if($form_default_commission['product_commission_type'] == 'Fixed'){
                        echo c_format($form_default_commission['product_commission']) .' '.__('user.per_sale');
                    }
                }
                else if($product['sale_commision_type'] == 'percentage'){
                    if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $product['sale_commision_value'])
                        $sale_commision_value = $userComission['value'];
                    else
                        $sale_commision_value = $product['sale_commision_value'];

                    echo $sale_commision_value .'% '.__('user.per_sale');
                }
                else if($product['sale_commision_type'] == 'fixed'){
                    echo c_format($product['sale_commision_value']) .' '.__('user.per_sale');
                }

                echo "<br>". "<b>".__('user.you_will_get')."</b>";
                if($product['click_commision_type'] == 'default'){
                    if((int)$product['vendor_id']){
                        $vendor_setting = $this->db->query("SELECT * FROM vendor_setting WHERE user_id=". (int)$product['vendor_id'] ." ")->row();
                        echo c_format($vendor_setting->form_affiliate_click_amount) .' '.__('user.of_per').' '. (int)$vendor_setting->form_affiliate_click_count .' '.__('user.click');
                    } else {
                        $commissionType = $form_default_commission['product_commission_type'];
                        if($form_default_commission['product_commission_type'] == 'percentage'){
                            echo c_format($form_default_commission['product_ppc']) .' '.__('user.of_per').' '. $form_default_commission['product_noofpercommission'] .' '.__('user.click');
                        }
                        else if($form_default_commission['product_commission_type'] == 'Fixed'){
                            echo c_format($form_default_commission['product_ppc']) .' '.__('user.of_per').' '. $form_default_commission['product_noofpercommission'] .' '.__('user.click');
                        }
                    }
                }
                else if($product['click_commision_type'] == 'custom') {
                    echo c_format($product['click_commision_per']) .' '.__('user.of_per').' '. $product['click_commision_ppc'] .' '.__('user.click');
                }
                ?>
                <div>
                    <?php 
                    if($product['form_recursion_type']){
                        if($product['form_recursion_type'] == 'custom'){
                            if($product['form_recursion'] != 'custom_time'){
                                echo '<b>'. __('user.recurring') .' </b> : ' . __('user.'. $product['form_recursion']);
                            } else {
                                echo '<b>'. __('user.recurring') .' </b> : '. timetosting($product['recursion_custom_time']);
                            }
                        } else{
                            if($form_setting['form_recursion'] == 'custom_time' ){
                                echo '<b>'. __('user.recurring') .' </b> : '. timetosting($form_setting['recursion_custom_time']);
                            } else {
                                echo '<b>'. __('user.recurring') .' </b> : '. __('user.'. $form_setting['form_recursion']);
                            }
                        }
                    }
                    ?>
                </div>
            </td>
            <td class="text-center">
                <?php echo $product['view_statistics'] ?>
            </td>
            <td>
                <?php 
                 $ordercountratio=0;
                 if($product['view_statistics']>0)
                    $ordercountratio=$product['all_count_commission']*100/$product['view_statistics'];
                 $ordercountratio = is_float($ordercountratio) ==1 ? number_format((float)$ordercountratio, 2, '.', '') : $ordercountratio ;
                 echo 'Sale : '. $ordercountratio .'%<br/>';

                 $ordercountratio=0;
                $comissionclickcount=(int)$product['all_commition_click_count']  ; 
                if($product['view_statistics']>0)
                   $ordercountratio=$comissionclickcount*100/$product['view_statistics'];
                $ordercountratio = is_float($ordercountratio) ==1 ? number_format((float)$ordercountratio, 2, '.', '') : $ordercountratio;
                echo 'Click : '. $ordercountratio.'%';
                ?>
            </td>
            <td>
                <?php
                if($product['slug']) {
                    $shareUrl = base_url($product['slug']);
                }else{
                    $shareUrl = $product['public_page'];
                }
                ?>
                <div class="form-group m-0 show-tiny-link">
                    <div class="copy-input input-group">
                        <input readonly="readonly" value="<?= $shareUrl ?>" class="form-control input-form-url-<?= $product['form_id'] ?>">
                        
                        <button type="button" copyToClipboard="<?= $shareUrl ?>" class="input-group-addon mr-1" >
                            <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                        </button>
                        <button type="button" class="btn btn-sm btn-dark btn-model-slug mr-1" data-type="form" data-related-id="<?= $product['form_id'] ?>" data-input-class="input-form-url-<?= $product['form_id'] ?>"><i class="fa fa-cog"></i></button>

                        <a href="<?= $product['public_page'] ?>" class="btn btn-sm btn-success btn-group-markettools mr-1" target='_black'><i class="fa fa-globe" aria-hidden="true"></i></a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-info btn-group-markettools mr-1" onclick="generateCodeForm(<?php echo $product['form_id'];?>,this);" ><i class="fa fa-code" aria-hidden="true"></i></a>
                        
                        <a class="get-downloads btn btn-sm btn-secondary btn-group-markettools mr-1" href="javascript:void(0)" onclick="downloadCode(this, <?= $product['form_id'] ?>, 'form')"><i class="fa fa-download" aria-hidden="true"></i></a>

                         <a href="javascript:void(0)" class="btn-secondary btn-group-markettools btn btn-sm btn-info qrcode "  data-id="<?= $shareUrl ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="form-group m-0 show-mega-link d-none">
                    <div class="copy-input input-group">
                        <input readonly="readonly" value="<?= $shareUrl ?>?id=<?= $userdetails['id'] ?>" class="form-control input-form-url-<?= $product['form_id'] ?>" data-addition-url="?id=<?= $userdetails['id'] ?>">
                        <button type="button" copyToClipboard="<?= $shareUrl ?>?id=<?= $userdetails['id'] ?>" class="input-group-addon mr-1" >
                            <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                        </button>
                        <button type="button" class="btn btn-sm btn-dark btn-model-slug mr-1" data-type="form" data-related-id="<?= $product['form_id'] ?>" data-input-class="input-form-url-<?= $product['form_id'] ?>"><i class="fa fa-cog"></i></button>

                        <a href="<?= $product['public_page'] ?>" class="btn btn-sm btn-success btn-group-markettools mr-1" target='_black'><i class="fa fa-globe" aria-hidden="true"></i></a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-info btn-group-markettools mr-1" onclick="generateCodeForm(<?php echo $product['form_id'];?>,this);" ><i class="fa fa-code" aria-hidden="true"></i></a>
                        
                        <a class="get-downloads btn btn-sm btn-secondary btn-group-markettools mr-1" href="javascript:void(0)" onclick="downloadCode(this, <?= $product['form_id'] ?>, 'form')"><i class="fa fa-download" aria-hidden="true"></i></a>

                             <a href="javascript:void(0)" class="btn-secondary btn-group-markettools btn btn-sm btn-info qrcode "  data-id="<?= $shareUrl ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                        
                    </div>
                </div>
            </td>
            <td>
                <span class="btn btn-md btn-primary" data-social-share data-share-url="<?= $shareUrl ?>" data-share-title="<?= $product['title'];?>" data-share-desc="<?= $product['description'];?>"><i class="fa fa-share-alt" aria-hidden="true"></i></span>
            </td>
        </tr>
        <tr class="detail-tr">
            <td colspan="100%">
                <div>
                    <ul>
                        <li><b><?= __('admin.coupon_code'); ?>: </b> <span><?= $product['coupon_code'] ? $product['coupon_code'] : __('user.n_a') ?></span></li>
                        <li><b><?= __('admin.coupon_use'); ?>: </b> <span><?= ($product['coupon_name'] ? $product['coupon_name'] : '-').' / '.$product['count_coupon'] ?></span></li>
                        <li><b><?= __('admin.sales_commission'); ?>: </b> <span><?= (int)$product['count_commission'].' / '.c_format($product['total_commission']) ?></span></li>
                        <li><b><?= __('admin.clicks_commission'); ?>: </b> <span><?= (int)$product['commition_click_count'].' / '.c_format($product['commition_click']); ?></span></li>
                        <li><b><?= __('admin.total_commission'); ?>: </b> <span><?= c_format($product['total_commission']+$product['commition_click']); ?></span></li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php } else if(isset($product['is_product'])) { ?>
        <?php 
        if($product['is_campaign_product']) {
            $af_id = _encrypt_decrypt($userdetails['id']."-".$product['product_id']);
            $productLink = addParams($product['product_url'],"af_id",$af_id);
        } else {
            $productLink = base_url('store/'. base64_encode($userdetails['id']) .'/product/'.$product['product_slug'] );
        }
        ?>
        <tr class="<?= $display_class ?>">
            <td class="text-center">                                                    
                <button type="button" class="toggle-child-tr"><i class="fa fa-plus"></i></button>
            </td>
            <td><img width="50px" height="50px" src="<?php echo base_url('assets/images/product/upload/thumb/'. $product['product_featured_image']) ?>" ></td>
            <td class="max-width-300"><?php echo $product['product_name'];?></td>
            <td>
                <?php 

                if($product['seller_id']){
                    $seller = $this->Product_model->getSellerFromProduct($product['product_id']);
                    $seller_setting = $this->Product_model->getSellerSetting($seller->user_id);

                    $commnent_line = "";
                    if($seller->affiliate_sale_commission_type == 'default'){ 
                        if($seller_setting->affiliate_sale_commission_type == ''){
                            $commnent_line .= __('user.warning_default_commission_not_set');
                        }
                        else if($seller_setting->affiliate_sale_commission_type == 'percentage'){
                            if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $seller_setting->affiliate_commission_value)
                                $affiliate_commission_value = $userComission['value'];
                            else
                                $affiliate_commission_value = (float) $seller_setting->affiliate_commission_value;

                            $commnent_line .= $affiliate_commission_value .'%';
                        }
                        else if($seller_setting->affiliate_sale_commission_type == 'fixed'){
                            $commnent_line .= c_format($seller_setting->affiliate_commission_value);
                        }
                    } else if($seller->affiliate_sale_commission_type == 'percentage'){
                        if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $seller->affiliate_commission_value)
                            $affiliate_commission_value = $userComission['value'];
                        else
                            $affiliate_commission_value = (float) $seller->affiliate_commission_value;

                        $commnent_line .=  $affiliate_commission_value .'%';
                    } else if($seller->affiliate_sale_commission_type == 'fixed'){
                        $commnent_line .= c_format($seller->affiliate_commission_value);
                    } 

                    echo '<b>'.__('user.you_will_get').'</b> : ' .$commnent_line.' '.__('user.per_sale');

                    $commnent_line = "";
                    if($seller->affiliate_click_commission_type == 'default'){ 
                        $commnent_line .= c_format($seller_setting->affiliate_click_amount) ." ".__('user.per')." ". (int)$seller_setting->affiliate_click_count ." ".__('user.clicks');
                    } else{
                        $commnent_line .= c_format($seller->affiliate_click_amount) ." ".__('user.per')." ". (int)$seller->affiliate_click_count ." ".__('user.clicks');
                    } 
                    echo '<br><b>'.__('user.you_will_get').'</b> : ' .$commnent_line;

                    ?>


                    <div>
                        <?php 
                        if($product['product_recursion_type']){
                            if($product['product_recursion_type'] == 'custom'){
                                if($product['product_recursion'] != 'custom_time'){
                                    echo '<b>'. __('user.recurring') .' </b> : ' . __('user.'.$product['product_recursion']);
                                } else {
                                    echo '<b>'. __('user.recurring') .' </b> : '. timetosting($product['recursion_custom_time']);
                                }
                            } else{
                                if($pro_setting['product_recursion'] == 'custom_time' ){
                                    echo '<b>'. __('user.recurring') .' </b> : '. timetosting($pro_setting['recursion_custom_time']);
                                } else {
                                    echo '<b>'. __('user.recurring') .' </b> : '. __('user.'.$pro_setting['product_recursion']);
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php

                } else { ?>

                    <b><?= __('user.you_will_get') ?></b> : 
                    <?php
                    if($product['product_commision_type'] == 'default'){
                        if($default_commition['product_commission_type'] == 'percentage'){
                            if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $default_commition['product_commission'])
                                $product_commission = $userComission['value'];
                            else
                                $product_commission = $default_commition['product_commission'];

                            echo $product_commission. "% ".__('user.per_sale');
                        } else {
                            echo c_format($default_commition['product_commission']) ." ".__('user.per_sale');
                        }
                    } else if($product['product_commision_type'] == 'percentage'){
                        if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $product['product_commision_value'])
                            $product_commision_value = $userComission['value'];
                        else
                            $product_commision_value = $product['product_commision_value'];

                        echo $product_commision_value. "% ".__('user.per_sale');
                    } else{
                        echo c_format($product['product_commision_value']) ." ".__('user.per_sale');
                    }
                    ?>
                    <br><b><?= __('user.you_will_get') ?></b> :
                    <?php
                    if($product['product_click_commision_type'] == 'default'){
                        echo c_format($default_commition['product_ppc']) ." ".__('user.per')." {$default_commition['product_noofpercommission']} ".__('user.click');   
                        echo "</small>";
                    } else{
                        echo c_format($product['product_click_commision_ppc']) ." ".__('user.per')." {$product['product_click_commision_per']} ".__('user.click');
                    }
                    ?>

                    <div>
                        <?php 
                        if($product['product_recursion_type']){
                            if($product['product_recursion_type'] == 'custom'){
                                if($product['product_recursion'] != 'custom_time'){
                                    echo '<b>'. __('user.recurring') .' </b> : ' . __('user.'.$product['product_recursion']);
                                } else {
                                    echo '<b>'. __('user.recurring') .' </b> : '. timetosting($product['recursion_custom_time']);
                                }
                            } else{
                                if($pro_setting['product_recursion'] == 'custom_time' ){
                                    echo '<b>'. __('user.recurring') .' </b> : '. timetosting($pro_setting['recursion_custom_time']);
                                } else {
                                    echo '<b>'. __('user.recurring') .' </b> : '. __('user.'.$pro_setting['product_recursion']);
                                }
                            }
                        }
                        ?>
                    </div>
                <?php } ?>
            </td>
            <td class="text-center">
                <?= $product['view_statistics'] ?>
            </td>
            <td>
                <?php 
                $ordercountratio=0;
                if($product['view_statistics']>0)
                    $ordercountratio=$product['all_order_count']*100/$product['view_statistics'];
                $ordercountratio = is_float($ordercountratio) ==1 ? number_format((float)$ordercountratio, 2, '.', '') : $ordercountratio;
                echo __('user.sale') . ' : '.$ordercountratio .'%<br/>';
                ?>

                <?php 
                $ordercountratio=0;
                $comissionclickcount=(int)$product['all_commition_click_count'] ;
                if($product['view_statistics']>0)
                    $ordercountratio=$comissionclickcount*100/$product['view_statistics'];
                $ordercountratio = is_float($ordercountratio) ==1 ? number_format((float)$ordercountratio, 2, '.', '') : $ordercountratio;
                echo __('user.click') . ' : '.$ordercountratio .'%';
                ?>
            </td>
            <td>
                <?php
                if($product['slug']) {
                    $shareUrl = base_url($product['slug']);
                }else{
                    $shareUrl = $productLink;
                }
                ?>
                <div class="form-group m-0 show-tiny-link">
                    <div class="copy-input input-group">
                        <input readonly="readonly" value="<?= $shareUrl ?>" class="form-control input-product-url-<?= $product['product_id'] ?>">
                       
                        <button type="button" copyToClipboard="<?= $shareUrl ?>" class="input-group-addon mr-1" >
                            <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                        </button>
                        
                        <button type="button" class="btn btn-sm btn-dark btn-model-slug mr-1" data-type="product" data-related-id="<?= $product['product_id'] ?>" data-input-class="input-product-url-<?= $product['product_id'] ?>"><i class="fa fa-cog"></i></button>

                        <a href="<?= $productLink ?>" class="btn btn-sm btn-success btn-group-markettools mr-1" target='_black'><i class="fa fa-globe" aria-hidden="true"></i></a>

                        <a href="javascript:void(0);" class="btn btn-sm btn-info btn-group-markettools mr-1" onclick="generateCode(<?php echo $product['product_id'];?>,this);" ><i class="fa fa-code" aria-hidden="true"></i></a>
                        
                        <a class="get-downloads btn btn-sm btn-secondary btn-group-markettools mr-1" href="javascript:void(0)" onclick="downloadCode(this, <?= $product['product_id'] ?>, 'product')"><i class="fa fa-download" aria-hidden="true"></i></a>

                         <a href="javascript:void(0)" class="btn-secondary btn-group-markettools btn btn-sm btn-info qrcode "  data-id="<?= $shareUrl ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="form-group m-0 show-mega-link d-none">
                    <div class="copy-input input-group">
                        <input readonly="readonly" value="<?= $shareUrl ?>?id=<?= $userdetails['id'] ?>" class="form-control input-product-url-<?= $product['product_id'] ?>" data-addition-url="?id=<?= $userdetails['id'] ?>">
                        <button type="button" copyToClipboard="<?= $shareUrl ?>?id=<?= $userdetails['id'] ?>" class="input-group-addon mr-1" >
                            <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                        </button>
                        <button type="button" class="btn btn-sm btn-dark btn-model-slug mr-1" data-type="product" data-related-id="<?= $product['product_id'] ?>" data-input-class="input-product-url-<?= $product['product_id'] ?>"><i class="fa fa-cog"></i></button>

                        <a href="<?= $productLink ?>" class="btn btn-sm btn-success btn-group-markettools mr-1" target='_black'><i class="fa fa-globe" aria-hidden="true"></i></a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-info btn-group-markettools mr-1" onclick="generateCode(<?php echo $product['product_id'];?>,this);" ><i class="fa fa-code" aria-hidden="true"></i></a>
                        
                        <a class="get-downloads btn btn-sm btn-secondary btn-group-markettools mr-1" href="javascript:void(0)" onclick="downloadCode(this, <?= $product['product_id'] ?>, 'product')"><i class="fa fa-download" aria-hidden="true"></i></a>

                         <a href="javascript:void(0)" class="btn-secondary btn-group-markettools btn btn-sm btn-info qrcode "  data-id="<?= $shareUrl ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                    </div>
                </div>
            </td>
            <td>
                <span class="btn btn-md btn-primary" data-social-share data-share-url="<?= $shareUrl ?>" data-share-title="<?= $product['product_name'];?>" data-share-desc="<?= $product['product_short_description'];?>"><i class="fa fa-share-alt" aria-hidden="true"></i></span>
            </td>
        </tr>
        <tr class="detail-tr">
            <td colspan="100%">
                <div>
                    <ul>
                        <li><b><?= __('admin.price') ?> :</b><span><?php echo c_format($product['product_price']); ?></span></li>
                        <li><b><?= __('admin.sku') ?> :</b><span><?php echo $product['product_sku'];?></span></li>
                        <li>
                            <b><?= __('admin.sales_/_commission') ?> :</b>
                            <span>
                                <?php echo $product['order_count'];?> / 
                                <?php echo c_format($product['commission']) ;?>
                            </span>
                        </li>
                        <li>
                            <b><?= __('admin.clicks_/_commission') ?> :</b>
                            <span>
                                <?php echo (int)$product['commition_click_count'];?> / <?php echo c_format($product['commition_click']) ;?>
                            </span>
                        </li>
                        <li>
                            <b><?= __('admin.total') ?> :</b>
                            <span>
                                <?php echo c_format((float)$product['commition_click'] + (float)$product['commission']); ?>
                            </span>
                        </li>
                        <li><b><?= __('admin.display') ?> :</b> <span><?= $product['on_store'] == '1' ? __('user.yes') : __('user.no') ?></span></li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php } else{ ?>

        <?php 
        $productLink = base_url('store/'. base64_encode($userdetails['id']) .'/product/'.$product['product_slug'] );
        ?>

        <tr class="<?= $display_class ?>">
            <td><button type="button" class="toggle-child-tr"><i class="fa fa-plus"></i></button></td>
            <td>
                <img width="50px" height="50px" src="<?php echo base_url('assets/images/product/upload/thumb/'. $product['featured_image']) ?>" >
            </td>
            <td class="max-width-300"><?= $product['name'] ?></td>
            <td>
                <div class="wallet-toggle ">
                    <div class="<?= $product['_tool_type'] == 'program' && $product['sale_status'] ? '' : 'd-none' ?>">
                        <?php 
                        $comm = '';
                        if($product['commission_type'] == 'percentage'){
                            if($award_level_status == 1 && $userComission['status'] && $userComission['value'] && $userComission['value'] < $product['commission_sale'])
                                $commission_sale = $userComission['value'];
                            else
                                $commission_sale = $product['commission_sale'];

                            $comm = $commission_sale.'%'; 
                        } else if($product['commission_type'] == 'fixed'){ 
                            $comm = c_format($product['commission_sale']); 
                        }
                        echo "<b>". __('user.you_will_get')." :</b><small> {$comm} ".__('user.per_sale')."</small><br>"
                        ?>
                    </div>
                </div>
                
                <div class="wallet-toggle ">
                    <div class="<?= $product['_tool_type'] == 'program' && $product['click_status'] ? '' : 'd-none' ?>">
                        <?php 
                        echo "<b>".__('user.you_will_get')." :</b><small> ";
                        echo c_format($product["commission_click_commission"]). " ".__('user.per')." ". $product['commission_number_of_click'] ." ".__('user.clicks')." </small><br>";
                        ?>
                    </div>
                </div>
                
                <div class="wallet-toggle ">
                    <div class="<?= $product['_tool_type'] == 'general_click' ? '' : 'd-none' ?>">
                        <?php 
                        echo "<b>".__('user.you_will_get')." :</b><small> ";
                        echo c_format($product["general_amount"]). " ".__('user.per')." ". $product['general_click'] ." ".__('user.clicks')." </small><br>";
                        ?>
                    </div>
                </div>
                <div class="wallet-toggle ">
                    <div class="<?= ($product['_tool_type'] == 'action' || $product['_tool_type'] == 'single_action') ? '' : 'd-none' ?>">
                        <?php 
                        echo "<b>".__('user.you_will_get')." :</b><small> ";
                        echo c_format($product["action_amount"]). " ".__('user.per')." ". $product['action_click'] ." ".__('user.actions')." </small><br>"; 
                        ?>
                    </div>
                </div>

                

                <?php 
                if($product['recursion']){
                    if($product['recursion'] != 'custom_time'){
                        echo '<b>'. __('user.recurring') .' </b> : ' . __('user.'.$product['recursion']);
                    } else {
                        echo '<b>'. __('user.recurring') .' </b> : '. timetosting($product['recursion_custom_time']);
                    }
                }
                ?>  
            </td>
            <td class="text-center"><?= $product['total_trigger_count'] ?></td>
            <td>
                <div class="">

                    <?php 
                    if($product['_tool_type'] == 'program' && $product['sale_status'])  
                    {
                        $conversionratio=0;
                        $totalratiocount=(int)$product['all_sale_count'];
                        if($product['total_trigger_count']>0)
                        $conversionratio=(int)($totalratiocount*100/$product['total_trigger_count']);
                        $conversionratio = is_float($conversionratio) ==1 ? number_format((float)$conversionratio, 2, '.', '') : $conversionratio;
                        echo __('user.sale'). ' : '. $conversionratio . '%<br/>';
                    }
                      if($product['_tool_type'] == 'action' || $product['_tool_type'] == 'single_action')
                    {
                        $conversionratio=0;
                        $totalratiocount=(int)$product['all_action_click_count'];
                        if($product['total_trigger_count']>0)
                            $conversionratio=(int)($totalratiocount*100/$product['total_trigger_count']);
                        $conversionratio = is_float($conversionratio) ==1 ? number_format((float)$conversionratio, 2, '.', '') : $conversionratio;
                        echo __('user.action'). ' : '. $conversionratio . '%<br/>';
                        
                    }
                    if($product['_tool_type'] == 'general_click')
                    {
                        $conversionratio=0;
                        $totalratiocount=(int)$product['all_general_click_count'];
                        if($product['total_trigger_count']>0)
                            $conversionratio=(int)($totalratiocount*100/$product['total_trigger_count']);
                        $conversionratio = is_float($conversionratio) ==1 ? number_format((float)$conversionratio, 2, '.', '') : $conversionratio;
                        echo __('user.click'). ' : '. $conversionratio . '%<br/>';
                    }
                    if($product['_tool_type'] == 'program' && $product['click_status']) 
                    {
                        $conversionratio=0;
                        $totalratiocount=(int)$product['all_click_count'];
                        if($product['total_trigger_count']>0)
                            $conversionratio=(int)($totalratiocount*100/$product['total_trigger_count']);
                        $conversionratio = is_float($conversionratio) ==1 ? number_format((float)$conversionratio, 2, '.', '') : $conversionratio;
                        echo __('user.product_click'). ' : '. $conversionratio . '%<br/>';
                    }
                    
                    ?>
                </div>
            </td>
            <td>
                <?php
                if($product['slug']) {
                    $shareUrl = base_url($product['slug']);
                }else{
                    $shareUrl = $product['redirectLocation'][0];
                }
                ?>
                <div class="form-group m-0 show-tiny-link">
                    <div class="copy-input input-group">
                        <input readonly="readonly" value="<?= $shareUrl ?>" class="form-control input-<?= $product['_tool_type'] ?>-url-<?= $product['id'] ?>">
                        <button type="button" copyToClipboard="<?= $shareUrl ?>" class="input-group-addon mr-1" >
                            <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                        </button>
                        <button type="button" class="btn btn-sm btn-dark btn-model-slug mr-1" data-type="<?= $product['_tool_type'] ?>" data-related-id="<?= $product['id'] ?>" data-input-class="input-<?= $product['_tool_type'] ?>-url-<?= $product['id'] ?>"><i class="fa fa-cog"></i></button>

                       

                        <a href="javascript:void(0)" class="get-terms btn btn-sm btn-warning btn-group-markettools mr-1"  data-id="<?= $product['id'] ?>"><i class="fa fa-info" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="get-code btn btn-sm btn-info btn-group-markettools mr-1"  data-id="<?= $product['id'] ?>"><i class="fa fa-code" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="get-downloads btn btn-sm btn-secondary btn-group-markettools mr-1" onclick="downloadCode(this, <?= $product['id'] ?>, 'tool')"><i class="fa fa-download" aria-hidden="true"></i></a>

                         <a href="javascript:void(0)" class="btn-secondary btn-group-markettools btn btn-sm btn-info qrcode "  data-id="<?= $shareUrl ?>"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="form-group m-0 show-mega-link d-none">
                    <div class="copy-input input-group">
                        <input readonly="readonly" value="<?= $shareUrl ?>?id=<?= $userdetails['id'] ?>" class="form-control input-<?= $product['_tool_type'] ?>-url-<?= $product['id'] ?>" data-addition-url="?id=<?= $userdetails['id'] ?>">
                        <button type="button" copyToClipboard="<?= $shareUrl ?>?id=<?= $userdetails['id'] ?>" class="input-group-addon mr-1" >
                            <img src="<?= base_url('assets/template/images/user-copy-icon.png') ?>" alt="<?= __('admin.copy') ?>">
                        </button>
                        <button type="button" class="btn btn-sm btn-dark btn-model-slug mr-1" data-type="<?= $product['_tool_type'] ?>" data-related-id="<?= $product['id'] ?>" data-input-class="input-<?= $product['_tool_type'] ?>-url-<?= $product['id'] ?>"><i class="fa fa-cog"></i></button>

                        <a href="javascript:void(0)" class="get-terms btn btn-sm btn-warning btn-group-markettools mr-1"  data-id="<?= $product['id'] ?>"><i class="fa fa-info" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="get-code btn btn-sm btn-info btn-group-markettools mr-1"  data-id="<?= $product['id'] ?>"><i class="fa fa-code" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="get-downloads btn btn-sm btn-secondary btn-group-markettools" onclick="downloadCode(this, <?= $product['id'] ?>, 'tool')"><i class="fa fa-download" aria-hidden="true"></i></a>
                    </div>
                </div>
            </td>
            <td class="-d-sm-table-cell -d-none">
                <span class="btn btn-md btn-primary" data-social-share data-share-url="<?= $shareUrl ?>" data-share-title="<?= $product['name'];?>"><i class="fa fa-share-alt" aria-hidden="true"></i></span>
            </td>
        </tr>
        <tr class="detail-tr">
            <td colspan="100%">
                <div>
                    <ul>

                        <?php 
                        if($product['_tool_type'] == 'program' && $product['sale_status']){ 
                            echo "<li><b>".__('user.sale_count')." :</b> <span>". (int)$product['total_sale_count'] ."</span></li>";
                            echo "<li><b>".__('user.sale_amount')." :</b> <span>". $product['total_sale_amount'] ."</span></li>";
                        }

                        if($product['_tool_type'] == 'program' && $product['click_status']){
                            echo "<li><b>".__('user.click_count')." :</b> <span>". (int)$product['total_click_count'] ."</span></li>";
                            echo "<li><b>".__('user.click_amount')." :</b> <span>". $product['total_click_amount'] ."</span></li>";
                        }

                        if($product['_tool_type'] == 'general_click'){
                            echo "<li><b>".__('user.general_count')." :</b> <span>". (int)$product['total_general_click_count'] ."</span></li>";
                            echo "<li><b>".__('user.general_amount')." :</b> <span>". $product['total_general_click_amount'] ."</span></li>";
                        }

                        if($product['_tool_type'] == 'action' || $product['_tool_type'] == 'single_action'){
                            echo "<li><b>".__('user.action_count')." :</b> <span>". (int)$product['total_action_click_count'] ."</span></li>";
                            echo "<li><b>".__('user.action_amount')." :</b> <span>". $product['total_action_click_amount'] ."</span></li>";
                        }
                        ?>
                    </ul>
                </div>
            </td>
        </tr>
    <?php } ?>
<?php } ?>