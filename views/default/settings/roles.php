<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
if (count($roles) < 1) {
	?><p><em>There are no roles.</em></p><?php
} else {
	?><div class="table-responsive"><table class="table table-striped table-hover tablesorter">
	<thead>
	<tr>
		<th>Name</th>
	</tr>
	</thead>
			<tbody>
	<?php foreach ($roles as $id => $role) { ?>
	<tr>
		<td nowrap width="100%">
			<p class="lead"><?php echo $role; ?> <span class="badge"><?php echo count($permissions[$id]); ?></span></p>
			<ul class="list-inline table-action">
				<?php if ($currentUser->acl->has('editRole')) { ?><li><a href="<?php echo $currentUrl; ?>edit/<?php echo $id; ?>" class="label label-default">Edit</a></li><?php } ?>
				<!--  <?php if ($currentUser->acl->has('addRole')) { ?><li><a href="<?php echo $currentUrl; ?>copy/<?php echo $id; ?>" class="label label-primary">Copy</a></li><?php } ?> -->
				<!--  <?php if ($currentUser->acl->has('deleteRole') && $role != 'Super User' && $role != 'Anonymous') { ?><li><a href="<?php echo $currentUrl; ?>delete/<?php echo $id; ?>" class="label label-danger">Delete</a></li><?php } ?> -->
			</ul>
		</td>
	</tr>
	<?php } ?>
	</tbody>
	</table></div>

<?php
}
?>
<?php if ($currentUser->acl->has('addRole')) { ?><a href="<?php echo $currentUrl; ?>add" class="btn btn-primary">New Role</a><?php } ?>
