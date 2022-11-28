$(function(){
    $.fn.delfile = function(id){
        
        var r = confirm("Are you sure you want to delete this file?");
        if (r == true){
            var url = "filedownloadpage/deletefile/" + id;
            $('#delete-file').attr('action' , url).submit();
            //console.log(url);
        } else {   

        }    
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
});

$(function(){
    $.fn.delsitrep= function(id){
        
        var r = confirm("Are you sure you want to delete this sitrep?");
        if (r == true){
            // alert($('#delete-sitrep').attr('url'))
            let cur = $('#delete-sitrep').attr('url');
            if(cur.search("provincial") == -1 && cur.search('regional') == -1 && cur.search('municipal') == -1)
                var url = "sitreps/deletesitrep/" + id;
            else
                var url = "deletesitrep/" + id;
            $('#delete-sitrep').attr('action' , url).submit();
            //console.log(url);
        } else {   

        }    
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
});