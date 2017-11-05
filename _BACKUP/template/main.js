
function changeCurrentProperty() {
	var propertyId = $('#propertySelect').val();
	$.ajax({
		url: '/remote/currentproperty/' + propertyId,
		success: function(data) {
			location.reload();
		}
	});
}

function changeCurrentDivision() {
	var divisionId = $('#divisionSelect').val();
	$.ajax({
		url: '/remote/currentdivision/' + divisionId,
		success: function(data) {
			location.reload();
		}
	});
}

function changeCurrentDepartment() {
	var departmentId = $('#departmentSelect').val();
	$.ajax({
		url: '/remote/currentdepartment/' + departmentId,
		success: function(data) {
			location.reload();
		}
	});
}
