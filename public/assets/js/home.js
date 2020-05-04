jQuery(function($){	
	$('.prntli a').on('click',function(e){
		e.preventDefault();
		$(this).parent().toggleClass('open');
	});	

	

	$('input[name="risk"]').change(function() {
	  if ($(this).val() == 'Typhoon') {
		  $('#typhoon_name').prop('disabled', false);
	  } else {
		  $('#typhoon_name').prop('disabled', true);
	  }
	});
	  
	  
	
});