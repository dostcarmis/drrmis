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

<div>
	<center>
		<div id="main-body" class="well">

			<div id="input-contact">
				<div class="input-group">
				    <input id="contact-input" type="text" class="form-control typeahead" autocomplete="off" 
				   	   spellcheck="false" placeholder="To">
				    <span class="input-group-addon">
				    	<a id="select-multiple" class="glyphicon glyphicon-plus" href="#"></a>
				    </span>
				</div>
				<div id="receiver-list">
					<button id="btn-recipient" class="btn btn-default btn-sm">
						<strong>Recipients</strong> 
						<span id="recipient-count" class="badge"></span>
					</button>
				</div>
			</div>

			<label class="char-count"><span id="character-count">0/160</span></label>
	  		<textarea id="msg" name="msg" class="form-control" rows="15"
	  				  placeholder="Type message"></textarea>
	  		<div class="button-container">
	  			<button id="send-msg" class="btn btn-primary btn-block btn-lg" 
	  					disabled="disabled">
	  					Send <span class="glyphicon glyphicon-send"></span>
	  			</button>
	  		</div>
		</div>
	</center>
</div>

<div class="overlay">
    <div id="sending">
    	<div id="progress-send" class='progress-bar progress-bar-striped active' role='progressbar'
			aria-valuenow='100 aria-valuemin='0' aria-valuemax='100' style="width: 100%;">
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-contact-list" role="dialog">
  	<div class="modal-dialog">
  
    	<!-- Modal content-->
    	<div class="modal-content">
    	  	<div class="modal-header">
    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
    	  	  	<h4 class="modal-title">Contacts</h4>
    	  	</div>
    	  	<div class="modal-body">
				<div class="form-group">

					<div style="max-height: 400px;overflow: auto;">

						<div id="list1">
				        	<a href="#" class="list-group-item active">
				        		Select All 
				        		<input title="toggle all" type="checkbox" class="all-contact pull-right">
				        	</a>
				     		<div id="contact-list">
				     			@foreach($subscribers as $subscriber)
					     			@foreach($users as $user)
					     				@if($user->id == $subscriber->user_id)
					     					<a href="#" class="list-group-item">

				        						<input name="{{ $user->	profile_img }}*{{ $user->first_name }} {{ $user->last_name }}" value="{{ $subscriber->subscriber_number }}" 
				        							   type="checkbox" class="pull-right">
				        						<center>								
													<img class="img-settings" src="{{ $user->profile_img }}" 
														 height="40" width="40">
													<ul class="contact-detail">
														<li>
															<strong class="contact-name"> {{ $user->first_name }} {{ $user->last_name }} </strong> 
														</li>
														<li>
															<em class="contact-number"> {{ $subscriber->subscriber_number }} </em>
														</li>
													</ul>
												</center>

				        					</a>
					     				@endif	
									@endforeach
								@endforeach
				     		</div>
				        </div>
		            	
		            </div>
				</div>
    	  	</div>
    	  	<div class="modal-footer">
    	  		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    	  		<button id="add-contact" class="btn btn-primary">Add Contacts</button>
    	  	</div>
    	</div>
    
  	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-recipient-list" role="dialog">
  	<div class="modal-dialog">
  
    	<!-- Modal content-->
    	<div class="modal-content">
    	  	<div class="modal-header">
    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
    	  	  	<h4 class="modal-title">Recipients</h4>
    	  	</div>
    	  	<div class="modal-body">
				<div class="form-group">

					<div style="max-height: 400px;overflow: auto;">

						<div id="list2">
				        	<a href="#" class="list-group-item active">
				        		Select All 
				        		<input title="toggle all" type="checkbox" class="all-recipient pull-right">
				        	</a>
				     		<div id="recipient-list">
				     			
				     		</div>
				        </div>
		            	
		            </div>
				</div>
    	  	</div>
    	  	<div class="modal-footer">
    	  		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    	  		<button id="remove-recipient" class="btn btn-primary" disabled="disabled">Remove</button>
    	  	</div>
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
					<textarea class="form-control" id="success-count" readonly="readonly" 
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
							<strong>Sending Failed!</strong>
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
	<script src="{!! url('assets/js/sms-compose.js') !!}"></script>
	<script src="{!! url('js/typeahead.bundle.js') !!}"></script>
@stop