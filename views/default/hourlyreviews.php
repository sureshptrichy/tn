<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>

<table class="table table-striped table-hover performance-reviews">
	<tr>
		<th colspan="5"><h3>Hourly Reviews</h3></th>
	</tr>
	<tr>
		<th>User</th>
		<th>Position</th>
		<th>Department</th>
		<th>Review Form</th>
		<th>Completed</th>
	</tr>
<?php 
	foreach($myForms as $myForm){
		?>
	<tr>
		<td><?php echo $myForm->hourly_name; ?></td>
		<td><?php echo $myForm->hourly_position; ?></td>
		<td><?php echo $myForm->hourly_department; ?></td>
		<td><a href="<?php echo $currentUrl; ?>review/<?php echo $myForm->id; ?>"><?php echo $myForm->reviewform_name; ?></a></td>
		<td><?php if ($myForm->completed_on > 0){?><i class="fa fa-check"></i><?php }?></td>
	</tr>
<?php }?>
</table>
