@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Municipality</h1>
	</div>
</div>
<p style="color:red">{{ $errors->first('municipality_name') }}</p>

<form id="category-form" action="{{ action('MunicipalityController@saveMunicipality') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 perinputwrap">
		<label>Municipality Name</label>
		<input id="municipality_name" placeholder="Enter Municipality . . . " type="text" class="form-control" name="municipality_name">		
	</div>
	<div class="col-xs-12 perinputwrap">
		{!! Form::label('province','Select Province:') !!}
		<select name="province_id" class="form-control">
			@foreach($provinces as $province)
			<option value="{{ $province->id }}">{{ $province->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Municipality" class="btn btn-addlocation">
	<a class="btn btn-updatelocation" href="{{ action("CategoriesController@viewCategories") }}">Cancel</a> </div>
{!! Form::close() !!}
@stop
