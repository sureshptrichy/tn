<h1>New Division</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>
<? if(isset($templateVars['pageError'])): ?>
<p><?= $templateVars['pageError']; ?>
<? else: ?>
<form name"newDivisionForm" action="/settings/divisions/new" method="post">
	<p>Division Name: <input type="text" name="name" autofocus value="<?= isset($templateVars['divisionName']) ? $templateVars['divisionName'] : ''; ?>">
		<?= isset($templateVars['divisionNameError']) ? $templateVars['divisionNameError'] : '' ?></p>
	<input type="submit" value="Save">
	<input type="button" value="Cancel" onclick="location='/settings/divisions/view'">
	<input type="hidden" name="newDivisionForm">
</form>
<? endif; ?>
