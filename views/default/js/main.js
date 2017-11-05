$(document).ready(function() {
	'use strict';
	if (!readCookie('tntz')) {
		var tz = jstz.determine();
		createCookie('tntz', tz.name(), 365);
	}
	
	// NOT required:
	// for this demo disable all links that point to "#"
	$('a[href="#"]').click(function(event){ 
		event.preventDefault(); 
	});
	/*
	$('#side-nav').affix({
		offset: {
			top: $('#page-title').offset().top + 6
		}
	});
	*/
	$('#nav-toggle').on('click', function(e){
		/*
		e.preventDefault();
		$('#main-navigation ul.nav-location').slideToggle();
		$('.menu-dup').toggle();
		$('#nav-toggle i.fa').toggleClass('fa-chevron-circle-up').toggleClass('fa-chevron-circle-down');
		if ($('#nav-toggle span').text() == 'Hide Navigation'){
			$('#nav-toggle span').text('Show Navigation');
		} else {
			$('#nav-toggle span').text('Hide Navigation');
		}
		var url = URL+'settings/togglenav/';
		$.ajax({
			type: "POST",
			url: url,
			success: function(data){
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});
		*/
	});

	$(document).on("click", 'a[href*="/delete/"]', function(e){
		e.preventDefault();
		$('#modalDelete').modal('show');
		$('#modalDelete .btn-primary').click(function(ev) {
			top.location.href = e.target.href;
		});
	});
	
	$(document).on("click", 'a[href*="/reopen/"]', function(e){
		e.preventDefault();
		$('#modalReopen').modal('show');
		$('#modalReopen .btn-primary').click(function(ev) {
			top.location.href = e.target.href;
		});
	});	

	$('input.datepicker').hover(function(){
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
	/*
	$('input.datepicker').datepicker({
		format: 'yyyy/mm/dd',
		todayBtn: 'linked',
		autoclose: true,
		todayHighlight: true
	});
	*/
	$('.panel-unhide').click(function(e) {
		e.preventDefault();
		$('.panel-hidden').removeClass('panel-hidden').addClass('panel-unhidden');
		$('.panel-unhide').css('display', 'none');
	});

	$('#division').change(function() {
		var html = '';
		var count = 0;
		var formObj = $(this).val();
		var url = URL+'settings/departments/departmentswitch/'+formObj;
		$('#department').prop('disabled', 'disabled');
		$.ajax({
			dataType: "json",
			type: "GET",
			url: url,
			success: function(data){
				$.each(data, function(idx, obj) {
					count++;
					html += '<option value="'+obj.id+'">'+obj.name+'</option>';
				});
				$('#department option').remove();
				$('#department').html(html);
				/* if (count == 1){
					$('#department').prop('disabled', 'disabled');
				} else {
					$('#department').prop('disabled', false);
				} */
				$('#department').prop('disabled', false);
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});
	});
	function loadTinyMCEEditor(id) {
		/* tinymce.init({
			selector: id,
			mode : 'exact',
			menubar : false,
			statusbar : false
		}); */
		CKEDITOR.replace( id );
	}
	$('.addcomponent').click(function(e){
		e.preventDefault();
		var html = '';
		var url = URL+'settings/subevaluations/field/addcomponent';
		var id = 'fd' + new Date().getTime(); 
		$.ajax({
			dataType: "html",
			type: "GET",
			url: url,
			success: function(data){
				$('.subeval-fields').find('div.panel-collapse').collapse('hide');
				$('.subeval-fields').append(data);
				$('.subeval-fields').find('div.subeval-field:last-child').find('.field-description').addClass(id).removeAttr('id').attr('id',id);
				//alert($('.subeval-fields').find('div.subeval-field:last-child').find('.field-description').attr('class'));
			},
			complete: function(){
				loadTinyMCEEditor(id);
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});
	});

	$('input[name="assignment[]"]').click(function(e){
		if($(this).prop('checked')){
			if ($(this).val() == 'self'){
				$('input[value="peer"]').removeAttr("checked");
			} else if ($(this).val() == 'peer'){
				$('input[value="self"]').removeAttr("checked");
			}
		}
	});
	
	/*
	$('.addsection').click(function(e){
		e.preventDefault();
		var selectedItem = $(".evaluations option:selected");
		$(".selectedevaluations").append(selectedItem);
	});
	$('.removesection').click(function(e){
		e.preventDefault();
		var selectedItem = $(".selectedevaluations option:selected");
		$(".evaluations").append(selectedItem);
	});
	*/
	
	$('button[name="addsection"]').click(function(e){
		e.preventDefault();
		var selectedItem = $('.subevaluations-fulllist ul li[active="active"]');
		var compiledId = $('input[name="id"]').val();

		$(".subevaluations ul").append(selectedItem.not('.static-item, .matrix-item, .signature-item'));
		selectedItem.not('.static-item, .matrix-item, .signature-item').children('input').attr('name', 'subevaluations[]');
		$(selectedItem).removeAttr('style');
		$(selectedItem).find('span a').removeAttr('style');
		$(selectedItem).removeAttr('active');

		if (selectedItem.hasClass('static-item')){
			$('#modalStaticContent').modal('toggle');
			var url = URL+'settings/compiledforms/static/add/'+compiledId;		
			var id = 'content'
			$.ajax({
				dataType: "html",
				type: "GET",
				url: url,
				success: function(data){
					$('#modalStaticContent .modal-body').html(data);

				},
				complete: function(){
					loadTinyMCEEditor(id);
				},
				error: function(jqXHR, textStatus, errorThrown){
					//alert(data);
				}
			});
		} else if (selectedItem.hasClass('matrix-item')){
			var url = URL+'settings/compiledforms/matrix/add/'+compiledId;		
			$.ajax({
				dataType: "html",
				type: "GET",
				url: url,
				success: function(data){
					$(".subevaluations ul").append(data);
				},
				complete: function(){
				},
				error: function(jqXHR, textStatus, errorThrown){
					//alert(data);
				}
			});
		} else if (selectedItem.hasClass('signature-item')){
			var url = URL+'settings/compiledforms/signature/add/'+compiledId;		
			$.ajax({
				dataType: "html",
				type: "GET",
				url: url,
				success: function(data){
					$(".subevaluations ul").append(data);
				},
				complete: function(){
				},
				error: function(jqXHR, textStatus, errorThrown){
					//alert(data);
				}
			});
		}
		
	});
	$('.rcMatrix .plots .point span').click(function (e){
		$(this).popover('toggle');
	});
	$('button[name="removesection"]').click(function(e){
		e.preventDefault();
		var selectedItem = $('.subevaluations ul li[active="active"]');
		$(".subevaluations-fulllist ul").append(selectedItem.not('.static-item'));
		$(selectedItem).removeAttr('style');
		$(selectedItem).find('span a').removeAttr('style');
		$(selectedItem).removeAttr('active');
		$(selectedItem).children('input').attr('name', '');
		if (selectedItem.hasClass('static-item')){
			selectedItem.remove();
			// Use ajax to delete static content
		} 
	});
	$(document).on("click", 'a[class="static-content-link"]', function(e){
		e.preventDefault();
		$('#modalStaticContent').modal('toggle');
		var url = $(this).attr('href');		
		$.ajax({
			dataType: "html",
			type: "GET",
			url: url,
			success: function(data){
				$('#modalStaticContent .modal-body').html(data);
				tinymce.init({
					selector: "#modalStaticContent textarea",
					menubar : false,
					statusbar : false
				});
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});
	});
	$(document).on("submit", '.static-form', function(e){
		//$(".static-form").submit(function(e){
			var staticid = $('input[name="id"]').val();
			var type = $('input[name="static-type"]').val();
			var url = URL+'settings/compiledforms/static/'+type+'/'+staticid;
			var postData = $(this).serializeArray();
			$.ajax({
				dataType: "html",
				type: "POST",
				data : postData,
				url: url,
				success: function(data){
					if (type == 'add'){
						$(".subevaluations ul").append(data);
					} else if (type == 'edit'){
						staticid = $(data).find('input[name="subevaluations[]"]').val();
						$('.subevaluations').find('input[value="'+staticid+'"]').parent().replaceWith(data);
					}
					$('#modalStaticContent .modal-body').empty();
					$('#modalStaticContent').modal('toggle');
				},
				error: function(jqXHR, textStatus, errorThrown){
					//alert(data);
				}
			});
			e.preventDefault();
			
		//});
	});
	$(document).on("click", '.subevaluations ul li', function(){
		if ($(this).attr('active')){
			$(this).removeAttr('style');
			$(this).find('span a').removeAttr('style');
			$(this).removeAttr('active');
		} else {
			$(this).css({'background': '#428BCA', 'color': '#FFFFFF' });
			$(this).find('span a').css({'color': '#FFFFFF' });
			$(this).attr('active', 'active');
		}
	});
	$(document).on("click", '.subevaluations-fulllist ul li', function(){
		if ($(this).attr('active')){
			$(this).removeAttr('style');
			$(this).find('span a').removeAttr('style');
			$(this).removeAttr('active');
		} else {
			$(this).css({'background': '#428BCA', 'color': '#FFFFFF' });
			$(this).find('span a').css({'color': '#FFFFFF' });
			$(this).attr('active', 'active');
		}
	});
	if($('input[name="locked"]').val() == 0){
		$(".subevaluations ul").sortable({ containment: "parent" });
	} else {
		$(".subevaluations ul li").css({'background':'#E6E6E6'});
		$(".subevaluations-fulllist ul li").css({'background':'#E6E6E6'});
	}
	
	$(document).on("click", 'a[name="field-delete"]', function(e){
		e.preventDefault();
		var subevalField = $(this).parents('.subeval-field');
		//var hiddenFieldval = $(this).parents(".panel-body").find('input[name="id"]').val();
		//var hiddenFieldToRemove = $(this).parents("form").find('input:nth-of-type(2)[value="'+hiddenFieldval+'"]');
		$('#modalDelete').modal('show');
		$('#modalDelete .btn-primary').click(function(ev) {
			var url = e.target.href;
			$.ajax({
				dataType: "html",
				type: "GET",
				url: url,
				success: function(data){
					$('#modalDelete').modal('hide');
					//hiddenFieldToRemove.remove();
					subevalField.fadeOut( "slow", function() {
						subevalField.remove();
					});
					//$('.form-subeval').find('.addcomponent').parent().before(html);
				},
				error: function(jqXHR, textStatus, errorThrown){
					//alert(data);
				}
			});
		});
		/*
		var val = $(this).parents("form").find('input[name="tnngtoken"]').val();
		var html = '<input type="hidden" name="fields[]" value="'+val+'" />';
		$('.form-subeval').append(html);
		$(this).parents('div#clp_'+val).collapse('toggle');
		*/
	})
	
	$(document).on("click", 'a[name="field-remove"]', function(e){
		e.preventDefault();
		var subevalField = $(this).parents('.subeval-field');
		//var hiddenFieldval = $(this).parents(".panel-body").find('input[name="id"]').val();
		//var hiddenFieldToRemove = $(this).parents("form").find('input:nth-of-type(2)[value="'+hiddenFieldval+'"]');
		$('#modalDelete').modal('show');
		$('#modalDelete .btn-primary').click(function(ev) {
			var url = e.target.href;
			$.ajax({
				dataType: "html",
				type: "GET",
				url: url,
				success: function(data){
					$('#modalDelete').modal('hide');
						subevalField.fadeOut( "slow", function() {
						subevalField.remove();
					});
				},
				error: function(jqXHR, textStatus, errorThrown){
					//alert(data);
				}
			});
		});
	})
	
	if($('body').hasClass('tn-'+baseDir+'settings-subevaluations-new')){
		var url = URL+'settings/subevaluations/field/addcomponent';
		var html = '<div class="subeval-fields"></div>';
		$.ajax({
			dataType: "html",
			type: "GET",
			url: url,
			success: function(data){
				$('.form-subeval').find('.addcomponent').parent().before(html);
				$('.subeval-fields').append(data);
				$('.subeval-fields').find('div.subeval-field:last-child').find('.field-description').addClass('fd1').removeAttr('id').attr('id','fd1');
			},
			complete: function(){
				loadTinyMCEEditor('fd1');
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});
	} else if($('body').hasClass('tn-'+baseDir+'settings-subevaluations-edit')){
		var id = $('.form-subeval').find('input[name="id"]').val();
		var url = URL+'settings/subevaluations/field/getcomponents/'+id;
		var html = '<div class="subeval-fields"></div>';
		$('.form-subeval').find('.addcomponent').parent().before(html);
		$.ajax({
			dataType: "json",
			type: "GET",
			url: url,
			success: function(data){
				$.each(data, function (key, val){
					var id = 'fd' + new Date().getTime(); 
					var url = URL+'settings/subevaluations/field/editcomponent/'+key;
					$.ajax({
						dataType: "html",
						type: "GET",
						url: url,
						async: false,
						success: function(data){
							$('.subeval-fields').append(data);
							$('.subeval-fields').find('div.subeval-field:last-child').find('.field-description').addClass(id).removeAttr('id').attr('id',id);
						},
						complete: function(){
							loadTinyMCEEditor(id);
							$('.subeval-fields').find('div.panel-collapse').collapse('hide');
						},
						error: function(jqXHR, textStatus, errorThrown){
							//alert(data);
						}
					});
				})
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});
	}
	$('div.rating-avg').click(function(e){
		var str = $(this).attr('data-modal');
		var json = str.replace(/'/g, '"');
		var xjson = jQuery.parseJSON(json);
		var html = '<div class="rating-avg rating-modal clearfix">';
		$.each(xjson, function (name, value) {
			html = html+'<span>'+name+'</span><div>';
			var stars = '';
			if (value == 'No Rating'){
				stars = '<p>'+value+'</p>';
			} else {
				for ( var i = 0; i < value; i++ ) {
					stars = stars+'<label>'+i+'</label>';
				}
			}
			html = html+stars+'</div>';
		});
		html = html+'</div>';
		$('#modalRatingContent').modal('toggle');
		$('#modalRatingContent .modal-body').html(html);
	});
	$.validate({
		modules: 'date, security',
		validateOnBlur: false
	});
	
	$('.nav-location').on('show.bs.collapse', function () {
		$('#nav-toggle').html("Hide Navigation");
		var url = URL+'settings/togglenav/';
		$.ajax({
			type: "POST",
			url: url,
			success: function(data){
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});
	})
	$('.nav-location').on('hide.bs.collapse', function () {
		$('#nav-toggle').html("Show Navigation");
		var url = URL+'settings/togglenav/';
		$.ajax({
			type: "POST",
			url: url,
			success: function(data){
			},
			error: function(jqXHR, textStatus, errorThrown){
				//alert(data);
			}
		});
	});

	$('#toolbox-folder li ul li').each(function(){
		$(this).hide('fast');
	});
    $('.tree li').addClass('parent_li').find(' > span[id!=department]').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
		if ($(this).attr('id') == 'department'){
			$(this).closest('li.parent_li').siblings().each(function(){
				$(this).children('span').attr('title', 'Expand this branch').find(' > i').addClass('fa-folder').removeClass('fa-folder-open');
			});
		}
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.length == 0){
        	if ($(this).attr('title') == 'Expand this branch'){
	            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-folder-open').removeClass('fa-folder');
	            loadDocuments($(this));
        	} else {
        		$(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-folder').removeClass('fa-folder-open');
        	}
        } else {
	        if (children.is(":visible")) {
	            children.hide('fast');
	            $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-folder').removeClass('fa-folder-open');
	        } else {
	            children.show('fast');
	            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-folder-open').removeClass('fa-folder');
	            loadDocuments($(this));
	        }
	    }
        e.stopPropagation();
    });
    function loadDocuments(obj){
        var propertyId = '';
        var divisionId = '';
        var departmentId = '';
        var item_id = $(obj).closest('li').attr('id');
        var type = $(obj).attr('id');

        if (type == 'department'){
        	var departmentId = item_id;
        	var divisionId = $(obj).parents('li').parents('li').attr('id');
        	var propertyId = $(obj).parents('li').parents('li').parents('li').attr('id');
        	var url = URL+'toolbox/getTemplates/'+propertyId+'/'+divisionId+'/'+departmentId;
        }

        if (type == 'division'){
        	var divisionId = item_id;
        	var propertyId = $(obj).parents('li').parents('li').attr('id');
			var url = URL+'toolbox/getTemplates/'+propertyId+'/'+divisionId;
        }
        if (type == 'property'){
        	var propertyId = item_id;
        	var url = URL+'toolbox/getTemplates/'+propertyId;
        }
		$.ajax({
			dataType: "html",
			//data: {'id':id, 'type': type},
			type: "GET",
			url: url,
			success: function(data){
				$('#toolbox-documents').empty().html(data);
			}
		});
    }
    $('.folder').on('click', function(e){
    	$( ".open-folder" ).each(function( index ) {
    		$(this).removeClass('open-folder');
    	});
    	e.preventDefault();
    	var obj = $(this);
    	var id = $(this).attr('id');
    	var url = URL+'toolbox/getTemplates/'+id;
    	if($(this).parent('li').hasClass('open-folder')){
    		$(obj).parents('div.col-md-5').siblings('.folder-files').empty();
    	}else {
    		$(this).parent('li').addClass('open-folder');
			$.ajax({
				dataType: "html",
				//data: {'id':id, 'type': type},
				type: "GET",
				url: url,
				success: function(data){
					$(obj).parents('div.col-md-5').siblings('.folder-files').empty().html(data);
					//$('#toolbox-documents').empty().html(data);
				}
			});
		}
    });
    $('.sort-by-name').on('click', function(){
    	var files = $(this).closest('.strategytactic-header').siblings('div.row').children('.folder-files').children('div.filerow');
		files.sort(function(a,b){
			var an = $(a).children('.file-name').children('a').attr('data-sort-name'),
				bn = $(a).children('.file-name').children('a').attr('data-sort-name');
			if(a < b) {
				return -1;
			} else {
				return 1;
			}
		}).each(function(_, container) {
			//console.log($(this).children('.file-name').children('a').html());
			console.log($(container));
			console.log($(container).parent());
			$(container).insertBefore($(container).parent().children('.divider'));
		});
    });
    $('.sort-by-mime').on('click', function(){
    	var files = $(this).closest('.strategytactic-header').siblings('div.row').children('.folder-files').children('div.filerow');
		files.sort(function(a,b){
			var an = $(a).children('.file-name').children('a').attr('data-sort-mime'),
				bn = $(a).children('.file-name').children('a').attr('data-sort-mime');
			if(a < b) {
				return -1;
			} else {
				return 1;
			}
		}).each(function(_, container) {
			//console.log($(this).children('.file-name').children('a').html());
			console.log($(container));
			console.log($(container).parent());
			$(container).insertBefore($(container).parent().children('.divider'));
		});
    });
    $('.sort-by-date').on('click', function(){
    	var files = $(this).closest('.strategytactic-header').siblings('div.row').children('.folder-files').children('div.filerow');
		files.sort(function(a,b){
			var an = $(a).children('.file-name').children('a').attr('data-sort-date'),
				bn = $(a).children('.file-name').children('a').attr('data-sort-date');
			if(a < b) {
				return -1;
			} else {
				return 1;
			}
		}).each(function(_, container) {
			//console.log($(this).children('.file-name').children('a').html());
			console.log($(container));
			console.log($(container).parent());
			$(container).insertBefore($(container).parent().children('.divider'));
		});
    });
	
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};

	$("#competencies-list tbody").sortable({
		helper: fixHelper
	}).disableSelection();

	$('#competencies-sort-save').click(function(event){
		var order = $("#competencies-list tbody").sortable("serialize");

		$.post(URL + "settings/competencies/sort",order,function(theResponse){
				window.location.href= URL + "settings/competencies";
		});
		event.preventDefault();
	});	
	
	$('#truenorth-submit').click(function(event){
		event.preventDefault();
		$('#modalSubmit').modal('show');
		$('#modalSubmit .btn-primary').click(function(ev) {
			top.location.href = event.target.href;
		});
	});

    $("#objective-form #start").datepicker({
        autoclose: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#objective-form #due').datepicker('setStartDate', minDate);
    });
    
    $("#objective-form #due").datepicker({
	autoclose: true})
        .on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#objective-form #start').datepicker('setEndDate', minDate);
    });
	
	$(document).on("click", '#tactic-form .del-comment', function(e){
		e.preventDefault();
		var elm = this;
		$('#modalDelete').modal('show');
		$('#modalDelete .btn-primary').click(function(ev) {
			$(elm).parent().remove();
			$('#modalDelete').modal('hide');
		});
	});

	if($("#description").length > 0) CKEDITOR.replace( 'description', {height:150} );
	if($("#description2").length > 0) CKEDITOR.replace( 'description2', {height:150} );
	if($("#description3").length > 0) CKEDITOR.replace( 'description3', {height:150} );
	if($("#description4").length > 0) CKEDITOR.replace( 'description4', {height:150} );
	if($("#description5").length > 0) CKEDITOR.replace( 'description5', {height:150} );
	if($("#comment").length > 0) CKEDITOR.replace( 'comment', {height:150} );
	
	$(document).bind('page:before-unload', function() {
		if (typeof(CKEDITOR) != "undefined"){
			for(name in CKEDITOR.instances){
				CKEDITOR.instances[name].destroy(true);
			}
		}
	});
	
	CKEDITOR.on('instanceReady', function(){
		$.each( CKEDITOR.instances, function(instance) {
			CKEDITOR.instances[instance].on("change", function(e) {
				for ( instance in CKEDITOR.instances)
					CKEDITOR.instances[instance].updateElement();
			});
		});
	});	
	
});