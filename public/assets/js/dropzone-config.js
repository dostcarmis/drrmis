(function() {
    Dropzone.options.bookImage = {
        paramName           :       "image", // The name that will be used to transfer the file
        maxFilesize         :       2, // MB
        dictDefaultMessage  :       "Drop File here or Click to upload Image",
        thumbnailWidth      :       "150",
        thumbnailHeight     :       "150",
        accept              :       function(file, done) { done() },
        success             :       uploadSuccess,
        complete            :       uploadCompleted,

    };

    function uploadSuccess(data, file) {
        var messageContainer    =   $('.mymessages'),
            message             =   $('<p></p>', {
                'text' : 'Image Uploaded Successfully! Image Path is: '
            }),
            imagePath           =   $('<a></a>', {
                'href'  :   JSON.parse(file).original_path,
                'text'  :   JSON.parse(file).original_path,
                'target':   '_blank'
            })
        imagePath.appendTo(message);
        message.appendTo(messageContainer);

    }

    function uploadCompleted(data) {
        if(data.status != "success")
        {
            var error_message   =   $('.mymessages'),
                message         =   $('<p></p>', {
                    'text' : 'Image Upload Failed'
                });

            message.appendTo(error_message);
            return;
        }
    }
})();