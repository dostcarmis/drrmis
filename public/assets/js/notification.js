$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

$(document).ready(function(){
  var base_url = window.location.origin+'/';
	$('#seenotifications').on('click',function(){
		if($('.notifcount').text() != '0'){
			$value = $(this).val();
			$.ajax({
			type: 'post',
			url: base_url+'seenotifications',
			data: {
				'seenotifications' : $value
			},
			success:function(){
				$('.notifcount').text('0');
				$('.notifcount').addClass('hidden');
			}
		});
		}
	});
//================BIND==================//

  $("#innerNav").on("focusin", function(){
    $('.readnotifications').on('click',function(e){
      $val = $(this).find('#notifid').val();    
      $.ajax({
        type: 'post',
        url: base_url+'readnotifications',
        data: {
          'readnotifications' : $val
        }
      });
    });
  });
    

//========================================//
 	$.ajax({
      type: 'GET',
      url: base_url+'cn',
      dataType:"json",
      success:function(data){

          var item = $('#message-preview');
          var notifcount = $('.notifcount');
          item.empty();
          notifcount.empty();
          notifcount.append(data.unread);
          for (var i = 0; i < 3; i++) {
            item.append(data.output['body'][i]);            
          }    
          if($('.notifcount').text() == 0){
            $('.notifcount').addClass('hidden');
          }else{
            $('.notifcount').removeClass('hidden');
          }
        }

    });
    setInterval(function(){    
      $.ajax({
        type: 'GET',
        url: base_url+'cn',
        dataType:"json",
        success:function(data){

            var item = $('#message-preview');
            var notifcount = $('.notifcount');
            item.empty();
            notifcount.empty();
            notifcount.append(data.unread);
            for (var i = 0; i < data.output['body'].length; i++) {
              item.append(data.output['body'][i]);
              
            }       
            if($('.notifcount').text() == 0){
              $('.notifcount').addClass('hidden');
            }else{
              $('.notifcount').removeClass('hidden');
            } 
          }
   
        
      });
   },60000);
});