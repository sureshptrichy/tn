<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>
<div class="panel-group">
	<?php /* ?>
	<div class="row">
		<div class="tree well col-md-3">
			<ul id="toolbox-folder">
			<?php foreach ($properties as $property){ ?>
				<li id="<?php echo $property['id']; ?>">
					<span id="property"><i class="fa fa-folder"></i> <?php echo $property['name']; ?></span>
					<ul>
					<?php foreach ($property['divisions'] as $divisions){ ?>
						<li id="<?php echo $divisions['id']; ?>">
							<span id="division"><i class="fa fa-folder"></i> <?php echo $divisions['name']; ?></span>
							<ul>
							<?php foreach ($divisions['departments'] as $departments){ ?>
								<li id="<?php echo $departments['id']; ?>">
									<span id="department" title="Expand this branch"><i class="fa fa-folder"></i> <?php echo $departments['name']; ?></span>
								</li>
							<?php } ?>
							</ul>
						</li>
					<?php } ?>
					</ul>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
	*/?>
	<?php foreach ($properties as $property){ ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_<?php echo $property['aid']; ?>">
					<?php echo $property['name']; ?>
				</a>
			</h3>
		</div>
		<div id="clp_<?php echo $property['aid']; ?>" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="row strategytactic-header">
					<div class="col-md-5">
						<h5>Function</h5>
					</div>
					<div class="col-md-4 sort-by-name">
						<h5>Files <i class="fa fa-sort"></i></h5>
					</div>
					<div class="col-md-1 sort-by-mime">
						<h5>Type <i class="fa fa-sort"></i></h5>
					</div>
					<div class="col-md-2 sort-by-date">
						<h5>Date Added <i class="fa fa-sort"></i></h5>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5">
						<ul>
						<?php foreach ($property['divisions'] as $divisions){ ?>
							<li>
								<h4><a href="#"><?php echo $divisions['name']; ?></a> <?php if($divisions['newfolder']){?><div class="table-action" style="display: inline-block; vertical-align: bottom;"><a href="<?php echo URL; ?>toolbox/folder/new/<?=$property['id'].'/'.$divisions['id']?>" class="btn btn-success btn-xs">Add Folder</a></div><?php } ?></h4>
								<ul id="<?=$property['id'].'-'.$divisions['id']?>-folder" class="folders">
									<?php foreach($divisions['folders'] as $folder){?>
										<li>
											<a href="/toolbox" id="<?=$folder['id']?>" class="folder"><img src="<?=$folder['path']?>" /><?=$folder['name']?></a>
											<?php if($folder['editable']){?><a href="/toolbox/folder/delete/<?=$folder['id']?>" class="folder-action fa fa-times-circle"></a><?php }?>
											<?php if($folder['editable']){?><a href="/toolbox/folder/edit/<?=$folder['id']?>" class="folder-action fa fa-cog"></a><?php }?>
										</li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
						</ul>
					</div>
					<div class="col-md-7 folder-files"></div>
				</div>
				<?php /* ?>
				<div class="row strategytactic-header">
					<div class="col-md-5">
						<h5>Function</h5>
					</div>
					<div class="col-md-4">
						<h5>Files</h5>
					</div>
					<div class="col-md-1">
						<h5>Type</h5>
					</div>
					<div class="col-md-2">
						<h5>Date Added</h5>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5">
						<ul>
						<?php foreach ($property['divisions'] as $divisions){ ?>
							<li>
								<h4><a href="#"><?php echo $divisions['name']; ?></a> <a href="<?php echo URL; ?>toolbox/folder/new/<?=$property['id'].'/'.$divisions['id']?>" class="btn btn-success btn-xs">Add Folder</span></a></h4>
								<ul id="<?=$property['id'].'-'.$divisions['id']?>-folder" class="folders">
									<?php foreach($divisions['folders'] as $folder){?>
										<li><a href="/toolbox" id="<?=$folder['id']?>" class="folder"><img src="<?=$folder['path']?>" /><?=$folder['name']?></a></li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
						</ul>
					</div>
					<div class="col-md-7 folder-files"></div>
				</div>
				*/?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>