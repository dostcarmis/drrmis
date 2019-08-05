$(document).ready(function() {

    var max_fields      = 10; 
    var wrapper         = $(".inputswrapper");
    var add_button      = $(".btnaddmoresource");
    
    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append('<div><div class="col-xs-12 perinputwrap col-sm-8 perinputwrap'+x+'"></div><div class="col-xs-12 perinputwrap col-sm-3 perinputwrap ptxtinput'+x+'"></div><div class="col-xs-12 col-sm-1 perinputwrap"><a href="#" class="remove_field" title="Remove Source"><span class="glyphicon glyphicon-remove"></span></a></div></div>'); //add input box
            $('.mainselect select#address_id').clone().appendTo('.perinputwrap'+x);
            $('.maininput input#threshold_flood').clone().appendTo('.ptxtinput'+x).text('');
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent().parent('div').remove(); x--;
    });



    var formatName = function(item) {
        return $.trim(item.address || '');
    };

    $('#affected_areas').selectize({
        persist: false,
        maxItems: null,
        valueField: 'id',
        labelField: 'address',
        searchField: ['address', 'email'],
        sortField: [
            {field: 'address', direction: 'asc'}
        ],
        options: frmCont.floodproneareas,
        render: {
            item: function(item, escape) {
                var name = formatName(item);
                return '<div>' +
                    (name ? '<span class="name">' + escape(name) + '</span>' : '') +
                    (item.name ? '<span class="email">' + escape(item.name) + '</span>' : '') +
                '</div>';
            },
            option: function(item, escape) {
                var name = formatName(item);
                var label = name || item.name;
                var caption = name ? item.email : null;
                return '<div>' +
                    '<span class="label">' + escape(label) + '</span>' +
                    (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
                '</div>';
            }
        }
    });
  
    var $editselect =  $('#affected_areas_edit').selectize({
        persist: false,
        maxItems: null,
        valueField: 'id',
        labelField: 'address',
        searchField: ['address', 'email'],
        sortField: [
            {field: 'address', direction: 'asc'}
        ],
        options: frmCont.floodproneareas,
        render: {
            item: function(item, escape) {
                var name = formatName(item);
                return '<div>' +
                    (name ? '<span class="name">' + escape(name) + '</span>' : '') +
                    (item.name ? '<span class="email">' + escape(item.name) + '</span>' : '') +
                '</div>';
            },
            option: function(item, escape) {
                var name = formatName(item);
                var label = name || item.name;
                var caption = name ? item.email : null;
                return '<div>' +
                    '<span class="label">' + escape(label) + '</span>' +
                    (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
                '</div>';
            }
        },
    });
      var control = $editselect[0].selectize;
        control.setValue(affectedareas);
});