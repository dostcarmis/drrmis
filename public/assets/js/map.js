jQuery(function($){
mapHeight = $( document ).height();
var kmlfilename = '';
var kmlurl = '';
var x = $('.top-wrap').height();
$('#map').css('height',mapHeight - x)   

/*****************************/

var arrtotals = frmCont.arrtotals;
var coordinates = frmCont.coordinates;

var cntSen = 0;
var cntkml = 0;
var contourst = 0;

/*****************************/

$('.opensensors').on('click',function(e){
    e.preventDefault();
    $(this).next('.sensorcontents').slideToggle();
    $(this).toggleClass('active');       
});

$('.btnleftmenu').on('click',function(e){
    e.preventDefault();
    $('#navleftside').toggleClass('closednavbar');
});

$('.foldername-prov>a').on('click',function(e){
    e.preventDefault();
    $(this).parent().parent().find('.foldername-prov').removeClass('activefolder');
    $(this).parent().parent().find('.collapse.in').collapse("hide");
    $(this).parent().addClass('activefolder');

});

$('.titleli>a').on('click',function(e){
    e.preventDefault();
    if($(this).parent().hasClass('activehazardmapcategory')){
        $(this).parent().removeClass('activehazardmapcategory')
    }else{
        $(this).parent().parent().find('.titleli').removeClass('activehazardmapcategory');
        $(this).parent().addClass('activehazardmapcategory');
    }

    $(this).parent().parent().find('.titleli>ul').collapse("hide");
    $(this).parent().parent().find('.titleli').removeClass('activehmc');

    $(this).addClass('activehmc');
});

/*================================ Map ================================*/
    var rainylight = {url: 'assets/images/mapicons/rainy-light.png'};
    var sunnylight = {url: 'assets/images/mapicons/sunny-light.png'};
    var rainymoderate = {url: 'assets/images/mapicons/rainy-moderate.png'};
    var rainyheavy = {url: 'assets/images/mapicons/rainy-heavy.png'};
    var rainyintense = {url: 'assets/images/mapicons/rainy-intense.png'};
    var rainytorrential = {url: 'assets/images/mapicons/rainy-torrential.png'};
    var stream = {url: 'assets/images/mapicons/waterlevel.png'};
    


    var locations = []; 
    var landslidelocation = [];
    var floodlocation = [];
    var historicalOverlay = new google.maps.KmlLayer();
    var kmlfnalmt = [];
    var kmlfnalk = [];
    var kmlfnalifugao = [];

    function initMap() {   
        var mapDiv = document.getElementById('map');
        var mapOptions = {
            center: new google.maps.LatLng(17.1990871,121.2453923),
            zoom: 9,
            zoomControl: false,
            streetViewControl: false,
            gestureHandling: 'greedy',
            mapTypeControl: true,
              mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                position: google.maps.ControlPosition.TOP_RIGHT,
                mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain','night_map','light_map']
            },
            styles: [
            {
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#e0efef"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "hue": "#1900ff"
                    },
                    {
                        "color": "#c0e8e8"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": 700
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#7dcdcd"
                    }
                ]
            }
        ]
        };       
    
        /****MAP STYLES****/
        var lightmap = new google.maps.StyledMapType(
            [
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "color": "#f0d0ff"
                  }
                ]
              },
              {
                "featureType": "water",
                "elementType": "geometry.stroke",
                "stylers": [
                  {
                    "visibility": "on"
                  },
                  {
                    "color": "#515c6d"
                  }
                ]
              }
              ],
            {name: 'Simple'});
        
        var nightmap = new google.maps.StyledMapType(
            [
                  {
                    "elementType": "geometry",
                    "stylers": [
                      {
                        "color": "#242f3e"
                      }
                    ]
                  },
                  {
                    "elementType": "labels.text.fill",
                    "stylers": [
                      {
                        "color": "#746855"
                      }
                    ]
                  },
                  {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                      {
                        "color": "#242f3e"
                      }
                    ]
                  },
                  {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      {
                        "color": "#d59563"
                      }
                    ]
                  },
                  {
                    "featureType": "administrative.province",
                    "elementType": "geometry.fill",
                    "stylers": [
                      {
                        "color": "#6253e8"
                      }
                    ]
                  },
                  {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      {
                        "color": "#d59563"
                      }
                    ]
                  },
                  {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                      {
                        "color": "#263c3f"
                      }
                    ]
                  },
                  {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      {
                        "color": "#6b9a76"
                      }
                    ]
                  },
                  {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                      {
                        "color": "#38414e"
                      }
                    ]
                  },
                  {
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      {
                        "color": "#212a37"
                      }
                    ]
                  },
                  {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      {
                        "color": "#9ca5b3"
                      }
                    ]
                  },
                  {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                      {
                        "color": "#746855"
                      }
                    ]
                  },
                  {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                      {
                        "color": "#1f2835"
                      }
                    ]
                  },
                  {
                    "featureType": "road.highway",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      {
                        "color": "#f3d19c"
                      }
                    ]
                  },
                  {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [
                      {
                        "color": "#2f3948"
                      }
                    ]
                  },
                  {
                    "featureType": "transit.station",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      {
                        "color": "#d59563"
                      }
                    ]
                  },
                  {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                      {
                        "color": "#17263c"
                      }
                    ]
                  },
                  {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                      {
                        "color": "#515c6d"
                      }
                    ]
                  },
                  {
                    "featureType": "water",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                      {
                        "color": "#17263c"
                      }
                    ]
                  }
                ],
            {name: 'Dark'});
            
/*END MAP STYLES*/
        var map = new google.maps.Map(mapDiv, mapOptions);
        map.mapTypes.set('night_map', nightmap);
        map.mapTypes.set('light_map', lightmap);

        var infoWindow = new google.maps.InfoWindow();
        
        google.maps.event.addListener(infoWindow, 'domready', function() {

            var iwOuter = $('.gm-style-iw');
            var iwBackground = iwOuter.prev();
                iwBackground.children(':nth-child(2)').css({'display' : 'none'});
                iwBackground.children(':nth-child(4)').css({'display' : 'none'});
                iwOuter.parent().parent().css({left: 'auto'});           
               iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;'});
                iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;'});
               iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});
            var iwCloseBtn = iwOuter.next();
                iwCloseBtn.css({width: '27px', height: '26px',opacity: '1', right: '38px', top: '3px', border: '7px solid #fff', 'border-radius': '13px', 'box-shadow': '0 0 5px #fff'});
            if($('.iw-content').height() < 140)
            {
               $('.iw-bottom-gradient').css({display: 'none'});
            }
            iwCloseBtn.mouseout(function(){
              $(this).css({opacity: '1'});
            });
        });
        kmlurl = new google.maps.KmlLayer({      
            url: 'http://drrmis.dostcar.ph/public/assets/images/provincecarkml.kml',
            suppressInfoWindows: true,
            preserveViewport: true,
            map: map
        });


/*================================ KML HAZARD MAPS ================================*/

        function toggleLayers(layer, map){
            if(layer.getMap() == null) {
                layer.setMap( layer.getMap() ? null : map );          
            }       
        }
        $('.typhoonclick').on('click',function(e){
            e.preventDefault(); 
            historicalOverlay.setMap(null);
            kmlurl.setMap(null);
            kmlurl = new google.maps.KmlLayer($(this).attr('data-value'),{
                preserveViewport:true,                
                map:map
            });

            kmlurl.addListener('click', function(kmlEvent) {
              var text = kmlEvent.featureData.description;
              showInContentWindow(text);
            });

            if ($(this).parent().hasClass('activemap')){
                $(this).parent().removeClass('activemap');  
                cntkml = 0;
                showhidesensor(cntSen,cntkml,contourst);
                kmlurl.setMap(null);
            }else{
                $(this).parent().parent().parent().parent().find('li').removeClass('activemap');    
                $(this).parent().addClass('activemap');  
                cntkml = 0;
                contourst = 0;
                showhidesensor(cntSen,cntkml,contourst); 
                toggleLayers(kmlurl,map);
            }      

        });   
        $('.kmlclick').on('click',function(e){
            e.preventDefault(); 
            historicalOverlay.setMap(null);
            kmlurl.setMap(null);
            kmlurl = new google.maps.KmlLayer($(this).attr('data-value'),{
                preserveViewport:true,                
                map:map
            });

            kmlurl.addListener('click', function(kmlEvent) {
              var text = kmlEvent.featureData.description;
              showInContentWindow(text);
            });

            if ($(this).parent().hasClass('activemap')){
                $(this).parent().removeClass('activemap');  
                cntkml = 0;
                showhidesensor(cntSen,cntkml,contourst);
                kmlurl.setMap(null);
            }else{
                $(this).parent().parent().parent().parent().find('li').removeClass('activemap');    
                $(this).parent().addClass('activemap');  
                cntkml = 1;
                contourst = 0;
                showhidesensor(cntSen,cntkml,contourst); 
                toggleLayers(kmlurl,map);
            }      

        });   

        $('.contourclick').on('click',function(e){
            e.preventDefault(); 
            historicalOverlay.setMap(null);
            kmlurl.setMap(null);
            kmlurl = new google.maps.KmlLayer($(this).attr('data-value'),{
                preserveViewport:true,                
                map:map
            });

            kmlurl.addListener('click', function(kmlEvent) {
              var text = kmlEvent.featureData.description;
              showInContentWindow(text);
            });

            if ($(this).parent().hasClass('activemap')){
                $(this).parent().removeClass('activemap');  
                contourst = 0;
                showhidesensor(cntSen,cntkml,contourst);
                kmlurl.setMap(null);
            }else{
                $(this).parent().parent().parent().parent().find('li').removeClass('activemap');    
                $(this).parent().addClass('activemap');  
                contourst = 1;
                cntkml = 0;
                showhidesensor(cntSen,cntkml,contourst); 
                toggleLayers(kmlurl,map);
            }      

        });   
/*================================ TIFF or PNG FILES ================================*/
        $('.onclicktiff').on('click', function(e){
            e.preventDefault();
            historicalOverlay.setMap(null);
            var dtval = $(this).attr('data-value');
            var imgArrbounds = $(this).attr('data-coords').split(",");  
            var a = parseFloat(imgArrbounds[0]);
            var b = parseFloat(imgArrbounds[1]);
            var c = parseFloat(imgArrbounds[2]);
            var d = parseFloat(imgArrbounds[3]);

            var imageBounds = {
                north: a,
                south: c,
                east: b,
                west: d
            };

            historicalOverlay = new google.maps.GroundOverlay(
            dtval,
            imageBounds);
            

            if($(this).parent().hasClass('activemap')){
                $(this).parent().removeClass('activemap');
                kmlurl.setMap(null);
                historicalOverlay.setMap(null);
                cntkml = 0;
                showhidesensor(cntSen,cntkml,contourst);
            }else{
                $(this).parent().parent().parent().parent().find("li").removeClass('activemap');
                $(this).parent().parent().find("li").removeClass('activemap');
                $(this).parent().addClass('activemap');
                kmlurl.setMap(null);
                cntkml = 1;
                contourst = 0;
                showhidesensor(cntSen,cntkml,contourst);
                historicalOverlay.setMap(map);
            }   
        });

/***********************END KML HAZARD MAPS*********************************/


/*===============================MULTI KML CONTOURS===============================**/ 
        var kmlinfowindow = new google.maps.InfoWindow();

        var siteurl = 'http://drrmis.dostcar.ph/public/assets/municipalityoverlays';  
        var siteurlmtprovince = 'http://drrmis.dostcar.ph/public/assets/municipalityoverlays/Mt_Province'; 
        var siteurlkalinga = 'http://drrmis.dostcar.ph/public/assets/municipalityoverlays/Kalinga';  
        var siteurlifugao = 'http://drrmis.dostcar.ph/public/assets/municipalityoverlays/Ifugao';   

        google.maps.event.addListener(kmlinfowindow, 'domready', function() {
            var iwOuter = $('.gm-style-iw');
            var iwBackground = iwOuter.prev();
                iwBackground.children(':nth-child(2)').css({'display' : 'none'});
                iwBackground.children(':nth-child(4)').css({'display' : 'none'});
                iwOuter.parent().parent().css({left: '115px'});           
                iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;'});
                iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;'});
                iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});
            var iwCloseBtn = iwOuter.next();
                iwCloseBtn.css({width: '27px', height: '26px',opacity: '1', right: '38px', top: '3px', border: '7px solid #fff', 'border-radius': '13px', 'box-shadow': '0 0 5px #fff'});
            if($('.iw-content').height() < 140)
            {
               $('.iw-bottom-gradient').css({display: 'none'});
            }
            iwCloseBtn.mouseout(function(){
              $(this).css({opacity: '1'});
            });
        });



/*=============================View Sensor=============================*/

        for( var coords=0;coords<coordinates.length;coords++){
            var iconclass;
            var cumulative;
            var ddate;
            for (var i = 0; i < arrtotals.length; i++) {

                if (arrtotals[i].id == coordinates[coords].id) {
                    if(arrtotals[i].total > 400){
                        iconclass = rainytorrential;
                    }else if((arrtotals[i].total >= 301) && (arrtotals[i].total <= 400)){
                        iconclass = rainyintense;
                    }else if((arrtotals[i].total >= 201) && (arrtotals[i].total <= 300)){
                        iconclass = rainyheavy;
                    }else if((arrtotals[i].total >= 101) && (arrtotals[i].total <= 200)){
                        iconclass = rainymoderate;
                    }else if(arrtotals[i].total > 0){
                        iconclass = rainylight;
                    }else{
                        iconclass = sunnylight;
                    }

                    if(arrtotals[i].category == 1){
                        cumulative = "<span class='l-coordinates'>Cumulative 8am: <span>" + arrtotals[i].total + " mm </span>"; 
                        ddate = "<span class='l-coordinates'>Date/s: <span>" + arrtotals[i].date + "</span>"; 
                    }else if(arrtotals[i].category == 3){
                        cumulative = "<span class='l-coordinates'>Cumulative 8am: <span>" + arrtotals[i].total + " mm </span><span class='l-coordinates'>Waterlevel: <span>" + (arrtotals[i].waterlevel / 100).toFixed(2) + " m </span>";                          
                        ddate = "<span class='l-coordinates'>Date/s: <span>" + arrtotals[i].date + "</span>"; 
                    }else if(arrtotals[i].category == 2){
                        cumulative = "<span class='l-coordinates'>Waterlevel: <span>" + (arrtotals[i].waterlevel / 100).toFixed(2) + " m </span>"; 
                        ddate = "<span class='l-coordinates'>Date/s: <span>" + arrtotals[i].date + "</span>"; 
                        iconclass = stream;
                    }else{
                        cumulative = "<span class='l-coordinates'>Cumulative 8am: <span>" + arrtotals[i].total + " mm </span>"; 
                        ddate = "<span class='l-coordinates'>Date/s: <span>" + arrtotals[i].date + "</span>"; 
                    }
                    
                }

            }               
            locations.push({
                id: coordinates[coords].id, 
                name:coordinates[coords].address,                 
                icon: iconclass, 
                ddate: ddate,
                cumulative : cumulative,
                latlng: new google.maps.LatLng(coordinates[coords].latitude,coordinates[coords].longitude),
                category: coordinates[coords].category_id
            });
        }


        var markers = [];
        var i, arrMarkers;
        for(i=0;i<locations.length;i++){
            var data = locations[i];
            var arrMarkers = new google.maps.Marker({
                position: data.latlng, 
                map:map, 
                icon:data.icon, 
                title:data.name,
            });
            arrMarkers.category = locations[i].category;
            arrMarkers.setVisible(false);
            markers.push(arrMarkers);
            
            (function (arrMarkers, data) {
                var title = '';
                    if(data.category == 1){
                        title = 'Rain Gauges';
                    }else if(data.category == 2){
                        title = 'Stream Gauges';
                    }else if(data.category == 3){
                        title = 'Rain & Stream Gauges';
                    }else{                        
                        title = 'Weather Stations';
                    }

                    google.maps.event.addListener(arrMarkers, "click", function (e) {
                        infoWindow.setContent(                            
                            "<div id='iw-container'><div class='iw-title s-maptitle'>"+data.name+"</div><div class='iw-content l-mapcontent'><span class='s-name'>Sensor Type: <span>" + title + "</span></span>" + data.cumulative + "</span>"+data.ddate+"</div><div class='iw-bottom-gradient'></div></div>"
                            );
                        infoWindow.open(map, arrMarkers);
                    });
            })(arrMarkers, data);                      
        }

/*==== Display Coordinates ====*/
        function displayMarkers(obj,category) {
             var i;
             for (i = 0; i < markers.length; i++)
             {   
                 if (markers[i].category == category) {
                     if ($(obj).hasClass("active")) {
                         markers[i].setVisible(true);
                     } else {
                       markers[i].setVisible(false);    
                     }
                 }                      
            }
        }    
        $('.onclicksensor').on('click',function(e){
            e.preventDefault();
            $(this).parent().toggleClass('active');
            var v = parseInt($(this).attr('data-value')); 
            displayMarkers($(this).parent(),v);  
            if($(this).parent().parent().find("li").hasClass('active')){
                cntSen = 1;
                showhidesensor(cntSen,cntkml,contourst);
            }else{
                cntSen = 0;
                showhidesensor(cntSen,cntkml,contourst);
            }
        });
        
        /************************************/
        $(".homepagetoogle").on('click',function(e){
            e.preventDefault();
            if($(this).parent().hasClass('open')){
                $(this).parent().parent().find("li").removeClass('open');
                $(this).parent().parent().find("li>ul").collapse('hide');
                $(this).parent().addClass('open');
            }else{
                $(this).parent().parent().find("li").removeClass('open');
                $(this).parent().parent().find("li>ul").collapse('hide');
                $(this).parent().removeClass('open');
            }
        });
        
    }
window.onload = initMap;


/***************************** END VIEW SENSORS*****************************/

function showhidesensor(cntSen,cntkml,contourst){
    if((cntSen == 0) && (cntkml == 0) && (contourst ==0)){
        $("#homepagelegend").hide();
        $(".sensorlegends").hide();
        $(".hazardmaplegends").hide();
        $(".contourlegends").hide();
    }else if((cntSen == 1) && (cntkml == 0) && (contourst ==0)){
        $("#homepagelegend").show();
        $(".sensorlegends").show();
        $(".hazardmaplegends").hide();
        $(".contourlegends").hide();
    }else if((cntSen == 0) && (cntkml == 1)  && (contourst ==0)){
        $("#homepagelegend").show();
        $(".sensorlegends").hide();
        $(".hazardmaplegends").show();
        $(".contourlegends").hide();
    }else if((cntSen == 0) && (cntkml == 0)  && (contourst ==1)){
        $("#homepagelegend").show();
        $(".sensorlegends").hide();
        $(".hazardmaplegends").hide();
        $(".contourlegends").show();
    }else if((cntSen == 1) && (cntkml == 1) && (contourst ==0)){
        $("#homepagelegend").show();
        $(".sensorlegends").show();
        $(".hazardmaplegends").show();
        $(".contourlegends").hide();
    }else if((cntSen == 1) && (cntkml == 0) && (contourst ==1)){
        $("#homepagelegend").show();
        $(".sensorlegends").show();
        $(".hazardmaplegends").hide();
        $(".contourlegends").show();
    }else if((cntSen == 0) && (cntkml == 1) && (contourst ==1)){
        $("#homepagelegend").show();
        $(".sensorlegends").hide();
        $(".hazardmaplegends").show();
        $(".contourlegends").show();
    }
    else{
        $("#homepagelegend").show();
        $(".sensorlegends").show();
        $(".hazardmaplegends").show();
        $(".contourlegends").show();
    }
}

/*============================Get attr=========================*/
    jQuery.fn.toggleAttr = function(attr) {
        return this.each(function() {
            var $this = $(this);
            $this.attr(attr) ? $this.removeAttr(attr) : $this.attr(attr, attr);
        });
    };
    /**********Map size************/
    $( window ).resize(function() {
        mapHeight1 = $( document ).height();
      $('#map').css('height',mapHeight1);   
    });
});
