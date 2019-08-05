jQuery(function($){
	$(document).ready(function(){
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
		
$('.headcheckbox').click(function (e) {
	var x = $(this).closest('table').find('td input.chbox');
    x.prop('checked', this.checked); 
    if($(this).prop("checked")){
    	$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('.btn-deleteselected').removeAttr('disabled'); 
    }else{
    	$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('.btn-deleteselected').attr('disabled','disabled'); 
    } 
});
var checkedValue = $('.chbox:checked').val();

$('.chbox').click(function (e) {
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
   console.log(checkedValue);
});

	
	
	});/*end load*/
});