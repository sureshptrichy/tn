<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>
		<div id="footer">
			<div class="col-md-4"><p>True North Performance Management</p></div>
			<div class="col-md-4 mid"><p>Powered by <a href="http://www.commerx.com" target="_new" >Commerx</a></p></div>
			<div class="col-md-4 last"><img class="footer-logo" src="<?php echo THEME_URL; ?>images/truenorth-logo.jpg" /></div>
		</div>
		</div>
	</div>
</div>
<div id="modalDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Delete Confirmation" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Delete Confirmation</h4>
			</div>
			<div class="modal-body">
				Are you sure you want to delete this? This action cannot be undone.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary">Delete</button>
			</div>
		</div>
	</div>
</div>
<div id="modalComplete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Completion Confirmation" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Completion Confirmation</h4>
			</div>
			<div class="modal-body">
				This Strategy will be marked as <strong>Complete</strong>. This action cannot be undone.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary">Complete</button>
			</div>
		</div>
	</div>
</div>


<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.47/jquery.form-validator.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo THEME_URL; ?>js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
<script src="<?php echo THEME_URL; ?>js/vendor/bootstrap-datepicker.<?php echo $revision; ?>.js"></script>
<script src="<?php echo THEME_URL; ?>js/plugins.<?php echo $revision; ?>.js"></script>
<script src="<?php echo THEME_URL; ?>js/vendor/retina-1.1.0.min.<?php echo $revision; ?>.js"></script>
<script src="<?php echo THEME_URL; ?>js/vendor/jstz-1.0.4.min.<?php echo $revision; ?>.js"></script>
<script src="<?php echo THEME_URL; ?>js/XMLHttpRequest.<?php echo $revision; ?>.js"></script>
<script src="<?php echo THEME_URL; ?>js/reviewcycles.<?php echo $revision; ?>.js"></script>
<script src="//cdn.ckeditor.com/4.5.11/basic/ckeditor.js"></script>
<script src="<?php echo THEME_URL; ?>js/browser-close1.<?php echo $revision; ?>.js"></script>
<script src="<?php echo THEME_URL; ?>js/vendor/jquery.tablesorter.min.<?php echo $revision; ?>.js"></script>
<script src="<?php echo THEME_URL; ?>js/vendor/jquery.cycle2.<?php echo $revision; ?>.js"></script>
	<script type="text/javascript">
	
	$(function() {
		$("table.tablesorter").tablesorter();
		$('.cycle-slideshow div:gt(0)').hide();
		
		
		var type_id = window.location.hash.substr(1);
		if(type_id) {
			if($("#" + type_id).hasClass("panel-collapse")) {
				var parent_obj = $("#" + type_id);
				$('#' + type_id).find(".read-more-toggle").trigger("click");
			} else {
				$('#' + type_id).parentsUntil(".panel-collapse").find(".read-more-toggle").trigger("click");
				var parent_obj = $('#' + type_id).parentsUntil(".panel-collapse");
				
			}
			
			$("html, body").animate({ scrollTop: parent_obj.offset().top }, 100);
		}		
		
	});
	</script>
	

</body>
</html>
