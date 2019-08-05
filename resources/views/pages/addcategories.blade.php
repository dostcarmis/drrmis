@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Category</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="category-form" action="{{ action('CategoriesController@saveCategory') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 perinputwrap">
		<label>Sensor Category Name</label>
		<input id="category_name" placeholder="e.g. Automated Rain Gauges" type="text" class="form-control" name="category_name">		
		@if ($errors->has('category_name')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Category" class="btn btn-addlocation">
	<a class="btn btn-updatelocation" href="{{ action("CategoriesController@viewCategories") }}">Cancel</a> </div>
{!! Form::close() !!}
@stop
