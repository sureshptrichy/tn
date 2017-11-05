<h1>Delete Property</h1>

<? if(isset($templateVars['formError'])): ?>

<p>Error: <?= $templateVars['formError']; ?></p>
<input type="button" value="Back" onclick="location='/settings/properties/listing'">

<? else: ?>

<? $property = $templateVars['property']; ?>
<p><img src="/images/logos/<?= $property['logo']; ?>"></p>	
<form name"deletePropertyForm" action="/settings/properties/delete" method="post">
	<p>Property Name: <?= $property['name']; ?></p>
	<p>Are you sure you want to delete the above property?</p>
	<input type="submit" value="Delete">
	<input type="button" value="Cancel" onclick="location='/settings/properties/view'">
	<input type="hidden" name="deletePropertyForm">
	<input type="hidden" name="deletePropertyId" value="<?= $property['id']; ?>">
</form>

<? endif; ?>
