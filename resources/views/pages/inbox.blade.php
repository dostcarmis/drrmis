@extends('layouts.masters.sms-module')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">
			<span class="glyphicon glyphicon-envelope"></span> 
			Notifications
		</h1>
		<div id="user-id" class="hidden">{{$currentUser->id}}</div>
	</div>

	<div id="frmmain" class="form-group col-xs-12 col-md-12 col-lg-12">
	  	<div class="panel panel-default">
	  	  	<div class="panel-heading" style="border-color: #1e1d1f; background-color: #262626;">
	  	  		
	  	  		<h3 style="color: #FFF;"> 
	  	  			<strong> All Notifications </strong> 
	  	  		</h3>
	  	  		
	  	  	</div>

	  	  	<div class="panel-body" style="background-color: #252525;">

	  	  		<div class="well panel-collapse collapse-in" style="background-color: #1e1d1f;">

	  	  			<div id="notification-display" style="overflow-y: auto; border-color: #363940; border-radius: 10px;"> 
	      	  			
	  	  			</div>
	  	  			
	  	  		</div>
	
	  		</div>

		</div>

	</div>

</div>

@stop
@section('page-js-files')
  	<script src="{!! url('assets/js/sms-inbox.js') !!}"></script>
@stop