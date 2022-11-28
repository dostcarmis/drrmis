//responsive map
$( window ).resize(function() {
    mapHeight1 = $( document ).height();
    $('#incidentmap').css('height',mapHeight1);   
});
//global variables
var locations = []; 
var landslidelocation = [];
var floodlocation = [];
var clearslocation = [];
var start = moment();
var end = moment();
let formatedStart, formatedEnd;
//map initialization
function initMap() {   
    var mapDiv = document.getElementById('incidentmap');
    var mapOptions = {
        center: new google.maps.LatLng(17.351324, 121.17500399999994),
        zoom: 9,
        zoomControl: false,
        streetViewControl: false,
        mapTypeControl: true,
          mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            position: google.maps.ControlPosition.TOP_RIGHT,
            mapTypeIds: [
                google.maps.MapTypeId.SATELLITE,
                google.maps.MapTypeId.ROADMAP,
                google.maps.MapTypeId.TERRAIN,                    
                google.maps.MapTypeId.HYBRID
            ]
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
    var map = new google.maps.Map(mapDiv, mapOptions);
    var infoWindow = new google.maps.InfoWindow();
    google.maps.event.addListener(infoWindow, 'domready', function() {
        var iwOuter = $('.gm-style-iw');
        var iwBackground = iwOuter.prev();
            iwBackground.children(':nth-child(2)').css({'display' : 'none'});
            iwBackground.children(':nth-child(4)').css({'display' : 'none'});
            iwOuter.parent().parent().css({left: '115px'});           
            iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 230px !important;'});
            iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 230px !important;'});
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
                    images[i] = '<div class="mapimages"><a data-fancybox-group="floodimage-'+xyz+'" href='+myimage[i].replace(/ /g,"%20") +' class="fancybox"><img src='+myimage[i].replace(/ /g,"%20") +' class="mres"/></a></div>';
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
            if(clearsimages[xyz].id == clearss[clearscount].id){
                myimage = clearsimages[xyz].image;
                for (var i = 0; i < myimage.length; i++) {
                    images[i] = '<div class="mapimages"><a data-fancybox-group="clearsimages-'+xyz+'" href='+myimage[i].replace(/ /g,"%20") +' class="fancybox thumbnail"><img src='+myimage[i].replace(/ /g,"%20") +' class="mres"/></a></div>';
                }
            }
        }
        
        clearslocation.push({
            id: clearss[clearscount].id, 
            province: clears[clearscount].province_id,                
            icon: clearsicon, 
            images: images,
            date: clears[clearscount].date,
            source: clears[clearscount].author,
            latlng: new google.maps.LatLng(clears[clearscount].latitude,clears[clearscount].longitude),
            type: clears[clearscount].clearstype,
            landcover: clears[clearscount].landcover,
            landmark: clears[clearscount].landmark,
            clearsreccuring: clears[clearscount].clearsreccuring,
            width: clears[clearscount].lewidth,
            length: clears[clearscount].lelength,
            depth: clears[clearscount].ledepth,
            casualty: clears[clearscount].idkilled,
            injured: clears[clearscount].idinjured,
            missing: clears[clearscount].idmissing,
            infra: clears[clearscount].idaffectedinfra,
            value: clears[clearscount].idaffectedcrops,
            cause: clears[clearscount].cause,
            typhoonname: clears[clearscount].typhoonname,
            heavyrainfall: clears[clearscount].heavyrainfall,
            reportedby: clears[clearscount].reportedby,
            reporterpos: clears[clearscount].reporterpos,
            author: clears[clearscount].author,
        });
        
    }   
    console.log(clears)
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
                                clears
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
                                    <p>Wow.
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
        console.log(clears);
        return false;
        $(this).toggleClass('activeclears');
        if($(this).hasClass('activeclears')){
            $(this).text('Remove on Map');
        }else{
            $(this).text('View on Map');
        }
        var v = parseInt($(this).attr('id'));  
            displayclearsMarkers(this,v); 
        }); 
    $.fn.toggleIconsC = function() {
        var isActive = $('#c-viewmap').hasClass("activeclears");
        $('#c-viewmap').toggleClass('activeclears');
        if (isActive) {
            $('#c-viewmap').text('View all clears');
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
        var i;
        for (i = 0; i < clearsmarkers.length; i++)
        {   
            if (clearsmarkers[i].id == id) {
                if ($(obj).hasClass("activeclears")) {
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



