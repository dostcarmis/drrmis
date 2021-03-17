const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(function(){
    var searchInput;
	var recipients = [];
    var _recipients = [];
    var segmentCount = 0;
    var textSegmentCount = 0;
    let recipientsData = {};

    $("#recipient-count").html(recipients.length);
    $(".overlay").fadeOut(500);

    initializeContacts();

    function initializeContacts() {
        $('#recipients').select2({
            tokenSeparators: [','],
            tags: true,
            placeholder: "Enter or select recipient/s here...",
            width: '100%',
            allowClear: true,
            dropdownCssClass: "recipient-dropdown",
            ajax: {
                url: `${baseURL}/warn/get-recipients`,
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            let jsonData = {};
                            jsonData['contact_name'] = item.contact_name;
                            jsonData['contact_number'] = item.contact_number;
                            recipientsData[item.id] = jsonData;

                            return {
                                text: `${item.contact_name} - ${item.contact_number}`,
                                id: item.contact_number
                            }
                        }),
                        pagination: {
                            more: true
                        }
                    };
                },
                cache: true
            },
            //theme: "material"
        }).on('select2:select', function (e) {
            const _contactNumber = e.params.data.id,
                  numberLength = _contactNumber.length,
                  contactNumber = proccessNumber(_contactNumber, numberLength);
            if (contactNumber) {
                recipients.push(contactNumber);
            }

            $(this).val(recipients);
            console.log(contactNumber);
        }).on('change', function (e) {
            /*
            const contactNumbers = $(this).val();
            recipients = contactNumbers;*/

            console.log(recipients);
        });
    }

    function setEnable_Disable_MsgBody(textCount, recipientsLength){
        if (textCount > 0 && recipientsLength > 0){
            $("#send-msg").removeAttr("disabled");
        } else {
            $("#send-msg").attr("disabled", "disabled");
        }
    }

    function proccessNumber(contactNumber, numberLength){
        var isValidNumber = false;
        var firstChar = "";

        firstChar = contactNumber.charAt(0);

        if (numberLength === 13 || numberLength === 11){
            if (!contactNumber.match(/[a-z]/i)) {
                isValidNumber = true;
            }

            if (isValidNumber) {
                if (contactNumber.substring(0, 2) != "09" && numberLength === 11){
                    isValidNumber = false;
                }else if (contactNumber.substring(0, 4) != "+639" && numberLength === 13){
                    isValidNumber = false;
                }
            }

            if (isValidNumber) {
                if (firstChar == "0" && numberLength === 11){
                    contactNumber = contactNumber.slice(1, numberLength);
                    contactNumber = "+63" + contactNumber;

                    return contactNumber;
                }
            }
        }

        return false;
    }

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

    

    $("#send-msg").click(function(){
        const msg = $("#msg").val();

        $(".overlay").fadeIn(500);
        $(this).html("Sending...");

        $.post('send', {
            _token: CSRF_TOKEN,
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