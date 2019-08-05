/*====MT KML FILES ====*/

    for (var i = 0; i < mtprovincekmls.length; i++) {      
        var result = mtprovincekmls[i].split('_'); //result[2]; - Municipality
        var cummulativedata = 0;
        var stypekml = '';
        var newkmllink = '';

        for (var x = 0; x < arrtotals.length; x++) {
            if(arrtotals[x].municipality_id == result[2]){      
                cummulativedata = arrtotals[x].total;
                if(arrtotals[x].category == 1){
                    stypekml = 'Rain Gauges';
                }else if(arrtotals[x].category == 2){
                    stypekml = 'Stream Gauges';
                }else if(arrtotals[x].category== 3){
                    stypekml = 'Rain & Stream Gauges';
                }else{                        
                    stypekml = 'Weather Stations';
                }

                if(cummulativedata >= 401){
                    newkmllink = result[0]+'_torrential_'+result[2]+'_'+result[3];
                }else if((cummulativedata >= 301) && (cummulativedata <= 400)) {
                    newkmllink = result[0]+'_intense_'+result[2]+'_'+result[3];
                }else if((cummulativedata >= 201) && (cummulativedata <= 300)){
                    newkmllink = result[0]+'_heavy_'+result[2]+'_'+result[3];
                }else if((cummulativedata >= 101) && (cummulativedata <= 200)){
                    newkmllink = result[0]+'_moderate_'+result[2]+'_'+result[3];
                }else{
                    newkmllink = mtprovincekmls[i];
                }

                kmlfnalmt.push({
                    fname: result[0],
                    kmlfnalfile: newkmllink, 
                    categoryname:stypekml,              
                    cummulative : cummulativedata,
                });
            }
        }              
    }    

/*=====Loop for MT kmlfiles ====*/
        function setmapmp(){
            var kmlmtmarkers = [];
            var abc, mylayers;
            for(abc=0;abc<kmlfnalmt.length;abc++){
                var data = kmlfnalmt[abc];

                mylayers = siteurlmtprovince+'/'+ kmlfnalmt[abc].kmlfnalfile;

                kmlurl = new google.maps.KmlLayer(mylayers,{
                    preserveViewport:true,    
                    suppressInfoWindows: true,                              
                    map:map
                });

                kmlurl.category = kmlfnalmt[abc].categoryname;
                kmlmtmarkers.push(kmlurl);
                
                (function (kmlurl, data) {
                        google.maps.event.addListener(kmlurl, "click", function (e) {
                            var content = "<div id='iw-container'><div class='iw-title s-maptitle'>"+data.fname+"</div><div class='iw-content l-mapcontent'><span class='s-name'>Sensor Type: <span>"+data.categoryname+"</span></span><span class='l-coordinates'>Cumulative 8am: <span>"+data.cummulative+"mm</span></span></div><div class='iw-bottom-gradient'></div></div>";
                            HandleInfoWindow(e.latLng, content);
                        });
                })(kmlurl, data);    

                function HandleInfoWindow(latLng, content) {
                    kmlinfowindow.setContent(content);
                    kmlinfowindow.setPosition(latLng);
                    kmlinfowindow.open(map);
                }                  
            }
        }

/****END Loop for MT kmlfiles ****/
====Kalinga KML FILES ====

    for (var i = 0; i < kalingakmls.length; i++) {      
        var result = kalingakmls[i].split('_'); //result[2]; - Municipality
        var cummulativedata = 0;
        var stypekml = '';
        var newkmllink = '';

        for (var x = 0; x < arrtotals.length; x++) {
            if(arrtotals[x].municipality_id == result[2]){      
                cummulativedata = arrtotals[x].total;
                if(arrtotals[x].category == 1){
                    stypekml = 'Rain Gauges';
                }else if(arrtotals[x].category == 2){
                    stypekml = 'Stream Gauges';
                }else if(arrtotals[x].category== 3){
                    stypekml = 'Rain & Stream Gauges';
                }else{                        
                    stypekml = 'Weather Stations';
                }

                if(cummulativedata >= 401){
                    newkmllink = result[0]+'_torrential_'+result[2]+'_'+result[3];
                }else if((cummulativedata >= 301) && (cummulativedata <= 400)) {
                    newkmllink = result[0]+'_intense_'+result[2]+'_'+result[3];
                }else if((cummulativedata >= 201) && (cummulativedata <= 300)){
                    newkmllink = result[0]+'_heavy_'+result[2]+'_'+result[3];
                }else if((cummulativedata >= 101) && (cummulativedata <= 200)){
                    newkmllink = result[0]+'_moderate_'+result[2]+'_'+result[3];
                }else{
                    newkmllink = kalingakmls[i];
                }

                kmlfnalk.push({
                    fname: result[0],
                    kmlfnalfile: newkmllink, 
                    categoryname:stypekml,              
                    cummulative : cummulativedata,
                });
            }
        }              
    }    

/*=====Loop for K kmlfiles ====*/
        function setmapk(){
            var kmlkmarkers = [];
            var abc, mylayers;
            for(abc=0;abc<kmlfnalk.length;abc++){
                var data = kmlfnalk[abc];

                mylayers = siteurlkalinga+'/'+ kmlfnalk[abc].kmlfnalfile;
                console.log(mylayers);
                kmlurl = new google.maps.KmlLayer(mylayers,{
                    preserveViewport:true,    
                    suppressInfoWindows: true,                              
                    map:map
                });

                kmlurl.category = kmlfnalk[abc].categoryname;
                kmlkmarkers.push(kmlurl);
                
                (function (kmlurl, data) {
                        google.maps.event.addListener(kmlurl, "click", function (e) {
                            var content = "<div id='iw-container'><div class='iw-title s-maptitle'>"+data.fname+"</div><div class='iw-content l-mapcontent'><span class='s-name'>Sensor Type: <span>"+data.categoryname+"</span></span><span class='l-coordinates'>Cumulative 8am: <span>"+data.cummulative+"mm</span></span></div><div class='iw-bottom-gradient'></div></div>";
                            HandleInfoWindow(e.latLng, content);
                        });
                })(kmlurl, data);    

                function HandleInfoWindow(latLng, content) {
                    kmlinfowindow.setContent(content);
                    kmlinfowindow.setPosition(latLng);
                    kmlinfowindow.open(map);
                }                  
            }
        }

/****END Loop for MT kmlfiles ****/
/********************************END MULTI KML CONTOURS**********************************/

/*=============================Contours ON CLICKS ==================================*/
        $('.mtprovincecontour').on('click',function(e){
            e.preventDefault(); 
            kmlurl.setMap(null);
            setmapmp();
                
        });      
        $('.kalingacontour').on('click',function(e){
            e.preventDefault(); 
            kmlurl.setMap(null);
            setmapk();
                
        }); 
/**********************End Contours ON CLICKS********************************/
