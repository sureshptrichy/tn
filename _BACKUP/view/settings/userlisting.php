<table border="1">
	<tr>
		<td><h1>Users</h1></td>
		<td colspan="2" style="text-align:right"><a href="/settings/users/new">New User</a></td>
	</tr>
	<? foreach($templateVars['users'] as $user): ?>
	<tr>
		<td><?= $user['lastname']; ?>, <?= $user['firstname']; ?></td>
		<td><a href="/settings/user/edit/<?= $user['id']; ?>">Edit</a></td>
		<td><a href="/settings/users/delete/<?= $user['id']; ?>">Delete</a></td>
	</tr>
	<? endforeach; ?>
</table>