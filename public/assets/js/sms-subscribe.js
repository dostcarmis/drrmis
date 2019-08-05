$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){

	var userID = $("#user-id").text();
	var url = window.location.href;

	addSubscriber();

	function addSubscriber() {
		$.post('add-subscriber', {
        
		    _token: $('meta[name=csrf-token]').attr('content'),
		    user_id: userID,
		    user_url: url

		}).done(function(data) {
			
			if (data == "1") {
                $("#modal-success").modal().on('hidden.bs.modal', function () {
                	window.open("registered-contacts", '_blank');
				    window.top.close();
				});
			} else if (data == "0") {
                $("#modal-failed").modal().on('hidden.bs.modal', function () {
                	window.open("registered-contacts", '_blank');
				    window.top.close();
				});
			}

		}).fail(function(xhr, status, error) {

			$("#modal-failed2").modal().on('hidden.bs.modal', function () {
				window.open("registered-contacts", '_blank');
				window.top.close();
			});

		});
	}

});