$(document).ready(function() {
	'use strict';

	// Fix layout on Add/Edit page.
	$('.form-reviewcycle .form-group:last').before($('#reviewcycleDivisionList'));

	// Fix layout on Peer Selection page.
	$('.form-reviewcycle .form-group:last').before($('#reviewcyclePeerList'));

	// Fix layout on Manager Selection page.
	$('.form-reviewcycle .form-group:last').before($('#reviewcycleManagerList'));

	
	// Enable modals.
	$(document).on('click', 'a.ajax-modal-form', function(e){
		e.preventDefault();
		$('#modalStrategyAddForm .modal-body').html('<p>Loading...</p>');
		$('#modalStrategyAddForm').modal('show');
		var url = e.target.href;
		$.ajax({
			dataType: 'html',
			type: 'GET',
			url: url,
			success: function(data) {
				$('#modalStrategyAddForm').html(data);	
				//$('#description').ckeditor();
				if($("#description").length > 0) CKEDITOR.replace( 'description', {height:150} );
				if($("#description2").length > 0) CKEDITOR.replace( 'description2', {height:150} );
				if($("#description3").length > 0) CKEDITOR.replace( 'description3', {height:150} );
				if($("#description4").length > 0) CKEDITOR.replace( 'description4', {height:150} );
				if($("#description5").length > 0) CKEDITOR.replace( 'description5', {height:150} );
				if($("#comment").length > 0) CKEDITOR.replace( 'comment', {height:150} );
				setTimeout(function(){
						$('#modalStrategyAddForm input.datepicker').hover(function(){
								$(this).datepicker({
									format: 'mm/dd/yyyy',
									todayBtn: 'linked',
									autoclose: true,
									todayHighlight: true
								});
								if($(this).attr('id') == 'due') {
									var startdate = $('input#start').val();
									if (startdate != null){
										var duedate = $(this).val();
										if (startdate != '' && duedate == ''){
											$(this).val(startdate);
											$(this).datepicker('update', new Date(startdate));
										}
									}
								}
							});
							$.validate({
								modules: 'date, security',
								validateOnBlur: false
							});
						}, 100);				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});
	});	
	
	// Enable modals.
	$(document).on('click', '#reviewcycleDivisionList a[data-action]', function(e){
		e.preventDefault();
		var parentId = $(this).closest('tr').attr('id');
		var formType = $(this).attr('data-action');
		$('#rcformlist').html('<p>Loading...</p>');
		$('#modalRCAddForm').modal('show');
		var url = e.target.href + '/' + formType + '/' + parentId + '?used=' + $('input[name=' + formType + '-' + parentId + ']').val();
		$.ajax({
			dataType: 'html',
			type: 'GET',
			url: url,
			success: function(data) {
				$('#rcformlist').html(data);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			}
		});
	});

	// Enable form selection.
	$(document).on('click', '.rcCompiledForms', function(e) {
		e.preventDefault();
		var formId = $(this).attr('data-id'),
			formType = $(this).attr('data-type'),
			formParentId = $(this).attr('data-parent'),
			formName = $(this).attr('data-name'),
			hiddenField = '';
		hiddenField = formType + '-' + formParentId;
		$('input[name=' + hiddenField + ']').val($('input[name=' + hiddenField + ']').val() + ',' + formId + ':' + formName);
		$('#' + formParentId + ' .' + formType).prepend('<a href="#" class="rcCompiledFormsRemove" data-id="' + formId + '" data-name="' + formName + '" data-field="' + hiddenField + '">' + formName + ' <i class="fa fa-times"></i></a><br>');
		$('#modalRCAddForm').modal('hide');
	});
	$(document).on('click', '.rcCompiledFormsRemove', function(e) {
		e.preventDefault();
		var formId = $(this).attr('data-id'),
			formName = $(this).attr('data-name'),
			hiddenField = $(this).attr('data-field'),
			val;
		val = $('input[name=' + hiddenField + ']').val();
		val = val.replace(',' + formId + ':' + formName, '');
		$('input[name=' + hiddenField + ']').val(val);
		$(this).remove();
	});

	// Enable Peer selection.
	$('.peerSelect').mouseenter(function() {
		$(this).addClass('peerOver');
	}).mouseleave(function() {
		$(this).removeClass('peerOver');
	});
	$(document).on('click', '.peerSelect', function(e) {
		e.preventDefault();
		var selected = $(this).attr('data-selected');
		if (selected == 1) {
			// Deselect this peer.
			selected = 0;
		} else {
			// Select this peer.
			selected = 1;
		}
		if (selected == 0) {
			$(this).html('');
			$('input[name=' + $(this).attr('id') + ']').val('0');
			$(this).attr('data-selected', '0');
		} else {
			$(this).html('<i class="fa fa-check"></i>');
			$('input[name=' + $(this).attr('id') + ']').val('1');
			$(this).attr('data-selected', '1');
		}
	});
	$('.peerSelector').each(function() {
		if ($(this).val() == 1) {
			$('#' + $(this).attr('name')).html('<i class="fa fa-check"></i>');
			$('#' + $(this).attr('name')).attr('data-selected', '1');
		} else {
			$('#' + $(this).attr('name')).attr('data-selected', '0');
		}
	});

	// Enable Manager selection.
	$('.managerSelect').mouseenter(function() {
		$(this).addClass('managerOver');
	}).mouseleave(function() {
		$(this).removeClass('managerOver');
	});
	$(document).on('click', '.managerSelect', function(e) {
		e.preventDefault();
		var selected = $(this).attr('data-selected');
		if (selected == 1) {
			// Deselect this peer.
			selected = 0;
		} else {
			// Select this peer.
			selected = 1;
		}
		if (selected == 0) {
			$(this).html('');
			$('input[name=' + $(this).attr('id') + ']').val('0');
			$(this).attr('data-selected', '0');
		} else {
			$(this).html('<i class="fa fa-check"></i>');
			$('input[name=' + $(this).attr('id') + ']').val('1');
			$(this).attr('data-selected', '1');
		}
	});
	$('.managerSelector').each(function() {
		if ($(this).val() == 1) {
			$('#' + $(this).attr('name')).html('<i class="fa fa-check"></i>');
			$('#' + $(this).attr('name')).attr('data-selected', '1');
		} else {
			$('#' + $(this).attr('name')).attr('data-selected', '0');
		}
	});

	// Enable launch.
	var rcLaunch = $('.tn-'+baseDir+'settings-reviewcycles-edit #rcLaunchLog');
	var launchContent = rcLaunch.html();
	if (launchContent !== undefined) {
		rcLaunch.html('<p>Contacting server...</p>');
		$(function() {
			var lastResponseLen = false,
				xhr = new XMLHttpRequest();
			xhr.open('GET', window.location + '?ajax=true', true);
			xhr.send(null);
			var timer;
			timer = window.setInterval(function() {
				if (xhr.readyState === XMLHttpRequest.DONE) {
					window.clearTimeout(timer);
				}
				var thisResponse, response = xhr.responseText;
				if (lastResponseLen === false) {
					thisResponse = response;
					lastResponseLen = response.length;
					rcLaunch.html('');
				} else {
					thisResponse = response.substring(lastResponseLen);
					lastResponseLen = response.length;
				}
				rcLaunch.append(thisResponse);
				if (xhr.readyState === XMLHttpRequest.DONE) {
					rcLaunch.append('<hr><h3>Completed.</h3>');
				}
				$('html, body').scrollTop(rcLaunch.prop('scrollHeight'));
			}, 200);
		});
	}

	// DATA FAKER!!
	var rcLog = $('.tn-'+baseDir+'performancereviews-test-begin #rcTestLog');
	var logContent = rcLog.html();
	if (logContent !== undefined) {
		rcLog.html('<p>Contacting server...</p>');
		$(function() {
			var lastResponseLen = false,
				xhr = new XMLHttpRequest();
			xhr.open('GET', window.location + '/1?ajax=true', true);
			xhr.send(null);
			var timer;
			timer = window.setInterval(function() {
				if (xhr.readyState === XMLHttpRequest.DONE) {
					window.clearTimeout(timer);
				}
				var thisResponse, response = xhr.responseText;
				if (lastResponseLen === false) {
					thisResponse = response;
					lastResponseLen = response.length;
					rcLog.html('');
				} else {
					thisResponse = response.substring(lastResponseLen);
					lastResponseLen = response.length;
				}
				rcLog.append(thisResponse);
				if (xhr.readyState === XMLHttpRequest.DONE) {
					rcLog.append('<hr><h3>Completed.</h3>');
				}
				$('html, body').scrollTop(rcLog.prop('scrollHeight'));
			}, 100);
		});
	}
});
