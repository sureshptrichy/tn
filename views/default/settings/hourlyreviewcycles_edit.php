<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));

switch ($step) {
	case 1:
		$formList = array();
		echo $form->html();
		break;
	case 2:
		echo $form->html();
		break;
	case 3:
		//echo $form->html();
		
		//print_r($hourlies);exit;
		
		?>
		
		<form class="form form-reviewcycle has-validation-callback" action="" role="form" method="post" autocomplete="off" enctype="multipart/form-data"><h2 class="form-reviewcycle-heading">Edit Hourly Review Cycle</h2>
		<div class="form-group"><h3>Review the below details before launching the review cycle.</h3></div>
		
<div class="table-responsive"><table class="table table-striped table-hover">
	<thead>		
	<tr>
			<th>Name</th>
			<th>Position</th>
			<th>Department</th>
			<th>Manager/Evaluator</th>
			<th>Review Cycle</th>
			<th>Review Form</th>
			<th>Completed</th>
		</tr>
			</thead>
			<tbody>
		<?php 
		
		if(count($hourly_forms) > 0) {
			foreach ($hourly_forms as $id => $hourly) { ?>
				<tr>
					<td>
						<p class="col-text"><?php echo $hourly->hourly_name; ?></p>					
					</td>
					<td>
						<p class="col-text"><?php echo $hourly->hourly_position; ?></p>					
					</td>
					<td>
						<p class="col-text"><?php echo $hourly->hourly_department; ?></p>					
					</td>
					<td>
						<p class="col-text">
						<?php if($hourly->status == 1) {  
								echo $hourly->manager_name; 
							} else { ?>
								<select name="manager[<?php echo $id; ?>]" required >
								<?php foreach($managers as $manager) { 
										$manager_name = $manager['firstname'] . ' ' . $manager['lastname'];
										$selected = ($manager['id'] == $hourly->manager_id) ? 'selected' : ''; 
								?>
										<option value="<?php echo $manager_name . '@@@' . $manager['username'] . '@@@' . $manager['id']; ?>" <?php echo $selected; ?>><?php echo $manager_name; ?></option>
								<?php } ?>
								</select>
						<?php } ?>
						</p>					
					</td>
					<td>
						<p class="col-text"><?php echo $hourly->review_cycle; ?></p>					
					</td>
					<td><p class="col-text">
					<?php if($hourly->status == 1) {  
								echo $hourly->reviewform_name; 
							} else { ?>
								<select name="review_form[<?php echo $id; ?>]" required>
								<?php foreach($review_forms as $review_form) { 
										
										$selected = ($review_form['code'] == $hourly->reviewform_code) ? 'selected' : ''; 
								?>
										<option value="<?php echo $review_form['code'] . '@@@' . $review_form['id'] . '@@@' . $review_form['name']; ?>" <?php echo $selected; ?>><?php echo $review_form['name']; ?></option>
								<?php } ?>
								</select>
						<?php } ?>
						</p>					
					</td>
					<td>
						<p class="col-text"><?php echo ($hourly->status == 1) ? '<i class="fa fa-check"></i>' : ''; ?></p>					
					</td>
				</tr>
			<?php 
			}			
		}
		else {
			foreach ($hourlies as $id => $hourly) { ?>
				<tr>
					<td>
						<p class="col-text"><?php echo $hourly['Name']; ?></p>					
					</td>
					<td>
						<p class="col-text"><?php echo $hourly['Position']; ?></p>					
					</td>
					<td>
						<p class="col-text"><?php echo $hourly['Department']; ?></p>					
					</td>
					<td>
						<p class="col-text">
						<select name="manager[]" required>
						<?php foreach($managers as $manager) { 
								$manager_name = $manager['firstname'] . ' ' . $manager['lastname'];
								$selected = ($manager['username'] == $hourly['Manager/Evaluator Email']) ? 'selected' : ''; 
						?>
								<option value="<?php echo $manager_name . '@@@' . $manager['username'] . '@@@' . $manager['id']; ?>" <?php echo $selected; ?>><?php echo $manager_name; ?></option>
						<?php } ?>
						</select>
						</p>					
					</td>
					<td>
						<p class="col-text"><?php echo $hourly['Review Cycle']; ?></p>					
					</td>
					<td>
						<select name="review_form[]" required>
						<?php foreach($review_forms as $review_form) { 
								
								$selected = ($review_form['code'] == $hourly['Review Form Code']) ? 'selected' : ''; 
						?>
								<option value="<?php echo $review_form['code'] . '@@@' . $review_form['id'] . '@@@' . $review_form['name']; ?>" <?php echo $selected; ?>><?php echo $review_form['name']; ?></option>
						<?php } ?>
						</select>
						</p>					
					</td>
				</tr>
			<?php 
			}
		}
		?>
		</tbody>
	</table></div>
<?php if(count($hourly_forms) > 0) { ?>	
	<div class="form-group"><button name="continue" value="save" class="btn btn-lg btn-primary btn-block" type="submit">Save</button></div>
<?php } else { ?>
	<div class="form-group"><button name="continue" value="launch" class="btn btn-lg btn-primary btn-block" type="submit">Launch</button></div>
	
<?php } ?>	
	
	
	<button name="reset" class="btn btn-warning" type="reset">Reset</button></form>
		
		<?php
		break;
	case 4:
		echo $form->html();
		break;
	case 5:
		echo $form->html(); ?>
		<div id="reviewcyclePeerList" class="table-responsive">
			<table id="peerList" class="table table-striped table-hover">
				<tr>
					<th class="topcorner">&nbsp;</th>
				</tr>
				<?php foreach ($users as $id => $user) {?>
				<tr>
					<td id="" class=""><?php echo $user->firstname . ' ' . $user->lastname; ?></td>
				</tr>
				<?php } ?>
			</table>
			<table class="table table-striped table-hover">
				<tr>
					<th class="topcorner">&nbsp;</th>
					<?php foreach ($users as $id => $user) {
						?><th id="x-<?php echo $id; ?>" class="peerBy"><?php echo $user->firstname . ' ' . $user->lastname; ?></th><?php
					} ?>
					<th class="noRotate">Additional Peer Email Addresses</th>
				</tr>
				<?php foreach ($users as $yId => $yUser) {
					$emailList = '';
					if (array_key_exists($yId, $emails)) {
						$emailList = implode(', ', $emails[$yId]);
					} ?>
				<tr>
					<td nowrap="nowrap" id="y-<?php echo $yId; ?>" class="peerFor"></td>
					<?php foreach ($users as $xId => $xUser) {
						$class = '';
						if ($xId != $yId) {
							$class = 'peerSelect';
						}
						?><td id="<?php echo $xId . '-' . $yId; ?>" class="<?php echo $class; ?>"></td><?php
					} ?>
					<td nowrap="nowrap" ><input type="text" class="peerEmailSelector" name="<?php echo $yId; ?>-emails" value="<?php echo $emailList; ?>" /></td>
				</tr>
				<?php } ?>
			</table>
		</div>

<?php
		break;
	case 6:
		echo $form->html();
		break;
	case 7:
		echo $form->html();
		break;
}
