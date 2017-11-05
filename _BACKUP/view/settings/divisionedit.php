<h1>Edit Division</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<? if(isset($templateVars['pageError'])): ?>
<p><?= $templateVars['pageError']; ?>
<? else: ?>
<form name"editDivisionForm" action="/settings/divisions/edit" method="post">
	<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
	<p>Division Name: <input type="text" name="name" autofocus value="<?= isset($templateVars['currentDivision']['name']) ? $templateVars['currentDivision']['name'] : ''; ?>">
		<?= isset($templateVars['divisionNameError']) ? $templateVars['divisionNameError'] : '' ?></p>
	<input type="submit" value="Save">
	<input type="button" value="Cancel" onclick="location='/settings/divisions/view'">
	<input type="hidden" name="editDivisionForm">
</form>
<? endif; ?>
