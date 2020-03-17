jQuery(function($){	
	$('.prntli a').on('click',function(e){
		e.preventDefault();
		$(this).parent().toggleClass('open');
	});	

	

	$('input[name="hazard"]').change(function() {
	  if ($(this).val() == 'Typhoon') {
		  $('#tyname_id').prop('disabled', false);
	  } else {
		  $('#tyname_id').prop('disabled', true);
	  }
	});
	  
	  
	
});