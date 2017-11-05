<h1>Delete Division</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
<? if(isset($templateVars['formError'])): ?>
<p>Error: <?= $templateVars['formError']; ?></p>
<input type="button" value="Back" onclick="location='/settings/divisions/view'">
<? else: ?>
<form name"deleteDivisionForm" action="/settings/divisions/delete" method="post">
	<p>Division Name: <?= $templateVars['currentDivision']['name']; ?></p>
	<p>Are you sure you want to delete the above division?</p>
	<input type="submit" value="Delete">
	<input type="button" value="Cancel" onclick="location='/settings/divisions/view'">
	<input type="hidden" name="deleteDivisionForm">
</form>
<? endif; ?>
