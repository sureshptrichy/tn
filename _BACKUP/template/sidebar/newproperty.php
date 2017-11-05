<? if(isset($templateVars['properties'])): ?>
<p>Current Property:<br>
<select id="propertySelect" onchange="changeCurrentProperty()">
<? foreach($templateVars['properties'] as $property): ?>
	<option value="<?= $property['id']; ?>"<?= $templateVars['currentPropertyId'] == $property['id'] ? ' selected' : ''; ?>><?= $property['name']; ?></option>
<? endforeach; ?></p>
</select>
<p>To add a new property click the following link.
<br><a href="/settings/properties/new">New Property</a></p>
<? endif; ?>