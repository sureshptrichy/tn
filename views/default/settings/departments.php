<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
if (count($departments) < 1) {
	?><p><em>There are no departments.</em></p><?php
} else {
	?><div class="table-responsive"><table class="table table-striped table-hover tablesorter">
		<thead>	
		<tr>
			<th>Name</th>
			<th>Division</th>
		</tr>
		</thead>
			<tbody>
		<?php foreach ($departments as $id => $department) {?>
			<tr>
				<td>
					<p class="lead"><?php echo $department['name']; ?></p>
					<ul class="list-inline table-action">
					<?php if (($currentUser->acl->has('editDefaultDepartment') AND $department['default'] == '1') || ($currentUser->acl->has('editDepartment') AND $department['default'] == '0')){?>
						<li><a href="<?php echo $currentUrl; ?>edit/<?php echo $id; ?>" class="label label-default">Edit</a></li>
					<?php }?>
					<?php if (($currentUser->acl->has('deleteDefaultDepartment') AND $department['default'] == '1') || ($currentUser->acl->has('deleteDepartment') AND $department['default'] == '0')){?>
						<li><a href="<?php echo $currentUrl; ?>delete/<?php echo $id; ?>" class="label label-danger">Delete</a></li>
					<?php }?>					
					</ul>
				</td>
				<td>
					<p class="text-primary"><?php echo $department['division_name']; ?><?php if ($department['default']) { ?> (<span class="text-success">Default</span>)<?php } ?></p>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>

<?php
}
?>
<?php if ($currentUser->acl->has('addDepartment') || $currentUser->acl->has('addDefaultDepartment')) { ?><a href="<?php echo $currentUrl; ?>add" class="btn btn-primary">New Department</a><?php } ?>
