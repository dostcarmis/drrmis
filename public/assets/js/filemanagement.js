var risks = [];
$(document)/* .on('input','#searchFileName',function(e){
    let input = $(e.currentTarget);
    let val = input.val();
    let url = $('#searchFileForm').attr('action');
    $('#searchFileForm').attr('action',url+= val);
}) */
.on('submit','#searchFileForm',function(e){
    e.preventDefault();
    let input = $('#searchFileName');
    let val = input.val();
    let url = location.href;
    if(input.attr('kind') == 'filerepo'){
        if(url.search('filetype') != -1){
            if(url.search('filename') != -1)
                url = url.substring(0,url.search('&filename'))
            val = "&filename="+val;}
        else if(url[url.length-1] == "?"){val = "&filename="+val;}
        else{
            if(url.search('filename') != -1)
                url = url.substring(0,url.search('&filename'))
            val = "?filename="+val;}
        let red = url+val;
        window.location.replace(red);
    }else if(input.attr('kind') == 'sitrep' && val.trim() != ""){
        let sitrep_level = 'all';
        if(url.search('regional') != -1){
            sitrep_level = "regional";
        }else if(url.search('provincial') != -1){
            sitrep_level = "provincial";
        }
        url = baseURL+"sitreps";
        $.ajax({
            type:"POST",
            url:url,
            data: {sitrep_level:sitrep_level,val:val},
            success:function(response){
                if($.isEmptyObject(response.error)){
                    if(response){
                        $('#fileslist').html(response);
                        $('#sitrep_table').DataTable();
                    }else{
                        if(response.msg){
                            alert(response.msg)
                        }
                    }
                }else{
                    alert(response.error.messages);
                }
            },
            error:function(data){
                alertResponse('danger',data.responseJSON.message);
            }
        })
    }
})
.on('change','input[name=risk_check]',function(e){
    if($(e.currentTarget).val() == 'Typhoon' && $(e.currentTarget).is(':checked')){
        $('#addsitrepModal #typhoon_hidden').show();
        $('#addsitrepModal #typhoon_name').removeAttr('disabled').focus();
    }else if($(e.currentTarget).val() == 'Typhoon' && $(e.currentTarget).not(':checked')){
        $('#addsitrepModal #typhoon_hidden').hide();
        $('#addsitrepModal #typhoon_name').attr('disabled',true)
    }else if($(e.currentTarget).val() == 'Other' && $(e.currentTarget).is(':checked')){
        $('#addsitrepModal #other_hidden').show();
        $('#addsitrepModal #other_risk').removeAttr('disabled').focus();
    }else if($(e.currentTarget).val() == 'Other' && $(e.currentTarget).not(':checked')){
        $('#addsitrepModal #other_hidden').hide();
        $('#addsitrepModal #other_risk').attr('disabled',true)
    }
    risks = [];
    $('input[name=risk_check]').each(function(index){
        if($(this).is(':checked') && $(this).val() != 'Other'){
            risks.push(" "+$(this).val())}
    });
    $('#risk_').val((risks.toString()).trim());
})
.on('input','#addsitrepModal #other_risk',function(){
    risks = [];
    $('input[name=risk_check]').each(function(index){
        if($(this).is(':checked') && $(this).val() != 'Other'){
            risks.push(" "+$(this).val())}
    });
    if($('#addsitrepModal #risk_type8').is(':checked') && ($('#addsitrepModal #other_risk').val()).trim() != '' ){
        risks.push(" "+($('#addsitrepModal #other_risk').val()).trim());
    }
    $('#risk_').val((risks.toString()).trim());
})

$(document).ready( function () {
    $('#sitrep_table, #files-repo-table').DataTable();
});