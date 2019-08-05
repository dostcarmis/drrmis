@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Typhoon Track</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<form id="hazard-form" action="{{action('TyphoontrackController@updateTyphoonTrack')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="<?= $typhoontracks->id ?>">		
	<div class="col-xs-12 col-sm-3 perinputwrap">
		<label>Status</label>
		<select name="typhoonstat" id="typhoonstat" class="form-control">
			@if($typhoontracks->typhoonstat == 0)
				<option value="0" selected="selected">Inactive</option>
				<option value="1">Active</option>
			@else
				<option value="0">Inactive</option>
				<option value="1" selected="selected">Active</option>
			@endif
		</select>
	</div>	
	<div class="col-xs-12 col-sm-12 perinputwrap">
		<label>Typhoon Name</label>
		<input type="text" name="name" value="<?= $typhoontracks->typhoonName ?>" class="form-control" placeholder="Enter Typhoon Name">	
		@if ($errors->has('name')) <span class="reqsymbol">*</span> @endif
	</div>	

	<div class="col-xs-12 col-sm-9 perinputwrap kmltype">
		<label>KML File</label>
		<div class="input-group">
		  <span class="input-group-btn">
		    <a id="typhoon" data-input="kmlfilepreview" data-preview="holder" class="btn btn-uploadfileimage btn-primary">
		      <i class="fa fa-file-o"></i> Choose
		    </a>
		  </span>
		  <input id="kmlfilepreview" class="form-control" type="text" value="<?= $typhoontracks->typhoonpath ?>" name="typhoon">
		</div>
	</div>
	
	
	
	<div class="col-xs-12 perinputwrap text-right">
		<input type="submit" value="Update Typhoon Track" class="btn btn-addlocation">
		<a class="btn btn-cancel" href="{{ action('TyphoontrackController@viewTyphoonTracks') }}">Cancel</a> 
		@include('pages.editdialogtyphoon')
	</div>
{!! Form::close() !!}
@stop
 @section('page-js-files')
<script src="{{asset('vendor/laravel-filemanager/js/lfm.js')}}"></script>
<script type="text/javascript">
	jQuery(function($){
		$('#typhoon').filemanageredit('file');
	});
</script>
@endsection