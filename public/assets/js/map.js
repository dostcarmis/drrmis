jQuery(function($){
  $('.fancybox').fancybox();
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
  var clearslocation = [];
  var historicalOverlay = new google.maps.KmlLayer();
  var kmlfnalmt = [];
  var kmlfnalk = [];
  var kmlfnalifugao = [];
  var start = moment();
  var end = moment();
  let formatedStart, formatedEnd;

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
      ]};       

      /****MAP STYLES****/
    var lightmap = new google.maps.StyledMapType([
      {"featureType": "road.highway",
       "elementType": "geometry.fill",
       "stylers": [
          {
            "color": "#f0d0ff"
          }]
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
      }],
      {name: 'Simple'});
    var nightmap = new google.maps.StyledMapType([
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
          }]
      }],
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
                if($('.iw-content').height() < 140){
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
    /*=============================== END MULTI KML CONTOURS===============================**/

    /*=============================View Sensor=============================*/
    for(var coords=0;coords<coordinates.length;coords++){
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
    /***************************** END VIEW SENSORS*****************************/

    /***************************** INCIDENTS MAP VIEW*****************************/
          for( var landslidecount = 0;landslidecount<landslides.length;landslidecount++){
            var landslideicon = {
                url: 'assets/images/landslideicon.png'
            };                
            var images = [];    
            for (var xyz = 0; xyz < landslideimages.length; xyz++) {
                if(landslideimages[xyz].id == landslides[landslidecount].id){
                    myimage = landslideimages[xyz].image;
                    for (var i = 0; i < myimage.length; i++) {
                        images[i] = '<div class="mapimages"><a data-fancybox-group="landslideimages-'+xyz+'" href='+myimage[i].replace(/ /g,"%20") +' class="fancybox thumbnail"><img src='+myimage[i].replace(/ /g,"%20") +' class="mres"/></a></div>';
                    }
                }
             }   
            landslidelocation.push({
                id: landslides[landslidecount].id, 
                name:landslides[landslidecount].road_location, 
                province: landslides[landslidecount].province_id,                
                icon: landslideicon, 
                images: images,
                date: landslides[landslidecount].date,
                source: landslides[landslidecount].author,
                latlng: new google.maps.LatLng(landslides[landslidecount].latitude,landslides[landslidecount].longitude),
                type: landslides[landslidecount].landslidetype,
                landcover: landslides[landslidecount].landcover,
                landmark: landslides[landslidecount].landmark,
                landslidereccuring: landslides[landslidecount].landslidereccuring,
                width: landslides[landslidecount].lewidth,
                length: landslides[landslidecount].lelength,
                depth: landslides[landslidecount].ledepth,
                casualty: landslides[landslidecount].idkilled,
                injured: landslides[landslidecount].idinjured,
                missing: landslides[landslidecount].idmissing,
                infra: landslides[landslidecount].idaffectedinfra,
                value: landslides[landslidecount].idaffectedcrops,
                cause: landslides[landslidecount].cause,
                typhoonname: landslides[landslidecount].typhoonname,
                heavyrainfall: landslides[landslidecount].heavyrainfall,
                reportedby: landslides[landslidecount].reportedby,
                reporterpos: landslides[landslidecount].reporterpos,
                author: landslides[landslidecount].author,
            });
            
        }   
    //Icon info when clicked
        var landslidemarkers = [];
        var i, arrMarkerslandslide;
        for(i=0;i<landslidelocation.length;i++){
            var data = landslidelocation[i];
            var arrMarkerslandslide = new google.maps.Marker({
                position: data.latlng, 
                map:map, 
                icon:data.icon, 
                title:data.road_location,
                date:data.date,
            });
            arrMarkerslandslide.id = landslidelocation[i].id;        
            arrMarkerslandslide.setVisible(false);
            landslidemarkers.push(arrMarkerslandslide); 
            
            (function (arrMarkerslandslide, data) {
                var monthNames = ["January", "February", "March", "April", "May", "June",
                  "July", "August", "September", "October", "November", "December"
                ];
                var d = new Date(data.date);
                    google.maps.event.addListener(arrMarkerslandslide, "click", function (e) {
                        infoWindow.setContent(
                            `<div id='iw-container' class='landslidemarkerinfowindow'>
                                <div class='iw-title l-maptitle'>
                                    LANDSLIDE
                                </div>
                                <div class='iw-content l-mapcontent'>
                                    <span class='l-name'>
                                        ${data.name}
                                    </span>
                                    <span class='defsp l-date'>
                                        ${monthNames[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}
                                    </span>
                                    <span class='l-images'>
                                        ${data.images}
                                    </span>
                                    <span class='l-coordinates'>
                                        <p> The type of the landslide that occured is a ${data.type} landslide.
                                        The landcover of the area is ${data.landcover}. The nearest landmark of the
                                        incident is ${data.landmark}. This incident recorded ${data.casualty} casualties,
                                        ${data.injured} people injured and ${data.missing} missing. This is caused by
                                        ${data.cause} with a local typhoon name ${data.typhoonname}.
                                        </p>    
                                    </span>
                                    <span class='l-source'>
                                    Source: ${data.source}
                                    </span>
                                </div>    
                                <div class='iw-bottom-gradient'></div>
                            </div>`);
                        infoWindow.open(map, arrMarkerslandslide);
                    });
            })(arrMarkerslandslide, data);                      
        }
        $('.l-viewmap').on('click',function(){
            $(this).toggleClass('activelandslide');
            if($(this).hasClass('activelandslide')){
                $(this).text('Remove on Map');
            }else{
                $(this).text('View on Map');
            }
            var v = parseInt($(this).attr('id'));  
                displaylandslideMarkers(this,v); 
            }); 
        $.fn.toggleIconsL = function() {
            var isActive = $('#l-viewmap').hasClass("activelandslide");
            $('#l-viewmap').toggleClass('activelandslide');
            if (isActive) {
                $('#l-viewmap').text('View all Landslides');
                for (i = 0; i < landslidemarkers.length; i++)
                {   
                    landslidemarkers[i].setVisible(false);       
                }
            } else {
                $('#l-viewmap').text('Remove on Map');
                for (i = 0; i < landslidemarkers.length; i++)
                {   
                    landslidemarkers[i].setVisible(true);       
                }
            }
        }
        function displaylandslideMarkers(obj,id) {
             var i;
             for (i = 0; i < landslidemarkers.length; i++)
             {   
                if (landslidemarkers[i].id == id) {
                    if ($(obj).hasClass("activelandslide")) {
                        landslidemarkers[i].setVisible(true);
                    } else {
                        landslidemarkers[i].setVisible(false);    
                    }      
                }          
            }
        }
         for( var floodcount = 0;floodcount<floods.length;floodcount++){
            var floodicon = {
                url: 'assets/images/floodicon.png'
            };      
            var images = [];          
            for (var xyz = 0; xyz < floodimage.length; xyz++) {
                if(floodimage[xyz].id == floods[floodcount].id){
                    myimage = floodimage[xyz].image;
                    for (var i = 0; i < myimage.length; i++) {
                        images[i] = '<div class="mapimages"><a target="_blank" data-fancybox-group="floodimage-'+xyz+'" href='+myimage[i].replace(/ /g,"%20") +' class="fancybox thumbnail"><img src='+myimage[i].replace(/ /g,"%20") +' class="mres"/></a></div>';
                    }
                }
             }
            floodlocation.push({
                id: floods[floodcount].id, 
                name:floods[floodcount].road_location,                 
                icon: floodicon, 
                date: floods[floodcount].date,
                images: images,
                source: floods[floodcount].author,
                latlng: new google.maps.LatLng(floods[floodcount].latitude,floods[floodcount].longitude),
                description: floods[floodcount].description,
                type: floods[floodcount].flood_type,
                river: floods[floodcount].river_system,
                waterlvl: floods[floodcount].flood_waterlvl,
                measured: floods[floodcount].measuredat,
                floodrecurring: floods[floodcount].flood_recurring,
                killed: floods[floodcount].flood_killed,
                injured: floods[floodcount].flood_injured,
                missing: floods[floodcount].flood_missing,
                cause: floods[floodcount].cause,
                tyname: floods[floodcount].typhoon_name,
                heavyrainfall: floods[floodcount].heavy_rainfall,
            });
        }   
        var floodmarkers = [];
        var i, arrMarkersflood;
        for(i=0;i<floodlocation.length;i++){
            var data = floodlocation[i];
            var arrMarkersflood = new google.maps.Marker({
                position: data.latlng, 
                map:map, 
                icon:data.icon, 
                title:data.location,
                date:data.date,
            });
            arrMarkersflood.id = data.id;        
            arrMarkersflood.setVisible(false);
            floodmarkers.push(arrMarkersflood);
            (function (arrMarkersflood, data) {
                var monthNames = ["January", "February", "March", "April", "May", "June",
                  "July", "August", "September", "October", "November", "December"
                ];
                var d = new Date(data.date);
                    google.maps.event.addListener(arrMarkersflood, "click", function (e) {
                        infoWindow.setContent(
                            `<div id='iw-container'>
                                <div class='iw-title f-maptitle'>
                                    FLOOD
                                </div>
                                <div class='iw-content l-mapcontent'>
                                    <span class='f-name'>
                                    ${data.name}
                                    </span>
                                    <span class='defsp l-date'>
                                     ${monthNames[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}
                                    </span>
                                    <span class='l-images'>
                                    ${data.images}
                                    </span>
                                    <span class='l-coordinates'>
                                        <p> The type of the flooding that occured is ${data.type}. The flooded area is part
                                        of ${data.river}. There is a recorded flood water level of ${data.waterlvl} meters that
                                        is measured at ${data.measured}. This incident recorded ${data.killed} casualties,
                                        ${data.injured} people injured and ${data.missing} missing. This is caused by
                                        ${data.cause} causes with a local typhoon name ${data.tyname}.
                                        </p>    
                                    </span>
                                    <span class='l-source'>
                                    Source: ${data.source}
                                    </span>
                                </div>
                                <div class='iw-bottom-gradient'></div>
                            </div>
                            `);
                        infoWindow.open(map, arrMarkersflood);
                    });
            })(arrMarkersflood, data);
            
        }
       $.fn.toggleIconsF = function() {
            var isActive = $('#f-viewmap').hasClass("activeflood");
            $('#f-viewmap').toggleClass('activeflood');
            if (isActive) {
                $('#f-viewmap').text('View all Floods');
                for (i = 0; i < floodmarkers.length; i++)
                {   
                    floodmarkers[i].setVisible(false);    
                }
            } else {
                $('#f-viewmap').text('Remove on Map');
                for (i = 0; i < floodmarkers.length; i++)
                {   
                    floodmarkers[i].setVisible(true);       
                }
            }
        }
        function displayfloodMarkers(obj,id) {
             var i;
             for (i = 0; i < floodmarkers.length; i++)
             {   
                if (floodmarkers[i].id == id) {
                    if ($(obj).hasClass("activeflood")) {
                     floodmarkers[i].setVisible(true);
                     } else {
                         floodmarkers[i].setVisible(false);    
                     }      
                }        
            }
        }
        $('.f-viewmap').on('click',function(){
            $(this).toggleClass('activeflood');
            if($(this).hasClass('activeflood')){
                $(this).text('Remove on Map');
            }else{
                $(this).text('View on Map');
            }
            var v = parseInt($(this).attr('id'));  
                displayfloodMarkers(this,v); 
        });

        for( var clearscount = 0;clearscount<clears.length;clearscount++){
          var clearsicon = {
              url: 'assets/images/clearsicon.png'
          };                
          var images = [];    
          for (var xyz = 0; xyz < clearsimages.length; xyz++) {
              if(clearsimages[xyz].id == clears[clearscount].id){
                  myimage = clearsimages[xyz].image;
                  for (var i = 0; i < myimage.length; i++) {
                      images[i] = '<div class="mapimages"><a data-fancybox-group="clearsimages-'+xyz+'" href='+myimage[i].replace(/ /g,"%20") +' class="fancybox thumbnail"><img src='+myimage[i].replace(/ /g,"%20") +' class="mres"/></a></div>';
                  }
              }
          }
          
          clearslocation.push({
              id: clears[clearscount].id, 
              province: clears[clearscount].province_id,                
              icon: clearsicon, 
              images: images,
              date: clears[clearscount].survey_date,
              latlng: new google.maps.LatLng(clears[clearscount].survey_latitude,clears[clearscount].survey_longitude),
              lat:clears[clearscount].survey_latitude,
              lang:clears[clearscount].survey_longitude,
              source:clears[clearscount].source,
              fs: clears[clearscount].Fs,
          });
          
      }   
  //Icon info when clicked
      var clearsmarkers = [];
      var i, arrMarkersclears;
      for(i=0;i<clearslocation.length;i++){
        
          var data = clearslocation[i];
          var arrMarkersclears = new google.maps.Marker({
              position: data.latlng, 
              map:map, 
              icon:data.icon, 
              title:data.road_location,
              date:data.date,
          });
          arrMarkersclears.id = clearslocation[i].id;        
          arrMarkersclears.setVisible(false);
          clearsmarkers.push(arrMarkersclears); 
          
          (function (arrMarkersclears, data) {
              var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
              ];
              var d = new Date(data.date);
                  google.maps.event.addListener(arrMarkersclears, "click", function (e) {
                      infoWindow.setContent(
                          `<div id='iw-container' class='clearsmarkerinfowindow'>
                              <div class='iw-title l-maptitle'>
                                  Landslide Susceptibility
                              </div>
                              <div class='iw-content l-mapcontent'>
                                  <span class='l-name'>
                                      ${data.lang}
                                  </span>
                                  <span class='defsp l-date'>
                                      ${monthNames[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}
                                  </span>
                                  <span class='l-images'>
                                      ${data.images}
                                  </span>
                                  <span class='l-coordinates'>
                                      <p>This slope has a Stability Factor of ${data.fs}, which means it is ${data.fs >= 1? 'stable':'susceptible to landslides'}.
                                      </p>    
                                  </span>
                                  <span class='l-source'>
                                  Source: ${data.source}
                                  </span>
                              </div>    
                              <div class='iw-bottom-gradient'></div>
                          </div>`);
                      infoWindow.open(map, arrMarkersclears);
                  });
          })(arrMarkersclears, data);                      
      }
      $('.c-viewmap').on('click',function(){
          $(this).toggleClass('activeClears');
          if($(this).hasClass('activeClears')){
              $(this).text('Remove on Map');
          }else{
              $(this).text('View on Map');
          }
          var v = parseInt($(this).attr('id'));  
              displayclearsMarkers(this,v); 
          }); 
      $.fn.toggleIconsC = function() {
          var isActive = $('#c-viewmap').hasClass("activeClears");
          $('#c-viewmap').toggleClass('activeClears');
          if (isActive) {
              $('#c-viewmap').text('CLEARS');
              for (i = 0; i < clearsmarkers.length; i++)
              {   
                  clearsmarkers[i].setVisible(false);       
              }
          } else {
              $('#c-viewmap').text('Remove on Map');
              for (i = 0; i < clearsmarkers.length; i++)
              {   
                  clearsmarkers[i].setVisible(true);       
              }
          }
      }
      function displayclearsMarkers(obj,id) {
        
          for (var i = 0; i < clearsmarkers.length; i++)
          {   
              if (clearsmarkers[i].id == id) {
                  if ($(obj).hasClass("activeClears")) {
                      clearsmarkers[i].setVisible(true);
                  } else {
                      clearsmarkers[i].setVisible(false);    
                  }      
              }          
          }
      }
    //showing all loaded icons  
        $.fn.toggleIconsAll = function() {
            var isActive = $('#all-viewmap').hasClass("activeall");
            $('#all-viewmap').toggleClass('activeall');
            if (isActive) {
                $('#all-viewmap').text('View all incidents');
                
                for (i = 0; i < floodmarkers.length; i++)
                {   
                    floodmarkers[i].setVisible(false);    
                }
                for (i = 0; i < landslidemarkers.length; i++)
                {   
                    landslidemarkers[i].setVisible(false);       
                }
            } else {
                $('#all-viewmap').text('Remove on Map');
              
                for (i = 0; i < floodmarkers.length; i++)
                {   
                    floodmarkers[i].setVisible(true);       
                }
                for (i = 0; i < landslidemarkers.length; i++)
                {   
                    landslidemarkers[i].setVisible(true);       
                }
            }
            
        }
        
    //showing all filtered by date icons 

    
      

        $.fn.toggleIconWithDateFilter = function(){
            //const isactive = $('#all-filteredmap').hasClass('showfiltered');
            $('#all-filteredmap').toggleClass('showfiltered')
            for (i = 0;i < landslidemarkers.length; i++){
                    if (moment(landslidemarkers[i].date).isBetween(formatedStart,formatedEnd)){
                        landslidemarkers[i].setVisible(true);
                    }else{
                        landslidemarkers[i].setVisible(false) ;
                    }  
            }    
            for (i = 0;i < floodmarkers.length; i++){
                    if (moment(floodmarkers[i].date).isBetween(formatedStart,formatedEnd)){
                        floodmarkers[i].setVisible(true);
                    }else{
                        floodmarkers[i].setVisible(false);
                    }   
                } 
        }
        function cb(start, end) {
            mStart = moment(start).subtract(1, 'd');
            mEnd = moment(end).add(1, 'd');
            formatedStart = mStart.format('YYYY-MM-DD');
            formatedEnd = mEnd.format('YYYY-MM-DD');
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
               'Last Year' : [moment().subtract(1, 'y').startOf('y'), moment().subtract(1, 'y').endOf('y')]
            }
        }, cb);
        cb(start, end);
  }
  window.onload = initMap;

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
