<div class="panel panel-primary">
	<div class="panel-body">
		<?php
		if (count($forms) > 0) {
			foreach ($forms as $id => $form) {
				?><a href="#" data-id="<?php echo $id; ?>" data-parent="<?php echo $parent; ?>" data-type="<?php echo $formType; ?>" data-name="<?php echo $form['name']; ?>" class="rcCompiledForms"><?php echo $form['name']; ?></a><br><?php
			}
		} else {
			?><p>There are no available forms.</p><?php
		}
		?>
	</div>
</div>
