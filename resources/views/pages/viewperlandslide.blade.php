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

	<div class="col-xs-12">

		<h1 class="pg-title page-header">{{$landslides->location}}</h1>

		<span class="defsp pagedate"><?php echo date("F j Y g:ia", strtotime($landslides->date));?></span>

	</div>

	@if(($currentUser->id == $landslides->created_by) || ($currentUser->role_id <= 3))

		<div class="col-xs-12 np text-right editlink editlinktop">

			<a href="<?php echo url('editlandslide')?>/{{$landslides->id }}">Edit Report</a>

		</div>

	@endif	

	<div class="col-xs-12 col-sm-8">

		

		<div class="col-xs-12 pagedescription np">

			{!! $landslides->description !!}

		</div>

		<div class="col-xs-12 pagedetails np">

			<span class="defsp" id="latvalue">Latitude: <span>{{$landslides->latitude}}</span></span>

			<span class="defsp" id="longvalue">Longitude: <span>{{$landslides->longitude}}</span></span>

		</div>

		<div class="col-xs-12 pagefoot np">

			<span class="defsp">Source: <span>{{$landslides->author}}</span></span>	

			<span class="defsp">Created by: <span>

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

			<a href="<?php echo url('editlandslide')?>/{{$landslides->id }}">Edit Report</a>

		</div>

	@endif

</div>

 @stop

@section('page-js-files')

<script src="{!! url('assets/js/pagelayouts.js')!!}"></script>

<script src="http://maps.google.com/maps/api/js?key=AIzaSyC058wNQG2iAeF7z0ysRHQw_0Gsqd6Xp5s"></script>

@stop