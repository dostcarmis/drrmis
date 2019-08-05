jQuery(function($){	
	$('.prntli a').on('click',function(e){
		e.preventDefault();
		$(this).parent().toggleClass('open');
	});	
	
});