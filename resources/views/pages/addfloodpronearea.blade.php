@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Flood-prone Area</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="hazard-form" action="{{action('FloodproneareasController@saveFloodproneArea')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 col-sm-12 perinputwrap">
		<label>Address: </label>
		<input type="text" name="address"  class="form-control" placeholder="Enter Flood-prone Area">	
		@if ($errors->has('address')) <span class="reqsymbol">*</span> @endif
	</div>	
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Province:</label>
		<select name="province_id" id="province_id" class="form-control">
			<option>Select Province</option>
				@foreach($provinces as $province)
					<option value="{{ $province->id }}">{{ $province->name }}</option>
				@endforeach
		</select>
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Municipality:</label>
		<select name="municipality_id"  id="municipality_id" class="form-control" disabled="disabled">		
		</select>
	</div>
	

	<div class="col-xs-12 perinputwrap text-right">
		<input type="submit" value="Save Flood-prone Area" class="btn btn-addlocation">
		<a class="btn btn-cancel" href="{{action('FloodproneareasController@viewFloodproneAreas')}}">Cancel</a> 
	</div>
{!! Form::close() !!}
@stop
