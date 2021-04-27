@extends('layouts.masters.sms-module')
@section('page-content')

<div class="row">
	<div class="col-md-12">
		<h1 class="page-header">
			<i class="fa fa-comment"></i>
			Compose Message
			<hr>

			<div class="form-group">
				<label for="sms-medium">
					<small>
						SMS Medium:
						<a href="{{ asset('assets/drrmis-gsm-client-setup.zip') }}" 
						   class="btn btn-link" id="drrmis-gsm-client"
						   style="display: none;">
							<i class="fa fa-file-zip-o" aria-hidden="true"></i>
							Download DRRMIS GSM Client Setup
						</a>
					</small>
					
				</label>
				<select name="sms_medium" id="sms-medium" class="form-control">
					<option value="semaphore" selected> SEMAPHORE API </option>
					<option value="gsm-module">GSM Module (Connected to PC)</option>
				</select>
			</div>
		</h1>
	</div>
	
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<div id="main-body">
					<h3 class="text-center">Send via Compose Message</h3>
					<hr>
					<div id="input-contact">
						<div class="form-group">
							<label style="color: #93e3f0;">
								*Use comma [ "," ] and whitespace [ " " ] to separate additional contact numbers.
							</label>
							<select id="recipients" name="recipients[]" multiple="multiple"></select>
						</div>
						<div class="form-group" id="sender-names-group">
							<label for="sender-names">
								Sender Name
							</label>
							<select name="sender_name" id="sender-names" class="form-control"></select>
						</div>
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

			<div class="col-md-1">
				<h3 class="text-center">
					<hr> OR <hr>
					
				</h3>
			</div>

			<div class="col-md-5">
				<div class="well" style="background: #363940; color: #fff;">
					<h3 class="text-center">Send via CSV File Upload</h3>
					<hr>
					<div class="panel panel-default">
						<div class="panel-heading"><strong>Upload Files</strong> <small>here</small></div>
						<div class="panel-body text-center">
				
							<!-- Standar Form -->
							<h4>Select files from your computer</h4>
							<a id="sms-semaphore-template" href="{{ asset('assets/sms-semaphore-template.csv') }}" 
							   class="btn btn-link btn-block">
							   	<b>
									<i class="fa fa-file-excel-o" aria-hidden="true"></i> 
									Download Semaphore CSV Template
								</b>
								
							</a>
							<a id="gsm-module-template" href="{{ asset('assets/sms-gsm-module-template.csv') }}" 
							   class="btn btn-link btn-block" style="display: none;">
							   	<b>
									<i class="fa fa-file-excel-o" aria-hidden="true"></i> 
									Download GSM Module CSV Template
								</b>
							</a>
							<small class="text-danger">
								<i>*Allowed format for the contact number/s: "+639123456789" or "09123456789" or "9123456789".</i>
							</small>
							<hr>
							<form action="#" method="post" enctype="multipart/form-data" id="form-upload-csv">
								{{ csrf_field() }}
				
								<input type="hidden" name="send_type" value="file">
								<div class="form-group">
									<input type="file" name="csv_file" id="csv_file" accept=".csv" 
										oninvalid="setCustomValidity('Please select a valid CSV file.')"
										class="btn btn-default btn-block">
								</div>
								<button type="submit" class="btn btn-primary" id="upload-submit">
									<i class="fa fa-paper-plane" aria-hidden="true"></i> Upload file & Send
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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