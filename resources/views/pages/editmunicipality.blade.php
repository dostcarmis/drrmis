@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Municipality</h1>
	</div>
</div>
<p style="color:red">{{ $errors->first('province_name') }}</p>

<form id="editform" action="{{ action('MunicipalityController@updateMunicipality') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $row->id ?>">	
	<div class="col-xs-12 perinputwrap">
		<label>Municipality Name</label>
		<input type="text" name="municipality_name" id="municipality_name" class="form-control" placeholder="Enter Municipality . . ." value="<?= $row->name ?>">
	</div>	
	<div class="col-xs-12 col-sm-12 perinputwrap">
		{!! Form::label('province','Select Province:') !!}
		<select name="province_id" class="form-control">
			@foreach($provinces as $province)
				@if($row->province_id === $province->id)
					<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>
					@else
					<option value="{{ $province->id }}">{{ $province->name }}</option>
				@endif	
			@endforeach
		</select>
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update Municipality</a>
	<a class="btn btn-updatelocation" href="{{ action("MunicipalityController@viewMunicipality") }}">Cancel</a> 
	</div>
	@include('pages.editdialogmunicipality')
</form>
 @stop