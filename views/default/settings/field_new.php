<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>

<div class="panel panel-default subeval-field <?php echo md5(rand());?>">
	<div class="panel-heading"><h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#clp_<?php echo $subevalComponentForm->id();?>" >Field Info</a></h3></div>
	<div id="clp_<?php echo $subevalComponentForm->id();?>" class="panel-collapse collapse in">
	<div class="panel-body">
		<?php echo $subevalComponentForm->html(); ?>
		<?php if ($currentUser->acl->has('editSubevaluation')) { ?><a href="#<?php echo $subevalComponentForm->id(); ?>" class="btn btn-sm btn-danger field-remove" name="field-remove">Remove</a><?php } ?>
	</div>
</div>