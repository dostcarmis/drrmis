@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Accident Report</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<p style="color:#00CA00"><?php echo Session::get('message'); ?></p>
<form id="userform" action="{{action('FloodproneareasController@updateFloodproneArea')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="<?= $floodproneareas->id ?>">	
	<div class="col-xs-12 perinputwrap">
		<label>Address:</label>
		<input type="text" name="address" id="address" value="<?= $floodproneareas->address ?>" class="form-control" placeholder="Enter Flood-prone Area">
		@if ($errors->has('address')) <span class="reqsymbol">*</span> @endif
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		{!! Form::label('province','Province:') !!}
		<select name="province_idedit" id="province_idedit"class="form-control">
			@foreach($provinces as $province)
				@if($floodproneareas->province_id === $province->id)
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
			@if($municipality->province_id === $floodproneareas->province_id)
				@if($floodproneareas->municipality_id === $municipality->id)
					<option selected="selected" value="{{ $municipality->id }}">{{ $municipality->name }}</option>
				@else
					<option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
				@endif	
			@endif				
		@endforeach
		</select>
	</div>
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update</a>
	<a class="btn btn-cancel" href="{{ action("FloodproneareasController@viewFloodproneAreas") }}">Cancel</a> 
	@include('pages.editfloodproneareadialog')
	</div>

</form>
 @stop