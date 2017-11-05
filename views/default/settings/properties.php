<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));

if (count($properties) < 1) {
	?><p><em>There are no properties.</em></p><?php
} else {
	?><div class="table-responsive"><table class="table table-striped table-hover tablesorter">
	<thead>
	<tr>
		<th>Logo</th>
		<th>Name</th>
		<th>S & T Restriction</th>
		<th>ASP Restriction</th>
	</tr>
	</thead>
	<tbody>

	<?php foreach ($properties as $id => $property) { ?>
	<tr>
		<td><?php if (isset($property['logo'])) { ?><img src="<?php echo URL; ?>images/show.php?src=<?php echo $property['logo']; ?>&w=200" class="prop-thumbnail img-responsive" /><?php } ?></td>
		<td nowrap width="100%">
			<p class="lead"><?php echo $property['name']; ?></p>
			<ul class="list-inline table-action">
				<?php if ($currentUser->acl->has('editProperty')) { ?><li><a href="<?php echo $currentUrl; ?>edit/<?php echo $id; ?>" class="label label-default">Edit</a></li><?php } ?>
				<?php if ($currentUser->acl->has('deleteProperty')) { ?><li><a href="<?php echo $currentUrl; ?>delete/<?php echo $id; ?>" class="label label-danger">Delete</a></li><?php } ?>
			</ul>
		</td>
		<td class="center"><?php if ($property['restrictSt']) { ?><i class="fa fa-check"></i><?php } ?></td>
		<td class="center"><?php if ($property['restrictAsp']) { ?><i class="fa fa-check"></i><?php } ?></td>
	</tr>
	<?php } ?>
	</tbody>

	</table></div>

<?php
}
?>
<?php if ($currentUser->acl->has('addProperty')) { ?><a href="<?php echo $currentUrl; ?>add" class="btn btn-primary">New Property</a><?php } ?>
