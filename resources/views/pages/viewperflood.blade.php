@extends('layouts.masters.frontend-layouts')
@section('page-content')
<?php 
	$incident_images = [];	
	if(!($floods->incident_images)){
		$incident_images = [];	
	}else{
		$incident_images = unserialize($floods->incident_images);
	}
?>

<div class="row">
		@foreach($provinces as $province)
		@if($floods->province_id == $province->id)
		<div class="col-xs-12">
			<center>
			<h1 class="pg-title page-header">{{$floods->road_location}}, {!! $province->name !!}</h1>
			<span class="defsp pagedate"><?php echo date("F j Y g:ia", strtotime($floods->date));?></span>
			</center>
		</div>	

		@if((Auth::user()->id == $floods->created_by) || (Auth::user()->role_id <= 3))
		<div class="col-xs-12 np text-right editlink">
			<a href="<?php echo url('editflood')?>/{{$floods->id }}" style="margin-right:5px">Edit This Report</a> 
		</div>
	@endif			

		<div class="col-xs-12 col-sm-8">			
			<div class="col-xs-12 pagedescription np">
Details			
<pre>
Location: {!! $floods->road_location !!}, {!! $province->name !!} 	
Date and time of occurence: <span><?php echo date("F j Y g:ia", strtotime($floods->date));?></span>
<span class="defsp" id="latvalue">Latitude: <span>{{$floods->latitude}}</span></span>
<span class="defsp" id="longvalue">Longitude: <span>{{$floods->longitude}}</span></span>
Flood Type: {!! $floods->flood_type !!}
The flooded are is a part/tributary to: {!! $floods->river_system !!}
Flood water level: {!! $floods->flood_waterlvl !!} Measured at: {!! $floods->measuredat !!}
Is this flood recurring? {!! $floods->flood_reccuring !!}
Number of deaths: {!! $floods->flood_killed !!}
Number of injured: {!! $floods->flood_injured !!}
Number of missing: {!! $floods->flood_missing !!}
Number of affected infrasturucture: {!! $floods->flood_affectedinfra !!}
Value of affected crops in Pesos(php): {!! $floods->flood_affectedcrops !!}  
The Flood happened because of {!! $floods->cause !!} causes
This is during the {!! $floods->typhoon_name !!}
Did the flood happened during a heavy rainfall? {!! $floods->heavy_rainfall !!}
The flood was reported by {!! $floods->reported_by !!}
He/she is a {!! $floods->reporter_pos !!} of the office of {!! $floods->author !!}     
</pre>
		@endif
		@endforeach	
			</div>


			<div class="col-xs-12 pagefoot np">
				<span class="defsp">This report is created and added to this system by: <span>
					@foreach($users as $user)
					@if($user->id === $floods->created_by)
					{{$user->first_name}} {{$user->last_name}}
					@endif
					@endforeach
				</span></span>		
			</div>
		</div>

		<div class="col-xs-12 col-sm-4">
			<div id="lfmap"></div>
			<div class="incident-images col-xs-12 np">
				@foreach($incident_images as $floodimg)
					<div class="col-xs-12 col-sm-6 incident-perimages">
						<a href="{{$floodimg}}" data-fancybox-group="myimages" class="fancybox thumbnail"><img class="mres" src="{{$floodimg}}"></a>
					</div>
				@endforeach
			</div>
		</div>	

		@if((Auth::user()->id == $floods->created_by) || (Auth::user()->role_id <= 3))
		<div class="col-xs-12 np text-right editlink">
			 
				<a href="<?php echo url('viewfloods')?>">Go back to flood report list</a> 
			</div>
		@endif		
</div>

 @stop
 @section('page-js-files')
<script src="{!! url('assets/js/pagelayouts.js')!!}"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script>
@stop

