$('#province_id').bind("keyup change", function(e){
    var cat_id = e.target.value;
    $('#municipality_id').removeAttr('disabled');
        $.ajax({
            type: 'GET',
            url: 'province-s?cat_id=' + cat_id,
            success:function(municipalities){
                var item = $('#municipality_id');
                item.empty();
                $.each(municipalities, function(i, municipality){
                    item.append("<option value='"+municipality.id+"'>" +municipality.name+"</option>");
                });
            }
        });
});
