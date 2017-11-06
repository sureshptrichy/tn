<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>

<?php if(count($selfReviewForms) > 0) { ?>
<table class="table table-striped table-hover performance-reviews">
	<tr>
		<th colspan="3"><h3>Self Reviews</h3></th>
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
		<td><?php if ($myForm['answer_date'] > 0){ ?><i class="fa fa-check"></i><?php } else { ?> Not Submitted Yet for manager review<?php } ?></td>
		<td><a href="<?php echo $currentUrl; ?>selfreview/<?php echo $myForm['review_id'];?>">View</a></td>
	</tr>
<?php }?>
</table>
<?php } else { ?>
<h4>You don't have any review forms now to do a self review.</h4>
<?php } ?>
<?php if(count($managerReviewForms) > 0) { ?>
<table class="table table-striped table-hover performance-reviews">
	<tr>
		<th colspan="4"><h3>Manager Reviews</h3></th>
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
		<td><?php if ($userForm['manager_answer_date'] > 0){?><i class="fa fa-check"></i><?php } else { ?> Not Reviewed Yet.<?php } ?></td>
		<td><a href="<?php echo $currentUrl; ?>mgrreview/<?php echo $userForm['review_id'];?>">View</a></td>
	</tr>
<?php }?>
</table>
<?php } ?>