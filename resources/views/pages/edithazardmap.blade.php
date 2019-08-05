@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Hazard Map</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<form id="hazard-form" action="{{action('HazardmapsController@updateHazardmap')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="<?= $hazardmaps->id ?>">		
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Status</label>
		<select name="hazardstatus" id="hazardstatus" class="form-control">
			@if($hazardmaps->status == 0)
				<option value="0" selected="selected">Inactive</option>
				<option value="1">Active</option>
			@else
				<option value="0">Inactive</option>
				<option value="1" selected="selected">Active</option>
			@endif
		</select>
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Hazard Map Category</label>
		<select name="hazardcategory" id="hazardcategory" class="form-control">
			@if($hazardmaps->category_id == 1)
			<option value="1" selected="selected">MGB</option>
			<option value="2">NOAH</option>
			<option value="3">Phivolcs</option>
			<option value="4">DREAM / LiPAD</option>
			@elseif($hazardmaps->category_id == 2)
			<option value="1">MGB</option>
			<option value="2" selected="selected">NOAH</option>
			<option value="3">Phivolcs</option>
			<option value="4">DREAM / LiPAD</option>
			@elseif($hazardmaps->category_id == 3)
			<option value="1">MGB</option>
			<option value="2">NOAH</option>
			<option value="3" selected="selected">Phivolcs</option>
			<option value="4">DREAM / LiPAD</option>
			@else
			<option value="1">MGB</option>
			<option value="2">NOAH</option>
			<option value="3">Phivolcs</option>
			<option value="4"  selected="selected">DREAM / LiPAD</option>
			@endif
		</select>
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap">
		<label>Title</label>
		<input type="text" name="name" value="<?= $hazardmaps->name ?>" class="form-control" placeholder="Enter Hazard Map Title">	
		@if ($errors->has('name')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Province:</label>
		<select name="province_idedit" id="province_idedit" class="form-control">
			@foreach($provinces as $province)				
				@if($hazardmaps->province_id == $province->id)
				<option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>
				@else
				<option value="{{ $province->id }}">{{ $province->name }}</option>
				@endif		
			@endforeach
		</select>
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Municipality:</label>
		<select name="municipality_idedit"  id="municipality_idedit" class="form-control">	
			@foreach($municipalities as $municipality)				
				@if($hazardmaps->municipality_id == $municipality->id)
				<option selected="selected" value="{{ $municipality->id }}">{{ $municipality->name }}</option>
				@else
				<option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
				@endif		
			@endforeach	
		</select>
	</div>
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Overlay Type</label>
		<select name="overlaytype" id="overlaytype" class="form-control">
			@if($hazardmaps->overlaytype == 'imagetype')
			<option value="kmlfile">KML File</option>
			<option value="imagetype"  selected="selected">Image File</option>
			@else
			<option value="kmlfile" selected="selected">KML File</option>
			<option value="imagetype">Image File</option>
			@endif
			
		</select>
	</div>
	@if($hazardmaps->overlaytype == 'imagetype')
	<div class="col-xs-12 col-sm-9 perinputwrap kmltype hidden">
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
	<div class="col-xs-12 col-sm-12 perinputwrap imagetype">
		<label>Image File</label>
		<div class="input-group">
		  <span class="input-group-btn">
		    <a id="kmlimagefile" data-input="kmlimage" data-preview="holder" class="btn btn-uploadfileimage btn-primary">
		      <i class="fa fa-file-o"></i> Choose
		    </a>
		  </span>
		  <input id="kmlimage" class="form-control" value="{{$hazardmaps->hazardmap}}" type="text" name="kmlimagefile">
		</div>
		<label>Image Boundary</label>
		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="north"  class="form-control"  value="{{ $hazardmaps->north }}" placeholder="North Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="south"  class="form-control"  value="{{ $hazardmaps->south }}" placeholder="South Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="east"  class="form-control"  value="{{ $hazardmaps->east }}" placeholder="East Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="west"  class="form-control"   value="{{ $hazardmaps->west }}" placeholder="West Coordinates">
			</div>
		</div>
	</div>
	@else
	<div class="col-xs-12 col-sm-9 perinputwrap kmltype">
		<label>KML File</label>
		<div class="input-group">
		  <span class="input-group-btn">
		    <a id="kmlfile" data-input="kmlfilepreview" data-preview="holder" class="btn btn-uploadfileimage btn-primary">
		      <i class="fa fa-file-o"></i> Choose
		    </a>
		  </span>
		  <input id="kmlfilepreview" value="{{$hazardmaps->hazardmap}}" class="form-control" type="text" name="kmlfile">
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
		  <input id="kmlimage" class="form-control"  type="text" name="kmlimagefile">
		</div>
		<label>Image Boundary</label>
		<div class="row">
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="north"  class="form-control"  placeholder="North Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="south"  class="form-control"  placeholder="South Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="east"  class="form-control"  placeholder="East Coordinates">
			</div>
			<div class="col-xs-12 col-sm-3">
				<input type="text" name="west"  class="form-control"  placeholder="West Coordinates">
			</div>
		</div>
	</div>
	@endif
	
	<div class="col-xs-12 perinputwrap text-right">
		<input type="submit" value="Update Hazard Map" class="btn btn-addlocation">
		<a class="btn btn-cancel" href="{{ action('HazardmapsController@viewHazardmaps') }}">Cancel</a> 
		@include('pages.editdialoghazardmap')
	</div>
{!! Form::close() !!}
@stop
 @section('page-js-files')
<script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}"></script>
<script type="text/javascript">
	jQuery(function($){
		$('#kmlfile').filemanageredit('file');
		$('#kmlimagefile').filemanageredit('file');
	});
</script>
@endsection