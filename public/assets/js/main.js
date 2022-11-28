jQuery(function($){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//================LOAD=========================///
$(document).ready(function(){    

    var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = decodeURIComponent(window.location.search.substring(1)),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

      for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
              return sParameterName[1] === undefined ? true : sParameterName[1];
          }
      }
  };



    var base_url = window.location.origin+'/';
    //var base_url = '/drrmis/public/';
    var thisdate = new Date();
    var defdate;

    thisdate.setDate(thisdate.getDate() + 20);

    defdate = thisdate.getFullYear() + '-'
             + ('0' + (thisdate.getMonth()+1)).slice(-2) + '-'
             + ('0' + thisdate.getDate()).slice(-2)+' '+('0' + thisdate.getHours()).slice(-2)+':'+('0' + thisdate.getMinutes()).slice(-2);
    $('#hiddendatepick').val(defdate);

    $('a.titletoggle').on('click', function(e){
      e.preventDefault();
      $($(this).parent()).toggleClass('open');        
    }); 

    try {
      $('.input-group.date.dates').datepicker({
        format: "yyyy-mm-dd", 
        useCurrent: false,
      });

      $('.perinputwrap #date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
      });

      $('.perinputwrap #datein').datetimepicker({
        inline: true,
        sideBySide: false,
        format: 'YYYY-MM-DD HH:mm', 
      });

      $('#datein').on('dp.change', function(event) { 
        var formatted_date = event.date.format('YYYY-MM-DD HH:mm');
        $('#hiddendatepick').val(formatted_date);

        

      });
    }    
    catch(err) { 

    }

    $('#overlaytype').on('change',function(){
      if($(this).val() == 'imagetype'){
        $(this).parent().parent().find('.kmltype').addClass('hidden');
        $(this).parent().parent().find('.imagetype').removeClass('hidden');
      } else {
        $(this).parent().parent().find('.imagetype').addClass('hidden');
        $(this).parent().parent().find('.kmltype').removeClass('hidden');
      }
    }); 

    var pathArray = window.location.pathname;

    if (pathArray.charAt(0) == "/") pathArray = pathArray.substr(1);

    var pathArray1 = window.location.pathname;

//=============================ADD EDIT PROVICE MUNICIPALITY DRP=========================//
  $('#province_id').bind("keyup change", function(e){

    var cat_id = e.target.value;
    $('#municipality_id').removeAttr('disabled');

    $.ajax({
      type: 'GET',
      url: `${baseURL}/ajax-subcat?cat_id=${cat_id}`,
      success:function(municipalities){
        var item = $('#municipality_id');
        item.empty();
        $.each(municipalities, function(i, municipality){
            item.append("<option value='"+municipality.id+"'>" +municipality.name+"</option>");
        });
      }
    });

  });

  var url = window.location.href;
  var value = url.substring(url.lastIndexOf('/') + 1);

  $('#province_idedit').bind("keyup change", function(e){

    $('#municipality_idedit').removeAttr('disabled');
    var cat_id = e.target.value;  

    $.ajax({
      type: "GET",
      url: `${baseURL}/ajax-subcat?cat_id=${cat_id}`,
      success:function(municipalities){
        var item = $('#message-preview');
        item.empty();
        $.each(municipalities, function(municipality){
            item.append("<option value='"+municipality.id+"'>" +municipality.name+ "</option>");
        });
      }
    });

  });
//===============================THRESHOLD PAGE CHECK CATEGORY==========================//

  function checkcategory(sensorcat){
    if (sensorcat == 2){
      $('#waterlevel-thresh-wrap').removeClass("hidden"); 
      $('#rain-thresh-wrap').addClass("hidden"); 
    }else if((sensorcat == 3)){
      $('#waterlevel-thresh-wrap').removeClass("hidden");   
      $('#rain-thresh-wrap').removeClass("hidden");       
    }else{
      $('#rain-thresh-wrap').removeClass("hidden");
      $('#waterlevel-thresh-wrap').addClass("hidden");
    }
  }

  $('#threshold_opt').change(function(){
    var sensorcat = $('#threshold_opt option:selected').attr('data-categoryid');
    checkcategory(sensorcat);
    });
  
//====================DISPLAY INCIDENTS =====================//
  var incidentType = getUrlParameter('ftype');
  var defIncident = '';
  if(incidentType === 'All'){
    defIncident == '';
  }else{
    defIncident = incidentType;
  }
  $.ajax({
    type: 'GET',
    dataType: 'json',
    url: `${baseURL}/incidents`,
    success:function(data){        
       $('#incidenttable').dataTable({
              data: data.data, 
              "paging": false,
              "oSearch": {"sSearch": defIncident}
        });

       var incidentTable = $('#incidenttable').DataTable();
        $('#searchall').keyup(function(){
          incidentTable.search($(this).val()).draw() ;
        });

        $('.optFilterIncident').change(function () {
            incidentTable
                .columns(2)
                .search($(this).val())
                .draw();
        });

       

        var checkedValue = $('.chbox:checked').val();

        $('.chbox').on('click',function (e) {
          if($(".chbox").length == $(".chbox:checked").length) {
            $(".headcheckbox").prop("checked", true);
          } else {
            $(".headcheckbox").prop("checked", false);
          }

         if($(".chbox:checked").length == 0){
            $(this).parent().parent().parent().parent().parent().parent().parent().parent().find('.btn-deleteselected').attr('disabled','disabled'); 
         }else{
            $(this).parent().parent().parent().parent().parent().parent().parent().parent().find('.btn-deleteselected').removeAttr('disabled'); 
         }

        });

        $('.deletepost').on('click',function(e){
          e.preventDefault();
          var btnid = $(this).attr("id");   
          var title = $(this).attr("title");
          var oid = $(this).attr("value");
          if(window.location.href.indexOf("page") != -1){
              window.location.href = window.location.href+"&snsid="+btnid+"&title="+title+"&oid="+oid;
            }else{
              window.location = "?snsid="+btnid+"&title="+title+"&oid="+oid;
            }
        });

        $("#mymodal").on("hidden.bs.modal", function (e) {
          e.preventDefault();
            window.location = 'incidents';
        });
    } 
  });



//===============================DISPLAY HYDROMET DATA TO TABLE==========================//
  var currentSensortype = 'rain';
  $('#hydromettable').dataTable({
                "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false,  
                },{ 
                  className: "hidden", "targets": [ 0 ] }
                ],
                "paging": false,
          });
  function getdata(sensortype){
    $.ajax({
      type: 'GET',
      dataType: 'json',
      url: `${baseURL}/ajaxhydromet?sensortype=${sensortype}`,
      success: function(data){
        $('#hydromettable').empty();
        

          var hydrometTable =  $('#hydromettable').DataTable();

          $('#hydrometsearch').keyup(function(){
                hydrometTable.search($(this).val()).draw() ;
          });
          $('.filtertable select').change(function () {
              hydrometTable
                  .columns(1)
                  .search($(this).val())
                  .draw();
          });
      }
    });
  } 
  $('.filtersensor select').change(function(){
      var x = $('#hydromettable').dataTable();  
      $('#filterstatus :first-child').prop('selected', true);   
      x.fnDestroy();
    //  getdata($(this).val());
      currentSensortype = $(this).val();
      
  });

  var newSensortype = sessionStorage.getItem('sensortype');

  $('#hydromettable').on( 'click', 'tbody tr', function () {
      $value = $(this).find('span').attr('data-value');      
      sessionStorage.setItem('sensortype', currentSensortype);
      $.ajax({
          type: 'get',
          url: `${baseURL}/viewhydrometdata`,
          data: {
              'sensorid' : $value
          },success:function(){
              window.location = 'viewpersensor?sensorid=' + $value;
          }
      });
   });

  //load data
  if(newSensortype != null){
      if(newSensortype == 'stream'){
       // getdata('stream');
        $('.filtersensor select option:nth-child(2)').attr('selected','selected');
      }else{
       // getdata('rain');
        $('.filtersensor select option:first-child').attr('selected','selected');
      }
  }else{
   // getdata('rain');
  }


    //poll
    setInterval( function () {
      var x = $('#hydromettable').dataTable();
       x.fnDestroy();      
      // getdata(currentSensortype);
    }, 600000 );   


//====================DISPLAY SENT MESSAGES =====================//

$.ajax({
  type: 'GET',
  dataType: 'json',
  url: `${baseURL}/warn/sent-messages`,
  success: function(data) {      
    const checkedValue = $('.chbox:checked').val();

    $('#sentmsgstable').dataTable({
      data: data.data, 
      paging: false,
    });
    $('#searchall').keyup(function(){
      sentmessageTable.search($(this).val()).draw();
    });

    //let sentmessageTable = $('#sentmsgstable').DataTable();

    $('.optFilterIncident').change(function () {
      sentmessageTable.columns(2)
                      .search($(this).val())
                      .draw();
    });

    $('.chbox').on('click', function(e) {
      if($(".chbox").length == $(".chbox:checked").length) {
        $(".headcheckbox").prop("checked", true);
      } else {
        $(".headcheckbox").prop("checked", false);
      }

      if($(".chbox:checked").length == 0){
        $(this).parent()
               .parent()
               .parent()
               .parent()
               .parent()
               .parent()
               .parent()
               .parent()
               .find('.btn-deleteselected')
               .attr('disabled','disabled'); 
      }else{
        $(this).parent()
               .parent()
               .parent()
               .parent()
               .parent()
               .parent()
               .parent()
               .parent()
               .find('.btn-deleteselected')
               .removeAttr('disabled'); 
      }
    });

    $('.deletepost').on('click', function(e) {
      const btnid = $(this).attr("id");   
      const title = $(this).attr("title");
      const oid = $(this).attr("value");

      e.preventDefault();
      
      if (window.location.href.indexOf("page") != -1) {
        window.location.href =`${window.location.href}&snsid=${btnid}&title=${title}&oid=${oid}`;
      } else {
        window.location = `?snsid=${btnid}&title=${title}&oid=${oid}`;
      }
    });

    $("#mymodal").on("hidden.bs.modal", function (e) {
      e.preventDefault();
      window.location = 'sent-messages';
    });
  } 
});

//===============================OTHER TABLES==========================//
    

    $('#dashboardtables').dataTable({
      responsive: true,
      "paging": false,
      "aaSorting": [],
      "columnDefs": [ {
        "targets"  : 'no-sort',
        "orderable": false,
      }]
    });

    mytable = $('#dashboardtables').DataTable();
    $('#searchall').keyup(function(){
      mytable.search($(this).val()).draw() ;
    });
    


//=========================//


    // $("#saveRehab").submit(function(event){
    //   event.preventDefault();
    //   // var formData = {
    //   //   'filename' :    $('input[name=filename]').val(),
    //   //   'fileToUpload' : $('input[name=fileToUpload]').val()

    //   // }
    //   // var filetoupload = document.getElementById('fileToUpload');
    //   // var filename = document.getElementById('filename');

    //   data = new FormData($("#saveRehab").get(0));

    //   data.append("fileToUpload", $('#fileToUpload').get(0).files[0]);
        
    //   $.ajax({
    //     url: base_url+'saverehab', 
    //     type: 'post',
    //     data: data,
    //     dataType : 'json',
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     success:function(){
    //       console.log('test')
    //     }
    //   });
    
    // });
    



  });//end document ready








//===========================FORM VALIDATOR==========================//



    $( "#userform" ).validate( {
        rules: {
          location: "required",
          
          latitude: {
            required: true,
            number: true
          },
          longitude: {
            required: true,
            number: true
          },
          radprovince: "required",
          datein: "required",        
        },
        messages: {
          location: "Please enter the Location",
          
          latitude: {
            required: "Please enter Latitude",
            number: "Please enter a valid Latitude"
          },
          longitude: {
            required: "Please enter Longitude",
            number: "Please enter a valid Longitude"
          },
          radprovince: "Please enter a valid email address",
          datein: "Please select date"
        },       
        errorElement: "em",
        errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
          } else {
            error.insertAfter( element );
          }
        },
        highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".reqelement" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".reqelement" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      } );



});

