<h1>Delete User</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
<p>Division: <?= $templateVars['currentDivision']['name']; ?></p>
<p>Department: <?= $templateVars['currentDepartment']['name']; ?></p>
<p>User: <?= $templateVars['currentUser']['firstname']; ?> <?= $templateVars['currentUser']['lastname']; ?></p>
<? if(isset($templateVars['formError'])): ?>
<p><?= $templateVars['formError']; ?></p>
<input type="button" value="Back" onclick="location='/settings/users/view'">
<? else: ?>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Email: <?= $templateVars['currentUser']['email']; ?></p>
<p>Access Level: <?= $templateVars['currentUser']['accessLevelDescription']['description']; ?></p>
<p>Account Disabled: <?= $templateVars['currentUser']['disabled'] == 1 ? 'Yes' : 'No'; ?></p>
<p>Last Login: <?= date('Y/m/d', $templateVars['currentUser']['lastlogin']); ?></p>
<form name"deleteUserForm" action="/settings/users/delete" method="post">
	<p>Are you sure you want to delete the above user?</p>
	<input type="submit" value="Delete">
	<input type="button" value="Cancel" onclick="location='/settings/users/view'">
	<input type="hidden" name="deleteUserForm">
</form>
<? endif; ?>
