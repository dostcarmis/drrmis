@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Threshold</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach
<?php
	$categorytype = 0;
?>
<form id="editform" action="{{ action('ThresholdController@updateThreshold') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $threshold->id ?>">	
	<div class="col-xs-12 col-sm-12 perinputwrap">
		{!! Form::label('address','Address:') !!}
		@foreach($sensors as $sensor)
			@if($sensor->id === $threshold->address_id)
				<span class="defsp spThreshtitle">{{ $sensor->address }}</span>
				@foreach($categories as $category)
					@if($category->id === $sensor->category_id)
						<span class="defsp spSensortype">{{ $category->name }}</span>
						<?php $categorytype = $sensor->category_id; ?>
					@endif
				@endforeach				
			@endif
		@endforeach	

	</div>
	@if(($categorytype == 1) || ($categorytype == 4))
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Landslide Warning Value (mm):</label>
		<input id="threshold_landslide" type="text" placeholder="e.g. 100" value="<?= $threshold->threshold_landslide ?>" class="form-control" name="threshold_landslide">
		@if ($errors->has('threshold_landslide')) <span class="reqsymbol">*</span> @endif
	</div>
	@elseif(($categorytype == 2))
	<div id="waterlevel-thresh-wrap" class="col-xs-12 np waterlevel-thresh">
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Normal Value (m):</label>
			<input id="waternormalvalue" type="text" placeholder="e.g. 100" value="<?= $threshold->normal_val ?>" class="form-control" name="waternormalvalue">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Level 1 Value (m):</label>
			<input id="waterlevel1value" type="text" placeholder="e.g. 100" value="<?= $threshold->level1_val ?>"  class="form-control" name="waterlevel1value">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Level 2 Value (m):</label>
			<input id="waterlevel2value" type="text" placeholder="e.g. 100" value="<?= $threshold->level2_val ?>"  class="form-control" name="waterlevel2value">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Critical Value (m):</label>
			<input id="watercriticalvalue" type="text" placeholder="e.g. 100" value="<?= $threshold->critical_val ?>"  class="form-control" name="watercriticalvalue">
		</div>
	</div>
	@else
	<div id="waterlevel-thresh-wrap" class="col-xs-12 np waterlevel-thresh">
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Normal Value (m):</label>
			<input id="waternormalvalue" type="text" placeholder="e.g. 100" value="<?= $threshold->normal_val ?>" class="form-control" name="waternormalvalue">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Level 1 Value (m):</label>
			<input id="waterlevel1value" type="text" placeholder="e.g. 100" value="<?= $threshold->level1_val ?>"  class="form-control" name="waterlevel1value">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Level 2 Value (m):</label>
			<input id="waterlevel2value" type="text" placeholder="e.g. 100" value="<?= $threshold->level2_val ?>"  class="form-control" name="waterlevel2value">
		</div>
		<div class="col-xs-12 col-sm-3 perinputwrap">
			<label>Critical Value (m):</label>
			<input id="watercriticalvalue" type="text" placeholder="e.g. 100" value="<?= $threshold->critical_val ?>"  class="form-control" name="watercriticalvalue">
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 perinputwrap">
		<label>Landslide Warning Value (mm):</label>
		<input id="threshold_landslide" type="text" placeholder="e.g. 100" value="<?= $threshold->threshold_landslide ?>" class="form-control" name="threshold_landslide">
		@if ($errors->has('threshold_landslide')) <span class="reqsymbol">*</span> @endif
	</div>
	@endif
	

	

	<div class="col-xs-12 col-sm-6 perinputwrap dates">
		<label>Date:</label>
		<div class="input-group date dates" data-provide="datepicker">
		    <input id="threshold_date" placeholder="Date" name="threshold_date" value="<?= $threshold->threshold_date ?>" type="text" class="form-control threshold_date">
		    <div class="input-group-addon">
		        <span class="glyphicon glyphicon-th"></span>
		    </div>
		</div>
		@if ($errors->has('threshold_date')) <span class="reqsymbol">*</span> @endif
	</div>
	
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update Threshold</a>
	<a class="btn btn-cancel" href="{{ action("ThresholdController@viewThreshold") }}">Cancel</a> 
	@include('pages.editthresholddialog')
	</div>
</form>
 @stop