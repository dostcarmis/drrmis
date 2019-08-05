@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Province</h1>
	</div>
</div>
<p style="color:red">{{ $errors->first('province_name') }}</p>

<form id="category-form" action="{{ action('ProvinceController@saveProvince') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 perinputwrap">
		<label>Province Name</label>
		<input id="province_name" placeholder="Enter Province . . ." type="text" class="form-control" name="province_name">		
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Province" class="btn btn-addlocation">
	<a class="btn btn-updatelocation" href="{{ action("CategoriesController@viewCategories") }}">Cancel</a> </div>
{!! Form::close() !!}
@stop
