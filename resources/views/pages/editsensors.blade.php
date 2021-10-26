@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Sensor</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
	<p class="alert alert-{{$message}}">{{ Session::get('alert-' . $message) }}</p>
@endforeach




<form id="editform" action="{{ action('SensorsController@updateSensor') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $sensors->id ?>">	
	<div class="col-xs-12 perinputwrap">
		<label>Device ID:</label>
		<div class="col-xs-12 col-sm-3 np">
			<input value="<?= $sensors->dev_id ?>" type="text" placeholder="Device ID" class="form-control" name="dev_id" id="dev_id"/>
		</div>
	</div>
	<div class="col-xs-12 perinputwrap">
		<label>Sensor</label>
		<input type="text" name="address" id="address" class="form-control" placeholder="Address" value="<?= $sensors->address ?>">
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		{!! Form::label('province','Province:') !!}
		<select name="province_idedit" id="province_idedit"class="form-control">
			@foreach($provinces as $province)
				@if($sensors->province_id === $province->id)
					<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>
					@else
					<option value="{{ $province->id }}">{{ $province->name }}</option>
				@endif	
			@endforeach
		</select>
	</div>



	<div class="col-xs-12 col-sm-6 perinputwrap">
		{!! Form::label('municality','Municipality:') !!}
		<select name="municipality_idedit"  id="municipality_idedit" class="form-control">
		@foreach($municipalities as $municipality)
			@if($municipality->province_id === $sensors->province_id)
				@if($sensors->municipality_id === $municipality->id)
					<option selected="selected" value="{{ $municipality->id }}">{{ $municipality->name }}</option>
				@else
					<option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
				@endif	
			@endif				
		@endforeach
		</select>
	</div>
	<div class="col-xs-12 np">
		<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Sensor Category:</label>
		<select name="category_id" class="form-control">
			@foreach($categories as $category)
				@if($sensors->category_id === $category->id)
				<option selected="selected" value="{{ $category->id }}">{{ $category->name }}</option>
				@else
				<option value="{{ $category->id }}">{{ $category->name }}</option>
				@endif		
			@endforeach
		</select>
	</div>
	</div>

	<div class="col-xs-12 col-sm-6 perinputwrap">
	<label>Latitude</label>
		<input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" value="<?= $sensors->latitude ?>">
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
	<label>Longitude</label>
	<input type="text" name="longitude" id="longitude" class="form-control" placeholder="longitude" value="<?= $sensors->longitude ?>">
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap">
	<label>Associated File</label>
	<input type="text" name="assoc_file" id="assoc_file" class="form-control" placeholder="file associated" value="<?= $sensors->assoc_file ?>">
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap">
	{!! Form::label('remarks','Remarks:') !!}
		<textarea  id="remarks" type="text" placeholder="Sensor remarks" class="form-control" name="remarks"><?= $sensors->remarks ?></textarea>
		@if ($errors->has('remarks')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update Sensor</a>
	<a class="btn btn-cancel" href="{{ action("SensorsController@viewSensor") }}">Cancel</a> 
	@include('pages.editdialog')
	</div>


</form>

 @stop