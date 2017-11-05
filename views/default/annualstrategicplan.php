<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>
<?php if ($G->user->acl->has('viewCompetency')) { ?>
<div class="panel-group">
	<?php

/* echo "<pre>";
print_r($items);
exit; */

	foreach($items as $cid => $competency) {
		$printhide = '';
		$objectives[$cid] = $competency['_objectives'];
		if (count($objectives[$cid]) == 0) {
			$printhide = ' printhide';
		}
		//print_r($currentUser);
		//print_r($_SESSION);
		?>
	<div class="panel panel-default <?=$printhide?>">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_<?php echo $cid; ?>"><strong><?php echo $competency['name']; ?></strong></a>
				<?php if ($currentUser->acl->has('addObjective')) { ?><a href="<?php echo URL; ?>objective/new/<?php echo $cid; ?>?rf=<?php echo $G->url; ?>" class="btn btn-success">Add Objective</a><?php } ?>
			</h3>
		</div>
		<?php if ($G->user->acl->has('viewObjective')) { ?>
		<div id="clp_<?php echo $cid; ?>" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="row strategytactic-header">
					<div class="col-sm-6">
						<div class="col-md-10 col-sm-offset-1"><h5>Objectives</h5></div>
					</div>
					<div class="col-sm-6">
						<div class="col-md-8 col-sm-offset-1"><h5>Strategies</h5></div>
						<div class="col-sm-3 tactic-due-date"><h5>Due Date</h5></div>
					</div>
				</div>
				<?php 
					$obj_count = 0;
					foreach ($objectives[$cid] as $oid => $objective) { 
						if($objective["tn_objective"] == 1) continue; 
					?>
				<?php	$sdatelist = array(
						'start' => $objective['start'],
						'due' => $objective['due']);
						$sdatelist['complete'] = (isset($objective['complete'])) ? $objective['complete'] : '';
					
					foreach ($sdatelist as $datetype => $date) {
						
						if($date ==  '') continue;
						
						$tempdate = date('Y/m/d', $date);
						$tempdate = date('M d, Y', $date);
						//if ($tempdate != '1970/01/01' && $tempdate != '1969/12/31') {
						if ($tempdate != 'Jan 01, 1970' && $tempdate != 'Dec 31, 1969') {							
							$sdatelist[$datetype] = $tempdate;
						}
					}
					$sdates = implode(' - ', $sdatelist);
					$sdates = substr_replace($sdates, '', strrpos($sdates, ' - '), strlen($sdates));
					if ($sdates != '') {
						$sdates = '<div class="main-date"><i class="fa fa-calendar"></i> '.$sdates.'</div>';
					}
					$sattachments = NULL;
					$attachments[$oid] = $objective['_attachments'];
					if ($G->user->acl->has('viewAttachment')) {
						if (isset($attachments[$oid])) {
							if (count($attachments[$oid]) > 0) {
								$sattachments = '<ul class="attachment-list">';
							}
							foreach ($attachments[$oid] as $attachment) {
								$sattachments .= '<li><i class="fa fa-file-text"></i> <a href="'.UPLOAD_URL.$attachment['path'].'"  target="_new">';
								if ($attachment['name'] != '') {
									$sattachments .= $attachment['name'];
								} else {
									$sattachments .= substr($attachment['path'], strrpos($attachment['path'], '/'));
								}
								$sattachments .= '</a>';
								
								if ($currentUser->acl->has('addAttachment') || $G->user->acl->has('addAttachment')) {
									$sattachments .= ' <a class="label label-danger " href="'.URL.'attachment/delete/'.$attachment['id'].'?rf='.$G->url.'">Delete</a>';
								}
								
								$sattachments .= '</li>';
							}
							if (count($attachments[$oid]) > 0) {
								$sattachments .= '</ul>';
							}
						}
					}
					$username = NULL;
					$user = $G->user->getOne($objective['cid'], 'id');
					$username = $user['lastname'].', '.$user['firstname'];
					
					$assigned_user = '';
					if(isset($objective['user_id']) && $objective['user_id']) {
						$assigned_to = get_model("user")->getOne($objective['user_id'], 'id');
						$assigned_user = $assigned_to["firstname"] . ' ' . $assigned_to["lastname"];
						
						$assigned_to_label_class = ($objective['user_id'] == session('user')) ? 'label-me' : 'label-success';
					}					
					$created_user = '';
					if(isset($objective['cid']) && $objective['cid']) {
						$created_by = get_model("user")->getOne($objective['cid'], 'id');
						$created_user = $created_by["firstname"] . ' ' . $created_by["lastname"];
					}					
					//$objective_class = ($obj_count == 0) ? '' : 'hidden';
					if($obj_count == 1 && count($objectives[$cid]) > 1) { ?>
						<div class="read-more-content">
					<?php }
				?>
				<div id="obj_<?php echo $oid; ?>" class="row strategytactic <?php // echo $objective_class; ?>">
					<div class="col-sm-6 strategy">
						<div class="col-md-10">
							<div class="main-description obj-title"><?php echo Parsedown::instance()->parse($objective['description']); ?></div>
							<?php echo $sdates; ?>
							<?php if ($objective['comment'] != '') { ?><div class="main-comment"><?php echo Parsedown::instance()->parse('<i class="fa fa-comment"></i> '.$objective['comment']); ?></div><?php } ?>
							<?php echo $sattachments; ?>
							<div class="table-action">
							<?php if($created_user) { ?><span style="font-size:11px"><i>Created By:</i> </span><span class="label label-default" style="margin-bottom: 5px;display: inline-block;"><?php echo $created_user; ?></span> &nbsp;<?php } ?>
							<?php if($assigned_user) { ?><span style="font-size:11px"><i>Assigned To:</i> </span><span class="label <?php echo $assigned_to_label_class; ?>" style="margin-bottom: 5px;display: inline-block;"><?php echo $assigned_user; ?></span><?php } ?>
							</div>

							<?php if((isset($objective['user_id']) && $objective['user_id'] == session('user')) || $objective['cid'] == session('user') || $objective['cid'] == session('user_filter') || ($currentUser->role == 'Super User' || $currentUser->role == 'Property Super User')){ ?>
							<?php if($currentUser->role != 'Supervisor'): ?>
							<ul class="list-inline table-action">
								<?php if (($currentUser->acl->has('editObjective') && $sdatelist['complete'] == '') || ($G->user->acl->has('editObjective') && $sdatelist['complete'] == '')) { ?><li><a href="<?php echo URL; ?>objective/edit/<?php echo $oid; ?>?rf=<?php echo $G->url; ?>" class="label label-default">Edit</a></li><?php } ?>
								<?php if (($currentUser->acl->has('editObjective') && $sdatelist['complete'] == '') || ($G->user->acl->has('editObjective') && $sdatelist['complete'] == '')) { ?><li><a href="<?php echo URL; ?>objective/delete/<?php echo $oid; ?>?rf=<?php echo $G->url; ?>" class="label label-danger">Delete</a></li><?php } ?>								<?php if ($currentUser->acl->has('addAttachment') || $G->user->acl->has('addAttachment')) { ?><li><a href="<?php echo URL; ?>attachment/new/<?php echo $oid; ?>?rf=<?php echo $G->url; ?>" class="label label-info  ajax-modal-form">Upload Attachment</a></li><?php } ?>
								<!--<?php if (($currentUser->acl->has('editObjective') && $sdatelist['complete'] == '') || ($G->user->acl->has('editObjective') && $sdatelist['complete'] == '')) { ?><li><a href="<?php echo URL; ?>strategy/complete/<?php echo $oid; ?>?rf=<?php echo $G->url; ?>" class="label label-success">Complete</a></li><?php } ?>-->
								<?php if ($currentUser->acl->has('addStrategy')) { ?><li><a href="<?php echo URL; ?>strategy/new/<?php echo $oid; ?>?rf=<?php echo $G->url; ?>" class="label label-primary">Add Strategy(s)</a></li><?php } ?>
							</ul>
							<?php endif; ?>
							<?php } ?>
						</div>
					</div>
					<div class="col-sm-6 tactics">
					
							<?php if ($currentUser->acl->has('viewStrategy')  || ($currentUser->role == 'Super User' || $currentUser->role == 'Property Super User')) { ?>
								<?php foreach ($objective['_strategies'] as $sid => $strategy) { ?>
								<?php	$tdates = array(
										'due' => $strategy['due'],
										'complete' => $strategy['complete']
									);
									foreach ($tdates as $datetype => $date) {
										if ($date != '') {
											//$tempdate = date('Y/m/d', $date);
											$tempdate = date('M d, Y', $date);
											$tdates[$datetype] = $tempdate;
										}
									}
									if ($tdates['due'] != '') {
										$tdates['due'] = '<div class="main-date">'.$tdates['due'].'</div>';
									}
									if ($tdates['complete'] != '') {
										$tdates['complete'] = '<p><small><strong>Completed<br>'.$tdates['complete'].'</strong></small></p>';
									}
									$tattachments = NULL;
									$attachments[$sid] = $strategy['_attachments'];
									if ($G->user->acl->has('viewAttachment')) {
										if (isset($attachments[$sid])) {
											if (count($attachments[$sid]) > 0) {
												$tattachments = '<ul class="attachment-list">';
											}
											foreach ($attachments[$sid] as $attachment) {
												$tattachments .= '<li><i class="fa fa-file-text"></i> <a href="'.UPLOAD_URL.$attachment['path'].'"  target="_new">';
												if ($attachment['name'] != '') {
													$tattachments .= $attachment['name'];
												} else {
													$tattachments .= substr($attachment['path'], strrpos($attachment['path'], '/'));
												}
	
												$tattachments .= '</a>';
												
												if ($currentUser->acl->has('addAttachment') || $G->user->acl->has('addAttachment')) {
													$tattachments .= ' <a class="label label-danger " href="'.URL.'attachment/delete/'.$attachment['id'].'?rf='.$G->url.'">Delete</a>';
												}
												
												$tattachments .= '</li>';												
											}
											if (count($attachments[$sid]) > 0) {
												$tattachments .= '</ul>';
											}
										}
									}
									
									$assigned_user = '';
									if(isset($strategy['user_id']) && $strategy['user_id']) {
										$assigned_to = get_model("user")->getOne($strategy['user_id'], 'id');
										$assigned_user = $assigned_to["firstname"] . ' ' . $assigned_to["lastname"];
										$assigned_to_label_class = ($strategy['user_id'] == session('user')) ? 'label-me' : 'label-success';
									}

									$created_user = '';
									if(isset($strategy['cid']) && $strategy['cid']) {
										$created_by = get_model("user")->getOne($strategy['cid'], 'id');
										$created_user = $created_by["firstname"] . ' ' . $created_by["lastname"];
									}									
								?>
								<div class="row tactic">
									<div class="col-md-9 tactic-info">
										<div class="main-description strategy-title"><?php echo Parsedown::instance()->parse($strategy['description']); ?></div>
										<?php if ($strategy['comment'] != '') { ?><div class="main-comment"><i class="fa fa-comment"></i><?php echo Parsedown::instance()->parse($strategy['comment']); ?></div><?php } ?>
										<?php echo $tattachments; ?>										
										<div class="table-action">
										<?php if($created_user) { ?><span style="font-size:11px"><i>Created By:</i> </span><span class="label label-default" style="margin-bottom: 5px;display: inline-block;"><?php echo $created_user; ?></span> &nbsp;<?php } ?>
										<?php if($assigned_user) { ?><span style="font-size:11px"><i>Assigned To:</i> </span><span class="label <?php echo $assigned_to_label_class; ?>" style="margin-bottom: 5px;display: inline-block;"><?php echo $assigned_user; ?></span><?php } ?>
										</div>

										<?php if((isset($objective['user_id']) && $objective['user_id'] == session('user')) || $strategy['cid'] == session('user') || ($currentUser->role == 'Super User' || $currentUser->role == 'Property Super User')){ ?>
										<ul class="list-inline table-action">
											<?php if ($currentUser->acl->has('editStrategy') && $tdates['complete'] == '') { ?><li><a href="<?php echo URL; ?>strategy/edit/<?php echo $sid; ?>?rf=<?php echo $G->url; ?>" class="label label-default  ajax-modal-form">Edit</a></li><?php } ?>
											<?php if ($currentUser->acl->has('editStrategy') && $tdates['complete'] == '') { ?><li><a href="<?php echo URL; ?>strategy/delete/<?php echo $sid; ?>?rf=<?php echo $G->url; ?>#obj_<?php echo $oid; ?>" class="label label-danger">Delete</a></li><?php } ?>											<?php if ($currentUser->acl->has('addAttachment')) { ?><li><a href="<?php echo URL; ?>attachment/new/<?php echo $sid; ?>?rf=<?php echo $G->url; ?>" class="label label-info  ajax-modal-form">Upload Attachment</a></li><?php } ?>
											<?php if ($currentUser->acl->has('editStrategy') && $tdates['complete'] == '') { ?><li><a href="<?php echo URL; ?>strategy/complete/<?php echo $sid; ?>?rf=<?php echo $G->url; ?>" class="label label-success  ajax-modal-form">Complete</a></li><?php } ?>
										</ul>
										<?php } ?>
									</div>
									<div class="col-sm-3 date-completed">
										<?php echo $tdates['due']; ?>
										<?php echo $tdates['complete']; ?>
									</div>
								</div>
								<?php }
							} ?>
					</div>
				</div>
				<?php 
					$obj_count++;
				
				}
				if($obj_count > 1) {
				?>
					</div>
					<a class="read-more-toggle pull-right label label-default" href="javascript:;" style="padding:5px">View More</a>

				<?php
				}

				?>
			</div>
		</div>
		<?php } ?>
	</div>
<?php } ?>
</div>
<?php } ?>


<div class="modals">
	<div id="modalStrategyAddForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Add Compiled Form to Review" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div id="strategyform">Loading...</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
$('.read-more-toggle').on('click', function() {
  $(this).prev('.read-more-content').slideToggle();
  //alert($(this).text());
  //alert($(this).html());
  if($(this).text() == "View More") {
	  $(this).text("View Less");
  } else {
	  $(this).text("View More");
  }
});
</script>