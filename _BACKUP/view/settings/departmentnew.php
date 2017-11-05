<h1>New Department</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
<p>Division: <?= $templateVars['currentDivision']['name']; ?></p>
<? if(isset($templateVars['pageError'])): ?>
<p><?= $templateVars['pageError']; ?>
<? else: ?>
<form name"newDepartmentForm" action="/settings/departments/new" method="post">
	<p>Department Name: <input type="text" name="name" autofocus value="<?= isset($templateVars['departmentName']) ? $templateVars['departmentName'] : ''; ?>">
		<?= isset($templateVars['departmentNameError']) ? $templateVars['departmentNameError'] : '' ?></p>
	<input type="submit" value="Save">
	<input type="button" value="Cancel" onclick="location='/settings/departments/view'">
	<input type="hidden" name="newDepartmentForm">
</form>
<? endif; ?>
