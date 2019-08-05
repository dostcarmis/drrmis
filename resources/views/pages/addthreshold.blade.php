@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Add Threshold Value</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<form id="category-form" action="{{ action('ThresholdController@saveThreshold') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="col-xs-12 col-sm-12 perinputwrap">
		{!! Form::label('address','Select Address:') !!}
		<select name="address_id" id="threshold_opt" class="form-control">

			@foreach($sensors as $sensor)

					<?php 
						$val = "";
						if(($sensor->category_id == 1) || ($sensor->category_id == 4)){
							$val = 'Rain Gauge';
						}else if($sensor->category_id == 2){
							$val = 'Waterlevel';
						}else{
							$val = 'Tandem';
				 		}
				 	?>	
				 	<option value="{{ $sensor->id }}" data-categoryid="{{$sensor->category_id}}">{{ $sensor->address }} - {{$val}}</option>

			@endforeach

		</select>
		<span class="defsp spsensorcat"></span>
	</div>
	<div id="waterlevel-thresh-wrap" class="col-xs-12 np waterlevel-thresh hidden">
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Normal Value (m):</label>
			<input id="waternormalvalue" type="text" placeholder="e.g. 100" class="form-control" name="waternormalvalue">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Level 1 Value (m):</label>
			<input id="waterlevel1value" type="text" placeholder="e.g. 100" class="form-control" name="waterlevel1value">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Level 2 Value (m):</label>
			<input id="waterlevel2value" type="text" placeholder="e.g. 100" class="form-control" name="waterlevel2value">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Critical Value (m):</label>
			<input id="watercriticalvalue" type="text" placeholder="e.g. 100" class="form-control" name="watercriticalvalue">
		</div>
	</div>

	<div id="rain-thresh-wrap" class="col-xs-12 col-sm-6 perinputwrap">
		<label>Landslide Warning Value (mm):</label>
		<input id="threshold_landslide" type="text" placeholder="e.g. 100" class="form-control" name="threshold_landslide">
	</div>
	
	<div class="col-xs-12 col-sm-6 perinputwrap dates">
		<label>Date:</label>
		<div class="input-group date dates" data-provide="datepicker">
		    <input id="threshold_date" placeholder="Date" name="threshold_date" type="text" class="form-control threshold_date">
		    <div class="input-group-addon">
		        <span class="glyphicon glyphicon-th"></span>
		    </div>
		</div>
		@if ($errors->has('threshold_date')) <span class="reqsymbol">*</span> @endif
	</div>
	
	<div class="col-xs-12 perinputwrap text-right">
	<input type="submit" value="Save Threshold" class="btn btn-addlocation">
	<a class="btn btn-cancel" href="{{ action("ThresholdController@viewThreshold") }}">Cancel</a> </div>
{!! Form::close() !!}
@stop
