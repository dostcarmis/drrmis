$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){

	var showDate = moment();
    var tableFileTitle = "";

    $("#toggle-hydromet-data").click(function(){
    	$("#landslide-data").fadeOut(300, function(){
			$("#flood-data").fadeOut(300, function(){
				$("#road-data").fadeOut(300, function(){
					$("#hydromet-data").fadeIn(300, function(){
						$("#hydromet-data").show();
						$("#text-hydromet").html("Selected");
						$("#text-landslide").html("View");
						$("#text-flood").html("View");
						$("#text-road").html("View");
						$("#b-color").css("background", "#d9534f");

					});

				});

			});

		});

    });

    $("#toggle-landslide-data").click(function(){

    	$("#landslide-display").html("<div>" +
									 	"<div id='loading-div'>" +
									 		"<h4 style='color: #FFFFFF;''><center>Generating Data...</center></h4>" +
									 		"<div class='progress'>" +
									 		  	"<div id='log-progress' class='progress-bar progress-bar-striped active' role='progressbar'" +
									 		  		"aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style='width: 100%'>" +
									 		  	"</div>" +
									 		"</div>" +
									 	"</div>"+
									 "</div>");

    	$("#hydromet-data").fadeOut(300, function(){
			$("#flood-data").fadeOut(300, function(){
				$("#road-data").fadeOut(300, function(){
					$("#landslide-data").fadeIn(300, function(){
						$("#landslide-data").show();
						$("#text-hydromet").html("View");
						$("#text-landslide").html("Selected");
						$("#text-flood").html("View");
						$("#text-road").html("View");
						$("#landslide-display").collapse("show");
						$("#b-color").css("background", "#5cb85c");

						$.post('report/generate-data', {
        
						    _token: $('meta[name=csrf-token]').attr('content'),
						    display_Type: "",
						    generate_All_Sensors: "",
						    sensor_Type: "",
						    province_ID: "",
						    sensor_ID: "",
						    date_Start: "",
						    date_End: "",
						    time_Start: "",
						    time_End: "",
						    toggle_TimeRange: "",
						    toggle_Report_Type: "2",

						}).done(function(data) {

							var tableData = JSON.parse(data);

							$("#landslide-display").fadeOut(200, function(){

								$(this).html("<div id='landslide-table' style='border-color: #363940;'>" +
									      	 "</div>").fadeIn(200, function(){

						    		fileTitle = "Landslide";

						    		tableColumns = [ { field: "date_time", title: "Date & Time (YYYY-MM-DD HH-mm-ss)" },
						    						 { field: "province", title: "Province" },
						                			 { field: "location", title: "Location" },
						                			 { field: "description", title: "Description" } ];

						           	tableFileTitle = "Table-" + fileTitle;
							    	tableFileTitle = tableFileTitle.toUpperCase();

							    	excelFilename = tableFileTitle + ".xlsx";

									$("#landslide-table").kendoGrid({
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
							            filterable: {
				                            extra: false,
				                            operators: {
				                                string: {
				                                    contains: "Contains"
				                                }
				                            }
				                        },
								        dataSource: {
									        data: tableData,
									        pageSize: 20
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

								});

							});
									      
						}).fail(function(xhr, status, error) {
							$("#landslide-display").fadeOut(200, function(){
								$(this).html("<div id='landslide-table' style='overflow-y: auto;'>" +
												"<center>" +
							      	  				"<h3 style='color: #d9534f;'>There is an error occured in generating the data.</h3>" +
							      	  			"</center>" +
									      	 "</div>").fadeIn(200);

							});

						});  

					});

				});

			});

		});

    });

	$("#toggle-flood-data").click(function(){

		$("#flood-display").html("<div>" +
								 	 "<div id='loading-div'>" +
								 		 "<h4 style='color: #FFFFFF;''><center>Generating Data...</center></h4>" +
								 		 "<div class='progress'>" +
								 		   	 "<div id='log-progress' class='progress-bar progress-bar-striped active' role='progressbar'" +
								 		   		 "aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style='width: 100%'>" +
								 		   	 "</div>" +
								 		 "</div>" +
								 	 "</div>"+
								 "</div>");

		$("#hydromet-data").fadeOut(300, function(){

			$("#landslide-data").fadeOut(300, function(){

				$("#road-data").fadeOut(300, function(){

					$("#flood-data").fadeIn(300, function(){

						$("#text-hydromet").html("View");
						$("#text-landslide").html("View");
						$("#text-flood").html("Selected");
						$("#text-road").html("View");
						$("#flood-data").show();
						$("#flood-display").collapse("show");
						$("#b-color").css("background", "#337ab7");

						$("#flood-display").html("<div>" +
												    	"<div id='loading-div'>" +
												    		"<h4 style='color: #FFFFFF;''><center>Generating Data...</center></h4>" +
												    		"<div class='progress'>" +
												    		  	"<div id='log-progress' class='progress-bar progress-bar-striped active' role='progressbar'" +
												    		  		"aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style='width: 100%'>" +
												    		  	"</div>" +
												    		"</div>" +
												    	"</div>"+
												    "</div>");
						$("#flood-display").collapse("show");

						$.post('report/generate-data', {
        
						    _token: $('meta[name=csrf-token]').attr('content'),
						    display_Type: "",
						    generate_All_Sensors: "",
						    sensor_Type: "",
						    province_ID: "",
						    sensor_ID: "",
						    date_Start: "",
						    date_End: "",
						    time_Start: "",
						    time_End: "",
						    toggle_TimeRange: "",
						    toggle_Report_Type: "3",

						}).done(function(data) {

							var tableData = JSON.parse(data);

							$("#flood-display").fadeOut(200, function(){

								$(this).html("<div id='flood-table' style='border-color: #363940;'>" +
									      	 "</div>").fadeIn(200, function(){

									fileTitle = "Flood";

						    		tableColumns = [ { field: "date_time", title: "Date & Time (YYYY-MM-DD HH-mm-ss)" },
						    						 { field: "province", title: "Province" },
						                			 { field: "location", title: "Location" },
						                			 { field: "description", title: "Description" } ];

						           	tableFileTitle = "Table-" + fileTitle;
							    	tableFileTitle = tableFileTitle.toUpperCase();

							    	excelFilename = tableFileTitle + ".xlsx";

									$("#flood-table").kendoGrid({
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

								});

							});
									      
						}).fail(function(xhr, status, error) {

							$("#flood-display").fadeOut(200, function(){

								$(this).html("<div id='flood-table' style='overflow-y: auto;'>" +
												"<center>" +
							      	  				"<h3 style='color: #d9534f;'>There is an error occured in generating the data.</h3>" +
							      	  			"</center>" +
									      	 "</div>").fadeIn(200);

							});

						});

					});

				});

			});

		});

	});

	$("#toggle-road-data").click(function(){

		$("#road-display").html("<div>" +
									"<div id='loading-div'>" +
										"<h4 style='color: #FFFFFF;''><center>Generating Data...</center></h4>" +
										"<div class='progress'>" +
										  	"<div id='log-progress' class='progress-bar progress-bar-striped active' role='progressbar'" +
										  		"aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style='width: 100%'>" +
										  	"</div>" +
										"</div>" +
									"</div>"+
								"</div>");

		$("#hydromet-data").fadeOut(300, function(){

			$("#landslide-data").fadeOut(300, function(){

				$("#flood-data").fadeOut(300, function(){

					$("#road-data").fadeIn(300, function(){

						$("#road-data").show();
						$("#text-hydromet").html("View");
						$("#text-landslide").html("View");
						$("#text-flood").html("View");
						$("#text-road").html("Selected");
						$("#road-display").collapse("show");
						$("#b-color").css("background", "#f0ad4e");

						$.post('report/generate-data', {
        
						    _token: $('meta[name=csrf-token]').attr('content'),
						    display_Type: "",
						    generate_All_Sensors: "",
						    sensor_Type: "",
						    province_ID: "",
						    sensor_ID: "",
						    date_Start: "",
						    date_End: "",
						    time_Start: "",
						    time_End: "",
						    toggle_TimeRange: "",
						    toggle_Report_Type: "4",

						}).done(function(data) {

							var tableData = JSON.parse(data);

							$("#road-display").fadeOut(200, function(){

								$(this).html("<div id='road-table' style='border-color: #363940;'>" +
									      	 "</div>").fadeIn(200, function(){

									fileTitle = "Road Network";

						    		tableColumns = [ { field: "date_time", title: "Date & Time (YYYY-MM-DD HH-mm-ss)" },
						                			 { field: "location", title: "Location" },
						                			 { field: "status", title: "Status" },
						                			 { field: "description", title: "Description" } ];

						           	tableFileTitle = "Table-" + fileTitle;
							    	tableFileTitle = tableFileTitle.toUpperCase();

							    	excelFilename = tableFileTitle + ".xlsx";

									$("#road-table").kendoGrid({
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

								});

							});
									      
						}).fail(function(xhr, status, error) {

							$("#road-display").fadeOut(200, function(){

								$(this).html("<div id='road-table' style='overflow-y: auto;'>" +
												"<center>" +
							      	  				"<h3 style='color: #d9534f;'>There is an error occured in generating the data.</h3>" +
							      	  			"</center>" +
									      	 "</div>").fadeIn(200);

							});

						});

					});

				});

			});

		});

	});

});

// HYDROMET DATA GENERATION

$(function(){

	var btnDisplayInfoShow;
	var showDate = moment();
	var displayType = "1";
	var sensorType = "0";
	var provinceID = "1";
	var sensorID = "";
	var dateStart;
	var dateEnd;
	var timeStart = "";
	var timeEnd = "";
	var toggle_Ranged_Date = false;
	var toggle_Ranged_Time = false;
	var labelDateTime = "Date Range";
	var categoryID = "";
	var generateAllSensors = "false";

	//$("#tour-report-modal").modal();

	$("#display-type").removeAttr("disabled");
	$("#sensor-type").removeAttr("disabled");
	$("#province-id").removeAttr("disabled");
	$("#address-id").removeAttr("disabled");
	$("#generate-all-sensors").removeAttr("disabled");
	//$("#report-type").removeAttr("disabled");

	$("#generate-all-sensors").change(function(){

		$("#defective-date").fadeOut(300);

		if(this.checked){

			sensorID = "";
			generateAllSensors = "true";
			dateTimeSettingsDaily();

			$("#sensor-location-display").html("Null");
			$(this).attr('disabled', true);
			$("#display-type").attr('disabled', true);
			$("#other-information").collapse("hide").on("hidden.bs.collapse", function(){

	            $("#generate-all-sensors").removeAttr("disabled");
	            
	            /*$("#display-type").html("<option value='3' selected> Daily </option>" +
	            						"<option value='4'> Monthly </option>" +
	            						"<option value='5'> Yearly </option>");*/

	        });

	        $("#display-type").removeAttr("disabled").html("<option value='3' selected> Daily </option>" +
	            						"<option value='4'> Monthly </option>" +
	            						"<option value='5'> Yearly </option>");

		}else {

			sensorID = "";
			generateAllSensors = "false";
			dateTimeSettingsDefault_Hourly();

			$("#sensor-location-display").html("Null");
			$(this).attr('disabled', true);
			$("#display-type").attr('disabled', true);
			$("#other-information").collapse("show").on("shown.bs.collapse", function(){

	            $("#generate-all-sensors").removeAttr("disabled");
	            
	        });

	        $("#display-type").removeAttr("disabled").html("<option value='1' selected> Default </option>" +
	            						"<option value='2'> Hourly </option>" +
	            						"<option value='3'> Daily </option>" +
	            						"<option value='4'> Monthly </option>" +
	            						"<option value='5'> Yearly </option>" +
	            						"<option value='6'> Other (Accumulated Rainfall and/or Lowest & Highest Waterlevel for a Period of Time) </option>");

		}

	});

	function dateTimeSettingsDefault_Hourly(){

		var currentDate = moment();
	    dateStart = currentDate.format('YYYY/MM/DD');
	    dateEnd = currentDate.add(1, 'days').format('YYYY/MM/DD');
	    timeStart = "";
		timeEnd = "";
	    
	    $("#display-date").html(dateStart);
		
		$("#calendar-input").html("<div id='range-toggle' class='form-check'>" +
		                              "<label class='form-check-label'>" +
		                                  "<input id='date-range-toggle' class='form-check-input' type='checkbox' value=''>" +
		                                  " Set Range" +
		                              "</label> " +
		                              "<span class='glyphicon glyphicon-th'></span>" +
		                          "</div>" +
		                          "<div class='collapse' id='date-range'>" +
		                              "<div class='card card-block'>" +
		                                  "<div class='well' style='color: #000000;'>" +
			                                  "<div>" +
		                                          "<label id='lbl-date-time'>Date Range</label> " +
		                                          "<span class='glyphicon glyphicon-calendar'></span>" +
		                                      "</div>" +
								              "<input type='text' id='date-range-input' class='form-control'>" +
		                                      "<br>" +
		                                 	"</div>" +
		                              "</div>" +
		                          "</div>");

		$("#range-toggle").collapse("show").on("shown.bs.collapse");

		$("#date-range-toggle").change(function(){

	        if(this.checked) {
	            
	            currentDate = moment();
	            toggle_Ranged_Date = "true";
	            dateStart = "";
	            dateEnd = "";
	            timeStart = "";
				timeEnd = "";

	            $("#display-date").html("[ YYYY/mm/dd ] to [ YYYY/mm/dd ]");
	            $(this).attr('disabled', true);

	            $("#date-range").collapse("show").on("shown.bs.collapse", function(){

	                $("#date-range-toggle").removeAttr("disabled");

	            });

	            $('#date-range-input').daterangepicker({
	            	"autoApply": false,
				    "alwaysShowCalendars": true,
				    "minDate": "1/1/2011",
				    "maxDate": currentDate.format('MM/DD/YYYY').toString(),
				    "drops": "up"
				}, function(start, end, label) {
					dateStart = start.format('YYYY/MM/DD');
					dateEnd = end.add(1, "days").format('YYYY/MM/DD');
				  	$("#display-date").html(dateStart +  " to " + end.add(-1, "days").format('YYYY/MM/DD'));
			      					
			      });
				
	        }else{

	        	currentDate = moment();
	        	toggle_Ranged_Time = "false";
	            dateStart = currentDate.format('YYYY/MM/DD');
	            dateEnd = currentDate.add(1, 'days').format("YYYY/MM/DD");
	            timeStart = "";
				timeEnd = "";
	            
	            $("#display-date").html(dateStart);
	            $(this).attr('disabled', true);
	            $("#date-range").collapse("hide").on("hidden.bs.collapse", function(){

	                $("#date-range-toggle").removeAttr("disabled");

	            });

	        }

	    });

	}

	function dateTimeSettingsDaily(){

		var currentDate = moment();
		toggle_Ranged_Date = true;
		toggle_Ranged_Time = "false";
	    dateStart = "";
	    dateEnd = "";
	    timeStart = "";
		timeEnd = "";

		if (generateAllSensors == "false"){

			$("#calendar-input").html("<div id='date-range'>" +
			                              "<div class='card card-block'>" +
			                                  "<div class='well' style='color: #000000;'>" +
				                                  "<div>" +
			                                          "<label id='lbl-date-time'>Date Range</label> " +
			                                          "<span class='glyphicon glyphicon-calendar'></span>" +
			                                      "</div>" +
									              "<input type='text' id='date-range-input' class='form-control'>" +
			                                      "<br>" +
			                                  "</div>" +
			                              "</div>" +
			                          "</div>");

		    $(this).attr('disabled', true);

		    $("#date-range").collapse("show").on("shown.bs.collapse", function(){

		        $("#date-range-toggle").removeAttr("disabled");

		    });

		    $("#display-date").html("[ YYYY/mm/dd ] to [ YYYY/mm/dd ]");

		    $('#date-range-input').daterangepicker({
				"autoApply": false,
			    "alwaysShowCalendars": true,
			    "minDate": "1/1/2011",
			    "maxDate": currentDate.format('MM/DD/YYYY').toString(),
			    "drops": "up"
			}, function(start, end, label) {
			  	dateStart = start.format('YYYY/MM/DD');
				dateEnd = end.add(1, "days").format('YYYY/MM/DD');
				$("#display-date").html(dateStart +  " to " + end.add(-1, "days").format('YYYY/MM/DD'));
			  	
			});

		}else if (generateAllSensors == "true"){

			$("#calendar-input").html("<div id='date-range'>" +
			                              "<div class='card card-block'>" +
			                                  "<div class='well' style='color: #000000;'>" +
									              "<div id='sandbox-container'>" +
			                                      "    <div class='input-daterange date'>" +
			                                      "        <div>" +
			                                      "            <label>Select Month</label>" +
			                                      "            <span class='glyphicon glyphicon-calendar'></span>" +
			                                      "            <input id='date-val-start' type='text' class='input-md form-control' name='start' placeholder='Select Month' readonly>" +
			                                      "        </div>" +
			                                      "    </div>" +
			                                      "</div>" +
			                                      "<br>" +
			                                  "</div>" +
			                              "</div>" +
			                          "</div>");

			$("#date-range").collapse("show").on("shown.bs.collapse");

		    $("#display-date").html("[ YYYY/mm ]");

		    $('#sandbox-container .input-daterange').datepicker({
	            
	            format: "yyyy/mm",
	            viewMode: 'months',
	            minViewMode: "months",
	            autoclose: true,
	            todayHighlight: true,
	            startDate: new Date(2010, 12),
	            endDate: "0d",

	        }).on("hide",function (e) {
	            
	            dateStart = $('#date-val-start').val();
	            dateEnd = dateStart;
	            $("#display-date").html(dateStart);

	        });

		}

	}

	function dateTimeSettingsMonthly_Yearly(_displayType){

		var currentDate = moment();
		toggle_Ranged_Date = true;
		toggle_Ranged_Time = "false";
	    dateStart = "";
	    dateEnd = "";
	    timeStart = "";
		timeEnd = "";

	    if (_displayType == "4"){

	    	var currentYear = (new Date).getFullYear();

            if (generateAllSensors == "false"){

            	$("#calendar-input").html("<div id='date-range'>" +
				                              "<div class='card card-block'>" +
				                                  "<div class='well' style='color: #000000;'>" +
										              "<div id='sandbox-container'>" +
			                                          "    <div class='input-daterange input-group date'>" +
			                                          "        <div>" +
			                                          "            <label>Month Start</label>" +
			                                          "            <span class='glyphicon glyphicon-calendar'></span>" +
			                                          "            <input id='date-val-start' type='text' class='input-md form-control' name='start' placeholder='Month Start' readonly>" +
			                                          "        </div>" +
			                                          "        <br>" +
			                                          "        <br>" +
			                                          "        <div>" +
			                                          "            <label>Month End</label>" +
			                                          "            <span class='glyphicon glyphicon-calendar'></span>" +
			                                          "            <input id='date-val-end' type='text' class='input-md form-control' name='end' placeholder='Month End' readonly>" +
			                                          "        </div>" +
			                                          "    </div>" +
			                                          "</div>" +
				                                      "<br>" +
				                                  "</div>" +
				                              "</div>" +
				                          "</div>");

			    $("#date-range").collapse("show").on("shown.bs.collapse");

		    	$("#display-date").html("[ YYYY/mm ] to [ YYYY/mm ]");

		    	$('#sandbox-container .input-daterange').datepicker({
	                
	                format: "yyyy/mm",
	                viewMode: 'months',
	                minViewMode: "months",
	                autoclose: true,
	                todayHighlight: true,
	                startDate: new Date(2010, 12),
	                endDate: "0d",

	            }).on("hide",function (e) {
	                
	                dateStart = $('#date-val-start').val();
	                dateEnd = $('#date-val-end').val();
	                $("#display-date").html(dateStart +  " to " + dateEnd);

	            });

            }else if (generateAllSensors == "true"){

            	$("#calendar-input").html("<div id='date-range'>" +
				                              "<div class='card card-block'>" +
				                                  "<div class='well' style='color: #000000;'>" +
										              "<div id='sandbox-container'>" +
				                                      "    <div class='input-daterange input-group date'>" +
				                                      "        <div>" +
				                                      "            <label>Select Year</label>" +
				                                      "            <span class='glyphicon glyphicon-calendar'></span>" +
				                                      "            <input id='date-val-start' type='text' class='input-md form-control' name='start' placeholder='Select Year' readonly>" +
				                                      "        </div>" +
				                                      "    </div>" +
				                                      "</div>" +
				                                      "<br>" +
				                                  "</div>" +
				                              "</div>" +
				                          "</div>");

				$("#date-range").collapse("show").on("shown.bs.collapse");

			    $("#display-date").html("[ YYYY ]");

			    $('#sandbox-container .input-daterange').datepicker({
		            
		            format: "yyyy",
		            startView: 2,
		            minViewMode: 2,
		            maxViewMode: 2,
		            autoclose: true,
		            todayHighlight: true,
		            startDate: "2011",
		            endDate: currentYear.toString(),

		        }).on("hide",function (e) {
		            
		            dateStart = $('#date-val-start').val();
		            dateEnd = dateStart;
		           	$("#display-date").html(dateStart);

		        });

            }

	    }else if (_displayType == "5"){

	    	var currentYear = (new Date).getFullYear();

	    	$("#calendar-input").html("<div id='date-range'>" +
			                              "<div class='card card-block'>" +
			                                  "<div class='well' style='color: #000000;'>" +
									              "<div id='sandbox-container'>" +
			                                      "    <div class='input-daterange input-group date'>" +
			                                      "        <div>" +
			                                      "            <label>Year Start</label>" +
			                                      "            <span class='glyphicon glyphicon-calendar'></span>" +
			                                      "            <input id='date-val-start' type='text' class='input-md form-control' name='start' placeholder='Year Start' readonly>" +
			                                      "        </div>" +
			                                      "        <br>" +
			                                      "        <br>" +
			                                      "        <div>" +
			                                      "            <label>Year End</label>" +
			                                      "            <span class='glyphicon glyphicon-calendar'></span>" +
			                                      "            <input id='date-val-end' type='text' class='input-md form-control' name='end' placeholder='Year End' readonly>" +
			                                      "        </div>" +
			                                      "    </div>" +
			                                      "</div>" +
			                                      "<br>" +
			                                  "</div>" +
			                              "</div>" +
			                          "</div>");

			$("#date-range").collapse("show").on("shown.bs.collapse");

		    $("#display-date").html("[ YYYY ] to [ YYYY ]");

		    $('#sandbox-container .input-daterange').datepicker({
	            
	            format: "yyyy",
	            startView: 2,
	            minViewMode: 2,
	            maxViewMode: 2,
	            autoclose: true,
	            todayHighlight: true,
	            startDate: "2011",
	            endDate: currentYear.toString(),

	        }).on("hide",function (e) {
	            
	            dateStart = $('#date-val-start').val();
	            dateEnd = $('#date-val-end').val();
	           	$("#display-date").html(dateStart +  " to " + dateEnd);

	        });

	    }

	}

	function dateTimeSettingsOthers(){

		toggle_Ranged_Date = true;
		toggle_Ranged_Time = "false";
	    dateStart = "";
	    dateEnd = "";
	    timeStart = "";
		timeEnd = "";

		//
		$("#calendar-input").html("<div id='date-range'>" +
		                              "<div class='card card-block'>" +
		                                  "<div class='well' style='color: #000000;'>" +
			                                  "<div>" +
		                                          "<label id='lbl-date-time'>Date Range</label> " +
		                                          "<span class='glyphicon glyphicon-calendar'></span>" +
		                                      "</div>" +
								              "<input type='text' id='date-range-input' class='form-control'>" +
		                                   	"<br>" +
		                                  "</div>" +
		                              "</div>" +
		                          "</div>");

	    $(this).attr('disabled', true);

	    $("#date-range").collapse("show").on("shown.bs.collapse", function(){

	        $("#date-range-toggle").removeAttr("disabled");

	    });

	    $("#display-date").html("[ YYYY/mm/dd ] to [ YYYY/mm/dd ]");

	    $('#date-range-input').daterangepicker({
			"autoApply": false,
		    "alwaysShowCalendars": true,
		    "minDate": "1/1/2011",
		    "maxDate": showDate.format('MM/DD/YYYY').toString(),
		    "drops": "up"
		}, function(start, end, label) {
		  	dateStart = start.format('YYYY/MM/DD');
			dateEnd = end.add(1, "days").format('YYYY/MM/DD');
			$("#display-date").html(dateStart +  " to " + end.add(-1, "days").format('YYYY/MM/DD'));
		 
		});

	}


	function getLocationList(){

		$.post('report/display-sensor-location', {
            
		    _token: $('meta[name=csrf-token]').attr('content'),
		    display_Type: displayType,
		    sensor_Type: sensorType,
		    province_ID: provinceID,

		}).done(function(data) {

			$("#address-id").html(data);

		}).fail(function(xhr, status, error) {

			getLocationList();

		});  

	}

	//======================================================================================================

	dateTimeSettingsDefault_Hourly();
	getLocationList();

	$("#display-date").html(showDate.format("YYYY/MM/DD"));

	$("#display-type").change(function(){

		displayType = $("#display-type option:selected").val();

		$("#defective-date").fadeOut(300);

		if (displayType == "1"){

			$("#sensor-type").html("<option value='0' selected>ALL</option>" +
								   "<option value='1'>Automated Rain Gauge (ARG)</option>" +
								   "<option value='2'>Waterlevel Monitoring Sensor (WLMS)</option>" +
								   "<option value='3'>Automated Rain and Stream Gauge (TDM)</option>" +
								   "<option value='4'>Automated Weather Station (AWS)</option>");

			dateTimeSettingsDefault_Hourly();

		}else if (displayType == "2"){

			$("#sensor-type").html("<option value='0' selected>ALL</option>" +
								   "<option value='1'>Automated Rain Gauge (ARG)</option>" +
								   "<option value='2'>Waterlevel Monitoring Sensor (WLMS)</option>" +
								   "<option value='3'>Automated Rain and Stream Gauge (TDM)</option>");

			dateTimeSettingsDefault_Hourly();
			

		}else if (displayType == "3"){

			$("#sensor-type").html("<option value='0' selected>ALL</option>" +
								   "<option value='1'>Automated Rain Gauge (ARG)</option>" +
								   "<option value='2'>Waterlevel Monitoring Sensor (WLMS)</option>" +
								   "<option value='3'>Automated Rain and Stream Gauge (TDM)</option>");

			dateTimeSettingsDaily();

		}else if (displayType == "4"){

			$("#sensor-type").html("<option value='0' selected>ALL</option>" +
								   "<option value='1'>Automated Rain Gauge (ARG)</option>" +
								   "<option value='2'>Waterlevel Monitoring Sensor (WLMS)</option>" +
								   "<option value='3'>Automated Rain and Stream Gauge (TDM)</option>");

			dateTimeSettingsMonthly_Yearly(displayType);

		}else if (displayType == "5"){

			$("#sensor-type").html("<option value='0' selected>ALL</option>" +
								   "<option value='1'>Automated Rain Gauge (ARG)</option>" +
								   "<option value='2'>Waterlevel Monitoring Sensor (WLMS)</option>" +
								   "<option value='3'>Automated Rain and Stream Gauge (TDM)</option>");

			dateTimeSettingsMonthly_Yearly(displayType);

		}else if (displayType == "6"){

			$("#sensor-type").html("<option value='0' selected>ALL</option>" +
								   "<option value='1'>Automated Rain Gauge (ARG)</option>" +
								   "<option value='2'>Waterlevel Monitoring Sensor (WLMS)</option>" +
								   "<option value='3'>Automated Rain and Stream Gauge (TDM)</option>");

			dateTimeSettingsOthers();

		}

		//getLocationList();

	});

	$("#sensor-type").unbind("change").change(function(){

		sensorType = $("#sensor-type option:selected").val();
		provinceID = $("#province-id option:selected").val();

		getLocationList();

	});

	$("#province-id").unbind("change").change(function(){

		sensorType = $("#sensor-type option:selected").val();
		provinceID = $("#province-id option:selected").val();
		sensorID = "0";

		getLocationList();
		
	});

    $("#address-id").unbind("change").change(function() {
		
		var jsonThresholdData;
		var floodThreshold = "";
		var landslideThreshold = "";
		var tempLocation = $("#address-id option:selected").text();

		sensorID = $("#address-id option:selected").val();

		$.post('report/generate-threshold', {
            
		    _token: $('meta[name=csrf-token]').attr('content'),
		    sensor_ID: sensorID

		}).done(function(data) {

			//floodThreshold = data[0];
			landslideThreshold = data[1];
			categoryID = data[2];

			$("#landslide-threshold-display").html(landslideThreshold);
			//$("#flood-threshold-display").html(floodThreshold);

		});

		$("#sensor-location-display").html(tempLocation);

	}).click(function(){

		$("#collapse-location").collapse("hide");

	});

    $("#display-info-hide").click(function(){

    	$("#display-info-hide").fadeOut(1);
    	$("#frmmain").fadeOut(500);
    	$("#display-info").fadeOut(500, function(){

    		$("#frmmain").attr("class", "form-group col-xs-12 col-md-12 col-lg-12");
    		$("#frmmain").fadeIn(500);
    		$("#btn-display-info").fadeIn(500).html("<div class='btn-group'>" +
														"<button id='display-info-show' class='btn btn-danger btn-md' type='button'>" +
															"<span class='glyphicon glyphicon-cog'></span>" +
															" Show Display Information" +
														"</button>" +
													"</div>" + 
													"<br><br>");

	      	btnDisplayInfoShow = $("#display-info-show").click(function(){

	      		$("#frmmain").fadeOut(500);
		        
		        $("#btn-display-info").fadeOut(500, function(){

		        	$("#display-info-hide").fadeIn(1);
		        	$("#display-info").fadeIn(500);
		        	$("#frmmain").attr("class", "form-group col-xs-12 col-md-8 col-lg-8");
		        	$("#frmmain").fadeIn(500);

		        });

		    });

    	});
        

    });

    $("#btn-generate").unbind("click").click(function(){

    	if (sensorID == ""){
    		if (generateAllSensors == "false"){
    			$("#error-report-modal").modal();
    		}else if (generateAllSensors == "true") {
    			initializeSensorData();
    		}
    	}else {
    		initializeSensorData();
    	}

    });

    $("#btn-tour").click(function(){

    	$("#tour-report-modal").modal();

    });

    function initializeSensorData(){

    	var provinceName = $("#province-id option:selected").text();
    	var locationName = $("#address-id option:selected").text();

    	displayType = $("#display-type option:selected").val();
    	sensorType = $("#sensor-type option:selected").val();
		provinceID = $("#province-id option:selected").val();
		sensorID = $("#address-id option:selected").val();

		$("#generate-report-modal").modal();
		$("#location-title").html("");
		$("#province-id").attr('disabled', true);
		$("#address-id").attr('disabled', true);
		$("#CSVTableDisplay").html("<div>" +
								    	"<div id='loading-div'>" +
								    		"<h4 style='color: #FFFFFF;''><center>Generating Data...</center></h4>" +
								    		"<div class='progress'>" +
								    		  	"<div id='log-progress' class='progress-bar progress-bar-striped active' role='progressbar'" +
								    		  		"aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style='width: 100%'>" +
								    		  	"</div>" +
								    		"</div>" +
								    	"</div>"+
								    "</div>");
		$("#CSVTableDisplay").collapse("show");

    	$.post('report/generate-data', {
        
		    _token: $('meta[name=csrf-token]').attr('content'),
		    display_Type: displayType,
		    generate_All_Sensors: generateAllSensors,
		    sensor_Type: sensorType,
		    province_ID: provinceID,
		    sensor_ID: sensorID,
		    date_Start: dateStart,
		    date_End: dateEnd,
		    toggle_Report_Type: "1",

		}).done(function(data) {

			$("#CSVTableDisplay").fadeOut(200, function(){

				$(this).html("<div id='report-table' style='border-color: #363940;'>" +
					      	 "</div>" +
					      	 "<br>" +
					      	 "<div id='chart-display' class='well'  style='background-color: #363940; border-color: #363940;'>" +
								    "<div id='container-chart'></div>" +
							 "</div>").fadeIn(200, function(){

					$("#province-id").removeAttr("disabled");
					$("#address-id").removeAttr("disabled");

					//var sensorData = $.parseJSON(data);
					//$("#container-chart").html("<div style='color: #FFF;'>" + data + "</div>");
					//console.log(sensorData);
					//console.log(sensorData.sensor_data.length);
					
					$("#defective-date").fadeOut(300);
    				$("#defective-table").html("");

					proccessSensorData(displayType, data, provinceName, locationName);

				});

			});
					      
		}).fail(function(xhr, status, error) {

			$("#CSVTableDisplay").fadeOut(200, function(){

				$(this).html("<div id='report-table' style='overflow-y: auto;'>" +
								"<center>" +
			      	  				"<h3 style='color: #d9534f;'>There is an error occured in generating the data.</h3>" +
			      	  			"</center>" +
					      	 "</div>").fadeIn(200);

				$("#province-id").removeAttr("disabled");
				$("#address-id").removeAttr("disabled");

			});

		});  

    }

    function proccessSensorData(displayType, _data, provinceName, locationName){

    	var fileTitle = "";
    	var data = $.parseJSON(_data);

    	if (generateAllSensors == "false"){

    		var tableData = data.sensor_data;
    		var defectiveDate = data.defective_date;

    		if (defectiveDate.length > 0) {

    			for (var i = 0; i < defectiveDate.length; i++) {
	    			var tblData = "<tr><td>" + 
	    						  	defectiveDate[i] + 
	    						  "</td></tr>";
	    			var str = str + tblData;
	    			$("#defective-table").html(str);
	    		}

    		} else if (defectiveDate.length == 0) {

    			var tblData = "<tr><td>" + 
	    					  	"None." + 
	    					  "</td></tr>";
	    		$("#defective-table").html(tblData);

    		}

    		$("#defective-date").fadeIn(300);

	    	if (categoryID == "1"){

	    		var datetime = [];
				var raincum = [];
				var rainval = [];

				for (var count = 0; count < tableData.length; count++){

					datetime.push(tableData[count].date_read);
					raincum.push(tableData[count].rain_cumulative);
					rainval.push(tableData[count].rain_value);

				}

				categoryData = datetime;
				textTitle = "Rain Cumulative Value (mm)";
		        unit = "mm";
		        legendToggle = "true";
		        
				if (displayType == "1"){

					chartName = "Rain Cumulative Chart (DEFAULT)";

					$("#location-title").html(provinceName + " - " + locationName + " (ARG)");
	    			fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date Time (MM/DD/YYYY hh:mm tt)", width: 300,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy hh:mm tt}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
		                			 { field: "rain_value", title: "Rain Value (mm)", filterable: false, width: 190 },
		                			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 },
		                			 { field: "air_pressure", title:"Air Pressure (hPa)", filterable: false, width: 190 } ];

		            seriesData = [{
							   	     type: 'area',
							   	     name: 'Rain Value',
							   	     data: rainval
							   	 },
							   	 {
							   	     type: 'area',
							   	     name: 'Rain Cumulative',
							   	     data: raincum
							   	 }];

		            generateTable(tableData, tableColumns, fileTitle);
	    			generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "2"){

					chartName = "Rain Cumulative Chart (HOURLY)";

					$("#location-title").html(provinceName + " - " + locationName + " (ARG)");
	    			fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date Time (MM/DD/YYYY hh:mm tt)", width: 300,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy hh:mm tt}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
		                			 { field: "rain_value", title: "Rain Value (mm)", filterable: false, width: 190 },
		                			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 },
		                			 { field: "air_pressure", title:"Air Pressure (hPa)", filterable: false, width: 190 } ];

		            seriesData = [{
							   	     type: 'area',
							   	     name: 'Rain Value',
							   	     data: rainval
							   	 },
							   	 {
							   	     type: 'area',
							   	     name: 'Rain Cumulative',
							   	     data: raincum
							   	 }];

		            generateTable(tableData, tableColumns, fileTitle);
	    			generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "3"){

					chartName = "Rain Cumulative Chart (DAILY)";

					$("#location-title").html(provinceName + " - " + locationName + " (ARG)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date (MM/DD/YYYY)", width: 250, filterable: false,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy}",
		    						 },
			             			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 } ];

			         seriesData = [{
							   	     type: 'area',
							   	     name: 'Rain Cumulative',
							   	     data: raincum
							   	 }];

			        generateTable(tableData, tableColumns, fileTitle);
		    		generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "4"){

					chartName = "Rain Cumulative Chart (MONTHLY)";

					$("#location-title").html(provinceName + " - " + locationName + " (ARG)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date (MM-YYYY)", filterable: false, width: 190 },
			            			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 } ];

			        seriesData = [{
							   	     type: 'area',
							   	     name: 'Rain Cumulative',
							   	     data: raincum
							   	 }];

			        generateTable(tableData, tableColumns, fileTitle);
		    		generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "5"){

					chartName = "Rain Cumulative Chart (YEARLY)";

					$("#location-title").html(provinceName + " - " + locationName + " (ARG)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date (YYYY)", width: 190 },
			            			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 } ];

			        seriesData = [{
							   	     type: 'area',
							   	     name: 'Rain Cumulative',
							   	     data: raincum
							   	 }];

			        generateTable(tableData, tableColumns, fileTitle);
		    		generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "6"){

					$("#location-title").html(provinceName + " - " + locationName + " (ARG)");
	    			fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_start", title: "Date Start (MM/DD/YYYY)", filterable: false,
		    						   type:"date", format: "{0: MM/dd/yyyy}", width: 250 },
		                			 { field: "date_end", title: "Date End (MM/DD/YYYY)", filterable: false,
		                			   type:"date", format: "{0: MM/dd/yyyy}", width: 250 },
		                			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 } ];

		            generateTable(tableData, tableColumns, fileTitle);
					
				}

	    	}else if (categoryID == "2"){

	    		var datetime = [];
	    		var waterlevelVal = [];
				var lowestWaterval = [];
				var highestWaterval = [];

				for (var count = 0; count < tableData.length; count++){

					datetime.push(tableData[count].date_read);
					waterlevelVal.push(tableData[count].waterlevel);
					lowestWaterval.push(tableData[count].lowest_waterlevel);
					highestWaterval.push(tableData[count].highest_waterlevel);

				}

				categoryData = datetime;
				textTitle = "Waterlevel Value (mm)";
		        unit = "mm";
		        legendToggle = "true";

				if (displayType == "1"){

					chartName = "Waterlevel Chart (DEFAULT)";

		    		$("#location-title").html(provinceName + " - " + locationName + " (WLMS)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date Time (MM/DD/YYYY hh:mm tt)", width: 300,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy hh:mm tt}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
		                			 { field: "waterlevel", title: "Waterlevel (mm)", filterable: false, width: 190 } ];	 

		            seriesData = [{
								 	 type: 'area',
								 	 name: 'Waterlevel',
								 	 data: waterlevelVal
								 }];

		            generateTable(tableData, tableColumns, fileTitle);
	    			generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);          

				}else if (displayType == "2"){

					chartName = "Waterlevel Chart (HOURLY)";

					$("#location-title").html(provinceName + " - " + locationName + " (WLMS)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date Time (MM/DD/YYYY hh:mm tt)", width: 300,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy hh:mm tt}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
		                			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
		                			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 } ];

		            seriesData = [{
							 	   	 type: 'area',
							 	   	 name: 'Highest Waterlevel',
							 	   	 data: highestWaterval
								 }, {
								     type: 'area',
								     name: 'Lowest Waterlevel',
								     data: lowestWaterval
								 }];

		            generateTable(tableData, tableColumns, fileTitle);
	    			generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "3"){

					chartName = "Waterlevel Chart (DAILY)";

					$("#location-title").html(provinceName + " - " + locationName + " (WLMS)");
			    	fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date Time (MM/DD/YYYY)", width: 250, filterable: false,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
			            			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
			            			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 } ];

			        seriesData = [{
							 	     type: 'area',
							 	     name: 'Highest Waterlevel',
							 	     data: highestWaterval
								 }, {
								     type: 'area',
								     name: 'Lowest Waterlevel',
								     data: lowestWaterval
								 }];

			        generateTable(tableData, tableColumns, fileTitle);
		    		generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "4"){

					chartName = "Waterlevel Chart (MONTHLY)";

	    			$("#location-title").html(provinceName + " - " + locationName + " (WLMS)");
			    	fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date (MM-YYYY)", width: 190 },
			            			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
			            			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 } ];

			        seriesData = [{
							 	     type: 'area',
							 	     name: 'Highest Waterlevel',
							 	     data: highestWaterval
								 }, {
								     type: 'area',
								     name: 'Lowest Waterlevel',
								     data: lowestWaterval
								 }];

			        generateTable(tableData, tableColumns, fileTitle);
		    		generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);
					
					

				}else if (displayType == "5"){

					chartName = "Waterlevel Chart (YEARLY)";

	    			$("#location-title").html(provinceName + " - " + locationName + " (WLMS)");
			    	fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date (YYYY)", width: 160 },
			            			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
			            			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 } ];

			        seriesData = [{
							 	   	 type: 'area',
							 	   	 name: 'Highest Waterlevel',
							 	   	 data: highestWaterval
								 }, {
								     type: 'area',
								     name: 'Lowest Waterlevel',
								     data: lowestWaterval
								 }];

			        generateTable(tableData, tableColumns, fileTitle);
		    		generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "6"){

					$("#location-title").html(provinceName + " - " + locationName + " (WLMS)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_start", title: "Date Start (YYYY-MM-DD)", filterable: false, width: 250 },
		                			 { field: "date_end", title: "Date End (YYYY-MM-DD)", filterable: false, width: 250 },
		                			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
		                			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 } ];

		            generateTable(tableData, tableColumns, fileTitle);
					
				}

	    	}else if (categoryID == "3"){

	    		var datetime = [];
				var raincum = [];
				var rainval = [];
				var waterlevelVal = [];
				var lowestWaterval = [];
				var highestWaterval = [];

				for (var count = 0; count < tableData.length; count++){
					
					datetime.push(tableData[count].date_read);
					raincum.push(tableData[count].rain_cumulative);
					rainval.push(tableData[count].rain_value);
					waterlevelVal.push(tableData[count].waterlevel);
					lowestWaterval.push(tableData[count].lowest_waterlevel);
					highestWaterval.push(tableData[count].highest_waterlevel);

				}

				categoryData = datetime;
				textTitle = "Waterlevel Value (mm), Rain Cumulative Value (mm)";
		        unit = "";
		        legendToggle = "true";

				if (displayType == "1"){

					chartName = "Waterlevel & Rain Cumulative Chart (DEFAULT)";

					$("#location-title").html(provinceName + " - " + locationName + " (TDM)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date Time (MM/DD/YYYY hh:mm tt)", width: 300,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy hh:mm tt}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
		                			 { field: "waterlevel", title: "Waterlevel (mm)", filterable: false, width: 190 },
		                			 { field: "rain_value", title: "Rain Value (mm)", filterable: false, width: 190 },
		                			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 },
		                			 { field: "air_pressure", title:"Air Pressure (hPa)", filterable: false, width: 190 } ];

		            seriesData = [{
							 	   	 type: 'area',
							 	   	 name: 'Waterlevel',
							 	   	 data: waterlevelVal
								 }, {
								     type: 'area',
								     name: 'Rain Value',
								     data: rainval
								 }, {
								     type: 'area',
								     name: 'Rain Cumulative',
								     data: raincum
								 }];

		            generateTable(tableData, tableColumns, fileTitle);
	    			generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "2"){

					chartName = "Waterlevel & Rain Cumulative Chart (HOURLY)";

		            $("#location-title").html(provinceName + " - " + locationName + " (TDM)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date Time (MM/DD/YYYY hh:mm tt)", width: 300,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy hh:mm tt}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
		                			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
		                			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 },
		                			 { field: "rain_value", title: "Rain Value (mm)", filterable: false, width: 190 },
		                			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 },
		                			 { field: "air_pressure", title:"Air Pressure (hPa)", filterable: false, width: 190 } ];

		            seriesData = [{
							 	   	 type: 'area',
							 	   	 name: 'Lowest Waterlevel',
							 	   	 data: lowestWaterval
								 }, {
							 	   	 type: 'area',
							 	   	 name: 'Highest Waterlevel',
							 	   	 data: highestWaterval
								 }, {
								     type: 'area',
								     name: 'Rain Value',
								     data: rainval
								 }, {
								     type: 'area',
								     name: 'Rain Cumulative',
								     data: raincum
								 }];

		            generateTable(tableData, tableColumns, fileTitle);
	    			generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "3"){

					chartName = "Waterlevel & Rain Cumulative Chart (DAILY)";

	    			$("#location-title").html(provinceName + " - " + locationName + " (TDM)");
			    	fileTitle = $("#location-title").text().replace(/ /g,'');

			    	tableColumns = [ { field: "date_read", title: "Date (MM/DD/YYYY)", width: 250, filterable: false,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
			            			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
			            			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 },
			            			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 } ];

			        seriesData = [{
							 	   	 type: 'area',
							 	   	 name: 'Lowest Waterlevel',
							 	   	 data: lowestWaterval
								 }, {
							 	   	 type: 'area',
							 	   	 name: 'Highest Waterlevel',
							 	   	 data: highestWaterval
								 }, {
								     type: 'area',
								     name: 'Rain Cumulative',
								     data: raincum
								 }];

			        generateTable(tableData, tableColumns, fileTitle);
		    		generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "4"){

					chartName = "Waterlevel & Rain Cumulative Chart (MONTHLY)";

	    			if (generateAllSensors == "false"){

	    				$("#location-title").html(provinceName + " - " + locationName + " (TDM)");
			    		fileTitle = $("#location-title").text().replace(/ /g,'');

			    		tableColumns = [ { field: "date_read", title: "Date (MM-YYYY)", width: 190 },
			                			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
			                			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 },
			                			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 } ];

			            seriesData = [{
								 	   	 type: 'area',
								 	   	 name: 'Lowest Waterlevel',
								 	   	 data: lowestWaterval
									 }, {
								 	   	 type: 'area',
								 	   	 name: 'Highest Waterlevel',
								 	   	 data: highestWaterval
									 }, {
									     type: 'area',
									     name: 'Rain Cumulative',
									     data: raincum
									 }];

			            generateTable(tableData, tableColumns, fileTitle);
		    			generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);
						
					}else if (generateAllSensors == "true"){

						

					}

				}else if (displayType == "5"){

					chartName = "Waterlevel & Rain Cumulative Chart (YEARLY)";

	    			$("#location-title").html(provinceName + " - " + locationName + " (TDM)");
			    	fileTitle = $("#location-title").text().replace(/ /g,'');

			    	tableColumns = [ { field: "date_read", title: "Date (YYYY)", width: 160 },
			            			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
			            			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 },
			            			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 } ];

			        seriesData = [{
							 	   	 type: 'area',
							 	   	 name: 'Lowest Waterlevel',
							 	   	 data: lowestWaterval
								 }, {
							 	   	 type: 'area',
							 	   	 name: 'Highest Waterlevel',
							 	   	 data: highestWaterval
								 }, {
								     type: 'area',
								     name: 'Rain Cumulative',
								     data: raincum
								 }];

			        generateTable(tableData, tableColumns, fileTitle);
		    		generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}else if (displayType == "6"){

					$("#location-title").html(provinceName + " - " + locationName + " (TDM)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_start", title: "Date Start (YYYY-MM-DD)", filterable: false, width: 250 },
		                			 { field: "date_end", title: "Date End (YYYY-MM-DD)", filterable: false, width: 250 },
		                			 { field: "lowest_waterlevel", title: "Lowest Waterlevel (mm)", filterable: false, width: 230 },
		                			 { field: "highest_waterlevel", title: "Highest Waterlevel (mm)", filterable: false, width: 230 },
		                			 { field: "rain_cumulative", title:"Rain Cumulative (mm)", filterable: false, width: 210 } ];

		            generateTable(tableData, tableColumns, fileTitle);

				}

	    	}else if (categoryID == "4"){

	    		$("#location-title").html(provinceName + " - " + locationName + " (AWS)");
		    	fileTitle = $("#location-title").text().replace(/ /g,'');

		    	var datetime = [];
				var rainval = [];
				var rainintensity = [];
				var rainduration = [];
				var airtemp = [];
				var airpressure = [];
				var windspeed = [];
				var winddirection = [];
				var airhumidity = [];
				var solarradiation = [];
				var windspeedmax = [];
				var raincum = [];
				var sunshinecount = [];
				var sunshinecum = [];
				var soilmoist1 = [];
				var soiltemp1 = [];
				var soilmoist2 = [];
				var soiltemp2 = [];
				var winddirectionmax = [];

				for (var count = 0; count < tableData.length; count++){

					datetime.push(tableData[count].date_read);
					rainval.push(tableData[count].rain_value);
					rainintensity.push(tableData[count].rain_intensity);
					rainduration.push(tableData[count].rain_duration);
					airtemp.push(tableData[count].air_temperature);
					airpressure.push(tableData[count].air_pressure);
					windspeed.push(tableData[count].wind_speed);
					winddirection.push(tableData[count].wind_direction);
					airhumidity.push(tableData[count].air_humidity);
					solarradiation.push(tableData[count].solar_radiation);
					windspeedmax.push(tableData[count].wind_speed_max);
					raincum.push(tableData[count].rain_cum);
					sunshinecount.push(tableData[count].sunshine_count);
					sunshinecum.push(tableData[count].sunshine_cum);
					soilmoist1.push(tableData[count].soil_moisture1);
					soiltemp1.push(tableData[count].soil_temperature1);
					soilmoist2.push(tableData[count].soil_moisture2);
					soiltemp2.push(tableData[count].soil_temperature2);
					winddirectionmax.push(tableData[count].wind_direction_max);

				}

				categoryData = datetime;
				textTitle = "Automated Weather Station Data";
		        unit = "";
		        legendToggle = "true";

				if (displayType == "1"){

					chartName = "Automated Weather Station Chart (DEFAULT)";

					$("#location-title").html(provinceName + " - " + locationName + " (AWS)");
		    		fileTitle = $("#location-title").text().replace(/ /g,'');

		    		tableColumns = [ { field: "date_read", title: "Date Time (MM/DD/YYYY hh:mm tt)", width: 300,
		    						   type:"date",
		    						   format: "{0: MM/dd/yyyy hh:mm tt}", 
		    						   filterable: 
		    						   { 
		    						   	   ui: "datetimepicker",
		    						   	   operators: 
		    						   	   { 
		    						   	   	   date: { gte: "Start Date", lte: "End Date" } 
		    						   	   } 
									   } 
		    						 },
		                			 { field: "rain_value", title: "Rain Value (mm)", width: 190, filterable: false },
		                			 { field: "rain_intensity", title:"Rain Intensity (mm/hr)", width: 230, filterable: false },
		                			 { field: "rain_duration", title:"Rain Duration (sec)", width: 230, filterable: false },
		                			 { field: "air_temperature", title:"Air Temperature (Â°C)", width: 220, filterable: false },
		                			 { field: "air_pressure", title:"Air Pressure (hPa)", width: 190, filterable: false },
		                			 { field: "wind_speed", title:"Wind Speed (kph)", width: 170, filterable: false },
		                			 { field: "wind_direction", title:"Wind Direction (Â°)", width: 190, filterable: false },
		                			 { field: "air_humidity", title:"Air Humidity (%)", width: 190, filterable: false },
		                			 { field: "solar_radiation", title:"Solar Radiation (W/m2)", width: 230, filterable: false },
		                			 { field: "wind_speed_max", title:"wind Speed_max(kph)", width: 230, filterable: false },
		                			 { field: "rain_cum", title:"Rain Cum (mm)", width: 160, filterable: false },
		                			 { field: "sunshine_count", title:"Sunshine Count (W/m2)", width: 230, filterable: false },
		                			 { field: "sunshine_cum", title:"Sunshine Cum (W/m2)", width: 230, filterable: false },
		                			 { field: "soil_moisture1", title:"Soil Moisture1 (Â°)", width: 230, filterable: false },
		                			 { field: "soil_temperature1", title: "Soil Temperature1 (Â°C)", width: 230, filterable: false },
		                			 { field: "soil_moisture2", title:"Soil Moisture2 (Â°)", width: 230, filterable: false },
		                			 { field: "soil_temperature2", title:"Soil Temperature2 (Â°C)", width: 230, filterable: false },
		                			 { field: "wind_direction_max", title:"Wind Direction Max (Â°)", width: 230, filterable: false } ];

		            seriesData = [{
						    	      type: 'area',
					        	      name: 'rain_value(mm)',
					        	      data: rainval
					        	  }, {
					        	  	type: 'area',
					        	      name: 'rain_intensity(mm/hr)',
					        	      data: rainintensity
					        	  }, {
					        	  	type: 'area',
					        	      name: 'rain_duration(sec)',
					        	      data: rainduration
					        	  }, {
					        	  	type: 'area',
					        	      name: 'air_temperature(°C)',
					        	      data: airtemp
					        	  }, {
					        	  	type: 'area',
					        	      name: 'air_pressure(hPa)',
					        	      data: airpressure
					        	  }, {
					        	  	type: 'area',
					        	      name: 'wind_speed(kph)',
					        	      data: windspeed
					        	  }, {
					        	  	type: 'area',
					        	      name: 'wind_direction(°)',
					        	      data: winddirection
					        	  }, {
					        	  	type: 'area',
					        	      name: 'air_humidity(%)',
					        	      data: airhumidity
					        	  }, {
					        	  	type: 'area',
					        	      name: 'solar_radiation(W/m2)',
					        	      data: solarradiation
					        	  }, {
					        	  	type: 'area',
					        	      name: 'wind_speed_max(kph)',
					        	      data: windspeedmax
					        	  }, {
					        	  	type: 'area',
					        	      name: 'rain_cum(mm)',
					        	      data: raincum
					        	  }, {
					        	  	type: 'area',
					        	      name: 'sunshine_count(W/m2)',
					        	      data: sunshinecount
					        	  }, {
					        	  	type: 'area',
					        	      name: 'sunshine_cum(W/m2)',
					        	      data: sunshinecum
					        	  }, {
					        	  	type: 'area',
					        	      name: 'soil_moisture1(°)',
					        	      data: soilmoist1
					        	  }, {
					        	  	type: 'area',
					        	      name: 'soil_temperature1(°C)',
					        	      data: soiltemp1
					        	  }, {
					        	  	type: 'area',
					        	      name: 'soil_moisture2(°)',
					        	      data: soilmoist2
					        	  }, {
					        	  	type: 'area',
					        	      name: 'soil_temperature2(°C)',
					        	      data: soiltemp2
					        	  }, {
					        	  	type: 'area',
					        	      name: 'wind_direction_max(°)',
					        	      data: winddirectionmax
					        	  }];

		            generateTable(tableData, tableColumns, fileTitle);
	    			generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData);

				}

	    	}

	    }else if (generateAllSensors == "true"){

	    	var startDate;
	    	var endDate;
	    	//var tableData = JSON.parse(data);
	    	var tableData = data;
	    	var dateRead_Length = 0;
	    	var dateRead = [];
	    	var tempField = "";
			var tempTitle = "";

			for(fieldName in tableData[0]){

			   	dateRead.push(fieldName);
			   	dateRead_Length++;

			}

			tableColumns = [ { field: "sensor_location", title: "Sensor Location", width: 250 },
			    			 { field: "province_name", title: "Province", width: 150 },
			        		 { field: "category_name", title: "Sensor Type", width: 150 } ]

	    	if (displayType == "3"){

	    		chartName = "Daily Rain Cumulative";

	    		$("#location-title").html("Daily Rain Cumulative");
			    fileTitle = $("#location-title").text().replace(/ /g,'');

			    for (var i = 0; i < dateRead_Length - 4; i++) {
			    	
			    	if (dateRead[i] != undefined){

			    		tempField = dateRead[i];
				    	tempTitle = dateRead[i].replace(/d/g,'').replace(/_/g,'/');
				    	tableColumns.push({ field: tempField, title: tempTitle, width: 140 });

			    	}

			    }

			    tableColumns.push({ field: "defective_date", title: "Date/s with Incomplete and No Data", width: 650 });

			    generateTable(tableData, tableColumns, fileTitle);

	    	}else if (displayType == "4"){

	    		chartName = "Monthly Rain Cumulative";

	    		$("#location-title").html("Monthly Rain Cumulative");
			    fileTitle = $("#location-title").text().replace(/ /g,'');

			    for (var i = 0; i < dateRead_Length - 4; i++) {
			    	
			    	if (dateRead[i] != undefined){

			    		tempField = dateRead[i];
				    	tempTitle = dateRead[i].replace(/_/g,' - ');
				    	tableColumns.push({ field: tempField, title: tempTitle, width: 250 });

			    	}

			    }

			    tableColumns.push({ field: "defective_date", title: "Date/s with Incomplete and No Data", width: 650 });

			    generateTable(tableData, tableColumns, fileTitle);

	    	}else if (displayType == "5"){

	    		chartName = "Yearly Rain Cumulative";

	    		$("#location-title").html("Yearly Rain Cumulative");
			    fileTitle = $("#location-title").text().replace(/ /g,'');

			    for (var i = 0; i < dateRead_Length - 4; i++) {
			    	
			    	if (dateRead[i] != undefined){

			    		tempField = dateRead[i];
				    	tempTitle = dateRead[i].replace(/d/g,'');
				    	tableColumns.push({ field: tempField, title: tempTitle, width: 140 });

			    	}

			    }

			    tableColumns.push({ field: "defective_date", title: "Date/s with Incomplete and No Data", width: 650 });

			    generateTable(tableData, tableColumns, fileTitle);

	    	}

	    }

    }

    function generateTable(tableData, tableColumns, fileTitle){

    	//var tableData = JSON.parse(data);
    	var tableFileTitle = "";

    	tableFileTitle = "Table-" + fileTitle + "-" + dateStart + "_" + dateEnd;
    	tableFileTitle = tableFileTitle.toUpperCase();

    	pdfFilename = tableFileTitle + ".pdf";
    	excelFilename = tableFileTitle + ".xlsx";

    	/*
    	$("#report-table").shieldGrid({
		    dataSource: {
		        data: data
		    },
		    sorting:{
                multiple: true
            },
            paging: {
                pageSize: 20,
                pageLinksCount: 10
            },
            selection:{
                type: "row",
                multiple: true,
                toggle: false
            },
            columns: tableColumns,
            toolbar: [
                {
                    buttons: [
                        {
                            commandName: "pdf",
                            caption: '<span class="fa fa-file-pdf-o"></span> <span class="sui-grid-button-text">Export to PDF</span>'
                        },
                        {
                            commandName: "excel",
                            caption: '<span class="fa fa-file-excel-o"></span> <span class="sui-grid-button-text">Export to Excel</span>'
                        }
                    ]
                }
            ],
            exportOptions: {
			    excel: {
                    fileName: excelFilename,
                    author: "DRRMIS",
                    dataSource: {
                        data: data
                    },
                    readDataSource: true
                },
			    pdf: {
                    fileName: pdfFilename,
                    author: "DRRMIS",
                    dataSource: {
                        data: data
                    },
                    readDataSource: true,
                    header: { tableColumns }
                }
            }
		});*/

		kendo.pdf.defineFont({
            "DejaVu Sans"             : "css/fonts/DejaVu/DejaVuSans.ttf",
            "DejaVu Sans|Bold"        : "css/fonts/DejaVu/DejaVuSans-Bold.ttf",
            "DejaVu Sans|Bold|Italic" : "css/fonts/DejaVu/DejaVuSans-Oblique.ttf",
            "DejaVu Sans|Italic"      : "css/fonts/DejaVu/DejaVuSans-Oblique.ttf"
        });

		$("#report-table").kendoGrid({
			toolbar: ["excel", "pdf"],
			excel: {
				title: fileTitle,
            	author: "DRRMIS",
            	creator: "DRRMIS",
            	date: showDate.format('YYYY/MM/DD'),
                fileName: excelFilename,
                filterable: true,
                allPages: true
            },
            pdf: {
            	title: fileTitle,
            	author: "DRRMIS",
            	creator: "DRRMIS",
            	date: showDate.format('YYYY/MM/DD'),
            	fileName: pdfFilename,
                allPages: true,
                avoidLinks: true,
                paperSize: "A4",
                margin: { top: "2cm", left: "1cm", right: "1cm", bottom: "1cm" },
                landscape: false,
                repeatHeaders: true,
                template: $("#page-template").html(),
                scale: 0.8
            },
	        dataSource: {
		        data: tableData,
		        pageSize: 20
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
            filterable: {
                extra: true
            },
	        columns: tableColumns,
	        dateTimePicker: {
	        	timeFormat: "hh:mm:ss"
	        }

	    });

    }

    function generateChart(fileTitle, chartName, textTitle, unit, legendToggle, seriesData, categoryData){

    	var chartFileTitle = "Chart-" + fileTitle + "-" + dateStart + "_" + dateEnd;
		//var tableData = JSON.parse(data);

		chartFileTitle = chartFileTitle.toUpperCase();

    	$('#container-chart').highcharts({
			credits: {
				text: 'DRRMIS',
            	href: 'http://drrmis.dostcar.ph'
			},
			exporting: {
		        filename: chartFileTitle,
		        sourceWidth: 1680,
    			sourceHeight: 768
		    },
		    chart: {
		        zoomType: 'x'
		    },
		    title: {
		        text: chartName,
		        x: -20 //center
		    },
		    subtitle: {
		        text: '',
		        x: -20
		    },
		    xAxis: {
		    	type: "datetime",
		    	categories: categoryData
		        
		    },
		    yAxis: {
		        title: {
		            text: textTitle
		        }
		    },
		    tooltip: {
		        valueSuffix: unit
		    },
		    legend: {
		        enabled: legendToggle
		    },
		    plotOptions: {
		        area: {
		            fillColor: {
		                linearGradient: {
		                    x1: 0,
		                    y1: 0,
		                    x2: 0,
		                    y2: 1
		                },
		                stops: [
		                    [0, Highcharts.getOptions().colors[0]],
		                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
		                ]
		            },
		            marker: {
		                radius: 2
		            },
		            lineWidth: 1,
		            states: {
		                hover: {
		                    lineWidth: 1
		                }
		            },
		            threshold: null
		        }
		    },

		    series: seriesData,

		});

		var chart = $('#container-chart').highcharts();

    }

});