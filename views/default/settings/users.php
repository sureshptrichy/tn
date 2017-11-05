<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>
<?php
$userId = session('user');
$loggedUser = get_model('user')->loadUser($userId);
$property = get_model('property')->getOne(session('property'), 'id');
if (count($users) < 1) {
	?><p><em>There are no users.</em></p><?php
} else {
	?><div class="table-responsive"><table class="table table-striped table-hover tablesorter">
	<thead>
		<tr>
			<th>Name</th>
			<th>Email Address</th>
			<th>Created</th>
			<?php if ($currentUser->acl->has('viewRole')) { ?><th>Role</th> <?php } ?>
			<th>Status</th>
		</tr>
		</thead>
			<tbody>
		<?php foreach ($users as $id => $user) { ?>
		<?php //if ($user->role != 'Super User' || $user->id == $loggedUser['id'] || $property['name'] == 'Globi Northview Admin'){?>
			<tr>
				<td nowrap>
					<?php echo $user->lastname; ?>, <?php echo $user->firstname; ?>
					<ul class="list-inline table-action">
						<?php if ($currentUser->acl->has('editUser') || user_is('Super User')){ ?>
						<li><a href="<?php echo $currentUrl; ?>edit/<?php echo $id; ?>" class="label label-default">Edit</a></li>
						<?php } ?>
						<?php if ($currentUser->acl->has('deleteUser') || user_is('Super User')){ ?>
						<li><a href="<?php echo $currentUrl; ?>delete/<?php echo $id; ?>" class="label label-danger">Delete</a></li>
						<?php } ?>
					</ul>
				</td>
				<td nowrap>
					<?php echo $user->username; ?>
				</td>
				<td nowrap>
					<?php echo date('Y/m/d h:i A', $user->created); ?>
				</td>
				<?php if ($currentUser->acl->has('viewRole')) { ?><td nowrap>
					<?php echo $user->role; ?>
				</td><?php } ?>
				<td nowrap width="100%">
					<?php echo $user->status; ?>
				</td>
			</tr>
		<?php //} ?>
		<?php } ?>
		</tbody>
	</table></div>

<?php
}
?>
<?php if ($currentUser->acl->has('addUser')) { ?><a href="<?php echo $currentUrl; ?>add" class="btn btn-primary">New User</a><?php } ?>
