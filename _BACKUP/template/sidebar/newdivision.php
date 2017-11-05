<p>Current Property:<br>
<select id="propertySelect" onchange="changeCurrentProperty()">
<? foreach($templateVars['properties'] as $property): ?>
	<option value="<?= $property['id']; ?>"<?= $templateVars['currentProperty']['id'] == $property['id'] ? ' selected' : ''; ?>><?= $property['name']; ?></option>
<? endforeach; ?>
</select>

<? if(count($templateVars['divisions']) > 0): ?>
<p>Current Division:<br>
<select id="divisionSelect" onchange="changeCurrentDivision()">
<? foreach($templateVars['divisions'] as $division): ?>
	<option value="<?= $division['id']; ?>"<?= $templateVars['currentDivision']['id'] == $division['id'] ? ' selected' : ''; ?>><?= $division['name']; ?></option>
<? endforeach; ?>
</select>
<p>To add a new division to the currently selected property click the following link.
<? else: ?>
<p>No divisions exist for the currently selected property. To add a new division click the following link.
<? endif; ?>
<br><a href="/settings/divisions/new">New Division</a></p>
