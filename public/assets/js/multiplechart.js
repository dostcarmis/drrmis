jQuery(function($){
  $(document).ready(function(){
    $('#viwbycol').on('change',function(){
        $('.chartwrap div').removeClass();
        $('.chartwrap div').addClass($(this).val());
    });
  }); 
Highcharts.setOptions({
    colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
    chart: {
      backgroundColor: {
        linearGradient: [0, 0, 500, 500],
        stops: [
          [0, 'rgb(0, 0, 0)'],
          [1, 'rgb(0, 0, 0)']
        ]
      },
      borderWidth: 2,
      plotBackgroundColor: 'rgba(49, 49, 64, .9)',
      plotShadow: true,
      plotBorderWidth: 1
    },
    title: {
      style: {
        color: '#000',
        font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
      }
    },
    subtitle: {
      style: {
        color: '#666666',
        font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
      }
    }
  
  });

/*start for*/
var chartoptions = [];
var charts = [];
 var options = {
    chart: {
      zoomType: 'xy'
    },

    xAxis: {
      type: 'datetime'
    }
  };

for (var arrcount = 0; arrcount < csvcontents.length; arrcount++) {
  var devid = csvcontents[arrcount][0].dev_id;
  var cat = csvcontents[arrcount][0].category;
  var devid = csvcontents[arrcount][0].dev_id;
  var timehr = [];
  var points = [];
  var wlvl = [];
  var time = [];

  for(x = 0;x<csvcontents[arrcount].length;x++){
      var wlvlvalue = parseFloat(csvcontents[arrcount][x].waterlvl) / 100;
      time[x] = csvcontents[arrcount][x].time;
      points[x] = parseFloat(csvcontents[arrcount][x].value);
      wlvl[x] = wlvlvalue;
  }

  if(cat != 1){
    subtitle = '24 hours Rainfall and Waterlevel';
    subtitle1 = 'Waterlevel and Rainfall (mm)';
  }else{
    subtitle = '24 hours Rainfall';
    subtitle1 = 'Rainfall (mm)';
  }
for (var i = 0;i<time.length; i++) {
  var myarr = time[i].split(':');

  var left = parseInt(myarr[0]);
  var right = parseInt(myarr[1]);

  var str ='';

  if(left > 12){
    left = parseInt(left) -12;
    str = left+':'+myarr[1]+'pm';
  }else if((left == 0) && (right == 0)){
    str = '12:'+myarr[1]+'mn';
  }else if((left == 0) && (right >= 1)){
    str = '12:'+myarr[1]+'am';
  }else{
  str = left+':'+myarr[1]+'am';
  }
  timehr[i] = str;
  }
	 // create the chart
  chartoptions[arrcount] = {
    chart: {
      renderTo: 'persensorchart-'+devid,
      zoomType: 'xy'
    },
        subtitle: {
            text: subtitle,
            x: -20
        },
    xAxis: {
            categories: timehr,

        },        
        yAxis: [{
            title: {
                text: 'Waterlevel (m)',
                
            },
            labels: {
                format: '{value} m',
                style: {
                    color: '#ff0000'
                }
            },
            min:0,
            minRange:1,
           
        },{            
            title: {
                text: 'Rainfall (mm)',
            },
            min:0,
            minRange:1,
            opposite:true,
            labels: {
                format: '{value} mm',
                style: {
                    color: '#00FFFF'
                }
            }
        }],
    series: [
    {
      name: 'Waterlevel',
      data: wlvl,
      color: '#ff0000',
      tooltip: {
          valueSuffix: 'm'
      }
    },
    {
      name: 'Rainfall',
      data: points,
      yAxis: 1,
      color: '#00FFFF',
      tooltip: {
          valueSuffix: ' mm'
      }
    }]
  };
  chartoptions[arrcount] = jQuery.extend(true, {}, options, chartoptions[arrcount]);
  charts[arrcount] = new Highcharts.Chart(chartoptions[arrcount]);


}/*endfor*/
 

});

