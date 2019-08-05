@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Hazard</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="editform" action="{{ action('HazardsController@updateHazard') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $row->id ?>">	
	<div class="col-xs-12 perinputwrap">
		<label>Name</label>
		<input type="text" name="hazard_name" id="category_name" class="form-control" placeholder="e.g. Flood" value="<?= $row->name ?>">
		@if ($errors->has('category_name')) <span class="reqsymbol">*</span> @endif
	</div>	
	<div class="col-xs-12 perinputwrap">
		<label>Description</label>
		<textarea  id="hazard_desc" type="text" class="form-control" name="hazard_desc"><?= $row->description ?></textarea>
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update Hazard</a>
	<a class="btn btn-cancel" href="{{ action("HazardsController@viewHazards") }}">Cancel</a> 
	@include('pages.editdialoghazard')
	</div>
</form>
 @stop