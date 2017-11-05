<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>
<div class="panel-group">
<?php foreach ($subevaluations as $type){?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_<?php echo $type['id'];?>"><?php echo $type['name'];?></a>
				<?php if ($currentUser->acl->has('addSubevaluation')) { ?><small><a href="<?php echo URL; ?>settings/subevaluations/new/<?php echo $type['id']; ?>?rf=<?php echo $G->url; ?>" class="btn btn-default">Add Review Section</a></small><?php } ?>
			</h3>
		</div>
		<div id="clp_<?php echo $type['id'];?>" class="panel-collapse collapse <?php if ($type['type_count'] > 0) {?>in<?php }?>">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed subevalstable">
						<tbody>
							<?php if(isset($type['subevaluations']) AND !empty($type['subevaluations'])){
									foreach ($type['subevaluations'] as $subevaluation => $item){
										if ($item['cummulation'] == 'results'){
											$badge = ' badge-r';
										} elseif ($item['cummulation'] == 'culture'){
											$badge = ' badge-c';
										} else {
											$badge = '';
										}
										?>
							<tr class="subevluation-row">
								<td>
									<table class="table-condensed">
										<tr>
											<td class="subeval-table-name">Name:</td>
											<td><?php echo $item['name'];?> <span class="badge<?=$badge?>"><?php echo ucfirst($item['cummulation']); ?> </span></td>
										</tr>
										<tr>
											<td>Description:</td>
											<td class="subeval-table-description"><?php echo $item['description'];?></td>
										</tr>
									</table>
								</td>
								<td class="subeval-table-btns">
									<ul class="list-inline table-action">									
										<?php if ($currentUser->acl->has('editSubevaluation')) { ?><li><a href="<?php echo $currentUrl; ?>edit/<?php echo $item['id']; ?>" class="label label-default">Edit</a></li><?php } ?>
										<?php if ($currentUser->acl->has('editSubevaluation')) { ?><li><a href="<?php echo $currentUrl; ?>preview/<?php echo $item['id']; ?>" class="label label-info">Preview</a></li><?php } ?>
										<?php if ($currentUser->acl->has('deleteSubevaluation')) { ?><li><a href="<?php echo $currentUrl; ?>delete/<?php echo $item['id']; ?>" class="label label-danger">Delete</a></li><?php } ?>
									</ul>
								</td>
							</tr>
							<tr>
							</tr>
							<?php }}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
</div>