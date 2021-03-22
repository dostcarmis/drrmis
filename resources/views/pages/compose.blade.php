@extends('layouts.masters.sms-module')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">
			<i class="fa fa-comment"></i>
			Compose Message
			<hr>
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div id="main-body" class="well">
			<div id="input-contact">
				<label style="color: #93e3f0;">
					*Use comma [ "," ] and whitespace [ " " ] to separate additional contact numbers.
				</label>
				<select id="recipients" name="recipients[]" multiple="multiple"></select>
			</div>

			<label class="char-count"><span id="character-count">0/160</span></label>
			<textarea id="msg" name="msg" class="form-control" rows="8"
					placeholder="Type message"></textarea>
			<div class="button-container">
				<button id="send-msg" class="btn btn-primary btn-block btn-lg" 
						disabled="disabled">
						Send <span class="glyphicon glyphicon-send"></span>
				</button>
			</div>
		</div>
	</div>
</div><br><br>

<hr>
<h3 class="text-center">Send via CSV File Upload</h3>
<hr>

<div class="container">
	<div class="panel panel-default">
        <div class="panel-heading"><strong>Upload Files</strong> <small>here</small></div>
        <div class="panel-body text-center">

			<!-- Standar Form -->
			<h4>Select files from your computer</h4>
			<a href="{{ asset('assets/sms-template.csv') }}" class="btn btn-link btn-block">
				<i class="fa fa-file-excel-o" aria-hidden="true"></i> Download CSV Template
			</a>
			<small class="text-danger">
				<i>*The format for the contact number/s: "+639123456789" or "09123456789" or "9123456789".</i>
			</small>
			<hr>
			<form action="#" method="post" enctype="multipart/form-data" id="form-upload-csv">
				{{ csrf_field() }}

				<input type="hidden" name="send_type" value="file">
				<div class="form-inline">
					<div class="form-group">
						<input type="file" name="csv_file" id="csv_file" accept=".csv" 
							   oninvalid="setCustomValidity('Please select a valid CSV file.')"
							   class="btn btn-info">
					</div>
					<button type="submit" class="btn btn-primary" id="upload-submit">
						<i class="fa fa-paper-plane" aria-hidden="true"></i> Upload file & Send
					</button>
				</div>
			</form>
        </div>
    </div>
</div><br><br>

<div class="overlay">
    <div id="sending">
    	<div id="progress-send" class='progress-bar progress-bar-striped active' role='progressbar'
			aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style="width: 100%;">
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-success" role="dialog">
  	<div class="modal-dialog">
  
    	<!-- Modal content-->
    	<div class="modal-content">
    	  	<div class="modal-header">
    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
    	  	</div>
    	  	<div class="modal-body">
				<div class="alert alert-success">
					<h3>Message Logs</h3>
					<textarea class="form-control" id="success-logs" readonly="readonly" 
							  style="resize: none;" rows="10"></textarea>
				</div>
    	  	</div>
    	  	<div class="modal-footer">
    	  		<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
    	  	</div>
    	</div>
    
  	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-failed" role="dialog">
  	<div class="modal-dialog">
  
    	<!-- Modal content-->
    	<div class="modal-content">
    	  	<div class="modal-header">
    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
    	  	</div>
    	  	<div class="modal-body">
				<div class="alert alert-danger">
					<h3>
						<strong>Sending failed! Invalid file or columns in CSV file.</strong>
					</h3>
				</div>
    	  	</div>
    	  	<div class="modal-footer">
    	  		<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
    	  	</div>
    	</div>
    
  	</div>
</div>

@stop
@section('page-js-files')
	<script src="{!! url('js/typeahead.bundle.js') !!}"></script>
	<script src="{!! url('assets/js/sms-module.js') !!}"></script>
@stop