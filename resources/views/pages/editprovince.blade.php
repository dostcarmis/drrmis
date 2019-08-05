@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Province</h1>
	</div>
</div>
<p style="color:red">{{ $errors->first('name') }}</p>

<form id="editform" action="{{ action('ProvinceController@updateProvince') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $row->id ?>">	
	<div class="col-xs-12 perinputwrap">
		<label>Province Name</label>
		<input type="text" name="province_name" id="category_name" class="form-control" placeholder="Province Name" value="<?= $row->name ?>">
	</div>	
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update Province</a>
	<a class="btn btn-updatelocation" href="{{ action("ProvinceController@viewProvince") }}">Cancel</a> 
	@include('pages.editdialogprovince')
	</div>

</form>
 @stop