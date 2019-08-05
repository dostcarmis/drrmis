@extends('layouts.masters.backend-layout')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-header">Edit Flood Threshold</h1>
	</div>
</div>
@foreach ($errors->all() as $message)
    <p style="color:red">{{ $message }}</p>
@endforeach

<?php $affectedareas = unserialize($thresholdflood->areas_affected); ?>
<?php $sourcesensors = unserialize($thresholdflood->sensor_sources); ?>
<p style="color:#00CA00"><?php echo Session::get('message'); ?></p>
<form id="editform" action="{{ action('ThresholdFlood@updateThresholdFlood') }}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="id" value="<?= $thresholdflood->id ?>">	
	<div class="col-xs-12 np sourcewrap">
		<div class="col-xs-12 perinputwrap">
			{!! Form::label('address','Select Source:') !!}
		</div>
		<div class="col-xs-12 np inputswrapper">
		<?php $counter = 0; ?>
			@foreach($sourcesensors as $sourcesensor)
				@foreach($sensors as $sensor)
					@if($sourcesensor[0] == $sensor->id)
						@if($counter == 0)
						<div class="col-xs-12 col-sm-8 perinputwrap mainselect">		
							<select name="address_id[]" id="address_id" class="form-control">
								@foreach($sensors as $sensor)
									@if($sourcesensor[0] == $sensor->id)
									<option selected="selected" value="{{ $sensor->id }}">{{ $sensor->address }}</option>
									@else
									<option value="{{ $sensor->id }}">{{ $sensor->address }}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="col-xs-12 col-sm-3 perinputwrap maininput">
							<input id="threshold_flood" type="text" placeholder="Flood Value" value="<?= $sourcesensor[1]?>" class="form-control" name="threshold_flood[]">
							@if ($errors->has('threshold_flood')) <span class="reqsymbol">*</span> @endif
						</div>
						@else
						<div>
							<div class="col-xs-12 col-sm-8 perinputwrap">		
								<select name="address_id[]" id="address_id" class="form-control">
									@foreach($sensors as $sensor)
										@if($sourcesensor[0] == $sensor->id)
										<option selected="selected" value="{{ $sensor->id }}">{{ $sensor->address }}</option>
										@else
										<option value="{{ $sensor->id }}">{{ $sensor->address }}</option>
										@endif
									@endforeach
								</select>
							</div>
							<div class="col-xs-12 col-sm-3 perinputwrap">
								<input id="threshold_flood" type="text" placeholder="Flood Value" value="<?= $sourcesensor[1]?>" class="form-control" name="threshold_flood[]">
								@if ($errors->has('threshold_flood')) <span class="reqsymbol">*</span> @endif
							</div>
							<div class="col-xs-12 col-sm-1 perinputwrap">
								<a href="#" class="remove_field" title="Remove Source">
									<span class="glyphicon glyphicon-remove"></span>
								</a>
							</div>
						</div>
						@endif
						<?php $counter++;?>
					@endif
				@endforeach
			@endforeach
		</div>
		<div class="col-xs-12 btnaddmoresource-wrap">
			<a href="#" class="btn btn-primary btnaddmoresource">+ Add more Source</a>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 perinputwrap">
		<label>Affected Areas:</label>
		<select id="affected_areas_edit" class="contacts" name="affected_areas[]" placeholder="Pick some people..."></select>  		
		@if ($errors->has('affected_areas')) <span class="reqsymbol">*</span> @endif
	</div>

	
	<div class="col-xs-12 perinputwrap text-right">
	<a class ="btn btn-update" title="Update" data-toggle="modal" data-target="#mymodal">Update Threshold</a>
	<a class="btn btn-updatelocation" href="{{ action("ThresholdFlood@viewThresholdFlood") }}">Cancel</a> 
	@include('pages.editthresholdflooddialog')
	</div>
</form>
 @stop
 @section('page-js-files')
<script type="text/javascript" src="{!! url('js/selectize.js') !!}"></script>
<script>

	var floodproneareas = {!! json_encode($floodproneareas) !!};
	var affectedareas = {!! json_encode($affectedareas) !!};

</script>

<script type="text/javascript" src="{!! url('assets/js/floodthreshold.js') !!}"></script>

@endsection