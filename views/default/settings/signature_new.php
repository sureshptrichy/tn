<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>

<?php
if (isset($signId)){?>
<li class="signature-item">
	Signature
	<input type="hidden" value="<?php echo $signId;?>" name="subevaluations[]" />
</li>
<?php }?>