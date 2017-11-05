<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>

<div class="panel panel-default subeval-field">
	<div class="panel-heading"><h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_<?php echo $fieldId;?>" ><?php if(isset($fieldName)){ echo $fieldName;} else { echo 'Field Info';}?></a></h3></div>
	<div id="clp_<?php echo $fieldId;?>" class="panel-collapse collapse in">
	<div class="panel-body">
		<?php echo $subevalComponentForm->html(); ?>
		<?php if ($currentUser->acl->has('editSubevaluation')) { ?><a href="/settings/subevaluations/field/deletecomponent/<?php echo $fieldId; ?>" class="btn btn-sm btn-danger field-delete" name="field-delete">Delete</a><?php } ?>
	</div>
</div>