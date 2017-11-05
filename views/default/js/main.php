<?php header('Content-Type', 'application/javascript');?>
$(document).ready(function() {
	"use strict";
	$('#main-nav-wrapper').height($('#main-nav').height());
	$('#main-nav').affix({
		offset: {
			top: $('#main-nav').offset().top
		}
	});
	$('#side-nav').affix({
		offset: {
			top: $('#page-title').offset().top + 6
		}
	});
	$('a[href*="/delete/"]').click(function(e) {
		e.preventDefault();
		$('#modalDelete').modal('show');
		$('#modalDelete .btn-primary').click(function(ev) {
			top.location.href = e.target.href;
		});
	});
	$('input[type="date"]').datepicker({
		format: "yyyy/mm/dd",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
	$('.panel-unhide').click(function(e) {
		e.preventDefault();
		$('.panel-hidden').removeClass('panel-hidden').addClass('panel-unhidden');
		$('.panel-unhide').css('display', 'none');
	});
	
	$('#division').change(function() {
		var formObj = $(this).val();
		alert("<?php echo $this->G; ?>");
		var url = "<?php echo THEME_URL; ?>user_new.php?"+formObj;
		/*$.ajax({
			dataType: "JSON",
			type: "POST",
			url: url,
			data: {division_id:formObj},
			success: function(data){
				alert(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});*/
	});
});
