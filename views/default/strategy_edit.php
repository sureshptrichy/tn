<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>
<?php if ($G->url->ajax) { ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Edit Strategy</h4>
		</div>
		<div class="modal-body">
<?php } echo $strategyForm->html(); if ($G->url->ajax) { ?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div>
	</div>
</div>
<?php } 

$start_date = '';
$end_date = '';

if($objective) {
$start_date = date("m/d/Y", $objective["start"]);
$end_date = date("m/d/Y", $objective["due"]);
}

?>
<script >
$(document).ready(function() {
    $("#strategy-form #start").datepicker({
        autoclose: true,
		startDate: '<?php echo $start_date; ?>',
		endDate: '<?php echo $end_date; ?>'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#strategy-form #due').datepicker('setStartDate', minDate);
    });
    
    $("#strategy-form #due").datepicker({
        autoclose: true,
		startDate: '<?php echo $start_date; ?>',
		endDate: '<?php echo $end_date; ?>'		
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#strategy-form #start').datepicker('setEndDate', minDate);
    });
});	
</script>