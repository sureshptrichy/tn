<h1>View Division</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Property: <?= $templateVars['currentProperty']['name']; ?></p>

<? if($templateVars['currentDivision'] == false): ?>
<p>No divisions currently exist for this property.</p>
<? else: ?>
<p>Division Name: <?= $templateVars['currentDivision']['name']; ?></p>
<input type="button" value="Edit" onclick="location='/settings/divisions/edit'">
<input type="button" value="Delete" onclick="location='/settings/divisions/delete'">
<? endif; ?>