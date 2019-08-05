@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add New Sensor</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="addsensor-form" action="{{ action('SensorsController@saveSensor') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 perinputwrap">
		{!! Form::label('dev_id','Device ID:') !!}
		<div class="col-xs-12 col-sm-3 np">
			<input type="text" placeholder="e.g. 1234" class="form-control" name="dev_id" id="dev_id"/>
		</div>
		@if ($errors->has('dev_id')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 perinputwrap">
		{!! Form::label('dev_id','Address:') !!}
		<input id="address" placeholder="Enter Sensor Address" type="text" class="form-control" name="address">		
		@if ($errors->has('address')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		{!! Form::label('province','Province:') !!}
		<select name="province_id" id="province_id" class="form-control">
			<option>Select Province</option>
			@foreach($provinces as $province)
			<option value="{{ $province->id }}">{{ $province->name }}</option>
			@endforeach
		</select>
		@if ($errors->has('province_id')) <span class="reqsymbol">*</span> @endif
	</div>


	<div class="col-xs-12 col-sm-6 perinputwrap">
		{!! Form::label('municality','Municipality:') !!}
		<select name="municipality_id"  id="municipality_id" class="form-control" disabled="disabled">
		
		</select>
		@if ($errors->has('municipality_id')) <span class="reqsymbol">*</span> @endif
	</div>

	
	<div class="col-xs-12 np">
		<div class="col-xs-12 col-sm-6 perinputwrap">
			{!! Form::label('sensorcategory','Sensor Category:') !!}
			<select name="category_id" class="form-control">
				@foreach($categories as $category)
				<option value="{{ $category->id }}">{{ $category->name }}</option>
				@endforeach
			</select>

		</div>
	</div>
	
	<div class="col-xs-12 col-sm-6 perinputwrap">
		{!! Form::label('latitude','Latitude:') !!}
		<input id="latitude" type="text" placeholder="e.g. 16.3994746" class="form-control" name="latitude">
		@if ($errors->has('latitude')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
	{!! Form::label('longitude','Longitude:') !!}
		<input id="longitude" type="text" placeholder="e.g. 120.5712656" class="form-control" name="longitude">
		@if ($errors->has('longitude')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap">
	{!! Form::label('remarks','Remarks:') !!}
		<textarea  id="remarks" type="text" placeholder="Sensor remarks" class="form-control" name="remarks"></textarea>
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save" class="btn btn-addlocation">
	<a class="btn btn-cancel" href="{{ action("SensorsController@viewSensor") }}">Cancel</a> </div>
{!! Form::close() !!}

 @stop
