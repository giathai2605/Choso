<?php 
if(count($reviews)==0)
{
?>	<tr style="background: #fff">
		<td colspan="8" >		
		 <div class="text-center">
		    <img class="img-responsive" src="<?php echo base_url(); ?>assets/vertical/assets/images/no-data-2.png" style="margin-top:100px; width: 100px; height: 100px;">
		    <h3 class="m-t-40 text-center text-muted"><?= __('user.no_reviews') ?></h3>
		 </div>
		</div>
	</td>
	</tr>
<?php

}
else
{

foreach($reviews as $review){ ?>
<tr><td>
      <div class="tooltip-copy">
        <img width="50px" height="50px" src="<?php echo $review['avatar']!="" ? base_url('assets/images/users/'. $review['avatar']) : base_url('assets/images/no-user_image.jpg') ?>" ><br>
      </div>
   </td>
   <td><?= $review['firstname'] ?></td>
   <td><?= $review['lastname'] ?></td>
   <td><?= $review['product_name'] ?></td>
   <td><?= $review['rating_comments'] ?></td>
   <td><?= $review['rating_number'] ?></td>
   <td><?= dateGlobalFormat($review['rating_created']) ?></td>  
   <td>
      <?php if($review['rating_created_by']==$user_id){ ?>
      <a href="<?= base_url('usercontrol/manage_review/'.$review['rating_id'])  ?>" class="btn btn-primary edit-button"><?= __("user.edit") ?></a>
      <?php }else {?>
      <a href="#" class="btn btn-primary edit-button disabled"  ><?= __("user.edit") ?></a>
      <?php }?>
      <a href="<?= base_url('usercontrol/deleteReview/'.$review['rating_id']);?>" class="btn btn-danger delete-button" onclick="return onDeleteReview(<?= $review['rating_id'] ?>);" ><?= __("user.delete") ?></a>
   </td>
</tr>
<?php } 
}?>
<script type="text/javascript">
	function onDeleteReview($rating_id)
	{
		if(!confirm("<?= __('user.are_you_sure') ?>")) 
		return false;
		else
		return true;	 
	}
</script>