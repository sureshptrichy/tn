<h1>View Property</h1>
<p><img src="/images/logos/<?= $templateVars['currentProperty']['logo']; ?>"></p>	
<p>Property Name: <?= $templateVars['currentProperty']['name']; ?></p>
<input type="button" value="Edit" onclick="location='/settings/properties/edit'">
<? if($templateVars['currentProperty']['id'] != 0): ?>
<input type="button" value="Delete" onclick="location='/settings/properties/delete'">
<? endif; ?>
