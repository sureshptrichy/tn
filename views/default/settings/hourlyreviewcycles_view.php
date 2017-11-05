<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));

?>
		
		<form class="form form-reviewcycle has-validation-callback" action="" role="form" method="post" autocomplete="off" enctype="multipart/form-data"><h2 class="form-reviewcycle-heading">View Hourly Review Cycle</h2>
		
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
						<p class="col-text"><?php echo $hourly->manager_name; ?></p>					
					</td>
					<td>
						<p class="col-text"><?php echo $hourly->review_cycle; ?></p>					
					</td>
					<td>
						<p class="col-text"><?php 
						if($hourly->status == 1) {
						?>
							<a href="<?php echo URL; ?>settings/hourlyreviewcycles/review/<?php echo $hourly->id; ?>"><?php echo $hourly->reviewform_name; ?></a>
						<?php
						} else {						
							echo $hourly->reviewform_name;
						}						?></p>					
					</td>
					<td>
						<p class="col-text"><?php echo ($hourly->status == 1) ? '<i class="fa fa-check"></i>' : ''; ?></p>					
					</td>
				</tr>
			<?php 
			}			
		}
		
		?>
		</tbody>
	</table></div>

