@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Hazard</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="category-form" action="{{ action('HazardsController@saveHazard') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 perinputwrap">
		<label>Hazard Name</label>
		<input id="hazard_name" placeholder="e.g. Flood" type="text" class="form-control" name="hazard_name">	
		@if ($errors->has('hazard_name')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 perinputwrap">
		<label>Description</label>
		<textarea  id="hazard_desc" type="text" class="form-control" name="hazard_desc"></textarea>
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Hazard" class="btn btn-addlocation">
	<a class="btn btn-cancel" href="{{ action("HazardsController@viewHazards") }}">Cancel</a> </div>
{!! Form::close() !!}
@stop
