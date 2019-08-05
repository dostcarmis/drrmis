@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Typhoon Track</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="hazard-form" action="{{action('TyphoontrackController@saveTyphoonTrack')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Status</label>
		<select name="typhoonstat" id="typhoonstat" class="form-control">
			<option value="0">Inactive</option>
			<option value="1">Active</option>
		</select>
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap">
		<label>Typhoon Name</label>
		<input type="text" name="name"  class="form-control" placeholder="Enter Typhoon Name">	
	</div>	

	<div class="col-xs-12 col-sm-9 perinputwrap kmltype">
		<label>Upload Kml File</label>
		<div class="input-group">
		  <span class="input-group-btn">
		    <a id="typhoon" data-input="kmlfilepreview" data-preview="holder" class="btn btn-uploadfileimage btn-primary">
		      <i class="fa fa-file-o"></i> Choose
		    </a>
		  </span>
		  <input id="kmlfilepreview" class="form-control" type="text" name="typhoon">
		</div>
	</div>


	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Typhoon" class="btn btn-addlocation">
	<a class="btn btn-cancel" href="{{action('TyphoontrackController@viewTyphoonTracks')}}">Cancel</a> </div>
{!! Form::close() !!}
@stop
 @section('page-js-files')
<script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}"></script>
<script type="text/javascript">
	jQuery(function($){
		$('#typhoon').filemanager('file');
	});
</script>
@endsection