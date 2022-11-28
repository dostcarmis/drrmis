@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Fire Reports</h1>
	</div>
</div>
<div class="row">
	<form action="{{action('FloodController@destroymultipleFloods')}}">
		<div class="col-xs-12">
			<p style="color:green"><?php echo Session::get('message'); ?></p>
			<div class="col-xs-12 ulpaginations np">
				<div class="col-xs-12 col-sm-8 np">
					<a id="btnadd-location" title="Add Flood" class="btnadd-location btn" href="{{ action('FiresController@viewaddFire') }}"><span class="glyphicon glyphicon-plus"></span> Add Fire Report</a>
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

			<table class="table table-hover table-striped tblcontents tbl-floods"  id="dashboardtables">
				<thead>
					<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
					<th class="desc">Location</th>
					<th>Province</th>	
					<th>Rainfall</th>
					<th>Latitude</th>
					<th>Longitude</th>
					<th>Source</th>
					<th>Date</th>
				</thead>
				<tbody>
				@foreach($floods as $flood)
					<tr>						
						<td>
						@if((Auth::user()->id == $flood->created_by) || (Auth::user()->role_id <= 3))
						<input class="chbox" name="chks[]" value="{{$flood->id}}"  type="checkbox"></td>
						@else
						<input type="checkbox" disabled></td>
						@endif
						<td>

						@if((Auth::user()->id == $flood->created_by) || (Auth::user()->role_id <= 3))
							<a class="desctitle" href="<?php echo url('viewperflood'); ?>/<?php echo $flood->id?>">{{ $flood->road_location }}</a>
						@else
						<a class="desctitle" href="<?php echo url('editflood'); ?>/<?php echo $flood->id?>">{{ $flood->road_location }}</a>
						@endif

							@if($flood->report_status != "Published")
								<span class="repstat">— {{$flood->report_status}}</span>
							@endif
							<span class="defsp spactions">
								<div class="inneractions">
								@if((Auth::user()->id == $flood->created_by) || (Auth::user()->role_id <= 3))
									<a href="<?php echo url('editflood'); ?>/<?php echo $flood->id; ?>">Edit</a> | 
									<a class="deletepost" href="#" id="{{$flood->id}}" value="{{$flood->id}}" title="Delete">Delete</a> | 
								@endif
									<a href="<?php echo url('viewperflood'); ?>/<?php echo $flood->id;  ?>">Preview</a> 
								</div>								
							</span>
						</td>

						<td>
							@foreach($provinces as $province)
							@if($province->id == $flood->province_id)
								{{ $province->name }}
							@endif
							@endforeach					
						</td>						
						<td>{{$flood->past_rainvalue }}</td>
						<td>{{$flood->latitude}}</td>
						<td>{{$flood->longitude}}</td>						
						<td>{{$flood->author}}</td>
						<td><?php echo date("F j, Y g:i A", strtotime($flood->date));?>
							</td>
					</tr>
					@endforeach
					@include('pages.deletedialogflood')
				</tbody>
			</table>
		</div>
	</form>
</div>
 @stop

