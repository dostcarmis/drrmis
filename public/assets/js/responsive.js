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