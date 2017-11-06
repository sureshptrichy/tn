<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>

<table class="table table-striped table-hover performance-reviews">
	<tr>
		<th colspan="3"><h3>Self Review</h3></th>
	</tr>
	<tr>
		<th>Review Form</th>
		<th>Completed</th>
		<th>Action</th>
	</tr>
<?php 
	foreach($selfReviewForms as $myForm){
		?>
	<tr>
		<td><?php echo $myForm['review_name']; ?></td>
		<td><?php if ($myForm['answer_date'] > 0){?><i class="fa fa-check"></i><?php }?></td>
		<td><a href="<?php echo $currentUrl; ?>selfreview/<?php echo $myForm['review_id'];?>">View</a></td>
	</tr>
<?php }?>
</table>

<table class="table table-striped table-hover performance-reviews">
	<tr>
		<th colspan="4"><h3>Manager Review</h3></th>
	</tr>
	<tr>
		<th>User</th>
		<th>Review Form</th>
		<th>Completed</th>
		<th>Action</th>
	</tr>
<?php 
	foreach($managerReviewForms as $userForm){?>
	<tr>
		<td><?php echo $userForm['review_for']; ?></td>
		<td><?php echo $userForm['review_name']; ?></td>
		<td><?php if ($userForm['answer_date'] > 0){?><i class="fa fa-check"></i><?php }?></td>
		<td><a href="<?php echo $currentUrl; ?>mgrreview/<?php echo $userForm['review_id'];?>">View</a></td>
	</tr>
<?php }?>
</table>