<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>

<?php
if (isset($id)){?>
<li class="static-item">
	<span class="static-content">
		<span class="static-content-edit">
			<a class="static-content-link" href="/settings/compiledforms/static/edit/<?php echo $id;?>">Edit</a>
		</span>
		<?php echo $name;?>
	</span>
	<input type="hidden" value="<?php echo $id;?>" name="subevaluations[]" />
</li>
<?php } else {
	echo $staticForm->html();
}
?>
