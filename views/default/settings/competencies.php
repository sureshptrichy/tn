<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
if (count($competencies) < 1) {
	?><p><em>There are no competencies.</em></p><?php
} else {
	?><div class="table-responsive"><table class="table table-striped table-hover tablesorter" id="competencies-list">
		<thead>
		<tr>
			<th>Name</th>
			<th>Property</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($competencies as $id => $competency) { ?>
			<tr id="ID_<?php echo $id; ?>">
				<td>
					<p class="lead"><?php echo $competency['name']; ?></p>
					<ul class="list-inline table-action">
						<?php if (($currentUser->acl->has('editCompetency') AND $competency['default'] == '0' ) || ($currentUser->acl->has('editDefaultCompetency') AND $competency['default'] == '1')) { ?><li><a href="<?php echo $currentUrl; ?>edit/<?php echo $id; ?>" class="label label-default">Edit</a></li><?php } ?>
						<?php if (($currentUser->acl->has('deleteCompetency') AND $competency['default'] == '0' ) || ($currentUser->acl->has('deleteDefaultCompetency') AND $competency['default'] == '1' )) { ?><li><a href="<?php echo $currentUrl; ?>delete/<?php echo $id; ?>" class="label label-danger">Delete</a></li><?php } ?>
					</ul>
				</td>
				<td>
					<?php if ($competency['default']) { ?><p class="text-success">Default</p><?php } else { echo '<p class="text-primary">'.$competency['property_name'].'</p>'; } ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table></div>

<?php
}
?>
<?php if ($currentUser->acl->has('addCompetency') || $currentUser->acl->has('addDefaultCompetency')) { ?><a href="<?php echo $currentUrl; ?>add" class="btn btn-primary">New Competency</a><?php } ?>

<?php if ($currentUser->acl->has('addCompetency') || $currentUser->acl->has('addDefaultCompetency')) { ?><a href="javascript:;" id="competencies-sort-save" class="btn btn-primary pull-right">Save Order</a><?php } ?>
