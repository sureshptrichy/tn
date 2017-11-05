<h1>New Property</h1>

<? if(isset($templateVars['formError'])): ?>

<p>Error: <?= $templateVars['formError']; ?></p>
<input type="button" value="Back" onclick="location='/settings/properties/view'">

<? else: ?>

<? $property = $templateVars['property']; ?>
<form name"newPropertyForm" action="/settings/properties/new" method="post" enctype="multipart/form-data">
	<p>Property Name: <input type="text" name="name" autofocus value="<?= isset($property['name']) ? $property['name'] : ''; ?>"><?= isset($templateVars['nameError']) ? $templateVars['nameError'] : '' ?></p>
	<p>Property Logo: <input type="file" name="logo" id="logo"><?= isset($templateVars['logoError']) ? $templateVars['logoError'] : '' ?></p>
	<input type="submit" value="Save">
	<input type="button" value="Cancel" onclick="location='/settings/properties/view'">
	<input type="hidden" name="newPropertyForm">
</form>

<? endif; ?>