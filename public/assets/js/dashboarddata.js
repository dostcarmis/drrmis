jQuery(function($){
    $(document).ready(function(){
        var mainarray = frmCont.mainarray;
        var length = mainarray.length;
        var heavy = 0;
        var torrential = 0;
        var moderate = 0;
        var light = 0;
        var intense = 0;
        var colors_array= ["#9CC4E4", "#3A89C9", "#F26C4F"];
        for(x = 0;x<mainarray.length;x++){
            if(mainarray[x].total >= 401){
                torrential++;
            }else if((mainarray[x].total >= 301) && (mainarray[x].total <= 400)){
                intense++;
            }else if((mainarray[x].total >= 201) && (mainarray[x].total <= 300)){
                heavy++;
            }else if((mainarray[x].total >= 101) && (mainarray[x].total <= 200)){
                moderate++;
            }else{
                light++;
            }
            console.log(torrential);
        }

        var colors_array= ["#ff0000","#FF9707", "#000292", "#0231FF", "#00CFC9"];
        Morris.Donut({
            element: 'donut-chart',
            colors: colors_array,
            data: [{
                label: "Torrential",
                value: torrential
  
            },{
                label: "Intense",
                value: intense
  
            }, {
                label: "Heavy",
                value: heavy,
                
            }, {
                label: "Moderate",
                value: moderate
            }, {
                label: "Light",
                value: light
            }],
            resize: true
        });
    });
});