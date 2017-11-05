<h1>Edit Property</h1>

<? if(isset($templateVars['formError'])): ?>

<p>Error: <?= $templateVars['formError']; ?></p>
<input type="button" value="Back" onclick="location='/settings/properties/view'">

<? else: ?>

<? $property = $templateVars['property']; ?>
<p><img src="/images/logos/<?= $property['logo']; ?>"></p>	
<form name"editPropertyForm" action="/settings/properties/edit" method="post" enctype="multipart/form-data">
	<p>Property Name: <input type="text" name="name" autofocus value="<?= $property['name']; ?>"><?= isset($templateVars['nameError']) ? $templateVars['nameError'] : '' ?></p>
	<p>New Logo: <input type="file" name="logo" id="logo"><?= isset($templateVars['logoError']) ? $templateVars['logoError'] : '' ?></p>
	<input type="submit" value="Save">
	<input type="button" value="Cancel" onclick="location='/settings/properties/view'">
	<input type="hidden" name="editPropertyForm">
	<input type="hidden" name="editPropertyId" value="<?= $property['id']; ?>">
</form>

<? endif; ?>