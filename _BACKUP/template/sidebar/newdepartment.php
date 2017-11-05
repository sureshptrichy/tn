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
<? if(count($templateVars['departments']) > 0): ?>
<p>Current Department:<br>
<select id="departmentSelect" onchange="changeCurrentDepartment()">
<? foreach($templateVars['departments'] as $department): ?>
	<option value="<?= $department['id']; ?>"<?= $templateVars['currentDepartment']['id'] == $department['id'] ? ' selected' : ''; ?>><?= $department['name']; ?></option>
<? endforeach; ?>
</select>
<p>To add a new department to the currently selected property and division click the following link.
<? else: ?>
<p>No departments exist for the currently selected division. To add a new department click the following link.
<? endif; ?>
<br><a href="/settings/departments/new">New Department</a></p>
<? else: ?>
<p>No divisions exist for the currently selected property. In order to add a new department at least one division must added first.</p>
<? endif; ?>
