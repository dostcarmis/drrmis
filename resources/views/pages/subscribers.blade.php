@extends('layouts.masters.sms-module')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">
			<span class="glyphicon glyphicon-user"></span> 
			Subscribers
			<hr>
		</h1>
		<div id="user-id" class="hidden">{{Auth::user()->id}}</div>
	</div>

	<div id="frmmain" class="form-group col-xs-12 col-md-12 col-lg-12">
	  	<div class="panel panel-default">
	  	  	<div class="panel-heading" style="border-color: #1e1d1f; background-color: #262626;">
	  	  		<button id="btn-subscribe" type="submit" class="btn btn-success hidden">
				  	<i class="fa fa-user-plus"></i> Subscribe
				</button>
				<button id="btn-unsubscribe" type="submit" class="btn btn-danger hidden">
				  	<i class="fa fa-user-times"></i> Unsubscribe
				</button>
	  	  	</div>

	  	  	<div class="panel-body" style="background-color: #252525;">
	  	  		<div class="well panel-collapse collapse-in" style="background-color: #1e1d1f;">
	  	  			<div id="phonebook-display" style="overflow-y: auto; border-color: #363940; border-radius: 10px;"> 
	      	  			
	  	  			</div>
	  	  		</div>
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
                <div class="alert alert-danger">
                    <h3>
                        <strong>Success!</strong> "You are now unsubscribe!"
                    </h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-confirm" role="dialog">
  	<div class="modal-dialog">
  
    	<!-- Modal content-->
    	<div class="modal-content">
    	  	<div class="modal-header">
    	  	  	<button type="button" class="close" data-dismiss="modal">&times;</button>
    	  	  	<h4 class="modal-title">Confirmation</h4>
    	  	</div>
    	  	<div class="modal-body">
				Are you sure you want to unsubscribe now?
    	  	</div>
    	  	<div class="modal-footer">
    	  		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    	  		<button id="confirm-unsubscribe" class="btn btn-danger">Yes</button>
    	  	</div>
    	</div>
    
  	</div>
</div>

@stop
@section('page-js-files')
  	<script src="{!! url('assets/js/sms-phonebook.js') !!}"></script>
@stop