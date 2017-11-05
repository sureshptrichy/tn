<h1>View User</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
<? if($templateVars['currentDivision'] == false): ?>
<p>No divisions currently exist for this property.</p>
<? else: ?>
<p>Division: <?= $templateVars['currentDivision']['name']; ?></p>
<? if($templateVars['currentDepartment'] == false): ?>
<p>No departments currently exist for this division.</p>
<? else: ?>
<p>Department: <?= $templateVars['currentDepartment']['name']; ?></p>
<? if($templateVars['currentUser'] == false): ?>
<p>No users currently exist for this department.</p>
<? else: ?>
<p>User: <?= $templateVars['currentUser']['firstname']; ?> <?= $templateVars['currentUser']['lastname']; ?></p>
<p>Email: <?= $templateVars['currentUser']['email']; ?></p>
<p>Access Level: <?= $templateVars['currentUser']['accessLevelDescription']['description']; ?></p>
<p>Account Disabled: <?= $templateVars['currentUser']['disabled'] == 1 ? 'Yes' : 'No'; ?></p>
<p>Last Login: <?= date('Y/m/d', $templateVars['currentUser']['lastlogin']); ?></p>
<input type="button" value="Edit" onclick="location='/settings/users/edit'">
<input type="button" value="Delete" onclick="location='/settings/users/delete'">
<? endif; ?>
<? endif; ?>
<? endif; ?>
