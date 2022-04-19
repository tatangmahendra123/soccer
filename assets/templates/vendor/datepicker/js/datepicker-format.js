

$(document).ready(function(){
	$('.tanggal').datepicker({
		format:"dd-mm-yyyy",
		autoclose:true
	});
});
$(document).ready(function(){
	$('.tahun').datepicker({
		format:"yyyy",
		viewMode:"years",
		minViewMode:"years",
		autoclose:true
	});
});
