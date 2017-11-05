<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>
<div class="panel-group">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_northview">Northview Templates</a>
				<?php if ($currentUser->acl->has('addTemplate')) { ?><small><a href="<?php echo URL; ?>templates/new/northview?rf=<?php echo $G->url; ?>" class="btn btn-default">New Template</a></small><?php } ?>
			</h3>
		</div>
		<div id="clp_northview" class="panel-collapse collapse <?php if (count($northviewTemplates) > 0) {?>in<?php }?>">
			<div class="panel-body">
				<div class="table-responsive">
				<?php
					if (!empty($northviewTemplates)){ 
					foreach ($northviewTemplates as $template){?>
						<table class="table table-hover table-condensed subevalstable">
							<tbody>
								<tr>
									<td>
										<table class="table-condensed">
											<tr>
												<td class="template-table-name">Name:</td>
												<td><?php echo $template['name'];?></td>
											</tr>
											<tr>
												<td>Description:</td>
												<td class="template-table-description"><?php echo $template['description'];?></td>
											</tr>
										</table>
									</td>
									<td class="template-table-btns">
										<ul class="list-inline table-action">
											<?php if ($currentUser->acl->has('viewTemplate')) { ?><li><a href="<?php echo $currentUrl;?>download/<?php echo $template['id'];?>" class="label label-primary">Downlaod</a></li><?php } ?>									
											<?php if ($currentUser->acl->has('editTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>edit/<?php echo $template['id']; ?>" class="label label-default">Edit</a></li><?php } ?>
											<?php if ($currentUser->acl->has('deleteTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>delete/<?php echo $template['id']; ?>" class="label label-danger">Delete</a></li><?php } ?>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
				<?php }} ?>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_property">Property Templates</a>
				<?php if ($currentUser->acl->has('addTemplate')) { ?><small><a href="<?php echo URL; ?>templates/new/property?rf=<?php echo $G->url; ?>" class="btn btn-default">New Template</a></small><?php } ?>
			</h3>
		</div>
		<div id="clp_property" class="panel-collapse collapse <?php if (count($propertyTemplates) > 0) {?>in<?php }?>">
			<div class="panel-body">
				<div class="table-responsive">
				<?php
					if (!empty($propertyTemplates)){
						foreach ($propertyTemplates as $template){?>
						<table class="table table-hover table-condensed subevalstable">
							<tbody>
								<tr>
									<td>
										<table class="table-condensed">
											<tr>
												<td class="template-table-name">Name:</td>
												<td><?php echo $template['name'];?></td>
											</tr>
											<tr>
												<td>Description:</td>
												<td class="template-table-description"><?php echo $template['description'];?></td>
											</tr>
										</table>
									</td>
									<td class="template-table-btns">
										<ul class="list-inline table-action">
											<?php if ($currentUser->acl->has('viewTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>download/<?php echo $template['id'];?>" class="label label-primary">Downlaod</a></li><?php } ?>									
											<?php if ($currentUser->acl->has('editTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>edit/<?php echo $template['id']; ?>" class="label label-default">Edit</a></li><?php } ?>
											<?php if ($currentUser->acl->has('deleteTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>delete/<?php echo $template['id']; ?>" class="label label-danger">Delete</a></li><?php } ?>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
				<?php }} ?>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_division">Division Templates</a>
				<?php if ($currentUser->acl->has('addTemplate')) { ?><small><a href="<?php echo URL; ?>templates/new/division?rf=<?php echo $G->url; ?>" class="btn btn-default">New Template</a></small><?php } ?>
			</h3>
		</div>
		<div id="clp_division" class="panel-collapse collapse <?php if (count($divisionTemplates) > 0) {?>in<?php }?>">
			<div class="panel-body">
				<div class="table-responsive">
				<?php 
					if (!empty($divisionTemplates)){
						foreach ($divisionTemplates as $template){?>
						<table class="table table-hover table-condensed subevalstable">
							<tbody>
								<tr>
									<td>
										<table class="table-condensed">
											<tr>
												<td class="template-table-name">Name:</td>
												<td><?php echo $template['name'];?></td>
											</tr>
											<tr>
												<td>Description:</td>
												<td class="template-table-description"><?php echo $template['description'];?></td>
											</tr>
										</table>
									</td>
									<td class="template-table-btns">
										<ul class="list-inline table-action">
											<?php if ($currentUser->acl->has('viewTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>download/<?php echo $template['id'];?>" class="label label-primary">Downlaod</a></li><?php } ?>									
											<?php if ($currentUser->acl->has('editTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>edit/<?php echo $template['id']; ?>" class="label label-default">Edit</a></li><?php } ?>
											<?php if ($currentUser->acl->has('deleteTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>delete/<?php echo $template['id']; ?>" class="label label-danger">Delete</a></li><?php } ?>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
				<?php }} ?>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_department">Department Templates</a>
				<?php if ($currentUser->acl->has('addTemplate')) { ?><small><a href="<?php echo URL; ?>templates/new/department?rf=<?php echo $G->url; ?>" class="btn btn-default">New Template</a></small><?php } ?>
			</h3>
		</div>
		<div id="clp_department" class="panel-collapse collapse <?php if (count($departmentTemplates) > 0) {?>in<?php }?>">
			<div class="panel-body">
				<div class="table-responsive">
				<?php 
					if (!empty($departmentTemplates)){
						foreach ($departmentTemplates as $template){?>
						<table class="table table-hover table-condensed subevalstable">
							<tbody>
								<tr>
									<td>
										<table class="table-condensed">
											<tr>
												<td class="template-table-name">Name:</td>
												<td><?php echo $template['name'];?></td>
											</tr>
											<tr>
												<td>Description:</td>
												<td class="template-table-description"><?php echo $template['description'];?></td>
											</tr>
										</table>
									</td>
									<td class="template-table-btns">
										<ul class="list-inline table-action">
											<?php if ($currentUser->acl->has('viewTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>download/<?php echo $template['id'];?>" class="label label-primary">Downlaod</a></li><?php } ?>									
											<?php if ($currentUser->acl->has('editTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>edit/<?php echo $template['id']; ?>" class="label label-default">Edit</a></li><?php } ?>
											<?php if ($currentUser->acl->has('deleteTemplate')) { ?><li><a href="<?php echo $currentUrl; ?>delete/<?php echo $template['id']; ?>" class="label label-danger">Delete</a></li><?php } ?>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
				<?php }} ?>
				</div>
			</div>
		</div>
	</div>
</div>