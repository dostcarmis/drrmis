@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Road Closures</h1>
	</div>
	<form action="{{ action('RoadController@destroymultipleRoadnetworks')}}">
		<div class="col-xs-12">
			<p style="color:green"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 ulpaginations np">
				<div class="col-xs-12 col-sm-8 np">
					<a id="btnadd-location" title="Add Road Network" class="btnadd-location btn" href="{{ action("RoadController@viewaddRoadnetwork") }}"><span class="glyphicon glyphicon-plus"></span> Add Road Report</a>

	<button disabled="disabled" type="submit" class="btn btn-deleteselected" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
				
				</div>
				<div class="col-xs-12 col-sm-4">
					<div class="col-xs-12 np text-right">
						<div class="input-group">				  
							  <input class="form-control" id="searchall" type="text" name="searchall" placeholder="Search">
							  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
							</div>
			   				    
			    	</div>
				</div>
			</div>
			<table class="table table-hover tblcontents tbl-roadnetworks" id="dashboardtables">
				<thead>
					<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
					<th class="desc">Location</th>		
					<th>Source</th>							
					<th>Road Status</th>
					<th>Date</th>			
					
				</thead>
				<tbody>
				@foreach($roadnetworks as $roadnetwork)
					<tr>						
						<td>
						@if((Auth::user()->id == $roadnetwork->user_id) || (Auth::user()->role_id <= 3))
						<input class="chbox" name="chks[]" value="{{$roadnetwork->id}}"  type="checkbox">
						@else
						<input disabled type="checkbox">
						@endif
						</td>
						<td>
						@if((Auth::user()->id == $roadnetwork->user_id) || (Auth::user()->role_id <= 3))
						<a class="desctitle" href="<?php echo url('editroadnetwork'); ?>/<?php echo $roadnetwork->id?>">{{ $roadnetwork->location }}</a>
						@else
						{{ $roadnetwork->location }}
						@endif
						@if($roadnetwork->latest_status == "Open")
							<span class="repcleared">— Cleared <span><?php echo date("F j, Y g:i A", strtotime($roadnetwork->recent_date));?></span></span>
						@endif
						@if((Auth::user()->id == $roadnetwork->user_id) || (Auth::user()->role_id <= 3))
						<span class="defsp spactions">
							<div class="inneractions">
								<a href="<?php echo url('editroadnetwork'); ?>/<?php echo $roadnetwork->id; ?>">Edit</a> | 
								<a class="deletepost" href="#" id="{{$roadnetwork->id}}" value="{{$roadnetwork->id}}">Delete</a>
							</div>								
						</span>
						@endif
						</td>		
						<td>{{$roadnetwork->author}}</td>				
						<td>{{$roadnetwork->status}}</td>
						<td><?php echo date("F j, Y g:i A", strtotime($roadnetwork->date));?>
						</td>					
					</tr>
					@endforeach
					@include('pages.deletedialogroadnetwork')
				</tbody>
			</table>
		</div>
	</form>
</div>
 @stop
