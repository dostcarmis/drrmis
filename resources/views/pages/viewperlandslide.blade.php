@extends('layouts.masters.frontend-layouts')
@section('page-content')
<?php 
	$incident_images = [];	
	if(!($landslides->incident_images)){
		$incident_images = [];	
	}else{
		$incident_images = unserialize($landslides->incident_images);
	}
?>
	
	
	
<div class="row">	
		@foreach($provinces as $province)
		@if($landslides->province_id == $province->id)
	<div class="col-xs-12">
		<center>
		<h1 class="pg-title page-header"> {!! $landslides->road_location !!}, {!! $province->name !!}</h1>
		<span class="defsp pagedate"><?php echo date("F j Y g:ia", strtotime($landslides->date));?></span>
		</center>
	</div>

	@if(($currentUser->id == $landslides->created_by) || ($currentUser->role_id <= 3))
		<div class="col-xs-12 np text-right editlink">
			<a href="<?php echo url('editlandslide')?>/{{$landslides->id }}" style="margin-right:5px">Edit This Report</a> 
		</div>
	@endif

	<div class="col-xs-12 col-sm-8">
		<div class="col-xs-12 pagedescription np">			

Details			
<pre>
Location: {!! $landslides->road_location !!}, {!! $province->name !!} 	
Date and time of occurence: <span><?php echo date("F j Y g:ia", strtotime($landslides->date));?></span>
<span class="defsp" id="latvalue">Latitude: <span>{{$landslides->latitude}}</span></span>
<span class="defsp" id="longvalue">Longitude: <span>{{$landslides->longitude}}</span></span>
Landslide Type: {!! $landslides->landslidetype !!}
Land cover of the eroded area: {!! $landslides->landcover !!}
Prominent Landmark: {!! $landslides->landmark !!}
Is this landslide recurring? {!! $landslides->landslidereccuring !!}
Landslide extent(width) in meters: {!! $landslides->lewidth !!} 
Landslide extent(length) in meters: {!! $landslides->lelength !!} 
Landslide extent(depth) in meters: {!! $landslides->ledepth !!}
Number of casualties: {!! $landslides->idkilled !!}
Number of injured: {!! $landslides->idinjured !!}
Number of missing: {!! $landslides->idmissing !!}
Number of affected infrasturucture: {!! $landslides->idaffectedinfra !!}
Value of affected crops in Pesos(php): {!! $landslides->idaffectedcrops !!}  
The landslide happened because of {!! $landslides->cause !!} causes
This is during the {!! $landslides->typhoonname !!}
Did the landslide happened during a heavy rainfall? {!! $landslides->heavyrainfall !!}
The landslide was reported by {!! $landslides->reportedby !!}
He/she is a {!! $landslides->reporterpos !!} of the office of {!! $landslides->author !!}     
</pre>
		@endif
		@endforeach
		</div>
		

		<div class="col-xs-12 pagefoot np">	
			<span class="defsp">This report is created and added to this system by: <span>
				@foreach($users as $user)
				@if($user->id === $landslides->created_by)
				{{$user->first_name}} {{$user->last_name}}
				@endif
				@endforeach
			</span></span>		
		</div>
	</div>	

	<div class="col-xs-12 col-sm-4">
		<div id="lfmap"></div>
		<div class="incident-images col-xs-12 np">
			@foreach($incident_images as $landslideimg)
				<div class="col-xs-12 col-sm-6 incident-perimages">
					<a href="{{$landslideimg}}" data-fancybox-group="myimages" class="fancybox thumbnail"><img class="mres" src="{{$landslideimg}}"></a>
				</div>
			@endforeach
		</div>
	</div>

	@if(($currentUser->id == $landslides->created_by) || ($currentUser->role_id <= 3))
		<div class="col-xs-12 np text-right editlink">
			 
			<a href="<?php echo url('viewlandslides')?>">Go back to lanslide report list</a> 
		</div>
	@endif
</div>
 @stop
@section('page-js-files')
<script src="{!! url('assets/js/pagelayouts.js')!!}"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script>
@stop