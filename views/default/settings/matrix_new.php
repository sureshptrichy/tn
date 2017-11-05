<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>

<?php
if (isset($matrixId)){?>
<li class="matrix-item">
	Results/Culture Matrix
	<input type="hidden" value="<?php echo $matrixId;?>" name="subevaluations[]" />
</li>
<?php }?>