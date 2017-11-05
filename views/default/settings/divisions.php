<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
if (count($divisions) < 1) {
	?><p><em>There are no divisions.</em></p><?php
} else {
	?><div class="table-responsive"><table class="table table-striped table-hover tablesorter">
	<thead>		
	<tr>
			<th>Name</th>
			<th>Property</th>
		</tr>
			</thead>
			<tbody>
		<?php foreach ($divisions as $id => $division) { ?>
			<tr>
				<td>
					<p class="lead"><?php echo $division['name']; ?></p>
					<ul class="list-inline table-action">
					<?php if (($currentUser->acl->has('editDefaultDivision') AND $division['default'] == '1') || ($currentUser->acl->has('editDivision') AND $division['default'] == '0')){?>
						<li><a href="<?php echo $currentUrl; ?>edit/<?php echo $id; ?>" class="label label-default">Edit</a></li>
					<?php }?>
					<?php if (($currentUser->acl->has('deleteDefaultDivision') AND $division['default'] == '1') || ($currentUser->acl->has('deleteDivision') AND $division['default'] == '0')){?>
						<li><a href="<?php echo $currentUrl; ?>delete/<?php echo $id; ?>" class="label label-danger">Delete</a></li>
					<?php }?>
					</ul>
				</td>
				<td>
					<?php if ($division['default']) { ?><p class="text-success">Default</p><?php } else { echo '<p class="text-primary">'.$division['property_name'].'</p>'; } ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>

<?php
}
?>
<?php if ($currentUser->acl->has('addDivision') || $currentUser->acl->has('addDefaultDivision')) { ?><a href="<?php echo $currentUrl; ?>add" class="btn btn-primary">New Division</a><?php } ?>
