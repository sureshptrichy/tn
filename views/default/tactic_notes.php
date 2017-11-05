<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>
<?php if ($G->url->ajax) { ?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Add Notes</h4>
		</div>
		<div class="modal-body">
<?php } echo $tacticForm->html(); if ($G->url->ajax) { ?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div>
	</div>
</div>
<?php } ?>
