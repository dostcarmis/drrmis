$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){

	var userID = $("#user-id").text();

	$("#notification-display").html("<div>" +
								 	"<div id='loading-div'>" +
								 		"<h4 style='color: #FFFFFF;''><center>Loading Notifications...</center></h4>" +
								 		"<div class='progress'>" +
								 		  	"<div id='log-progress' class='progress-bar progress-bar-striped active' role='progressbar'" +
								 		  		"aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style='width: 100%'>" +
								 		  	"</div>" +
								 		"</div>" +
								 	"</div>"+
								 "</div>");

	$.post('get-notification', {
        
	    _token: $('meta[name=csrf-token]').attr('content'),
	    user_id: userID

	}).done(function(data) {
		$("#notification-display").fadeOut(200, function(){
			$(this).html("<div id='notification-table' style='border-color: #363940;'>" +
				      	 "</div>").fadeIn(200, function(){

				generateTable(data);

			});
		});

	}).fail(function(xhr, status, error) {

		console.log("Error");

	});

	function generateTable(data, fileTitle, tableColumns, tableFileTitle){

		var tableData = JSON.parse(data);
		var showDate = moment();

		fileTitle = "Notifications";

		tableColumns = [ { field: "date_time", title: "Date and Time", width: 300 },
		     			 { field: "message", title: "Message" } ];

		tableFileTitle = "Table-" + fileTitle;
		tableFileTitle = tableFileTitle.toUpperCase();

		excelFilename = tableFileTitle + ".xlsx";

		$("#notification-table").kendoGrid({

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

});