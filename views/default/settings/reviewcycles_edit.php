<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));

switch ($step) {
	case 1:
		$formList = array();
		foreach ($setup as $formType => $sections) {
			foreach ($sections as $sectionId => $forms) {
				if (!array_key_exists($formType . '-' . $sectionId, $forms)) {
					$formList[$formType . '-' . $sectionId] = '';
				}
				foreach ($forms as $formId => $formName) {
					$formList[$formType . '-' . $sectionId] .= '<a href="#" class="rcCompiledFormsRemove" data-id="' . $formId . '" data-name="' . $formName . '" data-field="' . $formType . '-' . $sectionId . '">' . $formName . ' <i class="fa fa-times"></i></a><br>';
				}
			}
		}

		echo $form->html(); ?>
<div id="reviewcycleDivisionList" class="table-responsive">
	<table class="table table-striped table-hover">
		<tr>
			<th nowrap>Division / Department</th>
			<th nowrap>Management Review Forms</th>
			<th nowrap>Associate Review Forms</th>
		</tr>
		<?php
		foreach ($divisions as $divId => $division) {
			?>
			<tr id="<?php echo $divId; ?>">
				<td nowrap><p class="lead"><?php echo $division['name']; ?></p></td>
				<td class="me"><?php if (array_key_exists('me-'.$divId, $formList)) {echo $formList['me-'.$divId];} ?>
					<ul class="list-inline table-action">
						<?php if (user_has('addReviewcycle')){?>
							<li><a href="<?php echo $addFormUrl; ?>" class="label label-default" data-action="me">Add</a></li>
						<?php } ?>
					</ul>
				</td>
				<td class="ae"><?php if (array_key_exists('ae-'.$divId, $formList)) {echo $formList['ae-'.$divId];} ?>
					<ul class="list-inline table-action">
						<?php if (user_has('addReviewcycle')){?>
							<li><a href="<?php echo $addFormUrl; ?>" class="label label-default" data-action="ae">Add</a></li>
						<?php } ?>
					</ul>
				</td>
			</tr>
			<?php
			foreach ($division['_departments'] as $depId => $department) {
				?>
				<tr id="<?php echo $depId; ?>">
					<td nowrap><p><?php echo $department['name']; ?></p></td>
					<td class="me"><?php if (array_key_exists('me-'.$depId, $formList)) {echo $formList['me-'.$depId];} ?>
						<ul class="list-inline table-action">
							<?php if (user_has('addReviewcycle')){?>
								<li><a href="<?php echo $addFormUrl; ?>" class="label label-default" data-action="me">Add</a></li>
							<?php } ?>
						</ul>
					</td>
					<td class="ae"><?php if (array_key_exists('ae-'.$depId, $formList)) {echo $formList['ae-'.$depId];} ?>
						<ul class="list-inline table-action">
							<?php if (user_has('addReviewcycle')){?>
								<li><a href="<?php echo $addFormUrl; ?>" class="label label-default" data-action="ae">Add</a></li>
							<?php } ?>
						</ul>
					</td>
				</tr>
			<?php
			}
			?>
		<?php
		}
		?>
	</table>
</div>

<!--
	<div class="table-responsive"><table class="table table-striped table-hover">
		<tr>
			<th nowrap>Division / Department</th>
			<th nowrap>Management Review Form</th>
			<th nowrap>Associate Review Form</th>
		</tr>
		<tr id="{thing-id}">
			<td nowrap><p class="lead">{thing-name}</p></td>
			<td class="mrf"></td>
			<td class="arf"></td>
		</tr>
	</table></div>
</form>
-->

<div class="modals">
	<div id="modalRCAddForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Add Compiled Form to Review" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Add Compiled Form to Review</h4>
				</div>
				<div class="modal-body">
					Select a compiled form to add to this Division or Department:
					<div id="rcformlist">Loading...</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<!--<button type="button" class="btn btn-primary">Add</button>-->
				</div>
			</div>
		</div>
	</div>
</div>
<?php
		break;
	case 2:
		echo $form->html();
		break;
	case 3:
		echo $form->html();
		break;
	case 4:
		echo $form->html();
		break;
	case 5:?>
	<div id="rcLaunchLog"></div>
	<?php
	//echo $form->html();
/* 		echo $form->html(); ?>
		<div id="reviewcyclePeerList" class="table-responsive">
			<table id="peerList" class="table table-striped table-hover">
				<tr>
					<th class="topcorner">&nbsp;</th>
				</tr>
				<?php foreach ($users as $id => $user) {?>
				<tr>
					<td id="" class=""><?php echo $user->firstname . ' ' . $user->lastname; ?></td>
				</tr>
				<?php } ?>
			</table>
			<table class="table table-striped table-hover">
				<tr>
					<th class="topcorner">&nbsp;</th>
					<?php foreach ($users as $id => $user) {
						?><th id="x-<?php echo $id; ?>" class="peerBy"><?php echo $user->firstname . ' ' . $user->lastname; ?></th><?php
					} ?>
					<th class="noRotate">Additional Peer Email Addresses</th>
				</tr>
				<?php foreach ($users as $yId => $yUser) {
					$emailList = '';
					if (array_key_exists($yId, $emails)) {
						$emailList = implode(', ', $emails[$yId]);
					} ?>
				<tr>
					<td nowrap="nowrap" id="y-<?php echo $yId; ?>" class="peerFor"></td>
					<?php foreach ($users as $xId => $xUser) {
						$class = '';
						if ($xId != $yId) {
							$class = 'peerSelect';
						}
						?><td id="<?php echo $xId . '-' . $yId; ?>" class="<?php echo $class; ?>"></td><?php
					} ?>
					<td nowrap="nowrap" ><input type="text" class="peerEmailSelector" name="<?php echo $yId; ?>-emails" value="<?php echo $emailList; ?>" /></td>
				</tr>
				<?php } ?>
			</table>
		</div>

<?php
		break;  
	case 6:
		echo $form->html();
		break;
	case 7: */
		//echo $form->html();
		break;
}
