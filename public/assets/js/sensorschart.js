jQuery(function($){


var points = [];
var wlvl = [];

var subtitle = '';
var subtitle1 = '';
var time = [];
var dateyear = [];
var cat = '';

var csvcontents = frmCont.csvcontents;
if (csvcontents[1] < csvcontents.length) {
  cat = csvcontents[1].category;
}
var timehr = [];
if(cat != 1){
    subtitle = '24 hours Rainfall and Waterlevel';
    subtitle1 = 'Waterlevel and Rainfall (mm)';
  
}else{
    subtitle = '24 hours Rainfall';
    subtitle1 = 'Rainfall (mm)';
}


for(x = 0;x<csvcontents.length;x++){
    time[x] = csvcontents[x].time;
    var wlvlvalue = parseFloat(csvcontents[x].waterlvl);
    points.push({
            y: parseFloat(csvcontents[x].value),
            date: (new Date(csvcontents[x].date)).toDateString(),
            title: 'Rainfall',
            suffx: 'mm'
        }); 

    wlvl.push({
        y: wlvlvalue,
        date: (new Date(csvcontents[x].date)).toDateString(),
        title: 'Waterlevel',
        suffx: 'm'
    });
}

for (var i = 0;i<time.length; i++) {
    var myarr = time[i].split(':');

    var left = parseInt(myarr[0]);
    var right = parseInt(myarr[1]);
    
    var str ='';
    
    if(left > 12){
      left = parseInt(left) -12;
      str = left+':'+myarr[1]+' pm';
    }else if((left == 0) && (right == 0)){
      str = '12:'+myarr[1]+' mn';
    }else if((left == 0) && (right >= 1)){
      str = '12:'+myarr[1]+' am';
    }else if((left == 12) && (right == 0)){
      str = '12:'+myarr[1]+' nn';
    }else if((left == 12) && (right >= 1)){
      str = '12:'+myarr[1]+' pm';
    }else{
    str = left+':'+myarr[1]+' am';
    }
    timehr[i] = str;
}

$(function () {
    Highcharts.setOptions({lang: {noData: "Sensor not working! No data to Display."}});
    Highcharts.chart('persensorchart', {

        title: {
            text: $('.page-header').text(),
            x: -20 //center
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
        tooltip: {
            shared:false,

            formatter: function () {
                return 'Date: <strong>' + this.point.date + '</strong><br/>'+this.point.title+': <strong>' + this.point.y+' '+this.point.suffx +'</strong>';
            }


        },
        legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 0
        },
        series: [
        {
            name: 'Waterlevel',
            data: wlvl,
            color: '#ff0000',
            tooltip: {
                valueSuffix: 'cm'
            }
        },{
            name: 'Rainfall',
            data: points,
            yAxis: 1,
            color: '#00FFFF',
            tooltip: {
                valueSuffix: ' mm'
            }
        }]
    });

});



});