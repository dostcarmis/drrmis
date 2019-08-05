jQuery(function($){
	$(document).ready(function(){
		//var value = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);		
	$('.fancybox').fancybox();
  
	function initMap(){
		var latitude = $('#latvalue span').text();
		var longitude = $('#longvalue span').text();
		var title = $('.pg-title').text();
		latitude = parseFloat(latitude);
		longitude = parseFloat(longitude);
        var myLatLng = {lat: latitude, lng: longitude};
        var map = new google.maps.Map(document.getElementById('lfmap'), {
          zoom: 13,
          center: myLatLng
        });
        var icon = '';
        if(window.location.href.indexOf("viewperlandslide") > -1) {
	       icon = {
                url: '../assets/images/landslideicon.png'
            };    
	    }else{
	    	icon = {
                url: '../assets/images/floodicon.png'
            };    
	    }
	    
        var marker = new google.maps.Marker({
          position: myLatLng,
          icon: icon,
          map: map,
          title: title
        });
      }
      window.onload = initMap;
	});	

});