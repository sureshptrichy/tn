<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));

if (count($reviews)) { ?>
<table class="table table-striped table-hover">
	<tr>
		<th>Name</th>
		<th>Description</th>
		<th>Created On</th>
		<th>Due Date</th>
		<th>Status</th>
	</tr>
<?php
	foreach ($reviews as $id => $review) {
		$status = 'Open';
		$showEdit = true;
		if ($review->locked === 1) {
			$status = 'LOCKED';
			$showEdit = false;
		}
		?><tr>
			<td><?php echo $review->name; ?><?php if (true === $showEdit && user_has('editReviewcycle')) {?>
					<ul class="list-inline table-action">
						<li><a href="<?php echo $currentUrl; ?>edit/<?php echo $id; ?>/1" class="label label-default">Edit</a></li>
						<li><a href="<?php echo $currentUrl; ?>delete/<?php echo $id; ?>" class="label label-danger">Delete</a></li>
					</ul>
			<?php } ?></td>
			<td><?php echo parse($review->description); ?></td>
			<td><?php echo date('M d, Y', $review->created); ?></td>
			<td><?php echo date('M d, Y', $review->due); ?></td>
			<td><?php echo $status; ?></td>
		</tr><?php
	} ?>
</table>
<?php
}
?>
<?php if (user_has('addReviewcycle')) { ?><a href="<?php echo $currentUrl; ?>add" class="btn btn-primary">New Review</a><?php } ?>
