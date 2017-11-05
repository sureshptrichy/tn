<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
$bottomAddBtn = 0;
?>
<?php if (count($items) > 4){?>
<?php }?>
<?php if ($G->user->acl->has('viewCompetency')) { ?>
<div class="panel-group">
	<?php foreach($items as $cid => $competency) {
		$printhide = '';
		$strategies[$cid] = $competency['_strategies'];
		//print_r($competency['_strategies']);exit;
		$objectives = array();
		foreach ($competency['_objectives'] as $objective) {
			
			//print_r($objective);exit;
			if(count($objective['_strategies']) > 0) {
			
				foreach ($objective['_strategies'] as $osid=> $os){
					$os['parent_type'] = "ASP";
					$strategies[$cid][$osid] = $os;
				}
			
			} else {
				//print_r($objective);
				if((isset($objective['user_id']) && $objective['user_id'] == session('user')) || $objective['cid'] == session('user')){
					$objectives[$cid][] = $objective;
				}
			}
			//$strategies[$cid] = array_merge($strategies[$cid], $objective['_strategies']);
		}
		//print_r($objectives);exit;
		if (count($strategies[$cid]) == 0) {
			$printhide = ' printhide';
		}
		
		$strategiesList = array();
		$prev_objective = '';
		
		foreach ($strategies[$cid] as $sid => $strategy) {
			$strategy["objectiveInfo"] = '';
			if(isset($strategy['_objective']) && $strategy['_objective'] != $prev_objective) {
				$obj = get_model('objective')->getOne($strategy['_objective'], 'id');
				if($obj["status"] == 0) continue;
				$strategy["objectiveInfo"] = $obj;
				$prev_objective = $strategy['_objective'];
			}
			$strategiesList[$sid] = $strategy;
		}	
		
		$strategies[$cid] = $strategiesList;
		
		//if (count($strategies[$cid]) > 0) { $bottomAddBtn = count($strategies[$cid]);?>
	<div class="panel panel-default <?=$printhide?> tn-list">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_<?php echo $cid; ?>"><strong><?php echo $competency['name']; ?></strong></a>
				<?php if ($currentUser->acl->has('addStrategy')) { ?><a href="<?php echo URL; ?>strategiestactics/newobjective/<?php echo $cid; ?>?rf=<?php echo $G->url; ?>" class="btn btn-success ajax-modal-form">Add Objective</a><?php } ?>
			</h3>
		</div>
		<?php if ($G->user->acl->has('viewStrategy')) { ?>
		<div id="clp_<?php echo $cid; ?>" class="panel-collapse collapse in">
			<div class="panel-body">

				<?php 
				
					if(isset($objectives[$cid]) && count($objectives[$cid]) > 0) {
						foreach($objectives[$cid] as $oid => $objective) {
							//print_r($objective);
						?>
							<div id="obj_<?php echo $objective['id']; ?>"><h4><strong><?php echo $objective['description']; ?></strong></h4>
							
							<?php if((isset($objective['user_id']) && $objective['user_id'] == session('user')) || $objective['cid'] == session('user')){ ?>
							<ul class="list-inline table-action">
								<?php if ($currentUser->acl->has('editStrategy')) { ?><li><a href="<?php echo URL; ?>strategiestactics/editobjective/<?php echo $objective['id']; ?>?rf=<?php echo $G->url; ?>" class="label label-default ajax-modal-form">Edit</a></li><?php } ?>
								<?php if ($currentUser->acl->has('editStrategy')) { ?><li><a href="<?php echo URL; ?>objective/delete/<?php echo $objective['id']; ?>?rf=<?php echo $G->url . '#clp_' . $cid; ?>" class="label label-danger">Delete</a></li><?php } ?>
								
								<?php if ($currentUser->acl->has('addStrategy')) { ?><li><a href="<?php echo URL; ?>strategy/new/<?php echo $objective['id']; ?>?rf=<?php echo $G->url; ?>" class="label label-primary ajax-modal-form">Add Strategy</a></li><?php } ?>
							</ul>
							<?php } ?>							
							</div>
							<div style="border-top: 1px #000 solid;">&nbsp;</div>
						<?php
						}
					}
					$strategies_count = 0;
					$prev_objective = '';
					foreach ($strategies[$cid] as $sid => $strategy) {
					$attachments[$sid] = $strategy['_attachments'];
					$tactics[$sid] = $strategy['_tactics']; ?>
				<?php	$sdatelist = array(
						'start' => $strategy['start'],
						'due' => $strategy['due'],
						'complete' => $strategy['complete']
					);
					$due_changed_class = '';
					foreach ($sdatelist as $datetype => $date) {
						$tempdate = date('Y/m/d', $date);
						$tempdate = date('M d, Y', $date);
						//if ($tempdate != '1970/01/01' && $tempdate != '1969/12/31') {
						if ($tempdate != 'Jan 01, 1970' && $tempdate != 'Dec 31, 1969') {							
							$sdatelist[$datetype] = $tempdate;
						}
						
						if($datetype == 'due') {
							$now = new DateTime();;
							//echo $now->getTimestamp() . '--' . $date;
							if($date < $now->getTimestamp() && $strategy['complete'] == '') {
								$due_changed_class = 'due-changed';
							}
						}						
						
					}
					$sdates = implode(' - ', $sdatelist);
					$sdates = substr_replace($sdates, '', strrpos($sdates, ' - '), strlen($sdates));
					if ($sdates != '') {
						/* $due_changed_class = '';
						if(isset($strategy['past_due']) && $strategy['complete'] == '') {
							$due_changed_class = 'due-changed';
						} */
						
						$sdates = '<div class="main-date '.$due_changed_class.'"><i class="fa fa-calendar"></i> '.$sdates.'</div>';
					}
					$sattachments = NULL;
					if ($G->user->acl->has('viewAttachment')) {
						if (isset($attachments[$sid])) {
							if (count($attachments[$sid]) > 0) {
								$sattachments = '<ul class="attachment-list">';
							}
							foreach ($attachments[$sid] as $attachment) {
								$sattachments .= '<li><i class="fa fa-file-text"></i> <a href="'.UPLOAD_URL.$attachment['path'].'" target="_new">';
								if ($attachment['name'] != '') {
									$sattachments .= $attachment['name'];
								} else {
									$sattachments .= substr($attachment['path'], strrpos($attachment['path'], '/'));
								}
								$sattachments .= '</a>';
								
								if ($currentUser->acl->has('addAttachment') || $G->user->acl->has('addAttachment')) {
									$sattachments .= ' <a class="label label-danger " href="'.URL.'attachment/delete/'.$attachment['id'].'?rf='.$G->url. '#sty_' . $sid.'">Delete</a>';
								}
								
								$sattachments .= '</li>';
							}
							if (count($attachments[$sid]) > 0) {
								$sattachments .= '</ul>';
							}
						}
					}
					$username = NULL;
					$user = $G->user->getOne($strategy['cid'], 'id');
					$username = $user['lastname'].', '.$user['firstname'];

					//print_r($strategy);
					if($strategies_count == 1 && count($strategies[$cid]) > 1) { ?>
						<div class="read-more-content">
					<?php }
					
							
					if(isset($strategy['_objective']) && $strategy['_objective'] != $prev_objective) {
						$obj = get_model('objective')->getOne($strategy['_objective'], 'id');
						
						if($strategies_count > 0) {
						?>
						<div style="border-top: 1px #000 solid;">&nbsp;</div>
						<?php
						}
						
						?>
						
						
						
						<div id="obj_<?php echo $obj['id']; ?>"><h4><strong><?php echo $obj['description']; ?></strong></h4>
						<?php if((isset($objective['user_id']) && $objective['user_id'] == session('user')) || $objective['cid'] == session('user')){ ?>
							<ul class="list-inline table-action">
								<?php if ($currentUser->acl->has('editStrategy')) { ?><li><a href="<?php echo URL; ?>strategiestactics/editobjective/<?php echo $strategy['_objective']; ?>?rf=<?php echo $G->url; ?>" class="label label-default ajax-modal-form">Edit</a></li><?php } ?>
								<?php if ($currentUser->acl->has('editStrategy')) { ?><li><a href="<?php echo URL; ?>objective/delete/<?php echo $strategy['_objective']; ?>?rf=<?php echo $G->url . '#clp_' . $cid; ?>" class="label label-danger">Delete</a></li><?php } ?>
								
								<?php if ($currentUser->acl->has('addStrategy')) { ?><li><a href="<?php echo URL; ?>strategy/new/<?php echo $strategy['_objective']; ?>?rf=<?php echo $G->url; ?>" class="label label-primary ajax-modal-form">Add Strategy</a></li><?php } ?>
							</ul>
							<?php } ?>
						</div>
						
						<div class="row strategytactic-header">
							<div class="col-sm-6">
								<div class="col-md-10 col-sm-offset-1"><h5>Strategies</h5></div>
							</div>
							<div class="col-sm-6">
								<div class="col-md-8 col-sm-offset-1"><h5>Tactics</h5></div>
								<div class="col-sm-3 tactic-due-date"><h5>Due Date</h5></div>
							</div>
						</div>						
					<?php
						$prev_objective = $strategy['_objective'];
					}					
					
				?>
				<div id="sty_<?php echo $sid; ?>" class="row strategytactic">
					<div class="col-sm-6 strategy">
						
						<div class="col-md-10">
							<?php
							$assigned_user = '';
							if(isset($strategy['user_id']) && $strategy['user_id']) {
								$assigned_to = get_model("user")->getOne($strategy['user_id'], 'id');
								$assigned_user = $assigned_to["firstname"] . ' ' . $assigned_to["lastname"];
								$assigned_to_label_class = ($strategy['user_id'] == session('user')) ? 'label-me' : 'label-success';
							}
							
							?>						
							<div class="main-description strategy-title">							
							<?php echo Parsedown::instance()->parse($strategy['description']); ?></div>
							<?php if($assigned_user) { ?><span class="label <?php echo $assigned_to_label_class; ?>" style="margin-bottom: 5px;display: inline-block;"><?php echo $assigned_user; ?></span><?php } ?>
							
							<?php echo $sdates; ?>
							<?php if ($strategy['comment'] != '') { ?><div class="main-comment"><?php echo Parsedown::instance()->parse('<i class="fa fa-comment"></i> '.$strategy['comment']); ?></div><?php } ?>
							<?php echo $sattachments; ?>
							<?php if($strategy['user_id'] == session('user') || $strategy['cid'] == session('user')){ ?>
							<ul class="list-inline table-action">
								<?php if ($currentUser->acl->has('editStrategy') && $sdatelist['complete'] == '') { ?><li><a href="<?php echo URL; ?>strategy/edit/<?php echo $sid; ?>?rf=<?php echo $G->url; ?>" class="label label-default ajax-modal-form">Edit</a></li><?php } ?>
								<?php if ($currentUser->acl->has('editStrategy') && $sdatelist['complete'] == '') { ?><li><a href="<?php echo URL; ?>strategy/delete/<?php echo $sid; ?>?rf=<?php echo $G->url . '#clp_' . $cid; ?>" class="label label-danger">Delete</a></li><?php } ?>
								<?php if ($currentUser->acl->has('addAttachment')) { ?><li><a href="<?php echo URL; ?>attachment/new/<?php echo $sid; ?>?rf=<?php echo $G->url; ?>" class="label label-info  ajax-modal-form">Upload Attachment</a></li><?php } ?>
								<!--<?php if ($currentUser->acl->has('editStrategy') && $sdatelist['complete'] == '') { ?><li><a href="<?php echo URL; ?>strategy/complete/<?php echo $sid; ?>?rf=<?php echo $G->url; ?>" class="label label-success">Complete</a></li><?php } ?>-->
								<?php if (($currentUser->role == 'Super User' || $currentUser->role == 'Property Super User') || ($currentUser->acl->has('addTactic') && $strategy['user_id'] == session('user'))) { ?><li><a href="<?php echo URL; ?>tactic/new/<?php echo $sid; ?>?rf=<?php echo $G->url; ?>" class="label label-primary ajax-modal-form">Add Tactic(s)</a></li><?php } ?>
							</ul>
							<?php } ?>
						</div>
					</div>
					<div class="col-sm-6 tactics">
							<?php if ($G->user->acl->has('viewTactic')) { ?>
								<?php foreach ($tactics[$sid] as $tid => $tactic) { ?>
								<?php	$tdates = array(
										'due' => $tactic['due'],
										'complete' => $tactic['complete']
									);
									$due_changed_class = '';
									foreach ($tdates as $datetype => $date) {
										if ($date != '') {
											//$tempdate = date('Y/m/d', $date);
											$tempdate = date('M d, Y', $date);
											$tdates[$datetype] = $tempdate;
											
											if($datetype == 'due') {
												$now = new DateTime();
												//echo $now->getTimestamp() . '--' . $date;
												if($date < $now->getTimestamp()  && $tactic['complete'] == '') {
													$due_changed_class = 'due-changed';
												}
											}
											
										}
									}
									if ($tdates['due'] != '') {
										
										/* $due_changed_class = '';
										if(isset($tactic['past_due']) && $tactic['complete'] == '') {
											$due_changed_class = 'due-changed';
										} */
										$tdates['due'] = '<div class="main-date '.$due_changed_class.'">'.$tdates['due'].'</div>';
										
									}
									if ($tdates['complete'] != '') {
										$tdates['complete'] = '<p><small><strong>Completed<br>'.$tdates['complete'].'</strong></small></p>';
									}
									$tattachments = NULL;
									$attachments[$tid] = $tactic['_attachments'];
									if ($G->user->acl->has('viewAttachment')) {
										if (isset($attachments[$tid])) {
											if (count($attachments[$tid]) > 0) {
												$tattachments = '<ul class="attachment-list">';
											}
											foreach ($attachments[$tid] as $attachment) {
												$tattachments .= '<li><i class="fa fa-file-text"></i> <a href="'.UPLOAD_URL.$attachment['path'].'"  target="_new">';
												if ($attachment['name'] != '') {
													$tattachments .= $attachment['name'];
												} else {
													$tattachments .= substr($attachment['path'], strrpos($attachment['path'], '/'));
												}
												$tattachments .= '</a>';
												
												if ($currentUser->acl->has('addAttachment') || $G->user->acl->has('addAttachment')) {
													$tattachments .= ' <a class="label label-danger " href="'.URL.'attachment/delete/'.$attachment['id'].'?rf='.$G->url. '#sty_' . $sid.'">Delete</a>';
												}
												
												$tattachments .= '</li>';
												
											}
											if (count($attachments[$tid]) > 0) {
												$tattachments .= '</ul>';
											}
										}
									}
									
									$assigned_user = '';
									if(isset($tactic['user_id']) && $tactic['user_id']) {
										$assigned_to = get_model("user")->getOne($tactic['user_id'], 'id');
										$assigned_user = $assigned_to["firstname"] . ' ' . $assigned_to["lastname"];
										$assigned_to_label_class = ($tactic['user_id'] == session('user')) ? 'label-me' : 'label-success';
									}
									
								?>
								<div class="row tactic">
									<div class="col-md-9 tactic-info">
										<div class="main-description tactic-title"><?php echo Parsedown::instance()->parse($tactic['description']); ?></div>
										<?php if($assigned_user) { ?><span class="label <?php echo $assigned_to_label_class; ?>" style="margin-bottom: 5px;display: inline-block;"><?php echo $assigned_user; ?></span><?php } ?>
										<?php 
											if ($tactic['comment'] != '') { 
												
												$progress_notes = unserialize(base64_decode($tactic["comment"]));
												
												$notes = '<div class="main-comment">';
												if(count($progress_notes) > 0) {
													foreach($progress_notes as $note) {
														
														$notes .= '<p><i class="fa fa-comment"></i><span>Posted On: <strong>'.date("M d, Y", $note["dt"]).'</strong></span> <br/>'.Parsedown::instance()->parse($note["notes"]).'</p>';				
													}
													$notes .= "</div>";
												}
												echo $notes;
											} 
										?>										
										<?php echo $tattachments; ?>
										<?php if(($currentUser->role == 'Super User' || $currentUser->role == 'Property Super User') || $strategy['user_id'] == session('user') || $tactic['user_id'] == session('user') ){ ?>
										<ul class="list-inline table-action">
											<?php if ($currentUser->acl->has('editTactic') && $tdates['complete'] == '') { ?><li><a href="<?php echo URL; ?>tactic/edit/<?php echo $tid; ?>?rf=<?php echo $G->url; ?>" class="label label-default ajax-modal-form">Edit</a></li><?php } ?>
											<?php if ($currentUser->acl->has('editTactic') && $tdates['complete'] == '') { ?><li><a href="<?php echo URL; ?>tactic/delete/<?php echo $tid; ?>?rf=<?php echo $G->url. '#sty_' . $sid; ?>" class="label label-danger">Delete</a></li><?php } ?>
											<?php if ($currentUser->acl->has('addAttachment')) { ?><li><a href="<?php echo URL; ?>attachment/new/<?php echo $tid; ?>?rf=<?php echo $G->url; ?>" class="label label-info  ajax-modal-form">Upload Attachment</a></li><?php } ?>
											<?php if ($currentUser->acl->has('editTactic') && $tdates['complete'] == '') { ?><li><a href="<?php echo URL; ?>tactic/complete/<?php echo $tid; ?>?rf=<?php echo $G->url; ?>" class="label label-success ajax-modal-form">Complete</a></li><?php } ?>
											<?php if ($currentUser->acl->has('editTactic') && $tdates['complete'] != '') { ?><li><a href="<?php echo URL; ?>tactic/reopen/<?php echo $tid; ?>?rf=<?php echo $G->url; ?>" class="label label-success">Re-Open</a></li><?php } ?>
											<?php if ($currentUser->acl->has('editTactic')) { ?><li><a href="<?php echo URL; ?>tactic/notes/<?php echo $tid; ?>?rf=<?php echo $G->url; ?>" class="label label-default ajax-modal-form">Notes</a></li><?php } ?>
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
					$strategies_count++;
				}

				if($strategies_count > 1) {
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
	<?php if (count($items) > 0){?>
	<div class="text-center">
	<a href="<?php echo URL; ?>strategiestactics/send/<?php echo $G->user->id; ?>?rf=<?php echo $G->url; ?>" id="truenorth-submit" class="btn btn-primary">Submit</a>
	</div>
	<?php } ?>
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


<div id="modalSubmit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Submit Confirmation" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Submission Confirmation</h4>
			</div>
			<div class="modal-body">
				Are you sure you want to submit this? This action cannot be undone.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</div>
</div>

<div id="modalReopen" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Submit Confirmation" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Re-open Confirmation</h4>
			</div>
			<div class="modal-body">
				Are you sure you want to re-open this tactic?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary">Yes</button>
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