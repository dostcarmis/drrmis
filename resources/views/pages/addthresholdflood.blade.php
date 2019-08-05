@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Flood Threshold</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="category-form" action="{{action('ThresholdFlood@saveThresholdFlood')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 np sourcewrap">
		<div class="col-xs-12 perinputwrap">
			{!! Form::label('address','Select Source:') !!}
		</div>
		<div class="col-xs-12 np inputswrapper">
			<div class="col-xs-12 col-sm-8 perinputwrap mainselect">		
				<select name="address_id[]" id="address_id" class="form-control">
					@foreach($sensors as $sensor)
					<option value="{{ $sensor->id }}">{{ $sensor->address }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-12 col-sm-3 perinputwrap maininput">
				<input id="threshold_flood" type="text" placeholder="Flood Value" class="form-control" name="threshold_flood[]">
				@if ($errors->has('threshold_flood')) <span class="reqsymbol">*</span> @endif
			</div>
		</div>
		<div class="col-xs-12 btnaddmoresource-wrap">
			<a href="#" class="btn btn-primary btnaddmoresource">+ Add more Source</a>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap">
		<label>Affected Areas:</label>
		<select id="affected_areas" class="contacts" name="affected_areas[]" placeholder="Pick some people..."></select>
  		
		@if ($errors->has('affected_areas')) <span class="reqsymbol">*</span> @endif
	</div>

	
	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Threshold" class="btn btn-addlocation">
	<a class="btn btn-updatelocation" href="{{ action("ThresholdFlood@viewThresholdFlood") }}">Cancel</a> </div>
{!! Form::close() !!}
@stop
@section('page-js-files')
<script type="text/javascript" src="{!! url('js/selectize.js') !!}"></script>
<script type="text/javascript" src="{!! url('assets/js/floodthreshold.js') !!}"></script>
@endsection