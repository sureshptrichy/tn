<h1>Delete Department</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
<p>Division: <?= $templateVars['currentDivision']['name']; ?></p>
<? if(isset($templateVars['formError'])): ?>
<p>Error: <?= $templateVars['formError']; ?></p>
<input type="button" value="Back" onclick="location='/settings/departments/view'">
<? else: ?>
<form name"deleteDepartmentForm" action="/settings/departments/delete" method="post">
	<p>Department Name: <?= $templateVars['currentDepartment']['name']; ?></p>
	<p>Are you sure you want to delete the above department?</p>
	<input type="submit" value="Delete">
	<input type="button" value="Cancel" onclick="location='/settings/departments/view'">
	<input type="hidden" name="deleteDepartmentForm">
</form>
<? endif; ?>
