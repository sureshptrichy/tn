<h1>Edit User</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
<p>Division: <?= $templateVars['currentDivision']['name']; ?></p>
<p>Department: <?= $templateVars['currentDepartment']['name']; ?></p>
<? if(isset($templateVars['pageError'])): ?>
<p><?= $templateVars['pageError']; ?>
<? else: ?>
<form name"editUserForm" action="/settings/users/edit" method="post">
	<p>Last Name: <input type="text" name="lastname" autofocus value="<?= $templateVars['currentUser']['lastname']; ?>">
		<?= isset($templateVars['userLastnameError']) ? $templateVars['userLastnameError'] : '' ?></p>
	<p>First Name: <input type="text" name="firstname" value="<?= $templateVars['currentUser']['firstname']; ?>">
		<?= isset($templateVars['userFirstnameError']) ? $templateVars['userFirstnameError'] : '' ?></p>
	<p>Email: <input type="text" name="email" value="<?= $templateVars['currentUser']['email']; ?>">
		<?= isset($templateVars['userEmailError']) ? $templateVars['userEmailError'] : '' ?></p>
	<p>Access Level:	<select name="accessLevel">
	<? foreach($templateVars['accessLevels'] as $accessLevel): ?>
		<option value="<?= $accessLevel['id']; ?>"<?= $templateVars['currentUser']['accesslevels_id'] == $accessLevel['id'] ? ' selected' : ''; ?>><?= $accessLevel['description']; ?></option>
	<? endforeach; ?>
	</select></p>
	<p>New Password: <input type="password" name="newpassword">
		<?= isset($templateVars['userNewPasswordError']) ? $templateVars['userNewPasswordError'] : '' ?></p>
	<p>Verify New Password: <input type="password" name="verifypassword">
		<?= isset($templateVars['userVerifyPasswordError']) ? $templateVars['userVerifyPasswordError'] : '' ?></p>
	<p>Accout Disabled:	<select name="disabled">
		<option value="1"<?= $templateVars['currentUser']['disabled'] == 1 ? ' selected' : ''; ?>>Yes</option>
		<option value="0"<?= $templateVars['currentUser']['disabled'] == 0 ? ' selected' : ''; ?>>No</option>
	</select></p>
	<p>Last Login: <?= date('Y/m/d',$templateVars['currentUser']['lastlogin']); ?></p>
	<input type="submit" value="Save">
	<input type="button" value="Cancel" onclick="location='/settings/users/view'">
	<input type="hidden" name="editUserForm">
</form>
<? endif; ?>
