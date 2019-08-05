$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});


function $_GET(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace( 
        /[?&]+([^=&]+)=?([^&]*)?/gi, 
        function( m, key, value ) { 
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;    
    }
    return vars;
}
/******/
var stat = $_GET('statustitle');
$('#statustitle option[value='+stat+']').attr("selected", "selected");
if(stat == 1){
    $('.no_data').addClass('hidden');
    $('.delayed').addClass('hidden');
}else if(stat == 2){
    $('.with_data').addClass('hidden');
    $('.delayed').addClass('hidden');
}else if(stat == 3){
    $('.with_data').addClass('hidden');
    $('.no_data').addClass('hidden');
}
