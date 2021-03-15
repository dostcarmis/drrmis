$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){
    var searchInput;
	var recipients = [];
    var _recipients = [];

    $("#recipient-count").html(recipients.length);
    $(".overlay").fadeOut(500);

    initializeContacts();

    function initializeContacts() {

        $.post('get-recipients', {
            _token: $('meta[name=csrf-token]').attr('content'),
        }).done(function(data) {
            contacts = JSON.parse(data);

            var contact = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('contact_name', 'contact_number'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: contacts
            });

            contact.initialize();

            var ifEmptySuggestion = false;
            searchInput = $('.typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'contact',
                displayKey: 'contact_name',
                source: contact.ttAdapter(),
                templates: {
                    empty: function() {
                        ifEmptySuggestion = true; //$("#contact-input").val();

                        //"<em> Press 'Enter Key' to add recipient manually. </em>";
                        // "<em> Contact not found. </em>"
                        return "<em> Press 'Enter Key' to add recipient manually. </em>";
                    },
                    suggestion: function(data) {
                        ifEmptySuggestion = false;

                        return '<ul style=' + '"list-style: none; margin-left: 20px;"' + '>' +
                                    '<li><strong>' + data.contact_name + '</strong></li>' +
                                    '<li><em>' +  data.contact_number + '</em></strong>' +
                                '</ul>';
                    }
                }
            }).on('typeahead:selected', function(obj, datum){ //datum will be the object that is selected 
                var isInContact = true;
                var textCount = $("#msg").val().length;
                var inputContactName = datum.contact_name;
                var inputRecipient = datum.contact_number;
                var contactImage = datum.picture;
                var recipientsLength = 0;
                var n = 0;

                inputRecipient = inputRecipient.replace(/-/g , "");
                inputRecipient = inputRecipient.replace(/ /g , "");
                n = inputRecipient.length;
                
                proccessNumber(isInContact, n, inputRecipient, inputContactName, contactImage);
                recipientsLength = recipients.length;

                setEnable_Disable_MsgBody(textCount, recipientsLength);

            })/*.keypress(function(e) {

                var key = e.which;
                var isInContact = false;
                var textCount = $("#msg").val().length;
                var inputRecipient = $("#contact-input").val();
                var inputContactName = "";
                var contactImage = "default.jpg";
                var recipientsLength = 0;
                var n = 0;

                inputRecipient = inputRecipient.replace(/-/g , "");
                inputRecipient = inputRecipient.replace(/ /g , "");
                n = inputRecipient.length;

                if (key == 13 && ifEmptySuggestion == true) {

                    proccessNumber(isInContact, n, inputRecipient, inputContactName, contactImage);
                    recipientsLength = recipients.length;

                }

                setEnable_Disable_MsgBody(textCount, recipientsLength);

            });*/               
        }).fail(function(xhr, status, error) {
            initializeContacts();
        });
    }

    function setEnable_Disable_MsgBody(textCount, recipientsLength){
        if (textCount > 0 && recipientsLength > 0){
            $("#send-msg").removeAttr("disabled");
        } else {
            $("#send-msg").attr("disabled", "disabled");
        }
    }

    function proccessNumber(isInContact, n, inputRecipient, inputContactName, contactImage){
        var isValidNumber = false;
        var firstChar = "";

        firstChar = inputRecipient.charAt(0);

        if (n == 13 || n == 11){
            if (!inputRecipient.match(/[a-z]/i)) {
                isValidNumber = true;
            }

            if (isValidNumber) {
                if (inputRecipient.substring(0, 2) != "09" && n == 11){
                    isValidNumber = false;
                }else if (inputRecipient.substring(0, 4) != "+639" && n == 13){
                    isValidNumber = false;
                }
            }

            if (isValidNumber) {

                var hasDuplicate = false;

                if (firstChar == "0" && n == 11){
                    inputRecipient = inputRecipient.slice(1, n);
                    inputRecipient = "+63" + inputRecipient;

                    if (!isInContact){
                        inputContactName = inputRecipient;
                    }
                }

                for (var i = 0; i < recipients.length; i++) {
                    if (recipients[i] == inputRecipient) {
                        hasDuplicate = true;
                        break;
                    }
                }

                if (!hasDuplicate) {
                    _recipients.push({ 
                        picture: contactImage, 
                        contact_name: inputContactName, 
                        contact_number: inputRecipient 
                        }
                    );
                    recipients.push(inputRecipient);
                }
                
                searchInput.typeahead('val','');

                $("#recipient-count").html(recipients.length);
            }
        }
    }

    /* toggle all checkboxes in group */
    $('.all-contact').click(function(e){
        e.stopPropagation();
        var $this = $(this);
        if($this.is(":checked")) {
            $this.parents('#list1').find("[type=checkbox]").prop("checked",true);
        } else {
            $this.parents('#list1').find("[type=checkbox]").prop("checked",false);
            $this.prop("checked",false);
        }
    });

    $('[type=checkbox]').click(function(e){
        e.stopPropagation();
    });
     $('.all-recipient').click(function(e){

        var countCheck = 0;

        e.stopPropagation();
        var $this = $(this);
        if($this.is(":checked")) {
            $this.parents('#list2').find("[type=checkbox]").prop("checked",true);
        } else {
            $this.parents('#list2').find("[type=checkbox]").prop("checked",false);
            $this.prop("checked",false);
        }

        $('#list2 a input:checked').each(function() {
            countCheck++;
        });

        if (countCheck > 0){
            $("#remove-recipient").removeAttr("disabled");
        } else {
            $("#remove-recipient").attr("disabled", "disabled");
        }
    });

    $('[type=checkbox]').click(function(e){
        e.stopPropagation();
    });

    /* toggle checkbox when list group item is clicked */
    $('#list1 a').click(function(e){
        e.stopPropagation();
      
        var $this = $(this).find("[type=checkbox]");
        if($this.is(":checked")) {
            $this.prop("checked",false);
        } else {
            $this.prop("checked",true);
        }
      
        if ($this.hasClass("all-contact")) {
            $this.trigger('click');
        }
    });

    $("#select-multiple").click(function(){
    	$("#modal-contact-list").modal({backdrop: 'static', keyboard: false});

        var $this = $("#list1 a").find("[type=checkbox]");

        if($this.is(":checked")) {
            $this.prop("checked",false);
        }
    });

    var segmentCount = 0;
    var textSegmentCount = 0;

    function msgBodyCounter(textCount) {
        segmentCount = Math.floor(textCount / 160);

        if (segmentCount == 0) {
            if (textCount <= 160){
                textSegmentCount = textCount;
                $("#character-count").html(textSegmentCount + "/160");
            } else if (textCount > 160) {
                textSegmentCount = textCount - (160 * segmentCount);
                $("#character-count").html(textSegmentCount + "/160 (" + (segmentCount + 1) + ")");
            }
        } else if (segmentCount > 0) {
            textSegmentCount = textCount - (160 * segmentCount);

            if (textSegmentCount == 160) {
                textSegmentCount = textCount - (160 * segmentCount);
            } else if (textSegmentCount < 1) {
                textSegmentCount = textCount - (160 * segmentCount);
            }

            if (textSegmentCount == 0) {
                textSegmentCount = 160;
                segmentCount = Math.floor((textCount - 1) / 160);
            }

            if (textCount > 160) {
                $("#character-count").html(textSegmentCount + "/160 (" + (segmentCount + 1) + ")");
            } else if (textCount <= 160) {
                $("#character-count").html(textSegmentCount + "/160");
            }
        }

        setSendButton(textCount);
    }

    function setSendButton(textCount) {
        if (textCount > 0 && recipients.length > 0){
            $("#send-msg").removeAttr("disabled");
        } else if (textCount == 0 || recipients.length == 0){
            $("#send-msg").attr("disabled", "disabled");
        }
    }

    $("#msg").keyup(function(){
    	var textCount = $(this).val().length;
        msgBodyCounter(textCount);
    }).keydown(function() {
        var textCount = $(this).val().length;
        msgBodyCounter(textCount);
    });

    $("#btn-recipient").click(function (){
        var n = recipients.length;        
        $("#modal-recipient-list").modal({backdrop: 'static', keyboard: false});

        var $this = $("#list2 a").find("[type=checkbox]");

        if($this.is(":checked")) {
            $this.prop("checked",false);
        }

        if (n > 0){
            var countCheck = 0;
            $("#recipient-list").html("");

            for (var i = 0; i < n; i++) {
                $("#recipient-list").append(
                    "<a href='#' class='list-group-item'>" +
                        "<input name='" + _recipients[i].picture + "*" + _recipients[i].contact_name + "' value='" + 
                                          _recipients[i].contact_number + "' " +
                               "type='checkbox' class='pull-right'>" +
                        "<center> " +                                               
                            "<img class='img-settings' src='../uploads/avatars/" + _recipients[i].picture + "'" +
                                 "height='40' width='40'>" +
                            "<ul class='contact-detail'>" +
                                "<li>" +
                                    "<strong class='recipient-name'> " +  _recipients[i].contact_name + " </strong> " +
                                "</li>" +
                                "<li>" +
                                    "<em class='recipient-number'> " +  _recipients[i].contact_number + " </em>" +
                                "</li>" +
                            "</ul>" +
                        "</center>" +
                    "</a>"
                );
            }

            $('#list2 a').click(function(e){
                var $this = $(this).find("[type=checkbox]");

                countCheck = 0;
                e.stopPropagation();

                if($this.is(":checked")) {
                    $this.prop("checked",false);
                } else {
                    $this.prop("checked",true);
                }
                
                if ($this.hasClass("all-recipient")) {
                    $this.trigger('click');
                }

                $('#list2 a input:checked').each(function() {
                    countCheck++;
                });

                if (countCheck > 0){
                    $("#remove-recipient").removeAttr("disabled");
                } else {
                    $("#remove-recipient").attr("disabled", "disabled");
                }

            });
        }  
    });

    $('#remove-recipient').on('click', function(event) {
        var $this = $("#list2 a").find("[type=checkbox]");
        var textCount = $("#msg").val().length;

        _recipients = [];
        recipients = [];

        $('#recipient-list a input:checkbox:not(:checked)').each(function() {

            var inputContactName = $(this).attr('name');
            var contactImgName = inputContactName.split("*");
            var inputRecipient = $(this).attr('value');
            var recipientsLength = 0;

            inputRecipient = inputRecipient.replace(/-/g , "");
            inputRecipient = inputRecipient.replace(/ /g , "");

            _recipients.push( { 
                                picture: contactImgName[0], 
                                contact_name: contactImgName[1], 
                                contact_number: inputRecipient 
                            } );
            recipients.push(inputRecipient);

        });
        
        if($this.is(":checked")) {
            $this.prop("checked",false);
        }

        recipientsLength = recipients.length;

        setEnable_Disable_MsgBody(textCount, recipientsLength);

        $("#recipient-count").html(recipients.length);
        $("#recipient-list").html("");
        $("#modal-recipient-list").modal("hide");

    });
    
    $('#add-contact').on('click', function(event) {

        var $this = $("#list1 a").find("[type=checkbox]");
        var textCount = $("#msg").val().length;
        var isInContact = true;
        var n = 0;
        var recipientsLength = 0;
        
        $('#contact-list a input:checked').each(function() {

            var inputContactName = $(this).attr('name');
            var contactImgName = inputContactName.split("*");
            var inputRecipient = $(this).attr('value');
            recipientsLength = recipients.length;

            inputRecipient = inputRecipient.replace(/-/g , "");
            inputRecipient = inputRecipient.replace(/ /g , "");
            n = inputRecipient.length;
            
            setEnable_Disable_MsgBody(textCount, recipientsLength);
            proccessNumber(isInContact, n, inputRecipient, contactImgName[1], contactImgName[0]);

        });
        
        if($this.is(":checked")) {
            $this.prop("checked",false);
        }

        $("#modal-contact-list").modal("hide");

    });

    $("#send-msg").click(function(){

        var msg = $("#msg").val();

        $(".overlay").fadeIn(500);
        $(this).html("Sending...");

        $.post('send', {
            
            _token: $('meta[name=csrf-token]').attr('content'),
            msg: msg,
            phone_number: recipients

        }).done(function(response) {

            $("#send-msg").attr("disabled", "disabled");
            $("#character-count").html("0/160");
            $("#send-msg").html("Send");
            $("#msg").val("");
            
            $(".overlay").fadeOut(500, function(){
                $("#success-count").html(response);
                $("#modal-success").modal();
            });

            recipients = [];
            _recipients = [];

            $("#recipient-count").html(recipients.length);
                          
        }).fail(function(xhr, status, error) {

            //$("#send-msg").attr("disabled", "disabled");
            //$("#character-count").html("0");
            $("#send-msg").html("Send");
            //$("#msg").val("");
            
            $(".overlay").fadeOut(500, function(){
                $("#modal-failed").modal();
            });

        });
    });

});