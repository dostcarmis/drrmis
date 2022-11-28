jQuery(function($){
	/************************resize*****************************/
	$(window).resize(function() {
		if ($(window).width() < 768) {
	 		$('body').addClass('mobile-view');
	 		$('body').removeClass('web-view');
		}
		else{
			$('body').addClass('web-view');
			$('body').removeClass('mobile-view');
		}
	}); 
	/************************on load*****************************/
	$(document).ready(function(){
		if ($(window).width() < 768) {
			$('body').addClass('mobile-view');
			$('body').removeClass('web-view');
			
		}
		else{
			$('body').addClass('web-view');
			$('body').removeClass('mobile-view');
		}
	});

	 /*backend Layout and other layout*/

//     $('#mainmenus').mmenu({
//       "extensions": [
//           "fx-menu-zoom",
//           "pagedim-black",
//           "theme-dark"
//       ]
//     });
//     $('#mainmenumobile').mmenu({
//       "extensions": [
//           "fx-menu-zoom",
//           "pagedim-black",
//           "theme-dark"
//       ],
//       "offCanvas": {
//           "position": "right"
//       }
//     });

// 	 /*end*/
// 	 /*homepage layout*/
// 	 $('#menumobile').mmenu({
//       "extensions": [
//           "fx-menu-zoom",
//           "pagedim-black",
//           "theme-dark"
//       ]
//     });
// 	 /*end*/
// 	 /*frontend layout and mapview*/
// 	 $('#menumobileinnplayouts').mmenu({
//       "extensions": [
//           "fx-menu-zoom",
//           "pagedim-black",
//           "theme-dark"
//       ]
//     });
// 	 /*end*/

});
$(document).on('click','.little-toggler',function(){
	$('.logowrap').toggleClass('collapsed')
	$('.logowrap .container-fluid').slideToggle(300,"linear");				
	if($('.little-toggler i').attr('style')){$('.little-toggler i').attr('style',"");}
	else{$('.little-toggler i').css('transform','rotate(180deg)')}
})
.on('click','#wrap-main',function(e){
	if($(e.target).closest('#leftmenu').length != 1){
		if(!$('#leftmenu #navleftside').hasClass('closednavbar')){
			$('#leftmenu #navleftside').addClass('closednavbar');
		}
	}
	if($(e.target) != $('#footer-profile') && $(e.target).closest('#footer-profile').length != 1){
		if($('#footer-cabinet').hasClass('fc-visible')){
			$('#footer-cabinet').slideToggle(300,"linear");	
			$('#footer-cabinet').toggleClass('fc-visible');
		}
	}
	
})
.on('click','#footer-profile',function(e){
	$('#footer-cabinet').slideToggle(300,"linear");	
	$('#footer-cabinet').toggleClass('fc-visible');
})
.on('click','#navleftside #mobile-login',function(e){
	$('#leftmenu #navleftside').addClass('closednavbar');
})
	