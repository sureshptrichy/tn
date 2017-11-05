<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));

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
				<td class="me">
					<ul class="list-inline table-action">
						<?php if (user_has('addReviewcycle')){?>
							<li><a href="<?php echo $addFormUrl; ?>" class="label label-default" data-action="me">Add</a></li>
						<?php } ?>
					</ul>
				</td>
				<td class="ae">
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
					<td class="me">
						<ul class="list-inline table-action">
							<?php if (user_has('addReviewcycle')){?>
								<li><a href="<?php echo $addFormUrl; ?>" class="label label-default" data-action="me">Add</a></li>
							<?php } ?>
						</ul>
					</td>
					<td class="ae">
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
