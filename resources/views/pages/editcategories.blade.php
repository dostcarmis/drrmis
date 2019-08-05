@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Category</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="editform" action="{{ action('CategoriesController@updateCategory') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $row->id ?>">	
	<div class="col-xs-12 perinputwrap">
		<label>Sensor Category Name</label>
		<input type="text" name="category_name" id="category_name" class="form-control" placeholder="e.g. Automated Rain Gauges" value="<?= $row->name ?>">
		@if ($errors->has('category_name')) <span class="reqsymbol">*</span> @endif
	</div>	
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update Category</a>
	<a class="btn btn-updatelocation" href="{{ action("CategoriesController@viewCategories") }}">Cancel</a> 
	@include('pages.editdialogcategories')
	</div>

</form>
 @stop