$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){

	var _userID = "";
	var _baudRate = "";
	var _dataBits = "";
	var _parity = "";
	var _stopBits = "";
	var _flowControl = "";
	var _comPort = "";

	function initializeSettings(){

		var jsonResponse;

		_userID = $("#user-id").text();

		$.post('gsm/initialize-settings', {
            
		    _token: $('meta[name=csrf-token]').attr('content'),
		    userID: _userID,

		}).done(function(response) {

			jsonResponse = $.parseJSON(response);

			console.log(jsonResponse);

			_baudRate = jsonResponse.baud_rate;
			_dataBits = jsonResponse.data_bits;
			_parity = jsonResponse.parity;
			_stopBits = jsonResponse.stop_bits;
			_flowControl = jsonResponse.flow_control;

			$("#baud-rate").val(jsonResponse.baud_rate);
			$("#data-bits").val(jsonResponse.data_bits);
			$("#parity").val(jsonResponse.parity);
			$("#stop-bits").val(jsonResponse.stop_bits);
			$("#flow-control").val(jsonResponse.flow_control);
					      
		}).fail(function(xhr, status, error) {

			console.log(error);

		});

	}

	initializeSettings();

	$("#gsm-settings").click(function(){

		$("#gsm-settings-modal").modal({backdrop: 'static', keyboard: false});

		$("#save-gsm-settings").unbind("click").click(function(){

			_userID = $("#user-id").text();
			_baudRate = $("#baud-rate option:selected").val();
			_dataBits = $("#data-bits option:selected").val();
			_parity = $("#parity option:selected").val();
			_stopBits = $("#stop-bits option:selected").val();
			_flowControl = $("#flow-control option:selected").val();

			$.post('gsm/save-settings', {
            
		        _token: $('meta[name=csrf-token]').attr('content'),
		        userID: _userID,
		        baudRate: _baudRate,
		        dataBits: _dataBits,
		        parity: _parity,
		        stopBits: _stopBits,
		        flowControl: _flowControl

		    }).done(function(response) {

		    	console.log(response);
		    			      
		    }).fail(function(xhr, status, error) {

		    	console.log(error);

		    });

			$("#gsm-settings-modal").modal("hide");

		});

		initializeSettings();

		$("#restore-settings").click(function(){

			$("#baud-rate").val("9600");
			$("#data-bits").val("8");
			$("#parity").val("none");
			$("#stop-bits").val("1");
			$("#flow-control").val("none");

		});

	});

	$("#test-gsm").unbind("click").click(function(){

		_comPort = $("#com-port").val();

		$.post('gsm/test', {
            
		    _token: $('meta[name=csrf-token]').attr('content'),
		    comPort: _comPort,
		    baudRate: _baudRate,
		    dataBits: _dataBits,
		    parity: _parity,
		    stopBits: _stopBits,
		    flowControl: _flowControl,
		    writeMessage: "AT"

		}).done(function(response) {

			console.log(response);
					      
		}).fail(function(xhr, status, error) {

			console.log(error);

		});

	});

});