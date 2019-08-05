$(function(){
    $.fn.filedel = function(id){
        
        var r = confirm("Are you sure you want to delete this file?");
        if (r == true){
            var url = "deleterisk/" + id;
            $('#file-delete').attr('action' , url).submit();
            //console.log(url);
        } else {   

        }    
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

});

