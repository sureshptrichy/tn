<h1>View Department</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
<? if($templateVars['currentDivision'] == false): ?>
<p> No divisions currently exist for this property.</p>
<? else: ?>
<p>Division: <?= $templateVars['currentDivision']['name']; ?></p>
<? if($templateVars['currentDepartment'] == false): ?>
<p> No departments currently exist for this division.</p>
<? else: ?>
<p>Department Name: <?= $templateVars['currentDepartment']['name']; ?></p>
<input type="button" value="Edit" onclick="location='/settings/departments/edit'">
<input type="button" value="Delete" onclick="location='/settings/departments/delete'">
<? endif; ?>
<? endif; ?>
