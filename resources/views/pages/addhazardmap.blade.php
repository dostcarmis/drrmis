@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Hazard Map</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="hazard-form" action="{{action('HazardmapsController@saveHazardmap')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Status</label>
		<select name="hazardstatus" id="hazardstatus" class="form-control">
			<option value="0">Inactive</option>
			<option value="1">Active</option>
		</select>
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Hazard Map Category</label>
		<select name="hazardcategory" id="hazardcategory" class="form-control">
			<option value="1">MGB</option>
			<option value="2">NOAH</option>
			<option value="3">Phivolcs</option>
			<option value="4">DREAM / LiPAD</option>
		</select>
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap">
		<label>Title</label>
		<input type="text" name="name"  class="form-control" placeholder="Enter Hazard Map Title">	
		@if ($errors->has('name')) <span class="reqsymbol">*</span> @endif
	</div>	
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Province:</label>
		<select name="province_id" id="province_id" class="form-control">
			<option>Select Province</option>
				@foreach($provinces as $province)
					<option value="{{ $province->id }}">{{ $province->name }}</option>
				@endforeach
		</select>
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Municipality:</label>
		<select name="municipality_id"  id="municipality_id" class="form-control" disabled="disabled">		
		</select>
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Overlay Type</label>
		<select name="overlaytype" id="overlaytype" class="form-control">
			<option value="kmlfile" selected="selected">KML File</option>
			<option value="imagetype">Image File</option>
		</select>
	</div>
	<div class="col-xs-12 col-sm-9 perinputwrap kmltype">
		<label>KML File</label>
		<div class="input-group">
		  <span class="input-group-btn">
		    <a id="kmlfile" data-input="kmlfilepreview" data-preview="holder" class="btn btn-uploadfileimage btn-primary">
		      <i class="fa fa-file-o"></i> Choose
		    </a>
		  </span>
		  <input id="kmlfilepreview" class="form-control" type="text" name="kmlfile">
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap imagetype hidden">
		<label>Image File</label>
		<div class="input-group">
		  <span class="input-group-btn">
		    <a id="kmlimagefile" data-input="kmlimage" data-preview="holder" class="btn btn-uploadfileimage btn-primary">
		      <i class="fa fa-file-o"></i> Choose
		    </a>
		  </span>
		  <input id="kmlimage" class="form-control" type="text" name="kmlimagefile">
		</div>
		<label>Image Boundary</label>
		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="north"  class="form-control" placeholder="North Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="south"  class="form-control" placeholder="South Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="east"  class="form-control" placeholder="East Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="west"  class="form-control" placeholder="West Coordinates">
			</div>
		</div>
	</div>

	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Hazard Map" class="btn btn-addlocation">
	<a class="btn btn-cancel" href="{{action('HazardmapsController@viewHazardmaps')}}">Cancel</a> </div>
{!! Form::close() !!}
@stop
 @section('page-js-files')
<script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}"></script>
<script type="text/javascript">
	jQuery(function($){
		$('#kmlfile').filemanager('file');
		$('#kmlimagefile').filemanager('file');
	});
</script>
@endsection