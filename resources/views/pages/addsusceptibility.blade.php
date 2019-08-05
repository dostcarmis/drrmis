@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Susceptibility Value</h1>
	</div>
</div>
<p style="color:red"><?php echo Session::get('message'); ?></p>
<form id="category-form" action="{{ action('SusceptibilityController@saveSusceptibility') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 col-sm-6 perinputwrap">
		{!! Form::label('address','Select Address:') !!}
		<select name="address_id" class="form-control">
			@foreach($sensors as $sensor)
			<option value="{{ $sensor->id }}">{{ $sensor->address }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		{!! Form::label('address','Landslide Level:') !!}
		<select name="landslide" class="form-control">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		{!! Form::label('address','Flood Level:') !!}
		<select name="flood" class="form-control">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
	</div>
	
	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Susceptibility" class="btn btn-addlocation">
	<a class="btn btn-updatelocation" href="{{ action("SusceptibilityController@viewSusceptibility") }}">Cancel</a> </div>
{!! Form::close() !!}
@stop
