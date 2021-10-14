@extends('layouts.masters.backend-layout')
@section('page-content')

<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">
			<i class="fa fa-paper-plane"></i> Sent Messages
		</h1>
	</div>
	<form action="{{ action('SMSController@destroymultipleSentMsgs') }}" style="float: left;">
		<div class="col-xs-12">
			<p style="color:green">{!! Session::get('message') !!}</p>
			<div class="col-xs-12 ulpaginations np">
				<div class="col-xs-12 col-sm-8 np">
					<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete" 
						    value="Multidelete" name="in_delete">
						<i class="fa fa-trash-o" aria-hidden="true"></i> Delete
					</button>	
				</div>
				<div class="col-xs-12 col-sm-4">
					<div class="col-xs-12 np text-right">
						<div class="input-group">				  
							<input class="form-control" id="searchall" type="text" name="searchall" placeholder="Search">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-search"></span>
							</span>
						</div>		   				    
					</div>
				</div>
			</div>
			<table class="table table-hover table-striped tblcontents tbl-sent-messages" id="sentmsgstable">
				<thead>
					<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
					<th>Sender</th>
					<th class="desc">Message</th>	
					<th>Recipient/s</th>
					<th>SMS Medium</th>
					<th>Logs</th>
					<th>Sent At</th>
				</thead>
				<tbody>
					@include('pages.deletedialogsent')
				</tbody>
			</table>
		</div>
	</form>
</div>
@stop