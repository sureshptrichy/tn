<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
if (count($summary) < 1) {
	?><p><em>There are no user submitted data.</em></p><?php
} else {	
	?>
	
	
	<p class="lead">True North Summary - <?php echo session('year'); ?></p>
	
	<div class="table-responsive"><table class="table table-striped table-hover" border="1" cellspacing="1" cellpadding="1" style="border-color:#e6e6e6;" id="summary-list">
		<thead>
		<tr>
			<th>Name</th><th>&nbsp;</th>
			<?php 	
			for($m=1; $m<=12; ++$m){
				echo "<th>" . date('M', mktime(0, 0, 0, $m, 1)) . "</th>";
			}
			?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($summary as $id => $summary_data) { ?>
			
			<tr>
			<td rowspan="2" style="vertical-align: middle;"><?php echo $summary_data[0]; ?><td>Submitted</td>
			<?php 
			for($m=1; $m<=12; ++$m){
				$submitted = (array_key_exists($m, $summary_data[1]) && $summary_data[1][$m][0]) ? $summary_data[1][$m][0] : '';
				echo "<td style='text-align: center;'>" . $submitted . "</td>";
			}
			?>			
			</tr>
			<tr>
			<td>Approved</td>
			<?php 
			for($m=1; $m<=12; ++$m){
				$approved = (array_key_exists($m, $summary_data[1]) && $summary_data[1][$m][1]) ? $summary_data[1][$m][1] : '';
				echo "<td style='text-align: center;'>" . $approved . "</td>";
			}
			?>			
			</tr>
			
		<?php } ?>
		</tbody>
	</table></div>

<?php
}
?>
