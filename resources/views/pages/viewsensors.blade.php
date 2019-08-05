@extends('layouts.masters.backend-layout')
@section('page-content')


<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Sensors </h1>
	</div>
	
	<form action="{{ action("SensorsController@destroymultipleSensors") }}">
	<div class="col-xs-12">
		<p style="color:red"><?php echo Session::get('message'); ?></p>	
		<div class="col-xs-12 ulpaginations np">
			<div class="col-xs-12 col-sm-8 np">
				<a id="btnadd-location" title="Add Sensor" class="btnadd-location btn" href="{{ action("SensorsController@viewaddSensor") }}"><span class="glyphicon glyphicon-plus"></span> Add Sensor</a>
				<input disabled="disabled" type="submit" value="Delete" name="deletemultiple" class="btn btn-deleteselected" title="Delete">			
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
		<table class="table table-hover tblcontents table-striped tbl-sensors"  id="dashboardtables">
			<thead>
				<th class="no-sort"><input type="checkbox" class="headcheckbox"></th>
				<th>ID</th>
				<th class="desc">Address</th>
				<th>Province</th>
				<th>Municipality</th>
				<th>Sensor Type</th>
				<th>Latitude</th>
				<th>Longitude</th>
			</thead>
			<tbody>					
				@foreach($sensors as $sensor)
				<tr>

					<td><input class="chbox" name="chks[]" value="{{$sensor->id}}"  type="checkbox"></td>
					<td>{{$sensor->dev_id}}</td>
					<td>
						<a class="desctitle" href="<?php echo url('editsensor'); ?>/<?php echo $sensor->id?>">{{ $sensor->address }}</a>
						<span class="defsp spactions">
							<div class="inneractions">
								<a href="<?php echo url('editsensor'); ?>/<?php echo $sensor->id; ?>">Edit</a> | 
								<a class="deletepost" href="#" id="{{$sensor->id}}" value="{{$sensor->id}}" title="Delete">Delete</a>
							</div>								
						</span>
					</td>
					<td>
					@foreach($provinces as $province)
					@if($sensor->province_id === $province->id)
						{{ $province->name}}
					@endif				
					@endforeach
					</td>
					<td>
					@foreach($municipalities as $municipality)
					@if($sensor->municipality_id === $municipality->id)
						{{ $municipality->name}}
					@endif				
					@endforeach
					</td>
					<td>
					@foreach($categories as $category)
					@if($sensor->category_id === $category->id)
						{{ $category->name }}
					@endif				
					@endforeach					
					</td>

					<td>{{ $sensor->latitude }}</td>
					<td>{{ $sensor->longitude }}</td>

				</tr>

				@endforeach		
				@include('pages.dialog')
			
			</tbody>
		</table>
	</div>
	</form>
</div>

 @stop
