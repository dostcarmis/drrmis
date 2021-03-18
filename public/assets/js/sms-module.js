const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

/* ============ Message Composer Module ============
*/

$(function(){
    let recipientsData = {},
	    recipients = [],
        segmentCount = 0,
        textSegmentCount = 0;

    $("#recipient-count").html(recipients.length);
    $(".overlay").fadeOut(500);

    initializeContacts();

    function initializeContacts() {
        $('#recipients').select2({
            tokenSeparators: [',', ' '],
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
                            const recipientName = `${item.firstname} ${item.lastname}`;
                            jsonData['contact_name'] = recipientName;
                            jsonData['phone_number'] = item.phone_number;
                            recipientsData[item.id] = jsonData;

                            return {
                                text: `${recipientName} - ${item.phone_number}`,
                                id: item.phone_number
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

            $(this).val(null).trigger('change');
            $.each(recipients, function (i, recipient) {
                let option = new Option(recipient, recipient, true, true);
                $('#recipients').append(option).trigger('change');
            });
        }).on('select2:unselect', function (e) {
            const _contactNumber = e.params.data.id;
            recipients = $.grep(recipients, function(recipient) {
                return recipient != _contactNumber;
            });
        }).on('select2:clear', function(e) {
            recipients = [];
        });
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
                } else if (contactNumber.substring(0, 4) != "+639" && numberLength === 13){
                    isValidNumber = false;
                }
            }

            if (isValidNumber) {
                let hasDuplicate = false;

                if (firstChar == "0" && numberLength === 11){
                    contactNumber = contactNumber.slice(1, numberLength);
                    contactNumber = "+63" + contactNumber;
                }

                for (var i = 0; i < recipients.length; i++) {
                    if (recipients[i] == contactNumber) {
                        hasDuplicate = true;
                        break;
                    }
                }

                if (!hasDuplicate) {
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

        $.post(`${baseURL}/warn/send`, {
            _token: CSRF_TOKEN,
            msg: msg,
            send_type: 'compose',
            contact_numbers: recipients
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

            $("#recipient-count").html(recipients.length);
            $('#recipients').val(null).trigger('change');
        }).fail(function(xhr, status, error) {
            $("#send-msg").html("Send");
            $(".overlay").fadeOut(500, function(){
                $("#modal-failed").modal();
            });

        });
    });
});

$(function($) {
    const startUpload = function(uploadFormData) {
        const formData = new FormData(uploadFormData);

        $.ajax({
            url: `${baseURL}/warn/send`,
            type: 'POST',              
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                //location.reload();
            },
            error: function(data) {
                //console.log(data);
            },
        });
    }

    $('#form-upload-csv').on('submit', function(e) {
        e.preventDefault();

        const uploadFormData = $('#form-upload-csv')[0];

        startUpload(uploadFormData);

        /*
        $('#form-upload-csv').validate({
            rules: {
                csv_file: {
                    required: true,
                    accept: ".csv"
                }
            }, messages: {
                csv_file: {
                    required: "Please select a valid CSV file.",
                    accept: "Please select a valid CSV file."
                }
            }, submitHandler: function(form) {
                startUpload(form);
            }
        });*/

        
    });
});