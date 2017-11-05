<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>
<div class="matrixes">
<?php
	if (isset($matrixes)){ 
		foreach($matrixes as $matrix){
			echo $matrix;
		}
	}
?>
</div>
<table class="table table-striped table-hover performance-reviews">
	<tr>
		<th colspan="3"><h3>My Forms</h3></th>
	</tr>
	<tr>
		<th>User</th>
		<th>Review Form</th>
		<th>Completed</th>
	</tr>
<?php 
	foreach($myForms as $myForm){
		?>
	<tr>
		<td><?php echo $myForm['user_for_name']; ?></td>
		<td><a href="<?php echo $currentUrl; ?>review/<?php echo $myForm['reviewcycle_id'];?>/<?php echo $myForm['compiledform_id'];?>/<?php echo $myForm['user_for_id'];?>"><?php echo $myForm['compiledform_name']; ?></a></td>
		<td><?php if ($myForm['answer_date'] > 0){?><i class="fa fa-check"></i><?php }?></td>
	</tr>
<?php }?>
</table>
<?php 
if (!empty($userReviewForms)){?>
<table class="table table-striped table-hover performance-reviews">
	<tr>
		<th colspan="3"><h3>User Forms</h3></th>
	</tr>
	<tr>
		<th>User</th>
		<th>Review Form</th>
		<th>Completed</th>
	</tr>
<?php 
	foreach($userReviewForms as $userForms){
		foreach($userForms as $userForm){?>
		<tr>
			<td><?php echo $userForm['user_for_name']; ?></td>
			<td><a href="<?php echo $currentUrl; ?>review/<?php echo $userForm['reviewcycle_id'];?>/<?php echo $userForm['compiledform_id'];?>/<?php echo $userForm['user_for_id'];?>"><?php echo $userForm['compiledform_name']; ?></a></td>
			<td class="peerSelect"><?php if ($userForm['answer_date'] > 0){?><i class="fa fa-check"></i><?php }?></td>
		</tr>
	<?php }?>
<?php }}?>
</table>