$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){
	var userID = $("#user-id").text();
	
	initializeSubscribe_Button();

	function initializeSubscribe_Button() { 
		$.post('check-subscribed', {
			_token: $('meta[name=csrf-token]').attr('content'),
			user_id: userID
		}).done(function(data) {
			if (data == "0") {
				$("#btn-subscribe").removeClass("hidden");
			} else if (data == "1") {
				$("#btn-unsubscribe").removeClass("hidden");
			}
		}).fail(function(xhr, status, error) {
			initializeSubscribe_Button();
		});
	}

	$("#phonebook-display").html("<div>" +
								 	"<div id='loading-div'>" +
								 		"<h4 style='color: #FFFFFF;''><center>Loading Registered Contacts...</center></h4>" +
								 		"<div class='progress'>" +
								 		  	"<div id='log-progress' class='progress-bar progress-bar-striped active' role='progressbar'" +
								 		  		"aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style='width: 100%'>" +
								 		  	"</div>" +
								 		"</div>" +
								 	"</div>"+
								 "</div>");
	
	initializeRecipients();

	function initializeRecipients() {
		$.post('get-recipients', {
		    _token: $('meta[name=csrf-token]').attr('content'),
		    display_Type: "1"
		}).done(function(data) {
			$("#phonebook-display").fadeOut(200, function(){
				$(this).html("<div id='notification-table' style='border-color: #363940;'>" +
					      	 "</div>").fadeIn(200, function(){

					generateTable(data);

				});
			});
		}).fail(function(xhr, status, error) {
			initializeRecipients();
		});
	}

	function generateTable(data){
		var tableData = JSON.parse(data);
		var showDate = moment();

		fileTitle = "Registered Contacts";

		tableColumns = [ { field: "firstname", title: "First Name" },
		     			 { field: "lastname", title: "Last Name" },
		     			 { field: "province", title: "Province" },
		     			 { field: "contact_number", title: "Phone Number" } ];

		tableFileTitle = "Table-" + fileTitle;
		tableFileTitle = tableFileTitle.toUpperCase();
		excelFilename = tableFileTitle + ".xlsx";

		$("#phonebook-display").kendoGrid({
			toolbar: ["excel"],
			excel: {
				title: fileTitle,
		    	author: "DRRMIS",
		    	creator: "DRRMIS",
		    	date: showDate.format('YYYY/MM/DD'),
		        fileName: excelFilename,
		        filterable: true,
		        allPages: true
		    },
		    dataSource: {
		        data: tableData,
		        pageSize: 20
		    },
		    filterable: {
		        extra: false,
		        operators: {
		            string: {
		                contains: "Contains"
		            }
		        }
		    },
		    selectable: "multiple cell",
		    allowCopy: true,
		    height: 600,
		    sortable: true,
		    columnMenu: true,
		    groupable: true,
		    resizable: true,
		    reorderable: true,
		    pageable: {
		        refresh: true,
		        pageSize: 100,
		        pageSizes: [25, 50, 100, 1000, "all"],
				numeric: false,
		        buttonCount: 5
		    },
		    columns: tableColumns
		});

	}

	$("#btn-subscribe").click(function() {
		/*
		window.open("subscribe", '_blank');
		*/
		window.open("success-subscribe", '_blank');
	});

	$("#btn-unsubscribe").click(function() {
		$("#modal-confirm").modal({backdrop: 'static', keyboard: false});
	});

	$("#confirm-unsubscribe").click(function() {
		$("#modal-confirm").modal("hide").on('hidden.bs.modal', function () {
			$.post('unsubscribed', {
			    _token: $('meta[name=csrf-token]').attr('content'),
			    user_id: userID
			}).done(function(data) {
				if (data == "1") {
					location.reload();
				}
			}).fail(function(xhr, status, error) {
				console.log("Error!")
			});

		});

	});

});